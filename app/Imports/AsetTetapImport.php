<?php

namespace App\Imports;

use App\Models\AssetTetap;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AsetTetapImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Lewati jika data kunci kosong (mengantisipasi baris kosong di Excel)
        if (!isset($row['kode_barang']) || !isset($row['nama_barang'])) {
            return null;
        }

        try {
            // Cek apakah kode barang sudah ada (Update) atau Baru (Create)
            $aset = AssetTetap::where('kode_barang', $row['kode_barang'])->first();

            $data = [
                'tanggal_input'     => $this->parseDate($row['tanggal_input']) ?? now(),
                'nup'               => $row['nup'] ?? null,
                'nama_barang'       => $row['nama_barang'],
                'merek'             => $row['merek'] ?? null,
                'kategori'          => $row['kategori'] ?? null,
                'tanggal_perolehan' => $this->parseDate($row['tanggal_perolehan']),
                'nilai_perolehan'   => $row['nilai_perolehan'] ?? 0,
                'kondisi'           => strtolower($row['kondisi'] ?? 'baik'),
                'lokasi'            => $row['lokasi'] ?? null,
                'jumlah'            => $row['jumlah'] ?? 1,
                'status'            => ucfirst($row['status'] ?? 'Tersedia'),
            ];

            // Jika barang sudah ada, lakukan update datanya
            if ($aset) {
                $aset->update($data);
                return null; // Return null agar tidak membuat baris ganda
            }

            // Jika barang baru, masukkan ke dalam Create
            $data['kode_barang'] = $row['kode_barang'];
            return new AssetTetap($data);
        } catch (\Exception $e) {
            Log::error('Error Import Aset Baris: ' . json_encode($row) . ' - Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fungsi untuk mengubah format tanggal dari angka seri Excel ke Y-m-d
     */
    private function parseDate($date)
    {
        if (!$date) return null;

        // Excel seringkali menyimpan tanggal sebagai angka (misal: 44197)
        if (is_numeric($date)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
        }

        // Jika formatnya teks biasa
        return Carbon::parse($date)->format('Y-m-d');
    }
}
