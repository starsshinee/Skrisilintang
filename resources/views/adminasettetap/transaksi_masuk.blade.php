<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIMASET - Data Aset Tetap</title>
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
  .btn-cancel {
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

{{-- SIDEBAR --}}
@include('partials.sidebar')

<main class="main">
  <!-- Topbar sama persis -->
  <div class="topbar">
    <span class="topbar-title">Transaksi Masuk Aset Tetap</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ now()->translatedFormat('l, d F Y') }}</span>
      <button class="btn-keluar" onclick="document.location='{{ route('logout') }}'">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 11H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2z"/></svg>
        Keluar
      </button>
    </div>
  </div>

  <div class="content">
    {{-- ALERT --}}
    @if(session('success'))
    <div class="alert alert-success">
      <i class="fas fa-check-circle"></i>
      {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-triangle"></i>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- Page Top sama persis -->
    <div class="page-top">
      <div>
        <h1>Transaksi Masuk Aset Tetap</h1>
        <p>Menampilkan {{ $transaksi->firstItem() ?? 0 }}–{{ $transaksi->lastItem() ?? 0 }} dari {{ $transaksi->total() }} data</p>
      </div>
      <button onclick="openModal('createModal')" class="btn-tambah">
        <i class="fas fa-plus"></i>
        Tambah Transaksi
      </button>
    </div>

    <!-- Table sama persis, hanya ubah action buttons -->
    <div class="table-card">
      <div class="table-toolbar">
        <form method="GET" class="search-wrap" style="max-width: 400px;">
          <i class="fas fa-search"></i>
          <input type="text" name="search" placeholder="Cari nomor transaksi, kode barang, NUP..." 
                 value="{{ request('search') }}">
        </form>
        <div class="filter-group">
          <select name="kondisi" class="filter-select" onchange="this.form.submit()">
            <option value="">Semua Kondisi</option>
            @foreach($kondisiOptions as $kondisi)
            <option value="{{ $kondisi }}" {{ request('kondisi') == $kondisi ? 'selected' : '' }}>
              {{ ucwords(str_replace('_', ' ', $kondisi)) }}
            </option>
            @endforeach
          </select>
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th>No</th>
            {{-- <th>Nomor Transaksi</th> --}}
            <th>Tanggal Input</th>
            <th>Kode Barang</th>
            <th>NUP</th>
            <th>Nama Barang</th>
            <th>Merek</th>
            <th>Tanggal Perolehan</th>
            <th>Nilai Perolehan</th>
            <th>Kondisi</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            {{-- <th>Supplier</th>
            <th>Nomor Referensi</th>
            <th>Keterangan</th> --}}
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transaksi as $index => $item)
          <tr>
            <td><strong>{{ $transaksi->firstItem() + $index }}</strong></td>
            <td><strong>{{ $item->nomor_transaksi }}</strong></td>
            <td>{{ $item->tanggal_input }}</td>
            <td>{{ $item->kode_barang }}</td>
            <td>{{ $item->nup }}</td>
            <td>{{ $item->nama_barang }}</td>
            <td>{{ $item->merek ?? '-' }}</td>
            <td>{{ $item->kategori }}</td>
            <td>{{ $item->tanggal_perolehan?->format('d/m/Y') }}</td>
            <td class="nilai">{{ $item->nilai_format }}</td>
            <td>
              <span class="badge badge-{{ $item->kondisi_badge['color'] }}">
                <i class="fas {{ $item->kondisi_badge['icon'] }} me-1"></i>
                {{ $item->kondisi_badge['text'] }}
              </span>
            </td>
            <td>{{ $item->lokasi }}</td>
            <td><strong>{{ $item->jumlah }}</strong></td>
            <td>{{ $item->supplier ?? '-' }}</td>
            <td>{{ $item->nomor_referensi ?? '-' }}</td>
            <td>{{ Str::limit($item->keterangan ?? '-', 30) }}</td>
            <td>
              <div class="action-buttons">
                <button onclick="openDetail({{ $item->id }})" class="action-btn btn-detail" title="Detail">
                  <i class="fas fa-eye"></i>
                </button>
                <button onclick="openEdit({{ $item->id }})" class="action-btn btn-edit" title="Edit">
                  <i class="fas fa-edit"></i>
                </button>
                <button onclick="confirmDelete({{ $item->id }})" class="action-btn btn-delete" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="17" class="text-center py-8">
              <i class="fas fa-inbox text-4xl text-muted mb-3 block"></i>
              <div class="text-muted">Belum ada data transaksi masuk aset tetap</div>
              <button onclick="openModal('createModal')" class="btn-tambah mt-3 inline-block">
                Tambah transaksi pertama
              </button>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <div class="table-footer">
        <span>{{ $transaksi->total() }} data tersedia</span>
        <div class="pagination">
          {{ $transaksi->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>
</main>

{{-- MODAL CREATE --}}
<div id="createModal" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title"><i class="fas fa-plus-circle text-success me-2"></i>Tambah Transaksi Masuk</h3>
      <p class="modal-subtitle">Isi data transaksi masuk aset tetap baru</p>
    </div>
    <form id="createForm" method="POST" action="{{ route('adminasettetap.transaksi-masuk.store') }}">
      @csrf
      <div class="modal-body">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nomor Transaksi *</label>
            <input type="text" name="nomor_transaksi" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Kode Barang *</label>
            <input type="text" name="kode_barang" class="form-input" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">NUP *</label>
            <input type="text" name="nup" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Jumlah *</label>
            <input type="number" name="jumlah" class="form-input" min="1" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Barang *</label>
            <input type="text" name="nama_barang" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Merek</label>
            <input type="text" name="merek" class="form-input">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Kondisi *</label>
            <select name="kondisi" class="form-select" required>
              <option value="">Pilih Kondisi</option>
              @foreach($kondisiOptions as $kondisi)
              <option value="{{ $kondisi }}">{{ ucwords(str_replace('_', ' ', $kondisi)) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" class="form-input">
          </div>
          <div class="form-group">
            <label class="form-label">Nilai Perolehan</label>
            <input type="number" name="nilai_perolehan" class="form-input" step="0.01" min="0">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Lokasi *</label>
            <input type="text" name="lokasi" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" class="form-input">
          </div>
        </div>
                <div class="form-group">
          <label class="form-label">Nomor Referensi</label>
          <input type="text" name="nomor_referensi" class="form-input">
        </div>
        <div class="form-group form-row.full">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-textarea" placeholder="Masukkan keterangan tambahan..."></textarea>
        </div>
      </div>
      <div class="btn-group">
        <button type="button" class="btn-modal btn-cancel" onclick="closeModal('createModal')">Batal</button>
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save me-2"></i>Simpan Transaksi
        </button>
      </div>
      
    </form>
  </div>
</div>

{{-- MODAL DETAIL --}}
<div id="detailModal" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title"><i class="fas fa-eye text-info me-2"></i>Detail Transaksi</h3>
      <p class="modal-subtitle" id="detailSubtitle"></p>
    </div>
    <div class="modal-body">
      <div id="detailContent"></div>
    </div>
    <div class="btn-group">
      <button type="button" class="btn-modal btn-cancel" onclick="closeModal('detailModal')">Tutup</button>
    </div>
  </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="modal-overlay">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title"><i class="fas fa-edit text-warning me-2"></i>Edit Transaksi</h3>
      <p class="modal-subtitle" id="editSubtitle"></p>
    </div>
    <form id="editForm" method="POST">
      @method('PUT')
      <div class="modal-body">
        <input type="hidden" name="id" id="editId">
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nomor Transaksi *</label>
            <input type="text" name="nomor_transaksi" id="editNomorTransaksi" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Kode Barang *</label>
            <input type="text" name="kode_barang" id="editKodeBarang" class="form-input" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">NUP *</label>
            <input type="text" name="nup" id="editNup" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Jumlah *</label>
            <input type="number" name="jumlah" id="editJumlah" class="form-input" min="1" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Barang *</label>
            <input type="text" name="nama_barang" id="editNamaBarang" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Merek</label>
            <input type="text" name="merek" id="editMerek" class="form-input">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Kategori *</label>
            <select name="kategori" id="editKategori" class="form-select" required>
              <option value="">Pilih Kategori</option>
              @foreach($kategoriOptions as $kategori)
              <option value="{{ $kategori }}">{{ $kategori }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Kondisi *</label>
            <select name="kondisi" id="editKondisi" class="form-select" required>
              <option value="">Pilih Kondisi</option>
              @foreach($kondisiOptions as $kondisi)
              <option value="{{ $kondisi }}">{{ ucwords(str_replace('_', ' ', $kondisi)) }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Perolehan</label>
            <input type="date" name="tanggal_perolehan" id="editTanggalPerolehan" class="form-input">
          </div>
          <div class="form-group">
            <label class="form-label">Nilai Perolehan</label>
            <input type="number" name="nilai_perolehan" id="editNilaiPerolehan" class="form-input" step="0.01" min="0">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Lokasi *</label>
            <input type="text" name="lokasi" id="editLokasi" class="form-input" required>
          </div>
          <div class="form-group">
            <label class="form-label">Supplier</label>
            <input type="text" name="supplier" id="editSupplier" class="form-input">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Nomor Referensi</label>
          <input type="text" name="nomor_referensi" id="editNomorReferensi" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" id="editKeterangan" class="form-textarea" placeholder="Masukkan keterangan tambahan..."></textarea>
        </div>
      </div>
      <div class="btn-group">
        <button type="button" class="btn-modal btn-cancel" onclick="closeModal('editModal')">Batal</button>
        <button type="submit" class="btn-modal btn-confirm">
          <i class="fas fa-save me-2"></i>Update Transaksi
        </button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL DELETE --}}
<div id="deleteModal" class="modal-overlay">
  <div class="modal">
    <h3><i class="fas fa-exclamation-triangle text-warning me-2"></i>Hapus Transaksi?</h3>
    <p>Data transaksi masuk aset tetap ini akan dihapus permanen dan tidak dapat dikembalikan.</p>
    <div class="modal-buttons">
      <button class="btn-modal btn-cancel" onclick="closeModal('deleteModal')">Batal</button>
      <form id="deleteForm" method="POST" style="display: inline;">
        @csrf @method('DELETE')
        <button type="submit" class="btn-modal btn-confirm">Hapus</button>
      </form>
    </div>
  </div>
</div>

<script>
// Data transaksi untuk modal detail dan edit (akan diisi via AJAX atau dari server)
let transaksiData = {};

// Fungsi untuk membuka modal
function openModal(modalId) {
  document.getElementById(modalId).classList.add('show');
}

// Fungsi untuk menutup modal
function closeModal(modalId = null) {
  if (!modalId) {
    document.querySelectorAll('.modal-overlay.show').forEach(modal => {
      modal.classList.remove('show');
    });
  } else {
    document.getElementById(modalId).classList.remove('show');
  }
  // Reset form edit
  if (modalId === 'editModal') {
    document.getElementById('editForm').reset();
  }
}

// Open Detail Modal
function openDetail(id) {
  // Simulasi data - ganti dengan AJAX call ke show route
  fetch(`/admin/transaksi-masuk/${id}`)
    .then(response => response.json())
    .then(data => {
      transaksiData = data;
      populateDetailModal(data);
      openModal('detailModal');
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Gagal memuat data detail');
    });
}

// Populate Detail Modal
function populateDetailModal(data) {
  document.getElementById('detailSubtitle').textContent = `Transaksi #${data.nomor_transaksi}`;
  
  const kondisiColors = {
    'baik': 'success',
    'rusak_ringan': 'warning', 
    'rusak_berat': 'danger'
  };
  
  document.getElementById('detailContent').innerHTML = `
    <div class="detail-content">
      <div class="detail-label">Nomor Transaksi</div>
      <div class="detail-value">${data.nomor_transaksi || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Kode Barang</div>
      <div class="detail-value">${data.kode_barang || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">NUP</div>
      <div class="detail-value">${data.nup || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Nama Barang</div>
      <div class="detail-value">${data.nama_barang || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Merek</div>
      <div class="detail-value">${data.merek || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Kategori</div>
      <div class="detail-value">${data.kategori || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Kondisi</div>
      <div class="detail-value">
        <span class="badge badge-${kondisiColors[data.kondisi] || 'info'}">
          <i class="fas fa-circle me-1"></i>
          ${data.kondisi ? ucwords(str_replace('_', ' ', data.kondisi)) : '-'}
        </span>
      </div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Jumlah</div>
      <div class="detail-value">${data.jumlah || 0}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Lokasi</div>
      <div class="detail-value">${data.lokasi || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Tanggal Perolehan</div>
      <div class="detail-value">${data.tanggal_perolehan ? new Date(data.tanggal_perolehan).toLocaleDateString('id-ID') : '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Nilai Perolehan</div>
      <div class="detail-value">Rp ${data.nilai_perolehan ? parseFloat(data.nilai_perolehan).toLocaleString('id-ID') : '0'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Supplier</div>
      <div class="detail-value">${data.supplier || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Nomor Referensi</div>
      <div class="detail-value">${data.nomor_referensi || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Keterangan</div>
      <div class="detail-value">${data.keterangan || '-'}</div>
    </div>
    <div class="detail-content">
      <div class="detail-label">Tanggal Input</div>
      <div class="detail-value">${data.tanggal_input ? new Date(data.tanggal_input).toLocaleDateString('id-ID') : '-'}</div>
    </div>
  `;
}

// Open Edit Modal
function openEdit(id) {
  fetch(`/admin/transaksi-masuk/${id}/edit`)
    .then(response => response.json())
    .then(data => {
      populateEditModal(data);
      document.getElementById('editForm').action = `/admin/transaksi-masuk/${id}`;
      openModal('editModal');
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Gagal memuat data edit');
    });
}

// Populate Edit Modal
function populateEditModal(data) {
  document.getElementById('editId').value = data.id;
  document.getElementById('editNomorTransaksi').value = data.nomor_transaksi || '';
  document.getElementById('editKodeBarang').value = data.kode_barang || '';
  document.getElementById('editNup').value = data.nup || '';
  document.getElementById('editNamaBarang').value = data.nama_barang || '';
  document.getElementById('editMerek').value = data.merek || '';
  document.getElementById('editKategori').value = data.kategori || '';
  document.getElementById('editKondisi').value = data.kondisi || '';
  document.getElementById('editJumlah').value = data.jumlah || '';
  document.getElementById('editLokasi').value = data.lokasi || '';
  document.getElementById('editTanggalPerolehan').value = data.tanggal_perolehan || '';
  document.getElementById('editNilaiPerolehan').value = data.nilai_perolehan || '';
  document.getElementById('editSupplier').value = data.supplier || '';
  document.getElementById('editNomorReferensi').value = data.nomor_referensi || '';
  document.getElementById('editKeterangan').value = data.keterangan || '';
  document.getElementById('editSubtitle').textContent = `Edit Transaksi #${data.nomor_transaksi}`;
}

// Delete confirmation
function confirmDelete(id) {
  const modal = document.getElementById('deleteModal');
  const form = document.getElementById('deleteForm');
  form.action = `/admin/transaksi-masuk/${id}`;
  modal.classList.add('show');
}

// Close modal on outside click
document.querySelectorAll('.modal-overlay').forEach(modal => {
  modal.addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });
});

// Escape key to close modal
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeModal();
  }
});

// Form submit handlers
document.getElementById('editForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  const actionUrl = this.action;
  
  fetch(actionUrl, {
    method: 'PUT',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      location.reload();
    } else {
      alert('Gagal update data');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Terjadi kesalahan');
  });
});

</script>

</body>
</html>