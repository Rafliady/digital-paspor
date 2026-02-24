<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pemohon - Admin</title>
    
    <link rel="icon" type="image/png" href="{{ asset('img/logo_imigrasi.png') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        
        /* Default Table Styles */
        .table thead th { 
            background-color: #e9ecef; 
            font-size: 0.85rem; 
            vertical-align: middle;
            font-weight: 700;
        }
        .table tbody td { 
            font-size: 0.9rem; 
            vertical-align: middle;
        }

        /* --- CSS KHUSUS UNTUK HASIL PRINT --- */
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
            .card { box-shadow: none !important; border: none !important; }
            .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            
            /* Agar muat satu baris, kecilkan font saat diprint */
            .table thead th, .table tbody td {
                font-size: 11px !important;
                padding: 4px !important;
            }
            
            /* Pastikan tabel memenuhi lebar kertas */
            .table { width: 100% !important; }
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark m-0">Daftar Riwayat Cetak</h4>
                <p class="text-muted small m-0">Total Data: <strong>{{ count($data) }}</strong> pemohon</p>
            </div>
            
            <div class="d-flex gap-2 no-print">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                    <i class="bi bi-eye"></i> Form
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-power"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0"> 
                
                <div class="text-end p-3 border-bottom bg-light no-print">
                    <button class="btn btn-success btn-sm fw-bold" onclick="window.print()">
                        <i class="bi bi-printer"></i> Print Laporan
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="20%">Waktu (WIB)</th>
                                <th class="text-center" width="20%">Metode / No. Permohonan</th>
                                <th class="text-center" width="15%">NIK</th>
                                <th class="text-start ps-4" width="30%">Nama Pemohon</th>
                                <th class="text-center" width="10%">Tujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $row)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                
                                <td class="text-center small text-muted text-nowrap">
                                    {{ \Carbon\Carbon::parse($row->waktu_cetak)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                                </td>
                                
                                <td class="text-center small text-nowrap">
                                    @if(isset($row->metode) && $row->metode == 'SPRI')
                                        <span class="text-primary fw-bold" style="font-family: monospace; font-size: 1rem;">
                                            {{ $row->nomor_permohonan }}
                                        </span>
                                    @elseif(isset($row->metode) && $row->metode == 'SCAN')
                                        <span class="badge bg-success"><i class="bi bi-qr-code-scan"></i> SCAN KTP</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="bi bi-keyboard"></i> MANUAL</span>
                                    @endif
                                </td>
                                
                                <td class="text-center small text-nowrap">{{ $row->nik }}</td>
                                
                                <td class="text-start ps-4 fw-bold text-uppercase small text-nowrap">
                                    {{ $row->nama_lengkap }}
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-white text-dark border">{{ $row->tujuan }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    Belum ada data riwayat pencetakan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted small">
            &copy; {{ date('Y') }} Kantor Imigrasi Wonosobo
        </div>

    </div>

</body>
</html>