<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsjnssdm;
use     Crypt;

class MsJnsSdmController extends Controller
{
    public function __construct(
        Request $request,
        Repomsjnssdm $repomsjnssdm
    ){
        $this->request = $request;
        $this->repomsjnssdm = $repomsjnssdm;
    }

    public function index()
    {
        $data['rsData'] = $this->repomsjnssdm->get();
        return view('content.master.jns_sdm.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsjnssdm->findWhereRaw("","nm_jns_sdm = '$req[nm_jns_sdm]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama jenis sdm yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.jenis-sdm')->with($notification);
        }else{
            $save = $this->repomsjnssdm->store($req);
            $notification = [
                'message' => 'Berhasil, Data master jenis sdm berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.jenis-sdm')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsjnssdm->findId("",$req,"id_jns_sdm");
        return view('content.master.jns_sdm.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsjnssdm->findWhereRaw("","nm_jns_sdm = '$req[nm_jns_sdm]' and id_jns_sdm <> '$req[id_jns_sdm]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data Master jenis sdm sudah ada.")</script>';
        }else{
            $where['id_jns_sdm'] = $req['id_jns_sdm'];
            unset($req['id_jns_sdm']);
            $this->repomsjnssdm->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master jenis sdm berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $hapus = $this->repomsjnssdm->destroy($id,"id_jns_sdm");
        $notification = [
            'message' => 'Berhasil, Data Master jenis sdm berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.jenis-sdm')->with($notification);
    }
}
