<?php
namespace App\Repositories;

use App\Models\MsAbsen;
use Illuminate\Support\Facades\DB;

class Repomsabsen extends Repository
{
    protected $model;

    public function __construct(MsAbsen $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('status_aktif','desc')
            ->get();
    }
}