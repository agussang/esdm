<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use Session;
use Fungsi;

class IndexController extends Controller
{
    public function __construct(
        Request $request,
        Repomspegawai $repomspegawai
    ){
        $this->request = $request;
        $this->repomspegawai = $repomspegawai;
    }
    
    public function index()
    {
        if(Session::get('level')=="P"){
            return view('content.hal_pegawai.home');
        }else{
            $jns_kelamin = Fungsi::arrjenis_kelamin();
            $rsData = $this->repomspegawai->getdata(['nm_golongan','nm_pendidikan'],1);
            foreach($rsData as $rs=>$r){
                $jk = $jns_kelamin[$r->jk];
                $data['arrData'][$jk][$r->nm_golongan->kode_golongan][$r->id_sdm] = $r->id_sdm;
                $nm_golongan = $r->nm_golongan->nama_golongan." ( ".$r->nm_golongan->kode_golongan." ) ";
                $data['jm_by_golongan'][$r->nm_golongan->kode_golongan]['nm_golongan'] = $nm_golongan;
                $data['jm_by_golongan'][$r->nm_golongan->kode_golongan]['dt_golongan'][$jk][$r->id_sdm] = $r->id_sdm;
                $data['nm_golongan'][$r->nm_golongan->kode_golongan] = $r->nm_golongan->kode_golongan;
                $data['dtjmpegawaijk'][$jk][$r->id_sdm] = $r->id_sdm;
                $data['jm_pergolongan'][$r->nm_golongan->kode_golongan]+=1;
                if($arrPendidikan[$r->id_pendidikan_terakhir]){
                    $data['arrPendidikan'][$arrPendidikan[$r->id_pendidikan_terakhir]] = $arrPendidikan[$r->id_pendidikan_terakhir];
                }
                $data['arrpendidikan'][$r->nm_pendidikan->urutan][$r->nm_pendidikan->namapendidikan] = $r->nm_pendidikan->namapendidikan;
                $data['jm_by_pendidikan'][$jk][$r->nm_pendidikan->namapendidikan][$r->id_sdm] = $r->id_sdm;
                $data['jm_perpendidikan'][$r->nm_pendidikan->namapendidikan]+=1;
            }
            ksort($data['jm_by_pendidikan']);
            return view('content.home',$data);
        }
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

    
    public function edit($id)
    {
        //
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
