<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPANDU - Survei Layanan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  :root {
    --primary: #2563eb;
    --primary-light: #60a5fa;
    --accent: #06b6d4;
    --success: #10b981;
    --bg: #f8fafc;
    --card-bg: #ffffff;
    --text-primary: #0f172a;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 24px;
    --shadow-lg: 0 10px 40px rgba(37,99,235,0.08);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text-primary);
    display: flex;
    min-height: 100vh;
  }

  /* MAIN */
  .main { margin-left: 260px; flex: 1; padding: 0 32px 40px; display: flex; flex-direction: column; }

  .topbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0 24px;
    position: sticky; top: 0; z-index: 50;
    background: var(--bg);
  }
  .topbar-left { display: flex; align-items: center; gap: 14px; }
  .breadcrumb { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }
  .breadcrumb span { color: var(--primary); font-weight: 600; }
  .topbar-title { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; }
  .topbar-right { display: flex; align-items: center; gap: 12px; }
  .notif-btn {
    width: 40px; height: 40px;
    background: var(--card-bg); border: 1px solid var(--border);
    border-radius: 10px; display: grid; place-items: center;
    cursor: pointer; position: relative; color: var(--text-secondary); transition: all .2s;
  }
  .notif-btn:hover { border-color: var(--primary); color: var(--primary); }
  .notif-dot { position: absolute; top: 8px; right: 8px; width: 7px; height: 7px; background: #ef4444; border-radius: 50%; border: 1.5px solid var(--card-bg); }

  /* MESSAGE CARD LAYOUT */
  .center-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 0;
  }

  .message-card {
    background: var(--card-bg);
    max-width: 750px;
    width: 100%;
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    text-align: center;
    padding: 60px 50px;
    border-top: 6px solid var(--primary);
  }

  /* Decorative Background Elements */
  .message-card::before {
    content: '';
    position: absolute;
    top: -50px; left: -50px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(37,99,235,0.06) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 0;
  }
  .message-card::after {
    content: '';
    position: absolute;
    bottom: -80px; right: -80px;
    width: 250px; height: 250px;
    background: radial-gradient(circle, rgba(16,185,129,0.06) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 0;
  }

  .card-content {
    position: relative;
    z-index: 1;
  }

  .icon-wrapper {
    width: 86px;
    height: 86px;
    margin: 0 auto 28px;
    background: linear-gradient(135deg, var(--primary-light), var(--primary));
    color: #fff;
    font-size: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 24px;
    box-shadow: 0 12px 30px rgba(37,99,235,0.25);
    transform: rotate(-5deg);
    transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .message-card:hover .icon-wrapper {
    transform: rotate(0deg) scale(1.08);
  }

  .message-title {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 20px;
  }

  .message-text {
    font-size: 15.5px;
    color: var(--text-secondary);
    line-height: 1.8;
    margin-bottom: 35px;
  }

  .btn-survey {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, var(--primary), #1e40af);
    color: #fff;
    text-decoration: none;
    padding: 16px 36px;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 700;
    box-shadow: 0 8px 25px rgba(37,99,235,0.3);
    transition: all 0.3s;
  }
  .btn-survey:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(37,99,235,0.4);
  }
  .btn-survey i {
    font-size: 18px;
  }

  .divider {
    height: 1px;
    width: 60%;
    margin: 40px auto 30px;
    background: linear-gradient(90deg, transparent, var(--border), transparent);
  }

  .message-footer {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.7;
    font-style: italic;
    font-weight: 500;
  }

  @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
  .animate-card { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

  @media (max-width: 768px) {
    .main { margin-left: 0; padding: 20px; }
    .message-card { padding: 40px 25px; }
    .message-title { font-size: 22px; }
    .message-text { font-size: 14px; }
    .btn-survey { padding: 14px 28px; font-size: 14px; }
  }
</style>
</head>
<body>

@include('partials.sidebar')

<main class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left">
      <div>
        <div class="breadcrumb"><a href="{{ route('tamu.dashboard') }}" style="text-decoration:none;color:var(--text-secondary)">Dashboard</a> <i class="fas fa-chevron-right" style="font-size:10px"></i> <span>Survei Layanan</span></div>
        <div class="topbar-title">Survei Layanan Penilian Fasilitas BPMP</div>
      </div>
    </div>
    <div class="topbar-right">
      <div class="notif-btn"><i class="fas fa-bell"></i><div class="notif-dot"></div></div>
    </div>
  </div>

  <!-- CENTER CONTENT -->
  <div class="center-wrapper">
    <div class="message-card animate-card">
      <div class="card-content">
        
        <div class="icon-wrapper">
          <i class="fas fa-comment-dots"></i>
        </div>

        <h2 class="message-title">Survei Evaluasi Layanan</h2>
        
        <p class="message-text">
          Bapak dan Ibu yang kami hormati, terima kasih atas kepercayaan Anda dalam memanfaatkan fasilitas BPMP Provinsi Gorontalo. Sebagai upaya kami untuk terus meningkatkan standar layanan, kami memohon kesediaan waktu Anda untuk mengisi survei evaluasi di bawah ini.
        </p>

        <a href="https://s.id/SurveiLayananFasilitas" target="_blank" class="btn-survey">
          <i class="fas fa-external-link-alt"></i> Isi Survei Sekarang
        </a>

        <div class="divider"></div>

        <p class="message-footer">
          "Setiap masukan yang Anda berikan sangat berharga bagi kami dalam mewujudkan pelayanan yang lebih baik ke depannya. Terima kasih atas partisipasi dan kerja samanya."
        </p>

      </div>
    </div>
  </div>
</main>

</body>
</html>