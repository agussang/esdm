<?php
namespace App\Repositories;

use App\Models\MsStatusKepegawaian;
use Illuminate\Support\Facades\DB;

class Repomsstatuskepegawaian extends Repository
{
    protected $model;

    public function __construct(MsStatusKepegawaian $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->orderBy('kode_lokal','asc')
            ->get();
    }
}
