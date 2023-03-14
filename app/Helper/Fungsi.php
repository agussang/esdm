<?php

namespace App\Helper;

use Session;
use App\Models\MsStatusAktif;
use App\Models\TrJadwalShift;
use App\Models\TrStatusKepegawaian;
use App\Models\MsWaktuShift;
use App\Models\MsJabatan;
use App\Models\MsAgama;
use App\Models\MsPendidikan;
use App\Models\MsJnsSdm;
use App\Models\MsStatusKepegawaian;
use App\Models\SatuanUnitKerja;
use App\Models\MsGolongan;
use App\Models\MsAbsen;
use App\Models\MsPegawai;
use App\Models\MsAlasanAbsen;
use App\Models\MesinFinger;
use App\Models\MsGrade;
use App\Models\MsPeriodeSkp;
use App\Models\MsBank;
use App\Models\MsRole;
use App\Models\MsSatuan;
use App\Models\MsRubrik;
use App\Models\TrAbsenKehadiran;
use App\Models\RiwayatPresensi;
use App\Models\MsKedinasan;
use App\Models\MsKategoriPelanggaran;
use App\Models\TrJustifikasi;
use App\Models\SettingHariLibur;
use App\Models\SettingRamadhan;
use App\Models\MsProsentaseRealisasi;
use DB;
use DatePeriod;
use DateTime;
use DateInterval;
use GuzzleHttp\Psr7\Request;

error_reporting(0);
function bulan($idbln){
    $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    return $bulan[$idbln];
}
function nm_bulan(){
    $arrBulan = array(
        "01"=>"Januari",
        "02"=>"Februari",
        "03"=>"Maret",
        "04"=>"April",
        "05"=>"Mei",
        "06"=>"Juni",
        "07"=>"Juli",
        "08"=>"Agustus",
        "09"=>"September",
        "10"=>"Oktober",
        "11"=>"November",
        "12"=>"Desember"
    );
    return $arrBulan;
}

function jam_kerja_cek($id){
    $rsData = MsAbsen::where('id_khusus',$id)->orderBy('hari_biasa','asc')->get();
    $arrData = array();
    foreach($rsData as $rs=>$r){
        $arrData[$r->hari_biasa]['jam_masuk'] = $r->jam_masuk;
        $arrData[$r->hari_biasa]['jam_pulang'] = $r->jam_keluar;
        $arrData[$r->hari_biasa]['masuk_telat'] = $r->masuk_telat;
        $arrData[$r->hari_biasa]['pulang_telat'] = $r->pulang_telat;
        $arrData[$r->hari_biasa]['lama_kerja'] = $r->lama_kerja;
    }
    return $arrData;
}

function nama_bulan(){
    $arrBulan = array(
        "1"=>"Januari",
        "2"=>"Februari",
        "3"=>"Maret",
        "4"=>"April",
        "5"=>"Mei",
        "6"=>"Juni",
        "7"=>"Juli",
        "8"=>"Agustus",
        "9"=>"September",
        "10"=>"Oktober",
        "11"=>"November",
        "12"=>"Desember"
    );
    return $arrBulan;
}

function tajip($string,$key='intan') {
    $result = '';
    for($i=0; $i < strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result.=$char;
    }
    return base64_encode($result);
}

function list_hari_libur($tgl_awal,$tgl_akhir){
    $tgl_awal = substr($tgl_awal,0,7);
    $tgl_akhir = substr($tgl_akhir,0,7);
    $rsData = SettingHariLibur::selectRaw("substr(tgl_libur::text,0,8) as bulanthun,id_hari_libur,nama_libur,tgl_libur ")->whereRaw("substr(tgl_libur::text,0,8) >= '$tgl_awal' and substr(tgl_libur::text,0,8) <= '$tgl_akhir'")->get();
    $arrData = array();
    foreach($rsData as $rs=>$r){
        $arrData[$r->bulanthun][$r->tgl_libur] = $r->nama_libur;
    }
    return $arrData;
}

function harikerja($tgl_awal,$tgl_akhir){
    $list_hari_libur = list_hari_libur($tgl_awal,$tgl_akhir);
    $bulan_awal = date('m',strtotime($tgl_awal));
    $bulan_akhir = date('m',strtotime($tgl_akhir));
    $bulan_awal = sprintf("%0d", $bulan_awal);
    $thn = date('Y',strtotime($tgl_awal));
    $data_bulan = array();
    $bts_tgl_awal = date('d',strtotime($tgl_awal));
    $bts_tgl_akhir = date('d',strtotime($tgl_akhir));
    $arrAwal[$bulan_awal] = sprintf("%0d",$bts_tgl_awal);
    $arrAkhir[$bulan_akhir] = sprintf("%0d",$bts_tgl_akhir);
    $seee = array();
    for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
        for ($i=1; $i < $tanggal+1; $i++) {
                $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                $tgl = Fungsi::formatDate($gbng);
                $hari = explode(',',$tgl);
                if($hari[0]!='Sabtu' && $hari[0]!='Minggu' && $list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng] == null){
                    $buwulan = $x;
                    $data_bulan[$buwulan][$i] = $i;
                }
        }
    }
    return $data_bulan;
}



function daterange($tgl_awal,$tgl_akhir){

    // $bulan_awal = date('m',strtotime($tgl_awal));
    // $bulan_akhir = date('m',strtotime($tgl_akhir));
    // $bulan_awal = sprintf("%0d", $bulan_awal);
    // $bulan_akhir = sprintf("%0d", $bulan_akhir);
    // $thn = date('Y',strtotime($tgl_awal));
    // $data_bulan = array();
    // $bts_tgl_awal = date('d',strtotime($tgl_awal));
    // $bts_tgl_akhir = date('d',strtotime($tgl_akhir));
    // $arrAwal[$bulan_awal] = sprintf("%0d",$bts_tgl_awal);
    // $arrAkhir[$bulan_akhir] = sprintf("%0d",$bts_tgl_akhir);
    // $seee = array();
    // for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
    //     $akhirtgl = $arrAkhir[$x];
    //     $awaltgl = $arrAwal[$x];
    //     if($awaltgl>$akhirtgl){
    //         $akhirtgl = $arrAwal[$x];
    //         $awaltgl = $arrAkhir[$x];
    //     }
    //     for ($i=$awaltgl; $i <= $akhirtgl+1; $i++) {
    //         if($i>=$arrAwal[$bulan_awal]){
    //             $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
    //             $tgl = Fungsi::formatDate($gbng);
    //             $hari = explode(',',$tgl);
    //             //if($hari[0]!='Sabtu' && $hari[0]!='Minggu' && $list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng] == null){
    //                 $buwulan = $x;
    //                 $data_bulan[$gbng] = $gbng;
    //             //}
    //         }
    //     }
    // }
        $data_bulan = [];

        $startDate = strtotime($tgl_awal);
        $endDate = strtotime($tgl_akhir);

        for ($currentDate = $startDate; $currentDate <= $endDate;$currentDate += (86400)) {
            $date = date('Y-m-d', $currentDate);
            $data_bulan[$date] = $date;
        }

        return $data_bulan;
}

function tgl_ramadhan($tahun){
    $rsData = SettingRamadhan::where('tahun',$tahun)->first();
    $list_tgl = array();
    if($rsData!=null){
        $list_tgl = daterange($rsData->tgl_ramadhan,$rsData->tgl_ramadhan_akhir);
    }
    return $list_tgl;
}

function harikerjareal($tgl_awal,$tgl_akhir){
    $list_hari_libur = list_hari_libur($tgl_awal,$tgl_akhir);
    $bulan_awal = date('m',strtotime($tgl_awal));
    $bulan_akhir = date('m',strtotime($tgl_akhir));
    $bulan_awal = sprintf("%0d", $bulan_awal);
    $thn = date('Y',strtotime($tgl_awal));
    $data_bulan = array();
    $bts_tgl_awal = date('d',strtotime($tgl_awal));
    $bts_tgl_akhir = date('d',strtotime($tgl_akhir));
    $arrAwal[$bulan_awal] = sprintf("%0d",$bts_tgl_awal);
    $arrAkhir[$bulan_akhir] = sprintf("%0d",$bts_tgl_akhir);
    $seee = array();
    for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
        for ($i=1; $i < $tanggal+1; $i++) {
                $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                $tgl = Fungsi::formatDate($gbng);
                $hari = explode(',',$tgl);
                //if($hari[0]!='Sabtu' && $hari[0]!='Minggu' && $list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng] == null){
                    $buwulan = $x;
                    $nm_bulan = nama_bulan();
                    $data_bulan[$buwulan]['nm_bulan'] = $nm_bulan[$buwulan];
                    $data_bulan[$buwulan]['list_tgl'][$gbng]['tgl'] = $tgl;
                    $data_bulan[$buwulan]['list_tgl'][$gbng]['ket_nasional'] = $list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng];
                //}
                if($hari[0]!='Sabtu' && $hari[0]!='Minggu' && $list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng] == null){
                    $data_bulan[$buwulan]['hari_kerja'][$i]['tgl'] = $tgl;
                }
                if($list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng] != null){
                    $data_bulan[$buwulan]['hari_libur_nasional'][$gbng]['tgl'] = $tgl;
                    $data_bulan[$buwulan]['hari_libur_nasional'][$gbng]['ket_libur'] = $list_hari_libur[$thn."-".sprintf("%02d", $bulan_awal)][$gbng];
                }
        }
    }
    return $data_bulan;
}

function jm_absensi($tgl_awal,$tgl_akhir){
    $rsData = harikerja($tgl_awal,$tgl_akhir);
    $pecah1 = explode("-", $tgl_awal);
    $date1 = sprintf("%0d",$pecah1[2]);
    $month1 = sprintf("%0d",$pecah1[1]);

    $pecah2 = explode("-", $tgl_akhir);
    $date2 = sprintf("%0d",$pecah2[2]);
    $month2 = sprintf("%0d",$pecah2[1]);
    foreach($rsData[$month1] as $tgl=>$g){
        if($tgl<$date1){
            unset($rsData[$month1][$tgl]);
        }
    }
    foreach($rsData[$month2] as $tgl2=>$g2){
        if($tgl2>$date2){
            unset($rsData[$month2][$tgl2]);
        }
    }
    $arrJbul = array();
    foreach($rsData as $bul=>$jtgl){
        foreach($jtgl as $tg=>$lx){
            if($laporan==1){
                $arrJbul[$bul]['jmabsen']+=1;
            }else{
                $arrJbul['jmabsen']+=1;
            }
        }
    }
    return $arrJbul;
}

function jam_kerjaunit($id_satker){
    // jika poliklinik khusus
    if($id_unit=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
        $rsData = MsAbsen::where('id_khusus',"4e1ebf30-02fd-4948-87bb-c2992a822682")->get();
    }else{
        $rsData = MsAbsen::where('id_khusus',"347b23a9-8919-43ec-9b2d-a0c4b810b61d")->get();
    }
    $arrData = array();
    foreach($rsData as $rs=>$r){
        $arrData[$r->hari_biasa]['jam_masuk'] = $r->jam_masuk;
        $arrData[$r->hari_biasa]['jam_pulang'] = $r->jam_keluar;
        $arrData[$r->hari_biasa]['masuk_telat'] = $r->masuk_telat;
        $arrData[$r->hari_biasa]['pulang_telat'] = $r->pulang_telat;
    }
    return $arrData;
}


