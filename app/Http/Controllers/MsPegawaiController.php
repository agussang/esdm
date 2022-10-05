<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use App\Repositories\Repomspegawainew;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repopresensiapel;
use App\Repositories\Repotrabsenkehadiran;
use App\Repositories\Repotrjustifikasi;
use Crypt;
use Fungsi;
use Session;
use DB;
error_reporting(0);
function bulan($idbln){
    $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    return $bulan[$idbln];
}
class MsPegawaiController extends Controller
{
    public function __construct(
        Request $request,
        Repomspegawai $repomspegawai,
        Repomspegawainew $repomspegawainew,
        Reporiwayatpresensi $reporiwayatpresensi,
        Repopresensiapel $repopresensiapel,
        Repotrabsenkehadiran $repotrabsenkehadiran,
        Repotrjustifikasi $repotrjustifikasi
    ){
        $this->request = $request;
        $this->repomspegawai = $repomspegawai;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawainew = $repomspegawainew;
        $this->repopresensiapel = $repopresensiapel;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
        $this->repotrjustifikasi = $repotrjustifikasi;
    }

    public function index(Request $request)
    {
        // $arrBulan = array("Jan"=>"01","Feb"=>"02","Mar"=>"03","Apr"=>"04","Mei"=>"05","Jun"=>"06","Jul"=>"07","Agu"=>"08","Sep"=>"09","Nov"=>"10","Okt"=>"11","Des"=>"12");
        // $rsData = DB::table('data_pegawai_excel as a')->get();
        // $arrJabatan = Fungsi::jabatan();
        // $arrData = array();
        // foreach($rsData as $rs=>$r){
        //     $nip = str_replace(" ","",$r->nip);
        //     $nip = trim($nip);
        //     if($nip){
        //         $cek = $this->repomspegawai->findId("",$nip,"nip");
        //         if($cek){
        //             $arrData[$r->nama]['id_sdm'] = $cek->id_sdm;   
        //             $arrData[$r->nama]['tmpt_lahir'] = $cek->tmpt_lahir;   
        //             $arrData[$r->nama]['tgl_lahir'] = $cek->tgl_lahir;   
        //             $arrData[$r->nama]['nm_ibu_kandung'] = $cek->nm_ibu_kandung;  
        //             $arrData[$r->nama]['nik'] =  $cek->nik;
        //             $arrData[$r->nama]['nidn'] = $cek->nidn;
        //             $arrData[$r->nama]['jln'] = $cek->jln;
        //             $arrData[$r->nama]['rt'] = $cek->rt;
        //             $arrData[$r->nama]['rw'] = $cek->rw;
        //             $arrData[$r->nama]['nm_dsn'] = $cek->nm_dsn;
        //             $arrData[$r->nama]['ds_kel'] = $cek->ds_kel;
        //             $arrData[$r->nama]['kode_pos'] = $cek->kode_pos;
        //             $arrData[$r->nama]['no_hp'] = $cek->no_hp;
        //             $arrData[$r->nama]['email'] = $cek->email;
        //             $arrData[$r->nama]['no_sk_cpns'] = $cek->no_sk_cpns;
        //             $arrData[$r->nama]['no_sk_pns'] = $cek->no_sk_pns;
        //             $arrData[$r->nama]['npwp'] = $cek->npwp;
        //             $arrData[$r->nama]['kewarganegaraan'] = $cek->kewarganegaraan;
        //             $arrData[$r->nama]['id_stat_kepegawaian'] = $cek->id_stat_kepegawaian;
        //             $arrData[$r->nama]['id_stat_aktif'] = $cek->id_stat_aktif;
        //             $arrData[$r->nama]['id_agama'] = $cek->id_agama;
        //             $arrData[$r->nama]['id_jns_sdm'] = $cek->id_jns_sdm;
        //             $arrData[$r->nama]['nm_suami_istri'] = $cek->nm_suami_istri;
        //             $arrData[$r->nama]['cek_siakadu'] = 1;
        //             $arrData[$r->nama]['id_stat_kepegawaian'] = "eb592b52-58d8-4dfc-ac7d-c41c7cea695e";
        //         }
        //     }
        //     $arrData[$r->nama]['nm_sdm'] = $r->nama;
        //     $arrData[$r->nama]['jk'] = $r->jk;
        //     $arrData[$r->nama]['id_stat_kawin'] = $r->status_kawin;
        //     $arrData[$r->nama]['nip'] = $nip;
        //     $arrData[$r->nama]['id_kedinasan'] = $r->kedinasan;
        //     $arrData[$r->nama]['id_pendidikan_terakhir'] = $r->pendidikan_terakhir;
        //     if($r->tmt_cpns!=null){
        //         $extmptcpns = explode(" ",$r->tmt_cpns);
        //         $tgl_cpns = $extmptcpns[2]."-".$arrBulan[$extmptcpns[1]]."-".$extmptcpns[0];
        //         $arrData[$r->nama]['tgl_tmt_cpns'] = $tgl_cpns;
        //     }
        //     if($r->tmt_cpns!=null){
        //         $extmptpns = explode(" ",$r->tmt_pns);
        //         $tgl_pns = $extmptpns[2]."-".$arrBulan[$extmptpns[1]]."-".$extmptpns[0];
        //         $arrData[$r->nama]['tgl_tmt_pns'] = $tgl_pns;
        //     }
        //     $cek_jabatan = $arrJabatan[$r->nama_jabatan];
        //     if($cek_jabatan=="S"){
        //         $arrData[$r->nama]['id_jabatan_struktural_now'] = $r->nama_jabatan;
        //     }
        //     if($cek_jabatan=="F"){
        //         $arrData[$r->nama]['id_jabatan_fungsional_now'] = $r->nama_jabatan;
        //     }
        //     if($r->golongan){
        //         $arrData[$r->nama]['id_golongannow'] = $r->golongan;
        //     }
        //     $arrData[$r->nama]['no_kartu_pegawai'] = $r->no_pegawai;
        // }
        // foreach($arrData as $nm=>$req){
        //     $save = $this->repomspegawainew->store($req);
        // }
        // exit();


        $id_stat_aktif = Session::get('id_stat_aktif');
        $id_stat_kepeg = Session::get('id_stat_kepeg');
        $id_satkernow = Session::get('id_satkernow');
        $id_jns_sdm = Session::get('id_jns_sdm');
        $nama_pegawai = Session::get('nama_pegawai');
        $rsData = $this->repomspegawai->paginate(['nm_jab_struk','nm_jab_fung','nm_golongan','nm_jns_sdm','stat_kepegawaian','stat_aktif','nm_agama'],$id_stat_aktif, $id_stat_kepeg, $id_satkernow, $id_jns_sdm, $nama_pegawai);
        $data['pilihan_status_keaktifan'] = Fungsi::pilihan_status_keaktifan();
        $data['pilihan_status_kepegawaian'] = Fungsi::pilihan_status_kepegawaian();
        $data['pilihan_jns_sdm'] = Fungsi::pilihan_jns_sdm();
        $data['pilihan_status_kepegawaian'] = Fungsi::pilihan_status_kepegawaian();
        $data['pilihan_jabatan'] = Fungsi::pilihan_jabatan();
        $data['pilihan_satker'] = Fungsi::pilihan_satker();
        $paging = $rsData->links();
        $totalRecord = $rsData->total();
        $data['rsData'] = $rsData;
        $data['paging'] = $paging;
        $data['totalRecord'] = $totalRecord;
        //dd($rsData);
        return view('content.data_pegawai.index',$data);
    }

