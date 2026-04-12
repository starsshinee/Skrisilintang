<!DOCTYPE html>
<html lang="id">
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

<! -- AUTH: LOGIN -->

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

</html>