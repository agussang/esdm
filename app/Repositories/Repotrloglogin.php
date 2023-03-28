<?php
namespace App\Repositories;

use App\Models\TrLogLogin;
use Illuminate\Support\Facades\DB;

class Repotrloglogin extends Repository
{
    protected $model;

    public function __construct(TrLogLogin $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$tgl1 = null,$tgl2 = null)
    {
        return $this->model->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($tgl1, function ($query) use ($tgl1,$tgl2) {
                return $query->whereRaw(" substr(tgl_login::text,0,11) >= '$tgl1' and substr(tgl_login::text,0,11) <= '$tgl2' ");
            })
            ->orderBy('tgl_login','asc')
            ->get();
    }
}