    public function riwayat_kehadiran($id_sdm){
        $id_sdm = Crypt::decrypt($id_sdm);
        $rsData = $this->repomspegawai->first("",$id_sdm);
        $data['rsData'] = $rsData;
        $arrIdSdm[$rsData->id_sdm] = $rsData->id_sdm;
        $bln = "08";
        if(Session::get('bln')!=null){
            $bln = Session::get('bln');
        }
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $terakhir = cal_days_in_month(CAL_GREGORIAN, $bln, $tahun);
        $tgl_awal = $tahun."-".$bln."-01";
        $tgl_terakhir = $tahun."-".$bln."-".$terakhir;
        $jam_kerja = Fungsi::jam_kerja_unit($rsData->id_satkernow);
        $getRekapDataAbsen = Fungsi::get_rekap_data_kehadiran($jam_kerja,$tgl_awal,$tgl_terakhir,$arrIdSdm,1);
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['pilihan_bulan_presensi'] = Fungsi::pilihan_bulan_presensi($bln);
        
        $data['jam_kerja_unit'] = $jam_kerja;
        $data['kategoriwaktuabsen'] = Fungsi::kategoriwaktuabsen();
        $arrAbsen = array();$data_bul = array();
        $data['arrData'] = $getRekapDataAbsen[$rsData->id_sdm];
        $rekap = Fungsi::get_rekap_data_kehadiran($jam_kerja,$tgl_awal,$tgl_terakhir,$arrIdSdm,4);
        $data['thn_bulan'] = $tahun."-".$bln;
        $gbng = $tahun.$bln;
        $data['rekap'] = $rekap[$rsData->id_sdm][$gbng];
        //dd($data['rekap']);
        return view('content.data_pegawai.riwayat.presensi_kehadiran.index',$data);
    }

