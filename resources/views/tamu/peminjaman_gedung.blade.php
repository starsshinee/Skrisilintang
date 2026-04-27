<!DOCTYPE html>
<html lang="id">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>SIPANDU - Peminjaman Aset</title>
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
    --sidebar-width: 260px;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
  }

  /* ===================== SIDEBAR ===================== */
  .sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 200;
    display: flex;
    flex-direction: column;
    transition: transform .3s ease;
    overflow-y: auto;
  }
  .sidebar-logo {
    padding: 24px 20px;
    display: flex; align-items: center; gap: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    flex-shrink: 0;
  }
  .logo-box {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 10px;
    display: grid; place-items: center;
    color: #fff; font-size: 16px; font-weight: 800;
    font-family: 'Space Grotesk', sans-serif;
    flex-shrink: 0;
  }
  .logo-text { font-family: 'Space Grotesk', sans-serif; font-size: 16px; font-weight: 700; color: #fff; line-height: 1.1; }
  .logo-sub { font-size: 10px; color: rgba(255,255,255,0.4); }

  .sidebar-section { padding: 16px 12px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: rgba(255,255,255,0.25); }
  .sidebar-menu { list-style: none; padding: 0 12px; }
  .sidebar-menu li a {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 10px;
    font-size: 13px; font-weight: 500; color: var(--sidebar-text);
    text-decoration: none; transition: all .18s;
    margin-bottom: 2px;
  }
  .sidebar-menu li a:hover { background: rgba(255,255,255,0.06); color: #fff; }
  .sidebar-menu li a.active { background: rgba(37,99,235,0.2); color: #3b82f6; }
  .sidebar-menu li a i { width: 18px; text-align: center; font-size: 14px; }

  .sidebar-user {
    margin-top: auto;
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.06);
    display: flex; align-items: center; gap: 10px;
    flex-shrink: 0;
  }
  .user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    display: grid; place-items: center;
    color: #fff; font-size: 13px; font-weight: 700;
    flex-shrink: 0;
  }
  .user-name { font-size: 13px; font-weight: 600; color: #fff; }
  .user-role { font-size: 11px; color: var(--sidebar-text); }

  /* Overlay for mobile */
  .sidebar-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 190;
    backdrop-filter: blur(2px);
  }
  .sidebar-overlay.show { display: block; }

  /* Mobile hamburger */
  .hamburger {
    display: none;
    width: 40px; height: 40px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    align-items: center; justify-content: center;
    cursor: pointer; color: var(--text-secondary);
    font-size: 16px; transition: all .2s;
    flex-shrink: 0;
  }
  .hamburger:hover { border-color: var(--primary); color: var(--primary); }

  /* Close sidebar btn (mobile) */
  .sidebar-close {
    display: none;
    position: absolute; top: 16px; right: 16px;
    width: 32px; height: 32px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    cursor: pointer; color: rgba(255,255,255,0.7);
    font-size: 14px;
    align-items: center; justify-content: center;
    transition: all .2s;
  }
  .sidebar-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

  /* ===================== MAIN ===================== */
  .main {
    margin-left: var(--sidebar-width);
    flex: 1;
    padding: 0 32px 40px;
    min-width: 0;
    width: calc(100% - var(--sidebar-width));
  }

  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
    border-bottom: 1px solid transparent;
    gap: 12px;
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; flex: 1; min-width: 0; }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .topbar-right { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 1.5px solid var(--card-bg); }

  /* ===================== CONTENT GRID ===================== */
  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 28px;
    align-items: start;
  }

  /* ===================== FORM CARD ===================== */
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
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
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
    position: relative; z-index: 1;
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 13px;
    display: grid; place-items: center;
    font-size: 20px; color: #fff;
    margin-bottom: 12px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .form-header-title { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: #fff; position: relative; z-index: 1; }
  .form-header-sub { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 4px; position: relative; z-index: 1; }

  .form-body { padding: 24px 28px; }

  .form-group { margin-bottom: 18px; }
  .form-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .6px;
    margin-bottom: 8px;
  }
  .form-label i { color: var(--primary); font-size: 11px; }
  .form-label .req { color: var(--danger); }
  .form-hint { font-size: 11px; color: var(--text-secondary); margin-top: 5px; display: flex; align-items: center; gap: 4px; }

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
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }
  .form-input::placeholder, .form-textarea::placeholder { color: #b0bcd4; }
  .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .form-textarea { resize: vertical; min-height: 90px; }

  .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  /* Facility Preview */
  .facility-preview {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    border-radius: 10px;
    background: linear-gradient(135deg, #eff4ff, #f0fdff);
    border: 1px solid #c7d7ff;
  }
  .facility-preview.show { display: flex; align-items: center; gap: 12px; }
  .fp-icon { width: 36px; height: 36px; border-radius: 9px; background: var(--primary); display: grid; place-items: center; color: #fff; font-size: 15px; flex-shrink: 0; }
  .fp-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .fp-details { display: flex; gap: 10px; margin-top: 3px; flex-wrap: wrap; }
  .fp-tag { font-size: 10px; background: rgba(37,99,235,0.1); color: var(--primary); padding: 2px 8px; border-radius: 5px; font-weight: 600; }

  .file-input-wrapper {
    border: 1.5px dashed var(--border);
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    background: #fafcff;
  }
  .file-input-wrapper:hover { border-color: var(--primary); background: #f0f5ff; }
  .file-input-wrapper input[type="file"] { display: none; }
  .file-input-label { cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 8px; }
  .file-input-label i { font-size: 24px; color: var(--primary); opacity: .7; }
  .file-input-label span { font-size: 12px; color: var(--text-secondary); }
  .file-input-label strong { font-size: 13px; color: var(--primary); }

  .submit-btn {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    border: none;
    border-radius: 11px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    margin-top: 8px;
  }
  .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
  .submit-btn:active { transform: translateY(0); }

  /* ===================== RIWAYAT ===================== */
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
    flex-wrap: wrap; gap: 12px;
  }
  .history-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 17px; font-weight: 700; color: var(--text-primary);
    display: flex; align-items: center; gap: 8px;
  }
  .history-title i { color: var(--primary); }
  .filter-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
  .filter-tab {
    font-size: 11px; font-weight: 600; padding: 5px 12px;
    border-radius: 7px; cursor: pointer; border: 1.5px solid var(--border);
    background: transparent; color: var(--text-secondary);
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .filter-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
  .filter-tab:hover:not(.active) { border-color: var(--primary); color: var(--primary); }

  .req-list { padding: 20px 28px; display: flex; flex-direction: column; gap: 16px; }

  .req-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all .2s;
  }
  .req-card:hover { box-shadow: var(--shadow); transform: translateY(-1px); }

  .req-card-top {
    padding: 16px 18px;
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 10px;
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
    white-space: nowrap; flex-shrink: 0;
  }
  .status-badge.approved { background: rgba(16,185,129,0.1); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
  .status-badge.pending { background: rgba(245,158,11,0.1); color: var(--warning); border: 1px solid rgba(245,158,11,0.2); }
  .status-badge.rejected { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
  .status-badge i { font-size: 9px; }

  .req-card-meta {
    padding: 12px 18px;
    background: #f8faff;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #eef1ff;
  }
  .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: .6px; color: #94a3b8; font-weight: 700; margin-bottom: 3px; }
  .meta-value { font-size: 12px; font-weight: 600; color: var(--text-primary); }

  .req-card-footer {
    padding: 12px 18px;
    display: flex; gap: 8px;
    border-top: 1px solid #eef1ff;
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
  .card-btn.detail { background: rgba(37,99,235,0.08); color: var(--primary); }
  .card-btn.detail:hover { background: rgba(37,99,235,0.15); }
  .card-btn.cancel { background: rgba(239,68,68,0.08); color: var(--danger); }
  .card-btn.cancel:hover { background: rgba(239,68,68,0.15); }

  /* ===================== ANIMATIONS ===================== */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }

  /* ===================== MOBILE BOTTOM TAB ===================== */
  .mobile-tabs {
    display: none;
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--card-bg);
    border-top: 1px solid var(--border);
    padding: 8px 0 env(safe-area-inset-bottom, 8px);
    z-index: 100;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.08);
  }
  .mobile-tabs-inner { display: flex; justify-content: space-around; }
  .mobile-tab {
    display: flex; flex-direction: column; align-items: center; gap: 3px;
    padding: 6px 16px;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 10px; font-weight: 600;
    transition: all .2s;
    text-decoration: none;
    border: none; background: none; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .mobile-tab i { font-size: 18px; }
  .mobile-tab.active { color: var(--primary); }

  /* ===================== SCROLLBAR ===================== */
  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

  /* ===================== RESPONSIVE ===================== */

  /* Large desktop */
  @media (max-width: 1280px) {
    .content-grid { grid-template-columns: 1fr 1.2fr; gap: 20px; }
  }

  /* Tablet landscape */
  @media (max-width: 1024px) {
    :root { --sidebar-width: 220px; }
    .main { padding: 0 24px 40px; }
    .content-grid { grid-template-columns: 1fr; gap: 20px; }
    .form-card { position: static; }
    .topbar-title { font-size: 18px; }
  }

  /* Tablet portrait / small tablet */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-100%);
    }
    .sidebar.open {
      transform: translateX(0);
    }
    .sidebar-close { display: flex; }
    .hamburger { display: flex; }
    .main { margin-left: 0; padding: 0 16px 100px; width: 100%; }
    .topbar { padding: 14px 0 18px; }
    .topbar-title { font-size: 17px; }
    .breadcrumb { font-size: 12px; }
    .form-body { padding: 20px 18px; }
    .form-header { padding: 20px 18px 16px; }
    .req-list { padding: 16px 18px; }
    .history-header { padding: 18px 18px 14px; }
    .content-grid { gap: 16px; }
    .mobile-tabs { display: block; }
  }

  /* Mobile */
  @media (max-width: 480px) {
    .main { padding: 0 12px 100px; }
    .topbar { padding: 12px 0 14px; }
    .topbar-title { font-size: 15px; }
    .breadcrumb { display: none; }
    .input-row { grid-template-columns: 1fr; gap: 0; }
    .input-row .form-group { margin-bottom: 18px; }
    .form-body { padding: 16px 14px; }
    .form-header { padding: 18px 14px 14px; }
    .form-header-title { font-size: 16px; }
    .req-list { padding: 12px 14px; gap: 12px; }
    .history-header { padding: 14px 14px 12px; }
    .req-card-meta { grid-template-columns: 1fr; }
    .filter-tabs { gap: 4px; }
    .filter-tab { padding: 4px 9px; font-size: 10px; }
    .submit-btn { font-size: 13px; }
    .form-group { margin-bottom: 14px; }
    .form-input, .form-select, .form-textarea { font-size: 14px; padding: 12px 14px; }
  }

  /* Very small mobile */
  @media (max-width: 360px) {
    .main { padding: 0 10px 100px; }
    .history-title { font-size: 14px; }
  }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div>
        <div class="breadcrumb">
          <a href="#" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a>
          <i class="fas fa-chevron-right" style="font-size:10px"></i>
          <span>Peminjaman Aset</span>
        </div>
        <div class="topbar-title">Peminjaman Gedung</div>
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
        <div class="form-header-icon"><i class="fas fa-building"></i></div>
        <div class="form-header-title">Buat Permintaan</div>
        <div class="form-header-sub">Isi formulir peminjaman Gedung di bawah ini</div>
      </div>
      <div class="form-body">
        <div class="form-group">
          <div class="form-label"><i class="fas fa-user"></i> Nama Lengkap <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Masukkan nama lengkap Anda" id="namaInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-id-card"></i> NIP / NIK <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Masukkan NIP/NIK Anda" id="NIPNIKInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-building-columns"></i> Instansi / Lembaga <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Nama instansi atau lembaga" id="instansiInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-location-dot"></i> Kabupaten / Kota <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Masukkan Kab/Kota Anda" id="kabKotaInput">
        </div>
        <div class="form-group">
          <div class="form-label">
            <i class="fas fa-warehouse"></i> Fasilitas <span class="req">*</span>
          </div>
      
          <!-- Filter Kategori -->
          <div style="margin-bottom:12px">
            <select class="form-select" style="font-size:12px;padding:6px 12px" id="kategoriFilter">
              <option value="">Semua Kategori</option>
              @foreach(\App\Models\Gedung::kategoriOptions() as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
              @endforeach
            </select>
          </div>

          <select class="form-select" id="fasilitasSelect">
            <option value="">-- Pilih Fasilitas yang Tersedia --</option>
            @foreach($gedungs as $kategori => $items)
              <optgroup label="{{ ucwords(str_replace('_', ' ', $kategori)) }}">
                @foreach($items as $gedung)
                  <option 
                    value="{{ $gedung->id }}" 
                    data-kategori="{{ $gedung->kategori }}"
                    data-tarif="{{ $gedung->tarif_sewa }}"
                    data-kapasitas="{{ $gedung->kapasitas }}"
                    data-lokasi="{{ $gedung->lokasi }}"
                    data-icon="{{ $gedung->icon }}"
                  >
                    {{ $gedung->nama_gedung }} - {{ $gedung->lokasi }} ({{ $gedung->kapasitas }} Orang)
                  </option>
                @endforeach
              </optgroup>
            @endforeach
          </select>

          <!-- FACILITY PREVIEW ENHANCED -->
          <div class="facility-preview" id="facilityPreview">
            <div class="fp-icon" id="fpIconBox">
              <i class="fas fa-building" id="fpIcon"></i>
            </div>
            <div style="flex:1;min-width:0">
              <div class="fp-name" id="fpName"></div>
              <div class="fp-details" style="gap:8px;align-items:center">
                <span class="fp-tag" id="fpCap"></span>
                <span class="fp-tag" id="fpLokasi" style="background:rgba(6,182,212,0.1);color:var(--accent)"></span>
                <span class="fp-tag bg-success" id="fpStatus" style="background:rgba(16,185,129,0.2) !important;color:var(--success) !important">
                  <i class="fas fa-check-circle" style="font-size:9px"></i> Tersedia
                </span>
                <span class="fp-tag" id="fpPrice"></span>
              </div>
            </div>
            <img id="fpFoto" src="" 
                style="width:48px;height:48px;border-radius:10px;object-fit:cover;display:none"
                alt="Foto Fasilitas">
          </div>

             <!-- Counter fasilitas tersedia -->
          <div class="form-hint" id="fasilitasCounter" style="display:none">
            <i class="fas fa-info-circle"></i>
            <span>10 fasilitas tersedia dari 15 total</span>
          </div>
       </div>

        <div class="input-row">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar"></i> Tgl Pinjam <span class="req">*</span></div>
            <input type="date" class="form-input" id="tglPinjam">
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar-check"></i> Tgl Kembali <span class="req">*</span></div>
            <input type="date" class="form-input" id="tglKembali">
          </div>
        </div>

        <div class="input-row">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-clock"></i> Jam Mulai <span class="req">*</span></div>
            <input type="time" class="form-input" id="jamMulaiInput">
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-clock"></i> Jam Selesai <span class="req">*</span></div>
            <input type="time" class="form-input" id="jamSelesaiInput">
          </div>
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-sack-dollar"></i> Total Pembayaran <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Rp 0" id="totalPembayaran" oninput="formatRupiah(this)">
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-bullseye"></i> Tujuan Penggunaan <span class="req">*</span></div>
          <textarea class="form-textarea" placeholder="Jelaskan tujuan peminjaman secara singkat dan jelas..."></textarea>
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-phone"></i> Nomor Kontak <span class="req">*</span></div>
          <input type="tel" class="form-input" placeholder="Contoh: 0812-3456-7890">
        </div>

        <div class="form-group">
          <div class="form-label"><i class="fas fa-file-upload"></i> Upload Surat <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-secondary)">(opsional)</span></div>
          <div class="file-input-wrapper" onclick="document.getElementById('suratFile').click()">
            <label class="file-input-label">
              <input type="file" id="suratFile" name="surat" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="onFileChange(this)">
              <i class="fas fa-cloud-arrow-up"></i>
              <strong id="fileLabel">Klik untuk unggah file</strong>
              <span>PDF, DOC, JPG, PNG (Maks. 5MB)</span>
            </label>
          </div>
        </div>

        <button class="submit-btn submit-peminjaman">
          <i class="fas fa-paper-plane"></i> Kirim Permintaan
        </button>
      </div>
    </div>

    <!-- RIWAYAT -->
    <div>
      <div class="history-card animate d3">
        <div class="history-header">
          <div class="history-title"><i class="fas fa-clock-rotate-left"></i> Riwayat Permintaan</div>
          <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">Semua</button>
            <button class="filter-tab" data-filter="pending">Pending</button>
            <button class="filter-tab" data-filter="approved">Disetujui</button>
            <button class="filter-tab" data-filter="rejected">Ditolak</button>
          </div>
        </div>
        <div class="req-list" id="riwayatList">
          @forelse($riwayat as $item)
            @php
              $statusMap = [
                'pending' => ['pending', 'Menunggu'],
                'dalam_review' => ['pending', 'Dalam Review'],
                'disetujui_kasubag' => ['approved', 'Disetujui Kasubag'],
                'disetujui' => ['approved', 'Disetujui'],
                'ditolak' => ['rejected', 'Ditolak']
              ];
              $status = $statusMap[$item['status']] ?? ['pending', 'Pending'];
              $iconMap = [
                'aula' => 'fa-chalkboard-user',
                'vip' => 'fa-people-group', 
                'lab' => 'fa-desktop',
                'pelatihan' => 'fa-book-open',
                'olamita1' => 'fa-utensils',
                'olamita2' => 'fa-utensils',
                'asrama123' => 'fa-house',
                'asrama4' => 'fa-house-user',
                'mess1' => 'fa-bed',
                'mess2' => 'fa-bed'
              ];
            @endphp
            <div class="req-card" data-status="{{ $status[0] }}">
              <div class="req-card-top">
                <div style="display:flex;align-items:center;gap:12px;min-width:0">
                  <div class="req-card-icon" style="background:rgba(37,99,235,0.1);color:#2563eb">
                    <i class="fas {{ $iconMap[$item['fasilitas']] ?? 'fa-building' }}"></i>
                  </div>
                  <div style="min-width:0;flex:1">
                    <div class="req-card-name">{{ $item['nama_fasilitas'] }}</div>
                    <div class="req-card-code">{{ $item['kode'] }}</div>
                  </div>
                </div>
                <div class="status-badge {{ $status[0] }}">
                  <i class="fas fa-circle"></i> {{ $status[1] }}
                </div>
              </div>
              <div class="req-card-meta">
                <div>
                  <div class="meta-label">Instansi</div>
                  <div class="meta-value">{{ $item['instansi_lembaga'] }}</div>
                </div>
                <div>
                  <div class="meta-label">Tujuan</div>
                  <div class="meta-value">{{ $item['tujuan_penggunaan'] }}</div>
                </div>
                <div>
                  <div class="meta-label">Tgl Permintaan</div>
                  <div class="meta-value">{{ $item['created_at'] }}</div>
                </div>
                <div>
                  <div class="meta-label">Tgl Pinjam</div>
                  <div class="meta-value">{{ $item['range_tanggal'] }}</div>
                </div>
                @if($item['status_pembayaran'] === 'lunas')
                <div>
                  <div class="meta-label">Pembayaran</div>
                  <div class="meta-value" style="color:var(--success)">✅ Lunas</div>
                </div>
                @endif
              </div>
              <div class="req-card-footer">
                  <button class="card-btn detail" onclick="showDetail({{ $item['id'] }})">
                      <i class="fas fa-eye"></i> Detail
                  </button>
                  @if(in_array($item['status'], ['pending', 'dalam_review']))
                  <button class="card-btn cancel" onclick="cancelRequest({{ $item['id'] }})">
                      <i class="fas fa-xmark"></i> Batalkan
                  </button>
                  @endif
              </div>
            </div>
          @empty
            <div style="padding:40px 0;text-align:center;color:var(--text-secondary)">
              <i class="fas fa-clock-rotate-left" style="font-size:48px;opacity:0.3;margin-bottom:12px;display:block"></i>
              <div style="font-size:16px;font-weight:600;margin-bottom:4px">Belum ada riwayat</div>
              <div style="font-size:13px">Buat permintaan peminjaman pertama Anda</div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</main>

