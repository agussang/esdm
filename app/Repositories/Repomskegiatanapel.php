<?php
namespace App\Repositories;

use App\Models\MsKegiatanApel;
use Illuminate\Support\Facades\DB;

class Repomskegiatanapel extends Repository
{
    protected $model;

    public function __construct(MsKegiatanApel $model)
    {
        $this->model = $model;
    }

    public function paginate($with = null,$tgl_kegiatan = null,$text = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($tgl_kegiatan, function ($query) use ($tgl_kegiatan) {
                return $query->where('tgl_kegiatan', $tgl_kegiatan);
            })->when($text, function ($query) use ($text) {
                return $query->whereRaw("nama_kegiatan like '%$text%'");
            })
            ->orderBy('tgl_kegiatan','desc')->paginate();
    }
}