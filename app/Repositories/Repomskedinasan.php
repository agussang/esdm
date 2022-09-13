<?php
namespace App\Repositories;

use App\Models\MsKedinasan;
use Illuminate\Support\Facades\DB;

class Repomskedinasan extends Repository
{
    protected $model;

    public function __construct(MsKedinasan $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('nama_kedinasan','desc')
            ->get();
    }
}