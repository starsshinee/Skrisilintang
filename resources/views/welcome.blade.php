<!doctype html>
<html lang="id" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIBMN - BPMP Provinsi Gorontalo</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
  <script>
tailwind.config = {
  theme: {
    extend: {
      fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
      colors: {
        navy: { 50:'#eef3ff',100:'#d9e4ff',200:'#bccfff',300:'#8eaeff',400:'#5a82ff',500:'#3355ff',600:'#1a2f9b',700:'#0f1f6e',800:'#0a1550',900:'#060d33',950:'#030718' },
      }
    }
  }
}
</script>
  <style>
html, body { height: 100%; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
.app-root { height: 100%; overflow-y: auto; overflow-x: hidden; }
@keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes slideRight { from { opacity:0; transform:translateX(-40px); } to { opacity:1; transform:translateX(0); } }
@keyframes countUp { from { opacity:0; transform:scale(0.5); } to { opacity:1; transform:scale(1); } }
@keyframes pulse2 { 0%,100%{ transform:scale(1); } 50%{ transform:scale(1.05); } }
.anim-fade-up { animation: fadeUp 0.7s ease forwards; }
.anim-fade-in { animation: fadeIn 0.5s ease forwards; }
.anim-slide-r { animation: slideRight 0.6s ease forwards; }
.anim-count { animation: countUp 0.5s ease forwards; }
.delay-1 { animation-delay: 0.1s; opacity:0; }
.delay-2 { animation-delay: 0.2s; opacity:0; }
.delay-3 { animation-delay: 0.3s; opacity:0; }
.delay-4 { animation-delay: 0.4s; opacity:0; }
.delay-5 { animation-delay: 0.5s; opacity:0; }
.delay-6 { animation-delay: 0.6s; opacity:0; }
.card-hover { transition: all 0.3s ease; }
.card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(10,21,80,0.12); }
.btn-primary { background: linear-gradient(135deg, #1a2f9b 0%, #3355ff 100%); transition: all 0.3s ease; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,47,155,0.35); }
.glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); }
.sidebar-item { transition: all 0.2s ease; border-left: 3px solid transparent; }
.sidebar-item:hover, .sidebar-item.active { background: rgba(51,85,255,0.1); border-left-color: #3355ff; color: #1a2f9b; }
.stat-card { position: relative; overflow: hidden; }
.stat-card::before { content:''; position:absolute; top:-50%; right:-50%; width:100%; height:100%; background:radial-gradient(circle, rgba(51,85,255,0.08) 0%, transparent 70%); }
.carousel-track { display:flex; transition: transform 0.5s ease; }
.facilities-scroll { -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none; }
.facilities-scroll::-webkit-scrollbar { display: none; }
.toast { animation: fadeUp 0.4s ease; }
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f5f9; }
::-webkit-scrollbar-thumb { background: #bccfff; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #8eaeff; }
.hero-bg { background: linear-gradient(135deg, #060d33 0%, #0f1f6e 40%, #1a2f9b 70%, #3355ff 100%); }
.table-row:hover { background: #f0f4ff; }
.badge { display:inline-flex; align-items:center; padding:2px 10px; border-radius:9999px; font-size:0.75rem; font-weight:600; }
.modal-overlay { background: rgba(6,13,51,0.6); backdrop-filter: blur(4px); }
</style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full bg-slate-50">
  <div class="app-root" id="appRoot">
   <!-- ============ LANDING PAGE ============ -->
   <div id="landingPage">
    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300" style="background:transparent;">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 md:h-20">
       <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur">
         <svg width="24" height="24" viewbox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#3355ff" /><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#5a82ff" /><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#5a82ff" /><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#3355ff" />
         </svg>
        </div>
        <div>
         <span id="navTitle" class="text-white font-bold text-lg tracking-tight">SIBMN</span> <span class="text-blue-200 text-xs block leading-none">BPMP Gorontalo</span>
        </div>
       </div>
       <div class="hidden md:flex items-center gap-8">
        <a href="#hero" class="text-blue-100 hover:text-white text-sm font-medium transition">Beranda</a> <a href="#fitur" class="text-blue-100 hover:text-white text-sm font-medium transition">Fitur</a> <a href="#statistik" class="text-blue-100 hover:text-white text-sm font-medium transition">Statistik</a> <a href="#fasilitas" class="text-blue-100 hover:text-white text-sm font-medium transition">Fasilitas</a> <a href="#kontak" class="text-blue-100 hover:text-white text-sm font-medium transition">Kontak</a>
       </div>
       <div class="flex items-center gap-3">
        <button onclick="showLogin()" class="text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-white/10 transition">Masuk</button> <button onclick="showRegister()" class="btn-primary text-white text-sm font-semibold px-5 py-2 rounded-lg">Daftar</button> <button class="md:hidden text-white" onclick="toggleMobileMenu()"><i data-lucide="menu" class="w-6 h-6"></i></button>
       </div>
      </div>
     </div><!-- Mobile Menu -->
     <div id="mobileMenu" class="hidden md:hidden bg-navy-900/95 backdrop-blur-lg pb-4 px-4">
      <a href="#hero" class="block py-2 text-blue-100 text-sm" onclick="toggleMobileMenu()">Beranda</a> <a href="#fitur" class="block py-2 text-blue-100 text-sm" onclick="toggleMobileMenu()">Fitur</a> <a href="#statistik" class="block py-2 text-blue-100 text-sm" onclick="toggleMobileMenu()">Statistik</a> <a href="#fasilitas" class="block py-2 text-blue-100 text-sm" onclick="toggleMobileMenu()">Fasilitas</a> <a href="#kontak" class="block py-2 text-blue-100 text-sm" onclick="toggleMobileMenu()">Kontak</a>
     </div>
    </nav><!-- Hero -->
    <section id="hero" class="hero-bg relative overflow-hidden" style="min-height: 600px; padding-top: 100px; padding-bottom: 80px;">
     <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-400/8 rounded-full blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/5 rounded-full blur-3xl"></div>
     </div>
     <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-12">
      <div class="flex-1 text-center lg:text-left">
       <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 mb-6 anim-fade-up delay-1">
        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span> <span class="text-blue-200 text-xs font-medium">Sistem Aktif &amp; Terintegrasi</span>
       </div>
       <h1 id="heroTitle" class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 anim-fade-up delay-2">Sistem Informasi<br><span class="bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent">Barang Milik Negara</span></h1>
       <p id="heroSubtitle" class="text-blue-200 text-lg md:text-xl max-w-xl mb-8 leading-relaxed anim-fade-up delay-3">Kelola dan monitoring BMN pada Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo secara digital, transparan, dan akuntabel.</p>
       <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start anim-fade-up delay-4">
        <button onclick="showLogin()" class="btn-primary text-white font-semibold px-8 py-3.5 rounded-xl flex items-center justify-center gap-2 text-base"> <i data-lucide="log-in" class="w-5 h-5"></i> Masuk Sekarang </button> <a href="#fitur" class="border border-white/30 text-white font-semibold px-8 py-3.5 rounded-xl flex items-center justify-center gap-2 text-base hover:bg-white/10 transition"> <i data-lucide="info" class="w-5 h-5"></i> Pelajari Fitur </a>
       </div>
       <div class="flex items-center gap-8 mt-10 justify-center lg:justify-start anim-fade-up delay-5">
        <div class="text-center">
         <div class="text-2xl font-bold text-white">
          1,247
         </div>
         <div class="text-blue-300 text-xs">
          Total Aset
         </div>
        </div>
        <div class="w-px h-10 bg-white/20"></div>
        <div class="text-center">
         <div class="text-2xl font-bold text-white">
          89
         </div>
         <div class="text-blue-300 text-xs">
          Pegawai
         </div>
        </div>
        <div class="w-px h-10 bg-white/20"></div>
        <div class="text-center">
         <div class="text-2xl font-bold text-white">
          12
         </div>
         <div class="text-blue-300 text-xs">
          Fasilitas
         </div>
        </div>
       </div>
      </div>
      <div class="flex-1 hidden lg:flex justify-center anim-fade-up delay-5">
       <div class="relative">
        <div class="w-[400px] h-[300px] bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6">
         <div class="flex items-center gap-2 mb-4">
          <div class="w-3 h-3 rounded-full bg-red-400"></div>
          <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
          <div class="w-3 h-3 rounded-full bg-green-400"></div><span class="text-white/50 text-xs ml-2">Dashboard BMN</span>
         </div>
         <div class="grid grid-cols-2 gap-3 mb-4">
          <div class="bg-white/10 rounded-lg p-3">
           <div class="text-cyan-300 text-xs">
            Aset Tetap
           </div>
           <div class="text-white font-bold text-xl">
            856
           </div>
          </div>
          <div class="bg-white/10 rounded-lg p-3">
           <div class="text-green-300 text-xs">
            Persediaan
           </div>
           <div class="text-white font-bold text-xl">
            391
           </div>
          </div>
         </div>
         <div class="bg-white/10 rounded-lg p-3 flex items-center justify-between">
          <div>
           <div class="text-yellow-300 text-xs">
            Sarana Prasarana
           </div>
           <div class="text-white font-bold">
            127 Unit
           </div>
          </div>
          <div class="flex gap-1">
           <div class="w-2 h-8 bg-blue-400/60 rounded"></div>
           <div class="w-2 h-12 bg-blue-400/80 rounded"></div>
           <div class="w-2 h-6 bg-blue-400/40 rounded"></div>
           <div class="w-2 h-10 bg-blue-400/70 rounded"></div>
           <div class="w-2 h-14 bg-blue-400 rounded"></div>
          </div>
         </div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-32 h-20 bg-green-500/20 backdrop-blur rounded-xl border border-green-400/30 p-3 flex items-center gap-2">
         <div class="w-8 h-8 bg-green-500/30 rounded-full flex items-center justify-center"><i data-lucide="trending-up" class="w-4 h-4 text-green-300"></i>
         </div>
         <div>
          <div class="text-green-300 text-[10px]">
           Status
          </div>
          <div class="text-white text-xs font-bold">
           98.5% Baik
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </section><!-- Deskripsi Singkat -->
    <section class="py-16 bg-white">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center">
       <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
        <i data-lucide="shield-check" class="w-4 h-4 text-navy-600"></i> <span class="text-navy-700 text-sm font-semibold">Tentang SIBMN</span>
       </div>
       <h2 class="text-3xl font-bold text-navy-900 mb-4">Pengelolaan BMN yang Modern &amp; Transparan</h2>
       <p class="text-slate-600 leading-relaxed">SIBMN BPMP Gorontalo adalah sistem informasi terintegrasi untuk pencatatan, pemantauan, dan pengelolaan Barang Milik Negara. Sistem ini mendukung tata kelola aset yang akuntabel sesuai Peraturan Pemerintah No. 27 Tahun 2014 tentang Pengelolaan BMN, dengan fitur multi-peran untuk seluruh unit kerja di lingkungan BPMP Provinsi Gorontalo.</p>
      </div>
     </div>
    </section><!-- Fitur -->
    <section id="fitur" class="py-20 bg-slate-50">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
       <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
        <i data-lucide="layers" class="w-4 h-4 text-navy-600"></i> <span class="text-navy-700 text-sm font-semibold">Fitur Unggulan</span>
       </div>
       <h2 class="text-3xl md:text-4xl font-bold text-navy-900">Fitur Lengkap untuk Pengelolaan BMN</h2>
      </div>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
       <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4"><i data-lucide="package" class="w-6 h-6 text-navy-600"></i>
        </div>
        <h3 class="font-bold text-navy-900 text-lg mb-2">Pencatatan Persediaan</h3>
        <p class="text-slate-500 text-sm leading-relaxed">Kelola stok barang habis pakai, ATK, dan bahan operasional dengan pencatatan masuk-keluar yang akurat.</p>
       </div>
       <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4"><i data-lucide="building" class="w-6 h-6 text-indigo-600"></i>
        </div>
        <h3 class="font-bold text-navy-900 text-lg mb-2">Manajemen Sarana Prasarana</h3>
        <p class="text-slate-500 text-sm leading-relaxed">Monitoring kondisi gedung, ruangan, kendaraan dinas, dan fasilitas pendukung lainnya.</p>
       </div>
       <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
        <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4"><i data-lucide="landmark" class="w-6 h-6 text-cyan-600"></i>
        </div>
        <h3 class="font-bold text-navy-900 text-lg mb-2">Pengelolaan Aset Tetap</h3>
        <p class="text-slate-500 text-sm leading-relaxed">Inventarisasi tanah, bangunan, peralatan &amp; mesin, serta aset tetap lainnya sesuai standar SIMAK-BMN.</p>
       </div>
       <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
        <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4"><i data-lucide="file-check" class="w-6 h-6 text-emerald-600"></i>
        </div>
        <h3 class="font-bold text-navy-900 text-lg mb-2">Peminjaman &amp; Pengembalian</h3>
        <p class="text-slate-500 text-sm leading-relaxed">Sistem peminjaman aset oleh pegawai dengan tracking status dan riwayat lengkap.</p>
       </div>
       <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4"><i data-lucide="bar-chart-3" class="w-6 h-6 text-amber-600"></i>
        </div>
        <h3 class="font-bold text-navy-900 text-lg mb-2">Laporan &amp; Analitik</h3>
        <p class="text-slate-500 text-sm leading-relaxed">Generate laporan BMN otomatis, neraca aset, dan analisis kondisi barang secara real-time.</p>
       </div>
       <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
        <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4"><i data-lucide="users" class="w-6 h-6 text-rose-600"></i>
        </div>
        <h3 class="font-bold text-navy-900 text-lg mb-2">Multi-Role Access</h3>
        <p class="text-slate-500 text-sm leading-relaxed">Hak akses berbeda untuk Kepala BPMP, Kasubag, Admin Persediaan, Admin Sarpras, Admin Aset, dan Pegawai.</p>
       </div>
      </div>
     </div>
    </section><!-- Statistik -->
    <section id="statistik" class="py-20 hero-bg relative overflow-hidden">
     <div class="absolute inset-0">
      <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div>
     </div>
     <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
       <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 mb-4">
        <i data-lucide="activity" class="w-4 h-4 text-blue-300"></i> <span class="text-blue-200 text-sm font-semibold">Data Statistik</span>
       </div>
       <h2 class="text-3xl md:text-4xl font-bold text-white">Statistik BMN BPMP Gorontalo</h2>
      </div>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
       <div class="stat-card glass rounded-2xl p-6 text-center">
        <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><i data-lucide="database" class="w-7 h-7 text-blue-300"></i>
        </div>
        <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">
         1,247
        </div>
        <div class="text-blue-200 text-sm">
         Total Item BMN
        </div>
       </div>
       <div class="stat-card glass rounded-2xl p-6 text-center">
        <div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><i data-lucide="check-circle" class="w-7 h-7 text-green-300"></i>
        </div>
        <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">
         Rp 28.5M
        </div>
        <div class="text-blue-200 text-sm">
         Nilai Aset Terkelola
        </div>
       </div>
       <div class="stat-card glass rounded-2xl p-6 text-center">
        <div class="w-14 h-14 bg-yellow-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><i data-lucide="refresh-cw" class="w-7 h-7 text-yellow-300"></i>
        </div>
        <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">
         342
        </div>
        <div class="text-blue-200 text-sm">
         Transaksi Bulan Ini
        </div>
       </div>
       <div class="stat-card glass rounded-2xl p-6 text-center">
        <div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><i data-lucide="shield" class="w-7 h-7 text-purple-300"></i>
        </div>
        <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">
         98.5%
        </div>
        <div class="text-blue-200 text-sm">
         Kondisi Baik
        </div>
       </div>
      </div>
     </div>
    </section><!-- Fasilitas Carousel (tiket-style) -->
    <section id="fasilitas" class="py-16 md:py-20 bg-slate-50">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="rounded-3xl overflow-hidden bg-white border border-slate-100 shadow-xl">
       <div class="px-5 pt-6 pb-4 md:px-8 md:pt-8 md:pb-5 border-b border-slate-100/80">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5 mb-5">
         <div class="flex items-center gap-3 min-w-0">
          <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0 border border-blue-100/80">
           <i data-lucide="building-2" class="w-7 h-7 md:w-8 md:h-8 text-navy-600"></i>
          </div>
          <div>
           <h2 class="text-xl md:text-2xl font-bold text-navy-900 tracking-tight leading-tight">Fasilitas Unggulan</h2>
           <p class="text-slate-600 text-sm mt-1">BPMP Provinsi Gorontalo — sewa &amp; peminjaman untuk instansi dan umum</p>
          </div>
         </div>
         <div class="flex items-center gap-2 lg:gap-3 flex-wrap lg:flex-nowrap lg:justify-end">
          <span class="text-slate-600 text-sm font-medium whitespace-nowrap">Berakhir dalam</span>
          <div class="flex items-center gap-1 font-mono text-navy-900">
           <span id="facilitiesCdH" class="inline-flex min-w-[2.25rem] justify-center rounded-lg bg-navy-100 px-2 py-1.5 text-sm font-bold shadow-sm tabular-nums text-navy-900 border border-navy-200/60">00</span>
           <span class="font-bold text-slate-400">:</span>
           <span id="facilitiesCdM" class="inline-flex min-w-[2.25rem] justify-center rounded-lg bg-navy-100 px-2 py-1.5 text-sm font-bold shadow-sm tabular-nums text-navy-900 border border-navy-200/60">00</span>
           <span class="font-bold text-slate-400">:</span>
           <span id="facilitiesCdS" class="inline-flex min-w-[2.25rem] justify-center rounded-lg bg-navy-100 px-2 py-1.5 text-sm font-bold shadow-sm tabular-nums text-navy-900 border border-navy-200/60">00</span>
          </div>
         </div>
        </div>
        <div id="facilityChips" class="flex flex-wrap gap-2"></div>
       </div>
       <div class="relative px-3 pb-6 md:px-6 md:pb-8 pt-4 bg-slate-50/70">
        <button type="button" onclick="facilitiesScrollPrev()" class="absolute left-1 md:left-2 top-[42%] -translate-y-1/2 z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white shadow-lg flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-navy-700 transition border border-white/80 hidden sm:flex" aria-label="Sebelumnya">
         <i data-lucide="chevron-left" class="w-5 h-5 md:w-6 md:h-6"></i>
        </button>
        <div id="facilitiesCarouselScroll" class="facilities-scroll flex gap-3 md:gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory py-1 pl-1 pr-14 sm:pr-16 md:px-2"></div>
        <button type="button" onclick="facilitiesScrollNext()" class="absolute right-1 md:right-2 top-[42%] -translate-y-1/2 z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white shadow-lg flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-navy-700 transition border border-white/80" aria-label="Selanjutnya">
         <i data-lucide="chevron-right" class="w-5 h-5 md:w-6 md:h-6"></i>
        </button>
       </div>
      </div>
      <p class="text-center text-slate-500 text-sm mt-6 max-w-2xl mx-auto">Harga dapat berubah sesuai kebijakan. Hubungi Tata Usaha untuk jadwal dan persyaratan resmi.</p>
     </div>
    </section><!-- Demo Akun Login -->
    <section class="py-16 bg-slate-50">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-10">
       <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
        <i data-lucide="key" class="w-4 h-4 text-navy-600"></i> <span class="text-navy-700 text-sm font-semibold">Akun Demo</span>
       </div>
       <h2 class="text-3xl font-bold text-navy-900 mb-3">Coba Demo Setiap Peran</h2>
       <p class="text-slate-500">Gunakan akun demo berikut untuk mengeksplorasi fitur setiap role.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="demoAccountsGrid">
      </div>
     </div>
    </section><!-- Alamat & Kontak -->
    <section id="kontak" class="py-20 bg-white">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
       <div>
        <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
         <i data-lucide="map-pin" class="w-4 h-4 text-navy-600"></i> <span class="text-navy-700 text-sm font-semibold">Lokasi Kami</span>
        </div>
        <h2 class="text-3xl font-bold text-navy-900 mb-6">Hubungi BPMP Gorontalo</h2>
        <div class="space-y-5">
         <div class="flex items-start gap-4">
          <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="map-pin" class="w-5 h-5 text-navy-600"></i>
          </div>
          <div>
           <h4 class="font-semibold text-navy-900 text-sm">Alamat</h4>
           <p class="text-slate-500 text-sm">Jl. Prof. Dr. H. Aloei Saboe, Kel. Wongkaditi Timur, Kec. Kota Utara, Kota Gorontalo, Gorontalo 96128</p>
          </div>
         </div>
         <div class="flex items-start gap-4">
          <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="phone" class="w-5 h-5 text-navy-600"></i>
          </div>
          <div>
           <h4 class="font-semibold text-navy-900 text-sm">Telepon</h4>
           <p class="text-slate-500 text-sm">(0435) 821-555</p>
          </div>
         </div>
         <div class="flex items-start gap-4">
          <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="mail" class="w-5 h-5 text-navy-600"></i>
          </div>
          <div>
           <h4 class="font-semibold text-navy-900 text-sm">Email</h4>
           <p class="text-slate-500 text-sm">bpmp.gorontalo@kemdikbud.go.id</p>
          </div>
         </div>
         <div class="flex items-start gap-4">
          <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="clock" class="w-5 h-5 text-navy-600"></i>
          </div>
          <div>
           <h4 class="font-semibold text-navy-900 text-sm">Jam Operasional</h4>
           <p class="text-slate-500 text-sm">Senin - Jumat: 08.00 - 16.00 WITA</p>
          </div>
         </div>
        </div>
       </div>
       <div class="bg-slate-100 rounded-2xl overflow-hidden" style="height:350px;">
        <div class="w-full h-full bg-gradient-to-br from-navy-100 to-blue-100 flex items-center justify-center relative">
         <div class="text-center">
          <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-4">
           <i data-lucide="map" class="w-10 h-10 text-navy-600"></i>
          </div>
          <p class="text-navy-700 font-semibold">BPMP Provinsi Gorontalo</p>
          <p class="text-navy-500 text-sm mt-1">Kota Gorontalo, 96128</p>
         </div>
         <div class="absolute top-4 left-4 bg-white/80 backdrop-blur rounded-lg px-3 py-1.5 text-xs text-navy-600 font-medium">
          📍 0.5488° N, 123.0568° E
         </div>
        </div>
       </div>
      </div>
     </div>
    </section><!-- Footer -->
    <footer class="bg-navy-950 text-white py-12">
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8 mb-10">
       <div class="md:col-span-2">
        <div class="flex items-center gap-3 mb-4">
         <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
          <svg width="24" height="24" viewbox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#3355ff" /><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#5a82ff" /><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#5a82ff" /><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#3355ff" />
          </svg>
         </div>
         <div><span class="font-bold text-lg">SIBMN</span><span class="text-blue-300 text-xs block">BPMP Gorontalo</span>
         </div>
        </div>
        <p class="text-blue-200/70 text-sm leading-relaxed max-w-md">Sistem Informasi Barang Milik Negara Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo. Mendukung tata kelola aset yang transparan dan akuntabel.</p>
       </div>
       <div>
        <h4 class="font-semibold mb-4 text-sm">Menu</h4>
        <div class="space-y-2">
         <a href="#hero" class="block text-blue-200/70 text-sm hover:text-white transition">Beranda</a> <a href="#fitur" class="block text-blue-200/70 text-sm hover:text-white transition">Fitur</a> <a href="#statistik" class="block text-blue-200/70 text-sm hover:text-white transition">Statistik</a> <a href="#fasilitas" class="block text-blue-200/70 text-sm hover:text-white transition">Fasilitas</a>
        </div>
       </div>
       <div>
        <h4 class="font-semibold mb-4 text-sm">Tautan</h4>
        <div class="space-y-2">
         <a href="#" class="block text-blue-200/70 text-sm hover:text-white transition" target="_blank" rel="noopener noreferrer">Kemendikbud</a> <a href="#" class="block text-blue-200/70 text-sm hover:text-white transition" target="_blank" rel="noopener noreferrer">SIMAK-BMN</a> <a href="#" class="block text-blue-200/70 text-sm hover:text-white transition" target="_blank" rel="noopener noreferrer">DJKN</a>
        </div>
       </div>
      </div>
      <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
       <p class="text-blue-200/50 text-sm">© 2025 SIBMN BPMP Provinsi Gorontalo. Hak Cipta Dilindungi.</p>
       <div class="flex items-center gap-4">
        <span class="text-blue-200/50 text-xs">Dibangun dengan ❤️ untuk Pendidikan Indonesia</span>
       </div>
      </div>
     </div>
    </footer>
   </div><!-- END LANDING PAGE --> <!-- ============ AUTH MODALS ============ -->
   <div id="loginModal" class="fixed inset-0 z-[100] hidden">
    <div class="modal-overlay absolute inset-0" onclick="closeModals()"></div>
    <div class="relative flex items-center justify-center min-h-full p-4">
     <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 anim-fade-up relative">
      <button onclick="closeModals()" class="absolute top-4 right-4 w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center"><i data-lucide="x" class="w-5 h-5 text-slate-400"></i></button>
      <div class="text-center mb-6">
       <div class="w-14 h-14 bg-navy-100 rounded-2xl flex items-center justify-center mx-auto mb-3"><i data-lucide="log-in" class="w-7 h-7 text-navy-600"></i>
       </div>
       <h3 class="text-2xl font-bold text-navy-900">Masuk</h3>
       <p class="text-slate-500 text-sm mt-1">Masuk ke akun SIBMN Anda</p>
      </div>
      <form onsubmit="handleLogin(event)">
       <div class="mb-4">
        <label for="loginUser" class="block text-sm font-medium text-navy-800 mb-1.5">Username</label>
        <div class="relative">
         <i data-lucide="user" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i> <input id="loginUser" type="text" class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Masukkan username" required>
        </div>
       </div>
       <div class="mb-6">
        <label for="loginPass" class="block text-sm font-medium text-navy-800 mb-1.5">Password</label>
        <div class="relative">
         <i data-lucide="lock" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i> <input id="loginPass" type="password" class="w-full pl-10 pr-12 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Masukkan password" required> <button type="button" onclick="toggleLoginPassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-navy-600 transition"><i data-lucide="eye" id="loginPassIcon" class="w-5 h-5"></i></button>
        </div>
       </div>
       <div id="loginError" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-center gap-2">
        <i data-lucide="alert-circle" class="w-4 h-4 flex-shrink-0"></i><span></span>
       </div><button type="submit" id="loginBtn" class="w-full btn-primary text-white font-semibold py-3 rounded-xl text-sm">Masuk</button>
      </form>
      <p class="text-center text-sm text-slate-500 mt-4">Belum punya akun? <button onclick="closeModals();showRegister()" class="text-navy-600 font-semibold hover:underline">Daftar</button></p>
     </div>
    </div>
   </div>
   <div id="registerModal" class="fixed inset-0 z-[100] hidden">
    <div class="modal-overlay absolute inset-0" onclick="closeModals()"></div>
    <div class="relative flex items-center justify-center min-h-full p-4">
     <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 anim-fade-up relative" style="max-height:90%; overflow-y:auto;">
      <button onclick="closeModals()" class="absolute top-4 right-4 w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center z-10"><i data-lucide="x" class="w-5 h-5 text-slate-400"></i></button>
      <div class="text-center mb-6">
       <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3"><i data-lucide="user-plus" class="w-7 h-7 text-green-600"></i>
       </div>
       <h3 class="text-2xl font-bold text-navy-900">Registrasi</h3>
       <p class="text-slate-500 text-sm mt-1">Buat akun SIBMN baru (Demo)</p>
      </div>
      <form onsubmit="handleRegister(event)">
       <div class="mb-4">
        <label for="regName" class="block text-sm font-medium text-navy-800 mb-1.5">Nama Lengkap</label> <input id="regName" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Masukkan nama lengkap" required>
       </div>
       <div class="mb-4">
        <label for="regNIP" class="block text-sm font-medium text-navy-800 mb-1.5">NIP</label> <input id="regNIP" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Masukkan NIP" required>
       </div>
       <div class="mb-4">
        <label for="regUser" class="block text-sm font-medium text-navy-800 mb-1.5">Username</label> <input id="regUser" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Pilih username" required>
       </div>
       <div class="mb-4">
        <label for="regPass" class="block text-sm font-medium text-navy-800 mb-1.5">Password</label>
        <div class="relative">
         <input id="regPass" type="password" class="w-full pl-4 pr-12 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Buat password" required> <button type="button" onclick="toggleRegPassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-navy-600 transition"><i data-lucide="eye" id="regPassIcon" class="w-5 h-5"></i></button>
        </div>
       </div>
       <div class="mb-6">
        <label for="regRole" class="block text-sm font-medium text-navy-800 mb-1.5">Role</label> <select id="regRole" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white"> <option value="pegawai">Pegawai</option> <option value="admin_persediaan">Admin Persediaan</option> <option value="admin_sarpras">Admin Sarana Prasarana</option> <option value="admin_aset">Admin Aset Tetap</option> <option value="kasubag">Kasubag</option> <option value="kepala_bpmp">Kepala BPMP</option> <option value="superadmin">Super Admin</option> </select>
       </div>
       <div id="regSuccess" class="hidden mb-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm flex items-center gap-2">
        <i data-lucide="check-circle" class="w-4 h-4 flex-shrink-0"></i><span>Registrasi berhasil! Silakan login.</span>
       </div><button type="submit" class="w-full btn-primary text-white font-semibold py-3 rounded-xl text-sm">Daftar Sekarang</button>
      </form>
      <p class="text-center text-sm text-slate-500 mt-4">Sudah punya akun? <button onclick="closeModals();showLogin()" class="text-navy-600 font-semibold hover:underline">Masuk</button></p>
     </div>
    </div>
   </div><!-- ============ DASHBOARD ============ -->
   <div id="dashboardPage" class="hidden" style="height:100%;">
    <div class="flex" style="height:100%;">
     <!-- Sidebar -->
     <aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex-shrink-0 flex flex-col hidden lg:flex" style="height:100%;overflow-y:auto;">
      <div class="p-5 border-b border-slate-100">
       <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-navy-600 flex items-center justify-center">
         <svg width="20" height="20" viewbox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="white" /><rect x="14" y="3" width="7" height="7" rx="1.5" fill="white" opacity="0.6" /><rect x="3" y="14" width="7" height="7" rx="1.5" fill="white" opacity="0.6" /><rect x="14" y="14" width="7" height="7" rx="1.5" fill="white" />
         </svg>
        </div>
        <div><span class="font-bold text-navy-900 text-sm">SIBMN</span><span class="text-slate-400 text-xs block">BPMP Gorontalo</span>
        </div>
       </div>
      </div>
      <nav class="flex-1 p-3 space-y-1" id="sidebarNav"></nav>
      <div class="p-4 border-t border-slate-100">
       <div class="flex items-center gap-3 mb-3">
        <div id="sidebarAvatar" class="w-9 h-9 rounded-full bg-navy-100 flex items-center justify-center text-navy-600 font-bold text-sm"></div>
        <div>
         <div id="sidebarName" class="text-sm font-semibold text-navy-900 truncate" style="max-width:140px;"></div>
         <div id="sidebarRole" class="text-xs text-slate-400 truncate" style="max-width:140px;"></div>
        </div>
       </div><button onclick="handleLogout()" class="w-full flex items-center gap-2 text-sm text-red-500 hover:bg-red-50 px-3 py-2 rounded-lg transition"><i data-lucide="log-out" class="w-4 h-4"></i>Keluar</button>
      </div>
     </aside><!-- Main Content -->
     <div class="flex-1 flex flex-col" style="height:100%;overflow:hidden;">
      <!-- Top Bar -->
      <header class="bg-white border-b border-slate-200 px-4 lg:px-8 flex items-center justify-between flex-shrink-0" style="height:64px;">
       <div class="flex items-center gap-4">
        <button class="lg:hidden w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center" onclick="toggleSidebar()"><i data-lucide="menu" class="w-5 h-5 text-slate-600"></i></button>
        <div>
         <h1 id="pageTitle" class="text-lg font-bold text-navy-900"></h1>
         <p id="pageSubtitle" class="text-xs text-slate-400"></p>
        </div>
       </div>
       <div class="flex items-center gap-3">
        <div class="relative">
         <button class="w-9 h-9 rounded-lg hover:bg-slate-100 flex items-center justify-center relative"><i data-lucide="bell" class="w-5 h-5 text-slate-500"></i><span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span></button>
        </div>
        <div id="topAvatar" class="w-9 h-9 rounded-full bg-navy-600 flex items-center justify-center text-white font-bold text-sm cursor-pointer"></div>
       </div>
      </header><!-- Dashboard Content -->
      <main id="mainContent" class="flex-1 p-4 lg:p-8" style="overflow-y:auto;">
      </main>
     </div>
    </div>
   </div><!-- Toast -->
   <div id="toastContainer" class="fixed top-4 right-4 z-[200] space-y-2"></div>
  </div><!-- end appRoot -->
  <script>
// ===== DATA =====
const FACILITIES = [
  { name:'Aula Utama BPMP', desc:'Aula berkapasitas 200 orang dengan AC sentral, proyektor, dan sound system. Cocok untuk seminar, workshop, dan rapat besar.', price:'Rp 2.500.000/hari', capacity:'200 Orang', color:'from-blue-600 to-indigo-700', icon:'building', category:'ruang', image:'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=640&q=80', availability:'Beberapa jadwal tersedia', location:'Wongkaditi Timur, Kota Gorontalo', rating:4.6, reviews:18, priceOld:'Rp 3.000.000' },
  { name:'Ruang Rapat VIP', desc:'Ruangan eksklusif berkapasitas 20 orang dilengkapi video conference, whiteboard digital, dan pantry.', price:'Rp 1.000.000/hari', capacity:'20 Orang', color:'from-indigo-600 to-purple-700', icon:'users', category:'ruang', image:'https://images.unsplash.com/photo-1497366216548-37526070297c?w=640&q=80', availability:'2 slot minggu ini', location:'Kota Utara, Gorontalo', rating:4.8, reviews:24, priceOld:'Rp 1.250.000' },
  { name:'Lab Komputer', desc:'30 unit komputer terbaru dengan koneksi internet berkecepatan tinggi. Ideal untuk pelatihan IT dan ujian daring.', price:'Rp 1.500.000/hari', capacity:'30 Unit PC', color:'from-cyan-600 to-blue-700', icon:'monitor', category:'lab', image:'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=640&q=80', availability:'Tersedia', location:'Kompleks BPMP Gorontalo', rating:4.5, reviews:31, priceOld:null },
  { name:'Ruang Pelatihan A', desc:'Ruang kelas modern berkapasitas 40 orang dengan kursi ergonomis, AC, dan multimedia.', price:'Rp 800.000/hari', capacity:'40 Orang', color:'from-emerald-600 to-teal-700', icon:'book-open', category:'ruang', image:'https://images.unsplash.com/photo-1580582932707-520aed937d7b?w=640&q=80', availability:'Kapasitas terbatas', location:'Gedung Utama BPMP', rating:4.4, reviews:12, priceOld:'Rp 950.000' },
  { name:'Kendaraan Dinas - Minibus', desc:'Toyota HiAce berkapasitas 16 penumpang untuk keperluan dinas dan kegiatan lapangan.', price:'Rp 750.000/hari', capacity:'16 Penumpang', color:'from-amber-600 to-orange-700', icon:'truck', category:'kendaraan', image:'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=640&q=80', availability:'1 unit tersedia', location:'Pool Kendaraan BPMP', rating:4.7, reviews:9, priceOld:null },
  { name:'Gedung Serbaguna', desc:'Area multifungsi 500m² untuk pameran, bazar, atau kegiatan outdoor terlindung.', price:'Rp 3.000.000/hari', capacity:'300 Orang', color:'from-rose-600 to-pink-700', icon:'home', category:'outdoor', image:'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=640&q=80', availability:'Booking awal bulan', location:'Halaman BPMP Gorontalo', rating:4.5, reviews:7, priceOld:'Rp 3.500.000' },
];

const FACILITY_CHIPS = [
  { id:'semua', label:'Semua' },
  { id:'ruang', label:'Ruang & Aula' },
  { id:'lab', label:'Lab' },
  { id:'kendaraan', label:'Kendaraan' },
  { id:'outdoor', label:'Outdoor' },
];

const DEMO_ACCOUNTS = [
  { role:'superadmin', username:'superadmin', password:'super123', name:'Dr. Ahmad Ridwan, M.Pd', label:'Super Admin', color:'from-red-500 to-rose-600', icon:'shield', desc:'Akses penuh ke seluruh sistem' },
  { role:'kepala_bpmp', username:'kepalabpmp', password:'kepala123', name:'Prof. Haryanto, M.Si', label:'Kepala BPMP', color:'from-purple-500 to-indigo-600', icon:'crown', desc:'Dashboard eksekutif & persetujuan' },
  { role:'kasubag', username:'kasubag', password:'kasubag123', name:'Dra. Siti Rahayu, MM', label:'Kasubag TU', color:'from-indigo-500 to-blue-600', icon:'briefcase', desc:'Verifikasi & koordinasi BMN' },
  { role:'admin_persediaan', username:'adminpersediaan', password:'persediaan123', name:'Moh. Fadil, SE', label:'Admin Persediaan', color:'from-emerald-500 to-green-600', icon:'package', desc:'Kelola stok & barang habis pakai' },
  { role:'admin_sarpras', username:'adminsarpras', password:'sarpras123', name:'Nurul Hidayah, ST', label:'Admin Sarana Prasarana', color:'from-cyan-500 to-teal-600', icon:'building', desc:'Monitor gedung & fasilitas' },
  { role:'admin_aset', username:'adminaset', password:'aset123', name:'Irfan Gorontalo, S.Ak', label:'Admin Aset Tetap', color:'from-amber-500 to-yellow-600', icon:'landmark', desc:'Inventarisasi aset tetap' },
  { role:'pegawai', username:'pegawai', password:'pegawai123', name:'Fitri Mohamad, S.Pd', label:'Pegawai', color:'from-slate-500 to-gray-600', icon:'user', desc:'Peminjaman & riwayat BMN' },
  { role:'tamu', username:'tamu', password:'tamu123', name:'Pengunjung Umum', label:'Tamu', color:'from-cyan-400 to-blue-500', icon:'eye', desc:'Melihat info & statistik BMN' },
];

const ROLE_MENUS = {
  superadmin: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'users', label:'Manajemen User', icon:'users' },
    { id:'persediaan', label:'Persediaan', icon:'package' },
    { id:'sarpras', label:'Sarana Prasarana', icon:'building' },
    { id:'aset', label:'Aset Tetap', icon:'landmark' },
    { id:'peminjaman', label:'Peminjaman', icon:'file-check' },
    { id:'laporan', label:'Laporan', icon:'bar-chart-3' },
    { id:'pengaturan', label:'Pengaturan Sistem', icon:'settings' },
  ],
  kepala_bpmp: [
    { id:'dashboard', label:'Dashboard Eksekutif', icon:'layout-dashboard' },
    { id:'persetujuan', label:'Persetujuan', icon:'check-circle' },
    { id:'peminjaman_kendaraan', label:'Peminjaman Kendaraan', icon:'truck' },
    { id:'peminjaman_barang', label:'Peminjaman Barang', icon:'package' },
    { id:'permintaan_persediaan', label:'Permintaan Persediaan', icon:'shopping-cart' },
    { id:'laporan', label:'Laporan BMN', icon:'bar-chart-3' },
    { id:'sarpras', label:'Sarana Prasarana', icon:'building' },
    { id:'aset', label:'Aset Tetap', icon:'landmark' },
  ],
  kasubag: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'verifikasi', label:'Verifikasi BMN', icon:'shield-check' },
    { id:'persetujuan_peminjaman_kasubag', label:'Persetujuan Peminjaman', icon:'check-circle' },
    { id:'persetujuan_persediaan_kasubag', label:'Persetujuan Persediaan', icon:'check-circle' },
    { id:'persetujuan_sewa_kasubag', label:'Persetujuan Sewa', icon:'check-circle' },
    { id:'peminjaman_kendaraan', label:'Peminjaman Kendaraan', icon:'truck' },
    { id:'peminjaman_barang', label:'Peminjaman Barang', icon:'package' },
    { id:'permintaan_persediaan', label:'Permintaan Persediaan', icon:'shopping-cart' },
    { id:'persediaan', label:'Persediaan', icon:'package' },
    { id:'sarpras', label:'Sarana Prasarana', icon:'building' },
    { id:'aset', label:'Aset Tetap', icon:'landmark' },
    { id:'peminjaman', label:'Peminjaman', icon:'file-check' },
    { id:'laporan', label:'Laporan', icon:'bar-chart-3' },
  ],
  admin_persediaan: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'persediaan', label:'Data Persediaan', icon:'package' },
    { id:'barang_masuk', label:'Barang Masuk', icon:'arrow-down-circle' },
    { id:'barang_keluar', label:'Barang Keluar', icon:'arrow-up-circle' },
    { id:'opname', label:'Stok Opname', icon:'clipboard-list' },
    { id:'approval_persediaan', label:'Persetujuan Permintaan', icon:'check-circle' },
    { id:'laporan', label:'Laporan', icon:'bar-chart-3' },
  ],
  admin_sarpras: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'sarpras', label:'Data Sarpras', icon:'building' },
    { id:'pemeliharaan', label:'Pemeliharaan', icon:'wrench' },
    { id:'penyewaan', label:'Penyewaan Fasilitas', icon:'calendar' },
    { id:'kondisi', label:'Kondisi Bangunan', icon:'search' },
    { id:'approval_sewa', label:'Persetujuan Sewa', icon:'check-circle' },
    { id:'laporan', label:'Laporan', icon:'bar-chart-3' },
  ],
  admin_aset: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'aset', label:'Data Aset Tetap', icon:'landmark' },
    { id:'penyusutan', label:'Penyusutan', icon:'trending-down' },
    { id:'mutasi', label:'Mutasi Aset', icon:'repeat' },
    { id:'penghapusan', label:'Penghapusan', icon:'trash-2' },
    { id:'approval_peminjaman', label:'Persetujuan Peminjaman', icon:'check-circle' },
    { id:'laporan', label:'Laporan', icon:'bar-chart-3' },
  ],
  pegawai: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'peminjaman_kendaraan', label:'Peminjaman Kendaraan', icon:'truck' },
    { id:'peminjaman_barang', label:'Peminjaman Barang', icon:'package' },
    { id:'permintaan_persediaan', label:'Permintaan Persediaan', icon:'shopping-cart' },
    { id:'profil', label:'Profil Saya', icon:'user' },
  ],
  tamu: [
    { id:'dashboard', label:'Dashboard', icon:'layout-dashboard' },
    { id:'statistik_umum', label:'Statistik BMN', icon:'bar-chart-3' },
    { id:'fasilitas_info', label:'Info Fasilitas', icon:'info' },
    { id:'permintaan_peminjaman', label:'Permintaan Peminjaman', icon:'file-text' },
    { id:'kontak_bpmp', label:'Kontak BPMP', icon:'phone' },
  ],
};

