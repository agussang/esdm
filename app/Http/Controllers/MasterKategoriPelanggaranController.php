<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RepoMsPelanggaran;
use Fungsi;
use Crypt;


class MasterKategoriPelanggaranController extends Controller
{
    public function __construct(
        Request $request,
        RepoMsPelanggaran $repomspelanggaran
    ){
        $this->request = $request;
        $this->repomspelanggaran = $repomspelanggaran;
    }

    public function index()
    {
        $data['list_bulan'] = Fungsi::list_bulan("");
        $data['ket_berlaku'] = Fungsi::ket_berlaku();
        $data['rsData'] = $this->repomspelanggaran->get();
        return view('content.master.pelanggaran.index',$data);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomspelanggaran->findWhereRaw("","nama_pelanggaran = '$req[nama_pelanggaran]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama kategori yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.kategori-pelanggaran')->with($notification);
        }else{

            $save = $this->repomspelanggaran->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Kategori Pelanggaran berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.kategori-pelanggaran')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomspelanggaran->findId("",$req['id'],"id_pelanggaran");
        $data['list_bulan'] = Fungsi::list_bulan($data['rsData']->durasi);
        return view('content.master.pelanggaran.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomspelanggaran->findWhereRaw("","nama_pelanggaran = '$req[nama_pelanggaran]' and id_pelanggaran <> '$req[id_pelanggaran]' ");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Data kategori pelanggaran sudah ada.")</script>';
        }else{
            $where['id_pelanggaran'] = $req['id_pelanggaran'];
            unset($req['id_pelanggaran']);
            $this->repomspelanggaran->update($where,$req);
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
        $id_pelanggaran = Crypt::decrypt($id);
        $hapus = $this->repomspelanggaran->destroy($id_pelanggaran,"id_pelanggaran");
        $notification = [
            'message' => 'Berhasil, Data Master Kategori Pelanggaran berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.kategori-pelanggaran')->with($notification);
    }
}
