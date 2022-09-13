@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Upload Data Presensi</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.upload-presensi.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Nama Pegawai</label>
                            </div>
                            <select class="form-control" name="id_sdm" required>
                                {!!$pilihan_sdm!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Tanggal Presensi</label>
                            </div>
                            <input class="form-control" type="date" name="tgl_absen" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Jam Masuk</label>
                            </div>
                            <input class="form-control" type="time" name="jam_absen" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Jam Pulang</label>
                            </div>
                            <input class="form-control" type="time" name="jam_absen_pulang" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Mesin Finger</label>
                            </div>
                            <select class="form-control" name="mesin" required>
                                {!!$pilihan_mesin_finger!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button href="" class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Upload Data Presensi Excel</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.upload-presensi.upload')}}" method="post" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">File Excel Finger</label>
                            <input type="file" class="custom-file-input" id="inputGroupFile03" name="file_excel" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-upload"></i> Upload Excel</button>
                    </div>
                </div>
                </form>
                <br/><br/>
                @if(count((array)Session::get('pegawaiblumada'))>0)
                <span class="text-dark">Data Pegawai yang gagal di upload, dikarenakan data master pagwai nya belum ada didalam database.</span>
                <ul class="text-dark">
                    @foreach(Session::get('pegawaiblumada') as $rs=>$r)
                        <li>{{$r['nip']}} -- {{$r['nama']}}</li>
                    @endforeach
                </ul>
                <a href="{{route('data-pegawai.data-presensi.upload-presensi.clear')}}" class="btn btn-warning">Clear Data Gagal</a>
                @endif
            </div>
        </div>
    </div>
</div>

@stop