<!-- MOBILE BOTTOM TABS -->
<nav class="mobile-tabs">
  <div class="mobile-tabs-inner">
    <a href="#" class="mobile-tab"><i class="fas fa-gauge-high"></i>Dashboard</a>
    <button class="mobile-tab active" onclick="scrollToForm()"><i class="fas fa-file-pen"></i>Formulir</button>
    <button class="mobile-tab" onclick="scrollToHistory()"><i class="fas fa-clock-rotate-left"></i>Riwayat</button>
    <a href="#" class="mobile-tab"><i class="fas fa-user-circle"></i>Profil</a>
  </div>
</nav>

<!-- DETAIL MODAL -->
<div id="detailModal" style="
  position:fixed; inset:0; background:rgba(0,0,0,0.5); 
  display:none; align-items:center; justify-content:center; z-index:300;
  backdrop-filter:blur(4px);
">
  <div style="
    background:#fff; border-radius:20px; width:560px; max-width:92vw; 
    max-height:85vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.2);
    animation: modalIn .3s ease;
  ">
    <!-- Modal Header -->
    <div style="
      padding:24px 28px 20px; 
      background:linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
      border-radius:20px 20px 0 0;
      position:relative; overflow:hidden;
    ">
      <div style="position:absolute;right:-20px;top:-20px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,0.08)"></div>
      <div style="display:flex;align-items:center;justify-content:space-between;position:relative;z-index:1">
        <div>
          <div style="font-family:'Space Grotesk',sans-serif;font-size:18px;font-weight:700;color:#fff">📋 Detail Peminjaman</div>
          <div id="detailKode" style="font-size:12px;color:rgba(255,255,255,0.7);margin-top:4px"></div>
        </div>
        <button onclick="closeDetailModal()" style="
          width:32px;height:32px;border-radius:8px;border:none;
          background:rgba(255,255,255,0.2);color:#fff;font-size:16px;
          cursor:pointer;display:grid;place-items:center;
        ">✕</button>
      </div>
    </div>

    <!-- Modal Body -->
    <div style="padding:24px 28px" id="detailBody">
      <!-- Loading state -->
      <div id="detailLoading" style="text-align:center;padding:40px 0;color:var(--text-secondary)">
        <i class="fas fa-spinner fa-spin" style="font-size:32px;opacity:0.4;display:block;margin-bottom:12px"></i>
        <div style="font-size:14px">Memuat detail...</div>
      </div>

      <!-- Content (hidden by default) -->
      <div id="detailContent" style="display:none">
        <!-- Status Badge -->
        <div style="text-align:center;margin-bottom:20px">
          <span id="detailStatusBadge" class="status-badge" style="font-size:13px;padding:6px 16px"></span>
        </div>

        <!-- Data Peminjam -->
        <div style="margin-bottom:20px">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-secondary);margin-bottom:10px;display:flex;align-items:center;gap:6px">
            <i class="fas fa-user" style="color:var(--primary);font-size:10px"></i> Data Peminjam
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Nama</div>
              <div id="detailNama" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">NIP/NIK</div>
              <div id="detailNipNik" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Instansi</div>
              <div id="detailInstansi" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Kab/Kota</div>
              <div id="detailKabKota" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
          </div>
        </div>

        <!-- Data Fasilitas -->
        <div style="margin-bottom:20px">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-secondary);margin-bottom:10px;display:flex;align-items:center;gap:6px">
            <i class="fas fa-building" style="color:var(--accent);font-size:10px"></i> Data Fasilitas
          </div>
          <div style="background:linear-gradient(135deg,#eff4ff,#f0fdff);padding:14px;border-radius:12px;border:1px solid #c7d7ff">
            <div id="detailFasilitas" style="font-size:15px;font-weight:700;color:var(--text-primary)"></div>
            <div style="display:flex;gap:8px;margin-top:6px;flex-wrap:wrap">
              <span id="detailKategori" style="font-size:10px;background:rgba(37,99,235,0.1);color:var(--primary);padding:2px 8px;border-radius:5px;font-weight:600"></span>
              <span id="detailLokasi" style="font-size:10px;background:rgba(6,182,212,0.1);color:var(--accent);padding:2px 8px;border-radius:5px;font-weight:600"></span>
            </div>
          </div>
        </div>

        <!-- Waktu Peminjaman -->
        <div style="margin-bottom:20px">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-secondary);margin-bottom:10px;display:flex;align-items:center;gap:6px">
            <i class="fas fa-calendar" style="color:var(--warning);font-size:10px"></i> Waktu Peminjaman
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Tgl Pinjam</div>
              <div id="detailTglPinjam" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Tgl Kembali</div>
              <div id="detailTglKembali" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Jam</div>
              <div id="detailJam" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Durasi</div>
              <div id="detailDurasi" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
          </div>
        </div>

        <!-- Pembayaran -->
        <div style="margin-bottom:20px">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-secondary);margin-bottom:10px;display:flex;align-items:center;gap:6px">
            <i class="fas fa-money-bill" style="color:var(--success);font-size:10px"></i> Pembayaran
          </div>
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px">
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Tarif/Hari</div>
              <div id="detailTarif" style="font-size:13px;font-weight:600;margin-top:3px;color:var(--primary)"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Total</div>
              <div id="detailTotal" style="font-size:13px;font-weight:700;margin-top:3px;color:var(--success)"></div>
            </div>
            <div style="background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">Cara Bayar</div>
              <div id="detailCaraBayar" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
          </div>
        </div>

        <!-- Tujuan -->
        <div style="margin-bottom:20px">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-secondary);margin-bottom:10px;display:flex;align-items:center;gap:6px">
            <i class="fas fa-bullseye" style="color:var(--danger);font-size:10px"></i> Tujuan Penggunaan
          </div>
          <div id="detailTujuan" style="background:#f8faff;padding:12px 14px;border-radius:10px;font-size:13px;line-height:1.6;color:var(--text-primary)"></div>
        </div>

        <!-- Kontak -->
        <div style="margin-bottom:20px">
          <div style="display:flex;gap:10px">
            <div style="flex:1;background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">📞 Kontak</div>
              <div id="detailKontak" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
            <div style="flex:1;background:#f8faff;padding:10px 14px;border-radius:10px">
              <div style="font-size:10px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.5px">📅 Tgl Pengajuan</div>
              <div id="detailCreatedAt" style="font-size:13px;font-weight:600;margin-top:3px"></div>
            </div>
          </div>
        </div>

        <!-- Komentar Admin (jika ada) -->
        <div id="detailKomentarWrap" style="margin-bottom:20px;display:none">
          <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--text-secondary);margin-bottom:10px;display:flex;align-items:center;gap:6px">
            <i class="fas fa-comment" style="color:var(--accent2);font-size:10px"></i> Komentar Admin
          </div>
          <div id="detailKomentar" style="background:#fef3c7;padding:12px 14px;border-radius:10px;font-size:13px;line-height:1.6;color:#92400e;border:1px solid #fcd34d"></div>
        </div>

        <!-- Surat Download (jika ada) -->
        <div id="detailSuratWrap" style="margin-bottom:16px;display:none">
          <a id="detailSuratLink" href="#" target="_blank" style="
            display:flex;align-items:center;gap:8px;
            padding:12px 16px;border-radius:10px;
            background:rgba(37,99,235,0.05);border:1px solid rgba(37,99,235,0.15);
            color:var(--primary);font-size:13px;font-weight:600;text-decoration:none;
            transition:all .2s;
          ">
            <i class="fas fa-file-download"></i> Download Surat Peminjaman
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  @keyframes modalIn {
    from { opacity:0; transform:scale(0.95) translateY(10px); }
    to { opacity:1; transform:scale(1) translateY(0); }
  }
