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
        $bulan = Session::get('bulan');
        $periodeaktif = $this->repomsperiodeskp->findWhereRaw("","status = '1'");
        if($tahun==null){
            if($periodeaktif){
                $tahun = $periodeaktif->tahun;
            }
            if($tahun==null){
                $tahun = date('Y');
            }
        }

        if($bulan==null){
            if($periodeaktif){
                $bulan = $periodeaktif->bulan;
            }
            if($bulan==null){
                $bulan = date('Y');
            }
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
        $arrrekapnilai = array(); $arrRekapskp = array();
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
            if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($data['periode_skp']->tgl_batas_skp))){
                if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($data['periode_skp']->tgl_batas_skp))){
                    $arrrekapnilai[$r->id_sdm]['point_disiplin'] = 3;
                    $keterlambatan = Fungsi::hitung_absen($data['periode_skp']->tgl_batas_skp,date('Y-m-d',strtotime($r->created_at)),"");
                    $keter = $keterlambatan['jmabsen']-1;
                    $arrrekapnilai[$r->id_sdm]['ket_disiplin'] = "Terlambat ".$keter." hari";
                }
                if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($data['periode_skp']->tgl_potongan3persen))){
                    $arrrekapnilai[$r->id_sdm]['point_disiplin'] = 100;
                    $keterlambatan = Fungsi::hitung_absen($data['periode_skp']->tgl_potongan3persen,date('Y-m-d',strtotime($r->created_at)),"");
                    $keter = $keterlambatan['jmabsen']-1;
                    $arrrekapnilai[$r->id_sdm]['ket_disiplin'] = "Terlambat ".$keter." hari";
                }
            }
            if($r->point_justifikasi!=null){
                $arrrekapnilai[$r->id_sdm]['point_disiplin'] = $r->point_justifikasi;
            }

        }
        $data['arrrekapnilai'] = $arrrekapnilai;
        return view('content.skp.data_skp.index',$data);
    }

    public function simpan_penilaian_skp(Request $request){
        $req = $request->except('_token');
        $nilai_skp = $req['nilai_skp'];
        $valid = $req['valid'];
        unset($req['nilai_skp']);
        unset($req['valid']);
        if($valid=="on"){
            $reqrekap['validasi']=1;
            $reqrekap['validated_at'] = date('Y-m-d H:i:s');
            $reqrekap['userid_validated'] = Session::get('id_pengguna');
        }
        if($req['ket_justifikasi']!=null){
            $reqrekap['tgl_justifikasi'] = date('Y-m-d H:i:s');
            $reqrekap['justifikasi'] = "1";
            $reqrekap['ket_justifikasi'] = $req['ket_justifikasi'];
            $reqrekap['point_justifikasi'] = $req['point_justifikasi'];
            $reqrekap['tgl_justifikasi'] = date('Y-m-d H:i:s');
        }
        $reqrekap['id_sdm'] = $req['id_sdm'];
        $reqrekap['nip'] = $req['nip'];
        $reqrekap['nilai_skp'] = $nilai_skp;
        $reqrekap['idperiode'] = $req['idperiode'];
        $reqrekap['nilai_perilaku'] = $nilai_skp;
        $cekrekapskp = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$req[idperiode]' and id_sdm = '$req[id_sdm]' ");
        if($cekrekapskp){
            $where['id'] = $cekrekapskp->id;
            $this->repotrrekapskp->update($where,$reqrekap);
        }else{
            $this->repotrrekapskp->store($reqrekap);
        }
        $notification = [
            'message' => 'Berhasil, Penilaian prilaku pegawai berhasil disimpan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('skp.data-skp.index')->with($notification);
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
