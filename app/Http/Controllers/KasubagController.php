<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    PeminjamanGedung,
    PermintaanPersediaan,
};

class KasubagController extends Controller
{
    public function dashboard()
    {
        // Logika untuk menampilkan dashboard kasubag
        return view('kasubag.dashbord');
    }

    public function persetujuanPeminjamanGedung(Request $request)
    {
       $query = PeminjamanGedung::with(['user', 'reviewer'])
            ->whereIn('status', ['dalam_review', 'disetujui_kasubag'])
            ->orderBy('diteruskan_ke_kasubag_date', 'desc');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%'.$request->search.'%')
                  ->orWhere('instansi_lembaga', 'like', '%'.$request->search.'%');
            });
        }

        $peminjaman = $query->paginate(15);

        return view('kasubag.persetujuan_peminjaman_gedung', compact('peminjaman'));
    }

    // Approve oleh Kasubag
    // Fix approve method - tambahkan CSRF handling
    public function approveByKasubag(Request $request, PeminjamanGedung $peminjaman)
    {
        $request->validate(['komentar' => 'nullable|string|max:1000']);

        // Cek apakah masih dalam review
        if ($peminjaman->status !== 'dalam_review') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah diproses sebelumnya!'
            ], 400);
        }

        $peminjaman->update([
            'status' => 'disetujui_kasubag', // Ubah ke status yang sesuai model
            'approved_by_kasubag_id' => auth()->id(),
            'approved_by_kasubag_date' => now(),
            'komentar' => $request->komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil disetujui!'
        ]);
    }

    public function rejectByKasubag(Request $request, PeminjamanGedung $peminjaman)
    {
        $request->validate(['komentar' => 'required|string|max:1000']);

        if ($peminjaman->status !== 'dalam_review') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman sudah diproses sebelumnya!'
            ], 400);
        }

        $peminjaman->update([
            'status' => 'ditolak_kasubag',
            'approved_by_kasubag_id' => auth()->id(),
            'komentar' => $request->komentar
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Peminjaman berhasil ditolak!'
        ]);
    }


    // Download surat untuk Kasubag
    public function downloadSurat(PeminjamanGedung $peminjaman)
    {
        if (!$peminjaman->surat_path || !Storage::disk('public')->exists($peminjaman->surat_path)) {
        return back()->with('error', 'Surat peminjaman tidak ditemukan!');
    }

    $filePath = storage_path('app/public/' . $peminjaman->surat_path);
    $originalName = pathinfo($peminjaman->surat_path, PATHINFO_BASENAME);
    $downloadName = "Surat_Peminjaman_{$peminjaman->nama_lengkap}_{$peminjaman->id}." . 
                    pathinfo($originalName, PATHINFO_EXTENSION);

    return response()->download($filePath, $downloadName);
    }

    // Method untuk detail JSON (API)
    public function show(PeminjamanGedung $peminjaman)
    {
        $peminjaman->load(['user', 'gedung', 'reviewer', 'approver']);
        
        return response()->json([
            'id' => $peminjaman->id,
            'gedung' => $peminjaman->gedung ? [
                'nama_gedung' => $peminjaman->gedung->nama_gedung,
                'lokasi' => $peminjaman->gedung->lokasi,
            ] : null,
            'nama_lengkap' => $peminjaman->nama_lengkap,
            'nip_nik' => $peminjaman->nip_nik,
            'instansi_lembaga' => $peminjaman->instansi_lembaga,
            'kabupaten_kota' => $peminjaman->kabupaten_kota,
            'fasilitas' => $peminjaman->fasilitas,
            'nama_fasilitas' => $peminjaman->nama_fasilitas,
            'tarif_per_hari' => $peminjaman->tarif_per_hari,
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
            'tanggal_kembali' => $peminjaman->tanggal_kembali,
            'jam_mulai' => $peminjaman->jam_mulai,
            'jam_selesai' => $peminjaman->jam_selesai,
            'lama_peminjaman_hari' => $peminjaman->lama_peminjaman_hari,
            'total_pembayaran' => $peminjaman->total_pembayaran,
            'tujuan_penggunaan' => $peminjaman->tujuan_penggunaan,
            'nomor_kontak' => $peminjaman->nomor_kontak,
            'status' => $peminjaman->status,
            'status_text' => $peminjaman->status_text,
            'komentar' => $peminjaman->komentar,
            'reviewer' => $peminjaman->reviewer ? ['name' => $peminjaman->reviewer->name] : null,
            'diteruskan_ke_kasubag_date' => $peminjaman->diteruskan_ke_kasubag_date,
            'surat_url' => $peminjaman->surat_url,
            'created_at' => $peminjaman->created_at->toISOString(),
        ]);
    }

    //PEMINJAMAN BARANG
    public function persetujuanPeminjamanBarang()
    {
        // Logika untuk menampilkan halaman persetujuan peminjaman barang
        return view('kasubag.persetujuan_peminjaman_barang');
    }

     //PEMINJAMAN KENDARAAN
    public function persetujuanPeminjamanKendaraan()
    {
        // Logika untuk menampilkan halaman persetujuan peminjaman kendaraan
        return view('kasubag.persetujuan_peminjaman_kendaraan');
    }

     
    //PERMINTAAN PERSEDIAAN
    public function persetujuanPermintaanPersediaan()
    {
        $stats = [
            'menunggu' => PermintaanPersediaan::where('status', 'dalam_review')->count(),
            'disetujui' => PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag'])->count(),
            'total' => PermintaanPersediaan::whereIn('status', ['disetujui', 'disetujui_kasubag', 'ditolak', 'ditolak_kasubag'])->count()
        ];

        $permintaan = PermintaanPersediaan::with(['user', 'persediaan'])
                    ->whereIn('status', ['dalam_review', 'disetujui', 'disetujui_kasubag', 'ditolak', 'ditolak_kasubag'])
                    ->orderByRaw("CASE WHEN status = 'dalam_review' THEN 1 ELSE 2 END") // Yang belum direview ditaruh paling atas
                    ->latest()
                    ->get();

        // BENAR: Gunakan compact('permintaan') untuk mengirim data
        return view('kasubag.persetujuan_permintaan_persediaan', compact('permintaan', 'stats'));
    }

    public function approvePermintaan(Request $request, PermintaanPersediaan $permintaan)
    {
        if (!in_array($permintaan->status, ['dalam_review', 'disetujui_kasubag'])) {
            return back()->with('error', 'Permintaan tidak valid untuk diproses!');
        }

        if ($request->action === 'setuju') {
            $permintaan->update([
                'status' => 'disetujui',
                'approved_by_kasubag_id' => Auth::id(),
            ]);
        } else {
            $permintaan->update([
                'status' => 'ditolak',
                'approved_by_kasubag_id' => Auth::id(),
            ]);
        }

        return back()->with('success', 'Permintaan berhasil diproses!');
    }

    /**
     * Menampilkan Detail Permintaan Persediaan untuk Kasubag
     */
    public function showPermintaan($id)
    {
        // Ambil data beserta relasinya
        $permintaan = PermintaanPersediaan::with(['persediaan', 'user', 'reviewedBy', 'approvedByKasubag'])
                        ->findOrFail($id);

        return view('kasubag.detail_permintaan_persediaan', compact('permintaan'));
    }

    public function pengaturanAkun()
    {
        // Logika untuk menampilkan pengaturan akun
        return view('kasubag.pengaturan_akun');
    }
}