    public function riwayat_apel($id_sdm){
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $id_sdm = Crypt::decrypt($id_sdm);
        $data['dt_pegawai'] = $this->repomspegawai->first("",$id_sdm);
        $data['rsData'] = $this->repopresensiapel->get(['nm_kegiatan_apel'],"",$id_sdm,$tahun);
        $data['id_sdm'] = $id_sdm;
        return view('content.data_pegawai.riwayat.apel.index',$data);
    }

    public function riwayat_absen($id_sdm){
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['pilihan_tahun_absen'] = Fungsi::pilihan_tahun_absen($tahun);
        $id_sdm = Crypt::decrypt($id_sdm);
        $data['dt_pegawai'] = $this->repomspegawai->first("",$id_sdm);
        $data['id_sdm'] = $id_sdm;
        $data['rsData'] = $this->repotrabsenkehadiran->getpertahun(['alasan'],$tahun,$id_sdm);
        return view('content.data_pegawai.riwayat.absen.index',$data);
    }

    public function cari_kehadiran(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai/riwayat-kehadiran/'.Crypt::encrypt($req['id_sdm']));
    }

    public function cari_absen(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai/riwayat-absen/'.Crypt::encrypt($req['id_sdm']));
    }

    public function cari_apel(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai/riwayat-apel/'.Crypt::encrypt($req['id_sdm']));
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
        return redirect()->route('data-pegawai.master-pegawai.index');
    }

    public function cari_kehadiran_bawahan(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai-bawahan/riwayat-kehadiran/'.Crypt::encrypt($req['id_sdm']));
    }

    public function cari_absen_bawahan(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai-bawahan/riwayat-absen/'.Crypt::encrypt($req['id_sdm']));
    }

    public function cari_apel_bawahan(Request $request){
        $req = $request->except('_token');
        foreach ($req as $k => $v) {
            if ($v != null) {
                Session::put($k, $v);
            } else {
                Session::forget($k);
            }
        }
        return redirect()->intended('/pegawai-bawahan/riwayat-apel/'.Crypt::encrypt($req['id_sdm']));
    }

    public function create()
    {
        $data['pilihan_jenis_kelamin'] = Fungsi::pilihan_jenis_kelamin();
        $data['pilihan_jns_sdm'] = Fungsi::pilihan_jns_sdm();
        $data['pilihan_status_kepegawaian'] = Fungsi::pilihan_status_kepegawaian();
        $data['pilihan_status_keaktifan'] = Fungsi::pilihan_status_keaktifan();
        $data['pilihan_status_kawin'] = Fungsi::pilihan_status_kawin();
        $data['pilihan_agama'] = Fungsi::pilihan_agama();
        return view('content.data_pegawai.tambah',$data);
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $ceknip = $this->repomspegawai->findId("",$req['nip'],"nip");
        if($ceknip!=null){
            $notification = [
                'message' => 'Gagal, Nip yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-pegawai.master-pegawai.tambah')->withInput()->with($notification);
        }else{
            $bisa = 1;
            if($req['nidn']){
                $ceknidn = $this->repomspegawai->findId("",$req['nidn'],"nidn");
                if($ceknidn){
                    $bisa=0;
                }else{
                    $bisa = 1;
                }
            }
            if($bisa==1){
                $save = $this->repomspegawai->store($req);
                $notification = [
                    'message' => 'Berhasil, Data pegawai yang ada masukkan berhasil disimpan.',
                    'alert-type' => 'success',
                ];
                return redirect()->route('data-pegawai.master-pegawai.index')->with($notification);
            }else{
                $notification = [
                        'message' => 'Gagal, Nidn yang anda masukkan sudah ada.',
                        'alert-type' => 'error',
                    ];
                return redirect()->route('data-pegawai.master-pegawai.tambah')->withInput()->with($notification);
            }           
        }

    }
    
