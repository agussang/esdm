@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Data Jadwal Presensi Shift</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.jadwal-presensi-shift.import-jadwal')}}" class="btn btn-danger"><i class="fas fa-upload"></i> Unggah Jadwal Presensi Shift</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.jadwal-presensi-shift.search')}}" method="post">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal</span>
                            </div>
                            <input class="form-control" aria-label="Default" type="text" name="daterange" value="{{$tgl1}} - {{$tgl2}}" required aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
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
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Pegawai</th>
                                <th rowspan="2">Tanggal</th>
                                <th colspan="2">Data Shift</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Kode Shift</th>
                                <th>Nama Shift</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$no++}}</td>
                                <td><b>{{$r->dt_pegawai->nm_sdm}}</b><br/>Nip:{{$r->dt_pegawai->nip}}</td>
                                <td>{{date('d-m-Y',strtotime($r->tanggal_absen))}}</td>
                                <td>{{$r->dtwaktuabsen->kode_shift}}</td>
                                <td>{{$r->dtwaktuabsen->nm_shift}}</td>
                                <td>
                                    <a onclick="edit('<?php echo $r->id_jadwal_shift;?>');" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-white"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<script>
$('input[name="dates"]').daterangepicker();
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>
@stop
