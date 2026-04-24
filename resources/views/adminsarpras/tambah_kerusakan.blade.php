<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Kerusakan - Admin Sarana Prasarana</title>
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
    background: var(--card-bg);
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
    background: var(--card-bg); display: flex; align-items: center; justify-content: center;
    cursor: pointer; position: relative;
  }
  .notif-dot { width: 8px; height: 8px; background: #EF4444; border-radius: 50%; position: absolute; top: 6px; right: 6px; border: 2px solid white; }
  .date-text { font-size: 13px; color: #64748B; font-weight: 500; }
  .btn-keluar {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--card-bg); color: #64748B;
    font-size: 13px; font-weight: 600; font-family: inherit; cursor: pointer; transition: all .15s; text-decoration: none;
  }
  .btn-keluar:hover { background: #FEF2F2; color: #EF4444; }

  .content { padding: 28px; flex: 1; }
  .page-header {
    display: flex; align-items: center; gap: 16px; margin-bottom: 32px;
  }
  .page-icon { 
    width: 48px; height: 48px; background: var(--primary-light); 
    border-radius: 12px; display: flex; align-items: center; justify-content: center; 
    color: var(--primary); 
  }
  .page-title { font-size: 24px; font-weight: 700; }
  .page-subtitle { color: var(--text-secondary); font-size: 14px; margin-top: 4px; }

  .form-card {
    background: var(--card-bg); border-radius: 16px;
    border: 1px solid var(--border); padding: 32px; max-width: 800px;
    margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
  .form-row.full { grid-template-columns: 1fr; }
  .form-group { margin-bottom: 24px; }
  .form-label { 
    font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block; 
    color: var(--text-primary);
  }
  .form-input, .form-select, .form-textarea {
    width: 100%; padding: 12px 16px; border: 1px solid var(--border);
    border-radius: 12px; font-family: inherit; font-size: 14px; outline: none;
    transition: all .2s; background: var(--card-bg);
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus { 
    border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light);
  }
  .form-textarea { min-height: 100px; resize: vertical; }
  .file-preview {
    display: flex; align-items: center; gap: 12px; margin-top: 12px;
  }
  .file-preview img { 
    width: 80px; height: 80px; object-fit: cover; border-radius: 8px; 
    border: 2px solid var(--border);
  }
  .file-info { font-size: 13px; color: var(--text-secondary); }
  .btn-group {
    display: flex; gap: 12px; justify-content: flex-end; padding-top: 24px;
    border-top: 1px solid var(--border); margin-top: 32px;
  }
  .btn-primary {
    display: flex; align-items: center; gap: 8px;
    padding: 12px 24px; background: var(--primary); color: #fff;
    border: none; border-radius: 12px; font-family: inherit;
    font-size: 14px; font-weight: 600; cursor: pointer; transition: all .2s;
  }
  .btn-primary:hover { background: #3251d4; transform: translateY(-1px); }
  .btn-secondary {
    padding: 12px 24px; border: 1px solid var(--border); border-radius: 12px;
    font-family: inherit; font-size: 14px; cursor: pointer; background: #fff;
    font-weight: 500; color: var(--text-secondary); transition: all .2s;
  }
  .btn-secondary:hover { background: var(--primary-light); color: var(--primary); }

  .error-message {
    color: var(--danger); font-size: 12px; margin-top: 6px;
    display: block;
  }
  .required { color: var(--danger); }
  
  @media (max-width: 768px) {
    .form-row { grid-template-columns: 1fr; }
    .btn-group { flex-direction: column; }
    .content { padding: 20px; }
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <div style="display: flex; align-items: center; gap: 12px;">
      <a href="{{ route('tambah-kerusakan') }}" style="color: inherit; text-decoration: none;">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <span class="topbar-title">Tambah Data Kerusakan</span>
    </div>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</span>
      <a href="{{ route('logout') }}" class="btn-keluar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 11H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2z"/></svg>
        Keluar
      </a>
    </div>
  </div>

  <div class="content">
    @if ($errors->any())
    <div class="alert alert-danger" style="background: var(--danger-light); color: var(--danger); padding: 16px; border-radius: 12px; margin-bottom: 24px; border: 1px solid var(--danger);">
      <strong>Periksa kembali form berikut:</strong>
      <ul style="margin-top: 8px; margin-bottom: 0;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('kerusakan.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-card">
        <div class="page-header">
          <div class="page-icon">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div>
            <div class="page-title">Tambah Data Kerusakan Baru</div>
            <div class="page-subtitle">Isi informasi lengkap kerusakan barang</div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Input <span class="required">*</span></label>
            <input type="date" name="tanggal_input" class="form-input @error('tanggal_input') border-red-500 @enderror" 
                   value="{{ old('tanggal_input', now()->format('Y-m-d')) }}" required>
            @error('tanggal_input')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Kondisi <span class="required">*</span></label>
            <select name="kondisi" class="form-select @error('kondisi') border-red-500 @enderror" required>
              <option value="">Pilih kondisi</option>
              <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
              <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
              <option value="Rusak Sedang" {{ old('kondisi') == 'Rusak Sedang' ? 'selected' : '' }}>Rusak Sedang</option>
              <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
              <option value="Hancur" {{ old('kondisi') == 'Hancur' ? 'selected' : '' }}>Hancur</option>
            </select>
            @error('kondisi')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Barang <span class="required">*</span></label>
            <input type="text" name="nama_barang" class="form-input @error('nama_barang') border-red-500 @enderror" 
                   value="{{ old('nama_barang') }}" placeholder="Contoh: Kursi Kantor Executive" required>
            @error('nama_barang')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Kode Barang <span class="required">*</span></label>
            <input type="text" name="kode_barang" class="form-input @error('kode_barang') border-red-500 @enderror" 
                   value="{{ old('kode_barang') }}" placeholder="Contoh: KR-001" required>
            @error('kode_barang')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">NUP <span class="required">*</span></label>
            <input type="text" name="nup" class="form-input @error('nup') border-red-500 @enderror" 
                   value="{{ old('nup') }}" placeholder="Contoh: NUP-123456" required>
            @error('nup')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="form-label">Foto Kerusakan</label>
            <input type="file" name="foto" id="foto" class="file-input-wrapper @error('foto') border-red-500 @enderror" accept="image/*">
            <label for="foto" class="file-input-label">
              <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              Pilih Foto (JPG, PNG, max 2MB)
            </label>
            <div id="filePreview" class="file-preview" style="display: none;">
              <img id="previewImg" src="" alt="Preview">
              <div class="file-info">
                <div id="fileName"></div>
                <div id="fileSize"></div>
              </div>
            </div>
            @error('foto')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row full">
          <div class="form-group">
            <label class="form-label">Lokasi <span class="required">*</span></label>
            <input type="text" name="lokasi" class="form-input @error('lokasi') border-red-500 @enderror" 
                   value="{{ old('lokasi') }}" placeholder="Contoh: Laboratorium Informatika Lt. 2" required>
            @error('lokasi')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-row full">
          <div class="form-group">
            <label class="form-label">Deskripsi Kerusakan</label>
            <textarea name="deskripsi" class="form-textarea @error('deskripsi') border-red-500 @enderror" 
                      placeholder="Jelaskan detail kerusakan yang terjadi...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
            <span class="error-message">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="btn-group">
          <a href="{{ route('data-kerusakan') }}" class="btn-secondary">Batal</a>
          <button type="submit" class="btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Simpan Data
          </button>
        </div>
      </div>
    </form>
  </div>
</main>

<script>
document.getElementById('foto').addEventListener('change', function(e) {
  const file = e.target.files[0];
  const preview = document.getElementById('filePreview');
  const previewImg = document.getElementById('previewImg');
  const fileName = document.getElementById('fileName');
  const fileSize = document.getElementById('fileSize');

  if (file) {
    // Validasi ukuran file (2MB)
    if (file.size > 2 * 1024 * 1024) {
      alert('Ukuran file maksimal 2MB!');
      e.target.value = '';
      return;
    }

    // Preview gambar
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImg.src = e.target.result;
    };
    reader.readAsDataURL(file);

    // Info file
    fileName.textContent = file.name;
    fileSize.textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
    
    preview.style.display = 'flex';
  } else {
    preview.style.display = 'none';
  }
});

// Set tanggal hari ini sebagai default
document.addEventListener('DOMContentLoaded', function() {
  const today = new Date().toISOString().split('T')[0];
  if (!document.querySelector('input[name="tanggal_input"]').value) {
    document.querySelector('input[name="tanggal_input"]').value = today;
  }
});
</script>
</body>
</html>