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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiExport;
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
        $tgl_awal = $req['tgl_awal'];
        $tgl_akhir = $req['tgl_akhir'];
        $data['rsDataKetApp'] = $rsDataKetApp;
        $data['tipe'] = $req['tipe'];
        $data_bulan = Fungsi::hari_dalam_satu_bulan($tgl_awal,$tgl_akhir,1);
        $data['data_bulan'] = $data_bulan;
        $getajuan_justifikasi = Fungsi::getajuan_justifikasiall($tgl_awal,$tgl_akhir);
        $data['getajuan_justifikasi'] = $getajuan_justifikasi;
        $arrjumlahjustifikasi = array();
        foreach($getajuan_justifikasi as $rsidsdm=>$rdata){
            foreach($rdata as $rsdtx=>$rxdt){
                $arrjumlahjustifikasi[$rsidsdm]['jumlah_justifikasi']+=$rxdt['durasi_justifikasi'];
            }
        }
        $data['arrjumlahjustifikasi'] = $arrjumlahjustifikasi;
        $data['arrkategorijustifikasi'] = Fungsi::arrkategorijustifikasi();
        $arrtipecetak = array('1'=>"Data Presensi Format Harian 1",'2'=>"Data Presensi Format Harian 2",'3'=>"Data Presensi Format Harian + Lembur",'4'=>"Data Presensi Format Rekap Bulanan");
        if($req['id_jam_kerja'] == '0726e0a0-22f3-421b-a0ac-339a35d15d04'){
            if($req['satuan_kerja']==null || $req['satuan_kerja']!='30c82828-d938-42c1-975e-bf8a1db2c7b0'){
                $notification = [
                    'message' => 'Gagal menampilkan data, untuk jam kerja shift anda harus memilih unit kerja poliklinik.',
                    'alert-type' => 'error',
                ];
                return redirect()->route('laporan.presensi-kehadiran.index')->with($notification);
            }else{
                $rsData = $this->repomspegawai->get("","",$req['satuan_kerja'],$req['id_sdm']);
                $arrIdSdm = array();
                foreach($rsData as $rs=>$r){
                    $arrIdSdm[$r->id_sdm] = $r->id_sdm;
                }
                $bulan_awal = date('m',strtotime($tgl_awal));
                $bulan_akhir = date('m',strtotime($tgl_akhir));
                if($bulan_awal!=$bulan_akhir){
                    $notification = [
                        'message' => 'Gagal menampilkan data, rekap maksimal yang ditampilkan hanya 1 dalam kurun waktu 1 bulan.',
                        'alert-type' => 'error',
                    ];
                    return redirect()->route('laporan.presensi-kehadiran.index')->with($notification);
                }else{
                    $getRekapDataAbsenPoli = Fungsi::getRekapDataAbsenPoli($tgl_awal,$tgl_akhir,$arrIdSdm,$req['tipe']);
                    $getDataAbsen = Fungsi::gettanggalabsenkehadiran($arrIdSdm,$tgl_awal,$tgl_akhir);

                    foreach($rsData as $rsx=>$rx){
                        $arrData[$rx->id_sdm]['nm_sdm'] = $rx->nm_sdm;
                        $arrData[$rx->id_sdm]['nip'] = $rx->nip;
                        $arrData[$rx->id_sdm]['id_satker'] = $rx->id_satkernow;
                        $arrData[$rx->id_sdm]['dt_absen'] = $getDataAbsen[$rx->id_sdm];
                        $arrData[$rx->id_sdm]['data_presensi'] = $getRekapDataAbsenPoli[$rx->id_sdm];
                    }
                    $dt_hari_libur = Fungsi::jmlh_hari_libur($tgl_awal,$tgl_akhir);
                    $data['dt_hari_libur'] = $dt_hari_libur;
                    $data['arrData'] = $arrData;
                    // ambil master jam kerja shift
                    $jam_kerja_text = "";
                    $jam_kerja = Fungsi::jamkerjashift();
                    $data['jam_kerja'] = $jam_kerja;
                    foreach($jam_kerja as $id_hr_kerja=>$dt_hr_kerja){
                        $jam_kerja_text .= $dt_hr_kerja['nm_shift']." ( ".$dt_hr_kerja['jam_masuk']."-".$dt_hr_kerja['jam_pulang']." ), ";
                    }
                    $data['jam_kerja_text'] = trim($jam_kerja_text, ", \t\n");
                    $data['id_satker'] = $req['satuan_kerja'];
                    if($req['format']==1){
                        if($req['tipe']==1){
                            return view('content.laporan.kehadiran.cetak_data_presensi',$data);
                        }if($req['tipe']==2){
                            return view('content.laporan.kehadiran.cetak_data_presensi2',$data);
                        }
                        if($req['tipe']==3){
                            return view('content.laporan.kehadiran.cetak_data_presensi_lembur',$data);
                        }
                        if($req['tipe']==4){
                            //dd($data);

                            $rsAlasan = DB::table('ms_alasan_absen')->get();
                            foreach($rsAlasan as $rsa=>$ralasan){
                                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
                            }
                            $thn = date('Y',strtotime($tgl_awal));
                            $data['tahun'] = $thn;
                            $data['arrAlasan'] = $arrAlasan;
                            $arrjumlahabsen = array();
                            foreach($data_bulan as $id_bulan=>$dt_bln){
                                foreach($arrData as $id_sdm=>$dt_sdm){
                                    $kode = $thn.sprintf("%02d", $id_bulan);
                                    $dt_presensi = $dt_sdm['data_presensi'][$kode];
                                    if(count($dt_presensi)==0){
                                        foreach($dt_sdm['dt_absen'] as $tglabsennya=>$dtabsennya){
                                            foreach($dtabsennya as $nmkategoriabsen=>$dtkategori){
                                                $arrjumlahabsen[$dt_sdm['nip']][$dtkategori['nm_alasan']][$tglabsennya] = $tglabsennya;
                                            }
                                        }
                                    }
                                }
                            }
                            $data['arrjumlahabsen'] = $arrjumlahabsen;
                            return view('content.laporan.kehadiran.cetak_data_presensi_bulanan',$data);
                        }
                    }else{
                        if($req['tipe']==4){
                            $rsAlasan = DB::table('ms_alasan_absen')->get();
                            foreach($rsAlasan as $rsa=>$ralasan){
                                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
                            }
                            $thn = date('Y',strtotime($tgl_awal));
                            $data['tahun'] = $thn;
                            $data['arrAlasan'] = $arrAlasan;
                            $arrjumlahabsen = array();
                            foreach($data_bulan as $id_bulan=>$dt_bln){
                                foreach($arrData as $id_sdm=>$dt_sdm){
                                    $kode = $thn.sprintf("%02d", $id_bulan);
                                    $dt_presensi = $dt_sdm['data_presensi'][$kode];
                                    if(count($dt_presensi)==0){
                                        foreach($dt_sdm['dt_absen'] as $tglabsennya=>$dtabsennya){
                                            foreach($dtabsennya as $nmkategoriabsen=>$dtkategori){
                                                $arrjumlahabsen[$dt_sdm['nip']][$dtkategori['nm_alasan']][$tglabsennya] = $tglabsennya;
                                            }
                                        }
                                    }
                                }
                            }
                            $data['arrjumlahabsen'] = $arrjumlahabsen;
                        }
                        return Excel::download(new PresensiExport($data), $arrtipecetak[$req['tipe']].'.xlsx');
                    }
                }
            }
        }else{
            $rsData = $this->repomspegawai->get("","",$req['satuan_kerja'],$req['id_sdm']);

            $jam_kerja = Fungsi::jam_kerja($req['id_jam_kerja']);
            $arrIdSdm = array();
            foreach($rsData as $rs=>$r){
                $arrIdSdm[$r->id_sdm] = $r->id_sdm;
            }
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

                if($req['format']==1){
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
                        $arrjumlahabsen = array();
                        foreach($data_bulan as $id_bulan=>$dt_bln){
                            foreach($arrData as $id_sdm=>$dt_sdm){
                                $kode = $thn.sprintf("%02d", $id_bulan);
                                $dt_presensi = $dt_sdm['data_presensi'][$kode];
                                foreach($dt_sdm['dt_absen'] as $tglabsennya=>$dtabsennya){
                                    foreach($dtabsennya as $nmkategoriabsen=>$dtkategori){
                                        $arrjumlahabsen[$dt_sdm['nip']][$dtkategori['nm_alasan']][$tglabsennya] = $tglabsennya;
                                    }
                                }
                            }
                        }
                        $data['arrjumlahabsen'] = $arrjumlahabsen;
                        return view('content.laporan.kehadiran.cetak_data_presensi_bulanan',$data);
                    }
                }else{
                    if($req['tipe']==4){
                        $rsAlasan = DB::table('ms_alasan_absen')->get();
                        foreach($rsAlasan as $rsa=>$ralasan){
                            $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
                        }
                        $thn = date('Y',strtotime($tgl_awal));
                        $data['tahun'] = $thn;
                        $data['arrAlasan'] = $arrAlasan;
                    }
                    $arrjumlahabsen = array();
                    foreach($data_bulan as $id_bulan=>$dt_bln){
                        foreach($arrData as $id_sdm=>$dt_sdm){
                            $kode = $thn.sprintf("%02d", $id_bulan);
                            $dt_presensi = $dt_sdm['data_presensi'][$kode];
                            foreach($dt_sdm['dt_absen'] as $tglabsennya=>$dtabsennya){
                                foreach($dtabsennya as $nmkategoriabsen=>$dtkategori){
                                    $arrjumlahabsen[$dt_sdm['nip']][$dtkategori['nm_alasan']][$tglabsennya] = $tglabsennya;
                                }
                            }
                        }
                    }
                    $data['arrjumlahabsen'] = $arrjumlahabsen;
                    return Excel::download(new PresensiExport($data), $arrtipecetak[$req['tipe']].'.xlsx');
                }
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
