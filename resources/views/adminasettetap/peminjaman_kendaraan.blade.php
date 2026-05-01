<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Peminjaman Kendaraan</title>
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
    --sidebar-width: 260px;
    --card-bg: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow: 0 4px 24px rgba(37,99,235,0.08);
    --shadow-lg: 0 8px 40px rgba(37,99,235,0.14);
    --topbar-height: 80px;
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-primary); display: flex; min-height: 100vh; }

  /* SIDEBAR di-include dari partials */
  .main { margin-left: var(--sidebar-width); flex: 1; padding: 0 28px 40px; min-width: 0; transition: margin-left 0.3s cubic-bezier(.4,0,.2,1); }

  /* TOPBAR */
  .topbar { display: flex; align-items: center; justify-content: space-between; padding: 20px 0 20px; position: sticky; top: 0; z-index: 50; background: var(--bg); }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn { width: 40px; height: 40px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 10px; display: grid; place-items: center; cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s; }

  /* CONTENT GRID */
  .content-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 24px; align-items: start; }

  /* FORM CARD */
  .form-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; position: sticky; top: 90px; }
  .form-header { padding: 24px 24px 20px; background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: #fff; }
  .form-header-title { font-family: 'Space Grotesk', sans-serif; font-size: 18px; font-weight: 700; }
  .form-body { padding: 20px 24px; }
  .form-group { margin-bottom: 16px; }
  .form-label { font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 7px; display: flex; align-items: center; gap: 6px; }
  .form-input, .form-select, .form-textarea { width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; outline: none; }
  .form-input:focus { border-color: var(--primary); }
  .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .submit-btn { width: 100%; padding: 13px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; border: none; border-radius: 11px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(37,99,235,0.35); }

  /* HISTORY CARD */
  .history-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); }
  .history-header { padding: 20px 22px 16px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
  .history-title { font-family: 'Space Grotesk', sans-serif; font-size: 16px; font-weight: 700; }
  .req-list { padding: 18px 22px; display: flex; flex-direction: column; gap: 14px; }
  .req-card { border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; transition: all .2s; }
  .req-card-top { padding: 15px 16px; display: flex; justify-content: space-between; align-items: flex-start; }
  .status-badge { font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 7px; text-transform: uppercase; }
  .status-badge.disetujui { background: rgba(16,185,129,0.1); color: var(--success); }
  .status-badge.pending { background: rgba(245,158,11,0.1); color: var(--warning); }
  .status-badge.ditolak { background: rgba(239,68,68,0.1); color: var(--danger); }
  .req-card-meta { padding: 11px 16px; background: #f8faff; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; border-top: 1px solid #eef1ff; }
  .meta-label { font-size: 10px; color: #94a3b8; font-weight: 700; text-transform: uppercase; }
  .meta-value { font-size: 12px; font-weight: 600; }
  .req-card-footer { padding: 11px 16px; display: flex; gap: 8px; border-top: 1px solid #eef1ff; }
  .card-btn { flex: 1; padding: 9px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none;}
  .card-btn.detail { background: rgba(37,99,235,0.08); color: var(--primary); }
  .card-btn.cancel { background: rgba(239,68,68,0.08); color: var(--danger); }
  .card-btn.download { background: var(--primary); color: #fff; }

  @media (max-width: 768px) {
    .main { margin-left: 0; padding: 0 16px 40px; }
    .content-grid { grid-template-columns: 1fr; }
    .form-card { position: static; }
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <div class="topbar-left">
      <div class="breadcrumb">
        <a href="#" style="text-decoration:none;color:var(--text-secondary)">Pegawai</a>
        <i class="fas fa-chevron-right" style="font-size:9px"></i>
        <span>Peminjaman Kendaraan</span>
      </div>
      <div class="topbar-title">Peminjaman Kendaraan</div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i></div>
    </div>
  </div>

  <div class="content-grid">
    <!-- FORM INPUT -->
    <div class="form-card">
      <div class="form-header">
        <div class="form-header-title"><i class="fas fa-car-side"></i> Pinjam Kendaraan</div>
        <div style="font-size: 11px; opacity: 0.8;">Ajukan penggunaan kendaraan dinas</div>
      </div>
      <div class="form-body">
        <form action="{{ route('pegawai.peminjaman-kendaraan.store') }}" method="POST">
          @csrf
          <div class="form-group">
            <div class="form-label"><i class="fas fa-truck-pickup"></i> Kendaraan Tersedia</div>
            <select name="kode_barang" class="form-select" required>
              <option value="">-- Pilih Kendaraan --</option>
              @foreach($kendaraan as $k)
                <option value="{{ $k->kode_barang }}">{{ $k->nama_barang }} ({{ $k->merek }})</option>
              @endforeach
            </select>
          </div>
          <div class="input-row">
            <div class="form-group">
              <div class="form-label"><i class="fas fa-calendar-alt"></i> Tgl Pinjam</div>
              <input type="date" name="tanggal_peminjaman" class="form-input" id="tglPinjam" required>
            </div>
            <div class="form-group">
              <div class="form-label"><i class="fas fa-calendar-check"></i> Tgl Kembali</div>
              <input type="date" name="tanggal_pengembalian" class="form-input" id="tglKembali" required>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label"><i class="fas fa-map-marked-alt"></i> Tujuan Penggunaan</div>
            <textarea name="deskripsi_peruntukan" class="form-textarea" placeholder="Contoh: Operasional Monev ke Gorontalo Utara" required></textarea>
          </div>
          <button type="submit" class="submit-btn"><i class="fas fa-paper-plane"></i> Kirim Permintaan</button>
        </form>
      </div>
    </div>

    <!-- RIWAYAT LIST -->
    <div class="history-card">
      <div class="history-header">
        <div class="history-title"><i class="fas fa-history"></i> Riwayat Anda</div>
      </div>
      <div class="req-list">
        @forelse($riwayat as $item)
          <div class="req-card">
            <div class="req-card-top">
              <div style="display:flex; gap:12px">
                <div style="width:40px; height:40px; background:rgba(37,99,235,0.1); border-radius:10px; display:grid; place-items:center; color:var(--primary)">
                  <i class="fas fa-car"></i>
                </div>
                <div>
                  <div class="req-card-name">{{ $item->nama_barang }}</div>
                  <div style="font-size:11px; color:var(--text-secondary)">{{ $item->merek }} | {{ $item->kode_barang }}</div>
                </div>
              </div>
              <div class="status-badge {{ $item->status }}">
                {{ str_replace('_', ' ', $item->status) }}
              </div>
            </div>
            <div class="req-card-meta">
              <div class="meta-item">
                <div class="meta-label">Jadwal</div>
                <div class="meta-value">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</div>
              </div>
              <div class="meta-item">
                <div class="meta-label">Tujuan</div>
                <div class="meta-value">{{ Str::limit($item->deskripsi_peruntukan, 25) }}</div>
              </div>
            </div>
            <div class="req-card-footer">
              <button class="card-btn detail" onclick="showDetail({{ $item->id }})"><i class="fas fa-eye"></i> Detail</button>
              
              @if($item->status == 'pending')
                <button class="card-btn cancel" onclick="cancelRequest({{ $item->id }})"><i class="fas fa-xmark"></i> Batalkan</button>
              @endif

              @if($item->surat_bast_path)
                <a href="{{ asset('storage/'.$item->surat_bast_path) }}" target="_blank" class="card-btn download"><i class="fas fa-file-download"></i> Surat</a>
              @endif
            </div>
          </div>
        @empty
          <div style="text-align:center; padding: 40px; color:var(--text-secondary)">
            <i class="fas fa-inbox fa-3x" style="opacity:0.2"></i>
            <p style="margin-top:10px">Belum ada riwayat peminjaman.</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</main>

<script>
  function cancelRequest(id) {
    if(confirm('Yakin ingin membatalkan permintaan ini?')) {
      fetch(`/pegawai/peminjaman-kendaraan/${id}/cancel`, {
        method: 'DELETE',
        headers: { 
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      }).then(() => location.reload());
    }
  }

  // Set min date
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('tglPinjam').min = today;
  document.getElementById('tglKembali').min = today;
  document.getElementById('tglPinjam').addEventListener('change', function() {
    document.getElementById('tglKembali').min = this.value;
  });
</script>
</body>
</html>