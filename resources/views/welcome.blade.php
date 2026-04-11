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
    @keyframes fadeUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @keyframes slideInRight { from { opacity:0; transform:translateX(40px); } to { opacity:1; transform:translateX(0); } }
    @keyframes floatBob { 0%,100%{ transform:translateY(0px);} 50%{ transform:translateY(-12px);} }
    .anim-fade-up { animation: fadeUp 0.7s ease forwards; }
    .anim-fade-in { animation: fadeIn 0.5s ease forwards; }
    .anim-slide-in { animation: slideInRight 0.6s ease forwards; }
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
    .stat-card { position: relative; overflow: hidden; }
    .stat-card::before { content:''; position:absolute; top:-50%; right:-50%; width:100%; height:100%; background:radial-gradient(circle, rgba(51,85,255,0.08) 0%, transparent 70%); }
    .facilities-scroll { -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none; }
    .facilities-scroll::-webkit-scrollbar { display: none; }
    .hero-bg { background: linear-gradient(135deg, #060d33 0%, #0f1f6e 40%, #1a2f9b 70%, #3355ff 100%); }
    .auth-bg { background: linear-gradient(135deg, #060d33 0%, #0f1f6e 50%, #1a2f9b 100%); }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #bccfff; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #8eaeff; }
    /* Auth form input focus */
    .auth-input { transition: all 0.2s ease; }
    .auth-input:focus { border-color: #3355ff; box-shadow: 0 0 0 3px rgba(51,85,255,0.12); outline: none; }
    /* Page transition */
    .page { display: none; }
    .page.active { display: block; }
    /* Float anim for auth illustration */
    .float-anim { animation: floatBob 4s ease-in-out infinite; }
    /* Password strength bar */
    .strength-bar { height: 4px; border-radius: 9999px; transition: all 0.3s ease; }
    /* Checkbox custom */
    .custom-check { appearance: none; width: 18px; height: 18px; border: 2px solid #cbd5e1; border-radius: 5px; cursor: pointer; transition: all 0.2s; flex-shrink: 0; position: relative; }
    .custom-check:checked { background: #3355ff; border-color: #3355ff; }
    .custom-check:checked::after { content: ''; position: absolute; left: 3px; top: 0px; width: 5px; height: 10px; border: 2px solid white; border-top: none; border-left: none; transform: rotate(45deg); }
  </style>
</head>
<body class="h-full bg-slate-50">

<!-- =============================================
     PAGE: LANDING
     ============================================= -->
<div id="page-landing" class="page active">

  <!-- NAVBAR -->
  <nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300" style="background: rgba(6, 13, 51, 0.95); backdrop-filter: blur(12px); box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 20px;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16 md:h-20">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="3" width="7" height="7" rx="1.5" fill="#3355ff"/>
              <rect x="14" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/>
              <rect x="3" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/>
              <rect x="14" y="14" width="7" height="7" rx="1.5" fill="#3355ff"/>
            </svg>
          </div>
          <div>
            <span class="text-white font-bold text-lg tracking-tight">SIBMN</span>
            <span class="text-blue-200 text-xs block leading-none">BPMP Gorontalo</span>
          </div>
        </div>
        <div class="hidden md:flex items-center gap-8">
          <a href="#hero" class="text-blue-100 hover:text-white text-sm font-medium transition">Beranda</a>
          <a href="#fitur" class="text-blue-100 hover:text-white text-sm font-medium transition">Fitur</a>
          <a href="#statistik" class="text-blue-100 hover:text-white text-sm font-medium transition">Statistik</a>
          <a href="#fasilitas" class="text-blue-100 hover:text-white text-sm font-medium transition">Fasilitas</a>
          <a href="#kontak" class="text-blue-100 hover:text-white text-sm font-medium transition">Kontak</a>
        </div>
        <div class="flex items-center gap-3">
          <button onclick="goToPage('login')" class="text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-white/10 transition">Masuk</button>
          <button onclick="goToPage('register')" class="btn-primary text-white text-sm font-semibold px-5 py-2 rounded-lg">Daftar</button>
          <button class="md:hidden text-white" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
              <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div id="mobileMenu" class="hidden md:hidden bg-navy-900/95 backdrop-blur-lg pb-4 px-4">
      <a href="#hero" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Beranda</a>
      <a href="#fitur" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Fitur</a>
      <a href="#statistik" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Statistik</a>
      <a href="#fasilitas" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Fasilitas</a>
      <a href="#kontak" class="block py-2 text-blue-100 text-sm" onclick="document.getElementById('mobileMenu').classList.add('hidden')">Kontak</a>
      <div class="flex gap-2 mt-3 pt-3 border-t border-white/10">
        <button onclick="goToPage('login')" class="flex-1 text-white text-sm font-semibold py-2 rounded-lg border border-white/20 hover:bg-white/10 transition">Masuk</button>
        <button onclick="goToPage('register')" class="flex-1 btn-primary text-white text-sm font-semibold py-2 rounded-lg">Daftar</button>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section id="hero" class="hero-bg relative overflow-hidden" style="min-height: 600px; padding-top: 100px; padding-bottom: 80px;">
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
          <span class="bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent">Barang Milik Negara</span>
        </h1>
        <p class="text-blue-200 text-lg md:text-xl max-w-xl mb-8 leading-relaxed anim-fade-up delay-3">
          Kelola dan monitoring BMN pada Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo secara digital, transparan, dan akuntabel.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start anim-fade-up delay-4">
          <button onclick="goToPage('login')" class="btn-primary text-white font-semibold px-8 py-3.5 rounded-xl flex items-center justify-center gap-2 text-base">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
              <polyline points="10 17 15 12 10 7"/>
              <line x1="15" x2="3" y1="12" y2="12"/>
            </svg>
            Masuk Sekarang
          </button>
          <a href="#fitur" class="border border-white/30 text-white font-semibold px-8 py-3.5 rounded-xl flex items-center justify-center gap-2 text-base hover:bg-white/10 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/>
            </svg>
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
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-300">
                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
              </svg>
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
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
          <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M16.5 9.4 7.55 4.24"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg></div>
          <h3 class="font-bold text-navy-900 text-lg mb-2">Pencatatan Persediaan</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Kelola stok barang habis pakai, ATK, dan bahan operasional dengan pencatatan masuk-keluar yang akurat.</p>
        </div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
          <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-600"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg></div>
          <h3 class="font-bold text-navy-900 text-lg mb-2">Manajemen Sarana Prasarana</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Monitoring kondisi gedung, ruangan, kendaraan dinas, dan fasilitas pendukung lainnya.</p>
        </div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
          <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-cyan-600"><line x1="3" x2="21" y1="22" y2="22"/><line x1="6" x2="6" y1="18" y2="11"/><line x1="10" x2="10" y1="18" y2="11"/><line x1="14" x2="14" y1="18" y2="11"/><line x1="18" x2="18" y1="18" y2="11"/><polygon points="12 2 20 7 4 7"/></svg></div>
          <h3 class="font-bold text-navy-900 text-lg mb-2">Pengelolaan Aset Tetap</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Inventarisasi tanah, bangunan, peralatan &amp; mesin, serta aset tetap lainnya sesuai standar SIMAK-BMN.</p>
        </div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
          <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-600"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="m9 15 2 2 4-4"/></svg></div>
          <h3 class="font-bold text-navy-900 text-lg mb-2">Peminjaman &amp; Pengembalian</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Sistem peminjaman aset oleh pegawai dengan tracking status dan riwayat lengkap.</p>
        </div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
          <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-600"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg></div>
          <h3 class="font-bold text-navy-900 text-lg mb-2">Laporan &amp; Analitik</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Generate laporan BMN otomatis, neraca aset, dan analisis kondisi barang secara real-time.</p>
        </div>
        <div class="card-hover bg-white rounded-2xl p-7 border border-slate-100">
          <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-rose-600"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
          <h3 class="font-bold text-navy-900 text-lg mb-2">Multi-Role Access</h3>
          <p class="text-slate-500 text-sm leading-relaxed">Hak akses berbeda untuk Kepala BPMP, Kasubag, Admin Persediaan, Admin Sarpras, Admin Aset, dan Pegawai.</p>
        </div>
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
        <div class="stat-card glass rounded-2xl p-6 text-center">
          <div class="w-14 h-14 bg-blue-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-300"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg></div>
          <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">1,247</div>
          <div class="text-blue-200 text-sm">Total Item BMN</div>
        </div>
        <div class="stat-card glass rounded-2xl p-6 text-center">
          <div class="w-14 h-14 bg-green-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-300"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
          <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">Rp 28.5M</div>
          <div class="text-blue-200 text-sm">Nilai Aset Terkelola</div>
        </div>
        <div class="stat-card glass rounded-2xl p-6 text-center">
          <div class="w-14 h-14 bg-yellow-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-300"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg></div>
          <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">342</div>
          <div class="text-blue-200 text-sm">Transaksi Bulan Ini</div>
        </div>
        <div class="stat-card glass rounded-2xl p-6 text-center">
          <div class="w-14 h-14 bg-purple-500/20 rounded-xl flex items-center justify-center mx-auto mb-3"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-300"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
          <div class="text-3xl md:text-4xl font-extrabold text-white mb-1">98.5%</div>
          <div class="text-blue-200 text-sm">Kondisi Baik</div>
        </div>
      </div>
    </div>
  </section>

  <!-- FASILITAS -->
  <section id="fasilitas" class="py-16 md:py-20 bg-slate-50">
    <!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fasilitas – SIBMN BPMP Gorontalo</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
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
    html, body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }

    /* ── CARD & GLOBAL ── */
    .card-hover { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 16px 36px rgba(10,21,80,0.13); }
    .btn-primary { background: linear-gradient(135deg, #1a2f9b 0%, #3355ff 100%); transition: all 0.25s; }
    .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 22px rgba(26,47,155,0.32); }
    .glass { background: rgba(255,255,255,0.08); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15); }

    /* ── CAROUSEL ── */
    .facilities-scroll { -webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none; }
    .facilities-scroll::-webkit-scrollbar { display: none; }

    /* ── CHIP ── */
    .chip { transition: all 0.2s ease; }

    /* ── STRENGTH BAR ── */
    .strength-bar { height: 4px; border-radius: 9999px; transition: all 0.3s ease; }

    /* ── MODAL BACKDROP ── */
    #facilityModal {
      display: none;
      position: fixed;
      inset: 0;
      z-index: 9999;
      background: rgba(6,13,51,0.72);
      backdrop-filter: blur(6px);
      align-items: center;
      justify-content: center;
      padding: 1rem;
      animation: fadeIn 0.2s ease;
    }
    #facilityModal.open { display: flex; }

    /* ── MODAL PANEL ── */
    #modalPanel {
      background: #fff;
      border-radius: 1.5rem;
      width: 100%;
      max-width: 860px;
      max-height: 90vh;
      overflow-y: auto;
      position: relative;
      animation: slideUp 0.28s cubic-bezier(0.22,1,0.36,1);
    }
    #modalPanel::-webkit-scrollbar { width: 5px; }
    #modalPanel::-webkit-scrollbar-thumb { background: #bccfff; border-radius: 3px; }

    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    @keyframes slideUp { from { opacity:0; transform: translateY(32px); } to { opacity:1; transform: translateY(0); } }

    /* ── TABS ── */
    .tab-btn { transition: all 0.2s; border-bottom: 2px solid transparent; }
    .tab-btn.active { border-bottom-color: #3355ff; color: #1a2f9b; font-weight: 700; }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── GALLERY THUMB ── */
    .thumb { cursor: pointer; border: 2px solid transparent; border-radius: 0.5rem; overflow: hidden; transition: border-color 0.15s; }
    .thumb.selected { border-color: #3355ff; }
    .thumb img { width: 100%; height: 52px; object-fit: cover; display: block; }

    /* ── BADGE ── */
    .badge { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 9999px; }

    /* ── COUNTDOWN ── */
    .cd-box { display: inline-flex; min-width: 2.25rem; justify-content: center; background: #eef3ff; color: #0f1f6e; border: 1px solid #d9e4ff; border-radius: 0.5rem; padding: 5px 8px; font-size: 13px; font-weight: 700; font-variant-numeric: tabular-nums; }

    /* ── RESPONSIVE MODAL IMAGE ── */
    #modalHeroImg { width: 100%; height: 280px; object-fit: cover; display: block; }
    @media (min-width: 640px) { #modalHeroImg { height: 340px; } }

    /* ── STAR ── */
    .star-filled { color: #f59e0b; }
    .star-empty { color: #e2e8f0; }
  </style>
</head>
<body>

<!-- ===================================================
     SECTION: FASILITAS
     =================================================== -->
<section id="fasilitas" class="py-16 md:py-20 bg-slate-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- CARD WRAPPER -->
    <div class="rounded-3xl overflow-hidden bg-white border border-slate-100 shadow-xl">

      <!-- HEADER -->
      <div class="px-5 pt-6 pb-4 md:px-8 md:pt-8 md:pb-5 border-b border-slate-100/80">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5 mb-5">
          <!-- Title -->
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-blue-50 flex items-center justify-center flex-shrink-0 border border-blue-100/80">
              <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="#0f1f6e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
            </div>
            <div>
              <h2 class="text-xl md:text-2xl font-bold text-navy-900 tracking-tight leading-tight">Fasilitas Unggulan</h2>
              <p class="text-slate-600 text-sm mt-0.5">BPMP Provinsi Gorontalo — sewa &amp; peminjaman untuk instansi dan umum</p>
            </div>
          </div>
          <!-- Countdown -->
          <div class="flex items-center gap-2 lg:gap-3 flex-wrap lg:flex-nowrap lg:justify-end">
            <span class="text-slate-500 text-sm font-medium whitespace-nowrap">Penawaran berakhir dalam</span>
            <div class="flex items-center gap-1">
              <span id="cdH" class="cd-box">00</span>
              <span class="font-bold text-slate-300 text-sm">:</span>
              <span id="cdM" class="cd-box">00</span>
              <span class="font-bold text-slate-300 text-sm">:</span>
              <span id="cdS" class="cd-box">00</span>
            </div>
          </div>
        </div>

        <!-- FILTER CHIPS -->
        <div id="facilityChips" class="flex flex-wrap gap-2"></div>
      </div>

      <!-- CAROUSEL AREA -->
      <div class="relative px-3 pb-6 md:px-6 md:pb-8 pt-4 bg-slate-50/70">

        <!-- Prev button -->
        <button onclick="facilitiesScrollPrev()" class="absolute left-1 md:left-2 top-[42%] -translate-y-1/2 z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white shadow-lg hidden sm:flex items-center justify-center text-slate-400 hover:text-navy-700 hover:bg-white transition border border-slate-200/80">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </button>

        <!-- Cards scroll -->
        <div id="facilitiesCarouselScroll" class="facilities-scroll flex gap-3 md:gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory py-1 pl-1 pr-14 sm:pr-16 md:px-2"></div>

        <!-- Next button -->
        <button onclick="facilitiesScrollNext()" class="absolute right-1 md:right-2 top-[42%] -translate-y-1/2 z-10 w-10 h-10 md:w-11 md:h-11 rounded-full bg-white shadow-lg flex items-center justify-center text-slate-400 hover:text-navy-700 hover:bg-white transition border border-slate-200/80">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </button>
      </div>
    </div>

    <p class="text-center text-slate-400 text-xs mt-5 max-w-2xl mx-auto">
      Harga dapat berubah sesuai kebijakan. Hubungi Tata Usaha untuk jadwal dan persyaratan resmi.
      <span class="inline-block mt-1">Klik kartu fasilitas untuk melihat detail lengkap.</span>
    </p>
  </div>
</section>


<!-- ===================================================
     MODAL DETAIL FASILITAS
     =================================================== -->
<div id="facilityModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" onclick="handleModalBackdropClick(event)">
  <div id="modalPanel">

    <!-- Close button -->
    <button onclick="closeModal()" aria-label="Tutup" class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-white/90 shadow-md flex items-center justify-center text-slate-500 hover:text-navy-700 hover:bg-white transition border border-slate-200">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>

    <!-- Hero Image -->
    <div class="relative overflow-hidden rounded-t-3xl">
      <img id="modalHeroImg" src="" alt="" loading="lazy">
      <!-- Category badge on image -->
      <div class="absolute bottom-4 left-4">
        <span id="modalCategoryBadge" class="badge text-white" style="background:rgba(6,13,51,0.7);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,0.2)"></span>
      </div>
      <!-- Availability badge -->
      <div class="absolute top-4 left-4">
        <span id="modalAvailBadge" class="badge bg-green-500/90 text-white"></span>
      </div>
    </div>

    <!-- Gallery thumbnails -->
    <div id="modalGallery" class="flex gap-2 px-5 pt-3 md:px-8 overflow-x-auto pb-1" style="scrollbar-width:none"></div>

    <!-- Body -->
    <div class="px-5 pt-4 pb-8 md:px-8">

      <!-- Title row -->
      <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
        <div>
          <h2 id="modalTitle" class="text-xl md:text-2xl font-extrabold text-navy-900 leading-tight mb-1"></h2>
          <div class="flex items-center gap-1.5 flex-wrap">
            <div id="modalStars" class="flex items-center gap-0.5 text-sm"></div>
            <span id="modalRatingNum" class="text-navy-700 text-sm font-bold"></span>
            <span id="modalReviewCount" class="text-slate-400 text-sm"></span>
            <span class="text-slate-200 mx-1">|</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            <span id="modalLocation" class="text-slate-500 text-sm"></span>
          </div>
        </div>
        <div class="flex-shrink-0 text-right">
          <div id="modalPriceOld" class="text-slate-400 text-sm line-through mb-0.5"></div>
          <div id="modalPrice" class="text-2xl font-extrabold text-red-600 leading-tight tracking-tight"></div>
          <div class="text-slate-400 text-xs mt-0.5">Belum termasuk pajak &amp; biaya lain</div>
        </div>
      </div>

      <!-- TABS -->
      <div class="border-b border-slate-100 mb-5">
        <div class="flex gap-6 overflow-x-auto" style="scrollbar-width:none">
          <button class="tab-btn active text-sm pb-3 text-navy-700 whitespace-nowrap" onclick="switchTab('info')">Informasi</button>
          <button class="tab-btn text-sm pb-3 text-slate-500 whitespace-nowrap" onclick="switchTab('fasilitas')">Fasilitas &amp; Kapasitas</button>
          <button class="tab-btn text-sm pb-3 text-slate-500 whitespace-nowrap" onclick="switchTab('syarat')">Syarat &amp; Ketentuan</button>
          <button class="tab-btn text-sm pb-3 text-slate-500 whitespace-nowrap" onclick="switchTab('kontak')">Kontak</button>
        </div>
      </div>

      <!-- TAB: INFO -->
      <div id="tab-info" class="tab-panel active">
        <p id="modalDesc" class="text-slate-600 text-sm leading-relaxed mb-5"></p>
        <!-- Stats grid -->
        <div id="modalStats" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5"></div>
        <!-- Jadwal -->
        <h4 class="font-bold text-navy-900 text-sm mb-3">Jam Operasional</h4>
        <div id="modalJadwal" class="space-y-1.5 mb-4"></div>
      </div>

      <!-- TAB: FASILITAS -->
      <div id="tab-fasilitas" class="tab-panel">
        <div id="modalFasilList" class="grid sm:grid-cols-2 gap-x-6 gap-y-2 mb-5"></div>
        <!-- Kapasitas bar -->
        <h4 class="font-bold text-navy-900 text-sm mb-3">Kapasitas Ruang</h4>
        <div id="modalKapasitas" class="space-y-3"></div>
      </div>

      <!-- TAB: SYARAT -->
      <div id="tab-syarat" class="tab-panel">
        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4 mb-4 flex gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#b45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
          <p class="text-amber-800 text-sm leading-relaxed">Harap baca syarat dan ketentuan berikut sebelum mengajukan peminjaman atau penyewaan fasilitas.</p>
        </div>
        <div id="modalSyarat" class="space-y-3"></div>
      </div>

      <!-- TAB: KONTAK -->
      <div id="tab-kontak" class="tab-panel">
        <div id="modalKontak" class="space-y-3 mb-5"></div>
        <div class="bg-navy-50 rounded-xl p-4 flex gap-3 items-start border border-navy-100">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#1a2f9b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
          <p class="text-navy-700 text-sm leading-relaxed">Pengajuan peminjaman resmi dilakukan melalui surat permohonan yang ditujukan kepada Kepala BPMP Provinsi Gorontalo.</p>
        </div>
      </div>

      <!-- CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-3 mt-6 pt-5 border-t border-slate-100">
        <button onclick="closeModal()" class="flex-1 btn-primary text-white font-bold py-3 rounded-xl text-sm flex items-center justify-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="9" x2="15" y1="13" y2="13"/><line x1="9" x2="15" y1="17" y2="17"/><line x1="12" x2="12" y1="9" y2="13"/></svg>
          Ajukan Peminjaman
        </button>
        <button onclick="closeModal()" class="flex-1 border border-slate-200 text-navy-700 font-semibold py-3 rounded-xl text-sm flex items-center justify-center gap-2 hover:bg-slate-50 transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 12 19.79 19.79 0 0 1 1.09 3.38a2 2 0 0 1 2-2h3a2 2 0 0 1 2 1.72c.12.81.31 1.61.57 2.39a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.78.26 1.58.45 2.39.57A2 2 0 0 1 22 16.92z"/></svg>
          Hubungi Pengelola Sarpras
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ===================================================
     JAVASCRIPT
     =================================================== -->
<script>
/* ─── DATA FASILITAS ─── */
const FACILITIES = [
  {
    id: 1,
    name: 'Aula Utama BPMP',
    price: 'Rp 2.500.000/hari',
    priceOld: 'Rp 3.000.000',
    category: 'ruang',
    categoryLabel: 'Ruang & Aula',
    image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80',
      'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&q=80',
      'https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?w=800&q=80',
    ],
    availability: 'Beberapa jadwal tersedia',
    location: 'Gedung Utama Lt. 1, BPMP Gorontalo',
    rating: 4.6,
    reviews: 18,
    desc: 'Aula Utama BPMP Provinsi Gorontalo merupakan ruang pertemuan besar yang representatif dan modern, ideal untuk kegiatan seminar, workshop, pelatihan, rapat koordinasi, maupun acara resmi kedinasan lainnya. Dilengkapi sistem tata suara profesional dan pencahayaan yang memadai.',
    stats: [
      { label: 'Kapasitas', value: '300 orang' },
      { label: 'Luas', value: '600 m²' },
      { label: 'Lantai', value: '1 (Gedung Utama)' },
      { label: 'Parkir', value: '100+ kendaraan' },
    ],
    jadwal: [
      { hari: 'Senin – Jumat', jam: '07.00 – 21.00 WITA' },
      { hari: 'Sabtu', jam: '08.00 – 17.00 WITA' },
      { hari: 'Minggu & Libur Nasional', jam: 'Khusus (via permohonan)' },
    ],
    fasilitasList: [
      'Sound system profesional (2 mikrofon wireless)',
      'Proyektor Full HD + layar lebar (4 x 3 m)',
      'AC central (suhu terkontrol)',
      'Pencahayaan panggung adjustable',
      'Podium + meja pimpinan',
      'Kursi lipat 300 unit',
      'Meja registrasi (2 unit)',
      'Toilet dalam gedung (3 unit)',
      'Wi-Fi dedicated 100 Mbps',
      'Area parkir luas',
      'Lobby penerimaan tamu',
      'CCTV 24 jam',
    ],
    kapasitas: [
      { setup: 'Teater (kursi berderet)', persen: 100, orang: '300 orang' },
      { setup: 'Kelas (meja-kursi)', persen: 60, orang: '180 orang' },
      { setup: 'U-Shape / Horseshoe', persen: 30, orang: '90 orang' },
      { setup: 'Banquet / Makan', persen: 50, orang: '150 orang' },
    ],
    syarat: [
      { title: 'Surat Permohonan Resmi', isi: 'Ajukan surat permohonan resmi kepada Kepala BPMP Gorontalo minimal 7 hari kerja sebelum pelaksanaan kegiatan.' },
      { title: 'Uang Muka', isi: 'Pembayaran uang muka sebesar 50% dari total biaya sewa dilakukan saat konfirmasi booking.' },
      { title: 'Tujuan Kegiatan', isi: 'Prioritas untuk kegiatan pendidikan, pelatihan, dan kedinasan. Kegiatan umum/komersial dikenakan tarif berbeda.' },
      { title: 'Pembatalan', isi: 'Pembatalan kurang dari 3 hari kerja tidak mendapatkan pengembalian uang muka.' },
      { title: 'Kebersihan & Ketertiban', isi: 'Pengguna bertanggung jawab menjaga kebersihan dan kondisi fasilitas selama penggunaan.' },
    ],
    kontak: [
      { icon: 'phone', label: 'Telepon TU', value: '(0435) 821-555' },
      { icon: 'mail', label: 'Email', value: 'bpmp.gorontalo@kemdikbud.go.id' },
      { icon: 'person', label: 'Narahubung', value: 'Kasubag TU – Bpk. Ahmad (ext. 101)' },
      { icon: 'clock', label: 'Jam Layanan', value: 'Senin–Jumat, 08.00–16.00 WITA' },
    ],
  },
  {
    id: 2,
    name: 'Ruang Rapat VIP',
    price: 'Rp 1.000.000/hari',
    priceOld: 'Rp 1.250.000',
    category: 'ruang',
    categoryLabel: 'Ruang & Aula',
    image: 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&q=80',
      'https://images.unsplash.com/photo-1582653291997-079a1c04e5a1?w=800&q=80',
      'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=800&q=80',
    ],
    availability: '2 slot minggu ini',
    location: 'Gedung Utama Lt. 2, BPMP Gorontalo',
    rating: 4.8,
    reviews: 24,
    desc: 'Ruang Rapat VIP dirancang khusus untuk pertemuan eksekutif, rapat koordinasi pimpinan, dan diskusi kelompok kecil yang membutuhkan suasana profesional dan privat. Dilengkapi peralatan audio-visual terkini dan furnitur premium.',
    stats: [
      { label: 'Kapasitas', value: '30 orang' },
      { label: 'Luas', value: '80 m²' },
      { label: 'Lantai', value: '2 (Gedung Utama)' },
      { label: 'Setup', value: 'U-Shape / Round' },
    ],
    jadwal: [
      { hari: 'Senin – Jumat', jam: '07.30 – 20.00 WITA' },
      { hari: 'Sabtu', jam: '08.00 – 15.00 WITA (terbatas)' },
      { hari: 'Minggu', jam: 'Tidak tersedia' },
    ],
    fasilitasList: [
      'Smart TV 75" (2 unit)',
      'Video conference (Zoom/Teams ready)',
      'Sound system built-in',
      'Whiteboard digital interaktif',
      'AC split premium',
      'Meja rapat oval 1 unit (30 kursi)',
      'Mini bar & dispenser air minum',
      'Papan tulis & perlengkapan kantor',
      'Wi-Fi dedicated 100 Mbps',
      'Toilet eksklusif 1 unit',
      'CCTV & keamanan',
    ],
    kapasitas: [
      { setup: 'U-Shape', persen: 100, orang: '30 orang' },
      { setup: 'Round Table', persen: 80, orang: '24 orang' },
      { setup: 'Kelas', persen: 70, orang: '21 orang' },
    ],
    syarat: [
      { title: 'Surat Permohonan', isi: 'Ajukan permohonan resmi minimal 3 hari kerja sebelum pelaksanaan.' },
      { title: 'Prioritas Penggunaan', isi: 'Diutamakan untuk kegiatan rapat pimpinan dan tamu resmi Kemendikbud.' },
      { title: 'Kerahasiaan', isi: 'Pengguna bertanggung jawab menjaga kerahasiaan dokumen dan kegiatan rapat.' },
      { title: 'Pembatalan', isi: 'Konfirmasi ulang wajib dilakukan H-1. Pembatalan mendadak tanpa pemberitahuan dikenakan denda administrasi.' },
    ],
    kontak: [
      { icon: 'phone', label: 'Telepon TU', value: '(0435) 821-555' },
      { icon: 'mail', label: 'Email', value: 'bpmp.gorontalo@kemdikbud.go.id' },
      { icon: 'person', label: 'Narahubung', value: 'Staf TU – Ibu Siti (ext. 102)' },
      { icon: 'clock', label: 'Jam Layanan', value: 'Senin–Jumat, 08.00–16.00 WITA' },
    ],
  },
  {
    id: 3,
    name: 'Lab Komputer',
    price: 'Rp 1.500.000/hari',
    priceOld: null,
    category: 'lab',
    categoryLabel: 'Lab',
    image: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&q=80',
      'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&q=80',
      'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80',
    ],
    availability: 'Tersedia',
    location: 'Gedung Pelatihan Lt. 1, BPMP Gorontalo',
    rating: 4.5,
    reviews: 31,
    desc: 'Laboratorium Komputer BPMP dilengkapi unit komputer terkini dengan spesifikasi tinggi, cocok untuk pelatihan TIK, workshop digital, pengembangan SDM berbasis teknologi, dan ujian berbasis komputer (CBT). Setiap peserta mendapatkan satu unit komputer.',
    stats: [
      { label: 'Unit Komputer', value: '40 unit' },
      { label: 'Spesifikasi', value: 'Core i7 / 16 GB RAM' },
      { label: 'OS', value: 'Windows 11 / Ubuntu' },
      { label: 'Koneksi', value: 'LAN + Wi-Fi 200 Mbps' },
    ],
    jadwal: [
      { hari: 'Senin – Jumat', jam: '08.00 – 20.00 WITA' },
      { hari: 'Sabtu', jam: '08.00 – 16.00 WITA' },
      { hari: 'Minggu', jam: 'Tidak tersedia' },
    ],
    fasilitasList: [
      '40 unit komputer Core i7 / 16 GB',
      'SSD 512 GB per unit',
      'Monitor 24" Full HD',
      'Proyektor instruktur 1 unit',
      'Jaringan LAN Gigabit',
      'Wi-Fi dedicated 200 Mbps',
      'Server lokal untuk simulasi',
      'Whiteboard + papan instruksi',
      'AC sentral',
      'Kursi ergonomis 40 unit',
      'Printer laser 2 unit (bersama)',
      'UPS backup power',
    ],
    kapasitas: [
      { setup: 'Individual (1 komputer/orang)', persen: 100, orang: '40 peserta' },
      { setup: 'Berpasangan (2 orang/komputer)', persen: 50, orang: '20 kelompok' },
    ],
    syarat: [
      { title: 'Permohonan Tertulis', isi: 'Surat permohonan resmi minimal 5 hari kerja sebelum pelaksanaan.' },
      { title: 'Data Peserta', isi: 'Daftar nama peserta wajib diserahkan H-2 untuk pembuatan akun dan pengaturan komputer.' },
      { title: 'Software Khusus', isi: 'Instalasi software khusus yang dibutuhkan harus dikonfirmasi minimal 3 hari sebelumnya.' },
      { title: 'Larangan', isi: 'Dilarang menginstal software tanpa izin, membawa makanan/minuman ke area komputer, dan merusak perangkat keras.' },
      { title: 'Asuransi Kerusakan', isi: 'Kerusakan perangkat akibat kelalaian pengguna menjadi tanggung jawab pengguna.' },
    ],
    kontak: [
      { icon: 'phone', label: 'Telepon TU', value: '(0435) 821-555 ext. 103' },
      { icon: 'mail', label: 'Email', value: 'bpmp.gorontalo@kemdikbud.go.id' },
      { icon: 'person', label: 'Teknisi Lab', value: 'Bpk. Reza (HP: 0812-xxxx-xxxx)' },
      { icon: 'clock', label: 'Jam Layanan', value: 'Senin–Jumat, 08.00–16.00 WITA' },
    ],
  },
  {
    id: 4,
    name: 'Ruang Pelatihan A',
    price: 'Rp 800.000/hari',
    priceOld: 'Rp 950.000',
    category: 'ruang',
    categoryLabel: 'Ruang & Aula',
    image: 'https://images.unsplash.com/photo-1580582932707-520aed937d7b?w=800&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1580582932707-520aed937d7b?w=800&q=80',
      'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80',
      'https://images.unsplash.com/photo-1558008258-3256797b43f3?w=800&q=80',
    ],
    availability: 'Kapasitas terbatas',
    location: 'Gedung Pelatihan Lt. 2, BPMP Gorontalo',
    rating: 4.4,
    reviews: 12,
    desc: 'Ruang Pelatihan A adalah ruang kelas modern yang fleksibel, cocok untuk kegiatan pelatihan, workshop, bimbingan teknis (bimtek), dan seminar skala menengah. Layout kursi dapat disesuaikan dengan kebutuhan penyelenggara.',
    stats: [
      { label: 'Kapasitas', value: '60 orang' },
      { label: 'Luas', value: '120 m²' },
      { label: 'Lantai', value: '2 (Gedung Pelatihan)' },
      { label: 'Layout', value: 'Fleksibel' },
    ],
    jadwal: [
      { hari: 'Senin – Jumat', jam: '07.30 – 20.00 WITA' },
      { hari: 'Sabtu', jam: '08.00 – 16.00 WITA' },
      { hari: 'Minggu', jam: 'Tidak tersedia' },
    ],
    fasilitasList: [
      'Proyektor HD + layar 3 x 2 m',
      'Sound system portable',
      'Whiteboard besar 2 unit',
      'Meja lipat 30 unit',
      'Kursi 60 unit',
      'AC split 2 unit',
      'Wi-Fi shared 50 Mbps',
      'Papan flip chart 2 unit',
      'Spidol & perlengkapan tulis',
      'Toilet di lantai yang sama',
    ],
    kapasitas: [
      { setup: 'Kelas', persen: 100, orang: '60 orang' },
      { setup: 'U-Shape', persen: 60, orang: '36 orang' },
      { setup: 'Teater', persen: 85, orang: '51 orang' },
    ],
    syarat: [
      { title: 'Permohonan', isi: 'Surat permohonan resmi minimal 3 hari kerja sebelum pelaksanaan.' },
      { title: 'Pembayaran', isi: 'Lunas sebelum hari pelaksanaan atau melalui transfer ke rekening resmi BPMP.' },
      { title: 'Kebersihan', isi: 'Ruangan wajib bersih dan rapi setelah penggunaan. Sampah dikumpulkan dan dibuang pada tempatnya.' },
      { title: 'Dekorasi', isi: 'Pemasangan dekorasi (banner, spanduk) harus mendapat persetujuan dan tidak merusak dinding/fasilitas.' },
    ],
    kontak: [
      { icon: 'phone', label: 'Telepon TU', value: '(0435) 821-555' },
      { icon: 'mail', label: 'Email', value: 'bpmp.gorontalo@kemdikbud.go.id' },
      { icon: 'person', label: 'Narahubung', value: 'Staf TU – Bpk. Hendra (ext. 104)' },
      { icon: 'clock', label: 'Jam Layanan', value: 'Senin–Jumat, 08.00–16.00 WITA' },
    ],
  },
  {
    id: 5,
    name: 'Kendaraan Dinas – Minibus',
    price: 'Rp 750.000/hari',
    priceOld: null,
    category: 'kendaraan',
    categoryLabel: 'Kendaraan',
    image: 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=800&q=80',
      'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80',
      'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=800&q=80',
    ],
    availability: '1 unit tersedia',
    location: 'Pool Kendaraan BPMP, Gorontalo',
    rating: 4.7,
    reviews: 9,
    desc: 'Kendaraan dinas minibus tersedia untuk keperluan perjalanan dinas, survei lapangan, dan kegiatan operasional resmi dalam lingkup Provinsi Gorontalo. Kendaraan dalam kondisi prima dan dilengkapi fasilitas perjalanan yang nyaman. Tersedia dengan atau tanpa pengemudi.',
    stats: [
      { label: 'Jenis', value: 'Toyota HiAce / Innova' },
      { label: 'Kapasitas', value: '12 penumpang' },
      { label: 'Tahun', value: '2021 / 2022' },
      { label: 'Status', value: 'Laik Jalan (KIR aktif)' },
    ],
    jadwal: [
      { hari: 'Senin – Jumat', jam: 'Tersedia 07.00 – 18.00 WITA' },
      { hari: 'Sabtu', jam: 'Tersedia (terbatas, via permohonan)' },
      { hari: 'Minggu & Libur', jam: 'Khusus kedinasan mendesak' },
    ],
    fasilitasList: [
      'AC double blower',
      'Kapasitas 12 penumpang',
      'GPS tracking aktif',
      'Surat KIR & asuransi aktif',
      'Bahan bakar (tidak termasuk dalam tarif)',
      'Pengemudi tersedia (biaya terpisah Rp 200.000/hari)',
      'Kapasitas bagasi memadai',
      'Kondisi ban & mesin prima',
    ],
    kapasitas: [
      { setup: 'Penumpang (termasuk pengemudi)', persen: 100, orang: '12 orang' },
      { setup: 'Dengan bagasi besar', persen: 70, orang: '8 orang' },
    ],
    syarat: [
      { title: 'Surat Tugas', isi: 'Pengguna wajib melampirkan surat tugas/perjalanan dinas resmi dari instansi.' },
      { title: 'Bahan Bakar', isi: 'Bahan bakar ditanggung pengguna. Kendaraan dikembalikan dengan kondisi BBM tidak kurang dari saat penerimaan.' },
      { title: 'Wilayah Operasional', isi: 'Perjalanan luar Provinsi Gorontalo memerlukan persetujuan khusus Kepala BPMP.' },
      { title: 'Kondisi Kendaraan', isi: 'Kerusakan akibat kelalaian/kecelakaan dalam penggunaan menjadi tanggung jawab pengguna (tidak termasuk insiden force majeure).' },
      { title: 'Pengembalian', isi: 'Kendaraan wajib dikembalikan tepat waktu sesuai jadwal yang disepakati.' },
    ],
    kontak: [
      { icon: 'phone', label: 'Pool Kendaraan', value: '(0435) 821-555 ext. 105' },
      { icon: 'mail', label: 'Email', value: 'bpmp.gorontalo@kemdikbud.go.id' },
      { icon: 'person', label: 'Pengelola Pool', value: 'Bpk. Dedi (HP: 0813-xxxx-xxxx)' },
      { icon: 'clock', label: 'Jam Layanan', value: 'Senin–Jumat, 07.00–17.00 WITA' },
    ],
  },
  {
    id: 6,
    name: 'Gedung Serbaguna',
    price: 'Rp 3.000.000/hari',
    priceOld: 'Rp 3.500.000',
    category: 'outdoor',
    categoryLabel: 'Outdoor & Serbaguna',
    image: 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80',
    gallery: [
      'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80',
      'https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?w=800&q=80',
      'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?w=800&q=80',
    ],
    availability: 'Booking awal bulan',
    location: 'Halaman & Gedung Serbaguna, BPMP Gorontalo',
    rating: 4.5,
    reviews: 7,
    desc: 'Gedung Serbaguna BPMP merupakan fasilitas multiguna yang dapat digunakan untuk pameran pendidikan, expo, wisuda, pertemuan besar, hingga acara outdoor skala provinsi. Tersedia area indoor dan teras outdoor yang luas dengan kapasitas besar.',
    stats: [
      { label: 'Kapasitas', value: '500+ orang' },
      { label: 'Area Indoor', value: '900 m²' },
      { label: 'Area Outdoor', value: '2000 m² (halaman)' },
      { label: 'Parkir', value: '200+ kendaraan' },
    ],
    jadwal: [
      { hari: 'Senin – Jumat', jam: '07.00 – 22.00 WITA' },
      { hari: 'Sabtu', jam: '07.00 – 22.00 WITA' },
      { hari: 'Minggu & Libur', jam: 'Tersedia (via permohonan khusus)' },
    ],
    fasilitasList: [
      'Stage / panggung permanen',
      'Sound system outdoor profesional',
      'Tenda / kanopi besar (tersedia)',
      'Listrik 10.000 VA (extendable)',
      'AC portable (sewa terpisah)',
      'Toilet umum 6 unit',
      'Area parkir luas (200+ kendaraan)',
      'Keamanan & petugas parkir (bisa disediakan)',
      'Generator backup',
      'Akses difabel',
    ],
    kapasitas: [
      { setup: 'Indoor Teater / Upacara', persen: 100, orang: '500 orang' },
      { setup: 'Indoor + Outdoor Pameran', persen: 100, orang: '1.000+ pengunjung' },
      { setup: 'Banquet / Standing Party', persen: 80, orang: '400 orang' },
    ],
    syarat: [
      { title: 'Surat Permohonan Resmi', isi: 'Ajukan surat permohonan minimal 14 hari sebelum pelaksanaan untuk kegiatan besar.' },
      { title: 'Izin Keramaian', isi: 'Penyelenggara bertanggung jawab mengurus izin keramaian dari pihak berwenang jika diperlukan.' },
      { title: 'Keamanan & Ketertiban', isi: 'Penyelenggara menyediakan panitia keamanan dan wajib menjaga ketertiban selama acara berlangsung.' },
      { title: 'Pembersihan Pasca Acara', isi: 'Seluruh sampah dan dekorasi harus dibersihkan dalam 12 jam setelah acara selesai.' },
      { title: 'Konsumsi & Catering', isi: 'Penyelenggara bertanggung jawab atas pengelolaan sampah dari konsumsi dan catering yang disediakan.' },
    ],
    kontak: [
      { icon: 'phone', label: 'Telepon TU', value: '(0435) 821-555' },
      { icon: 'mail', label: 'Email', value: 'bpmp.gorontalo@kemdikbud.go.id' },
      { icon: 'person', label: 'Narahubung', value: 'Kasubag TU – Bpk. Ahmad (ext. 101)' },
      { icon: 'clock', label: 'Jam Layanan', value: 'Senin–Jumat, 08.00–16.00 WITA' },
    ],
  },
];

const FACILITY_CHIPS = [
  { id: 'semua', label: 'Semua' },
  { id: 'ruang', label: 'Ruang & Aula' },
  { id: 'lab', label: 'Lab' },
  { id: 'kendaraan', label: 'Kendaraan' },
  { id: 'outdoor', label: 'Outdoor' },
];

let facilityFilter = 'semua';
let currentModalFacility = null;
let currentHeroIdx = 0;

/* ─── COUNTDOWN ─── */
const PROMO_END = new Date('2026-04-30T23:59:59');
function updateCountdown() {
  const cdH = document.getElementById('cdH');
  const cdM = document.getElementById('cdM');
  const cdS = document.getElementById('cdS');
  if (!cdH) return;
  let ms = PROMO_END - Date.now();
  if (ms < 0) ms = 0;
  const sec = Math.floor(ms / 1000);
  cdH.textContent = String(Math.floor(sec / 3600)).padStart(2, '0');
  cdM.textContent = String(Math.floor((sec % 3600) / 60)).padStart(2, '0');
  cdS.textContent = String(sec % 60).padStart(2, '0');
}
updateCountdown();
setInterval(updateCountdown, 1000);

/* ─── STARS ─── */
function starHTML(rating) {
  const n = Math.round(rating);
  return [0,1,2,3,4].map(i =>
    `<span class="${i < n ? 'star-filled' : 'star-empty'}" style="font-size:13px;line-height:1;">★</span>`
  ).join('');
}

/* ─── CATEGORY COLOR ─── */
function catColor(cat) {
  const map = {
    ruang: 'background:#3355ff',
    lab: 'background:#0f766e',
    kendaraan: 'background:#b45309',
    outdoor: 'background:#7c3aed',
  };
  return map[cat] || 'background:#1a2f9b';
}

/* ─── BUILD CAROUSEL ─── */
function buildCarousel() {
  const chips = document.getElementById('facilityChips');
  const scroll = document.getElementById('facilitiesCarouselScroll');
  if (!chips || !scroll) return;

  chips.innerHTML = FACILITY_CHIPS.map(c => {
    const active = facilityFilter === c.id;
    return `<button type="button" onclick="setFacilityFilter('${c.id}')"
      class="chip px-4 py-2 rounded-full text-sm font-semibold border-2 transition
        ${active
          ? 'border-blue-500 bg-blue-50 text-navy-800 shadow-sm'
          : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:border-slate-300'
        }">
      ${c.label}
    </button>`;
  }).join('');

  const list = facilityFilter === 'semua'
    ? FACILITIES
    : FACILITIES.filter(f => f.category === facilityFilter);

  if (!list.length) {
    scroll.innerHTML = '<p class="text-slate-500 text-sm py-8 px-4">Tidak ada fasilitas pada kategori ini.</p>';
    return;
  }

  scroll.innerHTML = list.map(f => {
    const rs = String(f.rating).replace('.', ',');
    const priceOldHTML = f.priceOld
      ? `<div class="text-slate-400 text-xs line-through mb-0.5">${f.priceOld}</div>`
      : '';

    return `
    <article
      class="flex-shrink-0 w-[260px] sm:w-[280px] snap-start rounded-2xl bg-white shadow-md border border-slate-100/80 overflow-hidden card-hover flex flex-col cursor-pointer group"
      onclick="openModal(${f.id})"
      role="button"
      tabindex="0"
      aria-label="Lihat detail ${f.name}"
      onkeydown="if(event.key==='Enter')openModal(${f.id})"
    >
      <!-- Image -->
      <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden">
        <img
          src="${f.image}"
          alt="${f.name}"
          class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
          loading="lazy"
          width="320" height="240"
        >
        <!-- Overlay hint -->
        <div class="absolute inset-0 bg-navy-900/0 group-hover:bg-navy-900/30 transition-colors duration-300 flex items-center justify-center">
          <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300
            text-white text-xs font-semibold bg-white/20 backdrop-blur px-3 py-1.5 rounded-full border border-white/30
            flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            Lihat Detail
          </span>
        </div>
        <!-- Availability tag -->
        <div class="absolute top-2.5 left-2.5">
          <span class="badge text-white text-[10px]" style="background:rgba(22,163,74,0.88);backdrop-filter:blur(4px)">
            ● ${f.availability}
          </span>
        </div>
      </div>
      <!-- Body -->
      <div class="p-3.5 flex flex-col flex-1">
        <h3 class="font-bold text-navy-900 text-sm leading-snug mb-1.5 line-clamp-2">${f.name}</h3>
        <div class="flex items-center gap-0.5 mb-1">${starHTML(f.rating)}</div>
        <div class="flex items-center gap-1 text-slate-400 text-xs mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          <span class="truncate">${f.location}</span>
        </div>
        <!-- Rating + reviews -->
        <div class="flex items-center gap-2 mb-3 mt-auto">
          <span class="min-w-[1.75rem] h-7 px-1.5 rounded-md flex items-center justify-center text-white font-bold text-[11px] shadow-sm" style="background:#4338ca">${rs}</span>
          <span class="text-slate-500 text-xs"><span class="font-semibold text-navy-800">${rs}/5</span> <span class="text-slate-400">(${f.reviews} ulasan)</span></span>
        </div>
        <!-- Price -->
        <div class="border-t border-slate-100 pt-2.5">
          ${priceOldHTML}
          <div class="text-red-600 font-extrabold text-base leading-tight tracking-tight">${f.price}</div>
          <p class="text-slate-400 text-[11px] mt-1">Belum termasuk pajak &amp; biaya lain</p>
        </div>
      </div>
    </article>`;
  }).join('');
}

function setFacilityFilter(id) {
  facilityFilter = id;
  buildCarousel();
}

function facilitiesScrollNext() {
  const el = document.getElementById('facilitiesCarouselScroll');
  if (el) el.scrollBy({ left: 300, behavior: 'smooth' });
}
function facilitiesScrollPrev() {
  const el = document.getElementById('facilitiesCarouselScroll');
  if (el) el.scrollBy({ left: -300, behavior: 'smooth' });
}

/* ─── MODAL ─── */
function openModal(id) {
  const f = FACILITIES.find(x => x.id === id);
  if (!f) return;
  currentModalFacility = f;
  currentHeroIdx = 0;

  /* ── Hero image ── */
  const heroImg = document.getElementById('modalHeroImg');
  heroImg.src = f.gallery[0];
  heroImg.alt = f.name;

  /* ── Category badge ── */
  document.getElementById('modalCategoryBadge').textContent = f.categoryLabel;
  document.getElementById('modalCategoryBadge').setAttribute('style', catColor(f.category) + ';backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,0.2)');

  /* ── Availability badge ── */
  document.getElementById('modalAvailBadge').textContent = '● ' + f.availability;

  /* ── Gallery ── */
  const galleryEl = document.getElementById('modalGallery');
  galleryEl.innerHTML = f.gallery.map((img, i) => `
    <div class="thumb flex-shrink-0 ${i === 0 ? 'selected' : ''}" onclick="switchHeroImg(${i})" style="width:72px">
      <img src="${img}" alt="Foto ${i+1}">
    </div>`).join('');

  /* ── Title ── */
  document.getElementById('modalTitle').textContent = f.name;

  /* ── Rating ── */
  document.getElementById('modalStars').innerHTML = starHTML(f.rating);
  document.getElementById('modalRatingNum').textContent = String(f.rating).replace('.', ',') + '/5';
  document.getElementById('modalReviewCount').textContent = `(${f.reviews} ulasan)`;

  /* ── Location ── */
  document.getElementById('modalLocation').textContent = f.location;

  /* ── Price ── */
  const priceOldEl = document.getElementById('modalPriceOld');
  priceOldEl.textContent = f.priceOld ? f.priceOld + '/hari' : '';
  document.getElementById('modalPrice').textContent = f.price;

  /* ── Description ── */
  document.getElementById('modalDesc').textContent = f.desc;

  /* ── Stats grid ── */
  document.getElementById('modalStats').innerHTML = f.stats.map(s => `
    <div class="bg-navy-50 rounded-xl p-3 border border-navy-100/60">
      <div class="text-navy-400 text-xs mb-0.5">${s.label}</div>
      <div class="text-navy-900 font-bold text-sm">${s.value}</div>
    </div>`).join('');

  /* ── Jadwal ── */
  document.getElementById('modalJadwal').innerHTML = f.jadwal.map(j => `
    <div class="flex justify-between items-center py-1.5 border-b border-slate-100 last:border-0 text-sm">
      <span class="text-slate-600">${j.hari}</span>
      <span class="font-semibold text-navy-800">${j.jam}</span>
    </div>`).join('');

  /* ── Fasilitas list ── */
  document.getElementById('modalFasilList').innerHTML = f.fasilitasList.map(item => `
    <div class="flex items-start gap-2 text-sm text-slate-600 py-1">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="#3355ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 mt-0.5"><polyline points="20 6 9 17 4 12"/></svg>
      ${item}
    </div>`).join('');

  /* ── Kapasitas ── */
  document.getElementById('modalKapasitas').innerHTML = f.kapasitas.map(k => `
    <div>
      <div class="flex justify-between text-sm mb-1.5">
        <span class="text-slate-600">${k.setup}</span>
        <span class="font-semibold text-navy-800">${k.orang}</span>
      </div>
      <div class="w-full bg-slate-100 rounded-full" style="height:6px">
        <div class="rounded-full h-full" style="width:${k.persen}%;background:linear-gradient(90deg,#1a2f9b,#3355ff);transition:width 0.5s ease"></div>
      </div>
    </div>`).join('');

  /* ── Syarat ── */
  document.getElementById('modalSyarat').innerHTML = f.syarat.map((s, i) => `
    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
      <div class="flex items-start gap-3">
        <div class="w-6 h-6 rounded-full bg-navy-100 flex items-center justify-center flex-shrink-0 mt-0.5">
          <span class="text-navy-700 text-xs font-bold">${i+1}</span>
        </div>
        <div>
          <p class="text-navy-900 font-semibold text-sm mb-0.5">${s.title}</p>
          <p class="text-slate-500 text-sm leading-relaxed">${s.isi}</p>
        </div>
      </div>
    </div>`).join('');

  /* ── Kontak ── */
  const icoSVG = {
    phone: '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.11 12 19.79 19.79 0 0 1 1.09 3.38a2 2 0 0 1 2-2h3a2 2 0 0 1 2 1.72c.12.81.31 1.61.57 2.39a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.78.26 1.58.45 2.39.57A2 2 0 0 1 22 16.92z"/>',
    mail: '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
    person: '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
    clock: '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
  };
  document.getElementById('modalKontak').innerHTML = f.kontak.map(k => `
    <div class="flex items-center gap-3 py-2.5 border-b border-slate-100 last:border-0">
      <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#1a2f9b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${icoSVG[k.icon] || ''}</svg>
      </div>
      <div>
        <div class="text-xs text-slate-400">${k.label}</div>
        <div class="text-sm font-semibold text-navy-900">${k.value}</div>
      </div>
    </div>`).join('');

  /* ── Reset tabs ── */
  switchTab('info');

  /* ── Open ── */
  const modal = document.getElementById('facilityModal');
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('facilityModal').classList.remove('open');
  document.body.style.overflow = '';
}

function handleModalBackdropClick(e) {
  if (e.target === document.getElementById('facilityModal')) closeModal();
}

/* ─── Gallery switcher ─── */
function switchHeroImg(idx) {
  if (!currentModalFacility) return;
  currentHeroIdx = idx;
  document.getElementById('modalHeroImg').src = currentModalFacility.gallery[idx];
  document.querySelectorAll('#modalGallery .thumb').forEach((t, i) => {
    t.classList.toggle('selected', i === idx);
  });
}

/* ─── Tabs ─── */
function switchTab(name) {
  document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
  const idx = ['info','fasilitas','syarat','kontak'].indexOf(name);
  document.querySelectorAll('.tab-btn')[idx].classList.add('active');
  document.getElementById('tab-' + name).classList.add('active');
}

/* ─── Keyboard close ─── */
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeModal();
});

/* ─── INIT ─── */
buildCarousel();
</script>
</body>
</html>
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
            <div class="flex items-start gap-4">
              <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg></div>
              <div><h4 class="font-semibold text-navy-900 text-sm">Alamat</h4><p class="text-slate-500 text-sm">Jl. Prof. Dr. H. Aloei Saboe, Kel. Wongkaditi Timur, Kec. Kota Utara, Kota Gorontalo, Gorontalo 96128</p></div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
              <div><h4 class="font-semibold text-navy-900 text-sm">Telepon</h4><p class="text-slate-500 text-sm">(0435) 821-555</p></div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div>
              <div><h4 class="font-semibold text-navy-900 text-sm">Email</h4><p class="text-slate-500 text-sm">bpmp.gorontalo@kemdikbud.go.id</p></div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
              <div><h4 class="font-semibold text-navy-900 text-sm">Jam Operasional</h4><p class="text-slate-500 text-sm">Senin - Jumat: 08.00 - 16.00 WITA</p></div>
            </div>
          </div>
        </div>
        <div class="bg-slate-100 rounded-2xl overflow-hidden" style="height:350px;">
          <div class="w-full h-full bg-gradient-to-br from-navy-100 to-blue-100 flex items-center justify-center relative">
            <div class="text-center">
              <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-navy-600"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>
              </div>
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
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#3355ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#3355ff"/></svg>
            </div>
            <div><span class="font-bold text-lg">SIBMN</span><span class="text-blue-300 text-xs block">BPMP Gorontalo</span></div>
          </div>
          <p class="text-blue-200/70 text-sm leading-relaxed max-w-md">Sistem Informasi Barang Milik Negara Badan Penjaminan Mutu Pendidikan Provinsi Gorontalo. Mendukung tata kelola aset yang transparan dan akuntabel.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4 text-sm">Menu</h4>
          <div class="space-y-2">
            <a href="#hero" class="block text-blue-200/70 text-sm hover:text-white transition">Beranda</a>
            <a href="#fitur" class="block text-blue-200/70 text-sm hover:text-white transition">Fitur</a>
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

</div><!-- END page-landing -->


<!-- =============================================
     PAGE: LOGIN
     ============================================= -->
<div id="page-login" class="page">
  <div class="min-h-screen auth-bg relative overflow-hidden flex flex-col">

    <!-- Decorative blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
      <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-3xl translate-x-1/4 translate-y-1/4"></div>
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] bg-blue-800/5 rounded-full blur-3xl"></div>
      <!-- Grid pattern -->
      <svg class="absolute inset-0 w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
        <defs><pattern id="grid-login" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
        <rect width="100%" height="100%" fill="url(#grid-login)"/>
      </svg>
    </div>

    <!-- Top bar -->
    <div class="relative z-10 px-6 py-5 flex items-center justify-between max-w-7xl mx-auto w-full">
      <button onclick="goToPage('landing')" class="flex items-center gap-2 text-blue-200 hover:text-white transition text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Kembali ke Beranda
      </button>
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/></svg>
        </div>
        <span class="text-white font-bold text-sm">SIBMN</span>
      </div>
    </div>

    <!-- Main content -->
    <div class="relative z-10 flex-1 flex items-center justify-center px-4 py-8">
      <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

        <!-- Left: Illustration + text -->
        <div class="hidden lg:flex flex-col flex-1 text-white">
          <div class="mb-8 anim-fade-up delay-1">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 mb-5">
              <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
              <span class="text-blue-200 text-xs font-medium">Sistem Aktif 24/7</span>
            </div>
            <h2 class="text-4xl font-extrabold leading-tight mb-4">Selamat Datang<br><span class="bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent">Kembali!</span></h2>
            <p class="text-blue-200/80 text-base leading-relaxed max-w-sm">Masuk ke sistem untuk mengelola dan memantau Barang Milik Negara BPMP Provinsi Gorontalo.</p>
          </div>

          <!-- Stats mini cards -->
          <div class="grid grid-cols-2 gap-3 anim-fade-up delay-2">
            <div class="glass rounded-xl p-4">
              <div class="text-2xl font-extrabold text-white mb-0.5">1,247</div>
              <div class="text-blue-300 text-xs">Item BMN Tercatat</div>
            </div>
            <div class="glass rounded-xl p-4">
              <div class="text-2xl font-extrabold text-white mb-0.5">98.5%</div>
              <div class="text-blue-300 text-xs">Kondisi Baik</div>
            </div>
            <div class="glass rounded-xl p-4">
              <div class="text-2xl font-extrabold text-white mb-0.5">89</div>
              <div class="text-blue-300 text-xs">Pengguna Aktif</div>
            </div>
            <div class="glass rounded-xl p-4">
              <div class="text-2xl font-extrabold text-white mb-0.5">6</div>
              <div class="text-blue-300 text-xs">Peran Tersedia</div>
            </div>
          </div>

          <!-- Floating dashboard preview -->
          <div class="mt-8 anim-fade-up delay-3 float-anim">
            <div class="bg-white/10 backdrop-blur rounded-2xl border border-white/20 p-4 max-w-xs">
              <div class="flex items-center gap-2 mb-3">
                <div class="w-2.5 h-2.5 rounded-full bg-red-400"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                <div class="w-2.5 h-2.5 rounded-full bg-green-400"></div>
                <span class="text-white/40 text-xs ml-1">Dashboard BMN</span>
              </div>
              <div class="space-y-2">
                <div class="flex justify-between items-center bg-white/10 rounded-lg px-3 py-2">
                  <span class="text-blue-200 text-xs">Aset Tetap</span>
                  <span class="text-white text-xs font-bold">856 item</span>
                </div>
                <div class="flex justify-between items-center bg-white/10 rounded-lg px-3 py-2">
                  <span class="text-green-300 text-xs">Persediaan</span>
                  <span class="text-white text-xs font-bold">391 item</span>
                </div>
                <div class="flex justify-between items-center bg-white/10 rounded-lg px-3 py-2">
                  <span class="text-yellow-300 text-xs">Sarpras</span>
                  <span class="text-white text-xs font-bold">127 unit</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Login form card -->
        <div class="w-full max-w-md anim-slide-in delay-2">
          <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">

            <!-- Header -->
            <div class="text-center mb-8">
              <div class="w-16 h-16 bg-gradient-to-br from-navy-600 to-navy-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
              </div>
              <h2 class="text-2xl font-extrabold text-navy-900 mb-1">Masuk ke SIBMN</h2>
              <p class="text-slate-400 text-sm">Masukkan kredensial akun Anda</p>
            </div>

            <!-- Form -->
            <form onsubmit="handleLogin(event)" novalidate>
              <!-- Username -->
              <div class="mb-5">
                <label for="loginUsername" class="block text-sm font-semibold text-navy-800 mb-2">Username</label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  </span>
                  <input id="loginUsername" type="text" autocomplete="username"
                    class="auth-input w-full pl-10 pr-4 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 placeholder:text-slate-400"
                    placeholder="Masukkan username Anda">
                </div>
              </div>

              <!-- Password -->
              <div class="mb-5">
                <div class="flex justify-between items-center mb-2">
                  <label for="loginPassword" class="text-sm font-semibold text-navy-800">Password</label>
                  <button type="button" class="text-xs text-navy-500 hover:text-navy-700 font-medium transition">Lupa password?</button>
                </div>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <input id="loginPassword" type="password" autocomplete="current-password"
                    class="auth-input w-full pl-10 pr-12 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 placeholder:text-slate-400"
                    placeholder="Masukkan password Anda">
                  <button type="button" onclick="togglePass('loginPassword','eyeLogin')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-navy-600 transition">
                    <svg id="eyeLogin" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
              </div>

              <!-- Remember me -->
              <div class="flex items-center gap-2 mb-6">
                <input type="checkbox" id="rememberMe" class="custom-check">
                <label for="rememberMe" class="text-sm text-slate-600 cursor-pointer select-none">Ingat saya selama 30 hari</label>
              </div>

              <!-- Error alert -->
              <div id="loginError" class="hidden mb-5 flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
                <span id="loginErrorText">Username atau password salah.</span>
              </div>

              <!-- Submit -->
              <button type="submit" id="loginBtn" class="w-full btn-primary text-white font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg>
                Masuk Sekarang
              </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-6">
              <div class="flex-1 h-px bg-slate-200"></div>
              <span class="text-slate-400 text-xs font-medium">atau coba akun demo</span>
              <div class="flex-1 h-px bg-slate-200"></div>
            </div>

            <!-- Quick login buttons -->
            <div class="grid grid-cols-2 gap-2 mb-6">
              <button onclick="quickFill('superadmin','super123')" class="text-xs font-semibold text-navy-700 bg-navy-50 hover:bg-navy-100 border border-navy-200/60 rounded-lg py-2 px-3 transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-red-500"></span> Super Admin
              </button>
              <button onclick="quickFill('kepalabpmp','kepala123')" class="text-xs font-semibold text-navy-700 bg-navy-50 hover:bg-navy-100 border border-navy-200/60 rounded-lg py-2 px-3 transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span> Kepala BPMP
              </button>
              <button onclick="quickFill('kasubag','kasubag123')" class="text-xs font-semibold text-navy-700 bg-navy-50 hover:bg-navy-100 border border-navy-200/60 rounded-lg py-2 px-3 transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Kasubag TU
              </button>
              <button onclick="quickFill('adminpersediaan','persediaan123')" class="text-xs font-semibold text-navy-700 bg-navy-50 hover:bg-navy-100 border border-navy-200/60 rounded-lg py-2 px-3 transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Admin Persediaan
              </button>
              <button onclick="quickFill('adminsarpras','sarpras123')" class="text-xs font-semibold text-navy-700 bg-navy-50 hover:bg-navy-100 border border-navy-200/60 rounded-lg py-2 px-3 transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-cyan-500"></span> Admin Sarpras
              </button>
              <button onclick="quickFill('pegawai','pegawai123')" class="text-xs font-semibold text-navy-700 bg-navy-50 hover:bg-navy-100 border border-navy-200/60 rounded-lg py-2 px-3 transition flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-slate-500"></span> Pegawai
              </button>
            </div>

            <!-- Register link -->
            <p class="text-center text-sm text-slate-500">
              Belum punya akun?
              <button onclick="goToPage('register')" class="text-navy-600 font-semibold hover:underline ml-1">Daftar Sekarang</button>
            </p>
          </div>
        </div>

      </div>
    </div>

    <!-- Bottom note -->
    <div class="relative z-10 text-center pb-6 px-4">
      <p class="text-blue-200/40 text-xs">© 2025 SIBMN BPMP Provinsi Gorontalo · Sistem terintegrasi pengelolaan BMN</p>
    </div>
  </div>
</div><!-- END page-login -->

<!-- =============================================
     PAGE: REGISTER
     ============================================= -->
<div id="page-register" class="page">
  <div class="min-h-screen auth-bg relative overflow-hidden flex flex-col">

    <!-- Decorative blobs -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3"></div>
      <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-700/10 rounded-full blur-3xl -translate-x-1/4 translate-y-1/4"></div>
      <svg class="absolute inset-0 w-full h-full opacity-[0.03]" xmlns="http://www.w3.org/2000/svg">
        <defs><pattern id="grid-reg" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs>
        <rect width="100%" height="100%" fill="url(#grid-reg)"/>
      </svg>
    </div>

    <!-- Top bar -->
    <div class="relative z-10 px-6 py-5 flex items-center justify-between max-w-7xl mx-auto w-full">
      <button onclick="goToPage('landing')" class="flex items-center gap-2 text-blue-200 hover:text-white transition text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        Kembali ke Beranda
      </button>
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-lg bg-white/15 flex items-center justify-center">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/></svg>
        </div>
        <span class="text-white font-bold text-sm">SIBMN</span>
      </div>
    </div>

    <!-- Main content -->
    <div class="relative z-10 flex-1 flex items-center justify-center px-4 py-8">
      <div class="w-full max-w-5xl flex flex-col lg:flex-row-reverse items-center gap-12 lg:gap-20">

        <!-- Right: Info panel -->
        <div class="hidden lg:flex flex-col flex-1 text-white">
          <div class="mb-8 anim-fade-up delay-1">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur rounded-full px-4 py-1.5 mb-5">
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-300"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              <span class="text-blue-200 text-xs font-medium">Pendaftaran Aman &amp; Terverifikasi</span>
            </div>
            <h2 class="text-4xl font-extrabold leading-tight mb-4">Bergabung<br><span class="bg-gradient-to-r from-blue-300 to-cyan-300 bg-clip-text text-transparent">Bersama Kami</span></h2>
            <p class="text-blue-200/80 text-base leading-relaxed max-w-sm">Daftarkan akun Anda untuk mengakses sistem pengelolaan Barang Milik Negara BPMP Provinsi Gorontalo.</p>
          </div>

          <!-- Steps -->
          <div class="space-y-4 anim-fade-up delay-2">
            <div class="flex items-start gap-4">
              <div class="w-9 h-9 rounded-xl bg-blue-500/30 border border-blue-400/40 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">1</div>
              <div><p class="text-white font-semibold text-sm">Isi Data Diri</p><p class="text-blue-300 text-xs mt-0.5">Nama lengkap, NIP, dan informasi akun</p></div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-9 h-9 rounded-xl bg-blue-500/30 border border-blue-400/40 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">2</div>
              <div><p class="text-white font-semibold text-sm">Pilih Peran</p><p class="text-blue-300 text-xs mt-0.5">Tentukan role sesuai jabatan Anda</p></div>
            </div>
            <div class="flex items-start gap-4">
              <div class="w-9 h-9 rounded-xl bg-blue-500/30 border border-blue-400/40 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">3</div>
              <div><p class="text-white font-semibold text-sm">Akun Aktif</p><p class="text-blue-300 text-xs mt-0.5">Langsung bisa masuk ke dashboard</p></div>
            </div>
          </div>

          <!-- Roles info -->
          <div class="mt-8 anim-fade-up delay-3">
            <p class="text-blue-300 text-xs font-semibold uppercase tracking-wide mb-3">Peran yang Tersedia</p>
            <div class="flex flex-wrap gap-2">
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Super Admin</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Kepala BPMP</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Kasubag TU</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Admin Persediaan</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Admin Sarpras</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Admin Aset</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Pegawai</span>
              <span class="glass text-blue-200 text-xs font-medium px-3 py-1.5 rounded-full">Tamu</span>
            </div>
          </div>
        </div>

        <!-- Left: Register form card -->
        <div class="w-full max-w-md anim-slide-in delay-2">
          <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">

            <!-- Header -->
            <div class="text-center mb-7">
              <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
              </div>
              <h2 class="text-2xl font-extrabold text-navy-900 mb-1">Buat Akun Baru</h2>
              <p class="text-slate-400 text-sm">Registrasi akun SIBMN (Demo)</p>
            </div>

            <!-- Success alert -->
            <div id="regSuccess" class="hidden mb-5 flex items-center gap-2.5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
              <span>Registrasi berhasil! Mengarahkan ke halaman login...</span>
            </div>

            <!-- Error alert -->
            <div id="regError" class="hidden mb-5 flex items-center gap-2.5 bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 text-sm">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
              <span id="regErrorText">Terjadi kesalahan.</span>
            </div>

            <!-- Form -->
            <form onsubmit="handleRegister(event)" novalidate>
              <!-- Nama Lengkap -->
              <div class="mb-4">
                <label for="regName" class="block text-sm font-semibold text-navy-800 mb-2">Nama Lengkap <span class="text-red-400">*</span></label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                  </span>
                  <input id="regName" type="text" autocomplete="name"
                    class="auth-input w-full pl-9 pr-4 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 placeholder:text-slate-400"
                    placeholder="Nama lengkap Anda">
                </div>
              </div>

              <!-- NIP -->
              <div class="mb-4">
                <label for="regNIP" class="block text-sm font-semibold text-navy-800 mb-2">NIP <span class="text-red-400">*</span></label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"/><line x1="8" x2="16" y1="6" y2="6"/><line x1="8" x2="16" y1="10" y2="10"/><line x1="8" x2="12" y1="14" y2="14"/></svg>
                  </span>
                  <input id="regNIP" type="text"
                    class="auth-input w-full pl-9 pr-4 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 placeholder:text-slate-400"
                    placeholder="Nomor Induk Pegawai">
                </div>
              </div>

              <!-- Username -->
              <div class="mb-4">
                <label for="regUsername" class="block text-sm font-semibold text-navy-800 mb-2">Username <span class="text-red-400">*</span></label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"/></svg>
                  </span>
                  <input id="regUsername" type="text" autocomplete="username"
                    class="auth-input w-full pl-9 pr-4 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 placeholder:text-slate-400"
                    placeholder="Pilih username unik">
                </div>
              </div>

              <!-- Password -->
              <div class="mb-4">
                <label for="regPassword" class="block text-sm font-semibold text-navy-800 mb-2">Password <span class="text-red-400">*</span></label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                  </span>
                  <input id="regPassword" type="password" autocomplete="new-password" oninput="checkPasswordStrength(this.value)"
                    class="auth-input w-full pl-9 pr-12 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 placeholder:text-slate-400"
                    placeholder="Minimal 6 karakter">
                  <button type="button" onclick="togglePass('regPassword','eyeReg')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-navy-600 transition">
                    <svg id="eyeReg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                </div>
                <!-- Password strength -->
                <div class="mt-2 flex gap-1" id="strengthBars">
                  <div class="strength-bar flex-1 bg-slate-200"></div>
                  <div class="strength-bar flex-1 bg-slate-200"></div>
                  <div class="strength-bar flex-1 bg-slate-200"></div>
                  <div class="strength-bar flex-1 bg-slate-200"></div>
                </div>
                <p id="strengthText" class="text-xs text-slate-400 mt-1">Masukkan password untuk melihat kekuatan</p>
              </div>

              <!-- Role -->
              <div class="mb-6">
                <label for="regRole" class="block text-sm font-semibold text-navy-800 mb-2">Peran / Role <span class="text-red-400">*</span></label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                  </span>
                  <select id="regRole"
                    class="auth-input w-full pl-9 pr-4 py-3 border border-slate-200 rounded-xl text-sm text-navy-900 bg-slate-50 appearance-none cursor-pointer">
                    <option value="pegawai">Pegawai</option>
                    <option value="admin_persediaan">Admin Persediaan</option>
                    <option value="admin_sarpras">Admin Sarana Prasarana</option>
                    <option value="admin_aset">Admin Aset Tetap</option>
                    <option value="kasubag">Kasubag TU</option>
                    <option value="kepala_bpmp">Kepala BPMP</option>
                    <option value="superadmin">Super Admin</option>
                    <option value="tamu">Tamu</option>
                  </select>
                  <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                  </span>
                </div>
              </div>

              <!-- Submit -->
              <button type="submit" id="regBtn" class="w-full btn-primary text-white font-bold py-3.5 rounded-xl text-sm flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                Daftar Sekarang
              </button>
            </form>

            <!-- Login link -->
            <p class="text-center text-sm text-slate-500 mt-5">
              Sudah punya akun?
              <button onclick="goToPage('login')" class="text-navy-600 font-semibold hover:underline ml-1">Masuk di sini</button>
            </p>
          </div>
        </div>

      </div>
    </div>

    <!-- Bottom note -->
    <div class="relative z-10 text-center pb-6 px-4">
      <p class="text-blue-200/40 text-xs">© 2025 SIBMN BPMP Provinsi Gorontalo · Sistem terintegrasi pengelolaan BMN</p>
    </div>
  </div>
</div><!-- END page-register -->

<!-- =============================================
     TOAST CONTAINER
     ============================================= -->
<div id="toastContainer" class="fixed top-4 right-4 z-[200] space-y-2 pointer-events-none"></div>


<!-- =============================================
     JAVASCRIPT
     ============================================= -->
<script>
// ── DATA ──
const FACILITIES = [
  { name:'Aula Utama BPMP', price:'Rp 2.500.000/hari', priceOld:'Rp 3.000.000', category:'ruang', image:'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=640&q=80', availability:'Beberapa jadwal tersedia', location:'Wongkaditi Timur, Kota Gorontalo', rating:4.6, reviews:18 },
  { name:'Ruang Rapat VIP', price:'Rp 1.000.000/hari', priceOld:'Rp 1.250.000', category:'ruang', image:'https://images.unsplash.com/photo-1497366216548-37526070297c?w=640&q=80', availability:'2 slot minggu ini', location:'Kota Utara, Gorontalo', rating:4.8, reviews:24 },
  { name:'Lab Komputer', price:'Rp 1.500.000/hari', priceOld:null, category:'lab', image:'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=640&q=80', availability:'Tersedia', location:'Kompleks BPMP Gorontalo', rating:4.5, reviews:31 },
  { name:'Ruang Pelatihan A', price:'Rp 800.000/hari', priceOld:'Rp 950.000', category:'ruang', image:'https://images.unsplash.com/photo-1580582932707-520aed937d7b?w=640&q=80', availability:'Kapasitas terbatas', location:'Gedung Utama BPMP', rating:4.4, reviews:12 },
  { name:'Kendaraan Dinas - Minibus', price:'Rp 750.000/hari', priceOld:null, category:'kendaraan', image:'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=640&q=80', availability:'1 unit tersedia', location:'Pool Kendaraan BPMP', rating:4.7, reviews:9 },
  { name:'Gedung Serbaguna', price:'Rp 3.000.000/hari', priceOld:'Rp 3.500.000', category:'outdoor', image:'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=640&q=80', availability:'Booking awal bulan', location:'Halaman BPMP Gorontalo', rating:4.5, reviews:7 },
];
const FACILITY_CHIPS = [
  { id:'semua', label:'Semua' },
  { id:'ruang', label:'Ruang & Aula' },
  { id:'lab', label:'Lab' },
  { id:'kendaraan', label:'Kendaraan' },
  { id:'outdoor', label:'Outdoor' },
];
const DEMO_ACCOUNTS = [
  { username:'superadmin', password:'super123', label:'Super Admin', color:'from-red-500 to-rose-600', icon:'shield', desc:'Akses penuh ke seluruh sistem' },
  { username:'kepalabpmp', password:'kepala123', label:'Kepala BPMP', color:'from-purple-500 to-indigo-600', icon:'crown', desc:'Dashboard eksekutif & persetujuan' },
  { username:'kasubag', password:'kasubag123', label:'Kasubag TU', color:'from-indigo-500 to-blue-600', icon:'briefcase', desc:'Verifikasi & koordinasi BMN' },
  { username:'adminpersediaan', password:'persediaan123', label:'Admin Persediaan', color:'from-emerald-500 to-green-600', icon:'package', desc:'Kelola stok & barang habis pakai' },
  { username:'adminsarpras', password:'sarpras123', label:'Admin Sarana Prasarana', color:'from-cyan-500 to-teal-600', icon:'building', desc:'Monitor gedung & fasilitas' },
  { username:'adminaset', password:'aset123', label:'Admin Aset Tetap', color:'from-amber-500 to-yellow-600', icon:'landmark', desc:'Inventarisasi aset tetap' },
  { username:'pegawai', password:'pegawai123', label:'Pegawai', color:'from-slate-500 to-gray-600', icon:'user', desc:'Peminjaman & riwayat BMN' },
  { username:'tamu', password:'tamu123', label:'Tamu', color:'from-cyan-400 to-blue-500', icon:'eye', desc:'Melihat info & statistik BMN' },
];

let registeredUsers = [...DEMO_ACCOUNTS];
let facilityFilter = 'semua';
const PROMO_END = new Date('2026-04-30T23:59:59');

// ── PAGE NAVIGATION ──
function goToPage(page) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + page).classList.add('active');
  window.scrollTo(0, 0);
  // Re-init icons on auth pages
  if (page === 'login' || page === 'register') {
    setTimeout(() => lucide.createIcons(), 50);
  }
}

