<?php
error_reporting(0);
$expanded = "false";
$collapse = "";
$aktifexpand="";
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
?>
<li class="{{ $induk[0]=="home" ? 'active' : '' }}">
    <a href="{{URL::to('/home')}}"> <i class="fa fa-home"></i><span> Home</span> </a>
</li>
<li class="{{ $induk[1]=="data-skp" ? 'active' : '' }}">
    <a href="{{route('skp.data-skp.index')}}">
        <i class="las la-edit"></i><span>Data Skp</span>
    </a>
</li>
