<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use App\Repositories\Repomsperiodeskp;
use App\Repositories\Reposettingramadhan;
use Session;
use Fungsi;

class IndexController extends Controller
{
    public function __construct(
        Request $request,
        Repomspegawai $repomspegawai,
        Repomsperiodeskp $repomsperiodeskp,
        Reposettingramadhan $reposettingramadhan
    ){
        $this->request = $request;
        $this->repomspegawai = $repomspegawai;
        $this->repomsperiodeskp = $repomsperiodeskp;
        $this->reposettingramadhan = $reposettingramadhan;
    }

    public function index()
    {
        if(Session::get('level')=="P"){
            $tahun = date('Y');
            $data['ramadhan'] = Fungsi::ramadhan($tahun);
            $id_sdm = Session::get('id_sdm');
            $arrIdSdm[$id_sdm] = $id_sdm;
            $data['info_pegawai'] = $this->repomspegawai->findId('',Session::get('id_sdm'),'id_sdm');
            $data['tanggal_terakhir'] = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            $tgl_awal = date('Y')."-".date('m')."-"."01";
            $tgl_akhir = date('Y')."-".date('m')."-".$data['tanggal_terakhir'];
            $getajuan_justifikasi = Fungsi::getajuan_justifikasi($id_sdm,$tgl_awal,$tgl_akhir);
            $data['getajuan_justifikasi'] = $getajuan_justifikasi;

            $getajuan_justifikasiall = Fungsi::getajuan_justifikasiall($tgl_awal,$tgl_akhir);
            $data['getajuan_justifikasiall'] = $getajuan_justifikasiall;

            $req['id_jam_kerja'] = "4e1ebf30-02fd-4948-87bb-c2992a822682";
            //dd($data['ramadhan']);
            $jam_kerja = Fungsi::jam_kerja($req['id_jam_kerja']);
            $jam_kerja_ramadhan = Fungsi::jam_kerja("347b23a9-8919-43ec-9b2d-a0c4b810b61d");
            $durasibekerja = Fungsi::durasibekerja($req['id_jam_kerja']);
            $durasibekerja_ramadhan = Fungsi::durasibekerja("347b23a9-8919-43ec-9b2d-a0c4b810b61d");
            if($data['info_pegawai']->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                $data['getRekapDataAbsen'] = Fungsi::getRekapDataAbsenPoli($tgl_awal,$tgl_akhir,$arrIdSdm,1);
            }else{
                $data['getRekapDataAbsen'] = Fungsi::get_rekap_data_kehadiran($jam_kerja,$tgl_awal,$tgl_akhir,$arrIdSdm,1);
            }
            $data['data_bulan'] = Fungsi::hari_dalam_satu_bulan($tgl_awal,$tgl_akhir,1);
            $data['jamkerjashift'] = Fungsi::jamkerjashift();
            $data['getDataAbsen'] = Fungsi::gettanggalabsenkehadiran($arrIdSdm,$tgl_awal,$tgl_akhir);

            $data['dt_hari_libur'] = Fungsi::jmlh_hari_libur($tgl_awal,$tgl_akhir);

            $data['jam_kerja'] = $jam_kerja;
            $data['jam_kerja_ramadhan'] = $jam_kerja_ramadhan;

            $data['id_sdm'] = $id_sdm;
            $jam_kerja_text = "";$durasi_kerja_text = "";$jam_kerja_textramadhan = "";$durasi_kerja_textramadhan = "";
            $kategoriwaktuabsen = Fungsi::kategoriwaktuabsen();
            foreach($jam_kerja as $id_hr_kerja=>$dt_hr_kerja){
                $jam_kerja_text .= $kategoriwaktuabsen[$id_hr_kerja]." ( ".$dt_hr_kerja['jam_masuk']." - ".$dt_hr_kerja['jam_pulang']." ), ";
            }
            foreach($durasibekerja as $idhrkerja=>$dthrkerja){
                $durasi_kerja_text .= $kategoriwaktuabsen[$idhrkerja]." ( ".$dthrkerja['lama_kerja']." Jam ), ";
            }

            foreach($jam_kerja_ramadhan as $id_hr_kerjaramadhan=>$dt_hr_kerjaramadhan){
                $jam_kerja_textramadhan .= $kategoriwaktuabsen[$id_hr_kerjaramadhan]." ( ".$dt_hr_kerjaramadhan['jam_masuk']." - ".$dt_hr_kerjaramadhan['jam_pulang']." ), ";
            }
            foreach($durasibekerja_ramadhan as $idhrkerjaramadhan=>$dthrkerjaramadhan){
                $durasi_kerja_textramadhan .= $kategoriwaktuabsen[$idhrkerjaramadhan]." ( ".$dthrkerjaramadhan['lama_kerja']." Jam ), ";
            }

            $data['durasibekerja'] = $durasibekerja;
            $data['jam_kerja_text'] = trim($jam_kerja_text, ", \t\n");
            $data['durasi_kerja_text'] = trim($durasi_kerja_text, ", \t\n");

            $data['jam_kerja_textramadhan'] = trim($jam_kerja_textramadhan, ", \t\n");
            $data['durasi_kerja_textramadhan'] = trim($durasi_kerja_textramadhan, ", \t\n");

            $data['periodeaktif'] = $this->repomsperiodeskp->findWhereRaw("","status = '1'");
            $data['arrBulanPanjang'] = Fungsi::nm_bulan();

            return view('content.hal_pegawai.home',$data);
        }else{
            $jns_kelamin = Fungsi::arrjenis_kelamin();
            $rsData = $this->repomspegawai->getdata(['nm_golongan','nm_pendidikan'],1);
            foreach($rsData as $rs=>$r){
                $jk = $jns_kelamin[$r->jk];
                $data['arrData'][$jk][$r->nm_golongan->kode_golongan][$r->id_sdm] = $r->id_sdm;
                $nm_golongan = $r->nm_golongan->nama_golongan." ( ".$r->nm_golongan->kode_golongan." ) ";
                $data['jm_by_golongan'][$r->nm_golongan->kode_golongan]['nm_golongan'] = $nm_golongan;
                $data['jm_by_golongan'][$r->nm_golongan->kode_golongan]['dt_golongan'][$jk][$r->id_sdm] = $r->id_sdm;
                $data['nm_golongan'][$r->nm_golongan->kode_golongan] = $r->nm_golongan->kode_golongan;
                $data['dtjmpegawaijk'][$jk][$r->id_sdm] = $r->id_sdm;
                $data['jm_pergolongan'][$r->nm_golongan->kode_golongan]+=1;
                if($arrPendidikan[$r->id_pendidikan_terakhir]){
                    $data['arrPendidikan'][$arrPendidikan[$r->id_pendidikan_terakhir]] = $arrPendidikan[$r->id_pendidikan_terakhir];
                }
                $data['arrpendidikan'][$r->nm_pendidikan->urutan][$r->nm_pendidikan->namapendidikan] = $r->nm_pendidikan->namapendidikan;
                $data['jm_by_pendidikan'][$jk][$r->nm_pendidikan->namapendidikan][$r->id_sdm] = $r->id_sdm;
                $data['jm_perpendidikan'][$r->nm_pendidikan->namapendidikan]+=1;
            }
            ksort($data['jm_by_pendidikan']);
            return view('content.home',$data);
        }
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
