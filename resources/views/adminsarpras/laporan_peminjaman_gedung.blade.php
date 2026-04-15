@extends('layouts.app')

@section('content')
@php
  $user = auth()->user();
  $currentRole = 'admin_sarpras';
  
  $roleConfig = [
    'admin_sarpras' => [
      'bgGradient' => 'from-cyan-900 to-cyan-800',
      'badgeText' => 'Admin Sarpras',
      'badgeColor' => 'bg-cyan-500/20 text-cyan-300',
      'navItems' => [
        ['href' => route('adminsarpras.dashboard'), 'label' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'route' => 'adminsarpras.dashboard'],
        ['href' => route('adminsarpras.data-gedung'), 'label' => 'Data Gedung', 'icon' => 'fas fa-building', 'route' => 'adminsarpras.data-gedung'],
        ['href' => route('adminsarpras.daftar-peminjaman'), 'label' => 'Daftar Peminjaman', 'icon' => 'fas fa-list', 'route' => 'adminsarpras.daftar-peminjaman'],
        ['href' => route('adminsarpras.laporan'), 'label' => 'Laporan Sarpras', 'icon' => 'fas fa-file-alt', 'route' => 'adminsarpras.laporan'],
      ]
    ],
  ];
  
  $config = $roleConfig[$currentRole];

  $peminjamanData = [
    ['peminjam' => 'Dr. Budi Santoso', 'gedung' => 'Aula Utama', 'tanggal' => '2025-07-15', 'status' => 'Menunggu'],
    ['peminjam' => 'HMTI', 'gedung' => 'Gedung B Lt.2', 'tanggal' => '2025-07-18', 'status' => 'Disetujui'],
    ['peminjam' => 'Fak. Teknik', 'gedung' => 'Lab Komputer A', 'tanggal' => '2025-07-20', 'status' => 'Disetujui'],
    ['peminjam' => 'BEM Universitas', 'gedung' => 'Auditorium', 'tanggal' => '2025-07-22', 'status' => 'Menunggu'],
    ['peminjam' => 'Prodi Manajemen', 'gedung' => 'Ruang Serbaguna C', 'tanggal' => '2025-07-10', 'status' => 'Ditolak'],
  ];
@endphp

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
  :root {
    --sidebar-width: 260px;
  }
  
  * {
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  body {
    margin: 0;
    padding: 0;
    background: #f9fafb;
  }

  .main-wrapper {
    margin-left: var(--sidebar-width);
  }

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
    background: linear-gradient(135deg, #06b6d4, #00d4ff);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(6, 182, 212, 0.3);
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
    background: linear-gradient(135deg, #06b6d4, #00d4ff);
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
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.3), rgba(0, 212, 255, 0.3));
    color: white;
    border-left: 3px solid #06b6d4;
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

  /* Main Content Styling */
  .main-content {
    padding: 32px;
    background: #f9fafb;
    min-height: 100vh;
  }

  .page-header {
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .page-header-left h1 {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px;
  }

  .page-header-left p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
  }

  .btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-primary {
    background: #06b6d4;
    color: white;
  }

  .btn-primary:hover {
    background: #0891b2;
  }

  .card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }

  .card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 20px;
  }

  .chart-container {
    display: flex;
    align-items: flex-end;
    gap: 16px;
    height: 200px;
  }

  .chart-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
  }

  .chart-label {
    font-size: 12px;
    color: #6b7280;
  }

  .chart-bar {
    width: 100%;
    background: #f3f4f6;
    border-radius: 6px 6px 0 0;
    position: relative;
    transition: all 0.3s ease;
  }

  .chart-bar:hover {
    opacity: 0.8;
  }

  .chart-value {
    position: absolute;
    top: -24px;
    left: 50%;
    transform: translateX(-50%);
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
  }

  .bar-monthly {
    background: linear-gradient(135deg, #10b981, #059669);
  }

  .bar-facility {
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
  }

  .legend {
    display: flex;
    gap: 24px;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #6b7280;
  }

  .legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
  }

  .table-responsive {
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
  }

  thead {
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
  }

  thead th {
    padding: 16px;
    text-align: left;
    font-weight: 700;
    color: #374151;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
  }

  tbody td {
    padding: 16px;
    border-bottom: 1px solid #e5e7eb;
    color: #6b7280;
  }

  tbody tr:hover {
    background: #f9fafb;
  }

  .badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
  }

  .badge-warning {
    background: #fef3c7;
    color: #d97706;
  }

  .badge-success {
    background: #dcfce7;
    color: #16a34a;
  }

  .badge-danger {
    background: #fee2e2;
    color: #dc2626;
  }

  .two-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
  }

  @media (max-width: 1024px) {
    .two-grid {
      grid-template-columns: 1fr;
    }

    .page-header {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>

<aside class="sidebar-wrapper bg-gradient-to-b {{ $config['bgGradient'] }}">
  <div class="sidebar-header">
    <div class="sidebar-logo">
      <i class="fas fa-cube"></i>
    </div>
    <div class="sidebar-brand">
      <div class="sidebar-brand-name">SIBMN</div>
      <div class="sidebar-brand-sub">BPMP Gorontalo</div>
    </div>
  </div>

  <div class="sidebar-user">
    <div class="user-avatar">
      {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
    </div>
    <div class="user-info">
      <div class="user-name">{{ $user->name ?? 'User' }}</div>
      <div class="user-role">{{ $config['badgeText'] }}</div>
    </div>
  </div>

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

<div class="main-wrapper">
  <div class="main-content">
    <div class="page-header">
      <div class="page-header-left">
        <h1>Laporan</h1>
        <p>Statistik dan riwayat peminjaman gedung</p>
      </div>
      <button class="btn btn-primary">
        <i class="fas fa-download"></i>
        Export CSV
      </button>
    </div>

    <!-- Charts Section -->
    <div class="two-grid">
      <!-- Statistik Peminjaman Bulanan -->
      <div class="card">
        <h3 class="card-title">Statistik Peminjaman Bulanan</h3>
        <div class="chart-container">
          <div class="chart-item">
            <div class="chart-bar bar-monthly" style="height: 60%;">
              <div class="chart-value">12</div>
            </div>
            <div class="chart-label">Jan</div>
          </div>
          <div class="chart-item">
            <div class="chart-bar bar-monthly" style="height: 90%;">
              <div class="chart-value">18</div>
            </div>
            <div class="chart-label">Feb</div>
          </div>
          <div class="chart-item">
            <div class="chart-bar bar-monthly" style="height: 40%;">
              <div class="chart-value">8</div>
            </div>
            <div class="chart-label">Mar</div>
          </div>
          <div class="chart-item">
            <div class="chart-bar bar-monthly" style="height: 110%;">
              <div class="chart-value">22</div>
            </div>
            <div class="chart-label">Apr</div>
          </div>
          <div class="chart-item">
            <div class="chart-bar bar-monthly" style="height: 75%;">
              <div class="chart-value">15</div>
            </div>
            <div class="chart-label">Mei</div>
          </div>
          <div class="chart-item">
            <div class="chart-bar bar-monthly" style="height: 140%;">
              <div class="chart-value">28</div>
            </div>
            <div class="chart-label">Jun</div>
          </div>
        </div>
      </div>

      <!-- Gedung Terpopuler -->
      <div class="card">
        <h3 class="card-title">Gedung Terpopuler</h3>
        <div style="display: flex; flex-direction: column; gap: 16px;">
          <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 13px; color: #6b7280; min-width: 120px;">Aula Utama</span>
            <div style="flex: 1; height: 8px; background: #f3f4f6; border-radius: 4px;">
              <div style="width: 100%; height: 100%; background: linear-gradient(90deg, #3b82f6, #06b6d4); border-radius: 4px;"></div>
            </div>
            <span style="font-weight: 600; color: #1f2937; min-width: 32px; text-align: right;">45</span>
          </div>

          <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 13px; color: #6b7280; min-width: 120px;">Auditorium</span>
            <div style="flex: 1; height: 8px; background: #f3f4f6; border-radius: 4px;">
              <div style="width: 85%; height: 100%; background: linear-gradient(90deg, #3b82f6, #06b6d4); border-radius: 4px;"></div>
            </div>
            <span style="font-weight: 600; color: #1f2937; min-width: 32px; text-align: right;">38</span>
          </div>

          <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 13px; color: #6b7280; min-width: 120px;">Gedung B Lt.2</span>
            <div style="flex: 1; height: 8px; background: #f3f4f6; border-radius: 4px;">
              <div style="width: 60%; height: 100%; background: linear-gradient(90deg, #3b82f6, #06b6d4); border-radius: 4px;"></div>
            </div>
            <span style="font-weight: 600; color: #1f2937; min-width: 32px; text-align: right;">27</span>
          </div>

          <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 13px; color: #6b7280; min-width: 120px;">Lab Komputer A</span>
            <div style="flex: 1; height: 8px; background: #f3f4f6; border-radius: 4px;">
              <div style="width: 45%; height: 100%; background: linear-gradient(90deg, #3b82f6, #06b6d4); border-radius: 4px;"></div>
            </div>
            <span style="font-weight: 600; color: #1f2937; min-width: 32px; text-align: right;">20</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Riwayat Peminjaman -->
    <div class="card">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
        <h3 class="card-title" style="margin: 0;">Riwayat Peminjaman</h3>
        <button class="btn btn-primary">
          <i class="fas fa-download"></i>
          Export CSV
        </button>
      </div>

      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th style="min-width: 150px;">PEMINJAM</th>
              <th style="min-width: 150px;">GEDUNG</th>
              <th style="width: 120px;">TANGGAL</th>
              <th style="width: 100px;">STATUS</th>
            </tr>
          </thead>
          <tbody>
            @foreach($peminjamanData as $peminjaman)
            <tr>
              <td>
                <strong style="color: #1f2937;">{{ $peminjaman['peminjam'] }}</strong>
              </td>
              <td>{{ $peminjaman['gedung'] }}</td>
              <td>{{ $peminjaman['tanggal'] }}</td>
              <td>
                @if($peminjaman['status'] === 'Menunggu')
                  <span class="badge badge-warning">{{ $peminjaman['status'] }}</span>
                @elseif($peminjaman['status'] === 'Disetujui')
                  <span class="badge badge-success">{{ $peminjaman['status'] }}</span>
                @else
                  <span class="badge badge-danger">{{ $peminjaman['status'] }}</span>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection