<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIPANDU - Manajemen API Key</title>
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
      --danger: #e03131;
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8f9fc; color: var(--text); }
    .main { margin-left: var(--sidebar-w); display: flex; flex-direction: column; min-height: 100vh; }
    .topbar { display: flex; justify-content: space-between; align-items: center; padding: 20px 32px; background: #fff; border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50; }
    .page-title { font-size: 20px; font-weight: 700; }
    .page-sub { font-size: 13px; color: var(--muted); margin-top: 2px; }
    .topbar-right { display: flex; align-items: center; gap: 12px; }
    .avatar-top { width: 38px; height: 38px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 14px; cursor: pointer; }
    .content { padding: 28px 32px; flex: 1; }

    /* ALERTS */
    .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

    /* KEY NEW — WARNING */
    .key-warning { background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; padding: 18px 22px; margin-bottom: 20px; }
    .key-warning .icon { color: #d97706; font-size: 20px; }
    .key-row { background: #0f172a; border-radius: 10px; margin-top: 12px; padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
    .key-row code { color: #4ade80; font-size: 15px; font-weight: 700; letter-spacing: 1px; word-break: break-all; }
    .btn-copy { background: transparent; border: 1px solid #334155; color: #e2e8f0; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; transition: .2s; font-family: inherit; }
    .btn-copy:hover { background: #1e293b; }

    /* TOOLBAR */
    .table-toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .count-card { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 20px; }
    .stat-chip { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 12px 20px; min-width: 130px; }
    .stat-chip .num { font-size: 20px; font-weight: 700; }
    .stat-chip .lbl { font-size: 12px; color: var(--muted); }
    .text-green { color: #2f9e44; } .text-gray { color: #6b7280; } .text-red { color: var(--danger); }

    .btn-add { display: flex; align-items: center; gap: 8px; background: var(--primary); color: #fff; border: none; border-radius: 8px; padding: 10px 18px; font-size: 14px; font-weight: 600; cursor: pointer; transition: .2s; font-family: inherit; }
    .btn-add:hover { background: #2f4ac7; }

    /* TABLE */
    .table-card { background: var(--card-bg); border-radius: 14px; border: 1px solid var(--border); overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    thead th { text-align: left; padding: 12px 20px; font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; background: #f9fafb; border-bottom: 1px solid var(--border); }
    tbody tr { transition: background .15s; }
    tbody tr:hover { background: #f9fafb; }
    tbody td { padding: 14px 20px; font-size: 13px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .td-sub { font-size: 12px; color: var(--muted); margin-top: 2px; }
    code.prefix { background: #f1f3f5; border-radius: 6px; padding: 3px 8px; font-size: 12px; }

    /* BADGES */
    .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .b-active { background: #dcfce7; color: #166534; }
    .b-expired { background: #fee2e2; color: #991b1b; }
    .b-inactive { background: #f3f4f6; color: #4b5563; }
    .scope-chip { background: #eef2ff; color: #3b5bdb; border-radius: 6px; padding: 2px 8px; font-size: 11px; font-weight: 600; margin: 2px; display: inline-block; }

    /* ACTIONS */
    .action-group { display: flex; gap: 6px; align-items: center; }
    .btn-action { background: none; border: 1px solid var(--border); border-radius: 6px; padding: 6px 10px; font-size: 12px; font-weight: 600; cursor: pointer; transition: .2s; display: inline-flex; align-items: center; gap: 4px; font-family: inherit; }
    .btn-action.rotate { color: var(--primary); }
    .btn-action.rotate:hover { background: var(--primary-light); border-color: var(--primary); }
    .btn-action.toggle { color: #4b5563; }
    .btn-action.toggle:hover { background: #f3f4f6; }
    .btn-action.delete { color: var(--danger); }
    .btn-action.delete:hover { background: #fee2e2; border-color: var(--danger); }

    /* MODAL */
    .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.35); z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .modal-overlay.open { display: flex; }
    .modal { background: #fff; border-radius: 16px; padding: 24px 32px; width: 480px; max-width: 95vw; box-shadow: 0 20px 60px rgba(0,0,0,0.15); animation: slideUp .25s ease; }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .modal-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
    .modal-title i { cursor: pointer; color: var(--muted); }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--text); }
    .form-group input, .form-group select { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 8px; font-family: inherit; font-size: 13px; outline: none; transition: .2s; }
    .form-group input:focus, .form-group select:focus { border-color: var(--primary); }
    .help-text { font-size: 11px; color: var(--muted); margin-top: 4px; display: block; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .modal-actions { display: flex; gap: 10px; margin-top: 24px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--border); }
    .btn-save { padding: 10px 20px; border: none; border-radius: 8px; background: var(--primary); color: #fff; font-weight: 600; cursor: pointer; font-family: inherit; }
    .btn-cancel { padding: 10px 20px; border: 1px solid var(--border); border-radius: 8px; background: #fff; color: var(--text); font-weight: 600; cursor: pointer; font-family: inherit; }

    /* SCOPES CHECKBOX */
    .scope-box { border: 1px solid var(--border); border-radius: 8px; padding: 12px 14px; max-height: 200px; overflow-y: auto; }
    .scope-check { display: flex; align-items: center; gap: 8px; padding: 5px 4px; font-size: 13px; cursor: pointer; border-radius: 6px; transition: .15s; }
    .scope-check:hover { background: #f8f9fc; }
    .scope-check.all { font-weight: 700; color: var(--primary); border-bottom: 1px solid var(--border); padding-bottom: 10px; margin-bottom: 4px; }
    .scope-check input { accent-color: var(--primary); width: 15px; height: 15px; cursor: pointer; }

    .hint { font-size: 12px; color: var(--muted); margin-top: 16px; line-height: 1.7; }
    .hint i { color: var(--primary); margin-right: 6px; }

    .empty { text-align: center; color: var(--muted); padding: 40px 0; }
    .empty i { font-size: 32px; display: block; margin-bottom: 10px; opacity: .4; }

    @media (max-width: 768px) {
      .main { margin-left: 0; }
      .topbar { padding: 16px; padding-top: 70px; }
      .content { padding: 16px; }
      table { min-width: 640px; }
      .form-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

@include('partials.sidebar')

<div class="main">
  <div class="topbar">
    <div>
      <div class="page-title">Manajemen API Key</div>
      <div class="page-sub">Autentikasi endpoint provider SIPANDU — BPMP Provinsi Gorontalo</div>
    </div>
    {{-- <div class="topbar-right">
      <div class="avatar-top">{{ substr(Auth::user()->name ?? 'SA', 0, 2) }}</div>
    </div> --}}
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Key hasil create/rotate --}}
    @if(session('new_key'))
      <div class="key-warning">
        <div style="display:flex; gap:12px; align-items:flex-start;">
          <i class="fas fa-exclamation-triangle icon"></i>
          <div style="flex:1;">
            <strong>Simpan API Key berikut sekarang!</strong><br>
            <span style="font-size:13px; color:#92400e;">Key hanya ditampilkan sekali ini saja. Setelah halaman ini ditutup, key tidak dapat dilihat lagi.</span>
            <div class="key-row">
              <code id="newKey">{{ session('new_key') }}</code>
              <button class="btn-copy" onclick="copyKey()"><i class="fas fa-copy"></i> Salin</button>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- Statistik --}}
    <div class="count-card">
      <div class="stat-chip"><div class="num">{{ $keys->count() }}</div><div class="lbl">Total Keys</div></div>
      <div class="stat-chip"><div class="num text-green">{{ $keys->where('is_active', true)->count() }}</div><div class="lbl">Aktif</div></div>
      <div class="stat-chip"><div class="num text-gray">{{ $keys->where('is_active', false)->count() }}</div><div class="lbl">Nonaktif</div></div>
      <div class="stat-chip"><div class="num text-red">{{ $keys->sum(fn($k) => $k->is_expired ? 1 : 0) }}</div><div class="lbl">Kedaluwarsa</div></div>
    </div>

    <div class="table-toolbar">
      <div style="font-size:13px; color:var(--muted);">
        <i class="fas fa-info-circle" style="color:var(--primary);"></i> Setiap key berlaku <strong>90 hari</strong>. Gunakan tombol <i class="fas fa-sync-alt"></i> untuk memperpanjang & mengganti key.
      </div>
      <button class="btn-add" onclick="openModal()"><i class="fas fa-plus"></i> Buat Key Baru</button>
    </div>

    <div class="table-card">
      <table>
        <thead>
          <tr>
            <th>Label</th>
            <th>Key</th>
            <th>Scopes</th>
            <th>Status</th>
            <th>Kedaluwarsa</th>
            <th>Terakhir Digunakan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($keys as $key)
            <tr>
              <td>
                <strong>{{ $key->label }}</strong>
                @if ($key->created_by)
                  <div class="td-sub">dibuat oleh User #{{ $key->created_by }}</div>
                @endif
              </td>
              <td><code class="prefix">{{ $key->key_prefix }}****</code></td>
              <td>
                @foreach (collect($key->scopes ?? ['*'])->filter()->all() as $scope)
                  <span class="scope-chip">{{ $scope }}</span>
                @endforeach
              </td>
              <td>
                <span class="badge {{ !$key->is_active ? 'b-inactive' : ($key->is_expired ? 'b-expired' : 'b-active') }}">
                  {{ $key->status_label }}
                </span>
              </td>
              <td>
                {{ $key->expires_at ? $key->expires_at->format('d/m/Y H:i') : '-' }}
                @if ($key->is_expired)
                  <div class="td-sub text-red">sudah kedaluwarsa</div>
                @endif
              </td>
              <td>
                @if ($key->last_used_at)
                  {{ $key->last_used_at->diffForHumans() }}
                  @if ($key->last_used_ip)
                    <div class="td-sub">{{ $key->last_used_ip }}</div>
                  @endif
                @else
                  <span style="color:var(--muted);">belum pernah</span>
                @endif
              </td>
              <td>
                <div class="action-group">
                  <button class="btn-action rotate" title="Edit label & scope" onclick="openEditModal('{{ $key->id }}', '{{ addslashes($key->label) }}', {{ json_encode($key->scopes ?? ['*']) }}, {{ $key->is_active ? 'true' : 'false' }})">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                  <form method="POST" action="{{ route('api-keys.rotate', $key) }}" style="display:inline;"
                        onsubmit="return confirm('Rotate key &quot;{{ $key->label }}&quot;? Key lama langsung tidak berlaku.')">
                    @csrf
                    <button class="btn-action rotate" title="Rotate (key baru, berlaku 90 hari)">
                      <i class="fas fa-sync-alt"></i> Rotate
                    </button>
                  </form>
                  <form method="POST" action="{{ route('api-keys.toggle', $key) }}" style="display:inline;">
                    @csrf @method('PATCH')
                    <button class="btn-action toggle" title="{{ $key->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                      <i class="fas fa-{{ $key->is_active ? 'pause' : 'play' }}"></i>
                    </button>
                  </form>
                  <form method="POST" action="{{ route('api-keys.destroy', $key) }}" style="display:inline;"
                        onsubmit="return confirm('Hapus key &quot;{{ $key->label }}&quot;? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf @method('DELETE')
                    <button class="btn-action delete" title="Hapus"><i class="fas fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="empty">
                <i class="fas fa-key"></i> Belum ada API Key. Klik "Buat Key Baru" untuk memulai.
            </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="hint">
      <i class="fas fa-shield-halved"></i> API Key tersimpan sebagai <strong>hash SHA-256</strong> di database — key asli tidak pernah dilihat lagi setelah dibuat.<br>
      <i class="fas fa-clock"></i> Otomatis kedaluwarsa dalam 90 hari dan akan ditolak middleware <code>VerifyApiKey</code>.<br>
      <i class="fas fa-tag"></i> Gunakan label untuk mengidentifikasi client pemakai (contoh: <em>SAKTI</em>, <em>Dashboard Monitoring</em>).
    </div>
  </div>
</div>

{{-- Modal Buat Key --}}
@php
$scopeOptions = [
    'aset-tetap'             => 'Aset Tetap (master & transaksi)',
    'persediaan'             => 'Persediaan (master & transaksi)',
    'mutasi-barang'          => 'Mutasi Barang',
    'peminjaman-barang'      => 'Peminjaman Barang',
    'peminjaman-kendaraan'   => 'Peminjaman Kendaraan',
    'peminjaman-gedung'      => 'Peminjaman Gedung',
    'permintaan-persediaan'  => 'Permintaan Persediaan',
    'pengembalian-barang'    => 'Pengembalian Barang',
    'pengembalian-kendaraan' => 'Pengembalian Kendaraan',
    'kerusakan'              => 'Kerusakan',
];
@endphp

<div class="modal-overlay" id="modalCreate">
  <div class="modal">
    <div class="modal-title">
      Buat API Key Baru
      <i class="fas fa-times" onclick="closeModal()"></i>
    </div>
    <form method="POST" action="{{ route('api-keys.store') }}">
      @csrf
      <div class="form-group">
        <label>Label / Nama Client</label>
        <input type="text" name="label" placeholder="contoh: SAKTI, Monitoring, Dashboard" required maxlength="100">
        <span class="help-text">Identifikasi siapa yang memakai key ini.</span>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Kedaluwarsa</label>
          <input type="date" name="expires_at" value="{{ now()->addDays(90)->format('Y-m-d') }}">
          <span class="help-text">Default 90 hari.</span>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="is_active">
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
          </select>
        </div>
      </div>
      <div class="form-group">
          <label>Hak Akses (Scopes)</label>
          <div class="scope-box">
            <label class="scope-check all">
              <input type="checkbox" name="scope_all" value="1" checked onchange="toggleScopeList()"> Semua Endpoint (*)
            </label>
            <div id="scope_list" style="display:none;">
              @foreach ($scopeOptions as $scope => $name)
                <label class="scope-check">
                  <input type="checkbox" name="scopes[]" value="{{ $scope }}"> {{ $name }}
                </label>
              @endforeach
            </div>
          </div>
          <span class="help-text">Tidak perlu ubah jika ingin akses semua endpoint.</span>
        </div>
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
        <button type="submit" class="btn-save"><i class="fas fa-plus"></i> Buat Key</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Edit Key --}}
<div class="modal-overlay" id="modalEdit">
  <div class="modal">
    <div class="modal-title">
      Edit API Key
      <i class="fas fa-times" onclick="closeEditModal()"></i>
    </div>
    <form method="POST" action="" id="editForm">
      @csrf @method('PUT')
      <div class="form-group">
        <label>Label / Nama Client</label>
        <input type="text" name="label" id="editLabel" required maxlength="100">
      </div>
      <div class="form-group">
        <label>Hak Akses (Scopes)</label>
        <div class="scope-box">
          <label class="scope-check all">
            <input type="checkbox" name="scope_all" id="edit_scope_all" value="1" onchange="toggleEditScopeList()"> Semua Endpoint (*)
          </label>
          <div id="edit_scope_list" style="display:none;">
            @foreach ($scopeOptions as $scope => $name)
              <label class="scope-check">
                <input type="checkbox" name="scopes[]" value="{{ $scope }}"> {{ $name }}
              </label>
            @endforeach
          </div>
        </div>
        <span class="help-text">Centang endpoint mana yang boleh diakses key ini.</span>
      </div>
      <div class="form-group">
        <label>Status</label>
        <select name="is_active" id="editActive">
          <option value="1">Aktif</option>
          <option value="0">Nonaktif</option>
        </select>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-save"><i class="fas fa-save"></i> Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openModal()  { document.getElementById('modalCreate').classList.add('open'); }
function closeModal() { document.getElementById('modalCreate').classList.remove('open'); }
document.getElementById('modalCreate').addEventListener('click', e => {
  if (e.target === e.currentTarget) closeModal();
});

function toggleScopeList() {
  const all = document.getElementById('scope_all');
  const list = document.getElementById('scope_list');
  list.style.display = all.checked ? 'none' : 'block';
  if (all.checked) {
    list.querySelectorAll('input[type=checkbox]').forEach(c => c.checked = false);
  }
}

function openEditModal(id, label, scopes, isActive) {
  document.getElementById('editForm').action = '/superadmin/api-keys/' + id;
  document.getElementById('editLabel').value = label;
  document.getElementById('editActive').value = isActive ? 1 : 0;

  const isAll = scopes.includes('*');
  document.getElementById('edit_scope_all').checked = isAll;
  const list = document.getElementById('edit_scope_list');
  list.style.display = isAll ? 'none' : 'block';
  list.querySelectorAll('input[type=checkbox]').forEach(c => {
    c.checked = !isAll && scopes.includes(c.value);
  });

  document.getElementById('modalEdit').classList.add('open');
}
function toggleEditScopeList() {
  const all = document.getElementById('edit_scope_all');
  const list = document.getElementById('edit_scope_list');
  list.style.display = all.checked ? 'none' : 'block';
  if (all.checked) {
    list.querySelectorAll('input[type=checkbox]').forEach(c => c.checked = false);
  }
}
function closeEditModal() { document.getElementById('modalEdit').classList.remove('open'); }
document.getElementById('modalEdit').addEventListener('click', e => {
  if (e.target === e.currentTarget) closeEditModal();
});

function copyKey() {
  const text = document.getElementById('newKey').textContent.trim();
  navigator.clipboard.writeText(text).then(() => alert('API Key berhasil disalin ke clipboard!'));
}
</script>
</body>
</html>