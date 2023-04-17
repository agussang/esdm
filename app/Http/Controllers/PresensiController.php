<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repoclocktransaction;
use App\Repositories\Repomswaktushift;
use App\Models\Iclocktransaction;
use App\Repositories\Repomspegawai;
use App\Repositories\Repotrjadwalshift;
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
        Repomspegawai $repomspegawai,
        Repoclocktransaction $repoclocktransaction,
        Repomswaktushift $repomswaktushift,
        Repotrjadwalshift $repotrjadwalshift
    ){
        $this->request = $request;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawai = $repomspegawai;
        $this->repoclocktransaction = $repoclocktransaction;
        $this->repomswaktushift = $repomswaktushift;
        $this->repotrjadwalshift = $repotrjadwalshift;
    }

    public function index()
    {

        $data['pilihan_sdm'] = Fungsi::pilihan_sdm();
        $data['pilihan_mesin_finger'] = Fungsi::pilihan_mesin_finger();
        $ket_tgl = $this->repoclocktransaction->get();
        $n=0; $no=0;$arrTgl = array();$listtgl = array();
        foreach($ket_tgl as $tgl=>$rtgl){
            $arrTgl[$n][] = date('d-m-Y',strtotime($rtgl->tgl_absen));
            $no++;
            if($no==4){
                $no=0;
                $n++;
            }
            $listtgl[] = $rtgl->tgl_absen;
        }
        $data['listtgl'] = $listtgl;
        $data['arrTgl'] = $arrTgl;
        return view('content.data_pegawai.presensi.upload_presensi.index',$data);
    }

    public function sync_finger(Request $request){
        $req = $request->except('_token');
        if ($req['tgl_absen'] != 'undefined') {
            $rsPeg = $this->repomspegawai->get();
            $arrNip = array();$arrIdSdm = array();
            foreach($rsPeg as $rs=>$r){
                $arrNip[$r->nip] = $r->nip;
                $arrIdSdm[$r->nip] = $r->id_sdm;
            }
            $sync = $this->repoclocktransaction->getsyncabsen($req['tgl_absen'],$arrNip);
            foreach($sync as $empcode => $dt_tgl){
                $id_sdm = $arrIdSdm[$empcode];
                if($id_sdm){
                    foreach($dt_tgl as $tgl_absen => $dttglabsen){
                        foreach($dttglabsen as $jam_absen => $dt_jam_absen){
                            $id_finger = $dt_jam_absen['id'];
                            unset($dt_jam_absen['emp_code']);
                            unset($dt_jam_absen['id']);
                            $dt_jam_absen['tanggal_scan'] = date('Y-m-d H:i:s');
                            $dt_jam_absen['id_sdm'] = $id_sdm;
                            $this->reporiwayatpresensi->store($dt_jam_absen);
                            $upfinger['csf'] = "1";
                            $where['id'] = $id_finger;
                            $update_finger = Iclocktransaction::where('id',$id_finger)->update(['csf'=>1]);
                        }
                    }
                }
            }
        }else{
            echo '<script type="text/javascript">toastr.success("Proses sync finger telah selesai.")</script>';
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
        $req = $request->except('_token');
        $masuk['id_sdm'] = $req['id_sdm'];
        $masuk['mesin'] = $req['mesin'];
        $masuk['tanggal_absen'] = $req['tgl_absen'];
        $masuk['jam_absen'] = $req['jam_absen'].":00";
        $masuk['tanggal_scan'] = date('Y-m-d H:i:s');
        $this->reporiwayatpresensi->store($masuk);
        $pulang['id_sdm'] = $req['id_sdm'];
        $pulang['mesin'] = $req['mesin'];
        $pulang['tanggal_absen'] = $req['tgl_absen'];
        $pulang['jam_absen'] = $req['jam_absen_pulang'].":00";
        $pulang['tanggal_scan'] = date('Y-m-d H:i:s');
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
                return redirect()->route('data-pegawai.data-presensi.jadwal-presensi-shift.import-jadwal')->with($notification);
            }else{
                $array = Excel::toArray(new RiwayatPresensiImport(), request()->file('file_excel'));
                unset($array[0][0]);
                $xls = $array[0];
                $arrData = array();$arrgagal = array();
                foreach ($xls as $rx=>$r) {
                    $tgl_absen = date('Y-m-d',strtotime($r[2]));
                    if($tgl_absen == '1970-01-01'){
                        $tgl_absen = Fungsi::inttodate($r[2]);
                    }
                    $nip = trim($r[0]);
                    $cekidsdm = $this->repomspegawai->findId("",$nip,"nip");
                    if($cekidsdm){
                        //cek kode shift
                        $cekkode = $this->repomswaktushift->findWhereRaw("","kode_shift = '$r[3]'");
                        if($cekkode){
                            $data['id_sdm'] = $cekidsdm->id_sdm;
                            $data['tanggal_absen'] = $tgl_absen;
                            $data['id_shift'] = $cekkode->id;
                            $arrData[] = $data;
                        }else{
                            $arrgagal[$r[0]] = $r[1];
                        }
                    }else{
                        $arrgagal[$r[0]] = $r[1];
                    }
                }
                //dd($arrData);
                $jberhasil = 0;
                foreach($arrData as $key=>$dtkey){
                    // cek sudah ada apa belum
                    $cekrecod = $this->repotrjadwalshift->findWhereRaw("","tanggal_absen = '$dtkey[tanggal_absen]' and id_sdm = '$dtkey[id_sdm]' ");
                    if($cekrecod!=null){
                        //update
                        $where['id_jadwal_shift'] = $cekrecod['id_jadwal_shift'];
                        $this->repotrjadwalshift->update($where,$dtkey);
                    }else{
                        // insert
                        $this->repotrjadwalshift->store($dtkey);
                    }
                    $jberhasil++;
                }

                $text = "Data berhasil dimasukkan ".$jberhasil;
                if($arrgagal!=null){
                    $datagagalimp = implode(',',$arrgagal);
                    $text = "Data berhasil masuk ".$jberhasil. " pegawai ,dan ada data yang gagal di masukkan : ($datagagalimp).";
                }
                $notification = [
                    'message' => $text,
                    'alert-type' => 'success',
                ];

                return redirect()->route('data-pegawai.data-presensi.jadwal-presensi-shift.import-jadwal')->with($notification);
            }
        } catch (Exception $e) {
            $notification = [
                'message' => 'Gagal, Tidak bisa membaca file excel.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.data-presensi.jadwal-presensi-shift.import-jadwal')->with($notification);
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
