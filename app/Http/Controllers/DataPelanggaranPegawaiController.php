<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrpelanggaran;
use App\Repositories\RepoMsPelanggaran;
use Fungsi;
use Crypt;
use Session;
class DataPelanggaranPegawaiController extends Controller
{
    public function __construct(
        Request $request,
        Repotrpelanggaran $repotrpelanggaran,
        RepoMsPelanggaran $repomspelanggaran
    ){
        $this->request = $request;
        $this->repotrpelanggaran = $repotrpelanggaran;
        $this->repomspelanggaran = $repomspelanggaran;
    }
    public function index()
    {
        $text_cari = Session::get('text_cari');
        $kategori = Session::get('id_kategori');
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $rsData = $this->repotrpelanggaran->paginate(['dt_pegawai','kategori_pelanggaran']);
        $paging = $rsData->links();
        $totalRecord = $rsData->total();
        $data['rsData'] = $rsData;
        $data['paging'] = $paging;
        $data['totalRecord'] = $totalRecord;
        return view('content.data_pegawai.pelanggaran.index',$data);
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
        return redirect()->route('data-pegawai.pelanggaran.index');
    }
    
    public function create()
    {
        $id_pelanggaran = Session::get('id_pelanggaran');
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm();
        $data['pilihan_pelanggaran'] = Fungsi::pilihan_pelanggaran($id_pelanggaran);
        return view('content.data_pegawai.pelanggaran.tambah',$data);
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repotrpelanggaran->findWhereRaw("","id_sdm = '$req[id_sdm]' and id_kategori_pelanggaran = '$req[id_kategori_pelanggaran]' and tgl_berlaku = '$req[tgl_berlaku]'");
        $file = $request->file('file_surat');
        if($file){
            $tipe = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if ($tipe != 'pdf') {
                $notification = [
                        'message' => 'File harus berformat pdf',
                        'alert-type' => 'error',
                        ];
                return redirect()->route('data-pegawai.pelanggaran.tambah')->with($notification);
            } elseif ($size > 2000000) {
                $notification = [
                        'message' => 'Ukuran File lebih dari 2MB',
                        'alert-type' => 'error',
                        ];
                return redirect()->route('data-pegawai.pelanggaran.tambah')->with($notification);
            }
            unset($req['file_surat']);
            $name = md5($req['id_sdm']);
            $req['file_surat'] = $name.".pdf";
            $destinationPath = 'assets/file_pelanggaran/';
            $file->move($destinationPath, $req['file_surat']);
        }
        $kategori_pelanggaran = $this->repomspelanggaran->findId("",$req['id_kategori_pelanggaran'],'id_pelanggaran');
        $req['tgl_berakhir'] = date('Y-m-d', strtotime('+'.$kategori_pelanggaran->durasi .'months',strtotime(date("Y-m-d",strtotime($req['tgl_berlaku'])))));
        if($cek){
            $where['id_pelanggaran'] = $cek->id_pelanggaran;
            $save = $this->repotrpelanggaran->update($where,$req);
        }else{
            $save = $this->repotrpelanggaran->store($req);
        }
        $notification = [
            'message' => 'Berhasil, Data Pelanggaran Pegawai berhasil disimpan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.pelanggaran.index')->with($notification);
    }

    
    public function show($id)
    {
        
    }

    
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrpelanggaran->findId("",$id,"id_pelanggaran");
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($rsData->id_sdm);
        $data['pilihan_pelanggaran'] = Fungsi::pilihan_pelanggaran($rsData->id_kategori_pelanggaran);
        $data['rsData'] = $rsData;
        return view('content.data_pegawai.pelanggaran.edit',$data);
    }

    
    public function update(Request $request)
    {
        $req = $request->except('_token');
        $file = $request->file('file_surat');
        if($file){
            $tipe = $file->getClientOriginalExtension();
            $size = $file->getSize();
            if ($tipe != 'pdf') {
                $notification = [
                        'message' => 'File harus berformat pdf',
                        'alert-type' => 'error',
                        ];
                return redirect()->intended('/data-pegawai/pelanggaran/edit/'.Crypt::encrypt($req['id_pelanggaran']))->with($notification);
            } elseif ($size > 2000000) {
                $notification = [
                        'message' => 'Ukuran File lebih dari 2MB',
                        'alert-type' => 'error',
                        ];
                return redirect()->intended('/data-pegawai/pelanggaran/edit/'.Crypt::encrypt($req['id_pelanggaran']))->with($notification);
            }
            unset($req['file_surat']);
            $name = md5($req['id_pelanggaran']);
            $req['file_surat'] = $name.".pdf";
            $destinationPath = 'assets/file_pelanggaran/';
            $file->move($destinationPath, $req['file_surat']);
        }
        $kategori_pelanggaran = $this->repomspelanggaran->findId("",$req['id_kategori_pelanggaran'],'id_pelanggaran');
        $req['tgl_berakhir'] = date('Y-m-d', strtotime('+'.$kategori_pelanggaran->durasi .'months',strtotime(date("Y-m-d",strtotime($req['tgl_berlaku'])))));
        $where['id_pelanggaran'] = $req['id_pelanggaran'];
        unset($req['id_pelanggaran']);
        $save = $this->repotrpelanggaran->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data Pelanggaran Pegawai berhasil disimpan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.pelanggaran.index')->with($notification);
    }

    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrpelanggaran->destroy($id,"id_pelanggaran");
        $notification = [
            'message' => 'Berhasil, Data master grade berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.pelanggaran.index')->with($notification);
    }
}
