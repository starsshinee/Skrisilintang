<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Pengembalian Kendaraan</title>
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
  }

  .main { margin-left: 260px; flex: 1; padding: 0 32px 40px; }

  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
    border-bottom: 1px solid transparent;
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
  .breadcrumb a { text-decoration:none; color: var(--text-secondary); }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: var(--danger); border-radius: 50%; border: 1.5px solid var(--card-bg); }

  .content-grid {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 28px;
  }

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
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    position: relative; overflow: hidden;
  }
  .form-header::before {
    content: '';
    position: absolute; right: -30px; top: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
  }
  .form-header-icon {
    position: relative;
    z-index: 1;
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 13px;
    display: grid; place-items: center;
    font-size: 20px; color: #fff;
    margin-bottom: 12px;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .form-header-title { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; color: #fff; }
  .form-header-sub { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 4px; }

  .form-body { padding: 24px 28px; }

  .form-group { margin-bottom: 18px; }
  .form-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; font-weight: 700; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .6px;
    margin-bottom: 8px;
  }
  .form-label i { color: var(--primary); font-size: 11px; }
  .form-label .req { color: var(--danger); }

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
    box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
  }
  .form-input::placeholder, .form-textarea::placeholder { color: #b0bcd4; }
  .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .form-textarea { resize: vertical; min-height: 90px; }

  .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  .kendaraan-preview {
    display: none;
    margin-top: 8px;
    padding: 12px 14px;
    border-radius: 10px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid #bfdbfe;
  }
  .kendaraan-preview.show { display: flex; align-items: center; gap: 12px; }
  .kp-icon { width: 36px; height: 36px; border-radius: 9px; background: var(--primary); display: grid; place-items: center; color: #fff; font-size: 15px; flex-shrink: 0; }
  .kp-name { font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .kp-details { display: flex; gap: 10px; margin-top: 3px; }
  .kp-tag { font-size: 10px; background: rgba(79,70,229,0.1); color: var(--primary); padding: 2px 8px; border-radius: 5px; font-weight: 600; }

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
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 14px rgba(37,99,235,0.35);
    margin-top: 8px;
  }
  .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,99,235,0.4); }
  .submit-btn:active { transform: translateY(0); }
  .submit-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

  .history-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .history-header {
    padding: 22px 28px 18px;
    display: flex; align-items: center; justify-content: space-between;
    border-bottom: 1px solid var(--border);
  }
  .history-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 17px; font-weight: 700; color: var(--text-primary);
    display: flex; align-items: center; gap: 8px;
  }
  .history-title i { color: var(--primary); }
  .filter-tabs { display: flex; gap: 6px; }
  .filter-tab {
    font-size: 11px; font-weight: 600; padding: 5px 12px;
    border-radius: 7px; cursor: pointer; border: 1.5px solid var(--border);
    background: transparent; color: var(--text-secondary);
    transition: all .2s; font-family: 'Plus Jakarta Sans', sans-serif;
  }
  .filter-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
  .filter-tab:hover:not(.active) { border-color: var(--primary); color: var(--primary); }

  .req-list { padding: 20px 28px; display: flex; flex-direction: column; gap: 16px; max-height: 70vh; overflow-y: auto; }

  .req-card {
    border: 1.5px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    transition: all .2s;
    cursor: pointer;
  }
  .req-card:hover { box-shadow: var(--shadow); transform: translateY(-1px); }
  .req-card.active { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }

  .req-card-top {
    padding: 16px 18px;
    display: flex; align-items: flex-start; justify-content: space-between;
  }
  .req-card-icon {
    width: 42px; height: 42px; border-radius: 11px;
    display: grid; place-items: center;
    font-size: 17px; flex-shrink: 0;
  }
  .req-card-name { font-size: 14px; font-weight: 700; color: var(--text-primary); }
  .req-card-code { font-size: 11px; color: var(--text-secondary); margin-top: 2px; }
  .status-badge {
    font-size: 11px; font-weight: 700; padding: 4px 11px; border-radius: 7px;
    letter-spacing: .3px; display: flex; align-items: center; gap: 5px;
    white-space: nowrap;
  }
  .status-badge.diproses { background: rgba(245,158,11,0.1); color: var(--warning); border: 1px solid rgba(245,158,11,0.2); }
  .status-badge.diterima { background: rgba(16,185,129,0.1); color: var(--success); border: 1px solid rgba(16,185,129,0.2); }
  .status-badge.ditolak { background: rgba(239,68,68,0.1); color: var(--danger); border: 1px solid rgba(239,68,68,0.2); }
  .status-badge i { font-size: 9px; }

  .req-card-meta {
    padding: 12px 18px;
    background: #f0f9ff;
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px;
    border-top: 1px solid #e0f2fe;
  }
  .meta-item {}
  .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: .6px; color: #94a3b8; font-weight: 700; margin-bottom: 3px; }
  .meta-value { font-size: 12px; font-weight: 600; color: var(--text-primary); }

  .req-card-footer {
    padding: 12px 18px;
    display: flex; gap: 8px;
    border-top: 1px solid #e0f2fe;
  }
  .card-btn {
    flex: 1; padding: 9px;
    border-radius: 8px;
    font-size: 12px; font-weight: 600;
    cursor: pointer; border: none;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all .2s;
  }
  .card-btn.select { background: rgba(37,99,235,0.08); color: var(--primary); }
  .card-btn.select:hover { background: rgba(37,99,235,0.15); }
  .card-btn.detail { background: rgba(16,185,129,0.08); color: var(--success); }
  .card-btn.detail:hover { background: rgba(16,185,129,0.15); }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }
  .animate { animation: fadeUp .5s ease both; }
  .d1 { animation-delay: .05s; } .d2 { animation-delay: .1s; } .d3 { animation-delay: .15s; }

  ::-webkit-scrollbar { width: 5px; }
  ::-webkit-scrollbar-track { background: transparent; }
  ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

  .alert-success {
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.2);
    color: var(--success);
    padding: 16px 20px;
    border-radius: var(--radius-sm);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
  }
