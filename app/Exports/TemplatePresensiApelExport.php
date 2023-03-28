<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TemplatePresensiApelExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    public function __construct($data){
        $this->data = $data;
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }

    public function view(): View
    {
        return view('content.data_pegawai.presensi.data_apel.peserta.template', [
            'data' => $this->data
        ]);
    }
}
