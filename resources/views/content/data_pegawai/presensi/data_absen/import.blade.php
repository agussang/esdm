@extends('layouts.layout')
@section('content')
<form class="form" action="{{route('data-pegawai.data-presensi.data-absen.import-simpan')}}" method="post" enctype="multipart/form-data">
    {!! csrf_field() !!}
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Import Excel Data Absen Kehadiran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">FILE EXCEL DATA ABSEN KEHADIRAN PEGAWAI</label>
                            <input type="file" class="custom-file-input" id="inputGroupFile03"  required name="file">
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <a href="{{URL::to('assets/template_excel/template_unggah_absen_kehadiran_pegawai.xlsx')}}" class="btn btn-primary"><i class="fas fa-file"></i> Download Template</a>
                            <button class="btn btn-warning"><i class="fas fa-save"></i> Import</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@stop
