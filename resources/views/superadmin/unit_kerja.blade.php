<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIPANDU - Kelola Unit Kerja</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --sidebar-w: 240px;
      --primary: #3b5bdb;
      --primary-light: #eef2ff;
      --sidebar-bg: #1e2a4a;
      --text: #1a1a2e;
      --muted: #6b7280;
      --border: #e5e7eb;
      --card-bg: #ffffff;
      --bg: #f4f6fb;
      --danger: #ef4444;
      --success: #10b981;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
    .main { margin-left: 260px; flex: 1; display: flex; flex-direction: column; }
    .topbar { background: #fff; padding: 16px 32px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50; }
    .page-title { font-size: 20px; font-weight: 700; }
    .page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }
    .topbar-right { display: flex; align-items: center; gap: 12px; }
    .avatar-top { width: 38px; height: 38px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; cursor: pointer; }
    .content { padding: 28px 32px; flex: 1; }

    /* ALERTS */
    .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

    /* TOOLBAR & SEARCH */
    .table-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .search-box { display: flex; align-items: center; background: #fff; border: 1px solid var(--border); border-radius: 8px; padding: 8px 16px; width: 300px; }
    .search-box input { border: none; outline: none; width: 100%; font-family: inherit; font-size: 13px; margin-left: 8px; }
    
    .toolbar-actions { display: flex; gap: 10px; }
    .btn-add { display: flex; align-items: center; gap: 8px; background: var(--primary); color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 14px; font-weight: 600; cursor: pointer; transition: .2s; }
    .btn-add:hover { background: #2f4ac7; }

    /* TABLE */
    .table-card { background: var(--card-bg); border-radius: 14px; border: 1px solid var(--border); overflow: hidden; }
    .table-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-bottom: 1px solid var(--border); background: #fff; }
    .data-count { font-size: 14px; color: var(--muted); font-weight: 500; }
    table { width: 100%; border-collapse: collapse; }
    thead th { text-align: left; padding: 12px 24px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; background: #f9fafb; border-bottom: 1px solid var(--border); }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 14px 24px; font-size: 13px; border-bottom: 1px solid var(--border); vertical-align: middle; color: var(--text); }
    .td-name { font-weight: 600; font-size: 14px; }
    .td-sub { font-size: 12px; color: var(--muted); margin-top: 2px;}
    
    /* ACTIONS */
    .action-group { display: flex; gap: 6px; align-items: center; }
    .btn-action { background: none; border: 1px solid var(--border); border-radius: 6px; padding: 6px 12px; font-size: 12px; font-weight: 600; cursor: pointer; transition: .2s; display: inline-flex; align-items: center; gap: 4px;}
    .btn-action.edit { color: var(--primary); }
    .btn-action.edit:hover { background: var(--primary-light); border-color: var(--primary); }
    .btn-action.delete { color: var(--danger); }
    .btn-action.delete:hover { background: #fee2e2; border-color: var(--danger); }

    /* MODAL */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-overlay.open { display: flex; }
    .modal { background: #fff; border-radius: 16px; padding: 24px 32px; width: 500px; max-width: 95vw; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: slideUp .25s ease; }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;}
    .modal-title i { cursor: pointer; color: var(--muted); }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--text); }
    .form-group input { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 13px; outline: none; transition: .2s; }
    .form-group input:focus { border-color: var(--primary); }
    .modal-actions { display: flex; gap: 10px; margin-top: 24px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--border); }
    .btn-save { padding: 10px 20px; border: none; border-radius: 8px; background: var(--primary); color: #fff; font-weight: 600; cursor: pointer; transition: .2s;}
    .btn-save:hover { background: #2f4ac7; }

    @media (max-width: 768px) {
      .main { margin-left: 0; }
      .topbar { padding: 16px; padding-top: 70px; }
      .content { padding: 16px; }
      .search-box { width: 100%; }
      .table-toolbar { flex-direction: column; }
      .toolbar-actions { width: 100%; justify-content: stretch; }
      .toolbar-actions .btn-add { flex: 1; justify-content: center; }
      .table-card { overflow-x: auto; }
      table { min-width: 600px; }
    }
  </style>
</head>
<body>

@include('partials.sidebar')

<div class="main">
  <div class="topbar">
    <div>
      <div class="page-title">Manajemen Unit Kerja</div>
      <div class="page-sub">Super Admin — BPMP Provinsi Gorontalo</div>
    </div>
    <div class="topbar-right">
      <div class="avatar-top">{{ substr(Auth::user()->name ?? 'SA', 0, 2) }}</div>
    </div>
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error') || $errors->any())
      <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') ?? 'Terdapat kesalahan pada input form Anda.' }}</div>
    @endif

    <div class="table-toolbar">
      <form action="{{ url()->current() }}" method="GET" class="search-box">
        <i class="fas fa-search" style="color: var(--muted)"></i>
        <input type="text" name="search" placeholder="Cari nama unit kerja..." value="{{ request('search') }}">
      </form>
      
      <div class="toolbar-actions">
        <button class="btn-add" onclick="openAddModal()">
          <i class="fas fa-plus"></i> Tambah Unit Kerja
        </button>
      </div>
    </div>

    <div class="table-card">
      <div class="table-header">
        <span class="data-count">Total {{ count($units) ?? 0 }} unit kerja terdaftar</span>
      </div>

      <table>
        <thead>
          <tr>
            <th width="5%">No</th>
            <th>Nama Unit Kerja</th>
            <th>Lokasi (Gedung/Ruangan)</th>
            <th width="15%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($units as $index => $unit)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="td-name">{{ $unit->nama_unit }}</div>
            </td>
            <td>
              <div style="font-weight: 500;">{{ $unit->lokasi ?? '-' }}</div>
            </td>
            <td>
              <div class="action-group">
                <button class="btn-action edit" onclick="openEditModal({{ $unit->id }}, '{{ $unit->nama_unit }}', '{{ $unit->lokasi }}')">
                  <i class="fas fa-edit"></i>
                </button>
                
                <form action="{{ route('superadmin.unit_kerja.destroy', $unit->id) }}" method="POST" style="margin:0;" onsubmit="return confirm('Yakin hapus unit kerja ini? Pastikan tidak ada pegawai atau aset yang terikat dengan unit ini.');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-action delete"><i class="fas fa-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align: center; padding: 40px; color: var(--muted);">Belum ada data unit kerja.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-title">
      <span id="modalTitle">Tambah Unit Kerja</span>
      <i class="fas fa-times" onclick="closeModal('modalOverlay')"></i>
    </div>
    <form id="unitForm" action="{{ route('superadmin.unit_kerja.store') }}" method="POST">
      @csrf
      <input type="hidden" name="_method" id="formMethod" value="POST">
      
      <div class="form-group">
        <label>Nama Unit Kerja <span style="color:red">*</span></label>
        <input type="text" name="nama_unit" id="fieldNamaUnit" placeholder="Contoh: Subbagian Umum" required />
      </div>
      
      <div class="form-group">
        <label>Lokasi Gedung / Ruangan</label>
        <input type="text" name="lokasi" id="fieldLokasi" placeholder="Contoh: Gedung A Lantai 1" />
      </div>

      <div class="modal-actions">
        <button type="submit" class="btn-save">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Sesuaikan URL ini dengan nama Route Laravel Anda
  const storeUrl = "{{ route('superadmin.unit_kerja.store') }}";
  // Gunakan URL dasar untuk di-append dengan ID saat Update
  const updateUrlBase = "{{ url('superadmin/unit-kerja') }}"; 

  function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Unit Kerja';
    document.getElementById('unitForm').action = storeUrl;
    document.getElementById('formMethod').value = 'POST';
    
    // Kosongkan form
    document.getElementById('fieldNamaUnit').value = '';
    document.getElementById('fieldLokasi').value = '';

    document.getElementById('modalOverlay').classList.add('open');
  }

  function openEditModal(id, nama_unit, lokasi) {
    document.getElementById('modalTitle').textContent = 'Edit Unit Kerja';
    document.getElementById('unitForm').action = updateUrlBase + '/' + id;
    document.getElementById('formMethod').value = 'PUT';
    
    // Isi form dengan data yang ada
    document.getElementById('fieldNamaUnit').value = nama_unit;
    document.getElementById('fieldLokasi').value = (lokasi !== '-' && lokasi !== 'null') ? lokasi : '';

    document.getElementById('modalOverlay').classList.add('open');
  }

  function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('open');
  }

  // Tutup modal jika klik di luar area konten modal
  window.onclick = function(event) {
    if (event.target.classList.contains('modal-overlay')) {
      event.target.classList.remove('open');
    }
  }
</script>

</body>
</html>