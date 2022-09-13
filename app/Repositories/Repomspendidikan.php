<?php
namespace App\Repositories;

use App\Models\MsPendidikan;
use Illuminate\Support\Facades\DB;

class Repomspendidikan extends Repository
{
    protected $model;

    public function __construct(MsPendidikan $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->where('urutan','!=',null)
            ->orderBy('urutan','asc')
            ->get();
    }
}