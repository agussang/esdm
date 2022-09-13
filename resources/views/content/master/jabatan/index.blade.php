@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Jabatan</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-master.jabatan.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-master.jabatan.cari')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Jabatan</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="namajabatan" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Grade</span>
                            </div>
                            <select class="form-control" name="id_grade" id="id_grade">
                                {!!$pilihan_grade!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Type Jabatan</span>
                            </div>
                            <select class="form-control" name="tipejabatan" id="tipejabatan">
                                {!!$pilihan_tipe_jabatan!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary pull-right"><i class="fas fa-search"></i> Tampilkan Data</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-reponsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2"><center>Nama Jabatan</center></th>
                                <th rowspan="2"><center>Tipe Jabatan</center></th>
                                <th rowspan="2"><center>Grade</center></th>
                                <th rowspan="2"><center>Job Score</center></th>
                                <th rowspan="2"><center>Job Price</center></th>
                                <th rowspan="2"><center>Tambahan Gaji(P1) <br>30%</center></th>
                                <th rowspan="2"><center>Insentif Kinerja(P3) <br>70%</center></th>
                                <th rowspan="2"><center>Total Remun</center></th>
                                <th colspan="3"><center>Realisasi</center></th>
                                <th rowspan="2"><center>Aksi</center></th>
                            </tr>
                            <tr>
                                <th>P1</th>
                                <th>P2</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$r->namajabatan}}</td>
                                <td>{{$arrTipeJabatan[$r->tipejabatan]}}</td>
                                <td>{{$r->ms_grade->grade}}</td>
                                <td>{{$r->ms_grade->jobscore}}</td>
                                <td>{{$r->ms_grade->jobprice}}</td>
                                <td>{{number_format($r->ms_grade->gaji_p1)}}</td>
                                <td>{{number_format($r->ms_grade->insentif_p2)}}</td>
                                <td>{{number_format($r->ms_grade->total_remun)}}</td>
                                <td>{{number_format($r->ms_grade->realisasi_p1)}}</td>
                                <td>{{number_format($r->ms_grade->realisasi_p2)}}</td>
                                <td>{{number_format($r->ms_grade->total_realisasi)}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                            <a class="dropdown-item" href="{{URL::to('data-master/jabatan/edit')}}/{{Crypt::encrypt($r->id)}}"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                            <a class="dropdown-item" href="{{URL::to('data-master/jabatan/hapus')}}/{{Crypt::encrypt($r->id)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop