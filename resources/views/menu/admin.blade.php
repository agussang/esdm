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
<li class="{{$aktifexpand}}">
    <a href="#master" class="collapsed" data-toggle="collapse" aria-expanded="{{$expanded}}">
        <i class="fa fa-folder-open"></i><span> Data Master</span>
        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
    </a>
    <ul id="master" class="iq-submenu collapse {{$collapse}}" data-parent="#iq-sidebar-toggle">
        <li class="{{ $induk[1]=="agama" ? 'active' : '' }}">
            <a href="{{route('data-master.agama')}}"> <i class="fa fa-book"></i><span> Master Agama</span> </a>
        </li>
        <li class="{{ $induk[1]=="bank" ? 'active' : '' }}">
            <a href="{{route('data-master.bank')}}">  <i class="fa fa-book"></i><span> Master Bank</span> </a>
        </li>
        <li class="{{ $induk[1]=="waktu-presensi" ? 'active' : '' }}">
            <a href="{{route('data-master.waktu-presensi')}}">  <i class="fa fa-book"></i><span> Master Waktu Presensi</span> </a>
        </li>
        <li class="{{ $induk[1]=="jabatan" ? 'active' : '' }}">
            <a href="{{route('data-master.jabatan')}}">  <i class="fa fa-book"></i><span> Master Jabatan</span> </a>
        </li>
        <li class="{{ $induk[1]=="kategori-pelanggaran" ? 'active' : '' }}">
            <a href="{{route('data-master.kategori-pelanggaran')}}">  <i class="fa fa-book"></i><span> Master Kategori Pelanggaran</span> </a>
        </li>
        <li class="{{ $induk[1]=="alasan-absen" ? 'active' : '' }}">
            <a href="{{route('data-master.alasan-absen')}}">  <i class="fa fa-book"></i><span> Master Alasan Absen</span> </a>
        </li>
        {{--  <li class="{{ $induk[1]=="eselon" ? 'active' : '' }}">
            <a href="{{route('data-master.eselon')}}">  <i class="fa fa-book"></i><span> Master Eselon</span> </a>
        </li>  --}}
        <li class="{{ $induk[1]=="pendidikan" ? 'active' : '' }}">
            <a href="{{route('data-master.pendidikan')}}">  <i class="fa fa-book"></i><span> Master Pendidikan</span> </a>
        </li>
        <li class="{{ $induk[1]=="hari-libur" ? 'active' : '' }}">
            <a href="{{route('data-master.hari-libur')}}">  <i class="fa fa-calendar"></i><span> Master Hari Libur</span> </a>
        </li>
        <li class="{{ $induk[1]=="grade" ? 'active' : '' }}">
            <a href="{{route('data-master.grade')}}">  <i class="fa fa-book"></i><span> Master Grade</span> </a>
        </li>
        <li class="{{ $induk[1]=="golongan" ? 'active' : '' }}">
            <a href="{{route('data-master.golongan')}}">  <i class="fa fa-book"></i><span> Master Golongan</span> </a>
        </li>
        <li class="{{ $induk[1]=="kedinasan" ? 'active' : '' }}">
            <a href="{{route('data-master.kedinasan')}}">  <i class="fa fa-book"></i><span> Master Kedinasan</span> </a>
        </li>
        <li class="{{ $induk[1]=="status-aktif" ? 'active' : '' }}">
            <a href="{{route('data-master.status-aktif')}}">  <i class="fa fa-book"></i><span> Master Status Aktif</span> </a>
        </li>
        <li class="{{ $induk[1]=="status-kepegawaian" ? 'active' : '' }}">
            <a href="{{route('data-master.status-kepegawaian')}}">  <i class="fa fa-book"></i><span> Master Status Kepegawaian</span> </a>
        </li>
        <li class="{{ $induk[1]=="jenis-sdm" ? 'active' : '' }}">
            <a href="{{route('data-master.jenis-sdm')}}">  <i class="fa fa-book"></i><span> Master Jenis Sdm</span> </a>
        </li>
        <li class="{{ $induk[1]=="satuan-unit-kerja" ? 'active' : '' }}">
            <a href="{{route('data-master.satuan-unit-kerja')}}">  <i class="fa fa-book"></i><span> Master Unit Kerja</span> </a>
        </li>
    </ul>
