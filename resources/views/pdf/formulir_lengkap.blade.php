<!DOCTYPE html>
<html>
<head>
    <title>Berkas Paspor Lengkap Final Fix Layout</title>
    <style>
        /* --- GLOBAL --- */
        @page { margin: 0px; }
        body { 
            font-family: 'Arial MT', Arial, sans-serif; 
            font-size: 9px; /* Default Perdim tetap 9px */
            margin: 15px 30px; 
        }
        .bold { font-weight: bold; }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .uppercase { text-transform: uppercase; }

        /* --- STYLES PERDIM (HAL 1 & 2) --- */
        table.header-table { width: 100%; border: none; margin-bottom: 2px; }
        table.header-table td { vertical-align: top; padding: 0; }
        .instansi { font-weight: bold; font-size: 10px; line-height: 1.1; }
        .perdim-info { font-weight: bold; font-size: 11px; line-height: 1.1; }
        .square-mark { width: 10px; height: 10px; background-color: #000; display: inline-block; }
        .judul-form { text-align: center; font-weight: bold; font-size: 11px; margin-top: 5px; text-decoration: underline; }
        .sub-judul { text-align: center; font-weight: bold; font-size: 11px; margin-bottom: 5px; }
        .box-perhatian { border: 1px solid #000; padding: 5px 8px; font-size: 7.5px; margin-bottom: 5px; line-height: 1.3; background: #fff; }
        .list-perhatian { margin: 0; padding-left: 12px; }
        .k-ex { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; margin-right: 1px; background: #fff; text-align: center; line-height: 11px; font-weight: bold; }
        table.main-layout { width: 100%; border-collapse: collapse; border: 2px solid #000; }
        .col-num { width: 15px; text-align: center; font-weight: bold; vertical-align: top; padding-top: 5px; border-right: 1px solid #000; border-bottom: 1px solid #000; }
        table.grid-data { width: 100%; border-collapse: collapse; }
        table.grid-data td { padding: 2px 3px; vertical-align: top; border-bottom: 1px solid #000; height: 32px; }
        table.grid-data tr:last-child td { border-bottom: none; }
        .v-border { border-right: 1px solid #000; }
        .f-label { font-size: 7px; color: #444; font-weight: bold; text-transform: uppercase; display: block; margin-bottom: 2px; }
        .k { display: inline-block; width: 11px; height: 12px; border: 1px solid #000; text-align: center; line-height: 11px; font-size: 9px; font-weight: bold; margin-right: 1px; background: #fff; vertical-align: middle; }
        .k-sambung { display: inline-block; width: 11px; height: 12px; border: 1px solid #000; text-align: center; line-height: 11px; font-size: 9px; font-weight: bold; margin-right: -1px; background: #fff; vertical-align: middle;}
        .chk { display: inline-block; width: 10px; height: 10px; border: 1px solid #000; margin-right: 2px; vertical-align: middle; text-align:center; line-height:9px; font-size:8px;}
        .black-dot { display: inline-block; width: 5px; height: 5px; background-color: #000; margin-right: 3px; margin-bottom: 2px; }
        .telp-lbl { font-size: 8px; font-weight: bold; margin: 0 5px; }
        .unit { font-size: 8px; margin-left: 2px; }
        .opt-row { margin-bottom: 2px; font-size: 8px; font-weight: bold; }
        .box-num { display: inline-block; width: 14px; height: 14px; border: 1px solid #000; vertical-align: middle; text-align: center; line-height: 14px; font-size: 10px; font-weight: bold; margin-left: 5px; background-color: #fff; }
        .list-syarat { list-style: none; padding: 0; margin: 0; font-size: 8px; }
        .list-syarat li { margin-bottom: 3px; }
        .chk-box { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; vertical-align: middle; margin-right: 5px; background: #fff;}
        .dotted-line { border-bottom: 1px dotted #000; display: inline-block; }

        /* =========================================
           STYLES KHUSUS HALAMAN SURAT (3, 4, 5)
           ADJUSTMENT: Font 11pt tapi spasi dipadatkan
           ========================================= */
        
        .surat-container { font-size: 11pt; line-height: 1.15; } /* Line height dirapatkan sedikit */
        
        .kop-surat { width: 100%; border-bottom: 3px double #000; margin-bottom: 5px; padding-bottom: 5px; margin-top: 10px; }
        .kop-logo { width: 70px; text-align: center; vertical-align: top; padding-top: 5px; }
        .kop-text { text-align: center; font-family: Arial, Helvetica, sans-serif; }
        .kop-text h1 { font-size: 11pt; margin: 0; font-weight: bold; }
        .kop-text h2 { font-size: 10pt; margin: 0; font-weight: bold; }
        .kop-text h3 { font-size: 13pt; margin: 2px 0; font-weight: bold; }
        .kop-text p { font-size: 8pt; margin: 0; }
        
        /* LEGAL BLOCK DIPERKECIL AGAR MUAT 1 HALAMAN */
        .legal-block { margin-bottom: 5px; font-size: 8pt; text-align: justify; line-height: 1.1; }
        .legal-title { font-weight: bold; margin-bottom: 1px; }
        
        .judul-surat { text-align: center; text-decoration: underline; font-weight: bold; font-size: 11pt; margin: 10px 0; }
        
        /* Table Isian Rapat */
        .table-isian { width: 100%; font-size: 11pt; border-collapse: collapse; margin-bottom: 5px; }
        .table-isian td { padding: 2px 0; vertical-align: top; }
        .dots-fill { border-bottom: 1px dotted #000; font-weight: bold; }
        
        /* Poin List Rapat */
        .point-list { padding-left: 20px; font-size: 11pt; line-height: 1.2; text-align: justify; margin-top: 0; margin-bottom: 0; }
        .point-list li { margin-bottom: 2px; } /* Jarak antar poin dirapatkan */
        
        .wawancara-dots { border-bottom: 1px dotted #000; display: block; margin-top: 15px; height: 12px; }
        .wawancara-label { margin-top: 10px; margin-bottom: 2px; display: block; font-size: 11pt; }
        
        .materai-box { border: 1px solid #ccc; width: 70px; height: 40px; margin: 5px auto; padding-top: 12px; text-align: center; font-size: 9pt; color:#999; }
        .ttd-area-surat { float: right; width: 230px; text-align: center; margin-top: 10px; font-size: 11pt; }
        .ttd-kiri { float: left; width: 230px; text-align: center; margin-top: 10px; font-size: 11pt; }
    </style>
</head>
<body>

    <table class="header-table"><tr><td width="5%"><div class="square-mark"></div></td><td width="55%"><div class="instansi">KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA RI<br>KANTOR WILAYAH DEP. HUKUM DAN HAM JAWA TENGAH<br>KANTOR IMIGRASI WONOSOBO</div></td><td width="35%"><div class="perdim-info">PERDIM : 11<br>NO : ....................</div></td><td width="5%" align="right"><div class="square-mark"></div></td></tr></table>
    <div class="judul-form">FORMULIR SURAT PERJALANAN REPUBLIK INDONESIA</div><div class="sub-judul">UNTUK WARGA NEGARA INDONESIA</div>
    <div class="box-perhatian"><div style="font-weight:bold; text-align:center; margin-bottom:2px;">PERHATIAN</div><ol class="list-perhatian"><li>Isi formulir dengan HURUF CETAK dan TINTA HITAM</li><li>Tanda asterisk berarti : (*) Diisi sesuai nomor pilihan...</li><li>Lampirkan dokumen identitas diri...</li><li>Pemohon Wajib datang untuk verifikasi...</li><li>Formulir ini tidak dikenakan biaya apapun.</li><li>Jika dalam pengisian formulir ini kurang jelas...</li><li>Cara pengisian tanggal... CONTOH : &nbsp; <span class="k-ex">2</span><span class="k-ex">6</span> <span class="k-ex">0</span><span class="k-ex">1</span> <span class="k-ex">0</span><span class="k-ex">8</span></li></ol></div>
    
    <table class="main-layout">
        <tr><td class="col-num">1</td><td style="padding:0; border-bottom: 1px solid #000;"><table style="width:100%; border-collapse:collapse;"><tr><td width="70%" style="border-right: 1px solid #000; padding: 4px; vertical-align:top;"><div class="f-label">PERMOHONAN *</div><div style="margin-bottom:2px;">A. BARU * &nbsp;&nbsp; <span class="chk"></span> 1. Paspor Biasa Non Elektronik &nbsp;&nbsp; <span class="chk"></span> 2. Elektronik</div><div style="margin-bottom:2px;">B. PENGGANTIAN * &nbsp; <span class="chk"></span> 1. Habis Berlaku &nbsp; <span class="chk"></span> 2. Halaman Penuh &nbsp; <span class="chk"></span> 3. Hilang</div><div>C. PERUBAHAN * &nbsp;&nbsp; <span class="chk"></span> 1. Nama &nbsp;&nbsp; 2. Alamat &nbsp;&nbsp; 3. Lain-lain</div></td><td width="30%" style="vertical-align:top; padding: 4px;"><div style="text-align:center; font-weight:bold; font-size:8px; margin-bottom:5px;">TGL PERMOHONAN</div><div style="text-align:center;">@for($i=0;$i<8;$i++)<div class="k">&nbsp;</div>@endfor</div></td></tr></table></td></tr>
        <tr><td class="col-num" style="border-bottom:none;">2</td><td style="padding:0;">
            <table class="grid-data">
                <tr><td width="65%" class="v-border"><span class="f-label">NAMA LENGKAP</span><div>@foreach($nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td width="35%"><span class="f-label">JENIS KELAMIN *</span><div style="margin-top: 5px;"><span class="chk">{{ $jk=='L'?'X':'' }}</span> 1. L &nbsp;&nbsp;&nbsp;&nbsp; <span class="chk">{{ $jk=='P'?'X':'' }}</span> 2. P</div></td></tr>
                <tr><td class="v-border"><span class="f-label">NAMA LAIN (ALIAS) **</span><div>@foreach($alias_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label">TINGGI BADAN</span><div>@foreach($tinggi_chars as $t)<div class="k">{{ $t }}</div>@endforeach <span class="unit">cm</span></div></td></tr>
                <tr><td class="v-border"><span class="f-label">TEMPAT LAHIR</span><div>@foreach($tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label"><span class="black-dot"></span>TANGGAL LAHIR</span><div>@foreach($tgl_lahir_chars as $c)<div class="k-sambung">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td class="v-border"><span class="f-label">NOMOR KTP WNI</span><div>@foreach($nik_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label"><span class="black-dot"></span>TGL DIBERLAKUKAN</span><div>@foreach($tgl_berlaku_chars as $c)<div class="k-sambung">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td class="v-border"><span class="f-label">TEMPAT DIKELUARKAN</span><div>@foreach($tempat_keluar_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label"><span class="black-dot"></span>BERLAKU S/D</span><div>@foreach($tgl_habis_chars as $c)<div class="k-sambung">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">NAMA DAN ALAMAT KANTOR / PEKERJAAN ***</span><div style="margin-bottom: 2px;">@foreach($pekerjaan_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div><div>@foreach($pekerjaan_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach <span class="telp-lbl">TELP / HP</span> @foreach($telp_kantor_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">ALAMAT TEMPAT TINGGAL</span><div style="margin-bottom: 2px;">@foreach($alamat_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div><div>@foreach($alamat_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach <span class="telp-lbl">TELP / HP</span> @foreach($telp_rumah_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">ALAMAT EMAIL</span><div>@foreach($email_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">NAMA IBU</span><div>@foreach($ibu_nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">KEWARGANEGARAAN</span><div>@foreach($ibu_warga_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td class="v-border"><span class="f-label">TEMPAT LAHIR</span><div>@foreach($ibu_tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label"><span class="black-dot"></span>TANGGAL LAHIR</span><div>@foreach($ibu_tgl_chars as $c)<div class="k-sambung">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">NAMA AYAH</span><div>@foreach($ayah_nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">KEWARGANEGARAAN</span><div>@foreach($ayah_warga_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td class="v-border"><span class="f-label">TEMPAT LAHIR</span><div>@foreach($ayah_tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label"><span class="black-dot"></span>TANGGAL LAHIR</span><div>@foreach($ayah_tgl_chars as $c)<div class="k-sambung">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">ALAMAT ORANG TUA</span><div style="margin-bottom: 2px;">@foreach($ortu_alamat_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div><div>@foreach($ortu_alamat_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach <span class="telp-lbl">TELP / HP</span> @foreach($telp_ortu_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">NAMA SUAMI / ISTRI</span><div>@foreach($pasangan_nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td colspan="2"><span class="f-label">KEWARGANEGARAAN</span><div>@foreach($pasangan_warga_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr>
                <tr><td class="v-border"><span class="f-label">TEMPAT LAHIR</span><div>@foreach($pasangan_tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label"><span class="black-dot"></span>TANGGAL LAHIR</span><div>@foreach($pasangan_tgl_chars as $c)<div class="k-sambung">{{ $c }}</div>@endforeach</div></td></tr>
            </table>
        </td></tr>
    </table>

    <div style="page-break-before: always;"></div>

    <table class="main-layout" style="margin-top: 20px;">
        <tr><td class="col-num">3</td><td style="padding:0; border-bottom: 1px solid #000;"><table style="width:100%; border-collapse:collapse;"><tr><td width="55%" style="border-right:1px solid #000; padding:4px; vertical-align:top;"><div class="f-label">PEKERJAAN * &nbsp; <span class="box-num">{{ $pekerjaan_id }}</span></div><div class="opt-row">1. PEJABAT NEGARA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4. PEGAWAI SWASTA</div><div class="opt-row">2. PEGAWAI NEGERI SIPIL &nbsp; 5. LAINNYA : {{ $pekerjaan_lainnya }}</div><div class="opt-row">3. TNI / POLRI</div></td><td width="45%" style="padding:4px; vertical-align:top;"><div class="f-label">STATUS SIPIL * &nbsp; <span class="box-num">{{ $status_sipil_id }}</span></div><div class="opt-row">1. KAWIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. CERAI MATI</div><div class="opt-row">2. TIDAK KAWIN &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4. CERAI HIDUP</div></td></tr></table></td></tr>
        <tr><td class="col-num">4</td><td style="padding:5px; border-bottom: 1px solid #000;"><div style="text-align:justify; font-size:8px; line-height:1.2; margin-bottom:10px;">Seluruh keterangan...</div><table style="width:100%; font-size:8px; border-collapse:collapse;"><tr><td width="35%" valign="bottom">Tanda tangan yang diberi kuasa,<br><br><br><br></td><td width="30%"></td><td width="35%" align="right" valign="bottom">Tanda tangan pemohon,<br><br><br><br></td></tr><tr><td valign="middle" style="padding: 2px 0;"><table style="width:auto;"><tr><td style="padding-right:5px;">Nama</td><td>@foreach($nama_ambil_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</td></tr></table></td><td></td><td align="right" valign="bottom"><span class="dotted-line" style="width:150px;"></span></td></tr><tr><td colspan="3" style="padding: 10px 0;">Paspor diterima pada tanggal : &nbsp; @for($i=0;$i<8;$i++)<div class="k">&nbsp;</div>@endfor</td></tr><tr><td valign="bottom">Tanda tangan penerima,<br><br><br><br></td><td></td><td align="right" valign="bottom">Petugas yang menyerahkan,<br><br><br><br></td></tr><tr><td valign="middle" style="padding: 2px 0;"><table style="width:auto;"><tr><td style="padding-right:5px;">Nama</td><td>@foreach($nama_ambil_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach</td></tr></table></td><td></td><td align="right" valign="bottom"><span class="dotted-line" style="width:150px;"></span></td></tr></table></td></tr>
        <tr><td class="col-num">5</td><td style="padding:0; border-bottom: 1px solid #000;"><table style="width:100%; border-collapse:collapse;"><tr><td width="50%" style="border-right:1px solid #000; padding:4px; vertical-align:top;"><div class="f-label bold">CATATAN PETUGAS LOKET</div><div style="font-size:8px;">Lampiran persyaratan :</div><ul class="list-syarat"><li><span class="chk-box"></span> Copy KTP WNI</li><li><span class="chk-box"></span> Copy Kartu Keluarga</li><li><span class="chk-box"></span> Copy Akte Kelahiran...</li><li><span class="chk-box"></span> Paspor / SPLP Lama</li><li><span class="chk-box"></span> Surat Keterangan Hilang...</li><li><span class="chk-box"></span> Surat Rekomendasi...</li><li><span class="chk-box"></span> Surat Kuasa...</li></ul><div style="text-align:right; margin-top:20px; padding-right:10px;"><div style="margin-bottom:25px; font-size:8px;">Paraf Petugas</div><span class="dotted-line" style="width:80px;"></span></div></td><td width="50%" style="padding:4px; vertical-align:top;"><div class="f-label bold">CATATAN PETUGAS WAWANCARA</div><div style="font-size:8px; margin-bottom:15px; margin-top:5px;">1. <span class="dotted-line" style="width:90%;"></span></div><div style="font-size:8px; margin-bottom:15px;">2. <span class="dotted-line" style="width:90%;"></span></div><div style="font-size:8px; margin-bottom:30px;">3. <span class="dotted-line" style="width:90%;"></span></div><div style="text-align:right; margin-top:10px; padding-right:10px;"><div style="margin-bottom:25px; font-size:8px;">Paraf Pejim,</div><span class="dotted-line" style="width:80px;"></span></div></td></tr></table></td></tr>
        <tr><td class="col-num" style="border-bottom:none;">6</td><td style="padding:0;"><div style="text-align:center; font-weight:bold; font-size:9px; padding:2px; border-bottom:1px solid #000;">CATATAN PEGAWAI TATA USAHA</div><table class="grid-data"><tr><td colspan="3"><span class="f-label">Nama Lama</span><div>@foreach($nama_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td colspan="3"><span class="f-label">Alamat Tempat Tinggal Lama</span><div>@foreach($alamat_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td width="50%"><span class="f-label">Nomor Paspor / SPLP Lama</span><div>@foreach($paspor_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td width="25%"><span class="f-label">Tanggal</span><div>@foreach($tanggal_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td width="25%"><span class="f-label">Berlaku s/d</span><div>@foreach($tanggal_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td colspan="3"><span class="f-label">Tempat Dikeluarkan</span><div>@foreach($reg_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td colspan="3"><span class="f-label">Nomor Register</span><div>@foreach($reg_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td width="50%"><span class="f-label">Nomor Register / SPLP Baru</span><div>@foreach($paspor_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td width="25%"><span class="f-label">Tanggal</span><div>@foreach($tanggal_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td width="25%"><span class="f-label">Berlaku s/d</span><div>@foreach($tanggal_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td colspan="3"><span class="f-label">Tempat Dikeluarkan</span><div>@foreach($reg_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr><tr><td colspan="2"><span class="f-label">Nomor Surat Persetujuan Kakanwil Depkumham</span><div>@foreach($surat_kakanwil_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td><td><span class="f-label">Tanggal</span><div>@foreach($tanggal_lama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div></td></tr></table><div style="text-align:right; font-size:8px; padding:5px;">Paraf Pegawai, <span class="dotted-line" style="width:60px;"></span></div></td></tr>
        <tr><td colspan="2" style="padding:0; border-top:2px solid #000;"><div style="text-align:center; font-weight:bold; font-size:9px; padding:2px; border-bottom:1px solid #000;">CATATAN PEJABAT IMIGRASI</div><table style="width:100%; border-collapse:collapse; font-size:8px;"><tr><td width="50%" style="border-right:1px solid #000; padding:3px; vertical-align:top;"><div style="margin-bottom:3px;">NIK @foreach($nik_pejim_chars as $c)<div class="k">{{ $c }}</div>@endforeach &nbsp;&nbsp; Paraf Pejim, ______</div>Tanggal @for($i=0;$i<8;$i++)<div class="k" style="margin-top:2px;">&nbsp;</div>@endfor<div style="margin-top:5px; border-top:1px solid #000; padding-top:2px;">Daftar Cekal : Tercantum <span class="chk-box"></span> Tidak <span class="chk-box"></span> <br>Kelainan Surat : Ada <span class="chk-box"></span> Tidak <span class="chk-box"></span> <br>Tanggal @for($i=0;$i<8;$i++)<div class="k" style="margin-top:2px;">&nbsp;</div>@endfor Paraf Pejim, ______</div></td><td width="50%" style="padding:3px; vertical-align:top;">Kelengkapan Persyaratan : Lengkap <span class="chk-box"></span> Tidak <span class="chk-box"></span> <br>Tanggal @for($i=0;$i<8;$i++)<div class="k" style="margin-top:2px;">&nbsp;</div>@endfor Paraf Pejim, ______<div style="margin-top:5px; border-top:1px solid #000; padding-top:2px;">Persetujuan : Setuju <span class="chk-box"></span> Tidak <span class="chk-box"></span> <br><br>KAKANIM,<br><br><span class="dotted-line" style="width:150px;"></span></div></td></tr></table></td></tr>
    </table>

    <div style="page-break-before: always;"></div>

    <div class="surat-container">
        <table class="kop-surat" style="margin-top:0;">
            <tr>
                <td class="kop-logo"><img src="{{ public_path('img/logo-kemenkumham.png') }}" alt="Logo" style="width: 60px; height: auto;"></td>
                <td class="kop-text">
                    <h1>KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA</h1>
                    <h2>DIREKTORAT JENDERAL IMIGRASI</h2>
                    <h2>KANTOR WILAYAH JAWA TENGAH</h2>
                    <h3>KANTOR IMIGRASI WONOSOBO</h3>
                    <p>Jalan Raya Banyumas km 5,5 Selomerto Wonosobo 56361</p>
                    <p>Telepon : (0286) 321628, Faksimile : (0286) 325587</p>
                    <p>Laman : www.kanimwonosobo.kemenkumham.go.id Pos-el : kanim.wonosobo@kemenkumham.go.id</p>
                </td>
            </tr>
        </table>

        <div class="legal-block">
            <div class="legal-title">UNDANG-UNDANG NOMOR 6 TAHUN 2011 TENTANG KEIMIGRASIAN PASAL 126 HURUF C DAN D :</div>
            <ol type="a" start="3" style="margin-top:0; padding-left:15px; margin-bottom:3px;">
                <li>memberikan data yang tidak sah atau keterangan yang tidak benar untuk memperoleh Dokumen Perjalanan Republik Indonesia bagi dirinya sendiri atau orang lain dipidana dengan pidana penjara paling lama 5 (lima) tahun dan pidana denda paling banyak Rp. 500.000.000,00 (lima ratus juta rupiah).</li>
                <li>Memiliki atau menggunakan secara melawan hukum 2 (dua) atau lebih Dokumen Perjalanan Republik Indonesia yang sejenis dan semuanya masih berlaku dipidana dengan pidana penjara paling lama 5 (lima) tahun dan pidana denda paling banyak Rp. 500.000.000,00 (lima ratus juta rupiah).</li>
            </ol>
            <div class="legal-title">PERATURAN MENTERI HUKUM DAN HAM RI NOMOR 8 TAHUN 2014 PASAL 21 :</div>
            <div style="padding-left:0;">Seluruh biaya yang berkaitan dengan permohonan Paspor Biasa yang telah disetorkan pada Kas Negara oleh Pemohon tidak dapat ditarik kembali.</div>
        </div>

        <div class="judul-surat">SURAT PERNYATAAN</div>
        <div style="font-size:11pt;">Yang bertanda tangan di bawah ini, saya :</div>
        <table class="table-isian">
            <tr><td width="120">Nama</td><td width="10">:</td><td class="dots-fill bold">{{ $nama }}</td></tr>
            <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td class="dots-fill bold">{{ $ttl }}</td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td class="dots-fill bold">{{ $pekerjaan_str }}</td></tr>
            <tr><td>Nomor HP</td><td>:</td><td class="dots-fill bold">{{ $no_hp }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td class="dots-fill bold">{{ $alamat }}</td></tr>
        </table>
        <div style="font-size:11pt;">Dengan ini menyatakan dengan sebenarnya bahwa :</div>
        <ol class="point-list">
            <li>Saya belum/sudah* mempunyai Paspor RI atau Dokumen Perjalanan RI lainnya;</li>
            <li>Semua surat atau dokumen yang saya lampirkan dalam pengajuan permohonan Paspor RI ini adalah benar milik saya dan sah secara hukum sesuai dengan ketentuan yang berlaku;</li>
            <li>Tujuan saya mengurus paspor adalah untuk <span class="dots-fill bold" style="padding:0 5px;">{{ $tujuan ?? 'WISATA' }}</span>...........;</li>
            <li>Saya tidak akan bekerja secara illegal di luar negeri/menjadi <b>TKI NON PROSEDURAL</b>;</li>
            <li>Apabila permohonan saya Ditolak Sistem/ Ditolak Wawancara/ Ditolak Adjudikator/ Reject Adjudicator Pusat, saya tidak akan menuntut pengembalian biaya paspor sesuai dengan pasal 21 Peraturan Menteri Hukum dan HAM RI Nomor 8 Tahun 2014;</li>
            <li>Bahwa saya tidak akan menyerahkan paspor tersebut yang masih berlaku kepada orang lain yang tidak berhak;</li>
            <li>Apabila paspor tersebut tidak saya ambil sampai batas waktu 30 (tiga puluh) hari sejak tanggal diterbitkan, maka saya mengetahui bahwa paspor saya tersebut telah dibatalkan oleh pejabat yang berwenang;</li>
            <li>Segala keterangan yang saya berikan dalam proses permohonan Paspor RI adalah benar dan dapat dipertanggungjawabkan secara hukum.</li>
        </ol>
        <div style="font-size:11pt; text-align:justify; margin-top:5px;">Demikian Surat Pernyataan ini dibuat dengan sebenarnya dan untuk dipergunakan sebagaimana mestinya. Apabila pernyataan ini tidak benar, saya bersedia dituntut sesuai dengan ketentuan peraturan perundang-undangan.</div>
        <div class="ttd-area-surat">Wonosobo,<br>Yang membuat pernyataan,<br><br><div class="materai-box">Materai<br>Rp. 10.000,-</div><br>(......................................................)</div>
        <div style="clear:both;"></div><div style="font-size:10pt; font-style:italic; margin-top:10px;">*coret yang tidak perlu</div>
    </div>

    <div style="page-break-before: always;"></div>

    <div class="surat-container">
        <table class="kop-surat" style="margin-top:0;">
            <tr>
                <td class="kop-logo"><img src="{{ public_path('img/logo-kemenkumham.png') }}" alt="Logo" style="width: 60px; height: auto;"></td>
                <td class="kop-text">
                    <h1>KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA</h1>
                    <h2>DIREKTORAT JENDERAL IMIGRASI</h2>
                    <h2>KANTOR WILAYAH JAWA TENGAH</h2>
                    <h3>KANTOR IMIGRASI WONOSOBO</h3>
                    <p>Jalan Raya Banyumas km 5,5 Selomerto Wonosobo 56361</p>
                    <p>Telepon : (0286) 321628, Faksimile : (0286) 325587</p>
                    <p>Email : kanim_wonosobo@imigrasi.go.id</p>
                </td>
            </tr>
        </table>

        <div style="text-align:center; font-weight:bold; font-size:13pt; margin-bottom:20px; text-decoration:underline;">HASIL WAWANCARA PEMOHON PASPOR RI</div>

        <p style="font-size:11pt;">Atas pertanyaan-pertanyaan petugas wawancara, pemohon mengaku dan memberi keterangan sebagai berikut :</p>

        <table class="table-isian">
            <tr><td width="150">Nama</td><td width="10">:</td><td class="dots-fill bold">{{ $nama }}</td><td width="30" align="right">(L/P)</td></tr>
            <tr><td>Tempat dan Tgl. Lahir</td><td>:</td><td class="dots-fill bold" colspan="2">{{ $ttl }}</td></tr>
            <tr><td>Pekerjaan</td><td>:</td><td class="dots-fill bold" colspan="2">{{ $pekerjaan_str }}</td></tr>
            <tr><td>Nama Ayah</td><td>:</td><td class="dots-fill bold" colspan="2">{{ $ayah_nama }}</td></tr>
            <tr><td>Nama Ibu</td><td>:</td><td class="dots-fill bold" colspan="2">{{ $ibu_nama }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td class="dots-fill bold" colspan="2">{{ $alamat }}</td></tr>
            <tr><td></td><td></td><td class="dots-fill" colspan="2" style="height:15px;"></td></tr>
        </table>

        <div class="wawancara-label">Maksud dan tujuan keluar negeri :</div>
        <div class="wawancara-dots"></div><div class="wawancara-dots"></div>
        <div class="wawancara-label">Keterangan lain :</div>
        <div class="wawancara-dots"></div><div class="wawancara-dots"></div><div class="wawancara-dots"></div><div class="wawancara-dots"></div>
        <div class="wawancara-label">Kesimpulan :</div>
        <div class="wawancara-dots"></div><div class="wawancara-dots"></div><div class="wawancara-dots"></div><div class="wawancara-dots"></div>

        <br><br>
        <table style="width: 100%; font-size:11pt;">
            <tr><td></td><td align="center" width="40%">Wonosobo,....................................</td></tr>
            <tr><td align="center">Pemohon,<br><br><br><br><br>( ........................................ )</td><td align="center">Petugas Wawancara,<br><br><br><br><br>( ........................................ )</td></tr>
        </table>
    </div>

    @if($cetak_surat_ortu)
    <div style="page-break-before: always;"></div>
    <div class="surat-container">
        <table class="kop-surat" style="margin-top:0;">
            <tr>
                <td class="kop-logo"><img src="{{ public_path('img/logo-kemenkumham.png') }}" alt="Logo" style="width: 60px; height: auto;"></td>
                <td class="kop-text">
                    <h1>KEMENTERIAN IMIGRASI DAN PEMASYARAKATAN REPUBLIK INDONESIA</h1>
                    <h2>DIREKTORAT JENDERAL IMIGRASI</h2>
                    <h2>KANTOR WILAYAH JAWA TENGAH</h2>
                    <h3>KANTOR IMIGRASI WONOSOBO</h3>
                    <p>Jalan Raya Banyumas km 5,5 Selomerto Wonosobo 56361</p>
                    <p>Telepon : (0286) 321628, Faksimile : (0286) 325587</p>
                    <p>Email : kanim_wonosobo@imigrasi.go.id</p>
                </td>
            </tr>
        </table>

        <div class="judul-surat">SURAT PERNYATAAN ORANG TUA</div>
        <div class="text-center" style="margin-top:-10px; font-style:italic; font-size:10pt;">(Untuk Permohonan Paspor Anak)</div>

        <div style="font-size:11pt; margin-top:15px;">Yang bertanda tangan di bawah ini :</div>
        <table class="table-isian">
            <tr><td width="150">Nama Ayah/Wali</td><td width="10">:</td><td class="dots-fill bold">{{ $ayah_nama }}</td></tr>
            <tr><td>Tempat, Tgl Lahir</td><td>:</td><td class="dots-fill bold">{{ $ayah_ttl }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td class="dots-fill bold">{{ $ortu_alamat }}</td></tr>
            <tr><td>Bertindak Selaku</td><td>:</td><td class="dots-fill bold">AYAH KANDUNG</td></tr>
        </table>

        <div style="font-size:11pt; margin-top:10px;">Adalah benar orang tua kandung dari anak :</div>
        <table class="table-isian">
            <tr><td width="150">Nama Anak</td><td width="10">:</td><td class="dots-fill bold">{{ $nama }}</td></tr>
            <tr><td>Tempat, Tgl Lahir</td><td>:</td><td class="dots-fill bold">{{ $ttl }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td class="dots-fill bold">{{ $alamat }}</td></tr>
        </table>

        <div style="font-size:11pt; text-align:justify; margin-top:10px; line-height:1.5;">
            Dengan ini menyatakan sesungguhnya bahwa kami menyetujui anak kami tersebut untuk membuat Paspor RI
            dan akan bertanggung jawab sepenuhnya atas keberangkatan dan kepulangan anak kami, 
            serta menanggung segala biaya yang timbul.
        </div>

        <div class="ttd-area-surat">
            Wonosobo, {{ $tgl_ttd }}<br>
            Yang Membuat Pernyataan,<br><br>
            <div class="materai-box">Materai<br>Rp. 10.000,-</div>
            <br>
            ( <b>{{ $ayah_nama }}</b> )
        </div>

        <div class="ttd-kiri">
            <br>
            Mengetahui,<br>
            Ibu Kandung<br><br><br><br><br>
            ( <b>{{ $ibu_nama }}</b> )
        </div>
    </div>
    @endif

</body>
</html>