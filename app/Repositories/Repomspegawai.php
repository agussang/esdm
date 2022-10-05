<?php
namespace App\Repositories;

use App\Models\MsPegawai;
use Illuminate\Support\Facades\DB;

class Repomspegawai extends Repository
{
    protected $model;

    public function __construct(MsPegawai $model)
    {
        $this->model = $model;
    }

    public function paginate($with = null,$id_stat_aktif = null, $id_stat_kepeg = null, $id_satkernow = null, $id_jns_sdm = null, $nama_pegawai = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_stat_aktif, function ($query) use ($id_stat_aktif) {
                return $query->where('id_stat_aktif', $id_stat_aktif);
            })->when($id_stat_kepeg, function ($query) use ($id_stat_kepeg) {
                return $query->where('id_stat_kepegawaian', $id_stat_kepeg);
            })->when($id_satkernow, function ($query) use ($id_satkernow) {
                return $query->where('id_satkernow', $id_satkernow);
            })->when($id_jns_sdm, function ($query) use ($id_jns_sdm) {
                return $query->where('id_jns_sdm', $id_jns_sdm);
            })->when($nama_pegawai, function ($query) use ($nama_pegawai) {
                return $query->whereRaw(" trim(lower(nm_sdm)) like '%$nama_pegawai%' ");
            })->orderBy('nm_sdm','asc')->paginate(25);
    }

    public function get($with = null,$id_stat_aktif = null,$id_satker = null,$id_sdm = null,$field = 'id_sdm')
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_stat_aktif, function ($query) use ($id_stat_aktif) {
                return $query->where('id_stat_aktif', $id_stat_aktif);
            })->when($id_satker, function ($query) use ($id_satker) {
                return $query->where('id_satkernow', $id_satker);
            })->when($id_sdm, function ($query) use ($id_sdm,$field) {
                return $query->where($field, $id_sdm);
            })->orderBy('nm_sdm','asc')->get();
    }

    public function getskp($with = null,$id_stat_aktif = null,$text_cari = null,$id_sdm_atasan = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_stat_aktif, function ($query) use ($id_stat_aktif) {
                return $query->where('id_stat_aktif', $id_stat_aktif);
            })->when($id_stat_aktif, function ($query) use ($id_stat_aktif) {
                return $query->where('id_stat_aktif', $id_stat_aktif);
            })->when($id_sdm_atasan, function ($query) use ($id_sdm_atasan) {
                 return $query->where('id_sdm_atasan',$id_sdm_atasan);
            })->orderBy('nm_sdm','asc')->get();
    }

    public function first($with = null,$id_sdm){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->where('id_sdm',$id_sdm)->first();
    }

    public function getdata($with = null, $id_stat_aktif = null){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_stat_aktif, function ($query) use ($id_stat_aktif) {
                return $query->where('id_stat_aktif', $id_stat_aktif);
            })->orderBy('nm_sdm','asc')->get();
    }
}