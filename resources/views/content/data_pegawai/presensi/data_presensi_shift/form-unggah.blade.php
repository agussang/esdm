@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Data Jadwal Presensi Shift</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.jadwal-presensi-shift.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
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
                                <label class="custom-file-label" for="inputGroupFile03">File Excel Jadwal Shift</label>
                                <input type="file" class="custom-file-input" id="inputGroupFile03" name="file_excel" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary"><i class="fas fa-upload"></i> Upload Excel</button>
                            <a class="btn btn-warning" href="{{URL::to('assets/template_excel/template_unggah_excel_presensi_pegawai_shift.xlsx')}}"><i class="fas fa-download"></i> Template Excel</a>
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
