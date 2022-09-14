<?php

namespace App\Helper;

use Session;
use App\Models\MsStatusAktif;
use App\Models\TrStatusKepegawaian;
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

error_reporting(0);
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
function harikerja($tgl_awal,$tgl_akhir){
    $bulan_awal = date('m',strtotime($tgl_awal));
    $bulan_akhir = date('m',strtotime($tgl_akhir));
    $bulan_awal = sprintf("%0d", $bulan_awal);
    $thn = date('Y',strtotime($tgl_awal));
    $data_bulan = array();
    $bts_tgl_awal = date('d',strtotime($tgl_awal));
    $bts_tgl_akhir = date('d',strtotime($tgl_akhir));
    $arrAwal[$bulan_awal] = sprintf("%0d",$bts_tgl_awal);
    $arrAkhir[$bulan_akhir] = sprintf("%0d",$bts_tgl_akhir);
    for($x=$bulan_awal;$x<=$bulan_akhir;$x++){
        $tanggal = cal_days_in_month(CAL_GREGORIAN, $x, $thn);
        for ($i=1; $i < $tanggal+1; $i++) {
                $gbng = $thn."-".sprintf("%02d", $x)."-".sprintf("%02d", $i);
                $tgl = Fungsi::formatDate($gbng);
                $hari = explode(',',$tgl);
                if($hari[0]!='Sabtu' && $hari[0]!='Minggu'){
                    $buwulan = $x;
                    $data_bulan[$buwulan][$i] = $i;
                }
            
        }
    }
    return $data_bulan;
}
class Fungsi
{
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
        $rsData = MsAbsen::get();
        $d = '<option value="">Pilih Jam Kerja</option>';
        foreach ($rsData as $rs => $r) {
            
            $d .= "<option value=\"$r->id\" $sl>Jam : ".$r->jam_masuk. "-".$r->jam_keluar." </option>";
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
        $rsData = MsAbsen::where('id',$id)->first();
        return $rsData;
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

    public static function pilihan_sdm($id_sdm = null,$id_satker = null,$id_sdmnot = null){
        $query = MsPegawai::where('deleted_at',null);
        if($id_satker){
            $query->where('id_satkernow',$id_satker);
        }
        if($id_sdmnot){
            $query->where('id_sdm','!=',$id_sdmnot);
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
        $arrData = array('L'=>"Laki - Laki",'P'=>"Perempuan");
        return $arrData;
    }
    public static function pilihan_status_kawin($id = null){
        $arrData = array('0'=>"Belum Menikah",'1'=>"Menikah",'3'=>"Janda / Duda");
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
        $rsData = MsJabatan::where('deleted_at',null);
        if($tipe!=null){
            $rsData->where('tipejabatan',$tipe);
        }
        $arrData = $rsData->orderBy('namajabatan','asc')->get();
        $d = '<option value="">Pilih Jabatan</option>';
        foreach ($arrData as $rs => $r) {
            $sl = '';
            if ($r->id == $id) {
                $sl = 'selected';
            }
            $d .= "<option value=\"$r->id\" $sl>$r->namajabatan</option>";
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
            $rsData = MsAbsen::where('id',"627b6d0d-2ccc-4237-b944-46ac745f5bec")->first();
        }else{
            $rsData = MsAbsen::where('id',"d3da5be7-24f3-44e1-af4b-b83ea73b2be7")->first();
        }
        return $rsData;

    }

    public static function pilihan_bulan_presensi($bln){
        $rsData = RiwayatPresensi::selectRaw(" distinct SUBSTRING(CAST(tanggal_absen AS VARCHAR(19)), 6, 2) as bln ")->get();
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