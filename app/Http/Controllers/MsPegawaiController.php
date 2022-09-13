<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use App\Repositories\Repomspegawainew;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repopresensiapel;
use App\Repositories\Repotrabsenkehadiran;
use Crypt;
use Fungsi;
use Session;
use DB;
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
        Repotrabsenkehadiran $repotrabsenkehadiran
    ){
        $this->request = $request;
        $this->repomspegawai = $repomspegawai;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repomspegawainew = $repomspegawainew;
        $this->repopresensiapel = $repopresensiapel;
        $this->repotrabsenkehadiran = $repotrabsenkehadiran;
    }

    public function index(Request $request)
    {
        // $arrBulan = array("Jan"=>"01","Feb"=>"02","Mar"=>"03","Apr"=>"04","Mei"=>"05","Jun"=>"06","Jul"=>"07","Agu"=>"08","Sep"=>"09","Nov"=>"10","Okt"=>"11","Des"=>"12");
        // $rsData = DB::table('data_pegawai_excel as a')->get();
        // $arrJabatan = Fungsi::jabatan();
        // $arrData = array();
        // foreach($rsData as $rs=>$r){
        //     if($r->nip){
        //         $cek = $this->repomspegawai->findId("",$r->nip,"nip");
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
        //     $arrData[$r->nama]['nip'] = $r->nip;
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
        $rsData = $this->repomspegawai->first(['nm_jns_sdm','stat_kepegawaian','stat_aktif','nm_agama'],$id_sdm);
        $data['rsData'] = $rsData;
        $bln = "01";
        if(Session::get('bln')!=null){
            $bln = Session::get('bln');
        }
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $gbng = $tahun."-".$bln;
        $rsDataAbsen = $this->reporiwayatpresensi->getWhereRaw(""," id_sdm = '$id_sdm' and SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 0, 8) = '$gbng' ","tanggal_absen");
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $data['pilihan_bulan_presensi'] = Fungsi::pilihan_bulan_presensi($bln);
        $jam_kerja = Fungsi::jam_kerja_unit($rsData->id_satkernow);
        $data['jam_kerja_unit'] = $jam_kerja;
        $arrAbsen = array();$data_bul = array();
        foreach($rsDataAbsen as $rsA=>$rA){
            $tgl = Fungsi::formatDate($rA->tanggal_absen);
            $arrAbsen[$rA->id_sdm][$tgl][] = $rA->jam_absen;
            $arrAbsen2[$rA->tanggal_absen][] = $rA->jam_absen;
            $date = date('Y-m-d',strtotime($rA->tanggal_absen));
            $explode = explode('-',$date);
            $blnx = sprintf("%0d", $explode[1]);
            $tglnya = sprintf("%0d", $explode[2]);
            $arrAbsen3[$rA->id_sdm][$blnx][$tglnya] = $tglnya;
        }
        $listtgl = cal_days_in_month(CAL_GREGORIAN, $bln, $tahun);
        for ($i=1; $i < $listtgl+1; $i++) { 
            $gbng = $tahun."-".sprintf("%02d", $bln)."-".sprintf("%02d", $i);
            $tgl = Fungsi::formatDate($gbng);
            $hari = explode(',',$tgl);
            if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                $data_bulan[$bln][$i] = $tgl;
                $data_bul[$bln][$i] = $i;
            } 
        }

        foreach($arrAbsen2 as $tglx2=>$dttgl2){
            $date = date('Y-m-d',strtotime($tglx2));
            $explode = explode('-',$date);
            $bln = sprintf("%0d", $explode[1]);
            $tglnya = sprintf("%0d", $explode[2]);
            $cektglbulan = $data_bul[$explode[1]][$explode[2]];
            $kettgl = Fungsi::formatDate($tglx2);
            if($cektglbulan){
                $jam_pulang = end($dttgl2);
                $jam_masuk = array_shift($dttgl2);
                if($jam_masuk >= $jam_kerja->masuk_telat){

                    $jam_masukex = explode(':',$jam_masuk);
                    $jam_telatex = explode(':',$jam_kerja->masuk_telat);

                    $j_masuk_start = $jam_masukex[0];
                    $menit_masuk = $jam_masukex[1];

                    $j_telat_masuk = $jam_telatex[0];
                    $menit_telat_masuk = $jam_telatex[1];

                    $hasil = (intVal($j_telat_masuk) - intVal($j_masuk_start)) * 60 + (intVal($menit_telat_masuk) - intVal($menit_masuk));
                    $hasil = abs($hasil) / 60;
                    $hasil = number_format($hasil,2);
                    $hasilx = explode(".",$hasil);
                    $depan = sprintf("%02d", $hasilx[0]);
                    $gabung = $depan.":".$hasilx[1];
                    $menit = ($gabung*60)+$hasilx[1];
    
                    $data['telat'][$kettgl]['durasi'] = $menit;
                    $data['telat'][$kettgl]['jam_masuk'] = $jam_masuk;
                    $data['telat'][$kettgl]['jam_pulang'] = $jam_pulang;
                }
                if($jam_pulang <= $jam_kerja->jam_keluar){
                    $jam_pulangex = explode(':',$jam_pulang);
                    $jam_ker_pulangex = explode(':',$jam_kerja->jam_keluar);

                    $j_pulang_start = $jam_pulangex[0];
                    $menit_pulang = $jam_pulangex[1];

                    $j_ker_pulang = $jam_ker_pulangex[0];
                    $menit_ker_pulang = $jam_ker_pulangex[1];

                    $hasil = (intVal($j_ker_pulang) - intVal($j_pulang_start)) * 60 + (intVal($menit_ker_pulang) - intVal($menit_pulang));
                    $hasil = abs($hasil) / 60;
                    $hasil = number_format($hasil,2);
                    $hasilx = explode(".",$hasil);
                    $depan = sprintf("%02d", $hasilx[0]);
                    $gabung = $depan.":".$hasilx[1];
                    $menit = ($gabung*60)+$hasilx[1];
                    
                    $data['cepatpulang'][$kettgl]['durasi'] = $menit;
                    $data['cepatpulang'][$kettgl]['jam_pulang'] = $jam_pulang;
                    $data['cepatpulang'][$kettgl]['jam_masuk'] = $jam_masuk;
                }
            }
        }

        foreach($data_bulan as $idbln=>$dtbln){
            foreach($dtbln as $tglbln=>$tgln){
                foreach($arrAbsen3 as $idsdm=>$dtsdmx){
                    $idbln = sprintf("%0d", $idbln);
                    $cek = $dtsdmx[$idbln][$tglbln];
                    if($cek!=null){
                        $data['masuk'][$tglbln] = $tgln;
                    }else{
                        $data['tidakmasuk'][$tglbln] = $tgln;
                    }
                }
            }
        }
        //rsort($data['tidakmasuk']);
        //dd($data['telat']);
        //dd($data);

        
        $data['arrAbsen'] = $arrAbsen;
        return view('content.data_pegawai.riwayat.presensi_kehadiran.index',$data);
    }

    public function riwayat_apel($id_sdm){
        $tahun = date('Y');
        if(Session::get('tahun')!=null){
            $tahun = Session::get('tahun');
        }
        $data['pilihan_tahun_presensi'] = Fungsi::pilihan_tahun_presensi($tahun);
        $id_sdm = Crypt::decrypt($id_sdm);
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
                return redirect()->intended('/pegawai/'.Crypt::encrypt($req['id_sdm']))->with($notification);
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
                $where['id_sdm'] = $req['id_sdm'];
                $save = $this->repomspegawai->update($where,$req);
                $notification = [
                    'message' => 'Berhasil, Data pegawai yang ada masukkan berhasil disimpan.',
                    'alert-type' => 'success',
                ];
                if(Session::get('level')=="P"){
                    return redirect()->intended('/pegawai/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }
            }else{
                $notification = [
                        'message' => 'Gagal, Nidn yang anda masukkan sudah ada.',
                        'alert-type' => 'error',
                    ];
                if(Session::get('level')=="P"){
                return redirect()->intended('/pegawai/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }else{
                    return redirect()->intended('/data-pegawai/master-pegawai/detil-data/'.Crypt::encrypt($req['id_sdm']))->with($notification);
                }
            }            
        }
    }

    
    public function destroy($id)
    {
        //
    }
}
