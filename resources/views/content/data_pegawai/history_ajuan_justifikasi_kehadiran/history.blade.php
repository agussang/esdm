@extends('layouts.layout')
@section('content')
<?php
$arrStatusJustifikasi = array("1"=>"Disetujui","2"=>"Tidak disetuji","0"=>"Belum disetujui");
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="header-title">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-label"><i class="fas fa-list-alt"></i> List Pengajuan Justifikasi Kehadiran Pegawai</h5>
                            </div>
                            <div class="col-md-3">
                                <a href="{{route('data-pegawai.data-presensi.pengajuan-justifikasi-kehadiran.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
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
                            <input value="{{$dt_pegawai->nip}}" class="form-control" name="nip" id="nip" readonly="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Bulan</span>
                            </div>
                            <input value="{{$arrnmbulan[$bulan]}}" class="form-control" name="bulan" id="bulan" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                            </div>
                            <input value="{{$tahun}}" class="form-control" name="tahun" id="tahun" readonly="true">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <span>List Pengajuan Justifikasi Kehadiran</span>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Tanggal Presensi</th>
                                        <th rowspan="2">Jam Masuk</th>
                                        <th rowspan="2">Jam Pulang</th>
                                        <th rowspan="2">Kategori Pengajuan</th>
                                        <th rowspan="2">Tanggal Pengajuan</th>
                                        <th rowspan="2">Status</th>
                                        <th colspan="2">Durasi Justifikasi</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Ajuan</th>
                                        <th>Justifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;?>
                                    @foreach($rsData as $rs=>$r)
                                    <?php
                                    $jam_masuk = "--:--:--";
                                    $jam_pulang = "--:--:--";
                                    $text_masuk = "";$text_pulang = "";
                                    if($r->ket_justifikasi=="jam_masuk"){
                                        $text_masuk = "<br/><b><i>( Pengajuan ) </i></b>";
                                    }
                                    if($r->ket_justifikasi=="jam_pulang"){
                                        $text_pulang = "<br/><b><i>( Pengajuan ) </i></b>";
                                    }


                                    if($r->jam_masuk){
                                        $jam_masuk = $r->jam_masuk;
                                    }if($r->jam_pulang){
                                        $jam_pulang = $r->jam_pulang;
                                    }
                                    $durasitelat = "";
                                    if($r->kategori_justifikasi=="2" || $r->kategori_justifikasi=="3"){
                                        $durasitelat = "<b>( ".$r->durasi_kategori." Menit )</b>";
                                    }
                                    $warna = "";
                                    if($r->justifikasi_atasan==null){
                                        $warna = "background-color: #F1E780;";
                                    }else if($r->justifikasi_atasan=="1"){
                                        $warna = "background-color: #9AE972;";
                                    }else if($r->justifikasi_atasan=="2"){
                                        $warna = "background-color: #F18280;";
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{Fungsi::formatDate($r->tanggal_absen)}}</td>
                                        <td>{{$jam_masuk}} {!!$text_masuk!!}</td>
                                        <td>{{$jam_pulang}} {!!$text_pulang!!}</td>
                                        <td>{{$arrkategorijustifikasi[$r->kategori_justifikasi]}} {!!$durasitelat!!}</td>
                                        <td>{{date('d-m-Y H:i:s',strtotime($r->created_at))}}</td>
                                        <td style="{{$warna}}">
                                            {{$arrStatusJustifikasi[$r->justifikasi_atasan]}}
                                        </td>
                                        <td>{{$r->ajuan_durasi_justifikasi}}</td>
                                        <td>{{$r->durasi_justifikasi}}</td>
                                        <td>

                                            <a href="{{URL::to('/data-pegawai/data-presensi/pengajuan-justifikasi-kehadiran/tolak')}}/{{Crypt::encrypt($r->id_justifikasi)}}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-ruler"></i> Tolak Ajuan Justifikasi</a>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
