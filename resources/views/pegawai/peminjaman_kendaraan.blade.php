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
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --bg: #f0f4ff;
        --sidebar-bg: #0f172a;
        --sidebar-width: 260px;
        --card-bg: #ffffff;
        --text-primary: #0f172a;
        --text-secondary: #64748b;
        --border: #e2e8f0;
        --radius: 16px;
        --shadow: 0 4px 24px rgba(37,99,235,0.08);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text-primary); display: flex; min-height: 100vh; }

    .main { margin-left: var(--sidebar-width); flex: 1; padding: 0 28px 40px; min-width: 0; transition: margin-left 0.3s ease; }

    .topbar { display: flex; align-items: center; justify-content: space-between; padding: 20px 0; position: sticky; top: 0; z-index: 50; background: var(--bg); }
    .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }

    .content-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 24px; align-items: start; }

    .form-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); overflow: hidden; position: sticky; top: 90px; }
    .form-header { padding: 24px; background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); color: #fff; }
    .form-body { padding: 20px 24px; }

    .form-group { margin-bottom: 16px; }
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; margin-bottom: 7px; display: flex; align-items: center; gap: 6px; }
    .form-input, .form-select, .form-textarea { width: 100%; padding: 10px 13px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 13px; outline: none; transition: 0.2s; }
    .form-input:focus { border-color: var(--primary); }
    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

    .submit-btn { width: 100%; padding: 13px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: #fff; border: none; border-radius: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; }
    .submit-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(37,99,235,0.3); }

    .history-card { background: var(--card-bg); border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow); }
    .history-header { padding: 20px 22px; border-bottom: 1px solid var(--border); }
    .req-list { padding: 18px 22px; display: flex; flex-direction: column; gap: 14px; }
    .req-card { border: 1.5px solid var(--border); border-radius: 14px; overflow: hidden; transition: 0.2s; }
    .status-badge { font-size: 10px; font-weight: 700; padding: 4px 10px; border-radius: 7px; text-transform: uppercase; }
    .status-badge.pending { background: rgba(245,158,11,0.1); color: var(--warning); }
    .status-badge.disetujui { background: rgba(16,185,129,0.1); color: var(--success); }
    .status-badge.ditolak { background: rgba(239,68,68,0.1); color: var(--danger); }

    .card-btn { flex: 1; padding: 9px; border-radius: 8px; font-size: 12px; font-weight: 600; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; transition: 0.2s; }
    .card-btn.detail { background: rgba(37,99,235,0.08); color: var(--primary); }
    .card-btn.cancel { background: rgba(239,68,68,0.08); color: var(--danger); }

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
            <div class="topbar-title">Peminjaman Kendaraan</div>
        </div>
    </div>

    <div class="content-grid">
        <!-- FORM INPUT -->
        <div class="form-card">
            <div class="form-header">
                <div class="form-header-title"><i class="fas fa-car-side"></i> Pinjam Kendaraan</div>
            </div>
            <div class="form-body">
                <form action="{{ route('pegawai.peminjaman-kendaraan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="form-label">Pilih Kendaraan <span style="color:var(--danger)">*</span></div>
                        <select name="kode_barang" class="form-select" id="kendaraanSelect" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($kendaraan as $k)
                                <option value="{{ $k->kode_barang }}" data-nup="{{ $k->nup }}" data-merek="{{ $k->merek }}">
                                    {{ $k->nama_barang }} ({{ $k->merek }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-row">
                        <div class="form-group">
                            <div class="form-label">NUP</div>
                            <input type="text" id="nupInput" class="form-input" readonly style="background:#f8fafc" placeholder="-">
                        </div>
                        <div class="form-group">
                            <div class="form-label">Merek</div>
                            <input type="text" id="merekInput" class="form-input" readonly style="background:#f8fafc" placeholder="-">
                        </div>
                    </div>
                    <div class="input-row">
                        <div class="form-group">
                            <div class="form-label">Jumlah Unit</div>
                            <input type="number" name="jumlah" class="form-input" value="1" min="1" required>
                        </div>
                        <div class="form-group">
                            <div class="form-label">Tgl Pinjam</div>
                            <input type="date" name="tanggal_peminjaman" class="form-input" id="tglPinjam" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label">Tgl Kembali</div>
                        <input type="date" name="tanggal_pengembalian" class="form-input" id="tglKembali" required>
                    </div>
                    <div class="form-group">
                        <div class="form-label">Tujuan Penggunaan</div>
                        <textarea name="deskripsi_peruntukan" class="form-textarea" placeholder="Contoh: Operasional Monev..." required></textarea>
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
                        <div style="padding:15px; display:flex; justify-content:space-between; align-items:flex-start">
                            <div>
                                <div style="font-size:14px; font-weight:700">{{ $item->nama_barang }}</div>
                                <div style="font-size:11px; color:var(--text-secondary)">{{ $item->merek }} | {{ $item->kode_barang }}</div>
                            </div>
                            <div class="status-badge {{ $item->status }}">{{ str_replace('_', ' ', $item->status) }}</div>
                        </div>
                        <div style="padding:12px 15px; background:#f8faff; border-top:1px solid #eef1ff; display:flex; gap:20px">
                            <div>
                                <div style="font-size:10px; color:#94a3b8; font-weight:700">JADWAL</div>
                                <div style="font-size:12px; font-weight:600">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div style="padding:10px 15px; border-top:1px solid #eef1ff; display:flex; gap:8px">
                            <button class="card-btn detail" onclick="showDetail({{ $item->id }})"><i class="fas fa-eye"></i> Detail</button>
                            @if($item->status == 'pending')
                                <button class="card-btn cancel" onclick="cancelRequest({{ $item->id }})"><i class="fas fa-xmark"></i> Batalkan</button>
                            @endif
                            @if($item->surat_bast_path)
                                <a href="{{ asset('storage/'.$item->surat_bast_path) }}" target="_blank" class="card-btn detail" style="background:var(--primary); color:#fff"><i class="fas fa-file-download"></i> Surat</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:40px; color:var(--text-secondary)">Belum ada riwayat.</div>
                @endforelse
            </div>
        </div>
    </div>
</main>

<!-- MODAL DETAIL -->
<div id="detailModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#fff; width:90%; max-width:500px; border-radius:16px; padding:24px;">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px">
            <h3 style="font-weight:700; color:var(--primary)">Detail Peminjaman</h3>
            <button onclick="closeModal()" style="border:none; background:none; cursor:pointer"><i class="fas fa-times"></i></button>
        </div>
        <div id="modalLoading" style="text-align:center; padding:20px;"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
        <div id="modalContent" style="display:none">
            <p style="font-size:13px; margin-bottom:10px"><strong>Barang:</strong> <span id="detNama"></span></p>
            <p style="font-size:13px; margin-bottom:10px"><strong>Merek/NUP:</strong> <span id="detMerek"></span></p>
            <p style="font-size:13px; margin-bottom:10px"><strong>Tujuan:</strong> <span id="detTujuan"></span></p>
            <button onclick="closeModal()" class="submit-btn" style="margin-top:20px">Tutup</button>
        </div>
    </div>
</div>

<script>
    // FUNGSI DETAIL (Diluar DOM agar bisa dipanggil onclick)
    function showDetail(id) {
        const modal = document.getElementById('detailModal');
        modal.style.display = 'flex';
        document.getElementById('modalLoading').style.display = 'block';
        document.getElementById('modalContent').style.display = 'none';

        fetch(`/pegawai/peminjaman-kendaraan/${id}/show`)
            .then(r => r.json())
            .then(res => {
                if(res.success) {
                    document.getElementById('detNama').innerText = res.data.nama_barang;
                    document.getElementById('detMerek').innerText = `${res.data.merek} | NUP: ${res.data.nup || '-'}`;
                    document.getElementById('detTujuan').innerText = res.data.deskripsi_peruntukan;
                    document.getElementById('modalLoading').style.display = 'none';
                    document.getElementById('modalContent').style.display = 'block';
                }
            }).catch(() => alert('Gagal memuat data.'));
    }

    function closeModal() { document.getElementById('detailModal').style.display = 'none'; }

    function cancelRequest(id) {
        if(confirm('Batalkan permintaan?')) {
            fetch(`/pegawai/peminjaman-kendaraan/${id}/cancel`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }

    // LISTENER (Didalam DOM agar aman dari error null)
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('kendaraanSelect');
        if(select) {
            select.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                document.getElementById('nupInput').value = opt.getAttribute('data-nup') || '-';
                document.getElementById('merekInput').value = opt.getAttribute('data-merek') || '-';
            });
        }

        const today = new Date().toISOString().split('T')[0];
        if(document.getElementById('tglPinjam')) document.getElementById('tglPinjam').min = today;
    });
</script>
</body>
</html>