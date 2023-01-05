<?php
namespace App\Repositories;

use App\Models\TrJustifikasi;
use Illuminate\Support\Facades\DB;

class Repotrjustifikasi extends Repository
{
    protected $model;

    public function __construct(TrJustifikasi $model)
    {
        $this->model = $model;
    }
    public function get($with = null,$id_sdm = null, $tahunbulan = null){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->when($tahunbulan, function ($query) use ($tahunbulan) {
                return $query->whereRaw(" SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 0, 8) = '$tahunbulan' ");
            })
            ->get();
    }
}
