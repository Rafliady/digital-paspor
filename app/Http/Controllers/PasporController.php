<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PasporController extends Controller
{
    public function index()
    {
        return view('form-paspor');
    }

    public function cetak(Request $request)
    {
        // ==========================================
        // 1. TANGKAP DATA DARI FORM
        // ==========================================
        
        // --- DATA PRIBADI ---
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
        
        // --- VARIABEL TUJUAN (WAJIB ADA) ---
        // Jika kosong, default ke '-' atau 'WISATA' agar tidak error
        $tujuan = strtoupper($request->tujuan ?? 'WISATA'); 

        // --- PEKERJAAN ---
        $pekerjaan_id = $request->pekerjaan_id;
        $pekerjaan_lainnya = ($pekerjaan_id == '5') ? strtoupper($request->pekerjaan_lainnya) : "";
        $nama_alamat_kantor = strtoupper($request->nama_alamat_kantor ?? '');

        // Mapping Teks Pekerjaan (Untuk Surat Pernyataan)
        $map_pekerjaan_text = [
            '1' => 'PEJABAT NEGARA', 
            '2' => 'PNS', 
            '3' => 'TNI / POLRI',
            '4' => 'KARYAWAN SWASTA', 
            '5' => $pekerjaan_lainnya
        ];
        $pekerjaan_str = $map_pekerjaan_text[$pekerjaan_id] ?? 'LAINNYA';

        // --- STATUS SIPIL & PASANGAN ---
        $status_sipil_id = $request->status_sipil_id;
        $pasangan_nama = ""; $pasangan_warga = ""; $pasangan_tempat = ""; $pasangan_tgl = null;

        if ($status_sipil_id == '1') { // Jika KAWIN
            $pasangan_nama   = strtoupper($request->pasangan_nama);
            $pasangan_warga  = strtoupper($request->kewarganegaraan_pasangan ?? 'INDONESIA');
            $pasangan_tempat = strtoupper($request->tempat_lahir_pasangan);
            $pasangan_tgl    = $request->tgl_lahir_pasangan;
        }

        // --- DATA ORANG TUA ---
        $ayah_nama   = strtoupper($request->ayah_nama);
        $ayah_warga  = strtoupper($request->kewarganegaraan_ayah ?? 'INDONESIA');
        $ayah_tempat = strtoupper($request->ayah_tempat);
        $ayah_tgl    = $request->tgl_lahir_ayah;

        $ibu_nama    = strtoupper($request->ibu_nama);
        $ibu_warga   = strtoupper($request->kewarganegaraan_ibu ?? 'INDONESIA');
        $ibu_tempat  = strtoupper($request->ibu_tempat);
        $ibu_tgl     = $request->tgl_lahir_ibu;

        $ortu_alamat_raw = strtoupper($request->ortu_alamat ?? $request->alamat);

        // --- HELPER FUNGSI (SPLIT TEXT) ---
        $split_text = function($text, $len1, $len2) {
            $clean = preg_replace('/\s+/', ' ', strtoupper($text ?? ''));
            $line1 = substr($clean, 0, $len1);
            $line2 = substr($clean, $len1, $len2);
            return [$line1, $line2];
        };

        list($alamat_1, $alamat_2) = $split_text($alamat_lengkap, 37, 18);
        list($pekerjaan_1, $pekerjaan_2) = $split_text($nama_alamat_kantor, 37, 18);
        list($ortu_alamat_1, $ortu_alamat_2) = $split_text($ortu_alamat_raw, 37, 18);

        // --- KTP LOGIC ---
        $ktp_tgl_keluar = $request->ktp_tgl_keluar;
        if ($request->has('ktp_seumur_hidup')) {
            $ktp_habis_chars = str_split(str_pad("SEUMUR HIDUP", 10, " "));
        } else {
            $tgl_habis = $request->ktp_tgl_habis ?? date('Y-m-d', strtotime('+5 years'));
            $ktp_habis_chars = str_split(date('dmY', strtotime($tgl_habis)));
        }

        // --- HELPER FORMAT KOTAK ---
        $to_box = fn($str, $len) => str_split(str_pad(substr($str ?? '', 0, $len), $len, " "));
        $date_box = fn($d) => $d ? str_split(date('dmY', strtotime($d))) : str_split("        ");
        $empty_box = fn($len) => str_split(str_pad("", $len, " "));

        // ==========================================
        // 2. DATA UNTUK VIEW
        // ==========================================
        $data = [
            // --- DATA TEKS (Untuk Halaman 3, 4, 5) ---
            'tujuan'        => $tujuan, // Pastikan ini ada!
            'nama'          => $nama,
            'alamat'        => $alamat_lengkap,
            'pekerjaan_str' => $pekerjaan_str,
            'no_hp'         => $no_hp_pribadi,
            'ttl'           => $tempat . ', ' . ($tgl_lahir ? date('d-m-Y', strtotime($tgl_lahir)) : ''),
            'tgl_ttd'       => date('d F Y'),
            'ayah_nama'     => $ayah_nama,
            'ibu_nama'      => $ibu_nama,
            'ayah_ttl'      => $ayah_tempat . ', ' . ($ayah_tgl ? date('d-m-Y', strtotime($ayah_tgl)) : ''),
            'ortu_alamat'   => $ortu_alamat_raw,
            // Logic Halaman 5 (Surat Ortu)
            'cetak_surat_ortu' => $request->has('buat_surat_ortu'),

            // --- DATA KOTAK (Untuk Halaman 1 & 2) ---
            'nama_chars'      => $to_box($nama, 37),
            'jk'              => $jk,
            'alias_chars'     => $to_box($nama_alias, 25),
            'tinggi_chars'    => $to_box($tinggi, 3),
            'tempat_chars'    => $to_box($tempat, 20),
            'tgl_lahir_chars' => $date_box($tgl_lahir),
            'nik_chars'       => $to_box($nik, 16),
            'tgl_berlaku_chars' => $date_box($ktp_tgl_keluar),
            'tempat_keluar_chars' => $to_box("WONOSOBO", 20),
            'tgl_habis_chars' => $ktp_habis_chars,
            
            // Pekerjaan & Alamat (Dipisah Telpnya)
            'pekerjaan_1_chars' => $to_box($pekerjaan_1, 37),
            'pekerjaan_2_chars' => $to_box($pekerjaan_2, 18),
            'telp_kantor_chars' => $to_box($no_telp_kantor, 12),
            
            'alamat_1_chars'    => $to_box($alamat_1, 37),
            'alamat_2_chars'    => $to_box($alamat_2, 18),
            'telp_rumah_chars'  => $to_box($no_hp_pribadi, 12),
            
            'email_chars'       => $to_box($email, 37),

            // Keluarga
            'ibu_nama_chars'   => $to_box($ibu_nama, 37),
            'ibu_warga_chars'  => $to_box($ibu_warga, 37),
            'ibu_tempat_chars' => $to_box($ibu_tempat, 20),
            'ibu_tgl_chars'    => $date_box($ibu_tgl),
            'ayah_nama_chars'   => $to_box($ayah_nama, 37),
            'ayah_warga_chars'  => $to_box($ayah_warga, 37),
            'ayah_tempat_chars' => $to_box($ayah_tempat, 20),
            'ayah_tgl_chars'    => $date_box($ayah_tgl),
            'ortu_alamat_1_chars' => $to_box($ortu_alamat_1, 37),
            'ortu_alamat_2_chars' => $to_box($ortu_alamat_2, 18),
            'telp_ortu_chars'     => $to_box($no_hp_ortu, 12),
            
            'pasangan_nama_chars' => $to_box($pasangan_nama, 37),
            'pasangan_warga_chars'=> $to_box($pasangan_warga, 37),
            'pasangan_tempat_chars'=> $to_box($pasangan_tempat, 20),
            'pasangan_tgl_chars'   => $date_box($pasangan_tgl),

            // Halaman 2 Logic
            'pekerjaan_id'      => $pekerjaan_id,
            'pekerjaan_lainnya' => $pekerjaan_lainnya,
            'status_sipil_id'   => $status_sipil_id,
            
            // Kotak Nama & Tata Usaha
            'nama_ambil_1_chars' => $empty_box(20),
            'nama_ambil_2_chars' => $empty_box(20),
            'nama_lama_chars' => $empty_box(37),
            'alamat_lama_chars' => $empty_box(37),
            'paspor_lama_chars' => $empty_box(20),
            'tanggal_lama_chars'=> $empty_box(8),
            'reg_lama_chars'    => $empty_box(20),
            'surat_kakanwil_chars' => $empty_box(35),
            'nik_pejim_chars' => $empty_box(16),
        ];
        
        $pdf = Pdf::loadView('pdf.formulir_lengkap', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('Berkas_Paspor_Lengkap.pdf');
    }

    // --- FUNGSI SPESIAL UNTUK KOTAK-KOTAK ---
    private function tulisKotak($pdf, $text, $x, $y, $step)
    {
        $chars = str_split($text); // Pecah teks jadi huruf per huruf
        $currentX = $x;
        
        foreach ($chars as $char) {
            $pdf->SetXY($currentX, $y);
            // Angka 5 adalah tinggi baris, sesuaikan jika perlu
            $pdf->Cell($step, 5, $char, 0, 0, 'C'); 
            $currentX += $step; // Geser ke kanan sesuai jarak kotak
        }
    }
}