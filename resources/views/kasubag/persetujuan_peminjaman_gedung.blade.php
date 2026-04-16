<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman Kendaraan - Dashboard Kasubag</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  :root {
    --blue: #3b6ff0; --blue-light: #eef2ff;
    --orange: #f59e0b; --orange-light: #fffbeb;
    --green: #10b981; --green-light: #ecfdf5;
    --red: #ef4444; --red-light: #fef2f2;
    --purple: #8b5cf6; --purple-light: #f5f3ff;
    --gray-50: #f8fafc; --gray-100: #f1f5f9;
    --gray-200: #e2e8f0; --gray-400: #94a3b8;
    --gray-600: #475569; --gray-800: #1e293b;
    --sidebar-w: 240px;
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); display: flex; min-height: 100vh; }
  .sidebar { width: var(--sidebar-w); background: #fff; border-right: 1px solid var(--gray-200); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 10; }
  .sidebar-brand { padding: 20px 20px 16px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 12px; }
  .brand-icon { width: 40px; height: 40px; background: var(--blue); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
  .brand-icon svg { width: 22px; height: 22px; fill: #fff; }
  .brand-text h2 { font-size: 14px; font-weight: 700; }
  .brand-text p { font-size: 11px; color: var(--gray-400); margin-top: 1px; }
  .nav { padding: 12px; flex: 1; }
  .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13.5px; font-weight: 500; color: var(--gray-600); cursor: pointer; text-decoration: none; transition: all .15s; margin-bottom: 2px; }
  .nav-item:hover { background: var(--gray-100); }
  .nav-item.active { background: var(--blue-light); color: var(--blue); font-weight: 600; }
  .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
  .nav-section-label { font-size: 11px; font-weight: 600; color: var(--gray-400); text-transform: uppercase; letter-spacing: .06em; padding: 12px 12px 6px; display: flex; align-items: center; justify-content: space-between; }
  .nav-section-label svg { width: 14px; height: 14px; }
  .badge { margin-left: auto; background: var(--orange-light); color: var(--orange); font-size: 11px; font-weight: 700; padding: 1px 7px; border-radius: 20px; }
  .topbar { position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 60px; background: #fff; border-bottom: 1px solid var(--gray-200); display: flex; align-items: center; justify-content: flex-end; padding: 0 28px; gap: 16px; z-index: 9; }
  .notif-btn { width: 38px; height: 38px; border-radius: 10px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; border: none; }
  .notif-btn svg { width: 18px; height: 18px; stroke: var(--gray-600); fill: none; stroke-width: 2; }
  .notif-badge { position: absolute; top: -4px; right: -4px; background: var(--red); color: #fff; font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }
  .user-chip { display: flex; align-items: center; gap: 10px; background: var(--gray-100); border-radius: 10px; padding: 6px 12px 6px 6px; }
  .user-avatar { width: 30px; height: 30px; background: var(--blue); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; }
  .user-info strong { font-size: 13px; font-weight: 600; display: block; }
  .user-info span { font-size: 11px; color: var(--gray-400); }
  .main { margin-left: var(--sidebar-w); margin-top: 60px; padding: 32px; flex: 1; }
  .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
  .page-header-icon { width: 48px; height: 48px; background: var(--purple-light); border-radius: 14px; display: flex; align-items: center; justify-content: center; }
  .page-header-icon svg { width: 24px; height: 24px; stroke: var(--purple); fill: none; stroke-width: 2; }
  .page-header-text h1 { font-size: 22px; font-weight: 700; }
  .page-header-text p { font-size: 13px; color: var(--gray-400); margin-top: 2px; }
  .section-label { display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; color: var(--orange); margin-bottom: 16px; }
  .section-label svg { width: 16px; height: 16px; stroke: var(--orange); fill: none; stroke-width: 2; }
  .req-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 20px 22px; margin-bottom: 14px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; transition: box-shadow .15s; }
  .req-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }
  .req-card.highlighted { border: 2px solid var(--blue); }
  .req-info { flex: 1; }
  .req-tags { display: flex; gap: 8px; margin-bottom: 8px; }
  .tag { font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 6px; }
  .tag.id { background: var(--gray-100); color: var(--gray-600); }
  .tag.pending { background: var(--orange-light); color: var(--orange); }
  .req-name { font-size: 17px; font-weight: 700; margin-bottom: 10px; }
  .req-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 32px; font-size: 12.5px; color: var(--gray-600); margin-bottom: 6px; }
  .req-meta span strong { color: var(--gray-800); }
  .req-purpose { font-size: 12.5px; color: var(--gray-600); }
  .req-purpose span { color: var(--gray-800); font-weight: 500; }
  .req-actions { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; flex-shrink: 0; }
  .btn { display: flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; }
  .btn-detail { background: var(--gray-100); color: var(--gray-600); }
  .btn-detail:hover { background: var(--gray-200); }
  .btn-detail svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }
  .btn-approve { background: var(--green-light); color: var(--green); }
  .btn-approve:hover { background: #bbf7d0; }
  .btn-approve svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; }
  .btn-reject { background: var(--red-light); color: var(--red); }
  .btn-reject:hover { background: #fecaca; }
  .btn-reject svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; }
