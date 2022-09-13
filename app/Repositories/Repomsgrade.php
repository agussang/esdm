<?php
namespace App\Repositories;

use App\Models\MsGrade;
use Illuminate\Support\Facades\DB;

class Repomsgrade extends Repository
{
    protected $model;

    public function __construct(MsGrade $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('jobscore','desc')
            ->get();
    }
}