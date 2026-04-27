<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Peminjaman Barang</title>
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
    overflow-x: hidden;
  }

  /* SIDEBAR */
  .sidebar {
    width: 260px;
    background: var(--sidebar-bg);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    padding: 24px 16px;
    overflow-y: auto;
    z-index: 1000;
  }

  .sidebar-logo {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .sidebar-menu {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .sidebar-item {
    padding: 12px 14px;
    border-radius: 10px;
    color: var(--sidebar-text);
    cursor: pointer;
    font-size: 13px;
    font-weight: 600;
    transition: all .2s;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .sidebar-item:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
  }

  .sidebar-item.active {
    background: var(--primary);
    color: #fff;
  }

  /* MOBILE SIDEBAR TOGGLE */
  .sidebar-toggle {
    display: none;
    position: fixed;
    top: 20px;
    left: 20px;
    width: 40px;
    height: 40px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: 10px;
    cursor: pointer;
    z-index: 1100;
    align-items: center;
    justify-content: center;
  }

  /* MAIN */
  .main { 
    margin-left: 260px; 
    flex: 1; 
    padding: 0 32px 40px;
    width: calc(100% - 260px);
  }

  .topbar {
    display: flex; 
    align-items: center; 
    justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; 
    top: 0; 
    z-index: 50;
    background: var(--bg);
    border-bottom: 1px solid transparent;
    flex-wrap: wrap;
    gap: 16px;
  }

  .topbar-left { 
    display: flex; 
    align-items: center; 
    gap: 14px;
    flex: 1;
    min-width: 0;
  }

  .breadcrumb { 
    font-size: 13px; 
    color: var(--text-secondary); 
    display: flex; 
    align-items: center; 
    gap: 6px;
    flex-wrap: wrap;
  }

  .breadcrumb span { 
    color: var(--primary); 
    font-weight: 600; 
  }

  .topbar-title { 
    font-family: 'Space Grotesk', sans-serif; 
    font-size: 22px; 
    font-weight: 700;
    white-space: nowrap;
  }

  .topbar-right { 
    display: flex; 
    align-items: center; 
    gap: 12px;
  }

  .notif-btn {
    width: 40px; 
    height: 40px;
    background: var(--card-bg); 
    border: 1px solid var(--border);
    border-radius: 10px; 
    display: grid; 
    place-items: center;
    cursor: pointer; 
    position: relative; 
    color: var(--text-secondary); 
    transition: all .2s;
  }

  .notif-btn:hover { 
    border-color: var(--primary); 
    color: var(--primary); 
  }

  .notif-dot { 
    position: absolute; 
    top: 8px; 
    right: 8px; 
    width: 7px; 
    height: 7px; 
    background: var(--danger); 
    border-radius: 50%; 
    border: 1.5px solid var(--card-bg);
  }

  /* CONTENT LAYOUT */
  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 28px;
  }

  /* FORM CARD */
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
    position: relative; 
    overflow: hidden;
  }

  .form-header::before {
    content: '';
    position: absolute; 
    right: -30px; 
    top: -30px;
    width: 120px; 
    height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }

  .form-header-icon {
    position: relative;
    z-index: 1;
    width: 46px; 
    height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 13px;
    display: grid; 
    place-items: center;
    font-size: 20px; 
    color: #fff;
    margin-bottom: 12px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }

  .form-header-title { 
    font-family: 'Space Grotesk', sans-serif; 
    font-size: 18px; 
    font-weight: 700; 
    color: #fff;
  }

  .form-header-sub { 
    font-size: 12px; 
    color: rgba(255,255,255,0.75); 
    margin-top: 4px;
  }

  .form-body { 
    padding: 24px 28px;
  }

  .form-group { 
    margin-bottom: 18px;
  }

  .form-label {
    display: flex; 
    align-items: center; 
    gap: 6px;
    font-size: 12px; 
    font-weight: 700; 
    color: var(--text-secondary);
    text-transform: uppercase; 
    letter-spacing: .6px;
    margin-bottom: 8px;
  }

  .form-label i { 
    color: var(--primary); 
    font-size: 11px;
  }

  .form-label .req { 
    color: var(--danger);
  }

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

  .form-input::placeholder, .form-textarea::placeholder { 
    color: #b0bcd4;
  }

  .form-select { 
    appearance: none; 
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); 
    background-repeat: no-repeat; 
    background-position: right 14px center; 
    padding-right: 36px; 
    cursor: pointer;
  }

  .form-textarea { 
    resize: vertical; 
    min-height: 90px;
  }

  .input-row { 
    display: grid; 
    grid-template-columns: 1fr 1fr; 
    gap: 14px;
  }

  /* Facility Preview */
  .facility-preview {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    border-radius: 10px;
    background: linear-gradient(135deg, #eff4ff, #f0fdff);
    border: 1px solid #c7d7ff;
  }

  .facility-preview.show { 
    display: flex; 
    align-items: center; 
    gap: 12px;
  }

  .fp-icon { 
    width: 36px; 
    height: 36px; 
    border-radius: 9px; 
    background: var(--primary); 
    display: grid; 
    place-items: center; 
    color: #fff; 
    font-size: 15px; 
    flex-shrink: 0;
  }

  .fp-name { 
    font-size: 13px; 
    font-weight: 700; 
    color: var(--text-primary);
  }

  .fp-details { 
    display: flex; 
    gap: 10px; 
    margin-top: 3px;
  }

  .fp-tag { 
    font-size: 10px; 
    background: rgba(37,99,235,0.1); 
    color: var(--primary); 
    padding: 2px 8px; 
    border-radius: 5px; 
    font-weight: 600;
  }

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
    display: flex; 
    align-items: center; 
    justify-content: center; 
    gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    margin-top: 8px;
  }

  .submit-btn:hover { 
    transform: translateY(-2px); 
    box-shadow: 0 6px 20px rgba(37,99,235,0.4);
  }

  .submit-btn:active { 
    transform: translateY(0);
  }

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
    display: flex; 
    align-items: center; 
    justify-content: space-between;
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap;
    gap: 16px;
  }

  .history-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 17px; 
    font-weight: 700; 
    color: var(--text-primary);
    display: flex; 
    align-items: center; 
    gap: 8px;
  }

  .history-title i { 
    color: var(--primary);
  }

  .filter-tabs { 
    display: flex; 
    gap: 6px;
    flex-wrap: wrap;
  }

  .filter-tab {
    font-size: 11px; 
    font-weight: 600; 
    padding: 5px 12px;
    border-radius: 7px; 
    cursor: pointer; 
    border: 1.5px solid var(--border);
    background: transparent; 
    color: var(--text-secondary);
    transition: all .2s; 
    font-family: 'Plus Jakarta Sans', sans-serif;
    white-space: nowrap;
  }

  .filter-tab.active { 
    background: var(--primary); 
    color: #fff; 
    border-color: var(--primary);
  }

  .filter-tab:hover:not(.active) { 
    border-color: var(--primary); 
    color: var(--primary);
  }

  .req-list { 
    padding: 20px 28px; 
    display: flex; 
    flex-direction: column; 
    gap: 16px;
  }

  .req-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all .2s;
  }

  .req-card:hover { 
    box-shadow: var(--shadow); 
    transform: translateY(-1px);
  }

  .req-card-top {
    padding: 16px 18px;
    display: flex; 
    align-items: flex-start; 
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
  }

  .req-card-icon {
    width: 42px; 
    height: 42px; 
    border-radius: 11px;
    display: grid; 
    place-items: center;
    font-size: 17px; 
    flex-shrink: 0;
  }

  .req-card-name { 
    font-size: 14px; 
    font-weight: 700; 
    color: var(--text-primary);
  }

  .req-card-code { 
    font-size: 11px; 
    color: var(--text-secondary); 
    margin-top: 2px;
  }

  .status-badge {
    font-size: 11px; 
    font-weight: 700; 
    padding: 4px 11px; 
    border-radius: 7px;
    letter-spacing: .3px; 
    display: flex; 
    align-items: center; 
    gap: 5px;
    white-space: nowrap;
  }

  .status-badge.approved { 
    background: rgba(16,185,129,0.1); 
    color: var(--success); 
    border: 1px solid rgba(16,185,129,0.2);
  }

  .status-badge.pending { 
    background: rgba(245,158,11,0.1); 
    color: var(--warning); 
    border: 1px solid rgba(245,158,11,0.2);
  }

  .status-badge.rejected { 
    background: rgba(239,68,68,0.1); 
    color: var(--danger); 
    border: 1px solid rgba(239,68,68,0.2);
  }

  .status-badge i { 
    font-size: 9px;
  }

  .req-card-meta {
    padding: 12px 18px;
    background: #f8faff;
    display: grid; 
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #eef1ff;
  }

  .meta-item {}

  .meta-label { 
    font-size: 10px; 
    text-transform: uppercase; 
    letter-spacing: .6px; 
    color: #94a3b8; 
    font-weight: 700; 
    margin-bottom: 3px;
  }

  .meta-value { 
    font-size: 12px; 
    font-weight: 600; 
    color: var(--text-primary);
  }

  .req-card-footer {
    padding: 12px 18px;
    display: flex; 
    gap: 8px;
    border-top: 1px solid #eef1ff;
  }

  .card-btn {
    flex: 1; 
    padding: 9px;
    border-radius: 8px;
    font-size: 12px; 
    font-weight: 600;
    cursor: pointer; 
    border: none;
    display: flex; 
    align-items: center; 
    justify-content: center; 
    gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s;
    white-space: nowrap;
  }

  .card-btn.detail { 
    background: rgba(37,99,235,0.08); 
    color: var(--primary);
  }

  .card-btn.detail:hover { 
    background: rgba(37,99,235,0.15);
  }

  .card-btn.cancel { 
    background: rgba(239,68,68,0.08); 
    color: var(--danger);
  }

  .card-btn.cancel:hover { 
    background: rgba(239,68,68,0.15);
  }

  .empty-state {
    text-align: center; 
    padding: 60px 20px;
  }

  .empty-icon { 
    font-size: 56px; 
    color: #dde5f9; 
    margin-bottom: 14px;
  }

  .empty-text { 
    font-size: 15px; 
    font-weight: 600; 
    color: var(--text-primary); 
    margin-bottom: 6px;
  }

  .empty-sub { 
    font-size: 13px; 
    color: var(--text-secondary);
  }

  /* FACILITY GRID PAGE */
  .fac-section {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    margin-bottom: 28px;
    overflow: hidden;
  }

  .fac-section-header {
    padding: 22px 28px 18px;
    border-bottom: 1px solid var(--border);
    display: flex; 
    align-items: center; 
    justify-content: space-between;
  }

  .fac-section-title { 
    font-family: 'Space Grotesk', sans-serif; 
    font-size: 17px; 
    font-weight: 700; 
    display: flex; 
    align-items: center; 
    gap: 8px;
  }

  .fac-section-title i { 
    color: var(--primary);
  }

  .fac-grid { 
    display: grid; 
    grid-template-columns: repeat(3, 1fr); 
    gap: 14px; 
    padding: 20px 28px;
  }

  .fac-card {
    border-radius: 13px;
    overflow: hidden;
    border: 1.5px solid var(--border);
    transition: all .2s;
    cursor: pointer;
  }

  .fac-card:hover { 
    transform: translateY(-3px); 
    box-shadow: var(--shadow-lg); 
    border-color: transparent;
  }

  .fac-card-top {
    padding: 18px 16px 14px;
    color: #fff; 
    position: relative; 
    overflow: hidden;
  }

  .fac-card-top::after {
    content: '';
    position: absolute; 
    right: -15px; 
    bottom: -15px;
    width: 70px; 
    height: 70px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
  }

  .fac-card-top i { 
    font-size: 26px; 
    margin-bottom: 10px; 
    display: block;
  }

  .fac-card-name { 
    font-size: 13px; 
    font-weight: 700;
  }

  .fac-card-desc { 
    font-size: 11px; 
    opacity: .8; 
    margin-top: 3px; 
    line-height: 1.4;
  }

  .fac-card-bottom { 
    padding: 12px 16px;
  }

  .fac-card-price { 
    font-size: 13px; 
    font-weight: 700; 
    color: var(--text-primary);
  }

  .fac-card-cap { 
    font-size: 11px; 
    color: var(--text-secondary); 
    margin-top: 2px;
  }

  .fac-card-select {
    width: 100%; 
    margin-top: 10px;
    padding: 8px;
    border-radius: 8px;
    border: 1.5px solid var(--border);
    background: var(--primary);
    color: #fff;
    font-size: 12px; 
    font-weight: 600;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s;
  }

  .fac-card-select:hover { 
    background: #1d4ed8;
  }

  @keyframes fadeUp { 
    from { opacity: 0; transform: translateY(18px); } 
    to { opacity: 1; transform: translateY(0); } 
  }

  .animate { 
    animation: fadeUp .5s ease both;
  }

  .d1 { animation-delay: .05s; }
  .d2 { animation-delay: .1s; }
  .d3 { animation-delay: .15s; }
  .d4 { animation-delay: .2s; }
  .d5 { animation-delay: .25s; }

  ::-webkit-scrollbar { 
    width: 5px;
  }

  ::-webkit-scrollbar-track { 
    background: transparent;
  }

  ::-webkit-scrollbar-thumb { 
    background: #cbd5e1; 
    border-radius: 10px;
  }

  /* TOAST NOTIFICATION */
  #toast {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: #0f172a;
    color: #fff;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
    transform: translateY(80px);
    opacity: 0;
    transition: all .35s cubic-bezier(.4,0,.2,1);
    z-index: 9999;
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
    pointer-events: none;
  }

  /* ==================== RESPONSIVE DESIGN ==================== */
  
  /* TABLET - 1024px ke bawah */
  @media (max-width: 1024px) {
    .content-grid {
      grid-template-columns: 1fr;
      gap: 24px;
    }

    .form-card {
      position: static;
      top: auto;
    }

    .fac-grid {
      grid-template-columns: repeat(2, 1fr);
    }

    .main {
      padding: 0 24px 40px;
      margin-left: 260px;
      width: calc(100% - 260px);
    }
  }

  /* TABLET PORTRAIT - 768px ke bawah */
  @media (max-width: 768px) {
    .sidebar {
      width: 200px;
      padding: 16px 12px;
    }

    .main {
      margin-left: 200px;
      width: calc(100% - 200px);
      padding: 0 20px 40px;
    }

    .topbar {
      padding: 16px 0 20px;
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
    }

    .topbar-title {
      font-size: 20px;
    }

    .topbar-left {
      width: 100%;
    }

    .breadcrumb {
      font-size: 12px;
    }

    .form-body {
      padding: 20px 20px;
    }

    .form-group {
      margin-bottom: 16px;
    }

    .form-label {
      font-size: 11px;
    }

    .history-header {
      padding: 18px 20px;
    }

    .req-list {
      padding: 16px 20px;
      gap: 14px;
    }

    .req-card-top {
      padding: 14px 16px;
    }

    .req-card-meta {
      padding: 10px 16px;
      grid-template-columns: 1fr;
      gap: 8px;
    }

    .req-card-footer {
      padding: 10px 16px;
    }

    .filter-tabs {
      width: 100%;
      gap: 4px;
    }

    .filter-tab {
      font-size: 10px;
      padding: 4px 10px;
      flex: 1;
    }

    .fac-grid {
      grid-template-columns: 1fr;
      padding: 16px 20px;
      gap: 12px;
    }

    .fac-section-header {
      padding: 18px 20px;
    }

    .meta-label {
      font-size: 9px;
    }

    .meta-value {
      font-size: 11px;
    }
  }

  /* MOBILE - 480px ke bawah */
  @media (max-width: 480px) {
    body {
      flex-direction: column;
    }

    .sidebar {
      position: fixed;
      left: 0;
      top: 0;
      width: 100%;
      height: 0;
      padding: 0;
      background: var(--sidebar-bg);
      overflow: hidden;
      transition: height .3s ease, padding .3s ease;
      z-index: 999;
    }

    .sidebar.active {
      height: 100%;
      padding: 60px 16px 16px;
    }

    .sidebar-logo {
      margin-bottom: 24px;
    }

    .sidebar-toggle {
      display: flex;
    }

    .main {
      margin-left: 0;
      width: 100%;
      padding: 0 16px 40px;
      padding-top: 60px;
    }

    .topbar {
      padding: 12px 0 16px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      width: 100%;
      background: var(--bg);
      border-bottom: 1px solid var(--border);
      z-index: 100;
      padding-left: 56px;
      padding-right: 16px;
    }

    .topbar-left {
      flex-direction: column;
    }

    .breadcrumb {
      font-size: 11px;
      display: none;
    }

    .topbar-title {
      font-size: 18px;
      margin-bottom: 4px;
    }

    .topbar-right {
      position: absolute;
      right: 16px;
      top: 12px;
    }

    .form-card {
      border-radius: 12px;
    }

    .form-header {
      padding: 20px 20px 16px;
    }

    .form-header-title {
      font-size: 16px;
    }

    .form-body {
      padding: 18px 16px;
    }

    .form-group {
      margin-bottom: 14px;
    }

    .form-input, .form-select, .form-textarea {
      padding: 10px 12px;
      font-size: 14px;
      border-radius: 8px;
    }

    .form-label {
      font-size: 10px;
      margin-bottom: 6px;
    }

    .input-row {
      grid-template-columns: 1fr;
      gap: 12px;
    }

    .form-textarea {
      min-height: 80px;
    }

    .submit-btn {
      padding: 11px;
      font-size: 13px;
      margin-top: 6px;
    }

    .history-card {
      border-radius: 12px;
    }

    .history-header {
      flex-direction: column;
      align-items: flex-start;
      padding: 16px;
      gap: 12px;
    }

    .history-title {
      font-size: 15px;
    }

    .filter-tabs {
      width: 100%;
      gap: 6px;
    }

    .filter-tab {
      font-size: 10px;
      padding: 5px 10px;
      flex: 1;
    }

    .req-list {
      padding: 12px 0;
      gap: 12px;
    }

    .req-card {
      border-radius: 10px;
    }

    .req-card-top {
      padding: 12px 14px;
      flex-direction: column;
    }

    .req-card-icon {
      width: 38px;
      height: 38px;
      font-size: 15px;
    }

    .status-badge {
      align-self: flex-start;
      margin-top: 8px;
    }

    .req-card-meta {
      padding: 10px 14px;
      grid-template-columns: 1fr;
      gap: 6px;
    }

    .req-card-footer {
      padding: 10px 14px;
      gap: 6px;
      flex-direction: column;
    }

    .card-btn {
      font-size: 11px;
      padding: 8px;
    }

    .fac-section {
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .fac-section-header {
      padding: 16px;
    }

    .fac-section-title {
      font-size: 15px;
    }

    .fac-grid {
      grid-template-columns: 1fr;
      padding: 12px;
      gap: 12px;
    }

    .fac-card-top {
      padding: 16px 14px 12px;
    }

    .fac-card-name {
      font-size: 12px;
    }

    .fac-card-desc {
      font-size: 10px;
    }

    .fac-card-bottom {
      padding: 10px 14px;
    }

    .fac-card-price {
      font-size: 12px;
    }

    .fac-card-cap {
      font-size: 10px;
    }

    .empty-state {
      padding: 40px 16px;
    }

    .empty-icon {
      font-size: 48px;
      margin-bottom: 12px;
    }

    .empty-text {
      font-size: 14px;
      margin-bottom: 4px;
    }

    .empty-sub {
      font-size: 12px;
    }

    #toast {
      bottom: 16px;
      right: 16px;
      left: 16px;
      padding: 12px 16px;
      font-size: 12px;
    }
  }

  /* LARGE DESKTOP - 1440px ke atas */
  @media (min-width: 1440px) {
    .main {
      padding: 0 48px 40px;
    }

    .content-grid {
      gap: 32px;
    }
  }

