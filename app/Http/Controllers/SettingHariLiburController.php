<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repoharilibur;
use Crypt;
use Fungsi;

class SettingHariLiburController extends Controller
{
    public function __construct(
        Request $request,
        Repoharilibur $repoharilibur
    ){
        $this->request = $request;
        $this->repoharilibur = $repoharilibur;
    }

    public function index()
    {
        $data['rsData'] = $this->repoharilibur->get();
        return view('content.master.setting_libur.index',$data);

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repoharilibur->findWhereRaw("","tgl_libur = '$req[tgl_libur]' ");
        if($cek){
            $notification = [
                'message' => 'Gagal, Tanggal Libur yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.hari-libur')->with($notification);
        }else{
            $save = $this->repoharilibur->store($req);
            $notification = [
                'message' => 'Berhasil, Data tanggal libur berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.hari-libur')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repoharilibur->findId("",$req,"id_hari_libur");
        return view('content.master.setting_libur.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repoharilibur->findWhereRaw("","tgl_libur = '$req[tgl_libur]' and id_hari_libur <> '$req[id_hari_libur]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data Master tanggal libur sudah ada.")</script>';
        }else{
            $where['id_hari_libur'] = $req['id_hari_libur'];
            unset($req['id_hari_libur']);
            $this->repoharilibur->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master tanggal libur berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        $id_hari_libur = Crypt::decrypt($id);
        $hapus = $this->repoharilibur->destroy($id_hari_libur,"id_hari_libur");
        $notification = [
            'message' => 'Berhasil, Data master tanggal libur berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.hari-libur')->with($notification);
    }
}