class Fungsi
{
    public static function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }
    public static function pilihan_prosentase_realisasi($id_prosentase,$kode_p){
        $rsData = MsProsentaseRealisasi::where('kode_p',$kode_p)->get();
        $d = '<option value=""></option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_prosentase == $id_prosentase) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_prosentase\" $sl>$r->nilai</option>";
        }
        return $d;
    }
    public static function get_client_browser() {
        $browser = '';
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
            $browser = 'Netscape';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
            $browser = 'Firefox';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
            $browser = 'Chrome';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
            $browser = 'Opera';
        else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
            $browser = 'Internet Explorer';
        else
            $browser = 'Other';
        return $browser;
    }

    public static function pilihan_penerima_remun($id=null){
        $arrData = array('1'=>"Ya",'2'=>"Tidak");
        $d = '<option value="">Pilih Penerima Remun</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }
    public static function ket_berlaku(){
        $arrData = array('0'=>"Berlaku Selamanya",'1'=>"1 Bulan",'2'=>"2 Bulan",'3'=>"3 Bulan",'4'=>"4 Bulan",'5'=>"5 Bulan",'6'=>"6 Bulan",'7'=>"7 Bulan",'8'=>"8 Bulan",'9'=>"9 Bulan",'10'=>"10 Bulan",'11'=>"11 Bulan",'12'=>"12 Bulan");
        return $arrData;
    }


    public static function list_bulan($id=null){
        $arrData = array('1'=>"1 Bulan",'2'=>"2 Bulan",'3'=>"3 Bulan",'4'=>"4 Bulan",'5'=>"5 Bulan",'6'=>"6 Bulan",'7'=>"7 Bulan",'8'=>"8 Bulan",'9'=>"9 Bulan",'10'=>"10 Bulan",'11'=>"11 Bulan",'12'=>"12 Bulan");
        $d = '<option value="">Pilih Lama Berlaku</option>';
        $d .= '<option value="0">Berlaku Selamanya</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }
    public static function kategoriwaktuabsen(){
        $arrData = array("1"=> "Senin - Kamis","2"=>"Jumat");
        return $arrData;
    }
    public static function arrPendidikan(){
        $rsData = MsPendidikan::orderBy('urutan','asc')->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->id] = $r->namapendidikan;
        }
        return $arrData;
    }
    public static function pilihan_tahun_absen($tahun){
        $rsData = TrAbsenKehadiran::selectRaw(" distinct SUBSTRING(CAST(tgl_awal AS VARCHAR(19)), 0, 5) as tahun")->orderBy('tahun','asc')->get();
        $d = '<option value="">Pilih Tahun Absen</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->tahun == $tahun) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->tahun\" $sl>$r->tahun</option>";
        }
        return $d;
    }
    public static function pilihan_kedinasan($id_kedinasan){
        $rsData = MsKedinasan::orderBy('nama_kedinasan','asc')->get();
        $d = '<option value="">Pilih Nama Kedinasan</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_kedinasan == $id_kedinasan) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_kedinasan\" $sl>$r->nama_kedinasan</option>";
        }
        return $d;
    }
    public static function pilihan_absen($idbank){
        $rsData = MsBank::orderBy('nama_bank','asc')->get();
        $d = '<option value="">Pilih Nama Bank</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_bank == $idbank) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_bank\" $sl>$r->nama_bank</option>";
        }
        return $d;
    }

    public static function jum_hari_kerja($tgl_awal,$tgl_akhir){
        $rsData = harikerja($tgl_awal,$tgl_akhir);
        return $rsData;
    }
    public static function hari_dalam_satu_bulan($tgl_awal,$tgl_akhir){
        $rsData = harikerjareal($tgl_awal,$tgl_akhir);
        return $rsData;
    }
    public static function jumlah_absen($tgl_awal,$tgl_akhir,$laporan=0){
        $rsData = harikerja($tgl_awal,$tgl_akhir);
        $pecah1 = explode("-", $tgl_awal);
        $date1 = sprintf("%0d",$pecah1[2]);
        $month1 = sprintf("%0d",$pecah1[1]);

        $pecah2 = explode("-", $tgl_akhir);
        $date2 = sprintf("%0d",$pecah2[2]);
        $month2 = sprintf("%0d",$pecah2[1]);
        foreach($rsData[$month1] as $tgl=>$g){
            if($tgl<$date1){
                unset($rsData[$month1][$tgl]);
            }
        }
        foreach($rsData[$month2] as $tgl2=>$g2){
            if($tgl2>$date2){
                unset($rsData[$month2][$tgl2]);
            }
        }
        $arrJbul = array();
        $arrNmBulan = nm_bulan();
        foreach($rsData as $bul=>$jtgl){
            foreach($jtgl as $tg=>$lx){
                $arrJbul[sprintf("%02d",$bul)]['nm_bulan'] = $arrNmBulan[sprintf("%02d",$bul)];
                if($laporan==1){
                    $arrJbul[sprintf("%02d",$bul)]['list_tgl'][sprintf("%02d",$tg)] = sprintf("%02d",$tg);
                    $arrJbul[sprintf("%02d",$bul)]['total']+=1;
                }else{
                    $arrJbul[sprintf("%02d",$bul)]['list_tgl'][$tg] = $tg;
                    $arrJbul['total']+=1;
                }
                $arrJbul[sprintf("%02d",$bul)]['tahun'] = $pecah1[0];
            }
        }

        return $arrJbul;
    }

    public static function jmlh_hari_libur($tgl_awal,$tgl_akhir){
        $tgl_awal = substr($tgl_awal,0,7);
        $tgl_akhir = substr($tgl_akhir,0,7);
        $rsData = SettingHariLibur::selectRaw("substr(tgl_libur::text,0,8) as bulanthun,id_hari_libur,nama_libur,tgl_libur ")->whereRaw("substr(tgl_libur::text,0,8) >= '$tgl_awal' and substr(tgl_libur::text,0,8) <= '$tgl_akhir'")->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->bulanthun][$r->tgl_libur] = $r->nama_libur;
        }
        return $arrData;
    }

    public static function hitung_absen($tgl_awal,$tgl_akhir){
        $jm_absensi = jm_absensi($tgl_awal,$tgl_akhir);
        return $jm_absensi;
    }
    public static function rekap_presensi_pegawai($bulan,$tahun){
        $tgl_terakhir = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        $tgl_awal = $tahun."-".$bulan."-01";
        $tgl_akhir = $tahun."-".$bulan."-".$tgl_terakhir;
        $gbng = $tahun."-".$bulan;
        $jm_kerja = jm_absensi($tgl_awal,$tgl_akhir);
        return $jm_kerja;
    }
    public static function pilihan_role($id=null){
        $rsData = MsRole::get();
        $d = '<option value="">Pilih Role User</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_role == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_role\" $sl>$r->nama_role</option>";
        }
        return $d;
    }
    public static function arrGrade(){
        $rsData = MsGrade::get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->id] = $r->grade;
        }
        return $arrData;
    }
    public static function pilihan_grade($id=null){
        $rsData = MsGrade::where('jobscore','<>',null)->orderBy('jobscore','desc')->get();
        $d = '<option value="">Pilih Grade</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id\" $sl>$r->grade</option>";
        }
        return $d;
    }
    public static function pilihan_verifikasi($id = null){
        $arrData = array('1'=>"Setujui",'2'=>"Tidak Disetujui");
        $d = '<option value="">Pilih Status Verifikasi</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }
    public static function arralasan_absen(){
        $rsData = MsAlasanAbsen::get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->kode_lokal] = $r->id_alasan;
        }
        return $arrData;
    }
    public static function pilihan_alasan_absen($id=null){
        $rsData = MsAlasanAbsen::get();
        $d = '<option value="">Pilih Alasan Absen</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_alasan == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_alasan\" $sl>$r->alasan</option>";
        }
        return $d;
    }
    public static function pilihan_jam_kerja(){
        $rsData = MsAbsen::orderBy('hari_biasa','asc')->get();
        $kategoriwaktuabsen = array("1"=> "Senin - Kamis","2"=>"Jumat");$ketramahadhan = array();
        foreach($rsData as $rs=>$r){
            $ketramahadhan[$r->id_khusus] = $r->keterangan;
            $arrData[$r->id_khusus][$r->id]['ket'] = $kategoriwaktuabsen[$r->hari_biasa];
            if($r->hari_biasa==2){
                $arrData[$r->id_khusus][$r->id]['ket'] = ", ".$kategoriwaktuabsen[$r->hari_biasa];
            }
            $arrData[$r->id_khusus][$r->id]['jam_masuk'] = $r->jam_masuk;
            $arrData[$r->id_khusus][$r->id]['jam_keluar'] = $r->jam_keluar;
            $arrData[$r->id_khusus][$r->id]['masuk_telat'] = $r->masuk_telat;
            $arrData[$r->id_khusus][$r->id]['pulang_telat'] = $r->pulang_telat;
            $arrData[$r->id_khusus][$r->id]['lama_kerja'] = $r->lama_kerja;
            $arrData[$r->id_khusus][$r->id]['hari_biasa'] = $r->hari_biasa;
        }
        $gabung = array();
        foreach($arrData as $idkatkhusus=>$dtidkatkhusus){
            foreach($dtidkatkhusus as $id_absen=>$dthari){
                $gabung[$idkatkhusus]['waktu'] .= $dthari['ket']." ( ".$dthari['jam_masuk']."-".$dthari['jam_keluar']." )";
            }
        }
        $d = '<option value="">Pilih Jam Kerja</option>';
        foreach($gabung as $idkatkhususx=>$dtidkatkhususx){
            $waktu = $dtidkatkhususx['waktu'];
            $d .= "<option value=\"$idkatkhususx\">$ketramahadhan[$idkatkhususx] -- $waktu</option>";
        }
        $jam_kerja_shift = array();$arrjamkerjashift = array();
        $rsDatashift = MsWaktuShift::orderBy('kode_shift','asc')->where('id_khusus','<>',null)->get();
        foreach($rsDatashift as $dtshift=>$rshift){
            $arrjamkerjashift[$rshift->id_khusus][$rshift->id]['ket'] = $rshift->nm_shift;
            $arrjamkerjashift[$rshift->id_khusus][$rshift->id]['jam_masuk'] = $rshift->jam_masuk;
            $arrjamkerjashift[$rshift->id_khusus][$rshift->id]['jam_keluar'] = $rshift->jam_pulang;
        }
        foreach($arrjamkerjashift as $idkhusus=>$dtkhusus){
            foreach($dtkhusus as $idmastershift=>$dtshift){
                $jam_kerja_shift[$idkhusus]['waktu'] .= $dtshift['ket']." ( ".$dtshift['jam_masuk']."-".$dtshift['jam_keluar']." ), ";
            }
        }
        foreach($jam_kerja_shift as $idkatkhususshift=>$dtidkatkhususshift){
            $waktu = $dtidkatkhususshift['waktu'];
            $d .= "<option value=\"$idkatkhususshift\">Jam Kerja Shift -- $waktu</option>";
        }
        return $d;
    }

    public static function formatDate($date, $mode = 'full')
    {
        $hari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
        $bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $tanggal = $hari[date('w',strtotime($date))].",".date('j',strtotime($date))." ".$bulan[date('n',strtotime($date))]." ".date('Y',strtotime($date));
        return $tanggal;
    }

    public static function rumus_prilaku_sebutan($nilai){

        $ket = "";
        $nilai = (int)$nilai;
        if($nilai=="0"){
            $ket = "Sangat Kurang";
        }else if($nilai<"40" ){
            $ket = "Sangat Kurang";
        }else if($nilai>="41" && $nilai<="60" ){
            $ket = "Kurang";
        }else if($nilai>="61" && $nilai<="80" ){
            $ket = "Cukup";
        }else if($nilai>="81" && $nilai<="100" ){
            $ket = "Baik";
        }
        return $ket;
    }

    public static function arrkategorijustifikasi(){
        // 1. lupa finger, 2. terlambat, 3. pulang cepat, 4.finger 1 kali
        $arrData = array("1"=>"Lupa Finger / Tidak Masuk","2"=>"Terlambat","3"=>"Pulang Cepat","4"=>"Finger 1 Kali");
        return $arrData;
    }

    public static function nm_bulan(){
        $arrBulan = array(
            "01"=>"Januari",
            "02"=>"Februari",
            "03"=>"Maret",
            "04"=>"April",
            "05"=>"Mei",
            "06"=>"Juni",
            "07"=>"Juli",
            "08"=>"Agustus",
            "09"=>"September",
            "10"=>"Oktober",
            "11"=>"November",
            "12"=>"Desember"
        );
        return $arrBulan;
    }



    public static function nm_bulan_sing(){
        $arrBulan = array(
            "01"=>"Jan",
            "02"=>"Feb",
            "03"=>"Mar",
            "04"=>"Apr",
            "05"=>"Mei",
            "06"=>"Jun",
            "07"=>"Jul",
            "08"=>"Agu",
            "09"=>"Sep",
            "10"=>"Okt",
            "11"=>"Nov",
            "12"=>"Des"
        );
        return $arrBulan;
    }

    public static function jam_kerja($id){
        $rsData = MsAbsen::where('id_khusus',$id)->orderBy('hari_biasa','asc')->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->hari_biasa]['jam_masuk'] = $r->jam_masuk;
            $arrData[$r->hari_biasa]['jam_pulang'] = $r->jam_keluar;
            $arrData[$r->hari_biasa]['masuk_telat'] = $r->masuk_telat;
            $arrData[$r->hari_biasa]['pulang_telat'] = $r->pulang_telat;
            $arrData[$r->hari_biasa]['lama_kerja'] = $r->lama_kerja;
        }
        return $arrData;
    }

    public static function durasibekerja($id){
        $rsData = MsAbsen::where('id_khusus',$id)->orderBy('hari_biasa','asc')->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->hari_biasa]['lama_kerja'] = $r->lama_kerja;
        }
        return $arrData;
    }

    public static function pilihan_pelanggaran($id = null){
        $rsData = MsKategoriPelanggaran::orderBy('nama_pelanggaran','asc')->get();
        $d = '<option value="">Pilih Pelanggaran</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_pelanggaran == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_pelanggaran\" $sl>$r->nama_pelanggaran</option>";
        }
        return $d;
    }

    public static function hitungdurasi($jm_kerja_masuk,$jm_kerja_pulang){
        $kerja_jam_masukex = explode(':',$jm_kerja_masuk);
        $kerja_jam_keluarex = explode(':',$jm_kerja_pulang);

        $kerja_j_masuk_start = $kerja_jam_masukex[0];
        $kerja_menit_masuk_start = $kerja_jam_masukex[1];

        $kerja_j_keluar_start = $kerja_jam_keluarex[0];
        $kerja_menit_keluar_start = $kerja_jam_keluarex[1];

        $kerjahasil = (intVal($kerja_j_keluar_start) - intVal($kerja_j_masuk_start)) * 60 + (intVal($kerja_menit_keluar_start) - intVal($kerja_menit_masuk_start));
        $kerjahasil = $kerjahasil / 60;
        $kerjahasil = number_format($kerjahasil,2);
        $kerjahasilx = explode(".",$kerjahasil);
        $kerjadepan = sprintf("%02d", $kerjahasilx[0]);
        $kerjagabung = $kerjadepan.":".$kerjahasilx[1];
        return $kerjagabung;
    }

    public static function hitungdurasiterlambat($jm_kerja_masuk,$jam_absen){
        $jam_masukex = explode(':',$jam_absen);
        $jam_telatex = explode(':',$jm_kerja_masuk);

        $j_masuk_start = $jam_masukex[0];
        $menit_masuk = $jam_masukex[1];

        $j_telat_masuk = $jam_telatex[0];
        $menit_telat_masuk = $jam_telatex[1];

        $jmkerja = str_replace(':','',$jam_absen);
        $jmmkerja = str_replace(':','',$jm_kerja_masuk);
        $menit = 0;
        if($jmkerja > $jmmkerja){
            $hasil = (intVal($j_telat_masuk) - intVal($j_masuk_start)) * 60 + (intVal($menit_telat_masuk) - intVal($menit_masuk));
            $hasil = abs($hasil);
            $hasil = number_format($hasil,2);
            $hasilx = explode(".",$hasil);
            $depan = sprintf("%02d", $hasilx[0]);
            $gabung = $depan.":".$hasilx[1];
            $menit = ($gabung*60)+$hasilx[1];
            $menit = $menit/60;
        }

        return $menit;
    }
    public static function durasikerja($jamawal,$jamakhir){
        $datetime1 = new DateTime($jamawal);//start time
        $datetime2 = new DateTime($jamakhir);//end time
        $durasiker = $datetime1->diff($datetime2);
        $durasikerja = sprintf("%02d",$durasiker->h).":".sprintf("%02d",$durasiker->i).":".sprintf("%02d",$durasiker->s);
        return $durasikerja;
    }
    public static function konversiwaktu($waktu){
        $rsData = explode(':',$waktu);
        $jam = $rsData[0]*60;
        $menit = ($rsData[1].":".$rsData[2])*60;
        $jumlahkan = $jam+$menit/60;
        return $jumlahkan;
    }

    public static function get_rekap_data_kehadiran_by_unit($tgl_awal,$tgl_akhir,$arrIdSdm,$tipe){
        $arrUnitPegawai = array();
        $rsPegawai = MsPegawai::whereIn("id_sdm",$arrIdSdm)->get();
        foreach($rsPegawai as $rsPe=>$rpe){
            $arrUnitPegawai[$rpe->id_sdm] = $rpe->id_satkernow;
        }
        $rsDataAbsen = RiwayatPresensi::whereIn("id_sdm",$arrIdSdm)
                        ->whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->get();
        $arrAbsen = array();
        foreach($rsDataAbsen as $rsA=>$rA){
            $tgl = Fungsi::formatDate($rA->tanggal_absen);
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['ket_tgl'] = $tgl;
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['jam_absen'][] = $rA->jam_absen;
        }
        if($tipe!=4){
            return $arrAbsen;
        }else{
            $bulan_awal = date('m',strtotime($tgl_awal));
            $bulan_akhir = date('m',strtotime($tgl_akhir));
            $bulan_awal = sprintf("%0d", $bulan_awal);
            $thn = date('Y',strtotime($tgl_awal));
            $data_bulan = array();
            for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
                $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
                for ($i=1; $i < $tanggal+1; $i++) {
                    $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                    $tglx = Fungsi::formatDate($gbng);
                    $hari = explode(',',$tglx);
                    if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                        $data_bulan[sprintf("%02d", $x)]['nm_bulan'] = bulan($x);
                        $data_bulan[sprintf("%02d", $x)]['tgl_bulan'][sprintf("%02d", $i)] = sprintf("%02d", $i);
                    }
                }
            }
            $arrAlasan = array();$arrAbsenBul = array();$arrTelaat = array();$arrDataRekap = array();$arrAlasanabsen = array();$arrDtApel = array();
            $rsAlasan = DB::table('ms_alasan_absen')->get();
            foreach($rsAlasan as $rsa=>$ralasan){
                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
            }
            $rsDataAbsenKehadiran = DB::table('tr_absen_kehadiran')
                ->whereIn("id_sdm",$arrIdSdm)
                ->whereRaw(" tgl_awal BETWEEN '$tgl_awal' AND '$tgl_akhir' OR tgl_akhir BETWEEN '$tgl_akhir' AND '$tgl_akhir'")
                ->get();
            foreach($rsDataAbsenKehadiran as $sen=>$senx){
                $jm_absen = Fungsi::jumlah_absen($senx->tgl_awal,$senx->tgl_akhir,1);
                $jmalasanabsen[$senx->id_sdm][$senx->id_alasan] = $jm_absen;
            }
            $arrAbsensekali = array();
            foreach($arrAbsen as $id_sdm=>$absen){
                foreach($absen as $tgl_presensi=>$dt_absen){
                    $hariabsen = explode(',',$dt_absen['ket_tgl']);

                    $tglpresensi = date('Y-m-d',strtotime($tgl_presensi));
                    $explode = explode('-',$tglpresensi);
                    $bln_presensi = sprintf("%02d", $explode[1]);
                    $tglpresensikehadiran = sprintf("%02d", $explode[2]);

                    if(count($dt_absen['jam_absen'])>0 && count($dt_absen['jam_absen'])<2){
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['absensekali']['list_tgl'][$tglpresensikehadiran] = 1;
                    }

                    $id_unit = $arrUnitPegawai[$id_sdm];
                    $arrIdWaktuAbsen = jam_kerjaunit($id_unit);
                    if($hariabsen[0]=="Jumat"){
                        $jam_kerja = $arrIdWaktuAbsen[2];
                    }else{
                        $jam_kerja = $arrIdWaktuAbsen[1];
                    }
                    $jam_pulang = end($dt_absen['jam_absen']);
                    $jam_masuk = array_shift($dt_absen['jam_absen']);
                    if($jam_masuk >= $jam_kerja['jam_masuk']){
                        $jam_masukex = explode(':',$jam_masuk);
                        $jam_telatex = explode(':',$jam_kerja['jam_masuk']);

                        $j_masuk_start = $jam_masukex[0];
                        $menit_masuk = $jam_masukex[1];

                        $j_telat_masuk = $jam_telatex[0];
                        $menit_telat_masuk = $jam_telatex[1];

                        $hasil = (intVal($j_telat_masuk) - intVal($j_masuk_start)) * 60 + (intVal($menit_telat_masuk) - intVal($menit_masuk));
                        $hasil = abs($hasil);
                        $hasil = number_format($hasil,2);
                        $hasilx = explode(".",$hasil);
                        $depan = sprintf("%02d", $hasilx[0]);
                        $gabung = $depan.":".$hasilx[1];
                        $menit = ($gabung*60)+$hasilx[1];
                        $menit = $menit/60;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tgl'][$tglpresensikehadiran] = $menit;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['masuk'] = $jam_masuk;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['pulang'] = $jam_pulang;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['menit'] = $menit;
                    }
                    if($jam_pulang <= $jam_kerja['jam_pulang']){
                        $jam_pulangex = explode(':',$jam_pulang);
                        $jam_ker_pulangex = explode(':',$jam_kerja['jam_pulang']);

                        $j_pulang_start = $jam_pulangex[0];
                        $menit_pulang = $jam_pulangex[1];

                        $j_ker_pulang = $jam_ker_pulangex[0];
                        $menit_ker_pulang = $jam_ker_pulangex[1];

                        $hasil = (intVal($j_ker_pulang) - intVal($j_pulang_start)) * 60 + (intVal($menit_ker_pulang) - intVal($menit_pulang));
                        $hasil = abs($hasil);
                        $hasil = number_format($hasil,2);
                        $hasilx = explode(".",$hasil);
                        $depan = sprintf("%02d", $hasilx[0]);
                        $gabung = $depan.":".$hasilx[1];
                        $menit = ($gabung*60)+$hasilx[1];
                        $menit = $menit/60;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tgl'][$tglpresensikehadiran] = $menit;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['masuk'] = $jam_masuk;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['pulang'] = $jam_pulang;
                        $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['menit'] = $menit;
                    }
                }
            }
            foreach($arrDataRekap as $idpg=>$dtbul){
                foreach($dtbul as $idbulancekkehadiran=>$dtbulancekkehadiran){
                    foreach($dtbulancekkehadiran as $kategoricekkehadiran=>$dtkategoricekkehadiran){
                        foreach($dtkategoricekkehadiran['list_tgl'] as $tglcekkehadiran=>$jmlmenit){
                            $nmkategori = $kategoricekkehadiran;
                            $arrDataRekap[$idpg][$idbulancekkehadiran][$nmkategori]['total']+=$jmlmenit;
                        }
                    }
                }
            }
            foreach($data_bulan as $idbln=>$dtbln){
                $nm_bln_gabung = $thn.$idbln;
                foreach($dtbln['tgl_bulan'] as $tglbln=>$tgln){
                    foreach($arrAbsen as $idsdm=>$dtsdmx){
                        $arrDataRekap[$idsdm][$nm_bln_gabung]['hari_kerja'] = count($dtbln['tgl_bulan']);
                        $gabungan = $thn."-".$idbln."-".$tglbln;
                        $cek = $dtsdmx[$gabungan];
                        if($cek!=null){
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['masuk']['list_tgl'][$tglbln] = $tglbln;
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['masuk']['total']+=1;
                        }else{
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['list_tgl'][$tglbln] = $tglbln;
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['total']+=1;
                        }
                        $jumabsen = 0;
                        foreach($arrAlasan as $idalasan=>$nm_alasan){
                            if($jmalasanabsen[$idsdm][$idalasan][$idbln]){
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['absen'][$idalasan]['nm_alasan'] = $nm_alasan;
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['absen'][$idalasan]['data'] = $jmalasanabsen[$idsdm][$idalasan][$idbln];
                                $jumabsen+=count($jmalasanabsen[$idsdm][$idalasan][$idbln]['list_tgl']);
                            }
                        }
                        $arrDataRekap[$idsdm][$nm_bln_gabung]['absen']['totalabsen'] = $jumabsen;
                    }
                }
            }
            $rsDataApel = DB::table('presensi_apel as a')
                        ->join('ms_kegiatan_apel as b','a.id_kegiatan','=','b.id_kegiatan')
                        ->whereRaw(" tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir'")
                        ->whereIn("id_sdm",$arrIdSdm)
                        ->get();
            foreach($rsDataApel as $apl=>$dtapl){
                $tgl_kegiatan = str_replace("-","",substr($dtapl->tgl_kegiatan,0,7));
                if($dtapl->kehadiran=="H"){
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']+=1;
                }if($dtapl->kehadiran=="T"){
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']+=1;
                }
            }
            return $arrDataRekap;
        }
    }
    public static function hitungdurasipulangcepat($jam_pulang,$jam_kerja){
        $jam_pulangex = explode(':',$jam_pulang);
        $jam_ker_pulangex = explode(':',$jam_kerja);

        $j_pulang_start = $jam_pulangex[0];
        $menit_pulang = $jam_pulangex[1];

        $j_ker_pulang = $jam_ker_pulangex[0];
        $menit_ker_pulang = $jam_ker_pulangex[1];

        $hasil = (intVal($j_ker_pulang) - intVal($j_pulang_start)) * 60 + (intVal($menit_ker_pulang) - intVal($menit_pulang));
        $hasil = abs($hasil);
        $hasil = number_format($hasil,2);
        $hasilx = explode(".",$hasil);
        $depan = sprintf("%02d", $hasilx[0]);
        $gabung = $depan.":".$hasilx[1];
        $menit = ($gabung*60)+$hasilx[1];
        $menit = $menit/60;

        return $menit;
    }
    public static function gettanggalabsenkehadiran($arrIdSdm,$tgl_awal,$tgl_akhir){
        $arrData = array();$arrAlasan = array();
        $rsAlasan = DB::table('ms_alasan_absen')->get();
        foreach($rsAlasan as $rsa=>$ralasan){
            $arrAlasan[$ralasan->id_alasan]['nm_alasan'] = $ralasan->alasan;
            $arrAlasan[$ralasan->id_alasan]['kode_alasan'] = $ralasan->kode_lokal;
        }
        $rsDataAbsenKehadiran = DB::table('tr_absen_kehadiran')
                    ->whereIn("id_sdm",$arrIdSdm)
                    //->where('id_absen','ffcfe614-a036-41eb-9a42-727f2d5841be')
                    ->whereRaw(" ( tgl_awal BETWEEN '$tgl_awal' AND '$tgl_akhir' OR tgl_akhir BETWEEN '$tgl_akhir' AND '$tgl_akhir' ) ")
                    ->get();
        foreach($rsDataAbsenKehadiran as $rs=>$r){
            $tgl_awal = explode('-',$r->tgl_awal);
            $tgl_akhir = explode('-',$r->tgl_akhir);
            $tanggal_absen = daterange($r->tgl_awal,$r->tgl_akhir);
            foreach($tanggal_absen as $tgl){
                $tglx = Fungsi::formatDate($tgl);
                $hari = explode(',',$tglx);
                if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                    $arrData[$r->id_sdm][$tgl]['alasan_absen'] = $arrAlasan[$r->id_alasan];
                }
            }

        }
        return $arrData;
    }

    public static function getajuan_justifikasi($idsdm,$tgl_awal,$tgl_akhir){
        $rsJustifikasi = TrJustifikasi::where('id_sdm',$idsdm)
                        ->whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->get();
        $arrData = array();
        foreach($rsJustifikasi as $rs=>$r){
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['jam_masuk'] = $r->jam_masuk;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['jam_pulang'] = $r->jam_pulang;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['ket_justifikasi'] = $r->ket_justifikasi;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['kategori_justifikasi'] = $r->kategori_justifikasi;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['status'] = $r->justifikasi_atasan;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['ajuan_durasi_justifikasi'] = $r->ajuan_durasi_justifikasi;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['tgl_justifikasi'] = $r->tgl_justifikasi;
            $arrData[$r->tanggal_absen][$r->kategori_justifikasi]['durasi_justifikasi'] = $r->durasi_justifikasi;
        }
        return $arrData;
    }

    public static function getajuan_justifikasiall($tgl_awal,$tgl_akhir){
        $rsJustifikasi = TrJustifikasi::whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->get();
        $arrData = array();
        foreach($rsJustifikasi as $rs=>$r){
            if($r->justifikasi_atasan==1){
                $arrData[$r->id_sdm][$r->tanggal_absen]['jam_masuk'] = $r->jam_masuk;
                $arrData[$r->id_sdm][$r->tanggal_absen]['jam_pulang'] = $r->jam_pulang;
                $arrData[$r->id_sdm][$r->tanggal_absen]['ket_justifikasi'] = $r->ket_justifikasi;
                $arrData[$r->id_sdm][$r->tanggal_absen]['kategori_justifikasi'] = $r->kategori_justifikasi;
                $arrData[$r->id_sdm][$r->tanggal_absen]['status'] = $r->justifikasi_atasan;
                $arrData[$r->id_sdm][$r->tanggal_absen]['ajuan_durasi_justifikasi'] = $r->ajuan_durasi_justifikasi;
                $arrData[$r->id_sdm][$r->tanggal_absen]['tgl_justifikasi'] = $r->tgl_justifikasi;
                $arrData[$r->id_sdm][$r->tanggal_absen]['durasi_justifikasi'] = $r->durasi_justifikasi;
            }
        }
        return $arrData;
    }

    public static function getajuan_justifikasiarr($arridsdm,$tgl_awal,$tgl_akhir,$kode = 1){
        $rsJustifikasi = TrJustifikasi::whereIn('id_sdm',$arridsdm)
                        ->whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->get();
        $arrStatusJustifikasi = array("1"=>"Disetujui","2"=>"Tidak Disetuji","0"=>"Belum Disetujui");
        $arrData = array();$arrRekap = array();
        foreach($rsJustifikasi as $rs=>$r){
            // 1 setujui
            // 2 tidak disetujui
            // null belum diproses
            $arrRekap[$r->id_sdm][$r->justifikasi_atasan][$r->id_justifikasi] = $r->id_justifikasi;
            $arrData[$r->id_sdm][$r->tanggal_absen][$r->kategori_justifikasi]['status'] = $r->justifikasi_atasan;
            $arrData[$r->id_sdm][$r->tanggal_absen][$r->kategori_justifikasi]['ajuan_durasi_justifikasi'] = $r->ajuan_durasi_justifikasi;
            $arrData[$r->id_sdm][$r->tanggal_absen][$r->kategori_justifikasi]['tgl_justifikasi'] = $r->tgl_justifikasi;
            $arrData[$r->id_sdm][$r->tanggal_absen][$r->kategori_justifikasi]['durasi_justifikasi'] = $r->durasi_justifikasi;
        }
        if($kode=1){
            $arrDt = array();
            foreach($arrRekap as $id_sdm=>$dt_sdm){
                foreach($arrStatusJustifikasi as $key=>$nm_status){
                    $arrDt[$id_sdm][$key]['nm_status'] = $nm_status;
                    $arrDt[$id_sdm][$key]['jmlh'] = count($dt_sdm[$key]);
                }
            }
            return $arrDt;
        }else{
            return $arrData;
        }

    }

    public static function ramadhan($tahun){
        $rsData = tgl_ramadhan($tahun);
        return $rsData;
    }
    public static function jamkerjashift(){
        $rsData = MsWaktuShift::where('id_khusus','<>',null)->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->kode_shift]['nm_shift'] = $r->nm_shift;
            $arrData[$r->kode_shift]['jam_masuk'] = $r->jam_masuk;
            $arrData[$r->kode_shift]['jam_pulang'] = $r->jam_pulang;
        }
        return $arrData;
    }
    public static function getRekapDataAbsenPoli($tgl_awal,$tgl_akhir,$arrIdSdm,$tipe){
        $arrKategoriJustifikasi = array("0"=>"Tidak mengganggu layanan",'1'=>"Mengganggu Layanan");
        $rsDataAbsen = RiwayatPresensi::whereIn("id_sdm",$arrIdSdm)
                        ->whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->orderBy('tanggal_absen','asc')
                        ->orderBy('jam_absen','asc')
                        ->get();
        $arrAbsen = array();$justifikasi = array();
        foreach($rsDataAbsen as $rsA=>$rA){
            $tgl = Fungsi::formatDate($rA->tanggal_absen);
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['ket_tgl'] = $tgl;
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['jam_absen'][] = $rA->jam_absen;
            if((int)$rA->justifikasi_atasan>0){
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['alasan'] = $rA->alasan;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['tgl_justifikasi'] = $rA->tgl_justifikasi;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['ket_justifikasi'] = $rA->ket_justifikasi;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['durasi_justifikasi'] = $rA->durasi_justifikasi;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['kategori_justifikasi'] = $arrKategoriJustifikasi[$rA->kategori_justifikasi];

            }
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['justifikasi'] = $justifikasi[$rA->id_sdm][$rA->tanggal_absen];
        }
        // khusus untuk tidak hadir saja

        $tahunbulan = date('Y-m',strtotime($tgl_awal));
        $rsJustifikasi = TrJustifikasi::whereIn('id_sdm',$arrIdSdm)
                        ->whereRaw(" SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 0, 8) = '$tahunbulan' ")
                        ->get();
        $arrJustifikasi = array();
        foreach($rsJustifikasi as $rsjus=>$rjus){
            $tahunbulan = date('Y-m',strtotime($rjus->tanggal_absen));
            $tglabsennya = date('d',strtotime($rjus->tanggal_absen));
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['justifikasi_atasan'] = $rjus->justifikasi_atasan;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['alasan'] = $rjus->alasan;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['durasi_justifikasi'] = $rjus->durasi_justifikasi;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['kategori_justifikasi'] = $arrKategoriJustifikasi[$rjus->kategori_justifikasi];
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['ket_justifikasi'] = $rjus->ket_justifikasi;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['tgl_justifikasi'] = $rjus->tgl_justifikasi;
        }

        // ambil jadwal poli
        $rsDataPoli = TrJadwalShift::with(['dtwaktuabsen'])->whereIn("id_sdm",$arrIdSdm)
                        ->whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->get();
        foreach($rsDataPoli as $rsPoli=>$rPoli){
            $arrAbsen[$rPoli->id_sdm][$rPoli->tanggal_absen]['msjadwalshift']['nm_shift'] = $rPoli->dtwaktuabsen->nm_shift;
            $arrAbsen[$rPoli->id_sdm][$rPoli->tanggal_absen]['msjadwalshift']['kode_jadwal'] = $rPoli->dtwaktuabsen->kode_shift;
            $arrAbsen[$rPoli->id_sdm][$rPoli->tanggal_absen]['msjadwalshift']['jam_masuk'] = $rPoli->dtwaktuabsen->jam_masuk;
            $arrAbsen[$rPoli->id_sdm][$rPoli->tanggal_absen]['msjadwalshift']['jam_pulang'] = $rPoli->dtwaktuabsen->jam_pulang;
        }

        if($tipe!=4){
            return $arrAbsen;
        }else{
            $bulan_awal = date('m',strtotime($tgl_awal));
            $bulan_akhir = date('m',strtotime($tgl_akhir));
            $bulan_awal = sprintf("%0d", $bulan_awal);
            $thn = date('Y',strtotime($tgl_awal));
            $data_bulan = array();
            for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
                $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
                for ($i=1; $i < $tanggal+1; $i++) {
                    $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                    $tglx = Fungsi::formatDate($gbng);
                    $hari = explode(',',$tglx);
                    if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                        $data_bulan[sprintf("%02d", $x)]['nm_bulan'] = bulan($x);
                        $data_bulan[sprintf("%02d", $x)]['tgl_bulan'][sprintf("%02d", $i)] = sprintf("%02d", $i);
                    }
                }
            }
            $arrAlasan = array();$arrAbsenBul = array();$arrTelaat = array();$arrDataRekap = array();$arrAlasanabsen = array();$arrDtApel = array();
            $rsAlasan = DB::table('ms_alasan_absen')->get();
            foreach($rsAlasan as $rsa=>$ralasan){
                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
            }
            $rsDataAbsenKehadiran = DB::table('tr_absen_kehadiran')
                ->whereIn("id_sdm",$arrIdSdm)
                ->whereRaw(" ( tgl_awal BETWEEN '$tgl_awal' AND '$tgl_akhir' OR tgl_akhir BETWEEN '$tgl_akhir' AND '$tgl_akhir' ) ")
                ->get();
            $arrAbsenTanggal= array();$jmalasanabsen = array();$jmalasanabsenfirst = array();$arrtglabsen = array();
            foreach($rsDataAbsenKehadiran as $sen=>$senx){
                $jm_absen = Fungsi::jumlah_absen($senx->tgl_awal,$senx->tgl_akhir,1);
                $jmalasanabsenfirst[$senx->id_sdm][$senx->id_alasan][$senx->id_absen] = $jm_absen;
                $tanggal_absen = daterange($senx->tgl_awal,$senx->tgl_akhir);
                foreach($tanggal_absen as $tgl){
                    $bulanxx = date('m',strtotime($tgl));
                    $tglxx = date('d',strtotime($tgl));
                    $arrAbsenTanggal[$senx->id_sdm][$bulanxx][$tglxx] = $tglxx;
                    $arrtglabsen[$senx->id_sdm][$bulanxx][$tglxx] = $tglxx;
                }

            }
            foreach($jmalasanabsenfirst as $idsdmpegawai=>$dtsdmpegawai){
                foreach($dtsdmpegawai as $idalasanabsen=>$dtalasanabsen){
                    foreach($dtalasanabsen as $keyidabsen=>$dtkeyabsen){
                        foreach($dtkeyabsen as $idbulanabsen=>$dtidbulanabsen){
                            foreach($dtidbulanabsen['list_tgl'] as $dtlist_tgl=>$lst_tgl){
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['nm_bulan'] = $dtidbulanabsen['nm_bulan'];
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['list_tgl'][$dtlist_tgl] = $dtlist_tgl;
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['total']+=1;
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['tahun'] = $dtidbulanabsen['tahun'];
                            }
                        }
                    }
                }
            }
            $arrAbsensekali = array();
            foreach($arrAbsen as $id_sdm=>$absen){
                foreach($absen as $tgl_presensi=>$dt_absen){
                    $hariabsen = explode(',',$dt_absen['ket_tgl']);
                    // if($arrtglramadhan[$tgl_presensi]){
                    //     $arrIdWaktuAbsen = $wakturamadhan;
                    // }
                    $tglpresensi = date('Y-m-d',strtotime($tgl_presensi));
                    $explode = explode('-',$tglpresensi);
                    $bln_presensi = sprintf("%02d", $explode[1]);
                    $tglpresensikehadiran = sprintf("%02d", $explode[2]);

                    // cek apa ada absen jika ada abaikan semua keterangan presensi
                    if($arrAbsenTanggal[$id_sdm][$bln_presensi][$tglpresensikehadiran]==null){
                        // if($hariabsen[0]=="Jumat"){
                        //     $jam_kerja = $arrIdWaktuAbsen[2];
                        // }else{
                        //     $jam_kerja = $arrIdWaktuAbsen[1];
                        // }
                        //if($dt_sdm['id_satker'] == "30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                            $jam_kerja = $dt_absen['msjadwalshift'];
                        //}
                        $jam_pulang = end($dt_absen['jam_absen']);
                        $jam_masuk = array_shift($dt_absen['jam_absen']);
                        if($jam_pulang==null){
                            $jam_pulang = $jam_masuk;
                        }
                        if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu" && $jam_masuk == $jam_pulang){
                            $arrDataRekap[$id_sdm][$thn.$bln_presensi]['absensekali']['list_tgl'][$tglpresensikehadiran]=1;
                        }

                        if($jam_masuk >= $jam_kerja['jam_masuk'] && $jam_masuk!=$jam_pulang){
                            if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu"){
                                $jam_masukex = explode(':',$jam_masuk);
                                $jam_telatex = explode(':',$jam_kerja['jam_masuk']);

                                $j_masuk_start = $jam_masukex[0];
                                $menit_masuk = $jam_masukex[1];

                                $j_telat_masuk = $jam_telatex[0];
                                $menit_telat_masuk = $jam_telatex[1];

                                $hasil = (intVal($j_telat_masuk) - intVal($j_masuk_start)) * 60 + (intVal($menit_telat_masuk) - intVal($menit_masuk));
                                $hasil = abs($hasil);

                                $hasil = number_format($hasil,2);
                                $hasilx = explode(".",$hasil);
                                $depan = sprintf("%02d", $hasilx[0]);
                                $gabung = $depan.":".$hasilx[1];
                                $menit = ($gabung*60)+$hasilx[1];
                                $menit = $menit/60;
                                $durasi_terlambat = $menit;
                                if($jam_masuk==$jam_pulang){
                                    $menit = 0;
                                }
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tgl'][$tglpresensikehadiran] = $durasi_terlambat;
                                if($justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran]){
                                    $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['justifikasi'] = $justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran];
                                }
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['masuk'] = $jam_masuk;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['pulang'] = $jam_pulang;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['menit'] = $durasi_terlambat;
                            }
                        }
                        if($jam_pulang <= $jam_kerja['jam_pulang'] && $jam_masuk!=$jam_pulang){
                            if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu"){
                                $jam_pulangex = explode(':',$jam_pulang);
                                $jam_ker_pulangex = explode(':',$jam_kerja['jam_pulang']);

                                $j_pulang_start = $jam_pulangex[0];
                                $menit_pulang = $jam_pulangex[1];

                                $j_ker_pulang = $jam_ker_pulangex[0];
                                $menit_ker_pulang = $jam_ker_pulangex[1];

                                $hasilcpt = (intVal($j_ker_pulang) - intVal($j_pulang_start)) * 60 + (intVal($menit_ker_pulang) - intVal($menit_pulang));
                                $hasilcpt = abs($hasilcpt);
                                $hasilcpt = number_format($hasilcpt,2);
                                $hasilcpt = explode(".",$hasilcpt);
                                $depancpt = sprintf("%02d", $hasilcpt[0]);
                                $gabungcpt = $depancpt.":".$hasilcpt[1];
                                $menitcpt = ($gabungcpt*60)+$hasilcpt[1];
                                $menitcpt = $menitcpt/60;
                                if($jam_masuk==$jam_pulang){
                                    $menitcpt = 0;
                                }
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tgl'][$tglpresensikehadiran] = $menitcpt;
                                if($justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran]){
                                    $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['justifikasi'] = $justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran];
                                }

                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['masuk'] = $jam_masuk;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['pulang'] = $jam_pulang;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['menit'] = $menitcpt;
                            }
                        }
                    }
                }
            }
            foreach($arrDataRekap as $idpg=>$dtbul){
                foreach($dtbul as $idbulancekkehadiran=>$dtbulancekkehadiran){
                    foreach($dtbulancekkehadiran as $kategoricekkehadiran=>$dtkategoricekkehadiran){
                        //if($kategoricekkehadiran!="absensekali"){
                            foreach($dtkategoricekkehadiran['list_tgl'] as $tglcekkehadiran=>$jmlmenit){
                                $nmkategori = $kategoricekkehadiran;
                                $arrDataRekap[$idpg][$idbulancekkehadiran][$nmkategori]['total']+=$jmlmenit;
                            }
                        //}
                    }
                }
            }
            foreach($data_bulan as $idbln=>$dtbln){
                $nm_bln_gabung = $thn.$idbln;
                foreach($dtbln['tgl_bulan'] as $tglbln=>$tgln){
                    foreach($arrAbsen as $idsdm=>$dtsdmx){
                        foreach($arrAlasan as $idalasan=>$nm_alasan){
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['absen'][$idalasan]['nm_alasan'] = $nm_alasan;
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['absen'][$idalasan]['data'] = $jmalasanabsen[$idsdm][$idalasan][$idbln];
                        }
                        $arrDataRekap[$idsdm][$nm_bln_gabung]['hari_kerja'] = count($dtbln['tgl_bulan']);
                        $gabungan = $thn."-".$idbln."-".$tglbln;
                        $cek = $dtsdmx[$gabungan];
                        if($cek!=null){
                            $cekalasanabsen = $arrtglabsen[$idsdm][$idbln][$tglbln];
                            if($cekalasanabsen==null){
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['masuk']['list_tgl'][$tglbln] = $tglbln;
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['masuk']['total']+=1;
                            }
                        }else{
                            if($arrAbsenTanggal[$idsdm][$idbln][$tglbln]==null){
                                if($arrJustifikasi[$idsdm][$thn."-".$idbln][$tglbln]){
                                    $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['list_tgl'][$tglbln]['justifikasi'] = $arrJustifikasi[$idsdm][$thn."-".$idbln][$tglbln];
                                }else{
                                    $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['list_tgl'][$tglbln] = $tglbln;
                                }
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['total']+=1;
                            }
                        }

                    }
                }
            }
            $rsDataApel = DB::table('presensi_apel as a')
                        ->join('ms_kegiatan_apel as b','a.id_kegiatan','=','b.id_kegiatan')
                        ->whereRaw(" tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir'")
                        ->whereIn("id_sdm",$arrIdSdm)
                        ->get();
            foreach($rsDataApel as $apl=>$dtapl){
                $tgl_kegiatan = str_replace("-","",substr($dtapl->tgl_kegiatan,0,7));
                if($dtapl->kehadiran=="H"){
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']['total']+=1;
                }if($dtapl->kehadiran=="T"){
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['total']+=1;
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['justifikasi']['alasan']=$dtapl->alasan;
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['justifikasi']['tgl_justifikasi']=$dtapl->tgl_justifikasi;
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['justifikasi']['ket_justifikasi']=$dtapl->ket_justifikasi;
                }
                $hadirapel = $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']['total'];
                if(count($hadirapel)<1){
                    $hadirapel = 0;
                }
                $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']['total'] = $hadirapel;
                $tidak_hadirapel = $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['total'];
                if(count($tidak_hadirapel)<1){
                    $tidak_hadirapel = 0;
                }
                $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['total'] = $tidak_hadirapel;
            }
            $arrDataRekapNew = array();
            foreach($arrDataRekap as $id_sdmz=>$dtsdmz){
                foreach($dtsdmz as $tglnya=>$dttglnya){
                    $arrDataRekapNew[$id_sdmz][$tglnya]['hari_kerja'] = $arrDataRekap[$id_sdmz][$tglnya]['hari_kerja'];
                    $telat = $arrDataRekap[$id_sdmz][$tglnya]['telat'];
                    if(count($telat)<1){
                        $telat = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['telat'] = $telat;

                    $pulang_cepat = $arrDataRekap[$id_sdmz][$tglnya]['pulang_cepat'];
                    if(count($pulang_cepat)<1){
                        $pulang_cepat = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['pulang_cepat'] = $pulang_cepat;

                    $absensekali = $arrDataRekap[$id_sdmz][$tglnya]['absensekali'];
                    if(count($absensekali)<1){
                        $absensekali = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['absensekali'] = $absensekali;

                    $tidakmasuk = $arrDataRekap[$id_sdmz][$tglnya]['tidakmasuk'];
                    if(count($tidakmasuk)<1){
                        $tidakmasuk = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['tidakmasuk'] = $tidakmasuk;

                    $absen = $arrDataRekap[$id_sdmz][$tglnya]['absen'];
                    if(count($absen)<1){
                        $absen = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['absen'] = $absen;

                    $dt_apel = $arrDataRekap[$id_sdmz][$tglnya]['dt_apel'];
                    // if(count($dt_apel)<1){
                    //     $dt_apel = 0;
                    // }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['dt_apel'] = $dt_apel;

                    $masuk = $arrDataRekap[$id_sdmz][$tglnya]['masuk'];
                    if(count($masuk)<1){
                        $masuk = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['masuk'] = $masuk;
                }
            }
            return $arrDataRekapNew;
        }

    }


    public static function get_rekap_data_kehadiran($arrIdWaktuAbsen,$tgl_awal,$tgl_akhir,$arrIdSdm,$tipe){
        // cek ramadhan
        $tahunpencarian = date('Y',strtotime($tgl_awal));
        $arrtglramadhan = tgl_ramadhan($tahunpencarian);
        // ambil waktu ramadhan
        $wakturamadhan = jam_kerja_cek('347b23a9-8919-43ec-9b2d-a0c4b810b61d');

        $arrKategoriJustifikasi = array("0"=>"Tidak mengganggu layanan",'1'=>"Mengganggu Layanan");
        $rsDataAbsen = RiwayatPresensi::whereIn("id_sdm",$arrIdSdm)
                        ->whereRaw(" tanggal_absen >= '$tgl_awal' and tanggal_absen <= '$tgl_akhir'")
                        ->orderBy('tanggal_absen','asc')
                        ->orderBy('jam_absen','asc')
                        ->get();
        $arrAbsen = array();$justifikasi = array();
        foreach($rsDataAbsen as $rsA=>$rA){
            $tgl = Fungsi::formatDate($rA->tanggal_absen);
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['ket_tgl'] = $tgl;
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['jam_absen'][] = $rA->jam_absen;
            if((int)$rA->justifikasi_atasan>0){
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['alasan'] = $rA->alasan;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['tgl_justifikasi'] = $rA->tgl_justifikasi;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['ket_justifikasi'] = $rA->ket_justifikasi;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['durasi_justifikasi'] = $rA->durasi_justifikasi;
                $justifikasi[$rA->id_sdm][$rA->tanggal_absen]['kategori_justifikasi'] = $arrKategoriJustifikasi[$rA->kategori_justifikasi];

            }
            $arrAbsen[$rA->id_sdm][$rA->tanggal_absen]['justifikasi'] = $justifikasi[$rA->id_sdm][$rA->tanggal_absen];
        }
        // khusus untuk tidak hadir saja

        $tahunbulan = date('Y-m',strtotime($tgl_awal));
        $rsJustifikasi = TrJustifikasi::whereIn('id_sdm',$arrIdSdm)
                        ->whereRaw(" SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 0, 8) = '$tahunbulan' ")
                        ->get();
        $arrJustifikasi = array();
        foreach($rsJustifikasi as $rsjus=>$rjus){
            $tahunbulan = date('Y-m',strtotime($rjus->tanggal_absen));
            $tglabsennya = date('d',strtotime($rjus->tanggal_absen));
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['justifikasi_atasan'] = $rjus->justifikasi_atasan;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['alasan'] = $rjus->alasan;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['durasi_justifikasi'] = $rjus->durasi_justifikasi;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['kategori_justifikasi'] = $arrKategoriJustifikasi[$rjus->kategori_justifikasi];
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['ket_justifikasi'] = $rjus->ket_justifikasi;
            $arrJustifikasi[$rjus->id_sdm][$tahunbulan][$tglabsennya]['tgl_justifikasi'] = $rjus->tgl_justifikasi;
        }
        if($tipe!=4){
            return $arrAbsen;
        }else{
            $bulan_awal = date('m',strtotime($tgl_awal));
            $bulan_akhir = date('m',strtotime($tgl_akhir));
            $bulan_awal = sprintf("%0d", $bulan_awal);
            $thn = date('Y',strtotime($tgl_awal));
            $data_bulan = array();
            for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
                $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
                for ($i=1; $i < $tanggal+1; $i++) {
                    $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                    $tglx = Fungsi::formatDate($gbng);
                    $hari = explode(',',$tglx);
                    if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                        $data_bulan[sprintf("%02d", $x)]['nm_bulan'] = bulan($x);
                        $data_bulan[sprintf("%02d", $x)]['tgl_bulan'][sprintf("%02d", $i)] = sprintf("%02d", $i);
                    }
                }
            }
            $arrAlasan = array();$arrAbsenBul = array();$arrTelaat = array();$arrDataRekap = array();$arrAlasanabsen = array();$arrDtApel = array();
            $rsAlasan = DB::table('ms_alasan_absen')->get();
            foreach($rsAlasan as $rsa=>$ralasan){
                $arrAlasan[$ralasan->id_alasan] = $ralasan->alasan;
            }
            $rsDataAbsenKehadiran = DB::table('tr_absen_kehadiran')
                ->whereIn("id_sdm",$arrIdSdm)
                ->whereRaw(" ( tgl_awal BETWEEN '$tgl_awal' AND '$tgl_akhir' OR tgl_akhir BETWEEN '$tgl_akhir' AND '$tgl_akhir' ) ")
                ->get();
            $arrAbsenTanggal= array();$jmalasanabsen = array();$jmalasanabsenfirst = array();$arrtglabsen = array();
            foreach($rsDataAbsenKehadiran as $sen=>$senx){
                $jm_absen = Fungsi::jumlah_absen($senx->tgl_awal,$senx->tgl_akhir,1);
                $jmalasanabsenfirst[$senx->id_sdm][$senx->id_alasan][$senx->id_absen] = $jm_absen;
                $tanggal_absen = daterange($senx->tgl_awal,$senx->tgl_akhir);
                foreach($tanggal_absen as $tgl){
                    $bulanxx = date('m',strtotime($tgl));
                    $tglxx = date('d',strtotime($tgl));
                    $arrAbsenTanggal[$senx->id_sdm][$bulanxx][$tglxx] = $tglxx;
                    $arrtglabsen[$senx->id_sdm][$bulanxx][$tglxx] = $tglxx;
                }

            }

            foreach($jmalasanabsenfirst as $idsdmpegawai=>$dtsdmpegawai){
                foreach($dtsdmpegawai as $idalasanabsen=>$dtalasanabsen){
                    foreach($dtalasanabsen as $keyidabsen=>$dtkeyabsen){
                        foreach($dtkeyabsen as $idbulanabsen=>$dtidbulanabsen){
                            foreach($dtidbulanabsen['list_tgl'] as $dtlist_tgl=>$lst_tgl){
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['nm_bulan'] = $dtidbulanabsen['nm_bulan'];
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['list_tgl'][$dtlist_tgl] = $dtlist_tgl;
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['total']+=1;
                                $jmalasanabsen[$idsdmpegawai][$idalasanabsen][$idbulanabsen]['tahun'] = $dtidbulanabsen['tahun'];
                            }
                        }
                    }
                }
            }
            $arrAbsensekali = array();
            foreach($arrAbsen as $id_sdm=>$absen){
                foreach($absen as $tgl_presensi=>$dt_absen){
                    $hariabsen = explode(',',$dt_absen['ket_tgl']);
                    if($arrtglramadhan[$tgl_presensi]){
                        $arrIdWaktuAbsen = $wakturamadhan;
                    }
                    $tglpresensi = date('Y-m-d',strtotime($tgl_presensi));
                    $explode = explode('-',$tglpresensi);
                    $bln_presensi = sprintf("%02d", $explode[1]);
                    $tglpresensikehadiran = sprintf("%02d", $explode[2]);

                    // cek apa ada absen jika ada abaikan semua keterangan presensi
                    if($arrAbsenTanggal[$id_sdm][$bln_presensi][$tglpresensikehadiran]==null){
                        if($hariabsen[0]=="Jumat"){
                            $jam_kerja = $arrIdWaktuAbsen[2];
                        }else{
                            $jam_kerja = $arrIdWaktuAbsen[1];
                        }
                        $jam_pulang = end($dt_absen['jam_absen']);
                        $jam_masuk = array_shift($dt_absen['jam_absen']);
                        if($jam_pulang==null){
                            $jam_pulang = $jam_masuk;
                        }
                        if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu" && $jam_masuk == $jam_pulang){
                            $arrDataRekap[$id_sdm][$thn.$bln_presensi]['absensekali']['list_tgl'][$tglpresensikehadiran]=1;
                        }

                        if($jam_masuk >= $jam_kerja['jam_masuk'] && $jam_masuk!=$jam_pulang){
                            if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu"){
                                $jam_masukex = explode(':',$jam_masuk);
                                $jam_telatex = explode(':',$jam_kerja['jam_masuk']);

                                $j_masuk_start = $jam_masukex[0];
                                $menit_masuk = $jam_masukex[1];

                                $j_telat_masuk = $jam_telatex[0];
                                $menit_telat_masuk = $jam_telatex[1];

                                $hasil = (intVal($j_telat_masuk) - intVal($j_masuk_start)) * 60 + (intVal($menit_telat_masuk) - intVal($menit_masuk));
                                $hasil = abs($hasil);

                                $hasil = number_format($hasil,2);
                                $hasilx = explode(".",$hasil);
                                $depan = sprintf("%02d", $hasilx[0]);
                                $gabung = $depan.":".$hasilx[1];
                                $menit = ($gabung*60)+$hasilx[1];
                                $menit = $menit/60;
                                $durasi_terlambat = $menit;
                                if($jam_masuk==$jam_pulang){
                                    $menit = 0;
                                }
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tgl'][$tglpresensikehadiran] = $durasi_terlambat;
                                if($justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran]){
                                    $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['justifikasi'] = $justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran];
                                }
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['masuk'] = $jam_masuk;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['pulang'] = $jam_pulang;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['telat']['list_tglwaktuabsen'][$tglpresensikehadiran]['menit'] = $durasi_terlambat;
                            }
                        }
                        if($jam_pulang <= $jam_kerja['jam_pulang'] && $jam_masuk!=$jam_pulang){
                            if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu"){
                                $jam_pulangex = explode(':',$jam_pulang);
                                $jam_ker_pulangex = explode(':',$jam_kerja['jam_pulang']);

                                $j_pulang_start = $jam_pulangex[0];
                                $menit_pulang = $jam_pulangex[1];

                                $j_ker_pulang = $jam_ker_pulangex[0];
                                $menit_ker_pulang = $jam_ker_pulangex[1];

                                $hasilcpt = (intVal($j_ker_pulang) - intVal($j_pulang_start)) * 60 + (intVal($menit_ker_pulang) - intVal($menit_pulang));
                                $hasilcpt = abs($hasilcpt);
                                $hasilcpt = number_format($hasilcpt,2);
                                $hasilcpt = explode(".",$hasilcpt);
                                $depancpt = sprintf("%02d", $hasilcpt[0]);
                                $gabungcpt = $depancpt.":".$hasilcpt[1];
                                $menitcpt = ($gabungcpt*60)+$hasilcpt[1];
                                $menitcpt = $menitcpt/60;
                                if($jam_masuk==$jam_pulang){
                                    $menitcpt = 0;
                                }
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tgl'][$tglpresensikehadiran] = $menitcpt;
                                if($justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran]){
                                    $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['justifikasi'] = $justifikasi[$id_sdm][$thn."-".$bln_presensi."-".$tglpresensikehadiran];
                                }

                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['masuk'] = $jam_masuk;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['pulang'] = $jam_pulang;
                                $arrDataRekap[$id_sdm][$thn.$bln_presensi]['pulang_cepat']['list_tglwaktuabsen'][$tglpresensikehadiran]['menit'] = $menitcpt;
                            }
                        }
                    }
                }
            }
            $arrtglabsenkehadiran = array();
            foreach($arrDataRekap as $idpg=>$dtbul){
                foreach($dtbul as $idbulancekkehadiran=>$dtbulancekkehadiran){
                    foreach($dtbulancekkehadiran as $kategoricekkehadiran=>$dtkategoricekkehadiran){
                        //if($kategoricekkehadiran!="absensekali"){
                            foreach($dtkategoricekkehadiran['list_tgl'] as $tglcekkehadiran=>$jmlmenit){
                                $arrtglabsenkehadiran[$idpg][$tglcekkehadiran] = $tglcekkehadiran;
                                $nmkategori = $kategoricekkehadiran;
                                $arrDataRekap[$idpg][$idbulancekkehadiran][$nmkategori]['total']+=$jmlmenit;
                            }
                        //}
                    }
                }
            }
            foreach($data_bulan as $idbln=>$dtbln){
                $nm_bln_gabung = $thn.$idbln;
                foreach($dtbln['tgl_bulan'] as $tglbln=>$tgln){
                    foreach($arrAbsen as $idsdm=>$dtsdmx){
                        foreach($arrAlasan as $idalasan=>$nm_alasan){
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['absen'][$idalasan]['nm_alasan'] = $nm_alasan;
                            $arrDataRekap[$idsdm][$nm_bln_gabung]['absen'][$idalasan]['data'] = $jmalasanabsen[$idsdm][$idalasan][$idbln];
                        }
                        $arrDataRekap[$idsdm][$nm_bln_gabung]['hari_kerja'] = count($dtbln['tgl_bulan']);
                        $gabungan = $thn."-".$idbln."-".$tglbln;
                        $cek = $dtsdmx[$gabungan];
                        if($cek!=null){
                            $cekalasanabsen = $arrtglabsen[$idsdm][$idbln][$tglbln];
                            if($cekalasanabsen==null){
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['masuk']['list_tgl'][$tglbln] = $tglbln;
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['masuk']['total']+=1;
                            }
                        }else{
                            if($arrAbsenTanggal[$idsdm][$idbln][$tglbln]==null){
                                if($arrJustifikasi[$idsdm][$thn."-".$idbln][$tglbln]){
                                    $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['list_tgl'][$tglbln]['justifikasi'] = $arrJustifikasi[$idsdm][$thn."-".$idbln][$tglbln];
                                }else{
                                    $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['list_tgl'][$tglbln] = $tglbln;
                                }
                                $arrDataRekap[$idsdm][$nm_bln_gabung]['tidakmasuk']['total']+=1;
                            }
                        }

                    }
                }
            }
            $rsDataApel = DB::table('presensi_apel as a')
                        ->join('ms_kegiatan_apel as b','a.id_kegiatan','=','b.id_kegiatan')
                        ->whereRaw(" tgl_kegiatan BETWEEN '$tgl_awal' AND '$tgl_akhir'")
                        ->whereIn("id_sdm",$arrIdSdm)
                        ->get();
            foreach($rsDataApel as $apl=>$dtapl){
                $tgl_kegiatan = str_replace("-","",substr($dtapl->tgl_kegiatan,0,7));
                if($dtapl->kehadiran=="H"){
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']['total']+=1;
                }if($dtapl->kehadiran=="T"){
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['total']+=1;
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['justifikasi']['alasan']=$dtapl->alasan;
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['justifikasi']['tgl_justifikasi']=$dtapl->tgl_justifikasi;
                    $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['justifikasi']['ket_justifikasi']=$dtapl->ket_justifikasi;
                }
                $hadirapel = $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']['total'];
                if(count($hadirapel)<1){
                    $hadirapel = 0;
                }
                $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['hadir']['total'] = $hadirapel;
                $tidak_hadirapel = $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['total'];
                if(count($tidak_hadirapel)<1){
                    $tidak_hadirapel = 0;
                }
                $arrDataRekap[$dtapl->id_sdm][$tgl_kegiatan]['dt_apel']['tidak_hadir']['total'] = $tidak_hadirapel;
            }
            $arrDataRekapNew = array();
            foreach($arrDataRekap as $id_sdmz=>$dtsdmz){
                foreach($dtsdmz as $tglnya=>$dttglnya){
                    $arrDataRekapNew[$id_sdmz][$tglnya]['hari_kerja'] = $arrDataRekap[$id_sdmz][$tglnya]['hari_kerja'];
                    $telat = $arrDataRekap[$id_sdmz][$tglnya]['telat'];
                    if(count($telat)<1){
                        $telat = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['telat'] = $telat;

                    $pulang_cepat = $arrDataRekap[$id_sdmz][$tglnya]['pulang_cepat'];
                    if(count($pulang_cepat)<1){
                        $pulang_cepat = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['pulang_cepat'] = $pulang_cepat;

                    $absensekali = $arrDataRekap[$id_sdmz][$tglnya]['absensekali'];
                    if(count($absensekali)<1){
                        $absensekali = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['absensekali'] = $absensekali;

                    $tidakmasuk = $arrDataRekap[$id_sdmz][$tglnya]['tidakmasuk'];
                    if(count($tidakmasuk)<1){
                        $tidakmasuk = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['tidakmasuk'] = $tidakmasuk;

                    $absen = $arrDataRekap[$id_sdmz][$tglnya]['absen'];
                    if(count($absen)<1){
                        $absen = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['absen'] = $absen;

                    $dt_apel = $arrDataRekap[$id_sdmz][$tglnya]['dt_apel'];
                    // if(count($dt_apel)<1){
                    //     $dt_apel = 0;
                    // }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['dt_apel'] = $dt_apel;

                    $masuk = $arrDataRekap[$id_sdmz][$tglnya]['masuk'];
                    if(count($masuk)<1){
                        $masuk = 0;
                    }
                    $arrDataRekapNew[$id_sdmz][$tglnya]['masuk'] = $masuk;
                }
            }
            return $arrDataRekapNew;
        }
    }

    public static function pilihan_menggangu($id=null){
        $arrData = array('0'=> "Tidak mengganggu layanan",'1'=>"Mengganggu Layanan");
        $d = '<option value="">Pilih Kategori</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }

    public static function pilihan_rubrik($id = null){
        $arrData = array();$child=array();$child3=array();$child4=array();
        $rsData = MsRubrik::with(['nm_satuan'])->orderBy('urutan','asc')->get();
        foreach($rsData as $rs=>$r){
            if($r->level==3){
                $child4[$r->idparent][$r->id]['kode'] = $r->kode;
                $child4[$r->idparent][$r->id]['nama'] = $r->nama;
                $child4[$r->idparent][$r->id]['satuan'] = $r->nm_satuan->nama;
                $child4[$r->idparent][$r->id]['point'] = $r->poin;
            }
        }

        foreach($rsData as $rs=>$r){
            if($r->level==3){
                $child3[$r->idparent][$r->id]['kode'] = $r->kode;
                $child3[$r->idparent][$r->id]['nama'] = $r->nama;
                $child3[$r->idparent][$r->id]['satuan'] = $r->nm_satuan->nama;
                $child3[$r->idparent][$r->id]['point'] = $r->poin;
                $child3[$r->idparent][$r->id]['child'] = $child4[$r->id];
            }
        }

        foreach($rsData as $rs=>$r){
            if($r->level==2){
                $child[$r->idparent][$r->id]['kode'] = $r->kode;
                $child[$r->idparent][$r->id]['nama'] = $r->nama;
                $child[$r->idparent][$r->id]['satuan'] = $r->nm_satuan->nama;
                $child[$r->idparent][$r->id]['point'] = $r->poin;
                $child[$r->idparent][$r->id]['child'] = $child3[$r->id];
            }
        }

        foreach($rsData as $rs=>$r){
            if($r->level==1){
                $arrData[$r->id]['kode'] = $r->kode;
                $arrData[$r->id]['nama'] = $r->nama;
                $arrData[$r->id]['urutan'] = $r->urutan;
                $arrData[$r->id]['child'] = $child[$r->id];
            }
        }
        $d = '<option value="">Pilih Rubrik SKP</option>';
        foreach($arrData as $id_induk_rubrik=>$r){
            $name1 = $r['kode'].". ".$r['nama'];
            $d.= "<optgroup label=\"$name1\">";
            foreach($r['child'] as $id_rubrik=>$dt_rubrik){
                $name2 = $r['kode'].".".$dt_rubrik['kode']." ".$dt_rubrik['nama'];
                if(is_array($dt_rubrik['child'])){
                    $d.= "<optgroup label=\"&nbsp;&nbsp;&nbsp;&nbsp;$name2\">";
                        foreach($dt_rubrik['child'] as $id_rubrik3=>$dt_rubrik3){
                            $name3 = $r['kode'].".".$dt_rubrik['kode'].".".$dt_rubrik3['kode']." ".$dt_rubrik3['nama'];
                            if(is_array($dt_rubrik3['child'])){
                                $d.= "<optgroup label=\"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name3\">";
                                foreach($dt_rubrik3['child'] as $id_rubrik4=>$dt_rubrik4){
                                    $name4 = $r['kode'].".".$dt_rubrik['kode'].".".$dt_rubrik3['kode']." ".$dt_rubrik4['kode']." ".$dt_rubrik4['nama'];
                                    $d.= "<option value=\"$id_rubrik4\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$name4</option>";
                                }
                                $d.="</optgroup>";
                            }else{
                                $d.= "<option value=\"$id_rubrik3\">&nbsp;&nbsp;&nbsp;&nbsp;$name3</option>";
                            }
                        }
                    $d.="</optgroup>";
                }else{
                    $d.= "<option value=\"$id_rubrik\">&nbsp;&nbsp;&nbsp;&nbsp;$name2</option>";
                }
            }
            $d.="</optgroup>";
        }
        return $d;
    }

    public static function pilihan_sdm($id_sdm = null,$id_satker = null,$id_sdmnot = null,$id_sdm_atasan = null){
        $query = MsPegawai::where('deleted_at',null);
        if($id_satker){
            $query->where('id_satkernow',$id_satker);
        }
        if($id_sdmnot){
            $query->where('id_sdm','!=',$id_sdmnot);
        }
        if($id_sdm_atasan){
            $query->where('id_sdm_atasan',$id_sdm_atasan);
        }
        $rsData = $query->orderBy('nm_sdm','asc')->get();
        $d = '<option value="">Pilih Nama Pegawai</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_sdm == $id_sdm) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_sdm\" $sl>$r->nm_sdm</option>";
        }
        return $d;
    }
    public static function pilihan_mesin_finger($id=null){
        $rsData = MesinFinger::orderBy('nm_mesin','asc')->get();
        $d = '<option value="">Pilih Nama Mesin Finger</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->nm_mesin == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->nm_mesin\" $sl>$r->nm_mesin</option>";
        }
        return $d;
    }
    public static function arrhuruf(){
        $char = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
        $arrData = array();
        $no=1;
        foreach($char as $rs){
            $huruf = strtoupper($rs);
            $arrData[$no] = $huruf;
            $no++;
        }
        return $arrData;
    }
    public static function jabatan(){
        $rsData = MsJabatan::get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->id] = $r->tipejabatan;
        }
        return $arrData;
    }

    public static function pilihan_tipe_jabatan($id = null){
        $arrData = array('F'=>'Fungsional','S'=>"Struktural");
        $d = '<option value="">Pilih Tipe Jabatan</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }
    public static function arrTipeJabatan(){
        $arrData = array('F'=>'Fungsional','S'=>"Struktural");
        return $arrData;
    }
    public static function pilihan_bulan_skp($bulan){
        $rsData = MsPeriodeSkp::distinct('bulan')->get();
        $d = '<option value="">Pilih Bulan</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->bulan == $bulan) {
                $sl = 'selected';
            }
            $arrbulan = nm_bulan();
            $namabulan = $arrbulan[$r->bulan];
            $d .= "<option value=\"$r->bulan\" $sl>$namabulan</option>";
        }
        return $d;
    }
    public static function pilihan_tahun_skp($tahun){
        $rsData = MsPeriodeSkp::distinct('tahun')->get();
        $d = '<option value="">Pilih Tahun</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->tahun == $tahun) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->tahun\" $sl>$r->tahun</option>";
        }
        return $d;
    }
    public static function pilihan_jenis_kelamin($id = null){
        $arrData = array('L'=>"Laki - Laki",'P'=>"Perempuan");
        $d = '<option value="">Pilih Jenis Kelamin</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }

    public static function arrjenis_kelamin(){
        $arrData = array('L'=>"Laki - Laki",'P'=>"Perempuan",'99'=>"Tidak Diisi");
        return $arrData;
    }
    public static function pilihan_status_kawin($id = null){
        $arrData = array('0'=>"Belum Menikah",'1'=>"Menikah",'3'=>"Janda / Duda",'99'=>"Tidak Diisi");
        $d = '<option value="">Pilih Status Kawin</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($rs == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$rs\" $sl>$r</option>";
        }
        return $d;
    }
    public static function arrStatusKawin(){
        $arrData = array('0'=>"Belum Menikah",'1'=>"Menikah",'3'=>"Janda",'4'=>"Duda");
        return $arrData;
    }

    public static function pilihan_golongan($id = null){
        $rsData = MsGolongan::orderBy('kode_golongan','asc')->get();
        $d = '<option value="">Pilih Pangkat/Golongan</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_golongan == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_golongan\" $sl>$r->kode_golongan ( $r->nama_golongan )</option>";
        }
        return $d;
    }
    public static function arrstatusaktif(){
        $rsData = MsStatusAktif::get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->idstatusaktif] = $r->idstatusaktif;
        }
        return $arrData;
    }
    public static function pilihan_status_keaktifan($id = null){
        $arrData = MsStatusAktif::get();
        $d = '<option value="">Pilih Status</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id\" $sl>$r->namastatusaktif</option>";
        }
        return $d;
    }

    public static function arrjnssdm(){
        $rsData = MsJnsSdm::orderBy('nm_jns_sdm')->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->kode_lokal] = $r->id_jns_sdm;
        }
        return $arrData;
    }

    public static function arrAgama(){
        $rsData = MsAgama::orderBy('namaagama')->get();
        $arrData = array();
        foreach($rsData AS $rs=>$r){
            $arrData[$r->idagama] = $r->idagama;
        }
        return $arrData;
    }

    public static function pilihan_agama($id = null){
        $rsData = MsAgama::orderBy('namaagama')->get();
        $d = '<option value="">Pilih Agama</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id\" $sl>$r->namaagama</option>";
        }
        return $d;
    }

    public static function arrstatuskepegawaian(){
        $rsData = MsStatusKepegawaian::orderBy('namastatuspegawai')->get();
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->kode_lokal] = $r->id;
        }
        return $arrData;
    }

    public static function pilihan_status_kepegawaian($id = null){
        $rsData = MsStatusKepegawaian::orderBy('namastatuspegawai')->get();
        $d = '<option value="">Pilih Status Kepegawaian</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id\" $sl>$r->namastatuspegawai</option>";
        }
        return $d;
    }

    public static function pilihan_jns_sdm($id = null){
        $rsData = MsJnsSdm::orderBy('nm_jns_sdm')->get();

        $d = '<option value="">Pilih Jenis Sdm</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_jns_sdm == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_jns_sdm\" $sl>$r->nm_jns_sdm</option>";
        }
        return $d;
    }

    public static function pilihan_jabatan($id = null,$tipe = null){
        $rsData = MsJabatan::with(['ms_grade'])->where('deleted_at',null);
        if($tipe!=null){
            $rsData->where('tipejabatan',$tipe);
        }
        $arrData = $rsData->orderBy('namajabatan','asc')->get();
        $d = '<option value="">Pilih Jabatan</option>';
        //$tes = array();
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            //$nm_grade = $r->ms_grade->grade;
            $d .= "<option value=\"$r->id\" $sl>$r->namajabatan</option>";
            // $tes[$r->id]['namajabatan'] = $r->namajabatan;
            // $tes[$r->id]['grade'] = $nm_grade;
        }
        return $d;
    }

    public static function strToDate($str, $time = false)
    {
        $str = trim($str);
        $str = str_replace(',', ' ', $str);
        for ($i = 0; $i <= 100; ++$i) {
            $str = str_replace('  ', ' ', $str);
        }
        $str = trim($str);
        if (strpos($str, '/')) {
            $x = explode('/', $str);
        }
        if (strpos($str, '-')) {
            $x = explode('-', $str);
        }
        if (strpos($str, ' ')) {
            $x = explode(' ', $str);
        }
        $t1 = $x[0];
        $t2 = $x[1];
        $t3 = $x[2];
        if (strlen($t1) == 4 && (int) $t1 > 0) {
            $tahun = $t1;
            $tanggal = $t3;
        }
        if (strlen($t3) == 4 && (int) $t3 > 0) {
            $tahun = $t3;
            $tanggal = $t1;
        }
        if (strlen($t2) > 2) {
            $bulan = StrToBulan($t2);
        } else {
            $bulan = $t2;
        }
        if ((int) $tanggal < 10) {
            $tanggal = '0'.(int) $tanggal;
        }
        if ((int) $bulan < 10) {
            $bulan = '0'.(int) $bulan;
        }
        $date = $tahun.'-'.$bulan.'-'.$tanggal;
        if ($time == false) {
            return $date;
        } else {
            return strtotime($date);
        }
    }

    public static function inttodate($int){
        $convert = date("Y-m-d",($int  - 25569) * 86400);
        return $convert;
    }

    public static function pilihan_satuan_rubrik($id = null){
        $rsData = MsSatuan::get();
        $d = '<option value="">Pilih Satuan</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id\" $sl>$r->nama</option>";
        }
        return $d;
    }

    public static function pilihan_tahun_presensi($thn){
        $rsData = RiwayatPresensi::selectRaw(" distinct SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 0, 5) as tahun ")->get();
        $d = '<option value="">Pilih Tahun</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->tahun == $thn) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->tahun\" $sl>$r->tahun</option>";
        }
        return $d;
    }

    public static function jam_kerja_unit($id_unit){
        // jika poliklinik khusus
        if($id_unit=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
            $rsData = MsAbsen::where('id_khusus',"4e1ebf30-02fd-4948-87bb-c2992a822682")->get();
        }else{
            $rsData = MsAbsen::where('id_khusus',"347b23a9-8919-43ec-9b2d-a0c4b810b61d")->get();
        }
        $arrData = array();
        foreach($rsData as $rs=>$r){
            $arrData[$r->hari_biasa]['jam_masuk'] = $r->jam_masuk;
            $arrData[$r->hari_biasa]['jam_pulang'] = $r->jam_keluar;
            $arrData[$r->hari_biasa]['masuk_telat'] = $r->masuk_telat;
            $arrData[$r->hari_biasa]['pulang_telat'] = $r->pulang_telat;
            $arrData[$r->hari_biasa]['lama_kerja'] = $r->lama_kerja;
        }
        return $arrData;
    }

    public static function pilihan_bulan_presensi($bln){
        $rsData = RiwayatPresensi::selectRaw(" distinct SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 6, 2) as bln ")->orderBy('bln','asc')->get();
        $d = '<option value="">Pilih Bulan</option>';
        $nm_bulan = nm_bulan();
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->bln == $bln) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->bln\" $sl>".$nm_bulan[$r->bln]."</option>";
        }
        return $d;
    }


    public static function pilihan_satker($id_sms=null){
        $rsData = SatuanUnitKerja::orderBy('nm_lemb','asc')->get();
        $d = '<option value="">Pilih Unit Kerja</option>';
        foreach ($rsData as $rs => $r) {
            $sl = '';
            if ($r->id_sms == $id_sms) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id_sms\" $sl>$r->nm_lemb</option>";
        }
        return $d;
    }

    public static function grap_poltek($sql){
        $url = 'https://akademik.poltekbangsby.ac.id/opikintan';
        $data = ['sql' => $sql];
        $x = kirim_data($url, 'post', $data);
        $tampil = json_decode($x['isi']);
        return $tampil;
    }

    public static function enkripsql($sql){
        $data = tajip($sql);
        return $data;
    }
}
