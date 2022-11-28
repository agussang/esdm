<?php
namespace App\Repositories;

use App\Models\MsWaktuShift;
use Illuminate\Support\Facades\DB;

class Repomswaktushift extends Repository
{
    protected $model;

    public function __construct(MsWaktuShift $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->orderBy('kode_shift','asc')
            ->get();
    }
}
