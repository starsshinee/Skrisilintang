<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Data Integrasi Sakti - SIPANDU</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        body { 
            background-color: #f8f9fc; 
            font-family: 'Nunito', sans-serif;
        }
        .container-fluid { 
            padding: 2rem; 
        }
        .card { 
            border: none; 
            border-radius: 0.35rem; 
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); 
        }
        .text-primary { color: #4e73df !important; }
        .btn-primary { background-color: #4e73df; border-color: #4e73df; }
    </style>
</head>
<body>
    <div class="container-fluid">
        
        <!-- Header & Button -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Data Integrasi Sakti</h1>
            
            <!-- Tombol Sinkronisasi Sekarang -->
            <!-- Form mengarah ke route sync sakti -->
            <form action="{{ route('admin.sakti.sync') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary shadow-sm px-3 py-2">
                    <i class="fas fa-sync fa-sm text-white-50 me-1"></i> Sinkronisasi Sekarang
                </button>
            </form>
        </div>

        <!-- Tampilkan pesan sukses/error (Fungsi Session Laravel) -->
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
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white">
                <h6 class="m-0 font-weight-bold text-primary">Data Master dari Sakti</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Tgl Sinkronisasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop data hasil integrasi di sini -->
                            <!-- Contoh jika data kosong: -->
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3 text-gray-300"></i><br>
                                        Belum ada data yang disinkronisasi.<br>Silakan klik <strong>"Sinkronisasi Sekarang"</strong> untuk menarik data terbaru.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Dependensi -->
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (diperlukan untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "emptyTable": "Belum ada data yang disinkronisasi.",
                    "search": "Cari Data:",
                    "lengthMenu": "Tampilkan _MENU_ entri"
                }
            });
        });
    </script>
</body>
</html>