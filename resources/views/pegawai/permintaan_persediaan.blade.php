<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Permintaan Persediaan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --primary: #2563eb;
    --primary-light: #3b82f6;
    --accent: #06b6d4;
    --accent2: #8b5cf6;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --bg: #f0f4ff;
    --sidebar-bg: #0f172a;
    --sidebar-text: #94a3b8;
    --card-bg: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 4px 24px rgba(37,99,235,0.08);
    --shadow-lg: 0 8px 40px rgba(37,99,235,0.14);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
  }

  /* MOBILE RESPONSIVE */
  @media (max-width: 1024px) {
    .main { margin-left: 0 !important; padding: 16px; }
    .content-grid { grid-template-columns: 1fr !important; gap: 20px; }
  }

  @media (max-width: 768px) {
    .input-row { grid-template-columns: 1fr !important; }
    .fac-grid { grid-template-columns: repeat(2, 1fr) !important; }
    .history-header { flex-direction: column; gap: 12px; align-items: stretch; }
  }

  /* Sidebar dari partial */
  /* MAIN */
  .main { margin-left: 260px; flex: 1; padding: 0 32px 40px; }

  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
    border-bottom: 1px solid transparent;
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 1.5px solid var(--card-bg); }

  /* CONTENT LAYOUT */
  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 28px;
  }

  /* FORM CARD */
  .form-select {
    width: 100%; padding: 12px 16px; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--bg);
    font-family: inherit; font-size: 14px;
    }
    .riwayat-item {
        border: 1px solid var(--border); border-radius: 12px; 
        padding: 16px; margin-bottom: 12px; background: white;
    }
    .status-badge {
        padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
    }
    .status-badge.pending { background: #FEF3C7; color: #D97706; }
    .status-badge.success { background: #ECFDF5; color: #059669; }
    .status-badge.danger { background: #FEF2F2; color: #DC2626; }
  .form-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
    position: sticky;
    top: 90px;
    height: fit-content;
  }
  .form-header {
    padding: 24px 28px 20px;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    position: relative; overflow: hidden;
  }
  .form-header::before {
    content: '';
    position: absolute; right: -30px; top: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }
  .form-header-icon {
    position: relative;
    z-index: 1;
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 13px;
    display: grid; place-items: center;
    font-size: 20px; color: #fff;
    margin-bottom: 12px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .form-header-title { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }
  .form-header-sub { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 4px; }

  .form-body { padding: 24px 28px; }

  .form-group { margin-bottom: 18px; }
  .form-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .6px;
    margin-bottom: 8px;
  }
  .form-label i { color: var(--primary); font-size: 11px; }
  .form-label .req { color: var(--danger); }

  .form-input, .form-select, .form-textarea {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text-primary);
    background: #fff;
    transition: all .2s;
    outline: none;
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }
  .form-input::placeholder, .form-textarea::placeholder { color: #b0bcd4; }
  .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .form-textarea { resize: vertical; min-height: 90px; }

  .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  /* Facility Preview */
  .facility-preview {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    border-radius: 10px;
    background: linear-gradient(135deg, #eff4ff, #f0fdff);
    border: 1px solid #c7d7ff;
  }
  .facility-preview.show { display: flex; align-items: center; gap: 12px; }
  .fp-icon { width: 36px; height: 36px; border-radius: 9px; background: var(--primary); display: grid; place-items: center; color: #fff; font-size: 15px; flex-shrink: 0; }
  .fp-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .fp-details { display: flex; gap: 10px; margin-top: 3px; }
  .fp-tag { font-size: 10px; background: rgba(37,99,235,0.1); color: var(--primary); padding: 2px 8px; border-radius: 5px; font-weight: 600; }

  .submit-btn {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: #fff;
    border: none;
    border-radius: 11px;
    font-size: 14px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    margin-top: 8px;
  }
  .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
  .submit-btn:active { transform: translateY(0); }
  .submit-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

  /* RIWAYAT */
  .history-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .history-header {
    padding: 22px 28px 18px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
  }
  .history-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 17px; font-weight: 700; color: var(--text-primary);
    display: flex; align-items: center; gap: 8px;
  }
  .history-title i { color: var(--primary); }
  .filter-tabs { display: flex; gap: 6px; }
  .filter-tab {
    font-size: 11px; font-weight: 600; padding: 5px 12px;
    border-radius: 7px; cursor: pointer; border: 1.5px solid var(--border);
    background: transparent; color: var(--text-secondary);
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .filter-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
  .filter-tab:hover:not(.active) { border-color: var(--primary); color: var(--primary); }

  .req-list { padding: 20px 28px; display: flex; flex-direction: column; gap: 16px; }

  .req-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all .2s;
  }
  .req-card:hover { box-shadow: var(--shadow); transform: translateY(-1px); }

  .req-card-top {
    padding: 16px 18px;
    display: flex; align-items: flex-start; justify-content: space-between;
  }
  .req-card-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: grid; place-items: center;
    font-size: 17px; flex-shrink: 0;
  }
  .req-card-name { font-size: 14px; font-weight: 700; color: var(--text-primary); }
  .req-card-code { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
  .status-badge {
    font-size: 11px; font-weight: 700; padding: 4px 11px; border-radius: 7px;
    letter-spacing: .3px; display: flex; align-items: center; gap: 5px;
    white-space: nowrap;
  }
  .status-badge.pending { background: rgba(245,158,11,0.15); color: var(--warning); border: 1px solid rgba(245,158,11,0.3); }
  .status-badge.approved { background: rgba(16,185,129,0.15); color: var(--success); border: 1px solid rgba(16,185,129,0.3); }
  .status-badge.rejected { background: rgba(239,68,68,0.15); color: var(--danger); border: 1px solid rgba(239,68,68,0.3); }
  .status-badge.dalam_review { background: rgba(6,182,212,0.15); color: var(--accent); border: 1px solid rgba(6,182,212,0.3); }
  .status-badge i { font-size: 9px; }

  .req-card-meta {
    padding: 12px 18px;
    background: #f8faff;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #eef1ff;
  }
  .meta-item {}
  .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: .6px; color: #94a3b8; font-weight: 700; margin-bottom: 3px; }
  .meta-value { font-size: 12px; font-weight: 600; color: var(--text-primary); }

  .req-card-footer {
    padding: 12px 18px;
    display: flex; gap: 8px;
    border-top: 1px solid #eef1ff;
  }
  .card-btn {
    flex: 1; padding: 9px;
    border-radius: 8px;
    font-size: 12px; font-weight: 600;
    cursor: pointer; border: none;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s;
  }
  .card-btn.detail { background: rgba(37,99,235,0.08); color: var(--primary); }
  .card-btn.detail:hover { background: rgba(37,99,235,0.15); }
  .card-btn.cancel { background: rgba(239,68,68,0.08); color: var(--danger); }
  .card-btn.cancel:hover { background: rgba(239,68,68,0.15); }

  .empty-state {
    text-align: center; padding: 60px 20px;
  }
  .empty-icon { font-size: 56px; color: #dde5f9; margin-bottom: 14px; }
  .empty-text { font-size: 15px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; }
  .empty-sub { font-size: 13px; color: var(--text-secondary); }

  /* MODAL STYLES */
  #detailModal {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
    background: rgba(15,23,42,0.75); backdrop-filter: blur(8px);
    display: none; align-items: center; justify-content: center; z-index: 9998;
    padding: 20px;
  }
  #detailModal.show { display: flex !important; }
  #detailModal .modal-content {
    background: var(--card-bg); border-radius: var(--radius); 
    width: 100%; max-width: 620px; max-height: 90vh; overflow-y: auto;
    box-shadow: var(--shadow-lg); border: 1px solid var(--border);
    position: relative; animation: fadeUp .3s ease;
  }

  /* ANIMATIONS */
  @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }
  .d4 { animation-delay: .2s; } .d5 { animation-delay: .25s; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* TOAST */
  #toast {
    position:fixed; bottom:28px; right:28px;
    background:#0f172a; color:#fff;
    padding:14px 20px; border-radius:12px;
    font-size:13px; font-weight:600;
    display:flex; align-items:center; gap:10px;
    transform:translateY(80px); opacity:0;
    transition:all .35s cubic-bezier(.4,0,.2,1);
    z-index:9999; box-shadow:0 8px 24px rgba(0,0,0,0.25);
    pointer-events:none;
  }
  #toast.show {
    transform:translateY(0); opacity:1;
  }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div>
        <div class="breadcrumb">
          <a href="{{ route('pegawai.dashboard') }}" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a> 
          <i class="fas fa-chevron-right" style="font-size:10px"></i> 
          <span>Permintaan Persediaan</span>
        </div>
        <div class="topbar-title">Permintaan Persediaan</div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn" onclick="alert('Notifikasi akan datang!')"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  <!-- FORM + RIWAYAT -->
  <div class="content-grid">
    <!-- FORM PERMINTAAN -->
    <div class="form-card animate d2" id="formCard">
      <div class="form-header">
        <div class="form-header-icon"><i class="fas fa-boxes-stacked"></i></div>
        <div class="form-header-title">Buat Permintaan Baru</div>
        <div class="form-header-sub">Pilih barang dari persediaan yang tersedia</div>
      </div>
      
      <form method="POST" action="{{ route('pegawai.permintaan-persediaan.store') }}" method="POST" id="permintaanForm">
        @csrf
        <div class="form-body">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-user"></i> Nama Lengkap <span class="req">*</span></div>
            <input type="text" class="form-input @error('nama_lengkap') border-red-500 @enderror" 
                   name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                   placeholder="Masukkan nama lengkap Anda" required>
            @error('nama_lengkap')
              <div class="text-danger" style="font-size:11px;margin-top:4px;color:var(--danger)">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <div class="form-label"><i class="fas fa-box"></i> Pilih Barang <span class="req">*</span></div>
            <select class="form-select @error('kode_barang') border-red-500 @enderror" 
               name="kode_barang" id="persediaanSelect" required>
                <option value="">📦 Pilih barang dari persediaan...</option>
                @foreach($persediaan as $item)
                  <option value="{{ $item->kode_barang }}" 
                          data-nama="{{ $item->nama_barang }}" 
                          data-kategori="{{ $item->kategori ?? 'Umum' }}"
                          data-stok="{{ $item->jumlah}}">{{ $item->nama_barang }}</option>
                          {{ $item->kode_barang }} - {{ $item->nama_barang }} 
                  <span style="opacity:0.7;font-size:12px">(Stok: {{ number_format($item->jumlah) }})</span>
                  </option>
                @endforeach
              </select>
              @error('kode_barang')
                <div style="font-size:11px;margin-top:4px;color:var(--danger)">{{ $message }}</div>
              @enderror
            
            <!-- PREVIEW BARANG -->
            <div class="facility-preview" id="facilityPreview">
              <div class="fp-icon" id="fpIcon"><i class="fas fa-box"></i></div>
              <div>
                <div class="fp-name" id="fpName">-</div>
                <div class="fp-details">
                  <span class="fp-tag" id="fpKode">-</span>
                  <span class="fp-tag" id="fpStok" style="background:rgba(16,185,129,0.1);color:var(--success)">-</span>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-label"><i class="fas fa-hashtag"></i> Jumlah Diminta <span class="req">*</span></div>
            <input type="number" class="form-input @error('jumlah_diminta') border-red-500 @enderror" 
                   name="jumlah_diminta" id="jumlahInput" min="1" 
                   value="{{ old('jumlah_diminta') }}" placeholder="1" required>
            @error('jumlah_diminta')
              <div class="text-danger" style="font-size:11px;margin-top:4px;color:var(--danger)">{{ $message }}</div>
            @enderror
          </div>

          <div class="input-row">
            <div class="form-group">
              <div class="form-label"><i class="fas fa-calendar"></i> Tanggal Permintaan <span class="req">*</span></div>
              <input type="date" class="form-input @error('tanggal_permintaan') border-red-500 @enderror" 
                     name="tanggal_permintaan" value="{{ old('tanggal_permintaan') ?? date('Y-m-d') }}" required>
              @error('tanggal_permintaan')
                <div class="text-danger" style="font-size:11px;margin-top:4px;color:var(--danger)">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <div class="form-label"><i class="fas fa-calendar-check"></i> Tanggal Dibutuhkan <span class="req">*</span></div>
              <input type="date" class="form-input @error('tanggal_dibutuhkan') border-red-500 @enderror" 
                     name="tanggal_dibutuhkan" value="{{ old('tanggal_dibutuhkan') }}" required>
              @error('tanggal_dibutuhkan')
                <div class="text-danger" style="font-size:11px;margin-top:4px;color:var(--danger)">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="form-group">
            <div class="form-label"><i class="fas fa-bullseye"></i> Tujuan Penggunaan <span class="req">*</span></div>
            <textarea class="form-textarea @error('tujuan_penggunaan') border-red-500 @enderror" 
                      name="tujuan_penggunaan" rows="4" placeholder="Jelaskan tujuan penggunaan barang secara singkat dan jelas..."
                      required>{{ old('tujuan_penggunaan') }}</textarea>
            @error('tujuan_penggunaan')
              <div class="text-danger" style="font-size:11px;margin-top:4px;color:var(--danger)">{{ $message }}</div>
            @enderror
          </div>

          @if(session('success'))
            <div class="alert alert-success" style="padding:12px;border-radius:10px;margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:8px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2)">
              <i class="fas fa-check-circle" style="color:var(--success)"></i>
              {{ session('success') }}
            </div>
          @endif

          <button type="submit" class="submit-btn" id="submitBtn">
            <i class="fas fa-paper-plane"></i> 
            Kirim Permintaan Persediaan
          </button>
        </div>
      </form>
    </div>

    <!-- RIWAYAT PERMINTAAN -->
    <div>
      <div class="history-card animate d3">
        <div class="history-header">
          <div class="history-title"><i class="fas fa-clock-rotate-left"></i> Riwayat Permintaan ({{ $riwayat->count() }})</div>
          <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">Semua</button>
            <button class="filter-tab" data-filter="pending">Pending</button>
            <button class="filter-tab" data-filter="approved">Disetujui</button>
            <button class="filter-tab" data-filter="rejected">Ditolak</button>
          </div>
        </div>
        <div class="req-list" id="riwayatList">
          @forelse($riwayat as $item)
            <div class="req-card" data-status="{{ $item->status }}">
              <div class="req-card-top">
                <div style="display:flex;align-items:center;gap:12px">
                  <div class="req-card-icon" style="background:rgba(37,99,235,0.1);color:#2563eb">
                    <i class="fas fa-box"></i>
                  </div>
                  <div>
                    <div class="req-card-name">{{ $item->persediaan->nama_barang ?? $item->nama_barang }}</div>
                    <div class="req-card-code">REQ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                  </div>
                </div>
                <div class="status-badge {{ $item->status }}">
                  <i class="{{ $item->status_badge['icon'] ?? 'fas fa-circle' }}"></i> 
                  {{ $item->status_badge['text'] ?? ucfirst($item->status) }}
                </div>
              </div>
              <div class="req-card-meta">
                <div class="meta-item">
                  <div class="meta-label">Jumlah</div>
                  <div class="meta-value">{{ $item->jumlah_diminta }} unit</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Dibutuhkan</div>
                  <div class="meta-value">{{ $item->tanggal_dibutuhkan->format('d M Y') }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Status</div>
                  <div class="meta-value">
                    @if($item->status == 'pending')
                      <span style="color:var(--warning)">Menunggu Admin</span>
                    @elseif($item->status == 'dalam_review')
                      <span style="color:#06b6d4">Dalam Review Kasubag</span>
                    @elseif(in_array($item->status, ['disetujui', 'disetujui_kasubag']))
                      <span style="color:var(--success)">✅ Disetujui</span>
                    @else
                      <span style="color:var(--danger)">❌ {{ ucfirst($item->status) }}</span>
                    @endif
                  </div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Tujuan</div>
                  <div class="meta-value">{{ Str::limit($item->tujuan_penggunaan, 40) }}</div>
                </div>
              </div>
              <div class="req-card-footer">
                <button class="card-btn detail" onclick="showDetail({{ $item->id }})">
                  <i class="fas fa-eye"></i> Detail
                </button>
                @if($item->status == 'pending')
                <button class="card-btn cancel" onclick="cancelRequest({{ $item->id }})">
                  <i class="fas fa-xmark"></i> Batalkan
                </button>
                @endif
              </div>
            </div>
          @empty
            <div class="empty-state">
              <div class="empty-icon"><i class="fas fa-inbox"></i></div>
              <div class="empty-text">Belum ada riwayat permintaan</div>
              <div class="empty-sub">Buat permintaan persediaan pertama Anda di sebelah kiri</div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</main>

<!-- DETAIL MODAL -->
<div id="detailModal">
  <div class="modal-content">
    <!-- HEADER MODAL -->
    <div style="
      padding: 24px 28px 20px; background: linear-gradient(135deg, var(--primary), var(--primary-light));
      color: white; position: relative; overflow: hidden;
    ">
      <div style="position: absolute; right: 28px; top: 24px; cursor: pointer; font-size: 20px; opacity: 0.8;"
           onclick="closeModal()">
        <i class="fas fa-times"></i>
      </div>
      <div style="display: flex; align-items: center; gap: 16px;">
        <div style="
          width: 52px; height: 52px; background: rgba(255,255,255,0.2); 
          border-radius: 14px; display: grid; place-items: center; font-size: 22px;
          backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);
        ">
          <i class="fas fa-boxes-stacked"></i>
        </div>
        <div>
          <div style="font-size: 20px; font-weight: 700; font-family: 'Space Grotesk', sans-serif;">Detail Permintaan</div>
          <div style="font-size: 13px; opacity: 0.9; margin-top: 2px;">REQ-<span id="detailKode">-</span></div>
        </div>
      </div>
      
      <!-- STATUS BADGE -->
      <div id="detailStatusBadge" style="
        position: absolute; top: 28px; right: 28px; padding: 8px 16px; 
        border-radius: 10px; font-size: 12px; font-weight: 700; 
        letter-spacing: .5px; display: flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
      ">
        <i class="fas fa-circle-notch fa-spin"></i> Memuat...
      </div>
    </div>

    <!-- LOADING -->
    <div id="detailLoading" style="
      padding: 60px 28px; text-align: center; display: block;
    ">
      <div style="
        width: 56px; height: 56px; border: 3px solid rgba(37,99,235,0.1); 
        border-top: 3px solid var(--primary); border-radius: 50%; 
        margin: 0 auto 20px; animation: spin 1s linear infinite;
      "></div>
      <div style="color: var(--text-secondary); font-size: 14px;">Memuat detail permintaan...</div>
    </div>

    <!-- CONTENT -->
    <div id="detailContent" style="display: none; padding: 0;">
      <!-- INFO PEMINTA -->
      <div style="padding: 28px 28px 0;">
        <div style="
          font-size: 12px; font-weight: 700; color: var(--text-secondary); 
          text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
          display: flex; align-items: center; gap: 6px;
        ">
          <i class="fas fa-user" style="color: var(--primary); font-size: 11px;"></i>
          Informasi Peminta
        </div>
        <div style="background: #f8faff; padding: 20px; border-radius: 12px; border: 1px solid #eef1ff;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
              <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Nama Lengkap</div>
              <div id="detailNama" style="font-size: 16px; font-weight: 700; color: var(--text-primary);">-</div>
            </div>
            <div>
              <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">NIP/NIK</div>
              <div id="detailNipNik" style="font-size: 14px; color: var(--text-secondary);">-</div>
            </div>
          </div>
        </div>
      </div>

      <!-- INFO PERSEDIAAN -->
      <div style="padding: 24px 28px 0;">
        <div style="
          font-size: 12px; font-weight: 700; color: var(--text-secondary); 
          text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
          display: flex; align-items: center; gap: 6px;
        ">
          <i class="fas fa-box" style="color: var(--primary); font-size: 11px;"></i>
          Detail Persediaan
        </div>
        <div style="background: #f8faff; padding: 20px; border-radius: 12px; border: 1px solid #eef1ff;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
              <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Nama Barang</div>
              <div id="detailFasilitas" style="font-size: 16px; font-weight: 700; color: var(--text-primary);">-</div>
            </div>
            <div>
              <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Kode Barang</div>
              <div id="detailKodeBarang" style="font-size: 14px; color: var(--text-secondary);">-</div>
            </div>
            <div>
                            <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Kategori</div>
              <div id="detailKategori" style="font-size: 14px; color: var(--text-secondary);">-</div>
            </div>
            <div>
              <div style="font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Jumlah Diminta</div>
              <div id="detailJumlah" style="font-size: 16px; font-weight: 700; color: var(--primary);">-</div>
            </div>
          </div>
        </div>
      </div>

      <!-- TANGGAL & TUJUAN -->
      <div style="padding: 24px 28px 24px;">
        <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 24px;">
          <!-- TANGGAL -->
          <div>
            <div style="
              font-size: 12px; font-weight: 700; color: var(--text-secondary); 
              text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
              display: flex; align-items: center; gap: 6px;
            ">
              <i class="fas fa-calendar" style="color: var(--primary); font-size: 11px;"></i>
              Jadwal Permintaan
            </div>
            <div style="background: #f8faff; padding: 20px; border-radius: 12px; border: 1px solid #eef1ff;">
              <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                  <div style="font-size: 11px; color: #94a3b8; margin-bottom: 4px;">Tanggal Permintaan</div>
                  <div id="detailTglPermintaan" style="font-weight: 600; color: var(--text-primary);">-</div>
                </div>
                <div style="flex: 1;">
                  <div style="font-size: 11px; color: #94a3b8; margin-bottom: 4px;">Tanggal Dibutuhkan</div>
                  <div id="detailTglDibutuhkan" style="font-weight: 600; color: var(--text-primary);">-</div>
                </div>
              </div>
            </div>
          </div>

          <!-- TUJUAN -->
          <div>
            <div style="
              font-size: 12px; font-weight: 700; color: var(--text-secondary); 
              text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
              display: flex; align-items: center; gap: 6px;
            ">
              <i class="fas fa-bullseye" style="color: var(--primary); font-size: 11px;"></i>
              Tujuan Penggunaan
            </div>
            <div style="background: #f8faff; padding: 20px; border-radius: 12px; border: 1px solid #eef1ff; min-height: 100%;">
              <div id="detailTujuan" style="font-size: 14px; line-height: 1.6; color: var(--text-primary); white-space: pre-wrap;">-</div>
            </div>
          </div>
        </div>
      </div>

      <!-- REVIEWER & KOMENTAR -->
      <div style="padding: 0 28px 28px;">
        <div id="detailReviewedWrap" style="display: none; margin-bottom: 16px;">
          <div style="
            font-size: 12px; font-weight: 700; color: var(--text-secondary); 
            text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
            display: flex; align-items: center; gap: 6px;
          ">
            <i class="fas fa-user-check" style="color: var(--success); font-size: 11px;"></i>
            Reviewer
          </div>
          <div style="background: rgba(16,185,129,0.05); padding: 16px; border-radius: 10px; border: 1px solid rgba(16,185,129,0.15);">
            <div id="detailReviewedBy" style="font-size: 14px; color: var(--success); font-weight: 600;">-</div>
          </div>
        </div>

        <div id="detailApprovedWrap" style="display: none; margin-bottom: 16px;">
          <div style="
            font-size: 12px; font-weight: 700; color: var(--text-secondary); 
            text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
            display: flex; align-items: center; gap: 6px;
          ">
            <i class="fas fa-user-tie" style="color: #06b6d4; font-size: 11px;"></i>
            Approved Kasubag
          </div>
          <div style="background: rgba(6,182,212,0.05); padding: 16px; border-radius: 10px; border: 1px solid rgba(6,182,212,0.15);">
            <div id="detailApprovedBy" style="font-size: 14px; color: #06b6d4; font-weight: 600;">-</div>
          </div>
        </div>

        <div id="detailKomentarWrap" style="display: none;">
          <div style="
            font-size: 12px; font-weight: 700; color: var(--text-secondary); 
            text-transform: uppercase; letter-spacing: .6px; margin-bottom: 12px;
            display: flex; align-items: center; gap: 6px;
          ">
            <i class="fas fa-comment" style="color: var(--warning); font-size: 11px;"></i>
            Komentar Admin
          </div>
          <div style="background: rgba(245,158,11,0.05); padding: 16px; border-radius: 10px; border: 1px solid rgba(245,158,11,0.15);">
            <div id="detailKomentar" style="font-size: 14px; color: var(--text-primary); line-height: 1.6;">-</div>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <div style="
        padding: 20px 28px 28px; border-top: 1px solid var(--border); 
        display: flex; gap: 12px; justify-content: space-between;
      ">
        <div style="font-size: 11px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px;">
          <i class="fas fa-clock" style="font-size: 10px;"></i>
          <span id="detailCreatedAt">-</span>
        </div>
        <div style="display: flex; gap: 8px;">
          <a id="detailSuratLink" href="#" style="
            display: none; padding: 10px 20px; background: rgba(37,99,235,0.08); 
            color: var(--primary); border: 1px solid rgba(37,99,235,0.2); 
            border-radius: 8px; font-size: 13px; font-weight: 600; 
            text-decoration: none; display: flex; align-items: center; gap: 6px;
            transition: all .2s;
          " target="_blank">
            <i class="fas fa-file-pdf"></i> Lihat Surat
          </a>
          <button onclick="closeModal()" style="
            padding: 10px 20px; background: transparent; 
            color: var(--text-secondary); border: 1px solid var(--border); 
            border-radius: 8px; font-size: 13px; font-weight: 600; 
            cursor: pointer; transition: all .2s;
          ">
            <i class="fas fa-times"></i> Tutup
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="toast">
  <i class="fas fa-circle-check" style="color:#10b981;font-size:16px" id="toastIcon"></i>
  <span id="toastMsg">Permintaan berhasil dikirim!</span>
