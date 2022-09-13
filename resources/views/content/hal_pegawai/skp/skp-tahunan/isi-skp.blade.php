@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">
                        <i class="fas fa-list-alt"></i> Form Tambah Data Target Penilaian SKP Tahun {{$tahun}}
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp-pegawai.target-skp.simpan')}}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id_sdm" id="id_sdm" value="{{$dtpegawai->id_sdm}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Rubrik SKP</span>
                                </div>
                                <select class="form-control" id="idrubrik" name="idrubrik">
                                    {!!$pilihan_rubrik!!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Kuantitas</span>
                                </div>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Kualitas (Mutu) %</span>
                                </div>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Waktu (Jam)</span>
                                </div>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Biaya (Rp.)</span>
                                </div>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </from>
            </div>
        </div>
    </div>
</div>
@stop