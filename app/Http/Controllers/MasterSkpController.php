<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsrubrik;
use App\Repositories\Repomssatuan;
use App\Repositories\Repomsprilaku;
use Session;
use Fungsi;
use Crypt;

class MasterSkpController extends Controller
{

    public function __construct(
        Request $request,
        Repomsrubrik $repomsrubrik,
        Repomssatuan $repomssatuan,
        Repomsprilaku $repomsprilaku   
    ){
        $this->request = $request;
        $this->repomsprilaku = $repomsprilaku;
        $this->repomssatuan = $repomssatuan;
        $this->repomsrubrik = $repomsrubrik;        
    }

    public function prilaku(){
        $rsData = $this->repomsprilaku->get();
        $data['rsData'] = $rsData;
        return view('content.skp.master_skp.ms_prilaku.index',$data);
    }

    public function hapus_prilaku($id){
        $id = Crypt::decrypt($id);
        $this->repomsprilaku->destroy($id);
        // jangan lupa dikasih pengecekan apa sudah dipakai apa belum
        $notification = [
            'message' => 'Berhasil, Data Master Prilaku berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('skp.master-skp.prilaku.index')->with($notification);
    }

    public function simpan_prilaku(Request $request){
        $req = $request->except('_token');
        $cek = $this->repomsprilaku->findId("",$req['nama'],"nama");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama Indikator yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('skp.master-skp.prilaku.index')->with($notification);
        }else{
            $save = $this->repomsprilaku->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Prilaku berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('skp.master-skp.prilaku.index')->with($notification);
        }
    }

    public function edit_prilaku(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsprilaku->findId("",$req,"id");
        return view('content.skp.master_skp.ms_prilaku.edit',$data);
    }

