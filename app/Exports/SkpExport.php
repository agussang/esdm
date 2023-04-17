<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SkpExport implements FromView, ShouldAutoSize, WithColumnFormatting
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
        return view('content.skp.data_skp.download', [
            'data' => $this->data
        ]);
    }
}
