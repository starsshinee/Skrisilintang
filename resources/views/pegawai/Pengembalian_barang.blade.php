<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Pengembalian Barang</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --primary: #2563eb;
    --primary-light: #3b82f6;
    --accent: #06b6d4;
    --accent2: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --bg: #f0f4ff;
    --sidebar-bg: #0f172a;
    --sidebar-text: #94a3b8;
    --card-bg: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 4px 24px rgba(37,99,235,0.08);
    --shadow-lg: 0 8px 40px rgba(37,99,235,0.14);
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
    border-bottom: 1px solid transparent;
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 1.5px solid var(--card-bg); }

  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 28px;
  }

  .form-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: sticky;
    top: 90px;
    height: fit-content;
  }
  .form-header {
    padding: 24px 28px 20px;
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    position: relative; overflow: hidden;
  }
  .form-header::before {
    content: '';
    position: absolute; right: -30px; top: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }
  .form-header-icon {
    position: relative;
    z-index: 1;
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 13px;
    display: grid; place-items: center;
    font-size: 20px; color: #fff;
    margin-bottom: 12px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .form-header-title { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }
  .form-header-sub { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 4px; }

  .form-body { padding: 24px 28px; }

  .form-group { margin-bottom: 18px; }
  .form-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .6px;
    margin-bottom: 8px;
  }
  .form-label i { color: var(--danger); font-size: 11px; }
  .form-label .req { color: var(--danger); }

  .form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-primary);
    background: #fff;
    transition: all .2s;
    outline: none;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
  }
  .form-input::placeholder, .form-textarea::placeholder { color: #b0bcd4; }
  .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .form-textarea { resize: vertical; min-height: 90px; }

  .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  .barang-preview {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    border-radius: 10px;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    border: 1px solid #fecaca;
  }
  .barang-preview.show { display: flex; align-items: center; gap: 12px; }
  .bp-icon { width: 36px; height: 36px; border-radius: 9px; background: var(--danger); display: grid; place-items: center; color: #fff; font-size: 15px; flex-shrink: 0; }
  .bp-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .bp-details { display: flex; gap: 10px; margin-top: 3px; }
  .bp-tag { font-size: 10px; background: rgba(239,68,68,0.1); color: var(--danger); padding: 2px 8px; border-radius: 5px; font-weight: 600; }

  .submit-btn {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--danger), #dc2626);
    color: #fff;
    border: none;
    border-radius: 11px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(239,68,68,0.35);
    margin-top: 8px;
  }
  .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239,68,68,0.4); }
  .submit-btn:active { transform: translateY(0); }
  .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

  .history-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .history-header {
    padding: 22px 28px 18px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
  }
  .history-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 17px; font-weight: 700; color: var(--text-primary);
    display: flex; align-items: center; gap: 8px;
  }
  .history-title i { color: var(--danger); }
  .filter-tabs { display: flex; gap: 6px; }
  .filter-tab {
    font-size: 11px; font-weight: 600; padding: 5px 12px;
    border-radius: 7px; cursor: pointer; border: 1.5px solid var(--border);
    background: transparent; color: var(--text-secondary);
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .filter-tab.active { background: var(--danger); color: #fff; border-color: var(--danger); }
  .filter-tab:hover:not(.active) { border-color: var(--danger); color: var(--danger); }

  .req-list { padding: 20px 28px; display: flex; flex-direction: column; gap: 16px; }

  .req-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all .2s;
    cursor: pointer;
  }
  .req-card:hover { box-shadow: var(--shadow); transform: translateY(-1px); }
  .req-card.active { border-color: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,0.1); }

  .req-card-top {
    padding: 16px 18px;
    display: flex; align-items: flex-start; justify-content: space-between;
  }
  .req-card-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: grid; place-items: center;
    font-size: 17px; flex-shrink: 0;
  }
  .req-card-name { font-size: 14px; font-weight: 700; color: var(--text-primary); }
  .req-card-code { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
  .status-badge {
    font-size: 11px; font-weight: 700; padding: 4px 11px; border-radius: 7px;
    letter-spacing: .3px; display: flex; align-items: center; gap: 5px;
    white-space: nowrap;
  }
  .status-badge.borrowed { background: rgba(245,158,11,0.1); color: var(--warning); border: 1px solid rgba(245,158,11,0.2); }
  .status-badge.lost { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
  .status-badge.returned { background: rgba(16,185,129,0.1); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
  .status-badge i { font-size: 9px; }

  .req-card-meta {
    padding: 12px 18px;
    background: #fef2f2;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #fee2e2;
  }
  .meta-item {}
  .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: .6px; color: #94a3b8; font-weight: 700; margin-bottom: 3px; }
  .meta-value { font-size: 12px; font-weight: 600; color: var(--text-primary); }

  .req-card-footer {
    padding: 12px 18px;
    display: flex; gap: 8px;
    border-top: 1px solid #fee2e2;
  }
  .card-btn {
    flex: 1; padding: 9px;
    border-radius: 8px;
    font-size: 12px; font-weight: 600;
    cursor: pointer; border: none;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s;
  }
  .card-btn.select { background: rgba(239,68,68,0.08); color: var(--danger); }
  .card-btn.select:hover { background: rgba(239,68,68,0.15); }
  .card-btn.detail { background: rgba(37,99,235,0.08); color: var(--primary); }
  .card-btn.detail:hover { background: rgba(37,99,235,0.15); }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div>
        <div class="breadcrumb"><a href="{{ route('tamu.dashboard') }}" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:10px"></i> <span>Pengembalian Barang</span></div>
        <div class="topbar-title">Pengembalian Barang</div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  <!-- FORM + RIWAYAT -->
  <div class="content-grid">
    <!-- FORM -->
    <div class="form-card animate d2" id="formCard">
      <div class="form-header">
        <div class="form-header-icon"><i class="fas fa-box"></i></div>
        <div class="form-header-title">Lapor Pengembalian Barang</div>
        <div class="form-header-sub">Pilih barang yang sudah dikembalikan dan laporkan kondisi</div>
      </div>
      <div class="form-body">
        <div class="form-group">
          <div class="form-label"><i class="fas fa-clipboard-list"></i> *Pilih Peminjaman Barang <span class="req">*</span></div>
          <select class="form-select" id="peminjamanSelect" onchange="onPeminjamanChange()">
            <option value="">-- Pilih Peminjaman Barang --</option>
            <option value="barang001">Proyektor - BRG-TAM-001 (Ruang Ponuwa)</option>
            <option value="barang002">Sound System - BRG-TAM-002 (Tinelo 1-5)</option>
            <option value="barang003">Laptop Training - BRG-TAM-003 (Olamita 1)</option>
            <option value="barang004">Whiteboard - BRG-TAM-004 (Beledaa 1-4)</option>
          </select>
          <div class="barang-preview" id="barangPreview">
            <div class="bp-icon"><i class="fas fa-box" id="bpIcon"></i></div>
            <div>
              <div class="bp-name" id="bpName">Proyektor</div>
              <div class="bp-details">
                <span class ="bp-tag" id="bpCode">BRG-TAM-001</span>
                <span class="bp-tag" id="bpLokasi">Ruang Ponuwa</span>
              </div>
            </div>
          </div>
        </div>

        <div class="input-row">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar-check"></i> Tanggal Pengembalian <span class="req">*</span></div>
            <input type="date" class="form-input" id="tglPengembalian">
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-clock"></i> Jam Pengembalian <span class="req">*</span></div>
            <input type="time" class="form-input" id="jamPengembalian">
          </div>
        </div>

        <div class="input-row">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-hashtag"></i> Jumlah Dikembalikan <span class="req">*</span></div>
            <input type="number" class="form-input" id="jumlahKembali" min="1" placeholder="0">
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-hashtag"></i> Jumlah Dipinjam</div>
            <input type="number" class="form-input" id="jumlahPinjam" readonly>
          </div>
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-exclamation-triangle"></i> Kondisi Barang</div>
          <select class="form-select" id="kondisiBarang">
            <option value="">-- Pilih Kondisi --</option>
            <option value="baik">Baik - Normal seperti semula</option>
            <option value="rusak-ringan">Rusak Ringan - Perlu perbaikan kecil</option>
            <option value="rusak-berat">Rusak Berat - Tidak bisa digunakan</option>
            <option value="hilang">Hilang / Ketinggalan</option>
          </select>
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-camera"></i> Foto Kondisi Barang <span class="req">*</span></div>
          <input type="file" class="form-input" accept="image/*" multiple id="fotoKondisi">
          <div id="fileList" style="margin-top: 8px; font-size: 12px; color: var(--text-secondary);"></div>
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-clipboard"></i> Catatan Pengembalian</div>
          <textarea class="form-textarea" id="catatanPengembalian" placeholder="Deskripsikan kondisi barang, kerusakan, nomor seri, atau catatan lainnya..."></textarea>
        </div>

        <button class="submit-btn" onclick="submitPengembalian()" id="submitBtn" disabled>
          <i class="fas fa-paper-plane"></i> Laporkan Pengembalian
        </button>
      </div>
    </div>

    <!-- RIWAYAT PEMINJAMAN BARANG -->
    <div>
      <div class="history-card animate d3">
        <div class="history-header">
          <div class="history-title"><i class="fas fa-boxes-stacked"></i> Peminjaman Barang Aktif</div>
          <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterTab(this,'all')">Semua</button>
            <button class="filter-tab" onclick="filterTab(this,'borrowed')">Dipinjam</button>
            <button class="filter-tab" onclick="filterTab(this,'lost')">Hilang</button>
            <button class="filter-tab" onclick="filterTab(this,'returned')">Terkirim</button>
          </div>
        </div>
        <div class="req-list" id="riwayatList">
          <!-- Sample data berdasarkan fasilitas -->
          <div class="req-card active" data-status="borrowed" onclick="selectPeminjaman('barang001')">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px">
                <div class="req-card-icon" style="background:rgba(37,99,235,0.1);color:#2563eb"><i class="fas fa-projector"></i></div>
                <div>
                  <div class="req-card-name">Proyektor Epson</div>
                  <div class="req-card-code">BRG-TAM-001</div>
                </div>
              </div>
              <div class="status-badge borrowed"><i class="fas fa-clock"></i> Sedang Dipinjam</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Lokasi</div><div class="meta-value">Ruang Ponuwa</div></div>
              <div class="meta-item"><div class="meta-label">Jumlah</div><div class="meta-value">2 Unit</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam</div><div class="meta-value">20 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Kembali</div><div class="meta-value">22 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn select"><i class="fas fa-check"></i> Pilih</button>
            </div>
          </div>

          <div class="req-card" data-status="borrowed" onclick="selectPeminjaman('barang002')">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px">
                <div class="req-card-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4"><i class="fas fa-volume-up"></i></div>
                <div>
                  <div class="req-card-name">Sound System</div>
                  <div class="req-card-code">BRG-TAM-002</div>
                </div>
              </div>
              <div class="status-badge borrowed"><i class="fas fa-clock"></i> Sedang Dipinjam</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Lokasi</div><div class="meta-value">Tinelo 1-5</div></div>
              <div class="meta-item"><div class="meta-label">Jumlah</div><div class="meta-value">1 Set</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam</div><div class="meta-value">18 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Kembali</div><div class="meta-value">19 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn select"><i class="fas fa-check"></i> Pilih</button>
            </div>
          </div>

          <div class="req-card" data-status="lost" onclick="selectPeminjaman('barang003')">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px">
                <div class="req-card-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-laptop"></i></div>
                <div>
                  <div class="req-card-name">Laptop Training</div>
                  <div class="req-card-code">BRG-TAM-003</div>
                </div>
              </div>
              <div class="status-badge lost"><i class="fas fa-exclamation-triangle"></i> 1 Unit Hilang</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Lokasi</div><div class="meta-value">Olamita 1</div></div>
              <div class="meta-item"><div class="meta-label">Jumlah</div><div class="meta-value">5 Unit (4 Dikembalikan)</div></div>
              <div class="meta-item"><div class="meta-label">Denda</div><div class="meta-value">Rp 8.000.000</div></div>
              <div class="meta-item"><div class="meta-label">Status</div><div class="meta-value">Hilang</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn select"><i class="fas fa-check"></i> Pilih</button>
            </div>
          </div>

          <div class="req-card" data-status="returned">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px">
                <div class="req-card-icon" style="background:rgba(16,185,129,0.1);color:#10b981"><i class="fas fa-chalkboard"></i></div>
                <div>
                  <div class="req-card-name">Whiteboard</div>
                  <div class="req-card-code">BRG-TAM-004</div>
                </div>
              </div>
              <div class="status-badge returned"><i class="fas fa-check-circle"></i> Laporan Terkirim</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Kondisi</div><div class="meta-value">Baik</div></div>
              <div class="meta-item"><div class="meta-label">Jumlah</div><div class="meta-value">2 Unit</div></div>
              <div class="meta-item"><div class="meta-label">Denda</div><div class="meta-value">Rp 0</div></div>
              <div class="meta-item"><div class="meta-label">Status</div><div class="meta-value">Selesai</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- TOAST NOTIFICATION -->
<div id="toast" style="
  position:fixed; bottom:28px; right:28px;
  background:#0f172a; color:#fff;
  padding:14px 20px; border-radius:12px;
  font-size:13px; font-weight:600;
  display:flex; align-items:center; gap:10px;
  transform:translateY(80px); opacity:0;
  transition:all .35s cubic-bezier(.4,0,.2,1);
  z-index:9999; box-shadow:0 8px 24px rgba(0,0,0,0.25);
  pointer-events:none;
">
  <i class="fas fa-circle-check" style="color:#10b981;font-size:16px"></i>
  <span id="toastMsg">Laporan pengembalian barang berhasil dikirim!</span>
</div>

<script>
const barangData = {
  barang001: { name: 'Proyektor Epson', code: 'BRG-TAM-001', lokasi: 'Ruang Ponuwa', jumlah: 2, icon: 'fa-projector' },
  barang002: { name: 'Sound System', code: 'BRG-TAM-002', lokasi: 'Tinelo 1-5', jumlah: 1, icon: 'fa-volume-up' },
  barang003: { name: 'Laptop Training', code: 'BRG-TAM-003', lokasi: 'Olamita 1', jumlah: 5, icon: 'fa-laptop' },
  barang004: { name: 'Whiteboard', code: 'BRG-TAM-004', lokasi: 'Beledaa 1-4', jumlah: 2, icon: 'fa-chalkboard' },
};

function onPeminjamanChange() {
  const val = document.getElementById('peminjamanSelect').value;
  const preview = document.getElementById('barangPreview');
  const submitBtn = document.getElementById('submitBtn');
  
  if (val && barangData[val]) {
    const d = barangData[val];
    document.getElementById('bpName').textContent = d.name;
    document.getElementById('bpCode').textContent = d.code;
    document.getElementById('bpLokasi').textContent = d.lokasi;
    document.getElementById('bpIcon').className = 'fas ' + d.icon;
    document.getElementById('jumlahPinjam').value = d.jumlah;
    preview.classList.add('show');
    
    // Enable submit button
    submitBtn.disabled = false;
    submitBtn.style.opacity = '1';
    submitBtn.style.cursor = 'pointer';
  } else {
    preview.classList.remove('show');
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.6';
    submitBtn.style.cursor = 'not-allowed';
  }
}

function selectPeminjaman(id) {
  document.getElementById('peminjamanSelect').value = id;
  onPeminjamanChange();
  document.getElementById('formCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
  
  // Remove active class from all cards
  document.querySelectorAll('.req-card').forEach(card => card.classList.remove('active'));
  // Add active class to clicked card
  event.currentTarget.classList.add('active');
}

function handleFileUpload(input) {
  const fileList = document.getElementById('fileList');
  if (input.files.length > 0) {
    let files = Array.from(input.files).map(f => f.name).join(', ');
    fileList.textContent = `${input.files.length} foto terpilih: ${files}`;
  } else {
    fileList.textContent = '';
  }
}

function formatRupiah(input) {
  let value = input.value.replace(/[^\d]/g, '');
  input.value = value ? 'Rp ' + parseInt(value).toLocaleString('id-ID') : 'Rp 0';
}

function submitPengembalian() {
  const peminjaman = document.getElementById('peminjamanSelect').value;
  const jumlahKembali = document.getElementById('jumlahKembali').value;
  const kondisi = document.getElementById('kondisiBarang').value;
  const catatan = document.getElementById('catatanPengembalian').value.trim();
  
  if (!peminjaman || !jumlahKembali || !kondisi || !catatan) {
    showToast('Mohon lengkapi semua field yang wajib!', 'error');
    return;
  }
  
  showToast('Laporan pengembalian barang berhasil dikirim! Menunggu verifikasi.', 'success');
  
  // Reset form
  setTimeout(() => {
    document.getElementById('peminjamanSelect').value = '';
    document.getElementById('barangPreview').classList.remove('show');
    document.getElementById('submitBtn').disabled = true;
    document.querySelectorAll('.req-card').forEach(card => card.classList.remove('active'));
    document.getElementById('jumlahKembali').value = '';
    document.getElementById('kondisiBarang').value = '';
    document.getElementById('catatanPengembalian').value = '';
    document.getElementById('fileList').textContent = '';
    document.getElementById('denda').value = 'Rp 0';
  }, 2000);
}

function showToast(msg, type='success') {
  const toast = document.getElementById('toast');
  const icon = toast.querySelector('i');
  document.getElementById('toastMsg').textContent = msg;
  if(type === 'error') icon.style.color = '#ef4444';
  else icon.style.color = '#10b981';
  toast.style.transform = 'translateY(0)';
  toast.style.opacity = '1';
  setTimeout(() => {
    toast.style.transform = 'translateY(80px)';
    toast.style.opacity = '0';
  }, 3500);
}

function filterTab(el, filter) {
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.req-card').forEach(card => {
    if (filter === 'all' || card.dataset.status === filter) card.style.display = '';
    else card.style.display = 'none';
  });
}

// Set default date to today
document.addEventListener('DOMContentLoaded', function() {
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('tglPengembalian').value = today;
});
</script>
</body>
</html>