    public function show($id)
    {
        $id_sdm = Crypt::decrypt($id);
        $rsData = $this->repomspegawai->first(['nm_jns_sdm','stat_kepegawaian','stat_aktif','nm_agama'],$id_sdm);
        $data['rsData'] = $rsData;
        $data['pilihan_jenis_kelamin'] = Fungsi::pilihan_jenis_kelamin($rsData->jk);
        $data['pilihan_jns_sdm'] = Fungsi::pilihan_jns_sdm($rsData->id_jns_sdm);
        $data['pilihan_status_kepegawaian'] = Fungsi::pilihan_status_kepegawaian($rsData->id_stat_kepegawaian);
        $data['pilihan_status_keaktifan'] = Fungsi::pilihan_status_keaktifan($rsData->id_stat_aktif);
        $data['pilihan_status_kawin'] = Fungsi::pilihan_status_kawin($rsData->id_stat_kawin);
        $data['pilihan_agama'] = Fungsi::pilihan_agama($rsData->id_agama);
        $data['pilihan_absen'] = Fungsi::pilihan_absen($rsData->id_bank);
        $data['pilihan_satker'] = Fungsi::pilihan_satker($rsData->id_satkernow);
        $data['pilihan_jabatan_fungsional'] = Fungsi::pilihan_jabatan($rsData->id_jabatan_fungsional_now,"F");
        $data['pilihan_jabatan_struktural'] = Fungsi::pilihan_jabatan($rsData->id_jabatan_struktural_now,"S");
        $data['pilihan_golongan'] = Fungsi::pilihan_golongan($rsData->id_golongannow);
        $data['pilihan_kedinasan'] = Fungsi::pilihan_kedinasan($rsData->id_kedinasan);
        return view('content.data_pegawai.detil',$data);
    }

    
    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {
        $req = $request->except('_token');
        $ceknip = $this->repomspegawai->findWhereRaw(""," nip = '$req[nip]' and id_sdm != '$req[id_sdm]' ");
        if($ceknip!=null){
            $notification = [
                'message' => 'Gagal, Nip yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            if(Session::get('level')=="P"){
                return redirect()->intended('/pegawai/detil/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            }else{
                return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
            }
        }else{
            $bisa = 1;
            if($req['nidn']){
                $ceknidn = $this->repomspegawai->findWhereRaw(""," nidn = '$req[nidn]' and id_sdm != '$req[id_sdm]' ");
                if($ceknidn!=null){
                    $bisa=0;
                }else{
                    $bisa = 1;
                }
            }
            if($bisa==1){
                $file = $request->file('foto_pegawai');
                if($file){
                    $tipe = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    if ($tipe != 'jpg' && $tipe != 'jpeg' && $tipe != 'png') {
                        $notification = [
                                'message' => 'File harus berformat jpg / jpeg / png',
                                'alert-type' => 'error',
                                ];
                        if(Session::get('level')=="P"){
                            return redirect()->intended('/pegawai/detil/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                        }else{
                            return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                        }
                    } elseif ($size > 2000000) {
                        $notification = [
                                'message' => 'Ukuran File lebih dari 2MB',
                                'alert-type' => 'error',
                                ];
                        if(Session::get('level')=="P"){
                            return redirect()->intended('/pegawai/detil/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                        }else{
                            return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                        }
                    }
                    unset($req['foto_pegawai']);
                    $name = md5($req['id_sdm']);
                    $req['file_foto'] = $name.".jpg";
                    $destinationPath = 'assets/foto_pegawai/';
                    $file->move($destinationPath, $req['file_foto']);
                }
                $where['id_sdm'] = $req['id_sdm'];
                $save = $this->repomspegawai->update($where,$req);
                $notification = [
                    'message' => 'Berhasil, Data pegawai yang ada masukkan berhasil disimpan.',
                    'alert-type' => 'success',
                ];
                if(Session::get('level')=="P"){
                    return redirect()->intended('/pegawai/detil/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }
            }else{
                $notification = [
                        'message' => 'Gagal, Nidn yang anda masukkan sudah ada.',
                        'alert-type' => 'error',
                    ];
                if(Session::get('level')=="P"){
                return redirect()->intended('/pegawai/detil/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }
            }            
        }
    }

    public function bawahan(){
        $id_sdm = Session::get('id_sdm_pengguna');
        $rsData = $this->repomspegawai->getWhereRaw(['nm_satker','nm_golongan','nm_jns_sdm','stat_kepegawaian','nm_jab_struk','nm_jab_fung']," id_stat_aktif = '1' and (id_sdm_atasan = '$id_sdm' or id_sdm_pendamping = '$id_sdm') ","nm_sdm");
        $data['rsData'] = $rsData;
        $arrIdSdm = array();
        foreach($rsData as $rs=>$r){
            $arrIdSdm[$r->id_sdm] = $r->id_sdm;
        }
        $bln = "08";
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
        $dt_rekap_absen = Fungsi::rekap_presensi_pegawai($bln,$tahun);
        
        $data['dt_rekap_absen'] = $dt_rekap_absen;
        $tgl_terakhir = cal_days_in_month(CAL_GREGORIAN, $bln, $tahun);
        $tgl_awal = $tahun."-".$bln."-01";
        $tgl_akhir = $tahun."-".$bln."-".$tgl_terakhir;
        $data['getRekapDataAbsen'] = Fungsi::get_rekap_data_kehadiran_by_unit($tgl_awal,$tgl_akhir,$arrIdSdm,4);
        //dd($data['getRekapDataAbsen']);
        return view('content.hal_pegawai.bawahan.index',$data);
    }

    public function justifikasi($id_sdm,$bulan,$tahun){
        $id_sdm = Crypt::decrypt($id_sdm);
        $bulan = Crypt::decrypt($bulan);
        $tahun = Crypt::decrypt($tahun);
        // jika 1 presensi, jika 2 apel
        $tgl_terakhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tgl_awal = $tahun."-".$bulan."-01";
        $tgl_akhir = $tahun."-".$bulan."-".$tgl_terakhir;
        $arrIdSdm[$id_sdm] = $id_sdm;
        $data['id_sdm'] = $id_sdm;
        $rsData = $this->repomspegawai->findId("",$id_sdm,"id_sdm");
        $jam_kerja = Fungsi::jam_kerja_unit($rsData->id_satkernow);
        $rekap = Fungsi::get_rekap_data_kehadiran($jam_kerja,$tgl_awal,$tgl_akhir,$arrIdSdm,4);

        $gbng = $tahun.$bulan;
        $data['thn_bulan'] = $tahun."-".$bulan;
        $data['rekap'] = $rekap[$rsData->id_sdm][$gbng];
        $data['rsData'] = $rsData;
        $data['jam_kerja_unit'] = $jam_kerja;
        $data['kategoriwaktuabsen'] = Fungsi::kategoriwaktuabsen();
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['pilihan_bulan_presensi'] = Fungsi::pilihan_bulan_presensi($bulan);
        return view('content.hal_pegawai.bawahan.justifikasi_kehadiran',$data);

    }

    public function gen_justifikasi_kehadiran(Request $request){
        $req = $request->except('_token');
        $data['dt_pegawai'] = $this->repomspegawai->findId("",$req['id_sdm'],"id_sdm");
        $jam_kerja = Fungsi::jam_kerja_unit($rsData->id_satkernow);
        $hari = Fungsi::formatDate($req['tgl']);
        if($hariabsen[0]=="Jumat"){
            $jam_kerja = $jam_kerja[2];
        }else{
            $jam_kerja = $jam_kerja[1];
        }
        $data['jam_kerja'] = $jam_kerja;
        // 1 tidak masuk, 2 telat, 3 pulang cepat
        $data['kode'] = $req['kode'];
        if($req['kode']==1){
            $data['ket'] = "Justifikasi Tidak Masuk";
        }else if($req['kode']==2){
            $data['ket'] = "Justifikasi Terlambat";
        }else if($req['kode']==3){
            $data['ket'] = "Justifikasi Pulang Cepat";
        }
        $data['tgl'] = $req['tgl'];
        return view('content.hal_pegawai.bawahan.form_justifikasi_kehadiran',$data);
    }

    public function save_justifikasi_kehadiran(Request $request){
        $req = $request->except('_token');
        unset($req['nm_sdm']);
        $where['id_sdm'] = $req['id_sdm'];
        $where['tanggal_absen'] = $req['tanggal_absen'];
        $req['justifikasi_atasan'] = 1;
        $req['ket_justifikasi'] = $req['ket'];
        $req['tgl_justifikasi'] = date('Y-m-d H:i:s');
        unset($req['ket']);
        // hanya yang tidak masuk saja yang dimasukkan ke tr_justifikasi
        if($req['kode']!=1){
            unset($req['tanggal_absen']);
            unset($req['id_sdm']);
            unset($req['kode']);
            unset($req['jam_masuk']);
            unset($req['jam_pulang']);
            $this->reporiwayatpresensi->update($where,$req);
        }else{
            $cek = $this->repotrjustifikasi->findWhereRaw("","id_sdm = '$req[id_sdm]' and tanggal_absen = '$req[tanggal_absen]'");
            if($cek){
                $update['tgl_justifikasi'] = date('Y-m-d H:i:s');
                $update['tanggal_absen'] = $req['tanggal_absen'];
                $update['id_sdm'] = $req['id_sdm'];
                $update['justifikasi_atasan'] = $req['justifikasi_atasan'];
                $update['alasan'] = $req['alasan'];
                $update['ket_justifikasi'] = $req['ket_justifikasi'];
                $update['id_jns'] = 1;
                $where['id_justifikasi'] = $cek->id_justifikasi;
                $this->repotrjustifikasi->update($where,$update);
            }else{
                $masuk['tgl_justifikasi'] = date('Y-m-d H:i:s');
                $masuk['tanggal_absen'] = $req['tanggal_absen'];
                $masuk['id_sdm'] = $req['id_sdm'];
                $masuk['justifikasi_atasan'] = $req['justifikasi_atasan'];
                $masuk['alasan'] = $req['alasan'];
                $masuk['ket_justifikasi'] = $req['ket_justifikasi'];
                $masuk['id_jns'] = 1;
                $this->repotrjustifikasi->store($masuk);
            }            
        }
        echo '<script type="text/javascript">toastr.success("Proses justifikasi kehadiran berhasil diproses.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    public function justifikasi_apel($id_sdm,$bulan,$tahun){
        $bulan = Crypt::decrypt($bulan);
        $tahun = Crypt::decrypt($tahun);
        $id_sdm = Crypt::decrypt($id_sdm);

        $data['pilihan_bulan_presensi'] = Fungsi::pilihan_bulan_presensi($bulan);
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['dt_pegawai'] = $this->repomspegawai->first("",$id_sdm);
        $data['rsData'] = $this->repopresensiapel->get(['nm_kegiatan_apel'],"",$id_sdm,$tahun,$bulan);
        $data['id_sdm'] = $id_sdm;
        return view('content.hal_pegawai.bawahan.justifikasi_apel',$data);
    }

    public function gen_justifikasi_apel(Request $request){
        $req = $request->except('_token');
        $data['rsData'] = $this->repopresensiapel->findId(['nm_kegiatan_apel','dt_pegawai'],$req['id_presensi'],"id_presensi");
        return view('content.hal_pegawai.bawahan.form_justifikasi_apel',$data);
    }

    public function save_justifikasi_apel(Request $request){
        $req = $request->except('_token');
        $req['tgl_justifikasi'] = date('Y-m-d H:i:s');
        $req['alasan'] = $req['alasan'];
        $req['ket_justifikasi'] = "Justifikasi Kegiatan Apel";
        $req['justifikasi_atasan'] = 1;
        $where['id_presensi'] = $req['id_presensi'];
        unset($req['id_presensi']);
        $this->repopresensiapel->update($where,$req);
        echo '<script type="text/javascript">toastr.success("Proses justifikasi kehadiran apel berhasil diproses.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    
    public function destroy($id)
    {
        //
    }
}
