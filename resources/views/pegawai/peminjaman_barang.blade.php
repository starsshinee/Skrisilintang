<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIPANDU - Peminjaman Barang</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      --shadow: 0 4px 24px rgba(37, 99, 235, 0.08);
      --shadow-lg: 0 8px 40px rgba(37, 99, 235, 0.14);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

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
      background: rgba(255, 255, 255, 0.08);
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
      background: rgba(255, 255, 255, 0.08);
    }

    .form-header-icon {
      position: relative;
      z-index: 1;
      width: 46px;
      height: 46px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 13px;
      display: grid;
      place-items: center;
      font-size: 20px;
      color: #fff;
      margin-bottom: 12px;
      backdrop-filter: blur(8px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-header-title {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 18px;
      font-weight: 700;
      color: #fff;
    }

    .form-header-sub {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.75);
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

    .form-input,
    .form-select,
    .form-textarea {
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

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
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
      background: rgba(37, 99, 235, 0.1);
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
      box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
      margin-top: 8px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
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
      background: rgba(16, 185, 129, 0.1);
      color: var(--success);
      border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.pending {
      background: rgba(245, 158, 11, 0.1);
      color: var(--warning);
      border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.rejected {
      background: rgba(239, 68, 68, 0.1);
      color: var(--danger);
      border: 1px solid rgba(239, 68, 68, 0.2);
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
      background: rgba(37, 99, 235, 0.08);
      color: var(--primary);
    }

    .card-btn.detail:hover {
      background: rgba(37, 99, 235, 0.15);
    }

    .card-btn.cancel {
      background: rgba(239, 68, 68, 0.08);
      color: var(--danger);
    }

    .card-btn.cancel:hover {
      background: rgba(239, 68, 68, 0.15);
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
      background: rgba(255, 255, 255, 0.1);
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
      from {
        opacity: 0;
        transform: translateY(18px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate {
      animation: fadeUp .5s ease both;
    }

    .d1 {
      animation-delay: .05s;
    }

    .d2 {
      animation-delay: .1s;
    }

    .d3 {
      animation-delay: .15s;
    }

    .d4 {
      animation-delay: .2s;
    }

    .d5 {
      animation-delay: .25s;
    }

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
      transition: all .35s cubic-bezier(.4, 0, .2, 1);
      z-index: 9999;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
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

      .form-input,
      .form-select,
      .form-textarea {
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--bg);
      color: var(--text-primary);
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
    }

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

    .content-grid {
      display: grid;
      grid-template-columns: 1fr 1.4fr;
      gap: 28px;
    }

    .form-card,
    .history-card {
      background: var(--card-bg);
      border-radius: var(--radius);
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      overflow: hidden;
    }

    .form-card {
      position: sticky;
      top: 90px;
      height: fit-content;
    }

    .form-header {
      padding: 24px 28px 20px;
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
      position: relative;
      overflow: hidden;
      color: #fff;
    }

    .form-header-icon {
      width: 46px;
      height: 46px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 13px;
      display: grid;
      place-items: center;
      font-size: 20px;
      margin-bottom: 12px;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-header-title {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 18px;
      font-weight: 700;
    }

    .form-header-sub {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.75);
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

    .form-input,
    .form-select,
    .form-textarea {
      width: 100%;
      padding: 11px 14px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 13px;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: var(--text-primary);
      outline: none;
      transition: .2s;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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

    .submit-btn {
      width: 100%;
      padding: 13px;
      background: linear-gradient(135deg, var(--primary), #3b82f6);
      color: #fff;
      border: none;
      border-radius: 11px;
      font-size: 14px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: .2s;
      margin-top: 8px;
    }

    .submit-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    }

    /* Preview Styling */
    .facility-preview {
      display: none;
      margin-top: 8px;
      padding: 12px 14px;
      border-radius: 10px;
      background: #eff4ff;
      border: 1px solid #c7d7ff;
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
    }

    .fp-name {
      font-size: 13px;
      font-weight: 700;
    }

    .fp-details {
      display: flex;
      gap: 10px;
      margin-top: 3px;
    }

    .fp-tag {
      font-size: 10px;
      background: rgba(37, 99, 235, 0.1);
      color: var(--primary);
      padding: 2px 8px;
      border-radius: 5px;
      font-weight: 600;
    }

    /* History Cards */
    .history-header {
      padding: 22px 28px 18px;
      border-bottom: 1px solid var(--border);
    }

    .history-title {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 17px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
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
      transition: .2s;
    }

    .req-card:hover {
      box-shadow: var(--shadow);
      transform: translateY(-1px);
    }

    .req-card-top {
      padding: 16px 18px;
      display: flex;
      justify-content: space-between;
      gap: 12px;
      flex-wrap: wrap;
    }

    .req-card-icon {
      width: 42px;
      height: 42px;
      border-radius: 11px;
      background: rgba(37, 99, 235, 0.1);
      color: #2563eb;
      display: grid;
      place-items: center;
      font-size: 17px;
    }

    .req-card-name {
      font-size: 14px;
      font-weight: 700;
    }

    .status-badge {
      font-size: 11px;
      font-weight: 700;
      padding: 4px 11px;
      border-radius: 7px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .status-badge.pending {
      background: rgba(245, 158, 11, 0.1);
      color: var(--warning);
      border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.approved {
      background: rgba(16, 185, 129, 0.1);
      color: var(--success);
      border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.rejected {
      background: rgba(239, 68, 68, 0.1);
      color: var(--danger);
      border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .req-card-meta {
      padding: 12px 18px;
      background: #f8faff;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      border-top: 1px solid #eef1ff;
    }

    .meta-label {
      font-size: 10px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 700;
      margin-bottom: 3px;
    }

    .meta-value {
      font-size: 12px;
      font-weight: 600;
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
      transition: .2s;
    }

    .card-btn.detail {
      background: rgba(37, 99, 235, 0.08);
      color: var(--primary);
    }

    .card-btn.detail:hover {
      background: rgba(37, 99, 235, 0.15);
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

    @media (max-width: 1024px) {
      .content-grid {
        grid-template-columns: 1fr;
      }

      .form-card {
        position: static;
      }

      .main {
        margin-left: 260px;
        width: calc(100% - 260px);
      }
    }

    @media (max-width: 768px) {
      .main {
        margin-left: 200px;
        width: calc(100% - 200px);
        padding: 0 20px 40px;
      }
    }

    @media (max-width: 480px) {
      .main {
        margin-left: 0;
        width: 100%;
        padding: 60px 16px 40px;
      }

      .input-row {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  @include('partials.sidebar')

  <main class="main">
    <!-- TOPBAR -->
    <div class="topbar">
      <div class="topbar-left">
        <div>
          <div class="breadcrumb">
            <a href="#" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a>
            <i class="fas fa-chevron-right" style="font-size:10px"></i>
            <span>Peminjaman Barang</span>
          </div>
          <div class="topbar-title">Peminjaman Aset Tetap</div>
        </div>
      </div>
    </div>

    <div class="content-grid">
      <!-- FORM PEMINJAMAN -->
      <div class="form-card">
        <div class="form-header">
          <div class="form-header-icon"><i class="fas fa-box"></i></div>
          <div class="form-header-title">Buat Permintaan Peminjaman</div>
          <div class="form-header-sub">Isi formulir peminjaman aset di bawah ini</div>
        </div>

        <form action="{{ route('pegawai.peminjaman-barang.store') }}" method="POST" id="peminjamanForm">
          @csrf
          <div class="form-body">

            <!-- Menampilkan Pesan Sukses/Error -->
            @if(session('success'))
            <div style="background: rgba(16,185,129,0.1); color: var(--success); padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; border: 1px solid rgba(16,185,129,0.2);">
              <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div style="background: rgba(239,68,68,0.1); color: var(--danger); padding: 12px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; border: 1px solid rgba(239,68,68,0.2);">
              <i class="fas fa-exclamation-triangle"></i> Gagal menyimpan permintaan. Mohon periksa kembali form Anda.
            </div>
            @endif

            <div class="form-group">
              <div class="form-label"><i class="fas fa-search"></i> Pilih Aset <span class="req">*</span></div>
              <!-- Menggunakan data-attributes untuk menangkap nup & kategori -->
              <select class="form-select" name="kode_barang" id="asetSelect" required onchange="updateDetailAset()">
                <option value="">-- Pilih Barang yang Tersedia --</option>
                @foreach($asetTetap as $aset)
                <option value="{{ $aset->kode_barang }}"
                  data-nama="{{ $aset->nama_barang }}"
                  data-merek="{{ $aset->merek }}"
                  data-stok="{{ $aset->jumlah }}"
                  data-kategori="{{ $aset->kategori }}"
                  data-nup="{{ $aset->nup }}">
                  {{ $aset->kode_barang }} - {{ $aset->nama_barang }}
                </option>
                @endforeach
              </select>
            </div>

            <!-- Preview Barang Muncul Otomatis -->
            <div class="facility-preview" id="previewBarang">
              <div class="fp-icon"><i class="fas fa-box-open"></i></div>
              <div>
                <div class="fp-name" id="previewNama">-</div>
                <div class="fp-details">
                  <span class="fp-tag" id="previewMerek">-</span>
                  <span class="fp-tag" style="background:rgba(16,185,129,0.1);color:var(--success)" id="previewStok">-</span>
                </div>
              </div>
            </div>

            <!-- BARIS BARU: KATEGORI & NUP OTOMATIS (READ ONLY) -->
            <div class="input-row" style="margin-top: 14px;">
              <div class="form-group">
                <div class="form-label"><i class="fas fa-tags"></i> Kategori Barang</div>
                <input type="text" class="form-input" id="kategoriInput" placeholder="Otomatis terisi..." readonly style="background: #f8fafc; cursor: not-allowed; color: var(--text-secondary);">
              </div>
              <div class="form-group">
                <div class="form-label"><i class="fas fa-barcode"></i> Nomor Urut Pendaftaran (NUP)</div>
                <input type="text" class="form-input" id="nupInput" placeholder="Otomatis terisi..." readonly style="background: #f8fafc; cursor: not-allowed; color: var(--text-secondary);">
              </div>
            </div>

            <div class="form-group">
              <div class="form-label"><i class="fas fa-cubes"></i> Jumlah Diminta <span class="req">*</span></div>
              <input type="number" class="form-input" name="jumlah" id="inputJumlah" min="1" placeholder="Masukkan jumlah barang" required>
            </div>

            <div class="input-row">
              <div class="form-group">
                <div class="form-label"><i class="fas fa-calendar"></i> Tgl Pinjam <span class="req">*</span></div>
                <input type="date" class="form-input" name="tanggal_peminjaman" min="{{ date('Y-m-d') }}" required>
              </div>
              <div class="form-group">
                <div class="form-label"><i class="fas fa-calendar-check"></i> Tgl Kembali <span class="req">*</span></div>
                <input type="date" class="form-input" name="tanggal_pengembalian" min="{{ date('Y-m-d') }}" required>
              </div>
            </div>

            <div class="form-group">
              <div class="form-label"><i class="fas fa-bullseye"></i> Tujuan Penggunaan <span class="req">*</span></div>
              <textarea class="form-textarea" name="deskripsi_peruntukan" placeholder="Jelaskan tujuan peminjaman secara singkat dan jelas..." required></textarea>
            </div>

            <button type="submit" class="submit-btn" id="btnSubmit">
              <i class="fas fa-paper-plane"></i> Kirim Permintaan Peminjaman
            </button>
          </div>
        </form>
      </div>

      <!-- RIWAYAT -->
      <div>
        <div class="history-card">
          <div class="history-header">
            <div class="history-title"><i class="fas fa-clock-rotate-left"></i> Riwayat Peminjaman Saya</div>
          </div>
          <div class="req-list">

            @forelse($riwayat as $item)
            <div class="req-card">
              <div class="req-card-top">
                <div style="display:flex;align-items:center;gap:12px;flex:1;">
                  <div class="req-card-icon"><i class="fas fa-boxes"></i></div>
                  <div>
                    <div class="req-card-name">{{ $item->nama_barang }}</div>
                    <div style="font-size:11px; color:var(--text-secondary); margin-top:2px;">
                      Kode: {{ $item->kode_barang }} | NUP: {{ $item->nup ?? '-' }}
                    </div>
                  </div>
                </div>

                @php
                $badgeClass = 'pending'; $icon = 'fa-clock'; $statusText = 'Menunggu Admin';
                if($item->status == 'disetujui' || $item->status == 'disetujui_admin') { $badgeClass = 'approved'; $icon = 'fa-check'; $statusText = 'Disetujui'; }
                elseif($item->status == 'ditolak') { $badgeClass = 'rejected'; $icon = 'fa-times'; $statusText = 'Ditolak'; }
                elseif($item->status == 'diteruskan_kasubag') { $badgeClass = 'pending'; $icon = 'fa-eye'; $statusText = 'Review Kasubag'; }
                @endphp

                <div class="status-badge {{ $badgeClass }}"><i class="fas {{ $icon }}"></i> {{ $statusText }}</div>
              </div>

              <div class="req-card-meta">
                <div class="meta-item">
                  <div class="meta-label">Kategori</div>
                  <div class="meta-value">{{ $item->kategori ?? 'Umum' }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Jumlah</div>
                  <div class="meta-value">{{ $item->jumlah }} Unit</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Tgl Pengajuan</div>
                  <div class="meta-value">{{ \Carbon\Carbon::parse($item->request_date)->format('d M Y') }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Durasi</div>
                  <div class="meta-value">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M') }} – {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</div>
                </div>
              </div>

              <div class="req-card-footer">
                <button class="card-btn detail" onclick="showDetail({{ $item->id }})">
                  <i class="fas fa-eye"></i> Detail
                </button>

                <!-- Tombol Cancel (Hanya muncul jika status masih 'pending') -->
                @if($item->status == 'pending')
                <button class="card-btn cancel" onclick="cancelPeminjaman({{ $item->id }}, this)">
                  <i class="fas fa-xmark"></i> Batalkan
                </button>
                @endif

                <!-- TOMBOL UNDUH BAST JIKA TERSEDIA -->
                @if(!empty($item->surat_bast_path))
                <a href="{{ asset('storage/' . $item->surat_bast_path) }}" target="_blank" class="card-btn" style="background: rgba(16,185,129,0.1); color: var(--success); text-decoration: none;">
                  <i class="fas fa-file-contract"></i> Unduh BAST
                </a>
                @endif
              </div>
            </div>
            @empty
            <div class="empty-state">
              <div class="empty-icon"><i class="fas fa-folder-open"></i></div>
              <div class="empty-text">Belum ada riwayat peminjaman</div>
              <div class="empty-sub">Ajukan peminjaman aset di form sebelah kiri.</div>
            </div>
            @endforelse

          </div>
        </div>
      </div>

      <!-- MODAL DETAIL PEMINJAMAN -->
      <div class="modal-overlay" id="detailModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div class="modal-content" style="background: #fff; width: 100%; max-width: 500px; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
          <div style="padding: 20px 24px; background: var(--primary); color: white; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 16px;"><i class="fas fa-box"></i> Detail Peminjaman</h3>
            <i class="fas fa-times" style="cursor: pointer;" onclick="document.getElementById('detailModal').style.display='none'"></i>
          </div>
          <div style="padding: 24px;" id="detailBody">
            <!-- Loading Spinner -->
            <div id="detailLoading" style="text-align: center; color: var(--text-secondary);"><i class="fas fa-spinner fa-spin fa-2x"></i>
              <p>Memuat...</p>
            </div>

            <!-- Konten Detail (Disembunyikan awalnya) -->
            <div id="detailContent" style="display: none;">
              <table style="width: 100%; font-size: 13px; line-height: 2;">
                <tr>
                  <td style="color: var(--text-secondary); width: 40%;">Barang</td>
                  <td style="font-weight: bold;" id="detBarang">-</td>
                </tr>
                <tr>
                  <td style="color: var(--text-secondary);">Kode / NUP</td>
                  <td id="detKode">-</td>
                </tr>
                <tr>
                  <td style="color: var(--text-secondary);">Merek</td>
                  <td id="detMerek">-</td>
                </tr>
                <tr>
                  <td style="color: var(--text-secondary);">Jumlah</td>
                  <td id="detJumlah">-</td>
                </tr>
                <tr>
                  <td style="color: var(--text-secondary);">Tgl Pinjam - Kembali</td>
                  <td id="detTanggal">-</td>
                </tr>
                <tr>
                  <td style="color: var(--text-secondary);">Tujuan</td>
                  <td id="detTujuan">-</td>
                </tr>
                <tr>
                  <td style="color: var(--text-secondary);">Status</td>
                  <td style="font-weight: bold;" id="detStatus">-</td>
                </tr>
              </table>
            </div>
          </div>
          <div style="padding: 16px 24px; background: #f8fafc; text-align: right; border-top: 1px solid var(--border);">
            <button onclick="document.getElementById('detailModal').style.display='none'" style="padding: 8px 16px; border: 1px solid var(--border); background: white; border-radius: 8px; cursor: pointer; font-weight: 600;">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // JS Untuk Preview & Autofill Barang Saat Select Option Berubah
    function updateDetailAset() {
      const select = document.getElementById('asetSelect');
      const selected = select.options[select.selectedIndex];
      const previewBox = document.getElementById('previewBarang');
      const inputJumlah = document.getElementById('inputJumlah');

      // Field Autofill
      const kategoriInput = document.getElementById('kategoriInput');
      const nupInput = document.getElementById('nupInput');

      if (select.value !== "") {
        // 1. Tampilkan Box Info Kecil
        document.getElementById('previewNama').innerText = selected.getAttribute('data-nama');
        document.getElementById('previewMerek').innerText = "Merek: " + (selected.getAttribute('data-merek') || '-');
        document.getElementById('previewStok').innerText = "Stok Tersedia: " + selected.getAttribute('data-stok');

        // 2. Set max jumlah sesuai stok asli di DB
        inputJumlah.max = selected.getAttribute('data-stok');

        // 3. AUTO FILL NUP dan Kategori!
        kategoriInput.value = selected.getAttribute('data-kategori') || 'Umum';
        nupInput.value = selected.getAttribute('data-nup') || '-';

        previewBox.style.display = 'flex';
      } else {
        previewBox.style.display = 'none';
        kategoriInput.value = '';
        nupInput.value = '';
        inputJumlah.max = '';
      }
    }

    // Pencegahan double submit agar UX lebih smooth
    document.getElementById('peminjamanForm').addEventListener('submit', function() {
      const btn = document.getElementById('btnSubmit');
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
      btn.style.opacity = '0.7';
      btn.disabled = true;
    });

    // Fungsi Menampilkan Modal Detail via AJAX
    function showDetail(id) {
      const modal = document.getElementById('detailModal');
      const loading = document.getElementById('detailLoading');
      const content = document.getElementById('detailContent');

      modal.style.display = 'flex';
      loading.style.display = 'block';
      content.style.display = 'none';

      fetch(`/pegawai/peminjaman-barang/${id}/detail`)
        .then(response => response.json())
        .then(res => {
          if (res.success) {
            let data = res.data;
            document.getElementById('detBarang').innerText = data.nama_barang;
            document.getElementById('detKode').innerText = data.kode_barang + ' / ' + (data.nup || '-');
            document.getElementById('detMerek').innerText = data.merek || '-';
            document.getElementById('detJumlah').innerText = data.jumlah + ' Unit';

            let tglPinjam = new Date(data.tanggal_peminjaman).toLocaleDateString('id-ID');
            let tglKembali = new Date(data.tanggal_pengembalian).toLocaleDateString('id-ID');
            document.getElementById('detTanggal').innerText = tglPinjam + ' s/d ' + tglKembali;

            document.getElementById('detTujuan').innerText = data.deskripsi_peruntukan;
            document.getElementById('detStatus').innerText = data.status.toUpperCase().replace('_', ' ');

            loading.style.display = 'none';
            content.style.display = 'block';
          }
        })
        .catch(err => {
          alert("Gagal mengambil data detail.");
          modal.style.display = 'none';
        });
    }

    // Fungsi Membatalkan Peminjaman via AJAX
    function cancelPeminjaman(id, btnElement) {
      if (!confirm('Apakah Anda yakin ingin membatalkan peminjaman barang ini? Data akan dihapus.')) return;

      const originalText = btnElement.innerHTML;
      btnElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Batal...';
      btnElement.disabled = true;

      fetch(`/pegawai/peminjaman-barang/${id}/cancel`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Hapus Card dari layar dengan efek fade
            const card = btnElement.closest('.req-card');
            card.style.opacity = '0.5';
            setTimeout(() => card.remove(), 500);

            // Tampilkan toast notifikasi bawaan kamu (jika ada fungsi showToast)
            if (typeof showToast === 'function') showToast('Peminjaman berhasil dibatalkan!', 'success');
            else alert('Peminjaman berhasil dibatalkan!');
          } else {
            alert(data.message);
            btnElement.innerHTML = originalText;
            btnElement.disabled = false;
          }
        })
        .catch(error => {
          alert('Gagal membatalkan peminjaman.');
          btnElement.innerHTML = originalText;
          btnElement.disabled = false;
        });
    }
  </script>

</body>

</html>