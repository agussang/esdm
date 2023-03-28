<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspendidikan;
use Crypt;
use Fungsi;

class MsPendidikanController extends Controller
{
    public function __construct(
        Request $request,
        Repomspendidikan $repomspendidikan
    ){
        $this->request = $request;
        $this->repomspendidikan = $repomspendidikan;
    }

    public function index()
    {
        $data['rsData'] = $this->repomspendidikan->get();
        return view('content.master.pendidikan.index',$data);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomspendidikan->findWhereRaw("","namapendidikan = '$req[namapendidikan]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama pendidikan yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.pendidikan')->with($notification);
        }else{
            $save = $this->repomspendidikan->store($req);
            $notification = [
                'message' => 'Berhasil, Data master pendidikan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.pendidikan')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomspendidikan->findId("",$req,"id");
        return view('content.master.pendidikan.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomspendidikan->findWhereRaw("","namapendidikan = '$req[namapendidikan]' and id <> '$req[id]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data kategori pelanggaran sudah ada.")</script>';
        }else{
            $where['id'] = $req['id'];
            unset($req['id']);
            $this->repomspendidikan->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data kategori pelanggaran berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        $id_pendidikan = Crypt::decrypt($id);
        $hapus = $this->repomspendidikan->destroy($id_pendidikan,"id");
        $notification = [
            'message' => 'Berhasil, Data Master Pendidikan berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.pendidikan')->with($notification);
    }
}
