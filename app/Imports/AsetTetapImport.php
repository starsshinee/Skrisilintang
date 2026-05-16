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
        // Lewati jika kunci utama kosong
        if (empty($row['kode_barang']) || empty($row['nama_barang'])) {
            return null;
        }

        // Cari berdasarkan KODE BARANG dan NUP
        $query = AssetTetap::where('kode_barang', $row['kode_barang']);

        if (!empty($row['nup'])) {
            $query->where('nup', $row['nup']);
        } else {
            $query->whereNull('nup');
        }

        $aset = $query->first();

        $data = [
            'tanggal_input'     => $this->parseDate($row['tanggal_input']) ?? now(),
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

        // Jika barang dengan Kode & NUP tersebut sudah ada, Update lokasinya/kondisinya
        if ($aset) {
            $aset->update($data);
            return null;
        }

        // Jika belum ada, masukkan sebagai data baru (Create)
        $data['kode_barang'] = $row['kode_barang'];
        $data['nup'] = $row['nup'] ?? null;
        return new AssetTetap($data);
    }

    private function parseDate($date)
    {
        if (!$date) return null;

        if (is_numeric($date)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
        }

        return Carbon::parse($date)->format('Y-m-d');
    }
}
