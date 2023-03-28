<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsalasanabsen;
use Crypt;

class MasteralasanabsenController extends Controller
{

    public function __construct(
        Request $request,
        Repomsalasanabsen $repoalsanabsen
    ){
        $this->request = $request;
        $this->repoalsanabsen = $repoalsanabsen;
    }
    public function index()
    {
        $rsData = $this->repoalsanabsen->get();
        $data['rsData'] = $rsData;
        return view('content.master.alasan-absen.index',$data);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repoalsanabsen->findId("",$req['kode_lokal'],"kode_lokal");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kode alasan absen yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.alasan-absen.tambah')->with($notification);
        }else{
            $save = $this->repoalsanabsen->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master alasan absen berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.alasan-absen')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repoalsanabsen->findId("",$req,"id_alasan");
        return view('content.master.alasan-absen.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repoalsanabsen->findWhereRaw("","alasan = '$req[alasan]' and id_alasan <> '$req[id_alasan]'");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data master alasan absen yang anda masukkan sudah ada")</script>';
        }else{
            $where['id_alasan'] = $req['id_alasan'];
            unset($req['id_alasan']);
            $this->repoalsanabsen->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data master alasan absen berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }


    public function destroy($id)
    {
        $id_alasan = Crypt::decrypt($id);
        $hapus = $this->repoalsanabsen->destroy($id_alasan,"id_alasan");
        $notification = [
            'message' => 'Berhasil, Data Master alasan absen berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.alasan-absen')->with($notification);
    }
}
