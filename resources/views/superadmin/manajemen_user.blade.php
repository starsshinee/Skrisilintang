<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIBMN - Manajemen User</title>
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
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 100;
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 20px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .brand-icon {
      width: 40px; height: 40px;
      background: var(--primary);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      color: #fff;
      font-size: 18px;
    }

    .brand-text .name { color: #fff; font-weight: 700; font-size: 15px; }
    .brand-text .sub { color: rgba(255,255,255,0.5); font-size: 12px; }

    .sidebar-nav {
      padding: 16px 12px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .nav-item {
      display: flex; align-items: center; gap: 12px;
      padding: 10px 12px;
      border-radius: 8px;
      color: rgba(255,255,255,0.6);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
      text-decoration: none;
      transition: all .2s;
    }
    .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
    .nav-item.active { background: var(--primary); color: #fff; }
    .nav-item i { width: 18px; text-align: center; }

    .sidebar-footer {
      padding: 16px;
      border-top: 1px solid rgba(255,255,255,0.08);
    }

    .user-info {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 12px;
    }

    .avatar {
      width: 36px; height: 36px;
      background: var(--primary);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-weight: 700; font-size: 14px;
      flex-shrink: 0;
    }

    .user-name { color: #fff; font-size: 13px; font-weight: 600; }
    .user-role { color: rgba(255,255,255,0.4); font-size: 11px; }

    .logout-btn {
      display: flex; align-items: center; gap: 8px;
      color: rgba(255,255,255,0.5);
      font-size: 13px;
      cursor: pointer;
      transition: color .2s;
      background: none; border: none;
    }
    .logout-btn:hover { color: #ff6b6b; }

    /* MAIN */
    .main {
      margin-left: 260px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .topbar {
      background: #fff;
      padding: 16px 32px;
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 1px solid var(--border);
      position: sticky; top: 0; z-index: 50;
    }

    .page-title { font-size: 20px; font-weight: 700; }
    .page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }

    .topbar-right { display: flex; align-items: center; gap: 12px; }

    .notif-btn {
      width: 38px; height: 38px;
      border: 1px solid var(--border);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; position: relative;
      background: #fff; color: var(--muted);
    }
    .notif-dot {
      width: 8px; height: 8px;
      background: #f03e3e;
      border-radius: 50%;
      position: absolute; top: 6px; right: 6px;
      border: 2px solid #fff;
    }

    .avatar-top {
      width: 38px; height: 38px;
      background: var(--primary);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-weight: 700; font-size: 14px;
      cursor: pointer;
    }

    /* CONTENT */
    .content { padding: 28px 32px; flex: 1; }

    /* TABLE CARD */
    .table-card {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .table-header {
      display: flex; align-items: center; justify-content: space-between;
      padding: 20px 24px;
      border-bottom: 1px solid var(--border);
    }

    .user-count {
      font-size: 14px;
      color: var(--muted);
      font-weight: 500;
    }

    .btn-add {
      display: flex; align-items: center; gap: 8px;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 10px 18px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      font-family: inherit;
      transition: background .2s, transform .1s;
    }
    .btn-add:hover { background: #2f4ac7; transform: translateY(-1px); }
    .btn-add:active { transform: translateY(0); }

    /* TABLE */
    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead th {
      text-align: left;
      padding: 12px 24px;
      font-size: 11px;
      font-weight: 700;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 0.06em;
      background: #f9fafb;
      border-bottom: 1px solid var(--border);
    }

    tbody tr {
      transition: background .15s;
    }
    tbody tr:hover { background: #f9fafb; }

    tbody td {
      padding: 14px 24px;
      font-size: 14px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }
    tbody tr:last-child td { border-bottom: none; }

    .td-num { color: var(--muted); font-weight: 600; width: 50px; }
    .td-name { font-weight: 600; }
    .td-user { color: var(--muted); font-family: monospace; font-size: 13px; }

    /* ROLE BADGES */
    .role-badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .role-superadmin   { background: #eef2ff; color: #3b5bdb; }
    .role-kepalabpmp   { background: #ebfbee; color: #2f9e44; }
    .role-kasubagtu    { background: #fff3bf; color: #e67700; }
    .role-adminpersediaan  { background: #e3fafc; color: #0c8599; }
    .role-adminsarpras { background: #f3f0ff; color: #6741d9; }
    .role-adminaset    { background: #fff0f6; color: #c2255c; }
    .role-pegawai      { background: #f3f4f6; color: #495057; }
    .role-tamu         { background: #fff9db; color: #a06a00; }

    .btn-edit {
      background: none;
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 6px 14px;
      font-size: 13px;
      font-weight: 600;
      color: var(--primary);
      cursor: pointer;
      font-family: inherit;
      transition: all .2s;
    }
    .btn-edit:hover {
      background: var(--primary-light);
      border-color: var(--primary);
    }

    /* MODAL */
    .modal-overlay {
      display: none;
      position: fixed; inset: 0;
      background: rgba(0,0,0,0.35);
      z-index: 200;
      align-items: center;
      justify-content: center;
    }
    .modal-overlay.open { display: flex; }

    .modal {
      background: #fff;
      border-radius: 16px;
      padding: 32px;
      width: 460px;
      max-width: 95vw;
      box-shadow: 0 20px 60px rgba(0,0,0,0.15);
      animation: slideUp .25s ease;
    }

    @keyframes slideUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .modal-title {
      font-size: 18px; font-weight: 700;
      margin-bottom: 24px;
    }

    .form-group { margin-bottom: 16px; }
    .form-group label {
      display: block;
      font-size: 13px; font-weight: 600;
      margin-bottom: 6px;
      color: var(--text);
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-family: inherit;
      font-size: 14px;
      color: var(--text);
      outline: none;
      transition: border-color .2s;
    }
    .form-group input:focus,
    .form-group select:focus { border-color: var(--primary); }

    .modal-actions {
      display: flex; gap: 10px;
      margin-top: 24px;
      justify-content: flex-end;
    }

    .btn-cancel {
      padding: 10px 20px;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: #fff;
      font-family: inherit;
      font-size: 14px;
      font-weight: 600;
      color: var(--muted);
      cursor: pointer;
    }
    .btn-cancel:hover { background: #f3f4f6; }

    .btn-save {
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      background: var(--primary);
      color: #fff;
      font-family: inherit;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: background .2s;
    }
    .btn-save:hover { background: #2f4ac7; }
  </style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div>
      <div class="page-title">Manajemen User</div>
      <div class="page-sub">Super Admin — BPMP Gorontalo</div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn">
        <i class="fas fa-bell"></i>
        <span class="notif-dot"></span>
      </div>
      <div class="avatar-top">DA</div>
    </div>
  </div>

  <div class="content">
    <div class="table-card">
      <div class="table-header">
        <span class="user-count">8 pengguna terdaftar</span>
        <button class="btn-add" onclick="openModal()">
          <i class="fas fa-plus"></i> Tambah User
        </button>
      </div>

      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Role</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="td-num">1</td>
            <td class="td-name">Dr. Ahmad Ridwan, M.Pd</td>
            <td class="td-user">superadmin</td>
            <td><span class="role-badge role-superadmin">Super Admin</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Dr. Ahmad Ridwan, M.Pd', 'superadmin', 'Super Admin')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">2</td>
            <td class="td-name">Prof. Haryanto, M.Si</td>
            <td class="td-user">kepalabpmp</td>
            <td><span class="role-badge role-kepalabpmp">Kepala BPMP</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Prof. Haryanto, M.Si', 'kepalabpmp', 'Kepala BPMP')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">3</td>
            <td class="td-name">Dra. Siti Rahayu, MM</td>
            <td class="td-user">kasubag</td>
            <td><span class="role-badge role-kasubagtu">Kasubag TU</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Dra. Siti Rahayu, MM', 'kasubag', 'Kasubag TU')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">4</td>
            <td class="td-name">Moh. Fadil, SE</td>
            <td class="td-user">adminpersediaan</td>
            <td><span class="role-badge role-adminpersediaan">Admin Persediaan</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Moh. Fadil, SE', 'adminpersediaan', 'Admin Persediaan')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">5</td>
            <td class="td-name">Nurul Hidayah, ST</td>
            <td class="td-user">adminsarpras</td>
            <td><span class="role-badge role-adminsarpras">Admin Sarana Prasarana</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Nurul Hidayah, ST', 'adminsarpras', 'Admin Sarana Prasarana')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">6</td>
            <td class="td-name">Irfan Gorontalo, S.Ak</td>
            <td class="td-user">adminaset</td>
            <td><span class="role-badge role-adminaset">Admin Aset Tetap</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Irfan Gorontalo, S.Ak', 'adminaset', 'Admin Aset Tetap')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">7</td>
            <td class="td-name">Fitri Mohamad, S.Pd</td>
            <td class="td-user">pegawai</td>
            <td><span class="role-badge role-pegawai">Pegawai</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Fitri Mohamad, S.Pd', 'pegawai', 'Pegawai')">Edit</button></td>
          </tr>
          <tr>
            <td class="td-num">8</td>
            <td class="td-name">Pengunjung Umum</td>
            <td class="td-user">tamu</td>
            <td><span class="role-badge role-tamu">Tamu</span></td>
            <td><button class="btn-edit" onclick="openEditModal('Pengunjung Umum', 'tamu', 'Tamu')">Edit</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH / EDIT USER -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal">
    <div class="modal-title" id="modalTitle">Tambah User</div>
    <div class="form-group">
      <label>Nama Lengkap</label>
      <input type="text" id="fieldNama" placeholder="Masukkan nama lengkap" />
    </div>
    <div class="form-group">
      <label>Username</label>
      <input type="text" id="fieldUsername" placeholder="Masukkan username" />
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" id="fieldPassword" placeholder="Masukkan password" />
    </div>
    <div class="form-group">
      <label>Role</label>
      <select id="fieldRole">
        <option value="">Pilih role</option>
        <option>Super Admin</option>
        <option>Kepala BPMP</option>
        <option>Kasubag TU</option>
        <option>Admin Persediaan</option>
        <option>Admin Sarana Prasarana</option>
        <option>Admin Aset Tetap</option>
        <option>Pegawai</option>
        <option>Tamu</option>
      </select>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" onclick="closeModal()">Batal</button>
      <button class="btn-save">Simpan</button>
    </div>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('modalTitle').textContent = 'Tambah User';
    document.getElementById('fieldNama').value = '';
    document.getElementById('fieldUsername').value = '';
    document.getElementById('fieldPassword').value = '';
    document.getElementById('fieldRole').value = '';
    document.getElementById('modalOverlay').classList.add('open');
  }

  function openEditModal(nama, username, role) {
    document.getElementById('modalTitle').textContent = 'Edit User';
    document.getElementById('fieldNama').value = nama;
    document.getElementById('fieldUsername').value = username;
    document.getElementById('fieldPassword').value = '';
    document.getElementById('fieldRole').value = role;
    document.getElementById('modalOverlay').classList.add('open');
  }

  function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
  }

  document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });
</script>

</body>
</html>