<?php
namespace App\Repositories;

use App\Models\RiwayatPangkat;
use Illuminate\Support\Facades\DB;

class Reporiwayatpangkat extends Repository
{
    protected $model;

    public function __construct(RiwayatPangkat $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->orderBy('tgl_sk','asc')
            ->get();
    }
}