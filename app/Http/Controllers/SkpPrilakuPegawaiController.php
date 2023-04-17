<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsperiodeskp;
use App\Repositories\Repomspegawai;
use App\Repositories\Repomsprilaku;
use App\Repositories\Repotrprilakupegawai;
use App\Repositories\Repotrrekapskp;
use Session;
use Crypt;
use Fungsi;


class SkpPrilakuPegawaiController extends Controller
{
    public function __construct(
        Request $request,
        Repomsperiodeskp $repomsperiodeskp,
        Repomspegawai $repomspegawai,
        Repomsprilaku $repomsprilaku,
        Repotrprilakupegawai $repotrprilakupegawai,
        Repotrrekapskp $repotrrekapskp
    ){
        $this->request = $request;
        $this->repomsperiodeskp = $repomsperiodeskp;
        $this->repomspegawai = $repomspegawai;
        $this->repomsprilaku = $repomsprilaku;
        $this->repotrprilakupegawai = $repotrprilakupegawai;
        $this->repotrrekapskp = $repotrrekapskp;
    }

    public function prilaku($id)
    {
        $id_sdm = Crypt::decrypt($id);
        $tahun = Session::get('tahun');
        if($tahun==null){
            $tahun = date('Y');
        }
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($tahun);
        $data['rsData'] = $this->repomsperiodeskp->get("",$tahun);
        $arrBatas = array();
        foreach($data['rsData'] as $rsx=>$rx){
            $arrBatas[$rx->bulan]['tglbatasskp'] = $rx->tgl_batas_skp;
            $arrBatas[$rx->bulan]['tglbatasskp3persen'] = $rx->tgl_potongan3persen;
        }
        $data['periodeaktif'] = $this->repomsperiodeskp->findWhereRaw("","status = '1'");
        $data['arrBulan'] = Fungsi::nm_bulan_sing();
        $data['arrBulanPanjang'] = Fungsi::nm_bulan();
        $data['tahun'] = $tahun;
        $rekap_skp = $this->repotrrekapskp->get(['dt_periode'],$id_sdm,$tahun,"");
        $arrRekapskp = array();
        foreach($rekap_skp as $rs=>$r){
            $arrRekapskp[$r->dt_periode->bulan]['idperiode'] = $r->idperiode;
            $arrRekapskp[$r->dt_periode->bulan]['id_rekap'] = $r->id;
            $arrRekapskp[$r->dt_periode->bulan]['nilai_skp'] = $r->nilai_skp;
            $arrRekapskp[$r->dt_periode->bulan]['nilai_perilaku'] = $r->nilai_perilaku;
            $arrRekapskp[$r->dt_periode->bulan]['validasi'] = $r->validasi;
            $arrRekapskp[$r->dt_periode->bulan]['validated_at'] = date('d-m-Y H:i:s',strtotime($r->validated_at));
            $arrRekapskp[$r->dt_periode->bulan]['file_skp'] = $r->file_skp;
            $arrRekapskp[$r->dt_periode->bulan]['ket_justifikasi'] = $r->ket_justifikasi;
            $arrRekapskp[$r->dt_periode->bulan]['created_at'] = date('d-m-Y H:i:s',strtotime($r->created_at));
            $arrRekapskp[$r->dt_periode->bulan]['point_disiplin'] = 0;
            $arrRekapskp[$r->dt_periode->bulan]['ket_disiplin'] = "";

            if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($arrBatas[$r->dt_periode->bulan]['tglbatasskp']))){
                if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($arrBatas[$r->dt_periode->bulan]['tglbatasskp']))){
                    $arrRekapskp[$r->dt_periode->bulan]['point_disiplin'] = 3;
                    $keterlambatan = Fungsi::hitung_absen($arrBatas[$r->dt_periode->bulan]['tglbatasskp'],date('Y-m-d',strtotime($r->created_at)),"");
                    $keter = $keterlambatan['jmabsen']-1;
                    $arrRekapskp[$r->dt_periode->bulan]['ket_disiplin'] = "Terlambat ".$keter." hari";
                }
                if(date('Ymd',strtotime($r->created_at)) > date('Ymd',strtotime($arrBatas[$r->dt_periode->bulan]['tglbatasskp3persen']))){
                    $arrRekapskp[$r->dt_periode->bulan]['point_disiplin'] = 100;
                    $keterlambatan = Fungsi::hitung_absen($arrBatas[$r->dt_periode->bulan]['tglbatasskp3persen'],date('Y-m-d',strtotime($r->created_at)),"");
                    $keter = $keterlambatan['jmabsen']-1;
                    $arrRekapskp[$r->dt_periode->bulan]['ket_disiplin'] = "Terlambat ".$keter." hari";
                }
            }
            if($r->point_justifikasi!=null){
                $arrRekapskp[$r->dt_periode->bulan]['point_disiplin'] = $r->point_justifikasi;
            }
        }
        //dd($arrRekapskp);
        $data['arrRekapskp'] = $arrRekapskp;
        $data['dtpegawai'] = $this->repomspegawai->findId(['nm_atasan_pendamping','nm_atasan','nm_satker'],$id_sdm,"id_sdm");
        return view('content.hal_pegawai.skp.prilaku.index',$data);
    }

    public function form_justifikasi(Request $request){
        $req = $request->except('_token');
        $data['dt_pegawai'] = $this->repomspegawai->findId("",$req['id_sdm'],"id_sdm");
        return view('content.hal_pegawai.skp.prilaku.form-justifikasi',$data);
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
        return redirect()->back()->with($notification);
    }

    public function cari(Request $request){
        $req = $request->except('_token');
        $id_sdm = Crypt::encrypt($req['id_sdm']);
        unset($req['id_sdm']);
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/skp-pegawai/skp/'.$id_sdm);
    }

    public function cari_skp_bawahan(Request $request){
        $req = $request->except('_token');
        $id_sdm = Crypt::encrypt($req['id_sdm']);
        unset($req['id_sdm']);
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai-bawahan/skp-pegawai/'.$id_sdm);
    }




    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $nilai_skp = $req['nilai_skp'];
        $valid = $req['valid'];
        unset($req['nilai_skp']);
        unset($req['valid']);
        // $dtprilaku = $this->repomsprilaku->get();
        // $arr = array();
        // $total_n_skp = 0;$ttlkom = 0;
        // foreach($req as $id=>$value){
        //     $explod = explode("_",$id);
        //     if($explod[0]=="nilai"){
        //         $ttlkom++;
        //         $n_skp = str_replace(',','.',$value);
        //         $total_n_skp+=$n_skp;
        //         $arr[$explod[1]]['nilai'] = $n_skp;
        //         $arr[$explod[1]]['id_sdm'] = $req['id_sdm'];
        //         $arr[$explod[1]]['nip'] = $req['nip'];
        //         $arr[$explod[1]]['id_perilaku'] = $explod[1];
        //         $arr[$explod[1]]['idperiode'] = $req['idperiode'];
        //     }if($explod[0]=="keterangan"){
        //         $arr[$explod[1]]['keterangan'] = str_replace(',','.',$value);
        //         $arr[$explod[1]]['id_sdm'] = $req['id_sdm'];
        //         $arr[$explod[1]]['nip'] = $req['nip'];
        //         $arr[$explod[1]]['id_perilaku'] = $explod[1];
        //         $arr[$explod[1]]['idperiode'] = $req['idperiode'];
        //     }
        // }

        // foreach($arr as $id=>$dt){
        //     $cek = $this->repotrprilakupegawai->findWhereRaw("","id_perilaku = '$dt[id_perilaku]' and idperiode = '$dt[idperiode]' and id_sdm = '$dt[id_sdm]'");
        //     if($cek){
        //         $where['id'] = $cek->id;
        //         $this->repotrprilakupegawai->update($where,$dt);
        //     }else{
        //         $this->repotrprilakupegawai->store($dt);
        //     }
        // }

        //if(count($arr)>0){
            // $nilai_perilaku = $total_n_skp/$ttlkom;
            // $nilai_perilaku = round($nilai_perilaku,2);
            if($valid=="on"){
                $reqrekap['validasi']=1;
                $reqrekap['validated_at'] = date('Y-m-d H:i:s');
                $reqrekap['userid_validated'] = Session::get('id_pengguna');
            }
            if($req['ket_justifikasi']!=null){
                $reqrekap['tgl_justifikasi'] = date('Y-m-d H:i:s');
                $reqrekap['justifikasi'] = "1";
                $reqrekap['ket_justifikasi'] = $req['ket_justifikasi'];
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
        //}

        $notification = [
            'message' => 'Berhasil, Penilaian prilaku pegawai berhasil disimpan.',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
        //return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
    }


    public function show($id)
    {
        //
    }

    public function reset_penilaian($id,$id_sdm){
        $where['idperiode'] = Crypt::decrypt($id);
        $where['id_sdm'] = Crypt::decrypt($id_sdm);
        $req['nilai_skp'] = null;
        $req['validasi'] = null;
        $req['validated_at'] = null;
        $req['userid_validated'] = null;
        $req['justifikasi'] = null;
        $req['tgl_justifikasi'] = null;
        $req['ket_justifikasi'] = null;
        $this->repotrrekapskp->update($where,$req);
    }


    public function edit($id,$id_sdm)
    {
        $id = Crypt::decrypt($id);
        $id_sdm = Crypt::decrypt($id_sdm);
        $data['periodeaktif'] = $this->repomsperiodeskp->findId("",$id);
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($data['periodeaktif']->tahun);
        $data['arrBulan'] = Fungsi::nm_bulan();
        $data['dtprilaku'] = $this->repomsprilaku->get();
        $data['dtpegawai'] = $this->repomspegawai->findId(['nm_atasan_pendamping','nm_atasan','nm_satker'],$id_sdm,"id_sdm");
        $rsPrilaku = $this->repotrprilakupegawai->get("",$id_sdm,$data['periodeaktif']->id);
        $data['rekapskp'] = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$id' and id_sdm = '$id_sdm' ");
        $arrPenilaian = array();
        foreach($rsPrilaku as $rs=>$dt){
            $arrPenilaian[$dt->id_perilaku]['nilai'] = $dt['nilai'];
            $arrPenilaian[$dt->id_perilaku]['keterangan'] = $dt['keterangan'];
        }

        $arrpointpenguran['point_disiplin'] = 0;
        $arrpointpenguran['ket_disiplin'] = "";
        if(date('Ymd',strtotime($data['rekapskp']->created_at)) > date('Ymd',strtotime($data['periodeaktif']->tgl_batas_skp))){
            $keterlambatan = Fungsi::hitung_absen($data['periodeaktif']->tgl_batas_skp,date('Y-m-d',strtotime($data['rekapskp']->created_at)),"");
            $keter = $keterlambatan['jmabsen']-1;
            if($keter>5 && $keter<10){
                $arrpointpenguran['point_disiplin'] = 3;
                $arrpointpenguran['ket_disiplin'] = "Terlambat ".$keter." hari";
            }elseif($keter>=10){
                $arrpointpenguran['point_disiplin'] = 100;
                $arrpointpenguran['ket_disiplin'] = "Terlambat ".$keter." hari";
            }
        }
        $data['arrpointpenguran'] = $arrpointpenguran;
        $data['arrPenilaian'] = $arrPenilaian;
        $data['rekap_skp'] = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$id' and id_sdm = '$id_sdm' ");
        return view('content.hal_pegawai.skp.prilaku.edit',$data);
    }

    public function penilaian($id,$id_sdm)
    {
        $id = Crypt::decrypt($id);
        $id_sdm = Crypt::decrypt($id_sdm);
        $data['periodeaktif'] = $this->repomsperiodeskp->findId("",$id);
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($data['periodeaktif']->tahun);
        $data['arrBulan'] = Fungsi::nm_bulan();
        $data['dtprilaku'] = $this->repomsprilaku->get();
        $data['dtpegawai'] = $this->repomspegawai->findId(['nm_atasan_pendamping','nm_atasan','nm_satker'],$id_sdm,"id_sdm");
        $rsPrilaku = $this->repotrprilakupegawai->get("",$id_sdm,$data['periodeaktif']->id);
        $data['rekapskp'] = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$id' and id_sdm = '$id_sdm' ");
        $arrPenilaian = array();
        foreach($rsPrilaku as $rs=>$dt){
            $arrPenilaian[$dt->id_perilaku]['nilai'] = $dt['nilai'];
            $arrPenilaian[$dt->id_perilaku]['keterangan'] = $dt['keterangan'];
        }

        $arrpointpenguran['point_disiplin'] = 0;
        $arrpointpenguran['ket_disiplin'] = "";
        if(date('Ymd',strtotime($data['rekapskp']->created_at)) > date('Ymd',strtotime($data['periodeaktif']->tgl_batas_skp))){

            if(date('Ymd',strtotime($data['rekapskp']->created_at)) > date('Ymd',strtotime($data['periodeaktif']->tgl_batas_skp))){
                $arrpointpenguran['point_disiplin'] = 3;
                $keterlambatan = Fungsi::hitung_absen($data['periodeaktif']->tgl_batas_skp,date('Y-m-d',strtotime($data['rekapskp']->created_at)),"");
                $keter = $keterlambatan['jmabsen']-1;
                $arrpointpenguran['ket_disiplin'] = "Terlambat ".$keter." hari";
            }
            if(date('Ymd',strtotime($data['rekapskp']->created_at)) > date('Ymd',strtotime($data['periodeaktif']->tgl_potongan3persen))){
                $arrpointpenguran['point_disiplin'] = 100;
                $keterlambatan = Fungsi::hitung_absen($data['periodeaktif']->tgl_potongan3persen,date('Y-m-d',strtotime($data['rekapskp']->created_at)),"");
                $keter = $keterlambatan['jmabsen']-1;
                $arrpointpenguran['ket_disiplin'] = "Terlambat ".$keter." hari";
            }
        }
        $data['arrpointpenguran'] = $arrpointpenguran;
        $data['arrPenilaian'] = $arrPenilaian;
        $data['rekap_skp'] = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$id' and id_sdm = '$id_sdm' ");
        return view('content.hal_pegawai.skp.prilaku.form_penilaian',$data);
    }



    public function unggah_skp(Request $request){
        $req = $request->except('_token');
        if(Session::get('level')=="P"){
            $req['id_sdm'] = Session::get('id_sdm');
        }
        $file = $request->file('file_skp');
        $tipe = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $url = url()->previous();
        if ($tipe != 'pdf') {
            $notification = [
                    'message' => 'File harus berformat pdf',
                    'alert-type' => 'error',
                    ];
            // if(Session::get('level')=="P"){
            //     return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            // }else{
            //     return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            // }
            return redirect()->back()->with($notification);
        } elseif ($size > 2000000) {
            $notification = [
                    'message' => 'Ukuran File lebih dari 2MB',
                    'alert-type' => 'error',
                    ];
            // if(Session::get('level')=="P"){
            //     return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            // }else{
            //     return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            // }
            return redirect()->back()->with($notification);
        }
        unset($req['file_skp']);
        $name = md5($req['id_sdm']);
        $req['file_skp'] = $name.$req['idperiode'].".pdf";
        $destinationPath = 'assets/file_bukti_skp/';
        $file->move($destinationPath, $req['file_skp']);
        $cekrekapskp = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$req[idperiode]' and id_sdm = '$req[id_sdm]' ");
        if($cekrekapskp){
            $where['id'] = $cekrekapskp->id;
            $req['validasi'] = 0;
            $this->repotrrekapskp->update($where,$req);
        }else{
            $req['validasi'] = 0;
            $this->repotrrekapskp->store($req);
        }
        $notification = [
            'message' => 'Berhasil, Unggah File dokumen skp berhasil dilakukan.',
            'alert-type' => 'success',
        ];
        //return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
        return redirect()->back()->with($notification);
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
