<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsjabatan;
use Crypt;
use Fungsi;
use Session;

class MsJabatanController extends Controller
{
    
    public function __construct(
        Request $request,
        Repomsjabatan $repomsjabatan  
    ){
        $this->request = $request;
        $this->repomsjabatan = $repomsjabatan;
    }

    public function index()
    {
        $tipe_jabatan = Session::get('tipejabatan');
        $cari = strtolower(Session::get('namajabatan'));
        $data['rsData'] = $this->repomsjabatan->get(['ms_grade'],$cari,$tipe_jabatan);
        $data['pilihan_tipe_jabatan'] = Fungsi::pilihan_tipe_jabatan($tipe_jabatan);
        $data['pilihan_grade'] = Fungsi::pilihan_grade();
        $data['arrTipeJabatan'] = Fungsi::arrTipeJabatan();
        return view('content.master.jabatan.index',$data);
    }

    
    public function create()
    {
        $data['pilihan_grade'] = Fungsi::pilihan_grade();
        $data['pilihan_tipe_jabatan'] = Fungsi::pilihan_tipe_jabatan();
        return view('content.master.jabatan.tambah',$data);
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsjabatan->findId("",$req['namajabatan'],"namajabatan");
        if($cek){
            $notification = [
                'message' => 'Gagal, Nama yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.jabatan')->with($notification);
        }else{
            $save = $this->repomsjabatan->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Jabatan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.jabatan')->with($notification);
        }
    }

    public function cari(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->route('data-master.jabatan');
    }
    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data['rsData'] = $this->repomsjabatan->findId(['ms_grade'],$id);
        $data['pilihan_tipe_jabatan'] = Fungsi::pilihan_tipe_jabatan($data['rsData']->tipejabatan);
        $data['pilihan_grade'] = Fungsi::pilihan_grade($data['rsData']->id_grade);
        return view('content.master.jabatan.edit',$data);
    }

    
    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id = $req['id'];
        unset($req['id']);
        $where['id'] = $id;
        $save = $this->repomsjabatan->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data Master jabatan berhasil disimpan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.jabatan')->with($notification);
    }

    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $this->repomsjabatan->destroy($id);
        $notification = [
            'message' => 'Berhasil, Data Master Jabatan berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.jabatan')->with($notification);
    }
}
