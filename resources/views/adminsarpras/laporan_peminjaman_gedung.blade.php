<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan - Admin Sarana Prasarana</title>
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

  /* Report Type Cards */
  .report-types { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
  .report-type-card {
    background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border);
    padding: 24px; cursor: pointer; transition: all .25s;
  }
  .report-type-card:hover, .report-type-card.active {
    border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light);
  }
  .report-type-card.active { background: var(--primary-light); }
  .rt-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center; margin-bottom: 14px;
  }
  .rt-icon.blue { background: var(--primary-light); }
  .rt-icon.orange { background: var(--warning-light); }
  .rt-icon.green { background: var(--success-light); }
  .report-type-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
  .report-type-card p { font-size: 13px; color: var(--text-secondary); }

  /* Main Report Card */
  .card {
    background: var(--card-bg); border-radius: 16px;
    border: 1px solid var(--border); padding: 24px;
  }
  .card-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px;
  }
  .card-title { font-size: 16px; font-weight: 700; }
  .header-right { display: flex; align-items: center; gap: 12px; }
  .month-select {
    padding: 8px 14px; border: 1px solid var(--border); border-radius: 10px;
    font-family: inherit; font-size: 13px; outline: none; cursor: pointer;
    background: #fff;
  }
  .btn-export {
    display: flex; align-items: center; gap: 8px;
    padding: 9px 18px; background: var(--text-primary); color: #fff;
    border: none; border-radius: 10px; font-family: inherit;
    font-size: 14px; font-weight: 600; cursor: pointer;
  }
  .btn-export:hover { background: #2c3247; }

  /* Summary Stats */
  .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
  .summary-card { padding: 16px 20px; border-radius: 12px; }
  .summary-card.total { background: #f0f4ff; }
  .summary-card.approved { background: var(--success-light); }
  .summary-card.pending { background: var(--warning-light); }
  .summary-card.rejected { background: var(--danger-light); }
  .summary-label { font-size: 12px; font-weight: 600; margin-bottom: 6px; text-transform: uppercase; letter-spacing: .05em; }
  .summary-label.total { color: var(--primary); }
  .summary-label.approved { color: var(--success); }
  .summary-label.pending { color: var(--warning); }
  .summary-label.rejected { color: var(--danger); }
  .summary-value { font-size: 32px; font-weight: 800; }
  .summary-value.total { color: var(--primary); }
  .summary-value.approved { color: var(--success); }
  .summary-value.pending { color: var(--warning); }
  .summary-value.rejected { color: var(--danger); }

  /* Table */
  table { width: 100%; border-collapse: collapse; }
  thead th {
    font-size: 12px; font-weight: 600; color: var(--text-secondary);
    padding: 10px 16px; text-align: left; border-bottom: 1px solid var(--border);
    text-transform: uppercase; letter-spacing: .05em;
  }
  tbody td { padding: 14px 16px; font-size: 13px; border-bottom: 1px solid var(--border); }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: #fafbff; }

  /* Progress Bar */
  .progress-wrap { display: flex; align-items: center; gap: 10px; }
  .progress-bar {
    flex: 1; height: 8px; border-radius: 10px; background: #e5e7eb; overflow: hidden;
  }
  .progress-fill { height: 100%; border-radius: 10px; transition: width .6s; }
  .fill-blue { background: var(--primary); }
  .fill-orange { background: var(--warning); }
  .fill-gray { background: #9ca3af; }
  .progress-pct { font-size: 13px; font-weight: 700; color: var(--text-primary); min-width: 36px; text-align: right; }
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
    <!-- Report Type Selector -->
    <div class="report-types">
      <div class="report-type-card active" onclick="selectReport(this, 'peminjaman')">
        <div class="rt-icon blue">
          <svg width="26" height="26" fill="none" stroke="#4361ee" viewBox="0 0 24 24" stroke-width="1.8"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
        </div>
        <h3>Laporan Peminjaman</h3>
        <p>Rekap semua peminjaman ruangan</p>
      </div>
      <div class="report-type-card" onclick="selectReport(this, 'kondisi')">
        <div class="rt-icon orange">
          <svg width="26" height="26" fill="none" stroke="#f4a261" viewBox="0 0 24 24" stroke-width="1.8"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
        </div>
        <h3>Laporan Kondisi</h3>
        <p>Status kondisi gedung & ruangan</p>
      </div>
      <div class="report-type-card" onclick="selectReport(this, 'inventaris')">
        <div class="rt-icon green">
          <svg width="26" height="26" fill="none" stroke="#2ec4b6" viewBox="0 0 24 24" stroke-width="1.8"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <h3>Laporan Inventaris</h3>
        <p>Daftar aset dan inventaris</p>
      </div>
    </div>

    <!-- Report Content -->
    <div class="card" id="reportContent">
      <div class="card-header">
        <span class="card-title" id="reportTitle">Laporan Peminjaman</span>
        <div class="header-right">
          <select class="month-select" onchange="updateStats(this.value)">
            <option>Juni 2025</option>
            <option>Mei 2025</option>
            <option>April 2025</option>
            <option>Maret 2025</option>
          </select>
          <button class="btn-export" onclick="exportReport()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Export
          </button>
        </div>
      </div>

      <!-- Summary -->
      <div class="summary-grid" id="summaryGrid">
        <div class="summary-card total">
          <div class="summary-label total">Total Peminjaman</div>
          <div class="summary-value total">67</div>
        </div>
        <div class="summary-card approved">
          <div class="summary-label approved">Disetujui</div>
          <div class="summary-value approved">52</div>
        </div>
        <div class="summary-card pending">
          <div class="summary-label pending">Menunggu</div>
          <div class="summary-value pending">8</div>
        </div>
        <div class="summary-card rejected">
          <div class="summary-label rejected">Ditolak</div>
          <div class="summary-value rejected">7</div>
        </div>
      </div>

      <!-- Detail Table -->
      <div id="peminjaman-table">
        <table>
          <thead>
            <tr>
              <th>No</th>
              <th>Gedung</th>
              <th>Ruangan</th>
              <th>Jumlah Peminjaman</th>
              <th>Tingkat Penggunaan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td><td>Gedung A</td><td>Aula Utama</td><td>18 kali</td>
              <td><div class="progress-wrap"><div class="progress-bar"><div class="progress-fill fill-blue" style="width:85%"></div></div><span class="progress-pct">85%</span></div></td>
            </tr>
            <tr>
              <td>2</td><td>Gedung B</td><td>Lab Komputer 1</td><td>14 kali</td>
              <td><div class="progress-wrap"><div class="progress-bar"><div class="progress-fill fill-orange" style="width:72%"></div></div><span class="progress-pct">72%</span></div></td>
            </tr>
            <tr>
              <td>3</td><td>Gedung D</td><td>Auditorium</td><td>12 kali</td>
              <td><div class="progress-wrap"><div class="progress-bar"><div class="progress-fill fill-blue" style="width:90%"></div></div><span class="progress-pct">90%</span></div></td>
            </tr>
            <tr>
              <td>4</td><td>Gedung F</td><td>Co-working Space</td><td>10 kali</td>
              <td><div class="progress-wrap"><div class="progress-bar"><div class="progress-fill fill-orange" style="width:65%"></div></div><span class="progress-pct">65%</span></div></td>
            </tr>
            <tr>
              <td>5</td><td>Gedung C</td><td>R. Baca Utama</td><td>8 kali</td>
              <td><div class="progress-wrap"><div class="progress-bar"><div class="progress-fill fill-orange" style="width:55%"></div></div><span class="progress-pct">55%</span></div></td>
            </tr>
            <tr>
              <td>6</td><td>Gedung E</td><td>Lab Kimia</td><td>5 kali</td>
              <td><div class="progress-wrap"><div class="progress-bar"><div class="progress-fill fill-gray" style="width:40%"></div></div><span class="progress-pct">40%</span></div></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Kondisi Table (hidden) -->
      <div id="kondisi-table" style="display:none">
        <table>
          <thead>
            <tr><th>No</th><th>Gedung</th><th>Kondisi</th><th>Terakhir Diperiksa</th><th>Keterangan</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>Gedung A - Rektorat</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>10 Jun 2025</td><td>Tidak ada kerusakan</td></tr>
            <tr><td>2</td><td>Gedung B - Fak. Teknik</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>12 Jun 2025</td><td>Pemeliharaan rutin selesai</td></tr>
            <tr><td>3</td><td>Gedung C - Perpustakaan</td><td><span style="color:#f4a261;font-weight:600">Renovasi</span></td><td>5 Jun 2025</td><td>Pengecatan ulang dinding</td></tr>
            <tr><td>4</td><td>Gedung D - Auditorium</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>14 Jun 2025</td><td>AC baru dipasang</td></tr>
            <tr><td>5</td><td>Gedung E - Laboratorium</td><td><span style="color:#e63946;font-weight:600">Perlu Perbaikan</span></td><td>3 Jun 2025</td><td>Atap bocor di lab kimia</td></tr>
            <tr><td>6</td><td>Gedung F - Pusat Kegiatan</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>11 Jun 2025</td><td>Dalam kondisi baik</td></tr>
          </tbody>
        </table>
      </div>

      <!-- Inventaris Table (hidden) -->
      <div id="inventaris-table" style="display:none">
        <table>
          <thead>
            <tr><th>No</th><th>Nama Aset</th><th>Gedung</th><th>Jumlah</th><th>Kondisi</th><th>Tahun Pengadaan</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>Proyektor Epson</td><td>Gedung A</td><td>8 unit</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>2022</td></tr>
            <tr><td>2</td><td>Komputer Desktop</td><td>Gedung B</td><td>40 unit</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>2021</td></tr>
            <tr><td>3</td><td>AC Split</td><td>Gedung C</td><td>15 unit</td><td><span style="color:#f4a261;font-weight:600">Perlu Servis</span></td><td>2019</td></tr>
            <tr><td>4</td><td>Kursi Lipat</td><td>Gedung D</td><td>200 unit</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>2020</td></tr>
            <tr><td>5</td><td>Meja Lab</td><td>Gedung E</td><td>30 unit</td><td><span style="color:#e63946;font-weight:600">Rusak</span></td><td>2015</td></tr>
            <tr><td>6</td><td>Sound System</td><td>Gedung F</td><td>4 set</td><td><span style="color:#2ec4b6;font-weight:600">Baik</span></td><td>2023</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<script>
  const reportTitles = {
    peminjaman: 'Laporan Peminjaman',
    kondisi: 'Laporan Kondisi Gedung & Ruangan',
    inventaris: 'Laporan Inventaris Aset'
  };

  function selectReport(el, type) {
    document.querySelectorAll('.report-type-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('reportTitle').textContent = reportTitles[type];

    // Show/hide summary
    const summary = document.getElementById('summaryGrid');
    summary.style.display = type === 'peminjaman' ? 'grid' : 'none';

    // Show correct table
    ['peminjaman','kondisi','inventaris'].forEach(t => {
      document.getElementById(`${t}-table`).style.display = t === type ? 'block' : 'none';
    });
  }

  function exportReport() {
    alert('Export laporan berhasil! File akan diunduh dalam format Excel.');
  }

  function updateStats(month) {
    // Simulate different stats per month
    const stats = {
      'Juni 2025': [67, 52, 8, 7],
      'Mei 2025': [58, 44, 9, 5],
      'April 2025': [50, 38, 7, 5],
      'Maret 2025': [45, 35, 6, 4],
    };
    const data = stats[month] || [67, 52, 8, 7];
    const values = document.querySelectorAll('.summary-value');
    values.forEach((v, i) => { v.textContent = data[i]; });
  }
</script>
</body>
</html>