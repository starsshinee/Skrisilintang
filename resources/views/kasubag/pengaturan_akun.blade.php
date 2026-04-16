<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaturan Akun - Kasubag</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --primary: #4361ee;
    --primary-light: #eef2ff;
    --orange: #f59e0b;
    --orange-light: #fffbeb;
    --green: #10b981;
    --green-light: #ecfdf5;
    --red: #ef4444;
    --red-light: #fef2f2;
    --purple: #8b5cf6;
    --purple-light: #f5f3ff;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #f8fafc;
    color: #334155;
    display: flex;
    min-height: 100vh;
  }

  /* Sidebar */
  .sidebar {
    width: 260px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
  }

  .sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }

  .sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 18px;
    font-weight: 600;
  }

  .sidebar-logo i {
    font-size: 24px;
  }

  .sidebar-nav {
    padding: 20px 0;
  }

  .nav-item {
    margin: 4px 0;
  }

  .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 20px;
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .nav-link:hover, .nav-link.active {
    background: rgba(255,255,255,0.1);
    color: white;
  }

  .nav-link i {
    width: 20px;
  }

  /* Main Content */
  .main {
    margin-left: 260px;
    flex: 1;
    padding: 32px;
  }

  .page-header {
    margin-bottom: 32px;
  }

  .page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }

  .page-subtitle {
    color: #64748b;
    font-size: 16px;
  }

  /* Card */
  .card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    padding: 32px;
    margin-bottom: 24px;
  }

  .card-title {
    font-size: 20px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 24px;
  }

  /* Form */
  .form-group {
    margin-bottom: 24px;
  }

  .form-label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 8px;
  }

  .form-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }

  .form-input:focus {
    outline: none;
    border-color: var(--primary);
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
  }

  /* Button */
  .btn {
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
  }

  .btn-primary:hover {
    background: #3b4fd6;
    transform: translateY(-1px);
  }

  .btn-secondary {
    background: #f1f5f9;
    color: #64748b;
  }

  .btn-secondary:hover {
    background: #e2e8f0;
  }

  /* Alert */
  .alert {
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .alert-success {
    background: var(--green-light);
    color: var(--green);
    border: 1px solid #bbf7d0;
  }

  .alert-error {
    background: var(--red-light);
    color: var(--red);
    border: 1px solid #fecaca;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-100%);
    }

    .main {
      margin-left: 0;
      padding: 16px;
    }

    .form-row {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>
  <!-- Sidebar -->
  @include('partials.sidebar')

  <!-- Main Content -->
  <div class="main">
    <div class="page-header">
      <h1 class="page-title">Pengaturan Akun</h1>
      <p class="page-subtitle">Kelola informasi akun dan pengaturan keamanan Anda</p>
    </div>

    <div class="card">
      <h2 class="card-title">Informasi Pribadi</h2>

      <form action="#" method="POST">
        @csrf

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-input" value="{{ auth()->user()->name ?? '' }}" required>
          </div>

          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-input" value="{{ auth()->user()->email ?? '' }}" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">NIP</label>
            <input type="text" class="form-input" placeholder="Masukkan NIP">
          </div>

          <div class="form-group">
            <label class="form-label">Jabatan</label>
            <input type="text" class="form-input" value="Kasubag TU" readonly>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>

    <div class="card">
      <h2 class="card-title">Ubah Password</h2>

      <form action="#" method="POST">
        @csrf

        <div class="form-group">
          <label class="form-label">Password Lama</label>
          <input type="password" class="form-input" required>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <input type="password" class="form-input" required>
          </div>

          <div class="form-group">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" class="form-input" required>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-key"></i>
            Ubah Password
          </button>
        </div>
      </form>
    </div>

    <div class="card">
      <h2 class="card-title">Pengaturan Notifikasi</h2>

      <form action="#" method="POST">
        @csrf

        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" checked>
            <span>Email notifikasi untuk permintaan persetujuan</span>
          </label>
        </div>

        <div class="form-group">
          <label class="form-check">
            <input type="checkbox" checked>
            <span>Notifikasi laporan harian</span>
          </label>
        </div>

        <div class="form-group">
          <label class="form-check">
            <input type="checkbox">
            <span>Notifikasi pengingat deadline</span>
          </label>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-secondary">
            <i class="fas fa-bell"></i>
            Simpan Pengaturan
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Toggle sidebar on mobile
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('active');
    }

    // Form validation
    document.querySelectorAll('form').forEach(form => {
      form.addEventListener('submit', function(e) {
        // Basic validation can be added here
        console.log('Form submitted');
      });
    });
  </script>
</body>
</html>