</style>
</head>
<body>

<!-- SIDEBAR -->
@include ('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div>
        <div class="breadcrumb">
          <a href="#" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a>
          <i class="fas fa-chevron-right" style="font-size:10px"></i>
          <span>Peminjaman Barang</span>
        </div>
        <div class="topbar-title">Peminjaman Barang</div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  <!-- FORM + RIWAYAT -->
  <div class="content-grid">
    <!-- FORM -->
    <div class="form-card animate d2" id="formCard">
      <div class="form-header">
        <div class="form-header-icon"><i class="fas fa-box"></i></div>
        <div class="form-header-title">Buat Permintaan</div>
        <div class="form-header-sub">Isi formulir peminjaman aset di bawah ini</div>
      </div>
      <div class="form-body">
        <div class="form-group">
          <div class="form-label"><i class="fas fa-user"></i> *Nama Lengkap <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Masukkan nama lengkap Anda" id="namaInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-building"></i> Kode Barang <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Masukkan kode barang" id="kodBarangInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-barcode"></i> NUP <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="W11" id="nupInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-tag"></i> Merek <span class="req">*</span></div>
          <input type="text" class="form-input" placeholder="Yamaha" id="merekInput">
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-cubes"></i> Jumlah Barang <span class="req">*</span></div>
          <input type="number" class="form-input" placeholder="Masukkan jumlah barang" id="jumlahBarangInput">
        </div>
        <div class="input-row">
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar"></i> Tgl Pinjam <span class="req">*</span></div>
            <input type="date" class="form-input">
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-calendar-check"></i> Tgl Kembali <span class="req">*</span></div>
            <input type="date" class="form-input">
          </div>
        </div>
        <div class="form-group">
          <div class="form-label"><i class="fas fa-bullseye"></i> Tujuan Penggunaan <span class="req">*</span></div>
          <textarea class="form-textarea" placeholder="Jelaskan tujuan peminjaman secara singkat dan jelas..."></textarea>
        </div>
        
        <button class="submit-btn" onclick="submitForm()">
          <i class="fas fa-paper-plane"></i> Kirim Permintaan
        </button>
      </div>
    </div>

    <!-- RIWAYAT -->
    <div>
      <div class="history-card animate d3">
        <div class="history-header">
          <div class="history-title"><i class="fas fa-clock-rotate-left"></i> Riwayat Permintaan</div>
          <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterTab(this,'all')">Semua</button>
            <button class="filter-tab" onclick="filterTab(this,'pending')">Pending</button>
            <button class="filter-tab" onclick="filterTab(this,'approved')">Disetujui</button>
            <button class="filter-tab" onclick="filterTab(this,'rejected')">Ditolak</button>
          </div>
        </div>
        <div class="req-list" id="riwayatList">
          <!-- Sample data -->
          <div class="req-card" data-status="approved">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">
                <div class="req-card-icon" style="background:rgba(37,99,235,0.1);color:#2563eb"><i class="fas fa-chalkboard-user"></i></div>
                <div style="min-width:0">
                  <div class="req-card-name">Aula Serbaguna</div>
                  <div class="req-card-code">REQ-TAM-001</div>
                </div>
              </div>
              <div class="status-badge approved"><i class="fas fa-circle"></i> Disetujui</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Instansi</div><div class="meta-value">Dinas Pendidikan</div></div>
              <div class="meta-item"><div class="meta-label">Tujuan</div><div class="meta-value">Seminar Pendidikan</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Permintaan</div><div class="meta-value">15 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam - Kembali</div><div class="meta-value">20 Jan – 21 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
            </div>
          </div>

          <div class="req-card" data-status="pending">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">
                <div class="req-card-icon" style="background:rgba(6,182,212,0.1);color:#06b6d4"><i class="fas fa-desktop"></i></div>
                <div style="min-width:0">
                  <div class="req-card-name">Lab Komputer</div>
                  <div class="req-card-code">REQ-TAM-002</div>
                </div>
              </div>
              <div class="status-badge pending"><i class="fas fa-circle"></i> Menunggu</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Instansi</div><div class="meta-value">LPMP Sulut</div></div>
              <div class="meta-item"><div class="meta-label">Tujuan</div><div class="meta-value">Pelatihan IT</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Permintaan</div><div class="meta-value">12 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam - Kembali</div><div class="meta-value">18 Jan – 18 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
              <button class="card-btn cancel"><i class="fas fa-xmark"></i> Batalkan</button>
            </div>
          </div>

          <div class="req-card" data-status="rejected">
            <div class="req-card-top">
              <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0">
                <div class="req-card-icon" style="background:rgba(139,92,246,0.1);color:#8b5cf6"><i class="fas fa-people-group"></i></div>
                <div style="min-width:0">
                  <div class="req-card-name">Ruang Rapat VIP</div>
                  <div class="req-card-code">REQ-TAM-003</div>
                </div>
              </div>
              <div class="status-badge rejected"><i class="fas fa-circle"></i> Ditolak</div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item"><div class="meta-label">Instansi</div><div class="meta-value">Dinas Pendidikan Gorontalo</div></div>
              <div class="meta-item"><div class="meta-label">Tujuan</div><div class="meta-value">Workshop Guru</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Permintaan</div><div class="meta-value">10 Jan 2025</div></div>
              <div class="meta-item"><div class="meta-label">Tgl Pinjam - Kembali</div><div class="meta-value">15 Jan – 15 Jan 2025</div></div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail"><i class="fas fa-eye"></i> Detail</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- TOAST NOTIFICATION -->
<div id="toast">
  <i class="fas fa-circle-check" style="color:#10b981;font-size:16px"></i>
  <span id="toastMsg">Permintaan berhasil dikirim!</span>
</div>

<script>
// Toggle Sidebar di Mobile
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('active');
}

// Tutup sidebar saat klik di luar
document.addEventListener('click', function(event) {
  const sidebar = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  
  if (window.innerWidth <= 480) {
    if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
      sidebar.classList.remove('active');
    }
  }
});

// Utility Functions
function submitForm() {
  showToast('Permintaan berhasil dikirim! Menunggu persetujuan.', 'success');
}

function showToast(msg, type='success') {
  const toast = document.getElementById('toast');
  const icon = toast.querySelector('i');
  document.getElementById('toastMsg').textContent = msg;
  if(type === 'error') icon.style.color = '#ef4444';
  else icon.style.color = '#10b981';
  toast.style.transform = 'translateY(0)';
  toast.style.opacity = '1';
  setTimeout(() => {
    toast.style.transform = 'translateY(80px)';
    toast.style.opacity = '0';
  }, 3500);
}

function filterTab(el, filter) {
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.req-card').forEach(card => {
    if (filter === 'all' || card.dataset.status === filter) card.style.display = '';
    else card.style.display = 'none';
  });
}
</script>
</body>
</html>