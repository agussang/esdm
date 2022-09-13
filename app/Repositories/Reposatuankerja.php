<?php
namespace App\Repositories;

use App\Models\SatuanUnitKerja;
use Illuminate\Support\Facades\DB;

class Reposatuankerja extends Repository
{
    protected $model;

    public function __construct(SatuanUnitKerja $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('nm_lemb','asc')
            ->get();
    }
}