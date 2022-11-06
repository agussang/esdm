@extends('layouts.layout')
@section('content')
<?php
$induk = explode('/',request()->path());
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Riwayat / History Presensi Kehadiran Apel</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')!="P")
                            <a href="{{URL::to('data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                                @if($induk[0]=="pegawai-bawahan")
                                    <a href="{{URL::to('pegawai-bawahan/detil')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @else
                                    <a href="{{URL::to('pegawai/detil')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($induk[0]=="pegawai-bawahan")
                <form class="form" action="{{route('pegawai-bawahan.cari.apel')}}" method="post">
                @else
                <form class="form" action="{{route('pegawai.cari.apel')}}" method="post">
                @endif
                {!! csrf_field() !!}
                <input type="hidden" name="id_sdm" id="id_sdm" value="{{$id_sdm}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                            </div>
                            <select class="form-control" name="tahun" id="tahun" required>
                                {!!$pilihan_tahun_presensi!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input type="text" readonly="true" value="{{$dt_pegawai->nm_sdm}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
                    </div>
                </div>
                </forrm>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <span><i>*Nb: Data ditampilkan dalam 1 tahun</i></span>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Jam Kegiatan</th>
                                        <th>Hadir ?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;?>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$r->nm_kegiatan_apel->nama_kegiatan}}</td>
                                        <td>{{Fungsi::formatDate($r->nm_kegiatan_apel->tgl_kegiatan)}}</td>
                                        <td>{{$r->nm_kegiatan_apel->jam_mulai}} - {{$r->nm_kegiatan_apel->jam_selesai}}</td>
                                        <td>
                                            @if($r->kehadiran=="H")
                                                Hadir
                                            @else
                                                Tidak Hadir
                                            @endif
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