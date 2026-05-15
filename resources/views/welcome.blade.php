<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wireframe - Dashboard Admin Aset Tetap</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Styling Khusus Wireframe */
    .wireframe-box { border: 2px dashed #cbd5e1; background-color: #f8fafc; }
    .wireframe-solid { border: 2px solid #94a3b8; background-color: #ffffff; }
    .wireframe-input { border: 1px solid #94a3b8; background-color: #f1f5f9; }
    
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
  </style>
</head>
<body class="h-full bg-gray-50 text-gray-800 font-sans flex">

  <!-- SIDEBAR WIREFRAME -->
  <aside class="w-[240px] hidden md:flex flex-col border-r-2 border-gray-300 bg-white h-screen fixed left-0 top-0 p-6 overflow-y-auto z-50">
    <div class="flex items-center gap-3 mb-10">
      <div class="w-10 h-10 wireframe-box rounded flex items-center justify-center text-[10px] text-gray-400">Logo</div>
      <div class="font-bold text-xl text-gray-800">SIPANDU</div>
    </div>
    
    <div class="mb-4">
      <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Peran Aktif</div>
      <div class="wireframe-input px-3 py-2 rounded-lg text-center font-bold text-sm text-gray-700">Admin Aset Tetap</div>
    </div>

    <nav class="flex flex-col gap-2 flex-1 mt-4">
      <div class="p-3 wireframe-solid bg-gray-200 rounded-lg text-gray-800 font-bold text-sm flex items-center gap-3"><span class="w-4 h-4 bg-gray-400 rounded"></span> Menu 1</div>
      <div class="p-3 wireframe-input rounded-lg text-gray-600 font-bold text-sm flex items-center gap-3"><span class="w-4 h-4 bg-gray-300 rounded"></span> Menu 2</div>
      <div class="p-3 wireframe-input rounded-lg text-gray-600 font-bold text-sm flex items-center gap-3"><span class="w-4 h-4 bg-gray-300 rounded"></span> Menu 3</div>
      <div class="p-3 wireframe-input rounded-lg text-gray-600 font-bold text-sm flex items-center gap-3"><span class="w-4 h-4 bg-gray-300 rounded"></span> Menu 4</div>
      <div class="p-3 wireframe-input rounded-lg text-gray-600 font-bold text-sm flex items-center gap-3"><span class="w-4 h-4 bg-gray-300 rounded"></span> Menu 5</div>
      <div class="p-3 wireframe-input rounded-lg text-gray-600 font-bold text-sm flex items-center gap-3"><span class="w-4 h-4 bg-gray-300 rounded"></span> Menu 6</div>
    </nav>

    <div class="mt-auto pt-4 border-t border-gray-300">
      <div class="p-3 wireframe-input rounded-lg text-gray-600 font-bold text-sm flex items-center justify-center gap-2">
        <span class="w-4 h-4 bg-gray-300 rounded"></span> Keluar
      </div>
    </div>
  </aside>

  <!-- MAIN CONTENT WIREFRAME -->
  <main class="flex-1 md:ml-[240px] flex flex-col min-h-screen">
    
    <!-- TOPBAR -->
    <header class="h-16 bg-white border-b-2 border-gray-300 px-8 flex items-center justify-between sticky top-0 z-40">
      <div>
        <h1 class="text-xl font-bold text-gray-800">Dashboard Aset Tetap</h1>
        <p class="text-xs text-gray-500 font-bold">Ringkasan data inventaris dan aktivitas peminjaman</p>
      </div>
      <div class="flex items-center gap-4">
        <div class="wireframe-input px-4 py-2 rounded-xl text-sm font-bold text-gray-600 flex items-center gap-2">
          <span class="w-4 h-4 bg-gray-300 rounded"></span> 15 Mei 2026
        </div>
      </div>
    </header>

    <!-- CONTENT -->
    <div class="p-8 flex-1">
      
      <!-- STATS GRID -->
      <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mb-10">
        <!-- Card 1 (Span 2) -->
        <div class="md:col-span-2 wireframe-solid bg-white p-6 rounded-2xl shadow-sm transition-transform hover:-translate-y-1">
          <div class="w-12 h-12 wireframe-box rounded-xl mb-4 flex items-center justify-center text-xs text-gray-400">Icon</div>
          <div class="text-3xl font-bold text-gray-800 mb-1">842</div>
          <div class="text-xs font-bold text-gray-500 uppercase">Total Item Aset Tetap</div>
        </div>

        <!-- Card 2 (Span 2) -->
        <div class="md:col-span-2 wireframe-solid bg-white p-6 rounded-2xl shadow-sm transition-transform hover:-translate-y-1">
          <div class="w-12 h-12 wireframe-box rounded-xl mb-4 flex items-center justify-center text-xs text-gray-400">Icon</div>
          <div class="text-3xl font-bold text-gray-800 mb-1">124</div>
          <div class="text-xs font-bold text-gray-500 uppercase">Total Transaksi Masuk</div>
        </div>

        <!-- Card 3 (Span 2) -->
        <div class="md:col-span-2 wireframe-solid bg-white p-6 rounded-2xl shadow-sm transition-transform hover:-translate-y-1">
          <div class="w-12 h-12 wireframe-box rounded-xl mb-4 flex items-center justify-center text-xs text-gray-400">Icon</div>
          <div class="text-3xl font-bold text-gray-800 mb-1">28</div>
          <div class="text-xs font-bold text-gray-500 uppercase">Barang Sedang Dipinjam</div>
        </div>

        <!-- Card 4 (Span 3) -->
        <div class="md:col-span-3 wireframe-solid bg-white p-6 rounded-2xl shadow-sm transition-transform hover:-translate-y-1">
          <div class="w-12 h-12 wireframe-box rounded-xl mb-4 flex items-center justify-center text-xs text-gray-400">Icon</div>
          <div class="text-3xl font-bold text-gray-800 mb-1">5</div>
          <div class="text-xs font-bold text-gray-500 uppercase">Kendaraan Sedang Dipinjam</div>
        </div>

        <!-- Card 5 (Span 3) -->
        <div class="md:col-span-3 border-2 border-gray-500 bg-gray-100 p-6 rounded-2xl shadow-sm transition-transform hover:-translate-y-1">
          <div class="w-12 h-12 border-2 border-gray-400 bg-white rounded-xl mb-4 flex items-center justify-center text-xs text-gray-600">Icon</div>
          <div class="text-3xl font-bold text-gray-900 mb-1">12</div>
          <div class="text-xs font-bold text-gray-700 uppercase">Verifikasi Pengembalian Pending</div>
        </div>
      </div>

      <!-- RECENT ACTIVITY SECTION -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
          <span class="w-5 h-5 border-2 border-gray-600 bg-gray-300 rounded-full inline-block"></span> 
          Menunggu Verifikasi Pengembalian (12)
        </h2>
        <span class="text-sm font-bold text-gray-600 cursor-pointer flex items-center gap-1">
          Lihat Semua <span>→</span>
        </span>
      </div>

      <!-- Table Container -->
      <div class="wireframe-solid rounded-2xl bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead class="bg-gray-200 border-b-2 border-gray-400">
              <tr>
                <th class="p-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Peminjam</th>
                <th class="p-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Aset / Barang</th>
                <th class="p-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Tgl. Dikembalikan</th>
                <th class="p-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Kondisi</th>
                <th class="p-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="p-4 text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody>
              
              <!-- Row 1 -->
              <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="p-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 wireframe-solid rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">B</div>
                    <div>
                      <div class="font-bold text-sm text-gray-800">Budi Santoso</div>
                      <div class="text-[11px] text-gray-500 mt-0.5">NIP: 19801234567890</div>
                    </div>
                  </div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-sm text-gray-800">Laptop Asus ROG</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">Kode Pinjam: PJ-001</div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-sm text-gray-800">15 Mei 2026</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">2 jam yang lalu</div>
                </td>
                <td class="p-4">
                  <span class="text-sm font-bold text-gray-700 flex items-center gap-1">
                    <span class="w-3 h-3 bg-gray-400 rounded-full inline-block"></span> Baik
                  </span>
                </td>
                <td class="p-4">
                  <span class="border border-gray-400 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">Pending</span>
                </td>
                <td class="p-4">
                  <button class="bg-gray-300 border-2 border-gray-400 px-4 py-2 rounded-lg text-xs font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-500 rounded-sm"></span> Verifikasi
                  </button>
                </td>
              </tr>

              <!-- Row 2 -->
              <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="p-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 wireframe-solid rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">S</div>
                    <div>
                      <div class="font-bold text-sm text-gray-800">Siti Aminah</div>
                      <div class="text-[11px] text-gray-500 mt-0.5">NIP: 19851234567890</div>
                    </div>
                  </div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-sm text-gray-800">Kamera DSLR Canon</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">Kode Pinjam: PJ-042</div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-sm text-gray-800">14 Mei 2026</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">1 hari yang lalu</div>
                </td>
                <td class="p-4">
                  <span class="text-sm font-bold text-gray-800 flex items-center gap-1">
                    <span class="w-3 h-3 border-2 border-gray-600 rounded-full inline-block"></span> Rusak Ringan
                  </span>
                </td>
                <td class="p-4">
                  <span class="border border-gray-400 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">Pending</span>
                </td>
                <td class="p-4">
                  <button class="bg-gray-300 border-2 border-gray-400 px-4 py-2 rounded-lg text-xs font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-500 rounded-sm"></span> Verifikasi
                  </button>
                </td>
              </tr>

              <!-- Row 3 -->
              <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="p-4">
                  <div class="flex items-center gap-3">
                    <div class="w-10 h-10 wireframe-solid rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">A</div>
                    <div>
                      <div class="font-bold text-sm text-gray-800">Ahmad Yani</div>
                      <div class="text-[11px] text-gray-500 mt-0.5">NIP: 19901234567890</div>
                    </div>
                  </div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-sm text-gray-800">Proyektor Epson</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">Kode Pinjam: PJ-011</div>
                </td>
                <td class="p-4">
                  <div class="font-bold text-sm text-gray-800">12 Mei 2026</div>
                  <div class="text-[11px] text-gray-500 mt-0.5">3 hari yang lalu</div>
                </td>
                <td class="p-4">
                  <span class="text-sm font-bold text-gray-800 flex items-center gap-1">
                    <span class="w-3 h-3 border-2 border-gray-600 rounded-full inline-block bg-gray-200"></span> Hilang
                  </span>
                </td>
                <td class="p-4">
                  <span class="border border-gray-400 bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">Pending</span>
                </td>
                <td class="p-4">
                  <button class="bg-gray-300 border-2 border-gray-400 px-4 py-2 rounded-lg text-xs font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 bg-gray-500 rounded-sm"></span> Verifikasi
                  </button>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>

    </div>
  </main>
</body>
</html>