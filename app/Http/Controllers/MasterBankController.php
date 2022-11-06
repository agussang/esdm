<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repobank;

class MasterBankController extends Controller
{
    public function __construct(
        Request $request,
        Repobank $repobank  
    ){
        $this->request = $request;
        $this->repobank = $repobank;
    }

    public function index()
    {
        $rsData = $this->repobank->get();
        $data['rsData'] = $rsData;
        return view('content.master.bank.index',$data);
    }

    
    public function create()
    {
        return view('content.master.bank.tambah');
    }

    
    public function store(Request $request)
    {
        $req = $request->except('_token');
        $cek = $this->repobank->findId("",$req['kode_bank'],"kode_bank");
        if($cek){
            $notification = [
                'message' => 'Gagal, Kode Bank yang anda masukkan sudah ada.',
                'alert-type' => 'error',
            ];
            return redirect()->route('data-master.bank.tambah')->with($notification);
        }else{
            $save = $this->repobank->store($req);
            $notification = [
                'message' => 'Berhasil, Data Master Bank berhasil ditambahkan.',
                'alert-type' => 'success',
            ];
            return redirect()->route('data-master.bank')->with($notification);
        }
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
        
    }
}
