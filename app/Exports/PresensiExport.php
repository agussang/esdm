<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresensiExport implements FromView
{
    public function __construct($data){
        $this->data = $data;
    }

    public function view(): View
    {
        $tipe = $this->data['tipe'];
        if($tipe==1){
            return view('content.laporan.kehadiran.cetakdatapresensixls', [
                'data' => $this->data
            ]);
        }else if($tipe==2){
            return view('content.laporan.kehadiran.cetak_data_presensi2_xls', [
                'data' => $this->data
            ]);
        }else if($tipe==3){
            return view('content.laporan.kehadiran.cetak_data_presensi_lembur_xls', [
                'data' => $this->data
            ]);
        }else if($tipe==4){
            return view('content.laporan.kehadiran.cetak_data_presensi_bulanan_xls', [
                'data' => $this->data
            ]);
        }
    }
}
