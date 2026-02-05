<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Paspor Digital</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/logo_imigrasi.png') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* --- MODERN THEME --- */
        :root {
            --primary-color: #0c2e8a; /* Biru Imigrasi */
            --secondary-color: #bfa15f; /* Emas */
            --bg-color: #f4f7f6;
        }

/* OPSI 3: GAMBAR LATAR BELAKANG (CERAH/ASLI) */
body {
    /* HANYA memanggil gambar, tanpa lapisan warna biru */
    background-image: url("{{ asset('img/bg-imigrasi.jpg') }}");

    /* Pengaturan agar gambar pas di layar */
    background-size: cover;
    background-position: center center;
    background-attachment: fixed; /* Gambar diam saat discroll */
    background-repeat: no-repeat;

    font-family: 'Poppins', sans-serif;
    padding-bottom: 80px;
    color: #333;
    min-height: 100vh; /* Memastikan background memenuhi tinggi layar */
}

        /* CARD STYLING */
        .card { 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.08); 
            overflow: hidden; 
            background: white;
        }
        
        .card-header { 
            background: linear-gradient(135deg, var(--primary-color) 0%, #001f52 100%); 
            color: white; 
            padding: 30px 20px; 
            border-bottom: 5px solid var(--secondary-color);
        }

        /* STEPPER INDICATOR */
        .step-indicator { 
            display: flex; 
            justify-content: space-between; 
            margin: 30px 0 40px; 
            position: relative; 
            padding: 0 10px; 
        }
        .progress-bg { 
            position: absolute; 
            top: 20px; 
            left: 0; 
            width: 100%; 
            height: 4px; 
            background: #e9ecef; 
            z-index: 1; 
            border-radius: 10px;
        }
        .progress-fill { 
            height: 100%; 
            background: var(--secondary-color); 
            width: 0%; 
            transition: 0.4s ease-in-out; 
            border-radius: 10px;
        }
        .step-item { z-index: 2; text-align: center; width: 33.33%; }
        .step { 
            width: 45px; 
            height: 45px; 
            background: white; 
            border: 3px solid #e9ecef; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: bold; 
            color: #999; 
            margin: 0 auto 10px; 
            transition: 0.3s; 
            font-size: 1.1rem;
        }
        .step.active { 
            border-color: var(--primary-color); 
            background: var(--primary-color); 
            color: white; 
            transform: scale(1.1); 
            box-shadow: 0 0 15px rgba(12, 46, 138, 0.3); 
        }
        .step.finish { 
            border-color: var(--secondary-color); 
            background: var(--secondary-color); 
            color: white; 
        }
        .step-label { font-size: 0.85rem; font-weight: 600; color: #aaa; transition: 0.3s; }
        .step-item.active .step-label { color: var(--primary-color); }

        /* FORM STYLING */
        .form-label { font-weight: 600; font-size: 0.9rem; color: #444; margin-bottom: 6px; }
        .form-control, .form-select { 
            border-radius: 10px; 
            border: 1px solid #dee2e6; 
            padding: 12px 15px; 
            font-size: 0.95rem; 
            transition: 0.3s;
        }
        .form-control:focus, .form-select:focus { 
            border-color: var(--primary-color); 
            box-shadow: 0 0 0 4px rgba(12, 46, 138, 0.1); 
        }
        
        .bg-light-blue { 
            background-color: #f8faff; 
            border-radius: 15px; 
            padding: 20px; 
            margin-bottom: 20px; 
            border: 1px dashed #ced4da; 
        }

        /* BUTTONS */
        .btn-primary { 
            background-color: var(--primary-color); 
            border: none; 
            padding: 12px 30px; 
            border-radius: 10px; 
            font-weight: 600; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            transition: 0.3s; 
        }
        .btn-primary:hover { background-color: #08226b; transform: translateY(-2px); }
        
        .btn-success {
            background: linear-gradient(45deg, #11998e, #38ef7d);
            border: none;
            box-shadow: 0 4px 15px rgba(56, 239, 125, 0.4);
        }

        /* ANIMASI HALAMAN */
        .form-section { display: none; opacity: 0; transform: translateY(20px); transition: 0.4s ease-out; }
        .form-section.current { display: block; opacity: 1; transform: translateY(0); }

        /* AREA SCAN KAMERA */
        #video-container { 
            position: relative; width: 100%; max-width: 100%; 
            margin: 15px auto; display: none; border-radius: 15px; 
            overflow: hidden; border: 4px solid var(--primary-color); 
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
        }
        video { width: 100%; height: auto; display: block; transform: scaleX(1); } /* Pastikan tidak mirror */
        .overlay-guide { 
            position: absolute; top: 15%; left: 5%; width: 90%; height: 70%; 
            border: 2px dashed rgba(255,255,255,0.8); border-radius: 10px; 
            box-shadow: 0 0 0 9999px rgba(0,0,0,0.6); pointer-events: none; 
        }
        .overlay-text { 
            position: absolute; bottom: 20px; width: 100%; text-align: center; 
            color: white; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.8); 
            pointer-events: none; letter-spacing: 1px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <div class="card">
                <div class="card-header text-center">
                    <img src="{{ asset('img/logo_imigrasi.png') }}" alt="Logo" style="height: 50px; margin-bottom: 10px;">
                    <h3 class="mb-0 fw-bold">FORMULIR PASPOR DIGITAL</h3>
                    <p class="mb-0 text-white-50 small">Kantor Imigrasi Kelas II Non TPI Wonosobo</p>
                </div>
                <div class="card-body p-4 p-md-5">

                    <div class="card border-0 bg-light-blue mb-5">
                        <div class="card-body text-center">
                            <h5 class="fw-bold text-dark mb-2"><i class="bi bi-qr-code-scan text-primary"></i> Isi Otomatis (OCR)</h5>
                            <p class="small text-muted mb-3">Gunakan kamera HP atau upload foto KTP untuk mengisi data secara otomatis.</p>
                            
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <button class="btn btn-primary" onclick="startCamera()">
                                    <i class="bi bi-camera-fill me-2"></i> Buka Kamera
                                </button>
                                <button class="btn btn-outline-secondary bg-white" onclick="document.getElementById('uploadKtp').click()">
                                    <i class="bi bi-upload me-2"></i> Upload File
                                </button>
                                <input type="file" id="uploadKtp" accept="image/*" style="display:none;" onchange="handleFileUpload(this)">
                            </div>

                            <div id="video-container">
                                <video id="video" autoplay playsinline></video>
                                <div class="overlay-guide"></div>
                                <div class="overlay-text">POSISIKAN KTP DALAM KOTAK</div>
                                <canvas id="canvas" style="display:none;"></canvas>
                                
                                <div class="p-3 bg-dark d-flex justify-content-between align-items-center">
                                    <button class="btn btn-danger btn-sm px-3" onclick="stopCamera()">Batal</button>
                                    <button class="btn btn-light btn-sm fw-bold px-4" onclick="takeSnapshot()">
                                        <i class="bi bi-circle-fill text-danger small me-1"></i> AMBIL FOTO
                                    </button>
                                </div>
                            </div>

                            <div id="scanProgressBox" class="mt-4 px-3" style="display:none;">
                                <div class="d-flex justify-content-between small fw-bold mb-1">
                                    <span class="text-primary" id="statusScan">Memproses...</span>
                                    <span id="percentScan">0%</span>
                                </div>
                                <div class="progress" style="height: 8px; border-radius: 5px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" id="progressBarScan" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="step-indicator">
                        <div class="progress-bg"><div class="progress-fill" id="progressFill"></div></div>
                        <div class="step-item active" id="stepItem1">
                            <div class="step active" id="step1"><i class="bi bi-person"></i></div>
                            <div class="step-label">Identitas</div>
                        </div>
                        <div class="step-item" id="stepItem2">
                            <div class="step" id="step2"><i class="bi bi-people"></i></div>
                            <div class="step-label">Keluarga</div>
                        </div>
                        <div class="step-item" id="stepItem3">
                            <div class="step" id="step3"><i class="bi bi-file-earmark-text"></i></div>
                            <div class="step-label">Tambahan</div>
                        </div>
                    </div>

                    <form action="{{ route('cetak.proses') }}" method="POST" target="_blank" id="mainForm" novalidate>
                        @csrf
                        
                        <div class="form-section current" id="section1">
                            
                            <div class="alert alert-light border border-primary d-flex align-items-center p-3 mb-4 rounded-3 shadow-sm">
                                <div class="form-check form-switch w-100">
                                    <input class="form-check-input" type="checkbox" id="buat_surat_ortu" name="buat_surat_ortu" value="1" onchange="toggleAnak()" style="width: 50px; height: 25px; margin-right: 15px;">
                                    <label class="form-check-label fw-bold pt-1" for="buat_surat_ortu" style="cursor: pointer;">
                                        Pemohon Adalah Anak Dibawah Umur <span class="badge bg-warning text-dark ms-2">Belum KTP</span>
                                    </label>
                                    <div class="text-muted small mt-1" id="info-anak" style="display:none; padding-left: 0;">
                                        <i class="bi bi-info-circle-fill text-primary"></i> Surat Pernyataan Orang Tua akan otomatis dibuatkan.
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control text-uppercase" placeholder="Sesuai KTP / Akta" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nama Alias (Opsional)</label>
                                    <input type="text" name="nama_alias" class="form-control text-uppercase" placeholder="Nama Panggilan / Lainnya">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK (16 Digit)</label>
                                    <input type="text" name="nik" class="form-control" maxlength="16" placeholder="3307xxxxxxxxxxxx" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jk" class="form-select" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tinggi (cm)</label>
                                    <input type="number" name="tinggi" class="form-control" placeholder="165" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Sipil</label>
                                    <select name="status_sipil_id" id="status_sipil" class="form-select" onchange="togglePasangan()" required>
                                        <option value="1">KAWIN</option>
                                        <option value="2" selected>TIDAK KAWIN</option>
                                        <option value="3">CERAI MATI</option>
                                        <option value="4">CERAI HIDUP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-light-blue mt-4">
                                <label class="form-label text-primary mb-3"><i class="bi bi-briefcase-fill"></i> Data Pekerjaan</label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="small text-muted">Kategori</label>
                                        <select name="pekerjaan_id" id="pekerjaan_id" class="form-select" onchange="togglePekerjaanLainnya()" required>
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="1">PEJABAT NEGARA</option>
                                            <option value="2">PNS</option>
                                            <option value="3">TNI / POLRI</option>
                                            <option value="4">PEGAWAI SWASTA</option>
                                            <option value="5">LAINNYA...</option>
                                        </select>
                                        <input type="text" name="pekerjaan_lainnya" id="input_pekerjaan_lainnya" class="form-control mt-2 text-uppercase" placeholder="Sebutkan..." style="display:none;">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="small text-muted">Nama & Alamat Kantor</label>
                                        <input type="text" name="nama_alamat_kantor" class="form-control text-uppercase" placeholder="Contoh: PT. ABC, JL. MERDEKA..." required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="small text-muted">No. Telp Kantor</label>
                                        <input type="number" name="nomor_telp_kantor" class="form-control" placeholder="021xxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Rumah Lengkap</label>
                                <textarea name="alamat" class="form-control text-uppercase" rows="2" placeholder="Jalan, RT/RW, Desa, Kecamatan, Kabupaten" required></textarea>
                            </div>

                            <div class="text-end mt-5">
                                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextStep(2)">Lanjut Langkah 2 <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div class="form-section" id="section2">
                            
                            <div class="bg-light-blue">
                                <h6 class="text-dark fw-bold mb-3"><i class="bi bi-person-standing text-primary"></i> Data Ayah</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small">Nama Lengkap</label>
                                        <input type="text" name="ayah_nama" class="form-control text-uppercase">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Kewarganegaraan</label>
                                        <input type="text" name="kewarganegaraan_ayah" class="form-control text-uppercase" value="INDONESIA">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Tempat Lahir</label>
                                        <input type="text" name="ayah_tempat" class="form-control text-uppercase">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir_ayah" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-light-blue">
                                <h6 class="text-dark fw-bold mb-3"><i class="bi bi-person-standing-dress text-danger"></i> Data Ibu</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small">Nama Lengkap</label>
                                        <input type="text" name="ibu_nama" class="form-control text-uppercase">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Kewarganegaraan</label>
                                        <input type="text" name="kewarganegaraan_ibu" class="form-control text-uppercase" value="INDONESIA">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Tempat Lahir</label>
                                        <input type="text" name="ibu_tempat" class="form-control text-uppercase">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir_ibu" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label small">Alamat Orang Tua (Jika beda)</label>
                                    <input type="text" name="ortu_alamat" class="form-control text-uppercase" placeholder="Samakan jika tinggal bersama">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">No. HP Orang Tua</label>
                                    <input type="number" name="no_hp_ortu" class="form-control" placeholder="08xxxxx">
                                </div>
                            </div>

                            <div id="box-pasangan" style="display:none;" class="bg-light-blue border border-warning">
                                <h6 class="text-dark fw-bold mb-3"><i class="bi bi-heart-fill text-danger"></i> Data Pasangan (Suami/Istri)</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small">Nama Lengkap</label>
                                        <input type="text" name="pasangan_nama" class="form-control text-uppercase">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Kewarganegaraan</label>
                                        <input type="text" name="kewarganegaraan_pasangan" class="form-control text-uppercase" value="INDONESIA">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir_pasangan" class="form-control text-uppercase">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir_pasangan" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5">
                                <button type="button" class="btn btn-secondary px-4" onclick="nextStep(1)"><i class="bi bi-arrow-left ms-2"></i> Kembali</button>
                                <button type="button" class="btn btn-primary px-4" onclick="nextStep(3)">Lanjut Langkah 3 <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div class="form-section" id="section3">
                            <h5 class="text-primary mb-3 border-bottom pb-2">C. Data Tambahan</h5>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Tgl Dikeluarkan KTP</label>
                                    <input type="date" name="ktp_tgl_keluar" id="ktp_tgl_keluar" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Masa Berlaku KTP</label>
                                    <div class="input-group">
                                        <input type="date" name="ktp_tgl_habis" id="ktp_habis" class="form-control">
                                        <div class="input-group-text bg-white">
                                            <input class="form-check-input mt-0" type="checkbox" id="ktp_seumur_hidup" name="ktp_seumur_hidup" value="1" onchange="toggleSeumurHidup()">
                                            <label class="ms-2 small mb-0 fw-bold" for="ktp_seumur_hidup">Seumur Hidup</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">No WhatsApp (Pribadi)</label>
                                    <input type="number" name="no_hp" class="form-control" placeholder="Wajib diisi" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control text-uppercase" placeholder="nama@email.com">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Tujuan Pembuatan Paspor</label>
                                <select name="tujuan" class="form-select form-select-lg">
                                    <option value="WISATA">WISATA</option>
                                    <option value="UMROH">UMROH</option>
                                    <option value="BEKERJA">BEKERJA</option>
                                    <option value="STUDI">STUDI</option>
                                    <option value="BEROBAT">BEROBAT</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary px-4" onclick="nextStep(2)"><i class="bi bi-arrow-left ms-2"></i> Kembali</button>
                                <button type="submit" class="btn btn-success btn-lg px-5 py-3 fw-bold shadow">
                                    <i class="bi bi-printer-fill me-2"></i> CETAK DOKUMEN
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js'></script>

<script>
    // --- NAVIGASI STEP ---
    function nextStep(n) {
        document.querySelectorAll('.form-section').forEach(el => el.classList.remove('current'));
        
        // Reset Active States
        document.querySelectorAll('.step').forEach(el => el.classList.remove('active', 'finish'));
        document.querySelectorAll('.step-item').forEach(el => el.classList.remove('active'));

        document.getElementById('section'+n).classList.add('current');
        const fill = document.getElementById('progressFill');
        
        if(n==1) { 
            fill.style.width="0%"; 
            document.getElementById('step1').classList.add('active'); 
            document.getElementById('stepItem1').classList.add('active');
        }
        if(n==2) { 
            fill.style.width="50%"; 
            document.getElementById('step1').classList.add('finish'); 
            document.getElementById('step2').classList.add('active'); 
            document.getElementById('stepItem2').classList.add('active');
        }
        if(n==3) { 
            fill.style.width="100%"; 
            document.getElementById('step1').classList.add('finish'); 
            document.getElementById('step2').classList.add('finish'); 
            document.getElementById('step3').classList.add('active'); 
            document.getElementById('stepItem3').classList.add('active');
        }
    }

    // --- LOGIKA FORM ---
    function toggleSeumurHidup() {
        const isChecked = document.getElementById('ktp_seumur_hidup').checked;
        const dateInput = document.getElementById('ktp_habis');
        if(isChecked) { dateInput.value = ''; dateInput.disabled = true; } 
        else { dateInput.disabled = false; }
    }

    function togglePekerjaanLainnya() {
        const val = document.getElementById('pekerjaan_id').value;
        const inputLain = document.getElementById('input_pekerjaan_lainnya');
        if(val === '5') { inputLain.style.display = 'block'; inputLain.required = true; } 
        else { inputLain.style.display = 'none'; inputLain.required = false; }
    }

    function togglePasangan() {
        const val = document.getElementById('status_sipil').value;
        const box = document.getElementById('box-pasangan');
        if(val === '1') { box.style.display = 'block'; } 
        else { box.style.display = 'none'; }
    }

    function toggleAnak() {
        const isChild = document.getElementById('buat_surat_ortu').checked;
        const info = document.getElementById('info-anak');
        const tglKeluar = document.getElementById('ktp_tgl_keluar');
        const tglHabis = document.getElementById('ktp_habis');
        const chkSeumurHidup = document.getElementById('ktp_seumur_hidup');

        if(isChild) { 
            info.style.display = 'block';
            tglKeluar.value = ''; tglHabis.value = ''; chkSeumurHidup.checked = false;
            tglKeluar.disabled = true; tglHabis.disabled = true; chkSeumurHidup.disabled = true;
        } else { 
            info.style.display = 'none';
            tglKeluar.disabled = false; tglHabis.disabled = false; chkSeumurHidup.disabled = false;
        }
    }

    // --- LOGIKA KAMERA & OCR ---
    let videoStream = null;

    function startCamera() {
        const video = document.getElementById('video');
        const container = document.getElementById('video-container');
        
        container.style.display = 'block';

        // Minta akses kamera belakang
        navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: "environment" } 
        })
        .then(stream => {
            videoStream = stream;
            video.srcObject = stream;
        })
        .catch(err => {
            console.error(err);
            alert("Gagal membuka kamera. Pastikan menggunakan HTTPS (Ngrok) jika di HP.");
            container.style.display = 'none';
        });
    }

    function stopCamera() {
        if(videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            videoStream = null;
        }
        document.getElementById('video-container').style.display = 'none';
    }

    function handleFileUpload(input) {
        if (input.files && input.files[0]) {
            runOCR(input.files[0]);
        }
    }

    function takeSnapshot() {
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        canvas.toBlob(blob => {
            runOCR(blob);
            stopCamera();
        }, 'image/jpeg', 0.9);
    }

    function runOCR(imageBlob) {
        const box = document.getElementById('scanProgressBox');
        const status = document.getElementById('statusScan');
        const percent = document.getElementById('percentScan');
        const bar = document.getElementById('progressBarScan');
        
        box.style.display = 'block';
        bar.style.width = '0%';
        
        Tesseract.recognize(
            imageBlob,
            'ind',
            {
                logger: m => {
                    if(m.status === 'recognizing text') {
                        const progress = Math.round(m.progress * 100);
                        status.innerText = 'Membaca teks...';
                        percent.innerText = progress + '%';
                        bar.style.width = progress + '%';
                    } else {
                        status.innerText = m.status;
                    }
                }
            }
        ).then(({ data: { text } }) => {
            bar.className = 'progress-bar bg-success';
            status.innerText = 'Selesai!';
            setTimeout(() => { box.style.display = 'none'; }, 1500);
            
            parseKtpText(text);
        }).catch(err => {
            alert('Gagal memproses gambar.');
            box.style.display = 'none';
        });
    }

    function parseKtpText(text) {
        const cleanText = text; 

        const nikMatch = cleanText.match(/\b\d{16}\b/);
        if (nikMatch) document.querySelector('input[name="nik"]').value = nikMatch[0];

        const namaMatch = cleanText.match(/Nama\s*[:\.]?\s*([A-Z\s\.]+)/i);
        if (namaMatch && namaMatch[1]) {
            let namaBersih = namaMatch[1].trim().split('\n')[0];
            document.querySelector('input[name="nama"]').value = namaBersih.toUpperCase();
        }

        const ttlMatch = cleanText.match(/Tempat\/Tgl Lahir\s*[:\.]?\s*(.*)/i);
        if (ttlMatch) {
            const fullTTL = ttlMatch[1];
            const parts = fullTTL.split(',');
            if (parts.length >= 2) {
                document.querySelector('input[name="tempat_lahir"]').value = parts[0].trim().toUpperCase();
                const tglRaw = parts[1].trim(); 
                const tglPola = tglRaw.match(/(\d{2})[-\s](\d{2})[-\s](\d{4})/);
                if (tglPola) {
                    const tglFix = `${tglPola[3]}-${tglPola[2]}-${tglPola[1]}`;
                    document.querySelector('input[name="tgl_lahir"]').value = tglFix;
                }
            }
        }

        if (/LAKI/i.test(cleanText)) {
            document.querySelector('select[name="jk"]').value = 'L';
        } else if (/PEREMPUAN/i.test(cleanText)) {
            document.querySelector('select[name="jk"]').value = 'P';
        }

        const alamatMatch = cleanText.match(/Alamat\s*[:\.]?\s*(.*)/i);
        let alamatFull = '';
        if (alamatMatch) alamatFull = alamatMatch[1].trim();

        const rtrwMatch = cleanText.match(/RT\/RW\s*[:\.]?\s*(.*)/i);
        if (rtrwMatch) alamatFull += ', RT/RW ' + rtrwMatch[1].trim();

        const kelMatch = cleanText.match(/Kel\/Desa\s*[:\.]?\s*(.*)/i);
        if (kelMatch) alamatFull += ', ' + kelMatch[1].trim();

        const kecMatch = cleanText.match(/Kecamatan\s*[:\.]?\s*(.*)/i);
        if (kecMatch) alamatFull += ', ' + kecMatch[1].trim();

        if (alamatFull) {
            document.querySelector('textarea[name="alamat"]').value = alamatFull.toUpperCase();
        }

        if (/BELUM KAWIN/i.test(cleanText)) {
            document.querySelector('select[name="status_sipil_id"]').value = '2'; 
            togglePasangan();
        } else if (/KAWIN/i.test(cleanText)) {
            document.querySelector('select[name="status_sipil_id"]').value = '1'; 
            togglePasangan();
        } else if (/CERAI/i.test(cleanText)) {
            document.querySelector('select[name="status_sipil_id"]').value = '4'; 
            togglePasangan();
        }
    }
</script>
</body>
</html>