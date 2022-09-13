<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reporiwayatjabatan;
use App\Repositories\Repomspegawai;
use Fungsi;
use Session;
use Crypt;

class RiwayatJabatanController extends Controller
{
    public function __construct(
        Request $request,
        Reporiwayatjabatan $reporiwayatjabatan,
        Repomspegawai $repomspegawai  
    ){
        $this->request = $request;
        $this->reporiwayatjabatan = $reporiwayatjabatan;
        $this->repomspegawai = $repomspegawai;
    }

    public function index($id_sdm)
    {
        $id_sdm = Crypt::decrypt($id_sdm);

        $data['rsData'] = $this->reporiwayatjabatan->get(['dt_pegawai','nm_jabatan'],$id_sdm);
        $data['profil'] = $this->repomspegawai->findId(['nm_satker'],$id_sdm,"id_sdm");
        $data['pilihan_tipe_jabatan'] = Fungsi::pilihan_tipe_jabatan();
        $data['pilihan_jabatan'] = Fungsi::pilihan_jabatan();
        return view('content.data_pegawai.riwayat.jabatan.index',$data);
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
