<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsstatusaktif;
use Crypt;
use Fungsi;

class MsStatusKeaktifanController extends Controller
{
    public function __construct(
        Request $request,
        Repomsstatusaktif $repomsstatusaktif  
    ){
        $this->request = $request;
        $this->repomsstatusaktif = $repomsstatusaktif;
    }
    
    public function index()
    {
        $data['rsData'] = $this->repomsstatusaktif->get();
        return view('content.master.status_aktif.index',$data);
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
