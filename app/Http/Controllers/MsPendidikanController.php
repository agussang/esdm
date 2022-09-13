<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomspendidikan;
use Crypt;
use Fungsi;

class MsPendidikanController extends Controller
{
    public function __construct(
        Request $request,
        Repomspendidikan $repomspendidikan  
    ){
        $this->request = $request;
        $this->repomspendidikan = $repomspendidikan;
    }

    public function index()
    {
        $data['rsData'] = $this->repomspendidikan->get();
        return view('content.master.pendidikan.index',$data);
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
