<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Paspor Digital Kanim Wonosobo</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_imigrasi.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f1f5f9; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        
        /* Summary Widgets */
        .widget-card { padding: 20px; border-radius: 16px; color: white; display: flex; align-items: center; justify-content: space-between; }
        .bg-blue-gradient { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); }
        .bg-teal-gradient { background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); }
        .bg-orange-gradient { background: linear-gradient(135deg, #d97706 0%, #b45309 100%); }
        .widget-icon { font-size: 2.5rem; opacity: 0.8; }
        .widget-number { font-size: 2rem; font-weight: 700; margin: 0; line-height: 1; }
        .widget-title { font-size: 0.9rem; font-weight: 500; opacity: 0.9; margin-bottom: 5px; }

        /* Table Styles */
        .table thead th { background-color: #f8fafc; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; }
        .table tbody td { font-size: 0.9rem; vertical-align: middle; color: #334155; border-bottom: 1px solid #f1f5f9; }
        .table tbody tr:hover { background-color: #f8fafc; }

        /* Pagination Styles */
        .pagination { margin-bottom: 0; }
        .page-link { color: #2563eb; border: none; padding: 8px 16px; font-weight: 500; }
        .page-item.active .page-link { background-color: #2563eb; color: white; border-radius: 8px; }

        /* Media Print */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
            .card { box-shadow: none !important; }
            .container-fluid { padding: 0 !important; }
            .table thead th, .table tbody td { font-size: 11px !important; border: 1px solid #ddd !important; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 no-print" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 15px 0;">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="bi bi-shield-check fs-4 text-warning"></i> Admin Panel Paspor
            </a>
            <div class="d-flex gap-3">
                <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm fw-bold px-3"><i class="bi bi-window-stack me-1"></i> Buka Form</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm fw-bold px-3"><i class="bi bi-box-arrow-right me-1"></i> Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">
        
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 no-print"><i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 no-print"><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}</div>
        @endif

        <div class="row g-4 mb-4 no-print">
            <div class="col-md-4">
                <div class="widget-card bg-blue-gradient">
                    <div>
                        <p class="widget-title">Pemohon Hari Ini</p>
                        <h3 class="widget-number">{{ $pemohonHariIni }} <span class="fs-6 fw-normal">Orang</span></h3>
                    </div>
                    <i class="bi bi-people-fill widget-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-card bg-teal-gradient">
                    <div>
                        <p class="widget-title">Total Pemohon (Keseluruhan)</p>
                        <h3 class="widget-number">{{ $totalPemohon }} <span class="fs-6 fw-normal">Berkas</span></h3>
                    </div>
                    <i class="bi bi-folder-check widget-icon"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget-card bg-orange-gradient">
                    <div>
                        <p class="widget-title">Otomatisasi (SPRI/Scan)</p>
                        <h3 class="widget-number">{{ $pemohonOtomatis }} <span class="fs-6 fw-normal">Kali Digunakan</span></h3>
                    </div>
                    <i class="bi bi-robot widget-icon"></i>
                </div>
            </div>
        </div>

        <div class="card mb-5">
            <div class="card-header bg-white border-bottom-0 p-4 pb-0 no-print">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h5 class="fw-bold text-dark m-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Cetak Paspor</h5>
                    
                    <form action="" method="GET" class="d-flex gap-2">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar-date text-muted"></i></span>
                            <input type="date" name="filter_tanggal" class="form-control border-start-0" value="{{ request('filter_tanggal') }}" title="Filter Tanggal Cetak">
                        </div>
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="cari" class="form-control" placeholder="Cari Nama atau NIK..." value="{{ request('cari') }}">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                        @if(request('cari') || request('filter_tanggal'))
                            <a href="{{ url()->current() }}" class="btn btn-sm btn-light text-danger fw-bold" title="Reset Filter"><i class="bi bi-x-circle"></i> Reset</a>
                        @endif
                        <button type="button" class="btn btn-success btn-sm fw-bold ms-2" onclick="window.print()"><i class="bi bi-printer-fill me-1"></i> Cetak Laporan</button>
                    </form>
                </div>
            </div>

            <div class="card-body p-0 mt-3"> 
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="15%">Waktu (WIB)</th>
                                <th class="text-center" width="18%">Metode Pengisian</th>
                                <th class="text-center" width="15%">NIK</th>
                                <th class="text-start ps-3" width="25%">Nama Pemohon</th>
                                <th class="text-center" width="12%">Tujuan</th>
                                <th class="text-center no-print" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $row)
                            <tr>
                                <td class="text-center">{{ $data->firstItem() + $key }}</td>
                                
                                <td class="text-center small fw-medium">
                                    {{ \Carbon\Carbon::parse($row->waktu_cetak)->timezone('Asia/Jakarta')->format('d M Y - H:i') }}
                                </td>
                                
                                <td class="text-center small">
                                    @if($row->metode == 'SPRI')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"><i class="bi bi-database-check me-1"></i>{{ $row->nomor_permohonan ?? 'SPRI' }}</span>
                                    @elseif($row->metode == 'SCAN')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="bi bi-upc-scan me-1"></i>SCAN KTP</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1"><i class="bi bi-keyboard me-1"></i>MANUAL</span>
                                    @endif
                                </td>
                                
                                <td class="text-center fw-medium font-monospace small">{{ $row->nik }}</td>
                                <td class="text-start ps-3 fw-bold text-uppercase small text-dark">{{ $row->nama_lengkap }}</td>
                                <td class="text-center"><span class="badge bg-light text-dark border px-2 py-1">{{ $row->tujuan }}</span></td>
                                
                                <td class="text-center no-print">
                                    <form action="{{ route('riwayat.hapus', $row->id ?? 0) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $row->nama_lengkap }} dari riwayat?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" title="Hapus Riwayat"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="Empty" style="width: 80px; opacity: 0.5; margin-bottom: 15px;">
                                    <h6 class="text-muted fw-bold">Tidak ada data riwayat yang ditemukan.</h6>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($data->hasPages())
            <div class="card-footer bg-white border-top p-3 d-flex justify-content-center no-print">
                {{ $data->links('pagination::bootstrap-5') }}
            </div>
            @endif

        </div>
        
        <div class="text-center mt-2 mb-4 text-muted small fw-medium no-print">
            &copy; {{ date('Y') }} Kantor Imigrasi Kelas II Non TPI Wonosobo
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>