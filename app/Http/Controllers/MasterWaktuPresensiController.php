<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsabsen;
use Crypt;
use Fungsi;

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
        $arrData = array();
        $kategoriwaktuabsen = Fungsi::kategoriwaktuabsen();
        $ketramahadhan = array();
        foreach($rsData as $rs=>$r){
            $ketramahadhan[$r->id_khusus] = $r->keterangan;
            $arrData[$r->id_khusus][$r->hari_biasa][$r->id]['ket'] = $kategoriwaktuabsen[$r->hari_biasa];
            $arrData[$r->id_khusus][$r->hari_biasa][$r->id]['jam_masuk'] = $r->jam_masuk;
            $arrData[$r->id_khusus][$r->hari_biasa][$r->id]['jam_keluar'] = $r->jam_keluar;
            $arrData[$r->id_khusus][$r->hari_biasa][$r->id]['masuk_telat'] = $r->masuk_telat;
            $arrData[$r->id_khusus][$r->hari_biasa][$r->id]['pulang_telat'] = $r->pulang_telat;
            $arrData[$r->id_khusus][$r->hari_biasa][$r->id]['lama_kerja'] = $r->lama_kerja;
        }
        $data['ketramahadhan'] = $ketramahadhan;
        $data['arrData'] = $arrData;
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


    public function edit(Request $request)
    {
        $kategoriwaktuabsen = Fungsi::kategoriwaktuabsen();
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsabsen->findId("",$req,"id");
        $data['kategoriwaktuabsen'] = $kategoriwaktuabsen;
        return view('content.master.waktu_absen.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id = $req['id_waktu_absen'];
        $where['id']= $id;
        $req['status_aktif'] = 1;
        $rsData = $this->repomsabsen->findId("",$id);

        $jam_masuk = explode(':',$req['jam_masuk']);
        $jam_pulang = explode(':',$req['jam_keluar']);
        if(count($jam_masuk)=="2"){
            $req['jam_masuk'] = $jam_masuk[0].":".$jam_masuk[1].":"."00";
        }
        if(count($jam_pulang)=="2"){
            $req['jam_keluar'] = $jam_pulang[0].":".$jam_pulang[1].":"."00";
        }
        $durasikerja = Fungsi::durasikerja($req['jam_masuk'],$req['jam_keluar']);
        $durasijamkerja = explode(':',$durasikerja);
        if(count($durasijamkerja)=="2"){
            $durasikerja = $durasijamkerja[0].":".$durasijamkerja[1].":"."00";
        }
        $req['lama_kerja'] = $durasikerja;
        unset($req['id_waktu_absen']);
        $this->repomsabsen->update($where,$req);
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
