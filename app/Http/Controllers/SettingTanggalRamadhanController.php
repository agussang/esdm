<?php

namespace App\Http\Controllers;
use App\Repositories\Reposettingramadhan;

use Illuminate\Http\Request;
use Session;
use Fungsi;
use Crypt;

class SettingTanggalRamadhanController extends Controller
{
    public function __construct(
        Request $request,
        Reposettingramadhan $reposettingramadhan
    ){
        $this->request = $request;
        $this->reposettingramadhan = $reposettingramadhan;
    }

    public function index()
    {
        $tahun = Session::get('tahun');
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['rsData'] = $this->reposettingramadhan->get('',$tahun);
        return view('content.master.setting_ramadhan.index',$data);
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
        $tahun = Session::get('tahun');
        $tgl1 = Session::get('tgl1');
        if($tgl1==null){
            $tgl1 = date('Y-m-d');
        }
        $tgl2 = Session::get('tgl2');
        if($tgl2==null){
            $tgl2 = date('Y-m-d');
        }
        $data['tgl1'] = date('m/d/Y',strtotime($tgl1));
        $data['tgl2'] = date('m/d/Y',strtotime($tgl2));
        return view('content.master.setting_ramadhan.tambah',$data);
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->reposettingramadhan->findId("",$req['idagama'],"idagama");
        if($cek){
            $notification = [
                'message' => 'Gagal, Setting Tanggal Ramadhan sudah ada jika ada perubahan data silahkan melakukan editing data yang ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.tanggal-ramadhan.tambah')->with($notification);
        }else{
            $date = str_replace(' ','',$req['daterange']);
            $date = explode('-',$date);
            $tgl1 = date('Y-m-d',strtotime($date[0]));
            $tgl2 = date('Y-m-d',strtotime($date[1]));
            unset($req['daterange']);
            $req['tgl_ramadhan'] = $tgl1;
            $req['tgl_ramadhan_akhir'] = $tgl2;
            $req['tahun']  = date('Y',strtotime($tgl1));
            $save = $this->reposettingramadhan->store($req);
            $notification = [
                'message' => 'Berhasil, Data Setting tanggal ramadhan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.tanggal-ramadhan')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data['rsData'] = $this->reposettingramadhan->findId("",$id,"id_setting");
        $data['tgl1'] = date('m/d/Y',strtotime($data['rsData']->tgl_ramadhan));
        $data['tgl2'] = date('m/d/Y',strtotime($data['rsData']->tgl_ramadhan_akhir));
        return view('content.master.setting_ramadhan.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $date = str_replace(' ','',$req['daterange']);
        $date = explode('-',$date);
        $tgl1 = date('Y-m-d',strtotime($date[0]));
        $tgl2 = date('Y-m-d',strtotime($date[1]));
        $tahun = date('Y',strtotime($date[0]));

        $cek = $this->reposettingramadhan->findWhereRaw("","tahun != '$tahun'","");

        if($cek){
            $notification = [
                'message' => 'Gagal, Setting Tanggal Ramadhan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->intended('/data-master/tanggal-ramadhan/edit/'.Crypt::encrypt($req['id_setting']))->with($notification);
        }else{
            $date = str_replace(' ','',$req['daterange']);
            $date = explode('-',$date);
            $tgl1 = date('Y-m-d',strtotime($date[0]));
            $tgl2 = date('Y-m-d',strtotime($date[1]));
            unset($req['daterange']);
            $req['tgl_ramadhan'] = $tgl1;
            $req['tgl_ramadhan_akhir'] = $tgl2;
            $req['tahun']  = date('Y',strtotime($tgl1));
            $where['id_setting'] = $req['id_setting'];
            unset($req['id_setting']);
            $save = $this->reposettingramadhan->update($where,$req);
            $notification = [
                'message' => 'Berhasil, Data Setting tanggal ramadhan berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.tanggal-ramadhan')->with($notification);
        }
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->reposettingramadhan->destroy($id,"id_setting");
        $notification = [
            'message' => 'Berhasil, Data master setting tanggal ramadhan berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.tanggal-ramadhan')->with($notification);
    }
}
