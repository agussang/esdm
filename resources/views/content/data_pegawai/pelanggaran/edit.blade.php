@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Tambah Data Pelanggaran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.pelanggaran.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.pelanggaran.update')}}" method="post" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" value="{{$rsData->id_pelanggaran}}" name="id_pelanggaran">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                </div>
                                <select class="form-control" name="id_sdm" id="id_sdm" required disabled>
                                    {!!$pilihan_sdm!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Ketagori Pelanggaran</span>
                                </div>
                                <select class="form-control" name="id_kategori_pelanggaran" id="id_kategori_pelanggaran" required>
                                    {!!$pilihan_pelanggaran!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tgl Mulai Berlaku</span>
                                </div>
                                <input type="date" class="form-control" name="tgl_berlaku" id="tgl_berlaku" required value="{{$rsData->tgl_berlaku}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1"> Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="3">{{$rsData->keterangan}}</textarea>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <i class="text-danger">*Nb: No surat , tgl surat, file surat boleh kosong.</i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tgl Surat</span>
                                </div>
                                <input type="date" class="form-control" name="tgl_surat" id="tgl_surat" value="{{$rsData->tgl_surat}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">No Surat</span>
                                </div>
                                <input type="text" class="form-control" name="no_surat" id="no_surat" value="{{$rsData->no_surat}}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="custom-file">
                                        <label class="custom-file-label" for="inputGroupFile03">File Surat</label>
                                        <input type="file" class="custom-file-input" id="inputGroupFile03" accept="application/pdf" id="file_surat" name="file_surat">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if($rsData->file_surat)
                                    <a href="{{URL::to('assets/file_pelanggaran')}}/{{$rsData->file_surat}}" target="_blank"><i class="fas fa-file-pdf text-danger" style="font-size:30px;"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop