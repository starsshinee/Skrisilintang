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

        // ✅ DROPDOWN MENU - MANAJEMEN PERSETUJUAN
        [
          'label' => 'Manajemen Persetujuan',
          'icon' => 'fas fa-check-square',
          'route' => 'NONE',
          'children' => [
            ['href' => route('kasubag.persetujuan-peminjaman-gedung'), 'label' => 'Peminjaman Gedung', 'route' => 'kasubag.persetujuan-peminjaman-gedung'],
            ['href' => route('kasubag.persetujuan-peminjaman-barang'), 'label' => 'Peminjaman Barang', 'route' => 'kasubag.persetujuan-peminjaman-barang'],
            ['href' => route('kasubag.persetujuan-peminjaman-kendaraan'), 'label' => 'Peminjaman Kendaraan', 'route' => 'kasubag.persetujuan-peminjaman-kendaraan'],
            ['href' => route('kasubag.persetujuan-permintaan-persediaan'), 'label' => 'Permintaan Persediaan', 'route' => 'kasubag.persetujuan-permintaan-persediaan'],
          ]
        ],

        // // ✅ DROPDOWN MENU - LAPORAN & MONITORING
        // [
        //   'label' => 'Laporan & Monitoring',
        //   'icon' => 'fas fa-chart-bar',
        //   'route' => 'NONE',
        //   'children' => [
        //     ['href' => '#', 'label' => 'Laporan Peminjaman', 'route' => 'kasubag.laporan-peminjaman'],
        //     ['href' => '#', 'label' => 'Laporan Persediaan', 'route' => 'kasubag.laporan-persediaan'],
        //     ['href' => '#', 'label' => 'Dashboard Monitoring', 'route' => 'kasubag.monitoring'],
        //   ]
        // ],

        ['href' => route('kasubag.pengaturan-akun'), 'label' => 'Pengaturan Akun', 'icon' => 'fas fa-gear', 'route' => 'kasubag.pengaturan-akun'],
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
    --primary-color: #6366f1;
    --primary-hover: #4f46e5;
    --active-bg: #eef2ff;
    --active-text: #4338ca;
    --border-color: #e5e7eb;
    --text-muted: #6b7280;
    --text-dark: #111827;
    --kasubag-primary: #6366f1;
    --kasubag-secondary: #a5b4fc;
    --kasubag-accent: #c7d2fe;
  }

  .sidebar-wrapper {
    width: var(--sidebar-width);
    background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    z-index: 100;
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
  }

  /* ── HEADER ── */
  .sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border-color);
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    color: white;
    position: relative;
  }

  .sidebar-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  }

  .sidebar-logo {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--kasubag-primary);
    font-size: 18px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    border: 2px solid rgba(255, 255, 255, 0.2);
  }

  .sidebar-brand {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .sidebar-brand-name {
    color: white;
    font-weight: 700;
    font-size: 16px;
    line-height: 1.2;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  }

  .sidebar-brand-sub {
    color: rgba(255, 255, 255, 0.8);
    font-size: 12px;
    line-height: 1.2;
    font-weight: 500;
  }

  /* ── NAVIGATION ── */
  .sidebar-nav {
    flex: 1;
    padding: 16px 12px;
  }

  .nav-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  /* Parent Menu Item */
  .nav-item-parent {
    position: relative;
    margin-bottom: 8px;
  }

  .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    margin-bottom: 2px;
    border-radius: 12px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid transparent;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
  }

  .nav-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.1), transparent);
    transition: left 0.5s;
  }

  .nav-item:hover::before {
    left: 100%;
  }

  .nav-item:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: var(--text-dark);
    border-color: rgba(99, 102, 241, 0.2);
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .nav-item.active {
    background: linear-gradient(135deg, var(--active-bg) 0%, #e0e7ff 100%);
    color: var(--active-text);
    border-color: rgba(99, 102, 241, 0.3);
    font-weight: 600;
    box-shadow: 0 4px 16px rgba(99, 102, 241, 0.15);
    transform: translateX(6px);
  }

  .nav-item.active::after {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 60%;
    background: linear-gradient(135deg, var(--kasubag-primary) 0%, var(--primary-hover) 100%);
    border-radius: 0 2px 2px 0;
  }

  .nav-icon {
    width: 18px;
    text-align: center;
    font-size: 16px;
    flex-shrink: 0;
    transition: transform 0.3s ease;
  }

  .nav-item:hover .nav-icon {
    transform: scale(1.1);
  }

  /* Dropdown Arrow */
  .nav-arrow {
    margin-left: auto;
    font-size: 12px;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: var(--text-muted);
  }

  .nav-item.active .nav-arrow {
    color: var(--active-text);
    transform: rotate(180deg);
  }

  .nav-item-toggle {
    cursor: pointer;
    width: 100%;
  }

  .nav-item-toggle:focus {
    outline: none;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.18);
  }

  /* Submenu Container */
  .nav-submenu {
    margin-left: 44px;
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    max-height: 0;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: translateY(-10px);
  }

  .nav-submenu.expanded {
    max-height: 500px;
    opacity: 1;
    transform: translateY(0);
  }

  /* Submenu Items */
  .nav-subitem {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    margin-left: 8px;
    border-radius: 8px;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.3s ease;
    border-left: 2px solid transparent;
    position: relative;
  }

  .nav-subitem::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 0;
    background: linear-gradient(135deg, var(--kasubag-primary) 0%, var(--primary-hover) 100%);
    transition: width 0.3s ease;
    border-radius: 0 4px 4px 0;
  }

  .nav-subitem:hover::before {
    width: 3px;
  }

  .nav-subitem:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: var(--text-dark);
    transform: translateX(6px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  }

  .nav-subitem.active {
    background: linear-gradient(135deg, var(--active-bg) 0%, #e0e7ff 100%);
    color: var(--active-text);
    font-weight: 600;
    border-left-color: var(--kasubag-primary);
    transform: translateX(8px);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
  }

  .nav-subitem.active::before {
    width: 3px;
  }

  /* ── FOOTER ── */
  .sidebar-footer {
    padding: 16px 20px;
    border-top: 1px solid var(--border-color);
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
  }

  .sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
    padding: 12px;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 12px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
  }

  .sidebar-user:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .user-avatar {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--kasubag-primary) 0%, var(--primary-hover) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
  }

  .user-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
    flex: 1;
  }

  .user-name {
    color: var(--text-dark);
    font-weight: 600;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .user-role {
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 500;
  }

  .logout-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 12px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 1px solid #fca5a5;
    border-radius: 8px;
    color: #dc2626;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-family: inherit;
  }

  .logout-btn:hover {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
  }

  /* Scrollbar Styling */
  .sidebar-wrapper::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar-wrapper::-webkit-scrollbar-track {
    background: transparent;
  }

  .sidebar-wrapper::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
    border-radius: 3px;
    transition: background 0.3s ease;
  }

  .sidebar-wrapper::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    :root {
      --sidebar-width: 260px;
    }

    .sidebar-wrapper {
      transform: translateX(-100%);
      transition: transform 0.3s ease;
    }

    .sidebar-wrapper.open {
      transform: translateX(0);
    }
  }

  /* Loading Animation */
  @keyframes shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
  }

  .nav-item.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
  }

  /* Kasubag Specific Styling */
  .kasubag-theme .nav-item.active {
    background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
    border-color: #a5b4fc;
  }

  .kasubag-theme .nav-subitem.active {
    background: linear-gradient(135deg, #f0f4ff 0%, #e8f0ff 100%);
    border-left-color: #6366f1;
  }
</style>

<aside class="sidebar-wrapper {{ $currentRole === 'kasubag' ? 'kasubag-theme' : '' }}">
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
        {{-- MENU DENGAN CHILDREN --}}
        @if(isset($item['children']))
          @php
            $isParentActive = collect($item['children'])->contains(function ($child) {
              return request()->routeIs($child['route'] ?? '');
            });
          @endphp

          <div class="nav-item-parent">
            <div class="nav-item nav-item-toggle {{ $isParentActive ? 'active' : '' }}" role="button" aria-expanded="{{ $isParentActive ? 'true' : 'false' }}">
              <span class="nav-icon">
                <i class="{{ $item['icon'] }}"></i>
              </span>
              <span>{{ $item['label'] }}</span>
              <i class="fas fa-chevron-down nav-arrow {{ $isParentActive ? 'rotate-180' : '' }}"></i>
            </div>

            {{-- SUBMENU --}}
            <div class="nav-submenu {{ $isParentActive ? 'expanded' : '' }}">
              @foreach($item['children'] as $child)
                <a href="{{ $child['href'] }}"
                   class="nav-subitem {{ request()->routeIs($child['route'] ?? '') ? 'active' : '' }}">
                  {{ $child['label'] }}
                </a>
              @endforeach
            </div>
          </div>

        {{-- MENU BIASA --}}
        @else
          <a href="{{ $item['href'] }}"
             class="nav-item {{ request()->routeIs($item['route'] ?? '') ? 'active' : '' }}"
             title="{{ $item['label'] }}">
            <span class="nav-icon">
              <i class="{{ $item['icon'] }}"></i>
            </span>
            <span>{{ $item['label'] }}</span>
          </a>
        @endif
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.nav-item-toggle').forEach(function (toggle) {
      toggle.addEventListener('click', function () {
        var parent = toggle.closest('.nav-item-parent');
        if (!parent) return;

        var submenu = parent.querySelector('.nav-submenu');
        if (!submenu) return;

        var expanded = submenu.classList.toggle('expanded');
        toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');

        var arrow = toggle.querySelector('.nav-arrow');
        if (arrow) {
          arrow.classList.toggle('rotate-180', expanded);
        }
      });
    });
  });
</script>