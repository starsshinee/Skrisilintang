<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Daftar Pengembalian Gedung</title>
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
    --success: #16A34A;
    --warning: #D97706;
    --danger: #DC2626;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }

  /* SIDEBAR - sama seperti template */
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
  .stats-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 12px; margin-bottom: 24px;
  }
  .stat-card {
    background: var(--surface); border-radius: var(--radius);
    border: 1px solid var(--border); padding: 16px 20px;
    text-align: center; transition: all .15s;
  }
  .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79,111,255,.1); }
  .stat-number { font-size: 24px; font-weight: 800; }
  .stat-number.menunggu { color: var(--warning); }
  .stat-number.disetujui { color: var(--success); }
  .stat-number.ditolak { color: var(--danger); }
  .stat-label { font-size: 11px; color: var(--muted); font-weight: 700; letter-spacing: .5px; margin-top: 4px; }

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
    display: inline-flex; align-items: center; gap: 4px;
    padding: 6px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
  }
  .status-menunggu { background: #FEF3C7; color: var(--warning); }
  .status-disetujui { background: #DCFCE7; color: var(--success); }
  .status-ditolak { background: #FEE2E2; color: var(--danger); }

  .kondisi-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 10px; border-radius: 12px;
    font-size: 11px; font-weight: 700;
  }
  .kondisi-baikt { background: #ECFDF5; color: var(--success); }
  .kondisi-ringan { background: #FEF3C7; color: var(--warning); }
  .kondisi-rusak { background: #FEE2E2; color: var(--danger); }

  .action-btn {
    width: 34px; height: 34px; border-radius: 8px;
    border: 1px solid var(--border); background: var(--surface);
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .15s; margin-left: 4px; text-decoration: none;
  }
  .action-btn:hover { background: #EEF2FF; border-color: var(--blue); color: var(--blue) !important; }
  .action-btn.danger:hover { background: #FEF2F2; border-color: var(--danger); color: var(--danger) !important; }

  .photo-thumbnail {
    width: 44px; height: 44px; border-radius: 8px;
    object-fit: cover; border: 2px solid var(--border);
    cursor: pointer; transition: all .15s;
  }
  .photo-thumbnail:hover { transform: scale(1.05); border-color: var(--blue); }

  .verifikator-info {
    font-size: 11px; font-weight: 600; color: var(--blue);
  }
  .verifikasi-waktu {
    font-size: 10px; color: var(--muted); margin-top: 2px;
  }

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
    cursor: pointer; transition: all .15s; text-decoration: none;
  }
  .page-btn:hover { border-color: var(--blue); color: var(--blue); }
  .page-btn.active {
    background: var(--blue); border-color: var(--blue);
    color: white; font-weight: 700;
  }

  .empty-state {
    text-align: center; padding: 80px 20px;
  }
  .empty-icon { font-size: 64px; color: #D1D5DB; margin-bottom: 20px; }
  .empty-title { font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px; }
  .empty-text { font-size: 14px; color: var(--muted); max-width: 400px; margin: 0 auto; }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Daftar Pengembalian Gedung</span>
    <div class="topbar-right">
      <div class="notif-btn" title="Notifikasi"></div>        <i class="fas fa-bell"></i>
        <div class="notif-dot"></div>
      </div>
      <span class="date-text">{{ date('d M Y, H:i') }}</span>
      <button class="btn-keluar">
        <i class="fas fa-sign-out-alt"></i>
        Keluar
      </button>
    </div>
  </div>

  <div class="content">
    <!-- STATISTICS -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number menunggu">{{ $pengembalianGedung->where('status_verifikasi', 'menunggu')->count() }}</div>
        <div class="stat-label">Menunggu Verifikasi</div>
      </div>
      <div class="stat-card">
        <div class="stat-number disetujui">{{ $pengembalianGedung->where('status_verifikasi', 'disetujui')->count() }}</div>
        <div class="stat-label">Disetujui</div>
      </div>
      <div class="stat-card">
        <div class="stat-number ditolak">{{ $pengembalianGedung->where('status_verifikasi', 'ditolak')->count() }}</div>
        <div class="stat-label">Ditolak</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" style="color: var(--blue);">{{ $pengembalianGedung->total() }}</div>
        <div class="stat-label">Total</div>
      </div>
    </div>

    <div class="page-top">
      <div>
        <h1>Pengembalian Gedung</h1>
        <p>{{ $pengembalianGedung->total() }} data ditemukan</p>
      </div>
    </div>

    <div class="table-card">
      <div class="table-toolbar">
        <div class="search-wrap">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Cari kode peminjaman, nama gedung, atau instansi...">
        </div>
        <select class="filter-select">
          <option>Semua Status</option>
          <option>Menunggu Verifikasi</option>
          <option>Disetujui</option>
          <option>Ditolak</option>
        </select>
        <select class="filter-select">
          <option>Semua Kondisi</option>
          <option>Baik</option>
          <option>Ringan</option>
          <option>Rusak</option>
        </select>
        <button class="btn-filter">
          <i class="fas fa-filter"></i>
          Filter
        </button>
      </div>

      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Peminjaman</th>
            <th>Nama Gedung</th>
            <th>Tgl & Jam Kembali</th>
            <th>Kondisi Gedung</th>
            <th>Instansi</th>
            <th>Denda</th>
            <th>Status Verifikasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pengembalianGedung as $index => $item)
            <tr>
              <td><strong>{{ $index + 1 + ($pengembalianGedung->firstItem() - 1) }}</strong></td>
              <td>
                <strong style="color: var(--blue);">{{ $item->peminjaman->kode_peminjaman ?? '-' }}</strong>
                <br><small style="color: var(--muted);">{{ $item->peminjaman->nama_gedung ?? '-' }}</small>
              </td>
              <td>{{ $item->peminjaman->instansi ?? '-' }}</td>
              <td>
                <div style="font-weight: 600;">
                  {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}
                </div>
                <div style="font-size: 12px; color: var(--muted);">
                  {{ $item->jam_pengembalian ?? '-' }}
                </div>
              </td>
              <td>
                @php
                  $kondisi = $item->kondisi_gedung;
                  $kondisiLabel = [
                    'baik' => ['label' => 'Baik', 'class' => 'baikt'],
                    'ringan' => ['label' => 'Ringan', 'class' => 'ringan'],
                    'rusak' => ['label' => 'Rusak', 'class' => 'rusak']
                  ];
                  $badge = $kondisiLabel[$kondisi] ?? ['label' => 'Unknown', 'class' => ''];
                @endphp
                <span class="kondisi-badge kondisi-{{ $badge['class'] }}">
                  <i class="fas @if($kondisi=='baik')fa-check-circle @elseif($kondisi=='ringan')fa-tools @else fa-exclamation-triangle @endif kondisi-icon"></i>
                  {{ $badge['label'] }}
                </span>
                @if($item->catatan_pengembalian)
                  <div style="font-size: 11px; color: var(--muted); margin-top: 4px; max-width: 200px;">
                    {{ Str::limit($item->catatan_pengembalian, 60) }}
                  </div>
                @endif
              </td>
              <td>
                <div style="font-weight: 600;">{{ $item->peminjaman->instansi ?? '-' }}</div>
              </td>
              <td>
                @if($item->denda_akhir > 0)
                  <strong style="color: var(--danger);">Rp {{ number_format($item->denda_akhir, 0, ',', '.') }}</strong>
                @else
                  <span style="color: var(--success);">Rp 0</span>
                @endif
              </td>
              <td>
                @php $status = $item->status_verifikasi @endphp
                <span class="status-badge status-{{ $status }}">
                  <i class="fas @if($status=='menunggu')fa-clock @elseif($status=='disetujui')fa-check-double @else fa-times-circle @endif" style="font-size: 10px;"></i>
                  {{ ucfirst($status) }}
                </span>
                
                @if($item->admin_sarpras_id && $item->waktu_verifikasi)
                  <div class="verifikator-info">
                    {{ $item->adminSarpras->nama ?? 'Admin' }}
                  </div>
                  <div class="verifikasi-waktu">
                    {{ \Carbon\Carbon::parse($item->waktu_verifikasi)->diffForHumans() }}
                  </div>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.pengembalian-gedung.show', $item->id) }}" class="action-btn" title="Detail">
                  <i class="fas fa-eye"></i>
                </a>
                
                @if($item->status_verifikasi == 'menunggu')
                  <a href="{{ route('admin.pengembalian-gedung.edit', $item->id) }}" class="action-btn" title="Verifikasi">
                    <i class="fas fa-check-circle"></i>
                  </a>
                @endif
                
                <button onclick="cetakLaporan({{ $item->id }})" class="action-btn" title="Cetak Laporan">
                  <i class="fas fa-print"></i>
                </button>

                @if($item->foto_kondisi && count($item->foto_kondisi) > 0)
                  <div style="display: inline-block; position: relative;">
                    <img src="{{ asset('storage/' . $item->foto_kondisi[0]) }}" 
                         alt="Foto Kondisi" class="photo-thumbnail" 
                         onclick="openPhotoModal({{ $item->id }})" 
                         title="Lihat foto kondisi">
                    @if(count($item->foto_kondisi) > 1)
                      <span style="position: absolute; bottom: 2px; right: 2px; background: rgba(0,0,0,0.7); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center;">+{{ count($item->foto_kondisi) - 1 }}</span>
                    @endif
                  </div>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="empty-state">
                <i class="fas fa-warehouse" class="empty-icon"></i>
                <div class="empty-title">Belum ada laporan pengembalian gedung</div>
                <div class="empty-text">Laporan pengembalian gedung akan muncul di sini setelah tamu melaporkan pengembalian gedung.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <!-- PAGINATION -->
      @if($pengembalianGedung->hasPages())
      <div class="table-footer">
        <span>Menampilkan {{ $pengembalianGedung->firstItem() }}–{{ $pengembalianGedung->lastItem() }} dari {{ $pengembalianGedung->total() }} data</span>
        <div class="pagination">
          @if($pengembalianGedung->onFirstPage())
            <button class="page-btn" disabled><i class="fas fa-chevron-left"></i></button>
          @else
            <a href="{{ $pengembalianGedung->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
          @endif

          @foreach($pengembalianGedung->getUrlRange(1, $pengembalianGedung->lastPage()) as $page => $url)
            @if($page == $pengembalianGedung->currentPage())
              <button class="page-btn active">{{ $page }}</button>
            @else
              <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
          @endforeach

          @if($pengembalianGedung->hasMorePages())
            <a href="{{ $pengembalianGedung->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
          @else
            <button class="page-btn" disabled><i class="fas fa-chevron-right"></i></button>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</main>

<!-- PHOTO MODAL -->
<div id="photoModal" style="
  display:none; position:fixed; top:0; left:0; width:100%; height:100%;
  background:rgba(0,0,0,0.9); z-index:10000; align-items:center; justify-content:center;
">
  <div style="position:relative; max-width:90%; max-height:90%;">
    <button onclick="closePhotoModal()" style="
      position:absolute; top:-50px; right:0; background:none; border:none;
      color:white; font-size:30px; cursor:pointer;
    ">×</button>
    <img id="modalImage" style="max-width:100%; max-height:100%; border-radius:12px;">
  </div>
</div>

<script>
function cetakLaporan(id) {
  window.open('/admin/pengembalian-gedung/' + id + '/cetak', '_blank');
}

function openPhotoModal(id) {
  // Fetch foto dari server via AJAX
  fetch(`/admin/pengembalian-gedung/${id}/photos`)
    .then(response => response.json())
    .then(photos => {
      if (photos.length > 0) {
        document.getElementById('modalImage').src = photos[0];
        document.getElementById('photoModal').style.display = 'flex';
      }
    });
}

function closePhotoModal() {
  document.getElementById('photoModal').style.display = 'none';
}

// Close modal on click outside
document.getElementById('photoModal').addEventListener('click', function(e) {
  if (e.target === this) closePhotoModal();
});

// Auto refresh setiap 1 menit untuk update status real-time
setInterval(function() {
  if (document.visibilityState === 'visible') {
    location.reload();
  }
}, 60000);

// Search & Filter real-time
document.querySelector('.search-wrap input').addEventListener('input', function() {
  // Implementasi search AJAX
  console.log('Searching for:', this.value);
});
</script>

</body>
</html>
      