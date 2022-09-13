<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpangkat;
use App\Repositories\Repomspegawai;
use Fungsi;
use Session;
use Crypt;

class RiwayatPangkatController extends Controller
{
    public function __construct(
        Request $request,
        Reporiwayatpangkat $reporiwayatpangkat,
        Repomspegawai $repomspegawai  
    ){
        $this->request = $request;
        $this->reporiwayatpangkat = $reporiwayatpangkat;
        $this->repomspegawai = $repomspegawai;
    }
    
    public function index($id_sdm)
    {
        $id_sdm = Crypt::decrypt($id_sdm);

        $data['rsData'] = $this->reporiwayatpangkat->get(['dt_pegawai','nm_jabatan'],$id_sdm);
        $data['profil'] = $this->repomspegawai->findId(['nm_satker'],$id_sdm,"id_sdm");
        $data['pilihan_golongan'] = Fungsi::pilihan_golongan();
        return view('content.data_pegawai.riwayat.pangkat.index',$data);
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