let currentUser = null;
let currentPage = 'dashboard';
let facilityFilter = 'semua';
let registeredUsers = [...DEMO_ACCOUNTS];
let tamuPeminjamanRequests = [
  { id:'REQ-TAM-001', nama:'Aula Serbaguna', jenis:'Fasilitas', tgl_permintaan:'15 Jan 2025', tgl_pinjam:'20 Jan 2025', tgl_kembali:'21 Jan 2025', tujuan:'Seminar Pendidikan', status:'Disetujui', contact:'Dinas Pendidikan' },
  { id:'REQ-TAM-002', nama:'Lab Komputer', jenis:'Fasilitas', tgl_permintaan:'12 Jan 2025', tgl_pinjam:'18 Jan 2025', tgl_kembali:'18 Jan 2025', tujuan:'Pelatihan IT', status:'Menunggu Approval', contact:'LPMP Sulut' },
  { id:'REQ-TAM-003', nama:'Ruang Rapat VIP', jenis:'Fasilitas', tgl_permintaan:'10 Jan 2025', tgl_pinjam:'15 Jan 2025', tgl_kembali:'15 Jan 2025', tujuan:'Workshop Guru', status:'Ditolak', contact:'Dinas Pendidikan Gorontalo' },
];

// Data Peminjaman Kendaraan Pegawai
let pegawaiPeminjamanKendaraan = [
  { id:'PKN-2025-001', kendaraan:'Minibus Toyota HiAce', tgl_pinjam:'15 Jan 2025', tgl_kembali:'15 Jan 2025', tujuan:'Kunjungan Lapangan ke Sekolah SMA Negeri 1', peminjam:'Fitri Mohamad', status:'Aktif', driver:'Budi Santoso' },
  { id:'PKN-2025-002', kendaraan:'Kendaraan Dinas Roda 4 - Toyota Avanza', tgl_pinjam:'14 Jan 2025', tgl_kembali:'14 Jan 2025', tujuan:'Rapat Koordinasi di Kantor Dindik', peminjam:'Ahmad Yusuf', status:'Dikembalikan', driver:'Slamet Rijadi' },
  { id:'PKN-2024-045', kendaraan:'Minibus Toyota HiAce', tgl_pinjam:'10 Jan 2025', tgl_kembali:'10 Jan 2025', tujuan:'Pengawasan Sekolah Binaan', peminjam:'Siti Nurhaliza', status:'Dikembalikan', driver:'Budi Santoso' },
];