</style>
</head>
<body>

@include('partials.sidebar')

<div class="topbar">
  <button class="notif-btn"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg><div class="notif-badge">8</div></button>
  <div class="user-chip"><div class="user-avatar">K</div><div class="user-info"><strong>Kasubag</strong><span>Kepala Sub Bagian</span></div></div>
</div>

<main class="main">
  <div class="page-header">
    <div class="page-header-icon"><svg viewBox="0 0 24 24"><path d="M5 17H3a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v9a2 2 0 0 1-2 2h-1"/><circle cx="7.5" cy="17.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg></div>
    <div class="page-header-text"><h1>Peminjaman Kendaraan</h1><p>2 permintaan menunggu verifikasi</p></div>
  </div>

  <div class="section-label"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Menunggu Verifikasi</div>

  <div class="req-card">
    <div class="req-info">
      <div class="req-tags"><span class="tag id">REQ002</span><span class="tag pending">Menunggu</span></div>
      <div class="req-name">Toyota Avanza (B 1234 CD)</div>
      <div class="req-meta">
        <span>Pemohon: <strong>Siti Rahmawati</strong></span>
        <span>Tanggal Ajuan: <strong>2024-12-11</strong></span>
        <span>Mulai: <strong>2024-12-18</strong></span>
        <span>Selesai: <strong>2024-12-18</strong></span>
      </div>
      <div class="req-purpose">Tujuan: <span>Kunjungan dinas ke Kantor Cabang Bogor</span></div>
    </div>
    <div class="req-actions">
      <button class="btn btn-detail"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Detail</button>
      <button class="btn btn-approve"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Setuju</button>
      <button class="btn btn-reject"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Tolak</button>
    </div>
  </div>

  <div class="req-card highlighted">
    <div class="req-info">
      <div class="req-tags"><span class="tag id">REQ006</span><span class="tag pending">Menunggu</span></div>
      <div class="req-name">Mitsubishi Pajero (B 5678 EF)</div>
      <div class="req-meta">
        <span>Pemohon: <strong>Rina Wijaya</strong></span>
        <span>Tanggal Ajuan: <strong>2024-12-13</strong></span>
        <span>Mulai: <strong>2024-12-22</strong></span>
        <span>Selesai: <strong>2024-12-23</strong></span>
      </div>
      <div class="req-purpose">Tujuan: <span>Pengiriman dokumen ke Kantor Pusat Jakarta</span></div>
    </div>
    <div class="req-actions">
      <button class="btn btn-detail"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg> Detail</button>
      <button class="btn btn-approve"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Setuju</button>
      <button class="btn btn-reject"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Tolak</button>
    </div>
  </div>
</main>

</body>
</html>