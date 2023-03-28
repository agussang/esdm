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
    $expanded5 = "true";
    $collapse5 = "show";
    $aktifexpand5="active";
}
?>
<li class="{{ $induk[0]=="home" ? 'active' : '' }}">
    <a href="{{URL::to('/home')}}"> <i class="fa fa-home"></i><span> Home</span> </a>
</li>
<li class="{{ $induk[1]=="data-skp" ? 'active' : '' }}">
    <a href="{{route('skp.data-skp.index')}}">
        <i class="las la-edit"></i><span>Data Skp</span>
    </a>
</li>