// Data Peminjaman Barang Pegawai
let pegawaiPeminjamanBarang = [
  { id:'PKB-2025-001', barang:'Proyektor Epson EB-X51', qty:1, tgl_pinjam:'15 Jan 2025', tgl_kembali:'17 Jan 2025', tujuan:'Presentasi Workshop Guru', peminjam:'Fitri Mohamad', status:'Aktif', lokasi:'Ruang Pelatihan A' },
  { id:'PKB-2025-002', barang:'Laptop ASUS VivoBook', qty:3, tgl_pinjam:'14 Jan 2025', tgl_kembali:'16 Jan 2025', tujuan:'Rapat Evaluasi Program', peminjam:'Ahmad Yusuf', status:'Aktif', lokasi:'Ruang Rapat VIP' },
  { id:'PKB-2024-089', barang:'Kamera Canon EOS 5D Mark IV', qty:1, tgl_pinjam:'10 Jan 2025', tgl_kembali:'12 Jan 2025', tujuan:'Dokumentasi Kegiatan Sosialisasi', peminjam:'Siti Nurhaliza', status:'Dikembalikan', lokasi:'Studio BPMP' },
  { id:'PKB-2024-087', barang:'Speaker Portable JBL', qty:2, tgl_pinjam:'8 Jan 2025', tgl_kembali:'8 Jan 2025', tujuan:'Acara Seminar Internal', peminjam:'Rudi Hartono', status:'Dikembalikan', lokasi:'Aula Utama' },
];

// Data Permintaan Persediaan Pegawai
let pegawaiPermintaanPersediaan = [
  { id:'PRP-2025-001', barang:'Kertas HVS A4 70gr', qty:10, satuan:'Rim', tgl_permintaan:'15 Jan 2025', tujuan:'Administrasi Bid. PMP', peminjam:'Fitri Mohamad', status:'Disetujui', tgl_disetujui:'15 Jan 2025' },
  { id:'PRP-2025-002', barang:'Tinta Printer HP 680', qty:5, satuan:'Pcs', tgl_permintaan:'14 Jan 2025', tujuan:'Printing Dokumen Rapat', peminjam:'Ahmad Yusuf', status:'Menunggu Approval', tgl_disetujui:'-' },
  { id:'PRP-2025-003', barang:'Pulpen Pilot G1 0.7mm', qty:2, satuan:'Box', tgl_permintaan:'12 Jan 2025', tujuan:'Kebutuhan Kantor', peminjam:'Siti Nurhaliza', status:'Disetujui', tgl_disetujui:'12 Jan 2025' },
  { id:'PRP-2024-156', barang:'Map Ordner Folio', qty:20, satuan:'Lembar', tgl_permintaan:'10 Jan 2025', tujuan:'Arsip Dokumen', peminjam:'Rudi Hartono', status:'Ditolak', tgl_disetujui:'-' },
];

// ===== FASILITAS LANDING (tiket-style carousel) =====
const FACILITIES_PROMO_END = new Date('2026-04-30T23:59:59');

function facilityStarRow(rating) {
  const n = Math.round(rating);
  return [0, 1, 2, 3, 4].map((i) => `<span class="${i < n ? 'text-amber-400' : 'text-slate-200'} text-[11px] leading-none">★</span>`).join('');
}

function updateFacilitiesCountdown() {
  const hEl = document.getElementById('facilitiesCdH');
  const mEl = document.getElementById('facilitiesCdM');
  const sEl = document.getElementById('facilitiesCdS');
  if (!hEl || !mEl || !sEl) return;
  let ms = FACILITIES_PROMO_END - Date.now();
  if (ms < 0) ms = 0;
  const s = Math.floor(ms / 1000);
  const hh = String(Math.floor(s / 3600)).padStart(2, '0');
  const mm = String(Math.floor((s % 3600) / 60)).padStart(2, '0');
  const ss = String(s % 60).padStart(2, '0');
  hEl.textContent = hh;
  mEl.textContent = mm;
  sEl.textContent = ss;
}

function setFacilityFilter(id) {
  facilityFilter = id;
  buildCarousel();
}

function facilitiesScrollNext() {
  const el = document.getElementById('facilitiesCarouselScroll');
  if (!el) return;
  const step = Math.min(300, Math.max(260, el.clientWidth * 0.75));
  el.scrollBy({ left: step, behavior: 'smooth' });
}

function facilitiesScrollPrev() {
  const el = document.getElementById('facilitiesCarouselScroll');
  if (!el) return;
  const step = Math.min(300, Math.max(260, el.clientWidth * 0.75));
  el.scrollBy({ left: -step, behavior: 'smooth' });
}

function buildCarousel() {
  const chipsEl = document.getElementById('facilityChips');
  const scrollEl = document.getElementById('facilitiesCarouselScroll');
  if (!chipsEl || !scrollEl) return;

  chipsEl.innerHTML = FACILITY_CHIPS.map((c) => {
    const active = facilityFilter === c.id;
    const base = 'px-4 py-2 rounded-full text-sm font-semibold transition border-2';
    const cls = active
      ? `${base} border-blue-500 bg-blue-50 text-navy-800 shadow-sm`
      : `${base} border-slate-200 bg-white text-slate-700 hover:bg-slate-50`;
    return `<button type="button" onclick="setFacilityFilter('${c.id}')" class="${cls}">${c.label}</button>`;
  }).join('');

  const list = facilityFilter === 'semua'
    ? FACILITIES
    : FACILITIES.filter((f) => f.category === facilityFilter);

  if (list.length === 0) {
    scrollEl.innerHTML = '<p class="text-slate-600 text-sm py-8 px-4">Tidak ada fasilitas pada kategori ini.</p>';
    lucide.createIcons();
    return;
  }

  scrollEl.innerHTML = list.map((f) => {
    const ratingStr = String(f.rating).replace('.', ',');
    const oldPrice = f.priceOld
      ? `<div class="text-slate-400 text-xs line-through mb-0.5">${f.priceOld}<span class="text-slate-300">/hari</span></div>`
      : '';
    return `
    <article class="flex-shrink-0 w-[260px] sm:w-[280px] snap-start rounded-2xl bg-white shadow-md border border-slate-100/80 overflow-hidden card-hover flex flex-col">
      <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
        <img src="${f.image}" alt="${f.name.replace(/"/g, '&quot;')}" class="w-full h-full object-cover" loading="lazy" width="320" height="240">
      </div>
      <div class="p-3.5 flex flex-col flex-1">
        <p class="text-red-600 text-xs font-semibold mb-1.5">${f.availability}</p>
        <h3 class="font-bold text-navy-900 text-sm leading-snug mb-1 line-clamp-2">${f.name}</h3>
        <div class="flex items-center gap-0.5 mb-1">${facilityStarRow(f.rating)}</div>
        <p class="text-slate-500 text-xs mb-2">${f.location}</p>
        <div class="flex items-center gap-2 mb-3 mt-auto text-xs">
          <span class="inline-flex items-center justify-center min-w-[1.75rem] h-7 px-1 rounded-md bg-violet-600 text-white font-bold text-[11px] shadow-sm">${ratingStr}</span>
          <span class="text-slate-600"><span class="font-semibold text-navy-800">${ratingStr}/5</span> <span class="text-slate-400">(${f.reviews} ulasan)</span></span>
        </div>
        <div class="border-t border-slate-100 pt-2.5">
          ${oldPrice}
          <div class="text-red-600 font-extrabold text-base leading-tight tracking-tight">${f.price}</div>
          <p class="text-slate-400 text-[11px] mt-1">Belum termasuk pajak &amp; biaya lain</p>
        </div>
      </div>
    </article>`;
  }).join('');

  lucide.createIcons();
}

// ===== DEMO ACCOUNTS GRID =====
function buildDemoAccounts() {
  const grid = document.getElementById('demoAccountsGrid');
  grid.innerHTML = DEMO_ACCOUNTS.map(a => `
    <div class="bg-white rounded-xl border border-slate-100 p-5 card-hover">
      <div class="flex items-center gap-3 mb-3">
        <div class="w-10 h-10 bg-gradient-to-br ${a.color} rounded-xl flex items-center justify-center"><i data-lucide="${a.icon}" class="w-5 h-5 text-white"></i></div>
        <div><div class="font-semibold text-navy-900 text-sm">${a.label}</div><div class="text-slate-400 text-xs">${a.desc}</div></div>
      </div>
      <div class="bg-slate-50 rounded-lg p-3 space-y-1.5 mb-3">
        <div class="flex justify-between text-xs"><span class="text-slate-400">Username:</span><span class="font-mono font-semibold text-navy-700">${a.username}</span></div>
        <div class="flex justify-between text-xs"><span class="text-slate-400">Password:</span><span class="font-mono font-semibold text-navy-700">${a.password}</span></div>
      </div>
      <button onclick="quickLogin('${a.username}','${a.password}')" class="w-full text-center py-2 text-sm font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 rounded-lg transition">
        Login Cepat →
      </button>
    </div>
  `).join('');
  lucide.createIcons();
}

