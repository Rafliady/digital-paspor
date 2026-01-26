<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Paspor Digital Terintegrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding-bottom: 50px; }
        .card { border: none; box-shadow: 0 10px 20px rgba(0,0,0,0.1); border-radius: 15px; overflow: hidden; }
        .card-header { background: #003366; color: white; padding: 20px; }
        
        /* Wizard Progress Bar */
        .step-indicator { display: flex; justify-content: space-between; margin-bottom: 30px; position: relative; padding: 0 20px; }
        .step { width: 35px; height: 35px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #666; z-index: 2; transition: 0.3s; }
        .step.active { background: #003366; color: white; transform: scale(1.1); box-shadow: 0 0 10px rgba(0,51,102,0.5); }
        .step.finish { background: #28a745; color: white; }
        .progress-line { position: absolute; top: 17px; left: 0; width: 100%; height: 3px; background: #ddd; z-index: 1; }
        .progress-fill { height: 100%; background: #28a745; width: 0%; transition: 0.3s; }

        /* Form Animation */
        .form-section { display: none; animation: fadeIn 0.4s; }
        .form-section.current { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        .form-label { font-weight: 600; font-size: 0.85rem; color: #444; margin-bottom: 3px; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #ccc; padding: 10px; }
        .form-control:focus { border-color: #003366; box-shadow: 0 0 0 0.2rem rgba(0,51,102,0.15); }
        
        .btn-nav { width: 130px; border-radius: 25px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="bi bi-passport"></i> FORMULIR PASPOR DIGITAL</h4>
                    <small>Satu kali input untuk Perdim, Wawancara, Pernyataan & Surat Ortu</small>
                </div>
                <div class="card-body p-4">

                    <div class="step-indicator">
                        <div class="progress-line"><div class="progress-fill" id="progressFill"></div></div>
                        <div class="step active" id="step1">1</div>
                        <div class="step" id="step2">2</div>
                        <div class="step" id="step3">3</div>
                    </div>
                    <div class="d-flex justify-content-between px-2 mb-4 small text-muted fw-bold">
                        <span>Data Pribadi</span>
                        <span>Keluarga</span>
                        <span>Cetak</span>
                    </div>

                    <form action="{{ route('cetak.proses') }}" method="POST" target="_blank" id="mainForm">
                        @csrf
                        
                        <div class="form-section current" id="section1">
                            <h5 class="text-primary mb-3 border-bottom pb-2">A. Identitas Pemohon (Sesuai KTP)</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control text-uppercase" placeholder="CONTOH: BUDI UTOMO" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK (16 Digit)</label>
                                    <input type="text" name="nik" class="form-control" placeholder="3307xxxxxxxxxxxx" maxlength="16" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tgl Dikeluarkan KTP</label>
                                    <input type="date" name="ktp_tgl_keluar" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Masa Berlaku KTP</label>
                                    <div class="input-group">
                                        <input type="date" name="ktp_tgl_habis" id="ktp_habis" class="form-control" required>
                                        <div class="input-group-text bg-white">
                                            <input class="form-check-input mt-0" type="checkbox" id="ktp_seumur_hidup" name="ktp_seumur_hidup" value="1" onchange="toggleSeumurHidup()">
                                            <label class="ms-2 small mb-0" for="ktp_seumur_hidup">Seumur Hidup</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control text-uppercase" value="WONOSOBO" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tgl_lahir" class="form-control" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jk" class="form-select" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tinggi Badan (cm)</label>
                                    <input type="number" name="tinggi" class="form-control" placeholder="165" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status Sipil</label>
                                    <select name="status_sipil" id="status_sipil" class="form-select" onchange="togglePasangan()" required>
                                        <option value="BELUM KAWIN">BELUM KAWIN</option>
                                        <option value="KAWIN">KAWIN</option>
                                        <option value="CERAI MATI">CERAI MATI</option>
                                        <option value="CERAI HIDUP">CERAI HIDUP</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control text-uppercase" placeholder="WIRASWASTA" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control text-uppercase" rows="2" placeholder="Jalan, RT/RW, Desa, Kecamatan" required></textarea>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-primary btn-nav" onclick="nextStep(2)">Lanjut <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>


                        <div class="form-section" id="section2">
                            <h5 class="text-primary mb-3 border-bottom pb-2">B. Data Keluarga</h5>
                            
                            <div class="alert alert-warning d-flex align-items-center mb-4 py-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="buat_surat_ortu" name="buat_surat_ortu" value="1">
                                    <label class="form-check-label fw-bold small text-dark ms-2" for="buat_surat_ortu">
                                        Pemohon Anak Dibawah Umur? (Centang untuk buat Surat Pernyataan Ortu)
                                    </label>
                                </div>
                            </div>

                            <div class="card bg-light border-0 mb-3">
                                <div class="card-body">
                                    <h6 class="text-dark fw-bold border-bottom pb-1 mb-2 small text-uppercase">1. Data Ayah Kandung</h6>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="small text-muted">Nama Lengkap Ayah</label>
                                            <input type="text" name="ayah_nama" class="form-control form-control-sm text-uppercase" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted">Tempat Lahir</label>
                                            <input type="text" name="ayah_tempat" class="form-control form-control-sm text-uppercase" placeholder="KOTA">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted">Tanggal Lahir</label>
                                            <input type="date" name="ayah_tgl" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <h6 class="text-dark fw-bold border-bottom pb-1 mb-2 mt-3 small text-uppercase">2. Data Ibu Kandung</h6>
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="small text-muted">Nama Lengkap Ibu</label>
                                            <input type="text" name="ibu_nama" class="form-control form-control-sm text-uppercase" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted">Tempat Lahir</label>
                                            <input type="text" name="ibu_tempat" class="form-control form-control-sm text-uppercase" placeholder="KOTA">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small text-muted">Tanggal Lahir</label>
                                            <input type="date" name="ibu_tgl" class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="small text-muted fw-bold">Alamat Orang Tua (Jika beda dengan KTP Pemohon)</label>
                                        <input type="text" name="ortu_alamat" class="form-control form-control-sm text-uppercase" placeholder="Kosongkan jika sama dengan alamat pemohon">
                                    </div>
                                </div>
                            </div>

                            <div id="box-pasangan" style="display: none;">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="text-dark fw-bold border-bottom pb-1 mb-2 small text-uppercase">3. Data Suami / Istri</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="small text-muted">Nama Pasangan</label>
                                                <input type="text" name="pasangan_nama" class="form-control form-control-sm text-uppercase">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="small text-muted">Kewarganegaraan</label>
                                                <input type="text" name="pasangan_warga" class="form-control form-control-sm text-uppercase" value="INDONESIA">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="small text-muted">Tgl Lahir</label>
                                                <input type="date" name="pasangan_tgl" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary btn-nav" onclick="nextStep(1)"><i class="bi bi-arrow-left"></i> Kembali</button>
                                <button type="button" class="btn btn-primary btn-nav" onclick="nextStep(3)">Lanjut <i class="bi bi-arrow-right"></i></button>
                            </div>
                        </div>


                        <div class="form-section" id="section3">
                            <h5 class="text-primary mb-3 border-bottom pb-2">C. Data Pelengkap</h5>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nomor WhatsApp</label>
                                    <input type="number" name="no_hp" class="form-control" placeholder="0812xxxx" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tujuan Pembuatan Paspor</label>
                                    <select name="tujuan" class="form-select" required>
                                        <option value="WISATA">WISATA / LIBURAN</option>
                                        <option value="UMROH">UMROH / HAJI</option>
                                        <option value="STUDI">STUDI / BELAJAR</option>
                                        <option value="BEKERJA">BEKERJA (PMI)</option>
                                        <option value="KUNJUNGAN KELUARGA">KUNJUNGAN KELUARGA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4">
                                <div class="d-flex">
                                    <div class="me-3"><i class="bi bi-info-circle-fill fs-4"></i></div>
                                    <div>
                                        <strong>Siap Mencetak!</strong><br>
                                        Sistem akan otomatis membuat file PDF berisi:
                                        <ul class="mb-0 ps-3 small">
                                            <li>Formulir Perdim 11 (Grid)</li>
                                            <li>Surat Pernyataan</li>
                                            <li>Berita Acara Wawancara</li>
                                            <li id="msg-ortu" style="display:none; color: red;">+ Surat Pernyataan Orang Tua</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-secondary btn-nav" onclick="nextStep(2)"><i class="bi bi-arrow-left"></i> Kembali</button>
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

<script>
    // 1. LOGIKA WIZARD & VALIDASI
    function nextStep(targetStep) {
        let currentStep = targetStep - 1;
        
        // Jika MAJU, cek Validasi dulu
        const currentSection = document.getElementById('section' + currentStep);
        if (currentSection && currentSection.classList.contains('current')) {
            if (!validateSection(currentStep)) return;
        }

        // Logic Update Progress Bar
        const fill = document.getElementById('progressFill');
        const s1 = document.getElementById('step1');
        const s2 = document.getElementById('step2');
        const s3 = document.getElementById('step3');

        // Reset
        document.querySelectorAll('.step').forEach(el => el.classList.remove('active', 'finish'));
        document.querySelectorAll('.form-section').forEach(el => el.classList.remove('current'));

        // Set Target Active
        document.getElementById('section' + targetStep).classList.add('current');
        
        // Visual Bar Update
        if (targetStep === 1) {
            fill.style.width = "0%";
            s1.classList.add('active');
        } else if (targetStep === 2) {
            fill.style.width = "50%";
            s1.classList.add('finish');
            s2.classList.add('active');
        } else if (targetStep === 3) {
            fill.style.width = "100%";
            s1.classList.add('finish');
            s2.classList.add('finish');
            s3.classList.add('active');
            
            // Cek status checkbox surat ortu untuk update pesan info
            const isOrtu = document.getElementById('buat_surat_ortu').checked;
            document.getElementById('msg-ortu').style.display = isOrtu ? 'list-item' : 'none';
        }
    }

    // Fungsi Validasi Input HTML5
    function validateSection(stepIndex) {
        const section = document.getElementById('section' + stepIndex);
        const inputs = section.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        for (const input of inputs) {
            // Skip hidden inputs (like pasangan if not married)
            if (input.offsetParent === null) continue; 
            
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
                break;
            }
        }
        return isValid;
    }

    // 2. LOGIKA KTP SEUMUR HIDUP
    function toggleSeumurHidup() {
        const checkbox = document.getElementById('ktp_seumur_hidup');
        const inputDate = document.getElementById('ktp_habis');
        if (checkbox.checked) {
            inputDate.value = '';
            inputDate.disabled = true;
            inputDate.required = false;
        } else {
            inputDate.disabled = false;
            inputDate.required = true;
        }
    }

    // 3. LOGIKA STATUS KAWIN
    function togglePasangan() {
        const status = document.getElementById('status_sipil').value;
        const box = document.getElementById('box-pasangan');
        const inputNama = document.getElementsByName('pasangan_nama')[0];
        
        if (status === 'KAWIN') {
            box.style.display = 'block';
            inputNama.required = true;
        } else {
            box.style.display = 'none';
            inputNama.required = false;
            inputNama.value = ''; // Reset value
        }
    }
</script>

</body>
</html>