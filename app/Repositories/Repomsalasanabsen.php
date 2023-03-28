<?php
namespace App\Repositories;

use App\Models\MsAlasanAbsen;
use Illuminate\Support\Facades\DB;

class Repomsalasanabsen extends Repository
{
    protected $model;

    public function __construct(MsAlasanAbsen $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('alasan','asc')
            ->get();
    }
}
