<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repobank;

class MasterBankController extends Controller
{
    public function __construct(
        Request $request,
        Repobank $repobank
    ){
        $this->request = $request;
        $this->repobank = $repobank;
    }

    public function index()
    {
        $rsData = $this->repobank->get();
        $data['rsData'] = $rsData;
        return view('content.master.bank.index',$data);
    }


    public function create()
    {
        return view('content.master.bank.tambah');
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repobank->findId("",$req['kode_bank'],"kode_bank");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kode Bank yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.bank.tambah')->with($notification);
        }else{
            $save = $this->repobank->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Bank berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.bank')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repobank->findId("",$req,"id_bank");
        return view('content.master.bank.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repobank->findWhereRaw("","nama_bank = '$req[nama_bank]' and id_bank <> '$req[id_bank]'");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data master bank yang anda masukkan sudah ada")</script>';
        }else{
            $where['id_bank'] = $req['id_bank'];
            unset($req['id_bank']);
            $this->repobank->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data master bank berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {

    }
}