</div>

<script>
let currentStok = 0;

document.getElementById('persediaanSelect').addEventListener('change', function() {
  const preview = document.getElementById('facilityPreview');
  const selected = this.options[this.selectedIndex];
  
  console.log('🔍 SELECTED:', selected.value);
  console.log('📦 data-stok:', selected.getAttribute('data-stok'));
  
  if (selected.value) {
    // ✅ DIRECT PARSING - Sudah terbukti data-stok="5"
    currentStok = parseInt(selected.getAttribute('data-stok')) || 0;
    
    console.log('✅ FINAL STOK:', currentStok);
    
    // Update preview
    document.getElementById('fpName').textContent = selected.dataset.nama || 'N/A';
    document.getElementById('fpKode').textContent = 'Kode: ' + selected.value;
    document.getElementById('fpStok').textContent = 'Stok: ' + currentStok.toLocaleString();
    document.getElementById('fpIcon').innerHTML = '<i class="fas fa-box"></i>';
    preview.classList.add('show');

    updateJumlahMax();
  } else {
    preview.classList.remove('show');
    currentStok = 0;
    updateJumlahMax();
  }
});

function updateJumlahMax() {
  const jumlahInput = document.getElementById('jumlahInput');
  jumlahInput.max = currentStok;
  jumlahInput.title = currentStok > 0 ? `Maks ${currentStok.toLocaleString()}` : '';
  console.log('🔢 MAX SET TO:', jumlahInput.max);
}

