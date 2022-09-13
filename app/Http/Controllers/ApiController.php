<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repomspegawai;
use App\Repositories\Repotrrekapskp;
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
class ApiController extends Controller
{
    public function __construct(
        Request $request,
        Reporiwayatpresensi $reporiwayatpresensi,
        Repomspegawai $repomspegawai,
        Repotrabsenkehadiran $repotrabsenkehadiran,
        Repotrrekapskp $repotrrekapskp
    ){
        $this->request = $request;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawai = $repomspegawai;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
        $this->repotrrekapskp = $repotrrekapskp;
    }

    public function rekap_skp($nip,$bulan,$tahun){
        $rsData = $this->repomspegawai->findId("",$nip,"nip");
        $rekap_skp = $this->repotrrekapskp->get(['dt_periode'],$rsData->id_sdm, $tahun, $bulan);
        $arrrekapnilai = array();
        $arrNamabulan = Fungsi::nm_bulan();
        foreach($rekap_skp as $rs=>$r){
            $rekap['idperiode'] = $r->idperiode;
            $rekap['nilai_skp'] = $r->nilai_skp;
            $rekap['nilai_perilaku'] = $r->nilai_perilaku;
            $rekap['validasi'] = $r->validasi;
            $rekap['file_skp'] = $r->file_skp;
            $rekap['validated_at'] = date('d-m-Y H:i:s',strtotime($r->validated_at));
            $arrrekapnilai[$r->dt_periode->bulan]['nm_bulan'] = $arrNamabulan[$r->dt_periode->bulan];
            $arrrekapnilai[$r->dt_periode->bulan]['tahun'] = $r->dt_periode->tahun;
            $arrrekapnilai[$r->dt_periode->bulan]['kode'] = $r->dt_periode->kode;
            $arrrekapnilai[$r->dt_periode->bulan]['data_rekap_skp'] = $rekap;
        }
        $json_string = json_encode($arrrekapnilai, JSON_PRETTY_PRINT);
        return $json_string;

    }

    public function index($nip,$tgl_awal,$tgl_akhir)
    {
        $rsData = $this->repomspegawai->get("","","",$nip,"nip");
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
        $tahun = date('Y',strtotime($tgl_awal));

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
        $arrAlasan = array();
            $rsAlasan = DB::table('ms_alasan_absen')->get();
            foreach($rsAlasan as $rsa=>$ralasan){
                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
            }
            $arrAbsen = array();$arrAbsenBul = array();$arrTelaat = array();
            $data['data_bulan'] = $data_bulan;
            foreach($arrData as $id_sdm=>$absen){
                foreach($absen['data_presensi2'] as $tglx2=>$dttgl2){
                    $date = date('Y-m-d',strtotime($tglx2));
                    $explode = explode('-',$date);
                    $bln = sprintf("%0d", $explode[1]);
                    $tglnya = sprintf("%0d", $explode[2]);
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

                        $data['cepatpulang'][$id_sdm][$bln][$tglnya] = $menit;
                    }
                }
                $arrAbsen[$id_sdm] = $arrAbsenBul[$id_sdm];
            }
            
            $jmalasanabsen = array();
            $rsDataAbsen = $this->repotrabsenkehadiran->get(['dt_pegawai','alasan'],$tgl_awal,$tgl_akhir);
            foreach($rsDataAbsen as $sen=>$senx){
                $jm_absen = Fungsi::jumlah_absen($senx->tgl_awal,$senx->tgl_akhir,1);
                $jmalasanabsen[$senx->id_sdm][$senx->id_alasan] = $jm_absen;
            }
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
            $arrKirim = array();
            foreach($data['data_bulan'] as $id_bulan=>$dt_bln){
                foreach($data['arrData'] as $id_sdm=>$dt_sdm){
                    $blnkode = sprintf("%02d", $id_bulan);
                    $kode = $tahun."".$blnkode;
                    $arrKirim[$id_sdm][$kode]['nm_bulan'] = $dt_bln['nm_bulan'];
                    $arrKirim[$id_sdm][$kode]['nip'] = $dt_sdm['nip'];
                    $arrKirim[$id_sdm][$kode]['nm_sdm'] = $dt_sdm['nm_sdm'];
                    $arrKirim[$id_sdm][$kode]['hari_kerja'] = count((array)$dt_bln['tgl_bulan']);
                    $arrKirim[$id_sdm][$kode]['jml_kehadiran'] = count((array)$data['masuk'][$id_sdm][$id_bulan]);
                    $arrKirim[$id_sdm][$kode]['tidak_masuk'] = count((array)$data['tidakmasuk'][$id_sdm][$id_bulan]);
                    $arrKirim[$id_sdm][$kode]['telat'] = (int)$hittelatmasuk['total_terlambat'][$id_sdm][$id_bulan];
                    $arrKirim[$id_sdm][$kode]['pulang_cepat'] = (int)$hittelatmasuk['total_plng_cepet'][$id_sdm][$id_bulan];
                    foreach($arrAlasan as $idalasan=>$nm_alasan){
                        $arrKirim[$id_sdm][$kode]['absen'][$idalasan]['nm_alasan'] = $nm_alasan;
                        $arrKirim[$id_sdm][$kode]['absen'][$idalasan]['jmlh'] = $jmalasanabsen[$id_sdm][$idalasan][$id_bulan];
                    }
                }
            }
        $json_string = json_encode($arrKirim, JSON_PRETTY_PRINT);
        return $json_string;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