// ── COUNTDOWN ──
function updateCountdown() {
  const el = { h: document.getElementById('cdH'), m: document.getElementById('cdM'), s: document.getElementById('cdS') };
  if (!el.h) return;
  let ms = PROMO_END - Date.now(); if (ms < 0) ms = 0;
  const s = Math.floor(ms / 1000);
  el.h.textContent = String(Math.floor(s / 3600)).padStart(2, '0');
  el.m.textContent = String(Math.floor((s % 3600) / 60)).padStart(2, '0');
  el.s.textContent = String(s % 60).padStart(2, '0');
}
updateCountdown(); setInterval(updateCountdown, 1000);

// ── FACILITIES CAROUSEL ──
function starRow(r) {
  const n = Math.round(r);
  return [0,1,2,3,4].map(i => `<span class="${i<n?'text-amber-400':'text-slate-200'} text-[11px] leading-none">★</span>`).join('');
}
function buildCarousel() {
  const chips = document.getElementById('facilityChips');
  const scroll = document.getElementById('facilitiesCarouselScroll');
  if (!chips || !scroll) return;
  chips.innerHTML = FACILITY_CHIPS.map(c => {
    const a = facilityFilter === c.id;
    return `<button type="button" onclick="setFacilityFilter('${c.id}')" class="px-4 py-2 rounded-full text-sm font-semibold transition border-2 ${a?'border-blue-500 bg-blue-50 text-navy-800 shadow-sm':'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'}">${c.label}</button>`;
  }).join('');
  const list = facilityFilter === 'semua' ? FACILITIES : FACILITIES.filter(f => f.category === facilityFilter);
  if (!list.length) { scroll.innerHTML = '<p class="text-slate-600 text-sm py-8 px-4">Tidak ada fasilitas pada kategori ini.</p>'; return; }
  scroll.innerHTML = list.map(f => {
    const rs = String(f.rating).replace('.', ',');
    const op = f.priceOld ? `<div class="text-slate-400 text-xs line-through mb-0.5">${f.priceOld}<span class="text-slate-300">/hari</span></div>` : '';
    return `<article class="flex-shrink-0 w-[260px] sm:w-[280px] snap-start rounded-2xl bg-white shadow-md border border-slate-100/80 overflow-hidden card-hover flex flex-col">
      <div class="relative aspect-[4/3] bg-slate-100 overflow-hidden"><img src="${f.image}" alt="${f.name}" class="w-full h-full object-cover" loading="lazy" width="320" height="240"></div>
      <div class="p-3.5 flex flex-col flex-1">
        <p class="text-red-600 text-xs font-semibold mb-1.5">${f.availability}</p>
        <h3 class="font-bold text-navy-900 text-sm leading-snug mb-1 line-clamp-2">${f.name}</h3>
        <div class="flex items-center gap-0.5 mb-1">${starRow(f.rating)}</div>
        <p class="text-slate-500 text-xs mb-2">${f.location}</p>
        <div class="flex items-center gap-2 mb-3 mt-auto text-xs">
          <span class="inline-flex items-center justify-center min-w-[1.75rem] h-7 px-1 rounded-md bg-violet-600 text-white font-bold text-[11px] shadow-sm">${rs}</span>
          <span class="text-slate-600"><span class="font-semibold text-navy-800">${rs}/5</span> <span class="text-slate-400">(${f.reviews} ulasan)</span></span>
        </div>
        <div class="border-t border-slate-100 pt-2.5">${op}<div class="text-red-600 font-extrabold text-base leading-tight tracking-tight">${f.price}</div><p class="text-slate-400 text-[11px] mt-1">Belum termasuk pajak &amp; biaya lain</p></div>
      </div>
    </article>`;
  }).join('');
}
function setFacilityFilter(id) { facilityFilter = id; buildCarousel(); }
function facilitiesScrollNext() { const el = document.getElementById('facilitiesCarouselScroll'); if (el) el.scrollBy({ left: Math.min(300, Math.max(260, el.clientWidth * 0.75)), behavior: 'smooth' }); }
function facilitiesScrollPrev() { const el = document.getElementById('facilitiesCarouselScroll'); if (el) el.scrollBy({ left: -Math.min(300, Math.max(260, el.clientWidth * 0.75)), behavior: 'smooth' }); }