</style>

<!-- TOAST -->
<div id="toast" style="
  position:fixed; bottom:80px; right:20px;
  background:#0f172a; color:#fff;
  padding:14px 20px; border-radius:12px;
  font-size:13px; font-weight:600;
  display:flex; align-items:center; gap:10px;
  transform:translateY(80px); opacity:0;
  transition:all .35s cubic-bezier(.4,0,.2,1);
  z-index:9999; box-shadow:0 8px 24px rgba(0,0,0,0.25);
  pointer-events:none; max-width:calc(100vw - 40px);
">
  <i class="fas fa-circle-check" style="color:#10b981;font-size:16px;flex-shrink:0"></i>
  <span id="toastMsg">Permintaan berhasil dikirim!</span>
</div>



<script>
  $(document).ready(function() {
      // Disable Tailwind CDN warning
      if (window.tailwindCSSLoaded) console.warn = () => {};

      // Data dari PHP
      window.fasilitasData = @json($fasilitasData ?? []);
      window.gedungs = @json($gedungs ?? collect());

      console.log('Fasilitas loaded:', Object.keys(window.fasilitasData).length);

      // 1. Filter kategori
      $('#kategoriFilter').on('change', filterFasilitas);
      
      // 2. Fasilitas preview
      $('#fasilitasSelect').on('change', function() {
          showFacilityPreview($(this).val());
          calculateTotal();
      });

      // 3. Submit form
      $(document).on('click', '.submit-peminjaman', function(e) {
          e.preventDefault();
          submitForm();
      });

      // 4. Date & time change
      $('#tglPinjam, #tglKembali').on('change', calculateTotal);

      // 5. File upload
      $('#suratFile').on('change', handleFileUpload);

      // 6. Filter tabs riwayat
      $('.filter-tab').on('click', function() {
          $('.filter-tab').removeClass('active');
          $(this).addClass('active');
          const filter = $(this).data('filter') || $(this).attr('data-filter');
          $('.req-card').each(function() {
              if (filter === 'all' || $(this).data('status') === filter) {
                  $(this).slideDown(300);
              } else {
                  $(this).slideUp(300);
              }
          });
      });

      // 7. FUNGSI DETAIL - Buka modal dengan AJAX
      window.showDetail = function(id) {
        // Show modal with loading
        $('#detailModal').css('display', 'flex');
        $('#detailLoading').show();
        $('#detailContent').hide();

        $.ajax({
          url: `/tamu/peminjaman-gedung/${id}`,
          method: 'GET',
          headers: { 'Accept': 'application/json' },
          success: function(res) {
            if (res.success && res.data) {
              const d = res.data;

              // Kode
              $('#detailKode').text(d.kode);

              // Status badge
              const statusClass = {
                'pending': 'pending', 'dalam_review': 'pending',
                'disetujui_kasubag': 'approved', 'disetujui': 'approved',
                'ditolak': 'rejected'
              };
              const statusIcon = {
                'pending': 'fa-clock', 'dalam_review': 'fa-hourglass-half',
                'disetujui_kasubag': 'fa-check', 'disetujui': 'fa-check-double',
                'ditolak': 'fa-times'
              };
              $('#detailStatusBadge')
                .removeClass('pending approved rejected')
                .addClass(statusClass[d.status] || 'pending')
                .html(`<i class="fas ${statusIcon[d.status] || 'fa-circle'}"></i> ${d.status_label}`);

              // Data peminjam
              $('#detailNama').text(d.nama_lengkap);
              $('#detailNipNik').text(d.nip_nik);
              $('#detailInstansi').text(d.instansi_lembaga);
              $('#detailKabKota').text(d.kabupaten_kota);

              // Fasilitas
              $('#detailFasilitas').text(d.nama_fasilitas);
              $('#detailKategori').text(d.fasilitas ? d.fasilitas.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : '-');
              $('#detailLokasi').text(d.lokasi);

              // Waktu
              $('#detailTglPinjam').text(d.tanggal_pinjam);
              $('#detailTglKembali').text(d.tanggal_kembali);
              $('#detailJam').text(d.jam_mulai + ' - ' + d.jam_selesai);
              $('#detailDurasi').text(d.lama_peminjaman_hari + ' hari');

              // Pembayaran
              $('#detailTarif').text(d.tarif_per_hari);
              $('#detailTotal').text(d.total_pembayaran);
              $('#detailCaraBayar').text(d.cara_pembayaran);

              // Tujuan & kontak
              $('#detailTujuan').text(d.tujuan_penggunaan);
              $('#detailKontak').text(d.nomor_kontak);
              $('#detailCreatedAt').text(d.created_at);

              // Komentar (jika ada)
              if (d.komentar) {
                $('#detailKomentar').text(d.komentar);
                $('#detailKomentarWrap').show();
              } else {
                $('#detailKomentarWrap').hide();
              }

              // Surat (jika ada)
              if (d.surat_url) {
                $('#detailSuratLink').attr('href', d.surat_url);
                $('#detailSuratWrap').show();
              } else {
                $('#detailSuratWrap').hide();
              }

              // Show content, hide loading
              $('#detailLoading').hide();
              $('#detailContent').show();
            } else {
              showToast('❌ Gagal memuat detail', 'error');
              closeDetailModal();
            }
          },
          error: function(xhr) {
            let msg = 'Gagal memuat detail peminjaman';
            try {
              if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
              }
            } catch(e) {}
            showToast('❌ ' + msg, 'error');
            closeDetailModal();
          }
        });
      };

      window.closeDetailModal = function() {
        $('#detailModal').fadeOut(200);
      };

      // Tutup modal saat klik overlay
      $('#detailModal').on('click', function(e) {
        if (e.target === this) closeDetailModal();
      });

        window.cancelRequest = function(id) {
          if (!confirm('Yakin ingin membatalkan permintaan ini?')) {
              return;
          }

          const btn = $(`button[onclick="cancelRequest(${id})"]`);
          const original = btn.html();
          btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Membatalkan...');

          $.ajax({
              url: `/tamu/peminjaman-gedung/${id}/cancel`,
              method: 'POST',
              data: {
                  _token: $('meta[name="csrf-token"]').attr('content')
              },
              success: function(res) {
                  showToast(res.message || 'Permintaan berhasil dibatalkan', 'success');
                  setTimeout(() => {
                      $(`.req-card[data-id="${id}"]`).fadeOut(500, function() {
                          $(this).remove();
                      });
                  }, 1000);
              },
              error: function(xhr) {
                  let msg = 'Gagal membatalkan permintaan';
                  try {
                      const res = xhr.responseJSON;
                      if (res && res.message) {
                          msg = res.message;
                      }
                  } catch(e) {}
                  showToast('❌ ' + msg, 'error');
              },
              complete: function() {
                  btn.prop('disabled', false).html(original);
              }
          });
      };

      // FUNCTIONS
      function filterFasilitas() {
          const kategori = $('#kategoriFilter').val();
          const options = $('#fasilitasSelect option:not([value=""])');
          
          options.each(function() {
              const optKategori = $(this).data('kategori');
              if (!kategori || optKategori === kategori) {
                  $(this).show();
              } else {
                  $(this).hide();
              }
          });
          updateCounter();
      }

      function showFacilityPreview(gedungId) {
          const preview = $('#facilityPreview');
          if (gedungId && window.fasilitasData[gedungId]) {
              const gedung = window.fasilitasData[gedungId];
              
              $('#fpName').text(gedung.nama);
              $('#fpCap').text(gedung.kapasitas);
              $('#fpLokasi').text(gedung.lokasi);
              $('#fpPrice').html('Rp ' + formatNumber(gedung.tarif) + '<small>/hari</small>');
              $('#fpIcon').removeClass().addClass('fas fa-' + gedung.icon);
              $('#fpLuas').text(gedung.luas + ' m²');
              $('#fpStatus').html('<i class="fas fa-check-circle" style="font-size:9px"></i> ' + gedung.ketersediaan);
              
              if (gedung.foto_url) {
                  $('#fpFoto').attr('src', gedung.foto_url).show();
              } else {
                  $('#fpFoto').hide();
              }
              
              preview.slideDown(300);
          } else {
              preview.slideUp(300);
              $('#totalPembayaran').val('');
          }
      }

      function calculateTotal() {
          const gedungId = $('#fasilitasSelect').val();
          const tglPinjam = $('#tglPinjam').val();
          const tglKembali = $('#tglKembali').val();
          
          if (gedungId && tglPinjam && tglKembali && window.fasilitasData[gedungId]) {
              const start = new Date(tglPinjam);
              const end = new Date(tglKembali);
              const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
              const tarif = window.fasilitasData[gedungId].tarif;
              const total = tarif * days;
              $('#totalPembayaran').val(formatRupiah(total));
          } else {
              $('#totalPembayaran').val('');
          }
      }

      function submitForm() {
          // Validasi
          const required = ['#namaInput', '#NIPNIKInput', '#instansiInput', '#kabKotaInput', '#fasilitasSelect', '#tglPinjam', '#tglKembali', '#jamMulaiInput', '#jamSelesaiInput', 'textarea', 'input[type="tel"]'];
          let valid = true;
          
          required.forEach(id => {
              const el = $(id);
              if (!el.val()?.trim()) {
                  valid = false;
                  el.css('border-color', '#ef4444');
              } else {
                  el.css('border-color', '');
              }
          });

          if (!valid) {
              showToast('❌ Lengkapi semua field wajib (*)', 'error');
              return;
          }

          const btn = $('.submit-peminjaman');
          const original = btn.html();
          btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');

          const formData = new FormData();
          formData.append('nama_lengkap', $('#namaInput').val().trim());
          formData.append('nip_nik', $('#NIPNIKInput').val().trim());
          formData.append('instansi_lembaga', $('#instansiInput').val().trim());
          formData.append('kabupaten_kota', $('#kabKotaInput').val().trim());
          formData.append('gedung_id', $('#fasilitasSelect').val());
          formData.append('tanggal_pinjam', $('#tglPinjam').val());
          formData.append('tanggal_kembali', $('#tglKembali').val());
          formData.append('jam_mulai', $('#jamMulaiInput').val());
          formData.append('jam_selesai', $('#jamSelesaiInput').val());
          formData.append('tujuan_penggunaan', $('textarea').val().trim());
          formData.append('nomor_kontak', $('input[type="tel"]').val().trim());

          if ($('#suratFile')[0].files[0]) {
              formData.append('surat_path', $('#suratFile')[0].files[0]);
          }

          $.ajax({
              url: '{{ route("tamu.peminjaman-gedung.store") }}',
              method: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                  'Accept': 'application/json'
              },
              success: function(res) {
                  showToast(res.message, 'success');
                  setTimeout(() => location.reload(), 2000);
              },
              error: function(xhr) {
                  let msg = 'Terjadi kesalahan server';
                  try {
                      const res = xhr.responseJSON;
                      if (res && res.errors) {
                          const firstError = Object.values(res.errors);
                          if (firstError.length > 0) {
                              msg = firstError[0][0];
                          }
                      } else if (res && res.message) {
                          msg = res.message;
                      }
                  } catch(e) {
                      console.error('Error parsing response:', e);
                  }
                  showToast('❌ ' + msg, 'error');
              },
              complete: function() {
                  btn.prop('disabled', false).html(original);
              }
          });
      }

      function handleFileUpload() {
          const file = this.files[0];
          const label = $('#fileLabel');
          if (file) {
              if (file.size > 5 * 1024 * 1024) {
                  showToast('❌ File maksimal 5MB', 'error');
                  this.value = '';
                  return;
              }
              label.text(file.name);
          } else {
              label.text('Klik untuk unggah file');
          }
      }

      function updateCounter() {
          const count = $('#fasilitasSelect option:not([value=""]):visible').length;
          $('#counterText').text(`${count} fasilitas tersedia`);
          $('#fasilitasCounter').toggle(count > 0);
      }

      function formatRupiah(num) {
          return 'Rp ' + parseInt(num).toLocaleString('id-ID');
      }

      function formatNumber(num) {
          return parseInt(num).toLocaleString('id-ID');
      }

      function showToast(msg, type = 'success') {
          const toast = $('#toast');
          $('#toastMsg').text(msg);
          const icon = toast.find('i');
          icon.removeClass().addClass(type === 'error' ? 'fas fa-exclamation-triangle' : 'fas fa-check-circle');
          icon.css('color', type === 'error' ? '#ef4444' : '#10b981');
          
          toast.css({ transform: 'translateY(0)', opacity: 1 });
          setTimeout(() => toast.css({ transform: 'translateY(80px)', opacity: 0 }), 4000);
      }

      // Mobile scroll
      window.scrollToForm = () => $('#formCard')[0].scrollIntoView({behavior:'smooth'});
      window.scrollToHistory = () => $('.history-card')[0].scrollIntoView({behavior:'smooth'});

      // Initial
      filterFasilitas();
      updateCounter();

  });
</script>
</body>
</html