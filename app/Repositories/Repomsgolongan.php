<?php
namespace App\Repositories;

use App\Models\MsGolongan;
use Illuminate\Support\Facades\DB;

class Repomsgolongan extends Repository
{
    protected $model;

    public function __construct(MsGolongan $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('nama_golongan','desc')
            ->get();
    }
}