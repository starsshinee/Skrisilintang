<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Data Aset Tetap (Sakti) - SIPANDU</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fc; font-family: 'Nunito', sans-serif; }
        .container-fluid { padding: 2rem; }
        .card { border: none; border-radius: 0.35rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .text-primary { color: #4e73df !important; }
        .btn-primary { background-color: #4e73df; border-color: #4e73df; }
        /* Memastikan tabel bisa digeser (horizontal scroll) jika data panjang */
        .table-responsive { overflow-x: auto; white-space: nowrap; }
    </style>
</head>
<body>
    <div class="container-fluid">
        
        <!-- Header & Button -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Data Aset Tetap (Sakti)</h1>
            
            <!-- Tombol Sinkronisasi Sekarang -->
            <form action="{{ route('admin.sakti.sync') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_data" value="aset_tetap">
                <button type="submit" class="btn btn-sm btn-primary shadow-sm px-3 py-2">
                    <i class="fas fa-sync fa-sm text-white-50 me-1"></i> Sinkronisasi Aset Tetap Sekarang
                </button>
            </form>
        </div>

        <!-- Alert Notification -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Data Table Card -->
        <div class="card mb-4">
            <div class="card-header py-3 bg-white d-flex align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar BMN / Aset Tetap (Kode Satker 138)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="dataTableAset" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Jenis BMN</th>
                                <th>Kode Barang</th>
                                <th>NUP</th>
                                <th>Nama Barang</th>
                                <th>Merk / Tipe</th>
                                <th>Kondisi</th>
                                <th>Nilai Perolehan</th>
                                <th>Nilai Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Looping Data (Contoh implementasi jika sudah di-fetch ke DB) -->
                            @forelse($data_aset ?? [] as $index => $aset)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $aset->jenis_bmn ?? '-' }}</td>
                                <td>{{ $aset->kode_barang ?? '-' }}</td>
                                <td>{{ $aset->nup ?? '-' }}</td>
                                <td>{{ $aset->nama_barang ?? '-' }}</td>
                                <td>{{ $aset->merk ?? '-' }} / {{ $aset->tipe ?? '-' }}</td>
                                <td>
                                    @if(strtolower($aset->kondisi) == 'baik')
                                        <span class="badge bg-success">Baik</span>
                                    @else
                                        <span class="badge bg-warning">{{ $aset->kondisi ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($aset->nilai_perolehan ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($aset->nilai_buku ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <!-- Tombol aksi untuk melihat 74 kolom lainnya -->
                                    <button type="button" class="btn btn-sm btn-info text-white" title="Detail BMN">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <!-- Tampilan saat tabel belum ditarik datanya -->
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-file-excel fa-3x mb-3 text-gray-300"></i><br>
                                        Data belum tersinkronisasi dari Sakti.<br>Silakan klik <strong>"Sinkronisasi Aset Tetap Sekarang"</strong>.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Dependensi -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataTableAset').DataTable({
                "language": {
                    "emptyTable": "Belum ada data yang disinkronisasi.",
                    "search": "Cari BMN:",
                    "lengthMenu": "Tampilkan _MENU_ entri"
                }
            });
        });
    </script>
</body>
</html>