// ===== AUTH =====
function showLogin() { document.getElementById('loginModal').classList.remove('hidden'); lucide.createIcons(); }
function showRegister() { document.getElementById('registerModal').classList.remove('hidden'); lucide.createIcons(); }
function closeModals() {
  document.getElementById('loginModal').classList.add('hidden');
  document.getElementById('registerModal').classList.add('hidden');
  document.getElementById('loginError').classList.add('hidden');
  document.getElementById('regSuccess').classList.add('hidden');
}
function quickLogin(u, p) {
  document.getElementById('loginUser').value = u;
  document.getElementById('loginPass').value = p;
  showLogin();
}
function handleLogin(e) {
  e.preventDefault();
  const u = document.getElementById('loginUser').value.trim();
  const p = document.getElementById('loginPass').value.trim();
  const found = registeredUsers.find(a => a.username === u && a.password === p);
  if (found) {
    currentUser = found;
    closeModals();
    showDashboard();
    showToast('Login berhasil! Selamat datang, ' + found.name, 'success');
  } else {
    const err = document.getElementById('loginError');
    err.classList.remove('hidden');
    err.querySelector('span').textContent = 'Username atau password salah!';
  }
}
function toggleLoginPassword() {
  const input = document.getElementById('loginPass');
  const icon = document.getElementById('loginPassIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<use xlink:href="#eye-off"></use>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<use xlink:href="#eye"></use>';
  }
  lucide.createIcons();
}
function toggleRegPassword() {
  const input = document.getElementById('regPass');
  const icon = document.getElementById('regPassIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<use xlink:href="#eye-off"></use>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<use xlink:href="#eye"></use>';
  }
  lucide.createIcons();
}
function handleRegister(e) {
  e.preventDefault();
  const name = document.getElementById('regName').value.trim();
  const nip = document.getElementById('regNIP').value.trim();
  const user = document.getElementById('regUser').value.trim();
  const pass = document.getElementById('regPass').value.trim();
  const role = document.getElementById('regRole').value;
  if (registeredUsers.find(a => a.username === user)) {
    showToast('Username sudah digunakan!', 'error'); return;
  }
  const roleInfo = DEMO_ACCOUNTS.find(a => a.role === role);
  registeredUsers.push({ role, username: user, password: pass, name, nip, label: roleInfo.label, color: roleInfo.color, icon: roleInfo.icon, desc: roleInfo.desc });
  document.getElementById('regSuccess').classList.remove('hidden');
  showToast('Registrasi berhasil! Silakan login.', 'success');
  setTimeout(() => { closeModals(); showLogin(); }, 1500);
}
function handleLogout() {
  currentUser = null;
  document.getElementById('dashboardPage').classList.add('hidden');
  document.getElementById('landingPage').classList.remove('hidden');
  showToast('Anda telah keluar dari sistem.', 'info');
}

// ===== DASHBOARD =====
function showDashboard() {
  document.getElementById('landingPage').classList.add('hidden');
  document.getElementById('dashboardPage').classList.remove('hidden');
  buildSidebar();
  navigateTo('dashboard');
  const initials = currentUser.name.split(' ').map(w=>w[0]).join('').substring(0,2).toUpperCase();
  document.getElementById('sidebarAvatar').textContent = initials;
  document.getElementById('sidebarName').textContent = currentUser.name;
  document.getElementById('sidebarRole').textContent = currentUser.label;
  document.getElementById('topAvatar').textContent = initials;
}
function buildSidebar() {
  const nav = document.getElementById('sidebarNav');
  const menus = ROLE_MENUS[currentUser.role] || ROLE_MENUS.pegawai;
  nav.innerHTML = menus.map(m => `
    <button onclick="navigateTo('${m.id}')" class="sidebar-item w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-600" data-page="${m.id}">
      <i data-lucide="${m.icon}" class="w-[18px] h-[18px]"></i><span>${m.label}</span>
    </button>
  `).join('');
  lucide.createIcons();
}
function navigateTo(page) {
  currentPage = page;
  document.querySelectorAll('.sidebar-item').forEach(s => {
    s.classList.toggle('active', s.dataset.page === page);
    s.classList.toggle('text-navy-700', s.dataset.page === page);
    s.classList.toggle('font-semibold', s.dataset.page === page);
    s.classList.toggle('text-slate-600', s.dataset.page !== page);
  });
  const menus = ROLE_MENUS[currentUser.role] || ROLE_MENUS.pegawai;
  const menuItem = menus.find(m => m.id === page);
  document.getElementById('pageTitle').textContent = menuItem ? menuItem.label : 'Dashboard';
  document.getElementById('pageSubtitle').textContent = currentUser.label + ' — BPMP Gorontalo';
  renderPage(page);
}
function toggleSidebar() {
  const sb = document.getElementById('sidebar');
  sb.classList.toggle('hidden');
  sb.classList.toggle('fixed');
  sb.classList.toggle('inset-0');
  sb.classList.toggle('z-50');
}
function toggleMobileMenu() { document.getElementById('mobileMenu').classList.toggle('hidden'); }

// ===== PAGE RENDERERS =====
function renderPage(page) {
  const main = document.getElementById('mainContent');
  const role = currentUser.role;
  switch(page) {
    case 'dashboard': main.innerHTML = getDashboardHTML(role); break;
    case 'users': main.innerHTML = getUsersHTML(); break;
    case 'persediaan': main.innerHTML = getPersediaanHTML(); break;
    case 'sarpras': main.innerHTML = getSarprasHTML(); break;
    case 'aset': main.innerHTML = getAsetHTML(); break;
    case 'peminjaman': main.innerHTML = getPeminjamanHTML(); break;
    case 'laporan': main.innerHTML = getLaporanHTML(); break;
    case 'pengaturan': main.innerHTML = getPengaturanHTML(); break;
    case 'persetujuan': main.innerHTML = getPersetujuanHTML(); break;
    case 'verifikasi': main.innerHTML = getVerifikasiHTML(); break;
    case 'barang_masuk': main.innerHTML = getBarangMasukHTML(); break;
    case 'barang_keluar': main.innerHTML = getBarangKeluarHTML(); break;
    case 'opname': main.innerHTML = getOpnameHTML(); break;
    case 'pemeliharaan': main.innerHTML = getPemeliharaanHTML(); break;
    case 'penyewaan': main.innerHTML = getPenyewaanHTML(); break;
    case 'kondisi': main.innerHTML = getKondisiHTML(); break;
    case 'penyusutan': main.innerHTML = getPenyusutanHTML(); break;
    case 'mutasi': main.innerHTML = getMutasiHTML(); break;
    case 'penghapusan': main.innerHTML = getPenghapusanHTML(); break;
    case 'approval_persediaan': main.innerHTML = getApprovalPersediaanHTML(); break;
    case 'approval_peminjaman': main.innerHTML = getApprovalPeminjamanHTML(); break;
    case 'approval_sewa': main.innerHTML = getApprovalSewaHTML(); break;
    case 'persetujuan_peminjaman_kasubag': main.innerHTML = getPersetujuanPeminjamanKasubagHTML(); break;
    case 'persetujuan_persediaan_kasubag': main.innerHTML = getPersetujuanPersediaanKasubagHTML(); break;
    case 'persetujuan_sewa_kasubag': main.innerHTML = getPersetujuanSewaKasubagHTML(); break;
    case 'peminjaman_kendaraan': main.innerHTML = getPeminjamanKendaraanHTML(); break;
    case 'peminjaman_barang': main.innerHTML = getPeminjamanBarangHTML(); break;
    case 'permintaan_persediaan': main.innerHTML = getPermintaanPersediaanHTML(); break;
    case 'profil': main.innerHTML = getProfilHTML(); break;
    case 'statistik_umum': main.innerHTML = getStatistikUmumHTML(); break;
    case 'fasilitas_info': main.innerHTML = getFasilitasInfoHTML(); break;
    case 'permintaan_peminjaman': main.innerHTML = getPermintaanPeminjamanHTML(); break;
    case 'kontak_bpmp': main.innerHTML = getKontakBPMPHTML(); break;
    default: main.innerHTML = getDashboardHTML(role);
  }
  lucide.createIcons();
}

function statCard(icon, label, value, color, trend) {
  return `<div class="stat-card bg-white rounded-xl border border-slate-100 p-5 card-hover">
    <div class="flex items-center justify-between mb-3">
      <div class="w-11 h-11 ${color} rounded-xl flex items-center justify-center"><i data-lucide="${icon}" class="w-5 h-5 text-white"></i></div>
      ${trend ? `<span class="text-xs font-semibold ${trend.startsWith('+')?'text-green-500':'text-red-500'}">${trend}</span>` : ''}
    </div>
    <div class="text-2xl font-bold text-navy-900">${value}</div>
    <div class="text-slate-400 text-xs mt-1">${label}</div>
  </div>`;
}

function tableWrap(headers, rows) {
  return `<div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full text-sm">
    <thead><tr class="bg-slate-50 border-b border-slate-100">${headers.map(h=>`<th class="text-left px-4 py-3 font-semibold text-navy-700 text-xs uppercase tracking-wide">${h}</th>`).join('')}</tr></thead>
    <tbody>${rows}</tbody></table></div></div>`;
}

function badgeHTML(text, type) {
  const colors = { success:'bg-green-100 text-green-700', warning:'bg-amber-100 text-amber-700', danger:'bg-red-100 text-red-700', info:'bg-blue-100 text-blue-700', neutral:'bg-slate-100 text-slate-600' };
  return `<span class="badge ${colors[type]||colors.neutral}">${text}</span>`;
}

function getDashboardHTML(role) {
  let stats = '';
  if (role === 'superadmin' || role === 'kepala_bpmp' || role === 'kasubag') {
    stats = `<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      ${statCard('database','Total Item BMN','1,247','bg-navy-600','+12%')}
      ${statCard('trending-up','Nilai Aset','Rp 28.5M','bg-emerald-500','+5.2%')}
      ${statCard('repeat','Transaksi Bulan Ini','342','bg-amber-500','+18%')}
      ${statCard('alert-circle','Perlu Perhatian','23','bg-red-500','-3')}
    </div>`;
  } else if (role === 'admin_persediaan') {
    stats = `<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      ${statCard('package','Total Persediaan','391','bg-emerald-500','+8')}
      ${statCard('arrow-down-circle','Barang Masuk','45','bg-blue-500','+12')}
      ${statCard('arrow-up-circle','Barang Keluar','38','bg-amber-500','')}
      ${statCard('alert-triangle','Stok Menipis','7','bg-red-500','')}
    </div>`;
  } else if (role === 'admin_sarpras') {
    stats = `<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      ${statCard('building','Total Sarpras','127','bg-cyan-500','')}
      ${statCard('check-circle','Kondisi Baik','118','bg-green-500','')}
      ${statCard('wrench','Pemeliharaan','6','bg-amber-500','')}
      ${statCard('calendar','Sewa Aktif','4','bg-purple-500','')}
    </div>`;
  } else if (role === 'admin_aset') {
    stats = `<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      ${statCard('landmark','Total Aset Tetap','856','bg-amber-500','')}
      ${statCard('trending-down','Penyusutan','Rp 2.1M','bg-red-500','')}
      ${statCard('repeat','Mutasi Aset','15','bg-blue-500','')}
      ${statCard('trash-2','Penghapusan','3','bg-slate-500','')}
    </div>`;
  } else {
    stats = `<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
      ${statCard('file-check','Peminjaman Aktif','2','bg-blue-500','')}
      ${statCard('history','Total Riwayat','18','bg-emerald-500','')}
      ${statCard('clock','Menunggu Approval','1','bg-amber-500','')}
    </div>`;
  }

  const recentActivity = `<div class="bg-white rounded-xl border border-slate-100 p-5">
    <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="activity" class="w-4 h-4 text-navy-400"></i>Aktivitas Terakhir</h3>
    <div class="space-y-3">
      ${[
        { action:'Barang masuk: ATK 50 rim', time:'2 jam lalu', icon:'arrow-down-circle', c:'text-blue-500' },
        { action:'Peminjaman Proyektor #PRJ-003', time:'4 jam lalu', icon:'file-check', c:'text-amber-500' },
        { action:'Pemeliharaan AC Ruang Rapat', time:'Kemarin', icon:'wrench', c:'text-emerald-500' },
        { action:'Mutasi Laptop ke Bidang PMP', time:'2 hari lalu', icon:'repeat', c:'text-purple-500' },
        { action:'Stok opname persediaan Q4', time:'3 hari lalu', icon:'clipboard-list', c:'text-cyan-500' },
      ].map(a => `<div class="flex items-center gap-3 py-2 border-b border-slate-50 last:border-0">
        <i data-lucide="${a.icon}" class="w-4 h-4 ${a.c} flex-shrink-0"></i>
        <span class="text-sm text-slate-700 flex-1">${a.action}</span>
        <span class="text-xs text-slate-400 whitespace-nowrap">${a.time}</span>
      </div>`).join('')}
    </div>
  </div>`;

  const chart = `<div class="bg-white rounded-xl border border-slate-100 p-5">
    <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="bar-chart-3" class="w-4 h-4 text-navy-400"></i>Grafik BMN per Kategori</h3>
    <div class="space-y-3">
      ${[
        { label:'Peralatan & Mesin', val:420, max:500, color:'bg-blue-500' },
        { label:'Gedung & Bangunan', val:85, max:500, color:'bg-emerald-500' },
        { label:'Tanah', val:12, max:500, color:'bg-amber-500' },
        { label:'Kendaraan', val:35, max:500, color:'bg-purple-500' },
        { label:'Persediaan', val:391, max:500, color:'bg-cyan-500' },
        { label:'Aset Lainnya', val:304, max:500, color:'bg-rose-500' },
      ].map(b => `<div>
        <div class="flex justify-between text-xs mb-1"><span class="text-slate-600">${b.label}</span><span class="font-semibold text-navy-700">${b.val}</span></div>
        <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="${b.color} h-2.5 rounded-full transition-all duration-700" style="width:${(b.val/b.max)*100}%"></div></div>
      </div>`).join('')}
    </div>
  </div>`;

  return stats + `<div class="grid lg:grid-cols-2 gap-6">${recentActivity}${chart}</div>`;
}

function getUsersHTML() {
  const rows = registeredUsers.map((u,i) => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3">${i+1}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${u.name}</td>
    <td class="px-4 py-3 font-mono text-xs">${u.username}</td>
    <td class="px-4 py-3">${badgeHTML(u.label, 'info')}</td>
    <td class="px-4 py-3"><button class="text-navy-600 hover:underline text-xs font-semibold">Edit</button></td>
  </tr>`).join('');
  return `<div class="flex justify-between items-center mb-4">
    <p class="text-sm text-slate-500">${registeredUsers.length} pengguna terdaftar</p>
    <button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Tambah User</button>
  </div>` + tableWrap(['#','Nama','Username','Role','Aksi'], rows);
}

function getPersediaanHTML() {
  const items = [
    { kode:'PSD-001', nama:'Kertas HVS A4 70gr', satuan:'Rim', stok:124, min:20, status:'Aman' },
    { kode:'PSD-002', nama:'Tinta Printer HP 680', satuan:'Pcs', stok:8, min:10, status:'Menipis' },
    { kode:'PSD-003', nama:'Amplop Coklat F4', satuan:'Lembar', stok:350, min:50, status:'Aman' },
    { kode:'PSD-004', nama:'Binder Clip No.155', satuan:'Box', stok:15, min:5, status:'Aman' },
    { kode:'PSD-005', nama:'Pulpen Pilot G1', satuan:'Pcs', stok:3, min:10, status:'Kritis' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.kode}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${it.nama}</td>
    <td class="px-4 py-3">${it.satuan}</td>
    <td class="px-4 py-3 font-semibold">${it.stok}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Aman'?'success':it.status==='Menipis'?'warning':'danger')}</td>
    <td class="px-4 py-3"><button class="text-navy-600 hover:underline text-xs font-semibold">Detail</button></td>
  </tr>`).join('');
  return `<div class="flex justify-between items-center mb-4 flex-wrap gap-2">
    <p class="text-sm text-slate-500">Data persediaan barang habis pakai</p>
    <button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Tambah Persediaan</button>
  </div>` + tableWrap(['Kode','Nama Barang','Satuan','Stok','Status','Aksi'], rows);
}

