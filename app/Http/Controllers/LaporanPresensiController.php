<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repomspegawai;
use App\Repositories\Reposettingapp;
use App\Repositories\Repotrabsenkehadiran;
use Crypt;
use Fungsi;
use Session;
use Excel;
use DB;
error_reporting(0);
function bulan($idbln){
    $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    return $bulan[$idbln];
}
class LaporanPresensiController extends Controller
{
    public function __construct(
        Request $request,
        Reporiwayatpresensi $reporiwayatpresensi,
        Repomspegawai $repomspegawai,
        Repotrabsenkehadiran $repotrabsenkehadiran,
        Reposettingapp $reposettingapp
    ){
        $this->request = $request;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->reposettingapp = $reposettingapp;
        $this->repomspegawai = $repomspegawai;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
    }

    public function index()
    {
        $data['pilihan_satker'] = Fungsi::pilihan_satker();
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm();
        $data['pilihan_jam_kerja'] = Fungsi::pilihan_jam_kerja();
        //dd($data);
        return view('content.laporan.kehadiran.index',$data);
    }

    public function cari_pegawai(Request $request){
        $req = $request->except('_token');
        $rsData = $this->repomspegawai->get("","",$req['satuan_kerja']);
        $d = '<option value="">Pilih Nama Pegawai</option>';
        foreach ($rsData as $rs => $r) {
            $d .= "<option value=\"$r->id_sdm\">$r->nm_sdm</option>";
        }
        echo $d;
    }

    public function cari_presensi(Request $request){
        $req = $request->except('_token');
        $rsDataKetApp = $this->reposettingapp->findId("","cb6020d6-e8a7-4240-ab2c-dffd30d31892","id_setting");
        $rsData = $this->repomspegawai->get("","",$req['satuan_kerja'],$req['id_sdm']);
        $jam_kerja = Fungsi::jam_kerja($req['id_jam_kerja']);
        $arrIdSdm = array();
        foreach($rsData as $rs=>$r){
            $arrIdSdm[$r->id_sdm] = $r->id_sdm;
        }
        $tgl_awal = $req['tgl_awal'];
        $tgl_akhir = $req['tgl_akhir'];
        $bulan_awal = date('m',strtotime($tgl_awal));
        $bulan_akhir = date('m',strtotime($tgl_akhir));
        if($bulan_awal!=$bulan_akhir){
            $notification = [
                'message' => 'Gagal menampilkan data, rekap maksimal yang ditampilkan hanya 1 dalam kurun waktu 1 bulan.',
                'alert-type' => 'error',
            ];
            return redirect()->route('laporan.presensi-kehadiran.index')->with($notification);
        }else{
            $getRekapDataAbsen = Fungsi::get_rekap_data_kehadiran($jam_kerja,$tgl_awal,$tgl_akhir,$arrIdSdm,$req['tipe']);
            $getDataAbsen = Fungsi::gettanggalabsenkehadiran($arrIdSdm,$tgl_awal,$tgl_akhir);

            foreach($rsData as $rsx=>$rx){
                $arrData[$rx->id_sdm]['nm_sdm'] = $rx->nm_sdm;
                $arrData[$rx->id_sdm]['nip'] = $rx->nip;
                $arrData[$rx->id_sdm]['dt_absen'] = $getDataAbsen[$rx->id_sdm];
                $arrData[$rx->id_sdm]['data_presensi'] = $getRekapDataAbsen[$rx->id_sdm];
            }
            $dt_hari_libur = Fungsi::jmlh_hari_libur($tgl_awal,$tgl_akhir);
            $data['dt_hari_libur'] = $dt_hari_libur;
            $data['arrData'] = $arrData;
            $data['jam_kerja'] = $jam_kerja;
            $jam_kerja_text = "";
            $kategoriwaktuabsen = Fungsi::kategoriwaktuabsen();
            foreach($jam_kerja as $id_hr_kerja=>$dt_hr_kerja){
                $jam_kerja_text .= $kategoriwaktuabsen[$id_hr_kerja]." ( ".$dt_hr_kerja['jam_masuk']." - ".$dt_hr_kerja['jam_pulang']." ), ";
            }
            $data['jam_kerja_text'] = trim($jam_kerja_text, ", \t\n");
            $data['data_bulan'] = Fungsi::hari_dalam_satu_bulan($tgl_awal,$tgl_akhir,1);

            if($req['tipe']==1){
                return view('content.laporan.kehadiran.cetak_data_presensi',$data);
            }
            if($req['tipe']==2){
                return view('content.laporan.kehadiran.cetak_data_presensi2',$data);
            }
            if($req['tipe']==3){
                return view('content.laporan.kehadiran.cetak_data_presensi_lembur',$data);
            }
            if($req['tipe']==4){
                $rsAlasan = DB::table('ms_alasan_absen')->get();
                foreach($rsAlasan as $rsa=>$ralasan){
                    $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
                }
                $thn = date('Y',strtotime($tgl_awal));
                $data['tahun'] = $thn;
                $data['arrAlasan'] = $arrAlasan;

                return view('content.laporan.kehadiran.cetak_data_presensi_bulanan',$data);
            }
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
