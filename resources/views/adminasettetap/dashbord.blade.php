<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Dashboard Admin Aset Tetap</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --primary: #2563eb;
        --primary-light: #3b82f6;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --purple: #8b5cf6;
        --info: #06b6d4;
        --bg: #f8fafc;
        --card-bg: #ffffff;
        --text-primary: #0f172a;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --radius: 16px;
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background: var(--bg); 
        color: var(--text-primary);
        display: flex; min-height: 100vh;
    }

    .main { flex: 1; padding: 24px 32px; margin-left: 260px; } /* Sesuaikan margin-left dengan sidebar kamu */
    
    .topbar {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 32px;
    }
    .page-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 28px; font-weight: 700; color: var(--text-primary);
    }
    .page-subtitle { color: var(--text-secondary); font-size: 14px; margin-top: 4px; }
    
    .user-profile { display: flex; align-items: center; gap: 12px; }
    .date-badge {
        background: white; border: 1px solid var(--border); padding: 8px 16px;
        border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--text-secondary);
        display: flex; align-items: center; gap: 8px;
    }

    /* STATS GRID */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr); /* Membagi grid menjadi 6 bagian */
        gap: 20px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--card-bg); border-radius: var(--radius);
        padding: 24px; border: 1px solid var(--border);
        box-shadow: var(--shadow); position: relative; overflow: hidden;
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); }
    
    /* Formasi Baris Atas: 3 Card (Masing-masing mengambil 2 porsi) */
    .stat-card:nth-child(1),
    .stat-card:nth-child(2),
    .stat-card:nth-child(3) {
        grid-column: span 2;
    }

    /* Formasi Baris Bawah: 2 Card (Masing-masing mengambil 3 porsi agar lebih lebar & proporsional) */
    .stat-card:nth-child(4),
    .stat-card:nth-child(5) {
        grid-column: span 3;
    }

    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: grid; place-items: center; font-size: 20px;
        margin-bottom: 16px;
    }
    .stat-value { font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 700; margin-bottom: 4px; }
    .stat-label { font-size: 13px; color: var(--text-secondary); font-weight: 600; }

    /* SPECIFIC CARD COLORS */
    .card-aset .stat-icon { background: #eff6ff; color: var(--primary); }
    .card-masuk .stat-icon { background: #ecfdf5; color: var(--success); }
    .card-pinjam .stat-icon { background: #f5f3ff; color: var(--purple); }
    .card-kendaraan .stat-icon { background: #fffbeb; color: var(--warning); }
    .card-pending .stat-icon { background: #fef2f2; color: var(--danger); }
    .card-pending { border-color: #fecaca; background: #fffcfc; }


    /* RECENT ACTIVITY SECTION */
    .section-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px;
    }
    .section-title { font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
    .btn-view-all {
        font-size: 13px; font-weight: 600; color: var(--primary);
        text-decoration: none; display: flex; align-items: center; gap: 4px;
    }
    .btn-view-all:hover { text-decoration: underline; }

    /* TABLE STYLES */
    .table-container {
        background: var(--card-bg); border-radius: var(--radius);
        border: 1px solid var(--border); box-shadow: var(--shadow);
        overflow: hidden;
    }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th {
        padding: 16px 24px; font-size: 12px; font-weight: 700;
        color: var(--text-secondary); text-transform: uppercase;
        letter-spacing: 0.5px; background: #f8fafc; border-bottom: 1px solid var(--border);
    }
    td { padding: 16px 24px; font-size: 14px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    tr:hover { background: #f8faff; }

    .user-info { display: flex; align-items: center; gap: 12px; }
    .user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--primary); color: white;
        display: grid; place-items: center; font-weight: 700; font-size: 14px;
    }
    
    .badge {
        padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700;
        display: inline-flex; align-items: center; gap: 4px; text-transform: uppercase;
    }
    .badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

    .btn-action {
        padding: 8px 16px; background: var(--primary); color: white;
        border-radius: 8px; font-size: 12px; font-weight: 600;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        transition: 0.2s; border: none; cursor: pointer;
    }
    .btn-action:hover { background: var(--primary-light); }

    .empty-state { padding: 40px; text-align: center; color: var(--text-secondary); }
    .empty-state i { font-size: 40px; color: #cbd5e1; margin-bottom: 12px; }

    /* RESPONSIVE LAYOUT UNTUK TABLET & HP */
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .stat-card:nth-child(n) { grid-column: span 1; }
        .stat-card:nth-child(5) { grid-column: span 2; } /* Card terakhir memanjang di tablet */
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card:nth-child(n) { grid-column: span 1; }
        .main { margin-left: 0; padding: 0 16px 32px; padding-top: 60px; }
        .topbar { flex-direction: column; align-items: flex-start; gap: 8px; }
        .page-title { font-size: 22px; }
        .table-container { overflow-x: auto; }
        table { min-width: 600px; }
    }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
    <!-- TOPBAR -->
    <div class="topbar">
        <div>
            <h1 class="page-title">Dashboard Aset Tetap</h1>
            <p class="page-subtitle">Ringkasan data inventaris dan aktivitas peminjaman</p>
        </div>
        <div class="user-profile">
            <div class="date-badge">
                <i class="fas fa-calendar-alt" style="color: var(--primary)"></i>
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}
            </div>
        </div>
    </div>

    <!-- STATS GRID -->
    <div class="stats-grid">
        <!-- 1. Total Aset -->
        <div class="stat-card card-aset">
            <div class="stat-icon"><i class="fas fa-boxes"></i></div>
            <div class="stat-value">{{ number_format($stats['totalAset']) }}</div>
            <div class="stat-label">Total Item Aset Tetap</div>
        </div>

        <!-- 2. Transaksi Masuk -->
        <div class="stat-card card-masuk">
            <div class="stat-icon"><i class="fas fa-arrow-down-to-bracket"></i></div>
            <div class="stat-value">{{ number_format($stats['transaksiMasuk']) }}</div>
            <div class="stat-label">Total Transaksi Masuk</div>
        </div>

        <!-- 3. Peminjaman Barang Aktif -->
        <div class="stat-card card-pinjam">
            <div class="stat-icon"><i class="fas fa-hand-holding-box"></i></div>
            <div class="stat-value">{{ number_format($stats['peminjamanBarangAktif']) }}</div>
            <div class="stat-label">Barang Sedang Dipinjam</div>
        </div>

        <!-- 4. Kendaraan Dipinjam -->
        <div class="stat-card card-kendaraan">
            <div class="stat-icon"><i class="fas fa-car-side"></i></div>
            <div class="stat-value">{{ number_format($stats['kendaraanDipinjam']) }}</div>
            <div class="stat-label">Kendaraan Sedang Dipinjam</div>
        </div>

        <!-- 5. Pengembalian Pending -->
        <div class="stat-card card-pending">
            <div class="stat-icon"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-value" style="color: var(--danger)">{{ number_format($stats['pengembalianPending']) }}</div>
            <div class="stat-label">Verifikasi Pengembalian Pending</div>
        </div>
    </div>

    <!-- RECENT ACTIVITY: Pengembalian Pending -->
    <div class="section-header">
        <h2 class="section-title">
            <i class="fas fa-bell" style="color: var(--danger)"></i> 
            Menunggu Verifikasi Pengembalian ({{ $stats['pengembalianPending'] }})
        </h2>
        <a href="{{ route('adminasettetap.pengembalian-barang') }}" class="btn-view-all">
            Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Aset / Barang</th>
                    <th>Tgl. Dikembalikan</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPengembalian as $item)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ substr($item->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: var(--text-primary)">{{ $item->user->nama_lengkap ?? $item->user->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-secondary)">{{ $item->user->nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 600">{{ $item->peminjamanBarang->barang->nama_barang ?? 'Barang tidak diketahui' }}</div>
                            <div style="font-size: 12px; color: var(--text-secondary)">Kode Pinjam: {{ $item->peminjamanBarang->kode_peminjaman ?? '-' }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian_aktual)->format('d M Y') }}</div>
                            <div style="font-size: 12px; color: var(--text-secondary)">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengembalian_aktual)->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            @if($item->kondisi == 'baik')
                                <span style="color: var(--success); font-weight: 600"><i class="fas fa-check-circle"></i> Baik</span>
                            @else
                                <span style="color: var(--danger); font-weight: 600"><i class="fas fa-times-circle"></i> {{ ucfirst($item->kondisi) }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-pending">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        </td>
                        <td>
                            <!-- Sesuaikan link ini dengan route verifikasi kamu -->
                            <a href="{{ route('adminasettetap.pengembalian-barang') }}" class="btn-action">
                                <i class="fas fa-check"></i> Verifikasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-check"></i>
                                <h3>Tidak ada tugas verifikasi</h3>
                                <p>Semua pengembalian barang saat ini sudah diverifikasi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

</body>
</html>