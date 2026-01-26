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
        // 1. SIAPKAN DATA DARI INPUTAN USER
        // ==========================================
        $nama_lengkap = strtoupper($request->nama);
        $nik          = $request->nik;
        $jk           = $request->jk;
        $tinggi       = $request->tinggi;
        $tempat_lahir = strtoupper($request->tempat_lahir);
        $tgl_lahir    = $request->tgl_lahir;
        
        // Bersihkan alamat dari enter/spasi berlebih agar rapi masuk kotak
        $alamat_raw   = strtoupper($request->alamat);
        $alamat_clean = preg_replace('/\s+/', ' ', $alamat_raw); 
        
        $pekerjaan    = strtoupper($request->pekerjaan);
        $no_hp        = $request->no_hp;
        
        // --- Data KTP ---
        $ktp_tgl_keluar = $request->ktp_tgl_keluar;
        if ($request->has('ktp_seumur_hidup')) {
            $ktp_tgl_habis_chars = str_split(str_pad("SEUMUR HIDUP", 10, " "));
        } else {
            $tgl_habis_raw = $request->ktp_tgl_habis ?? date('Y-m-d', strtotime('+5 years'));
            $ktp_tgl_habis_chars = str_split(date('dmy', strtotime($tgl_habis_raw)));
        }

        $tujuan = strtoupper($request->tujuan); 

        // --- Data Orang Tua ---
        $ayah_nama   = strtoupper($request->ayah_nama);
        $ayah_tempat = strtoupper($request->ayah_tempat);
        $ayah_tgl    = $request->ayah_tgl;
        $ibu_nama    = strtoupper($request->ibu_nama);
        $ibu_tempat  = strtoupper($request->ibu_tempat);
        $ibu_tgl     = $request->ibu_tgl;
        $ortu_alamat = $request->ortu_alamat ? strtoupper($request->ortu_alamat) : $alamat_raw;
        $cetak_surat_ortu = $request->has('buat_surat_ortu');


        // ==========================================
        // 2. FORMAT DATA UNTUK PERDIM (GRID KOTAK)
        // ==========================================
        
        $nama_chars   = str_split(str_pad($nama_lengkap, 25, " "));
        $nik_chars    = str_split(str_pad($nik, 16, " "));
        $tempat_chars = str_split(str_pad($tempat_lahir, 12, " "));
        $tinggi_chars = str_split(str_pad($tinggi, 3, " "));
        $tempat_keluar_chars = str_split(str_pad("WONOSOBO", 12, " "));
        
        // --- PERBAIKAN DISINI: PEKERJAAN & ALAMAT MASUK KOTAK ---
        // Pekerjaan: Siapkan 35 kotak
        $pekerjaan_chars = str_split(str_pad(substr($pekerjaan, 0, 35), 35, " "));
        
        // Alamat: Siapkan 70 kotak (untuk 2 baris @35 kotak)
        // Kita potong dulu jika kepanjangan, lalu pad agar kotak kosong tetap tergambar
        $alamat_chars = str_split(str_pad(substr($alamat_clean, 0, 70), 70, " "));

        // Tanggal
        $tgl_lahir_chars   = str_split(date('dmy', strtotime($tgl_lahir)));
        $tgl_berlaku_chars = str_split(date('dmy', strtotime($ktp_tgl_keluar)));


        // ==========================================
        // 3. FORMAT DATA TEKS BIASA
        // ==========================================
        $bulan_indo = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        
        $format_ttl = function($tempat, $tgl) use ($bulan_indo) {
            if(!$tgl) return $tempat;
            $exp = explode('-', $tgl);
            if(count($exp) < 3) return $tempat;
            $tgl_indo = $exp[2] . ' ' . $bulan_indo[$exp[1]] . ' ' . $exp[0];
            return $tempat . ', ' . $tgl_indo;
        };

        $ttl_pemohon = $format_ttl($tempat_lahir, $tgl_lahir);
        $ttl_ayah    = $format_ttl($ayah_tempat, $ayah_tgl);
        $ttl_ibu     = $format_ttl($ibu_tempat, $ibu_tgl);
        $tgl_ttd     = date('d') . ' ' . $bulan_indo[date('m')] . ' ' . date('Y');

        $data = [
            'kop_instansi' => 'KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA R.I',
            
            // Grid Data
            'nama_chars'   => $nama_chars,
            'nik_chars'    => $nik_chars,
            'jk'           => $jk,
            'tinggi_chars' => $tinggi_chars,
            'tempat_chars' => $tempat_chars,
            'tgl_lahir_chars' => $tgl_lahir_chars,
            'tgl_berlaku_chars' => $tgl_berlaku_chars,
            'tgl_habis_chars' => $ktp_tgl_habis_chars,
            'tempat_keluar_chars' => $tempat_keluar_chars,
            
            // NEW: Kirim array pekerjaan dan alamat
            'pekerjaan_chars' => $pekerjaan_chars,
            'alamat_chars'    => $alamat_chars,

            // Text Data
            'nama'      => $nama_lengkap,
            'nik'       => $nik,
            'alamat'    => $alamat_raw, // Untuk surat pernyataan tetap pakai text asli
            'ttl'       => $ttl_pemohon,
            'pekerjaan' => $pekerjaan,
            'no_hp'     => $no_hp,
            'tujuan'    => $tujuan,
            'tgl_ttd'   => $tgl_ttd,
            'ayah_nama'   => $ayah_nama,
            'ayah_ttl'    => $ttl_ayah,
            'ibu_nama'    => $ibu_nama,
            'ibu_ttl'     => $ttl_ibu,
            'ortu_alamat' => $ortu_alamat,
            'cetak_surat_ortu' => $cetak_surat_ortu,
        ];

        $pdf = Pdf::loadView('pdf.formulir_lengkap', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('Berkas_Paspor_'.$nama_lengkap.'.pdf');
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