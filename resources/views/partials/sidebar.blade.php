@php
  $user = auth()->user();
  $currentRole = $user->role ?? 'guest';
  
  // Definisi warna dan konfigurasi untuk setiap role
  $roleConfig = [
    'superadmin' => [
      'bgGradient' => 'from-slate-900 to-slate-800',
      'badgeText' => 'Super Admin',
      'badgeColor' => 'bg-red-500/20 text-red-300',
      'navItems' => [
        ['href' => route('superadmin.dashboard'),       'label' => 'Dashboard',        'icon' => 'fas fa-chart-line', 'route' => 'superadmin.dashboard'],
        ['href' => route('superadmin.manajemen-user'),  'label' => 'Kelola Pengguna',  'icon' => 'fas fa-users',      'route' => 'superadmin.manajemen-user'],
      ]
    ],
    'pegawai' => [
      'bgGradient' => 'from-blue-900 to-blue-800',
      'badgeText' => 'Pegawai',
      'badgeColor' => 'bg-blue-500/20 text-blue-300',
      'navItems' => [
        ['href' => route('pegawai.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-home', 'route' => 'pegawai.dashboard'],
        ['href' => route('pegawai.peminjaman-barang'), 'label' => 'Peminjaman Barang', 'icon' => 'fas fa-box', 'route' => 'pegawai.peminjaman-barang'],
        ['href' => route('pegawai.peminjaman-kendaraan'), 'label' => 'Peminjaman Kendaraan', 'icon' => 'fas fa-car', 'route' => 'pegawai.peminjaman-kendaraan'],
        ['href' => route('pegawai.permintaan-persediaan'), 'label' => 'Permintaan Persediaan', 'icon' => 'fas fa-boxes', 'route' => 'pegawai.permintaan-persediaan'],
        ['href' => route('pegawai.pengaturan-akun'),  'label' => 'Pengaturan Akun',      'icon' => 'fas fa-gear',        'route' => 'pegawai.pengaturan-akun'],
      ]
    ],
    'tamu' => [
      'bgGradient' => 'from-slate-900 to-slate-800',
      'badgeText' => 'Tamu',
      'badgeColor' => 'bg-cyan-500/20 text-cyan-300',
      'navItems' => [
        ['href' => route('tamu.dashboard'),        'label' => 'Dashboard',            'icon' => 'fas fa-door-open',   'route' => 'tamu.dashboard'],
        ['href' => route('tamu.peminjaman-gedung'),  'label' => 'Peminjaman Gedung',      'icon' => 'fas fa-box-archive', 'route' => 'tamu.peminjaman-gedung'],
        ['href' => route('tamu.info-fasilitas'),   'label' => 'Informasi Fasilitas',  'icon' => 'fas fa-info-circle', 'route' => 'tamu.info-fasilitas'],
        ['href' => route('tamu.pengaturan-akun'),  'label' => 'Pengaturan Akun',      'icon' => 'fas fa-gear',        'route' => 'tamu.pengaturan-akun'],
      ]
    ],
    'admin_aset_tetap' => [
      'bgGradient' => 'from-orange-900 to-orange-800',
      'badgeText' => 'Admin Aset Tetap',
      'badgeColor' => 'bg-orange-500/20 text-orange-300',
      'navItems' => [
        ['href' => route('adminasettetap.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'adminasettetap.dashboard'],
        ['href' => '#', 'label' => 'Aset Tetap', 'icon' => 'fas fa-cubes', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Kondisi Aset', 'icon' => 'fas fa-check-circle', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Laporan Aset', 'icon' => 'fas fa-file-alt', 'route' => 'NONE'],
      ]
    ],
    'admin_persediaan' => [
      'bgGradient' => 'from-green-900 to-green-800',
      'badgeText' => 'Admin Persediaan',
      'badgeColor' => 'bg-green-500/20 text-green-300',
      'navItems' => [
        ['href' => route('adminpersediaan.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'adminpersediaan.dashboard'],
        ['href' => '#', 'label' => 'Barang Persediaan', 'icon' => 'fas fa-boxes', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Tambah Barang', 'icon' => 'fas fa-plus-circle', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Laporan Persediaan', 'icon' => 'fas fa-file-alt', 'route' => 'NONE'],
      ]
    ],
    'adminsarpras' => [
      'bgGradient' => 'from-cyan-900 to-cyan-800',
      'badgeText' => 'Admin Sarpras',
      'badgeColor' => 'bg-cyan-500/20 text-cyan-300',
      'navItems' => [
        ['href' => route('adminsarpras.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'adminsarpras.dashboard'],
        ['href' => route('adminsarpras.data-gedung'), 'label' => 'Data Gedung', 'icon' => 'fas fa-building', 'route' => 'adminsarpras.data-gedung'],
        ['href' => route('adminsarpras.daftar-peminjaman'), 'label' => 'Daftar Peminjaman', 'icon' => 'fas fa-door-open', 'route' => 'adminsarpras.daftar-peminjaman'],
        ['href' => route('adminsarpras.laporan-peminjaman-gedung'), 'label' => 'Laporan Peminjaman Gedung', 'icon' => 'fas fa-file-alt', 'route' => 'adminsarpras.laporan-peminjaman-gedung'],
        ['href' => route('adminsarpras.pengaturan-akun'), 'label' => 'Pengaturan Akun', 'icon' => 'fas fa-gear', 'route' => 'adminsarpras.pengaturan-akun'],
      ]
    ],
    'kasubag' => [
      'bgGradient' => 'from-indigo-900 to-indigo-800',
      'badgeText' => 'Ka Subag',
      'badgeColor' => 'bg-indigo-500/20 text-indigo-300',
      'navItems' => [
        ['href' => route('kasubag.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'kasubag.dashboard'],
        ['href' => '#', 'label' => 'Kelola Pengguna', 'icon' => 'fas fa-users-cog', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Semua BMN', 'icon' => 'fas fa-cube', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Laporan', 'icon' => 'fas fa-file-alt', 'route' => 'NONE'],
      ]
    ],
    'kepala_bpmp' => [
      'bgGradient' => 'from-purple-900 to-purple-800',
      'badgeText' => 'Kepala BPMP',
      'badgeColor' => 'bg-purple-500/20 text-purple-300',
      'navItems' => [
        ['href' => route('kepalabpmp.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'kepalabpmp.dashboard'],
        ['href' => '#', 'label' => 'Laporan BMN', 'icon' => 'fas fa-file-pdf', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Persetujuan', 'icon' => 'fas fa-check-square', 'route' => 'NONE'],
      ]
    ],
  ];
  
  // Dapatkan konfigurasi dari role saat ini
  $config = $roleConfig[$currentRole] ?? $roleConfig['pegawai'];
@endphp

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
  :root {
    --sidebar-width: 240px;
  }

  .sidebar-wrapper {
    width: var(--sidebar-width);
    background: #ffffff;
    border-right: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: 100;
    overflow-y: auto;
  }

  /* ── HEADER ── */
  .sidebar-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb; /* FIX: ganti dari rgba transparan */
  }

  .sidebar-logo {
    width: 36px;
    height: 36px;
    background: #1e3a5f;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 15px;
    flex-shrink: 0;
  }

  /* FIX: pisah brand-name dan brand-sub, hapus comment */
  .sidebar-brand {
    display: flex;
    flex-direction: column;
    gap: 1px;
  }

  .sidebar-brand-name {
    color: #111827;
    font-weight: 700;
    font-size: 14px;
    line-height: 1.2;
  }

  .sidebar-brand-sub {
    color: #9ca3af;
    font-size: 11px;
    line-height: 1.2;
  }

  /* ── NAV ── */
  .sidebar-nav {
    flex: 1;
    padding: 12px 10px;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    margin-bottom: 2px;
    border-radius: 8px;
    color: #6b7280;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border-left: 3px solid transparent; /* FIX: siapkan slot border agar tidak geser */
  }

  .nav-item:hover {
    background: #f3f4f6;
    color: #374151;
  }

  .nav-item.active {
    background: #eff6ff;
    color: #1d4ed8;
    border-left: 3px solid #3b82f6;
    font-weight: 600;
  }

  .nav-icon {
    width: 16px;
    text-align: center;
    font-size: 13px;
    flex-shrink: 0;
  }

  /* ── FOOTER ── */
  .sidebar-footer {
    padding: 14px 20px;
    border-top: 1px solid #e5e7eb;
  }

  .sidebar-user {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
  }

  .user-avatar {
    width: 34px;
    height: 34px;
    background: #dbeafe;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #1d4ed8;
    font-weight: 700;
    font-size: 12px;
    flex-shrink: 0;
  }

  /* FIX: user-info butuh flex column agar nama & role tersusun vertikal */
  .user-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
    flex: 1;
  }

  .user-name {
    color: #111827;
    font-weight: 600;
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .user-role {
    color: #9ca3af;
    font-size: 11px;
  }

  .logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 8px 2px;
    background: none;
    border: none;
    color: #ef4444;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: color 0.2s;
    text-decoration: none;
    font-family: inherit;
  }

  .logout-btn:hover {
    color: #dc2626;
  }

  /* Scrollbar */
  .sidebar-wrapper::-webkit-scrollbar { width: 4px; }
  .sidebar-wrapper::-webkit-scrollbar-track { background: transparent; }
  .sidebar-wrapper::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 4px; }
</style>

<aside class="sidebar-wrapper">
  <!-- Logo & Branding -->
  <div class="sidebar-header">
    <div class="sidebar-logo">
      <i class="fas fa-cube"></i>
    </div>
    <div class="sidebar-brand">
      <div class="sidebar-brand-name">SIBMN</div>
      <div class="sidebar-brand-sub">BPMP Gorontalo</div>
    </div>
  </div>

  <!-- Navigation Menu -->
  <nav class="sidebar-nav">
    <div class="nav-group">
      @foreach($config['navItems'] as $item)
        <a href="{{ $item['href'] }}" 
           class="nav-item {{ request()->routeIs($item['route'] ?? 'NEVER_MATCH') ? 'active' : '' }}"
           title="{{ $item['label'] }}">
          <span class="nav-icon">
            <i class="{{ $item['icon'] }}"></i>
          </span>
          <span>{{ $item['label'] }}</span>
        </a>
      @endforeach
    </div>
  </nav>

  <!-- Footer: User Info + Logout -->
  <div class="sidebar-footer">
    <!-- User Info -->
    <div class="sidebar-user">
      <div class="user-avatar">
        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
      </div>
      <div class="user-info">
        <div class="user-name">{{ $user->name ?? 'User' }}</div>
        <div class="user-role">{{ $config['badgeText'] }}</div>
      </div>
    </div>

    <!-- Logout -->
    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
      @csrf
      <button type="submit" class="logout-btn">
        <span class="nav-icon">
          <i class="fas fa-sign-out-alt"></i>
        </span>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</aside>