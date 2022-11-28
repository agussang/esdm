@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Pegawai</h5>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('data-pegawai.master-pegawai.import')}}" class="btn btn-danger"><i class="fas fa-upload"></i> Import Data Pegawai</a>
                            <a href="{{route('data-pegawai.master-pegawai.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.master-pegawai.cari')}}" method="post">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Keaktifan</span>
                            </div>
                            <select class="form-control" id="id_stat_aktif" name="id_stat_aktif">
                                {!!$pilihan_status_keaktifan!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Kepegawaian</span>
                            </div>
                            <select class="form-control" id="id_stat_kepeg" name="id_stat_kepeg">
                                {!!$pilihan_status_kepegawaian!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Satuan Unit Kerja</span>
                            </div>
                            <select class="form-control" id="id_satkernow" name="id_satkernow">
                                {!!$pilihan_satker!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jenis Sdm</span>
                            </div>
                            <select class="form-control" id="id_jns_sdm" name="id_jns_sdm">
                                {!!$pilihan_jns_sdm!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input type="text" name="nama_pegawai" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="{{route('data-pegawai.master-pegawai.import-rekening')}}" class="btn btn-success"><i class="fas fa-upload"></i> Import No Rekening</a>
                        <button class="btn btn-primary pull-right"><i class="fas fa-search"></i> Tampilkan Data</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <span><b>Total Data : {!!$totalRecord!!}</b></span>
                    </div>
                    <div class="col-md-8">
                        {!!$paging!!}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="20%">Nama Pegawai</th>
                                <th width="10%">Unit Kerja</th>
                                <th width="10%">Golongan</th>
                                <th width="10%">Status <br/>Kepegawaian</th>
                                <th width="20%">Jab. Fung</th>
                                <th width="20%">Jab. Struk</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData AS $rs=>$r)
                            <tr>
                                <td>
                                    <b>{{$r->nm_sdm}}</b><br/>
                                    <span>Nidn : {{$r->nidn}}</span><br/>
                                    <span>Nip : {{$r->nip}}</span><br/>
                                    <span>Status Aktif : {{$r->stat_aktif->namastatusaktif}}</span>
                                </td>
                                <td>{{$r->nm_satker->nm_lemb}}</td>
                                <td align="center">{{$r->nm_golongan->kode_golongan}}</td>
                                <td align="center">{{$r->stat_kepegawaian->namastatuspegawai}}</td>
                                <td>{{$r->nm_jab_fung->namajabatan}}</td>
                                <td>{{$r->nm_jab_struk->namajabatan}}</td>
                                <th>
                                    <a href="{{URL::to('/data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($r->id_sdm)}}" class="btn btn-primary btn-xs" style="margin-bottom: 70px;"><i class="fas fa-eye"></i> Lihat</a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><br/>
                <div class="row">
                    <div class="col-md-4">
                        <span><b>Total Data : {!!$totalRecord!!}</b></span>
                    </div>
                    <div class="col-md-8">
                        {!!$paging!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
