<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repoprosentase;
use Fungsi;
use Crypt;
use Session;

class MasterProsentaseController extends Controller
{
    public function __construct(
        Request $request,
        Repoprosentase $repoprosentase
    ){
        $this->request = $request;
        $this->repoprosentase = $repoprosentase;
    }

    public function index()
    {
        $data['rsData'] = $this->repoprosentase->get("");
        return view('content.master.prosentase.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $req['is_aktif'] = '0';
        $req['id_updater'] = Session::get('id_pengguna');
        $save = $this->repoprosentase->store($req);
        $notification = [
            'message' => 'Berhasil, Data Master Prosentase Realisasi berhasil ditambahkan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.prosentase')->with($notification);
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repoprosentase->findId("",$req,"id_prosentase");
        return view('content.master.prosentase.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $where['id_prosentase'] = $req['id_prosentase'];
        unset($req['id_prosentase']);
        $this->repoprosentase->update($where,$req);
        echo '<script type="text/javascript">toastr.success("Data master prosentase berhasil di update")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";

    }


    public function destroy($id)
    {
        //
    }
}
