<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomskedinasan;
use Crypt;
use Fungsi;

class MsKedinasanController extends Controller
{
    public function __construct(
        Request $request,
        Repomskedinasan $repomskedinasan  
    ){
        $this->request = $request;
        $this->repomskedinasan = $repomskedinasan;
    }

    public function index()
    {
        $data['rsData'] = $this->repomskedinasan->get();
        return view('content.master.kedinasan.index',$data);
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
