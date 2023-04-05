@extends('layouts.layout')
@section('content')
<?php
$readonly = "";$text = "";$pengajuan_durasi = $durasi;
if($kode==2 || $kode==3){
    $readonly = "readonly=\"true\"";
    $text = "Pengajuan durasi justifikasi maksimal 60 menit.";
    if($durasi>60){
        $pengajuan_durasi = "60";
    }
}
if($kode==1){
    $text = "Kategori justifikasi tidak hadir pegawai dapat mengajukan jam masuk dan jam pulang.";
}

$readjammasuk = "";$readjampulang="";$requiredmasuk = "";$requiredpulang="";
$ket_justifikasi = "";
if($kode==4){
    $jam = array_shift($arrData[$tgl]['jam_absen']);
    if(str_replace(":","",$jam) < "120001"){
        $jam_masuk = $jam;
        $ket_justifikasi = "jam_pulang";
        $jam_pulang = "";
        $readjammasuk = "readonly=\"true\"";
        $requiredpulang = "required";
    }else{
        $jam_masuk = "";
        $jam_pulang = $jam;
        $readjampulang = "readonly=\"true\"";
        $requiredmasuk = "required";
        $ket_justifikasi = "jam_masuk";
    }
    $text = "Kategori justifikasi absen 1x pegawai dapat mengajukan jam presensi.";
}else{
    $jam_masuk = array_shift($arrData[$tgl]['jam_absen']);
    $jam_pulang= end($arrData[$tgl]['jam_absen']);
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> <span> Form Pengajuan Justifikasi Kehadiran Pegawai</span></h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('beranda')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('justifikasi.simpan-pengajuan-justifikasi-pegawai')}}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="ket_justifikasi" id="ket_justifikasi" value="{{$ket_justifikasi}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input value="{{$dt_pegawai->nm_sdm}}" class="form-control" name="nm_sdm" id="nm_sdm" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nip Pegawai</span>
                            </div>
                            <input type="text" value="{{$dt_pegawai->nip}}" class="form-control" name="nip" id="nip" readonly="true">
                            <input type="hidden" value="{{$dt_pegawai->id_sdm}}" class="form-control" name="id_sdm" id="id_sdm" readonly="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Presensi</span>
                            </div>
                            <input value="{{$arrData[$tgl]['tgl_text']}}" class="form-control" readonly="true">
                            <input type="hidden" value="{{$tgl}}" class="form-control" name="tanggal_absen" id="tanggal_absen" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk</span>
                            </div>
                            <input type="time" value="{{$jam_masuk}}" {{$requiredmasuk}} class="form-control" name="jam_masuk" id="jam_masuk" {{$readjammasuk}}>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang</span>
                            </div>
                            <input type="time" value="{{$jam_pulang}}" {{$requiredpulang}} class="form-control" name="jam_pulang" id="jam_pulang"{{$readjampulang}}>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    @if($kode==2 || $kode=="3")
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Durasi {{$text_kategori}} <i><b>( Menit )</b></i></span>
                            </div>
                            <input value="{{$durasi}}" class="form-control" {{$readonly}} name="durasi_kategori" id="durasi_kategori">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Pengajuan Durasi Justifikasi <i><b>( Menit )</b></i></span>
                            </div>
                            <input type="number" value="{{$pengajuan_durasi}}" class="form-control" max="{{$pengajuan_durasi}}" name="ajuan_durasi_justifikasi" id="ajuan_durasi_justifikasi">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kategori Pengajuan</span>
                            </div>
                            <input value="{{$text_kategori}}" class="form-control" readonly="true" ame="ket_justifikasi" id="ket_justifikasi">
                            <input type="hidden" value="{{$kode}}" class="form-control"  name="kategori_justifikasi" id="kategori_justifikasi">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Alasan</span>
                            </div>
                            <textarea class="form-control" name="alasan" id="alasan">

                            </textarea>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <span>
                            <i>*Nb: {{$text}}</i>
                        </span>
                        <button class="btn btn-primary pull-right"><i class="fa fa-upload"></i> Ajukan Justifikasi</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
