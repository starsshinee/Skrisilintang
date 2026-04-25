<?php

namespace App\Exports;

use App\Models\SurveyKepuasan; // Sesuaikan dengan model Survey Anda
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;


class SurveyExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        // Ambil data dengan filter yang sama seperti halaman web
        return SurveyKepuasan::filter($this->request)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function map($survey): array
    {
        $ratingText = [
            'sangat_puas' => 'Sangat Puas (★★★★★)',
            'puas' => 'Puas (★★★★☆)',
            'cukup' => 'Cukup (★★★☆☆)',
            'kurang_puas' => 'Kurang Puas (★★☆☆☆)',
            'tidak_puas' => 'Tidak Puas (★☆☆☆☆)'
        ];

        return [
            $survey->created_at?->format('d-m-Y H:i') ?? '-',
            $survey->nama ?? '-',
            $survey->email ?? '-',
            $ratingText[$survey->kepuasan] ?? 'Tidak Puas',
            $survey->aspek_memuaskan ?? '-',
            $survey->saran ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal Survey',
            'Nama Responden',
            'Email',
            'Tingkat Kepuasan',
            'Aspek Positif',
            'Saran Perbaikan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}