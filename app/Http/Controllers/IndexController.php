<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspegawai;
use App\Repositories\Repomsperiodeskp;
use App\Repositories\Reposettingramadhan;
use Session;
use Fungsi;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repoclocktransaction;
use App\Models\Iclocktransaction;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __construct(
        Request $request,
        Repomspegawai $repomspegawai,
        Repomsperiodeskp $repomsperiodeskp,
        Reposettingramadhan $reposettingramadhan,
        Reporiwayatpresensi $reporiwayatpresensi,
        Repoclocktransaction $repoclocktransaction
    ){
        $this->request = $request;
        $this->repomspegawai = $repomspegawai;
        $this->repomsperiodeskp = $repomsperiodeskp;
        $this->reposettingramadhan = $reposettingramadhan;
        $this->reporiwayatpresensi = $reporiwayatpresensi;
        $this->repoclocktransaction = $repoclocktransaction;
    }

    public function sync_semi_auto(){
        $rsPeg = $this->repomspegawai->get();
        $arrNip = array();$arrIdSdm = array();
        foreach($rsPeg as $rs=>$r){
            $arrNip[$r->nip] = $r->nip;
            $arrIdSdm[$r->nip] = $r->id_sdm;
        }
        $tgl_saiki = date('Y-m-d');
        $sync = $this->repoclocktransaction->getsyncabsen($tgl_saiki,$arrNip);
        
        foreach($sync as $empcode => $dt_tgl){
            $id_sdm = $arrIdSdm[$empcode];
            if($id_sdm){
                foreach($dt_tgl as $tgl_absen => $dttglabsen){
                    foreach($dttglabsen as $jam_absen => $dt_jam_absen){
                        $id_finger = $dt_jam_absen['id'];
                        unset($dt_jam_absen['emp_code']);
                        unset($dt_jam_absen['id']);
                        $dt_jam_absen['tanggal_scan'] = date('Y-m-d H:i:s');
                        $dt_jam_absen['id_sdm'] = $id_sdm;
                        $this->reporiwayatpresensi->store($dt_jam_absen);
                        $upfinger['csf'] = "1";
                        $where['id'] = $id_finger;
                        $update_finger = Iclocktransaction::where('id',$id_finger)->update(['csf'=>1]);
                    }
                }
            }
        }
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
            // develop by masgus - pass jumlah justifikasi kat.4 per bulan ke view
            $data['justifikasiKat4Count'] = Fungsi::countAllJustifikasiKat4(Session::get('id_sdm'), $tgl_awal);

            // Data ranking kehadiran hari ini untuk ucapan/penghargaan
            $today = date('Y-m-d');
            $rankingHariIni = DB::table('neosimpeg.riwayat_finger as rf')
                ->join('neosimpeg.ms_pegawai as p', 'rf.id_sdm', '=', 'p.id_sdm')
                ->where('rf.tanggal_absen', $today)
                ->where('p.id_stat_aktif', '1')
                ->whereNull('p.deleted_at')
                ->select('rf.id_sdm', 'p.nm_sdm', DB::raw("MIN(rf.jam_absen) as jam_masuk"))
                ->groupBy('rf.id_sdm', 'p.nm_sdm')
                ->orderBy('jam_masuk', 'asc')
                ->get();

            $data['ranking_hari_ini'] = null;
            $data['juara_top3'] = [];
            foreach ($rankingHariIni as $idx => $rk) {
                if ($idx < 3) {
                    $data['juara_top3'][] = [
                        'nama' => $rk->nm_sdm,
                        'jam_masuk' => substr($rk->jam_masuk, 0, 5),
                        'ranking' => $idx + 1,
                    ];
                }
                if ($rk->id_sdm == $id_sdm) {
                    $data['ranking_hari_ini'] = $idx + 1;
                    $data['jam_masuk_hari_ini'] = substr($rk->jam_masuk, 0, 5);
                }
            }
            $data['total_hadir_hari_ini'] = count($rankingHariIni);

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

            $this->sync_semi_auto();
            
            return view('content.home',$data);
        }
    }


    public function live_kehadiran()
    {
        $today = date('Y-m-d');
        $jam_masuk_batas = '08:15'; // toleransi 15 menit dari jam 08:00

        // Total pegawai aktif
        $total_pegawai = DB::table('neosimpeg.ms_pegawai')
            ->where('id_stat_aktif', '1')
            ->whereNull('deleted_at')
            ->count();

        // Data kehadiran hari ini - ambil jam pertama (masuk) dan terakhir (pulang) per pegawai
        $kehadiran = DB::table('neosimpeg.riwayat_finger as rf')
            ->join('neosimpeg.ms_pegawai as p', 'rf.id_sdm', '=', 'p.id_sdm')
            ->leftJoin('neosimpeg.ms_satker as s', 'p.id_satkernow', '=', 's.id_sms')
            ->where('rf.tanggal_absen', $today)
            ->where('p.id_stat_aktif', '1')
            ->whereNull('p.deleted_at')
            ->select(
                'rf.id_sdm',
                'p.nm_sdm',
                'p.nip',
                's.nm_lemb as unit_kerja',
                DB::raw("MIN(rf.jam_absen) as jam_masuk"),
                DB::raw("MAX(rf.jam_absen) as jam_pulang"),
                DB::raw("COUNT(rf.id_finger) as total_scan")
            )
            ->groupBy('rf.id_sdm', 'p.nm_sdm', 'p.nip', 's.nm_lemb')
            ->orderBy('jam_masuk', 'asc')
            ->get();

        $hadir = 0;
        $terlambat = 0;
        $tepat_waktu = 0;
        $sudah_pulang = 0;
        $list_hadir = [];
        $list_terlambat = [];

        foreach ($kehadiran as $k) {
            $hadir++;
            $is_terlambat = ($k->jam_masuk > $jam_masuk_batas);
            if ($is_terlambat) {
                $terlambat++;
            } else {
                $tepat_waktu++;
            }
            if ($k->total_scan > 1 && $k->jam_masuk != $k->jam_pulang) {
                $sudah_pulang++;
            }

            $ranking = $hadir; // karena $hadir sudah di-increment di atas
            $item = [
                'nama' => $k->nm_sdm,
                'nip' => $k->nip,
                'unit' => $k->unit_kerja,
                'jam_masuk' => substr($k->jam_masuk, 0, 5),
                'jam_pulang' => ($k->total_scan > 1 && $k->jam_masuk != $k->jam_pulang) ? substr($k->jam_pulang, 0, 5) : null,
                'terlambat' => $is_terlambat,
                'ranking' => $ranking,
            ];
            $list_hadir[] = $item;
            if ($is_terlambat) {
                $list_terlambat[] = $item;
            }
        }

        $belum_hadir = $total_pegawai - $hadir;
        $persen_hadir = $total_pegawai > 0 ? round(($hadir / $total_pegawai) * 100, 1) : 0;

        // Top 3 datang paling awal
        $juara = array_slice($list_hadir, 0, 3);

        return response()->json([
            'tanggal' => $today,
            'waktu_update' => date('H:i:s'),
            'total_pegawai' => $total_pegawai,
            'hadir' => $hadir,
            'belum_hadir' => $belum_hadir,
            'terlambat' => $terlambat,
            'tepat_waktu' => $tepat_waktu,
            'sudah_pulang' => $sudah_pulang,
            'persen_hadir' => $persen_hadir,
            'juara' => $juara,
            'list_hadir' => $list_hadir,
            'list_terlambat' => $list_terlambat,
        ]);
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
