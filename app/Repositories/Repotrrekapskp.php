<?php
namespace App\Repositories;

use App\Models\TrRekapSkp;
use Illuminate\Support\Facades\DB;

class Repotrrekapskp extends Repository
{
    protected $model;

    public function __construct(TrRekapSkp $model)
    {
        $this->model = $model;
    }

    public function get($with = null, $id_sdm = null, $tahun = null, $bulan = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->whereHas('dt_periode', function ($query) use ($tahun,$bulan) {
                $tmbh = "";
                if($bulan){
                    $tmbh = " and bulan = '$bulan'";
                }
                return $query->whereRaw(" SUBSTRING(CAST(tahun AS VARCHAR(19)), 0, 5) = '$tahun' $tmbh");
            })
            ->get();
    }
}