@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Form Tambah Data Absen Kehadiran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')=="P" && Session::get('id_sdm_atasan')==Session::get('id_sdm'))
                            <a href="{{route('data-presensi.data-absen.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                            <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(Session::get('level')=="P" && Session::get('id_sdm_atasan')==Session::get('id_sdm'))
                <form class="form" action="{{route('data-presensi.data-absen.simpan')}}" method="post" enctype="multipart/form-data">
                @else
                <form class="form" action="{{route('data-pegawai.data-presensi.data-absen.simpan')}}" method="post" enctype="multipart/form-data">
                @endif
				{!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                </div>
                                <select class="form-control" id="id_sdm" name="id_sdm" required>
                                        {!!$pilihan_sdm!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Mulai Absen</span>
                                </div>
                                <input type="date" class="form-control" name="tgl_awal" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Berakhir Absen</span>
                                </div>
                                <input type="date" class="form-control" name="tgl_akhir" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Alasan Absen</span>
                                </div>
                                <select class="form-control" id="id_alasan" name="id_alasan" required>
                                    @foreach ($alasan_absen as $rs => $r)
                                        <option value="{{$r->id_alasan}}">{{$r->alasan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-file">
                                <label class="custom-file-label" for="inputGroupFile03">File Surat</label>
                                <input type="file" class="custom-file-input" id="inputGroupFile03" accept="application/pdf" name="file_surat" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">No Sk</span>
                                </div>
                                <input type="text" class="form-control" id="no_sk" name="no_sk">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
