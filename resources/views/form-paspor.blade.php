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
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
    <style>
        body { background: linear-gradient(135deg, #eef2f8 0%, #d0dbe7 100%); font-family: 'Poppins', sans-serif; padding-bottom: 80px; min-height: 100vh; }
        .header-logo { height: 50px; margin-bottom: 10px; }
        .card-menu { transition: all 0.3s; cursor: pointer; border: 2px solid transparent; border-radius: 15px; background: white; }
        .card-menu:hover { transform: translateY(-5px); border-color: #0c2e8a; box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .card-menu i { font-size: 3rem; margin-bottom: 15px; display: block; }
        .card-form { border: none; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.08); overflow: hidden; background: white; }
        .card-header-form { background: linear-gradient(135deg, #0c2e8a 0%, #001f52 100%); color: white; padding: 25px 20px; border-bottom: 5px solid #bfa15f; }
        .bg-light-blue { background-color: #f8faff; border-radius: 15px; padding: 20px; margin-bottom: 20px; border: 1px dashed #ced4da; }
        .step-indicator { display: flex; justify-content: space-between; margin: 20px 0 30px; position: relative; padding: 0 10px; }
        .progress-bg { position: absolute; top: 20px; left: 0; width: 100%; height: 4px; background: #e9ecef; z-index: 1; border-radius: 10px; }
        .progress-fill { height: 100%; background: #bfa15f; width: 0%; transition: 0.4s ease-in-out; border-radius: 10px; }
        .step-item { z-index: 2; text-align: center; width: 33.33%; }
        .step { width: 45px; height: 45px; background: white; border: 3px solid #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #999; margin: 0 auto 5px; transition: 0.3s; }
        .step.active { border-color: #0c2e8a; background: #0c2e8a; color: white; transform: scale(1.1); box-shadow: 0 0 15px rgba(12, 46, 138, 0.3); }
        .step.finish { border-color: #bfa15f; background: #bfa15f; color: white; }
        .step-label { font-size: 0.8rem; font-weight: 600; color: #aaa; }
        .step-item.active .step-label { color: #0c2e8a; }
        #camera-container { position: relative; width: 100%; max-width: 480px; margin: 0 auto; display: none; background: #000; border-radius: 10px; overflow: hidden; }
        #video-preview { width: 100%; height: auto; display: block; }
        #btn-snap { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 10; border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); }
        .fade-in { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        #section2, #section3 { display: none; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #dee2e6; }
    </style>
</head>
<body>

<div class="container mt-4">
    <div id="header-utama" class="text-center mb-5 fade-in">
        <img src="{{ asset('img/logo_imigrasi.png') }}" class="header-logo" alt="Logo">
        <h3 class="fw-bold text-dark">LAYANAN PASPOR DIGITAL</h3>
        <p class="text-muted">Kantor Imigrasi Kelas II Non TPI Wonosobo</p>
    </div>

    <div id="menu-pilihan" class="row justify-content-center fade-in">
        <div class="col-md-4 mb-3">
            <div class="card card-menu h-100 py-4 text-center text-primary" onclick="pilihMode('spri')">
                <div class="card-body"><i class="bi bi-database-fill-check"></i><h5 class="fw-bold">Tarik Data SPRI</h5><p class="small text-muted mb-0">Isi otomatis via No. Permohonan.</p></div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-menu h-100 py-4 text-center text-success" onclick="pilihMode('scan')">
                <div class="card-body"><i class="bi bi-upc-scan"></i><h5 class="fw-bold">Scan / Upload KTP</h5><p class="small text-muted mb-0">Isi otomatis via Scan Foto KTP.</p></div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-menu h-100 py-4 text-center text-secondary" onclick="pilihMode('manual')">
                <div class="card-body"><i class="bi bi-keyboard"></i><h5 class="fw-bold">Input Manual</h5><p class="small text-muted mb-0">Isi formulir secara manual.</p></div>
            </div>
        </div>
    </div>

    <div id="container-form" class="row justify-content-center fade-in" style="display: none;">
        <div class="col-lg-8 col-md-10">
            <button class="btn btn-outline-dark btn-sm mb-3" onclick="kembaliKeMenu()"><i class="bi bi-arrow-left"></i> Ganti Metode</button>

            <div class="card card-form">
                <div class="card-header-form text-center">
                    <h4 class="mb-0 fw-bold">FORMULIR PASPOR</h4>
                    <p class="mb-0 text-white-50 small">Lengkapi data berikut dengan benar</p>
                </div>
                <div class="card-body p-4">

                    <div class="step-indicator">
                        <div class="progress-bg"><div class="progress-fill" id="progressFill"></div></div>
                        <div class="step-item active" id="stepItem1"><div class="step active" id="step1">1</div><div class="step-label">Data Diri</div></div>
                        <div class="step-item" id="stepItem2"><div class="step" id="step2">2</div><div class="step-label">Keluarga</div></div>
                        <div class="step-item" id="stepItem3"><div class="step" id="step3">3</div><div class="step-label">Lainnya</div></div>
                    </div>

                    <div id="tool-spri" class="card bg-light-blue border-0 mb-4 shadow-sm" style="display:none;">
                        <div class="card-body">
                            <label class="form-label fw-bold text-primary"><i class="bi bi-database-fill-check"></i> Integrasi Data SPRI</label>
                            <div class="input-group">
                                <input type="text" id="cari_nomor_permohonan" class="form-control" placeholder="Contoh: 1558000000000032">
                                <button class="btn btn-primary" type="button" onclick="cariDataSpri()"><i class="bi bi-search"></i> Cari Data</button>
                            </div>
                            <small id="loading-spri" class="text-primary mt-2" style="display:none;"><span class="spinner-border spinner-border-sm"></span> Menghubungkan ke Server...</small>
                        </div>
                    </div>

                    <div id="tool-ocr" class="card bg-light-blue border-0 mb-4 shadow-sm" style="display:none;">
                        <div class="card-body text-center">
                            <label class="fw-bold text-success mb-3"><i class="bi bi-card-heading"></i> Pindai E-KTP (OCR)</label>
                            <div class="d-flex justify-content-center gap-2 mb-3">
                                <button type="button" class="btn btn-outline-success" onclick="startCamera()"><i class="bi bi-camera-fill"></i> Buka Kamera</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('file_ktp').click()"><i class="bi bi-upload"></i> Upload File</button>
                            </div>
                            <input type="file" id="file_ktp" class="d-none" accept="image/*" onchange="prosesGambar(this.files[0])">
                            <div id="camera-container">
                                <video id="video-preview" autoplay playsinline></video>
                                <canvas id="canvas-snap" style="display:none;"></canvas>
                                <button type="button" id="btn-snap" class="btn btn-danger btn-lg rounded-circle" onclick="ambilFoto()"><i class="bi bi-camera"></i></button>
                            </div>
                            <div id="preview-container" class="mt-3" style="display:none;">
                                <img id="hasil-foto" src="" class="img-fluid rounded border mb-2 shadow-sm" style="max-height: 250px;">
                                <br><button class="btn btn-warning fw-bold px-4" onclick="scanTesseract()"><i class="bi bi-magic"></i> EKSTRAK DATA</button>
                            </div>
                            <div id="loading-ocr" class="alert alert-info mt-3 text-center" style="display:none;"><span class="spinner-border spinner-border-sm"></span> Sedang membaca data KTP... <br><small>Mohon tunggu 5-10 detik.</small></div>
                        </div>
                    </div>

                    <form action="{{ route('cetak.proses') }}" method="POST" target="_blank" id="mainForm" novalidate>
                        @csrf
                        
                        <input type="hidden" name="metode" id="input_metode" value="MANUAL">
                        <input type="hidden" name="cari_nomor_permohonan" id="hidden_nomor_permohonan" value="">

                        <div id="section1">
                            <div class="alert alert-info py-2 mb-3 d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" id="buat_surat_ortu" name="buat_surat_ortu" value="1" onchange="toggleAnak()">
                                <label class="form-check-label fw-bold small" for="buat_surat_ortu">Pemohon Adalah Anak Dibawah Umur</label>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="small fw-bold">NIK</label><input type="text" name="nik" id="nik" class="form-control" maxlength="16" required></div>
                                <div class="col-md-6"><label class="small fw-bold">Nama Lengkap</label><input type="text" name="nama" id="nama" class="form-control text-uppercase" required></div>
                                <div class="col-md-6"><label class="small fw-bold">Nama Alias (Opsional)</label><input type="text" name="nama_alias" id="nama_alias" class="form-control text-uppercase"></div>
                                <div class="col-md-6"><label class="small fw-bold">Tempat Lahir</label><input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control text-uppercase"></div>
                                <div class="col-md-6"><label class="small fw-bold">Tanggal Lahir</label><input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control"></div>
                                <div class="col-md-3"><label class="small fw-bold">Jenis Kelamin</label><select name="jk" id="jk" class="form-select"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                                <div class="col-md-3"><label class="small fw-bold">Tinggi (cm)</label><input type="number" name="tinggi" id="tinggi" class="form-control" placeholder="165"></div>
                                <div class="col-md-6"><label class="small fw-bold">Status Sipil</label>
                                    <select name="status_sipil_id" id="status_sipil" class="form-select" onchange="togglePasangan()">
                                        <option value="1">KAWIN</option><option value="2" selected>TIDAK KAWIN</option><option value="3">CERAI MATI</option><option value="4">CERAI HIDUP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="bg-light-blue mt-3">
                                <label class="fw-bold small mb-2 text-primary">Data Pekerjaan</label>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <select name="pekerjaan_id" id="pekerjaan_id" class="form-select form-select-sm" onchange="togglePekerjaanLainnya()">
                                            <option value="1">PEJABAT NEGARA</option><option value="2">PNS</option><option value="3">TNI / POLRI</option><option value="4">PEGAWAI SWASTA</option><option value="5">LAINNYA...</option>
                                        </select>
                                        <input type="text" name="pekerjaan_lainnya" id="input_pekerjaan_lainnya" class="form-control form-control-sm mt-2 text-uppercase" placeholder="Sebutkan..." style="display:none;">
                                    </div>
                                    <div class="col-md-5"><input type="text" name="nama_alamat_kantor" class="form-control form-control-sm text-uppercase" placeholder="Nama & Alamat Kantor"></div>
                                    <div class="col-md-3"><input type="number" name="nomor_telp_kantor" class="form-control form-control-sm" placeholder="Telp Kantor"></div>
                                </div>
                            </div>
                            <div class="mb-3"><label class="small fw-bold">Alamat Rumah Lengkap</label><textarea name="alamat" id="alamat" class="form-control text-uppercase" rows="2"></textarea></div>
                            <div class="text-end mt-5"><button type="button" class="btn btn-primary px-4" onclick="nextStep(2)">Lanjut <i class="bi bi-arrow-right"></i></button></div>
                        </div>

                        <div id="section2">
                            <div class="bg-light-blue"><h6 class="fw-bold small mb-2 text-primary">Data Ayah</h6><div class="row g-2"><div class="col-md-6"><input type="text" name="ayah_nama" class="form-control form-control-sm text-uppercase" placeholder="Nama Lengkap"></div><div class="col-md-6"><input type="text" name="kewarganegaraan_ayah" class="form-control form-control-sm text-uppercase" value="INDONESIA"></div><div class="col-md-6"><input type="text" name="ayah_tempat" class="form-control form-control-sm text-uppercase" placeholder="Tempat Lahir"></div><div class="col-md-6"><input type="date" name="tgl_lahir_ayah" class="form-control form-control-sm"></div></div></div>
                            <div class="bg-light-blue"><h6 class="fw-bold small mb-2 text-danger">Data Ibu</h6><div class="row g-2"><div class="col-md-6"><input type="text" name="ibu_nama" class="form-control form-control-sm text-uppercase" placeholder="Nama Lengkap"></div><div class="col-md-6"><input type="text" name="kewarganegaraan_ibu" class="form-control form-control-sm text-uppercase" value="INDONESIA"></div><div class="col-md-6"><input type="text" name="ibu_tempat" class="form-control form-control-sm text-uppercase" placeholder="Tempat Lahir"></div><div class="col-md-6"><input type="date" name="tgl_lahir_ibu" class="form-control form-control-sm"></div></div></div>
                            <div id="box-pasangan" style="display:none;" class="bg-light-blue border border-warning">
                                <h6 class="fw-bold small mb-2">Data Pasangan (Suami/Istri)</h6>
                                <div class="row g-2">
                                    <div class="col-md-6"><input type="text" name="pasangan_nama" class="form-control form-control-sm text-uppercase" placeholder="Nama Pasangan"></div>
                                    <div class="col-md-6"><input type="text" name="kewarganegaraan_pasangan" class="form-control form-control-sm text-uppercase" value="INDONESIA"></div>
                                    <div class="col-md-6"><input type="text" name="tempat_lahir_pasangan" class="form-control form-control-sm text-uppercase" placeholder="Tempat Lahir"></div>
                                    <div class="col-md-6"><input type="date" name="tgl_lahir_pasangan" class="form-control form-control-sm"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4"><button type="button" class="btn btn-secondary" onclick="nextStep(1)">Kembali</button><button type="button" class="btn btn-primary" onclick="nextStep(3)">Lanjut</button></div>
                        </div>

                        <div id="section3">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Data Tambahan</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6"><label class="small">Tgl Dikeluarkan KTP</label><input type="date" name="ktp_tgl_keluar" id="ktp_tgl_keluar" class="form-control"></div>
                                <div class="col-md-6"><label class="small">Masa Berlaku KTP</label><div class="input-group"><input type="date" name="ktp_tgl_habis" id="ktp_habis" class="form-control"><div class="input-group-text bg-white"><input class="form-check-input mt-0" type="checkbox" id="ktp_seumur_hidup" name="ktp_seumur_hidup" value="1" onchange="toggleSeumurHidup()"><label class="ms-2 small mb-0" for="ktp_seumur_hidup">Seumur Hidup</label></div></div></div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6"><label class="small">No WhatsApp</label><input type="number" name="no_hp" id="no_hp" class="form-control" required></div>
                                <div class="col-md-6"><label class="small">Email</label><input type="email" name="email" id="email" class="form-control text-uppercase"></div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="small fw-bold">Tujuan Pembuatan</label>
                                <select name="tujuan" id="tujuan" class="form-select form-select-lg" onchange="toggleTujuanLainnya()">
                                    <option value="WISATA">WISATA</option><option value="UMROH">UMROH</option><option value="BEKERJA">BEKERJA</option><option value="STUDI">STUDI</option><option value="BEROBAT">BEROBAT</option><option value="LAINNYA">LAINNYA...</option>
                                </select>
                                <input type="text" name="tujuan_lainnya" id="tujuan_lainnya" class="form-control mt-2 text-uppercase" placeholder="Sebutkan tujuan lainnya..." style="display:none;">
                            </div>

                            <div class="d-flex justify-content-between mt-4"><button type="button" class="btn btn-secondary" onclick="nextStep(2)">Kembali</button><button type="submit" class="btn btn-success btn-lg px-5 shadow"><i class="bi bi-printer-fill me-2"></i> CETAK PDF</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <a href="{{ route('admin.dashboard') }}" style="position: fixed; bottom: 20px; right: 20px; opacity: 0.7; z-index: 9999;" class="btn btn-dark btn-sm rounded-circle shadow-lg p-2" title="Masuk ke Dashboard Admin"><i class="bi bi-gear-fill fs-5"></i></a>
</div>

<script>
    function pilihMode(mode) {
        document.getElementById('header-utama').style.display='none'; document.getElementById('menu-pilihan').style.display='none';
        document.getElementById('container-form').style.display='flex';
        document.getElementById('tool-spri').style.display = (mode==='spri'?'block':'none');
        document.getElementById('tool-ocr').style.display = (mode==='scan'?'block':'none');
        
        // --- LOGIKA UPDATE METODE PENGISIAN (HIDDEN INPUT) ---
        let m = 'MANUAL';
        if(mode === 'spri') m = 'SPRI';
        else if(mode === 'scan') m = 'SCAN';
        document.getElementById('input_metode').value = m;
    }

    function kembaliKeMenu() { document.getElementById('container-form').style.display='none'; document.getElementById('menu-pilihan').style.display='flex'; document.getElementById('header-utama').style.display='block'; document.getElementById('mainForm').reset(); stopCamera(); }
    
    // --- KAMERA & OCR ---
    let streamCamera = null;
    function startCamera() {
        const v = document.getElementById('video-preview'); const c = document.getElementById('camera-container');
        document.getElementById('preview-container').style.display='none'; c.style.display='block';
        navigator.mediaDevices.getUserMedia({video:{facingMode:"environment",width:{ideal:1920},height:{ideal:1080}}})
        .then(s=>{streamCamera=s; v.srcObject=s;}).catch(e=>{alert("Gagal: "+e); c.style.display='none';});
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
            load.style.display='none'; parsingKTP(text); alert("Scan Selesai!");
        }).catch(e=>{load.style.display='none'; alert("Gagal scan.");});
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

    // --- STEPPER & LOGIC ---
    function nextStep(n) {
        [1,2,3].forEach(i=>document.getElementById('section'+i).style.display='none');
        document.getElementById('section'+n).style.display='block';
        document.querySelectorAll('.step, .step-item').forEach(e=>e.classList.remove('active','finish'));
        if(n>=1){document.getElementById('step1').classList.add('active'); document.getElementById('progressFill').style.width="0%";}
        if(n>=2){document.getElementById('step1').classList.add('finish'); document.getElementById('step2').classList.add('active'); document.getElementById('progressFill').style.width="50%";}
        if(n>=3){document.getElementById('step2').classList.add('finish'); document.getElementById('step3').classList.add('active'); document.getElementById('progressFill').style.width="100%";}
    }
    function toggleAnak() { 
        const c=document.getElementById('buat_surat_ortu').checked; 
        const ids=['ktp_tgl_keluar','ktp_habis','ktp_seumur_hidup'];
        ids.forEach(id=>document.getElementById(id).disabled=c);
        if(c){ document.getElementById('ktp_tgl_keluar').value=''; document.getElementById('ktp_habis').value=''; document.getElementById('ktp_seumur_hidup').checked=false; }
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

    function cariDataSpri() {
        const no=document.getElementById('cari_nomor_permohonan').value, load=document.getElementById('loading-spri');
        if(!no)return alert('Isi nomor permohonan!'); load.style.display='block';
        fetch('/cari-spri/'+no).then(r=>r.json()).then(d=>{
            load.style.display='none';
            if(d.status==='success'){
                const r=d.data;
                // --- UPDATE HIDDEN INPUT AGAR TEREKAM DI DATABASE ---
                document.getElementById('hidden_nomor_permohonan').value = no;

                document.getElementById('nama').value=r.nama||''; document.getElementById('tempat_lahir').value=r.tempat_lahir||'';
                document.getElementById('tgl_lahir').value=r.tgl_lahir||''; document.getElementById('alamat').value=r.alamat||'';
                document.getElementById('no_hp').value=r.no_hp||''; document.getElementById('email').value=r.email||'';
                if(r.jk==='L')document.getElementById('jk').value='L'; else if(r.jk==='P')document.getElementById('jk').value='P';
                alert('Ditemukan!');
            }else alert(d.message);
        }).catch(()=>{load.style.display='none'; alert('Gagal koneksi.');});
    }
</script>

</body>
</html>