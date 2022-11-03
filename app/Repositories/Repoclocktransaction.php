<?php
namespace App\Repositories;

use App\Models\Iclocktransaction;
use Illuminate\Support\Facades\DB;

class Repoclocktransaction extends Repository
{
    protected $model;

    public function __construct(Iclocktransaction $model)
    {
        $this->model = $model;
    }

    public function get($with = null)
    {
        return $this->model->selectRaw("distinct SUBSTRING(CAST(punch_time AS VARCHAR(20)), 0, 11) as tgl_absen")
            ->where('csf',null)
            ->orderBy('tgl_absen','asc')
            ->get();
    }

    public function getsyncabsen($tgl_absen,$nip){
        $rsData = $this->model
                ->whereRaw(" SUBSTRING(CAST(punch_time AS VARCHAR(20)), 0, 11) = '$tgl_absen' ")
                ->whereIn('emp_code',$nip)
                ->where('csf',null)
                ->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $tgl_absen = substr($r->punch_time,0,10);
            $jam_absen = substr($r->punch_time,11,8);
            $emp_code = trim($r->emp_code);
            $arrData[$emp_code][$tgl_absen][$jam_absen]['id'] = $r->id;
            $arrData[$emp_code][$tgl_absen][$jam_absen]['emp_code'] = $r->emp_code;
            $arrData[$emp_code][$tgl_absen][$jam_absen]['tanggal_absen'] = $tgl_absen;
            $arrData[$emp_code][$tgl_absen][$jam_absen]['jam_absen'] = $jam_absen;
            $arrData[$emp_code][$tgl_absen][$jam_absen]['sn'] = $r->terminal_sn;
            $arrData[$emp_code][$tgl_absen][$jam_absen]['mesin'] = $r->terminal_alias;
        }
        return $arrData;
    }
}
