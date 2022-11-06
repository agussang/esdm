<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reposatuankerja;
use Crypt;
use Fungsi;

class SatuanUnitKerjaController extends Controller
{
    
    public function __construct(
        Request $request,
        Reposatuankerja $reposatuankerja  
    ){
        $this->request = $request;
        $this->reposatuankerja = $reposatuankerja;
    }

    public function index()
    {        
        $rsData = $this->reposatuankerja->get();
        $unitkerja = array();$child = array();
        foreach($rsData as $rs=>$r){
            if($r->id_jns_sms==2){
                $child[$r->id_induk_sms][$r->id_sms]['kode_satker'] = $r->kode_prodi;
                $child[$r->id_induk_sms][$r->id_sms]['nama_satker'] = $r->nm_lemb;
            }
        }foreach($rsData as $rs=>$r){
            if($r->id_jns_sms==1){
                $unitkerja[$r->id_sms]['kode_satker'] = $r->kode_prodi;
                $unitkerja[$r->id_sms]['nama_satker'] = $r->nm_lemb;
                $unitkerja[$r->id_sms]['child'] = $child[$r->id_sms];
            }
        }
        $data['unitkerja'] = $unitkerja;
        $data['child'] = $child;
        return view('content.master.ms_satker.index',$data);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->reposatuankerja->findId("",$req['kode_prodi'],"kode_prodi");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kode Prodi yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.satuan-unit-kerja')->with($notification);
        }else{
            $save = $this->reposatuankerja->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Satuan Unit Kerja berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.satuan-unit-kerja')->with($notification);
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->reposatuankerja->findId("",$req,"id_sms");
        return view('content.master.ms_satker.edit',$data);
    }

    
    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id_sms = $req['id_sms'];
        unset($req['id_sms']);
        $where['id_sms'] = $id_sms;
        $save = $this->reposatuankerja->update_or_create($where,$req);
        echo '<script type="text/javascript">toastr.success("Berhasil, Data Master Satuan Unit Kerja berhasil disimpan.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $this->reposatuankerja->destroy($id,'id_sms');
        $notification = [
            'message' => 'Berhasil, Data Master Satuan Unit Kerja berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.satuan-unit-kerja')->with($notification);
    }
}
