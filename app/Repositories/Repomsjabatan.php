<?php
namespace App\Repositories;

use App\Models\MsJabatan;
use Illuminate\Support\Facades\DB;

class Repomsjabatan extends Repository
{
    protected $model;

    public function __construct(MsJabatan $model)
    {
        $this->model = $model;
    }

    public function get($with = null, $cari = null,$tipe_jabatan = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($tipe_jabatan, function ($query) use ($tipe_jabatan) {
                return $query->where('tipejabatan', $tipe_jabatan);
            })->when($cari, function ($query) use ($cari) {
                return $query->whereRaw("LOWER(namajabatan) like '%$cari%'");
            })
            ->orderBy('namajabatan','asc')
            ->get();
    }
}