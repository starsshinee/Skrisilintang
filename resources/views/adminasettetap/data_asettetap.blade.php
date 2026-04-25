<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Data Aset Tetap</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
    --success: #10B981;
    --danger: #EF4444;
    --warning: #F59E0B;
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

  /* ALERT */
  .alert {
    padding: 14px 18px; border-radius: 10px; margin-bottom: 20px;
    display: flex; align-items: center; gap: 10px; font-weight: 600;
  }
  .alert-success { background: #ECFDF5; color: var(--success); border: 1px solid #BBF7D0; }
  .alert-danger { background: #FEF2F2; color: var(--danger); border: 1px solid #FECACA; }

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

  /* STATUS BADGE */
  .status-badge {
    padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
  }
  .status-baikk { background: #ECFDF5; color: var(--success); }
  .status-rusak { background: #FEF2F2; color: var(--danger); }
  .status-perawatan { background: #FEF3C7; color: var(--warning); }

  /* ACTION BUTTONS */
  td:last-child { white-space: nowrap; }
  .action-btn {
    width: 36px; height: 36px; border-radius: 8px;
    border: 1px solid var(--border); background: var(--surface);
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .15s; margin-left: 4px;
  }
  .action-btn:hover { background: #EEF2FF; border-color: var(--blue); transform: translateY(-1px); }
  .action-btn.danger:hover { background: #FEF2F2; border-color: var(--danger); }
  .action-btn svg { width: 16px; height: 16px; }

  /* MODAL */
  .modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,.5); display: flex; align-items: center; justify-content: center;
    z-index: 1000; opacity: 0; visibility: hidden; transition: all .2s;
  }
  .modal-overlay.show { opacity: 1; visibility: visible; }
  .modal {
    background: var(--surface); border-radius: var(--radius); padding: 28px;
    max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto;
    transform: scale(.9) translateY(-20px); transition: all .2s;
  }
  .modal-overlay.show .modal { transform: scale(1) translateY(0); }
  .modal-title { font-size: 20px; font-weight: 800; color: var(--text); margin-bottom: 20px; }
  .form-group { margin-bottom: 20px; }
  .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
  .form-input, .form-select {
    width: 100%; padding: 12px 16px; border-radius: 10px;
    border: 1.5px solid var(--border); background: var(--bg);
    font-family: inherit; font-size: 14px; transition: all .15s;
  }
  .form-input:focus, .form-select:focus {
    outline: none; border-color: var(--blue); box-shadow: 0 0 0 3px rgba(79,111,255,.1);
  }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
  .btn {
    padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 14px;
    border: none; cursor: pointer; transition: all .2s; font-family: inherit;
  }
  .btn-primary {
    background: linear-gradient(135deg, var(--blue), #7C3AED);
    color: white; box-shadow: 0 4px 14px rgba(79,111,255,.35);
  }
  .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,111,255,.45); }
  .btn-secondary {
    background: var(--bg); color: var(--text); border: 1.5px solid var(--border);
  }
  .btn-danger {
    background: var(--danger); color: white;
  }
  .btn-danger:hover { background: #DC2626; }
  .btn-group { display: flex; gap: 12px; justify-content: flex-end; }

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
  .page-btn:hover:not(.active) { border-color: var(--blue); color: var(--blue); }
  .page-btn.active {
    background: var(--blue); border-color: var(--blue);
    color: white; font-weight: 700;
  }

  @media (max-width: 768px) {
    .main { margin-left: 0; }
    .sidebar { transform: translateX(-100%); }
    .table-toolbar { flex-direction: column; align-items: stretch; gap: 12px; }
    .form-row { grid-template-columns: 1fr; }
    .page-top { flex-direction: column; gap: 16px; align-items: stretch; }
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Data Aset Tetap</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</span>
      {{-- <button class="btn-keluar" onclick="document.location='{{ route('admin.logout') }}'"> --}}
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 11H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2z"/></svg>
        Keluar
      </button>
    </div>
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        {{ session('error') }}
      </div>
    @endif

    <div class="page-top">
      <div>
        <h1>Data Aset Tetap</h1>
        <p>{{ $asetTetap->total() }} data ditemukan</p>
      </div>
      <a href="#modal-tambah" class="btn-tambah" onclick="openModal('modal-tambah')">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        Tambah Baru
      </a>
    </div>

    <div class="table-card">
      <div class="table-toolbar">
        <form method="GET" action="{{ route('adminasettetap.data-aset-tetap') }}" class="search-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8"><path d="M15.5 14h-.79l-.28-.27A6.47 6.47 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
          <input type="text" name="search" placeholder="Cari aset tetap..." value="{{ request('search') }}">
        </form>
        <select name="kategori_id" class="filter-select" onchange="this.form.submit()">
          <option value="">Semua Kategori</option>
          @foreach($kategoris ?? [] as $kategori)
            <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
              {{ $kategori->nama }}
            </option>
          @endforeach
        </select>
        <button type="submit" form="search-form" class="btn-filter">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M4.25 5.61C6.27 8.2 10 13 10 13v6c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-6s3.72-4.8 5.74-7.39A1 1 0 0018.95 4H5.04a1 1 0 00-.79 1.61z"/></svg>
          Filter
        </button>
      </div>

      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Input</th>
            <th>Kode Barang</th>
            <th>NUP</th>
            <th>Nama Barang</th>
            <th>Merek</th>
            <th>Kategori</th>
            <th>Tanggal Perolehan</th>
            <th>Nilai Perolehan</th>
            <th>Kondisi</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($asetTetap as $index => $aset)
            <tr>
              <td><strong>{{ $asetTetap->firstItem() + $index }}</strong></td>
              <td>{{ $aset->tanggal_input?->format('d-m-Y') ?? '-' }}</td>
              <td><strong>{{ $aset->kode_barang ?? '-' }}</strong></td>
              <td>{{ $aset->nup ?? '-' }}</td>
              <td>{{ $aset->nama_barang ?? '-' }}</td>
              <td>{{ $aset->merek ?? '-' }}</td>
              <td>{{ $aset->kategori ?? '-' }}</td>
              <td>{{ $aset->tanggal_perolehan?->format('d-m-Y') ?? '-' }}</td>
              <td><strong>Rp {{ number_format($aset->nilai_perolehan ?? 0, 0, ',', '.') }}</strong></td>
              <td>
                @php $kondisi = $aset->kondisi ?? 'baik'; @endphp
                <span class="status-badge status-{{ str_replace(' ', '-', $kondisi) }}">
                  {{ ucwords(str_replace(['rusak ringan', 'rusak berat'], ['Rusak Ringan', 'Rusak Berat'], $kondisi)) }}
                </span>
              </td>
              <td>{{ $aset->lokasi ?? '-' }}</td>
              <td><strong>{{ $aset->jumlah ?? 0 }}</strong></td>
              <td>
                <a href="#modal-detail-{{ $aset->id }}" class="action-btn" onclick="openModal('modal-detail-{{ $aset->id }}')" title="Detail">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8">
                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                  </svg>
                </a>
                <a href="#modal-edit-{{ $aset->id }}" class="action-btn" onclick="openModal('modal-edit-{{ $aset->id }}')" title="Edit">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8">
                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zm18-11.5c0-.41-.17-.79-.44-1.06l-2.25-2.25a1.5 1.5 0 0 0-2.12 0l-1.83 1.83 3.75 3.75 1.83-1.83c.27-.27.44-.65.44-1.06z"/>
                  </svg>
                </a>
                <form action="{{ route('admin.data-aset-tetap.destroy', $aset->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus aset tetap ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="action-btn danger" title="Hapus">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8">
                      <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                    </svg>
                  </button>
                </form>
              </td>
            </tr>
            
            {{-- MODAL DETAIL --}}
            <div id="modal-detail-{{ $aset->id }}" class="modal-overlay">
              <div class="modal">
                <h2 class="modal-title">Detail Aset Tetap</h2>
                
                <div class="form-group">
                  <div class="form-label">Tanggal Input</div>
                  <div>{{ $aset->tanggal_input?->format('d F Y') ?? '-' }}</div>
                </div>
                
                <div class="form-group">
                  <div class="form-label">Kode Barang</div>
                  <div><strong>{{ $aset->kode_barang ?? '-' }}</strong></div>
                </div>
                
                <div class="form-group">
                  <div class="form-label">NUP</div>
                  <div><strong>{{ $aset->nup ?? '-' }}</strong></div>
                </div>
                
                <div class="form-group">
                  <div class="form-label">Nama Barang</div>
                  <div><strong>{{ $aset->nama_barang ?? '-' }}</strong></div>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <div class="form-label">Merek</div>
                    <div>{{ $aset->merek ?? '-' }}</div>
                  </div>
                  <div class="form-group">
                    <div class="form-label">Kategori</div>
                    <div>{{ $aset->kategori ?? '-' }}</div>
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <div class="form-label">Tanggal Perolehan</div>
                    <div>{{ $aset->tanggal_perolehan?->format('d F Y') ?? '-' }}</div>
                  </div>
                  <div class="form-group">
                    <div class="form-label">Kondisi</div>
                    <div>
                      @php $kondisi = $aset->kondisi ?? 'baik'; @endphp
                      <span class="status-badge status-{{ str_replace(' ', '-', $kondisi) }}">
                        {{ ucwords(str_replace(['rusak ringan', 'rusak berat'], ['Rusak Ringan', 'Rusak Berat'], $kondisi)) }}
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <div class="form-label">Nilai Perolehan</div>
                    <div><strong>Rp {{ number_format($aset->nilai_perolehan ?? 0, 0, ',', '.') }}</strong></div>
                  </div>
                  <div class="form-group">
                    <div class="form-label">Jumlah</div>
                    <div><strong>{{ $aset->jumlah ?? 0 }} {{ $aset->jumlah > 1 ? 'unit' : 'unit' }}</strong></div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="form-label">Lokasi</div>
                  <div>{{ $aset->lokasi ?? '-' }}</div>
                </div>
                
                <div class="form-group">
                  <div class="form-label">Dibuat</div>
                  <div>{{ $aset->created_at?->format('d F Y H:i') ?? '-' }}</div>
                </div>
                
                <div class="form-group">
                  <div class="form-label">Diupdate</div>
                  <div>{{ $aset->updated_at?->format('d F Y H:i') ?? '-' }}</div>
                </div>
                
                <div class="btn-group">
                  <a href="{{ route('adminasettetap.data-aset-tetap.edit', $aset->id) }}" class="btn btn-primary">
                    Edit Aset
                  </a>
                  <button class="btn btn-secondary" onclick="closeModal('modal-detail-{{ $aset->id }}')">Tutup</button>
                </div>
              </div>
            </div>

            {{-- MODAL EDIT --}}
          <div id="modal-edit-{{ $aset->id }}" class="modal-overlay">
            <div class="modal">
              <h2 class="modal-title">Edit Aset Tetap</h2>
              <form action="{{ route('adminasettetap.data-aset-tetap.update', $aset->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Kode Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_barang" class="form-input @error('kode_barang') border-red-300 @enderror" 
                          value="{{ old('kode_barang', $aset->kode_barang) }}" required>
                    @error('kode_barang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group">
                    <label class="form-label">NUP <span class="text-red-500">*</span></label>
                    <input type="text" name="nup" class="form-input @error('nup') border-red-300 @enderror" 
                          value="{{ old('nup', $aset->nup) }}" required>
                    @error('nup') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="form-label">Nama Barang <span class="text-red-500">*</span></label>
                  <input type="text" name="nama_barang" class="form-input @error('nama_barang') border-red-300 @enderror" 
                        value="{{ old('nama_barang', $aset->nama_barang) }}" required>
                  @error('nama_barang') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Merek</label>
                    <input type="text" name="merek" class="form-input @error('merek') border-red-300 @enderror" 
                          value="{{ old('merek', $aset->merek) }}">
                    @error('merek') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-input @error('kategori') border-red-300 @enderror" 
                          value="{{ old('kategori', $aset->kategori) }}" placeholder="Elektronik/Furniture">
                    @error('kategori') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Tanggal Perolehan</label>
                    <input type="date" name="tanggal_perolehan" class="form-input @error('tanggal_perolehan') border-red-300 @enderror" 
                          value="{{ old('tanggal_perolehan', $aset->tanggal_perolehan?->format('Y-m-d')) }}">
                    @error('tanggal_perolehan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group">
                    <label class="form-label">Kondisi <span class="text-red-500">*</span></label>
                    <select name="kondisi" class="form-select @error('kondisi') border-red-300 @enderror" required>
                      <option value="">Pilih Kondisi</option>
                      <option value="baik" {{ old('kondisi', $aset->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                      <option value="rusak ringan" {{ old('kondisi', $aset->kondisi) == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                      <option value="rusak berat" {{ old('kondisi', $aset->kondisi) == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('kondisi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                </div>
                
                <div class="form-row">
                  <div class="form-group">
                    <label class="form-label">Nilai Perolehan (Rp)</label>
                    <input type="number" name="nilai_perolehan" class="form-input @error('nilai_perolehan') border-red-300 @enderror" 
                          value="{{ old('nilai_perolehan', $aset->nilai_perolehan) }}" step="0.01" min="0">
                    @error('nilai_perolehan') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group">
                    <label class="form-label">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" class="form-input @error('jumlah') border-red-300 @enderror" 
                          value="{{ old('jumlah', $aset->jumlah) }}" min="0" required>
                    @error('jumlah') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="form-label">Lokasi</label>
                  <input type="text" name="lokasi" class="form-input @error('lokasi') border-red-300 @enderror" 
                        value="{{ old('lokasi', $aset->lokasi) }}" placeholder="Ruang Server / Gudang Utama">
                  @error('lokasi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit-{{ $aset->id }}')">Batal</button>
                  <button type="submit" class="btn btn-primary">Update Aset</button>
                </div>
              </form>
            </div>
          </div>
          @empty
            <tr>
              <td colspan="13" class="text-center py-8">
                <div class="text-center py-12">
                  <svg width="64" height="64" viewBox="0 0 24 24" fill="#94A3B8" style="margin: 0 auto 16px;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                  </svg>
                  <h3 class="text-lg font-semibold text-gray-500 mb-2">Tidak ada data</h3>
                  <p class="text-sm text-gray-400 mb-4">Belum ada data aset tetap yang ditemukan</p>
                  <a href="#modal-tambah" class="btn-tambah inline-flex" onclick="openModal('modal-tambah')">Tambah Aset Pertama</a>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="table-footer">
        @if($asetTetap->hasPages())
          <span>Menampilkan {{ $asetTetap->firstItem() }}–{{ $asetTetap->lastItem() }} dari {{ $asetTetap->total() }} data</span>
        @else
          <span>Menampilkan {{ $asetTetap->total() }} data</span>
        @endif
        {!! $asetTetap->appends(request()->query())->links() !!}
      </div>
    </div>
  </div>
</main>

{{-- MODAL TAMBAH --}}
<div id="modal-tambah" class="modal-overlay">
  <div class="modal">
    <h2 class="modal-title">Tambah Aset Tetap</h2>
    <form action="{{ route('adminasettetap.data-aset-tetap.store') }}" method="POST">
      @csrf
      
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Kode Barang <span class="text-red-500">*</span></label>
          <input type="text" name="kode_barang" class="form-input @error('kode_barang') border-red-300 @enderror" 
                 value="{{ old('kode_barang') }}" required>
          @error('kode_barang') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">NUP <span class="text-red-500">*</span></label>
          <input type="text" name="nup" class="form-input @error('nup') border-red-300 @enderror" 
                 value="{{ old('nup') }}" required>
          @error('nup') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Nama Barang <span class="text-red-500">*</span></label>
        <input type="text" name="nama_barang" class="form-input @error('nama_barang') border-red-300 @enderror" 
               value="{{ old('nama_barang') }}" required>
        @error('nama_barang') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Merek</label>
          <input type="text" name="merek" class="form-input @error('merek') border-red-300 @enderror" 
                 value="{{ old('merek') }}">
          @error('merek') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Kategori</label>
          <input type="text" name="kategori" class="form-input @error('kategori') border-red-300 @enderror" 
                 value="{{ old('kategori') }}" placeholder="Elektronik / Furniture / Kendaraan">
          @error('kategori') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Tanggal Perolehan</label>
          <input type="date" name="tanggal_perolehan" class="form-input @error('tanggal_perolehan') border-red-300 @enderror" 
                 value="{{ old('tanggal_perolehan') }}">
          @error('tanggal_perolehan') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Kondisi <span class="text-red-500">*</span></label>
          <select name="kondisi" class="form-select @error('kondisi') border-red-300 @enderror" required>
            <option value="">Pilih Kondisi</option>
            <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="rusak ringan" {{ old('kondisi') == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="rusak berat" {{ old('kondisi') == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
          </select>
          @error('kondisi') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Nilai Perolehan (Rp)</label>
          <input type="number" name="nilai_perolehan" class="form-input @error('nilai_perolehan') border-red-300 @enderror" 
                 value="{{ old('nilai_perolehan') }}" step="0.01" min="0">
          @error('nilai_perolehan') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
          <label class="form-label">Jumlah <span class="text-red-500">*</span></label>
          <input type="number" name="jumlah" class="form-input @error('jumlah') border-red-300 @enderror" 
                 value="{{ old('jumlah') }}" min="0" required>
          @error('jumlah') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Lokasi</label>
        <input type="text" name="lokasi" class="form-input @error('lokasi') border-red-300 @enderror" 
               value="{{ old('lokasi') }}" placeholder="Ruang Server / Gudang Utama / Ruang Rapat">
        @error('lokasi') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
      </div>

      <div class="btn-group">
        <button type="button" class="btn btn-secondary" onclick="closeModal('modal-tambah')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Aset</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal(modalId) {
  document.getElementById(modalId).classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove('show');
  document.body.style.overflow = 'auto';
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      overlay.classList.remove('show');
      document.body.style.overflow = 'auto';
    }
  });
});

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-overlay.show').forEach(overlay => {
      overlay.classList.remove('show');
      document.body.style.overflow = 'auto';
    });
  }
});
</script>

</body>
</html>