</style>
</head>
<body>

@include('partials.sidebar')

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div>
        <div class="breadcrumb">
          <a href="{{ route('tamu.dashboard') }}">Dashboard</a> 
          <i class="fas fa-chevron-right" style="font-size:10px"></i> 
          <span>Pengembalian Kendaraan</span>
        </div>
        <div class="topbar-title">Pengembalian Kendaraan</div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  @if(session('success'))
    <div class="alert-success">
      <i class="fas fa-check-circle"></i>
      {{ session('success') }}
    </div>
  @endif

  <!-- FORM + RIWAYAT -->
  <div class="content-grid">
    <!-- FORM LAPOR PENGEMBALIAN -->
    <div class="form-card animate d2" id="formCard">
      <div class="form-header">
        <div class="form-header-icon"><i class="fas fa-car"></i></div>
        <div class="form-header-title">Lapor Pengembalian Kendaraan</div>
        <div class="form-header-sub">Pilih peminjaman kendaraan dan laporkan kondisi pengembalian</div>
      </div>
      <div class="form-body">
        <form action="{{ route('pegawai.pengembalian-kendaraan') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="form-group">
            <div class="form-label">
              <i class="fas fa-clipboard-list"></i> 
              *Pilih Peminjaman Kendaraan <span class="req">*</span>
            </div>
            <select class="form-select" name="peminjaman_kendaraan_id"            id="peminjamanSelect" onchange="onPeminjamanChange()" required>
              <option value="">-- Pilih Peminjaman Kendaraan --</option>
              @foreach($peminjamanKendaraan as $peminjaman)
                <option value="{{ $peminjaman->id }}" 
                        data-nopol="{{ $peminjaman->kendaraan->nopol }}"
                        data-merek="{{ $peminjaman->kendaraan->merk }}"
                        data-tipe="{{ $peminjaman->kendaraan->tipe }}"
                        data-tgl-pinjam="{{ $peminjaman->tanggal_pinjam->format('d M Y') }}">
                  {{ $peminjaman->kendaraan->nopol }} - {{ $peminjaman->kendaraan->merk }} {{ $peminjaman->kendaraan->tipe }}
                </option>
              @endforeach
            </select>
            <div class="kendaraan-preview" id="kendaraanPreview">
              <div class="kp-icon"><i class="fas fa-car" id="kpIcon"></i></div>
              <div>
                <div class="kp-name" id="kpName">Toyota Avanza</div>
                <div class="kp-details">
                  <span class="kp-tag" id="kpNopol">B 1234 XYZ</span>
                  <span class="kp-tag" id="kpMerek">Toyota Avanza</span>
                </div>
              </div>
            </div>
          </div>

          <div class="input-row">
            <div class="form-group">
              <div class="form-label"><i class="fas fa-calendar-check"></i> Tanggal Pengembalian <span class="req">*</span></div>
              <input type="datetime-local" class="form-input" name="tanggal_pengembalian_aktual" id="tglPengembalian" required>
            </div>
          </div>

          <div class="form-group">
            <div class="form-label"><i class="fas fa-car-side"></i> Kondisi Kendaraan <span class="req">*</span></div>
            <select class="form-select" name="kondisi_kendaraan" id="kondisiKendaraan" required>
              <option value="">-- Pilih Kondisi --</option>
              <option value="baik">Baik - Normal seperti semula</option>
              <option value="rusak-ringan">Rusak Ringan - Perlu perbaikan kecil</option>
              <option value="rusak-berat">Rusak Berat - Tidak bisa digunakan</option>
              <option value="hilang">Hilang / Kecelakaan Total</option>
            </select>
          </div>

          {{-- <div class="input-row">
            <div class="form-group">
              <div class="form-label"><i class="fas fa-camera"></i> Foto Sebelum <span class="req">*</span></div>
              <input type="file" class="form-input" name="foto_sebelum" accept="image/*" required>
            </div>
            <div class="form-group">
              <div class="form-label"><i class="fas fa-camera-retro"></i> Foto Sesudah <span class="req">*</span></div>
              <input type="file" class="form-input" name="foto_sesudah" accept="image/*" required>
            </div>
          </div> --}}

          <div class="form-group">
            <div class="form-label"><i class="fas fa-clipboard"></i> Catatan Pengembalian</div>
            <textarea class="form-textarea" name="catatan" id="catatanPengembalian" 
                      placeholder="Deskripsikan kondisi kendaraan, kerusakan, kilometer, bahan bakar, atau catatan lainnya..."></textarea>
          </div>

          <button type="submit" class="submit-btn" id="submitBtn" disabled>
            <i class="fas fa-paper-plane"></i> Laporkan Pengembalian
          </button>
        </form>
      </div>
    </div>

    <!-- RIWAYAT PENGEMBALIAN KENDARAAN -->
    <div>
      <div class="history-card animate d3">
        <div class="history-header">
          <div class="history-title">
            <i class="fas fa-history"></i> 
            Riwayat Pengembalian Kendaraan
            <span style="font-size:14px;font-weight:500;color:var(--text-secondary);margin-left:8px">
              {{ $pengembalianKendaraan->count() }} data
            </span>
          </div>
          <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterTab(this,'all')">Semua</button>
            <button class="filter-tab" onclick="filterTab(this,'diproses')">Diproses</button>
            <button class="filter-tab" onclick="filterTab(this,'diterima')">Diterima</button>
            <button class="filter-tab" onclick="filterTab(this,'ditolak')">Ditolak</button>
          </div>
        </div>
        <div class="req-list" id="riwayatList">
          @forelse($pengembalianKendaraan as $pengembalian)
            @php
              $peminjaman = $pengembalian->peminjamanKendaraan;
              $statusClass = strtolower($pengembalian->status_pengembalian ?? 'diproses');
            @endphp
            <div class="req-card" data-status="{{ $statusClass }}" onclick="viewDetail({{ $pengembalian->id }})">
              <div class="req-card-top">
                <div style="display:flex;align-items:center;gap:12px">
                  <div class="req-card-icon" style="background:rgba(37,99,235,0.1);color:var(--primary)">
                    <i class="fas fa-car-side"></i>
                  </div>
                  <div>
                    <div class="req-card-name">{{ $peminjaman->kendaraan->nopol ?? 'N/A' }}</div>
                    <div class="req-card-code">{{ $peminjaman->kendaraan->merk ?? '' }} {{ $peminjaman->kendaraan->tipe ?? '' }}</div>
                  </div>
                </div>
                <div class="status-badge {{ $statusClass }}">
                  <i class="fas fa-{{ $statusClass == 'diterima' ? 'check-circle' : ($statusClass == 'ditolak' ? 'times-circle' : 'clock') }}"></i>
                  {{ ucfirst($pengembalian->status_pengembalian ?? 'Diproses') }}
                </div>
              </div>
              <div class="req-card-meta">
                <div class="meta-item">
                  <div class="meta-label">Peminjam</div>
                  <div class="meta-value">{{ $peminjaman->user->nama ?? 'N/A' }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Tgl Aktual</div>
                  <div class="meta-value">{{ $pengembalian->tanggal_pengembalian_aktual?->format('d M Y H:i') ?? '-' }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Kondisi</div>
                  <div class="meta-value">{{ ucwords(str_replace('-', ' ', $pengembalian->kondisi_kendaraan ?? '-')) }}</div>
                </div>
                <div class="meta-item">
                  <div class="meta-label">Denda</div>
                  <div class="meta-value">Rp {{ number_format($pengembalian->biaya_denda ?? 0, 0, ',', '.') }}</div>
                </div>
              </div>
              <div class="req-card-footer">
                <button class="card-btn detail">
                  <i class="fas fa-eye"></i> Detail
                </button>
              </div>
            </div>
          @empty
            <div style="text-align:center;padding:40px 20px;color:var(--text-secondary)">
              <i class="fas fa-car" style="font-size:48px;margin-bottom:16px;opacity:0.5"></i>
              <h3 style="font-family:'Space Grotesk',sans-serif;font-size:18px;margin-bottom:8px">Belum ada riwayat</h3>
              <p style="font-size:13px">Mulai laporkan pengembalian kendaraan pertama Anda</p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</main>

<!-- TOAST NOTIFICATION -->
<div id="toast" style="
  position:fixed; bottom:28px; right:28px;
  background:#0f172a; color:#fff;
  padding:14px 20px; border-radius:12px;
  font-size:13px; font-weight:600;
  display:flex; align-items:center; gap:10px;
  transform:translateY(80px); opacity:0;
  transition:all .35s cubic-bezier(.4,0,.2,1);
  z-index:9999; box-shadow:0 8px 24px rgba(0,0,0,0.25);
  pointer-events:none;
">
  <i class="fas fa-circle-check" style="color:#10b981;font-size:16px"></i>
  <span id="toastMsg">Laporan pengembalian kendaraan berhasil dikirim!</span>
</div>

<script>
let kendaraanData = {};

function onPeminjamanChange() {
  const select = document.getElementById('peminjamanSelect');
  const val = select.value;
  const preview = document.getElementById('kendaraanPreview');
  const submitBtn = document.getElementById('submitBtn');
  
  if (val) {
    const option = select.options[select.selectedIndex];
    const nopol = option.dataset.nopol;
    const merek = option.dataset.merek;
    const tipe = option.dataset.tipe;
    
    document.getElementById('kpName').textContent = `${merek} ${tipe}`;
    document.getElementById('kpNopol').textContent = nopol;
    document.getElementById('kpMerek').textContent = `${merek} ${tipe}`;
    preview.classList.add('show');
    
    // Enable submit button
    submitBtn.disabled = false;
    submitBtn.style.opacity = '1';
    submitBtn.style.cursor = 'pointer';
  } else {
    preview.classList.remove('show');
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.6';
    submitBtn.style.cursor = 'not-allowed';
  }
}

function viewDetail(id) {
  // Redirect to detail page
  window.location.href = `/pengembalian/${id}`;
}

function filterTab(el, filter) {
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.req-card').forEach(card => {
    if (filter === 'all' || card.dataset.status === filter) {
      card.style.display = '';
    } else {
      card.style.display = 'none';
    }
  });
}

// Set default datetime to now
document.addEventListener('DOMContentLoaded', function() {
  const now = new Date();
  const datetime = now.toISOString().slice(0, 16);
  document.getElementById('tglPengembalian').value = datetime;
  
  // Initialize data from options
  const select = document.getElementById('peminjamanSelect');
  for(let i = 0; i < select.options.length; i++) {
    const opt = select.options[i];
    if(opt.value) {
      kendaraanData[opt.value] = {
        nopol: opt.dataset.nopol,
        merek: opt.dataset.merek,
        tipe: opt.dataset.tipe
      };
    }
  }
});
</script>
</body>
</html>