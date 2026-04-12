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
