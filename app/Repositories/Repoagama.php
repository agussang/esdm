<?php
namespace App\Repositories;

use App\Models\MsAgama;
use Illuminate\Support\Facades\DB;

class Repoagama extends Repository
{
    protected $model;

    public function __construct(MsAgama $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('namaagama','asc')
            ->get();
    }
}
