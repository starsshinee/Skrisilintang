<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Tamu – SIBMN</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <script>tailwind.config={theme:{extend:{fontFamily:{jakarta:['Plus Jakarta Sans','sans-serif']},colors:{navy:{50:'#eef3ff',600:'#1a2f9b',700:'#0f1f6e',800:'#0a1550',900:'#060d33'}}}}}</script>
  <style>body{font-family:'Plus Jakarta Sans',sans-serif;background:#f1f5f9;}.sidebar{background:linear-gradient(180deg,#060d33,#0f1f6e);}.card{background:white;border-radius:1rem;box-shadow:0 1px 3px rgba(0,0,0,.08);}.badge-role{background:linear-gradient(135deg,#6b7280,#9ca3af);}@keyframes fadeSlide{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeSlide .5s ease forwards;}</style>
</head>
<body class="h-full">
<div class="flex h-full min-h-screen">
  <aside class="sidebar w-64 flex-shrink-0 flex flex-col p-5 gap-3">
    <div class="flex items-center gap-3 mb-6 px-2">
      <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1.5" fill="#5a82ff"/><rect x="14" y="3" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="3" y="14" width="7" height="7" rx="1.5" fill="#8eaeff"/><rect x="14" y="14" width="7" height="7" rx="1.5" fill="#5a82ff"/></svg></div>
      <div><p class="text-white font-extrabold text-sm leading-none">SIBMN</p><p class="text-blue-300 text-xs mt-0.5">BPMP Gorontalo</p></div>
    </div>
    <nav class="flex-1 space-y-1">
      <a href="{{ route('tamu.dashboard') }}" class="flex items-center gap-3 text-white bg-white/15 rounded-xl px-3 py-2.5 text-sm font-semibold"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>Dashboard</a>
      <a href="#" class="flex items-center gap-3 text-blue-200 hover:text-white hover:bg-white/10 rounded-xl px-3 py-2.5 text-sm font-medium transition"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Lihat Data BMN</a>
    </nav>
    <form method="POST" action="{{ route('logout') }}">@csrf
      <button type="submit" class="w-full flex items-center gap-3 text-blue-200 hover:text-red-300 hover:bg-red-500/10 rounded-xl px-3 py-2.5 text-sm font-medium transition"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>Keluar</button>
    </form>
  </aside>
  <main class="flex-1 overflow-auto p-8">
    <div class="flex items-center justify-between mb-8 anim">
      <div><h1 class="text-2xl font-extrabold text-navy-900">Dashboard Tamu</h1><p class="text-slate-500 text-sm mt-1">Selamat datang, <span class="font-semibold text-navy-700">{{ auth()->user()->name }}</span></p></div>
      <div class="flex items-center gap-3">
        <span class="badge-role text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ auth()->user()->role_label }}</span>
        <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      </div>
    </div>
    <div class="card p-8 anim text-center">
      <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
        <svg width="32" height="32" fill="none" stroke="#64748b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
      </div>
      <h2 class="text-xl font-bold text-navy-800 mb-2">Akses Tamu</h2>
      <p class="text-slate-500 text-sm max-w-sm mx-auto">Anda masuk sebagai <strong>Tamu</strong>. Anda hanya dapat melihat informasi publik sistem SIBMN BPMP Gorontalo.</p>
    </div>
    <div class="card p-6 anim mt-5">
      <h2 class="text-lg font-bold text-navy-800 mb-4">Informasi Akun</h2>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div><p class="text-slate-400 text-xs mb-1">Nama</p><p class="font-semibold text-navy-800">{{ auth()->user()->name }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Username</p><p class="font-semibold text-navy-800">{{ auth()->user()->username }}</p></div>
        <div><p class="text-slate-400 text-xs mb-1">Status</p><span class="inline-block bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">Tamu</span></div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
