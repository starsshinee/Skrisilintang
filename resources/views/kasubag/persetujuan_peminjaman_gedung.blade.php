<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Persetujuan Peminjaman Gedung - Dashboard Kasubag</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  :root {
    --blue: #3b6ff0; --blue-light: #eef2ff;
    --orange: #f59e0b; --orange-light: #fffbeb;
    --green: #10b981; --green-light: #ecfdf5;
    --red: #ef4444; --red-light: #fef2f2;
    --purple: #8b5cf6; --purple-light: #f5f3ff;
    --gray-50: #f8fafc; --gray-100: #f1f5f9;
    --gray-200: #e2e8f0; --gray-400: #94a3b8;
    --gray-600: #475569; --gray-800: #1e293b;
    --sidebar-w: 240px;
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); display: flex; min-height: 100vh; }
  .sidebar { width: var(--sidebar-w); background: #fff; border-right: 1px solid var(--gray-200); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 10; }
  .sidebar-brand { padding: 20px 20px 16px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 12px; }
  .brand-icon { width: 40px; height: 40px; background: var(--blue); border-radius: 10px; display: flex; align-items: center; justify-content: center; }
  .brand-icon svg { width: 22px; height: 22px; fill: #fff; }
  .brand-text h2 { font-size: 14px; font-weight: 700; }
  .brand-text p { font-size: 11px; color: var(--gray-400); margin-top: 1px; }
  .nav { padding: 12px; flex: 1; }
  .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: 8px; font-size: 13.5px; font-weight: 500; color: var(--gray-600); cursor: pointer; text-decoration: none; transition: all .15s; margin-bottom: 2px; }
  .nav-item:hover { background: var(--gray-100); }
  .nav-item.active { background: var(--blue-light); color: var(--blue); font-weight: 600; }
  .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
  .nav-section-label { font-size: 11px; font-weight: 600; color: var(--gray-400); text-transform: uppercase; letter-spacing: .06em; padding: 12px 12px 6px; display: flex; align-items: center; justify-content: space-between; }
  .badge { margin-left: auto; background: var(--orange-light); color: var(--orange); font-size: 11px; font-weight: 700; padding: 1px 7px; border-radius: 20px; }
  .topbar { position: fixed; top: 0; left: var(--sidebar-w); right: 0; height: 60px; background: #fff; border-bottom: 1px solid var(--gray-200); display: flex; align-items: center; justify-content: flex-end; padding: 0 28px; gap: 16px; z-index: 9; }
  .notif-btn { width: 38px; height: 38px; border-radius: 10px; background: var(--gray-100); display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; border: none; }
  .notif-btn svg { width: 18px; height: 18px; stroke: var(--gray-600); fill: none; stroke-width: 2; }
  .notif-badge { position: absolute; top: -4px; right: -4px; background: var(--red); color: #fff; font-size: 10px; font-weight: 700; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid #fff; }
  .user-chip { display: flex; align-items: center; gap: 10px; background: var(--gray-100); border-radius: 10px; padding: 6px 12px 6px 6px; }
  .user-avatar { width: 30px; height: 30px; background: var(--blue); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: #fff; }
  .user-info strong { font-size: 13px; font-weight: 600; display: block; }
  .user-info span { font-size: 11px; color: var(--gray-400); }
  .main { margin-left: var(--sidebar-w); margin-top: 60px; padding: 32px; flex: 1; }
  .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
  .page-header-icon { width: 48px; height: 48px; background: var(--purple-light); border-radius: 14px; display: flex; align-items: center; justify-content: center; }
  .page-header-icon svg { width: 24px; height: 24px; stroke: var(--purple); fill: none; stroke-width: 2; }
  .page-header-text h1 { font-size: 22px; font-weight: 700; }
  .page-header-text p { font-size: 13px; color: var(--gray-400); margin-top: 2px; }
  .search-container { background: #fff; border: 1px solid var(--gray-200); border-radius: 12px; padding: 12px 16px; display: flex; gap: 12px; align-items: center; margin-bottom: 28px; }
  .search-input { flex: 1; border: none; outline: none; font-size: 14px; color: var(--gray-800); }
  .search-input::placeholder { color: var(--gray-400); }
  .search-btn { width: 40px; height: 40px; border-radius: 10px; background: var(--blue); display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; }
  .search-btn svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
  .section-label { display: flex; align-items: center; gap: 8px; font-size: 13.5px; font-weight: 600; color: var(--orange); margin-bottom: 16px; }
  .section-label svg { width: 16px; height: 16px; stroke: var(--orange); fill: none; stroke-width: 2; }
  .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 28px; }
  .stat-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 20px; text-align: center; }
  .stat-number { font-size: 28px; font-weight: 700; color: var(--gray-800); margin-bottom: 4px; }
  .stat-label { font-size: 13px; color: var(--gray-400); }
  .req-card { background: #fff; border: 1px solid var(--gray-200); border-radius: 14px; padding: 20px 22px; margin-bottom: 14px; display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; transition: box-shadow .15s; }
  .req-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.07); }
  .req-card.highlighted { border: 2px solid var(--blue); }
  .req-info { flex: 1; }
  .req-tags { display: flex; gap: 8px; margin-bottom: 8px; }
  .tag { font-size: 11.5px; font-weight: 600; padding: 3px 10px; border-radius: 6px; }
  .tag.id { background: var(--gray-100); color: var(--gray-600); }
  .tag.pending { background: var(--orange-light); color: var(--orange); }
  .tag.review { background: var(--purple-light); color: var(--purple); }
  .req-name { font-size: 17px; font-weight: 700; margin-bottom: 10px; }
  .req-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 4px 32px; font-size: 12.5px; color: var(--gray-600); margin-bottom: 6px; }
  .req-meta span strong { color: var(--gray-800); }
  .req-purpose { font-size: 12.5px; color: var(--gray-600); }
  .req-purpose span { color: var(--gray-800); font-weight: 500; }
  .req-actions { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; flex-shrink: 0; }
  .btn { display: flex; align-items: center; gap: 6px; padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all .15s; }
  .btn-detail { background: var(--gray-100); color: var(--gray-600); }
  .btn-detail:hover { background: var(--gray-200); }
  .btn-detail svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }
  .btn-approve { background: var(--green-light); color: var(--green); }
  .btn-approve:hover { background: #bbf7d0; }
  .btn-approve svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; }
  .btn-reject { background: var(--red-light); color: var(--red); }
  .btn-reject:hover { background: #fecaca; }
  .btn-reject svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2.5; }
  .btn-download { background: var(--blue-light); color: var(--blue); }
  .btn-download:hover { background: var(--blue-light); opacity: 0.9; }
  .pagination { display: flex; justify-content: center; gap: 8px; margin-top: 32px; }
  .pagination a, .pagination span { padding: 8px 12px; border: 1px solid var(--gray-200); border-radius: 8px; text-decoration: none; color: var(--gray-600); font-size: 13px; transition: all .15s; }
  .pagination a:hover { background: var(--gray-100); }
  .pagination .active a { background: var(--blue); color: #fff; border-color: var(--blue); }
  .empty-state { text-align: center; padding: 60px 20px; color: var(--gray-400); }
  .empty-state svg { width: 64px; height: 64px; margin: 0 auto 20px; opacity: 0.5; }
  @media (max-width: 768px) {
    .main { margin-left: 0; padding: 20px; }
    .topbar { left: 0; padding: 0 20px; }
    .req-card { flex-direction: column; align-items: stretch; }
    .req-actions { flex-direction: row; justify-content: flex-end; }
  }
  /* Modal Styles */
.modal-overlay {
  position: fixed; top: 0; left: 0; right: 0; bottom: 0; 
  background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); 
  display: none; align-items: center; justify-content: center; 
  z-index: 1000; padding: 20px;
}
.modal-container {
  background: #fff; border-radius: 16px; width: 100%; max-width: 600px; 
  max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px rgba(0,0,0,0.25);
  animation: modalSlideIn 0.3s ease-out;
}
@keyframes modalSlideIn { from { opacity: 0; transform: translateY(-20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
.modal-header {
  padding: 24px 28px 0; border-bottom: 1px solid var(--gray-200); 
  display: flex; justify-content: space-between; align-items: center;
}
.modal-title { font-size: 20px; font-weight: 700; color: var(--gray-800); }
.modal-close { width: 36px; height: 36px; border-radius: 10px; background: var(--gray-100); 
               border: none; display: flex; align-items: center; justify-content: center; 
               cursor: pointer; font-size: 18px; color: var(--gray-600); }
.modal-close:hover { background: var(--gray-200); }
.modal-body { padding: 24px 28px 28px; }
.detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
.detail-item { background: var(--gray-50); padding: 16px; border-radius: 12px; }
.detail-label { font-size: 12px; color: var(--gray-400); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px; }
.detail-value { font-size: 15px; font-weight: 600; color: var(--gray-800); }
.gedung-info { grid-column: 1 / -1; }
.status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; 
                border-radius: 20px; font-size: 12px; font-weight: 600; }
.status-pending { background: var(--orange-light); color: var(--orange); }
.status-approved { background: var(--green-light); color: var(--green); }
.surat-section { grid-column: 1 / -1; text-align: center; padding: 20px; border: 2px dashed var(--gray-200); border-radius: 12px; }
.surat-link { color: var(--blue); text-decoration: none; font-weight: 600; }
.surat-link:hover { text-decoration: underline; }
.modal-actions { display: flex; gap: 12px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--gray-200); }
@media (max-width: 640px) { .detail-grid { grid-template-columns: 1fr; } }
</style>
</head>
<body>

@include('partials.sidebar')

<div class="topbar">
  <button class="notif-btn">
    <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    <div class="notif-badge">{{ $peminjaman->whereIn('status', ['dalam_review'])->count() }}</div>
  </button>
  <div class="user-chip">
    <div class="user-avatar">K</div>
    <div class="user-info">
      <strong>Kasubag</strong>
      <span>Kepala Sub Bagian</span>
    </div>
  </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal-overlay">
  <div class="modal-container">
    <div class="modal-header">
      <h2 class="modal-title">Detail Peminjaman Gedung</h2>
      <button class="modal-close" onclick="closeModal()">&times;</button>
    </div>
    <div class="modal-body">
      <div class="detail-grid">
        <div>
          <div class="detail-label">ID Permintaan</div>
          <div class="detail-value" id="modalReqId">-</div>
        </div>
        <div class="gedung-info">
          <div class="detail-label">Gedung & Fasilitas</div>
          <div class="detail-value" id="modalGedungName" style="font-size: 18px; margin-bottom: 8px;"></div>
          <div class="detail-value" id="modalFasilitas" style="font-size: 14px; opacity: 0.8;"></div>
        </div>
        
        <div>
          <div class="detail-label">Nama Lengkap</div>
          <div class="detail-value" id="modalNamaLengkap">-</div>
        </div>
        <div>
          <div class="detail-label">NIP/NIK</div>
          <div class="detail-value" id="modalNipNik">-</div>
        </div>
        <div>
          <div class="detail-label">Instansi/Lembaga</div>
          <div class="detail-value" id="modalInstansi">-</div>
        </div>
        <div>
          <div class="detail-label">Kabupaten/Kota</div>
          <div class="detail-value" id="modalKabupaten">-</div>
        </div>
        
        <div>
          <div class="detail-label">Tarif per Hari</div>
          <div class="detail-value" id="modalTarif">-</div>
        </div>
        <div>
          <div class="detail-label">Tanggal Pinjam</div>
          <div class="detail-value" id="modalTanggalPinjam">-</div>
        </div>
        <div>
          <div class="detail-label">Tanggal Kembali</div>
          <div class="detail-value" id="modalTanggalKembali">-</div>
        </div>
        <div>
          <div class="detail-label">Lama Peminjaman</div>
          <div class="detail-value" id="modalLamaPinjam">-</div>
        </div>
        
        <div>
          <div class="detail-label">Jam Mulai</div>
          <div class="detail-value" id="modalJamMulai">-</div>
        </div>
        <div>
          <div class="detail-label">Jam Selesai</div>
          <div class="detail-value" id="modalJamSelesai">-</div>
        </div>
        <div>
          <div class="detail-label">Total Pembayaran</div>
          <div class="detail-value" id="modalTotalBayar">-</div>
        </div>
        
        <div style="grid-column: 1 / -1;">
          <div class="detail-label">Tujuan Penggunaan</div>
          <div class="detail-value" id="modalTujuan" style="white-space: pre-wrap; line-height: 1.5;"></div>
        </div>
        
        <div>
          <div class="detail-label">Status</div>
          <div class="detail-value">
            <span class="status-badge status-pending" id="modalStatusContainer">
              <span id="modalStatus">-</span>
            </span>
          </div>
        </div>
        <div>
          <div class="detail-label">No. Kontak</div>
          <div class="detail-value" id="modalKontak">-</div>
        </div>
        
        <div style="grid-column: 1 / -1;">
          <div class="detail-label">Komentar Admin</div>
          <div class="detail-value" id="modalKomentar" style="font-style: italic; color: var(--gray-600);"></div>
        </div>
        
        <div>
          <div class="detail-label">Review Admin</div>
          <div class="detail-value" id="modalAdminReview">-</div>
        </div>
        <div>
          <div class="detail-label">Tgl Diteruskan</div>
          <div class="detail-value" id="modalTglReview">-</div>
        </div>
        
        @if($peminjaman->where('surat_path', '!=', null)->count() > 0)
        <div class="surat-section">
          <div style="font-size: 13px; color: var(--gray-500); margin-bottom: 12px;">📄 Surat Permohonan</div>
          <a id="modalSuratLink" href="#" class="surat-link" target="_blank">Unduh Surat Permohonan</a>
        </div>
        @endif
      </div>
    </div>
    <div class="modal-actions">
      <button class="btn btn-detail" onclick="closeModal()">Tutup</button>
      <button class="btn btn-approve" id="modalApproveBtn" onclick="approvePeminjaman(currentPeminjamanId)" style="display: none;">
        <svg viewBox="0 0 24 24" style="width: 14px;"><polyline points="20 6 9 17 4 12"/></svg>
        Setujui Sekarang
      </button>
    </div>
  </div>
</div>

<main class="main">
  <div class="page-header">
    <div class="page-header-icon">
      <svg viewBox="0 0 24 24">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
    </div>
    <div class="page-header-text">
      <h1>Persetujuan Peminjaman Gedung</h1>
      <p>{{ $peminjaman->whereIn('status', ['dalam_review'])->count() }} permintaan menunggu verifikasi</p>
    </div>
  </div>

  <!-- Search -->
  <div class="search-container">
    <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: var(--gray-400); flex-shrink: 0;">
      <circle cx="11" cy="11" r="8"/>
      <path d="m21 21-4.35-4.35"/>
    </svg>
    <input type="text" class="search-input" placeholder="Cari nama pemohon atau instansi..." 
           id="searchInput" onkeyup="searchPeminjaman()">
    <button class="search-btn">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
    </button>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-number">{{ $peminjaman->whereIn('status', ['dalam_review'])->count() }}</div>
      <div class="stat-label">Menunggu Review</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">{{ $peminjaman->where('status', 'disetujui_kasubag')->count() }}</div>
      <div class="stat-label">Disetujui Kasubag</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">{{ $peminjaman->total() }}</div>
      <div class="stat-label">Total Permintaan</div>
    </div>
  </div>

  @if($peminjaman->count() > 0)
    <div class="section-label">
      <svg viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/>
        <polyline points="12 6 12 12 16 14"/>
      </svg>
      Menunggu Verifikasi & Disetujui Kasubag
    </div>

    @foreach($peminjaman as $item)
    <div class="req-card {{ $item->status == 'dalam_review' ? 'highlighted' : '' }}" 
         data-search="{{ strtolower($item->nama_lengkap) }} {{ strtolower($item->instansi_lembaga) }}">
      <div class="req-info">
        <div class="req-tags">
          <span class="tag id">REQ{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}</span>
          <span class="tag {{ $item->status == 'dalam_review' ? 'pending' : 'review' }}">
            {{ $item->status == 'dalam_review' ? 'Menunggu' : 'Disetujui Kasubag' }}
          </span>
        </div>
        <div class="req-name">{{ $item->gedung->nama_gedung ?? 'Gedung Tidak Ditemukan' }} 
          ({{ $item->fasilitas }} - {{ $item->nama_fasilitas ?? '-' }})</div>
        <div class="req-meta">
          <span>Pemohon: <strong>{{ $item->nama_lengkap }}</strong></span>
          <span>NIP/NIK: <strong>{{ $item->nip_nik }}</strong></span>
          <span>Instansi: <strong>{{ Str::limit($item->instansi_lembaga, 25) }}</strong></span>
          <span>Tgl Ajuan: <strong>{{ $item->created_at->locale('id')->isoFormat('D MMM YYYY') }}</strong></span>
          <span>Mulai: <strong>{{ $item->tanggal_pinjam->locale('id')->isoFormat('D MMM YYYY') }}</strong></span>
          <span>Selesai: <strong>{{ $item->tanggal_kembali->locale('id')->isoFormat('D MMM YYYY') }}</strong></span>
        </div>
        <div class="req-purpose">Tujuan: <span>{{ Str::limit($item->tujuan_penggunaan, 80) }}</span></div>
        @if($item->surat_path)
        <div style="margin-top: 8px; font-size: 11.5px; color: var(--gray-500);">
          📎 <a href="{{ route('kasubag.download-surat', $item) }}" target="_blank" 
             style="color: var(--blue); text-decoration: none;">Unduh Surat Permohonan</a>
        </div>
        @endif
      </div>
      <div class="req-actions">
        <button class="btn btn-detail" onclick="showDetail({{ $item->id }})">
          <svg viewBox="0 0 24 24">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
          </svg> 
          Detail
        </button>
        @if($item->status == 'dalam_review')
        <button class="btn btn-approve" onclick="approvePeminjaman({{ $item->id }})">
          <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> 
          Setuju
        </button>
        <button class="btn btn-reject" onclick="rejectPeminjaman({{ $item->id }})">
          <svg viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
          </svg> 
          Tolak
        </button>
        @else
        <span style="font-size: 11.5px; color: var(--green); font-weight: 600;">✓ Disetujui</span>
        @endif
      </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="pagination">
      {{ $peminjaman->appends(request()->query())->links() }}
    </div>
  @else
    <div class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/>
      </svg>
      <h3>Tidak ada permintaan peminjaman</h3>
      <p>Semua permintaan peminjaman gedung sudah diproses</p>
    </div>
  @endif
</main>

<script>
function searchPeminjaman() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.req-card');
    
    cards.forEach(card => {
        const searchData = card.getAttribute('data-search');
        if (searchData.includes(input)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

let currentPeminjamanId = null;

function showDetail(id) {
    currentPeminjamanId = id;
    document.getElementById('detailModal').style.display = 'flex';
    
    fetch(`/kasubag/peminjaman-gedung/${id}`)
        .then(res => res.json())
        .then(data => {
            // 1. HEADER
            document.getElementById('modalReqId').textContent = `REQ${data.id}`;
            document.getElementById('modalGedungName').textContent = data.gedung.nama_gedung;
            document.getElementById('modalFasilitas').textContent = `${data.fasilitas} - ${data.nama_fasilitas}`;
            
            // 2. PEMOHON
            document.getElementById('modalNamaLengkap').textContent = data.nama_lengkap;
            document.getElementById('modalNipNik').textContent = data.nip_nik;
            document.getElementById('modalInstansi').textContent = data.instansi_lembaga;
            document.getElementById('modalKabupaten').textContent = data.kabupaten_kota;
            
            // 3. BIAYA
            document.getElementById('modalTarif').textContent = `Rp ${parseFloat(data.tarif_per_hari).toLocaleString('id-ID')}`;
            document.getElementById('modalTotalBayar').textContent = `Rp ${parseFloat(data.total_pembayaran).toLocaleString('id-ID')}`;
            
            // 4. JADWAL - FORMAT INDONESIA
            const pinjamDate = new Date(data.tanggal_pinjam);
            const kembaliDate = new Date(data.tanggal_kembali);
            const mulaiTime = new Date(data.jam_mulai);
            const selesaiTime = new Date(data.jam_selesai);
            
            document.getElementById('modalTanggalPinjam').textContent = pinjamDate.toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'});
            document.getElementById('modalTanggalKembali').textContent = kembaliDate.toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'});
            document.getElementById('modalJamMulai').textContent = mulaiTime.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
            document.getElementById('modalJamSelesai').textContent = selesaiTime.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
            document.getElementById('modalLamaPinjam').textContent = `${data.lama_peminjaman_hari} hari`;
            
            // 5. DETAIL
            document.getElementById('modalTujuan').textContent = data.tujuan_penggunaan;
            document.getElementById('modalKontak').textContent = data.nomor_kontak;
            
            // 6. STATUS
            document.getElementById('modalStatus').textContent = data.status_text;
            document.getElementById('modalStatus').parentElement.className = `status-badge status-${data.status}`;
            document.getElementById('modalKomentar').textContent = data.komentar;
            document.getElementById('modalAdminReview').textContent = data.reviewer.name;
            
            // 7. SURAT
            if (data.surat_url) {
                document.getElementById('modalSuratLink').href = data.surat_url;
                document.getElementById('modalSuratSection').style.display = 'block';
            }
            
            // 8. APPROVE BUTTON
            document.getElementById('modalApproveBtn').style.display = data.status === 'dalam_review' ? 'flex' : 'none';
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Gagal load detail');
        });
}

function closeModal() {
    document.getElementById('detailModal').style.display = 'none';
}

// Close modal on overlay click
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
});

function approvePeminjaman(id) {
    if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
        const komentar = prompt('Masukkan komentar (opsional):');
        
        fetch(`/kasubag/peminjaman-gedung/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ komentar: komentar || '' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function rejectPeminjaman(id) {
    const komentar = prompt('Alasan penolakan (wajib):');
    if (!komentar) return;
    
    fetch(`/kasubag/peminjaman-gedung/${id}/reject`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ komentar: komentar })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>