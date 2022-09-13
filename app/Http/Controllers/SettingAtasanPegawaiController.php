<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use Crypt;
use Fungsi;
use Session;

class SettingAtasanPegawaiController extends Controller
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
        $rsData = $this->repomspegawai->get(['nm_atasan_pendamping','nm_atasan','nm_satker','nm_golongan','nm_jns_sdm','stat_kepegawaian','stat_aktif'],"1");
        $data['rsData'] = $rsData;
        return view('content.data_pegawai.setting_atasan.index',$data);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $where['id_sdm'] = $req['id_sdm'];
        $save = $this->repomspegawai->update($where,$req);
        echo '<script type="text/javascript">toastr.success("Setting atasan berhasil dilakukan.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomspegawai->findId(['nm_satker'],$req['id'],"id_sdm");
        $data['pilihan_sdm_atasan'] = Fungsi::pilihan_sdm($data['rsData']->id_sdm_atasan,"",$data['rsData']->id_sdm);
        $data['pilihan_sdm_pendamping'] = Fungsi::pilihan_sdm($data['rsData']->id_sdm_pendamping,"",$data['rsData']->id_sdm);
        return view('content.data_pegawai.setting_atasan.edit',$data);
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
