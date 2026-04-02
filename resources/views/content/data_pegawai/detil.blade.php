@extends('layouts.layout')
@section('content')
<?php
$readonly = "";
$disabled = "";
if(Session::get('level')=="P"){
    $readonly = "readonly=\"true\"";
    $disabled = "disabled = \"true\"";
}
$induk = explode('/',request()->path());
$path = public_path().'/assets/foto_pegawai/'.$rsData->file_foto;
if($rsData->file_foto){
    $file_photo = "/assets/foto_pegawai/".$rsData->file_foto;
}else{
    $file_photo = "assets/foto_tidak_ada.png";
}
?>
@if(Session::get('level')!="P")
<form class="form" action="{{route('data-pegawai.master-pegawai.update')}}" method="post" enctype="multipart/form-data">
@else
<form class="form" action="{{route('pegawai.update')}}" method="post" enctype="multipart/form-data">
@endif
{!! csrf_field() !!}
<input type="hidden" name="id_sdm" id="id_sdm" value="{{$rsData->id_sdm}}">
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Detail / Edit Data Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')!="P")
                                <a href="{{route('data-pegawai.master-pegawai.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @endif
                            @if($induk[0]=="pegawai-bawahan")
                            <a href="{{route('pegawai-bawahan.pegawai')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-end mb-3" style="gap: 8px;">
                    @if(Session::get('level')!='P')
                    <a href="{{URL::to('skp-pegawai/skp/')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-warning"><i class="fas fa-chart-line"></i> Riwayat SKP & Perilaku</a>
                    @endif

                    @if($induk[0]=="pegawai-bawahan")
                    <a href="{{URL::to('pegawai-bawahan/riwayat-apel')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-purple"><i class="fas fa-flag"></i> Riwayat Apel</a>
                    <a href="{{URL::to('pegawai-bawahan/riwayat-kehadiran')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-primary"><i class="fas fa-fingerprint"></i> Riwayat Presensi</a>
                    <a href="{{URL::to('pegawai-bawahan/riwayat-absen')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-success"><i class="fas fa-calendar-check"></i> Riwayat Absen</a>
                    @else
                    <a href="{{URL::to('pegawai/riwayat-apel')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-purple"><i class="fas fa-flag"></i> Riwayat Apel</a>
                    <a href="{{URL::to('pegawai/riwayat-kehadiran')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-primary"><i class="fas fa-fingerprint"></i> Riwayat Presensi</a>
                    <a href="{{URL::to('pegawai/riwayat-absen')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-sm btn-success"><i class="fas fa-calendar-check"></i> Riwayat Absen</a>
                    @endif
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{URL::to($file_photo)}}" class="img-thumbnail w-60 img-fluid rounded" alt="Responsive image">
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                    </div>
                                    <input type="text" class="form-control" name="nm_sdm" id="nm_sdm"  value="{{ $rsData->nm_sdm }}" {{$readonly}}>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Tempat Lahir</span>
                                    </div>
                                    <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir"  value="{{ $rsData->tmpt_lahir }}" {{$readonly}}>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Lahir</span>
                                    </div>
                                    <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir"  value="{{ $rsData->tgl_lahir }}" {{$readonly}}>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Jenis Kelamin</span>
                                    </div>
                                    <select class="form-control" name="jk" id="jk"  {{$disabled}}>
                                        {!!$pilihan_jenis_kelamin!!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">NIK</span>
                                    </div>
                                    <input type="text" class="form-control" name="nik" id="nik"  minlength="16" maxlength="16" onkeypress="return goodchars(event,'1234567890',this)" value="{{ $rsData->nik }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">No Hp</span>
                                    </div>
                                    <input type="text" class="form-control" name="no_hp" id="no_hp" minlength="11" maxlength="13"  onkeypress="return goodchars(event,'1234567890',this)" value="{{ $rsData->no_hp }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                                    </div>
                                    <input type="text" class="form-control" name="email" id="email"  value="{{ $rsData->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Status Perkawinan</span>
                                    </div>
                                    <select class="form-control" name="id_stat_kawin" id="id_stat_kawin" >
                                        {!!$pilihan_status_kawin!!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Agama</span>
                                    </div>
                                    <select class="form-control" name="id_agama" id="id_agama" >
                                        {!!$pilihan_agama!!}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="inputGroupFile03">Foto Pegawai</label>
                                    <input type="file" class="custom-file-input" id="inputGroupFile03" accept="application/jpg" name="foto_pegawai">
                                </div>
                                <br/><br/>
                                <span>Ketentuan Upload Foto :</span>
                                <ul>
                                    <li>Format foto .jpg</li>
                                    <li>Ukuran File 2 MB.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <p class="text-dark"><i class="fa fa-home text-dark"></i> Informasi Alamat Rumah</p><hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jalan</span>
                            </div>
                            <input type="text" class="form-control" name="jln" id="jln" value="{{ $rsData->jln }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kode Pos</span>
                            </div>
                            <input type="text" class="form-control" name="kode_pos" value="{{ $rsData->kode_pos }}" id="kode_pos" minlength="5" maxlength="5" onkeypress="return goodchars(event,'1234567890',this)">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Desa</span>
                            </div>
                            <input type="text" class="form-control" name="ds_kel" id="ds_kel" value="{{ $rsData->ds_kel }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Dusun</span>
                            </div>
                            <input type="text" class="form-control" name="nm_dsn" id="nm_dsn" value="{{ $rsData->nm_dsn }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">RT</span>
                            </div>
                            <input type="text" class="form-control" name="rt" id="rt" minlength="1" value="{{ $rsData->rt }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">RW</span>
                            </div>
                            <input type="text" class="form-control" name="rw" id="rw" minlength="1" value="{{ $rsData->rw }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <p class="text-dark"><i class="fa fa-home text-dark"></i> Informasi Jabatan, Kedinasan, Golongan, Dan Penempatan Unit Kerja Pegawai</p><hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Unit Kerja</span>
                            </div>
                            <select class="form-control" name="id_satkernow" id="id_satkernow"  {{$disabled}}>
                                {!!$pilihan_satker!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kedinasan</span>
                            </div>
                            <select class="form-control" name="id_kedinasan" id="id_kedinasan"  {{$disabled}}>
                                {!!$pilihan_kedinasan!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jabatan Fungsional</span>
                            </div>
                            <select class="form-control" name="id_jabatan_fungsional_now" id="id_jabatan_fungsional_now" {{$disabled}}>
                                {!!$pilihan_jabatan_fungsional!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jabatan Struktural</span>
                            </div>
                            <select class="form-control" name="id_jabatan_struktural_now" id="id_jabatan_struktural_now" {{$disabled}}>
                                {!!$pilihan_jabatan_struktural!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Golongan</span>
                            </div>
                            <select class="form-control" name="id_golongannow" id="id_golongannow" {{$disabled}}>
                                {!!$pilihan_golongan!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Grade Jabatan</span>
                            </div>
                            <select class="form-control" name="id_grade_khusus" id="id_grade_khusus" {{$disabled}}>
                                {!!$pilihan_grade!!}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <p class="text-dark"><i class="fa fa-home text-dark"></i> Informasi Npwp Dan Nomor Rekening</p><hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Npwp</span>
                            </div>
                            <input type="text" class="form-control" name="npwp" id="npwp"  value="{{ $rsData->npwp }}" {{$disabled}}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Bank</span>
                            </div>
                            <select class="form-control" name="id_bank" id="id_bank"  {{$disabled}}>
                                {!!$pilihan_absen!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Rekening</span>
                            </div>
                            <input type="text" class="form-control" name="nmrek" id="nmrek"  value="{{ $rsData->nmrek }}" {{$readonly}}>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nomor Rekening</span>
                            </div>
                            <input type="text" class="form-control" name="no_rekening" {{$readonly}} id="no_rekening"  value="{{ $rsData->no_rekening }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <p class="text-dark"><i class="fa fa-user text-dark"></i> Informasi Status Kepegawaian</p><hr/>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jenis Pegawai</span>
                            </div>
                            <select class="form-control" name="id_jns_sdm" id="id_jns_sdm" onchange="tmp_jns_sdm(this)"  {{$disabled}}>
                                {!!$pilihan_jns_sdm!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Kepegawaian</span>
                            </div>
                            <select class="form-control" name="id_stat_kepegawaian" {{$disabled}} id="id_stat_kepegawaian" onchange="tmp_status_kepegawaian(this)" >
                                {!!$pilihan_status_kepegawaian!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Keaktifan</span>
                            </div>
                            <select class="form-control" name="id_stat_aktif" id="id_stat_aktif" {{$disabled}} >
                                {!!$pilihan_status_keaktifan!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="form-nidn">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nidn</span>
                            </div>
                            <input type="number" class="form-control" name="nidn" id="nidn" value="{{ $rsData->nidn }}" {{$readonly}}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nip</span>
                            </div>
                            <input type="number" class="form-control" name="nip" id="nip" value="{{ $rsData->nip }}" {{$readonly}}>
                        </div>
                    </div>
                </div>
                <div class="row" id="form-non-cpns">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk</span>
                            </div>
                            <input type="text" class="form-control" name="no_sk" id="no_sk" value="{{ $rsData->no_sk }}" {{$readonly}}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Sk Angkat</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_sk_angkat" id="tgl_sk_angkat" value="{{ $rsData->tgl_sk_angkat }}" {{$readonly}}>
                        </div>
                    </div>
                </div>
                <div class="row" id="form-cpns">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk Cpns</span>
                            </div>
                            <input type="text" class="form-control" name="no_sk_cpns" id="no_sk_cpns" value="{{ $rsData->no_sk_cpns }}" {{$readonly}}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">TMT CPNS</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_tmt_cpns" id="tgl_tmt_cpns" value="{{ $rsData->tgl_tmt_cpns }}" {{$readonly}}>
                        </div>
                    </div>
                </div>
                <div class="row" id="form-pns">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk PNS</span>
                            </div>
                            <input type="text" class="form-control" name="no_sk_pns" id="no_sk_pns" value="{{ $rsData->no_sk_pns }}" {{$readonly}}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">TMT PNS</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_tmt_pns" id="tgl_tmt_pns" value="{{ $rsData->tgl_tmt_pns }}" {{$readonly}}>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($induk[0]!="pegawai-bawahan")
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Update Data</button>
    </div>
</div>
@endif
</form>
<br/><br/><br/><br/><br/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
$('#form-pns').hide();
$('#form-cpns').hide();
$('#form-non-cpns').hide();
$('#form-nidn').hide();
@if($rsData->id_jns_sdm=="60943815-0ef4-403e-98d8-7a96ecdc6d5f")
    $('#form-nidn').show();
@endif

@if($rsData->id_stat_kepegawaian=="eb592b52-58d8-4dfc-ac7d-c41c7cea695e")
    $('#form-pns').show();
    $('#form-cpns').hide();
    $('#form-non-cpns').hide();
@endif
@if($rsData->id_stat_kepegawaian=="588fe662-9f66-44e3-a923-5056b67536f5")
    $('#form-cpns').show();
    $('#form-non-cpns').hide();
    $('#form-pns').hide();
@endif
@if($rsData->id_stat_kepegawaian!="588fe662-9f66-44e3-a923-5056b67536f5" && $rsData->id_stat_kepegawaian!="eb592b52-58d8-4dfc-ac7d-c41c7cea695e")
    $('#form-non-cpns').show();
    $('#form-cpns').hide();
    $('#form-pns').hide();
@endif

function tmp_status_kepegawaian(a)
{
    var x = (a.value || a.options[a.selectedIndex].value);

    if (x == "eb592b52-58d8-4dfc-ac7d-c41c7cea695e") {
        $('#form-pns').show();
        $('#form-cpns').hide();
        $('#form-non-cpns').hide();
    } else if(x == "588fe662-9f66-44e3-a923-5056b67536f5") {
        $('#form-cpns').show();
        $('#form-non-cpns').hide();
        $('#form-pns').hide();
    } else if(x != "588fe662-9f66-44e3-a923-5056b67536f5" && x != "eb592b52-58d8-4dfc-ac7d-c41c7cea695e") {
        $('#form-non-cpns').show();
        $('#form-cpns').hide();
        $('#form-pns').hide();
    }
}
function tmp_jns_sdm(a)
{
    var x = (a.value || a.options[a.selectedIndex].value);

    if (x == "60943815-0ef4-403e-98d8-7a96ecdc6d5f") {
        $('#form-nidn').show();
    } else {
        $('#form-nidn').hide();
    }
}
</script>
@stop
