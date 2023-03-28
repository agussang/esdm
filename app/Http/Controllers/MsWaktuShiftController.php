<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomswaktushift;

class MsWaktuShiftController extends Controller
{
    public function __construct(
        Request $request,
        Repomswaktushift $repomswaktushift
    ){
        $this->request = $request;
        $this->repomswaktushift = $repomswaktushift;
    }

    public function index()
    {
        $data['rsData'] = $this->repomswaktushift->get();
        return view('content.master.waktu-shift.index',$data);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomswaktushift->findWhereRaw("","kode_shift = '$req[kode_shift]' or nm_shift = '$req[nm_shift]' ");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kode Shift atau Nama Shift yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.waktu-shift')->with($notification);
        }else{
            $save = $this->repomswaktushift->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master waktu shift berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.waktu-shift')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomswaktushift->findId("",$req,"id");
        return view('content.master.waktu-shift.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomswaktushift->findWhereRaw("","(kode_shift = '$req[kode_shift]' or nm_shift = '$req[nm_shift]') and id != '$req[id]'");
        if($cek){
            echo '<script type="text/javascript">toastr.success("Data master presensi shift yang anda masukkan sudah ada.")</script>';
        }else{
            $where['id'] = $req['id'];
            unset($req['id']);
            $update = $this->repomswaktushift->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data master presensi shift berhasil diubah.")</script>';
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
