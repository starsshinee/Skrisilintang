<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Kerusakan - Admin Sarana Prasarana</title>
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

  .sidebar {
    width: var(--sidebar-width); background: var(--sidebar-bg);
    border-right: 1px solid var(--border); display: flex; flex-direction: column;
    position: fixed; top: 0; left: 0; bottom: 0; z-index: 100;
  }
  .sidebar-brand {
    display: flex; align-items: center; gap: 12px;
    padding: 20px 20px 16px; border-bottom: 1px solid var(--border);
  }
  .brand-icon {
    width: 44px; height: 44px; background: var(--primary);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
  }
  .brand-text strong { font-size: 13px; font-weight: 700; display: block; }
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

  .main { margin-left: var(--sidebar-width); flex: 1; display: flex; flex-direction: column; }
  .topbar {
    background: var(--card-bg);
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
    background: var(--card-bg); display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative;
  }
  .notif-dot { width: 8px; height: 8px; background: #EF4444; border-radius: 50%; position: absolute; top: 6px; right: 6px; border: 2px solid white; }
  .date-text { font-size: 13px; color: #64748B; font-weight: 500; }
  .btn-keluar {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--card-bg); color: #64748B;
    font-size: 13px; font-weight: 600; font-family: inherit; cursor: pointer; transition: all .15s;
  }
  .btn-keluar:hover { background: #FEF2F2; color: #EF4444; }

  .content { padding: 28px; flex: 1; }
  .empty-state {
    text-align: center; padding: 60px 20px; color: var(--text-secondary);
  }
  .empty-state svg { width: 64px; height: 64px; margin: 0 auto 20px; opacity: .5; }
  .empty-state h3 { font-size: 18px; font-weight: 600; margin-bottom: 8px; color: var(--text-primary); }

  /* Toolbar */
  .toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
  }
  .search-wrap {
    position: relative; width: 320px;
  }
  .search-wrap svg {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    width: 16px; height: 16px; color: var(--text-secondary);
  }
  .search-input {
    width: 100%; padding: 10px 12px 10px 38px;
    border: 1px solid var(--border); border-radius: 10px;
    font-family: inherit; font-size: 13px; color: var(--text-primary);
    background: var(--card-bg); outline: none; transition: border .2s;
  }
  .search-input:focus { border-color: var(--primary); }
  .search-input::placeholder { color: var(--text-secondary); }
  .btn-primary {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 18px; background: var(--primary); color: #fff;
    border: none; border-radius: 10px; font-family: inherit;
    font-size: 14px; font-weight: 600; cursor: pointer; transition: background .2s;
  }
  .btn-primary:hover { background: #3251d4; }

  /* Table */
  .table-card {
    background: var(--card-bg); border-radius: 16px;
    border: 1px solid var(--border); overflow: hidden;
  }
  table { width: 100%; border-collapse: collapse; }
  thead th {
    font-size: 12px; font-weight: 600; color: var(--text-secondary);
    padding: 12px 16px; text-align: left; border-bottom: 1px solid var(--border);
    text-transform: uppercase; letter-spacing: .05em; background: #fafbff;
  }
  tbody td { padding: 14px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #fafbff; }

  .status-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
  }
  .badge-baik { background: var(--success-light); color: var(--success); }
  .badge-rusak-ringan { background: var(--warning-light); color: var(--warning); }
  .badge-rusak-sedang { background: #fff3cd; color: #856404; }
  .badge-rusak-berat { background: var(--danger-light); color: var(--danger); }
  .badge-hancur { background: #fee2e2; color: #dc2626; font-weight: 700; }

  .action-btns { display: flex; gap: 8px; }
  .act-btn {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; border: 1px solid var(--border); background: #fff;
    transition: all .2s;
  }
  .act-btn:hover { transform: scale(1.05); }
  .act-btn.photo { color: #6b7280; }
  .act-btn.view { color: var(--primary); border-color: #c7d2fe; background: var(--primary-light); }
  .act-btn.del { color: var(--danger); border-color: #fecaca; background: var(--danger-light); }
  .photo-thumbnail { width: 40px; height: 40px; object-fit: cover; border-radius: 6px; }

  /* Modal */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.4);
    display: none; align-items: center; justify-content: center; z-index: 200;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: #fff; border-radius: 16px; padding: 28px;
    width: 500px; max-width: 90vw; max-height: 90vh; overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
  }
  .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
  .form-group { margin-bottom: 16px; }
  .form-label { font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block; }
  .form-input, .form-select {
    width: 100%; padding: 10px 14px; border: 1px solid var(--border);
    border-radius: 10px; font-family: inherit; font-size: 13px; outline: none;
    transition: border .2s; background: var(--card-bg);
  }
  .form-input:focus, .form-select:focus { border-color: var(--primary); }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .form-textarea { min-height: 80px; resize: vertical; }
  .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
  .btn-cancel {
    padding: 10px 18px; border: 1px solid var(--border); border-radius: 10px;
    font-family: inherit; font-size: 14px; cursor: pointer; background: #fff;
    font-weight: 500; color: var(--text-secondary);
  }
  .file-input-wrapper {
    position: relative; overflow: hidden; display: inline-block; width: 100%;
  }
  .file-input-wrapper input[type=file] {
    position: absolute; left: -9999px;
  }
  .file-input-label {
    display: block; padding: 10px 14px; border: 1px solid var(--border);
    border-radius: 10px; background: var(--card-bg); cursor: pointer;
    text-align: center; transition: all .2s; font-size: 13px;
  }
  .file-input-label:hover { border-color: var(--primary); background: var(--primary-light); }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Data Kerusakan</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</span>
      <a href="{{ route('logout') }}" class="btn-keluar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 11H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2z"/></svg>
        Keluar
      </a>
    </div>
  </div>
  
  <div class="content">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="background: var(--success-light); color: var(--success); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid var(--success);">
      {{ session('success') }}
      <button type="button" class="btn-close" style="float: right; background: none; border: none; font-size: 18px; cursor: pointer;" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background: var(--danger-light); color: var(--danger); padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid var(--danger);">
      {{ session('error') }}
      <button type="button" class="btn-close" style="float: right; background: none; border: none; font-size: 18px; cursor: pointer;" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
    @endif

    <div class="toolbar">
      <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input class="search-input" type="text" placeholder="Cari kerusakan barang..." id="searchInput" oninput="filterTable()">
      </div>
      <a href="/tambah-kerusakan" class="btn-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 5v14m-7-7h14"/></svg>
        Tambah Data
      </a>
    </div>

    <div class="table-card">
      @if($kerusakans->count() > 0)
      <table id="kerusakanTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Input</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th>NUP</th>
            <th>Kondisi</th>
            <th>Foto</th>
            <th>Lokasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach($kerusakans as $index => $kerusakan)
          <tr data-kode="{{ $kerusakan->kode_barang }}" data-nama="{{ $kerusakan->nama_barang }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ \Carbon\Carbon::parse($kerusakan->tanggal_input)->format('d/m/Y') }}</td>
            <td>{{ $kerusakan->nama_barang }}</td>
            <td><strong>{{ $kerusakan->kode_barang }}</strong></td>
            <td>{{ $kerusakan->nup }}</td>
            <td>
            @php
                $kondisiClass = match($kerusakan->kondisi) {
                    'Baik' => 'badge-baik',
                    'Rusak Ringan' => 'badge-rusak-ringan',
                    'Rusak Sedang' => 'badge-rusak-sedang',
                    'Rusak Berat' => 'badge-rusak-berat',
                    'Hancur' => 'badge-hancur',
                    default => 'badge-rusak-sedang'
                };
              @endphp
              <span class="status-badge {{ $kondisiClass }}">{{ $kerusakan->kondisi }}</span>
            </td>
            <td>
              @if($kerusakan->foto)
                @if(file_exists(public_path('storage/' . $kerusakan->foto)))
                  <img src="{{ asset('storage/' . $kerusakan->foto) }}" alt="Foto" class="photo-thumbnail" 
                       onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                  <div class="act-btn photo" style="display: none;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                      <rect x="3" y="3" width="18" height="18" rx="2"/>
                      <circle cx="8.5" cy="8.5" r="1.5"/>
                      <path d="m21 15-5-5L5 21"/>
                    </svg>
                  </div>
                @else
                  <div class="act-btn photo">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                      <rect x="3" y="3" width="18" height="18" rx="2"/>
                      <circle cx="8.5" cy="8.5" r="1.5"/>
                      <path d="m21 15-5-5L5 21"/>
                    </svg>
                  </div>
                @endif
              @else
                <div class="act-btn photo">
                  <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="m21 15-5-5L5 21"/>
                  </svg>
                </div>
              @endif
            </td>
            <td>{{ $kerusakan->lokasi }}</td>
            <td>
              <div class="action-btns">
                {{-- <a href="{{ route('kerusakan.show', $kerusakan->id) }}" class="act-btn view" title="Lihat Detail"> --}}
                  <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </a>
                <a href="{{ route('kerusakan.edit', $kerusakan->id) }}" class="act-btn" title="Edit" style="color: #10b981; border-color: #a7f3d0; background: #ecfdf5;">
                  <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </a>
                <form action="{{ route('kerusakan.destroy', $kerusakan->id) }}" method="POST" class="delete-form" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="act-btn del" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                      <polyline points="3 6 5 6 21 6"/>
                      <path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/>
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2zm0 0V9a2 2 0 0 0 2-2h2a2 2 0 0 1 2 2v10m-6 0a2 2 0 0 0 2 2h.01M9 19h.01"/>
        </svg>
        <h3>Belum ada data kerusakan</h3>
        <p>Tambahkan data kerusakan barang pertama Anda</p>
      </div>
      @endif
    </div>

    <!-- Pagination -->
    @if($kerusakans->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
      {{ $kerusakans->links('pagination::bootstrap-5') }}
    </div>
    @endif
  </div>
</main>

<script>
function filterTable() {
  const query = document.getElementById('searchInput').value.toLowerCase();
  const rows = document.querySelectorAll('#tableBody tr');
  
  rows.forEach(row => {
    const kode = row.dataset.kode?.toLowerCase() || '';
    const nama = row.dataset.nama?.toLowerCase() || '';
    row.style.display = (kode.includes(query) || nama.includes(query)) ? '' : 'none';
  });
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      alert.style.transition = 'opacity 0.3s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 300);
    }, 5000);
  });
});
</script>
</body>
</html>