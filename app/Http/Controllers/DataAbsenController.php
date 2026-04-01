<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrabsenkehadiran;
use App\Repositories\Repomspegawai;
use App\Models\MsAlasanAbsen;
use App\Imports\Absenkehadiranimport;
use App\Repositories\Repomsperiodeskp;
use App\Repositories\Repotrjustifikasi;
use Session;
use Fungsi;
use Crypt;
use DateTime;
use Excel;
use Illuminate\Support\Str;

class DataAbsenController extends Controller
{
    public function __construct(
        Request $request,
        Repotrabsenkehadiran $repotrabsenkehadiran,
        Repomspegawai $repomspegawai,
        Repomsperiodeskp $repomsperiodeskp,
        Repotrjustifikasi $repotrjustifikasi
    ){
        $this->request = $request;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
        $this->repomspegawai = $repomspegawai;
        $this->repomsperiodeskp = $repomsperiodeskp;
        $this->repotrjustifikasi = $repotrjustifikasi;
    }

    public function index()
    {
        $id_sdm = Session::get('id_sdm');
        $tgl_awal = Session::get('tgl_awal');
        $tgl_akhir = Session::get('tgl_akhir');
        $id_alasan = Session::get('id_alasan');
        $id_sdm_atasan = Session::get('id_sdm_atasan');
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($id_sdm,"","",$id_sdm_atasan);
        $data['pilihan_alasan_absen'] = Fungsi::pilihan_alasan_absen($id_alasan);
        $id_status = Session::get('id_status');
        $data['status_persetujuan'] = Fungsi::status_persetujuan($id_status);
        $arrIdSdm = array();
        if($id_sdm_atasan){
            $rsPegawai = $this->repomspegawai->getWhereRaw(['nm_satker','nm_golongan','nm_jns_sdm','stat_kepegawaian','nm_jab_struk','nm_jab_fung']," id_stat_aktif = '1' and (id_sdm_atasan = '$id_sdm_atasan' or id_sdm_pendamping = '$id_sdm_atasan') ","nm_sdm");
            foreach($rsPegawai as $rs=>$r){
                $arrIdSdm[$r->id_sdm] = $r->id_sdm;
            }
        }
        $rsData = $this->repotrabsenkehadiran->paginate(['dt_pegawai','r_alasan'],$id_sdm,$tgl_awal,$tgl_akhir,$id_alasan,$arrIdSdm,$id_status);
        $paging = $rsData->links();
        $totalRecord = $rsData->total();
        $data['rsData'] = $rsData;
        $data['paging'] = $paging;
        $data['totalRecord'] = $totalRecord;
        return view('content.data_pegawai.presensi.data_absen.index',$data);
    }

    public function create()
    {
        $id_sdm_atasan = Session::get('id_sdm_atasan');
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm("","","",$id_sdm_atasan);
        $data['alasan_absen'] = MsAlasanAbsen::orderBy('alasan','asc')->get();
        return view('content.data_pegawai.presensi.data_absen.tambah',$data);
    }

