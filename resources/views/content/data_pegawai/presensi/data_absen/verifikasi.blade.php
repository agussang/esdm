@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Form Edit Data Absen Kehadiran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.data-absen.simpan_verifikasi')}}" method="post" enctype="multipart/form-data">
				{!! csrf_field() !!}
                    <input type="hidden" id="id_absen" name="id_absen" value="{{$rsData->id_absen}}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                </div>
                                <select class="form-control" required disabled="true">
                                        {!!$pilihan_sdm!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Mulai Absen</span>
                                </div>
                                <input type="date" class="form-control" required value="{{$rsData->tgl_awal}}" readonly="true">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Berakhir Absen</span>
                                </div>
                                <input type="date" class="form-control" required value="{{$rsData->tgl_akhir}}" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Alasan Absen</span>
                                </div>
                                <select class="form-control"  required disabled="true">
                                        {!!$pilihan_alasan_absen!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Pilihan Status</span>
                                </div>
                                <select class="form-control" id="is_valid" name="is_valid" required>
                                    {!!$pilihan_verifikasi!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Verifikasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span><i class="fas fa-file-pdf text-dark"></i> File Bukti Absen Kehadiran</span>
                <hr/>
                <center>
                    <object type="application/pdf" data="{{URL::to('assets/file_bukti_absen')}}/{{$rsData->file_bukti}}" src="" width="1400" height="800">
                    </object>
                </center>
            </div>
        </div>
    </div>
</div>
@stop