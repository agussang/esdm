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
        }
        $data['arrRekapskp'] = $arrRekapskp;
        $data['dtpegawai'] = $this->repomspegawai->findId(['nm_atasan_pendamping','nm_atasan','nm_satker'],$id_sdm,"id_sdm");
        return view('content.hal_pegawai.skp.prilaku.index',$data);
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
        $dtprilaku = $this->repomsprilaku->get();
        $arr = array();
        $total_n_skp = 0;$ttlkom = 0;
        foreach($req as $id=>$value){
            $explod = explode("_",$id);
            if($explod[0]=="nilai"){
                $ttlkom++;
                $n_skp = str_replace(',','.',$value);
                $total_n_skp+=$n_skp;
                $arr[$explod[1]]['nilai'] = $n_skp;
                $arr[$explod[1]]['id_sdm'] = $req['id_sdm'];
                $arr[$explod[1]]['nip'] = $req['nip'];
                $arr[$explod[1]]['id_perilaku'] = $explod[1];
                $arr[$explod[1]]['idperiode'] = $req['idperiode'];
            }if($explod[0]=="keterangan"){
                $arr[$explod[1]]['keterangan'] = str_replace(',','.',$value);
                $arr[$explod[1]]['id_sdm'] = $req['id_sdm'];
                $arr[$explod[1]]['nip'] = $req['nip'];
                $arr[$explod[1]]['id_perilaku'] = $explod[1];
                $arr[$explod[1]]['idperiode'] = $req['idperiode'];
            }
        }

        foreach($arr as $id=>$dt){
            $cek = $this->repotrprilakupegawai->findWhereRaw("","id_perilaku = '$dt[id_perilaku]' and idperiode = '$dt[idperiode]' and id_sdm = '$dt[id_sdm]'");
            if($cek){
                $where['id'] = $cek->id;
                $this->repotrprilakupegawai->update($where,$dt);
            }else{
                $this->repotrprilakupegawai->store($dt);
            }
        }

        if(count($arr)>0){
            $nilai_perilaku = $total_n_skp/$ttlkom;
            $nilai_perilaku = round($nilai_perilaku,2);
            if($valid=="on"){
                $reqrekap['validasi']=1;
                $reqrekap['validated_at'] = date('Y-m-d H:i:s');
                $reqrekap['userid_validated'] = Session::get('id_pengguna');
            }
            $reqrekap['id_sdm'] = $req['id_sdm'];
            $reqrekap['nip'] = $req['nip'];
            $reqrekap['nilai_skp'] = $nilai_skp;
            $reqrekap['idperiode'] = $req['idperiode'];
            $reqrekap['nilai_perilaku'] = $nilai_perilaku;
            $cekrekapskp = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$req[idperiode]' and id_sdm = '$req[id_sdm]' ");
            if($cekrekapskp){
                $where['id'] = $cekrekapskp->id;
                $this->repotrrekapskp->update($where,$reqrekap);
            }else{
                $this->repotrrekapskp->store($reqrekap);
            }
        }

        $notification = [
            'message' => 'Berhasil, Penilaian prilaku pegawai berhasil disimpan.',
            'alert-type' => 'success',
        ];
        return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
    }

    
    public function show($id)
    {
        //
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
        $data['arrPenilaian'] = $arrPenilaian;
        $data['rekap_skp'] = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$id' and id_sdm = '$id_sdm' ");
        return view('content.hal_pegawai.skp.prilaku.edit',$data);
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
            if(Session::get('level')=="P"){
                return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            }else{
                return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            }
        } elseif ($size > 2000000) {
            $notification = [
                    'message' => 'Ukuran File lebih dari 2MB',
                    'alert-type' => 'error',
                    ];
            if(Session::get('level')=="P"){
                return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            }else{
                return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            }
        }
        unset($req['file_skp']);
        $name = md5($req['id_sdm']);
        $req['file_skp'] = $name.$req['idperiode'].".pdf";
        $destinationPath = 'assets/file_bukti_skp/';
        $file->move($destinationPath, $req['file_skp']);
        $cekrekapskp = $this->repotrrekapskp->findWhereRaw(""," idperiode = '$req[idperiode]' and id_sdm = '$req[id_sdm]' ");
        if($cekrekapskp){
            $where['id'] = $cekrekapskp->id;
            $req['valid'] = 0;
            $this->repotrrekapskp->update($where,$req);
        }else{
            $req['valid'] = 0;
            $this->repotrrekapskp->store($req);
        }
        $notification = [
            'message' => 'Berhasil, Unggah File dokumen skp berhasil dilakukan.',
            'alert-type' => 'success',
        ];
        return redirect()->intended('/skp-pegawai/skp/isi/'.Crypt::encrypt($req['idperiode']).'/'.Crypt::encrypt($req['id_sdm']))->with($notification);

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
