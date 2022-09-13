<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsjnssdm;

class MsJnsSdmController extends Controller
{
    public function __construct(
        Request $request,
        Repomsjnssdm $repomsjnssdm  
    ){
        $this->request = $request;
        $this->repomsjnssdm = $repomsjnssdm;
    }

    public function index()
    {
        $data['rsData'] = $this->repomsjnssdm->get();
        return view('content.master.jns_sdm.index',$data);
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
