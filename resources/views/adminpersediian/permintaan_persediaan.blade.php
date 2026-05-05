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
  --purple: #8b5cf6;
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

.main { padding: 24px; max-width: 1400px; margin: 0 auto; margin-left: 240px; }
.topbar {
  display: flex; align-items: center; justify-content: space-between; 
  margin-bottom: 32px; padding: 20px 24px;
  background: var(--card-bg); border-radius: var(--radius); 
  box-shadow: var(--shadow);
}
.topbar-title { 
  font-family: 'Space Grotesk', sans-serif; 
  font-size: 20px; font-weight: 700; color: var(--text-primary);
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
.date-text { font-size: 14px; color: var(--text-secondary); font-weight: 500; }
.btn-keluar {
  display: flex; align-items: center; gap: 8px; 
  padding: 10px 20px; background: #fef2f2; 
  color: var(--danger); border: 1px solid #fecaca; border-radius: 10px; 
  font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.btn-keluar:hover { background: var(--danger); color: white; }

.content { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; }
.page-top {
  padding: 28px 32px; border-bottom: 1px solid var(--border); 
}
.page-top h1 { font-size: 24px; font-weight: 800; margin-bottom: 4px; color: var(--primary); }
.page-top p { color: var(--text-secondary); font-size: 14px; }

.table-toolbar {
  padding: 24px 32px; border-bottom: 1px solid var(--border); 
  display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.search-wrap {
  flex: 1; min-width: 250px; max-width: 400px; 
  display: flex; align-items: center; gap: 12px; 
  padding: 10px 16px; background: #f8fafc; 
  border: 1.5px solid var(--border); border-radius: 10px;
}
.search-wrap:focus-within { border-color: var(--primary); }
.search-wrap svg { color: var(--text-secondary); }
.search-wrap input {
  flex: 1; border: none; outline: none; 
  font-size: 14px; background: transparent; font-family: inherit;
}
.filter-select {
  padding: 10px 16px; border: 1.5px solid var(--border); 
  border-radius: 10px; background: white; font-size: 14px;
  min-width: 160px; font-family: inherit; outline: none; cursor: pointer;
}
.filter-select:focus { border-color: var(--primary); }

.table-responsive {
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
table {
  width: 100%; border-collapse: collapse; 
  font-size: 13.5px; background: var(--card-bg);
}
th {
  text-align: left; padding: 16px 24px; 
  font-weight: 700; color: var(--primary); 
  font-size: 11px; text-transform: uppercase; 
  letter-spacing: 0.8px; border-bottom: 2px solid var(--border);
  white-space: nowrap; background: #f8faff;
}
td { padding: 16px 24px; border-bottom: 1px solid var(--border); vertical-align: middle; white-space: nowrap;}
tr:hover { background: #f8faff; }

/* BADGES */
.status-badge {
  padding: 6px 12px; border-radius: 20px; 
  font-size: 11.5px; font-weight: 700; 
  display: inline-flex; align-items: center; gap: 6px;
  text-transform: capitalize;
}
.bg-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.bg-review { background: #e0f2fe; color: #0891b2; border: 1px solid #a5f3fc; }
.bg-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.bg-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

/* ACTION BUTTONS */
.action-group { display: flex; gap: 6px; align-items: center; }
.action-btn {
  width: 36px; height: 36px; border-radius: 8px; 
  border: 1px solid var(--border); background: var(--card-bg); 
  display: inline-flex; align-items: center; justify-content: center; 
  cursor: pointer; transition: all 0.15s; color: var(--text-secondary);
  text-decoration: none;
}
.action-btn:hover { transform: translateY(-1px); }
.action-btn.detail:hover { background: #f1f5f9; border-color: var(--text-secondary); color: var(--text-primary); }
.action-btn.teruskan:hover { background: #ecfdf5; border-color: var(--success); color: var(--success); }
.action-btn.tolak:hover { background: #fef2f2; border-color: var(--danger); color: var(--danger); }
.action-btn.generate:hover { background: #eff6ff; border-color: var(--primary); color: var(--primary); }
.action-btn.upload:hover { background: #ecfdf5; border-color: var(--success); color: var(--success); }
.action-btn.lihat:hover { background: #faf5ff; border-color: var(--purple); color: var(--purple); }
.action-btn i { font-size: 14px; }

/* MODAL CSS */
.modal-overlay {
  position: fixed; top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
  display: flex; align-items: center; justify-content: center;
  z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.2s ease-out;
}
.modal-overlay.show { opacity: 1; visibility: visible; }
.modal {
  background: var(--card-bg); border-radius: 16px; padding: 32px;
  width: 90%; max-width: 500px;
  transform: scale(0.95) translateY(10px); transition: all 0.2s ease-out;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
.modal-overlay.show .modal { transform: scale(1) translateY(0); }
.form-group { margin-bottom: 20px; }
.form-label { display: block; font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px; }
.form-input {
  width: 100%; padding: 12px 16px; border-radius: 10px;
  border: 1.5px solid var(--border); background: #f8fafc;
  font-family: inherit; font-size: 14px; transition: border-color 0.15s;
}
.form-input:focus { outline: none; border-color: var(--primary); background: white; }
.btn { padding: 12px 20px; border-radius: 10px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; font-size: 14px; transition: all 0.15s; }
.btn-cancel { background: white; color: var(--text-secondary); border: 1.5px solid var(--border); }
.btn-cancel:hover { background: #f1f5f9; color: var(--text-primary); }
.btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
.btn-primary:hover { background: var(--primary-light); transform: translateY(-1px); }

.table-footer { padding: 24px 32px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.pagination { display: flex; align-items: center; gap: 8px; }
.page-btn { padding: 8px 12px; border: 1px solid var(--border); background: white; border-radius: 8px; cursor: pointer; transition: all 0.2s; font-family: inherit; font-size: 13px; font-weight: 600; color: var(--text-secondary); text-decoration: none;}
.page-btn:hover:not(.active) { background: #f1f5f9; color: var(--primary); border-color: var(--primary); }
.page-btn.active { background: var(--primary); color: white; border-color: var(--primary); }

@media (max-width: 768px) {
  .main { margin-left: 0; padding: 16px; }
}
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Manajemen Permintaan</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <i class="fas fa-bell" style="color: var(--text-secondary);"></i>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</span>
      <form method="POST" action="{{ route('logout') }}" style="display:inline">
        @csrf
        <button type="submit" class="btn-keluar">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
      </form>
    </div>
  </div>

  <div class="content">
    <div class="page-top">
      <h1>Permintaan Persediaan</h1>
      <p>{{ $permintaan->total() }} data permintaan ditemukan {{ $permintaan->hasPages() ? '(Halaman ' . $permintaan->currentPage() . ')' : '' }}</p>
    </div>

    <div class="table-card">
      <div class="table-toolbar">
        <form method="GET" action="" style="display: flex; gap: 16px; width: 100%; flex-wrap: wrap;">
          <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Cari nama barang, pemohon..." value="{{ request('search') }}">
          </div>
          
          <select name="status" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="dalam_review" {{ request('status') == 'dalam_review' ? 'selected' : '' }}>Dalam Review</option>
            <option value="disetujui_kasubag" {{ request('status') == 'disetujui_kasubag' ? 'selected' : '' }}>Disetujui Kasubag</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
          </select>
        </form>
      </div>

      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th width="50">No</th>
              <th width="120">Kode Barang</th>
              <th>Pemohon & Barang</th>
              <th width="100">Jml</th>
              <th width="130">Tgl Permintaan</th>
              <th width="130">Tgl Dibutuhkan</th>
              <th>Tujuan Penggunaan</th>
              <th width="130">Status</th>
              <th width="180">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($permintaan as $index => $item)
              <tr>
                <td><strong>{{ ($permintaan->currentPage() - 1) * $permintaan->perPage() + $index + 1 }}</strong></td>
                <td>
                  <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 700; color: var(--primary);">
                    {{ $item->persediaan->kode_barang ?? $item->kode_barang ?? '-' }}
                  </code>
                </td>
                <td>
                  {{-- PERBAIKAN NAMA PEMOHON DI SINI --}}
                  <div style="font-weight: 700; color: var(--text-primary); margin-bottom: 2px;">
                    {{ $item->user->name ?? $item->user->nama_lengkap ?? $item->nama_lengkap ?? 'Tanpa Nama' }}
                  </div>
                  <div style="font-size: 12.5px; color: var(--text-secondary);">
                    <i class="fas fa-box" style="margin-right: 4px; font-size: 10px;"></i>
                    {{ $item->persediaan->nama_barang ?? $item->nama_barang }}
                  </div>
                </td>
                <td>
                  <strong style="color: var(--primary); font-size: 16px;">{{ $item->jumlah_diminta }}</strong>
                  <br><small style="color: var(--text-secondary);">Stok: {{ $item->persediaan->jumlah ?? 0 }}</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_permintaan)->format('d M Y') }}</td>
                <td>
                  <strong style="color: var(--warning);">{{ \Carbon\Carbon::parse($item->tanggal_dibutuhkan)->format('d M Y') }}</strong>
                </td>
                <td style="max-width: 200px;">
                  <span style="display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->tujuan_penggunaan }}">
                    {{ $item->tujuan_penggunaan }}
                  </span>
                </td>
                <td>
                  @php 
                    $badgeClass = 'bg-pending';
                    $iconClass = 'fa-clock';
                    $statusText = str_replace('_', ' ', $item->status);
                    
                    if(in_array($item->status, ['disetujui', 'disetujui_kasubag'])) {
                        $badgeClass = 'bg-success';
                        $iconClass = 'fa-check-circle';
                    } elseif(in_array($item->status, ['ditolak', 'ditolak_kasubag'])) {
                        $badgeClass = 'bg-danger';
                        $iconClass = 'fa-times-circle';
                    } elseif($item->status == 'dalam_review') {
                        $badgeClass = 'bg-review';
                        $iconClass = 'fa-search';
                    }
                  @endphp
                  <span class="status-badge {{ $badgeClass }}">
                    <i class="fas {{ $iconClass }}"></i>
                    {{ $statusText }}
                  </span>
                </td>
                
                <td>
                  <div class="action-group">
                    <button class="action-btn detail" onclick="showDetail({{ $item->id }})" title="Lihat Detail Lengkap">
                      <i class="fas fa-eye"></i>
                    </button>

                    @if($item->status === 'pending')
                      <form action="{{ route('adminpersediaan.review-permintaan', $item->id) }}" method="POST" style="margin:0;">
                        @csrf
                        <input type="hidden" name="action" value="teruskan">
                        <button type="submit" class="action-btn teruskan" title="Teruskan ke Kasubag">
                          <i class="fas fa-forward"></i>
                        </button>
                      </form>
                      
                      <form action="{{ route('adminpersediaan.review-permintaan', $item->id) }}" method="POST" style="margin:0;" onclick="return confirm('Yakin menolak permintaan ini?')">
                        @csrf
                        <input type="hidden" name="action" value="tolak">
                        <button type="submit" class="action-btn tolak" title="Tolak Permintaan">
                          <i class="fas fa-times"></i>
                        </button>
                      </form>

                    @elseif(in_array($item->status, ['dalam_review', 'disetujui_kasubag', 'disetujui']))
                      <a href="{{ route('adminpersediaan.surat-permintaan', $item->id) }}" class="action-btn generate" title="Generate Berita Acara PDF" target="_blank">
                        <i class="fas fa-file-signature"></i>
                      </a>

                      <button type="button" onclick="openUploadModal({{ $item->id }})" class="action-btn upload" title="Upload Surat BAST Final">
                        <i class="fas fa-upload"></i>
                      </button>

                      @if($item->surat_bast_path)
                      <a href="{{ asset('storage/' . $item->surat_bast_path) }}" class="action-btn lihat" title="Lihat Dokumen Final (BAST)" target="_blank">
                        <i class="fas fa-file-circle-check"></i>
                      </a>
                      @endif
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" style="text-align: center; padding: 60px; color: var(--text-secondary);">
                  <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                  <div style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px;">Belum ada permintaan</div>
                  <div>Data pengajuan dari pegawai akan muncul di sini.</div>
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
            <button class="page-btn" disabled style="opacity:0.5; cursor:not-allowed;"><i class="fas fa-chevron-left"></i></button>
          @else
            <a href="{{ $permintaan->previousPageUrl() }}" class="page-btn"><i class="fas fa-chevron-left"></i></a>
          @endif

          @foreach($permintaan->getUrlRange(max(1, $permintaan->currentPage() - 2), min($permintaan->lastPage(), $permintaan->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $permintaan->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
          @endforeach

          @if($permintaan->hasMorePages())
            <a href="{{ $permintaan->nextPageUrl() }}" class="page-btn"><i class="fas fa-chevron-right"></i></a>
          @else
            <button class="page-btn" disabled style="opacity:0.5; cursor:not-allowed;"><i class="fas fa-chevron-right"></i></button>
          @endif
        </div>
      </div>
      @endif
    </div>
  </div>
</main>

{{-- MODAL UPLOAD SURAT FINAL --}}
<div id="uploadModal" class="modal-overlay">
  <div class="modal">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid var(--border);">
      <h3 style="font-size:20px; font-weight:800; color:var(--text-primary); margin:0;">
        <i class="fas fa-cloud-upload-alt" style="color: var(--primary); margin-right: 8px;"></i>
        Upload Surat BAST Final
      </h3>
      <button onclick="closeModal('uploadModal')" style="background:none; border:none; cursor:pointer; font-size:18px; color:var(--text-secondary);">&times;</button>
    </div>

    <form id="uploadForm" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label class="form-label">File Surat Persetujuan (PDF) <span style="color:var(--danger)">*</span></label>
        <input type="file" name="surat_bast" class="form-input" accept="application/pdf" required style="padding: 10px; background: white;">
        
        <div style="background: #f0fdfa; border: 1px solid #ccfbf1; padding: 12px; border-radius: 8px; margin-top: 16px;">
          <p style="font-size: 12.5px; color: #0f766e; margin: 0; line-height: 1.5;">
            <i class="fas fa-info-circle" style="margin-right:4px;"></i>
            <strong>Catatan Penting:</strong><br>
            Pastikan file PDF yang diunggah adalah dokumen final yang sudah ditandatangani secara lengkap oleh Peminjam, Admin, Kasubag TU, dan Kepala BPMP. Ukuran maksimal 2MB.
          </p>
        </div>
      </div>

      <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:32px;">
        <button type="button" onclick="closeModal('uploadModal')" class="btn btn-cancel">Batal</button>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-upload" style="margin-right: 6px;"></i> Upload Dokumen
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// Fungsi Buka/Tutup Modal
function openModal(id) {
  document.getElementById(id).classList.add('show');
  document.body.style.overflow = 'hidden'; 
}

function closeModal(id) {
  document.getElementById(id).classList.remove('show');
  document.body.style.overflow = '';
}

document.getElementById('uploadModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal('uploadModal');
});

// Fungsi Tombol Aksi
function showDetail(id) {
  window.location.href = `/adminpersediaan/permintaan/${id}`;
}

function openUploadModal(id) {
    const form = document.getElementById('uploadForm');
    form.action = `/adminpersediaan/permintaan/${id}/upload-bast`; 
    openModal('uploadModal');
}
</script>

</body>
</html>