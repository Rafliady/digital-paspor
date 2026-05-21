<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPANDA-JIWO | Paspor Digital Kanim Wonosobo</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_imigrasi.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <style>
        /* --- WARNA & FONT DASAR --- */
        :root { --primary: #0c2e8a; --gold: #bfa15f; --bg-light: #f4f7f9; }
        body { background: var(--bg-light); font-family: 'Poppins', sans-serif; padding-bottom: 80px; min-height: 100vh; color: #333; }
        
        /* --- HEADER & MENU AWAL --- */
        .header-logo { height: 60px; margin-bottom: 15px; drop-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-menu { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; border: 2px solid transparent; border-radius: 20px; background: white; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .card-menu:hover { transform: translateY(-8px); border-color: var(--primary); box-shadow: 0 15px 30px rgba(12, 46, 138, 0.15); }
        .card-menu i { font-size: 3.5rem; margin-bottom: 15px; display: block; }
        
        /* --- FORM UTAMA (RAMAH LANSIA & HP) --- */
        .card-form { border: none; border-radius: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.08); overflow: hidden; background: white; }
        .card-header-form { background: linear-gradient(135deg, #0c2e8a 0%, #1e40af 100%); color: white; padding: 25px 20px; border-bottom: 5px solid var(--gold); }
        
        /* Input diperbesar agar mudah diklik (Fat-Finger Friendly) */
        .form-control, .form-select { border-radius: 12px; padding: 14px 18px; font-size: 16px; border: 2px solid #e2e8f0; font-weight: 500; transition: all 0.3s; }
        .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(12, 46, 138, 0.1); }
        label { font-weight: 600; color: #475569; margin-bottom: 8px; font-size: 0.95rem; }
        
        /* Tombol diperbesar */
        .btn-lg, .btn-primary, .btn-success, .btn-secondary { padding: 14px 28px; border-radius: 14px; font-weight: 600; letter-spacing: 0.5px; }
        .bg-light-blue { background-color: #f8fafc; border-radius: 16px; padding: 25px; margin-bottom: 25px; border: 2px dashed #cbd5e1; }
        
        /* --- PROGRESS BAR STEPPER --- */
        .step-indicator { display: flex; justify-content: space-between; margin: 20px 0 35px; position: relative; padding: 0 10px; }
        .progress-bg { position: absolute; top: 22px; left: 0; width: 100%; height: 6px; background: #e2e8f0; z-index: 1; border-radius: 10px; }
        .progress-fill { height: 100%; background: var(--gold); width: 0%; transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 10px; }
        .step-item { z-index: 2; text-align: center; width: 33.33%; }
        .step { width: 50px; height: 50px; background: white; border: 4px solid #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.1rem; color: #94a3b8; margin: 0 auto 8px; transition: 0.4s; }
        .step.active { border-color: var(--primary); background: var(--primary); color: white; transform: scale(1.15); box-shadow: 0 0 20px rgba(12, 46, 138, 0.3); }
        .step.finish { border-color: var(--gold); background: var(--gold); color: white; }
        .step-label { font-size: 0.85rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .step-item.active .step-label { color: var(--primary); }

        /* --- KAMERA OCR --- */
        #camera-container { position: relative; width: 100%; max-width: 480px; margin: 0 auto; display: none; background: #000; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        #video-preview { width: 100%; height: auto; display: block; }
        #btn-snap { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 10; border: 4px solid white; box-shadow: 0 0 15px rgba(0,0,0,0.5); width: 60px; height: 60px; }
        
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        #section2, #section3 { display: none; }
    </style>
</head>
<body>

<div class="container mt-4">
    <div id="header-utama" class="text-center mb-5 fade-in">
        <img src="{{ asset('img/logo_imigrasi.png') }}" class="header-logo" alt="Logo Imigrasi">
        <h2 class="fw-bold text-dark mb-0" style="letter-spacing: 1px;">SIPANDA</h2>
        <h4 class="fw-bold text-primary mb-2">SISTEM PENGISIAN DATA PASPOR</h4>
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold shadow-sm">Layanan Walk-In & Prioritas</span>
    </div>

    <div id="menu-pilihan" class="row justify-content-center fade-in g-4">
        <div class="col-12 col-md-4">
            <div class="card card-menu h-100 p-4 text-center text-primary" onclick="pilihMode('spri')">
                <i class="bi bi-database-fill-check"></i>
                <h5 class="fw-bold mb-2">Tarik Data SPRI</h5>
                <p class="small text-muted mb-0">Isi otomatis via No. Permohonan untuk mempercepat proses.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-menu h-100 p-4 text-center text-success" onclick="pilihMode('scan')">
                <i class="bi bi-upc-scan"></i>
                <h5 class="fw-bold mb-2">Scan E-KTP</h5>
                <p class="small text-muted mb-0">Pindai fisik KTP untuk pengisian otomatis menggunakan AI.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card card-menu h-100 p-4 text-center text-secondary" onclick="pilihMode('manual')">
                <i class="bi bi-keyboard"></i>
                <h5 class="fw-bold mb-2">Input Manual</h5>
                <p class="small text-muted mb-0">Ketik data formulir paspor secara manual dari awal.</p>
            </div>
        </div>
    </div>

    <div id="container-form" class="row justify-content-center fade-in" style="display: none;">
        <div class="col-lg-9 col-md-11">
            <button class="btn btn-light fw-bold shadow-sm mb-4" onclick="kembaliKeMenu()" style="border-radius: 12px;">
                <i class="bi bi-arrow-left me-2"></i> Ganti Metode Pengisian
            </button>

            <div class="card card-form">
                <div class="card-header-form text-center">
                    <h3 class="mb-1 fw-bold">FORMULIR PASPOR</h3>
                    <p class="mb-0 text-white-50">Lengkapi data pemohon dengan benar dan sesuai dokumen asli</p>
                </div>
                <div class="card-body p-4 p-md-5">

                    <div class="step-indicator">
                        <div class="progress-bg"><div class="progress-fill" id="progressFill"></div></div>
                        <div class="step-item active" id="stepItem1"><div class="step active" id="step1">1</div><div class="step-label">Data Diri</div></div>
                        <div class="step-item" id="stepItem2"><div class="step" id="step2">2</div><div class="step-label">Keluarga</div></div>
                        <div class="step-item" id="stepItem3"><div class="step" id="step3">3</div><div class="step-label">Lainnya</div></div>
                    </div>

                    <div id="tool-spri" class="bg-light-blue" style="display:none;">
                        <label class="form-label fw-bold text-primary fs-5"><i class="bi bi-database-fill-check me-2"></i> Integrasi Data SPRI</label>
                        <div class="input-group input-group-lg mt-2 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                            <input type="text" id="cari_nomor_permohonan" class="form-control border-0" placeholder="Masukkan 16 Digit No. Permohonan">
                            <button class="btn btn-primary px-4 fw-bold" type="button" onclick="cariDataSpri()"><i class="bi bi-search me-2"></i> Cari Data</button>
                        </div>
                        <div id="loading-spri" class="text-primary mt-3 fw-bold" style="display:none;"><span class="spinner-border spinner-border-sm me-2"></span> Menarik data dari server...</div>
                    </div>

                    <div id="tool-ocr" class="bg-light-blue text-center" style="display:none;">
                        <h5 class="fw-bold text-success mb-4"><i class="bi bi-card-heading me-2"></i> Pindai E-KTP (Kamera / File)</h5>
                        <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
                            <button type="button" class="btn btn-success btn-lg shadow-sm" onclick="startCamera()"><i class="bi bi-camera-fill me-2"></i> Buka Kamera</button>
                            <button type="button" class="btn btn-outline-secondary btn-lg bg-white shadow-sm" onclick="document.getElementById('file_ktp').click()"><i class="bi bi-upload me-2"></i> Upload Foto KTP</button>
                        </div>
                        <input type="file" id="file_ktp" class="d-none" accept="image/*" onchange="prosesGambar(this.files[0])">
                        
                        <div id="camera-container">
                            <video id="video-preview" autoplay playsinline></video>
                            <canvas id="canvas-snap" style="display:none;"></canvas>
                            <button type="button" id="btn-snap" class="btn btn-danger rounded-circle" onclick="ambilFoto()"><i class="bi bi-camera fs-4"></i></button>
                        </div>
                        
                        <div id="preview-container" class="mt-4" style="display:none;">
                            <img id="hasil-foto" src="" class="img-fluid rounded-4 border border-3 border-success mb-3 shadow" style="max-height: 250px;">
                            <br><button class="btn btn-warning btn-lg fw-bold px-5 shadow" onclick="scanTesseract()"><i class="bi bi-magic me-2"></i> EKSTRAK DATA KTP</button>
                        </div>
                        <div id="loading-ocr" class="alert alert-info mt-4 text-start shadow-sm border-0" style="display:none; border-radius: 12px;">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border text-info me-3" role="status"></div>
                                <div><strong class="d-block">Sedang memproses AI...</strong><small>Membaca teks dari KTP (Bisa memakan waktu 5-10 detik).</small></div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('cetak.proses') }}" method="POST" target="_blank" id="mainForm" novalidate>
                        @csrf
                        <input type="hidden" name="metode" id="input_metode" value="MANUAL">
                        <input type="hidden" name="cari_nomor_permohonan" id="hidden_nomor_permohonan" value="">

                        <div id="section1" class="fade-in">
                            
                            <div class="alert border-0 shadow-sm p-4 mb-4" style="background-color: #fffbeb; border-radius: 16px; border-left: 6px solid var(--gold) !important;">
                                <div class="form-check form-switch d-flex align-items-center">
                                    <input class="form-check-input me-3" type="checkbox" id="buat_surat_ortu" name="buat_surat_ortu" value="1" onchange="toggleAnak()" style="transform: scale(1.5);">
                                    <label class="form-check-label fw-bold text-dark fs-6" for="buat_surat_ortu" style="cursor: pointer;">Centang Jika Pemohon Adalah Anak (Di Bawah Umur)</label>
                                </div>
                                <div id="notif-anak" class="mt-3 text-danger small fw-bold" style="display:none;">
                                    <i class="bi bi-info-circle-fill me-1"></i> Mode Anak Aktif! Kolom KTP akan dinonaktifkan. Pastikan mengisi <span class="text-decoration-underline">Data Ayah & Ibu</span> di Tahap 2 untuk Surat Pernyataan.
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label>Nomor Induk Kependudukan (NIK)</label>
                                    <input type="text" name="nik" id="nik" class="form-control" maxlength="16" placeholder="16 Digit NIK" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Lengkap Pemohon</label>
                                    <input type="text" name="nama" id="nama" class="form-control text-uppercase" placeholder="Sesuai KTP/KK" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Alias (Opsional)</label>
                                    <input type="text" name="nama_alias" id="nama_alias" class="form-control text-uppercase" placeholder="Kosongkan jika tidak ada">
                                </div>
                                <div class="col-md-6">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control text-uppercase" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jk" id="jk" class="form-select">
                                        <option value="L">LAKI-LAKI</option>
                                        <option value="P">PEREMPUAN</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Tinggi Badan (cm)</label>
                                    <input type="number" name="tinggi" id="tinggi" class="form-control" placeholder="Misal: 165">
                                </div>
                                <div class="col-md-12">
                                    <label>Status Sipil</label>
                                    <select name="status_sipil_id" id="status_sipil" class="form-select" onchange="togglePasangan()">
                                        <option value="1">KAWIN</option>
                                        <option value="2" selected>TIDAK KAWIN</option>
                                        <option value="3">CERAI MATI</option>
                                        <option value="4">CERAI HIDUP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="bg-light-blue mt-4">
                                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-briefcase-fill me-2"></i> Data Pekerjaan</h5>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label>Jenis Pekerjaan</label>
                                        <select name="pekerjaan_id" id="pekerjaan_id" class="form-select" onchange="togglePekerjaanLainnya()">
                                            <option value="1">PEJABAT NEGARA</option>
                                            <option value="2">PNS</option>
                                            <option value="3">TNI / POLRI</option>
                                            <option value="4">PEGAWAI SWASTA</option>
                                            <option value="5">LAINNYA...</option>
                                        </select>
                                        <input type="text" name="pekerjaan_lainnya" id="input_pekerjaan_lainnya" class="form-control mt-2 text-uppercase" placeholder="Sebutkan pekerjaannya..." style="display:none;">
                                    </div>
                                    <div class="col-md-5">
                                        <label>Nama & Alamat Kantor</label>
                                        <input type="text" name="nama_alamat_kantor" class="form-control text-uppercase" placeholder="Isi alamat lengkap kantor">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Telp Kantor</label>
                                        <input type="number" name="nomor_telp_kantor" class="form-control" placeholder="Opsional">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Alamat Rumah Lengkap (Sesuai KTP)</label>
                                <textarea name="alamat" id="alamat" class="form-control text-uppercase" rows="3" placeholder="Jalan, RT/RW, Desa/Kelurahan, Kecamatan" required></textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <button type="button" class="btn btn-primary btn-lg px-5 shadow-sm" onclick="nextStep(2)">Lanjut ke Tahap 2 <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div id="section2" class="fade-in">
                            <div class="bg-light-blue mb-4">
                                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-person-standing me-2"></i> Data Ayah</h5>
                                <div class="row g-3">
                                    <div class="col-md-6"><label>Nama Lengkap Ayah</label><input type="text" name="ayah_nama" class="form-control text-uppercase" placeholder="Sesuai Akta Kelahiran"></div>
                                    <div class="col-md-6"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_ayah" class="form-control text-uppercase" value="INDONESIA"></div>
                                    <div class="col-md-6"><label>Tempat Lahir</label><input type="text" name="ayah_tempat" class="form-control text-uppercase"></div>
                                    <div class="col-md-6"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir_ayah" class="form-control"></div>
                                </div>
                            </div>
                            
                            <div class="bg-light-blue mb-4" style="border-color: #fca5a5;">
                                <h5 class="fw-bold text-danger mb-3"><i class="bi bi-person-standing-dress me-2"></i> Data Ibu</h5>
                                <div class="row g-3">
                                    <div class="col-md-6"><label>Nama Lengkap Ibu</label><input type="text" name="ibu_nama" class="form-control text-uppercase" placeholder="Sesuai Akta Kelahiran"></div>
                                    <div class="col-md-6"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_ibu" class="form-control text-uppercase" value="INDONESIA"></div>
                                    <div class="col-md-6"><label>Tempat Lahir</label><input type="text" name="ibu_tempat" class="form-control text-uppercase"></div>
                                    <div class="col-md-6"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir_ibu" class="form-control"></div>
                                </div>
                            </div>
                            
                            <div id="box-pasangan" style="display:none;" class="bg-light-blue mb-4" style="border-color: #fcd34d;">
                                <h5 class="fw-bold text-warning-emphasis mb-3"><i class="bi bi-people-fill me-2"></i> Data Pasangan (Suami/Istri)</h5>
                                <div class="row g-3">
                                    <div class="col-md-6"><label>Nama Lengkap Pasangan</label><input type="text" name="pasangan_nama" class="form-control text-uppercase"></div>
                                    <div class="col-md-6"><label>Kewarganegaraan</label><input type="text" name="kewarganegaraan_pasangan" class="form-control text-uppercase" value="INDONESIA"></div>
                                    <div class="col-md-6"><label>Tempat Lahir</label><input type="text" name="tempat_lahir_pasangan" class="form-control text-uppercase"></div>
                                    <div class="col-md-6"><label>Tanggal Lahir</label><input type="date" name="tgl_lahir_pasangan" class="form-control"></div>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-column flex-md-row justify-content-between mt-5 gap-3">
                                <button type="button" class="btn btn-secondary btn-lg px-4" onclick="nextStep(1)"><i class="bi bi-arrow-left me-2"></i> Kembali</button>
                                <button type="button" class="btn btn-primary btn-lg px-5 shadow-sm" onclick="nextStep(3)">Lanjut ke Tahap 3 <i class="bi bi-arrow-right ms-2"></i></button>
                            </div>
                        </div>

                        <div id="section3" class="fade-in">
                            <h4 class="text-primary fw-bold border-bottom border-2 pb-3 mb-4"><i class="bi bi-card-checklist me-2"></i> Data Tambahan Dokumen</h4>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label>Tgl Dikeluarkan KTP</label>
                                    <input type="date" name="ktp_tgl_keluar" id="ktp_tgl_keluar" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Masa Berlaku KTP</label>
                                    <div class="input-group">
                                        <input type="date" name="ktp_tgl_habis" id="ktp_habis" class="form-control">
                                        <div class="input-group-text bg-white" style="border-radius: 0 12px 12px 0; border: 2px solid #e2e8f0; border-left: none;">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input mt-1" type="checkbox" id="ktp_seumur_hidup" name="ktp_seumur_hidup" value="1" onchange="toggleSeumurHidup()">
                                                <label class="form-check-label fw-bold ms-1" for="ktp_seumur_hidup">Seumur Hidup</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label>Nomor WhatsApp Aktif</label>
                                    <input type="number" name="no_hp" id="no_hp" class="form-control" placeholder="Contoh: 08123456789" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Alamat Email (Opsional)</label>
                                    <input type="email" name="email" id="email" class="form-control text-uppercase" placeholder="Contoh: email@gmail.com">
                                </div>
                            </div>
                            
                            <div class="mb-5 bg-light-blue border-0 shadow-sm">
                                <label class="fs-5 fw-bold text-dark mb-3">Tujuan Pembuatan Paspor</label>
                                <select name="tujuan" id="tujuan" class="form-select form-select-lg" onchange="toggleTujuanLainnya()">
                                    <option value="WISATA">WISATA / LIBURAN</option>
                                    <option value="UMROH">UMROH / HAJI</option>
                                    <option value="BEKERJA">BEKERJA DI LUAR NEGERI</option>
                                    <option value="STUDI">STUDI / PENDIDIKAN</option>
                                    <option value="BEROBAT">BEROBAT / KESEHATAN</option>
                                    <option value="LAINNYA">LAINNYA...</option>
                                </select>
                                <input type="text" name="tujuan_lainnya" id="tujuan_lainnya" class="form-control form-control-lg mt-3 text-uppercase" placeholder="Sebutkan tujuan lainnya secara spesifik..." style="display:none;">
                            </div>

                            <div class="d-flex flex-column flex-md-row justify-content-between mt-5 gap-3 pt-3 border-top border-2">
                                <button type="button" class="btn btn-secondary btn-lg px-4" onclick="nextStep(2)"><i class="bi bi-arrow-left me-2"></i> Kembali</button>
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-lg" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">
                                    <i class="bi bi-printer-fill me-2 fs-5"></i> SIMPAN & CETAK PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <a href="{{ route('admin.dashboard') }}" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;" class="btn btn-dark btn-lg rounded-circle shadow-lg p-3" title="Masuk ke Dashboard Admin"><i class="bi bi-gear-fill fs-4"></i></a>
</div>

<script>
    // --- NAVIGASI METODE ---
    function pilihMode(mode) {
        document.getElementById('header-utama').style.display='none'; 
        document.getElementById('menu-pilihan').style.display='none';
        document.getElementById('container-form').style.display='flex';
        
        document.getElementById('tool-spri').style.display = (mode==='spri'?'block':'none');
        document.getElementById('tool-ocr').style.display = (mode==='scan'?'block':'none');
        
        let m = 'MANUAL';
        if(mode === 'spri') m = 'SPRI';
        else if(mode === 'scan') m = 'SCAN';
        document.getElementById('input_metode').value = m;
    }

    function kembaliKeMenu() { 
        document.getElementById('container-form').style.display='none'; 
        document.getElementById('menu-pilihan').style.display='flex'; 
        document.getElementById('header-utama').style.display='block'; 
        document.getElementById('mainForm').reset(); 
        nextStep(1);
        stopCamera(); 
    }
    
    // --- KAMERA & OCR (TIDAK ADA YANG DIUBAH, AMAN 100%) ---
    let streamCamera = null;
    function startCamera() {
        const v = document.getElementById('video-preview'); const c = document.getElementById('camera-container');
        document.getElementById('preview-container').style.display='none'; c.style.display='block';
        navigator.mediaDevices.getUserMedia({video:{facingMode:"environment",width:{ideal:1920},height:{ideal:1080}}})
        .then(s=>{streamCamera=s; v.srcObject=s;}).catch(e=>{alert("Gagal mengakses kamera: "+e); c.style.display='none';});
    }
    function stopCamera() { if(streamCamera){streamCamera.getTracks().forEach(t=>t.stop()); streamCamera=null; document.getElementById('camera-container').style.display='none';} }
    function ambilFoto() {
        const v=document.getElementById('video-preview'), c=document.getElementById('canvas-snap'), p=document.getElementById('preview-container');
        c.width=v.videoWidth; c.height=v.videoHeight; c.getContext('2d').drawImage(v,0,0);
        document.getElementById('hasil-foto').src=c.toDataURL('image/png'); stopCamera(); p.style.display='block';
    }
    function prosesGambar(file) {
        if(file){const r=new FileReader(); r.onload=e=>{document.getElementById('hasil-foto').src=e.target.result; document.getElementById('preview-container').style.display='block'; document.getElementById('camera-container').style.display='none';}; r.readAsDataURL(file);}
    }
    function preprocessImage(img) {
        const c=document.createElement('canvas'), ctx=c.getContext('2d'); c.width=img.naturalWidth; c.height=img.naturalHeight; ctx.drawImage(img,0,0);
        const d=ctx.getImageData(0,0,c.width,c.height), data=d.data;
        for(let i=0;i<data.length;i+=4){ const avg=(data[i]+data[i+1]+data[i+2])/3; const col=(avg<130)?0:255; data[i]=col; data[i+1]=col; data[i+2]=col; }
        ctx.putImageData(d,0,0); return c.toDataURL('image/png');
    }
    function scanTesseract() {
        const img=document.getElementById('hasil-foto'), load=document.getElementById('loading-ocr'); if(!img.src) return alert("Foto kosong!");
        load.style.display='block';
        Tesseract.recognize(preprocessImage(img),'ind',{logger:m=>console.log(m)}).then(({data:{text}})=>{
            load.style.display='none'; parsingKTP(text); alert("Pemindaian AI Selesai! Silakan cek hasil isian form di bawah.");
        }).catch(e=>{load.style.display='none'; alert("Gagal membaca gambar KTP.");});
    }
    function parsingKTP(text) {
        const lines=text.split('\n');
        lines.forEach(line=>{
            line=line.trim().toUpperCase(); if(line.length<3)return;
            const clnNik=s=>s.replace(/O/g,'0').replace(/B/g,'8').replace(/I/g,'1').replace(/L/g,'1').replace(/D/g,'0');
            if(line.includes("NIK")||line.match(/\d{16}/)){ let m=clnNik(line.replace(/[^0-9OBILD]/g,"")).match(/\d{16}/); if(m)document.getElementById('nik').value=m[0]; }
            if(line.includes("NAMA")){ let n=line.replace("NAMA","").replace(":","").trim().replace(/[^A-Z .]/g,""); if(n.length>2)document.getElementById('nama').value=n; }
            if(line.includes("TEMPAT")||line.includes("LAHIR")){
                let d=line.match(/(\d{2})\s?-\s?(\d{2})\s?-\s?(\d{4})/);
                if(d){ document.getElementById('tgl_lahir').value=`${d[3]}-${d[2]}-${d[1]}`;
                let k=line.split(d[0])[0].replace("TEMPAT","").replace("TGL","").replace("LAHIR","").replace(/[:/,]/g,"").trim().replace(/[^A-Z ]/g,""); document.getElementById('tempat_lahir').value=k; }
            }
            if(line.includes("ALAMAT")){ document.getElementById('alamat').value=line.replace("ALAMAT","").replace(":","").trim(); }
            if(line.includes("RT")||line.includes("RW")){ let cur=document.getElementById('alamat').value; if(cur && !cur.includes("RT")) document.getElementById('alamat').value=cur+" "+line.replace(":","").trim(); }
            if(line.includes("DESA")||line.includes("KEL")){ let cur=document.getElementById('alamat').value; document.getElementById('alamat').value=cur+", "+line.replace(":","").trim(); }
        });
    }

    // --- STEPPER PROGRESS BAR ---
    function nextStep(n) {
        [1,2,3].forEach(i=>document.getElementById('section'+i).style.display='none');
        document.getElementById('section'+n).style.display='block';
        document.querySelectorAll('.step, .step-item').forEach(e=>e.classList.remove('active','finish'));
        
        if(n>=1){document.getElementById('step1').classList.add('active'); document.getElementById('progressFill').style.width="0%";}
        if(n>=2){document.getElementById('step1').classList.add('finish'); document.getElementById('step2').classList.add('active'); document.getElementById('progressFill').style.width="50%"; window.scrollTo(0, 0);}
        if(n>=3){document.getElementById('step2').classList.add('finish'); document.getElementById('step3').classList.add('active'); document.getElementById('progressFill').style.width="100%"; window.scrollTo(0, 0);}
    }

    // --- LOGIKA FORM DINAMIS (TERMASUK FIX PENYAKIT FORM ANAK) ---
    function toggleAnak() { 
        const c = document.getElementById('buat_surat_ortu').checked; 
        const notif = document.getElementById('notif-anak');
        
        // Mematikan paksa form KTP (Karena Anak belum punya KTP)
        const ids = ['ktp_tgl_keluar','ktp_habis','ktp_seumur_hidup'];
        ids.forEach(id => {
            let el = document.getElementById(id);
            el.disabled = c;
            if(c) {
                if(el.type === 'checkbox') el.checked = false;
                else el.value = '';
            }
        });
        
        // Memunculkan Peringatan agar Data Ayah/Ibu di Step 2 wajib diisi
        notif.style.display = c ? 'block' : 'none';
    }
    
    function togglePasangan() { 
        const s=document.getElementById('status_sipil').value;
        document.getElementById('box-pasangan').style.display = (s==='1')?'block':'none';
    }
    function toggleSeumurHidup() { 
        const c=document.getElementById('ktp_seumur_hidup').checked;
        const d=document.getElementById('ktp_habis');
        if(c){d.value=''; d.disabled=true;}else{d.disabled=false;}
    }
    function togglePekerjaanLainnya() { 
        const v=document.getElementById('pekerjaan_id').value; const i=document.getElementById('input_pekerjaan_lainnya');
        i.style.display=(v==='5')?'block':'none'; if(v==='5')i.required=true; else i.required=false;
    }
    function toggleTujuanLainnya() {
        const val = document.getElementById('tujuan').value;
        const inputLain = document.getElementById('tujuan_lainnya');
        if (val === 'LAINNYA') { inputLain.style.display = 'block'; inputLain.required = true; } 
        else { inputLain.style.display = 'none'; inputLain.required = false; inputLain.value = ''; }
    }

    // --- FETCH TARIK DATA SPRI ---
    function cariDataSpri() {
        const no=document.getElementById('cari_nomor_permohonan').value, load=document.getElementById('loading-spri');
        if(!no)return alert('Silakan isi 16 Digit Nomor Permohonan terlebih dahulu!'); 
        load.style.display='block';
        fetch('/cari-spri/'+no).then(r=>r.json()).then(d=>{
            load.style.display='none';
            if(d.status==='success'){
                const r=d.data;
                document.getElementById('hidden_nomor_permohonan').value = no;
                document.getElementById('nama').value=r.nama||''; document.getElementById('tempat_lahir').value=r.tempat_lahir||'';
                document.getElementById('tgl_lahir').value=r.tgl_lahir||''; document.getElementById('alamat').value=r.alamat||'';
                document.getElementById('no_hp').value=r.no_hp||''; document.getElementById('email').value=r.email||'';
                if(r.jk==='L')document.getElementById('jk').value='L'; else if(r.jk==='P')document.getElementById('jk').value='P';
                alert('Data SPRI berhasil ditemukan dan dimasukkan ke form!');
            }else alert(d.message);
        }).catch(()=>{load.style.display='none'; alert('Gagal terhubung ke Server. Pastikan jaringan lokal aktif.');});
    }
</script>

</body>
</html>