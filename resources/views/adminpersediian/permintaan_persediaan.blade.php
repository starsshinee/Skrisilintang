<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Persediaan - Permintaan Persediaan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root {
  --primary: #2563eb;
  --primary-light: #3b82f6;
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #06b6d4;
  --bg: #f8fafc;
  --card-bg: #ffffff;
  --text-primary: #0f172a;
  --text-secondary: #64748b;
  --border: #e2e8f0;
  --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --radius: 12px;
}

* { margin: 0; padding: 0; box-sizing: border-box; }
body { 
  font-family: 'Plus Jakarta Sans', sans-serif; 
  background: var(--bg); 
  color: var(--text-primary);
  line-height: 1.6;
}

.main { padding: 24px; max-width: 1400px; margin: 0 auto; }
.topbar {
  display: flex; align-items: center; justify-content: space-between; 
  margin-bottom: 32px; padding: 20px 0;
  background: var(--card-bg); border-radius: var(--radius); 
  box-shadow: var(--shadow);
}
.topbar-title { 
  font-family: 'Space Grotesk', sans-serif; 
  font-size: 24px; font-weight: 700; color: var(--text-primary);
}
.topbar-right { display: flex; align-items: center; gap: 16px; }
.notif-btn {
  width: 44px; height: 44px; border-radius: 12px; 
  background: #f1f5f9; display: grid; place-items: center; 
  cursor: pointer; position: relative; transition: all 0.2s;
}
.notif-btn:hover { background: #e2e8f0; }
.notif-dot {
  position: absolute; top: 8px; right: 8px; 
  width: 8px; height: 8px; background: var(--danger); 
  border-radius: 50%; border: 2px solid var(--card-bg);
}
.date-text { font-size: 14px; color: var(--text-secondary); }
.btn-keluar {
  display: flex; align-items: center; gap: 8px; 
  padding: 10px 20px; background: var(--danger); 
  color: white; border: none; border-radius: 10px; 
  font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-keluar:hover { background: #dc2626; transform: translateY(-1px); }

.content { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; }
.page-top {
  padding: 28px 32px; border-bottom: 1px solid var(--border); 
  display: flex; align-items: center; justify-content: space-between;
}
.page-top h1 { font-size: 28px; font-weight: 700; margin-bottom: 4px; }
.page-top p { color: var(--text-secondary); font-size: 14px; }
.btn-tambah {
  display: flex; align-items: center; gap: 8px; 
  padding: 12px 24px; background: var(--primary); 
  color: white; border: none; border-radius: 10px; 
  font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-tambah:hover { background: var(--primary-light); transform: translateY(-2px); }

.table-card { overflow: hidden; }
.table-toolbar {
  padding: 24px 32px; border-bottom: 1px solid var(--border); 
  display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.search-wrap {
  flex: 1; min-width: 300px; max-width: 400px; 
  display: flex; align-items: center; gap: 12px; 
  padding: 12px 16px; background: #f8fafc; 
  border: 1px solid var(--border); border-radius: 10px;
}
.search-wrap svg { color: var(--text-secondary); }
.search-wrap input {
  flex: 1; border: none; outline: none; 
  font-size: 14px; background: transparent;
}
.filter-select {
  padding: 12px 16px; border: 1px solid var(--border); 
  border-radius: 10px; background: white; font-size: 14px;
  min-width: 160px;
}
.btn-filter {
  display: flex; align-items: center; gap: 8px; 
  padding: 12px 20px; background: #f1f5f9; 
  border: 1px solid var(--border); border-radius: 10px; 
  color: var(--text-secondary); cursor: pointer; transition: all 0.2s;
}
.btn-filter:hover { background: #e2e8f0; }

table {
  width: 100%; border-collapse: collapse; 
  font-size: 14px; background: var(--card-bg);
}
th {
  text-align: left; padding: 20px 32px; 
  font-weight: 600; color: var(--text-secondary); 
  font-size: 12px; text-transform: uppercase; 
  letter-spacing: 0.5px; border-bottom: 2px solid #f1f5f9;
  white-space: nowrap;
}
td { padding: 20px 32px; border-bottom: 1px solid #f8fafc; vertical-align: middle; white-space: nowrap;}
tr:hover { background: #f8fafc; }

.status-badge {
  padding: 6px 12px; border-radius: 20px; 
  font-size: 12px; font-weight: 600; 
  display: inline-flex; align-items: center; gap: 4px;
}
.status-diterima { 
  background: rgba(16,185,129,0.1); color: var(--success); 
  border: 1px solid rgba(16,185,129,0.2);
}
.status-pending { 
  background: rgba(245,158,11,0.1); color: var(--warning); 
  border: 1px solid rgba(245,158,11,0.2);
}
.status-ditolak { 
  background: rgba(239,68,68,0.1); color: var(--danger); 
  border: 1px solid rgba(239,68,68,0.2);
}
.status-review { 
  background: rgba(6,182,212,0.1); color: var(--info); 
  border: 1px solid rgba(6,182,212,0.2);
}

.action-btn {
  width: 40px; height: 40px; border-radius: 10px; 
  border: none; background: #f8fafc; 
  display: grid; place-items: center; cursor: pointer; 
  transition: all 0.2s; margin-left: 4px;
}
.action-btn:hover { background: #e2e8f0; transform: translateY(-1px); }
.action-btn.danger:hover { background: #fef2f2; }
.action-btn.edit:hover { background: #eff6ff; }
.action-btn svg { color: var(--text-secondary); }

.table-footer {
  padding: 24px 32px; border-top: 1px solid var(--border); 
  display: flex; align-items: center; justify-content: space-between;
}
.pagination {
  display: flex; align-items: center; gap: 8px;
}
.page-btn {
  padding: 8px 12px; border: 1px solid var(--border); 
  background: white; border-radius: 8px; 
  cursor: pointer; transition: all 0.2s;
}
.page-btn:hover:not(.active) { background: #f1f5f9; }
.page-btn.active { 
  background: var(--primary); color: white; 
  border-color: var(--primary);
}

@media (max-width: 768px) {
  .main { padding: 16px; }
  .table-toolbar { flex-direction: column; align-items: stretch; gap: 12px; }
  .search-wrap { min-width: auto; }
  th, td { padding: 16px 12px; font-size: 13px; }
  .page-top { flex-direction: column; gap: 16px; text-align: center; }
}
.table-responsive {
  width: 100%;
  overflow-x: auto; /* Ini yang memunculkan scrollbar horizontal */
  -webkit-overflow-scrolling: touch;
}
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Permintaan Persediaan</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn-keluar">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 11H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2z"/>
          </svg>
          Keluar
        </button>
      </form>
    </div>
  </div>

  <div class="content">
    <div class="page-top">
      <div>
        <h1>Permintaan Persediaan</h1>
        <p>{{ $permintaan->total() }} data ditemukan {{ $permintaan->hasPages() ? '(Halaman ' . $permintaan->currentPage() . ')' : '' }}</p>
      </div>
    </div>

    <div class="table-card">
      <div class="table-toolbar">
        <div class="search-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8">
            <path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
          </svg>
          <input type="text" placeholder="Cari nama barang, pemohon..." value="{{ request('search') }}">
        </div>
        
        <form method="GET" class="filter-form">
          <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="dalam_review" {{ request('status') == 'dalam_review' ? 'selected' : '' }}>Dalam Review</option>
            <option value="disetujui_kasubag" {{ request('status') == 'disetujui_kasubag' ? 'selected' : '' }}>Disetujui Kasubag</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
          </select>
          @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
          @endif
        </form>
      </div>

      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th width="60">No</th>
              <th>Nama Barang</th>
              <th width="120">Kode Barang</th>
              <th>Pemohon</th>
              <th width="100">Jumlah</th>
              <th width="140">Tgl Permintaan</th>
              <th width="140">Tgl Dibutuhkan</th>
              <th>Tujuan Penggunaan</th>
              <th width="120">Status</th>
              <th width="180">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($permintaan as $index => $item)
              <tr>
                <td><strong>{{ ($permintaan->currentPage() - 1) * $permintaan->perPage() + $index + 1 }}</strong></td>
                <td>
                  <div style="font-weight: 600; color: var(--text-primary);">{{ $item->persediaan->nama_barang ?? $item->nama_barang }}</div>
                  @if($item->persediaan)
                    <small style="color: var(--text-secondary);">{{ $item->persediaan->kategori }}</small>
                  @endif
                </td>
                <td>
                  <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 12px;">
                    {{ $item->persediaan->kode_barang ?? '-' }}
                  </code>
                </td>
                <td>
                  <div>{{ $item->nama_lengkap }}</div>
                  <small style="color: var(--text-secondary);">{{ $item->user->name ?? '-' }}</small>
                </td>
                <td>
                  <strong style="color: var(--primary);">{{ $item->jumlah_diminta }}</strong>
                  <br><small>Stok: {{ $item->persediaan->jumlah ?? 0 }}</small>
                </td>
                <td>{{ $item->tanggal_permintaan->format('d M Y') }}</td>
                <td>
                  <strong style="color: var(--warning);">{{ $item->tanggal_dibutuhkan->format('d M Y') }}</strong>
                </td>
                <td style="max-width: 200px;">
                  {{ Str::limit($item->tujuan_penggunaan, 60) }}
                  @if(strlen($item->tujuan_penggunaan) > 60)
                    <br><small style="color: var(--text-secondary);">...</small>
                  @endif
                </td>
                <td>
                  @php $badge = $item->status_badge; @endphp
                  <span class="status-badge status-{{ $badge['color'] }}">
                    <i class="fas fa-{{ $badge['icon'] }}"></i>
                    {{ $badge['text'] }}
                  </span>
                </td>
                <td>
                  @if($item->status === 'pending')
                    {{-- FORM TERUSKAN KE KASUBAG --}}
                    <form action="{{ route('adminpersediaan.review-permintaan', $item) }}" method="POST" style="display: inline-block;" 
                          class="action-form" title="Teruskan ke Kasubag">
                      @csrf
                      <input type="hidden" name="action" value="teruskan">
                      <button type="submit" class="action-btn" style="background: rgba(16,185,129,0.1);">
                        <i class="fas fa-forward" style="font-size: 12px; color: var(--success);"></i>
                      </button>
                    </form>
                    
                    {{-- FORM TOLAK --}}
                    <form action="{{ route('adminpersediaan.review-permintaan', $item) }}" method="POST" style="display: inline-block;" 
                          class="action-form" title="Tolak Permintaan" 
                          onclick="return confirm('Yakin menolak permintaan ini?')">
                      @csrf
                      <input type="hidden" name="action" value="tolak">
                      <button type="submit" class="action-btn danger">
                        <i class="fas fa-times" style="font-size: 12px; color: var(--danger);"></i>
                      </button>
                    </form>
                  @elseif(in_array($item->status, ['dalam_review', 'disetujui_kasubag']))
                    {{-- DOWNLOAD SURAT --}}
                    <a href="{{ route('adminpersediaan.surat-permintaan', $item) }}" 
                       class="action-btn" style="background: rgba(37,99,235,0.1);" title="Download Surat Permintaan">
                      <i class="fas fa-file-pdf" style="font-size: 12px; color: var(--primary);"></i>
                    </a>
                  @endif

                  {{-- DETAIL --}}
                  <button class="action-btn" onclick="showDetail({{ $item->id }})" title="Lihat Detail">
                    <i class="fas fa-eye" style="font-size: 12px;"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="10" style="text-align: center; padding: 60px; color: var(--text-secondary);">
                  <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                  <div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">Belum ada permintaan persediaan</div>
                  <div>Permintaan pertama akan muncul di sini</div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($permintaan->hasPages())
      <div class="table-footer">
        <span>Menampilkan {{ ($permintaan->currentPage() - 1) * $permintaan->perPage() + 1 }}–{{ min($permintaan->total(), $permintaan->currentPage() * $permintaan->perPage()) }} dari {{ $permintaan->total() }} data</span>
        <div class="pagination">
          @if($permintaan->onFirstPage())
            <button class="page-btn" disabled>Prev</button>
          @else
            <a href="{{ $permintaan->previousPageUrl() }}" class="page-btn">Prev</a>
          @endif

          @foreach($permintaan->getUrlRange(1, $permintaan->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $permintaan->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($permintaan->hasMorePages())
            <a href="{{ $permintaan->nextPageUrl() }}" class="page-btn">Next</a>
          @else
            <button class="page-btn" disabled>Next</button>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</main>

<script>
function showDetail(id) {
  // Bisa buka modal atau redirect ke detail
  window.location.href = `/adminpersediaan/permintaan/${id}`;
}

// CSRF Token untuk AJAX
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Auto refresh notifikasi (opsional)
setInterval(() => {
  // Fetch notifikasi count
}, 30000);
</script>

</body>
</html>