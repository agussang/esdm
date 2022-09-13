@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Tambah Data Riwayat Jabatan</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{URL::to('data-pegawai/detil-data')}}/{{Crypt::encrypt($profil->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{URL::to('/assets/images/page-img/15.jpg')}}" class="img-thumbnail w-100 img-fluid rounded" alt="Responsive image">
                    </div>
                    <div class="col-md-10">
                        <div class="table-reponsive">
                            <table class="table">
                                <tr>
                                    <td width="20%">Nama Pegawai</td>
                                    <td width="5%">:</td>
                                    <td width="75%">{{$profil->nm_sdm}}</td>
                                </tr>
                                <tr>
                                    <td>Nip</td>
                                    <td>:</td>
                                    <td width="75%">{{$profil->nip}}</td>
                                </tr>
                                <tr>
                                    <td>Satuan Unit Kerja</td>
                                    <td>:</td>
                                    <td width="75%">{{$profil->nm_satker->nm_lemb}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
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
                            <h5 class="card-label"><i class="fa fa-plus"></i> Form Tambah Data Riwayat Jabatan</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Type Jabatan</span>
                            </div>
                            <select class="form-control" name="tipejabatan" id="tipejabatan" required onchange="tmp_jabatan();">
                                {!!$pilihan_tipe_jabatan!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Jabatan</span>
                            </div>
                            <select class="form-control" name="id_jabatan" id="id_jabatan" required>

                            </select>   
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" id="no_sk" value="" name="no_sk" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Sk</span>
                            </div>
                            <input type="date" class="form-control" aria-label="Default" id="tgl_sk" value="" name="tgl_sk" aria-describedby="inputGroup-sizing-default" required>  
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">File Sk Penetapan</label>
                           <input type="file" class="custom-file-input" id="inputGroupFile03">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <a href="" class="btn btn-primary pull-right">Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Data Riwayat Jabatan</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <span><i>*Nb: Data terakhir yang dimasukkan akan menjadi jabatan saat ini.</i></span>
                        <div class="table-reponsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Jabatan</th>
                                        <th>Jenis Jabatan</th>
                                        <th>No Sk</th>
                                        <th>Tanggal Sk</th>
                                        <th>File Sk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
@stop