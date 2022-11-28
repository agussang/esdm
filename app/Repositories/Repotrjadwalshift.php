<?php
namespace App\Repositories;

use App\Models\TrJadwalShift;
use Illuminate\Support\Facades\DB;

class Repotrjadwalshift extends Repository
{
    protected $model;

    public function __construct(TrJadwalShift $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$tgl1 = null,$tgl2 = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($tgl1, function ($query) use ($tgl1,$tgl2) {
                return $query->whereRaw(" substr(tanggal_absen::text,0,11) >= '$tgl1' and substr(tanggal_absen::text,0,11) <= '$tgl2' ");
            })
            ->orderBy('tanggal_absen','asc')
            ->get();
    }

}
