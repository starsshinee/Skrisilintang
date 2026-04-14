<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Super Admin – SIBMN</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
          colors: {
            navy: { 50:'#eef3ff',100:'#d9e4ff',200:'#bccfff',300:'#8eaeff',400:'#5a82ff',500:'#3355ff',600:'#1a2f9b',700:'#0f1f6e',800:'#0a1550',900:'#060d33' },
          }
        }
      }
    }
  </script>
  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f1f5f9; }
    .sidebar { background: linear-gradient(180deg, #060d33 0%, #0f1f6e 100%); }
    .card { background: white; border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
    .badge-role { background: linear-gradient(135deg,#1a2f9b,#3355ff); }
    @keyframes fadeSlide { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
    .anim { animation: fadeSlide .5s ease forwards; }
  </style>
</head>
<body class="h-full">
<div class="flex h-full min-h-screen">

  {{-- ── SIDEBAR ── --}}
  <aside class="sidebar w-64 flex-shrink-0 flex flex-col p-5 gap-3">
    {{-- Brand --}}
    <div class="flex items-center gap-3 mb-6 px-2">
      <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/></svg>
      </div>
      <div>
        <p class="text-white font-extrabold text-sm leading-none">SIBMN</p>
        <p class="text-blue-300 text-xs mt-0.5">BPMP Gorontalo</p>
      </div>
    </div>
    {{-- Nav --}}
    <nav class="flex-1 space-y-1">
      <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 text-white bg-white/15 rounded-xl px-3 py-2.5 text-sm font-semibold">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Manajemen User
      </a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
        Data BMN
      </a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Laporan
      </a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
        Pengaturan Sistem
      </a>
    </nav>
    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="w-full flex items-center gap-3 text-blue-200 hover:text-red-300 hover:bg-red-500/10 rounded-xl px-3 py-2.5 text-sm font-medium transition">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
        Keluar
      </button>
    </form>
  </aside>

  {{-- ── MAIN CONTENT ── --}}
  <main class="flex-1 overflow-auto p-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8 anim">
      <div>
        <h1 class="text-2xl font-extrabold text-navy-900">Dashboard Super Admin</h1>
        <p class="text-slate-500 text-sm mt-1">Selamat datang, <span class="font-semibold text-navy-700">{{ auth()->user()->name }}</span></p>
      </div>
      <div class="flex items-center gap-3">
        <span class="badge-role text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ auth()->user()->role_label }}</span>
        <div class="w-10 h-10 rounded-full bg-navy-600 flex items-center justify-center text-white font-bold text-sm">
          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
      </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
      @foreach([
        ['label'=>'Total Pengguna',   'value'=>'89',    'color'=>'bg-blue-100 text-blue-600',   'icon'=>'users'],
        ['label'=>'Total Aset BMN',   'value'=>'1.247', 'color'=>'bg-emerald-100 text-emerald-600','icon'=>'package'],
        ['label'=>'Kondisi Baik',     'value'=>'98.5%', 'color'=>'bg-green-100 text-green-600',  'icon'=>'check'],
        ['label'=>'Peran Aktif',      'value'=>'8',     'color'=>'bg-purple-100 text-purple-600', 'icon'=>'shield'],
      ] as $stat)
      <div class="card p-5 anim flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl {{ $stat['color'] }} flex items-center justify-center text-xl font-bold flex-shrink-0">
          {{ strtoupper(substr($stat['label'],0,1)) }}
        </div>
        <div>
          <p class="text-2xl font-extrabold text-navy-900">{{ $stat['value'] }}</p>
          <p class="text-slate-500 text-xs">{{ $stat['label'] }}</p>
        </div>
      </div>
      @endforeach
    </div>

    {{-- Info Card --}}
    <div class="card p-6 anim">
      <h2 class="text-lg font-bold text-navy-800 mb-4">Informasi Akun</h2>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div><p class="text-slate-400 text-xs mb-1">Nama</p><p class="font-semibold text-navy-800">{{ auth()->user()->name }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Username</p><p class="font-semibold text-navy-800">{{ auth()->user()->username }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">NIP</p><p class="font-semibold text-navy-800">{{ auth()->user()->nip ?? '-' }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Jabatan</p><p class="font-semibold text-navy-800">{{ auth()->user()->jabatan ?? '-' }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Peran</p><p class="font-semibold text-navy-800">{{ auth()->user()->role_label }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Status</p><span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">Aktif</span></div>
      </div>
    </div>

  </main>
</div>
</body>
</html>