// ── DEMO ACCOUNTS ──
function buildDemoAccounts() {
  const grid = document.getElementById('demoAccountsGrid');
  if (!grid) return;
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
      <button onclick="goToPage('login'); setTimeout(()=>quickFill('${a.username}','${a.password}'),100)" class="w-full text-center py-2 text-sm font-semibold text-navy-600 bg-navy-50 hover:bg-navy-100 rounded-lg transition">
        Login Cepat →
      </button>
    </div>`).join('');
  lucide.createIcons();
}

// ── AUTH: LOGIN ──
function quickFill(u, p) {
  const uEl = document.getElementById('loginUsername');
  const pEl = document.getElementById('loginPassword');
  if (uEl && pEl) { uEl.value = u; pEl.value = p; }
}
function handleLogin(e) {
  e.preventDefault();
  const u = document.getElementById('loginUsername').value.trim();
  const p = document.getElementById('loginPassword').value.trim();
  const errEl = document.getElementById('loginError');
  const errText = document.getElementById('loginErrorText');
  errEl.classList.add('hidden');
  if (!u || !p) {
    errText.textContent = 'Username dan password wajib diisi.';
    errEl.classList.remove('hidden');
    return;
  }
  const found = registeredUsers.find(a => a.username === u && a.password === p);
  if (found) {
    const btn = document.getElementById('loginBtn');
    btn.innerHTML = '<svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Memuat...';
    btn.disabled = true;
    showToast('Login berhasil! Selamat datang, ' + found.label, 'success');
    setTimeout(() => {
      btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/></svg> Masuk Sekarang';
      btn.disabled = false;
      // In a real app, redirect to dashboard. Here we go back to landing as placeholder.
      goToPage('landing');
    }, 1500);
  } else {
    errText.textContent = 'Username atau password tidak sesuai. Coba akun demo di bawah.';
    errEl.classList.remove('hidden');
    document.getElementById('loginUsername').classList.add('border-red-300');
    document.getElementById('loginPassword').classList.add('border-red-300');
    setTimeout(() => {
      document.getElementById('loginUsername').classList.remove('border-red-300');
      document.getElementById('loginPassword').classList.remove('border-red-300');
    }, 2000);
  }
}

// ── AUTH: REGISTER ──
function handleRegister(e) {
  e.preventDefault();
  const name = document.getElementById('regName').value.trim();
  const nip = document.getElementById('regNIP').value.trim();
  const user = document.getElementById('regUsername').value.trim();
  const pass = document.getElementById('regPassword').value.trim();
  const role = document.getElementById('regRole').value;
  const errEl = document.getElementById('regError');
  const errText = document.getElementById('regErrorText');
  const sucEl = document.getElementById('regSuccess');
  errEl.classList.add('hidden');
  sucEl.classList.add('hidden');

  if (!name || !nip || !user || !pass) {
    errText.textContent = 'Semua field wajib diisi.';
    errEl.classList.remove('hidden'); return;
  }
  if (pass.length < 6) {
    errText.textContent = 'Password minimal 6 karakter.';
    errEl.classList.remove('hidden'); return;
  }
  if (registeredUsers.find(a => a.username === user)) {
    errText.textContent = 'Username sudah digunakan, coba yang lain.';
    errEl.classList.remove('hidden'); return;
  }
  const roleMap = { pegawai:'Pegawai', admin_persediaan:'Admin Persediaan', admin_sarpras:'Admin Sarana Prasarana', admin_aset:'Admin Aset Tetap', kasubag:'Kasubag TU', kepala_bpmp:'Kepala BPMP', superadmin:'Super Admin', tamu:'Tamu' };
  registeredUsers.push({ username: user, password: pass, label: roleMap[role] || role, color:'from-navy-600 to-navy-400', icon:'user', desc: roleMap[role] });
  sucEl.classList.remove('hidden');
  const btn = document.getElementById('regBtn');
  btn.disabled = true;
  showToast('Registrasi berhasil! Silakan login.', 'success');
  setTimeout(() => {
    sucEl.classList.add('hidden');
    btn.disabled = false;
    document.getElementById('regName').value = '';
    document.getElementById('regNIP').value = '';
    document.getElementById('regUsername').value = '';
    document.getElementById('regPassword').value = '';
    document.getElementById('regRole').value = 'pegawai';
    resetStrength();
    quickFill(user, pass);
    goToPage('login');
  }, 1800);
}

// ── PASSWORD TOGGLE ──
function togglePass(inputId, iconId) {
  const input = document.getElementById(inputId);
  const isText = input.type === 'text';
  input.type = isText ? 'password' : 'text';
  const icon = document.getElementById(iconId);
  icon.innerHTML = isText
    ? '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>'
    : '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>';
}

// ── PASSWORD STRENGTH ──
function checkPasswordStrength(val) {
  const bars = document.querySelectorAll('#strengthBars .strength-bar');
  const text = document.getElementById('strengthText');
  if (!val) { resetStrength(); return; }
  let score = 0;
  if (val.length >= 6) score++;
  if (val.length >= 10) score++;
  if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
  const labels = ['Sangat Lemah', 'Lemah', 'Cukup Kuat', 'Kuat'];
  const textColors = ['text-red-500', 'text-orange-500', 'text-yellow-600', 'text-green-600'];
  bars.forEach((b, i) => {
    b.className = 'strength-bar flex-1 ' + (i < score ? colors[score - 1] : 'bg-slate-200');
  });
  text.className = 'text-xs mt-1 ' + textColors[score - 1];
  text.textContent = labels[score - 1] || 'Masukkan password';
}
function resetStrength() {
  document.querySelectorAll('#strengthBars .strength-bar').forEach(b => b.className = 'strength-bar flex-1 bg-slate-200');
  const t = document.getElementById('strengthText');
  t.className = 'text-xs text-slate-400 mt-1';
  t.textContent = 'Masukkan password untuk melihat kekuatan';
}

// ── TOAST ──
function showToast(msg, type = 'info') {
  const container = document.getElementById('toastContainer');
  const colors = { success:'bg-green-500', error:'bg-red-500', info:'bg-navy-600', warning:'bg-amber-500' };
  const icons = { success:'check-circle', error:'x-circle', info:'info', warning:'alert-triangle' };
  const toast = document.createElement('div');
  toast.className = `pointer-events-auto flex items-center gap-3 ${colors[type]} text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium max-w-sm`;
  toast.style.animation = 'fadeUp 0.4s ease forwards';
  toast.innerHTML = `<i data-lucide="${icons[type]}" class="w-5 h-5 flex-shrink-0"></i><span>${msg}</span>`;
  container.appendChild(toast);
  lucide.createIcons();
  setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity 0.3s'; setTimeout(() => toast.remove(), 300); }, 3500);
}

// ── INIT ──
buildCarousel();
buildDemoAccounts();
lucide.createIcons();
</script>
</body>
</html>