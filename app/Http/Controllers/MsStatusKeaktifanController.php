<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsstatusaktif;
use Crypt;
use Fungsi;

class MsStatusKeaktifanController extends Controller
{
    public function __construct(
        Request $request,
        Repomsstatusaktif $repomsstatusaktif
    ){
        $this->request = $request;
        $this->repomsstatusaktif = $repomsstatusaktif;
    }

    public function index()
    {
        $data['rsData'] = $this->repomsstatusaktif->get();
        return view('content.master.status_aktif.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsstatusaktif->findWhereRaw("","namastatusaktif = '$req[namastatusaktif]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama status keaktifan yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.status-aktif')->with($notification);
        }else{
            $save = $this->repomsstatusaktif->store($req);
            $notification = [
                'message' => 'Berhasil, Data master status keaktifan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.status-aktif')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsstatusaktif->findId("",$req,"id");
        return view('content.master.status_aktif.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsstatusaktif->findWhereRaw("","namastatusaktif = '$req[namastatusaktif]' and id <> '$req[id]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data Master status keaktifan sudah ada.")</script>';
        }else{
            $where['id'] = $req['id'];
            unset($req['id']);
            $this->repomsstatusaktif->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master status keaktifan berhasil di update")</script>';
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
        $hapus = $this->repomsstatusaktif->destroy($id,"id");
        $notification = [
            'message' => 'Berhasil, Data Master status keaktifan berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.status-aktif')->with($notification);
    }
}
