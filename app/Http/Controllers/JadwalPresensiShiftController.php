<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use App\Repositories\Repotrjadwalshift;
use App\Repositories\Repomswaktushift;
use Crypt;
use Fungsi;
use Session;
use Excel;


class JadwalPresensiShiftController extends Controller
{
    public function __construct(
        Request $request,
        Repomspegawai $repomspegawai,
        Repomswaktushift $repomswaktushift,
        Repotrjadwalshift $repotrjadwalshift
    ){
        $this->request = $request;
        $this->repomspegawai = $repomspegawai;
        $this->repomswaktushift = $repomswaktushift;
        $this->repotrjadwalshift = $repotrjadwalshift;
    }

    public function index()
    {
        $tgl1 = Session::get('tgl1');
        if($tgl1==null){
            $tgl1 = date('Y-m-d');
        }
        $tgl2 = Session::get('tgl2');
        if($tgl2==null){
            $tgl2 = date('Y-m-d');
        }
        $data['tgl1'] = date('m/d/Y',strtotime($tgl1));
        $data['tgl2'] = date('m/d/Y',strtotime($tgl2));
        $data['rsData'] = $this->repotrjadwalshift->get(['dt_pegawai','dtwaktuabsen'],$tgl1,$tgl2);
        return view('content.data_pegawai.presensi.data_presensi_shift.index',$data);
    }

    public function cari(Request $request){
        $req = $request->except('_token');
        $date = str_replace(' ','',$req['daterange']);
        $date = explode('-',$date);
        $tgl1 = date('Y-m-d',strtotime($date[0]));
        $tgl2 = date('Y-m-d',strtotime($date[1]));
        $request->session()->put('tgl1',$tgl1);
        $request->session()->put('tgl2',$tgl2);
        return redirect()->route('data-pegawai.data-presensi.jadwal-presensi-shift.index');
    }

    public function import(Request $request){
        return view('content.data_pegawai.presensi.data_presensi_shift.form-unggah');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repotrjadwalshift->findId("",$req,"id_jadwal_shift");
        return view('content.master.bank.edit',$data);
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
