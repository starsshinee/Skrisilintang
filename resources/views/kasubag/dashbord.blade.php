<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Kasubag TU – SIBMN</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <script>tailwind.config={theme:{extend:{fontFamily:{jakarta:['Plus Jakarta Sans','sans-serif']},colors:{navy:{50:'#eef3ff',600:'#1a2f9b',700:'#0f1f6e',800:'#0a1550',900:'#060d33'}}}}}</script>
  <style>body{font-family:'Plus Jakarta Sans',sans-serif;background:#f1f5f9;}.sidebar{background:linear-gradient(180deg,#060d33,#0f1f6e);}.card{background:white;border-radius:1rem;box-shadow:0 1px 3px rgba(0,0,0,.08);}.badge-role{background:linear-gradient(135deg,#4338ca,#6366f1);}@keyframes fadeSlide{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}.anim{animation:fadeSlide .5s ease forwards;}</style>
</head>
<body class="h-full">
<div class="flex h-full min-h-screen">
  @include('partials.sidebar')
  <main class="flex-1 overflow-auto p-8">
    <div class="flex items-center justify-between mb-8 anim">
      <div><h1 class="text-2xl font-extrabold text-navy-900">Dashboard Kasubag TU</h1><p class="text-slate-500 text-sm mt-1">Selamat datang, <span class="font-semibold text-navy-700">{{ auth()->user()->name }}</span></p></div>
      <div class="flex items-center gap-3">
        <span class="badge-role text-white text-xs font-bold px-3 py-1.5 rounded-full">{{ auth()->user()->role_label }}</span>
        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
      @foreach([['label'=>'Total BMN','value'=>'1.247','color'=>'bg-indigo-100 text-indigo-600'],['label'=>'Admin Aktif','value'=>'6','color'=>'bg-green-100 text-green-600'],['label'=>'Peminjaman Aktif','value'=>'23','color'=>'bg-amber-100 text-amber-600']] as $s)
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
