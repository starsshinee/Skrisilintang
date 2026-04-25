<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Kerusakan - Admin Sarana Prasarana</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  /* ===== RESET & BASE ===== */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  /* ===== MODAL OVERLAY ===== */
  .modal-overlay {
    position: fixed; inset: 0;
    background: rgba(15, 23, 42, 0.45);
    backdrop-filter: blur(2px);
    display: none; align-items: center; justify-content: center;
    z-index: 200; padding: 20px;
  }
  .modal-overlay.open { display: flex; }

  .modal {
    background: #fff;
    border-radius: 18px;
    width: 520px; max-width: 100%;
    max-height: 92vh; overflow-y: auto;
    box-shadow: 0 24px 64px rgba(0,0,0,.18);
    animation: modalIn .2s ease;
  }
  @keyframes modalIn {
    from { opacity:0; transform: translateY(12px) scale(.98); }
    to   { opacity:1; transform: translateY(0) scale(1); }
  }

  .modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
    position: sticky; top: 0; background: #fff; z-index: 1;
    border-radius: 18px 18px 0 0;
  }
  .modal-title { font-size: 16px; font-weight: 700; color: var(--text-primary); }

  .close-btn {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: 1px solid var(--border);
    background: var(--bg);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 18px; line-height: 1;
    color: var(--text-secondary); transition: all .15s;
  }
  .close-btn:hover { background: var(--border); color: var(--text-primary); }

  /* ===== FORM ===== */
  form { padding: 20px 24px; }

  .form-group { margin-bottom: 16px; }
  .form-label {
    font-size: 11.5px; font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .05em;
    margin-bottom: 7px; display: block;
  }
  .form-input, .form-select, .form-textarea {
    width: 100%; padding: 10px 13px;
    border: 1px solid var(--border);
    border-radius: 10px;
    font-family: inherit; font-size: 13.5px;
    outline: none; transition: border .15s, box-shadow .15s;
    background: #fff; color: var(--text-primary);
  }
  .form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(59,107,218,.12);
  }
  .form-textarea { min-height: 80px; resize: vertical; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  /* File upload */
  .file-input-wrapper { position: relative; }
  .file-input-wrapper input[type=file] { position: absolute; left: -9999px; }
  .file-input-label {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    padding: 10px 13px;
    border: 1.5px dashed var(--border);
    border-radius: 10px; cursor: pointer;
    font-size: 13px; color: var(--text-secondary);
    transition: all .15s;
  }
  .file-input-label:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-light);
  }
  .photo-preview {
    width: 80px; height: 80px; object-fit: cover;
    border-radius: 10px; margin-top: 10px;
    border: 1px solid var(--border); display: none;
  }

  /* Modal footer */
  .modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid var(--border);
    background: var(--bg); border-radius: 0 0 18px 18px;
  }
  .btn-cancel {
    padding: 9px 18px;
    border: 1px solid var(--border); border-radius: 10px;
    font-family: inherit; font-size: 13.5px; font-weight: 500;
    cursor: pointer; background: #fff; color: var(--text-secondary);
    transition: all .15s;
  }
  .btn-cancel:hover { background: var(--bg); }
  .btn-save {
    padding: 9px 20px;
    background: var(--primary); color: #fff;
    border: none; border-radius: 10px;
    font-family: inherit; font-size: 13.5px; font-weight: 700;
    cursor: pointer; transition: background .15s;
  }
  .btn-save:hover { background: #3058c0; }

  /* ===== DETAIL MODAL ===== */
  .detail-body { padding: 8px 24px 4px; }
  .detail-row {
    display: flex; gap: 16px; align-items: flex-start;
    padding: 11px 0; border-bottom: 1px solid var(--border);
    font-size: 13.5px;
  }
  .detail-row:last-child { border-bottom: none; }
  .detail-label {
    font-size: 11.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .05em; color: var(--text-secondary);
    min-width: 120px; padding-top: 2px;
  }
  .detail-value { color: var(--text-primary); flex: 1; line-height: 1.5; }
  .detail-photo {
    width: 100%; max-height: 200px; object-fit: cover;
    border-radius: 10px; margin-top: 4px;
    border: 1px solid var(--border);
  }

  /* ===== PHOTO THUMBNAIL in table ===== */
  .photo-thumbnail {
    width: 38px; height: 38px; border-radius: 8px;
    object-fit: cover; border: 1px solid var(--border);
    cursor: pointer; transition: opacity .15s;
  }
  .photo-thumbnail:hover { opacity: .8; }
  .photo-empty-icon {
    width: 38px; height: 38px; border-radius: 8px;
    border: 1.5px dashed var(--border);
    display: flex; align-items: center; justify-content: center;
    color: var(--text-tertiary, #94a3b8);
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <div class="topbar">
    <span class="topbar-title">Data Kerusakan</span>
    <div class="topbar-right">
      <div class="notif-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#64748B">
          <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span class="notif-dot"></span>
      </div>
      <span class="date-text">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</span>
      <a href="{{ route('logout') }}" class="btn-keluar">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
          <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5-5-5zm-5 11H5V5h7V3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h7v-2z"/>
        </svg>
        Keluar
      </a>
    </div>
  </div>

  <div class="content">

    {{-- FLASH MESSAGES --}}
    @if (session('success'))
    <div class="alert-flash alert-success-flash" role="alert">
      <div style="display:flex;align-items:center;gap:8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
          <path d="M20 6L9 17l-5-5"/>
        </svg>
        {{ session('success') }}
      </div>
      <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:18px;color:inherit;line-height:1;">&times;</button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert-flash alert-error-flash" role="alert">
      <div style="display:flex;align-items:center;gap:8px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
          <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
        </svg>
        {{ session('error') }}
      </div>
      <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:18px;color:inherit;line-height:1;">&times;</button>
    </div>
    @endif

    {{-- TOOLBAR --}}
    <div class="toolbar">
      <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <circle cx="11" cy="11" r="8"/>
          <path d="m21 21-4.35-4.35"/>
        </svg>
        <input class="search-input" type="text" placeholder="Cari nama atau kode barang..."
               id="searchInput" oninput="filterTable()">
      </div>
      <button class="btn-primary" onclick="openModal('create')">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
          <path d="M12 5v14m-7-7h14"/>
        </svg>
        Tambah Data
      </button>
    </div>

    {{-- TABLE --}}
    <div class="table-card">
      @if($kerusakans->count() > 0)
      <table id="kerusakanTable">
        <thead>
          <tr>
            <th style="width:48px;">No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th style="width:64px;">NUP</th>
            <th>Kondisi</th>
            <th style="width:64px;">Foto</th>
            <th>Lokasi</th>
            <th style="width:110px;">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach($kerusakans as $kerusakan)
          <tr data-id="{{ $kerusakan->id }}"
              data-kode="{{ strtolower($kerusakan->kode_barang) }}"
              data-nama="{{ strtolower($kerusakan->nama_barang) }}">
            <td>{{ $loop->iteration }}</td>
            <td style="white-space:nowrap;">
              {{ \Carbon\Carbon::parse($kerusakan->tanggal_input)->format('d/m/Y') }}
            </td>
            <td>{{ $kerusakan->nama_barang }}</td>
            <td>
              <span style="font-family:monospace;font-size:12.5px;font-weight:700;
                           background:var(--bg);padding:3px 8px;border-radius:6px;
                           border:1px solid var(--border);color:var(--text-secondary);">
                {{ $kerusakan->kode_barang }}
              </span>
            </td>
            <td>{{ $kerusakan->nup }}</td>
            <td>
              @php
                $kondisiClass = match($kerusakan->kondisi) {
                  'Baik'         => 'badge-baik',
                  'Rusak Ringan' => 'badge-rusak-ringan',
                  'Rusak Sedang' => 'badge-rusak-sedang',
                  'Rusak Berat'  => 'badge-rusak-berat',
                  'Hancur'       => 'badge-hancur',
                  default        => 'badge-rusak-sedang'
                };
              @endphp
              <span class="status-badge {{ $kondisiClass }}">{{ $kerusakan->kondisi }}</span>
            </td>
            <td>
              @if($kerusakan->foto)
                @if(file_exists(public_path('storage/' . $kerusakan->foto)))
                  <img src="{{ asset('storage/' . $kerusakan->foto) }}"
                       alt="Foto {{ $kerusakan->nama_barang }}"
                       class="photo-thumbnail"
                       onclick="viewPhoto('{{ asset('storage/' . $kerusakan->foto) }}')"
                       onerror="this.style.display='none'">
                @else
                  <button class="act-btn photo" title="Lihat Foto"
                          onclick="viewPhoto('{{ asset('storage/' . $kerusakan->foto) }}')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                      <rect x="3" y="3" width="18" height="18" rx="2"/>
                      <circle cx="8.5" cy="8.5" r="1.5"/>
                      <path d="m21 15-5-5L5 21"/>
                    </svg>
                  </button>
                @endif
              @else
                <div class="photo-empty-icon" title="Tidak ada foto">
                  <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <path d="m21 15-5-5L5 21"/>
                  </svg>
                </div>
              @endif
            </td>
            <td>{{ $kerusakan->lokasi }}</td>
            <td>
              <div class="action-btns">
                <button class="act-btn view" title="Lihat Detail"
                        onclick="openModal('view', {{ $kerusakan->id }})">
                  <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </button>
                <button class="act-btn" title="Edit"
                        style="color:#10b981;border-color:#a7f3d0;background:#ecfdf5;"
                        onclick="openModal('edit', {{ $kerusakan->id }})">
                  <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </button>
                <button class="act-btn del" title="Hapus"
                        onclick="confirmDelete({{ $kerusakan->id }})">
                  <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="empty-state">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" width="48" height="48">
          <path d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2zm0 0V9a2 2 0 0 0 2-2h2a2 2 0 0 1 2 2v10m-6 0a2 2 0 0 0 2 2h.01"/>
        </svg>
        <h3>Belum ada data kerusakan</h3>
        <p>Tambahkan data kerusakan barang pertama Anda</p>
      </div>
      @endif
    </div>

    {{-- PAGINATION --}}
    @if($kerusakans->hasPages())
    <div style="margin-top:24px;display:flex;justify-content:center;">
      {{ $kerusakans->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif

  </div>{{-- end .content --}}
</main>

{{-- ============================================================ --}}
{{--  MODAL TAMBAH / EDIT                                         --}}
{{-- ============================================================ --}}
<div class="modal-overlay" id="crudModal">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title" id="modalTitle">Tambah Data Kerusakan</h3>
      <button class="close-btn" onclick="closeModal()" aria-label="Tutup">&times;</button>
    </div>

    <form id="crudForm" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="id" id="kerusakanId">

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="tanggal_input">Tanggal Input</label>
          <input type="date" name="tanggal_input" id="tanggal_input"
                 class="form-input" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="kondisi">Kondisi</label>
          <select name="kondisi" id="kondisi" class="form-select" required>
            <option value="">Pilih kondisi</option>
            <option value="Baik">Baik</option>
            <option value="Rusak Ringan">Rusak Ringan</option>
            <option value="Rusak Sedang">Rusak Sedang</option>
            <option value="Rusak Berat">Rusak Berat</option>
            <option value="Hancur">Hancur</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="nama_barang">Nama Barang</label>
        <input type="text" name="nama_barang" id="nama_barang"
               class="form-input" placeholder="Contoh: Meja Belajar" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="kode_barang">Kode Barang</label>
          <input type="text" name="kode_barang" id="kode_barang"
                 class="form-input" placeholder="MB-0012" required>
        </div>
        <div class="form-group">
          <label class="form-label" for="nup">NUP</label>
          <input type="text" name="nup" id="nup"
                 class="form-input" placeholder="001" required>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="lokasi">Lokasi</label>
        <input type="text" name="lokasi" id="lokasi"
               class="form-input" placeholder="Contoh: Ruang Kelas 3A" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="deskripsi">
          Deskripsi <span style="font-weight:400;text-transform:none;letter-spacing:0;color:var(--text-tertiary,#94a3b8)">(opsional)</span>
        </label>
        <textarea name="deskripsi" id="deskripsi"
                  class="form-input form-textarea"
                  placeholder="Keterangan kondisi kerusakan..."></textarea>
      </div>

      <div class="form-group">
        <label class="form-label">Foto</label>
        <div class="file-input-wrapper">
          <input type="file" name="foto" id="foto" accept="image/*">
          <label for="foto" class="file-input-label">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <rect x="3" y="3" width="18" height="18" rx="2"/>
              <circle cx="8.5" cy="8.5" r="1.5"/>
              <path d="m21 15-5-5L5 21"/>
            </svg>
            Pilih foto (JPG, PNG — maks 2 MB)
          </label>
        </div>
        <img id="photoPreview" class="photo-preview" alt="Preview foto">
      </div>

      <div class="modal-footer" id="modalFooter">
        <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
        <button type="submit" class="btn-save" id="submitBtn">Simpan Data</button>
      </div>
    </form>
  </div>
</div>

{{-- ============================================================ --}}
{{--  MODAL DETAIL                                                 --}}
{{-- ============================================================ --}}
<div class="modal-overlay" id="detailModal">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title">Detail Data Kerusakan</h3>
      <button class="close-btn" onclick="closeDetailModal()" aria-label="Tutup">&times;</button>
    </div>

    <div class="detail-body" id="detailContent">
      <div class="detail-row">
        <span class="detail-label">Tanggal Input</span>
        <span class="detail-value" id="detailTanggal"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Nama Barang</span>
        <span class="detail-value" id="detailNama"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Kode Barang</span>
        <span class="detail-value" id="detailKode"
              style="font-family:monospace;font-weight:700;font-size:13px;"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">NUP</span>
        <span class="detail-value" id="detailNup"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Kondisi</span>
        <span class="detail-value" id="detailKondisi"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Lokasi</span>
        <span class="detail-value" id="detailLokasi"></span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Deskripsi</span>
        <span class="detail-value" id="detailDeskripsi"
              style="color:var(--text-secondary);"></span>
      </div>
      <div class="detail-row" id="detailFotoContainer"></div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn-cancel" onclick="closeDetailModal()">Tutup</button>
    </div>
  </div>
</div>

{{-- ============================================================ --}}
{{--  JAVASCRIPT                                                   --}}
{{-- ============================================================ --}}
<script>
let currentKerusakanId = null;
let isEditMode = false;

/* ---------- Search / Filter ---------- */
function filterTable() {
  const q = document.getElementById('searchInput').value.toLowerCase().trim();
  document.querySelectorAll('#tableBody tr').forEach(row => {
    const kode = row.dataset.kode || '';
    const nama = row.dataset.nama || '';
    row.style.display = (!q || kode.includes(q) || nama.includes(q)) ? '' : 'none';
  });
}

/* ---------- Open CRUD Modal ---------- */
function openModal(action, id = null) {
  const modal   = document.getElementById('crudModal');
  const title   = document.getElementById('modalTitle');
  const form    = document.getElementById('crudForm');
  const preview = document.getElementById('photoPreview');

  form.reset();
  preview.style.display = 'none';

  if (action === 'create') {
    title.textContent = 'Tambah Data Kerusakan';
    form.action = '{{ route("adminsarpras.kerusakan.store") }}';
    document.getElementById('submitBtn').textContent = 'Simpan Data';
    isEditMode = false;

  } else if (action === 'edit' && id) {
    currentKerusakanId = id;
    title.textContent = 'Edit Data Kerusakan';
    form.action = '{{ route("adminsarpras.kerusakan.update.ajax", ":id") }}'.replace(':id', id);
    document.getElementById('kerusakanId').value = id;
    document.getElementById('submitBtn').textContent = 'Update Data';
    loadKerusakanData(id);
    isEditMode = true;

  } else if (action === 'view' && id) {
    openDetailModal(id);
    return;
  }

  modal.classList.add('open');
}

function closeModal() {
  document.getElementById('crudModal').classList.remove('open');
}

/* ---------- Load data into edit form ---------- */
function loadKerusakanData(id) {
  fetch(`/admin/sarpras/kerusakan/${id}/edit`)
    .then(r => r.json())
    .then(data => {
      document.getElementById('tanggal_input').value = data.tanggal_input;
      document.getElementById('nama_barang').value   = data.nama_barang;
      document.getElementById('kode_barang').value   = data.kode_barang;
      document.getElementById('nup').value           = data.nup;
      document.getElementById('kondisi').value       = data.kondisi;
      document.getElementById('lokasi').value        = data.lokasi;
      document.getElementById('deskripsi').value     = data.deskripsi || '';

      if (data.foto) {
        const p = document.getElementById('photoPreview');
        p.src = data.foto_url;
        p.style.display = 'block';
      }
    })
    .catch(err => console.error('Load error:', err));
}

/* ---------- Detail Modal ---------- */
function openDetailModal(id) {
  fetch(`/admin/sarpras/kerusakan/${id}`)
    .then(r => r.json())
    .then(data => {
      document.getElementById('detailTanggal').textContent =
        new Date(data.tanggal_input).toLocaleDateString('id-ID', {
          day: '2-digit', month: 'long', year: 'numeric'
        });
      document.getElementById('detailNama').textContent    = data.nama_barang;
      document.getElementById('detailKode').textContent    = data.kode_barang;
      document.getElementById('detailNup').textContent     = data.nup;
      document.getElementById('detailKondisi').innerHTML   =
        `<span class="status-badge ${getKondisiClass(data.kondisi)}">${data.kondisi}</span>`;
      document.getElementById('detailLokasi').textContent  = data.lokasi;
      document.getElementById('detailDeskripsi').textContent = data.deskripsi || '—';

      const fotoEl = document.getElementById('detailFotoContainer');
      fotoEl.innerHTML = data.foto
        ? `<span class="detail-label">Foto</span>
           <span class="detail-value">
             <img src="${data.foto_url}" class="detail-photo" alt="Foto kerusakan">
           </span>`
        : `<span class="detail-label">Foto</span>
           <span class="detail-value" style="color:var(--text-secondary)">Tidak ada foto</span>`;

      document.getElementById('detailModal').classList.add('open');
    })
    .catch(err => console.error('Detail error:', err));
}

function closeDetailModal() {
  document.getElementById('detailModal').classList.remove('open');
}

function getKondisiClass(kondisi) {
  const map = {
    'Baik'         : 'badge-baik',
    'Rusak Ringan' : 'badge-rusak-ringan',
    'Rusak Sedang' : 'badge-rusak-sedang',
    'Rusak Berat'  : 'badge-rusak-berat',
    'Hancur'       : 'badge-hancur',
  };
  return map[kondisi] || 'badge-rusak-sedang';
}

/* ---------- Delete ---------- */
function confirmDelete(id) {
  if (!confirm('Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) return;
  const form = document.createElement('form');
  form.method = 'POST';
  form.action = `/admin/sarpras/kerusakan/${id}`;
  form.innerHTML = `@csrf @method('DELETE')`;
  document.body.appendChild(form);
  form.submit();
}

/* ---------- View photo ---------- */
function viewPhoto(url) {
  window.open(url, '_blank');
}

/* ---------- Photo preview ---------- */
document.getElementById('foto').addEventListener('change', function (e) {
  const file = e.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    const p = document.getElementById('photoPreview');
    p.src = e.target.result;
    p.style.display = 'block';
  };
  reader.readAsDataURL(file);
});

/* ---------- Form submit (edit via AJAX) ---------- */
document.getElementById('crudForm').addEventListener('submit', function (e) {
  if (!isEditMode) return; // biarkan form submit biasa untuk create
  e.preventDefault();

  const formData = new FormData(this);

  fetch(this.action, {
    method : 'POST',
    body   : formData,
    headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      location.reload();
    } else {
      alert('Error: ' + (data.message || 'Terjadi kesalahan'));
    }
  })
  .catch(err => {
    console.error('Submit error:', err);
    alert('Gagal menyimpan data. Periksa koneksi dan coba lagi.');
  });
});

/* ---------- Auto-hide flash alerts ---------- */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.alert-flash').forEach(el => {
    setTimeout(() => {
      el.style.transition = 'opacity .4s';
      el.style.opacity = '0';
      setTimeout(() => el.remove(), 400);
    }, 5000);
  });
});

/* ---------- Close modal on backdrop click ---------- */
document.getElementById('crudModal').addEventListener('click', function (e) {
  if (e.target === this) closeModal();
});
document.getElementById('detailModal').addEventListener('click', function (e) {
  if (e.target === this) closeDetailModal();
});
</script>

</body>
</html>