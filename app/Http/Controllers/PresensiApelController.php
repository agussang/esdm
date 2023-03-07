<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomskegiatanapel;
use App\Repositories\Repopresensiapel;
use App\Repositories\Repomspegawai;
use App\Exports\TemplatePresensiApelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PresensiApelImport;
use Crypt;
use Fungsi;
use Session;

class PresensiApelController extends Controller
{
    public function __construct(
        Request $request,
        Repomskegiatanapel $repomskegiatanapel,
        Repopresensiapel $repopresensiapel,
        Repomspegawai $repomspegawai
    ){
        $this->request = $request;
        $this->repomskegiatanapel = $repomskegiatanapel;
        $this->repopresensiapel = $repopresensiapel;
        $this->repomspegawai = $repomspegawai;
    }

    public function index()
    {
        $text = Session::get('cari_kegiatan');
        $tgl_kegiatan = Session::get('tgl_kegiatan');
        $rsData= $this->repomskegiatanapel->paginate(['peserta'],$tgl_kegiatan,$text);
        $arrDataPesertaApel = array();
        foreach($rsData as $rs=>$r){
            foreach($r->peserta as $rsp=>$rp){
                if($rp->dt_pegawai->id_stat_aktif=="1"){
                    $arrDataPesertaApel[$r->id_kegiatan][$rp->kehadiran][$rp->id_presensi] = $rp->id_presensi;
                }
            }
        }
        $paging = $rsData->links();
        $totalRecord = $rsData->total();
        $data['rsData'] = $rsData;
        $data['paging'] = $paging;
        $data['totalRecord'] = $totalRecord;
        $data['arrDataPesertaApel'] = $arrDataPesertaApel;
        return view('content.data_pegawai.presensi.data_apel.index',$data);
    }

    public function upload(Request $request){
        $array = Excel::toArray(new PresensiApelImport(), request()->file('file_excel'));
        unset($array[0][0]);
        unset($array[0][1]);
        unset($array[0][2]);
        unset($array[0][3]);
        unset($array[0][4]);
        unset($array[0][5]);
        unset($array[0][6]);
        $req = $request->except('_token');
        $xls = $array[0];
        $arrData = array();$pegawaiblumada = array();
        foreach ($xls as $rx) {
            $nip = str_replace(" ",'',trim($rx[2]));
            $cekidsdm = $this->repomspegawai->findId("",$nip,"nip");
            if($cekidsdm){
                $data['id_sdm'] = $cekidsdm->id_sdm;
                $data['id_kegiatan'] = $req['id_kegiatan'];
                $data['kehadiran'] = $rx[5];
                $data['keterangan'] = $rx[6];
                $arrData[] = $data;
            }else{
                $dtgagal['nip'] = $nip;
                $dtgagal['nama'] = $rx[1];
                $pegawaiblumada[] = $dtgagal;
            }
        }
        $jberhasil = 0;$jgagal=0;
        if(count($arrData)>0){
            foreach($arrData as $rs=>$dt){
                $jberhasil++;
                $where['id_sdm'] = $dt['id_sdm'];
                $where['id_kegiatan'] = $dt['id_kegiatan'];
                $cek = $this->repopresensiapel->findWhereRaw("","id_kegiatan = '$dt[id_kegiatan]' and id_sdm = '$dt[id_sdm]' ");
                if($cek){
                    $this->repopresensiapel->update($where,$dt);
                }else{
                    $this->repopresensiapel->store($dt);
                }
            }
        }
        if(count($pegawaiblumada)>0){
            Session::put('pegawaiapelbelumada',$pegawaiblumada);
            $jgagal+=count($pegawaiblumada);
        }
        $notification = [
            'message' => 'Berhasil, Upload data finger berhasil dilakukan. '.$jberhasil." Berhasil di upload, ".$jgagal." gagal diupload.",
            'alert-type' => 'success',
        ];
        return redirect()->intended('data-pegawai/data-presensi/apel/peserta/'.Crypt::encrypt($req['id_kegiatan']))->with($notification);
    }

    public function peserta($id){
        $id_kegiatan = Crypt::decrypt($id);
        $data['rsData'] = $this->repomskegiatanapel->findId("",$id_kegiatan,"id_kegiatan");
        $data['peserta'] = $this->repopresensiapel->get(['dt_pegawai'],$id_kegiatan);
        $arrGrafik = array();
        foreach($data['peserta'] as $rs=>$r){
            $text = "Hadir";
            if($r->kehadiran=="T" || $r->kehadiran=="TH"){
                $text = "Tidak Hadir";
            }
            $data['kehadiran'][$text]+=1;
            $data['text_kehadiran'][$text] = $text;
            $data['kehadiran_jk'][$r->dt_pegawai->jk][$text]+=1;
        }
        return view('content.data_pegawai.presensi.data_apel.peserta.index',$data);
    }


    public function create()
    {
        return view('content.data_pegawai.presensi.data_apel.tambah',$data);
    }

    public function download_template($id){
        $id = Crypt::decrypt($id);
        $data['rsData'] = $this->repomspegawai->get(['nm_jns_sdm','stat_kepegawaian','stat_aktif','nm_agama'],1);
        $data['info_kegiatan'] = $this->repomskegiatanapel->findId("",$id,"id_kegiatan");
        return Excel::download(new TemplatePresensiApelExport($data), 'template_presensi_kegiatan.xlsx');
    }

    public function clear($id){
        Session::forget('pegawaiapelbelumada');
        return redirect()->intended('data-pegawai/data-presensi/apel/peserta/'.$id);
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
        return redirect()->route('data-pegawai.data-presensi.apel.index');
    }


    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomskegiatanapel->findWhereRaw(""," nama_kegiatan = '$req[nama_kegiatan]' and tgl_kegiatan = '$req[tgl_kegiatan]'");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kegiatan tersebut sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.data-presensi.apel.tambah')->with($notification);
        }else{
            $save = $this->repomskegiatanapel->store($req);
            $notification = [
                'message' => 'Berhasil, Data Kegiatan Apel berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-pegawai.data-presensi.apel.index')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomskegiatanapel->findId("",$req,"id_kegiatan");
        return view('content.data_pegawai.presensi.data_apel.edit',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repomskegiatanapel->findWhereRaw(""," nama_kegiatan = '$req[nama_kegiatan]' and tgl_kegiatan = '$req[tgl_kegiatan]' and id_kegiatan != '$req[id_kegiatan]' ");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kegiatan tersebut sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.data-presensi.apel.index')->with($notification);
        }else{
            $where['id_kegiatan'] = $req['id_kegiatan'];
            unset($req['id_kegiatan']);
            $update = $this->repomskegiatanapel->update_or_create($where,$req);
            $notification = [
                'message' => 'Berhasil, Data Kegiatan Apel berhasil diupdate.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-pegawai.data-presensi.apel.index')->with($notification);
        }
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $rsPresensiApel = $this->repopresensiapel->findId("",$id,"id_kegiatan");
        if($rsPresensiApel){
            $notification = [
                'message' => 'Gagal, Data Kegiatan Apel gagal dihapus, dikarenakan record data presensi sudah di unggah.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.data-presensi.apel.index')->with($notification);
        }else{
            $this->repomskegiatanapel->destroy($id,"id_kegiatan");
            $notification = [
                'message' => 'Berhasil, Data Kegiatan Apel berhasil dihapus.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-pegawai.data-presensi.apel.index')->with($notification);
        }
    }
}
