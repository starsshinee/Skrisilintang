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
    ['id' => 1, 'peminjam' => 'Dr. Budi Santoso', 'gedung' => 'Aula Utama', 'tanggal' => '2025-07-15', 'keterangan' => 'Seminar Nasional', 'status' => 'Menunggu', 'aksi' => ['check', 'delete']],
    ['id' => 2, 'peminjam' => 'HMTI', 'gedung' => 'Gedung B Lt.2', 'tanggal' => '2025-07-18', 'keterangan' => 'Workshop IoT', 'status' => 'Disetujui', 'aksi' => ['-', 'pdf']],
    ['id' => 3, 'peminjam' => 'Fak. Teknik', 'gedung' => 'Lab Komputer A', 'tanggal' => '2025-07-20', 'keterangan' => 'Ujian Praktikum', 'status' => 'Disetujui', 'aksi' => ['-', 'pdf']],
    ['id' => 4, 'peminjam' => 'BEM Universitas', 'gedung' => 'Auditorium', 'tanggal' => '2025-07-22', 'keterangan' => 'Dies Natalis', 'status' => 'Menunggu', 'aksi' => ['check', 'delete']],
    ['id' => 5, 'peminjam' => 'Prodi Manajemen', 'gedung' => 'Ruang Serbaguna C', 'tanggal' => '2025-07-10', 'keterangan' => 'Kuliah Tamu', 'status' => 'Ditolak', 'aksi' => ['-', 'pdf']],
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
    margin-bottom: 24px;
  }

  .page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px;
  }

  .page-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
  }

  .tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
  }

  .tab {
    padding: 12px 16px;
    border: none;
    background: none;
    color: #6b7280;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
  }

  .tab.active {
    color: #06b6d4;
  }

  .tab.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    height: 3px;
    background: #06b6d4;
    border-radius: 2px 2px 0 0;
  }

  .card {
    background: white;
    border-radius: 12px;
    padding: 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
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

  .action-btns {
    display: flex;
    gap: 8px;
    align-items: center;
  }

  .icon-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    background: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    font-size: 14px;
  }

  .icon-btn:hover {
    background: #f3f4f6;
  }

  .icon-btn.check {
    color: #16a34a;
  }

  .icon-btn.check:hover {
    background: #dcfce7;
  }

  .icon-btn.delete {
    color: #dc2626;
  }

  .icon-btn.delete:hover {
    background: #fee2e2;
  }

  .icon-btn.pdf {
    color: #06b6d4;
  }

  .icon-btn.pdf:hover {
    background: #cffafe;
  }

  .action-text {
    color: #9ca3af;
    font-size: 12px;
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
      <h1 class="page-title">Daftar Peminjaman</h1>
      <p class="page-subtitle">Kelola permintaan peminjaman gedung</p>
    </div>

    <div class="tabs">
      <button class="tab active">Semua</button>
      <button class="tab">Menunggu</button>
      <button class="tab">Disetujui</button>
      <button class="tab">Ditolak</button>
    </div>

    <div class="card">
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th style="width: 50px;">NO</th>
              <th style="min-width: 150px;">PEMINJAM</th>
              <th style="min-width: 150px;">GEDUNG</th>
              <th style="width: 120px;">TANGGAL</th>
              <th style="min-width: 150px;">KETERANGAN</th>
              <th style="width: 100px;">STATUS</th>
              <th style="width: 120px;">AKSI</th>
            </tr>
          </thead>
          <tbody>
            @foreach($peminjamanData as $index => $peminjaman)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>
                <strong style="color: #1f2937;">{{ $peminjaman['peminjam'] }}</strong>
              </td>
              <td>{{ $peminjaman['gedung'] }}</td>
              <td>{{ $peminjaman['tanggal'] }}</td>
              <td>{{ $peminjaman['keterangan'] }}</td>
              <td>
                @if($peminjaman['status'] === 'Menunggu')
                  <span class="badge badge-warning">{{ $peminjaman['status'] }}</span>
                @elseif($peminjaman['status'] === 'Disetujui')
                  <span class="badge badge-success">{{ $peminjaman['status'] }}</span>
                @else
                  <span class="badge badge-danger">{{ $peminjaman['status'] }}</span>
                @endif
              </td>
              <td>
                <div class="action-btns">
                  @if($peminjaman['aksi'][0] === 'check')
                    <button class="icon-btn check" title="Terima" onclick="alert('Peminjaman diterima')">
                      <i class="fas fa-check"></i>
                    </button>
                    <button class="icon-btn delete" title="Tolak" onclick="alert('Peminjaman ditolak')">
                      <i class="fas fa-times"></i>
                    </button>
                  @else
                    <span class="action-text">—</span>
                  @endif
                  
                  @if($peminjaman['aksi'][1] === 'pdf')
                    <button class="icon-btn pdf" title="Lihat Detail" onclick="alert('Membuka detail peminjaman')">
                      <i class="fas fa-file-pdf"></i>
                    </button>
                  @elseif($peminjaman['aksi'][1] === 'delete')
                    <button class="icon-btn delete" title="Hapus" onclick="alert('Menghapus peminjaman')">
                      <i class="fas fa-trash"></i>
                    </button>
                  @endif
                </div>
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