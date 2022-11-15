<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrloglogin;
use Session;
use Fungsi;
use Crypt;

class TrLogloginController extends Controller
{
    public function __construct(
        Request $request,
        Repotrloglogin $repotrloglogin
    ){
        $this->request = $request;
        $this->repotrloglogin = $repotrloglogin;
    }

    public function index()
    {
        $tgl1 = Session::get('tgl1');
        if($tgl1==null){
            $tgl1 = date('Y-m-d');
        }
        $tgl2 = Session::get('tgl2');
        if($tgl2==null){
            $tgl2 = date('Y-m-d');
        }
        $data['rsData'] = $this->repotrloglogin->get("",$tgl1,$tgl2);
        $data['tgl1'] = date('m/d/Y',strtotime($tgl1));
        $data['tgl2'] = date('m/d/Y',strtotime($tgl2));
        $arrData = array();
        foreach($data['rsData'] as $rs=>$r){
            $arrData[$r->browser]['jmlh']+=1;
        }
        $data['arrData'] = $arrData;
        return view('content.log.index',$data);

    }

    public function cari(Request $request){
        $req = $request->except('_token');
        $date = str_replace(' ','',$req['daterange']);
        $date = explode('-',$date);
        $tgl1 = date('Y-m-d',strtotime($date[0]));
        $tgl2 = date('Y-m-d',strtotime($date[1]));
        $request->session()->put('tgl1',$tgl1);
        $request->session()->put('tgl2',$tgl2);
        return redirect()->route('setting.log-login.index');
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
