<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomsstatuskepegawaian;
use Crypt;
use Fungsi;

class MsStatusKepegawaianController extends Controller
{
    public function __construct(
        Request $request,
        Repomsstatuskepegawaian $repomsstatuskepegawaian  
    ){
        $this->request = $request;
        $this->repomsstatuskepegawaian = $repomsstatuskepegawaian;
    }
    
    public function index()
    {
        $rsData= $this->repomsstatuskepegawaian->get();
        $data['rsData'] = $rsData;
        return view('content.master.status_kepegawaian.index',$data);
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
