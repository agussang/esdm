<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repotrprilakupegawai;
use App\Repositories\Repomsperiodeskp;
use App\Repositories\Repomspegawai;
use Session;
use Crypt;
use Fungsi;

class TargetSkpPegawaiController extends Controller
{
    public function __construct(
        Request $request,
        Repomsperiodeskp $repomsperiodeskp,
        Repomspegawai $repomspegawai,
        Repotrprilakupegawai $repotrprilakupegawai
    ){
        $this->request = $request;
        $this->repomsperiodeskp = $repomsperiodeskp;
        $this->repomspegawai = $repomspegawai;
        $this->repotrprilakupegawai = $repotrprilakupegawai;
    }
    public function index($id_sdm)
    {
        $tahun = Session::get('tahun');
        if($tahun==null){
            $tahun = date('Y');
        }
        $id_sdm = Crypt::decrypt($id_sdm);
        $data['pilihan_tahun_skp'] = Fungsi::pilihan_tahun_skp($tahun);
        $data['rsData'] = $this->repomsperiodeskp->get("",$tahun);
        $data['periodeaktif'] = $this->repomsperiodeskp->findWhereRaw("","status = '1'");
        $data['tahun'] = $tahun;
        $data['arrBulanPanjang'] = Fungsi::nm_bulan();
        $data['dtpegawai'] = $this->repomspegawai->findId(['nm_atasan_pendamping','nm_atasan','nm_satker'],$id_sdm,"id_sdm");
        // develop by masgus - no-cache headers agar data SKP selalu fresh
        return response()
            ->view('content.hal_pegawai.skp.skp-tahunan.index',$data)
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    
    public function create($id)
    {
        $id_sdm = Crypt::encrypt($id);
        $data['pilihan_rubrik'] = Fungsi::pilihan_rubrik();
        return view('content.hal_pegawai.skp.skp-tahunan.isi-skp',$data);
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
