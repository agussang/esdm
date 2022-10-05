<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repomspegawai;
use App\Repositories\Repotrrekapskp;
use App\Repositories\Repotrabsenkehadiran;
use App\Repositories\Repotrprilakupegawai;
use App\Repositories\Repotrpelanggaran;

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
        Repotrrekapskp $repotrrekapskp,
        Repotrprilakupegawai $repotrprilakupegawai,
        Repotrpelanggaran $repotrpelanggaran
    ){
        $this->request = $request;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawai = $repomspegawai;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
        $this->repotrrekapskp = $repotrrekapskp;
        $this->repotrprilakupegawai = $repotrprilakupegawai;
        $this->repotrpelanggaran = $repotrpelanggaran;
    }

    public function rekap_skp($nip,$bulan,$tahun){
        $rsData = $this->repomspegawai->findId("",$nip,"nip");
        
        $rekap_skp = $this->repotrrekapskp->get(['dt_periode'],$rsData->id_sdm, $tahun, $bulan);
        $data_prilaku = $this->repotrprilakupegawai->getWhereRaw(['dt_periode','dt_prilaku'],$rsData->id_sdm," bulan = '$bulan' and tahun = '$tahun' ");
        $arrrekapnilai = array();$arrdtprilaku = array();
        $arrNamabulan = Fungsi::nm_bulan();
        foreach($data_prilaku as $rsx=>$rx){
            $arrdtprilaku[$rx->id]['nama_komponen'] = $rx->dt_prilaku->nama;
            $arrdtprilaku[$rx->id]['nilai'] = $rx->nilai;
            $arrdtprilaku[$rx->id]['keterangan'] = $rx->keterangan;
        }
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
            $arrrekapnilai[$r->dt_periode->bulan]['data_prilaku'] = $arrdtprilaku;
        }
        $json_string = json_encode($arrrekapnilai, JSON_PRETTY_PRINT);
        return $json_string;
    }

    public function rekap_skp_all($bulan,$tahun){
        $rsPegawai = $this->repomspegawai->getskp(['nm_atasan','nm_atasan_pendamping','nm_satker'],1,"");
        $rekap_skp = $this->repotrrekapskp->get(['dt_periode'],"", $tahun, $bulan);
        $arrrekapnilai = array();$arrDataAll = array();$arrdtprilaku = array();
        $data_prilaku = $this->repotrprilakupegawai->getWhereRaw(['dt_periode','dt_prilaku'],""," bulan = '$bulan' and tahun = '$tahun' ");

        foreach($data_prilaku as $rsx=>$rx){
            $arrdtprilaku[$rx->id_sdm][$rx->id]['nama_komponen'] = $rx->dt_prilaku->nama;
            $arrdtprilaku[$rx->id_sdm][$rx->id]['nilai'] = $rx->nilai;
            $arrdtprilaku[$rx->id_sdm][$rx->id]['keterangan'] = $rx->keterangan;
        }

        foreach($rekap_skp as $rs=>$r){
            $arrrekapnilai[$r->id_sdm]['idperiode'] = $r->idperiode;
            $arrrekapnilai[$r->id_sdm]['nilai_skp'] = $r->nilai_skp;
            $arrrekapnilai[$r->id_sdm]['nilai_perilaku'] = $r->nilai_perilaku;
            $arrrekapnilai[$r->id_sdm]['validasi'] = $r->validasi;
            $arrrekapnilai[$r->id_sdm]['file_skp'] = $r->file_skp;
            $arrrekapnilai[$r->id_sdm]['validated_at'] = date('d-m-Y H:i:s',strtotime($r->validated_at));
        }
        foreach($rsPegawai as $rsP=>$rp){
            $arrDataAll[$rp->id_sdm]['nm_sdm'] = $rp->nm_sdm;
            $arrDataAll[$rp->id_sdm]['nip'] = $rp->nip;
            $arrDataAll[$rp->id_sdm]['data_rekap_skp'] = $arrrekapnilai[$rp->id_sdm];
            $arrDataAll[$rp->id_sdm]['data_prilaku'] = $arrdtprilaku[$rp->id_sdm];
        }
        $json_string = json_encode($arrrekapnilai, JSON_PRETTY_PRINT);
        return $json_string;
    }

    public function index($nip,$tgl_awal,$tgl_akhir)
    {

        $rsData = $this->repomspegawai->findId("",$nip,"nip");

        $arrIdSdm[$rsData->id_sdm] = $rsData->id_sdm;
        $jam_kerja = Fungsi::jam_kerja_unit($rsData->id_satkernow);
        $getRekapDataAbsen = Fungsi::get_rekap_data_kehadiran($jam_kerja,$tgl_awal,$tgl_akhir,$arrIdSdm,4);
        dd($getRekapDataAbsen);
    }

    public function pelanggaran($nip,$bulan,$tahun){
        $rsData = $this->repotrpelanggaran->get(['dt_pegawai','kategori_pelanggaran'],$nip,$bulan,$tahun);
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r['id_sdm']]['nip'] = $r->dt_pegawai->nip;
            $arrData[$r['id_sdm']]['nip'] = $r->dt_pegawai->nm_pegawai;
            $arrData[$r['id_sdm']]['nm_pelanggaran'] = $r->kategori_pelanggaran->nama_pelanggaran;
            $arrData[$r['id_sdm']]['lama_pengurang_remun'] = $r->kategori_pelanggaran->durasi;
            $arrData[$r['id_sdm']]['prosentase_pengurang'] = $r->kategori_pelanggaran->prosentase_pengurang;
            $arrData[$r['id_sdm']]['tgl_surat'] = $r->tgl_surat;
            $arrData[$r['id_sdm']]['no_surat'] = $r->no_surat;
            $arrData[$r['id_sdm']]['keterangan'] = $r->keterangan;
            $arrData[$r['id_sdm']]['tgl_berlaku'] = $r->tgl_berlaku;
            $arrData[$r['id_sdm']]['tgl_berakhir'] = $r->tgl_berakhir;
        }
        return json_encode($arrData);
    }

    public function pelanggaranall($bulan,$tahun){
        $rsData = $this->repotrpelanggaran->get(['dt_pegawai','kategori_pelanggaran'],"",$bulan,$tahun);
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->id_sdm]['nip'] = $r->dt_pegawai->nip;
            $arrData[$r->id_sdm]['nm_pegawai'] = $r->dt_pegawai->nm_sdm;
            $arrData[$r->id_sdm]['nm_pelanggaran'] = $r->kategori_pelanggaran->nama_pelanggaran;
            $arrData[$r->id_sdm]['lama_pengurang_remun'] = $r->kategori_pelanggaran->durasi;
            $arrData[$r->id_sdm]['prosentase_pengurang'] = $r->kategori_pelanggaran->prosentase_pengurang;
            $arrData[$r->id_sdm]['tgl_surat'] = $r->tgl_surat;
            $arrData[$r->id_sdm]['no_surat'] = $r->no_surat;
            $arrData[$r->id_sdm]['keterangan'] = $r->keterangan;
            $arrData[$r->id_sdm]['tgl_berlaku'] = $r->tgl_berlaku;
            $arrData[$r->id_sdm]['tgl_berakhir'] = $r->tgl_berakhir;
        }
        return json_encode($arrData);
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
