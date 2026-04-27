<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\{
    Gedung,
    PeminjamanGedung,
    PengembalianGedung,
};

class TamuController extends Controller
{
    // Di Controller (misal: TamuDashboardController.php)
    public function dashboard()
    {
        $user = auth()->user();
        
        // Stats
        $stats = [
            'total' => $user->peminjamanGedung()->count(),
            'pending' => $user->peminjamanGedung()->where('status', 'pending')->count(),
            'approved' => $user->peminjamanGedung()->where('status', 'disetujui')->count(),
        ];
        
        // Recent requests (5 terbaru)
        $peminjaman_terbaru = $user->peminjamanGedung()
            ->with('gedung')
            ->latest()
            ->limit(5)
            ->get();
        
        // Notifications (optional)
        // $notifikasi = $user->notifications()->unread()->limit(5)->get();
        
        return view('tamu.dashbord', compact('stats', 'peminjaman_terbaru'));
    }

    public function peminjamanGedung()
    {
        // ✅ 1. Ambil gedung yang tersedia
        $gedungs = Gedung::where('ketersediaan', 'Tersedia')
            ->orderBy('kategori')
            ->orderBy('nama_gedung')
            ->get()
            ->groupBy('kategori');

        // ✅ 2. Generate $fasilitasData dari database (BUKAN hardcoded)
        $fasilitasData = [];
        foreach ($gedungs as $kategori => $items) {
            foreach ($items as $gedung) {
                $fasilitasData[$gedung->id] = [
                    'id' => $gedung->id,
                    'nama' => $gedung->nama_gedung,
                    'kategori' => $gedung->kategori,
                    'lokasi' => $gedung->lokasi,
                    'kapasitas' => $gedung->kapasitas . ' Orang',
                    'tarif' => $gedung->tarif_sewa,
                    'icon' => $gedung->icon,
                    'ketersediaan' => $gedung->ketersediaan,
                    'foto_url' => $gedung->foto_url,
                    'luas' => $gedung->luas_bangunan,
                ];
            }
        }

        // ✅ 3. Riwayat peminjaman
        $riwayat = collect();
        if (auth('web')->check()) {
            $riwayat = PeminjamanGedung::where('user_id', auth('web')->id())
                ->with('gedung')
                ->latest()
                ->limit(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama_fasilitas' => $item->nama_fasilitas ?? $item->gedung?->nama_gedung,
                        'kode' => 'REQ-TAM-' . str_pad($item->id, 3, '0', STR_PAD_LEFT),
                        'instansi_lembaga' => $item->instansi_lembaga,
                        'tujuan_penggunaan' => Str::limit($item->tujuan_penggunaan, 25),
                        'tanggal_pinjam' => $item->tanggal_pinjam?->format('d M Y'),
                        'tanggal_kembali' => $item->tanggal_kembali?->format('d M Y'),
                        'range_tanggal' => $item->tanggal_pinjam?->format('d M') . ' – ' . $item->tanggal_kembali?->format('d M Y'),
                        'total_pembayaran' => 'Rp ' . number_format($item->total_pembayaran, 0, ',', '.'),
                        'status' => $item->status,
                        'status_pembayaran' => $item->status_pembayaran,
                        'created_at' => $item->created_at?->format('d M Y'),
                        'fasilitas' => $item->fasilitas,
                        'gedung_id' => $item->gedung_id,
                    ];
                });
        }

        // ✅ 4. Pass SEMUA variabel ke view
        return view('tamu.peminjaman_gedung', compact('gedungs', 'fasilitasData', 'riwayat'));
    }

    public function storePeminjamanGedung(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nip_nik' => 'required|string|max:50',
            'instansi_lembaga' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:100',
            'gedung_id' => 'required|exists:gedung,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'tujuan_penggunaan' => 'required|string|max:1000',
            'nomor_kontak' => 'required|string|max:20',
            'surat_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ]);

        // Ambil data gedung
        $gedung = Gedung::findOrFail($validated['gedung_id']);

        // Hitung durasi dan total pembayaran
        $start = Carbon::parse($validated['tanggal_pinjam']);
        $end = Carbon::parse($validated['tanggal_kembali']);
        $lamaPeminjaman = $start->diffInDays($end) + 1;
        $totalPembayaran = $gedung->tarif_sewa * $lamaPeminjaman;

        // Upload surat
        $suratPath = null;
        if ($request->hasFile('surat_path')) {
            $suratPath = $request->file('surat_path')->store('peminjaman_surat', 'public');
        }

        // Buat peminjaman
        $peminjaman = PeminjamanGedung::create([
            'user_id' => auth('web')->id(),
            'gedung_id' => $gedung->id,
            'nama_lengkap' => $validated['nama_lengkap'],
            'nip_nik' => $validated['nip_nik'],
            'instansi_lembaga' => $validated['instansi_lembaga'],
            'kabupaten_kota' => $validated['kabupaten_kota'],
            'fasilitas' => $gedung->kategori,
            'nama_fasilitas' => $gedung->nama_gedung,
            'tarif_per_hari' => $gedung->tarif_sewa,
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'lama_peminjaman_hari' => $lamaPeminjaman,
            'total_pembayaran' => $totalPembayaran,
            'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
            'nomor_kontak' => $validated['nomor_kontak'],
            'surat_path' => $suratPath,
            'status' => 'pending',
            'status_pembayaran' => 'belum_lunas',
            'cara_pembayaran' => 'tunai',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan peminjaman ' . $gedung->nama_gedung . ' berhasil dikirim!',
            'data' => $peminjaman
        ]);
    }

    public function pengaturanAkun()
    {
        // Logika untuk pengaturan akun
        return view('tamu.pengaturan_akun');
    }

    /**
     * Info Fasilitas – data diambil dari tabel gedung (relasi dengan CRUD admin sarpras)
     */
    public function infoFasilitas(Request $request)
    {
        $query = Gedung::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_gedung', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('fasilitas', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        $gedungs = $query->latest()->get();

        // Statistik untuk hero section
        $totalGedung = Gedung::count();
        $tersedia    = Gedung::where('ketersediaan', 'Tersedia')->count();

        return view('tamu.info_fasilitas', compact('gedungs', 'totalGedung', 'tersedia'));
    }

    public function pengembalianGedung()
    {
        // Logika untuk pengembalian gedung
        return view('tamu.pengembalian_gedung');
    }
}
