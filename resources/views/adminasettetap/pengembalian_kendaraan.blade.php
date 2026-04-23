<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Pengembalian Kendaraan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
  :root {
    --blue: #4F6FFF;
    --sidebar-w: 240px;
    --radius: 16px;
    --bg: #F4F6FB;
    --surface: #FFFFFF;
    --text: #1E293B;
    --muted: #94A3B8;
    --border: #E8EDF5;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

  /* SIDEBAR */
  .sidebar {
    width: var(--sidebar-w);
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 0; left: 0; bottom: 0;
    z-index: 100;
  }
  .sidebar-logo {
    display: flex; align-items: center; gap: 10px;
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--border);
  }
  .logo-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, var(--blue), #7C3AED);
    display: flex; align-items: center; justify-content: center;
  }
  .logo-icon svg { width: 20px; height: 20px; fill: white; }
  .logo-text strong { font-size: 15px; font-weight: 800; color: var(--text); display: block; }
  .logo-text span { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 1px; }

  .sidebar-section { padding: 16px 16px 4px; }
  .sidebar-label { font-size: 10px; font-weight: 700; color: var(--muted); letter-spacing: 1.5px; text-transform: uppercase; padding: 0 4px 8px; }

  .role-badge {
    background: linear-gradient(135deg, #EEF2FF, #E0E7FF);
    border: 1px solid #C7D2FE;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 12px; font-weight: 700; color: var(--blue);
    margin: 0 16px 16px;
  }

  .nav { flex: 1; overflow-y: auto; padding: 4px 12px; }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px;
    border-radius: 10px;
    font-size: 13.5px; font-weight: 500;
    color: #64748B;
    cursor: pointer; transition: all .15s;
    margin-bottom: 2px;
  }
  .nav-item:hover { background: var(--bg); color: var(--text); }
  .nav-item.active { background: linear-gradient(135deg, #EEF2FF, #E0E7FF); color: var(--blue); font-weight: 700; }
  .nav-item svg { width: 17px; height: 17px; flex-shrink: 0; }
  .nav-item .chevron { margin-left: auto; width: 14px; height: 14px; }

  .sidebar-footer { border-top: 1px solid var(--border); padding: 14px 16px; }
  .user-info { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
  .user-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, var(--blue), #7C3AED);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 13px; font-weight: 700;
  }
  .user-detail strong { font-size: 13px; font-weight: 700; display: block; }
  .user-detail span { font-size: 11px; color: var(--muted); }
  .btn-logout {
    width: 100%; display: flex; align-items: center; justify-content: center; gap: 6px;
    padding: 8px; border-radius: 8px;
    border: 1px solid var(--border);
    background: transparent; color: #64748B;
    font-size: 13px; font-weight: 600; font-family: inherit;
    cursor: pointer; transition: all .15s;
  }
  .btn-logout:hover { background: #FEF2F2; color: #EF4444; border-color: #FECACA; }

  /* MAIN */
  .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

  .topbar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 0 28px;
    height: 56px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
  }
  .topbar-title { font-size: 16px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 16px; }
  .notif-btn {
    width: 36px; height: 36px; border-radius: 50%; border: 1px solid var(--border);
    background: var(--surface); display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative;
  }
  .notif-dot { width: 8px; height: 8px; background: #EF4444; border-radius: 50%; position: absolute; top: 6px; right: 6px; border: 2px solid white; }
  .date-text { font-size: 13px; color: #64748B; font-weight: 500; }
  .btn-keluar {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--surface); color: #64748B;
    font-size: 13px; font-weight: 600; font-family: inherit; cursor: pointer; transition: all .15s;
  }
  .btn-keluar:hover { background: #FEF2F2; color: #EF4444; }

  .content { padding: 28px; flex: 1; }

  /* PAGE HEADER */
  .page-top {
    display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;
  }
  .page-top h1 { font-size: 22px; font-weight: 800; color: var(--blue); margin-bottom: 4px; }
  .page-top p { font-size: 13px; color: var(--muted); }
  .btn-tambah {
    display: flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 10px;
    background: linear-gradient(135deg, var(--blue), #7C3AED);
    color: white; font-size: 13.5px; font-weight: 700;
    font-family: inherit; border: none; cursor: pointer;
    box-shadow: 0 4px 14px rgba(79,111,255,.35);
    transition: all .2s;
  }
  .btn-tambah:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,111,255,.45); }

  /* TABLE CARD */
  .table-card {
    background: var(--surface);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
  }

  .table-toolbar {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
  }
  .search-wrap {
    flex: 1; display: flex; align-items: center; gap: 8px;
    border: 1.5px solid var(--border); border-radius: 10px;
    padding: 8px 14px; background: var(--bg);
    transition: border-color .15s;
  }
  .search-wrap:focus-within { border-color: var(--blue); }
  .search-wrap input {
    border: none; background: none; outline: none;
    font-family: inherit; font-size: 13.5px; color: var(--text); width: 100%;
  }
  .search-wrap input::placeholder { color: var(--muted); }

  .filter-select {
    padding: 8px 14px; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--bg);
    font-family: inherit; font-size: 13px; color: var(--text);
    cursor: pointer; outline: none;
  }
  .filter-select:focus { border-color: var(--blue); }

  .btn-filter {
    display: flex; align-items: center; gap: 6px;
    padding: 8px 14px; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--bg);
    font-family: inherit; font-size: 13px; color: #64748B; cursor: pointer;
    transition: all .15s;
  }
  .btn-filter:hover { border-color: var(--blue); color: var(--blue); }

  table { width: 100%; border-collapse: collapse; }
  thead tr { background: #F8FAFF; }
  th {
    padding: 12px 20px;
    text-align: left;
    font-size: 11px; font-weight: 700;
    color: var(--blue); letter-spacing: .8px; text-transform: uppercase;
    border-bottom: 1px solid var(--border);
  }
  td {
    padding: 14px 20px;
    font-size: 13.5px; color: var(--text);
    border-bottom: 1px solid var(--border);
  }
  tr:last-child td { border-bottom: none; }
  tbody tr { transition: background .15s; }
  tbody tr:hover { background: #F8FAFF; }

  .status-badge {
    display: inline-block; padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
  }
  .status-diterima { background: #DCFCE7; color: #16A34A; }
  .status-pending { background: #FEF3C7; color: #D97706; }
  .status-ditolak { background: #FEE2E2; color: #DC2626; }
  .status-verified { background: #DBEAFE; color: var(--blue); }

  .action-btn {
    width: 32px; height: 32px; border-radius: 8px;
    border: 1px solid var(--border); background: var(--surface);
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .15s; margin-left: 4px;
  }
  .action-btn:hover { background: #EEF2FF; border-color: var(--blue); }
  .action-btn.danger:hover { background: #FEF2F2; border-color: #EF4444; }

  .photo-thumbnail {
    width: 40px; height: 40px; border-radius: 8px;
    object-fit: cover; border: 2px solid var(--border);
    cursor: pointer; transition: all .15s;
  }
  .photo-thumbnail:hover { transform: scale(1.05); border-color: var(--blue); }

  /* PAGINATION */
  .table-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px;
    border-top: 1px solid var(--border);
    font-size: 13px; color: var(--muted);
  }
  .pagination { display: flex; align-items: center; gap: 6px; }
  .page-btn {
    padding: 6px 12px; border-radius: 8px;
    border: 1px solid var(--border); background: var(--surface);
    font-family: inherit; font-size: 13px; color: #64748B;
    cursor: pointer; transition: all .15s;
  }
  .page-btn:hover { border-color: var(--blue); color: var(--blue); }
  .page-btn.active {
    background: var(--blue); border-color: var(--blue);
    color: white; font-weight: 700;
  }

  .kondisi-icon {
    font-size: 10px; margin-right: 3px;
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Pengembalian Kendaraan</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#94A3B8">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <div class="notif-dot"></div>
      </div>
      <span class="date-text">{{ date('d M Y, H:i') }}</span>
      <button class="btn-keluar">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="#64748B">
          <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5a2 2 0 00-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2z"/>
        </svg>
        Keluar
      </button>
    </div>
  </div>

  <div class="content">
    <div class="page-top">
      <div>
        <h1>Pengembalian Kendaraan</h1>
        <p>{{ $pengembalianKendaraan->count() ?? 0 }} data ditemukan</p>
      </div>
    </div>

    <div class="table-card">
      <div class="table-toolbar">
        <div class="search-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8"><path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 14z"/></svg>
          <input type="text" placeholder="Cari nomor polisi, peminjam, atau catatan...">
        </div>
        <select class="filter-select">
          <option>Semua Status</option>
          <option>Baik</option>
          <option>Rusak Ringan</option>
          <option>Rusak Berat</option>
          <option>Hilang/Kecelakaan</option>
        </select>
        <button class="btn-filter">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M4.25 5.61C6.27 8.2 10 13 10 13v6c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-6s3.72-4.8 5.74-7.39A1 1 0 0018.95 4H5.04a1 1 0 00-.79 1.61z"/></svg>
          Filter
        </button>
      </div>

      <table>
        <thead>
          <tr>
                        <th>No</th>
            <th>Kode Pengembalian</th>
            <th>Peminjaman Kendaraan</th>
            <th>No. Polisi</th>
            <th>Kondisi Kendaraan</th>
            <th>Tgl Pengembalian Aktual</th>
            <th>Peminjam</th>
            <th>Biaya Denda</th>
            <th>Status Pengembalian</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pengembalianKendaraan as $index => $item)
            <tr>
              <td><strong>{{ $index + 1 + ($pengembalianKendaraan->firstItem() - 1) }}</strong></td>
              <td><strong>{{ $item->kode_pengembalian ?? 'KND-RET-' . $item->id }}</strong></td>
              <td>
                <div style="font-weight:600;">{{ $item->peminjaman_kendaraan_id ?? '-' }}</div>
                <small style="color:#64748B;">{{ $item->peminjamanKendaraan->kendaraan->nama_kendaraan ?? '-' }}</small>
              </td>
              <td>
                <strong style="color: var(--blue);">{{ $item->peminjamanKendaraan->kendaraan->no_polisi ?? '-' }}</strong>
              </td>
              <td>
                @php 
                  $kondisi = strtolower($item->kondisi_kendaraan ?? ''); 
                  $kondisiIcon = [
                    'baik' => 'fa-car',
                    'rusak-ringan' => 'fa-tools',
                    'rusak-berat' => 'fa-wrench',
                    'hilang' => 'fa-exclamation-triangle',
                    'kecelakaan' => 'fa-car-crash'
                  ];
                @endphp
                @if($kondisi == 'baik')
                  <span class="status-badge status-diterima">
                    <i class="fas fa-car kondisi-icon" style="color:#16A34A;"></i>
                    Baik
                  </span>
                @elseif($kondisi == 'rusak-ringan')
                  <span class="status-badge status-pending">
                    <i class="fas fa-tools kondisi-icon" style="color:#D97706;"></i>
                    Rusak Ringan
                  </span>
                @elseif($kondisi == 'rusak-berat')
                  <span class="status-badge status-ditolak">
                    <i class="fas fa-wrench kondisi-icon" style="color:#DC2626;"></i>
                    Rusak Berat
                  </span>
                @elseif($kondisi == 'hilang')
                  <span class="status-badge status-ditolak">
                    <i class="fas fa-exclamation-triangle kondisi-icon" style="color:#DC2626;"></i>
                    Hilang
                  </span>
                @elseif($kondisi == 'kecelakaan')
                  <span class="status-badge status-ditolak">
                    <i class="fas fa-car-crash kondisi-icon" style="color:#DC2626;"></i>
                    Kecelakaan
                  </span>
                @else
                  <span class="status-badge status-pending">{{ ucfirst($kondisi) }}</span>
                @endif
              </td>
              <td>
                {{ $item->tanggal_pengembalian_aktual ? \Carbon\Carbon::parse($item->tanggal_pengembalian_aktual)->format('d/m/Y H:i') : '-' }}
              </td>
              <td>
                <div style="font-weight:600;">{{ $item->user->name ?? '-' }}</div>
                <small style="color:#64748B;">{{ $item->user->instansi ?? '-' }}</small>
              </td>
              <td>
                @if($item->biaya_denda > 0)
                  <strong style="color: var(--blue);">Rp {{ number_format($item->biaya_denda, 0, ',', '.') }}</strong>
                @else
                  <span style="color:#16A34A;">Rp 0</span>
                @endif
              </td>
              <td>
                @php $status = strtolower($item->status_pengembalian ?? 'pending') @endphp
                @switch($status)
                  @case('verified')
                    <span class="status-badge status-diterima">
                      <i class="fas fa-check-double" style="font-size:10px; margin-right:3px;"></i>
                      Terverifikasi
                    </span>
                    @break
                  @case('partial')
                    <span class="status-badge status-pending">
                      <i class="fas fa-minus-circle" style="font-size:10px; margin-right:3px;"></i>
                      Partial
                    </span>
                    @break
                  @case('rejected')
                    <span class="status-badge status-ditolak">
                      <i class="fas fa-times-circle" style="font-size:10px; margin-right:3px;"></i>
                      Ditolak
                    </span>
                    @break
                  @default
                    <span class="status-badge status-pending">
                      <i class="fas fa-clock" style="font-size:10px; margin-right:3px;"></i>
                      Menunggu
                    </span>
                @endswitch
              </td>
              <td>
                <a href="{{ route('admin.pengembalian-kendaraan.show', $item->id) }}" class="action-btn" title="Detail">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="#94A3B8">
                    <circle cx="12" cy="12" r="3.25"/>
                    <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                  </svg>
                </a>
                
                @if($item->status_pengembalian == 'pending')
                  <a href="{{ route('admin.pengembalian-kendaraan.edit', $item->id) }}" class="action-btn" title="Verifikasi">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="#94A3B8">
                      <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a1.5 1.5 0 0 0-2.12 0l-1.83 1.83 3.75 3.75 1.83-1.83c.39-.39.39-1.02 0-1.41z"/>
                    </svg>
                  </a>
                @endif
                
                @if($item->status_pengembalian != 'verified')
                  <button onclick="cetakLaporan({{ $item->id }})" class="action-btn" title="Cetak Laporan">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="#94A3B8">
                      <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-3-5H6V3h12v4z"/>
                    </svg>
                  </button>
                @endif

                @if($item->foto_sebelum || $item->foto_sesudah)
                  <div class="action-btn" title="Foto" onclick="showPhotos({{ $item->id }})">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="#94A3B8">
                      <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                    </svg>
                  </div>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="11" style="text-align:center; padding:60px; color:var(--muted);">
                <i class="fas fa-car" style="font-size:56px; margin-bottom:16px; opacity:.4;"></i>
                <div style="font-size:16px; font-weight:700; margin-bottom:6px;">Belum ada laporan pengembalian kendaraan</div>
                <div style="font-size:13px; max-width:300px; margin:0 auto;">Laporan pengembalian kendaraan akan muncul di sini setelah pengguna melaporkan pengembalian</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="table-footer">
        @if($pengembalianKendaraan->hasPages())
          <span>Menampilkan {{ $pengembalianKendaraan->firstItem() }}–{{ $pengembalianKendaraan->lastItem() }} dari {{ $pengembalianKendaraan->total() }} data</span>
        @else
          <span>Menampilkan {{ $pengembalianKendaraan->count() ?? 0 }} data</span>
        @endif
        <div class="pagination">
          @if($pengembalianKendaraan->onFirstPage())
            <button class="page-btn" disabled>Prev</button>
          @else
            <a href="{{ $pengembalianKendaraan->previousPageUrl() }}" class="page-btn">Prev</a>
          @endif

          @foreach($pengembalianKendaraan->getUrlRange(1, $pengembalianKendaraan->lastPage()) as $page => $url)
            @if($page == $pengembalianKendaraan->currentPage())
              <button class="page-btn active">{{ $page }}</button>
            @else
              <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
          @endforeach

          @if($pengembalianKendaraan->hasMorePages())
            <a href="{{ $pengembalianKendaraan->nextPageUrl() }}" class="page-btn">Next</a>
          @else
            <button class="page-btn" disabled>Next</button>
          @endif
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Modal Foto -->
<div id="photoModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:1000; justify-content:center; align-items:center;">
  <div style="position:relative; max-width:90%; max-height:90%;">
    <button onclick="closePhotoModal()" style="position:absolute; top:-10px; right:-10px; background:#EF4444; color:white; border:none; border-radius:50%; width:40px; height:40px; cursor:pointer; font-size:18px; font-weight:700;">×</button>
    <img id="modalPhoto" style="max-width:100%; max-height:100%; border-radius:12px;">
  </div>
</div>

<script>
function cetakLaporan(id) {
  window.open('/admin/pengembalian-kendaraan/' + id + '/cetak', '_blank');
}

function showPhotos(id) {
  // Fetch foto dari server via AJAX atau langsung tampilkan
  const modal = document.getElementById('photoModal');
  const img = document.getElementById('modalPhoto');
  
  // Contoh: ambil foto sebelum/sesudah berdasarkan ID
  fetch(`/admin/pengembalian-kendaraan/${id}/photos`)
    .then(response => response.json())
    .then(data => {
      if (data.foto_sebelum) {
        img.src = data.foto_sebelum;
        modal.style.display = 'flex';
      } else if (data.foto_sesudah) {
        img.src = data.foto_sesudah;
        modal.style.display = 'flex';
      }
    })
    .catch(() => {
      alert('Foto tidak ditemukan');
    });
}

function closePhotoModal() {
  document.getElementById('photoModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
  // Auto refresh setiap 30 detik untuk update status real-time
  setInterval(function() {
    location.reload();
  }, 30000);
  
  // Close modal on click outside
  document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) closePhotoModal();
  });
});
</script>

</body>
</html>