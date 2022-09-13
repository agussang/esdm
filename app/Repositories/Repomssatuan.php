<?php
namespace App\Repositories;

use App\Models\MsSatuan;
use Illuminate\Support\Facades\DB;

class Repomssatuan extends Repository
{
    protected $model;

    public function __construct(MsSatuan $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->orderBy('kode','asc')
            ->get();
    }
}