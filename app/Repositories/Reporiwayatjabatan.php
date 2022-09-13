<?php
namespace App\Repositories;

use App\Models\RiwayatJabatan;
use Illuminate\Support\Facades\DB;

class Reporiwayatjabatan extends Repository
{
    protected $model;

    public function __construct(RiwayatJabatan $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$id_sdm)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->where('id_sdm',$id_sdm)
            ->orderBy('tmt_sk','asc')
            ->get();
    }
}