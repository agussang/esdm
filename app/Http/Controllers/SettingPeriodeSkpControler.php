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
        $data['arrBulan'] = Fungsi::nm_bulan();
        return view('content.skp.setting_periode.index',$data);
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
