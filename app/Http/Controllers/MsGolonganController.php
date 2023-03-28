<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsgolongan;
use Crypt;
use Fungsi;

class MsGolonganController extends Controller
{
    public function __construct(
        Request $request,
        Repomsgolongan $repomsgolongan
    ){
        $this->request = $request;
        $this->repomsgolongan = $repomsgolongan;
    }

    public function index()
    {
        $data['rsData'] = $this->repomsgolongan->get();
        return view('content.master.golongan.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsgolongan->findWhereRaw("","nama_golongan = '$req[nama_golongan]' or kode_golongan = '$req[kode_golongan]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama golongan / Kode Golongan yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.golongan')->with($notification);
        }else{
            $save = $this->repomsgolongan->store($req);
            $notification = [
                'message' => 'Berhasil, Data master Golongan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.golongan')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsgolongan->findId("",$req,"id_golongan");
        return view('content.master.golongan.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsgolongan->findWhereRaw("","nama_golongan = '$req[nama_golongan]' and id_golongan <> '$req[id_golongan]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data Master Golongan sudah ada.")</script>';
        }else{
            $where['id_golongan'] = $req['id_golongan'];
            unset($req['id_golongan']);
            $this->repomsgolongan->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master Golongan berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        $id_golongan = Crypt::decrypt($id);
        $hapus = $this->repomsgolongan->destroy($id_golongan,"id_golongan");
        $notification = [
            'message' => 'Berhasil, Data Master Golongan berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.golongan')->with($notification);
    }
}
