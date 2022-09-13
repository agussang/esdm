<?php
namespace App\Repositories;

use App\Models\MsPegawaiNew;
use Illuminate\Support\Facades\DB;

class Repomspegawainew extends Repository
{
    protected $model;

    public function __construct(MsPegawaiNew $model)
    {
        $this->model = $model;
    }
}