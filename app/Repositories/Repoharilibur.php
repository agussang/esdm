<?php
namespace App\Repositories;

use App\Models\SettingHariLibur;
use Illuminate\Support\Facades\DB;

class Repoharilibur extends Repository
{
    protected $model;

    public function __construct(SettingHariLibur $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->orderBy('tgl_libur','desc')
            ->get();
    }
}
