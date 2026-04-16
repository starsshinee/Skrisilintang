<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Admin Sarana Prasarana</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --primary: #4361ee;
    --primary-light: #eef0fd;
    --success: #2ec4b6;
    --success-light: #e8faf9;
    --warning: #f4a261;
    --warning-light: #fff4ec;
    --danger: #e63946;
    --danger-light: #fdecea;
    --sidebar-bg: #fff;
    --body-bg: #f0f2f9;
    --text-primary: #1a1f36;
    --text-secondary: #6b7280;
    --border: #e5e7eb;
    --card-bg: #fff;
    --sidebar-width: 240px;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--body-bg); color: var(--text-primary); display: flex; min-height: 100vh; }

  /* Sidebar */
  .sidebar {
    width: var(--sidebar-width);
    background: var(--sidebar-bg);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 100;
  }
  .sidebar-brand {
    display: flex; align-items: center; gap: 12px;
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--border);
  }
  .brand-icon {
    width: 44px; height: 44px; background: var(--primary);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
  }
  .brand-icon svg { color: #fff; }
  .brand-text { line-height: 1.2; }
  .brand-text strong { font-size: 13px; font-weight: 700; color: var(--text-primary); display: block; }
  .brand-text span { font-size: 11px; color: var(--text-secondary); }
  .nav { flex: 1; padding: 16px 12px; display: flex; flex-direction: column; gap: 4px; }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    font-size: 14px; font-weight: 500; color: var(--text-secondary);
    cursor: pointer; transition: all .2s; text-decoration: none;
  }
  .nav-item:hover { background: var(--primary-light); color: var(--primary); }
  .nav-item.active { background: var(--primary-light); color: var(--primary); font-weight: 600; }
  .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
  .sidebar-user {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 20px; border-top: 1px solid var(--border);
  }
  .user-avatar {
    width: 36px; height: 36px; background: var(--primary);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; color: #fff;
  }
  .user-info strong { font-size: 13px; font-weight: 700; display: block; }
  .user-info span { font-size: 11px; color: var(--text-secondary); }

  /* Main */
  .main { margin-left: var(--sidebar-width); flex: 1; display: flex; flex-direction: column; }
  .topbar {
    background: var(--card-bg); border-bottom: 1px solid var(--border);
    padding: 14px 28px; display: flex; justify-content: flex-end; align-items: center;
    position: sticky; top: 0; z-index: 50;
  }
  .notif-btn {
    position: relative; width: 38px; height: 38px;
    border-radius: 50%; background: var(--body-bg);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; border: 1px solid var(--border);
  }
  .notif-badge {
    position: absolute; top: 4px; right: 4px;
    width: 8px; height: 8px; background: var(--danger);
    border-radius: 50%; border: 2px solid #fff;
  }
  .content { padding: 24px 28px; flex: 1; }

   /* ── MAIN CONTENT ── */
  .main { margin-left: 260px; flex: 1; padding: 0 32px 32px; }

  /* TOP BAR */
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
  }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-primary); }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .topbar-date {
    font-size: 13px; color: var(--text-secondary); font-weight: 500;
    background: var(--card-bg);
    border: 1px solid var(--border);
    padding: 8px 14px; border-radius: 10px;
    display: flex; align-items: center; gap: 6px;
  }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    display: grid; place-items: center;
    cursor: pointer; position: relative;
    color: var(--text-secondary);
    transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot {
    position: absolute; top: 8px; right: 8px;
    width: 7px; height: 7px;
    background: var(--danger);
    border-radius: 50%;
    border: 1.5px solid var(--card-bg);
  }

  /* HERO BANNER */
  .hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0891b2 100%);
    border-radius: 20px;
    padding: 32px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
    box-shadow: 0 8px 32px rgba(37,99,235,0.28);
  }
  .hero::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  }
  .hero-blob {
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
    right: -60px; top: -80px;
    pointer-events: none;
  }
  .hero-blob2 {
    position: absolute;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    right: 120px; bottom: -60px;
    pointer-events: none;
  }
  .hero-left { position: relative; z-index: 2; }
  .hero-greeting { font-size: 13px; color: rgba(255,255,255,0.7); font-weight: 500; margin-bottom: 6px; letter-spacing: .5px; }
  .hero-title { font-family: 'Space Grotesk', sans-serif; font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 8px; }
  .hero-sub { font-size: 14px; color: rgba(255,255,255,0.75); max-width: 380px; line-height: 1.6; }
  .hero-right { position: relative; z-index: 2; text-align: right; }
  .hero-inst { font-size: 12px; color: rgba(255,255,255,0.65); margin-bottom: 4px; }
  .hero-nip { font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 600; margin-bottom: 14px; }
  .hero-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,0.18);
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(255,255,255,0.25);
    color: #fff; font-size: 13px; font-weight: 600;
    padding: 10px 20px; border-radius: 10px;
    cursor: pointer; transition: all .2s;
    text-decoration: none;
  }
  .hero-btn:hover { background: rgba(255,255,255,0.28); }

  /* Stat Cards */
  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
  .stat-card {
    background: var(--card-bg); border-radius: 16px;
    padding: 20px; border: 1px solid var(--border);
    position: relative; overflow: hidden;
  }
  .stat-icon {
    width: 44px; height: 44px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
  }
  .stat-card .badge {
    position: absolute; top: 16px; right: 16px;
    font-size: 11px; font-weight: 700; padding: 2px 8px;
    border-radius: 20px;
  }
  .badge-blue { background: #e0e7ff; color: var(--primary); }
  .badge-green { background: var(--success-light); color: var(--success); }
  .stat-value { font-size: 32px; font-weight: 800; color: var(--text-primary); line-height: 1; margin-bottom: 4px; }
  .stat-label { font-size: 13px; color: var(--text-secondary); font-weight: 500; }

  /* Grid bottom */
  .bottom-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; margin-bottom: 24px; }

  /* Chart Card */
  .card {
    background: var(--card-bg); border-radius: 16px;
    border: 1px solid var(--border); padding: 24px;
  }
  .card-title { font-size: 15px; font-weight: 700; margin-bottom: 20px; color: var(--text-primary); }

  /* Bar Chart */
  .chart-wrap { display: flex; align-items: flex-end; gap: 6px; height: 180px; }
  .bar-group { display: flex; flex-direction: column; align-items: center; gap: 6px; flex: 1; }
  .bar {
    width: 100%; border-radius: 6px 6px 0 0;
    background: linear-gradient(180deg, #4361ee 0%, #3a0ca3 100%);
    transition: opacity .2s;
    cursor: pointer;
  }
  .bar:hover { opacity: 0.8; }
  .bar-label { font-size: 11px; color: var(--text-secondary); font-weight: 500; }

  /* Activity */
  .activity-list { display: flex; flex-direction: column; gap: 12px; }
  .activity-item { display: flex; align-items: flex-start; gap: 12px; }
  .act-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .act-text { flex: 1; }
  .act-text p { font-size: 13px; font-weight: 600; color: var(--text-primary); }
  .act-text span { font-size: 11px; color: var(--text-secondary); }

  /* Table */
  .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
  .see-all { font-size: 13px; color: var(--primary); font-weight: 600; cursor: pointer; text-decoration: none; }
  table { width: 100%; border-collapse: collapse; }
  thead th {
    font-size: 12px; font-weight: 600; color: var(--text-secondary);
    padding: 8px 12px; text-align: left; border-bottom: 1px solid var(--border);
    text-transform: uppercase; letter-spacing: .05em;
  }
  tbody td { padding: 14px 12px; font-size: 13px; border-bottom: 1px solid var(--border); }
  tbody tr:last-child td { border-bottom: none; }
  .status-badge {
    display: inline-flex; padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
  }
  .status-approved { background: var(--success-light); color: var(--success); }
  .status-pending { background: var(--warning-light); color: var(--warning); }
  .status-rejected { background: var(--danger-light); color: var(--danger); }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-title">Dashboard Admin Sarpras</div>
    <div class="topbar-right">
      <div class="topbar-date">
        <i class="fas fa-calendar" style="color:var(--primary)"></i>
        Rabu, 15 April 2026
      </div>
      <div class="notif-btn">
        <i class="fas fa-bell"></i>
        <div class="notif-dot"></div>
      </div>
    </div>
  </div>

  <!-- HERO BANNER -->
  <div class="hero animate d1">
    <div class="hero-blob"></div>
    <div class="hero-blob2"></div>
    <div class="hero-left">
      <div class="hero-greeting">👋 Selamat datang kembali!</div>
      <div class="hero-title">Halo, Admin Sarana dan Prasarana!</div>
      <div class="hero-sub" font-weight="500">
        Sebagai Admin Sarana dan Prasarana, Anda dapat mengelola data gedung, ruangan, dan peminjaman fasilitas di BPMP Provinsi Gorontalo.
      </div>
    </div>
    <div class="hero-right">
      <div class="hero-inst">Instansi: BPMP Provinsi Gorontalo</div>
      <div class="hero-nip">NIP: 0983654321</div>
      <a href="{{ route('adminsarpras.pengaturan-akun') }}" class="hero-btn">
        <i class="fas fa-gear"></i> Pengaturan Akun
      </a>
    </div>
  </div>
    <!-- Stats -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon" style="background:#eef0fd">
          <svg width="22" height="22" fill="none" stroke="#4361ee" viewBox="0 0 24 24" stroke-width="2"><path d="M3 21h18M5 21V7l7-4 7 4v14"/></svg>
        </div>
        <div class="badge badge-blue">+2</div>
        <div class="stat-value">24</div>
        <div class="stat-label">Total Gedung</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff4ec">
          <svg width="22" height="22" fill="none" stroke="#f4a261" viewBox="0 0 24 24" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <div class="badge badge-green">+5</div>
        <div class="stat-value">148</div>
        <div class="stat-label">Total Ruangan</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#e8faf9">
          <svg width="22" height="22" fill="none" stroke="#2ec4b6" viewBox="0 0 24 24" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
        </div>
        <div class="stat-value">67</div>
        <div class="stat-label">Peminjaman Aktif</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#fdecea">
          <svg width="22" height="22" fill="none" stroke="#e63946" viewBox="0 0 24 24" stroke-width="2"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div class="stat-value">12</div>
        <div class="stat-label">Perlu Perbaikan</div>
      </div>
    </div>

    <!-- Chart + Activity -->
    <div class="bottom-grid">
      <div class="card">
        <div class="card-title">Statistik Peminjaman Bulanan</div>
        <div class="chart-wrap">
          <div class="bar-group"><div class="bar" style="height:60%"></div><span class="bar-label">Jan</span></div>
          <div class="bar-group"><div class="bar" style="height:45%"></div><span class="bar-label">Feb</span></div>
          <div class="bar-group"><div class="bar" style="height:75%"></div><span class="bar-label">Mar</span></div>
          <div class="bar-group"><div class="bar" style="height:65%"></div><span class="bar-label">Apr</span></div>
          <div class="bar-group"><div class="bar" style="height:70%"></div><span class="bar-label">Mei</span></div>
          <div class="bar-group"><div class="bar" style="height:85%"></div><span class="bar-label">Jun</span></div>
          <div class="bar-group"><div class="bar" style="height:78%"></div><span class="bar-label">Jul</span></div>
          <div class="bar-group"><div class="bar" style="height:80%"></div><span class="bar-label">Agu</span></div>
          <div class="bar-group"><div class="bar" style="height:72%"></div><span class="bar-label">Sep</span></div>
          <div class="bar-group"><div class="bar" style="height:95%"></div><span class="bar-label">Okt</span></div>
          <div class="bar-group"><div class="bar" style="height:88%"></div><span class="bar-label">Nov</span></div>
          <div class="bar-group"><div class="bar" style="height:55%"></div><span class="bar-label">Des</span></div>
        </div>
      </div>

      <div class="card">
        <div class="card-title">Aktivitas Terbaru</div>
        <div class="activity-list">
          <div class="activity-item">
            <div class="act-icon" style="background:#e8faf9">
              <svg width="16" height="16" fill="none" stroke="#2ec4b6" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="act-text"><p>Peminjaman Aula disetujui</p><span>5 menit lalu</span></div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:#eef0fd">
              <svg width="16" height="16" fill="none" stroke="#4361ee" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="act-text"><p>Gedung baru ditambahkan</p><span>1 jam lalu</span></div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:#fff4ec">
              <svg width="16" height="16" fill="none" stroke="#f4a261" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 9v2m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
            </div>
            <div class="act-text"><p>Laporan kondisi Gedung E</p><span>2 jam lalu</span></div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:#f3e8fd">
              <svg width="16" height="16" fill="none" stroke="#9333ea" viewBox="0 0 24 24" stroke-width="2.5"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div class="act-text"><p>Peminjaman baru oleh Maya</p><span>3 jam lalu</span></div>
          </div>
          <div class="activity-item">
            <div class="act-icon" style="background:#fdecea">
              <svg width="16" height="16" fill="none" stroke="#e63946" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <div class="act-text"><p>Jadwal perbaikan Lab Kimia</p><span>5 jam lalu</span></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Table -->
    <div class="card">
      <div class="table-header">
        <span class="card-title" style="margin-bottom:0">Peminjaman Terbaru</span>
        <a class="see-all" href="daftar-peminjaman.html">Lihat Semua →</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Peminjam</th>
            <th>Ruangan</th>
            <th>Tanggal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Dr. Ahmad Fauzi</td><td>Aula Utama</td><td>15 Jun 2025</td><td><span class="status-badge status-approved">Disetujui</span></td></tr>
          <tr><td>Siti Nurhaliza</td><td>Lab Komputer 1</td><td>16 Jun 2025</td><td><span class="status-badge status-approved">Disetujui</span></td></tr>
          <tr><td>Budi Santoso</td><td>R. Rapat 201</td><td>17 Jun 2025</td><td><span class="status-badge status-pending">Menunggu</span></td></tr>
          <tr><td>Maya Putri</td><td>Auditorium</td><td>18 Jun 2025</td><td><span class="status-badge status-approved">Disetujui</span></td></tr>
          <tr><td>Rizky Ramadhan</td><td>Lab Fisika</td><td>19 Jun 2025</td><td><span class="status-badge status-rejected">Ditolak</span></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</main>
</body>
</html>