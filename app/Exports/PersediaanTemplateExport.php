<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PersediaanTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'kode_kategori',
            'kategori',
            'kode_barang',
            'nama_barang',
            'tanggal_masuk',
            'harga_satuan',
            'jumlah'
        ];
    }

    public function array(): array
    {
        return [
            [
                'ATK',
                'Alat Tulis Kantor',
                'ATK-001',
                'Kertas HVS A4 Sidu',
                date('Y-m-d'),
                50000,
                10
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4F6FFF']
                ],
            ],
        ];
    }
}
