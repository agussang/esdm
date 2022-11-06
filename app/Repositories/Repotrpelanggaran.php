<?php
namespace App\Repositories;

use App\Models\TrDataPelanggaran;
use Illuminate\Support\Facades\DB;

class Repotrpelanggaran extends Repository
{
    protected $model;

    public function __construct(TrDataPelanggaran $model)
    {
        $this->model = $model;
    }

    public function paginate($with = null,$id_sdm = null,$tgl_awal = null,$tgl_akhir = null,$id_alasan = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->paginate(25);
    }
    public function get($with = null,$nip = null, $bulan, $tahun){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($nip, function ($query) use ($nip) {
                $query->whereHas('dt_pegawai', function ($query) use ($nip) {
                    return $query->whereRaw(" nip  = '$nip' ");
                });
            })->when($bulan, function ($query) use ($bulan,$tahun) {
                $gabung = $tahun.'-'.$bulan;
                return $query->whereRaw(" SUBSTRING(CAST(tgl_berakhir AS VARCHAR(19)), 0, 8) >= '$gabung' ");
            })
            ->get();
    }
}