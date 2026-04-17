<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Kendaraan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f6f7;
            color: #333;
        }

        .header {
            background-color: #fff;
            padding: 16px 32px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-title {
            font-size: 16px;
            font-weight: 600;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .header-date {
            font-size: 14px;
            color: #666;
        }

        .exit-btn {
            padding: 8px 16px;
            border: none;
            background: none;
            color: #666;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .container {
            padding: 32px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e40af;
        }

        .page-subtitle {
            font-size: 14px;
            color: #888;
            margin-top: 4px;
        }

        .btn-tambah {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s;
        }

        .btn-tambah:hover {
            background-color: #1d4ed8;
        }

        .search-filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            align-items: center;
        }

        .search-box {
            flex: 1;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background-color: #fff;
        }

        .search-box input::placeholder {
            color: #9ca3af;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
        }

        .filter-controls {
            display: flex;
            gap: 12px;
        }

        .select-box {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #fff;
            cursor: pointer;
            font-size: 14px;
        }

        .filter-btn {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background-color: #fff;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .table-wrapper {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #f3f4f6;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-disetujui {
            background-color: #dbeafe;
            color: #0c2d6b;
        }

        .badge-pending {
            background-color: #fed7aa;
            color: #92400e;
        }

        .badge-ditolak {
            background-color: #fecaca;
            color: #dc2626;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .icon-btn {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 16px;
            padding: 4px 8px;
            transition: color 0.3s;
        }

        .icon-btn:hover {
            color: #3b82f6;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            padding: 0 16px;
            font-size: 14px;
            color: #666;
        }

        .pagination-nav {
            display: flex;
            gap: 8px;
        }

        .pagination-btn {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #fff;
            color: #333;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .pagination-btn:hover:not(:disabled) {
            background-color: #f3f4f6;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn.active {
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
        }
    </style>
</head>
<body>
@include('partials.sidebar')
<main class="main">
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="header-title">Peminjaman Kendaraan</div>
        </div>
        <div class="header-right">
            <div class="header-date">Jumat, 17 April 2026</div>
            <button class="exit-btn">➜ Keluar</button>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <div class="page-header">
            <div>
                <div class="page-title">Peminjaman Kendaraan</div>
                <div class="page-subtitle">3 data ditemukan</div>
            </div>
            <button class="btn-tambah">+ Tambah Baru</button>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter-bar">
            <div class="search-box">
                <span class="search-icon">🔍</span>
                <input type="text" placeholder="Cari...">
            </div>
            <div class="filter-controls">
                <select class="select-box">
                    <option>Semua Status</option>
                    <option>Disetujui</option>
                    <option>Pending</option>
                    <option>Ditolak</option>
                </select>
                <button class="filter-btn">⚙️ Filter</button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>PEMINJAM</th>
                        <th>KENDARAAN</th>
                        <th>TGL PINJAM</th>
                        <th>TGL KEMBALI</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PK-001</td>
                        <td>Dewi Lestari</td>
                        <td>Toyota Avanza</td>
                        <td>2025-01-15</td>
                        <td>2025-01-16</td>
                        <td><span class="badge badge-disetujui">Disetujui</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="icon-btn">👁️</button>
                                <button class="icon-btn">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>PK-002</td>
                        <td>Rudi Hartono</td>
                        <td>Honda Civic</td>
                        <td>2025-01-14</td>
                        <td>2025-01-15</td>
                        <td><span class="badge badge-pending">Pending</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="icon-btn">👁️</button>
                                <button class="icon-btn">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>PK-003</td>
                        <td>Lisa Wijaya</td>
                        <td>Mitsubishi Pajero</td>
                        <td>2025-01-13</td>
                        <td>2025-01-14</td>
                        <td><span class="badge badge-ditolak">Ditolak</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="icon-btn">👁️</button>
                                <button class="icon-btn">🗑️</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <div>Menampilkan 1–3 dari 3 data</div>
            <div class="pagination-nav">
                <button class="pagination-btn" disabled>Prev</button>
                <button class="pagination-btn active">1</button>
                <button class="pagination-btn">Next</button>
            </div>
        </div>
    </div>
</main>
</body>
</html>