// VALIDASI - dengan extra debug
// document.getElementById('permintaanForm').addEventListener('submit', function(e) {
//   console.log('📋 FORM SUBMIT DEBUG:');
//   console.log('- currentStok:', currentStok);
//   console.log('- jumlahInput.value:', document.getElementById('jumlahInput').value);
  
//   const persediaanSelect = document.getElementById('persediaanSelect');
//   const jumlahInput = document.getElementById('jumlahInput');
//   const jumlah = parseInt(jumlahInput.value) || 0;
  
//   if (!persediaanSelect.value) {
//     e.preventDefault();
//     showToast('❌ Pilih barang terlebih dahulu!', 'error');
//     return;
//   }
  
//   if (jumlah > currentStok || currentStok === 0) {
//     e.preventDefault();
//     showToast(`❌ Jumlah ${jumlah} > Stok ${currentStok}`, 'error');
//     return;
//   }
  
//   console.log('✅ VALIDASI LULUS!');
// });

document.querySelector('form').addEventListener('submit', function(e) {
    let persediaanSelect = document.getElementById('persediaan_id');
    
    // Pastikan user sudah memilih opsi barang
    if (persediaanSelect.selectedIndex === 0 || persediaanSelect.value === "") {
        return; // Biarkan validasi HTML default berjalan
    }

    let selectedOption = persediaanSelect.options[persediaanSelect.selectedIndex];
    
    // Ambil nilai data-stok dan ubah menjadi integer
    let currentStok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
    let jumlahInput = document.getElementById('jumlah'); // sesuaikan ID input jumlahmu
    let jumlahPermintaan = parseInt(jumlahInput.value) || 0;

    // Console log untuk memastikan nilai sudah masuk
    console.log('FORM SUBMIT DEBUG:');
    console.log('- currentStok:', currentStok);
    console.log('- jumlahInput:', jumlahPermintaan);

    // Validasi stok
    if (jumlahPermintaan > currentStok) {
        e.preventDefault(); // Hentikan form agar tidak terkirim
        
        // Munculkan alert error
        alert('Stok Tidak Mencukupi! Jumlah permintaan melebihi stok yang tersedia.');
    }
});

function showToast(msg, type = 'success') {
  const toast = document.getElementById('toast');
  const icon = document.getElementById('toastIcon');
  const msgEl = document.getElementById('toastMsg');
  
  msgEl.textContent = msg;
  icon.className = type === 'error' ? 'fas fa-exclamation-triangle' : 'fas fa-circle-check';
  icon.style.color = type === 'error' ? '#ef4444' : '#10b981';
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 4000);
}
</script>
</body>
</html>