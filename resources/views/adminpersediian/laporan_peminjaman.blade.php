<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIMASET - Laporan Peminjaman & Pengembalian</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --blue: #3B82F6;
    --green: #10B981;
    --red: #EF4444;
    --purple: #8B5CF6;
    --amber: #F59E0B;
    --radius: 14px;
    --bg: #F8F9FB;
    --surface: #FFFFFF;
    --text: #1E293B;
    --muted: #94A3B8;
    --border: #E8EDF5;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

  .topbar {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 0 20px;
    height: 52px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
  }
  .topbar-left { display: flex; align-items: center; gap: 12px; }
  .menu-btn {
    width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
    border-radius: 8px; border: none; background: none; cursor: pointer; color: var(--muted);
  }
  .topbar-title { font-size: 15px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 34px; height: 34px; border-radius: 50%; border: 1px solid var(--border);
    background: var(--surface); display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative;
  }
  .notif-dot { width: 8px; height: 8px; background: #EF4444; border-radius: 50%; position: absolute; top: 5px; right: 5px; border: 2px solid white; }
  .date-text { font-size: 13px; color: #64748B; font-weight: 500; }

  .content { padding: 20px; max-width: 900px; margin: 0 auto; }

  /* PAGE HEADER */
  .page-top {
    display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 20px;
  }
  .page-top h1 { font-size: 20px; font-weight: 800; color: var(--blue); margin-bottom: 4px; }
  .page-top p { font-size: 13px; color: var(--muted); }
  .btn-unduh {
    display: flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 10px;
    background: var(--blue);
    color: white; font-size: 13px; font-weight: 700;
    font-family: inherit; border: none; cursor: pointer;
    box-shadow: 0 4px 12px rgba(59,130,246,.3);
    transition: all .2s;
  }
  .btn-unduh:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(59,130,246,.4); }

  /* STAT CARDS */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 20px;
  }
  .stat-card {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 18px;
    border: 1px solid var(--border);
    transition: transform .2s, box-shadow .2s;
  }
  .stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,.06); }
  .stat-header { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
  .stat-icon {
    width: 28px; height: 28px; border-radius: 7px;
    display: flex; align-items: center; justify-content: center;
  }
  .stat-label-sm { font-size: 12px; font-weight: 600; color: #64748B; line-height: 1.3; }
  .stat-value { font-size: 28px; font-weight: 800; margin-bottom: 2px; }
  .stat-sub { font-size: 12px; color: var(--muted); }

  .ic-blue { background: #EFF6FF; }
  .ic-blue svg { fill: var(--blue); }
  .ic-green { background: #ECFDF5; }
  .ic-green svg { fill: var(--green); }
  .ic-red { background: #FEF2F2; }
  .ic-red svg { fill: var(--red); }
  .ic-purple { background: #F5F3FF; }
  .ic-purple svg { fill: var(--purple); }

  /* TABS */
  .tab-card {
    background: var(--surface);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    overflow: hidden;
  }
  .tab-bar {
    display: flex;
    border-bottom: 1px solid var(--border);
    padding: 0 20px;
    gap: 4px;
  }
  .tab-btn {
    padding: 14px 4px;
    font-size: 14px; font-weight: 600;
    color: var(--muted);
    border: none; background: none; cursor: pointer;
    font-family: inherit;
    border-bottom: 2.5px solid transparent;
    margin-right: 20px;
    transition: all .15s;
  }
  .tab-btn.active { color: var(--blue); border-bottom-color: var(--blue); }
  .tab-btn:hover:not(.active) { color: var(--text); }

  /* TABLE */
  table { width: 100%; border-collapse: collapse; }
  th {
    padding: 12px 20px;
    text-align: left;
    font-size: 11px; font-weight: 700;
    color: var(--blue); letter-spacing: .8px; text-transform: uppercase;
    background: #F8FAFF;
    border-bottom: 1px solid var(--border);
  }
  td {
    padding: 14px 20px;
    font-size: 13px; color: var(--text);
    border-bottom: 1px solid var(--border);
    vertical-align: top;
  }
  tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #F8FAFF; }

  .id-cell { font-weight: 700; color: #475569; font-size: 12px; }

  .priority-badge {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 700;
  }
  .prio-tinggi { background: #FEE2E2; color: #DC2626; }
  .prio-normal { background: #DBEAFE; color: #2563EB; }
  .prio-rendah { background: #F1F5F9; color: #64748B; }

  .status-badge {
    display: inline-block; padding: 3px 10px; border-radius: 20px;
    font-size: 11px; font-weight: 700;
  }
  .status-pending { background: #FEF3C7; color: #B45309; }
  .status-disetujui { background: #DCFCE7; color: #15803D; }
  .status-ditolak { background: #FEE2E2; color: #DC2626; }

  .item-list { font-size: 12.5px; line-height: 1.6; }
</style>
</head>
<body>

<div class="topbar">
  <div class="topbar-left">
    <button class="menu-btn">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
    </button>
    <span class="topbar-title">Laporan Peminjaman & Pengembalian</span>
  </div>
  <div class="topbar-right">
    <div class="notif-btn">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="#64748B"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
      <span class="notif-dot"></span>
    </div>
    <span class="date-text">Jumat, 17 April 2026</span>
  </div>
</div>

<div class="content">
  <div class="page-top">
    <div>
      <h1>Laporan Peminjaman & Pengembalian</h1>
      <p>Analisis lengkap peminjaman dan pengembalian persediaan</p>
    </div>
    <button class="btn-unduh">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="white"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
      Unduh Laporan
    </button>
  </div>

  <!-- Stats -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon ic-blue">
          <svg width="14" height="14" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
        </div>
        <span class="stat-label-sm">Total Peminjaman</span>
      </div>
      <div class="stat-value">3</div>
      <div class="stat-sub">Keseluruhan</div>
    </div>
    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon ic-green">
          <svg width="14" height="14" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
        </div>
        <span class="stat-label-sm">Sedang Dipinjam</span>
      </div>
      <div class="stat-value" style="color:#10B981">0</div>
      <div class="stat-sub">0%</div>
    </div>
    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon ic-red">
          <svg width="14" height="14" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        </div>
        <span class="stat-label-sm">Terlambat</span>
      </div>
      <div class="stat-value" style="color:#EF4444">0</div>
      <div class="stat-sub">Perlu tindakan</div>
    </div>
    <div class="stat-card">
      <div class="stat-header">
        <div class="stat-icon ic-purple">
          <svg width="14" height="14" viewBox="0 0 24 24"><path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6a5.87 5.87 0 01-2.8-.7l-1.46 1.46A7.93 7.93 0 0012 20c4.42 0 8-3.58 8-8h3l-4-4z"/></svg>
        </div>
        <span class="stat-label-sm">Total Pengembalian</span>
      </div>
      <div class="stat-value" style="color:#8B5CF6">0</div>
      <div class="stat-sub">Sudah dikembalikan</div>
    </div>
  </div>

  <!-- Tab + Table -->
  <div class="tab-card">
    <div class="tab-bar">
      <button class="tab-btn active">Laporan Peminjaman</button>
      <button class="tab-btn">Laporan Pengembalian</button>
      <button class="tab-btn">Ringkasan Gabungan</button>
    </div>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Pemohon</th>
          <th>Item Diminta</th>
          <th>Tanggal</th>
          <th>Prioritas</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="id-cell">PP-001</td>
          <td><strong>Dept. Keuangan</strong></td>
          <td class="item-list">Kertas HVS (50), Tinta (5)</td>
          <td>2025-01-15</td>
          <td><span class="priority-badge prio-tinggi">Tinggi</span></td>
          <td><span class="status-badge status-pending">Pending</span></td>
        </tr>
        <tr>
          <td class="id-cell">PP-002</td>
          <td><strong>Dept. IT</strong></td>
          <td class="item-list">Kabel LAN (20), Mouse (10)</td>
          <td>2025-01-14</td>
          <td><span class="priority-badge prio-normal">Normal</span></td>
          <td><span class="status-badge status-disetujui">Disetujui</span></td>
        </tr>
        <tr>
          <td class="id-cell">PP-003</td>
          <td><strong>Dept. HR</strong></td>
          <td class="item-list">Map Folder (100), Stapler (5)</td>
          <td>2025-01-13</td>
          <td><span class="priority-badge prio-rendah">Rendah</span></td>
          <td><span class="status-badge status-pending">Pending</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
  // Tab switching
  document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

</body>
</html>