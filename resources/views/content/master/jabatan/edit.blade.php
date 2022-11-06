@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fas fa-pencil-ruler text-dark"></i> Form Edit Data Master Jabatan</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-master.jabatan')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <div class="iq-alert-text">Perubahan data master jabatan akan berpengaruh ke semua transaksi.</div>
                </div>
                <form class="form" action="{{route('data-master.jabatan.update')}}" method="post">
				{!! csrf_field() !!}
                <input type="hidden" name="id" value="{{$rsData->id}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Jabatan</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="namajabatan" aria-describedby="inputGroup-sizing-default" required value="{{$rsData['namajabatan']}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Grade</span>
                            </div>
                            <select class="form-control" name="id_grade" id="id_grade" required>
                                {!!$pilihan_grade!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Type Jabatan</span>
                            </div>
                            <select class="form-control" name="tipejabatan" id="tipejabatan" required>
                                {!!$pilihan_tipe_jabatan!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Job Score</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->ms_grade->jobscore}}" id="jobscore" aria-label="Default"  readonly= "true" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Job Price</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->ms_grade->jobprice}}" id="jobprice" aria-label="Default" readonly= "true"  aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tambahan Gaji P1</span>
                            </div>
                            <input type="text" class="form-control" value="{{number_format($rsData->ms_grade->gaji_p1)}}" id="p1" aria-label="Default" readonly= "true"  aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Insentif Kinerja P2</span>
                            </div>
                            <input type="text" class="form-control" value="{{number_format($rsData->ms_grade->insentif_p2)}}" id="p2" aria-label="Default" readonly= "true"  aria-describedby="inputGroup-sizing-default" required>
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