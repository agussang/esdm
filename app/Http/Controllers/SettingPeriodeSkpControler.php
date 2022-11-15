<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsperiodeskp;
use Session;
use Fungsi;

class SettingPeriodeSkpControler extends Controller
{
    public function __construct(
        Request $request,
        Repomsperiodeskp $repomsperiodeskp
    ){
        $this->request = $request;
        $this->repomsperiodeskp = $repomsperiodeskp;
    }

    public function index()
    {
        $tahun = Session::get('tahun');
        if($tahun==null){
            $tahun = date('Y');
        }
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($tahun);
        $data['rsData'] = $this->repomsperiodeskp->get("",$tahun);
        $arrData = array();
        foreach($data['rsData'] as $rs=>$r){
            if($r->tgl_batas_skp==null){
                $bulan = $r->bulan;
                $tahunx = $r->tahun;
                $tglawal = 5;
                $gbng = $tahunx."-".sprintf("%02d",$bulan)."-".sprintf("%02d", $tglawal);
                $tgl = Fungsi::formatDate($gbng);
                $arrData[$tahunx][$bulan] = $gbng;
                $hari = explode(',',$tgl);
                if($hari[0]=='Sabtu'){
                    $gbng2 = $tahunx."-".sprintf("%02d",$bulan)."-".sprintf("%02d", $tglawal+1);
                    $tgl2 = Fungsi::formatDate($gbng2);
                    $arrData[$tahunx][$bulan] = $gbng2;
                    $hari2 = explode(',',$tgl2);
                    if($hari2[0]=='Minggu'){
                        $gbng3 = $tahunx."-".sprintf("%02d",$bulan)."-".sprintf("%02d", $tglawal+2);
                        $arrData[$tahunx][$bulan] = $gbng3;
                    }
                }else if($hari[0]=='Minggu'){
                    $gbng4 = $tahunx."-".sprintf("%02d",$bulan)."-".sprintf("%02d", $tglawal+1);
                    $arrData[$tahunx][$bulan] = $gbng4;
                }
            }
        }
        if(count($arrData)>0){
            foreach($arrData as $thn=>$dtthn){
                foreach($dtthn as $bln=>$tglbln){
                    $where['tahun'] = $thn;
                    $where['bulan'] = $bln;
                    $req['tgl_batas_skp'] = $tglbln;
                    $this->repomsperiodeskp->update($where,$req);
                }
            }
        }
        $data['arrBulan'] = Fungsi::nm_bulan();
        return view('content.skp.setting_periode.index',$data);
    }

    public function update_batas_skp(Request $request){
        $req = $request->except('_token');
        $where['id'] = $req['id'];
        unset($req['id']);
        $this->repomsperiodeskp->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Tanggal Batas Skp berhasil diubah.',
            'alert-type' => 'success',
        ];
        return redirect()->route('skp.setting-skp.index')->with($notification);
    }

    public function update_status(Request $request){
        $req = $request->except('_token');
        $id = $req['id'];
        $where['id']= $id;
        $reqnot['status'] = 0;
        if($req['status']=="true"){
            $req['status'] = 1;
        }
        $this->repomsperiodeskp->update($where,$req);
        $this->repomsperiodeskp->updatewherenot($id,$reqnot);
        echo '<script type="text/javascript">toastr.success("Data Periode Skp Aktif berhasil diubah.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    public function cari(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->route('skp.setting-skp.index');
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
