<?php
namespace App\Repositories;

use App\Models\TrAbsenKehadiran;
use Illuminate\Support\Facades\DB;

class Repotrabsenkehadiran extends Repository
{
    protected $model;

    public function __construct(TrAbsenKehadiran $model)
    {
        $this->model = $model;
    }

    public function paginate($with = null,$id_sdm = null,$tgl_awal = null,$tgl_akhir = null,$id_alasan = null,$arrIdSdm = null)
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->when($tgl_awal, function ($query) use ($tgl_awal,$tgl_akhir) {
                return $query->whereRaw("tgl_awal>='$tgl_awal' and tgl_akhir <='$tgl_akhir' ");
            })->when($id_alasan, function ($query) use ($id_alasan) {
                return $query->where('id_alasan',$id_alasan);
            })->when($arrIdSdm, function ($query) use ($arrIdSdm) {
                return $query->whereIn('id_sdm',$arrIdSdm);
            })->orderBy('created_at','asc')->paginate(25);
    }

    public function getpertahun($with = null, $tahun = null, $id_sdm = null){
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->when($tahun, function ($query) use ($tahun) {
                return $query->whereRaw(" SUBSTRING(CAST(tgl_awal AS VARCHAR(19)), 0, 5) = '$tahun' ");
            })->orderBy('tgl_awal','asc')->get();
    }

    public function get($with = null, $tgl_awal = null,$tgl_akhir = null,$field = "nip")
    {
        return $this->model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })->when($id_sdm, function ($query) use ($id_sdm) {
                return $query->where('id_sdm',$id_sdm);
            })->whereRaw(" tgl_awal BETWEEN '$tgl_awal' AND '$tgl_akhir' OR tgl_akhir BETWEEN '$tgl_akhir' AND '$tgl_akhir'")
            ->orderBy('created_at','asc')->get();
    }
}