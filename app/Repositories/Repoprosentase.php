<?php
namespace App\Repositories;

use App\Models\MsProsentaseRealisasi;
use Illuminate\Support\Facades\DB;

class Repoprosentase extends Repository
{
    protected $model;

    public function __construct(MsProsentaseRealisasi $model)
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
