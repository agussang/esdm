@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Grade</h5>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-master.grade.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Grade</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="grade" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">N.Jabatan ( Job Score )</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="jobscore" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">PIR ( Job Price )</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="jobprice" aria-describedby="inputGroup-sizing-default" required>
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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Grade</th>
                                        <th rowspan="2">Nilai Jabatan <br/>(Job Score)</th>
                                        <th rowspan="2">Pir <br>(Job Price)</th>
                                        <th>Tambahan Gaji <br/>(P1)</th>
                                        <th>Insentif Kinerja <br/>(P2)</th>
                                        <th rowspan="2">Total Remun</th>
                                        <th>Realisasi <br>(P1)</th>
                                        <th>Realisasi <br>(P2)</th>
                                        <th rowspan="2">Total Realisasi</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>30%</th>
                                        <th>70%</th>
                                        <th>
                                            <select class="form-control" onchange="update_nilai_prosentase_p1(this)">
                                                {!!$pilihan_prosentase_realisasi_p1!!}
                                            </select>%
                                        </th>
                                        <th>
                                            <select class="form-control" onchange="update_nilai_prosentase_p2(this)">
                                                {!!$pilihan_prosentase_realisasi_p2!!}
                                            </select>%
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->grade}}</td>
                                        <td>{{$r->jobscore}}</td>
                                        <td>{{number_format($r->jobprice)}}</td>
                                        <td>{{number_format($r->gaji_p1)}}</td>
                                        <td>{{number_format($r->insentif_p2)}}</td>
                                        <td>{{number_format($r->total_remun)}}</td>
                                        <td>{{number_format($r->realisasi_p1)}}</td>
                                        <td>{{number_format($r->realisasi_p2)}}</td>
                                        <td>{{number_format($r->total_realisasi)}}</td>
                                        <td>
                                            <a onclick="edit('<?php echo $r->id;?>');" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-white"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
                                            <a href="{{URL::to('data-master/grade/hapus')}}/{{Crypt::encrypt($r->id)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
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
    </div>
</div>
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Grade</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formku" method="post">
				{!! csrf_field() !!}
                    <div id="form-edit">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
function update_nilai_prosentase_p1(selectObject){
    var id_prosentase = selectObject.value;
    var request = $.ajax ({
           url : "{{ route('data-master.grade.update_realisasi_p1') }}",
           type : "post",
           dataType: "html",
           data: "id_prosentase="+id_prosentase
       });
       request.done(function(output) {
        $('#balik').html(output);
       });
}
function update_nilai_prosentase_p2(selectObject){
    var id_prosentase = selectObject.value;
    var request = $.ajax ({
           url : "{{ route('data-master.grade.update_realisasi_p2') }}",
           type : "post",
           dataType: "html",
           data: "id_prosentase="+id_prosentase
       });
       request.done(function(output) {
        $('#balik').html(output);
       });
}
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('data-master.grade.edit') }}",
       data:"id="+id,
       type : "get",
       dataType: "html"
   });
   $('#form-edit').html('Sedang Melakukan Proses Pencarian Data...');
   request.done(function(output) {
       $('#form-edit').html(output);
   });
}
function simpan_edit()
{
    var x=$('#formku').serialize();
    var request = $.ajax ({
           url : "{{ route('data-master.grade.update') }}",
           type : "post",
           dataType: "html",
           data: x
       });
       request.done(function(output) {
        $('#balik').html(output);
       });
}
</script>
@stop
