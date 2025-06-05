<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reposettingapp;
use App\Repositories\Repouser;
use App\Repositories\Repomspegawai;
use App\Models\Iclocktransaction;
use App\Models\User;
use App\Repositories\Repotrloglogin;
use App\Repositories\Reporiwayatpresensi;
use App\Repositories\Repoclocktransaction;
use Session;
use Fungsi;
use Crypt;
use DB;

class LoginController extends Controller
{
    public function __construct(
        Request $request,
        Reposettingapp $reposettingapp,
        Repouser $repouser,
        Repomspegawai $repomspegawai,
        Repotrloglogin $repotrloglogin,
        Reporiwayatpresensi $reporiwayatpresensi,
        Repoclocktransaction $repoclocktransaction
    ){
        $this->request = $request;
        $this->reposettingapp = $reposettingapp;
        $this->repouser = $repouser;
        $this->repomspegawai = $repomspegawai;
        $this->repotrloglogin = $repotrloglogin;
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

    public function decrypt($string, $key = 'faiqmaharan')
    {
        $result = '';
        if (strlen($key) > 0) {
            $string = base64_decode($string);
            for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
            }
        }
        return $result;
    }

    public function index(Request $request)
    {
	//return response()->json(User::where("email","eremun@poltekbangsby.ac.id")->first());
	//return response()->json(User::first());
        $rsData = $this->reposettingapp->findId("","cb6020d6-e8a7-4240-ab2c-dffd30d31892","id_setting");
        $request->session()->put('nama_aplikasi',$rsData->nama_aplikasi);
        $data['rsData'] = $rsData;
        $this->sync_semi_auto();
        $sql= "UPDATE riwayat_finger r
        SET deleted_at = NOW()
        FROM tr_justifikasi t
        WHERE t.justifikasi_atasan = '2'
        AND t.id_sdm = r.id_sdm
        AND t.tanggal_absen = r.tanggal_absen
        AND sn = 'justifikasi'
        AND (jam_absen::time = jam_masuk OR jam_absen::time = jam_pulang)
        AND r.deleted_at IS NULL";
        DB::statement($sql);

        if ($_COOKIE['sesi_sso']) {
            $cobasesi = json_decode($this->decrypt($_COOKIE['sesi_sso'], 'alimsumarno'), true);
            if (is_array($cobasesi)) {
                $dt = User::where('email',$cobasesi['email'])->first();
                return $this->ceklogin($dt->username,$dt->hidden_password);
            }
        }
        
        return view('login',$data);
    }

    public function ceklogin($username,$password){
        if(auth()->attempt(array('username' => $username, 'password' => $password))){
            $dtUser = auth()->user()->load(['roleuser']);
            // catat log
            $getip = Fungsi::get_client_ip();
            $getbrowser = Fungsi::get_client_browser();
            

            $reqlog['tgl_login'] = date('Y-m-d H:i:s');
            $reqlog['ip'] = $getip;
            $reqlog['browser'] = $getbrowser;
            $reqlog['id_user'] = $dtUser->id_user;
            $reqlog['username'] = $dtUser->username;
            $reqlog['nama_user'] = $dtUser->nama_user;
            $this->repotrloglogin->store($reqlog);

            $this->request->session()->put('id_pengguna',$dtUser->id_user);
            $this->request->session()->put('username',$dtUser->username);
            $this->request->session()->put('nama_pengguna',$dtUser->nama_user);
            $this->request->session()->put('userlevel',$dtUser->roleuser->nama_role);
            $this->request->session()->put('level',$dtUser->roleuser->kode_role);
            
            $notification = [
                'message' => 'Selamat Datang '.$dtUser->nama_user,
                'alert-type' => 'success',
            ];
            if (auth()->user()->ganti_pass == '1') {
                //auth()->user()->update(['ganti_pass'=>null]);
                return redirect()->route('ubahpassword')->with($notification);
            }
            if($dtUser->roleuser->kode_role=="P"){
                $this->request->session()->put('id_sdm',$dtUser->id_sdm);
                $this->request->session()->put('id_sdm_pengguna',$dtUser->id_sdm);
                $id_sdm = $dtUser->id_sdm;
                $cek_dt_bawahan = $this->repomspegawai->getWhereRaw(['nm_satker','nm_golongan','nm_jns_sdm','stat_kepegawaian','stat_aktif']," id_stat_aktif = '1' and (id_sdm_atasan = '$id_sdm' or id_sdm_pendamping = '$id_sdm') ","nm_sdm");
                if(count($cek_dt_bawahan)>0){
                    $this->request->session()->put('atasan_penilai',1);
                    $this->request->session()->put('id_sdm_atasan',$id_sdm);
                }
                return redirect()->route('beranda')->with($notification);
            }else{
                return redirect()->route('home')->with($notification);
            }
        }else{
            $notification = [
                'message' => 'Username dan Password Salah',
                'alert-type' => 'error',
            ];
            return redirect()->route('/')->with($notification);
        }
    }

    public function ubahpassword(){
        $id = Session::get('id_pengguna');
        $data['rsData'] = $this->repouser->findId("",$id,"id_user");
        return view('content.change_password',$data);
    }

    public function simpan_ubah_password(Request $request){
        $req = $request->except('_token');
        if($req['password']!=null){
            $req['hidden_password'] = $req['password'];
            $req['password'] = bcrypt($req['password']);
        }
        $id = Session::get('id_pengguna');
        $where['id_user'] = $id;
        $this->repouser->update($where,$req);
        auth()->user()->update(['ganti_pass' => null]);
        $notification = [
            'message' => 'Data berhasil disimpan, silahkan login ulang.',
            'alert-type' => 'error',
        ];
        return redirect()->route('logout')->with($notification);
    }

    public function proses_login(Request $request){
        $req = $request->except('_token');
        return $this->ceklogin($req['username'],$req['password']);
    }

    public function loginas($id){
        $id = Crypt::decrypt($id);
        $cekuser = $this->repouser->findId("",$id,"id_user");
        if($cekuser->is_aktif!="1"){
            $notification = [
                'message' => 'Pengguna sudah tidak aktif',
                'alert-type' => 'error',
            ];
            return redirect()->route('setting.manajemen-user.index')->with($notification);
        }else{
            return $this->ceklogin($cekuser->username,$cekuser->hidden_password);
        }

    }

    public function logout()
    {
        $old = Session::get('old');
        Session::flush();
        return redirect()->intended('/');
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
