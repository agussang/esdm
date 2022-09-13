<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repomspegawai;
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
        Repotrabsenkehadiran $repotrabsenkehadiran
    ){
        $this->request = $request;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawai = $repomspegawai;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
    }

    public function index()
    {
        $data['pilihan_satker'] = Fungsi::pilihan_satker();
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm();
        $data['pilihan_jam_kerja'] = Fungsi::pilihan_jam_kerja();
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
        $rsData = $this->repomspegawai->get("","",$req['satuan_kerja'],$req['id_sdm']);
        $jam_kerja = Fungsi::jam_kerja($req['id_jam_kerja']);
        $tgl_awal = $req['tgl_awal'];
        $tgl_akhir = $req['tgl_akhir'];
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrIdSdm[$r->id_sdm] = $r->id_sdm;
        }
        $rsDataAbsen = $this->reporiwayatpresensi->get("","",$arrIdSdm,$tgl_awal,$tgl_akhir);
        foreach($rsDataAbsen as $rsA=>$rA){
            $tgl = Fungsi::formatDate($rA->tanggal_absen);
            $arrAbsen[$rA->id_sdm][$tgl][] = $rA->jam_absen;
            $arrAbsen2[$rA->id_sdm][$rA->tanggal_absen][] = $rA->jam_absen;
        }
        foreach($rsData as $rsx=>$rx){
            $arrData[$rx->id_sdm]['nm_sdm'] = $rx->nm_sdm;
            $arrData[$rx->id_sdm]['nip'] = $rx->nip;
            $arrData[$rx->id_sdm]['data_presensi'] = $arrAbsen[$rx->id_sdm];
            $arrData[$rx->id_sdm]['data_presensi2'] = $arrAbsen2[$rx->id_sdm];
        }
        $data['arrData'] = $arrData;
        $data['jam_kerja'] = $jam_kerja;
        $bulan_awal = date('m',strtotime($tgl_awal));
        $bulan_akhir = date('m',strtotime($tgl_akhir));
        $bulan_awal = sprintf("%0d", $bulan_awal);
        $thn = date('Y',strtotime($tgl_awal));
        $data_bulan = array();
        for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
            $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
            for ($i=1; $i < $tanggal+1; $i++) { 
                $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                $tgl = Fungsi::formatDate($gbng);
                $hari = explode(',',$tgl);
                if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                    $data_bulan[$x]['nm_bulan'] = bulan($x);
                    $data_bulan[$x]['tgl_bulan'][$i] = $i;
                } 
            }
        }
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
            $arrAlasan = array();
            $rsAlasan = DB::table('ms_alasan_absen')->get();
            foreach($rsAlasan as $rsa=>$ralasan){
                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
            }
            $data['arrAlasan'] = $arrAlasan;
            $arrAbsen = array();$arrAbsenBul = array();$arrTelaat = array();
            $data['data_bulan'] = $data_bulan;
            foreach($arrData as $id_sdm=>$absen){
                foreach($absen['data_presensi2'] as $tglx2=>$dttgl2){
                    
                    $date = date('Y-m-d',strtotime($tglx2));
                    $explode = explode('-',$date);
                    $bln = sprintf("%0d", $explode[1]);
                    $tglnya = sprintf("%0d", $explode[2]);

                    // if(count($dttgl2)<2){
                    //     $data['absen1kali'][$id_sdm][$bln][$dttgl2] = $dttgl2;
                    // }

                    $arrAbsenBul[$id_sdm][$bln][$tglnya] = $tglnya;
                    $jam_pulang = end($dttgl2);
                    $jam_masuk = array_shift($dttgl2);
                    if($jam_masuk >= $jam_kerja->masuk_telat){

                        $jam_masukex = explode(':',$jam_masuk);
                        $jam_telatex = explode(':',$jam_kerja->masuk_telat);

                        $j_masuk_start = $jam_masukex[0];
                        $menit_masuk = $jam_masukex[1];

                        $j_telat_masuk = $jam_telatex[0];
                        $menit_telat_masuk = $jam_telatex[1];

                        $hasil = (intVal($j_telat_masuk) - intVal($j_masuk_start)) * 60 + (intVal($menit_telat_masuk) - intVal($menit_masuk));
                        $hasil = abs($hasil) / 60;
                        $hasil = number_format($hasil,2);
                        $hasilx = explode(".",$hasil);
                        $depan = sprintf("%02d", $hasilx[0]);
                        $gabung = $depan.":".$hasilx[1];
                        $menit = ($gabung*60)+$hasilx[1];

                        $data['telat'][$id_sdm][$bln][$tglnya] = $menit;
                    }
                    if($jam_pulang <= $jam_kerja->jam_keluar){
                        $jam_pulangex = explode(':',$jam_pulang);
                        $jam_ker_pulangex = explode(':',$jam_kerja->jam_keluar);

                        $j_pulang_start = $jam_pulangex[0];
                        $menit_pulang = $jam_pulangex[1];

                        $j_ker_pulang = $jam_ker_pulangex[0];
                        $menit_ker_pulang = $jam_ker_pulangex[1];

                        $hasil = (intVal($j_ker_pulang) - intVal($j_pulang_start)) * 60 + (intVal($menit_ker_pulang) - intVal($menit_pulang));
                        $hasil = abs($hasil) / 60;
                        $hasil = number_format($hasil,2);
                        $hasilx = explode(".",$hasil);
                        $depan = sprintf("%02d", $hasilx[0]);
                        $gabung = $depan.":".$hasilx[1];
                        $menit = ($gabung*60)+$hasilx[1];

                        $data['cepatpulang'][$id_sdm][$bln]['hasil'] = $menit;
                        $data['cepatpulang'][$id_sdm][$bln]['jam_pulang'] = $jam_pulang;
                        $data['cepatpulang'][$id_sdm][$bln]['jam_master_pulang'] = $jam_kerja->jam_keluar;
                    }
                }
                $arrAbsen[$id_sdm] = $arrAbsenBul[$id_sdm];
            }

            //dd($data['absen1kali']);

            $hittelatmasuk = array();
            foreach($data['telat'] as $idpg=>$dtbul){
                foreach($dtbul as $ibln=>$dtbln){
                    foreach($dtbln as $tglxe=>$jmtlt){
                        $hittelatmasuk['total_terlambat'][$idpg][$ibln]+=$jmtlt;
                    }
                }
            }

            $hitpulangcepat = array();
            foreach($data['cepatpulang'] as $idpgx=>$dtbulx){
                foreach($dtbulx as $iblnx=>$dtblnx){
                    foreach($dtblnx as $tglxex=>$jmtltx){
                        $hitpulangcepat['total_plng_cepet'][$idpgx][$iblnx]+=$jmtltx;
                    }
                }
            }
            $data['molehcepet'] = $hitpulangcepat['total_plng_cepet'];
            $data['terlambat'] = $hittelatmasuk['total_terlambat'];

            $arrAlasanabsen = array();
            $rsDataAbsen = $this->repotrabsenkehadiran->get(['dt_pegawai','alasan'],$tgl_awal,$tgl_akhir);
            foreach($rsDataAbsen as $sen=>$senx){
                $jm_absen = Fungsi::jumlah_absen($senx->tgl_awal,$senx->tgl_akhir,1);
                $arrAlasanabsen[$senx->id_sdm][$senx->id_alasan] = $jm_absen;
            }
            $data['arrAlasanabsen'] = $arrAlasanabsen;
            foreach($data['data_bulan'] as $idbln=>$dtbln){
                foreach($dtbln['tgl_bulan'] as $tglbln=>$tgln){
                    foreach($arrAbsen as $idsdm=>$dtsdmx){
                        $cek = $dtsdmx[$idbln][$tglbln];
                        if($cek!=null){
                            $data['masuk'][$idsdm][$idbln][$tglbln] = $tglbln;
                        }else{
                            $data['tidakmasuk'][$idsdm][$idbln][$tglbln] = $tglbln;
                        }
                    }
                }
            }
            
            return view('content.laporan.kehadiran.cetak_data_presensi_bulanan',$data);
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
