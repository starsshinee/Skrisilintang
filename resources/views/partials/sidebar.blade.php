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
        ['href' => '#',                                  'label' => 'Laporan Semua BMN','icon' => 'fas fa-cube',       'route' => 'NONE'],
      ]
    ],
    'pegawai' => [
      'bgGradient' => 'from-blue-900 to-blue-800',
      'badgeText' => 'Pegawai',
      'badgeColor' => 'bg-blue-500/20 text-blue-300',
      'navItems' => [
        ['href' => route('pegawai.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-home', 'route' => 'pegawai.dashboard'],
        ['href' => '#', 'label' => 'Ajukan Peminjaman', 'icon' => 'fas fa-hand-paper', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Riwayat Pengajuan', 'icon' => 'fas fa-history', 'route' => 'NONE'],
      ]
    ],
    'tamu' => [
      'bgGradient' => 'from-slate-900 to-slate-800',
      'badgeText' => 'Tamu',
      'badgeColor' => 'bg-cyan-500/20 text-cyan-300',
      'navItems' => [
        ['href' => route('tamu.dashboard'),        'label' => 'Dashboard',            'icon' => 'fas fa-door-open',   'route' => 'tamu.dashboard'],
        ['href' => route('tamu.peminjaman-aset'),  'label' => 'Peminjaman Aset',      'icon' => 'fas fa-box-archive', 'route' => 'tamu.peminjaman-aset'],
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
        ['href' => route('adminpersediian.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'adminpersediian.dashboard'],
        ['href' => '#', 'label' => 'Barang Persediaan', 'icon' => 'fas fa-boxes', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Tambah Barang', 'icon' => 'fas fa-plus-circle', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Laporan Persediaan', 'icon' => 'fas fa-file-alt', 'route' => 'NONE'],
      ]
    ],
    'admin_sarpras' => [
      'bgGradient' => 'from-cyan-900 to-cyan-800',
      'badgeText' => 'Admin Sarpras',
      'badgeColor' => 'bg-cyan-500/20 text-cyan-300',
      'navItems' => [
        ['href' => route('adminsarpras.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'adminsarpras.dashboard'],
        ['href' => '#', 'label' => 'Data Sarpras', 'icon' => 'fas fa-tools', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Peminjaman Kendaraan', 'icon' => 'fas fa-car', 'route' => 'NONE'],
        ['href' => '#', 'label' => 'Laporan Sarpras', 'icon' => 'fas fa-file-alt', 'route' => 'NONE'],
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
    --sidebar-width: 260px;
  }
  
  /* Sidebar Styling */
  .sidebar-wrapper {
    width: var(--sidebar-width);
    background: linear-gradient(180deg, rgb(17, 24, 39) 0%, rgb(31, 41, 55) 100%);
    display: flex;
    flex-direction: column;
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: 100;
    box-shadow: -2px 0 8px rgba(0, 0, 0, 0.15);
    overflow-y: auto;
  }

  .sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 24px 20px 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  }

  .sidebar-logo {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #3b82f6, #0ea5e9);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
  }

  .sidebar-brand {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .sidebar-brand-name {
    color: white;
    font-weight: 700;
    font-size: 14px;
    line-height: 1.2;
  }

  .sidebar-brand-sub {
    color: rgba(255, 255, 255, 0.5);
    font-size: 11px;
    line-height: 1;
  }

  .sidebar-user {
    margin: 16px 16px 8px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 10px;
    padding: 10px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .user-avatar {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #3b82f6, #0ea5e9);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
  }

  .user-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex: 1;
    min-width: 0;
  }

  .user-name {
    color: white;
    font-weight: 600;
    font-size: 12px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .user-role {
    color: rgba(255, 255, 255, 0.4);
    font-size: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .sidebar-nav {
    flex: 1;
    padding: 12px 8px;
  }

  .nav-group {
    margin-bottom: 8px;
  }

  .nav-group-label {
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: rgba(148, 163, 184, 0.5);
    padding: 12px 14px 6px;
    font-weight: 700;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    margin-bottom: 3px;
    border-radius: 8px;
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
  }

  .nav-item:hover {
    background: rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.9);
  }

  .nav-item.active {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(14, 165, 233, 0.3));
    color: white;
    border-left: 3px solid #3b82f6;
    padding-left: 11px;
  }

  .nav-icon {
    width: 18px;
    text-align: center;
    font-size: 14px;
    flex-shrink: 0;
  }

  .sidebar-footer {
    padding: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
  }

  .logout-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 14px;
    border-radius: 8px;
    background: rgba(239, 68, 68, 0.08);
    border: none;
    color: #ef4444;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .logout-btn:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #ff6b6b;
  }

  /* Scrollbar styling */
  .sidebar-wrapper::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar-wrapper::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.02);
  }

  .sidebar-wrapper::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
  }

  .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.15);
  }
</style>

<aside class="sidebar-wrapper bg-gradient-to-b {{ $config['bgGradient'] }}">
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

  <!-- Logout Button -->
  <div class="sidebar-footer">
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
