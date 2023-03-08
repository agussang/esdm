<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsgrade;
use App\Repositories\Repoprosentase;
use App\Models\MsProsentaseRealisasi;
use Crypt;
use Fungsi;

class MasterGradeController extends Controller
{
    public function __construct(
        Request $request,
        Repomsgrade $repomsgrade,
        Repoprosentase $repoprosentase
    ){
        $this->request = $request;
        $this->repomsgrade = $repomsgrade;
        $this->repoprosentase = $repoprosentase;
    }

    public function index()
    {
        $data['rsData'] = $this->repomsgrade->get();
        $dtpersen1 = $this->repoprosentase->findWhereRaw("","is_aktif='1' and kode_p = '1' ");
        $dtpersen2 = $this->repoprosentase->findWhereRaw("","is_aktif='1' and kode_p = '2' ");
        $data['pilihan_prosentase_realisasi_p1'] = Fungsi::pilihan_prosentase_realisasi($dtpersen1->id_prosentase,'1');
        $data['pilihan_prosentase_realisasi_p2'] = Fungsi::pilihan_prosentase_realisasi($dtpersen2->id_prosentase,'2');
        return view('content.master.grade.index',$data);
    }

    public function update_realisasi_p1(Request $request){
        $req = $request->except('_token');
        $ambilnilai = $this->repoprosentase->findId("",$req,"id_prosentase");
        $nilai = $ambilnilai->nilai;
        $rsData = $this->repomsgrade->get();
        $arrData = array();
        foreach($rsData AS $rs=>$r){
            if($r->jobscore > 0 && $r->jobprice > 0){
                $persenp1=30;
                $persenrealisasip1 = $nilai;
                $p1 = round((($r->jobscore*$r->jobprice)*$persenp1)/100);
                $realp1 = round((($p1*$persenrealisasip1)/100),-3);
                $realp2 = $r->realisasi_p2;
                $arrData[$r->id]['grade'] = $r->grade;
                $arrData[$r->id]['realisasi_p1'] = $realp1;
                $arrData[$r->id]['total_realisasi'] = $realp1+$realp2;
            }
        }
        foreach($arrData as $id_grade=>$dtgrade){
            $where['id'] = $id_grade;
            unset($dtgrade['grade']);
            $this->repomsgrade->update($where,$dtgrade);
        }
        $wherepro['id_prosentase'] = $ambilnilai->id_prosentase;
        $reqpro['is_aktif'] = '1';
        $update = $this->repoprosentase->update($wherepro,$reqpro);
        $updatenot = MsProsentaseRealisasi::where('id_prosentase','<>',$ambilnilai->id_prosentase)->where('kode_p',1)->update(['is_aktif'=>'0']);
        echo '<script type="text/javascript">toastr.success("Data grade berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
    }

