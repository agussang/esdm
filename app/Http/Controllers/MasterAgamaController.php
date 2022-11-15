<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsAgama;
use App\Repositories\Repoagama;
use DB;
class MasterAgamaController extends Controller
{
    public function __construct(
        Request $request,
        Repoagama $repoagama
    ){
        $this->request = $request;
        $this->repoagama = $repoagama;
    }

    public function index()
    {
        $data['rsData'] = MsAgama::orderBy('idagama','asc')->get();
        return view('content.master.agama.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repoagama->findId("",$req['idagama'],"idagama");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kode agama yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.agama.tambah')->with($notification);
        }else{
            $save = $this->repoagama->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master agama berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.agama')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repoagama->findId("",$req,"id");
        return view('content.master.agama.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repoagama->findWhereRaw("","namaagama = '$req[namaagama]' and id <> '$req[id]'");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data agama yang anda masukkan sudah ada")</script>';
        }else{
            $where['id'] = $req['id'];
            unset($req['id']);
            $this->repoagama->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data agama berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        //
    }
}
