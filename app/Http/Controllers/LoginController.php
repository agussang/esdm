<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reposettingapp;
use App\Repositories\Repouser;
use App\Repositories\Repomspegawai;
use App\Repositories\Repotrloglogin;
use Session;
use Fungsi;
use Crypt;

class LoginController extends Controller
{
    public function __construct(
        Request $request,
        Reposettingapp $reposettingapp,
        Repouser $repouser,
        Repomspegawai $repomspegawai,
        Repotrloglogin $repotrloglogin
    ){
        $this->request = $request;
        $this->reposettingapp = $reposettingapp;
        $this->repouser = $repouser;
        $this->repomspegawai = $repomspegawai;
        $this->repotrloglogin = $repotrloglogin;
    }

    public function index(Request $request)
    {
        $rsData = $this->reposettingapp->findId("","cb6020d6-e8a7-4240-ab2c-dffd30d31892","id_setting");
        $request->session()->put('nama_aplikasi',$rsData->nama_aplikasi);
        $data['rsData'] = $rsData;
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
            if($dtUser->roleuser->kode_role=="P"){
                $this->request->session()->put('id_sdm',$dtUser->id_sdm);
                $this->request->session()->put('id_sdm_pengguna',$dtUser->id_sdm);
                $id_sdm = Session::get('id_sdm');
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
