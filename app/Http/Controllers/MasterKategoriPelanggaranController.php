<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RepoMsPelanggaran;
use Fungsi;


class MasterKategoriPelanggaranController extends Controller
{
    public function __construct(
        Request $request,
        RepoMsPelanggaran $repomspelanggaran
    ){
        $this->request = $request;
        $this->repomspelanggaran = $repomspelanggaran;
    }
    
    public function index()
    {
        $data['rsData'] = $this->repomspelanggaran->get();
        return view('content.master.pelanggaran.index',$data);
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
