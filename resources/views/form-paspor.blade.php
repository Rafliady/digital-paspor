<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Paspor Digital</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/logo_imigrasi.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .card { border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; }
        .card-header { background: #003366; color: white; padding: 20px; }
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 30px; position: relative; padding: 0 20px; }
        .step { width: 35px; height: 35px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #666; z-index: 2; transition: 0.3s; }
        .step.active { background: #003366; color: white; transform: scale(1.1); box-shadow: 0 0 10px rgba(0,51,102,0.5); }
        .step.finish { background: #28a745; color: white; }
        .progress-line { position: absolute; top: 17px; left: 0; width: 100%; height: 3px; background: #ddd; z-index: 1; }
        .progress-fill { height: 100%; background: #28a745; width: 0%; transition: 0.3s; }
        .form-section { display: none; animation: fadeIn 0.4s; }
        .form-section.current { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .form-label { font-weight: 600; font-size: 0.85rem; color: #444; margin-bottom: 3px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #ccc; padding: 10px; }
        .bg-light-blue { background-color: #eef2f7; border-radius: 10px; padding: 15px; margin-bottom: 15px; border: 1px solid #dee2e6; }
        
        /* Style Kamera */
        #video-container { position: relative; width: 100%; max-width: 500px; margin: 0 auto; display: none; border-radius: 10px; overflow: hidden; border: 3px solid #003366; }
        video { width: 100%; height: auto; display: block; }
        .overlay-guide { position: absolute; top: 20%; left: 10%; width: 80%; height: 60%; border: 2px dashed rgba(255,255,255,0.7); box-shadow: 0 0 0 9999px rgba(0,0,0,0.5); pointer-events: none; border-radius: 8px; }
        .overlay-text { position: absolute; bottom: 10px; width: 100%; text-align: center; color: white; font-weight: bold; text-shadow: 1px 1px 2px black; pointer-events: none; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="bi bi-passport"></i> FORMULIR PASPOR DIGITAL</h4>
                </div>
                <div class="card-body p-4">

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-secondary text-center">
                                <h5 class="fw-bold text-dark"><i class="bi bi-person-vcard"></i> Isi Otomatis dari KTP</h5>
                                <p class="small text-muted mb-3">Gunakan kamera atau upload foto KTP agar data terisi otomatis.</p>
                                
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-primary" onclick="startCamera()">
                                        <i class="bi bi-camera-video-fill"></i> Buka Kamera
                                    </button>
                                    <button class="btn btn-outline-primary" onclick="document.getElementById('uploadKtp').click()">
                                        <i class="bi bi-upload"></i> Upload File
                                    </button>
                                    <input type="file" id="uploadKtp" accept="image/*" style="display:none;" onchange="handleFileUpload(this)">
                                </div>

                                <div id="video-container" class="mt-3">
                                    <video id="video" autoplay playsinline></video>
                                    <div class="overlay-guide"></div> <div class="overlay-text">Posisikan KTP di dalam kotak</div>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    
                                    <div class="p-2 bg-dark d-flex justify-content-between">
                                        <button class="btn btn-danger btn-sm" onclick="stopCamera()">Tutup</button>
                                        <button class="btn btn-success btn-sm" onclick="takeSnapshot()">
                                            <i class="bi bi-camera-fill"></i> Ambil Foto & Scan
                                        </button>
                                    </div>
                                </div>

                                <div id="scanProgressBox" class="mt-3" style="display:none;">
                                    <p class="small mb-1 text-primary fw-bold" id="statusScan">Memproses gambar...</p>
                                    <div class="progress" style="height: 10px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBarScan" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step-indicator">
                        <div class="progress-line"><div class="progress-fill" id="progressFill"></div></div>
                        <div class="step active" id="step1">1</div>
                        <div class="step" id="step2">2</div>
                        <div class="step" id="step3">3</div>
                    </div>

                    <form action="{{ route('cetak.proses') }}" method="POST" target="_blank" id="mainForm" novalidate>
                        @csrf
                        
                        <div class="form-section current" id="section1">
                            <h5 class="text-primary mb-3 border-bottom pb-2">A. Identitas Pemohon</h5>
                            
                            <div class="alert alert-info py-2 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="buat_surat_ortu" name="buat_surat_ortu" value="1" onchange="toggleAnak()">
                                    <label class="form-check-label fw-bold" for="buat_surat_ortu">
                                        Pemohon Adalah Anak Dibawah Umur (Belum Punya KTP)
                                    </label>
                                </div>
                                <div class="text-muted small mt-1 ms-4" id="info-anak" style="display:none;">
                                    * Surat Pernyataan Orang Tua akan otomatis dibuatkan di halaman akhir PDF.
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Alias (Jika Ada)</label>
                                    <input type="text" name="nama_alias" class="form-control text-uppercase">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK (16 Digit)</label>
                                    <input type="text" name="nik" class="form-control" maxlength="16" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jk" class="form-select" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Tinggi (cm)</label>
                                    <input type="number" name="tinggi" class="form-control" placeholder="165" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status Sipil</label>
                                    <select name="status_sipil_id" id="status_sipil" class="form-select" onchange="togglePasangan()" required>
                                        <option value="1">1. KAWIN</option>
                                        <option value="2" selected>2. TIDAK KAWIN</option>
                                        <option value="3">3. CERAI MATI</option>
                                        <option value="4">4. CERAI HIDUP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-light-blue">
                                <label class="form-label text-primary">Data Pekerjaan</label>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label class="small text-muted">Kategori</label>
                                        <select name="pekerjaan_id" id="pekerjaan_id" class="form-select form-select-sm" onchange="togglePekerjaanLainnya()" required>
                                            <option value="" selected disabled>-- Pilih --</option>
                                            <option value="1">1. PEJABAT NEGARA</option>
                                            <option value="2">2. PNS</option>
                                            <option value="3">3. TNI / POLRI</option>
                                            <option value="4">4. PEGAWAI SWASTA</option>
                                            <option value="5">5. LAINNYA...</option>
                                        </select>
                                        <input type="text" name="pekerjaan_lainnya" id="input_pekerjaan_lainnya" class="form-control form-control-sm mt-2 text-uppercase" placeholder="Sebutkan..." style="display:none;">
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        <label class="small text-muted">Nama & Alamat Kantor Lengkap</label>
                                        <input type="text" name="nama_alamat_kantor" class="form-control form-control-sm text-uppercase" placeholder="Contoh: PT. MAJU JAYA, JL. SUDIRMAN..." required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="small text-muted">No. Telp Kantor</label>
                                        <input type="number" name="nomor_telp_kantor" class="form-control form-control-sm" placeholder="021xxxx">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Alamat Rumah Lengkap</label>
                                    <textarea name="alamat" class="form-control text-uppercase" rows="2" placeholder="Jalan, RT/RW, Desa, Kecamatan, Kabupaten" required></textarea>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-primary btn-nav" onclick="nextStep(2)">Lanjut <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>

                        <div class="form-section" id="section2">
                            <h5 class="text-primary mb-3 border-bottom pb-2">B. Data Keluarga</h5>
                            
                            <div class="bg-light-blue">
                                <h6 class="text-dark fw-bold"><i class="bi bi-person-standing"></i> Data Ayah</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="small">Nama Lengkap</label>
                                        <input type="text" name="ayah_nama" class="form-control form-control-sm text-uppercase">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="small">Kewarganegaraan</label>
                                        <input type="text" name="kewarganegaraan_ayah" class="form-control form-control-sm text-uppercase" value="INDONESIA">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="small">Tempat Lahir</label>
                                        <input type="text" name="ayah_tempat" class="form-control form-control-sm text-uppercase">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="small">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir_ayah" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-light-blue">
                                <h6 class="text-dark fw-bold"><i class="bi bi-person-standing-dress"></i> Data Ibu</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="small">Nama Lengkap</label>
                                        <input type="text" name="ibu_nama" class="form-control form-control-sm text-uppercase">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="small">Kewarganegaraan</label>
                                        <input type="text" name="kewarganegaraan_ibu" class="form-control form-control-sm text-uppercase" value="INDONESIA">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="small">Tempat Lahir</label>
                                        <input type="text" name="ibu_tempat" class="form-control form-control-sm text-uppercase">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="small">Tanggal Lahir</label>
                                        <input type="date" name="tgl_lahir_ibu" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <label class="form-label small">Alamat Orang Tua (Jika beda dengan pemohon)</label>
                                    <input type="text" name="ortu_alamat" class="form-control form-control-sm text-uppercase" placeholder="Samakan dengan alamat pemohon jika tinggal bersama">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">No. Telp/HP Ortu</label>
                                    <input type="number" name="no_hp_ortu" class="form-control form-control-sm" placeholder="08xxxxx">
                                </div>
                            </div>

                            <div id="box-pasangan" style="display:none;">
                                <div class="bg-light-blue border-warning">
                                    <h6 class="text-dark fw-bold"><i class="bi bi-heart-fill text-danger"></i> Data Suami/Istri</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="small">Nama Lengkap</label>
                                            <input type="text" name="pasangan_nama" class="form-control form-control-sm text-uppercase">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="small">Kewarganegaraan</label>
                                            <input type="text" name="kewarganegaraan_pasangan" class="form-control form-control-sm text-uppercase" value="INDONESIA">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="small">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir_pasangan" class="form-control form-control-sm text-uppercase">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="small">Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir_pasangan" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary btn-nav" onclick="nextStep(1)">Kembali</button>
                                <button type="button" class="btn btn-primary btn-nav" onclick="nextStep(3)">Lanjut</button>
                            </div>
                        </div>

                        <div class="form-section" id="section3">
                            <h5 class="text-primary mb-3 border-bottom pb-2">C. Data Tambahan</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tgl Dikeluarkan KTP</label>
                                    <input type="date" name="ktp_tgl_keluar" id="ktp_tgl_keluar" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Masa Berlaku KTP</label>
                                    <div class="input-group">
                                        <input type="date" name="ktp_tgl_habis" id="ktp_habis" class="form-control">
                                        <div class="input-group-text bg-white">
                                            <input class="form-check-input mt-0" type="checkbox" id="ktp_seumur_hidup" name="ktp_seumur_hidup" value="1" onchange="toggleSeumurHidup()">
                                            <label class="ms-2 small mb-0" for="ktp_seumur_hidup">Seumur Hidup</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">No WhatsApp (Pribadi)</label>
                                    <input type="number" name="no_hp" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control text-uppercase">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tujuan Pembuatan</label>
                                <select name="tujuan" class="form-select">
                                    <option value="WISATA">WISATA</option>
                                    <option value="UMROH">UMROH</option>
                                    <option value="BEKERJA">BEKERJA</option>
                                    <option value="STUDI">STUDI</option>
                                    <option value="BEROBAT">BEROBAT</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary btn-nav" onclick="nextStep(2)">Kembali</button>
                                <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow">
                                    <i class="bi bi-printer-fill"></i> CETAK PDF
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
        document.querySelectorAll('.step').forEach(el => el.classList.remove('active', 'finish'));
        document.getElementById('section'+n).classList.add('current');
        const fill = document.getElementById('progressFill');
        if(n==1) { fill.style.width="0%"; document.getElementById('step1').classList.add('active'); }
        if(n==2) { fill.style.width="50%"; document.getElementById('step1').classList.add('finish'); document.getElementById('step2').classList.add('active'); }
        if(n==3) { fill.style.width="100%"; document.getElementById('step1').classList.add('finish'); document.getElementById('step2').classList.add('finish'); document.getElementById('step3').classList.add('active'); }
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

        // Minta akses kamera (Prefer kamera belakang)
        navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: "environment" } 
        })
        .then(stream => {
            videoStream = stream;
            video.srcObject = stream;
        })
        .catch(err => {
            console.error(err);
            alert("Gagal membuka kamera. Pastikan izin kamera diberikan.");
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
        
        // Sesuaikan ukuran canvas dengan video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Gambar frame video ke canvas
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Convert ke Blob dan jalankan OCR
        canvas.toBlob(blob => {
            runOCR(blob);
            stopCamera();
        }, 'image/jpeg', 0.9);
    }

    function runOCR(imageBlob) {
        const box = document.getElementById('scanProgressBox');
        const status = document.getElementById('statusScan');
        const bar = document.getElementById('progressBarScan');
        
        box.style.display = 'block';
        bar.style.width = '0%';
        bar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-warning';

        Tesseract.recognize(
            imageBlob,
            'ind',
            {
                logger: m => {
                    if(m.status === 'recognizing text') {
                        status.innerText = `Membaca teks... ${Math.round(m.progress * 100)}%`;
                        bar.style.width = `${m.progress * 100}%`;
                    } else {
                        status.innerText = m.status;
                    }
                }
            }
        ).then(({ data: { text } }) => {
            bar.className = 'progress-bar bg-success';
            status.innerText = 'Selesai! Data dimasukkan...';
            console.log("OCR Result:", text);
            parseKtpText(text);
            
            setTimeout(() => { box.style.display = 'none'; }, 2000);
        }).catch(err => {
            console.error(err);
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