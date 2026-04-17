<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPANDU - Laporan Kepala BPMP</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #4338ca;
            --secondary: #2563eb;
            --accent: #0ea5e9;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #eef2ff;
            --card-bg: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border: #e2e8f0;
            --radius: 20px;
            --shadow: 0 16px 50px rgba(15, 23, 42, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
        }

        .main {
            margin-left: 260px;
            flex: 1;
            padding: 28px 32px 40px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 16px;
            margin-bottom: 22px;
        }

        .breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .breadcrumb span {
            font-weight: 700;
            color: var(--secondary);
        }

        .topbar-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px;
            font-weight: 800;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .topbar-pill i {
            color: var(--secondary);
        }

        .report-banner {
            background: linear-gradient(135deg, #4338ca 0%, #0ea5e9 100%);
            border-radius: 32px;
            padding: 32px;
            color: #fff;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 16px 50px rgba(15, 23, 42, 0.15);
        }

        .report-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -80px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
        }

        .report-banner h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .report-banner p {
            color: rgba(255, 255, 255, 0.88);
            max-width: 640px;
            line-height: 1.75;
            margin-bottom: 22px;
        }

        .report-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.92);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-box {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .summary-box .marker {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 18px;
        }

        .summary-info {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .summary-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px;
            font-weight: 800;
        }

        .summary-label {
            font-size: 12px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 34px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        .chart-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .chart-title i {
            color: var(--secondary);
        }

        .report-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 24px;
        }

        .data-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 12px 34px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .data-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px;
            border-bottom: 1px solid var(--border);
        }

        .data-card-header h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 18px;
            font-weight: 700;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 16px 20px;
            text-align: left;
            font-size: 13px;
        }

        .data-table th {
            text-transform: uppercase;
            letter-spacing: .8px;
            font-weight: 700;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border);
        }

        .data-table td {
            color: var(--text-primary);
            border-bottom: 1px solid var(--border);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-approved {
            background: rgba(34, 197, 94, 0.12);
            color: var(--success);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.14);
            color: var(--warning);
        }

        .status-rejected {
            background: rgba(239, 68, 68, 0.12);
            color: var(--danger);
        }

        .summary-list {
            padding: 24px;
            display: grid;
            gap: 16px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item span {
            font-size: 13px;
        }

        .summary-key {
            color: var(--text-secondary);
        }

        .summary-value {
            font-weight: 700;
        }

        @media (max-width: 1120px) {

            .report-grid,
            .chart-grid {
                grid-template-columns: 1fr;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    @include('partials.sidebar')

    <div class="main">
        <div class="topbar">
            <div>
                <div class="breadcrumb"><i class="fas fa-home"></i><span>Laporan</span></div>
                <div class="topbar-title">Laporan Kepala BPMP</div>
            </div>
            <div class="topbar-right">
                <div class="topbar-pill"><i class="fas fa-calendar-day"></i>{{ date('d M Y') }}</div>
            </div>
        </div>

        <section class="report-banner">
            <h1>Ringkasan Laporan Sistem SIPANDU</h1>
            <p>Laporan visual lengkap untuk semua data aset, permintaan, persetujuan, dan status sistem dalam satu
                halaman yang mudah dibaca.</p>
            <div class="report-meta">
                <div><strong>Tanggal:</strong> {{ date('d M Y') }}</div>
                <div><strong>Periode:</strong> {{ date('M Y') }}</div>
                <div><strong>Pembuat:</strong> {{ auth()->user()->name }}</div>
            </div>
        </section>

        <div class="summary-grid">
            <div class="summary-box">
                <div class="marker" style="background: linear-gradient(135deg, #4338ca, #8b5cf6);"><i
                        class="fas fa-boxes"></i></div>
                <div class="summary-info">
                    <div class="summary-value">1,247</div>
                    <div class="summary-label">Total Aset</div>
                </div>
            </div>
            <div class="summary-box">
                <div class="marker" style="background: linear-gradient(135deg, #0ea5e9, #22d3ee);"><i
                        class="fas fa-users"></i></div>
                <div class="summary-info">
                    <div class="summary-value">156</div>
                    <div class="summary-label">Total Pengguna</div>
                </div>
            </div>
            <div class="summary-box">
                <div class="marker" style="background: linear-gradient(135deg, #14b8a6, #06b6d4);"><i
                        class="fas fa-file-alt"></i></div>
                <div class="summary-info">
                    <div class="summary-value">89</div>
                    <div class="summary-label">Permintaan Bulan Ini</div>
                </div>
            </div>
            <div class="summary-box">
                <div class="marker" style="background: linear-gradient(135deg, #f97316, #facc15);"><i
                        class="fas fa-hourglass-half"></i></div>
                <div class="summary-info">
                    <div class="summary-value">23</div>
                    <div class="summary-label">Menunggu Approval</div>
                </div>
            </div>
        </div>

        <div class="chart-grid">
            <div class="chart-card">
                <div class="chart-title"><i class="fas fa-chart-line"></i> Aktivitas Mingguan</div><canvas
                    id="activityChart" width="400" height="260"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-title"><i class="fas fa-chart-pie"></i> Kategori Aset</div><canvas id="categoryChart"
                    width="400" height="260"></canvas>
            </div>
        </div>

        <div class="report-grid">
            <div class="data-card">
                <div class="data-card-header">
                    <h2><i class="fas fa-list"></i> Permintaan Terbaru</h2>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pengguna</th>
                            <th>Jenis</th>
                            <th>Item</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001</td>
                            <td>Ahmad Surya</td>
                            <td>Peminjaman Barang</td>
                            <td>Laptop Dell</td>
                            <td>{{ date('d/m/Y') }}</td>
                            <td><span class="status-badge status-approved">Disetujui</span></td>
                        </tr>
                        <tr>
                            <td>#002</td>
                            <td>Siti Nurhaliza</td>
                            <td>Peminjaman Kendaraan</td>
                            <td>Mobil Avanza</td>
                            <td>{{ date('d/m/Y', strtotime('-1 day')) }}</td>
                            <td><span class="status-badge status-pending">Menunggu</span></td>
                        </tr>
                        <tr>
                            <td>#003</td>
                            <td>Budi Santoso</td>
                            <td>Permintaan Persediaan</td>
                            <td>Pulpen Hitam</td>
                            <td>{{ date('d/m/Y', strtotime('-2 days')) }}</td>
                            <td><span class="status-badge status-approved">Disetujui</span></td>
                        </tr>
                        <tr>
                            <td>#004</td>
                            <td>Rina Kartika</td>
                            <td>Peminjaman Gedung</td>
                            <td>Aula Utama</td>
                            <td>{{ date('d/m/Y', strtotime('-3 days')) }}</td>
                            <td><span class="status-badge status-rejected">Ditolak</span></td>
                        </tr>
                        <tr>
                            <td>#005</td>
                            <td>Dedi Kurniawan</td>
                            <td>Peminjaman Barang</td>
                            <td>Proyektor</td>
                            <td>{{ date('d/m/Y', strtotime('-4 days')) }}</td>
                            <td><span class="status-badge status-approved">Disetujui</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="data-card">
                <div class="data-card-header">
                    <h2><i class="fas fa-chart-pie"></i> Detail Sistem</h2>
                </div>
                <div class="summary-list">
                    <div class="summary-item"><span class="summary-key">Server Status</span><span class="summary-value"
                            style="color: var(--success);">Online</span></div>
                    <div class="summary-item"><span class="summary-key">Database</span><span class="summary-value"
                            style="color: var(--success);">Healthy</span></div>
                    <div class="summary-item"><span class="summary-key">Uptime</span><span
                            class="summary-value">99.9%</span></div>
                    <div class="summary-item"><span class="summary-key">Response Time</span><span
                            class="summary-value">245ms</span></div>
                    <div class="summary-item"><span class="summary-key">Security Alerts</span><span
                            class="summary-value" style="color: var(--success);">0</span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
                datasets: [{
                    label: 'Permintaan',
                    data: [22, 19, 35, 28],
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.18)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563eb'
                }, {
                    label: 'Pengguna Aktif',
                    data: [45, 52, 48, 61],
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14,165,233,0.16)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#0ea5e9'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Barang', 'Kendaraan', 'Gedung', 'Lainnya'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: ['#4338ca', '#0ea5e9', '#22c55e', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</body>

</html>
