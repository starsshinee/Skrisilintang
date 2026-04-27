<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Dashboard Tamu</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --primary: #2563eb;
    --primary-light: #3b82f6;
    --primary-dark: #1d4ed8;
    --accent: #06b6d4;
    --accent2: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --bg: #f0f4ff;
    --sidebar-bg: #0f172a;
    --sidebar-text: #94a3b8;
    --sidebar-active: #2563eb;
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
    overflow-x: hidden;
  }

  /* ── SIDEBAR ── */
  .sidebar {
    width: 260px;
    min-height: 100vh;
    background: var(--sidebar-bg);
    display: flex;
    flex-direction: column;
    position: fixed;
    left: 0; top: 0; bottom: 0;
    z-index: 100;
    transition: all .3s ease;
  }
  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 28px 24px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
  }
  .logo-icon {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 12px;
    display: grid; place-items: center;
    font-size: 18px; color: #fff;
    box-shadow: 0 4px 14px rgba(37,99,235,0.4);
  }
  .logo-text { font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 20px; color: #fff; letter-spacing: -.3px; }
  .logo-sub { font-size: 10px; color: var(--sidebar-text); font-weight: 500; letter-spacing: 1px; text-transform: uppercase; }

  .sidebar-user {
    margin: 16px 16px 8px;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    border: 1px solid rgba(255,255,255,0.07);
  }
  .user-avatar {
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    border-radius: 10px;
    display: grid; place-items: center;
    font-size: 14px; color: #fff; font-weight: 700;
  }
  .user-name { font-size: 13px; font-weight: 600; color: #fff; }
  .user-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; color: var(--accent); font-weight: 600;
    background: rgba(6,182,212,0.12);
    padding: 2px 7px; border-radius: 20px;
    letter-spacing: .3px; margin-top: 2px;
  }

  .sidebar-nav { padding: 10px 12px; flex: 1; }
  .nav-label {
    font-size: 10px; text-transform: uppercase; letter-spacing: 1.2px;
    color: rgba(148,163,184,0.5); font-weight: 700;
    padding: 14px 12px 6px;
  }
  .nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 14px;
    border-radius: 10px;
    color: var(--sidebar-text);
    font-size: 14px; font-weight: 500;
    text-decoration: none;
    margin-bottom: 2px;
    cursor: pointer;
    transition: all .2s;
    position: relative;
  }
  .nav-item:hover { background: rgba(255,255,255,0.06); color: #fff; }
  .nav-item.active {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
  }
  .nav-item .nav-icon { width: 18px; text-align: center; font-size: 15px; }
  .nav-badge {
    margin-left: auto;
    background: var(--accent2);
    color: #fff; font-size: 10px; font-weight: 700;
    padding: 2px 7px; border-radius: 20px;
  }

  .sidebar-footer {
    padding: 16px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }
  .logout-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #ef4444;
    font-size: 13px; font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.15);
    text-decoration: none;
    width: 100%;
  }
  .logout-btn:hover { background: rgba(239,68,68,0.16); }

  /* ── MAIN CONTENT ── */
  .main { margin-left: 256px; flex: 1; padding: 24px 28px 32px; }

  /* TOP BAR */
  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
  }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 24px; font-weight: 700; color: var(--text-primary); }
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
    margin-bottom: 32px;
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
  .hero-left { position: relative; z-index: 2; flex: 1; }
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

  /* STAT CARDS */
  .stats-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px; 
    margin-bottom: 32px; 
  }
  .stat-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    padding: 24px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    display: flex; align-items: center; gap: 18px;
    position: relative; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    cursor: default;
  }
  .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
  .stat-card::after {
    content: '';
    position: absolute; right: -20px; top: -20px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: .07;
  }
  .stat-card.blue::after { background: var(--primary); }
  .stat-card.yellow::after { background: var(--warning); }
  .stat-card.green::after { background: var(--success); }

  .stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: grid; place-items: center;
    font-size: 22px; flex-shrink: 0;
  }
  .stat-icon.blue { background: rgba(37,99,235,0.1); color: var(--primary); }
  .stat-icon.yellow { background: rgba(245,158,11,0.1); color: var(--warning); }
  .stat-icon.green { background: rgba(16,185,129,0.1); color: var(--success); }
  .stat-label { font-size: 13px; color: var(--text-secondary); font-weight: 500; margin-bottom: 4px; }
  .stat-value { font-family: 'Space Grotesk', sans-serif; font-size: 32px; font-weight: 700; color: var(--text-primary); line-height: 1; }
  .stat-sub { font-size: 11px; color: var(--text-secondary); margin-top: 4px; }

  /* MAIN CONTENT GRID */
  .content-grid { 
    display: grid; 
    grid-template-columns: 2fr 1fr;
    gap: 24px;
    margin-bottom: 0;
  }

  /* SECTION CARDS */
  .section-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    display: flex;
    flex-direction: column;
  }
  .section-header {
    padding: 24px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
  }
  .section-title { 
    font-family: 'Space Grotesk', sans-serif; 
    font-size: 16px; 
    font-weight: 700; 
    color: var(--text-primary); 
    display: flex; 
    align-items: center; 
    gap: 8px; 
  }
  .section-title i { color: var(--primary); }
  .see-all { font-size: 12px; color: var(--primary); font-weight: 600; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 4px; }
  .see-all:hover { text-decoration: underline; }

  /* QUICK ACTIONS */
  .quick-actions {
    display: grid; 
    grid-template-columns: 1fr 1fr;
    gap: 12px; 
    padding: 24px;
    flex: 1;
  }
  .qa-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 16px;
    border-radius: 12px;
    font-size: 13px; font-weight: 600;
    cursor: pointer; transition: all .2s;
    text-decoration: none;
    border: 1.5px solid transparent;
  }
  .qa-btn.primary { 
    background: linear-gradient(135deg, var(--primary), var(--primary-light)); 
    color: #fff; 
    box-shadow: 0 4px 14px rgba(37,99,235,0.3); 
  }
  .qa-btn.primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
  .qa-btn.outline { background: transparent; color: var(--primary); border-color: var(--primary); }
  .qa-btn.outline:hover { background: rgba(37,99,235,0.05); }
  .qa-btn.accent { 
    background: linear-gradient(135deg, var(--accent2), #7c3aed); 
    color: #fff; 
    box-shadow: 0 4px 14px rgba(139,92,246,0.3); 
  }
  .qa-btn.accent:hover { transform: translateY(-2px); }
  .qa-btn.success { 
    background: linear-gradient(135deg, var(--success), #059669); 
    color: #fff; 
    box-shadow: 0 4px 14px rgba(16,185,129,0.3); 
  }
  .qa-btn.success:hover { transform: translateY(-2px); }
  .qa-btn i { font-size: 17px; }

  /* RECENT REQUESTS */
  .req-list { 
    padding: 24px;
    display: flex; 
    flex-direction: column; 
    gap: 12px;
    flex: 1;
  }
  .req-empty { text-align: center; padding: 40px 20px; }
  .req-empty-icon { font-size: 48px; color: #dde5f9; margin-bottom: 12px; }
  .req-empty-text { font-size: 14px; color: var(--text-secondary); font-weight: 500; }
  .req-empty-sub { font-size: 12px; color: #b0bcd4; margin-top: 4px; }

  .req-item {
    display: flex; align-items: center; gap: 14px;
    padding: 14px;
    border-radius: 12px;
    border: 1px solid var(--border);
    transition: all .2s;
  }
  .req-item:hover { background: #f8faff; }
  .req-status-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
  .req-status-dot.pending { background: var(--warning); box-shadow: 0 0 0 3px rgba(245,158,11,0.2); }
  .req-status-dot.approved { background: var(--success); box-shadow: 0 0 0 3px rgba(16,185,129,0.2); }
  .req-status-dot.rejected { background: var(--danger); box-shadow: 0 0 0 3px rgba(239,68,68,0.2); }
  .req-info { flex: 1; }
  .req-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
  .req-date { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
  .req-badge {
    font-size: 10px; font-weight: 700; padding: 3px 9px; border-radius: 6px;
    letter-spacing: .3px; text-transform: uppercase;
  }
  .req-badge.pending { background: rgba(245,158,11,0.1); color: var(--warning); }
  .req-badge.approved { background: rgba(16,185,129,0.1); color: var(--success); }
  .req-badge.rejected { background: rgba(239,68,68,0.1); color: var(--danger); }

  /* SCROLLBAR */
  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }
  .d4 { animation-delay: .2s; } .d5 { animation-delay: .25s; } .d6 { animation-delay: .3s; }

  /* RESPONSIVE */
  @media (max-width: 1024px) {
    .content-grid { grid-template-columns: 1fr; }
    .stats-grid { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
  }

  @media (max-width: 768px) {
    .sidebar { width: 100%; }
    .main { margin-left: 0; padding: 16px; }
    .hero { flex-direction: column; text-align: center; }
    .hero-right { text-align: center; margin-top: 16px; }
    .stats-grid { grid-template-columns: 1fr; }
    .topbar { flex-direction: column; gap: 12px; }
    .topbar-right { width: 100%; justify-content: space-between; }
  }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <!-- TOPBAR -->
  <div class="topbar animate d1">
    <div class="topbar-title">Dashboard Tamu</div>
    <div class="topbar-right">
      <div class="topbar-date">
        <i class="fas fa-calendar" style="color:var(--primary)"></i>
        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
      </div>
      <div class="notif-btn" onclick="toggleNotifications()">
        <i class="fas fa-bell"></i>
        {{-- @if($notifikasi->count() > 0)
          <div class="notif-dot"></div>
        @endif --}}
      </div>
    </div>
  </div>

  <!-- HERO BANNER -->
  <div class="hero animate d1">
    <div class="hero-blob"></div>
    <div class="hero-blob2"></div>
    <div class="hero-left">
      <div class="hero-greeting">👋 Selamat datang kembali!</div>
      <h1 class="hero-title">Halo, {{ auth()->user()->nama_lengkap ?? 'Tamu' }}!</h1>
      <div class="hero-sub">
        @if(auth()->user()->instansi_lembaga)
          {{ auth()->user()->instansi_lembaga }} • 
        @endif
        Kelola permintaan peminjaman aset dan fasilitas BPMP Provinsi Gorontalo dengan mudah.
      </div>
    </div>
    <div class="hero-right">
      <div class="hero-inst">{{ auth()->user()->instansi_lembaga ?? 'Tamu Eksternal' }}</div>
      <div class="hero-nip">{{ auth()->user()->email ?? 'tamu@example.com' }}</div>
      <a href="{{ route('tamu.pengaturan-akun') }}" class="hero-btn">
        <i class="fas fa-gear"></i> Pengaturan Akun
      </a>
    </div>
  </div>

  <!-- STATS -->
  <div class="stats-grid">
    <div class="stat-card blue animate d2">
      <div class="stat-icon blue"><i class="fas fa-file-lines"></i></div>
      <div>
        <div class="stat-label">Total Permintaan</div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-sub">Sepanjang waktu</div>
      </div>
    </div>
    <div class="stat-card yellow animate d3">
      <div class="stat-icon yellow"><i class="fas fa-hourglass-half"></i></div>
      <div>
        <div class="stat-label">Menunggu</div>
        <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
        <div class="stat-sub">Menunggu persetujuan</div>
      </div>
    </div>
    <div class="stat-card green animate d4">
      <div class="stat-icon green"><i class="fas fa-circle-check"></i></div>
      <div>
        <div class="stat-label">Diterima</div>
        <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
        <div class="stat-sub">Permintaan disetujui</div>
      </div>
    </div>
  </div>

  <!-- CONTENT GRID -->
  <div class="content-grid">
    <!-- Left Column - Quick Actions -->
    <div class="section-card animate d5">
      <div class="section-header">
        <div class="section-title"><i class="fas fa-bolt"></i> Aksi Cepat</div>
      </div>
      <div class="quick-actions">
        <a href="{{ route('tamu.peminjaman-gedung') }}" class="qa-btn primary">
          <i class="fas fa-plus-circle"></i> Ajukan Peminjaman
        </a>
        <a href="{{ route('tamu.peminjaman-gedung') }}" class="qa-btn primary">
          <i class="fas fa-clock-rotate-left"></i> Lihat Histori
        </a>
        <a href="{{ route('tamu.pengaturan-akun') }}" class="qa-btn accent">
          <i class="fas fa-user-pen"></i> Edit Profil
        </a>
        {{-- <a href="{{ route('tamu.kontak') }}" class="qa-btn success">
          <i class="fas fa-phone"></i> Kontak BPMP
        </a> --}}
      </div>
    </div>

    <!-- Right Column - Recent Requests -->
    <div class="section-card animate d6">
      <div class="section-header">
        <div class="section-title"><i class="fas fa-list-check"></i> Permintaan Terbaru</div>
        <a href="{{ route('tamu.peminjaman-gedung') }}" class="see-all">
          Lihat Semua <i class="fas fa-arrow-right"></i>
        </a>
      </div>
      <div class="req-list">
        @forelse($peminjaman_terbaru as $item)
          <div class="req-item">
            <div class="req-status-dot {{ $item->status == 'pending' ? 'pending' : ($item->status == 'disetujui' ? 'approved' : 'rejected') }}"></div>
            <div class="req-info">
              <div class="req-name">{{ Str::limit($item->tujuan_penggunaan, 35) }}</div>
              <div class="req-date">
                {{ $item->tanggal_pinjam->locale('id')->isoFormat('D MMM YY') }} • 
                {{ $item->nama_fasilitas ?? $item->fasilitas }}
              </div>
            </div>
            <span class="req-badge {{ $item->status }}">
              {{ ucfirst(str_replace('_', ' ', $item->status)) }}
            </span>
          </div>
        @empty
          <div class="req-empty">
            <div class="req-empty-icon"><i class="fas fa-inbox"></i></div>
            <div class="req-empty-text">Belum ada permintaan</div>
            <div class="req-empty-sub">Ajukan peminjaman gedung untuk memulai</div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</main>

<script>
function toggleNotifications() {
  // Add notification dropdown logic here
  alert('Fitur notifikasi akan segera hadir!');
}

document.addEventListener('DOMContentLoaded', function() {
  // Add animation on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = 'running';
      }
    });
  });
  
  document.querySelectorAll('.animate').forEach(el => observer.observe(el));
});
</script>

</body>
</html>