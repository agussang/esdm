<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsabsen;
use Crypt;

class MasterWaktuPresensiController extends Controller
{
    public function __construct(
        Request $request,
        Repomsabsen $repomsabsen  
    ){
        $this->request = $request;
        $this->repomsabsen = $repomsabsen;
    }

    public function index()
    {
        $rsData = $this->repomsabsen->get();
        $data['rsData'] = $rsData;
        return view('content.master.waktu_absen.index',$data);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $jam_masuk = explode(':',$req['jam_masuk']);
        $jam_pulang = explode(':',$req['jam_keluar']);
        $jam = $jam_pulang[0]-$jam_masuk[0];
        $menit = $jam_pulang[1]-$jam_masuk[1];
        $req['lama_kerja'] = sprintf("%02d", $jam).":".sprintf("%02d", $menit);
        $req['status_aktif'] = 0;
        $save = $this->repomsabsen->store($req);
        $notification = [
            'message' => 'Berhasil, Data Master Absen berhasil ditambahkan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.waktu-presensi')->with($notification);
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id = $req['id_waktu_absen'];
        $where['id']= $id;
        $reqnot['status_aktif'] = 0;
        $req['status_aktif'] = 0;
        if($req['status_aktif']=="true"){
            $req['status_aktif'] = 1;
            $rsData = $this->repomsabsen->findId("",$id);
            
            $jam_masuk = explode(':',$rsData->jam_masuk);
            $jam_pulang = explode(':',$rsData->jam_keluar);
            $jam = $jam_pulang[0]-$jam_masuk[0];
            $menit = $jam_pulang[1]-$jam_masuk[1];
            $req['lama_kerja'] = sprintf("%02d", $jam).":".sprintf("%02d", $menit);
        }
        unset($req['id_waktu_absen']);
        $this->repomsabsen->update($where,$req);
        $this->repomsabsen->updatewherenot($id,$reqnot);
        echo '<script type="text/javascript">toastr.success("Data absen berlaku berhasil diubah.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $this->repomsabsen->destroy($id,'');
        $notification = [
            'message' => 'Berhasil, Data Master Absen berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.waktu-presensi')->with($notification);
    }
}
