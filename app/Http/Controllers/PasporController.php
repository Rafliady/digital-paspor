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
        // 1. DATA INPUT
        // ==========================================
        $nama_lengkap = strtoupper($request->nama);
        $nik          = $request->nik;
        $jk           = $request->jk;
        $tinggi       = $request->tinggi;
        $tempat_lahir = strtoupper($request->tempat_lahir);
        $tgl_lahir    = $request->tgl_lahir;
        $no_hp        = $request->no_hp;
        $email        = strtoupper($request->email ?? ''); 

        // Helper Split Text (Untuk Alamat/Pekerjaan 2 Baris)
        // Baris 1: 37 Karakter, Baris 2: 18 Karakter (Sisanya buat Telp)
        $split_text = function($text, $len1, $len2) {
            $clean = preg_replace('/\s+/', ' ', strtoupper($text));
            $line1 = substr($clean, 0, $len1);
            $line2 = substr($clean, $len1, $len2);
            return [$line1, $line2];
        };

        list($alamat_1, $alamat_2)       = $split_text($request->alamat, 37, 18);
        list($pekerjaan_1, $pekerjaan_2) = $split_text($request->pekerjaan, 37, 18);

        // KTP & Tanggal (Format 8 Digit: ddmY -> 26012026)
        $ktp_tgl_keluar = $request->ktp_tgl_keluar;
        if ($request->has('ktp_seumur_hidup')) {
            $ktp_habis_chars = str_split(str_pad("SEUMUR HIDUP", 10, " "));
        } else {
            $tgl_habis = $request->ktp_tgl_habis ?? date('Y-m-d', strtotime('+5 years'));
            $ktp_habis_chars = str_split(date('dmY', strtotime($tgl_habis)));
        }

        // Data Orang Tua & Pasangan
        $ayah_nama   = strtoupper($request->ayah_nama);
        $ayah_tempat = strtoupper($request->ayah_tempat);
        $ayah_tgl    = $request->ayah_tgl;
        $ayah_warga  = "INDONESIA"; 

        $ibu_nama    = strtoupper($request->ibu_nama);
        $ibu_tempat  = strtoupper($request->ibu_tempat);
        $ibu_tgl     = $request->ibu_tgl;
        $ibu_warga   = "INDONESIA";

        $ortu_alamat_raw = strtoupper($request->ortu_alamat ?? $request->alamat);
        list($ortu_alamat_1, $ortu_alamat_2) = $split_text($ortu_alamat_raw, 37, 18);

        // Pasangan
        $status_kawin = $request->status_sipil;
        $pasangan_nama   = ($status_kawin == 'KAWIN') ? strtoupper($request->pasangan_nama) : "";
        $pasangan_tempat = ($status_kawin == 'KAWIN') ? strtoupper($request->pasangan_tempat ?? 'WONOSOBO') : "";
        $pasangan_tgl    = ($status_kawin == 'KAWIN') ? $request->pasangan_tgl : null;
        $pasangan_warga  = ($status_kawin == 'KAWIN') ? strtoupper($request->pasangan_warga ?? 'INDONESIA') : "";


        // ==========================================
        // 2. FORMAT KOTAK (GRID)
        // ==========================================
        $to_box = fn($str, $len) => str_split(str_pad(substr($str ?? '', 0, $len), $len, " "));
        
        // FORMAT TANGGAL BARU: 8 KOTAK (dmY)
        $to_date_box = fn($date) => $date ? str_split(date('dmY', strtotime($date))) : str_split("        ");

        $data_grid = [
            'nama_chars'      => $to_box($nama_lengkap, 37),
            'nik_chars'       => $to_box($nik, 16),
            'tempat_chars'    => $to_box($tempat_lahir, 20),
            'tgl_lahir_chars' => $to_date_box($tgl_lahir), // 8 Kotak
            'jk'              => $jk,
            'tinggi_chars'    => $to_box($tinggi, 3),
            'tempat_keluar_chars' => $to_box("WONOSOBO", 20),
            'tgl_berlaku_chars'   => $to_date_box($ktp_tgl_keluar), // 8 Kotak
            'tgl_habis_chars'     => $ktp_habis_chars,
            
            // PEKERJAAN & ALAMAT (SPLIT)
            'pekerjaan_1_chars' => $to_box($pekerjaan_1, 37),
            'pekerjaan_2_chars' => $to_box($pekerjaan_2, 18),
            'alamat_1_chars'    => $to_box($alamat_1, 37),
            'alamat_2_chars'    => $to_box($alamat_2, 18),
            'telp_chars'        => $to_box($no_hp, 12),
            'email_chars'       => $to_box($email, 37),

            // IBU
            'ibu_nama_chars'   => $to_box($ibu_nama, 37),
            'ibu_warga_chars'  => $to_box($ibu_warga, 37),
            'ibu_tempat_chars' => $to_box($ibu_tempat, 20),
            'ibu_tgl_chars'    => $to_date_box($ibu_tgl),

            // AYAH
            'ayah_nama_chars'   => $to_box($ayah_nama, 37),
            'ayah_warga_chars'  => $to_box($ayah_warga, 37),
            'ayah_tempat_chars' => $to_box($ayah_tempat, 20),
            'ayah_tgl_chars'    => $to_date_box($ayah_tgl),
            
            // ALAMAT ORTU (Split juga)
            'ortu_alamat_1_chars' => $to_box($ortu_alamat_1, 37),
            'ortu_alamat_2_chars' => $to_box($ortu_alamat_2, 18),

            // PASANGAN
            'pasangan_nama_chars'   => $to_box($pasangan_nama, 37),
            'pasangan_warga_chars'  => $to_box($pasangan_warga, 37),
            'pasangan_tempat_chars' => $to_box($pasangan_tempat, 20),
            'pasangan_tgl_chars'    => $to_date_box($pasangan_tgl),
        ];

        // ... (Bagian Data Text Biasa & Return View sama seperti sebelumnya) ...
        // Agar tidak kepanjangan saya potong, gunakan kode merge array yang ada di file sebelumnya
        
        $data_text = [
            'kop_instansi' => 'KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA R.I',
            'nama' => $nama_lengkap, 
            'nik' => $nik, 'alamat' => $request->alamat,
            'pekerjaan' => $request->pekerjaan, 'no_hp' => $no_hp,
            'tujuan' => strtoupper($request->tujuan),
            'tgl_ttd' => date('d F Y'),
            'ayah_nama' => $ayah_nama, 'ibu_nama' => $ibu_nama, 
            'ortu_alamat' => $ortu_alamat_raw,
            'cetak_surat_ortu' => $request->has('buat_surat_ortu'),
            // Tambahkan TTL Text untuk surat pernyataan jika perlu
            'ttl' => $tempat_lahir . ', ' . $tgl_lahir
        ];
        
        $data = array_merge($data_grid, $data_text);
        
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