    public function update_prilaku(Request $request){
        $req = $request->except('_token');
        $cek = $this->repomsprilaku->findWhereRaw("","nama = '$req[nama]' and id <> '$req[id]'");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Gagal, Nama Indikator yang anda masukkan sudah ada.")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }else{
            $where['id'] = $req['id'];
            if($req['status']){
                if($req['status']=="true"){
                    $req['status'] = 1;
                }else{
                    $req['status'] = 0;
                }
            }
            $this->repomsprilaku->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master Prilaku berhasil diupdate")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }



    public function satuan(){
        $rsData = $this->repomssatuan->get();
        $data['rsData'] = $rsData;
        return view('content.skp.master_skp.ms_satuan.index',$data);
    }

    public function hapus_satuan($id){
        $id = Crypt::decrypt($id);
        $this->repomssatuan->destroy($id);
        // jangan lupa dikasih pengecekan apa sudah dipakai apa belum
        $notification = [
            'message' => 'Berhasil, Data Master Prilaku berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('skp.master-skp.satuan')->with($notification);
    }

    public function simpan_satuan(Request $request){
        $req = $request->except('_token');
        $cek = $this->repomssatuan->findId("",$req['nama'],"nama");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama Satuan yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('skp.master-skp.satuan')->with($notification);
        }else{
            $save = $this->repomssatuan->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Satuan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('skp.master-skp.satuan')->with($notification);
        }
    }

    public function edit_satuan(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomssatuan->findId("",$req,"id");
        return view('content.skp.master_skp.ms_satuan.edit',$data);
    }

    public function update_satuan(Request $request){
        $req = $request->except('_token');
        $cek = $this->repomssatuan->findWhereRaw("","nama = '$req[nama]' and id <> '$req[id]'");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Gagal, Nama Satuan yang anda masukkan sudah ada.")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }else{
            $where['id'] = $req['id'];
            if($req['status']){
                if($req['status']=="true"){
                    $req['status'] = 1;
                }else{
                    $req['status'] = 0;
                }
            }
            $this->repomssatuan->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data Master Satuan berhasil diupdate")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }



    public function rubrik(){
        $rsData = $this->repomsrubrik->get(['nm_satuan'],"");
        $arrData = array();$child=array();$child3=array();$child4=array();
        foreach($rsData as $rs=>$r){
            if($r->level==3){
                $child4[$r->idparent][$r->id]['kode'] = $r->kode;
                $child4[$r->idparent][$r->id]['nama'] = $r->nama;
                $child4[$r->idparent][$r->id]['satuan'] = $r->nm_satuan->nama;
                $child4[$r->idparent][$r->id]['point'] = $r->poin;
            }
        }

        foreach($rsData as $rs=>$r){
            if($r->level==3){
                $child3[$r->idparent][$r->id]['kode'] = $r->kode;
                $child3[$r->idparent][$r->id]['nama'] = $r->nama;
                $child3[$r->idparent][$r->id]['satuan'] = $r->nm_satuan->nama;
                $child3[$r->idparent][$r->id]['point'] = $r->poin;
                $child3[$r->idparent][$r->id]['child'] = $child4[$r->id];
            }
        }

        foreach($rsData as $rs=>$r){
            if($r->level==2){
                $child[$r->idparent][$r->id]['kode'] = $r->kode;
                $child[$r->idparent][$r->id]['nama'] = $r->nama;
                $child[$r->idparent][$r->id]['satuan'] = $r->nm_satuan->nama;
                $child[$r->idparent][$r->id]['point'] = $r->poin;
                $child[$r->idparent][$r->id]['child'] = $child3[$r->id];
            }
        }

        foreach($rsData as $rs=>$r){
            if($r->level==1){
                $arrData[$r->id]['kode'] = $r->kode;
                $arrData[$r->id]['nama'] = $r->nama;
                $arrData[$r->id]['urutan'] = $r->urutan;
                $arrData[$r->id]['child'] = $child[$r->id];
            }
        }
        $data['rsData'] = $arrData;
        $data['arrhuruf'] = Fungsi::arrhuruf();
        $data['pilihan_satuan_rubrik'] = Fungsi::pilihan_satuan_rubrik();
        return view('content.skp.master_skp.ms_rubrik.index',$data);
    }


    public function simpan_rubrik(Request $request){
        $req = $request->except('_token');
        $cek = $this->repomsrubrik->findWhereRaw("","nama = '$req[nama]' and idparent = '$req[idparent]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama Rubrik yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('skp.master-skp.rubrik')->with($notification);
        }else{
            if($req['level']==1){
                $req['level'] = 1;
                $req['urutan'] = count($this->repomsrubrik->get("",1,""))+1;
            }else if($req['level']==2){
                $req['level'] = 2;
                $req['urutan'] = count($this->repomsrubrik->get("",2,$req['idparent']))+1;
            }else if($req['level']==3){
                $req['level'] = 3;
                $req['urutan'] = count($this->repomsrubrik->get("",3,$req['idparent']))+1;
            }
            $req['status'] = 1;
            $req['isdosen'] = 1;
            $this->repomsrubrik->store($req);
            $notification = [
                'message' => 'Berhasil, Data master rubrik berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('skp.master-skp.rubrik')->with($notification);
        }
    }

    public function hapus_rubrik($id){
        $rsData = $this->repomsrubrik->destroy($id,"id");
        $rsData = $this->repomsrubrik->destroy($id,"idparent");
        $notification = [
            'message' => 'Berhasil, Data master rubrik skp berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('skp.master-skp.rubrik')->with($notification);
    }

    public function edit_rubrik(Request $request){
        $req = $request->except('_token');
        $rsData = $this->repomsrubrik->findId("",$req['id'],"id");
        $data['rsData'] = $rsData;
        $data['pilihan_satuan_rubrik'] = Fungsi::pilihan_satuan_rubrik($rsData->idsatuan);
        return view('content.skp.master_skp.ms_rubrik.edit',$data);
    }

    public function update_rubrik(Request $request){
        $req = $request->except('_token');
        $cek = $this->repomsrubrik->findWhereRaw("","nama like '%$req[nama]%' and id <> '$req[id]'");
        if($cek){
            echo '<script type="text/javascript">toastr.error("Gagal, Nama Rubrik yang anda masukkan sudah ada.")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }else{
            $where['id'] = $req['id'];
            unset($req['id']);
            $this->repomsrubrik->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Berhasil, Nama Rubrik yang anda masukkan telah diupdate.")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }
    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