function getSarprasHTML() {
  const items = [
    { kode:'SPR-001', nama:'Gedung Utama BPMP', jenis:'Bangunan', kondisi:'Baik', nilai:'Rp 8.500.000.000' },
    { kode:'SPR-002', nama:'Aula Serbaguna', jenis:'Bangunan', kondisi:'Baik', nilai:'Rp 3.200.000.000' },
    { kode:'SPR-003', nama:'Kendaraan Dinas Roda 4', jenis:'Kendaraan', kondisi:'Baik', nilai:'Rp 285.000.000' },
    { kode:'SPR-004', nama:'AC Central Lantai 2', jenis:'Instalasi', kondisi:'Rusak Ringan', nilai:'Rp 45.000.000' },
    { kode:'SPR-005', nama:'Genset 50KVA', jenis:'Mesin', kondisi:'Baik', nilai:'Rp 120.000.000' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.kode}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${it.nama}</td>
    <td class="px-4 py-3">${it.jenis}</td>
    <td class="px-4 py-3">${badgeHTML(it.kondisi, it.kondisi==='Baik'?'success':'warning')}</td>
    <td class="px-4 py-3 font-mono text-xs">${it.nilai}</td>
    <td class="px-4 py-3"><button class="text-navy-600 hover:underline text-xs font-semibold">Detail</button></td>
  </tr>`).join('');
  return `<div class="flex justify-between items-center mb-4 flex-wrap gap-2">
    <p class="text-sm text-slate-500">Data sarana dan prasarana</p>
    <button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Tambah Sarpras</button>
  </div>` + tableWrap(['Kode','Nama','Jenis','Kondisi','Nilai','Aksi'], rows);
}

function getAsetHTML() {
  const items = [
    { kode:'AST-001', nama:'Tanah Kantor BPMP', golongan:'Tanah', tahun:2005, nilai:'Rp 15.000.000.000', status:'Aktif' },
    { kode:'AST-002', nama:'Laptop ASUS VivoBook', golongan:'Peralatan & Mesin', tahun:2023, nilai:'Rp 12.500.000', status:'Aktif' },
    { kode:'AST-003', nama:'Meja Kerja Stainless', golongan:'Peralatan & Mesin', tahun:2020, nilai:'Rp 3.500.000', status:'Aktif' },
    { kode:'AST-004', nama:'Proyektor Epson EB-X51', golongan:'Peralatan & Mesin', tahun:2022, nilai:'Rp 8.900.000', status:'Dipinjam' },
    { kode:'AST-005', nama:'Server Dell PowerEdge', golongan:'Peralatan & Mesin', tahun:2021, nilai:'Rp 85.000.000', status:'Aktif' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.kode}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${it.nama}</td>
    <td class="px-4 py-3 text-xs">${it.golongan}</td>
    <td class="px-4 py-3">${it.tahun}</td>
    <td class="px-4 py-3 font-mono text-xs">${it.nilai}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Aktif'?'success':'warning')}</td>
    <td class="px-4 py-3"><button class="text-navy-600 hover:underline text-xs font-semibold">Detail</button></td>
  </tr>`).join('');
  return `<div class="flex justify-between items-center mb-4 flex-wrap gap-2">
    <p class="text-sm text-slate-500">Data aset tetap BPMP Gorontalo</p>
    <button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Tambah Aset</button>
  </div>` + tableWrap(['Kode','Nama Aset','Golongan','Tahun','Nilai','Status','Aksi'], rows);
}

function getPeminjamanHTML() {
  const items = [
    { id:'PMJ-2025-001', barang:'Proyektor Epson EB-X51', peminjam:'Fitri Mohamad', tgl:'15 Jan 2025', kembali:'17 Jan 2025', status:'Aktif' },
    { id:'PMJ-2025-002', barang:'Laptop ASUS VivoBook (3)', peminjam:'Ahmad Yusuf', tgl:'14 Jan 2025', kembali:'16 Jan 2025', status:'Terlambat' },
    { id:'PMJ-2025-003', barang:'Kamera Canon EOS', peminjam:'Siti Nurhaliza', tgl:'10 Jan 2025', kembali:'12 Jan 2025', status:'Dikembalikan' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${it.barang}</td>
    <td class="px-4 py-3">${it.peminjam}</td>
    <td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3 text-xs">${it.kembali}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Aktif'?'info':it.status==='Terlambat'?'danger':'success')}</td>
  </tr>`).join('');
  return `<div class="flex justify-between items-center mb-4 flex-wrap gap-2">
    <p class="text-sm text-slate-500">Data peminjaman BMN</p>
    <button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Buat Peminjaman</button>
  </div>` + tableWrap(['ID','Barang','Peminjam','Tgl Pinjam','Tgl Kembali','Status'], rows);
}

function getLaporanHTML() {
  return `<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    ${[
      { title:'Laporan Persediaan', desc:'Rekapitulasi stok barang habis pakai per periode', icon:'package', color:'bg-emerald-100 text-emerald-600' },
      { title:'Laporan Aset Tetap', desc:'Daftar dan nilai seluruh aset tetap BMN', icon:'landmark', color:'bg-amber-100 text-amber-600' },
      { title:'Laporan Penyusutan', desc:'Perhitungan penyusutan aset per tahun', icon:'trending-down', color:'bg-red-100 text-red-600' },
      { title:'Laporan Peminjaman', desc:'Riwayat peminjaman dan pengembalian BMN', icon:'file-check', color:'bg-blue-100 text-blue-600' },
      { title:'Laporan Mutasi', desc:'Catatan perpindahan aset antar unit kerja', icon:'repeat', color:'bg-purple-100 text-purple-600' },
      { title:'Neraca BMN', desc:'Neraca keseluruhan Barang Milik Negara', icon:'scale', color:'bg-cyan-100 text-cyan-600' },
    ].map(l => `<div class="bg-white rounded-xl border border-slate-100 p-5 card-hover cursor-pointer">
      <div class="w-11 h-11 ${l.color} rounded-xl flex items-center justify-center mb-3"><i data-lucide="${l.icon}" class="w-5 h-5"></i></div>
      <h4 class="font-bold text-navy-900 mb-1">${l.title}</h4>
      <p class="text-slate-400 text-xs mb-3">${l.desc}</p>
      <button class="text-navy-600 text-xs font-semibold flex items-center gap-1 hover:underline"><i data-lucide="download" class="w-3 h-3"></i>Download</button>
    </div>`).join('')}
  </div>`;
}

function getPengaturanHTML() {
  return `<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-slate-100 p-6 mb-6">
      <h3 class="font-bold text-navy-900 mb-4">Pengaturan Umum</h3>
      <div class="space-y-4">
        <div><label for="setNamaInstansi" class="block text-sm font-medium text-navy-800 mb-1">Nama Instansi</label><input id="setNamaInstansi" type="text" value="BPMP Provinsi Gorontalo" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
        <div><label for="setTahunAnggaran" class="block text-sm font-medium text-navy-800 mb-1">Tahun Anggaran</label><input id="setTahunAnggaran" type="text" value="2025" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
        <div><label for="setKodeSatker" class="block text-sm font-medium text-navy-800 mb-1">Kode Satker</label><input id="setKodeSatker" type="text" value="023.08.2.429159" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none"></div>
      </div>
      <button class="btn-primary text-white text-sm font-semibold px-6 py-2.5 rounded-lg mt-6">Simpan Pengaturan</button>
    </div>
  </div>`;
}

function getPersetujuanHTML() {
  const items = [
    { id:'APR-001', jenis:'Penghapusan Aset', item:'Printer HP LaserJet (Rusak Berat)', tgl:'14 Jan 2025', status:'Menunggu' },
    { id:'APR-002', jenis:'Mutasi Aset', item:'Laptop Dell ke Bidang PMP', tgl:'13 Jan 2025', status:'Menunggu' },
    { id:'APR-003', jenis:'Pengadaan', item:'Kursi Ergonomis x20', tgl:'10 Jan 2025', status:'Disetujui' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td>
    <td class="px-4 py-3">${it.jenis}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${it.item}</td>
    <td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Menunggu'?'warning':'success')}</td>
    <td class="px-4 py-3">${it.status==='Menunggu'?'<button class="text-green-600 text-xs font-semibold mr-2">Setujui</button><button class="text-red-500 text-xs font-semibold">Tolak</button>':'<span class="text-slate-400 text-xs">—</span>'}</td>
  </tr>`).join('');
  return tableWrap(['ID','Jenis','Item','Tanggal','Status','Aksi'], rows);
}

function getVerifikasiHTML() {
  const items = [
    { id:'VRF-001', item:'Stok Opname Persediaan Q4', pengaju:'Moh. Fadil', tgl:'15 Jan 2025', status:'Menunggu Verifikasi' },
    { id:'VRF-002', item:'Pemeliharaan Gedung Lt.2', pengaju:'Nurul Hidayah', tgl:'14 Jan 2025', status:'Menunggu Verifikasi' },
    { id:'VRF-003', item:'Registrasi Aset Baru - Server', pengaju:'Irfan Gorontalo', tgl:'12 Jan 2025', status:'Terverifikasi' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${it.item}</td>
    <td class="px-4 py-3">${it.pengaju}</td>
    <td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status.includes('Menunggu')?'warning':'success')}</td>
    <td class="px-4 py-3">${it.status.includes('Menunggu')?'<button class="text-green-600 text-xs font-semibold">Verifikasi</button>':'<span class="text-slate-400 text-xs">—</span>'}</td>
  </tr>`).join('');
  return tableWrap(['ID','Item','Pengaju','Tanggal','Status','Aksi'], rows);
}

function getBarangMasukHTML() {
  const items = [
    { no:'BM-001', nama:'Kertas HVS A4', qty:100, supplier:'CV Mandiri Jaya', tgl:'15 Jan 2025' },
    { no:'BM-002', nama:'Toner HP 85A', qty:10, supplier:'PT Office Pro', tgl:'14 Jan 2025' },
    { no:'BM-003', nama:'Map Ordner', qty:50, supplier:'UD Berkah', tgl:'12 Jan 2025' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.no}</td><td class="px-4 py-3 font-medium text-navy-900">${it.nama}</td>
    <td class="px-4 py-3 font-semibold">${it.qty}</td><td class="px-4 py-3">${it.supplier}</td><td class="px-4 py-3 text-xs">${it.tgl}</td>
  </tr>`).join('');
  return `<div class="flex justify-end mb-4"><button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Catat Barang Masuk</button></div>` + tableWrap(['No','Nama Barang','Qty','Supplier','Tanggal'], rows);
}

function getBarangKeluarHTML() {
  const items = [
    { no:'BK-001', nama:'Kertas HVS A4', qty:10, penerima:'Bidang PMP', tgl:'15 Jan 2025' },
    { no:'BK-002', nama:'Pulpen Pilot G1', qty:5, penerima:'Bidang Fasilitasi', tgl:'14 Jan 2025' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.no}</td><td class="px-4 py-3 font-medium text-navy-900">${it.nama}</td>
    <td class="px-4 py-3 font-semibold">${it.qty}</td><td class="px-4 py-3">${it.penerima}</td><td class="px-4 py-3 text-xs">${it.tgl}</td>
  </tr>`).join('');
  return `<div class="flex justify-end mb-4"><button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Catat Barang Keluar</button></div>` + tableWrap(['No','Nama Barang','Qty','Penerima','Tanggal'], rows);
}

function getOpnameHTML() {
  return `<div class="bg-white rounded-xl border border-slate-100 p-6">
    <div class="flex items-center justify-between mb-6">
      <div><h3 class="font-bold text-navy-900">Stok Opname Periode Q4 2024</h3><p class="text-sm text-slate-400 mt-1">Terakhir dilakukan: 15 Januari 2025</p></div>
      <button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg">Mulai Opname Baru</button>
    </div>
    <div class="grid grid-cols-3 gap-4 mb-6">
      ${statCard('check-circle','Sesuai','384','bg-green-500','')}
      ${statCard('alert-triangle','Selisih','5','bg-amber-500','')}
      ${statCard('x-circle','Hilang','2','bg-red-500','')}
    </div>
    <div class="text-center py-6 text-slate-400 text-sm"><i data-lucide="clipboard-list" class="w-12 h-12 mx-auto mb-2 text-slate-300"></i><p>Detail opname tersedia setelah proses selesai</p></div>
  </div>`;
}

function getPemeliharaanHTML() {
  const items = [
    { id:'PML-001', item:'AC Central Lt.2', jenis:'Perbaikan', tgl:'15 Jan 2025', biaya:'Rp 2.500.000', status:'Proses' },
    { id:'PML-002', item:'Atap Gedung Utama', jenis:'Pemeliharaan Rutin', tgl:'10 Jan 2025', biaya:'Rp 5.000.000', status:'Selesai' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td><td class="px-4 py-3 font-medium text-navy-900">${it.item}</td>
    <td class="px-4 py-3">${it.jenis}</td><td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3 font-mono text-xs">${it.biaya}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Selesai'?'success':'warning')}</td>
  </tr>`).join('');
  return `<div class="flex justify-end mb-4"><button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Tambah Pemeliharaan</button></div>` + tableWrap(['ID','Item','Jenis','Tanggal','Biaya','Status'], rows);
}

function getPenyewaanHTML() {
  const items = [
    { id:'SEW-001', fasilitas:'Aula Utama', penyewa:'Dinas Pendidikan', tgl:'20-21 Jan 2025', harga:'Rp 5.000.000', status:'Aktif' },
    { id:'SEW-002', fasilitas:'Ruang Rapat VIP', penyewa:'LPMP Sulut', tgl:'18 Jan 2025', harga:'Rp 1.000.000', status:'Selesai' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td><td class="px-4 py-3 font-medium text-navy-900">${it.fasilitas}</td>
    <td class="px-4 py-3">${it.penyewa}</td><td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3 font-mono text-xs">${it.harga}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Aktif'?'info':'success')}</td>
  </tr>`).join('');
  return `<div class="flex justify-end mb-4"><button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Tambah Penyewaan</button></div>` + tableWrap(['ID','Fasilitas','Penyewa','Tanggal','Harga','Status'], rows);
}

function getKondisiHTML() {
  const items = [
    { nama:'Gedung Utama', kondisi:'Baik', skor:92, terakhir:'Jan 2025' },
    { nama:'Aula Serbaguna', kondisi:'Baik', skor:88, terakhir:'Jan 2025' },
    { nama:'Pos Satpam', kondisi:'Rusak Ringan', skor:65, terakhir:'Des 2024' },
    { nama:'Gudang Belakang', kondisi:'Rusak Ringan', skor:58, terakhir:'Des 2024' },
  ];
  return `<div class="grid md:grid-cols-2 gap-4">${items.map(it => `
    <div class="bg-white rounded-xl border border-slate-100 p-5 card-hover">
      <div class="flex items-center justify-between mb-3">
        <h4 class="font-bold text-navy-900">${it.nama}</h4>
        ${badgeHTML(it.kondisi, it.kondisi==='Baik'?'success':'warning')}
      </div>
      <div class="flex items-center gap-3 mb-2">
        <div class="flex-1 bg-slate-100 rounded-full h-3"><div class="h-3 rounded-full ${it.skor>=80?'bg-green-500':it.skor>=60?'bg-amber-500':'bg-red-500'}" style="width:${it.skor}%"></div></div>
        <span class="text-sm font-bold text-navy-700">${it.skor}%</span>
      </div>
      <p class="text-xs text-slate-400">Inspeksi terakhir: ${it.terakhir}</p>
    </div>`).join('')}</div>`;
}

function getPenyusutanHTML() {
  const items = [
    { kode:'AST-002', nama:'Laptop ASUS VivoBook', nilai_perolehan:'Rp 12.500.000', umur:'4 tahun', penyusutan:'Rp 3.125.000', nilai_buku:'Rp 9.375.000' },
    { kode:'AST-004', nama:'Proyektor Epson EB-X51', nilai_perolehan:'Rp 8.900.000', umur:'4 tahun', penyusutan:'Rp 2.225.000', nilai_buku:'Rp 6.675.000' },
    { kode:'AST-005', nama:'Server Dell PowerEdge', nilai_perolehan:'Rp 85.000.000', umur:'4 tahun', penyusutan:'Rp 21.250.000', nilai_buku:'Rp 63.750.000' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.kode}</td><td class="px-4 py-3 font-medium text-navy-900">${it.nama}</td>
    <td class="px-4 py-3 font-mono text-xs">${it.nilai_perolehan}</td><td class="px-4 py-3">${it.umur}</td>
    <td class="px-4 py-3 font-mono text-xs text-red-500">${it.penyusutan}</td>
    <td class="px-4 py-3 font-mono text-xs font-semibold">${it.nilai_buku}</td>
  </tr>`).join('');
  return tableWrap(['Kode','Nama Aset','Nilai Perolehan','Umur Ekonomis','Penyusutan/Thn','Nilai Buku'], rows);
}

function getMutasiHTML() {
  const items = [
    { id:'MUT-001', aset:'Laptop Dell Latitude', dari:'Sekretariat', ke:'Bidang PMP', tgl:'14 Jan 2025', status:'Proses' },
    { id:'MUT-002', aset:'Kursi Kerja x5', dari:'Gudang', ke:'Ruang Rapat', tgl:'10 Jan 2025', status:'Selesai' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td><td class="px-4 py-3 font-medium text-navy-900">${it.aset}</td>
    <td class="px-4 py-3">${it.dari}</td><td class="px-4 py-3">${it.ke}</td><td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status==='Selesai'?'success':'warning')}</td>
  </tr>`).join('');
  return `<div class="flex justify-end mb-4"><button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Buat Mutasi</button></div>` + tableWrap(['ID','Aset','Dari','Ke','Tanggal','Status'], rows);
}

function getPenghapusanHTML() {
  const items = [
    { id:'HPS-001', aset:'Printer HP LaserJet P1102', alasan:'Rusak Berat', nilai:'Rp 2.800.000', tgl:'12 Jan 2025', status:'Menunggu Approval' },
    { id:'HPS-002', aset:'UPS APC 600VA', alasan:'Tidak Ekonomis', nilai:'Rp 850.000', tgl:'8 Jan 2025', status:'Disetujui' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td><td class="px-4 py-3 font-medium text-navy-900">${it.aset}</td>
    <td class="px-4 py-3">${it.alasan}</td><td class="px-4 py-3 font-mono text-xs">${it.nilai}</td><td class="px-4 py-3 text-xs">${it.tgl}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, it.status.includes('Menunggu')?'warning':'success')}</td>
  </tr>`).join('');
  return `<div class="flex justify-end mb-4"><button class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg flex items-center gap-2"><i data-lucide="plus" class="w-4 h-4"></i>Ajukan Penghapusan</button></div>` + tableWrap(['ID','Aset','Alasan','Nilai','Tanggal','Status'], rows);
}