    public function update_realisasi_p2(Request $request){
        $req = $request->except('_token');
        $ambilnilai = $this->repoprosentase->findId("",$req,"id_prosentase");
        $nilai = $ambilnilai->nilai;
        $rsData = $this->repomsgrade->get();

        $arrData = array();
        foreach($rsData AS $rs=>$r){
            if($r->jobscore > 0 && $r->jobprice > 0){
                $persenp2=70;
                $persenrealisasip2 = $nilai;
                $p2 = round((($r->jobscore*$r->jobprice)*$persenp2)/100);
                $realp1 = $r->realisasi_p1;
                $realp2 = round((($p2*$persenrealisasip2)/100),-3);
                $arrData[$r->id]['grade'] = $r->grade;
                $arrData[$r->id]['realisasi_p2'] = $realp2;
                $arrData[$r->id]['total_realisasi'] = $realp1+$realp2;
            }
        }
        foreach($arrData as $id_grade=>$dtgrade){
            $where['id'] = $id_grade;
            unset($dtgrade['grade']);
            $this->repomsgrade->update($where,$dtgrade);
        }
        $wherepro['id_prosentase'] = $ambilnilai->id_prosentase;
        $reqpro['is_aktif'] = '1';
        $update = $this->repoprosentase->update($wherepro,$reqpro);
        $updatenot = MsProsentaseRealisasi::where('id_prosentase','<>',$ambilnilai->id_prosentase)->where('kode_p',2)->update(['is_aktif'=>'0']);
        echo '<script type="text/javascript">toastr.success("Data grade berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsgrade->findId("",$req['grade'],"grade");
        if($cek){
            $notification = [
                    'message' => 'Data grade yang anda masukkan sudah ada',
                    'alert-type' => 'error',
                    ];
            return redirect()->route('data-master.grade')->with($notification);
        }else{
            $persenp1=30;
            $persenp2=70;
            $dtpersen1 = $this->repoprosentase->findWhereRaw("","is_aktif='1' and kode_p = '1' ");
            $dtpersen2 = $this->repoprosentase->findWhereRaw("","is_aktif='1' and kode_p = '2' ");
            $persenrealisasip1 = $dtpersen1->nilai;
            $persenrealisasip2 =  $dtpersen2->nilai;
            $p1 = round((($req['jobscore']*$req['jobprice'])*$persenp1)/100);
            $p2 = round((($req['jobscore']*$req['jobprice'])*$persenp2)/100);
            $realp1 = round((($p1*$persenrealisasip1)/100),-3);
            $realp2 = round((($p2*$persenrealisasip2)/100),-3);
            $req['gaji_p1'] = $p1;
            $req['insentif_p2'] = $p2;
            $req['total_remun'] = round($p1+$p2);
            $req['realisasi_p1'] = $realp1;
            $req['realisasi_p2'] = $realp2;
            $req['total_realisasi'] = $realp1+$realp2;
            $this->repomsgrade->store($req);
            $notification = [
                    'message' => 'Data grade berhasil dimasukkan',
                    'alert-type' => 'success',
                    ];
            return redirect()->route('data-master.grade')->with($notification);
        }
    }


    public function show($id)
    {

    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomsgrade->findId("",$req,"id");
        return view('content.master.grade.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomsgrade->findWhereRaw("","grade = '$req[grade]' and id <> '$req[id]'");

        if($cek){
            echo '<script type="text/javascript">toastr.error("Data grade yang anda masukkan sudah ada")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }else{
            $persenp1=30;
            $persenp2=70;
            $dtpersen1 = $this->repoprosentase->findWhereRaw("","is_aktif='1' and kode_p = '1' ");
            $dtpersen2 = $this->repoprosentase->findWhereRaw("","is_aktif='1' and kode_p = '2' ");
            $persenrealisasip1 = $dtpersen1->nilai;
            $persenrealisasip2 =  $dtpersen2->nilai;
            $p1 = round((($req['jobscore']*$req['jobprice'])*$persenp1)/100);
            $p2 = round((($req['jobscore']*$req['jobprice'])*$persenp2)/100);
            $realp1 = round((($p1*$persenrealisasip1)/100),-3);
            $realp2 = round((($p2*$persenrealisasip2)/100),-3);
            $req['gaji_p1'] = $p1;
            $req['insentif_p2'] = $p2;
            $req['total_remun'] = round($p1+$p2);
            $req['realisasi_p1'] = $realp1;
            $req['realisasi_p2'] = $realp2;
            $req['total_realisasi'] = $realp1+$realp2;
            $where['id'] = $req['id'];
            unset($req['id']);
            $this->repomsgrade->update($where,$req);
            echo '<script type="text/javascript">toastr.success("Data grade berhasil di update")</script>';
            echo "<script>
            setTimeout(function () {
            location.reload();
            }, 2000);
            </script>";
        }
    }

    public function tmp_grade(Request $request){
        $req = $request->except('_token');
        $rsData = $this->repomsgrade->findId("",$req,"id");
        $p1 = number_format($rsData->gaji_p1);
        $p2 = number_format($rsData->insentif_p2);
        echo "<script>document.getElementById(\"jobscore\").value = \"$rsData->jobscore\";</script>";
        echo "<script>document.getElementById(\"jobprice\").value = \"$rsData->jobprice\";</script>";
        echo "<script>document.getElementById(\"p1\").value = \"$p1\";</script>";
        echo "<script>document.getElementById(\"p2\").value = \"$p2\";</script>";
    }
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repomsgrade->destroy($id,"id");
        $notification = [
            'message' => 'Berhasil, Data master grade berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-master.grade')->with($notification);
    }
}