</li>
<li class="{{$aktifexpand2}}">
    <a href="#master" class="collapsed" data-toggle="collapse" aria-expanded="{{$expanded2}}">
        <i class="fa fa-swatchbook"></i><span> Data Pegawai</span>
        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
    </a>
    <ul id="master" class="iq-submenu collapse {{$collapse2}}" data-parent="#iq-sidebar-toggle">
        <li class="{{ $induk[1]=="master-pegawai" ? 'active' : '' }}">
            <a href="{{route('data-pegawai.master-pegawai.index')}}">  <i class="fa fa-list-alt"></i><span> Master Pegawai</span> </a>
        </li>
        <li class="{{ $induk[1]=="pelanggaran" ? 'active' : '' }}">
            <a href="{{route('data-pegawai.pelanggaran.index')}}"><i class="fa fa-tag"></i><span> Pelanggaran Disiplin</span> </a>
        </li>
        <li class="{{ $induk[1]=="atasan-pegawai" ? 'active' : '' }}">
            <a href="{{route('data-pegawai.atasan-pegawai.index')}}">  <i class="fas fa-pencil-ruler"></i><span> Setting Atasan Pegawai</span> </a>
        </li>
        <li class="{{ $induk[1]=="data-presensi" ? 'active' : '' }}">
            <a href="#form-controls" class="collapsed" data-toggle="collapse" aria-expanded="false">
                <i class="lab la-wpforms"></i><span>Data Presensi</span>
                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
            </a>
            <ul id="form-controls" class="iq-submenu collapse" data-parent="#form" style="">
                <li class="{{ $induk[2]=="upload-presensi" ? 'active' : '' }}">
                    <a href="{{route('data-pegawai.data-presensi.upload-presensi.index')}}">
                        <i class="las la-book"></i><span>Upload / Sync Presensi</span>
                    </a>
                </li>
                <li class="{{ $induk[2]=="apel" ? 'active' : '' }}">
                    <a href="{{route('data-pegawai.data-presensi.apel.index')}}">
                        <i class="las la-upload"></i><span>Upload Apel</span>
                    </a>
                </li>
                <li class="{{ $induk[2]=="data-absen" ? 'active' : '' }}">
                    <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}">
                        <i class="las la-keyboard"></i><span>Data Absen</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
<li class="{{$aktifexpand3}}">
    <a href="#skp" class="collapsed" data-toggle="collapse" aria-expanded="{{$expanded3}}">
        <i class="lab la-wpforms"></i><span> SKP</span>
        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
    </a>
    <ul id="skp" class="iq-submenu collapse {{$collapse3}}" data-parent="#form" style="">
        <li class="{{ $induk[1]=="setting-skp" ? 'active' : '' }}">
            <a href="{{route('skp.setting-skp.index')}}">
                <i class="fas fa-cogs"></i><span>Setting Periode SKP</span>
            </a>
        </li>
        <li class="{{ $induk[1]=="data-skp" ? 'active' : '' }}">
            <a href="{{route('skp.data-skp.index')}}">
                <i class="las la-edit"></i><span>Data Skp</span>
            </a>
        </li>
        <li class="{{ $induk[1]=="master-skp" ? 'active' : '' }}">
            <a href="#form-controls" class="collapsed" data-toggle="collapse" aria-expanded="false">
                <i class="lab la-wpforms"></i><span>Master Skp</span>
                <i class="las la-angle-right iq-arrow-right arrow-active"></i>
                <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
            </a>
            <ul id="form-controls" class="iq-submenu collapse" data-parent="#form" style="">
                <li class="{{ $induk[2]=="prilaku" ? 'active' : '' }}">
                    <a href="{{route('skp.master-skp.prilaku.index')}}">
                        <i class="las la-book"></i><span>Master Prilaku</span>
                    </a>
                </li>
                {{--  <li class="{{ $induk[2]=="satuan" ? 'active' : '' }}">
                    <a href="{{route('skp.master-skp.satuan')}}">
                        <i class="las la-book"></i><span>Master Satuan</span>
                    </a>
                </li>
                <li class="{{ $induk[2]=="rubrik" ? 'active' : '' }}">
                    <a href="{{route('skp.master-skp.rubrik')}}">
                        <i class="las la-book"></i><span>Master Rubrik</span>
                    </a>
                </li>                  --}}
            </ul>
        </li>
    </ul>
</li>
<li class="{{$aktifexpand4}}">
    <a href="#laporan" class="collapsed" data-toggle="collapse" aria-expanded="{{$expanded4}}">
        <i class="las la-book"></i><span> Laporan</span>
        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
    </a>
    <ul id="laporan" class="iq-submenu collapse {{$collapse4}}" data-parent="#iq-sidebar-toggle">
        <li class="{{ $induk[1]=="presensi-kehadiran" ? 'active' : '' }}">
            <a href="{{route('laporan.presensi-kehadiran.index')}}"> <i class="fa fa-users"></i><span> Laporan Kehadiran</span> </a>
        </li>
    </ul>
</li>
<li class="{{$aktifexpand5}}">
    <a href="#setting" class="collapsed" data-toggle="collapse" aria-expanded="{{$expanded5}}">
        <i class="fa fa-swatchbook"></i><span> Setting</span>
        <i class="las la-angle-right iq-arrow-right arrow-active"></i>
        <i class="las la-angle-down iq-arrow-right arrow-hover"></i>
    </a>
    <ul id="setting" class="iq-submenu collapse {{$collapse5}}" data-parent="#iq-sidebar-toggle">
        @if(Session::get('id_pengguna')=="30065b84-9afb-4c24-b565-12bfef2dde76")
        <li class="{{ $induk[1]=="app" ? 'active' : '' }}">
            <a href="{{route('setting.app.index')}}">  <i class="fa fa-list-alt"></i><span> Setting App</span> </a>
        </li>
        @endif
        <li class="{{ $induk[1]=="manajemen-user" ? 'active' : '' }}">
            <a href="{{route('setting.manajemen-user.index')}}"> <i class="fa fa-users"></i><span> Manajemen User</span> </a>
        </li>
        <li class="{{ $induk[1]=="log-login" ? 'active' : '' }}">
            <a href="{{route('setting.log-login.index')}}"> <i class="fa fa-eye"></i><span> Log Login</span> </a>
        </li>
    </ul>
</li>
