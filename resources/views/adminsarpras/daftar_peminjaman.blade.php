<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Peminjaman - Admin Sarana Prasarana</title>
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

  /* Tabs */
  .top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
  .tabs { display: flex; gap: 4px; border-bottom: 2px solid var(--border); }
  .tab {
    padding: 10px 20px; font-size: 14px; font-weight: 500;
    color: var(--text-secondary); cursor: pointer; border-bottom: 2px solid transparent;
    margin-bottom: -2px; transition: all .2s;
  }
  .tab.active { color: var(--primary); border-bottom-color: var(--primary); font-weight: 600; }
  .tab:hover:not(.active) { color: var(--text-primary); }
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
    display: inline-flex; padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
  }
  .badge-approved { background: var(--success-light); color: var(--success); }
  .badge-pending { background: var(--warning-light); color: var(--warning); }
  .badge-rejected { background: var(--danger-light); color: var(--danger); }

  .peminjam-name { font-weight: 600; color: var(--primary); }

  .action-btns { display: flex; gap: 6px; align-items: center; }
  .act-btn {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; border: none; transition: all .2s;
  }
  .act-approve { background: var(--success-light); color: var(--success); }
  .act-approve:hover { background: var(--success); color: #fff; }
  .act-reject { background: var(--danger-light); color: var(--danger); }
  .act-reject:hover { background: var(--danger); color: #fff; }
  .act-dash { color: var(--text-secondary); font-size: 18px; line-height: 1; }

  /* Modal */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.4);
    display: none; align-items: center; justify-content: center; z-index: 200;
  }
  .modal-overlay.open { display: flex; }
  .modal {
    background: #fff; border-radius: 16px; padding: 28px;
    width: 520px; max-width: 90vw;
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
    <div class="top-bar">
      <div class="tabs">
        <div class="tab active" onclick="filterTab('semua', this)">Semua</div>
        <div class="tab" onclick="filterTab('disetujui', this)">Disetujui</div>
        <div class="tab" onclick="filterTab('menunggu', this)">Menunggu</div>
        <div class="tab" onclick="filterTab('ditolak', this)">Ditolak</div>
      </div>
      {{-- <button class="btn-primary" onclick="openModal()">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 5v14m-7-7h14"/></svg>
        Peminjaman Baru
      </button> --}}
    </div>

    <div class="table-card">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Gedung/Ruangan</th>
            <th>Tanggal</th>
            <th>Keperluan</th>
            <th>Status</th>
            <th>Tarif Pembayaran (mengikuti lama peminjam)</th>
            <th>Status Pembayaran (Lunas/belum lunas)</th>
            <th>Cara Pembayaran (lunas/e-billing)</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="pinjamTable">
          <tr data-status="disetujui">
            <td>1</td><td class="peminjam-name">Dr. Ahmad Fauzi</td><td>Aula Utama</td><td>Gedung A</td><td>15 Jun 2025</td><td>Seminar Nasional</td>
            <td><span class="status-badge badge-approved">Disetujui</span></td>
            <td><div class="act-dash">—</div></td>
          </tr>
          <tr data-status="disetujui">
            <td>2</td><td class="peminjam-name">Siti Nurhaliza</td><td>Lab Komputer 1</td><td>Gedung B</td><td>16 Jun 2025</td><td>Workshop Python</td>
            <td><span class="status-badge badge-approved">Disetujui</span></td>
            <td><div class="act-dash">—</div></td>
          </tr>
          <tr data-status="menunggu">
            <td>3</td><td class="peminjam-name">Budi Santoso</td><td>R. Rapat 201</td><td>Gedung C</td><td>17 Jun 2025</td><td>Rapat BEM</td>
            <td><span class="status-badge badge-pending">Menunggu</span></td>
            <td><div class="action-btns">
              <button class="act-btn act-approve" onclick="approveRow(this)" title="Setujui">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              </button>
              <button class="act-btn act-reject" onclick="rejectRow(this)" title="Tolak">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
              </button>
            </div></td>
          </tr>
          <tr data-status="disetujui">
            <td>4</td><td class="peminjam-name">Maya Putri</td><td>Auditorium</td><td>Gedung D</td><td>18 Jun 2025</td><td>Wisuda</td>
            <td><span class="status-badge badge-approved">Disetujui</span></td>
            <td><div class="act-dash">—</div></td>
          </tr>
          <tr data-status="ditolak">
            <td>5</td><td class="peminjam-name">Rizky Ramadhan</td><td>Lab Fisika</td><td>Gedung E</td><td>19 Jun 2025</td><td>Praktikum</td>
            <td><span class="status-badge badge-rejected">Ditolak</span></td>
            <td><div class="act-dash">—</div></td>
          </tr>
          <tr data-status="menunggu">
            <td>6</td><td class="peminjam-name">Dewi Lestari</td><td>Co-working Space</td><td>Gedung F</td><td>20 Jun 2025</td><td>Hackathon</td>
            <td><span class="status-badge badge-pending">Menunggu</span></td>
            <td><div class="action-btns">
              <button class="act-btn act-approve" onclick="approveRow(this)" title="Setujui">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
              </button>
              <button class="act-btn act-reject" onclick="rejectRow(this)" title="Tolak">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
              </button>
            </div></td>
          </tr>
          <tr data-status="disetujui">
            <td>7</td><td class="peminjam-name">Hendra Wijaya</td><td>R. Rapat 101</td><td>Gedung A</td><td>21 Jun 2025</td><td>Interview Kerja</td>
            <td><span class="status-badge badge-approved">Disetujui</span></td>
            <td><div class="act-dash">—</div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>

<!-- Modal -->
<div class="modal-overlay" id="modalOverlay" onclick="closeModalOutside(event)">
  <div class="modal">
    {{-- <div class="modal-title">Tambah Peminjaman Baru</div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nama Peminjam</label>
        <input class="form-input" type="text" placeholder="Nama lengkap" id="namaPeminjam">
      </div>
      <div class="form-group">
        <label class="form-label">Ruangan</label>
        <input class="form-input" type="text" placeholder="Nama ruangan" id="namaRuangan">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Gedung</label>
        <select class="form-input" id="gedung">
          <option>Gedung A</option>
          <option>Gedung B</option>
          <option>Gedung C</option>
          <option>Gedung D</option>
          <option>Gedung E</option>
          <option>Gedung F</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Tanggal</label>
        <input class="form-input" type="date" id="tanggal">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Keperluan</label>
      <input class="form-input" type="text" placeholder="Keterangan keperluan" id="keperluan">
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" onclick="closeModal()">Batal</button>
      <button class="btn-primary" onclick="addPeminjaman()">Simpan</button>
    </div>
  </div> 
</div>

<script>
  function openModal() { document.getElementById('modalOverlay').classList.add('open'); }
  function closeModal() { document.getElementById('modalOverlay').classList.remove('open'); }
  function closeModalOutside(e) { if (e.target === document.getElementById('modalOverlay')) closeModal(); }

  function approveRow(btn) {
    const tr = btn.closest('tr');
    tr.setAttribute('data-status', 'disetujui');
    tr.querySelector('.status-badge').className = 'status-badge badge-approved';
    tr.querySelector('.status-badge').textContent = 'Disetujui';
    tr.cells[7].innerHTML = '<div class="act-dash">—</div>';
  }

  function rejectRow(btn) {
    const tr = btn.closest('tr');
    tr.setAttribute('data-status', 'ditolak');
    tr.querySelector('.status-badge').className = 'status-badge badge-rejected';
    tr.querySelector('.status-badge').textContent = 'Ditolak';
    tr.cells[7].innerHTML = '<div class="act-dash">—</div>';
  }

  function filterTab(filter, el) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('#pinjamTable tr').forEach(tr => {
      const status = tr.getAttribute('data-status');
      tr.style.display = (filter === 'semua' || status === filter) ? '' : 'none';
    });
  }

  function formatDate(d) {
    if (!d) return '';
    const dt = new Date(d);
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    return `${dt.getDate()} ${months[dt.getMonth()]} ${dt.getFullYear()}`;
  }

  function addPeminjaman() {
    const nama = document.getElementById('namaPeminjam').value;
    const ruangan = document.getElementById('namaRuangan').value;
    const gedung = document.getElementById('gedung').value;
    const tanggal = document.getElementById('tanggal').value;
    const keperluan = document.getElementById('keperluan').value;
    if (!nama || !ruangan || !tanggal || !keperluan) { alert('Harap isi semua field!'); return; }
    const tbody = document.getElementById('pinjamTable');
    const rowCount = tbody.querySelectorAll('tr').length + 1;
    const tr = document.createElement('tr');
    tr.setAttribute('data-status', 'menunggu');
    tr.innerHTML = `
      <td>${rowCount}</td>
      <td class="peminjam-name">${nama}</td>
      <td>${ruangan}</td><td>${gedung}</td>
      <td>${formatDate(tanggal)}</td><td>${keperluan}</td>
      <td><span class="status-badge badge-pending">Menunggu</span></td>
      <td><div class="action-btns">
        <button class="act-btn act-approve" onclick="approveRow(this)">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
        </button>
        <button class="act-btn act-reject" onclick="rejectRow(this)">
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
      </div></td>
    `;
    tbody.appendChild(tr);
    closeModal();
    ['namaPeminjam','namaRuangan','tanggal','keperluan'].forEach(id => document.getElementById(id).value = '');
  }
</script>
</body>
</html>