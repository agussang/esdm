<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrrekapskp;
use App\Repositories\Repomspegawai;
use Session;
use Crypt;
use Fungsi;

class DataSkpController extends Controller
{
    public function __construct(
        Request $request,
        Repotrrekapskp $repotrrekapskp,
        Repomspegawai $repomspegawai
    ){
        $this->request = $request;
        $this->repotrrekapskp = $repotrrekapskp;
        $this->repomspegawai = $repomspegawai;
    }

    public function index()
    {
        $tahun = Session::get('tahun');
        if($tahun==null){
            $tahun = date('Y');
        }
        $bulan = Session::get('bulan');
        if($bulan==null){
            $bulan = date('m');
        }
        $bulan = "01";
        $rekap_skp = $this->repotrrekapskp->get(['dt_periode'],"", $tahun, $bulan);
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($tahun);
        $data['pilihan_bulan_skp'] = Fungsi::pilihan_bulan_skp($bulan);
        $text_cari = Session::get('text_cari');
        $data['rsData'] = $this->repomspegawai->getskp(['nm_atasan','nm_atasan_pendamping','nm_satker'],1,$text_cari);
        $arrrekapnilai = array();
        foreach($rekap_skp as $rs=>$r){
            $arrrekapnilai[$r->id_sdm]['idperiode'] = $r->idperiode;
            $arrrekapnilai[$r->id_sdm]['nilai_skp'] = $r->nilai_skp;
            $arrrekapnilai[$r->id_sdm]['nilai_perilaku'] = $r->nilai_perilaku;
            $arrrekapnilai[$r->id_sdm]['validasi'] = $r->validasi;
            $arrrekapnilai[$r->id_sdm]['file_skp'] = $r->file_skp;
            $arrrekapnilai[$r->id_sdm]['validated_at'] = date('d-m-Y H:i:s',strtotime($r->validated_at));
        }
        $data['arrrekapnilai'] = $arrrekapnilai;
        return view('content.skp.data_skp.index',$data);
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
