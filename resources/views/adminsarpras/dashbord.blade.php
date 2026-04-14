<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin Sarpras – SIBMN</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <script>tailwind.config={theme:{extend:{fontFamily:{jakarta:['Plus Jakarta Sans','sans-serif']},colors:{navy:{50:'#eef3ff',600:'#1a2f9b',700:'#0f1f6e',800:'#0a1550',900:'#060d33'}}}}}</script>
  <style>body{font-family:'Plus Jakarta Sans',sans-serif;background:#f1f5f9;}.sidebar{background:linear-gradient(180deg,#060d33,#0f1f6e);}.card{background:white;border-radius:1rem;box-shadow:0 1px 3px rgba(0,0,0,.08);}.badge-role{background:linear-gradient(135deg,#0891b2,#06b6d4);}@keyframes fadeSlide{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeSlide .5s ease forwards;}</style>
</head>
<body class="h-full">
<div class="flex h-full min-h-screen">
  <aside class="sidebar w-64 flex-shrink-0 flex flex-col p-5 gap-3">
    <div class="flex items-center gap-3 mb-6 px-2">
      <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/></svg></div>
      <div><p class="text-white font-extrabold text-sm leading-none">SIBMN</p><p class="text-blue-300 text-xs mt-0.5">BPMP Gorontalo</p></div>
    </div>
    <nav class="flex-1 space-y-1">
      <a href="{{ route('adminsarpras.dashboard') }}" class="flex items-center gap-3 text-white bg-white/15 rounded-xl px-3 py-2.5 text-sm font-semibold"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>Data Sarpras</a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18M3 15h18M9 3v18M15 3v18"/></svg>Peminjaman Kendaraan</a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Laporan Sarpras</a>
    </nav>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="w-full flex items-center gap-3 text-blue-200 hover:text-red-300 hover:bg-red-500/10 rounded-xl px-3 py-2.5 text-sm font-medium transition"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>Keluar</button>
    </form>
  </aside>
  <main class="flex-1 overflow-auto p-8">
    <div class="flex items-center justify-between mb-8 anim">
      <div><h1 class="text-2xl font-extrabold text-navy-900">Dashboard Admin Sarpras</h1><p class="text-slate-500 text-sm mt-1">Selamat datang, <span class="font-semibold text-navy-700">{{ auth()->user()->name }}</span></p></div>
      <div class="flex items-center gap-3">
        <span class="badge-role text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ auth()->user()->role_label }}</span>
        <div class="w-10 h-10 rounded-full bg-cyan-600 flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
      @foreach([['label'=>'Total Sarpras','value'=>'127','color'=>'bg-cyan-100 text-cyan-600'],['label'=>'Dipinjam','value'=>'14','color'=>'bg-amber-100 text-amber-600'],['label'=>'Tersedia','value'=>'113','color'=>'bg-green-100 text-green-600']] as $s)
      <div class="card p-5 anim flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl {{ $s['color'] }} flex items-center justify-center font-extrabold text-lg">{{ strtoupper(substr($s['label'],0,1)) }}</div>
        <div><p class="text-2xl font-extrabold text-navy-900">{{ $s['value'] }}</p><p class="text-slate-500 text-xs">{{ $s['label'] }}</p></div>
      </div>
      @endforeach
    </div>
    <div class="card p-6 anim">
      <h2 class="text-lg font-bold text-navy-800 mb-4">Informasi Akun</h2>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div><p class="text-slate-400 text-xs mb-1">Nama</p><p class="font-semibold text-navy-800">{{ auth()->user()->name }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Username</p><p class="font-semibold text-navy-800">{{ auth()->user()->username }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">NIP</p><p class="font-semibold text-navy-800">{{ auth()->user()->nip ?? '-' }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Jabatan</p><p class="font-semibold text-navy-800">{{ auth()->user()->jabatan ?? '-' }}</p></div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
