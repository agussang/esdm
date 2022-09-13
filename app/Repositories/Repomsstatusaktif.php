<?php
namespace App\Repositories;

use App\Models\MsStatusAktif;
use Illuminate\Support\Facades\DB;

class Repomsstatusaktif extends Repository
{
    protected $model;

    public function __construct(MsStatusAktif $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->orderBy('id','asc')
            ->get();
    }
}