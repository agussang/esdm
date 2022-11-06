<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrabsenkehadiran;
use App\Repositories\Repomspegawai;
use App\Models\MsAlasanAbsen;
use Session;
use Fungsi;
use Crypt;
use DateTime;


class DataAbsenController extends Controller
{
    public function __construct(
        Request $request,
        Repotrabsenkehadiran $repotrabsenkehadiran,
        Repomspegawai $repomspegawai
    ){
        $this->request = $request;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
        $this->repomspegawai = $repomspegawai;
    }

    public function index()
    {
        $id_sdm = Session::get('id_sdm');
        $tgl_awal = Session::get('tgl_awal');
        $tgl_akhir = Session::get('tgl_akhir');
        $id_alasan = Session::get('id_alasan');
        $id_sdm_atasan = Session::get('id_sdm_atasan');
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($id_sdm,"","",$id_sdm_atasan);
        $data['pilihan_alasan_absen'] = Fungsi::pilihan_alasan_absen($id_alasan);
        $arrIdSdm = array();
        if($id_sdm_atasan){
            $rsPegawai = $this->repomspegawai->getWhereRaw(['nm_satker','nm_golongan','nm_jns_sdm','stat_kepegawaian','nm_jab_struk','nm_jab_fung']," id_stat_aktif = '1' and (id_sdm_atasan = '$id_sdm_atasan' or id_sdm_pendamping = '$id_sdm_atasan') ","nm_sdm");
            foreach($rsPegawai as $rs=>$r){
                $arrIdSdm[$r->id_sdm] = $r->id_sdm;
            }
        }
        $rsData = $this->repotrabsenkehadiran->paginate(['dt_pegawai','alasan'],$id_sdm,$tgl_awal,$tgl_akhir,$id_alasan,$arrIdSdm);
        $paging = $rsData->links();
        $totalRecord = $rsData->total();
        $data['rsData'] = $rsData;
        $data['paging'] = $paging;
        $data['totalRecord'] = $totalRecord;
        return view('content.data_pegawai.presensi.data_absen.index',$data);
    }

    
    public function create()
    {
        $id_sdm_atasan = Session::get('id_sdm_atasan');
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm("","","",$id_sdm_atasan);
        $data['alasan_absen'] = MsAlasanAbsen::whereRaw("id_alasan = '7bd5db1b-ce78-4b5d-93ea-5cc5c20ff580' or id_alasan = '047a6862-b00d-4d58-9b57-d9448e8b5996'")->get();
        return view('content.data_pegawai.presensi.data_absen.tambah',$data);
    }

    public function cari(Request $request){
        $req = $request->except('_token');
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
            $req['id_sdm'] = Session::get('id_sdm');
        }
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        if(Session::get('level')=="P"){
            return redirect()->route('data-presensi.data-absen.index');
        }else{
            return redirect()->route('data-pegawai.data-presensi.data-absen.index');
        }
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')==Session::get('id_sdm')){
            $req['id_sdm'] = Session::get('id_sdm');
        }
        $file = $request->file('file_surat');
        $tipe = $file->getClientOriginalExtension();
        $size = $file->getSize();
        if ($tipe != 'pdf') {
            $notification = [
                    'message' => 'File harus berformat pdf',
                    'alert-type' => 'error',
                    ];
            if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        } elseif ($size > 2000000) {
            $notification = [
                    'message' => 'Ukuran File lebih dari 2MB',
                    'alert-type' => 'error',
                    ];
            if(Session::get('level')=="P"){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        }
        unset($req['file_surat']);
        $name = md5($req['id_sdm']);
        $req['file_bukti'] = $name.".pdf";
        $destinationPath = 'assets/file_bukti_absen/';
        $file->move($destinationPath, $req['file_bukti']);
        $cek = $this->repotrabsenkehadiran->findWhereRaw(""," ( tgl_awal = '$req[tgl_awal]' or tgl_akhir = '$req[tgl_awal]' ) and id_sdm = '$req[id_sdm]' ");
        if($cek){
            $notification = [
                'message' => 'Gagal, Data absen pegawai gagal ditambahkan.',
                'alert-type' => 'error',
            ];
            if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        }else{
            $jmlhabsen = Fungsi::hitung_absen($req['tgl_awal'],$req['tgl_akhir']);
            $req['lama_hari'] = $jmlhabsen['jmabsen'];

            $this->repotrabsenkehadiran->store($req);
            $notification = [
                'message' => 'Berhasil, Data absen pegawai berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        }
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrabsenkehadiran->findId("",$id,"id_absen");
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($rsData->id_sdm);
        $data['pilihan_alasan_absen'] = Fungsi::pilihan_alasan_absen($rsData->id_alasan);
        $data['rsData'] = $rsData;
        return view('content.data_pegawai.presensi.data_absen.edit',$data);
    }

    public function verifikasi($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrabsenkehadiran->findId("",$id,"id_absen");
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($rsData->id_sdm);
        $data['pilihan_verifikasi'] = Fungsi::pilihan_verifikasi();
        $data['pilihan_alasan_absen'] = Fungsi::pilihan_alasan_absen($rsData->id_alasan);
        $data['rsData'] = $rsData;
        return view('content.data_pegawai.presensi.data_absen.verifikasi',$data);
    }

    
    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id_absen = $req['id_absen'];
        $file = $request->file('file_surat');
        if($file){
            $tipe = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $url = url()->previous();
            if ($tipe != 'pdf') {
                $notification = [
                        'message' => 'File harus berformat pdf',
                        'alert-type' => 'error',
                        ];
                if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                    return redirect()->intended('/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }
            } elseif ($size > 2000000) {
                $notification = [
                        'message' => 'Ukuran File lebih dari 2MB',
                        'alert-type' => 'error',
                        ];
                if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                    return redirect()->intended('/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }
            }
            unset($req['file_surat']);
            $name = md5($req['id_sdm']);
            $req['file_bukti'] = $name.".pdf";
            $destinationPath = 'assets/file_bukti_absen/';
            $file->move($destinationPath, $req['file_bukti']);
        }
        $where['id_absen'] = $id_absen;
        $tgl_awal    =new DateTime($req['tgl_awal']);
        $tgl_akhir   =new DateTime($req['tgl_akhir']);
        $jumlahabsen =$tgl_akhir->diff($tgl_awal);
        $req['lama_hari'] = $jumlahabsen->d;
        $this->repotrabsenkehadiran->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil diupdate.',
            'alert-type' => 'success',
        ];
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
            return redirect()->route('data-presensi.data-absen.index')->with($notification);
        }else{
            return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
        }
    }

    public function simpan_verifikasi(Request $request)
    {
        $req = $request->except('_token');
        $id_absen = $req['id_absen'];
        $req['tgl_verifikasi'] = date('Y-m-d H:i:s');
        $where['id_absen'] = $id_absen;
        $this->repotrabsenkehadiran->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil diverifikasi.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
    }

    
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrabsenkehadiran->destroy($id,"id_absen");
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil dihapus.',
            'alert-type' => 'success',
        ];
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
            return redirect()->route('data-presensi.data-absen.index')->with($notification);
        }else{
            return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
        }
    }
}
