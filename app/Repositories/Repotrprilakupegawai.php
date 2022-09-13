<?php
namespace App\Repositories;

use App\Models\TrPrilakuPegawai;
use Illuminate\Support\Facades\DB;

class Repotrprilakupegawai extends Repository
{
    protected $model;

    public function __construct(TrPrilakuPegawai $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$id_sdm = null,$id_periode = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->when($id_periode, function ($query) use ($id_periode) {
                return $query->whereRaw("idperiode = '$id_periode'");
            })->get();
    }
}