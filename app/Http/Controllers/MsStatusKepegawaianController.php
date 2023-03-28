<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsstatuskepegawaian;
use Crypt;
use Fungsi;

class MsStatusKepegawaianController extends Controller
{
    public function __construct(
        Request $request,
        Repomsstatuskepegawaian $repomsstatuskepegawaian
    ){
        $this->request = $request;
        $this->repomsstatuskepegawaian = $repomsstatuskepegawaian;
    }

    public function index()
    {
        $rsData= $this->repomsstatuskepegawaian->get();
        $data['pilihan_penerima_remun'] = Fungsi::pilihan_penerima_remun("");
        $data['rsData'] = $rsData;
        return view('content.master.status_kepegawaian.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsstatuskepegawaian->findWhereRaw("","namastatuspegawai = '$req[namastatuspegawai]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama status kepegawaian yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.status-kepegawaian')->with($notification);
        }else{
            $save = $this->repomsstatuskepegawaian->store($req);
            $notification = [
                'message' => 'Berhasil, Data master status kepegawaian berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.status-kepegawaian')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsstatuskepegawaian->findId("",$req,"id");
        $data['pilihan_penerima_remun'] = Fungsi::pilihan_penerima_remun($data['rsData']->isremun);
        return view('content.master.status_kepegawaian.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsstatuskepegawaian->findWhereRaw("","namastatuspegawai = '$req[namastatuspegawai]' and id <> '$req[id]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data Master status kepegawaian sudah ada.")</script>';
        }else{
            $where['id'] = $req['id'];
            unset($req['id']);
            $this->repomsstatuskepegawaian->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master status kepegawaian berhasil di update")</script>';
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
        $hapus = $this->repomsstatuskepegawaian->destroy($id,"id");
        $notification = [
            'message' => 'Berhasil, Data Master status kepegawaian berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.status-kepegawaian')->with($notification);
    }
}