// ===== APPROVAL PAGES =====
function getApprovalPersediaanHTML() {
  const rows = pegawaiPermintaanPersediaan.map(pp => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${pp.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${pp.barang}</td>
    <td class="px-4 py-3">${pp.qty} ${pp.satuan}</td>
    <td class="px-4 py-3">${pp.peminjam}</td>
    <td class="px-4 py-3 text-xs">${pp.tgl_permintaan}</td>
    <td class="px-4 py-3 text-sm text-slate-600">${pp.tujuan}</td>
    <td class="px-4 py-3">${badgeHTML(pp.status, pp.status === 'Menunggu Approval' ? 'warning' : pp.status === 'Diteruskan ke Kasubag' ? 'info' : 'danger')}</td>
    <td class="px-4 py-3">
      ${pp.status === 'Menunggu Approval' ? `
        <div class="flex gap-2">
          <button onclick="forwardPersediaan('${pp.id}')" class="text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded transition"><i data-lucide="arrow-right" class="w-3 h-3 inline mr-1"></i>Teruskan</button>
          <button onclick="rejectPersediaan('${pp.id}')" class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition"><i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Tolak</button>
        </div>
      ` : '<span class="text-slate-400 text-xs">—</span>'}
    </td>
  </tr>`).join('');
  
  return `<div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-navy-900">Persetujuan Permintaan Persediaan</h3>
      <p class="text-sm text-slate-400 mt-1">Verifikasi dan teruskan permintaan persediaan dari pegawai</p>
    </div>
    <span class="badge bg-amber-100 text-amber-700">${pegawaiPermintaanPersediaan.filter(p => p.status === 'Menunggu Approval').length} Menunggu</span>
  </div>` + tableWrap(['ID', 'Barang', 'Qty', 'Peminta', 'Tgl Permintaan', 'Tujuan', 'Status', 'Aksi'], rows);
}

function getApprovalPeminjamanHTML() {
  const allPeminjaman = [...pegawaiPeminjamanBarang, ...pegawaiPeminjamanKendaraan];
  const rows = allPeminjaman.map(pm => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${pm.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${pm.barang || pm.kendaraan}</td>
    <td class="px-4 py-3">${pm.qty || '1'}</td>
    <td class="px-4 py-3">${pm.peminjam}</td>
    <td class="px-4 py-3 text-xs">${pm.tgl_pinjam} s/d ${pm.tgl_kembali}</td>
    <td class="px-4 py-3 text-sm text-slate-600">${pm.tujuan}</td>
    <td class="px-4 py-3">${badgeHTML(pm.status, pm.status === 'Aktif' ? 'info' : pm.status === 'Dikembalikan' ? 'success' : 'warning')}</td>
    <td class="px-4 py-3">
      ${pm.status === 'Aktif' ? `
        <div class="flex gap-2">
          <button onclick="forwardPeminjaman('${pm.id}')" class="text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded transition"><i data-lucide="arrow-right" class="w-3 h-3 inline mr-1"></i>Teruskan</button>
          <button onclick="rejectPeminjaman('${pm.id}')" class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition"><i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Tolak</button>
        </div>
      ` : '<span class="text-slate-400 text-xs">—</span>'}
    </td>
  </tr>`).join('');
  
  return `<div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-navy-900">Persetujuan Peminjaman Barang & Kendaraan</h3>
      <p class="text-sm text-slate-400 mt-1">Verifikasi dan teruskan peminjaman aset dari pegawai</p>
    </div>
    <span class="badge bg-amber-100 text-amber-700">${allPeminjaman.filter(p => p.status === 'Aktif').length} Menunggu</span>
  </div>` + tableWrap(['ID', 'Barang/Kendaraan', 'Qty', 'Peminjam', 'Tgl Pinjam - Kembali', 'Tujuan', 'Status', 'Aksi'], rows);
}

function getApprovalSewaHTML() {
  const rows = tamuPeminjamanRequests.map(req => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${req.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${req.nama}</td>
    <td class="px-4 py-3">${req.contact}</td>
    <td class="px-4 py-3 text-xs">${req.tgl_permintaan}</td>
    <td class="px-4 py-3 text-xs">${req.tgl_pinjam} s/d ${req.tgl_kembali}</td>
    <td class="px-4 py-3 text-sm text-slate-600">${req.tujuan}</td>
    <td class="px-4 py-3">${badgeHTML(req.status, req.status === 'Disetujui' ? 'success' : req.status === 'Menunggu Approval' ? 'warning' : 'danger')}</td>
    <td class="px-4 py-3">
      ${req.status === 'Menunggu Approval' ? `
        <div class="flex gap-2">
          <button onclick="forwardSewa('${req.id}')" class="text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-2.5 py-1.5 rounded transition"><i data-lucide="arrow-right" class="w-3 h-3 inline mr-1"></i>Teruskan</button>
          <button onclick="rejectSewa('${req.id}')" class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition"><i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Tolak</button>
        </div>
      ` : '<span class="text-slate-400 text-xs">—</span>'}
    </td>
  </tr>`).join('');
  
  return `<div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-navy-900">Persetujuan Sewa Fasilitas</h3>
      <p class="text-sm text-slate-400 mt-1">Verifikasi dan teruskan permintaan sewa dari tamu/instansi</p>
    </div>
    <span class="badge bg-amber-100 text-amber-700">${tamuPeminjamanRequests.filter(p => p.status === 'Menunggu Approval').length} Menunggu</span>
  </div>` + tableWrap(['ID', 'Fasilitas', 'Instansi', 'Tgl Permintaan', 'Tgl Sewa', 'Tujuan', 'Status', 'Aksi'], rows);
}

function getRiwayatHTML() {
  const items = [
    { id:'PMJ-2024-018', barang:'Projector Epson', tgl_pinjam:'10 Des 2024', tgl_kembali:'12 Des 2024', status:'Dikembalikan' },
    { id:'PMJ-2024-015', barang:'Laptop Dell x2', tgl_pinjam:'1 Nov 2024', tgl_kembali:'5 Nov 2024', status:'Dikembalikan' },
    { id:'PMJ-2024-012', barang:'Kamera Canon', tgl_pinjam:'15 Okt 2024', tgl_kembali:'17 Okt 2024', status:'Dikembalikan' },
  ];
  const rows = items.map(it => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${it.id}</td><td class="px-4 py-3 font-medium text-navy-900">${it.barang}</td>
    <td class="px-4 py-3 text-xs">${it.tgl_pinjam}</td><td class="px-4 py-3 text-xs">${it.tgl_kembali}</td>
    <td class="px-4 py-3">${badgeHTML(it.status, 'success')}</td>
  </tr>`).join('');
  return tableWrap(['ID','Barang','Tgl Pinjam','Tgl Kembali','Status'], rows);
}

function getProfilHTML() {
  return `<div class="max-w-lg">
    <div class="bg-white rounded-xl border border-slate-100 p-6">
      <div class="flex items-center gap-4 mb-6">
        <div class="w-16 h-16 rounded-2xl bg-navy-100 flex items-center justify-center text-navy-600 font-bold text-xl">${currentUser.name.split(' ').map(w=>w[0]).join('').substring(0,2).toUpperCase()}</div>
        <div><h3 class="font-bold text-navy-900 text-lg">${currentUser.name}</h3><p class="text-slate-400 text-sm">${currentUser.label}</p></div>
      </div>
      <div class="space-y-3">
        <div class="flex justify-between py-2 border-b border-slate-50"><span class="text-slate-400 text-sm">Username</span><span class="font-medium text-navy-900 text-sm">${currentUser.username}</span></div>
        <div class="flex justify-between py-2 border-b border-slate-50"><span class="text-slate-400 text-sm">NIP</span><span class="font-medium text-navy-900 text-sm">${currentUser.nip||'198501012010012001'}</span></div>
        <div class="flex justify-between py-2 border-b border-slate-50"><span class="text-slate-400 text-sm">Role</span><span class="font-medium text-navy-900 text-sm">${currentUser.label}</span></div>
        <div class="flex justify-between py-2"><span class="text-slate-400 text-sm">Status</span>${badgeHTML('Aktif','success')}</div>
      </div>
    </div>
  </div>`;
}

// ===== PEGAWAI PAGES =====
function getPeminjamanKendaraanHTML() {
  return `<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
      <div class="bg-white rounded-xl border border-slate-100 p-6 sticky top-4">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600"></i>Buat Peminjaman</h3>
        <form onsubmit="handlePeminjamanKendaraanSubmit(event)">
          <div class="mb-4"><label for="pknKendaraan" class="block text-sm font-medium text-navy-800 mb-1.5">Pilih Kendaraan *</label><select id="pknKendaraan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white" required><option value="">-- Pilih Kendaraan --</option><option value="Minibus Toyota HiAce">Minibus Toyota HiAce</option><option value="Kendaraan Dinas Roda 4 - Toyota Avanza">Kendaraan Dinas Roda 4 - Toyota Avanza</option><option value="Kendaraan Dinas Roda 4 - Honda Odyssey">Kendaraan Dinas Roda 4 - Honda Odyssey</option></select></div>
          <div class="mb-4"><label for="pknTglPinjam" class="block text-sm font-medium text-navy-800 mb-1.5">Tanggal Pinjam *</label><input id="pknTglPinjam" type="date" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" required></div>
          <div class="mb-4"><label for="pknTglKembali" class="block text-sm font-medium text-navy-800 mb-1.5">Tanggal Kembali *</label><input id="pknTglKembali" type="date" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" required></div>
          <div class="mb-4"><label for="pknTujuan" class="block text-sm font-medium text-navy-800 mb-1.5">Tujuan Perjalanan *</label><textarea id="pknTujuan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm resize-none" rows="3" placeholder="Jelaskan tujuan perjalanan..." required></textarea></div>
          <div class="mb-4"><label for="pknDriver" class="block text-sm font-medium text-navy-800 mb-1.5">Nama Driver *</label><input id="pknDriver" type="text" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Nama driver dinas" required></div>
          <button type="submit" class="w-full btn-primary text-white font-semibold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2"><i data-lucide="send" class="w-4 h-4"></i>Kirim Permintaan</button>
        </form>
      </div>
    </div>
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl border border-slate-100 p-6">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="history" class="w-5 h-5 text-navy-600"></i>Riwayat Peminjaman Kendaraan</h3>
        <div class="space-y-3">${pegawaiPeminjamanKendaraan.map(pk => `<div class="border border-slate-100 rounded-lg p-4 hover:border-blue-300 transition"><div class="flex items-start justify-between mb-3"><div><h4 class="font-semibold text-navy-900">${pk.kendaraan}</h4><p class="text-xs text-slate-400">${pk.id}</p></div>${pk.status === 'Aktif' ? '<span class="badge bg-blue-100 text-blue-700">'+pk.status+'</span>' : pk.status === 'Dikembalikan' ? '<span class="badge bg-green-100 text-green-700">'+pk.status+'</span>' : '<span class="badge bg-amber-100 text-amber-700">'+pk.status+'</span>'}</div><div class="grid grid-cols-2 gap-3 mb-3 text-xs"><div><span class="text-slate-400">Tgl Pinjam - Kembali</span><p class="font-medium text-navy-900">${pk.tgl_pinjam} s/d ${pk.tgl_kembali}</p></div><div><span class="text-slate-400">Driver</span><p class="font-medium text-navy-900">${pk.driver}</p></div><div class="col-span-2"><span class="text-slate-400">Tujuan</span><p class="font-medium text-navy-900">${pk.tujuan}</p></div></div><div class="flex gap-2"><button class="flex-1 text-xs font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 py-2 rounded-lg transition">Detail</button>${pk.status === 'Aktif' ? '<button class="flex-1 text-xs font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 py-2 rounded-lg transition">Laporkan Kembalian</button>' : ''}</div></div>`).join('')}</div>
      </div>
    </div>
  </div>`;
}

function getPeminjamanBarangHTML() {
  return `<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
      <div class="bg-white rounded-xl border border-slate-100 p-6 sticky top-4">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600"></i>Buat Peminjaman</h3>
        <form onsubmit="handlePeminjamanBarangSubmit(event)">
          <div class="mb-4"><label for="pkbBarang" class="block text-sm font-medium text-navy-800 mb-1.5">Pilih Barang *</label><select id="pkbBarang" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white" required><option value="">-- Pilih Barang --</option><option value="Proyektor Epson EB-X51">Proyektor Epson EB-X51</option><option value="Laptop ASUS VivoBook">Laptop ASUS VivoBook</option><option value="Kamera Canon EOS 5D Mark IV">Kamera Canon EOS 5D Mark IV</option><option value="Speaker Portable JBL">Speaker Portable JBL</option><option value="Server Dell PowerEdge">Server Dell PowerEdge</option></select></div>
          <div class="mb-4"><label for="pkbQty" class="block text-sm font-medium text-navy-800 mb-1.5">Jumlah *</label><input id="pkbQty" type="number" min="1" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Jumlah barang" required></div>
          <div class="mb-4"><label for="pkbTglPinjam" class="block text-sm font-medium text-navy-800 mb-1.5">Tanggal Pinjam *</label><input id="pkbTglPinjam" type="date" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" required></div>
          <div class="mb-4"><label for="pkbTglKembali" class="block text-sm font-medium text-navy-800 mb-1.5">Tanggal Kembali *</label><input id="pkbTglKembali" type="date" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" required></div>
          <div class="mb-4"><label for="pkbTujuan" class="block text-sm font-medium text-navy-800 mb-1.5">Tujuan Penggunaan *</label><textarea id="pkbTujuan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm resize-none" rows="3" placeholder="Jelaskan tujuan peminjaman..." required></textarea></div>
          <button type="submit" class="w-full btn-primary text-white font-semibold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2"><i data-lucide="send" class="w-4 h-4"></i>Kirim Permintaan</button>
        </form>
      </div>
    </div>
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl border border-slate-100 p-6">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="history" class="w-5 h-5 text-navy-600"></i>Riwayat Peminjaman Barang</h3>
        <div class="space-y-3">${pegawaiPeminjamanBarang.map(pb => `<div class="border border-slate-100 rounded-lg p-4 hover:border-blue-300 transition"><div class="flex items-start justify-between mb-3"><div><h4 class="font-semibold text-navy-900">${pb.barang}</h4><p class="text-xs text-slate-400">${pb.id}</p></div>${pb.status === 'Aktif' ? '<span class="badge bg-blue-100 text-blue-700">'+pb.status+'</span>' : pb.status === 'Dikembalikan' ? '<span class="badge bg-green-100 text-green-700">'+pb.status+'</span>' : '<span class="badge bg-amber-100 text-amber-700">'+pb.status+'</span>'}</div><div class="grid grid-cols-2 gap-3 mb-3 text-xs"><div><span class="text-slate-400">Qty</span><p class="font-medium text-navy-900">${pb.qty} Unit</p></div><div><span class="text-slate-400">Lokasi Penyimpanan</span><p class="font-medium text-navy-900">${pb.lokasi}</p></div><div><span class="text-slate-400">Tgl Pinjam - Kembali</span><p class="font-medium text-navy-900">${pb.tgl_pinjam} s/d ${pb.tgl_kembali}</p></div><div><span class="text-slate-400">Tujuan</span><p class="font-medium text-navy-900">${pb.tujuan}</p></div></div><div class="flex gap-2"><button class="flex-1 text-xs font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 py-2 rounded-lg transition">Detail</button>${pb.status === 'Aktif' ? '<button class="flex-1 text-xs font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 py-2 rounded-lg transition">Laporkan Kembalian</button>' : ''}</div></div>`).join('')}</div>
      </div>
    </div>
  </div>`;
}

function getPermintaanPersediaanHTML() {
  return `<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
      <div class="bg-white rounded-xl border border-slate-100 p-6 sticky top-4">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600"></i>Buat Permintaan</h3>
        <form onsubmit="handlePermintaanPersediaanSubmit(event)">
          <div class="mb-4"><label for="prpBarang" class="block text-sm font-medium text-navy-800 mb-1.5">Pilih Barang *</label><select id="prpBarang" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white" required><option value="">-- Pilih Barang --</option><option value="Kertas HVS A4 70gr">Kertas HVS A4 70gr</option><option value="Tinta Printer HP 680">Tinta Printer HP 680</option><option value="Pulpen Pilot G1 0.7mm">Pulpen Pilot G1 0.7mm</option><option value="Map Ordner Folio">Map Ordner Folio</option><option value="Amplop Coklat F4">Amplop Coklat F4</option><option value="Binder Clip No.155">Binder Clip No.155</option></select></div>
          <div class="mb-4"><label for="prpQty" class="block text-sm font-medium text-navy-800 mb-1.5">Jumlah *</label><input id="prpQty" type="number" min="1" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Jumlah barang" required></div>
          <div class="mb-4"><label for="prpSatuan" class="block text-sm font-medium text-navy-800 mb-1.5">Satuan *</label><select id="prpSatuan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white" required><option value="">-- Pilih Satuan --</option><option value="Rim">Rim</option><option value="Pcs">Pcs</option><option value="Box">Box</option><option value="Lembar">Lembar</option><option value="Set">Set</option></select></div>
          <div class="mb-4"><label for="prpTujuan" class="block text-sm font-medium text-navy-800 mb-1.5">Tujuan Penggunaan *</label><textarea id="prpTujuan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm resize-none" rows="3" placeholder="Jelaskan kebutuhan dan tujuan..." required></textarea></div>
          <button type="submit" class="w-full btn-primary text-white font-semibold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2"><i data-lucide="send" class="w-4 h-4"></i>Kirim Permintaan</button>
        </form>
      </div>
    </div>
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl border border-slate-100 p-6">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="history" class="w-5 h-5 text-navy-600"></i>Riwayat Permintaan Persediaan</h3>
        <div class="space-y-3">${pegawaiPermintaanPersediaan.map(pp => `<div class="border border-slate-100 rounded-lg p-4 hover:border-blue-300 transition"><div class="flex items-start justify-between mb-3"><div><h4 class="font-semibold text-navy-900">${pp.barang}</h4><p class="text-xs text-slate-400">${pp.id}</p></div>${pp.status === 'Disetujui' ? '<span class="badge bg-green-100 text-green-700">'+pp.status+'</span>' : pp.status === 'Menunggu Approval' ? '<span class="badge bg-amber-100 text-amber-700">'+pp.status+'</span>' : '<span class="badge bg-red-100 text-red-700">'+pp.status+'</span>'}</div><div class="grid grid-cols-2 gap-3 mb-3 text-xs"><div><span class="text-slate-400">Jumlah</span><p class="font-medium text-navy-900">${pp.qty} ${pp.satuan}</p></div><div><span class="text-slate-400">Tgl Permintaan</span><p class="font-medium text-navy-900">${pp.tgl_permintaan}</p></div><div class="col-span-2"><span class="text-slate-400">Tujuan</span><p class="font-medium text-navy-900">${pp.tujuan}</p></div></div><div class="text-xs text-slate-400 mb-2">Tgl Disetujui: <span class="font-medium text-navy-900">${pp.tgl_disetujui}</span></div><button class="w-full text-xs font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 py-2 rounded-lg transition">Detail</button></div>`).join('')}</div>
      </div>
    </div>
  </div>`;
}

function handlePeminjamanKendaraanSubmit(e) {
  e.preventDefault();
  const kendaraan = document.getElementById('pknKendaraan').value;
  const tglPinjam = document.getElementById('pknTglPinjam').value;
  const tglKembali = document.getElementById('pknTglKembali').value;
  const tujuan = document.getElementById('pknTujuan').value.trim();
  const driver = document.getElementById('pknDriver').value.trim();
  const today = new Date().toISOString().split('T')[0];
  if (tglPinjam < today) { showToast('Tanggal pinjam tidak boleh kurang dari hari ini!', 'warning'); return; }
  if (tglKembali < tglPinjam) { showToast('Tanggal kembali harus lebih besar atau sama dengan tanggal pinjam!', 'warning'); return; }
  const newPeminjaman = { id:'PKN-2025-'+String(pegawaiPeminjamanKendaraan.length + 1).padStart(3, '0'), kendaraan, tgl_pinjam:tglPinjam, tgl_kembali:tglKembali, tujuan, peminjam:currentUser.name, status:'Aktif', driver };
  pegawaiPeminjamanKendaraan.unshift(newPeminjaman);
  document.getElementById('pknKendaraan').value = '';
  document.getElementById('pknTglPinjam').value = '';
  document.getElementById('pknTglKembali').value = '';
  document.getElementById('pknTujuan').value = '';
  document.getElementById('pknDriver').value = '';
  navigateTo('peminjaman_kendaraan');
  showToast('Permintaan peminjaman kendaraan berhasil dikirim!', 'success');
}

function handlePeminjamanBarangSubmit(e) {
  e.preventDefault();
  const barang = document.getElementById('pkbBarang').value;
  const qty = parseInt(document.getElementById('pkbQty').value);
  const tglPinjam = document.getElementById('pkbTglPinjam').value;
  const tglKembali = document.getElementById('pkbTglKembali').value;
  const tujuan = document.getElementById('pkbTujuan').value.trim();
  const today = new Date().toISOString().split('T')[0];
  if (tglPinjam < today) { showToast('Tanggal pinjam tidak boleh kurang dari hari ini!', 'warning'); return; }
  if (tglKembali < tglPinjam) { showToast('Tanggal kembali harus lebih besar atau sama dengan tanggal pinjam!', 'warning'); return; }
  const newPeminjaman = { id:'PKB-2025-'+String(pegawaiPeminjamanBarang.length + 1).padStart(3, '0'), barang, qty, tgl_pinjam:tglPinjam, tgl_kembali:tglKembali, tujuan, peminjam:currentUser.name, status:'Aktif', lokasi:'Ruang Penyimpanan' };
  pegawaiPeminjamanBarang.unshift(newPeminjaman);
  document.getElementById('pkbBarang').value = '';
  document.getElementById('pkbQty').value = '';
  document.getElementById('pkbTglPinjam').value = '';
  document.getElementById('pkbTglKembali').value = '';
  document.getElementById('pkbTujuan').value = '';
  navigateTo('peminjaman_barang');
  showToast('Permintaan peminjaman barang berhasil dikirim!', 'success');
}

function handlePermintaanPersediaanSubmit(e) {
  e.preventDefault();
  const barang = document.getElementById('prpBarang').value;
  const qty = parseInt(document.getElementById('prpQty').value);
  const satuan = document.getElementById('prpSatuan').value;
  const tujuan = document.getElementById('prpTujuan').value.trim();
  const today_date = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
  const newPermintaan = { id:'PRP-2025-'+String(pegawaiPermintaanPersediaan.length + 1).padStart(3, '0'), barang, qty, satuan, tgl_permintaan:today_date, tujuan, peminjam:currentUser.name, status:'Menunggu Approval', tgl_disetujui:'-' };
  pegawaiPermintaanPersediaan.unshift(newPermintaan);
  document.getElementById('prpBarang').value = '';
  document.getElementById('prpQty').value = '';
  document.getElementById('prpSatuan').value = '';
  document.getElementById('prpTujuan').value = '';
  navigateTo('permintaan_persediaan');
  showToast('Permintaan persediaan berhasil dikirim! Tunggu konfirmasi dari Admin Persediaan.', 'success');
}

// ===== TAMU PAGES =====
function getStatistikUmumHTML() {
  return `<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    ${statCard('database','Total Item BMN','1,247','bg-navy-600','')}
    ${statCard('trending-up','Nilai Aset','Rp 28.5M','bg-emerald-500','')}
    ${statCard('repeat','Transaksi Bulan Ini','342','bg-amber-500','')}
    ${statCard('check-circle','Kondisi Baik','98.5%','bg-green-500','')}
  </div>
  <div class="bg-white rounded-xl border border-slate-100 p-6">
    <h3 class="font-bold text-navy-900 mb-4">Perincian BMN per Kategori</h3>
    <div class="space-y-4">
      ${[
        { label:'Peralatan & Mesin', val:420, max:500, color:'bg-blue-500', icon:'cpu' },
        { label:'Gedung & Bangunan', val:85, max:500, color:'bg-emerald-500', icon:'building' },
        { label:'Tanah', val:12, max:500, color:'bg-amber-500', icon:'map' },
        { label:'Kendaraan', val:35, max:500, color:'bg-purple-500', icon:'truck' },
        { label:'Persediaan', val:391, max:500, color:'bg-cyan-500', icon:'package' },
        { label:'Aset Lainnya', val:304, max:500, color:'bg-rose-500', icon:'box' },
      ].map(b => `<div class="flex items-center gap-4">
        <div class="w-10 h-10 ${b.color} rounded-lg flex items-center justify-center flex-shrink-0"><i data-lucide="${b.icon}" class="w-5 h-5 text-white"></i></div>
        <div class="flex-1">
          <div class="flex justify-between text-sm mb-1"><span class="font-medium text-navy-900">${b.label}</span><span class="font-bold text-navy-700">${b.val}</span></div>
          <div class="w-full bg-slate-100 rounded-full h-2.5"><div class="${b.color} h-2.5 rounded-full transition-all duration-700" style="width:${(b.val/b.max)*100}%"></div></div>
        </div>
      </div>`).join('')}
    </div>
  </div>`;
}

function getFasilitasInfoHTML() {
  const items = FACILITIES.map(f => `
    <div class="bg-gradient-to-br ${f.color} rounded-xl p-6 text-white card-hover">
      <div class="flex items-start justify-between mb-4">
        <div><h4 class="font-bold text-lg mb-1">${f.name}</h4><p class="text-white/80 text-sm">${f.desc}</p></div>
        <i data-lucide="${f.icon}" class="w-8 h-8 text-white/70 flex-shrink-0"></i>
      </div>
      <div class="grid grid-cols-2 gap-3">
        <div class="bg-white/15 backdrop-blur rounded-lg px-3 py-2">
          <div class="text-xs text-white/70">Harga Sewa</div>
          <div class="font-bold text-sm">${f.price}</div>
        </div>
        <div class="bg-white/15 backdrop-blur rounded-lg px-3 py-2">
          <div class="text-xs text-white/70">Kapasitas</div>
          <div class="font-bold text-sm">${f.capacity}</div>
        </div>
      </div>
      <button class="w-full mt-3 bg-white/20 hover:bg-white/30 text-white font-semibold py-2 rounded-lg transition text-sm">
        <i data-lucide="phone" class="w-4 h-4 inline mr-2"></i>Hubungi untuk Sewa
      </button>
    </div>
  `).join('');

  return `<div class="mb-4">
    <p class="text-slate-600 text-sm">Daftar lengkap fasilitas yang tersedia untuk disewa atau dipinjam oleh masyarakat umum.</p>
  </div>
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">${items}</div>`;
}

function getKontakBPMPHTML() {
  return `<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-100 p-6">
      <h3 class="font-bold text-navy-900 mb-6 flex items-center gap-2"><i data-lucide="info" class="w-5 h-5 text-navy-600"></i>Informasi Kontak</h3>
      <div class="space-y-5">
        <div class="flex gap-4">
          <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="map-pin" class="w-6 h-6 text-blue-600"></i></div>
          <div><h4 class="font-semibold text-navy-900 text-sm mb-1">Alamat</h4><p class="text-slate-500 text-sm">Jl. Prof. Dr. H. Aloei Saboe, Kel. Wongkaditi Timur, Kec. Kota Utara, Kota Gorontalo, Gorontalo 96128</p></div>
        </div>
        <div class="flex gap-4">
          <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="phone" class="w-6 h-6 text-green-600"></i></div>
          <div><h4 class="font-semibold text-navy-900 text-sm mb-1">Telepon</h4><p class="text-slate-500 text-sm">(0435) 821-555</p></div>
        </div>
        <div class="flex gap-4">
          <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="mail" class="w-6 h-6 text-purple-600"></i></div>
          <div><h4 class="font-semibold text-navy-900 text-sm mb-1">Email</h4><p class="text-slate-500 text-sm">bpmp.gorontalo@kemdikbud.go.id</p></div>
        </div>
        <div class="flex gap-4">
          <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0"><i data-lucide="clock" class="w-6 h-6 text-amber-600"></i></div>
          <div><h4 class="font-semibold text-navy-900 text-sm mb-1">Jam Operasional</h4><p class="text-slate-500 text-sm">Senin - Jumat: 08.00 - 16.00 WITA<br>Istirahat: 12.00 - 13.00 WITA</p></div>
        </div>
      </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-100 p-6">
      <h3 class="font-bold text-navy-900 mb-6 flex items-center gap-2"><i data-lucide="help-circle" class="w-5 h-5 text-navy-600"></i>Pertanyaan Umum</h3>
      <div class="space-y-4">
        <div class="pb-4 border-b border-slate-100">
          <h4 class="font-semibold text-navy-900 text-sm mb-2">Bagaimana cara menyewa fasilitas?</h4>
          <p class="text-slate-500 text-sm">Hubungi bagian Tata Usaha BPMP Gorontalo melalui telepon atau email, kemudian akan dijelaskan prosedur dan persyaratan peminjaman.</p>
        </div>
        <div class="pb-4 border-b border-slate-100">
          <h4 class="font-semibold text-navy-900 text-sm mb-2">Apa syarat menyewa Aula Utama?</h4>
          <p class="text-slate-500 text-sm">Silakan hubungi kami untuk mengetahui detail persyaratan, ketersediaan jadwal, dan harga khusus untuk acara tertentu.</p>
        </div>
        <div>
          <h4 class="font-semibold text-navy-900 text-sm mb-2">Apakah ada potongan harga grup?</h4>
          <p class="text-slate-500 text-sm">Tersedia paket khusus untuk penyewaan dalam jumlah besar. Hubungi kami untuk konsultasi lebih lanjut.</p>
        </div>
      </div>
    </div>
  </div>`;
}

function getPermintaanPeminjamanHTML() {
  return `<div class="grid lg:grid-cols-3 gap-6">
    <!-- Form Permintaan Peminjaman -->
    <div class="lg:col-span-1">
      <div class="bg-white rounded-xl border border-slate-100 p-6 sticky top-4">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="plus-circle" class="w-5 h-5 text-emerald-600"></i>Buat Permintaan</h3>
        <form onsubmit="handleTamuPeminjamanSubmit(event)">
          <div class="mb-4">
            <label for="tamuPeminjamanNama" class="block text-sm font-medium text-navy-800 mb-1.5">Nama Lengkap *</label>
            <input id="tamuPeminjamanNama" type="text" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Nama Anda" required>
          </div>
          <div class="mb-4">
            <label for="tamuPeminjamanInstansi" class="block text-sm font-medium text-navy-800 mb-1.5">Instansi/Lembaga *</label>
            <input id="tamuPeminjamanInstansi" type="text" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Nama instansi" required>
          </div>
          <div class="mb-4">
            <label for="tamuPeminjamanFasilitas" class="block text-sm font-medium text-navy-800 mb-1.5">Fasilitas *</label>
            <select id="tamuPeminjamanFasilitas" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white" required>
              <option value="">-- Pilih Fasilitas --</option>
              <option value="Aula Utama BPMP">Aula Utama BPMP</option>
              <option value="Ruang Rapat VIP">Ruang Rapat VIP</option>
              <option value="Lab Komputer">Lab Komputer</option>
              <option value="Ruang Pelatihan A">Ruang Pelatihan A</option>
              <option value="Kendaraan Dinas - Minibus">Kendaraan Dinas - Minibus</option>
              <option value="Gedung Serbaguna">Gedung Serbaguna</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="tamuPeminjamanTglPinjam" class="block text-sm font-medium text-navy-800 mb-1.5">Tanggal Pinjam *</label>
            <input id="tamuPeminjamanTglPinjam" type="date" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" required>
          </div>
          <div class="mb-4">
            <label for="tamuPeminjamanTglKembali" class="block text-sm font-medium text-navy-800 mb-1.5">Tanggal Kembali *</label>
            <input id="tamuPeminjamanTglKembali" type="date" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" required>
          </div>
          <div class="mb-4">
            <label for="tamuPeminjamanTujuan" class="block text-sm font-medium text-navy-800 mb-1.5">Tujuan Penggunaan *</label>
            <textarea id="tamuPeminjamanTujuan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm resize-none" rows="3" placeholder="Jelaskan tujuan peminjaman..." required></textarea>
          </div>
          <div class="mb-4">
            <label for="tamuPeminjamanKontak" class="block text-sm font-medium text-navy-800 mb-1.5">Nomor Kontak *</label>
            <input id="tamuPeminjamanKontak" type="tel" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm" placeholder="Nomor telepon/WhatsApp" required>
          </div>
          <button type="submit" class="w-full btn-primary text-white font-semibold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2">
            <i data-lucide="send" class="w-4 h-4"></i>Kirim Permintaan
          </button>
        </form>
      </div>
    </div>

    <!-- Riwayat Permintaan -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-xl border border-slate-100 p-6">
        <h3 class="font-bold text-navy-900 mb-4 flex items-center gap-2"><i data-lucide="history" class="w-5 h-5 text-navy-600"></i>Riwayat Permintaan Peminjaman</h3>
        <div class="space-y-3">
          ${tamuPeminjamanRequests.map(req => `
            <div class="border border-slate-100 rounded-lg p-4 hover:border-blue-300 transition">
              <div class="flex items-start justify-between mb-3">
                <div>
                  <h4 class="font-semibold text-navy-900">${req.nama}</h4>
                  <p class="text-xs text-slate-400">${req.id}</p>
                </div>
                ${req.status === 'Disetujui' ? '<span class="badge bg-green-100 text-green-700">' + req.status + '</span>' : req.status === 'Menunggu Approval' ? '<span class="badge bg-amber-100 text-amber-700">' + req.status + '</span>' : '<span class="badge bg-red-100 text-red-700">' + req.status + '</span>'}
              </div>
              <div class="grid grid-cols-2 gap-3 mb-3 text-xs">
                <div>
                  <span class="text-slate-400">Instansi</span>
                  <p class="font-medium text-navy-900">${req.contact}</p>
                </div>
                <div>
                  <span class="text-slate-400">Tujuan</span>
                  <p class="font-medium text-navy-900">${req.tujuan}</p>
                </div>
                <div>
                  <span class="text-slate-400">Tgl Permintaan</span>
                  <p class="font-medium text-navy-900">${req.tgl_permintaan}</p>
                </div>
                <div>
                  <span class="text-slate-400">Tgl Pinjam - Kembali</span>
                  <p class="font-medium text-navy-900">${req.tgl_pinjam} s/d ${req.tgl_kembali}</p>
                </div>
              </div>
              <div class="flex gap-2">
                <button class="flex-1 text-xs font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 py-2 rounded-lg transition">Detail</button>
                ${req.status === 'Menunggu Approval' ? '<button class="flex-1 text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 py-2 rounded-lg transition">Batalkan</button>' : ''}
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    </div>
  </div>`;
}

function handleTamuPeminjamanSubmit(e) {
  e.preventDefault();
  const nama = document.getElementById('tamuPeminjamanNama').value.trim();
  const instansi = document.getElementById('tamuPeminjamanInstansi').value.trim();
  const fasilitas = document.getElementById('tamuPeminjamanFasilitas').value;
  const tglPinjam = document.getElementById('tamuPeminjamanTglPinjam').value;
  const tglKembali = document.getElementById('tamuPeminjamanTglKembali').value;
  const tujuan = document.getElementById('tamuPeminjamanTujuan').value.trim();
  const kontak = document.getElementById('tamuPeminjamanKontak').value.trim();

  const today = new Date().toISOString().split('T')[0];
  if (tglPinjam < today) {
    showToast('Tanggal pinjam tidak boleh kurang dari hari ini!', 'warning');
    return;
  }
  if (tglKembali < tglPinjam) {
    showToast('Tanggal kembali harus lebih besar atau sama dengan tanggal pinjam!', 'warning');
    return;
  }

  const today_date = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
  const newRequest = {
    id: 'REQ-TAM-' + String(tamuPeminjamanRequests.length + 1).padStart(3, '0'),
    nama: fasilitas,
    jenis: 'Fasilitas',
    tgl_permintaan: today_date,
    tgl_pinjam: tglPinjam,
    tgl_kembali: tglKembali,
    tujuan: tujuan,
    status: 'Menunggu Approval',
    contact: instansi
  };

  tamuPeminjamanRequests.unshift(newRequest);
  document.getElementById('tamuPeminjamanNama').value = '';
  document.getElementById('tamuPeminjamanInstansi').value = '';
  document.getElementById('tamuPeminjamanFasilitas').value = '';
  document.getElementById('tamuPeminjamanTglPinjam').value = '';
  document.getElementById('tamuPeminjamanTglKembali').value = '';
  document.getElementById('tamuPeminjamanTujuan').value = '';
  document.getElementById('tamuPeminjamanKontak').value = '';

  navigateTo('permintaan_peminjaman');
  showToast('Permintaan peminjaman berhasil dikirim! Tunggu konfirmasi dari BPMP.', 'success');
}

// ===== APPROVAL HANDLERS =====
function forwardPersediaan(id) {
  const request = pegawaiPermintaanPersediaan.find(p => p.id === id);
  if (request) {
    request.status = 'Diteruskan ke Kasubag';
    navigateTo('approval_persediaan');
    showToast('Permintaan ' + id + ' telah diteruskan ke Kasubag!', 'success');
  }
}

function rejectPersediaan(id) {
  const request = pegawaiPermintaanPersediaan.find(p => p.id === id);
  if (request) {
    request.status = 'Ditolak';
    request.tgl_disetujui = '-';
    navigateTo('approval_persediaan');
    showToast('Permintaan ' + id + ' telah ditolak.', 'info');
  }
}

function forwardPeminjaman(id) {
  const barang = pegawaiPeminjamanBarang.find(p => p.id === id);
  const kendaraan = pegawaiPeminjamanKendaraan.find(p => p.id === id);
  if (barang) {
    barang.status = 'Diteruskan ke Kasubag';
    navigateTo('approval_peminjaman');
    showToast('Peminjaman barang ' + id + ' telah diteruskan ke Kasubag!', 'success');
  } else if (kendaraan) {
    kendaraan.status = 'Diteruskan ke Kasubag';
    navigateTo('approval_peminjaman');
    showToast('Peminjaman kendaraan ' + id + ' telah diteruskan ke Kasubag!', 'success');
  }
}

function rejectPeminjaman(id) {
  const barang = pegawaiPeminjamanBarang.find(p => p.id === id);
  const kendaraan = pegawaiPeminjamanKendaraan.find(p => p.id === id);
  if (barang) {
    barang.status = 'Ditolak';
    navigateTo('approval_peminjaman');
    showToast('Peminjaman barang ' + id + ' telah ditolak.', 'info');
  } else if (kendaraan) {
    kendaraan.status = 'Ditolak';
    navigateTo('approval_peminjaman');
    showToast('Peminjaman kendaraan ' + id + ' telah ditolak.', 'info');
  }
}

function forwardSewa(id) {
  const request = tamuPeminjamanRequests.find(p => p.id === id);
  if (request) {
    request.status = 'Diteruskan ke Kasubag';
    navigateTo('approval_sewa');
    showToast('Permintaan sewa ' + id + ' telah diteruskan ke Kasubag!', 'success');
  }
}

function rejectSewa(id) {
  const request = tamuPeminjamanRequests.find(p => p.id === id);
  if (request) {
    request.status = 'Ditolak';
    navigateTo('approval_sewa');
    showToast('Permintaan sewa ' + id + ' telah ditolak.', 'info');
  }
}

// ===== KASUBAG APPROVAL PAGES =====
function getPersetujuanPeminjamanKasubagHTML() {
  const forwardedItems = [...pegawaiPeminjamanBarang, ...pegawaiPeminjamanKendaraan].filter(p => p.status === 'Diteruskan ke Kasubag');
  
  if (forwardedItems.length === 0) {
    return `<div class="bg-white rounded-xl border border-slate-100 p-12 text-center">
      <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
      <h3 class="font-bold text-navy-900 mb-2">Tidak Ada Permintaan</h3>
      <p class="text-slate-400 text-sm">Semua permintaan peminjaman telah diproses.</p>
    </div>`;
  }

  const rows = forwardedItems.map(pm => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${pm.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${pm.barang || pm.kendaraan}</td>
    <td class="px-4 py-3">${pm.qty || '1'}</td>
    <td class="px-4 py-3">${pm.peminjam}</td>
    <td class="px-4 py-3 text-xs">${pm.tgl_pinjam} s/d ${pm.tgl_kembali}</td>
    <td class="px-4 py-3 text-sm text-slate-600">${pm.tujuan}</td>
    <td class="px-4 py-3">${badgeHTML('Menunggu Final', 'warning')}</td>
    <td class="px-4 py-3">
      <div class="flex gap-2">
        <button onclick="approvePeminjamanKasubag('${pm.id}')" class="text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 px-2.5 py-1.5 rounded transition"><i data-lucide="check" class="w-3 h-3 inline mr-1"></i>Setujui</button>
        <button onclick="rejectPeminjamanKasubag('${pm.id}')" class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition"><i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Tolak</button>
      </div>
    </td>
  </tr>`).join('');
  
  return `<div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-navy-900">Persetujuan Final Peminjaman Barang & Kendaraan</h3>
      <p class="text-sm text-slate-400 mt-1">Verifikasi permintaan peminjaman yang telah diteruskan oleh admin</p>
    </div>
    <span class="badge bg-amber-100 text-amber-700">${forwardedItems.length} Menunggu</span>
  </div>` + tableWrap(['ID', 'Barang/Kendaraan', 'Qty', 'Peminjam', 'Tgl Pinjam - Kembali', 'Tujuan', 'Status', 'Aksi'], rows);
}

function getPersetujuanPersediaanKasubagHTML() {
  const forwardedItems = pegawaiPermintaanPersediaan.filter(p => p.status === 'Diteruskan ke Kasubag');
  
  if (forwardedItems.length === 0) {
    return `<div class="bg-white rounded-xl border border-slate-100 p-12 text-center">
      <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
      <h3 class="font-bold text-navy-900 mb-2">Tidak Ada Permintaan</h3>
      <p class="text-slate-400 text-sm">Semua permintaan persediaan telah diproses.</p>
    </div>`;
  }

  const rows = forwardedItems.map(pp => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${pp.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${pp.barang}</td>
    <td class="px-4 py-3">${pp.qty} ${pp.satuan}</td>
    <td class="px-4 py-3">${pp.peminjam}</td>
    <td class="px-4 py-3 text-xs">${pp.tgl_permintaan}</td>
    <td class="px-4 py-3 text-sm text-slate-600">${pp.tujuan}</td>
    <td class="px-4 py-3">${badgeHTML('Menunggu Final', 'warning')}</td>
    <td class="px-4 py-3">
      <div class="flex gap-2">
        <button onclick="approvePersediaanKasubag('${pp.id}')" class="text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 px-2.5 py-1.5 rounded transition"><i data-lucide="check" class="w-3 h-3 inline mr-1"></i>Setujui</button>
        <button onclick="rejectPersediaanKasubag('${pp.id}')" class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition"><i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Tolak</button>
      </div>
    </td>
  </tr>`).join('');
  
  return `<div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-navy-900">Persetujuan Final Permintaan Persediaan</h3>
      <p class="text-sm text-slate-400 mt-1">Verifikasi permintaan persediaan yang telah diteruskan oleh admin</p>
    </div>
    <span class="badge bg-amber-100 text-amber-700">${forwardedItems.length} Menunggu</span>
  </div>` + tableWrap(['ID', 'Barang', 'Qty', 'Peminta', 'Tgl Permintaan', 'Tujuan', 'Status', 'Aksi'], rows);
}

function getPersetujuanSewaKasubagHTML() {
  const forwardedItems = tamuPeminjamanRequests.filter(p => p.status === 'Diteruskan ke Kasubag');
  
  if (forwardedItems.length === 0) {
    return `<div class="bg-white rounded-xl border border-slate-100 p-12 text-center">
      <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
      <h3 class="font-bold text-navy-900 mb-2">Tidak Ada Permintaan</h3>
      <p class="text-slate-400 text-sm">Semua permintaan sewa fasilitas telah diproses.</p>
    </div>`;
  }

  const rows = forwardedItems.map(req => `<tr class="table-row border-b border-slate-50">
    <td class="px-4 py-3 font-mono text-xs">${req.id}</td>
    <td class="px-4 py-3 font-medium text-navy-900">${req.nama}</td>
    <td class="px-4 py-3">${req.contact}</td>
    <td class="px-4 py-3 text-xs">${req.tgl_permintaan}</td>
    <td class="px-4 py-3 text-xs">${req.tgl_pinjam} s/d ${req.tgl_kembali}</td>
    <td class="px-4 py-3 text-sm text-slate-600">${req.tujuan}</td>
    <td class="px-4 py-3">${badgeHTML('Menunggu Final', 'warning')}</td>
    <td class="px-4 py-3">
      <div class="flex gap-2">
        <button onclick="approveSewaKasubag('${req.id}')" class="text-xs font-semibold text-green-600 bg-green-50 hover:bg-green-100 px-2.5 py-1.5 rounded transition"><i data-lucide="check" class="w-3 h-3 inline mr-1"></i>Setujui</button>
        <button onclick="rejectSewaKasubag('${req.id}')" class="text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 px-2.5 py-1.5 rounded transition"><i data-lucide="x" class="w-3 h-3 inline mr-1"></i>Tolak</button>
      </div>
    </td>
  </tr>`).join('');
  
  return `<div class="mb-4 flex items-center justify-between">
    <div>
      <h3 class="font-bold text-navy-900">Persetujuan Final Sewa Fasilitas</h3>
      <p class="text-sm text-slate-400 mt-1">Verifikasi permintaan sewa yang telah diteruskan oleh admin</p>
    </div>
    <span class="badge bg-amber-100 text-amber-700">${forwardedItems.length} Menunggu</span>
  </div>` + tableWrap(['ID', 'Fasilitas', 'Instansi', 'Tgl Permintaan', 'Tgl Sewa', 'Tujuan', 'Status', 'Aksi'], rows);
}

// ===== KASUBAG APPROVAL HANDLERS =====
function approvePeminjamanKasubag(id) {
  const barang = pegawaiPeminjamanBarang.find(p => p.id === id);
  const kendaraan = pegawaiPeminjamanKendaraan.find(p => p.id === id);
  if (barang) {
    barang.status = 'Disetujui';
    navigateTo('persetujuan_peminjaman_kasubag');
    showToast('Peminjaman barang ' + id + ' telah disetujui!', 'success');
  } else if (kendaraan) {
    kendaraan.status = 'Disetujui';
    navigateTo('persetujuan_peminjaman_kasubag');
    showToast('Peminjaman kendaraan ' + id + ' telah disetujui!', 'success');
  }
}

function rejectPeminjamanKasubag(id) {
  const barang = pegawaiPeminjamanBarang.find(p => p.id === id);
  const kendaraan = pegawaiPeminjamanKendaraan.find(p => p.id === id);
  if (barang) {
    barang.status = 'Ditolak';
    navigateTo('persetujuan_peminjaman_kasubag');
    showToast('Peminjaman barang ' + id + ' telah ditolak.', 'info');
  } else if (kendaraan) {
    kendaraan.status = 'Ditolak';
    navigateTo('persetujuan_peminjaman_kasubag');
    showToast('Peminjaman kendaraan ' + id + ' telah ditolak.', 'info');
  }
}

function approvePersediaanKasubag(id) {
  const request = pegawaiPermintaanPersediaan.find(p => p.id === id);
  if (request) {
    request.status = 'Disetujui';
    request.tgl_disetujui = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    navigateTo('persetujuan_persediaan_kasubag');
    showToast('Permintaan persediaan ' + id + ' telah disetujui!', 'success');
  }
}

function rejectPersediaanKasubag(id) {
  const request = pegawaiPermintaanPersediaan.find(p => p.id === id);
  if (request) {
    request.status = 'Ditolak';
    navigateTo('persetujuan_persediaan_kasubag');
    showToast('Permintaan persediaan ' + id + ' telah ditolak.', 'info');
  }
}

function approveSewaKasubag(id) {
  const request = tamuPeminjamanRequests.find(p => p.id === id);
  if (request) {
    request.status = 'Disetujui';
    navigateTo('persetujuan_sewa_kasubag');
    showToast('Permintaan sewa ' + id + ' telah disetujui!', 'success');
  }
}

function rejectSewaKasubag(id) {
  const request = tamuPeminjamanRequests.find(p => p.id === id);
  if (request) {
    request.status = 'Ditolak';
    navigateTo('persetujuan_sewa_kasubag');
    showToast('Permintaan sewa ' + id + ' telah ditolak.', 'info');
  }
}

// ===== TOAST =====
function showToast(msg, type='info') {
  const container = document.getElementById('toastContainer');
  const colors = { success:'bg-green-500', error:'bg-red-500', info:'bg-navy-600', warning:'bg-amber-500' };
  const icons = { success:'check-circle', error:'x-circle', info:'info', warning:'alert-triangle' };
  const toast = document.createElement('div');
  toast.className = `toast flex items-center gap-3 ${colors[type]} text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium max-w-sm`;
  toast.innerHTML = `<i data-lucide="${icons[type]}" class="w-5 h-5 flex-shrink-0"></i><span>${msg}</span>`;
  container.appendChild(toast);
  lucide.createIcons();
  setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s'; setTimeout(() => toast.remove(), 300); }, 3500);
}

// ===== NAVBAR SCROLL =====
const appRoot = document.getElementById('appRoot');
appRoot.addEventListener('scroll', () => {
  const nb = document.getElementById('navbar');
  if (appRoot.scrollTop > 50) {
    nb.style.background = 'rgba(6,13,51,0.95)';
    nb.style.backdropFilter = 'blur(12px)';
    nb.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
  } else {
    nb.style.background = 'transparent';
    nb.style.backdropFilter = 'none';
    nb.style.boxShadow = 'none';
  }
});

// ===== ELEMENT SDK =====
const defaultConfig = {
  site_title: 'SIBMN',
  hero_subtitle: 'Kelola dan monitoring BMN pada Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo secara digital, transparan, dan akuntabel.',
  background_color: '#060d33',
  surface_color: '#ffffff',
  text_color: '#0a1550',
  primary_action_color: '#1a2f9b',
  secondary_action_color: '#3355ff',
  font_family: 'Plus Jakarta Sans',
  font_size: 16,
};

function applyConfig(config) {
  const title = config.site_title || defaultConfig.site_title;
  const subtitle = config.hero_subtitle || defaultConfig.hero_subtitle;
  const bg = config.background_color || defaultConfig.background_color;
  const surface = config.surface_color || defaultConfig.surface_color;
  const textC = config.text_color || defaultConfig.text_color;
  const primary = config.primary_action_color || defaultConfig.primary_action_color;
  const secondary = config.secondary_action_color || defaultConfig.secondary_action_color;
  const font = config.font_family || defaultConfig.font_family;
  const fontSize = config.font_size || defaultConfig.font_size;

  const navT = document.getElementById('navTitle');
  if (navT) navT.textContent = title;
  const heroSub = document.getElementById('heroSubtitle');
  if (heroSub) heroSub.textContent = subtitle;

  document.documentElement.style.fontFamily = `${font}, Plus Jakarta Sans, sans-serif`;
  document.querySelectorAll('h1,h2,h3,h4').forEach(el => el.style.fontFamily = `${font}, Plus Jakarta Sans, sans-serif`);
  document.querySelectorAll('p, span, a, button, td, th, label, input, select').forEach(el => {
    el.style.fontFamily = `${font}, Plus Jakarta Sans, sans-serif`;
  });

  const baseSize = fontSize;
  document.querySelectorAll('p, td, span, a, button, label, input, select').forEach(el => {
    if (!el.closest('.badge') && !el.classList.contains('text-xs') && !el.classList.contains('text-2xl') && !el.classList.contains('text-3xl') && !el.classList.contains('text-4xl')) {
      el.style.fontSize = `${baseSize}px`;
    }
  });
}

if (window.elementSdk) {
  window.elementSdk.init({
    defaultConfig,
    onConfigChange: async (config) => { applyConfig(config); },
    mapToCapabilities: (config) => ({
      recolorables: [
        { get: () => config.background_color || defaultConfig.background_color, set: (v) => { config.background_color = v; window.elementSdk.setConfig({ background_color: v }); } },
        { get: () => config.surface_color || defaultConfig.surface_color, set: (v) => { config.surface_color = v; window.elementSdk.setConfig({ surface_color: v }); } },
        { get: () => config.text_color || defaultConfig.text_color, set: (v) => { config.text_color = v; window.elementSdk.setConfig({ text_color: v }); } },
        { get: () => config.primary_action_color || defaultConfig.primary_action_color, set: (v) => { config.primary_action_color = v; window.elementSdk.setConfig({ primary_action_color: v }); } },
        { get: () => config.secondary_action_color || defaultConfig.secondary_action_color, set: (v) => { config.secondary_action_color = v; window.elementSdk.setConfig({ secondary_action_color: v }); } },
      ],
      borderables: [],
      fontEditable: {
        get: () => config.font_family || defaultConfig.font_family,
        set: (v) => { config.font_family = v; window.elementSdk.setConfig({ font_family: v }); }
      },
      fontSizeable: {
        get: () => config.font_size || defaultConfig.font_size,
        set: (v) => { config.font_size = v; window.elementSdk.setConfig({ font_size: v }); }
      }
    }),
    mapToEditPanelValues: (config) => new Map([
      ['site_title', config.site_title || defaultConfig.site_title],
      ['hero_subtitle', config.hero_subtitle || defaultConfig.hero_subtitle],
    ])
  });
}

// ===== INIT =====
buildCarousel();
buildDemoAccounts();
updateFacilitiesCountdown();
setInterval(updateFacilitiesCountdown, 1000);
lucide.createIcons();
</script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9de2a59106d93f73',t:'MTc3MzgyMDIyOS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
