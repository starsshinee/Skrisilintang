<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Data Persediaan (Sakti) - SIPANDU</title>
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
        .text-success-custom { color: #1cc88a !important; }
        .btn-success-custom { background-color: #1cc88a; border-color: #1cc88a; color: white; }
        .btn-success-custom:hover { background-color: #17a673; border-color: #17a673; color: white; }
        .table-responsive { overflow-x: auto; white-space: nowrap; }
    </style>
</head>
<body>
    <div class="container-fluid">
        
        <!-- Header & Button -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Data Persediaan (Sakti)</h1>
            
            <!-- Tombol Sinkronisasi Sekarang -->
            <form action="{{ route('admin.sakti.sync') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis_data" value="persediaan">
                <button type="submit" class="btn btn-sm btn-success-custom shadow-sm px-3 py-2">
                    <i class="fas fa-sync fa-sm text-white-50 me-1"></i> Sinkronisasi Persediaan Sekarang
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
                <h6 class="m-0 font-weight-bold text-success-custom">Daftar Barang Persediaan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="dataTablePersediaan" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Tgl Masuk</th>
                                <th>Harga Satuan</th>
                                <th>Stok (Jumlah)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Looping Data -->
                            @forelse($data_persediaan ?? [] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $item->kategori ?? '-' }}</strong><br>
                                    <small class="text-muted">{{ $item->kode_kategori ?? '-' }}</small>
                                </td>
                                <td>{{ $item->kode_barang ?? '-' }}</td>
                                <td>{{ $item->nama_barang ?? '-' }}</td>
                                <td>
                                    @if(!empty($item->tanggal_masuk))
                                        {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d-m-Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>Rp {{ number_format($item->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ ($item->jumlah ?? 0) > 0 ? 'bg-success' : 'bg-danger' }} fs-6">
                                        {{ $item->jumlah ?? 0 }} {{ $item->satuan ?? 'Item' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <!-- Tampilan saat tabel belum ditarik datanya -->
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-cubes fa-3x mb-3 text-gray-300"></i><br>
                                        Data belum tersinkronisasi dari Sakti.<br>Silakan klik <strong>"Sinkronisasi Persediaan Sekarang"</strong>.
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
            $('#dataTablePersediaan').DataTable({
                "language": {
                    "emptyTable": "Belum ada data yang disinkronisasi.",
                    "search": "Cari Persediaan:",
                    "lengthMenu": "Tampilkan _MENU_ entri"
                }
            });
        });
    </script>
</body>
</html>