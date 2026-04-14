<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIBMN - BPMP Provinsi Gorontalo</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/lucide@0.263.0/dist/umd/lucide.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

    @keyframes fadeUp   { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
    @keyframes fadeIn   { from { opacity:0; } to { opacity:1; } }
    @keyframes floatBob { 0%,100%{ transform:translateY(0); } 50%{ transform:translateY(-12px); } }
    @keyframes modalIn  { from { opacity:0; transform:scale(0.96) translateY(16px); } to { opacity:1; transform:scale(1) translateY(0); } }
    @keyframes overlayIn{ from { opacity:0; } to { opacity:1; } }
    @keyframes imgZoom  { from { transform:scale(1.08); } to { transform:scale(1); } }

    .anim-fade-up { animation: fadeUp 0.7s ease forwards; }
    .anim-fade-in { animation: fadeIn 0.5s ease forwards; }
    .delay-1 { animation-delay:0.1s; opacity:0; }
    .delay-2 { animation-delay:0.2s; opacity:0; }
    .delay-3 { animation-delay:0.3s; opacity:0; }
    .delay-4 { animation-delay:0.4s; opacity:0; }
    .delay-5 { animation-delay:0.5s; opacity:0; }
    .delay-6 { animation-delay:0.6s; opacity:0; }

    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(10,21,80,0.12); }
    .btn-primary { background: linear-gradient(135deg, #1a2f9b 0%, #3355ff 100%); transition: all 0.3s ease; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,47,155,0.35); }
    .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); }
    .stat-card { position: relative; overflow: hidden; }
    .stat-card::before { content:''; position:absolute; top:-50%; right:-50%; width:100%; height:100%; background:radial-gradient(circle, rgba(51,85,255,0.08) 0%, transparent 70%); }

    .facilities-scroll { -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none; }
    .facilities-scroll::-webkit-scrollbar { display: none; }

    .facility-card { cursor: pointer; }
    .facility-card .card-img { transition: transform 0.4s ease; }
    .facility-card:hover .card-img { transform: scale(1.05); }
    .facility-card .card-overlay { opacity: 0; transition: opacity 0.3s ease; background: linear-gradient(to top, rgba(6,13,51,0.85) 0%, rgba(6,13,51,0.1) 60%, transparent 100%); }
    .facility-card:hover .card-overlay { opacity: 1; }
    .facility-card .view-detail-btn { opacity: 0; transform: translateY(8px); transition: all 0.3s ease; }
    .facility-card:hover .view-detail-btn { opacity: 1; transform: translateY(0); }

    .modal-overlay {
      position: fixed; inset: 0; z-index: 1000;
      background: rgba(6,13,51,0.72); backdrop-filter: blur(6px);
      display: flex; align-items: center; justify-content: center;
      padding: 16px;
      animation: overlayIn 0.25s ease forwards;
    }
    .modal-box {
      background: #fff; border-radius: 24px;
      width: 100%; max-width: 860px; max-height: 90vh;
      overflow: hidden; display: flex; flex-direction: column;
      animation: modalIn 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards;
      box-shadow: 0 32px 80px rgba(6,13,51,0.28);
    }
    .modal-body { overflow-y: auto; }
    .modal-body::-webkit-scrollbar { width: 5px; }
    .modal-body::-webkit-scrollbar-thumb { background: #bccfff; border-radius: 4px; }
    .modal-img { animation: imgZoom 0.5s ease forwards; }

    .thumb { cursor: pointer; transition: all 0.2s; border: 2px solid transparent; border-radius: 10px; overflow: hidden; }
    .thumb:hover { border-color: #3355ff; }
    .thumb.active { border-color: #3355ff; box-shadow: 0 0 0 3px rgba(51,85,255,0.2); }

    .hero-bg { background: linear-gradient(135deg, #060d33 0%, #0f1f6e 40%, #1a2f9b 70%, #3355ff 100%); }

    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #bccfff; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #8eaeff; }

    .avail-tersedia { background:#dcfce7; color:#15803d; }
    .avail-terbatas { background:#fef9c3; color:#a16207; }
    .avail-beberapa { background:#fee2e2; color:#b91c1c; }
    .avail-booking  { background:#ede9fe; color:#7c3aed; }
  </style>
</head>
<body class="h-full bg-slate-50">

  <!-- NAVBAR -->
  <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300" style="background:rgba(6,13,51,0.95);backdrop-filter:blur(12px);box-shadow:rgba(0,0,0,0.15) 0px 4px 20px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 md:h-20">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#3355ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#3355ff"/></svg>
          </div>
          <div>
            <span class="text-white font-bold text-lg tracking-tight">SIPANDU</span>
            <span class="text-blue-200 text-xs block leading-none">BPMP Gorontalo</span>
          </div>
        </div>
        <div class="hidden md:flex items-center gap-8">
          <a href="#hero"      class="text-blue-100 hover:text-white text-sm font-medium transition">Beranda</a>
          <a href="#fitur"     class="text-blue-100 hover:text-white text-sm font-medium transition">Fitur</a>
          <a href="#statistik" class="text-blue-100 hover:text-white text-sm font-medium transition">Statistik</a>
          <a href="#fasilitas" class="text-blue-100 hover:text-white text-sm font-medium transition">Fasilitas</a>
          <a href="#kontak"    class="text-blue-100 hover:text-white text-sm font-medium transition">Kontak</a>
        </div>
        <div class="flex items-center gap-3">
          <a href="{{ route('login') }}"    class="text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-white/10 transition">Masuk</a>
          <a href="{{ route('register') }}" class="btn-primary text-white text-sm font-semibold px-5 py-2 rounded-lg">Daftar</a>
          <button class="md:hidden text-white" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
          </button>
        </div>
      </div>
    </div>
    <div id="mobileMenu" class="hidden md:hidden bg-navy-900/95 backdrop-blur-lg pb-4 px-4">
      <a href="#hero"      class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Beranda</a>
      <a href="#fitur"     class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Fitur</a>
      <a href="#statistik" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Statistik</a>
      <a href="#fasilitas" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Fasilitas</a>
      <a href="#kontak"    class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Kontak</a>
      <div class="flex gap-2 mt-3 pt-3 border-t border-white/10">
        <a href="{{ route('login') }}"    class="flex-1 text-center text-white text-sm font-semibold py-2 rounded-lg border border-white/20 hover:bg-white/10 transition">Masuk</a>
        <a href="{{ route('register') }}" class="flex-1 text-center btn-primary text-white text-sm font-semibold py-2 rounded-lg">Daftar</a>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section id="hero" class="hero-bg relative overflow-hidden" style="min-height:600px;padding-top:100px;padding-bottom:80px;">
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-10 right-10 w-96 h-96 bg-indigo-400/8 rounded-full blur-3xl"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/5 rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-12">
      <div class="flex-1 text-center lg:text-left">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 mb-6 anim-fade-up delay-1">
          <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
          <span class="text-blue-200 text-xs font-medium">Sistem Aktif &amp; Terintegrasi</span>
        </div>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6 anim-fade-up delay-2">
          Sistem Informasi<br>
          <span class="bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent">BMN TERPADU</span>
        </h1>
        <p class="text-blue-200 text-lg md:text-xl max-w-xl mb-8 leading-relaxed anim-fade-up delay-3">
          Kelola dan monitoring BMN pada Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo secara digital, transparan, dan akuntabel.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start anim-fade-up delay-4">
          <a href="{{ route('login') }}" class="btn-primary text-white font-semibold px-8 py-3.5 rounded-xl flex items-center justify-center gap-2 text-base">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
            Masuk Sekarang
          </a>
          <a href="#fitur" class="border border-white/30 text-white font-semibold px-8 py-3.5 rounded-xl flex items-center justify-center gap-2 text-base hover:bg-white/10 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            Pelajari Fitur
          </a>
        </div>
        <div class="flex items-center gap-8 mt-10 justify-center lg:justify-start anim-fade-up delay-5">
          <div class="text-center"><div class="text-2xl font-bold text-white">1,247</div><div class="text-blue-300 text-xs">Total Aset</div></div>
          <div class="w-px h-10 bg-white/20"></div>
          <div class="text-center"><div class="text-2xl font-bold text-white">89</div><div class="text-blue-300 text-xs">Pegawai</div></div>
          <div class="w-px h-10 bg-white/20"></div>
          <div class="text-center"><div class="text-2xl font-bold text-white">12</div><div class="text-blue-300 text-xs">Fasilitas</div></div>
        </div>
      </div>
      <div class="flex-1 hidden lg:flex justify-center anim-fade-up delay-5">
        <div class="relative">
          <div class="w-[400px] h-[300px] bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6">
            <div class="flex items-center gap-2 mb-4">
              <div class="w-3 h-3 rounded-full bg-red-400"></div>
              <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
              <div class="w-3 h-3 rounded-full bg-green-400"></div>
              <span class="text-white/50 text-xs ml-2">Dashboard BMN</span>
            </div>
            <div class="grid grid-cols-2 gap-3 mb-4">
              <div class="bg-white/10 rounded-lg p-3"><div class="text-cyan-300 text-xs">Aset Tetap</div><div class="text-white font-bold text-xl">856</div></div>
              <div class="bg-white/10 rounded-lg p-3"><div class="text-green-300 text-xs">Persediaan</div><div class="text-white font-bold text-xl">391</div></div>
            </div>
            <div class="bg-white/10 rounded-lg p-3 flex items-center justify-between">
              <div><div class="text-yellow-300 text-xs">Sarana Prasarana</div><div class="text-white font-bold">127 Unit</div></div>
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
            <div class="w-8 h-8 bg-green-500/30 rounded-full flex items-center justify-center">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-300"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
            <div><div class="text-green-300 text-[10px]">Status</div><div class="text-white text-xs font-bold">98.5% Baik</div></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TENTANG -->
  <section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center">
        <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
          <span class="text-navy-700 text-sm font-semibold">Tentang SIBMN</span>
        </div>
        <h2 class="text-3xl font-bold text-navy-900 mb-4">Pengelolaan BMN yang Modern &amp; Transparan</h2>
        <p class="text-slate-600 leading-relaxed">SIBMN BPMP Gorontalo adalah sistem informasi terintegrasi untuk pencatatan, pemantauan, dan pengelolaan Barang Milik Negara. Sistem ini mendukung tata kelola aset yang akuntabel sesuai Peraturan Pemerintah No. 27 Tahun 2014 tentang Pengelolaan BMN, dengan fitur multi-peran untuk seluruh unit kerja di lingkungan BPMP Provinsi Gorontalo.</p>
      </div>
    </div>
  </section>

  <!-- FITUR -->
  <section id="fitur" class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
        <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
          <span class="text-navy-700 text-sm font-semibold">Fitur Unggulan</span>
        </div>
        <h2 class="text-3xl md:text-4xl font-bold text-navy-900">Fitur Lengkap untuk Pengelolaan BMN</h2>
      </div>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100"><div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M16.5 9.4 7.55 4.24"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg></div><h3 class="font-bold text-navy-900 text-lg mb-2">Pencatatan Persediaan</h3><p class="text-slate-500 text-sm leading-relaxed">Kelola stok barang habis pakai, ATK, dan bahan operasional dengan pencatatan masuk-keluar yang akurat.</p></div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100"><div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-600"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg></div><h3 class="font-bold text-navy-900 text-lg mb-2">Manajemen Sarana Prasarana</h3><p class="text-slate-500 text-sm leading-relaxed">Monitoring kondisi gedung, ruangan, kendaraan dinas, dan fasilitas pendukung lainnya.</p></div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100"><div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-cyan-600"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg></div><h3 class="font-bold text-navy-900 text-lg mb-2">Pengelolaan Aset Tetap</h3><p class="text-slate-500 text-sm leading-relaxed">Inventarisasi tanah, bangunan, peralatan &amp; mesin, serta aset tetap lainnya sesuai standar SIMAK-BMN.</p></div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100"><div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg></div><h3 class="font-bold text-navy-900 text-lg mb-2">Peminjaman &amp; Pengembalian</h3><p class="text-slate-500 text-sm leading-relaxed">Sistem peminjaman aset oleh pegawai dengan tracking status dan riwayat lengkap.</p></div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100"><div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg></div><h3 class="font-bold text-navy-900 text-lg mb-2">Laporan &amp; Analitik</h3><p class="text-slate-500 text-sm leading-relaxed">Generate laporan BMN otomatis, neraca aset, dan analisis kondisi barang secara real-time.</p></div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100"><div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-rose-600"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><h3 class="font-bold text-navy-900 text-lg mb-2">Multi-Role Access</h3><p class="text-slate-500 text-sm leading-relaxed">Hak akses berbeda untuk Kepala BPMP, Kasubag, Admin Persediaan, Admin Sarpras, Admin Aset, dan Pegawai.</p></div>
      </div>
    </div>
  </section>

  <!-- STATISTIK -->
  <section id="statistik" class="py-20 hero-bg relative overflow-hidden">
    <div class="absolute inset-0"><div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl"></div></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-300"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
          <span class="text-blue-200 text-sm font-semibold">Data Statistik</span>
        </div>
        <h2 class="text-3xl md:text-4xl font-bold text-white">Statistik BMN BPMP Gorontalo</h2>
      </div>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="stat-card glass rounded-2xl p-6 text-center"><div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-300"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg></div><div class="text-3xl md:text-4xl font-extrabold text-white mb-1">1,247</div><div class="text-blue-200 text-sm">Total Item BMN</div></div>
        <div class="stat-card glass rounded-2xl p-6 text-center"><div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-300"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div><div class="text-3xl md:text-4xl font-extrabold text-white mb-1">Rp 28.5M</div><div class="text-blue-200 text-sm">Nilai Aset Terkelola</div></div>
        <div class="stat-card glass rounded-2xl p-6 text-center"><div class="w-14 h-14 bg-yellow-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-300"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg></div><div class="text-3xl md:text-4xl font-extrabold text-white mb-1">342</div><div class="text-blue-200 text-sm">Transaksi Bulan Ini</div></div>
        <div class="stat-card glass rounded-2xl p-6 text-center"><div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-300"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div><div class="text-3xl md:text-4xl font-extrabold text-white mb-1">98.5%</div><div class="text-blue-200 text-sm">Kondisi Baik</div></div>
      </div>
    </div>
  </section>

  <!-- FASILITAS -->
  <section id="fasilitas" class="py-16 md:py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="rounded-3xl overflow-hidden bg-white border border-slate-100 shadow-xl">
        <div class="px-5 pt-6 pb-4 md:px-8 md:pt-8 md:pb-5 border-b border-slate-100/80">
          <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5 mb-5">
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0 border border-blue-100/80">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
              </div>
              <div>
                <h2 class="text-xl md:text-2xl font-bold text-navy-900 tracking-tight leading-tight">Fasilitas Unggulan</h2>
                <p class="text-slate-500 text-sm mt-1">Klik gambar untuk melihat detail — BPMP Provinsi Gorontalo</p>
              </div>
            </div>
            <div class="flex items-center gap-2 lg:gap-3 flex-wrap lg:flex-nowrap lg:justify-end">
              <span class="text-slate-600 text-sm font-medium whitespace-nowrap">Promo berakhir dalam</span>
              <div class="flex items-center gap-1 font-mono">
                <span id="cdH" class="inline-flex min-w-[2.25rem] justify-center rounded-lg bg-navy-100 px-2 py-1.5 text-sm font-bold shadow-sm tabular-nums text-navy-900 border border-navy-200/60">00</span>
                <span class="font-bold text-slate-400">:</span>
                <span id="cdM" class="inline-flex min-w-[2.25rem] justify-center rounded-lg bg-navy-100 px-2 py-1.5 text-sm font-bold shadow-sm tabular-nums text-navy-900 border border-navy-200/60">00</span>
                <span class="font-bold text-slate-400">:</span>
                <span id="cdS" class="inline-flex min-w-[2.25rem] justify-center rounded-lg bg-navy-100 px-2 py-1.5 text-sm font-bold shadow-sm tabular-nums text-navy-900 border border-navy-200/60">00</span>
              </div>
            </div>
          </div>
          <div id="facilityChips" class="flex flex-wrap gap-2"></div>
        </div>
        <div class="relative px-3 pb-6 md:px-6 md:pb-8 pt-4 bg-slate-50/70">
          <button onclick="facilitiesScrollPrev()" class="absolute left-1 md:left-2 top-[42%] -translate-y-1/2 z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white shadow-lg hidden sm:flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-navy-700 transition border border-white/80">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
          </button>
          <div id="facilitiesCarouselScroll" class="facilities-scroll flex gap-3 md:gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory py-2 pl-1 pr-14 sm:pr-16 md:px-2"></div>
          <button onclick="facilitiesScrollNext()" class="absolute right-1 md:right-2 top-[42%] -translate-y-1/2 z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white shadow-lg flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-navy-700 transition border border-white/80">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
          </button>
        </div>
      </div>
      <p class="text-center text-slate-500 text-sm mt-5 max-w-2xl mx-auto">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline mr-1 text-navy-400"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
        Harga dapat berubah sesuai kebijakan. Hubungi Tata Usaha BPMP untuk jadwal dan persyaratan resmi.
      </p>
    </div>
  </section>

  <!-- AKUN DEMO -->
  <section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-10">
        <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="m15.5 7.5 3 3L22 7l-3-3"/></svg>
          <span class="text-navy-700 text-sm font-semibold">Akun Demo</span>
        </div>
        <h2 class="text-3xl font-bold text-navy-900 mb-3">Coba Demo Setiap Peran</h2>
        <p class="text-slate-500">Gunakan akun demo berikut untuk mengeksplorasi fitur setiap role.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="demoAccountsGrid"></div>
    </div>
  </section>

  <!-- KONTAK -->
  <section id="kontak" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div>
          <div class="inline-flex items-center gap-2 bg-blue-50 rounded-full px-4 py-1.5 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span class="text-navy-700 text-sm font-semibold">Lokasi Kami</span>
          </div>
          <h2 class="text-3xl font-bold text-navy-900 mb-6">Hubungi BPMP Gorontalo</h2>
          <div class="space-y-5">
            <div class="flex items-start gap-4"><div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></div><div><h4 class="font-semibold text-navy-900 text-sm">Alamat</h4><p class="text-slate-500 text-sm">Jl. Prof. Dr. H. Aloei Saboe, Kel. Wongkaditi Timur, Kec. Kota Utara, Kota Gorontalo, Gorontalo 96128</p></div></div>
            <div class="flex items-start gap-4"><div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div><div><h4 class="font-semibold text-navy-900 text-sm">Telepon</h4><p class="text-slate-500 text-sm">(0435) 821-555</p></div></div>
            <div class="flex items-start gap-4"><div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div><div><h4 class="font-semibold text-navy-900 text-sm">Email</h4><p class="text-slate-500 text-sm">bpmp.gorontalo@kemdikbud.go.id</p></div></div>
            <div class="flex items-start gap-4"><div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div><h4 class="font-semibold text-navy-900 text-sm">Jam Operasional</h4><p class="text-slate-500 text-sm">Senin – Jumat: 08.00 – 16.00 WITA</p></div></div>
          </div>
        </div>
        <div class="bg-slate-100 rounded-2xl overflow-hidden" style="height:350px;">
          <div class="w-full h-full bg-gradient-to-br from-navy-100 to-blue-100 flex items-center justify-center relative">
            <div class="text-center">
              <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg></div>
              <p class="text-navy-700 font-semibold">BPMP Provinsi Gorontalo</p>
              <p class="text-navy-500 text-sm mt-1">Kota Gorontalo, 96128</p>
            </div>
            <div class="absolute top-4 left-4 bg-white/80 backdrop-blur rounded-lg px-3 py-1.5 text-xs text-navy-600 font-medium">📍 0.5488° N, 123.0568° E</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-navy-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8 mb-10">
        <div class="md:col-span-2">
          <div class="flex items-center gap-3 mb-4"><div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#3355ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#3355ff"/></svg></div><div><span class="font-bold text-lg">SIBMN</span><span class="text-blue-300 text-xs block">BPMP Gorontalo</span></div></div>
          <p class="text-blue-200/70 text-sm leading-relaxed max-w-md">Sistem Informasi Barang Milik Negara Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo. Mendukung tata kelola aset yang transparan dan akuntabel.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4 text-sm">Menu</h4>
          <div class="space-y-2">
            <a href="#hero"      class="block text-blue-200/70 text-sm hover:text-white transition">Beranda</a>
            <a href="#fitur"     class="block text-blue-200/70 text-sm hover:text-white transition">Fitur</a>
            <a href="#statistik" class="block text-blue-200/70 text-sm hover:text-white transition">Statistik</a>
            <a href="#fasilitas" class="block text-blue-200/70 text-sm hover:text-white transition">Fasilitas</a>
          </div>
        </div>
        <div>
          <h4 class="font-semibold mb-4 text-sm">Tautan</h4>
          <div class="space-y-2">
            <a href="#" class="block text-blue-200/70 text-sm hover:text-white transition">Kemendikbud</a>
            <a href="#" class="block text-blue-200/70 text-sm hover:text-white transition">SIMAK-BMN</a>
            <a href="#" class="block text-blue-200/70 text-sm hover:text-white transition">DJKN</a>
          </div>
        </div>
      </div>
      <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-blue-200/50 text-sm">© 2025 SIBMN BPMP Provinsi Gorontalo. Hak Cipta Dilindungi.</p>
        <span class="text-blue-200/50 text-xs">Dibangun dengan ❤️ untuk Pendidikan Indonesia</span>
      </div>
    </div>
  </footer>

  <!-- MODAL FASILITAS -->
  <div id="facilityModal" class="modal-overlay hidden" onclick="handleModalOverlayClick(event)">
    <div class="modal-box" onclick="event.stopPropagation()">
      <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 flex-shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/></svg></div>
          <span class="font-bold text-navy-900 text-base">Detail Fasilitas</span>
        </div>
        <button onclick="closeModal()" class="w-9 h-9 rounded-xl hover:bg-slate-100 flex items-center justify-center text-slate-500 hover:text-navy-700 transition"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
      </div>
      <div class="modal-body flex-1">
        <div class="flex flex-col lg:flex-row">
          <div class="lg:w-[52%] flex-shrink-0">
            <div class="relative overflow-hidden bg-slate-100" style="height:280px;">
              <img id="modalMainImg" src="" alt="" class="modal-img w-full h-full object-cover">
              <div class="absolute top-4 left-4"><span id="modalAvailBadge" class="text-xs font-bold px-3 py-1.5 rounded-full"></span></div>
              <div class="absolute bottom-4 left-4 flex items-center gap-1.5 bg-navy-900/80 backdrop-blur text-white rounded-xl px-3 py-1.5">
                <span id="modalRatingScore" class="font-bold text-sm"></span>
                <div id="modalStars" class="flex gap-0.5"></div>
                <span id="modalReviewCount" class="text-white/70 text-xs"></span>
              </div>
            </div>
            <div id="modalThumbs" class="flex gap-2 p-4 overflow-x-auto"></div>
          </div>
          <div class="flex-1 p-6 lg:p-7 flex flex-col overflow-y-auto">
            <div class="mb-4">
              <h2 id="modalName" class="text-xl font-extrabold text-navy-900 leading-tight mb-1"></h2>
              <div class="flex items-center gap-1.5 text-slate-500 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg><span id="modalLocation"></span></div>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-5" id="modalSpecs"></div>
            <div class="mb-5"><h4 class="text-xs font-bold text-navy-700 uppercase tracking-wide mb-2">Deskripsi</h4><p id="modalDesc" class="text-slate-600 text-sm leading-relaxed"></p></div>
            <div class="mb-5"><h4 class="text-xs font-bold text-navy-700 uppercase tracking-wide mb-2">Fasilitas yang Tersedia</h4><div id="modalFeatures" class="flex flex-wrap gap-1.5"></div></div>
            <div class="mb-5"><h4 class="text-xs font-bold text-navy-700 uppercase tracking-wide mb-2">Ketentuan Penggunaan</h4><ul id="modalRules" class="space-y-1.5"></ul></div>
            <div class="mt-auto pt-4 border-t border-slate-100">
              <div class="flex items-end justify-between flex-wrap gap-3">
                <div>
                  <div id="modalPriceOld" class="text-slate-400 text-xs line-through mb-0.5"></div>
                  <div id="modalPrice" class="text-xl font-extrabold text-navy-900"></div>
                  <div class="text-slate-400 text-xs mt-0.5">Belum termasuk pajak &amp; biaya lain</div>
                </div>
                <div class="flex gap-2">
                  <button onclick="closeModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Kembali</button>
                  <a href="{{ route('login') }}" class="btn-primary px-5 py-2.5 rounded-xl text-white text-sm font-semibold flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="13" x="2" y="5" rx="2"/><path d="m22 8-8 5-8-5"/></svg>
                    Hubungi Kami
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- TOAST -->
  <div id="toastContainer" class="fixed top-4 right-4 z-[300] space-y-2 pointer-events-none"></div>

<script>
const FACILITIES = [
  { name:'Aula Utama BPMP', category:'ruang', price:'Rp 2.500.000/hari', priceOld:'Rp 3.000.000', availability:'Beberapa jadwal tersedia', availClass:'avail-beberapa', location:'Gedung Utama Lt.1, Wongkaditi Timur', rating:4.6, reviews:18, capacity:'200 Orang', luas:'420 m²', operasional:'Senin–Jumat 07.00–22.00 WITA', kontak:'(0435) 821-555 ext. 101', description:'Aula Utama BPMP adalah ruang multifungsi berkapasitas besar yang ideal untuk seminar nasional, workshop, pelantikan, rapat koordinasi, dan berbagai kegiatan resmi lainnya. Dilengkapi dengan sistem audio visual modern, AC sentral, dan panggung permanen.', features:['AC Sentral','Sound System Profesional','Proyektor + Layar 5m','Podium & Panggung','Kursi Ergonomis 200 unit','Meja Registrasi','Wi-Fi 100 Mbps','Toilet Dalam','Area Parkir Luas','CCTV 24 Jam'], rules:['Pemesanan minimal H-7','Tidak diperkenankan untuk kegiatan komersial non-pendidikan','Konsumsi disediakan sendiri oleh penyewa','Penyewa bertanggung jawab atas kebersihan dan kerusakan','Jam malam maksimal pukul 22.00 WITA'], images:['https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80','https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80','https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=800&q=80'] },
  { name:'Ruang Rapat VIP', category:'ruang', price:'Rp 1.000.000/hari', priceOld:'Rp 1.250.000', availability:'2 slot minggu ini', availClass:'avail-terbatas', location:'Gedung Utama Lt.2, Kota Utara', rating:4.8, reviews:24, capacity:'20 Orang', luas:'60 m²', operasional:'Senin–Jumat 08.00–17.00 WITA', kontak:'(0435) 821-555 ext. 102', description:'Ruang Rapat VIP adalah ruangan eksklusif yang dirancang untuk rapat pimpinan, konsultasi, dan pertemuan terbatas. Dilengkapi sistem video conference terkini, whiteboard digital, dan pantry pribadi untuk kenyamanan maksimal.', features:['Video Conference 4K','Whiteboard Digital','AC Split Inverter','Meja Rapat Oval','Kursi Eksekutif','Mini Pantry','Smart TV 75"','Wi-Fi Dedicated','Brankas Dokumen','Akses Kartu'], rules:['Reservasi minimal H-3','Kapasitas maksimal 20 orang','Dilarang membawa makanan beraroma kuat','Peralatan video conference wajib dikembalikan dalam kondisi baik','Konsumsi ringan tersedia dengan biaya tambahan'], images:['https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80','https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80','https://images.unsplash.com/photo-1568992687947-868a62a9f521?w=800&q=80'] },
  { name:'Lab Komputer', category:'lab', price:'Rp 1.500.000/hari', priceOld:null, availability:'Tersedia', availClass:'avail-tersedia', location:'Gedung Teknologi Lt.1, Kompleks BPMP', rating:4.5, reviews:31, capacity:'30 Unit PC', luas:'80 m²', operasional:'Senin–Jumat 07.30–17.00 WITA', kontak:'(0435) 821-555 ext. 103', description:'Lab Komputer BPMP dilengkapi 30 unit komputer modern dengan spesifikasi terkini dan koneksi internet berkecepatan tinggi. Fasilitas ini ideal untuk pelatihan TI, ujian berbasis komputer (CBT), workshop digital, dan kegiatan literasi digital lainnya.', features:['30 Unit PC Intel Core i7','RAM 16 GB per unit','Internet Fiber 1 Gbps','Windows 11 Pro','MS Office 365','AC Sentral','Proyektor + Layar','Kamera CCTV','UPS per Unit','Headset Tersedia'], rules:['Dilarang menginstal software tanpa izin','Flash disk harus discan antivirus terlebih dahulu','Penyewa bertanggung jawab atas kerusakan hardware','Aktivitas download masif harus dikonfirmasi sebelumnya','Lab akan direset setelah setiap sesi'], images:['https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80','https://images.unsplash.com/photo-1531297484001-80022131f5a1?w=800&q=80','https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80'] },
  { name:'Ruang Pelatihan B', category:'ruang', price:'Rp 700.000/hari', priceOld:null, availability:'Tersedia', availClass:'avail-tersedia', location:'Gedung Pelatihan Lt.2, BPMP', rating:4.3, reviews:8, capacity:'30 Orang', luas:'90 m²', operasional:'Senin–Sabtu 07.00–20.00 WITA', kontak:'(0435) 821-555 ext. 105', description:'Ruang Pelatihan B merupakan alternatif yang lebih terjangkau untuk kegiatan pelatihan, rapat, dan diskusi kelompok. Terletak di lantai 2 dengan pencahayaan alami yang baik dan suasana kondusif untuk belajar.', features:['AC 2 Unit','Proyektor BenQ','Layar 2.5m','Kursi Lipat 30 unit','Papan Tulis','Wi-Fi','Mic Kabel 1 unit','Colokan Listrik 6 titik','Whiteboard Kecil','Pencahayaan Alami'], rules:['Reservasi minimal H-3','Kapasitas tidak boleh melebihi 30 orang','Penyewa membawa perlengkapan presentasi sendiri jika diperlukan spek khusus','Dilarang merokok di dalam ruangan'], images:['https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80','https://images.unsplash.com/photo-1580582932707-520aed937d7b?w=800&q=80','https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80'] },
  { name:'Kendaraan Dinas – Minibus', category:'kendaraan', price:'Rp 750.000/hari', priceOld:null, availability:'1 unit tersedia', availClass:'avail-terbatas', location:'Pool Kendaraan BPMP, Wongkaditi Timur', rating:4.7, reviews:9, capacity:'16 Penumpang', luas:'—', operasional:'Senin–Jumat 06.00–18.00 WITA', kontak:'(0435) 821-555 ext. 106', description:'Kendaraan dinas Toyota HiAce berkapasitas 16 penumpang tersedia untuk mendukung kegiatan dinas lapangan, kunjungan sekolah, dan transportasi resmi. Kendaraan dalam kondisi prima dan wajib disertai driver resmi BPMP.', features:['Toyota HiAce 2022','Kapasitas 16 Penumpang','AC Double Blower','Kondisi Terawat','Driver Resmi Tersedia','Asuransi Perjalanan','BBM Tanggungan Penyewa','Bagasi Luas'], rules:['Wajib menggunakan driver resmi BPMP','Peminjaman hanya untuk kegiatan resmi/dinas','Pemesanan minimal H-3 dan mendapat persetujuan Kasubag','BBM dan tol ditanggung oleh peminjam','Pengembalian kendaraan harus dalam kondisi bersih'], images:['https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800&q=80','https://images.unsplash.com/photo-1601584115197-04ecc0da31d7?w=800&q=80','https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&q=80'] },
  { name:'Gedung Serbaguna', category:'outdoor', price:'Rp 3.000.000/hari', priceOld:'Rp 3.500.000', availability:'Booking awal bulan', availClass:'avail-booking', location:'Halaman BPMP Gorontalo, Area Selatan', rating:4.5, reviews:7, capacity:'300 Orang', luas:'500 m²', operasional:'Fleksibel — koordinasi TU', kontak:'(0435) 821-555 ext. 107', description:'Gedung Serbaguna adalah area multifungsi outdoor-indoor seluas 500m² yang dapat digunakan untuk pameran pendidikan, bazar, expo, pertunjukan seni, acara resepsi, dan kegiatan skala besar lainnya. Tersedia tenda permanen dan instalasi listrik memadai.', features:['Tenda Permanen 300 m²','Instalasi Listrik 3 Phase','Sound System Outdoor','Area Parkir 50 Kendaraan','Toilet Portabel','Penerangan Malam','Aksesibilitas Difabel','Area Hijau Pendukung','CCTV Perimeter','Keamanan 24 Jam'], rules:['Pemesanan minimal H-14 untuk acara besar','Penyewa menyediakan perlengkapan dekorasi sendiri','Kapasitas maksimal 300 orang','Kegiatan yang menghasilkan limbah wajib dibersihkan oleh penyewa','Kebisingan tidak boleh mengganggu kantor sekitar (batas jam 21.00 WITA)','Mendapat persetujuan tertulis dari Kepala BPMP'], images:['https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80','https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&q=80','https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&q=80'] },
  { name:'Lapangan Olahraga', category:'outdoor', price:'Rp 300.000/hari', priceOld:null, availability:'Tersedia', availClass:'avail-tersedia', location:'Area Belakang BPMP Gorontalo', rating:4.2, reviews:5, capacity:'50 Orang', luas:'600 m²', operasional:'Senin–Sabtu 06.00–18.00 WITA', kontak:'(0435) 821-555 ext. 108', description:'Lapangan olahraga serbaguna yang dapat digunakan untuk futsal, voli, senam massal, dan aktivitas outdoor lainnya. Cocok untuk kegiatan pembinaan jasmani, outbound ringan, dan event olahraga instansi.', features:['Lapangan Futsal','Net Voli','Tiang Lampu 4 unit','Ruang Ganti','Area Penonton','Pompa Angin Tersedia'], rules:['Dilarang menggunakan alas kaki yang merusak lapangan','Kegiatan pertandingan formal wajib didampingi panitia','Kebersihan lapangan menjadi tanggung jawab penyewa','Tidak tersedia saat hari libur nasional tanpa reservasi khusus'], images:['https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&q=80','https://images.unsplash.com/photo-1518611012118-696072aa579a?w=800&q=80','https://images.unsplash.com/photo-1540747913346-19212a4e5d05?w=800&q=80'] },
];

const FACILITY_CHIPS = [
  { id:'semua', label:'Semua' },
  { id:'ruang', label:'Ruang & Aula' },
  { id:'lab',   label:'Lab' },
  { id:'kendaraan', label:'Kendaraan' },
  { id:'outdoor',   label:'Outdoor' },
];

const DEMO_ACCOUNTS = [
  { username:'superadmin',     password:'super123',      label:'Super Admin',          color:'from-red-500 to-rose-600',     icon:'shield',    desc:'Akses penuh ke seluruh sistem' },
  { username:'kepalabpmp',     password:'kepala123',     label:'Kepala BPMP',           color:'from-purple-500 to-indigo-600',icon:'crown',     desc:'Dashboard eksekutif & persetujuan' },
  { username:'kasubag',        password:'kasubag123',    label:'Kasubag TU',            color:'from-indigo-500 to-blue-600',  icon:'briefcase', desc:'Verifikasi & koordinasi BMN' },
  { username:'adminpersediaan',password:'persediaan123', label:'Admin Persediaan',      color:'from-emerald-500 to-green-600',icon:'package',   desc:'Kelola stok & barang habis pakai' },
  { username:'adminsarpras',   password:'sarpras123',    label:'Admin Sarana Prasarana',color:'from-cyan-500 to-teal-600',   icon:'building',  desc:'Monitor gedung & fasilitas' },
  { username:'adminaset',      password:'aset123',       label:'Admin Aset Tetap',      color:'from-amber-500 to-yellow-600', icon:'landmark',  desc:'Inventarisasi aset tetap' },
  { username:'pegawai',        password:'pegawai123',    label:'Pegawai',               color:'from-slate-500 to-gray-600',   icon:'user',      desc:'Peminjaman & riwayat BMN' },
  { username:'tamu',           password:'tamu123',       label:'Tamu',                  color:'from-cyan-400 to-blue-500',    icon:'eye',       desc:'Melihat info & statistik BMN' },
];

let facilityFilter = 'semua';
let activeModalFacility = null;
const PROMO_END = new Date('2026-04-30T23:59:59');

// Countdown
function updateCountdown() {
  const hEl = document.getElementById('cdH'), mEl = document.getElementById('cdM'), sEl = document.getElementById('cdS');
  if (!hEl) return;
  let ms = PROMO_END - Date.now(); if (ms < 0) ms = 0;
  const s = Math.floor(ms / 1000);
  hEl.textContent = String(Math.floor(s / 3600)).padStart(2,'0');
  mEl.textContent = String(Math.floor((s % 3600) / 60)).padStart(2,'0');
  sEl.textContent = String(s % 60).padStart(2,'0');
}
updateCountdown(); setInterval(updateCountdown, 1000);

function starRow(rating, size='13px') {
  const n = Math.round(rating);
  return [0,1,2,3,4].map(i => `<span style="font-size:${size};line-height:1;color:${i < n ? '#f59e0b' : '#e2e8f0'}">★</span>`).join('');
}

function buildCarousel() {
  const chipsEl  = document.getElementById('facilityChips');
  const scrollEl = document.getElementById('facilitiesCarouselScroll');
  if (!chipsEl || !scrollEl) return;
  chipsEl.innerHTML = FACILITY_CHIPS.map(c => {
    const active = facilityFilter === c.id;
    return `<button type="button" onclick="setFacilityFilter('${c.id}')" class="px-4 py-2 rounded-full text-sm font-semibold transition border-2 ${active ? 'border-blue-500 bg-blue-50 text-navy-800 shadow-sm' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'}">${c.label}</button>`;
  }).join('');
  const list = facilityFilter === 'semua' ? FACILITIES : FACILITIES.filter(f => f.category === facilityFilter);
  if (!list.length) { scrollEl.innerHTML = '<p class="text-slate-500 text-sm py-8 px-4">Tidak ada fasilitas pada kategori ini.</p>'; return; }
  scrollEl.innerHTML = list.map(f => {
    const globalIdx = FACILITIES.indexOf(f);
    const rs = String(f.rating).replace('.', ',');
    const op = f.priceOld ? `<div class="text-slate-400 text-xs line-through mb-0.5">${f.priceOld}<span class="text-slate-300">/hari</span></div>` : '';
    return `<article class="facility-card flex-shrink-0 w-[260px] sm:w-[280px] snap-start rounded-2xl bg-white shadow-md border border-slate-100/80 overflow-hidden card-hover flex flex-col" onclick="openModal(${globalIdx})" title="Klik untuk lihat detail">
      <div class="relative overflow-hidden" style="aspect-ratio:4/3;">
        <img src="${f.images[0]}" alt="${f.name}" class="card-img w-full h-full object-cover" loading="lazy">
        <div class="card-overlay absolute inset-0 flex flex-col justify-end p-3"><div class="view-detail-btn inline-flex items-center gap-1.5 bg-white/90 backdrop-blur text-navy-800 text-xs font-bold px-3 py-1.5 rounded-full self-start shadow"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>Lihat Detail</div></div>
        ${f.images.length > 1 ? `<div class="absolute top-2 right-2 flex gap-0.5">${f.images.map((_,i)=>`<div class="w-1.5 h-1.5 rounded-full ${i===0?'bg-white':'bg-white/50'}"></div>`).join('')}</div>` : ''}
      </div>
      <div class="p-3.5 flex flex-col flex-1">
        <span class="text-xs font-bold px-2 py-0.5 rounded-full mb-2 self-start ${f.availClass}">${f.availability}</span>
        <h3 class="font-bold text-navy-900 text-sm leading-snug mb-1 line-clamp-2">${f.name}</h3>
        <div class="flex items-center gap-0.5 mb-1">${starRow(f.rating,'11px')}</div>
        <p class="text-slate-500 text-xs mb-1">📍 ${f.location}</p>
        <p class="text-slate-400 text-xs mb-2">👥 ${f.capacity}</p>
        <div class="flex items-center gap-2 mb-3 mt-auto text-xs"><span class="inline-flex items-center justify-center min-w-[1.75rem] h-7 px-1 rounded-md bg-violet-600 text-white font-bold text-[11px] shadow-sm">${rs}</span><span class="text-slate-600"><span class="font-semibold text-navy-800">${rs}/5</span> <span class="text-slate-400">(${f.reviews} ulasan)</span></span></div>
        <div class="border-t border-slate-100 pt-2.5">${op}<div class="text-red-600 font-extrabold text-base leading-tight tracking-tight">${f.price}</div><p class="text-slate-400 text-[11px] mt-1">Belum termasuk pajak &amp; biaya lain</p></div>
      </div>
    </article>`;
  }).join('');
}

function setFacilityFilter(id) { facilityFilter = id; buildCarousel(); }
function facilitiesScrollNext() { const el = document.getElementById('facilitiesCarouselScroll'); if (el) el.scrollBy({ left: 300, behavior:'smooth' }); }
function facilitiesScrollPrev() { const el = document.getElementById('facilitiesCarouselScroll'); if (el) el.scrollBy({ left: -300, behavior:'smooth' }); }

function openModal(idx) {
  const f = FACILITIES[idx]; if (!f) return;
  activeModalFacility = f;
  const mainImg = document.getElementById('modalMainImg');
  mainImg.src = f.images[0]; mainImg.alt = f.name;
  mainImg.className = 'modal-img w-full h-full object-cover';
  const badge = document.getElementById('modalAvailBadge');
  badge.textContent = f.availability; badge.className = `text-xs font-bold px-3 py-1.5 rounded-full ${f.availClass}`;
  document.getElementById('modalRatingScore').textContent = String(f.rating).replace('.', ',');
  document.getElementById('modalStars').innerHTML = starRow(f.rating, '12px');
  document.getElementById('modalReviewCount').textContent = `(${f.reviews} ulasan)`;
  document.getElementById('modalThumbs').innerHTML = f.images.map((img, i) => `<div class="thumb flex-shrink-0 ${i===0?'active':''}" onclick="switchModalImg(${i})" style="width:72px;height:52px;"><img src="${img}" alt="foto ${i+1}" class="w-full h-full object-cover"></div>`).join('');
  document.getElementById('modalName').textContent = f.name;
  document.getElementById('modalLocation').textContent = f.location;
  const specs = [
    { icon:'users', label:'Kapasitas', value:f.capacity },
    { icon:'maximize-2', label:'Luas', value:f.luas },
    { icon:'clock', label:'Operasional', value:f.operasional },
    { icon:'phone', label:'Kontak TU', value:f.kontak },
  ];
  document.getElementById('modalSpecs').innerHTML = specs.map(s => `<div class="flex items-start gap-2.5 bg-slate-50 rounded-xl p-3"><div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0"><i data-lucide="${s.icon}" class="w-3.5 h-3.5 text-navy-600"></i></div><div><div class="text-slate-400 text-[10px] font-semibold uppercase tracking-wide">${s.label}</div><div class="text-navy-900 text-xs font-semibold mt-0.5 leading-snug">${s.value}</div></div></div>`).join('');
  document.getElementById('modalDesc').textContent = f.description;
  document.getElementById('modalFeatures').innerHTML = f.features.map(feat => `<span class="inline-flex items-center gap-1 bg-blue-50 text-navy-700 text-xs font-medium px-2.5 py-1 rounded-full border border-blue-100"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none" stroke="#1a2f9b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>${feat}</span>`).join('');
  document.getElementById('modalRules').innerHTML = f.rules.map(rule => `<li class="flex items-start gap-2 text-slate-600 text-xs leading-relaxed"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="#3355ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5"><polyline points="9 18 15 12 9 6"/></svg>${rule}</li>`).join('');
  document.getElementById('modalPriceOld').textContent = f.priceOld ? f.priceOld + '/hari' : '';
  document.getElementById('modalPrice').textContent = f.price;
  document.getElementById('facilityModal').classList.remove('hidden');
  document.body.style.overflow = 'hidden';
  setTimeout(() => lucide.createIcons(), 30);
}

function switchModalImg(idx) {
  if (!activeModalFacility) return;
  const mainImg = document.getElementById('modalMainImg');
  mainImg.style.animation = 'none'; mainImg.offsetHeight;
  mainImg.style.animation = ''; mainImg.className = 'modal-img w-full h-full object-cover';
  mainImg.src = activeModalFacility.images[idx];
  document.querySelectorAll('#modalThumbs .thumb').forEach((th, i) => th.classList.toggle('active', i === idx));
}

function closeModal() {
  document.getElementById('facilityModal').classList.add('hidden');
  document.body.style.overflow = '';
  activeModalFacility = null;
}
function handleModalOverlayClick(e) { if (e.target === document.getElementById('facilityModal')) closeModal(); }
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

function buildDemoAccounts() {
  const grid = document.getElementById('demoAccountsGrid'); if (!grid) return;
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
      <a href="{{ route('login') }}"
        onclick="sessionStorage.setItem('prefill_u', '${a.username}'); sessionStorage.setItem('prefill_p', '${a.password}');"
        class="block w-full text-center py-2 text-sm font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 rounded-lg transition">
        Login Cepat →
      </a>
    </div>`).join('');
  lucide.createIcons();
}

buildCarousel();
buildDemoAccounts();
lucide.createIcons();
</script>
</body>
</html>