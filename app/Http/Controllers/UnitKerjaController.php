<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    /**
     * Menampilkan halaman kelola Unit Kerja
     */
    public function index(Request $request)
    {
        // Fitur pencarian sederhana jika ada input 'search'
        $query = UnitKerja::query();
        
        if ($request->filled('search')) {
            $query->where('nama_unit', 'like', "%{$request->search}%")
                  ->orWhere('lokasi', 'like', "%{$request->search}%");
        }

        // Mengambil semua data unit kerja, urutkan berdasarkan nama
        $units = $query->orderBy('nama_unit', 'asc')->get();

        // Pastikan nama view ini sesuai dengan file blade yang Anda buat
        // Contoh: resources/views/superadmin/unit_kerja.blade.php
        return view('superadmin.unit_kerja', compact('units'));
    }

    /**
     * Menyimpan data Unit Kerja baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
        ], [
            'nama_unit.required' => 'Nama Unit Kerja wajib diisi.',
        ]);

        // Proses simpan
        UnitKerja::create([
            'nama_unit' => $request->nama_unit,
            'lokasi'    => $request->lokasi,
        ]);

        return back()->with('success', 'Unit Kerja berhasil ditambahkan!');
    }

    /**
     * Memperbarui data Unit Kerja yang sudah ada
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
        ], [
            'nama_unit.required' => 'Nama Unit Kerja wajib diisi.',
        ]);

        // Cari data berdasarkan ID, lalu update
        $unitKerja = UnitKerja::findOrFail($id);
        $unitKerja->update([
            'nama_unit' => $request->nama_unit,
            'lokasi'    => $request->lokasi,
        ]);

        return back()->with('success', 'Data Unit Kerja berhasil diperbarui!');
    }

    /**
     * Menghapus data Unit Kerja dari database
     */
    public function destroy($id)
    {
        $unitKerja = UnitKerja::findOrFail($id);
        
        // Opsional: Cek apakah unit kerja ini sedang dipakai oleh User/Pegawai
        // Jika Anda memiliki relasi users() di model UnitKerja:
        /*
        if ($unitKerja->users()->count() > 0) {
            return back()->with('error', 'Gagal menghapus! Unit Kerja ini masih memiliki pegawai yang terdaftar.');
        }
        */

        $unitKerja->delete();

        return back()->with('success', 'Unit Kerja berhasil dihapus!');
    }
}