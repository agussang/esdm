<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Reposettingapp;
use Crypt;
use Fungsi;
use Session;
error_reporting(0);

class SettingAppController extends Controller
{
    public function __construct(
        Reposettingapp $reposettingapp  
    ){
        $this->reposettingapp = $reposettingapp;
    }

    public function index()
    {
        $data['rsData'] = $this->reposettingapp->findId("","cb6020d6-e8a7-4240-ab2c-dffd30d31892","id_setting");
        return view('content.setting.app.index',$data);
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


    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id = $req['id_setting'];
        unset($req['id_setting']);
        $where['id_setting'] = $id;
        $save = $this->reposettingapp->update($where,$req);
        $notification = [
            'message' => 'Berhasil, Setting App berhasil diupdate.',
            'alert-type' => 'success',
        ];
        return redirect()->route('setting.app.index')->with($notification);
    }


    public function destroy($id)
    {
        //
    }
}
