<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Gedung - Admin Sarana Prasarana</title>
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
    background: var(--card-bg); border-bottom: 1px solid var(--border);
    padding: 14px 28px; display: flex; justify-content: flex-end; align-items: center;
    position: sticky; top: 0; z-index: 50;
  }
  .notif-btn {
    position: relative; width: 38px; height: 38px; border-radius: 50%;
    background: var(--body-bg); display: flex; align-items: center; justify-content: center;
    cursor: pointer; border: 1px solid var(--border);
  }
  .notif-badge {
    position: absolute; top: 4px; right: 4px;
    width: 8px; height: 8px; background: var(--danger);
    border-radius: 50%; border: 2px solid #fff;
  }
  .content { padding: 24px 28px; flex: 1; }

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
  .badge-tersedia { background: var(--success-light); color: var(--success); }
  .badge-baik { background: #e8faf9; color: #2ec4b6; }
  .badge-renovasi { background: #fff4ec; color: #f4a261; }
  .badge-perlu { background: #fdecea; color: #e63946; font-size: 11px; }

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

  /* Modal */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.4);
    display: none; align-items: center; justify-content: center; z-index: 200;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: #fff; border-radius: 16px; padding: 28px;
    width: 480px; max-width: 90vw;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
  }
  .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; }
  .form-group { margin-bottom: 16px; }
  .form-label { font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block; }
  .form-input {
    width: 100%; padding: 10px 14px; border: 1px solid var(--border);
    border-radius: 10px; font-family: inherit; font-size: 13px; outline: none;
    transition: border .2s;
  }
  .form-input:focus { border-color: var(--primary); }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
  .btn-cancel {
    padding: 10px 18px; border: 1px solid var(--border); border-radius: 10px;
    font-family: inherit; font-size: 14px; cursor: pointer; background: #fff;
    font-weight: 500; color: var(--text-secondary);
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <div class="notif-btn">
      <svg width="18" height="18" fill="none" stroke="#6b7280" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
      <div class="notif-badge"></div>
    </div>
  </div>
  <div class="content">
    <div class="toolbar">
      <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input class="search-input" type="text" placeholder="Cari gedung..." oninput="filterTable(this.value)">
      </div>
      <button class="btn-primary" onclick="openModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 5v14m-7-7h14"/></svg>
        Tambah Gedung
      </button>
    </div>

    <div class="table-card">
      <table id="gedungTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Gedung</th>
            <th>Lantai</th>
            <th>Ruangan</th>
            <th>Ketersediaan</th>
            <th>Tahun Bangun</th>
            <th>Kondisi</th>
            <th>Foto</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <tr>
            <td>1</td><td>Gedung A - Rektorat</td><td>4</td><td>18</td>
            <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
            <td>2015</td>
            <td><span class="status-badge badge-baik">Baik</span></td>
            <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
            <td><div class="action-btns">
              <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>\
              <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
            </div></td>
          </tr>
          <tr>
            <td>2</td><td>Gedung B - Fakultas Teknik</td><td>3</td><td>24</td>
            <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
            <td>2018</td>
            <td><span class="status-badge badge-baik">Baik</span></td>
            <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
            <td><div class="action-btns">
              <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
              <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
            </div></td>
          </tr>
          <tr>
            <td>3</td><td>Gedung C - Perpustakaan</td><td>3</td><td>12</td>
            <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
            <td>2010</td>
            <td><span class="status-badge badge-renovasi">Renovasi</span></td>
            <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
            <td><div class="action-btns">
              <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
              <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
            </div></td>
          </tr>
          <tr>
            <td>4</td><td>Gedung D - Auditorium</td><td>2</td><td>8</td>
            <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
            <td>2020</td>
            <td><span class="status-badge badge-baik">Baik</span></td>
            <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
            <td><div class="action-btns">
              <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
              <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
            </div></td>
          </tr>
          <tr>
            <td>5</td><td>Gedung E - Laboratorium</td><td>3</td><td>20</td>
            <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
            <td>2008</td>
            <td><span class="status-badge badge-perlu">Perlu Perbaikan</span></td>
            <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
            <td><div class="action-btns">
              <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
              <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
            </div></td>
          </tr>
          <tr>
            <td>6</td><td>Gedung F - Pusat Kegiatan</td><td>2</td><td>14</td>
            <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
            <td>2019</td>
            <td><span class="status-badge badge-baik">Baik</span></td>
            <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
            <td><div class="action-btns">
              <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
              <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
            </div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- Modal Tambah Gedung -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModalOutside(event)">
  <div class="modal">
    <div class="modal-title">Tambah Gedung Baru</div>
    <div class="form-group">
      <label class="form-label">Nama Gedung</label>
      <input class="form-input" type="text" placeholder="Contoh: Gedung G - Rektorat Baru" id="namaGedung">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Jumlah Lantai</label>
        <input class="form-input" type="number" placeholder="4" id="lantai">
      </div>
      <div class="form-group">
        <label class="form-label">Jumlah Ruangan</label>
        <input class="form-input" type="number" placeholder="20" id="ruangan">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tahun Bangun</label>
        <input class="form-input" type="number" placeholder="2024" id="tahun">
      </div>
      <div class="form-group">
        <label class="form-label">Kondisi</label>
        <select class="form-input" id="kondisi">
          <option>Baik</option>
          <option>Renovasi</option>
          <option>Perlu Perbaikan</option>
        </select>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal()">Batal</button>
      <button class="btn-primary" onclick="addGedung()">Simpan</button>
    </div>
  </div>
</div>

<script>
  function openModal() { document.getElementById('modalOverlay').classList.add('open'); }
  function closeModal() { document.getElementById('modalOverlay').classList.remove('open'); }
  function closeModalOutside(e) { if (e.target === document.getElementById('modalOverlay')) closeModal(); }

  function deleteRow(btn) {
    if (confirm('Hapus data gedung ini?')) {
      btn.closest('tr').remove();
      renumberRows();
    }
  }
  function renumberRows() {
    document.querySelectorAll('#tableBody tr').forEach((tr, i) => {
      tr.cells[0].textContent = i + 1;
    });
  }

  function addGedung() {
    const nama = document.getElementById('namaGedung').value;
    const lantai = document.getElementById('lantai').value;
    const ruangan = document.getElementById('ruangan').value;
    const tahun = document.getElementById('tahun').value;
    const kondisi = document.getElementById('kondisi').value;
    if (!nama || !lantai || !ruangan || !tahun) { alert('Harap isi semua field!'); return; }
    const tbody = document.getElementById('tableBody');
    const rowCount = tbody.rows.length + 1;
    const kondisiBadge = kondisi === 'Baik' ? 'badge-baik' : kondisi === 'Renovasi' ? 'badge-renovasi' : 'badge-perlu';
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${rowCount}</td><td>${nama}</td><td>${lantai}</td><td>${ruangan}</td>
      <td><span class="status-badge badge-tersedia">✓ Tersedia</span></td>
      <td>${tahun}</td>
      <td><span class="status-badge ${kondisiBadge}">${kondisi}</span></td>
      <td><div class="act-btn photo"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg></div></td>
      <td><div class="action-btns">
        <div class="act-btn view"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
        <div class="act-btn del" onclick="deleteRow(this)"><svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg></div>
      </div></td>
    `;
    tbody.appendChild(tr);
    closeModal();
    ['namaGedung','lantai','ruangan','tahun'].forEach(id => document.getElementById(id).value = '');
  }

  function filterTable(q) {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(q.toLowerCase()) ? '' : 'none';
    });
  }
</script>
</body>
</html>