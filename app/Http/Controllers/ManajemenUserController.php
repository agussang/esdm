<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repouser;
use App\Repositories\Repomspegawai;
use Crypt;
use Fungsi;
use Session;
error_reporting(0);

class ManajemenUserController extends Controller
{
    public function __construct(
        Repouser $repouser,
        Repomspegawai $repomspegawai
    ){
        $this->repouser = $repouser;
        $this->repomspegawai = $repomspegawai;
    }

    public function index()
    {
        $text = Session::get('text_user');
        $id_role = Session::get('id_role');
        $rsData =  $this->repouser->paginate(['roleuser'],strtolower($text),$id_role);
        $paging = $rsData->links();
        $totalRecord = $rsData->total();
        $data['pilihan_role'] = Fungsi::pilihan_role($id_role);
        $data['rsData'] = $rsData;
        $data['paging'] = $paging;
        $data['totalRecord'] = $totalRecord;
        return view('content.setting.manajemen_user.index',$data);
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
        return redirect()->route('setting.manajemen-user.index');
    }

    public function create()
    {
        $data['pilihan_role'] = Fungsi::pilihan_role();
        return view('content.setting.manajemen_user.tambah',$data);
    }

    public function reindex(){
        $rsData = $this->repomspegawai->get();
        foreach($rsData as $rs=>$r){
            if($r->nip){
                $req['username'] = $r->nip;
                $req['password'] = bcrypt($r->nip);
                $req['email'] = $r->email;
                $req['id_role'] = "263bfe8a-ed05-45b9-a41d-b0c278022992";
                $req['is_aktif'] = "1";
                $req['nama_user'] = $r->nm_sdm;
                $req['hidden_password'] = $r->nip;
                $req['id_sdm'] = $r->id_sdm;
                $req['password_change'] = 1;
                $cek = $this->repouser->findId("",$r->nip,"username");
                if($cek==null){
                    $this->repouser->store($req);
                }
            }
        }
        $notification = [
            'message' => 'Berhasil, Data pengguna baru simpeg berhasil ditambahkan.',
            'alert-type' => 'success',
        ];
        return redirect()->route('setting.manajemen-user.index')->with($notification);
    }

    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cekUser = $this->repouser->findWhereRaw("","( trim(lower(nama_user)) = '$req[nama_user]' or trim(lower(username))='$req[username]' )");
        if($cekUser){
            $notification = [
                'message' => 'Gagal, Data pengguna yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
        return redirect()->route('setting.manajemen-user.tambah')->with($notification);
        }else{
            $req['hidden_password'] = $req['password'];
            $req['password'] = bcrypt($req['password']);
            $req['is_aktif'] = 1;
            $this->repouser->store($req);
            $notification = [
                'message' => 'Berhasil, Data pengguna baru simpeg berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('setting.manajemen-user.index')->with($notification);
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $data['rsData'] = $this->repouser->findId("",$id,"id_user");
        $data['pilihan_role'] = Fungsi::pilihan_role($data['rsData']->id_role);
        return view('content.setting.manajemen_user.edit',$data);
    }

    public function update(Request $request)
    {
        $req = $request->except('_token');
        $cekUser = $this->repouser->findWhereRaw("","( trim(lower(nama_user)) = '$req[nama_user]' or trim(lower(username))='$req[username]' ) and id_user <> '$req[id_user]' ");
        if($cekUser){
            $notification = [
                'message' => 'Gagal, Data pengguna yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->intended('setting/manajemen-user/edit/'.Crypt::encrypt($req['id_user']))->with($notification);
        }else{
            if($req['password']!=null){
                $req['hidden_password'] = $req['password'];
                $req['password'] = bcrypt($req['password']);
            }
            $statment = $req['statment'];
            unset($req['statment']);
            if($statment==1){
                if($req['is_aktif']=="true"){
                    $req['is_aktif'] = 1;
                }else{
                    $req['is_aktif'] = 0;
                }
            }

            $where['id_user'] = $req['id_user'];
            unset($req['id_user']);
            if($statment==1){
                $this->repouser->update($where,$req);
                echo '<script type="text/javascript">toastr.success("Status keaktifan pengguna berhasil diubah.")</script>';
                echo "<script>
                setTimeout(function () {
                location.reload();
                }, 2000);
                </script>";
            }else{
                $this->repouser->update($where,$req);
                $notification = [
                    'message' => 'Berhasil, Data pengguna simpeg berhasil diupdate.',
                    'alert-type' => 'success',
                ];
                return redirect()->route('setting.manajemen-user.index')->with($notification);
            }
        }
    }


    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $this->repouser->destroy($id,"id_user");
        $notification = [
            'message' => 'Berhasil, Data pengguna simpeg berhasil dihapus.',
            'alert-type' => 'success',
        ];
        return redirect()->route('setting.manajemen-user.index')->with($notification);
    }
}
