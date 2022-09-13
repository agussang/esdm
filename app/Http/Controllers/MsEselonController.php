<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repomseselon;
use Crypt;
use Fungsi;

class MsEselonController extends Controller
{
    public function __construct(
        Request $request,
        Repomseselon $repomseselon  
    ){
        $this->request = $request;
        $this->repomseselon = $repomseselon;
    }
    
    public function index()
    {
        $data['rsData'] = $this->repomseselon->get();
        return view('content.master.eselon.index',$data);
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

    
    public function edit(Request $request)
    {
        $req = $request->except('_token');
        $data['rsData'] = $this->repomseselon->findId("",$req,"id");
        return view('content.master.eselon.edit',$data);
    }

    
    public function update(Request $request)
    {
        $req = $request->except('_token');
        $id = $req['id'];
        unset($req['id']);
        $where['id'] = $id;
        $save = $this->repomseselon->update_or_create($where,$req);
        echo '<script type="text/javascript">toastr.success("Berhasil, Data Master Eselon berhasil disimpan.")</script>';
        echo "<script>
        setTimeout(function () {
        location.reload();
        }, 2000);
        </script>";
    }

    
    public function destroy($id)
    {
        //
    }
}
