<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class IndexController extends Controller
{
    
    public function index()
    {
        if(Session::get('level')=="P"){
            return view('content.hal_pegawai.home');
        }else{
            return view('content.home');
        }
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
