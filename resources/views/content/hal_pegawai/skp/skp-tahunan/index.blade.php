@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">
                        <i class="fas fa-list-alt"></i> Data Pengisian Penilaian SKP Pegawai Tahun {{$tahun}}
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp-pegawai.prilaku.cari')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                                </div>
                                <select class="form-control" id="tahun" name="tahun">
                                    {!!$pilihan_tahun_skp!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button href="" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-block card-stretch card-height">
            <div class="card-body bg-warning-light rounded">
                <div class="row">
                    <div class="col-md-12">
                        <center><span><h4>Periode Aktif Pengisian SKP Pegawai</h4></span><hr/></center>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-6">
                        <center><h4>Bulan : {{$arrBulanPanjang[$periodeaktif->bulan]}}</h4></center>
                    </div>
                    <div class="col-md-6">
                        <center><h4>Tahun : {{$periodeaktif->tahun}}</h4></center>
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
                <span>Informasi Atasan Penilai<hr/></span>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Atasan Pendamping</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$dtpegawai->nm_atasan_pendamping->nm_sdm}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Atasan Langsung</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$dtpegawai->nm_atasan->nm_sdm}}" aria-describedby="inputGroup-sizing-default" required>
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
                        <a href="{{URL::to('skp-pegawai/target-skp/isi_skp')}}/{{Crypt::encrypt($dtpegawai->id_sdm)}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Nama Kegiatan Tugas Jabatan / Rubrik Kinerja</th>
                                        <th colspan="5"><center>Ralisasi</center></th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Kuantitas / Output</th>
                                        <th>Kualitas Mutu</th>
                                        <th><center>Waktu <br/>(Jam)</center></th>
                                        <th><center>Biaya <br/>(Rp.)</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}"/>

@stop