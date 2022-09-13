<?php
namespace App\Repositories;

use App\Models\MsJnsSdm;
use Illuminate\Support\Facades\DB;

class Repomsjnssdm extends Repository
{
    protected $model;

    public function __construct(MsJnsSdm $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->get();
    }
}