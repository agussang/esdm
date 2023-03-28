<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomskedinasan;
use Crypt;
use Fungsi;

class MsKedinasanController extends Controller
{
    public function __construct(
        Request $request,
        Repomskedinasan $repomskedinasan
    ){
        $this->request = $request;
        $this->repomskedinasan = $repomskedinasan;
    }

    public function index()
    {
        $data['rsData'] = $this->repomskedinasan->get();
        return view('content.master.kedinasan.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomskedinasan->findWhereRaw("","nama_kedinasan = '$req[nama_kedinasan]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama tingkat kedinasan yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.kedinasan')->with($notification);
        }else{
            $save = $this->repomskedinasan->store($req);
            $notification = [
                'message' => 'Berhasil, Data master tingkat kedinasan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.kedinasan')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomskedinasan->findId("",$req,"id_kedinasan");
        return view('content.master.kedinasan.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomskedinasan->findWhereRaw("","nama_kedinasan = '$req[nama_kedinasan]' and id_kedinasan <> '$req[id_kedinasan]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data Master Tingkat Kedinasan sudah ada.")</script>';
        }else{
            $where['id_kedinasan'] = $req['id_kedinasan'];
            unset($req['id_kedinasan']);
            $this->repomskedinasan->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master Tingkat Kedinasan berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        $id_kedinasan = Crypt::decrypt($id);
        $hapus = $this->repomskedinasan->destroy($id_kedinasan,"id_kedinasan");
        $notification = [
            'message' => 'Berhasil, Data Master Kedinasan berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.kedinasan')->with($notification);
    }
}
