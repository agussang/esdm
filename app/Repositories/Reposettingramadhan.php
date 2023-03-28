<?php
namespace App\Repositories;

use App\Models\SettingRamadhan;
use Illuminate\Support\Facades\DB;

class Reposettingramadhan extends Repository
{
    protected $model;

    public function __construct(SettingRamadhan $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$tahun = null)
    {
        return $this->model->orderBy('tgl_ramadhan','desc')
            ->get();
    }
}
