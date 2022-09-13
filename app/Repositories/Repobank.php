<?php
namespace App\Repositories;

use App\Models\MsBank;
use Illuminate\Support\Facades\DB;

class Repobank extends Repository
{
    protected $model;

    public function __construct(MsBank $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('kode_bank','asc')
            ->get();
    }
}