<?php
namespace App\Repositories;

use App\Models\RiwayatPresensi;
use Illuminate\Support\Facades\DB;


class Reporiwayatpresensi extends Repository
{
    protected $model;

    public function __construct(RiwayatPresensi $model)
    {
        $this->model = $model;
    }

    public function get($with = null, $mesin = null, $arrIdSdm = null,$tgl_awal = null,$tgl_akhir = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($arrIdSdm, function ($query) use ($arrIdSdm) {
                return $query->whereIn('id_sdm', $arrIdSdm);
            })->when($tgl_awal, function ($query) use ($tgl_awal) {
                return $query->whereRaw("tanggal_absen >= '$tgl_awal'");
            })->when($tgl_akhir, function ($query) use ($tgl_akhir) {
                return $query->whereRaw("tanggal_absen <= '$tgl_akhir'");
            })
            ->orderBy('tanggal_absen','asc')
            ->orderBy('jam_absen','asc')
            ->get();
    }
}