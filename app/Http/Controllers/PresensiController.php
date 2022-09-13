<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repomspegawai;
use Crypt;
use Fungsi;
use Session;
use Excel;
use App\Imports\RiwayatPresensiImport;

class PresensiController extends Controller
{
    public function __construct(
        Request $request,
        Reporiwayatpresensi $reporiwayatpresensi,
        Repomspegawai $repomspegawai
    ){
        $this->request = $request;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawai = $repomspegawai;
    }

    public function index()
    {
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm();
        $data['pilihan_mesin_finger'] = Fungsi::pilihan_mesin_finger();
        return view('content.data_pegawai.presensi.upload_presensi.index',$data);
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $masuk['id_sdm'] = $req['id_sdm'];
        $masuk['mesin'] = $req['mesin'];
        $masuk['tanggal_absen'] = $req['tgl_absen'];
        $masuk['jam_absen'] = $req['jam_absen'];
        $masuk['tanggal_scan'] = date('d-m-Y H:i:s');
        $this->reporiwayatpresensi->store($masuk);
        $pulang['id_sdm'] = $req['id_sdm'];
        $pulang['mesin'] = $req['mesin'];
        $pulang['tanggal_absen'] = $req['tgl_absen'];
        $pulang['jam_absen'] = $req['jam_absen_pulang'];
        $pulang['tanggal_scan'] = date('d-m-Y H:i:s');
        $this->reporiwayatpresensi->store($pulang);
        $notification = [
            'message' => 'Berhasil, Presensi manual berhasil dilakukan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.data-presensi.upload-presensi.index')->with($notification);
    }

    public function upload(Request $request){
        try {
            $file = request()->file('file_excel');
            $extension = $request->file('file_excel')->extension();
            if($extension!="xlsx"){
                $notification = [
                    'message' => 'Gagal, Tidak bisa membaca file excel.',
                    'alert-type' => 'error',
                ];
                return redirect()->route('data-pegawai.data-presensi.upload-presensi.index')->with($notification);
            }else{
                $array = Excel::toArray(new RiwayatPresensiImport(), request()->file('file_excel'));
                unset($array[0][0]);
                $xls = $array[0];
                $arrData = array();$pegawaiblumada = array();
                foreach ($xls as $rx) {
                    $nip = trim($rx[4]);
                    $cekidsdm = $this->repomspegawai->findId("",$nip,"nip");
                    if($cekidsdm){
                        $data['tanggal_scan'] = date('Y-m-d H:i:s',strtotime($rx[0]));
                        $data['tanggal_absen'] = Fungsi::strToDate($rx[1]);
                        $data['jam_absen'] = $rx[2];
                        $data['id_sdm'] = $cekidsdm->id_sdm;
                        $data['sn'] = $rx[12];
                        $data['mesin'] = $rx[13];
                        $arrData[] = $data;
                    }else{
                        $dtgagal['nip'] = $nip;
                        $dtgagal['nama'] = $rx[5];
                        $pegawaiblumada[] = $dtgagal;
                    }
                }
                $jberhasil = 0;$jgagal=0;
                if(count($arrData)>0){
                    foreach($arrData as $rs=>$dt){
                        $jberhasil++;
                        $this->reporiwayatpresensi->store($dt);
                    }
                }
                if(count($pegawaiblumada)>0){
                    Session::put('pegawaiblumada',$pegawaiblumada);
                    $jgagal+=count($pegawaiblumada);
                }
                $notification = [
                    'message' => 'Berhasil, Upload data finger berhasil dilakukan. '.$jberhasil." Berhasil di upload, ".$jgagal." gagal diupload.",
                    'alert-type' => 'success',
                ];
                return redirect()->route('data-pegawai.data-presensi.upload-presensi.index')->with($notification);
            }
        } catch (Exception $e) {
            $notification = [
                'message' => 'Gagal, Tidak bisa membaca file excel.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.data-presensi.upload-presensi.index')->with($notification);
        }
    }

    public function clear(){
        Session::forget('pegawaiblumada');
        return redirect()->route('data-pegawai.data-presensi.upload-presensi.index');
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
