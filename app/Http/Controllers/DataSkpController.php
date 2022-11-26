<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrrekapskp;
use App\Repositories\Repomspegawai;
use App\Repositories\Repomsperiodeskp;
use Session;
use Crypt;
use Fungsi;

class DataSkpController extends Controller
{
    public function __construct(
        Request $request,
        Repotrrekapskp $repotrrekapskp,
        Repomspegawai $repomspegawai,
        Repomsperiodeskp $repomsperiodeskp
    ){
        $this->request = $request;
        $this->repotrrekapskp = $repotrrekapskp;
        $this->repomsperiodeskp = $repomsperiodeskp;
        $this->repomspegawai = $repomspegawai;
    }

    public function index()
    {
        $id_sdm_atasan = "";
        if(Session::get('atasan_penilai')==1){
            $id_sdm_atasan = Session::get('id_sdm');
        }
        $tahun = Session::get('tahun');
        if($tahun==null){
            $tahun = date('Y');
        }
        $bulan = Session::get('bulan');
        if($bulan==null){
            $bulan = date('m');
        }
        $data['periode_skp'] = $this->repomsperiodeskp->findWhereRaw(""," bulan = '$bulan' and tahun='$tahun'");
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($tahun);
        $data['pilihan_bulan_skp'] = Fungsi::pilihan_bulan_skp($bulan);
        $text_cari = Session::get('text_cari');
        $data['rsData'] = $this->repomspegawai->getskp(['nm_atasan','nm_atasan_pendamping','nm_satker'],1,$text_cari,$id_sdm_atasan);
        $arrIdSdm = array();
        foreach($data['rsData'] as $rsp=>$rp){
            $arrIdSdm[$rp->id_sdm] = $rp->id_sdm;
        }
        $rekap_skp = $this->repotrrekapskp->get(['dt_periode'],"", $tahun, $bulan,$arrIdSdm);
        $arrrekapnilai = array();
        foreach($rekap_skp as $rs=>$r){
            $arrrekapnilai[$r->id_sdm]['idperiode'] = $r->idperiode;
            $arrrekapnilai[$r->id_sdm]['nilai_skp'] = $r->nilai_skp;
            $arrrekapnilai[$r->id_sdm]['nilai_perilaku'] = $r->nilai_perilaku;
            $arrrekapnilai[$r->id_sdm]['validasi'] = $r->validasi;
            $arrrekapnilai[$r->id_sdm]['file_skp'] = $r->file_skp;
            $arrrekapnilai[$r->id_sdm]['ket_justifikasi'] = $r->ket_justifikasi;
            $arrrekapnilai[$r->id_sdm]['validated_at'] = date('d-m-Y H:i:s',strtotime($r->validated_at));
            $arrrekapnilai[$r->id_sdm]['created_at'] = date('d-m-Y H:i:s',strtotime($r->created_at));
            $arrrekapnilai[$r->id_sdm]['point_disiplin'] = 0;
            $arrrekapnilai[$r->id_sdm]['ket_disiplin'] = "";
            if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($data['periode_skp']['tgl_batas_skp']))){
                $keterlambatan = Fungsi::hitung_absen($data['periode_skp']['tgl_batas_skp'],date('Y-m-d',strtotime($r->created_at)),"");
                $keter = $keterlambatan['jmabsen']-1;
                if($keter>5 && $keter<10){
                    $arrrekapnilai[$r->id_sdm]['point_disiplin'] = 3;
                    $arrrekapnilai[$r->id_sdm]['ket_disiplin'] = "Terlambat ".$keter." hari";
                }elseif($keter>=10){
                    $arrrekapnilai[$r->id_sdm]['point_disiplin'] = 100;
                    $arrrekapnilai[$r->id_sdm]['ket_disiplin'] = "Terlambat ".$keter." hari";
                }
            }

        }
        //dd($arrrekapnilai);
        $data['arrrekapnilai'] = $arrrekapnilai;
        return view('content.skp.data_skp.index',$data);
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
        return redirect()->route('skp.data-skp.index');
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
