<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SpriPemohon;       // Model untuk DB SPRI (Read Only)
use Illuminate\Support\Facades\DB; // Untuk DB Lokal (Log Admin)
use Carbon\Carbon; // Tambahkan Carbon untuk manipulasi tanggal
use Illuminate\Support\Facades\Log;

class PasporController extends Controller
{
    // ==========================================
    // HALAMAN UTAMA FORMULIR
    // ==========================================
    public function index()
    {
        return view('form-paspor');
    }

    // ==========================================
    // FITUR 1: API CARI DATA SPRI (Database Eksternal)
    // ==========================================
    public function cariDataSpri(string $nomor_permohonan)
    {
        // 1. PENTING: Perpanjang waktu tunggu (5 menit) agar tidak timeout
        set_time_limit(300);

        try {
            // 2. OPTIMASI: Gunakan 'select' agar query lebih ringan & cepat
            // Kita sesuaikan nama kolom dengan tabel 'nxt_spri_links'
            $data = SpriPemohon::select(
                'nomor_permohonan',
                'nama_lengkap',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'alamat',
                'no_hp',
                'email',
                'tujuan_pembuatan_paspor'
            )->where('nomor_permohonan', $nomor_permohonan)->first();

            if ($data) {
                // 3. Normalisasi Jenis Kelamin
                // Database mungkin simpan: L, LAKI-LAKI, P, PEREMPUAN, WANITA
                $jk = 'L'; // Default
                $jk_db = strtoupper($data->jenis_kelamin);
                if (str_contains($jk_db, 'P') || str_contains($jk_db, 'WANITA') || str_contains($jk_db, 'PEREMPUAN')) {
                    $jk = 'P';
                }

                // 4. Mapping Data ke Form HTML
                $result = [
                    'nik'           => '', // NIK kosong karena di SPRI tidak ada
                    'nama'          => $data->nama_lengkap,
                    'tempat_lahir'  => $data->tempat_lahir,
                    'tgl_lahir'     => $data->tanggal_lahir ? date('Y-m-d', strtotime($data->tanggal_lahir)) : '',
                    'jk'            => $jk, 
                    'alamat'        => $data->alamat,
                    'no_hp'         => $data->no_hp,
                    'email'         => $data->email,
                    'tujuan'        => strtoupper($data->tujuan_pembuatan_paspor)
                ];
                
                return response()->json(['status' => 'success', 'data' => $result]);
            } else {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Nomor Permohonan tidak ditemukan di Database SPRI.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Koneksi ke Database SPRI Gagal. Error: ' . $e->getMessage()
            ]);
        }
    }

    // ==========================================
    // FITUR 2: DASHBOARD ADMIN
    // ==========================================
   // ==========================================
    // FITUR 2: DASHBOARD ADMIN (Dengan Filter, Search, & Pagination)
    // ==========================================
    public function dashboard(Request $request)
    {
        try {
            $query = DB::table('riwayat_cetak');

            // Fitur 1: Pencarian Berdasarkan Nama atau NIK
            if ($request->has('cari') && $request->cari != '') {
                $query->where('nama_lengkap', 'like', '%' . $request->cari . '%')
                      ->orWhere('nik', 'like', '%' . $request->cari . '%');
            }

            // Fitur 2: Filter Berdasarkan Tanggal Cetak
            if ($request->has('filter_tanggal') && $request->filter_tanggal != '') {
                // Konversi tanggal HTML (Y-m-d) agar cocok dengan created_at di DB
                $query->whereDate('waktu_cetak', $request->filter_tanggal);
            }

            // Hitung Statistik Cepat (Untuk Kotak Summary)
            $totalPemohon = DB::table('riwayat_cetak')->count();
            $pemohonHariIni = DB::table('riwayat_cetak')->whereDate('waktu_cetak', Carbon::today())->count();
            $pemohonManual = DB::table('riwayat_cetak')->where('metode', 'MANUAL')->count();
            $pemohonOtomatis = $totalPemohon - $pemohonManual;

            // Pagination (Tampilkan 15 data per halaman)
            $data = $query->orderBy('created_at', 'desc')->paginate(15);
            
            // Tambahkan query string ke link pagination agar tidak hilang saat di-klik Next Page
            $data->appends($request->all());

        } catch (\Exception $e) {
            $data = []; 
            $totalPemohon = 0; $pemohonHariIni = 0; $pemohonOtomatis = 0; $pemohonManual = 0;
        }

        return view('dashboard', compact('data', 'totalPemohon', 'pemohonHariIni', 'pemohonOtomatis', 'pemohonManual'));
    }

    // ==========================================
    // FITUR TAMBAHAN: HAPUS RIWAYAT CETAK
    // ==========================================
    public function hapusRiwayat(string $id)
    {
        try {
            DB::table('riwayat_cetak')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'Data pemohon berhasil dihapus dari riwayat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }

    // ==========================================
    // FITUR 3: CETAK PDF & LOGGING
    // ==========================================
    public function cetak(Request $request)
    {
        // 1. TANGKAP DATA DARI FORM
        $nama       = strtoupper($request->nama);
        $nama_alias = strtoupper($request->nama_alias ?? '');
        $nik        = $request->nik;
        $jk         = $request->jk;
        $tinggi     = $request->tinggi;
        $tempat     = strtoupper($request->tempat_lahir);
        $tgl_lahir  = $request->tgl_lahir;
        
        // --- KONTAK & ALAMAT ---
        $no_hp_pribadi  = $request->no_hp; 
        $no_telp_kantor = $request->nomor_telp_kantor ?? ''; 
        $no_hp_ortu     = $request->no_hp_ortu ?? ''; 
        
        $email          = strtoupper($request->email ?? '');
        $alamat_lengkap = strtoupper($request->alamat);
        
        // --- LOGIKA TUJUAN ---
        // Jika user memilih "LAINNYA", ambil teks dari input manual 'tujuan_lainnya'
        if ($request->tujuan == 'LAINNYA') {
            $tujuan = strtoupper($request->tujuan_lainnya); 
        } else {
            $tujuan = strtoupper($request->tujuan ?? 'WISATA');
        }

        // ---------------------------------------------------------
        // LOG KE DATABASE LOKAL (RIWAYAT CETAK)
        // ---------------------------------------------------------
        try {
            DB::table('riwayat_cetak')->insert([
                'nomor_permohonan' => $request->cari_nomor_permohonan ?? null, // Input dari form pencarian / hidden input
                'nik'              => $nik,
                'nama_lengkap'     => $nama,
                'tujuan'           => $tujuan,
                'metode'           => $request->metode ?? 'MANUAL', // SPRI, SCAN, atau MANUAL
                'waktu_cetak'      => now(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        } catch (\Exception $e) {
            // Log error tapi biarkan proses cetak lanjut
           \Illuminate\Support\Facades\Log::error("Gagal menyimpan riwayat cetak: " . $e->getMessage());
        }
        // ---------------------------------------------------------

        // TANGGAL TTD (HARI INI)
        $bulanIndo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        $tgl_ttd = date('d') . ' ' . $bulanIndo[date('m')] . ' ' . date('Y');

        // --- TANGGAL PERMOHONAN OTOMATIS (ddmmyyyy) ---
        $tgl_permohonan_chars = str_split(date('dmY')); 

        // --- PEKERJAAN ---
        $pekerjaan_id = $request->pekerjaan_id;
        $pekerjaan_lainnya = ($pekerjaan_id == '5') ? strtoupper($request->pekerjaan_lainnya) : "";
        $nama_alamat_kantor = strtoupper($request->nama_alamat_kantor ?? '');

        $map_pekerjaan_text = [
            '1' => 'PEJABAT NEGARA', '2' => 'PNS', '3' => 'TNI / POLRI',
            '4' => 'KARYAWAN SWASTA', '5' => $pekerjaan_lainnya
        ];
        $pekerjaan_str = $map_pekerjaan_text[$pekerjaan_id] ?? 'LAINNYA';

        // --- STATUS SIPIL & PASANGAN ---
        $status_sipil_id = $request->status_sipil_id;
        $pasangan_nama = ""; $pasangan_warga = ""; $pasangan_tempat = ""; $pasangan_tgl = null;

        if ($status_sipil_id == '1') { // KAWIN
            $pasangan_nama   = strtoupper($request->pasangan_nama);
            $pasangan_warga  = strtoupper($request->kewarganegaraan_pasangan ?? 'INDONESIA');
            $pasangan_tempat = strtoupper($request->tempat_lahir_pasangan);
            $pasangan_tgl    = $request->tgl_lahir_pasangan;
        }

        // --- ORANG TUA ---
        $ayah_nama   = strtoupper($request->ayah_nama);
        $ayah_warga  = strtoupper($request->kewarganegaraan_ayah ?? 'INDONESIA');
        $ayah_tempat = strtoupper($request->ayah_tempat);
        $ayah_tgl    = $request->tgl_lahir_ayah;

        $ibu_nama    = strtoupper($request->ibu_nama);
        $ibu_warga   = strtoupper($request->kewarganegaraan_ibu ?? 'INDONESIA');
        $ibu_tempat  = strtoupper($request->ibu_tempat);
        $ibu_tgl     = $request->tgl_lahir_ibu;

        $ortu_alamat_raw = strtoupper($request->ortu_alamat ?? $request->alamat);

        // --- HELPER FORMAT ---
        $split_text = function($text, $len1, $len2) {
            $clean = preg_replace('/\s+/', ' ', strtoupper($text ?? ''));
            return [substr($clean, 0, $len1), substr($clean, $len1, $len2)];
        };

        list($alamat_1, $alamat_2) = $split_text($alamat_lengkap, 37, 18);
        list($pekerjaan_1, $pekerjaan_2) = $split_text($nama_alamat_kantor, 37, 18);
        list($ortu_alamat_1, $ortu_alamat_2) = $split_text($ortu_alamat_raw, 37, 18);

        // --- LOGIKA TANGGAL KTP ---
        $ktp_tgl_keluar = $request->ktp_tgl_keluar; 

        if ($request->has('ktp_seumur_hidup')) {
            $ktp_habis_chars = str_split(str_pad("SEUMUR HIDUP", 10, " "));
        } elseif (!empty($request->ktp_tgl_habis)) {
            $ktp_habis_chars = str_split(date('dmY', strtotime($request->ktp_tgl_habis)));
        } else {
            $ktp_habis_chars = str_split("        ");
        }

        // Helper fungsi pemecah string ke array karakter (kotak-kotak)
        $to_box = fn($str, $len) => str_split(str_pad(substr($str ?? '', 0, $len), $len, " "));
        
        // Perbaikan Helper Tanggal: Cek dulu apakah tanggal ada isinya
        $date_box = fn($d) => (!empty($d)) ? str_split(date('dmY', strtotime($d))) : str_split("        ");
        
        $empty_box = fn($len) => str_split(str_pad("", $len, " "));

        $jk_long = ($jk == 'L') ? 'Laki-laki' : 'Perempuan';

        // 4. KIRIM DATA KE VIEW PDF
        $data = [
            'tujuan'        => $tujuan,
            'nama'          => $nama,
            'jk_long'       => $jk_long,
            'alamat'        => $alamat_lengkap,
            'pekerjaan_str' => $pekerjaan_str,
            'no_hp'         => $no_hp_pribadi,
            'ttl'           => $tempat . ', ' . ($tgl_lahir ? date('d-m-Y', strtotime($tgl_lahir)) : ''),
            'tgl_ttd'       => $tgl_ttd,
            'ayah_nama'     => $ayah_nama,
            'ibu_nama'      => $ibu_nama,
            'ayah_ttl'      => $ayah_tempat . ', ' . ($ayah_tgl ? date('d-m-Y', strtotime($ayah_tgl)) : ''),
            'ortu_alamat'   => $ortu_alamat_raw,
            'cetak_surat_ortu' => $request->has('buat_surat_ortu'),

            // Data Kotak Perdim
            'tgl_permohonan_chars' => $tgl_permohonan_chars,
            
            'nama_chars' => $to_box($nama, 37), 
            'jk' => $jk, 
            'alias_chars' => $to_box($nama_alias, 25), 
            
            'tinggi_chars' => $to_box($tinggi, 3), 
            'tempat_chars' => $to_box($tempat, 20),
            'tgl_lahir_chars' => $date_box($tgl_lahir), 
            'nik_chars' => $to_box($nik, 16),
            'tgl_berlaku_chars' => $date_box($ktp_tgl_keluar), 
            'tempat_keluar_chars' => $to_box("WONOSOBO", 20),
            'tgl_habis_chars' => $ktp_habis_chars,
            'pekerjaan_1_chars' => $to_box($pekerjaan_1, 37), 'pekerjaan_2_chars' => $to_box($pekerjaan_2, 18),
            
            // Variabel Kotak Telepon
            'telp_kantor_chars' => $to_box($no_telp_kantor, 12),
            'telp_rumah_chars' => $to_box($no_hp_pribadi, 12),
            'telp_ortu_chars' => $to_box($no_hp_ortu, 12),
            
            'alamat_1_chars' => $to_box($alamat_1, 37), 'alamat_2_chars' => $to_box($alamat_2, 18),
            'email_chars' => $to_box($email, 37),
            'ibu_nama_chars' => $to_box($ibu_nama, 37), 'ibu_warga_chars' => $to_box($ibu_warga, 37),
            'ibu_tempat_chars' => $to_box($ibu_tempat, 20), 'ibu_tgl_chars' => $date_box($ibu_tgl),
            'ayah_nama_chars' => $to_box($ayah_nama, 37), 'ayah_warga_chars' => $to_box($ayah_warga, 37),
            'ayah_tempat_chars' => $to_box($ayah_tempat, 20), 'ayah_tgl_chars' => $date_box($ayah_tgl),
            'ortu_alamat_1_chars' => $to_box($ortu_alamat_1, 37), 'ortu_alamat_2_chars' => $to_box($ortu_alamat_2, 18),
            'pasangan_nama_chars' => $to_box($pasangan_nama, 37), 'pasangan_warga_chars' => $to_box($pasangan_warga, 37),
            'pasangan_tempat_chars' => $to_box($pasangan_tempat, 20), 'pasangan_tgl_chars' => $date_box($pasangan_tgl),
            
            'pekerjaan_id' => $pekerjaan_id, 'pekerjaan_lainnya' => $pekerjaan_lainnya, 'status_sipil_id' => $status_sipil_id,
            
            // Kolom Kosong (Reserved)
            'nama_ambil_1_chars' => $empty_box(20), 'nama_ambil_2_chars' => $empty_box(20),
            'nama_lama_chars' => $empty_box(37), 'alamat_lama_chars' => $empty_box(37),
            'paspor_lama_chars' => $empty_box(20), 'tanggal_lama_chars' => $empty_box(8),
            'reg_lama_chars' => $empty_box(20), 'surat_kakanwil_chars' => $empty_box(35), 'nik_pejim_chars' => $empty_box(16),
        ];
        
        $pdf = Pdf::loadView('pdf.formulir_lengkap', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('Berkas_Paspor_Lengkap.pdf');
    }
}