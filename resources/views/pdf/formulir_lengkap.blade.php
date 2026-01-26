<!DOCTYPE html>
<html>
<head>
    <title>Formulir Paspor Lengkap</title>
    <style>
        /* --- GLOBAL --- */
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; padding: 20px 30px; }
        .page-break { page-break-after: always; }
        .text-center { text-align: center; }
        .text-justify { text-align: justify; }
        .bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }

        /* --- HEADER HALAMAN 1 --- */
        .header-wrapper { height: 50px; margin-bottom: 5px; }
        .instansi { float: left; font-weight: bold; font-size: 10px; line-height: 1.2; }
        .nomor-perdim { float: right; font-weight: bold; font-size: 11px; text-align: right; }
        .clear { clear: both; }

        /* --- TABEL UTAMA (LAYOUT FORM) --- */
        table.form-layout { 
            width: 100%; 
            border-collapse: collapse; 
            border: 2px solid #000; /* Bingkai Luar Tebal */
        }
        
        /* Baris Biasa (Garis Bawah Tipis) */
        table.form-layout tr { border-bottom: 1px solid #000; }
        
        /* Sel Biasa (Tanpa Kotak, Padding Rapi) */
        table.form-layout td { 
            padding: 3px 5px; 
            vertical-align: top;
        }

        /* Garis Pemisah Vertikal (Untuk memisah Kiri/Kanan) */
        .border-right { border-right: 1px solid #000; }

        /* Hapus Border Bawah (Untuk Baris Split seperti Alamat) */
        .no-border-bottom { border-bottom: none !important; }
        .no-border-top { border-top: none !important; }

        /* LABEL & INPUT */
        .f-label {
            font-size: 8px; font-weight: bold; color: #555;
            text-transform: uppercase; margin-bottom: 1px; display: block;
        }
        
        /* Label dengan Titik Hitam */
        .label-with-dot { display: block; margin-bottom: 1px; }
        .dot { display: inline-block; width: 8px; height: 8px; background: #000; margin-right: 4px; vertical-align: middle; }
        .label-text { font-size: 8px; font-weight: bold; color: #555; text-transform: uppercase; vertical-align: middle; }

        /* KOTAK ISIAN */
        .box-row { margin-top: 1px; white-space: nowrap; }
        .k { 
            display: inline-block; width: 13px; height: 14px; 
            border: 1px solid #000; text-align: center; 
            line-height: 13px; font-size: 10px; font-weight: bold; 
            margin-right: 1px; vertical-align: middle;
        }
        .k-sambung { 
            display: inline-block; width: 13px; height: 14px; 
            border: 1px solid #000; text-align: center; 
            line-height: 13px; font-size: 10px; font-weight: bold; 
            margin-right: -1px; vertical-align: middle;
        }
        
        /* CHECKBOX */
        .chk { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; text-align: center; line-height: 11px; font-size: 9px; vertical-align: middle; }

        /* --- STYLES SURAT TEXT (Pernyataan & Wawancara) --- */
        table.plain-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.plain-table td { vertical-align: top; padding: 4px 0; font-size: 11px; border: none; }
        .isian-text { font-weight: bold; font-size: 11px; text-transform: uppercase; }
        .border-dots { border-bottom: 1px dotted #000; }
        .materai-box { border: 1px solid #ccc; width: 60px; height: 30px; margin: 10px auto; font-size: 8px; padding-top: 10px; text-align: center; }
        .ttd-area { width: 250px; text-align: center; float: right; }
        .ttd-left { width: 250px; text-align: center; float: left; }
    </style>
</head>
<body>

    <div class="header-wrapper">
        <div class="instansi">
            KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA RI<br>
            KANTOR WILAYAH DEP. HUKUM DAN HAM JAWA TENGAH<br>
            KANTOR IMIGRASI WONOSOBO
        </div>
        <div class="nomor-perdim">
            PERDIM : 11<br>NO: ....................
        </div>
        <div class="clear"></div>
    </div>

    <div class="text-center bold" style="text-decoration: underline; font-size: 12px; margin: 10px 0;">
        FORMULIR SURAT PERJALANAN REPUBLIK INDONESIA<br>UNTUK WARGA NEGARA INDONESIA
    </div>
    
    <div style="font-size: 8px; border: 1px solid #000; padding: 3px; margin-bottom: 3px;">
        <strong>PERHATIAN:</strong> 1. Isi formulir dengan HURUF CETAK dan TINTA HITAM. 2. Tanda asterisk (*) berarti diisi sesuai nomor pilihan.
    </div>

    <table class="form-layout">
        <tr style="background: #f9f9f9;">
            <td colspan="4">
                <span class="f-label" style="display:inline; margin-right: 15px;">PERMOHONAN *</span>
                <span class="chk">X</span> <span style="font-size: 9px;">Baru</span> &nbsp; 
                <span class="chk">&nbsp;</span> <span style="font-size: 9px;">Penggantian</span> &nbsp;
                <span class="chk">&nbsp;</span> <span style="font-size: 9px;">Perubahan</span>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="border-right" style="width: 75%;">
                <span class="f-label">NAMA LENGKAP</span>
                <div class="box-row">@foreach($nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td>
                <span class="f-label">JENIS KELAMIN *</span>
                <span class="chk">{{ $jk=='L'?'X':'' }}</span> L &nbsp;
                <span class="chk">{{ $jk=='P'?'X':'' }}</span> P
            </td>
        </tr>

        <tr>
            <td colspan="3" class="border-right">
                <span class="f-label">NAMA LAIN (ALIAS) **</span>
                <div class="box-row">@for($i=0;$i<25;$i++)<div class="k">&nbsp;</div>@endfor</div>
            </td>
            <td>
                <span class="f-label">TINGGI BADAN</span>
                @foreach($tinggi_chars as $t)<div class="k">{{ $t }}</div>@endforeach cm
            </td>
        </tr>

        <tr>
            <td colspan="2" class="border-right" style="width: 60%;">
                <span class="f-label">TEMPAT LAHIR</span>
                <div class="box-row">@foreach($tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td colspan="2">
                <div class="label-with-dot">
                    <span class="dot"></span><span class="label-text">TANGGAL LAHIR</span>
                </div>
                <div class="box-row">@foreach($tgl_lahir_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="border-right">
                <span class="f-label">NOMOR KTP WNI</span>
                <div class="box-row">@foreach($nik_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td colspan="2">
                <div class="label-with-dot">
                    <span class="dot"></span><span class="label-text">TGL DIBERLAKUKAN</span>
                </div>
                <div class="box-row">@foreach($tgl_berlaku_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="border-right">
                <span class="f-label">TEMPAT DIKELUARKAN</span>
                <div class="box-row">@foreach($tempat_keluar_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td colspan="2">
                <div class="label-with-dot">
                    <span class="dot"></span><span class="label-text">BERLAKU S/D</span>
                </div>
                <div class="box-row">@foreach($tgl_habis_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>

        <tr class="no-border-bottom">
            <td colspan="4" style="padding-bottom: 0;">
                <span class="f-label">NAMA DAN ALAMAT KANTOR / PEKERJAAN ***</span>
                <div class="box-row">@foreach($pekerjaan_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top: 2px;">
                <div class="box-row">
                    @foreach($pekerjaan_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach
                    <span style="font-size: 9px; font-weight: bold; margin: 0 8px;">TELP / HP</span>
                    @foreach($telp_chars as $c)<div class="k">{{ $c }}</div>@endforeach
                </div>
            </td>
        </tr>

        <tr class="no-border-bottom">
            <td colspan="4" style="padding-bottom: 0;">
                <span class="f-label">ALAMAT TEMPAT TINGGAL</span>
                <div class="box-row">@foreach($alamat_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top: 2px;">
                <div class="box-row">
                    @foreach($alamat_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach
                    <span style="font-size: 9px; font-weight: bold; margin: 0 8px;">TELP / HP</span>
                    @foreach($telp_chars as $c)<div class="k">{{ $c }}</div>@endforeach
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <span class="f-label">ALAMAT EMAIL</span>
                <div class="box-row">@foreach($email_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <span class="f-label">NAMA IBU</span>
                <div class="box-row">@foreach($ibu_nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <span class="f-label">KEWARGANEGARAAN</span>
                <div class="box-row">@foreach($ibu_warga_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-right">
                <span class="f-label">TEMPAT LAHIR</span>
                <div class="box-row">@foreach($ibu_tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td colspan="2">
                <div class="label-with-dot">
                    <span class="dot"></span><span class="label-text">TANGGAL LAHIR</span>
                </div>
                <div class="box-row">@foreach($ibu_tgl_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <span class="f-label">NAMA AYAH</span>
                <div class="box-row">@foreach($ayah_nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <span class="f-label">KEWARGANEGARAAN</span>
                <div class="box-row">@foreach($ayah_warga_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-right">
                <span class="f-label">TEMPAT LAHIR</span>
                <div class="box-row">@foreach($ayah_tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td colspan="2">
                <div class="label-with-dot">
                    <span class="dot"></span><span class="label-text">TANGGAL LAHIR</span>
                </div>
                <div class="box-row">@foreach($ayah_tgl_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>

        <tr class="no-border-bottom">
            <td colspan="4" style="padding-bottom: 0;">
                <span class="f-label">ALAMAT ORANG TUA</span>
                <div class="box-row">@foreach($ortu_alamat_1_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top: 2px;">
                <div class="box-row">
                    @foreach($ortu_alamat_2_chars as $c)<div class="k">{{ $c }}</div>@endforeach
                    <span style="font-size: 9px; font-weight: bold; margin: 0 8px;">TELP / HP</span>
                    @for($i=0;$i<12;$i++)<div class="k">&nbsp;</div>@endfor
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <span class="f-label">NAMA SUAMI / ISTRI</span>
                <div class="box-row">@foreach($pasangan_nama_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <span class="f-label">KEWARGANEGARAAN</span>
                <div class="box-row">@foreach($pasangan_warga_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border-right">
                <span class="f-label">TEMPAT LAHIR</span>
                <div class="box-row">@foreach($pasangan_tempat_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
            <td colspan="2">
                <div class="label-with-dot">
                    <span class="dot"></span><span class="label-text">TANGGAL LAHIR</span>
                </div>
                <div class="box-row">@foreach($pasangan_tgl_chars as $c)<div class="k">{{ $c }}</div>@endforeach</div>
            </td>
        </tr>
    </table>

    <div class="page-break"></div>


    <div class="header-wrapper">
        <div class="instansi">{{ $kop_instansi ?? 'KEMENTERIAN HUKUM DAN HAM' }}<br>KANTOR IMIGRASI WONOSOBO</div>
        <div style="font-size: 9px; text-align: center; clear:both; padding-top: 5px;">Jalan Raya Banyumas km 5,5 Selomerto Wonosobo</div>
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

    <ol style="padding-left: 20px; margin: 5px 0;">
        <li style="margin-bottom: 5px;">Saya belum/sudah* mempunyai Paspor RI atau Dokumen Perjalanan RI lainnya;</li>
        <li style="margin-bottom: 5px;">Semua surat atau dokumen yang saya lampirkan adalah benar milik saya dan sah secara hukum;</li>
        <li style="margin-bottom: 5px;">Tujuan saya mengurus paspor adalah untuk <b>{{ $tujuan }}</b>;</li>
        <li style="margin-bottom: 5px;">Saya tidak akan bekerja secara illegal di luar negeri/menjadi TKI NON PROSEDURAL;</li>
        <li style="margin-bottom: 5px;">Apabila permohonan saya Ditolak Sistem/Wawancara, saya tidak akan menuntut pengembalian biaya paspor;</li>
        <li style="margin-bottom: 5px;">Segala keterangan yang saya berikan adalah benar dan dapat dipertanggungjawabkan secara hukum.</li>
    </ol>

    <br>
    <div class="ttd-area">
        Wonosobo, {{ $tgl_ttd }}<br>
        Yang Membuat Pernyataan,<br>
        <div class="materai-box">Materai<br>Rp10.000</div>
        <br><br>
        ( <b>{{ $nama }}</b> )
    </div>

    <div class="page-break"></div>


    <div class="header-wrapper">
        <div class="instansi">{{ $kop_instansi ?? 'KEMENTERIAN HUKUM DAN HAM' }}<br>KANTOR IMIGRASI WONOSOBO</div>
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
        <div class="instansi">{{ $kop_instansi ?? 'KEMENTERIAN HUKUM DAN HAM' }}<br>KANTOR IMIGRASI WONOSOBO</div>
    </div>
    <div class="garis-kop"></div>

    <h3 class="text-center" style="text-decoration: underline;">SURAT PERNYATAAN ORANG TUA</h3>
    <p class="text-center" style="margin-top: -10px; font-style: italic;">(Untuk Permohonan Paspor Anak)</p>

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
        serta menanggung segala biaya yang timbul.
    </p>

    <br>
    
    <div class="ttd-area">
        Wonosobo, {{ $tgl_ttd }}<br>
        Yang Membuat Pernyataan,<br>
        <div class="materai-box">Materai<br>Rp 10.000</div>
        <br><br>
        ( <b>{{ $ayah_nama }}</b> )
    </div>
    
    <div class="ttd-left">
        <br>Mengetahui,<br>Ibu Kandung<br><br><br><br><br>
        ( <b>{{ $ibu_nama }}</b> )
    </div>

    @endif

</body>
</html>