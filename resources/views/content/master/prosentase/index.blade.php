@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Prosentase Realisasi</h5>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-master.prosentase.simpan')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nilai Prosentase</span>
                                </div>
                                <input type="number" class="form-control" aria-label="Default" max="100" name="nilai" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Kode Realisasi</span>
                                </div>
                                <select class="form-control" name="kode_p">
                                    <option value="1">P1</option>
                                    <option value="2">P2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
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
                                        <th>Kode Realisasi</th>
                                        <th>Prosentase</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>P{{$r->kode_p}}</td>
                                        <td>{{$r->nilai}}</td>
                                        <td>
                                            <a onclick="edit('<?php echo $r->id_prosentase;?>');" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-white"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Prosentase Realisasi</h5>
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
<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('data-master.prosentase.edit') }}",
       data:"id_prosentase="+id,
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
           url : "{{ route('data-master.prosentase.update') }}",
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
