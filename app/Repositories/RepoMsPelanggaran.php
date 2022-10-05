<?php
namespace App\Repositories;

use App\Models\MsKategoriPelanggaran;
use Illuminate\Support\Facades\DB;

class RepoMsPelanggaran extends Repository
{
    protected $model;

    public function __construct(MsKategoriPelanggaran $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('urutan','asc')
            ->get();
    }
}