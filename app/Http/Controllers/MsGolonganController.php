<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsgolongan;
use Crypt;
use Fungsi;

class MsGolonganController extends Controller
{
    public function __construct(
        Request $request,
        Repomsgolongan $repomsgolongan  
    ){
        $this->request = $request;
        $this->repomsgolongan = $repomsgolongan;
    }

    public function index()
    {
        $data['rsData'] = $this->repomsgolongan->get();
        return view('content.master.golongan.index',$data);
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
