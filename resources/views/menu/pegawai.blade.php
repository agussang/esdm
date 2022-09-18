<?php
error_reporting(0);
$expanded = "false";
$expanded2 = "false";
$expanded3 = "false";
$expanded4 = "false";
$collapse = "";
$collapse2 = "";
$collapse3 = "";
$collapse4 = "";
$aktifexpand="";
$aktifexpand2="";
$aktifexpand3="";
$aktifexpand4="";
$menu_aktif="";
$induk = explode('/',request()->path());
if($induk[0]=="data-master"){
    $expanded = "true";
    $collapse = "show";
    $aktifexpand="active";
}
if($induk[0]=="data-pegawai"){
    $expanded2 = "true";
    $collapse2 = "show";
    $aktifexpand2="active";
}
if($induk[0]=="skp"){
    $expanded3 = "true";
    $collapse3 = "show";
    $aktifexpand3="active";
}
if($induk[0]=="laporan"){
    $expanded4 = "true";
    $collapse4 = "show";
    $aktifexpand4="active";
}
if($induk[0]=="setting"){
    $expanded3 = "true";
    $collapse3 = "show";
    $aktifexpand3="active";
}

?>
<li class="{{ $induk[0]=="home" ? 'active' : '' }}">
    <a href="{{URL::to('/beranda')}}"> <i class="fa fa-home"></i><span> Home</span> </a>
</li>
<li class="{{ $induk[0]=="pegawai" ? 'active' : '' }}">
    <a href="{{URL::to('/pegawai/detil')}}/{{Crypt::encrypt(Session::get('id_sdm_pengguna'))}}"> <i class="fa fa-user"></i><span> Data Pegawai</span> </a>
</li>
<li class="{{ $induk[1]=="skp" ? 'active' : '' }}">
    <a href="{{URL::to('skp-pegawai/skp/')}}/{{Crypt::encrypt(Session::get('id_sdm_pengguna'))}}">
        <i class="fas fa-user-edit"></i><span>Skp Dan Prilaku</span>
    </a>
</li>
@if(Session::get('atasan_penilai')!=null)
<li class="{{ $induk[0]=="pegawai-bawahan" ? 'active' : '' }}">
    <a href="{{route('pegawai-bawahan.pegawai')}}">
        <i class="fas fa-users"></i><span>Pegawai Bawahan</span>
    </a>
</li>
@endif