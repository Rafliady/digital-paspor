<!DOCTYPE html>
<html>
<head>
    <title>Berkas Paspor Lengkap</title>
    <style>
        /* --- GLOBAL STYLE --- */
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; padding: 20px 30px; }
        
        /* Utility */
        .page-break { page-break-after: always; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-justify { text-align: justify; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* --- HEADER STYLE --- */
        .header-wrapper { position: relative; width: 100%; height: 50px; margin-bottom: 5px; }
        .instansi { text-align: center; font-weight: bold; font-size: 12px; line-height: 1.3; }
        .nomor-perdim { position: absolute; top: -20px; right: 0; font-weight: bold; font-size: 11px; }
        .garis-kop { border-bottom: 3px double #000; margin-bottom: 10px; }
        
        /* --- LAYOUT GRID PERDIM --- */
        table.layout { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        table.layout td { vertical-align: middle; padding: 3px 0; }
        
        /* Kolom Label & Input Perdim */
        .col-label-L { width: 140px; font-weight: bold; text-transform: uppercase; }
        .col-input-L { width: auto; }
        .col-label-R { width: 100px; font-weight: bold; text-transform: uppercase; padding-left: 10px;}
        .col-input-R { width: 110px; }

        /* Kotak Styles */
        .kotak { display: inline-block; width: 15px; height: 16px; border: 1px solid #000; text-align: center; line-height: 15px; font-weight: bold; font-size: 11px; margin-right: 2px; }
        .kotak-sambung { display: inline-block; width: 15px; height: 16px; border: 1px solid #000; text-align: center; line-height: 15px; font-weight: bold; font-size: 11px; margin-right: -1px; }
        .small-unit { font-size: 9px; margin-left: 3px; }

        /* --- STYLE SURAT TEXT (Pernyataan & Wawancara) --- */
        table.plain-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.plain-table td { vertical-align: top; padding: 4px 0; font-size: 11px; }
        
        .isian-text { font-weight: bold; font-size: 11px; text-transform: uppercase; }
        .border-dots { border-bottom: 1px dotted #000; }
        
        .list-numbered { padding-left: 20px; margin: 5px 0; }
        .list-numbered li { margin-bottom: 5px; text-align: justify; }

        .materai-box { border: 1px solid #ccc; width: 60px; height: 30px; margin: 10px auto; font-size: 8px; padding-top: 10px; text-align: center; }
        .ttd-block { width: 250px; text-align: center; }
    </style>
</head>
<body>

    <div class="header-wrapper">
        <div class="instansi">{{ $kop_instansi }}<br>DIREKTORAT JENDERAL IMIGRASI</div>
        <div class="nomor-perdim">PERDIM : 11</div>
    </div>
    <div class="garis-kop"></div>
    <h3 class="text-center" style="text-decoration: underline; margin: 0 0 10px 0;">FORMULIR PERJALANAN REPUBLIK INDONESIA</h3>
    
    <div style="font-size: 9px; margin-bottom: 10px;">
        Perhatian: 1. Isi formulir dengan HURUF CETAK dan TINTA HITAM<br>
        2. Tanda asterisk (*) berarti diisi sesuai nomor pilihan
    </div>

    <div style="border: 1px solid black; padding: 5px;">
        <table class="layout">
            <tr>
                <td class="col-label-L">PERMOHONAN *</td>
                <td><div class="kotak">X</div> Baru &nbsp;&nbsp; <div class="kotak">&nbsp;</div> Penggantian</td>
            </tr>
        </table>
        <hr style="border: 0; border-top: 1px solid black; margin: 2px 0 5px 0;">

        <table class="layout">
            <tr>
                <td class="col-label-L">NAMA LENGKAP</td>
                <td class="col-input-L">
                    @foreach($nama_chars as $char) <div class="kotak">{{ $char }}</div> @endforeach
                </td>
                <td class="col-label-R">JENIS KELAMIN</td>
                <td class="col-input-R">
                    <div class="kotak">{{ $jk == 'L' ? 'X' : '' }}</div> L &nbsp; <div class="kotak">{{ $jk == 'P' ? 'X' : '' }}</div> P
                </td>
            </tr>
            <tr>
                <td class="col-label-L">NAMA LAIN (ALIAS)</td>
                <td class="col-input-L">@for($i=0; $i<20; $i++) <div class="kotak">&nbsp;</div> @endfor</td>
                <td class="col-label-R">TINGGI BADAN</td>
                <td class="col-input-R">
                    @foreach($tinggi_chars as $t) <div class="kotak-sambung">{{ $t }}</div> @endforeach <span class="small-unit">cm</span>
                </td>
            </tr>
            <tr>
                <td class="col-label-L">TEMPAT LAHIR</td>
                <td class="col-input-L">
                    @foreach($tempat_chars as $t) <div class="kotak">{{ $t }}</div> @endforeach
                </td>
                <td class="col-label-R">TANGGAL LAHIR</td>
                <td class="col-input-R">
                    @foreach($tgl_lahir_chars as $t) <div class="kotak-sambung">{{ $t }}</div> @endforeach
                </td>
            </tr>
            <tr>
                <td class="col-label-L">NOMOR KTP / NIK</td>
                <td class="col-input-L">
                    @foreach($nik_chars as $n) <div class="kotak">{{ $n }}</div> @endforeach
                </td>
                <td class="col-label-R" style="font-size:9px;">TGL DIBERLAKUKAN</td>
                <td class="col-input-R">
                    @foreach($tgl_berlaku_chars as $t) <div class="kotak-sambung">{{ $t }}</div> @endforeach
                </td>
            </tr>
            <tr>
                <td class="col-label-L">TEMPAT DIKELUARKAN</td>
                <td class="col-input-L">
                    @foreach($tempat_keluar_chars as $t) <div class="kotak">{{ $t }}</div> @endforeach
                </td>
                <td class="col-label-R">BERLAKU S/D</td>
                <td class="col-input-R">
                    @foreach($tgl_habis_chars as $t) <div class="kotak-sambung">{{ $t }}</div> @endforeach
                </td>
            </tr>
        </table>

        <table class="layout">
            <tr>
                <td class="col-label-L">PEKERJAAN</td>
                <td colspan="3"> @foreach($pekerjaan_chars as $char) 
                        <div class="kotak">{{ $char }}</div> 
                    @endforeach
                </td>
            </tr>
            
            <tr>
                <td class="col-label-L" style="vertical-align: top;">ALAMAT TINGGAL</td>
                <td colspan="3">
                    <div style="margin-bottom: 2px;">
                        @foreach(array_slice($alamat_chars, 0, 35) as $char) 
                            <div class="kotak">{{ $char }}</div> 
                        @endforeach
                    </div>
                    
                    <div>
                        @foreach(array_slice($alamat_chars, 35, 35) as $char) 
                            <div class="kotak">{{ $char }}</div> 
                        @endforeach
                    </div>
                    
                    </td>
            </tr>
        </table>
    </div>
    </div>
    
    <div class="page-break"></div>


    <div class="header-wrapper">
        <div class="instansi">{{ $kop_instansi }}<br>KANTOR IMIGRASI WONOSOBO</div>
        <div style="font-size: 9px; text-align: center;">Jalan Raya Banyumas km 5,5 Selomerto Wonosobo</div>
    </div>
    <div class="garis-kop"></div>

    <h3 class="text-center" style="text-decoration: underline;">SURAT PERNYATAAN</h3>

    <p>Yang bertanda tangan di bawah ini, saya :</p>

    <table class="plain-table">
        <tr><td width="150">Nama</td><td width="10">:</td><td class="isian-text">{{ $nama }}</td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td class="isian-text">{{ $ttl }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td class="isian-text">{{ $pekerjaan }}</td></tr>
        <tr><td>Nomor HP</td><td>:</td><td class="isian-text">{{ $no_hp }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td class="isian-text">{{ $alamat }}</td></tr>
    </table>

    <p>Dengan ini menyatakan dengan sebenarnya bahwa :</p>

    <ol class="list-numbered">
        <li>Saya belum/sudah* mempunyai Paspor RI atau Dokumen Perjalanan RI lainnya;</li>
        <li>Semua surat atau dokumen yang saya lampirkan adalah benar milik saya dan sah secara hukum;</li>
        <li>Tujuan saya mengurus paspor adalah untuk <b>{{ $tujuan }}</b>;</li>
        <li>Saya tidak akan bekerja secara illegal di luar negeri/menjadi TKI NON PROSEDURAL;</li>
        <li>Apabila permohonan saya Ditolak Sistem/Wawancara, saya tidak akan menuntut pengembalian biaya paspor;</li>
        <li>Segala keterangan yang saya berikan adalah benar dan dapat dipertanggungjawabkan secara hukum.</li>
    </ol>

    <br>
    <div style="float: right;" class="ttd-block">
        Wonosobo, {{ $tgl_ttd }}<br>
        Yang Membuat Pernyataan,<br>
        <div class="materai-box">Materai<br>Rp10.000</div>
        <br><br>
        ( <b>{{ $nama }}</b> )
    </div>

    <div class="page-break"></div>


    <div class="header-wrapper">
        <div class="instansi">{{ $kop_instansi }}<br>KANTOR IMIGRASI WONOSOBO</div>
    </div>
    <div class="garis-kop"></div>

    <h3 class="text-center">HASIL WAWANCARA PEMOHON PASPOR RI</h3>

    <p>Atas pertanyaan-pertanyaan petugas wawancara, pemohon mengaku dan memberi keterangan sebagai berikut :</p>

    <table class="plain-table">
        <tr><td width="150">Nama</td><td width="10">:</td><td class="border-dots"><b>{{ $nama }}</b></td></tr>
        <tr><td>Tempat dan Tgl. Lahir</td><td>:</td><td class="border-dots">{{ $ttl }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td class="border-dots">{{ $pekerjaan }}</td></tr>
        <tr><td>Nama Ayah</td><td>:</td><td class="border-dots">{{ $ayah_nama }}</td></tr>
        <tr><td>Nama Ibu</td><td>:</td><td class="border-dots">{{ $ibu_nama }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td class="border-dots">{{ $alamat }}</td></tr>
    </table>

    <br>
    <p>Maksud dan tujuan keluar negeri :</p>
    <div class="border-dots" style="padding: 5px;">{{ $tujuan }}</div>
    
    <br>
    <p>Keterangan lain :</p>
    <div class="border-dots" style="height: 20px;"></div>
    <div class="border-dots" style="height: 20px;"></div>

    <br>
    <p>Kesimpulan :</p>
    <div class="border-dots" style="padding: 5px;">DAPAT DIBERIKAN PASPOR</div>

    <br><br>
    <table style="width: 100%;">
        <tr>
            <td class="text-center" width="50%">
                Pemohon,<br><br><br><br>
                ( {{ $nama }} )
            </td>
            <td class="text-center" width="50%">
                Wonosobo, ........................<br>
                Petugas Wawancara,<br><br><br><br>
                ( ...................................... )
            </td>
        </tr>
    </table>


    @if($cetak_surat_ortu)
    
    <div class="page-break"></div>

    <div class="header-wrapper">
        <div class="instansi">{{ $kop_instansi }}<br>KANTOR IMIGRASI WONOSOBO</div>
    </div>
    <div class="garis-kop"></div>

    <h3 class="text-center" style="text-decoration: underline;">SURAT PERNYATAAN ORANG TUA</h3>
    <p class="text-center" style="margin-top: -10px; font-style: italic;">(Untuk Permohonan Paspor Anak Dibawah Umur)</p>

    <br>
    <p>Yang bertanda tangan di bawah ini:</p>

    <table class="plain-table">
        <tr><td width="150">Nama Ayah/Wali</td><td width="10">:</td><td class="isian-text">{{ $ayah_nama }}</td></tr>
        <tr><td>Tempat, Tgl Lahir</td><td>:</td><td class="isian-text">{{ $ayah_ttl }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td class="isian-text">{{ $ortu_alamat }}</td></tr>
        <tr><td>Bertindak selaku</td><td>:</td><td class="isian-text">AYAH KANDUNG</td></tr>
    </table>

    <p>Adalah benar orang tua kandung dari anak:</p>

    <table class="plain-table">
        <tr><td width="150">Nama Anak</td><td width="10">:</td><td class="isian-text">{{ $nama }}</td></tr>
        <tr><td>Tempat, Tgl Lahir</td><td>:</td><td class="isian-text">{{ $ttl }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td class="isian-text">{{ $alamat }}</td></tr>
    </table>

    <p class="text-justify">
        Dengan ini menyatakan sesungguhnya bahwa kami menyetujui anak kami tersebut untuk membuat Paspor RI
        dan akan bertanggung jawab sepenuhnya atas keberangkatan dan kepulangan anak kami, 
        serta menanggung segala biaya yang timbul. Apabila dikemudian hari keterangan ini tidak benar, 
        kami bersedia dituntut sesuai dengan hukum yang berlaku.
    </p>

    <br>
    
    <div style="float: right;" class="ttd-block">
        Wonosobo, {{ $tgl_ttd }}<br>
        Yang Membuat Pernyataan,<br>
        <div class="materai-box">Materai<br>Rp 10.000</div>
        <br><br>
        ( <b>{{ $ayah_nama }}</b> )
    </div>
    
    <div style="float: left;" class="ttd-block">
        <br>Mengetahui,<br>Ibu Kandung<br><br><br><br><br>
        ( <b>{{ $ibu_nama }}</b> )
    </div>

    @endif

</body>
</html>