    public function cari(Request $request){
        $req = $request->except('_token');

        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
            $req['id_sdm'] = Session::get('id_sdm');
        }
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        if(Session::get('level')=="P"){
            return redirect()->route('data-presensi.data-absen.index');
        }else{
            return redirect()->route('data-pegawai.data-presensi.data-absen.index');
        }
    }

    public function ajuan_justifikasi_kehadiran(Request $request){
        $data['arrStatusJustifikasi'] = array("0"=>"Belum Disetujui","1"=>"Disetujui","2"=>"Tidak Disetuji");
        $rsData = $this->repomspegawai->getWhereRaw(['nm_satker','nm_golongan','nm_jns_sdm','stat_kepegawaian','nm_jab_struk','nm_jab_fung']," id_stat_aktif = '1'","nm_sdm");
        $data['rsData'] = $rsData;
        $arrIdSdm = array();
        foreach($rsData as $rs=>$r){
            $arrIdSdm[$r->id_sdm] = $r->id_sdm;
        }
        $bln = date('m');
        if(Session::get('bln')!=null){
            $bln = Session::get('bln');
        }
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $data['bulan'] = $bln;
        $data['tahun'] = $tahun;
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['pilihan_bulan_presensi'] = Fungsi::pilihan_bulan_presensi($bln);

        $tgl_terakhir = cal_days_in_month(CAL_GREGORIAN, $bln, $tahun);
        $tgl_awal = $tahun."-".$bln."-"."01";
        $tgl_akhir = $tahun."-".$bln."-".$tgl_terakhir;
        $data['getajuan_justifikasi'] = Fungsi::getajuan_justifikasiarr($arrIdSdm,$tgl_awal,$tgl_akhir,1);
        $arrRekap = array();
        foreach($data['getajuan_justifikasi'] as $id_sdm=>$dtsdm){
            foreach($dtsdm as $key=>$dtkey){
                $arrRekap[$key]['jmlh']+=$dtkey['jmlh'];
            }
        }
        $data['arrRekap'] = $arrRekap;
        return view('content.data_pegawai.history_ajuan_justifikasi_kehadiran.index',$data);
    }

    public function cari_ajuan_justifikasi_kehadiran(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->route('data-pegawai.data-presensi.pengajuan-justifikasi-kehadiran.index');
    }

    public function history_kehadiran($id_sdm,$bulan,$tahun){
        $tahunbulan = $tahun."-".$bulan;
        $data['rsData'] = $this->repotrjustifikasi->get("",Crypt::decrypt($id_sdm),$tahunbulan);
        $data['dt_pegawai'] =  $this->repomspegawai->findId("",Crypt::decrypt($id_sdm),"id_sdm");
        $data['arrnmbulan'] = Fungsi::nm_bulan();
        $data['arrkategorijustifikasi'] = Fungsi::arrkategorijustifikasi();
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;
        //dd($data['arrStatusJustifikasi']);
        return view('content.data_pegawai.history_ajuan_justifikasi_kehadiran.history',$data);
    }

    public function tolak_justifikasi($id_justifikasi){
        $notification = [
            'message' => 'Justifikasi Berhasil di tolak oleh admin.',
            'alert-type' => 'success',
        ];
        $rsData = $this->repotrjustifikasi->findId("",Crypt::decrypt($id_justifikasi),"id_justifikasi");

        $bulan = date('m',strtotime($rsData->tanggal_absen));
        $tahun = date('Y',strtotime($rsData->tanggal_absen));
        $tgl_batal = date('Y-m-d H:i:s');
        $req['ket_pembatalan_admin'] = "Dibatalkan oleh admin ".$tgl_batal;
        $req['justifikasi_atasan'] = "2";
        $where['id_justifikasi'] = Crypt::decrypt($id_justifikasi);
        $this->repotrjustifikasi->update($where,$req);

        return redirect()->intended('/data-pegawai/data-presensi/pengajuan-justifikasi-kehadiran/history/'.Crypt::encrypt($rsData->id_sdm).'/'.$bulan.'/'.$tahun)->with($notification);
    }

    public function reset_justifikasi($id_justifikasi){
        $notification = [
            'message' => 'Justifikasi Berhasil di tolak oleh admin.',
            'alert-type' => 'success',
        ];
        $rsData = $this->repotrjustifikasi->findId("",Crypt::decrypt($id_justifikasi),"id_justifikasi");

        $bulan = date('m',strtotime($rsData->tanggal_absen));
        $tahun = date('Y',strtotime($rsData->tanggal_absen));
        $tgl_batal = date('Y-m-d H:i:s');
        $req['ket_pembatalan_admin'] = null;
        $req['justifikasi_atasan'] = '0';
        $where['id_justifikasi'] = Crypt::decrypt($id_justifikasi);
        $this->repotrjustifikasi->destroy(Crypt::decrypt($id_justifikasi),'id_justifikasi');

        return redirect()->intended('/data-pegawai/data-presensi/pengajuan-justifikasi-kehadiran/history/'.Crypt::encrypt($rsData->id_sdm).'/'.$bulan.'/'.$tahun)->with($notification);
    }

    public function store(Request $request)
    {
        $req = $request->except('_token');
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')==Session::get('id_sdm')){
            $req['id_sdm'] = Session::get('id_sdm');
        }
        $file = $request->file('file_surat');
        $tipe = $file->getClientOriginalExtension();
        $size = $file->getSize();
        if ($tipe != 'pdf') {
            $notification = [
                    'message' => 'File harus berformat pdf',
                    'alert-type' => 'error',
                    ];
            if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        } elseif ($size > 2000000) {
            $notification = [
                    'message' => 'Ukuran File lebih dari 2MB',
                    'alert-type' => 'error',
                    ];
            if(Session::get('level')=="P"){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        }
        unset($req['file_surat']);
        $name = md5($req['id_sdm']).$req['id_alasan'].date('YmdHis');
        $req['file_bukti'] = $name.".pdf";
        $destinationPath = 'assets/file_bukti_absen/';
        $file->move($destinationPath, $req['file_bukti']);
        $cek = $this->repotrabsenkehadiran->findWhereRaw(""," ( tgl_awal = '$req[tgl_awal]' or tgl_akhir = '$req[tgl_awal]' ) and id_sdm = '$req[id_sdm]' ");
        if($cek){
            $notification = [
                'message' => 'Gagal, Data absen pegawai gagal ditambahkan.',
                'alert-type' => 'error',
            ];
            if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        }else{
            // cek unit kerjanya
            $cek = $this->repomspegawai->findWhereRaw("","id_sdm = '$req[id_sdm]'");
            if($cek->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                $jmlhabsen = Fungsi::hitung_absen_poli($req['tgl_awal'],$req['tgl_akhir']);
            }else{
                $jmlhabsen = Fungsi::hitung_absen($req['tgl_awal'],$req['tgl_akhir']);
            }
            $req['lama_hari'] = $jmlhabsen['jmabsen'];

            $this->repotrabsenkehadiran->store($req);
            $notification = [
                'message' => 'Berhasil, Data absen pegawai berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                return redirect()->route('data-presensi.data-absen.index')->with($notification);
            }else{
                return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
            }
        }
    }


    public function show($id)
    {
        //
    }

    public function import(){

        return view('content.data_pegawai.presensi.data_absen.import');
    }

    public function gasimport(Request $request){
        try {
            $file = request()->file('file');
            $extension = $request->file('file')->extension();
            if($extension!="xlsx"){
                $notification = [
                    'message' => 'Gagal, Tidak bisa membaca file excel.',
                    'alert-type' => 'error',
                ];
                return redirect()->route('data-pegawai.data-presensi.data-absen.import')->with($notification);
            }else{
                $rsData = Excel::toArray(new Absenkehadiranimport(), request()->file('file'));
                $arrData = array();
                unset($rsData[0][0]);
                foreach($rsData[0] as $rs=>$r){
                    $tgl_awalx = date('Y-m-d',strtotime($r[2]));
                    $tgl_akhirx = date('Y-m-d',strtotime($r[3]));
                    $jmlhabsen = Fungsi::hitung_absen($tgl_awalx,$tgl_akhirx);
                    // cek unit kerjanya
                    $nipx = trim($r[0]);
                    $cek = $this->repomspegawai->findWhereRaw("","nip = '$nipx'");
                    if($cek->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                        $jmlhabsen = Fungsi::hitung_absen_poli($tgl_awalx,$tgl_akhirx);
                    }else{
                        $jmlhabsen = Fungsi::hitung_absen($tgl_awalx,$tgl_akhirx);
                    }
                    $data['lama_hari'] = $jmlhabsen['jmabsen'];
                    $data['nip'] = trim($r[0]);
                    $data['nama'] = $r[1];
                    $data['tgl_awal'] = $tgl_awalx;
                    $data['tgl_akhir'] = $tgl_akhirx;
                    $data['kode_alasan_absen'] = $r[4];
                    $data['is_valid'] = 1;
                    $data['tgl_verifikasi'] = date('Y-m-d H:i:s');
                    $data['no_sk'] = $r[5];
                    $data['tgl_sk'] = $r[6];
                    $arrData[] = $data;
                }
                $arralasan_absen = Fungsi::arralasan_absen();
                $datagagal = array();$jberhasil = 0;
                foreach($arrData as $rsp=>$rp){
                    $cek = $this->repomspegawai->findWhereRaw("","nip = '$rp[nip]'");
                    if($cek==null){
                        $datagagal[$rp['nip']] = $rp['nama'];
                    }else{
                        //cek dulu kode alasan nya baru insert kan
                        if($arralasan_absen[$rp['kode_alasan_absen']]){
                            unset($rp['nip']);
                            unset($rp['nama']);
                            $rp['id_alasan'] = $arralasan_absen[$rp['kode_alasan_absen']];
                            unset($rp['kode_alasan_absen']);
                            $rp['id_sdm'] = $cek->id_sdm;
                            // masukkan ke ms tr_absen_kehadiran
                            // cek dulu
                            $cekdulu = $this->repotrabsenkehadiran->findWhereRaw("","id_sdm = '$cek->id_sdm' and tgl_awal='$rp[tgl_awal]' ");
                            if($cekdulu){
                                $where['id_absen'] = $cekdulu->id_absen;
                                unset($rp['id_sdm']);
                                $this->repotrabsenkehadiran->update($where,$rp);
                            }else{
                                $this->repotrabsenkehadiran->store($rp);
                            }
                            $jberhasil++;
                        }else{
                            $datagagal[$rp['nip']] = $rp['nama'];
                        }
                    }
                }
                $text = "Data berhasil dimasukkan";
                if($datagagal!=null){
                    $datagagalimp = implode(',',$datagagal);
                    Session::put('niptidakterdeteksi',$datagagal);
                    $text = "Data berhasil masuk ".$jberhasil. " ,dan ada data yang gagal di masukkan : ($datagagalimp).";
                }
                $notification = [
                    'message' => $text,
                    'alert-type' => 'success',
                ];
                return redirect()->route('data-pegawai.data-presensi.data-absen.import')->with($notification);
            }
        }catch (Exception $e) {
            $notification = [
                'message' => 'Gagal, Tidak bisa membaca file excel.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.data-presensi.data-absen.import')->with($notification);
        }
    }

    public function clear(){
        Session::forget('niptidakterdeteksi');
        return redirect()->route('data-pegawai.data-presensi.data-absen.import');
    }


    public function unggah_sk(){
        $mode = Session::get('mode');
        $text_cari = Session::get('no_sk');
        if($mode==null){
            $mode = 2;
        }
        $tmbh = "";
        if($text_cari!=null){
            $tmbh = " and no_sk like '$text_cari' ";
        }
        $data['mode'] = $mode;
        $data['text_cari'] = $text_cari;
        if($mode==1){
            $rsData = $this->repotrabsenkehadiran->getWhereRaw(['r_alasan']," file_bukti is not null and no_sk is not null $tmbh","tgl_sk");
        }else{
            $rsData = $this->repotrabsenkehadiran->getWhereRaw(['r_alasan']," file_bukti is null and no_sk is not null $tmbh","tgl_sk");
        }
        $arrData = array();$arrpenerima = array();
        foreach($rsData as $rs=>$r){
            $arrpenerima[$r->no_sk][$r->id_absen] = $r->id_absen;
            $arrData[$r->no_sk]['tgl_sk'] = $r->tgl_sk;
            $arrData[$r->no_sk]['file_bukti'] = $r->file_bukti;
            $arrData[$r->no_sk]['alasan'] = $r->r_alasan->alasan;
        }
        $data['arrpenerima'] = $arrpenerima;
        $data['arrData'] = $arrData;

        return view('content.data_pegawai.presensi.data_absen.unggah_sk',$data);
    }

    public function hapus_file($no_sk){
        $no_sk = Crypt::decrypt($no_sk);
        $where['no_sk'] = $no_sk;
        $req['file_bukti'] = null;
        $this->repotrabsenkehadiran->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.data-presensi.data-absen.unggah-sk')->with($notification);
    }

    public function cari_sk(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->route('data-pegawai.data-presensi.data-absen.unggah-sk');
    }

    public function unggah_file_sk(Request $request){
        $req = $request->except('_token');
        $data['rsData'] = $this->repotrabsenkehadiran->getWhereRaw(['r_alasan']," no_sk = '$req[no_sk]' ","tgl_sk");
        $arrData = array();
        foreach($data['rsData'] as $rs=>$r){
            $arrData[$r->no_sk] = $r->tgl_sk;
        }
        $data['arrData'] = $arrData;
        return view('content.data_pegawai.presensi.data_absen.form_unggah_sk',$data);
    }


    public function unggah_file_sk_simpan(Request $request){
        $req = $request->except('_token');
        $file = request()->file('file');
        $uuid = (string) Str::uuid();
        $req['file_bukti'] = $uuid.".pdf";
        $destinationPath = 'assets/file_bukti_absen/';
        $file->move($destinationPath, $req['file_bukti']);
        unset($req['file']);
        $where['no_sk'] = $req['no_sk'];
        $this->repotrabsenkehadiran->update($where,$req);
        $notification = [
            'message' => "Berhasil, File sk ".$req['no_sk']." berhasil disimpan.",
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.data-presensi.data-absen.unggah-sk')->with($notification);
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrabsenkehadiran->findId("",$id,"id_absen");
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($rsData->id_sdm);
        $data['pilihan_alasan_absen'] = Fungsi::pilihan_alasan_absen($rsData->id_alasan);
        $data['rsData'] = $rsData;
        return view('content.data_pegawai.presensi.data_absen.edit',$data);
    }

    public function verifikasi($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrabsenkehadiran->findId("",$id,"id_absen");
        $data['pilihan_sdm'] = Fungsi::pilihan_sdm($rsData->id_sdm);
        $data['pilihan_verifikasi'] = Fungsi::pilihan_verifikasi();
        $data['pilihan_alasan_absen'] = Fungsi::pilihan_alasan_absen($rsData->id_alasan);
        $data['rsData'] = $rsData;
        return view('content.data_pegawai.presensi.data_absen.verifikasi',$data);
    }


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id_absen = $req['id_absen'];
        $file = $request->file('file_surat');

        if($file){
            $tipe = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $url = url()->previous();
            if ($tipe != 'pdf') {
                $notification = [
                        'message' => 'File harus berformat pdf',
                        'alert-type' => 'error',
                        ];
                if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                    return redirect()->intended('/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }
            } elseif ($size > 2000000) {
                $notification = [
                        'message' => 'Ukuran File lebih dari 2MB',
                        'alert-type' => 'error',
                        ];
                if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
                    return redirect()->intended('/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/data-presensi/data-absen/edit/'.Crypt::encrypt($id_absen))->with($notification);
                }
            }
            unset($req['file_surat']);
            $name = md5($req['id_sdm']).$req['id_alasan'].date('YmdHis');
            $req['file_bukti'] = $name.".pdf";
            $destinationPath = 'assets/file_bukti_absen/';
            $file->move($destinationPath, $req['file_bukti']);
        }
        $where['id_absen'] = $id_absen;
        // cek unit kerjanya
        $cekunit = $this->repotrabsenkehadiran->findId(['dt_pegawai'],$id_absen,"id_absen");
        if($cekunit->dt_pegawai->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
            $jmlhabsen = Fungsi::hitung_absen_poli($req['tgl_awal'],$req['tgl_akhir']);
        }else{
            $jmlhabsen = Fungsi::hitung_absen($req['tgl_awal'],$req['tgl_akhir']);
        }
        $req['lama_hari'] = $jmlhabsen['jmabsen'];
        $this->repotrabsenkehadiran->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil diupdate.',
            'alert-type' => 'success',
        ];
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
            return redirect()->route('data-presensi.data-absen.index')->with($notification);
        }else{
            return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
        }
    }

    public function simpan_verifikasi(Request $request)
    {
        $req = $request->except('_token');
        $id_absen = $req['id_absen'];
        $req['tgl_verifikasi'] = date('Y-m-d H:i:s');
        $where['id_absen'] = $id_absen;
        $this->repotrabsenkehadiran->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil diverifikasi.',
            'alert-type' => 'success',
        ];
        return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $rsData = $this->repotrabsenkehadiran->destroy($id,"id_absen");
        $notification = [
            'message' => 'Berhasil, Data absen pegawai berhasil dihapus.',
            'alert-type' => 'success',
        ];
        if(Session::get('level')=="P" && Session::get('id_sdm_atasan')!=Session::get('id_sdm')){
            return redirect()->intended('pegawai/riwayat-absen/'.Crypt::encrypt(Session::get('id_sdm')))->with($notification);
        }
        else{
            return redirect()->route('data-pegawai.data-presensi.data-absen.index')->with($notification);
        }
    }
}
