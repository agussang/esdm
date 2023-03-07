<?php
namespace App\Repositories;

use App\Models\PresensiApel;
use Illuminate\Support\Facades\DB;

class Repopresensiapel extends Repository
{
    protected $model;

    public function __construct(PresensiApel $model)
    {
        $this->model = $model;
    }

    public function get($with = null,$id_kegiatan=null,$id_sdm=null,$tahun=null,$bulan=null,$id_stat_aktif = 1)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_kegiatan, function ($query) use ($id_kegiatan) {
                return $query->where('id_kegiatan',$id_kegiatan);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->when($tahun, function ($query) use ($tahun) {
                $query->whereHas('nm_kegiatan_apel', function ($query) use ($tahun) {
                    return $query->whereRaw(" SUBSTRING(CAST(tgl_kegiatan AS VARCHAR(19)), 0, 5) = '$tahun' ");
                });
            })->when($bulan, function ($query) use ($bulan) {
                $query->whereHas('nm_kegiatan_apel', function ($query) use ($bulan) {
                    return $query->whereRaw(" SUBSTRING(CAST(tgl_kegiatan AS VARCHAR(19)), 6, 2) = '$bulan' ");
                });
            })->when($id_stat_aktif, function ($query) use ($id_stat_aktif) {
                $query->whereHas('dt_pegawai', function ($query) use ($id_stat_aktif) {
                    return $query->where('id_stat_aktif',$id_stat_aktif);
                });
            })
            ->get();
    }


}
