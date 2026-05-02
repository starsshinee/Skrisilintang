<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Informasi Mutasi Barang</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    :root {
        --primary: #2563eb;
        --primary-light: #3b82f6;
        --success: #10b981;
        --danger: #ef4444;
        --bg: #f0f4ff;
        --card-bg: #ffffff;
        --text-primary: #0f172a;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --radius: 16px;
        --shadow: 0 4px 24px rgba(37,99,235,0.08);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: var(--bg);
        color: var(--text-primary);
        display: flex;
        min-height: 100vh;
    }

    .main { margin-left: 260px; flex: 1; padding: 0 32px 40px; }

    .topbar {
        display: flex; align-items: center; justify-content: space-between;
        padding: 20px 0 24px;
        position: sticky; top: 0; z-index: 50;
        background: var(--bg);
    }
    .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-primary); }
    .topbar-date {
        font-size: 13px; color: var(--text-secondary); font-weight: 500;
        background: var(--card-bg); border: 1px solid var(--border);
        padding: 8px 14px; border-radius: 10px;
        display: flex; align-items: center; gap: 6px;
    }

    /* TABLE CARD */
    .content-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        overflow: hidden;
        animation: fadeIn 0.5s ease-out;
    }
    .card-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(to right, #ffffff, #f8fafc);
    }
    .card-header h2 { font-size: 16px; font-weight: 700; color: var(--text-primary); }
    .card-header p { font-size: 12px; color: var(--text-secondary); margin-top: 4px; }

    .table-container { padding: 20px 28px; overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th {
        padding: 14px 16px;
        background: #f8fafc;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--border);
    }
    td { padding: 16px; font-size: 13px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    
    .item-info { display: flex; flex-direction: column; gap: 2px; }
    .item-name { font-weight: 700; color: var(--text-primary); }
    .item-nup { font-size: 11px; color: var(--text-secondary); }

    .location-badge {
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 11.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .loc-from { background: #fee2e2; color: var(--danger); }
    .loc-to { background: #dcfce7; color: var(--success); }
    
    .arrow-icon { color: var(--text-secondary); margin: 0 10px; font-size: 12px; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
    <div class="topbar">
        <div class="topbar-title">Info Mutasi Barang</div>
        <div class="topbar-date">
            <i class="fas fa-calendar-alt"></i>
            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
        </div>
    </div>

    <div class="content-card">
        <div class="card-header">
            <h2>Riwayat Perpindahan Barang</h2>
            <p>Daftar mutasi barang dinas di lingkungan BPMP Provinsi Gorontalo.</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Informasi Barang</th>
                        <th>Tanggal Mutasi</th>
                        <th>Alur Perpindahan</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mutasiBarang as $index => $mutasi)
                    <tr>
                        <td style="width: 50px; font-weight: 600; color: var(--text-secondary);">
                            {{ $mutasiBarang->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="item-info">
                                <span class="item-name">{{ $mutasi->barang->nama_barang ?? 'Barang Tidak Diketahui' }}</span>
                                <span class="item-nup">NUP: {{ $mutasi->barang->nup ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500;">
                                <i class="far fa-calendar-check" style="margin-right: 4px; color: var(--primary);"></i>
                                {{ \Carbon\Carbon::parse($mutasi->tanggal_mutasi)->format('d/m/Y') }}
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <span class="location-badge loc-from">
                                    <i class="fas fa-sign-out-alt"></i> {{ $mutasi->lokasi_asal }}
                                </span>
                                <i class="fas fa-long-arrow-alt-right arrow-icon"></i>
                                <span class="location-badge loc-to">
                                    <i class="fas fa-sign-in-alt"></i> {{ $mutasi->lokasi_tujuan }}
                                </span>
                            </div>
                        </td>
                        <td style="color: var(--text-secondary); font-style: italic; font-size: 12px;">
                            {{ $mutasi->keterangan ?? 'Tanpa keterangan' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 60px 0;">
                            <i class="fas fa-exchange-alt" style="font-size: 40px; color: var(--border); margin-bottom: 16px; display: block;"></i>
                            <span style="color: var(--text-secondary); font-weight: 500;">Belum ada data mutasi barang yang tercatat.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $mutasiBarang->links() }}
            </div>
        </div>
    </div>
</main>

</body>
</html>