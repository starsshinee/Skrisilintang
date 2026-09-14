<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Test - Provider SIPANDU</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f5f7fa; margin: 0; padding: 24px; }
        .container { max-width: 640px; margin: 0 auto; }
        h1 { color: #1e293b; font-size: 20px; margin: 0 0 4px; }
        p.sub { color: #64748b; margin: 0 0 20px; font-size: 13px; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 12px; overflow: hidden; }
        .card-header { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; cursor: pointer; background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .card-header:hover { background: #f1f5f9; }
        .card-title { font-weight: 600; font-size: 14px; color: #1e293b; }
        .card-method { font-size: 11px; background: #6366f1; color: #fff; padding: 2px 8px; border-radius: 4px; }
        .status-pill { font-size: 11px; padding: 2px 8px; border-radius: 4px; margin-left: 8px; }
        .status-200 { background: #22c55e; color: #fff; }
        .status-4xx, .status-5xx { background: #ef4444; color: #fff; }
        .card-body { padding: 12px 16px; display: none; }
        .card-body.open { display: block; }
        pre { background: #0f172a; color: #a5f3fc; padding: 12px; border-radius: 6px; font-size: 12px; overflow-x: auto; max-height: 280px; }
        .summary { font-size: 12px; color: #334155; margin-bottom: 8px; }
        .btn-test { background: #6366f1; color: #fff; border: none; padding: 10px 18px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; }
        .btn-test:hover { background: #4f46e5; }
        .btn-test:disabled { background: #94a3b8; cursor: not-allowed; }
        .hint { background: #fef9c3; border: 1px solid #fde047; color: #713f12; padding: 10px 14px; border-radius: 6px; font-size: 12px; margin-bottom: 16px; line-height: 1.6; }
        code { background: #e2e8f0; padding: 1px 5px; border-radius: 3px; font-size: 12px; }
        .empty { color: #94a3b8; font-style: italic; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Halaman Test API Provider SIPANDU</h1>
        <p class="sub">Hasil setiap request akan tercetak di <b>Browser Console</b> (tekan <code>F12</code> &gt; tab Console)</p>

        <div class="hint">
            Permission: Cek header yang dikirim di <b>Network tab</b> (F12 &gt; Network &gt; klik request &gt; Headers).<br>
            Header yang dikirim: <code>X-API-KEY: {{ $apiKey }}</code>
        </div>

        <button class="btn-test" id="btnAll" onclick="testAll()">Test Semua Endpoint</button>

        <div style="margin-top:20px">
            @foreach ($endpoints as $label => $endpoint)
                <div class="card">
                    <div class="card-header" onclick="toggleBody(this)">
                        <span>
                            <span class="card-method">GET</span>
                            <span class="card-title">{{ $label }}</span>
                        </span>
                        <span>
                            <span class="status-pill" id="pill-{{ \Illuminate\Support\Str::slug($label) }}">belum di-test</span>
                            <button class="btn-test" style="padding:4px 10px;font-size:12px" onclick="event.stopPropagation();testEndpoint('{{ $endpoint }}', this.parentElement.parentElement)">Test</button>
                        </span>
                    </div>
                    <div class="card-body" id="body-{{ \Illuminate\Support\Str::slug($label) }}">
                        <div class="summary" id="summary-{{ \Illuminate\Support\Str::slug($label) }}">Menunggu...</div>
                        <pre id="pre-{{ \Illuminate\Support\Str::slug($label) }}"></pre>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const API_KEY = @json($apiKey);

        function toggleBody(header) {
            const body = header.nextElementSibling;
            body.classList.toggle('open');
        }

        async function testEndpoint(endpoint, card) {
            const label = card.querySelector('.card-title').textContent.trim();
            const slug = label.toLowerCase().replace(/[^a-z0-9]+/g, '-');
            const pill = document.getElementById('pill-' + slug);
            const body = document.getElementById('body-' + slug);
            const summary = document.getElementById('summary-' + slug);
            const pre = document.getElementById('pre-' + slug);

            body.classList.add('open');
            pill.textContent = 'proses...';
            pill.className = 'status-pill';

            const t0 = performance.now();

            console.groupCollapsed('%c[API TEST] ' + endpoint, 'color:#6366f1;font-weight:bold');
            console.log('Endpoint:', endpoint);
            console.log('Method  : GET');
            console.log('Headers :', { 'X-API-KEY': API_KEY });

            const response = await fetch(endpoint, {
                method: 'GET',
                headers: { 'X-API-KEY': API_KEY }
            });

            const elapsed = Math.round(performance.now() - t0);
            let json;
            try { json = await response.json(); } catch (e) { json = { raw: '(bukan JSON)' }; }

            // ── INFO KE CONSOLE ──────────────────────────────
            console.log('HTTP Status :', response.status, response.statusText);
            console.log('Waktu       :', elapsed + ' ms');
            console.log('Response    :', json);

            if (json && json.status === 'success' && json.data) {
                const records = json.data.data ? json.data.data.length : (Array.isArray(json.data) ? json.data.length : '-');
                console.log('%cSUKSES - Jumlah record: ' + records, 'color:#22c55e;font-weight:bold');
            } else {
                console.log('%cGAGAL - ' + (json.message || 'data kosong'), 'color:#ef4444;font-weight:bold');
            }
            console.groupEnd();
            // ── AKHIR INFO KE CONSOLE ────────────────────────

            // ── TAMPILAN DI HALAMAN ──────────────────────────
            const statusClass = response.status === 200 ? 'status-200' : 'status-4xx';
            pill.textContent = response.status + ' (' + elapsed + 'ms)';
            pill.className = 'status-pill ' + statusClass;

            summary.textContent = 'Status: ' + response.status + ' ' + response.statusText + ' | ' + elapsed + ' ms';

            if (json && json.status === 'success' && json.data) {
                const records = json.data.data ? json.data.data.length : (Array.isArray(json.data) ? json.data.length : '-');
                const total = json.data.total ? ' | Total: ' + json.data.total : '';
                summary.textContent += ' | Sisipan Data: ' + records + total;
                pre.textContent = JSON.stringify(json.data.data || json.data, null, 2).slice(0, 4000);
            } else {
                pre.textContent = JSON.stringify(json, null, 2);
            }
        }

        async function testAll() {
            const btn = document.getElementById('btnAll');
            btn.disabled = true;
            btn.textContent = 'Menjalankan...';
            document.querySelectorAll('.card').forEach(card => {
                const btnTest = card.querySelector('.btn-test');
                if (btnTest) { btnTest.disabled = true; }
            });
            await testEndpoint('/api/aset-tetap/master');
            await testEndpoint('/api/aset-tetap/transaksi-masuk');
            await testEndpoint('/api/aset-tetap/transaksi-keluar');
            await testEndpoint('/api/persediaan/master');
            await testEndpoint('/api/persediaan/transaksi-masuk');
            await testEndpoint('/api/persediaan/transaksi-keluar');
            btn.disabled = false;
            btn.textContent = 'Test Semua Endpoint';
            document.querySelectorAll('.card').forEach(card => {
                const btnTest = card.querySelector('.btn-test');
                if (btnTest) { btnTest.disabled = false; }
            });
        }
    </script>
</body>
</html>