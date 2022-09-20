@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Setting Atasan Pegawai</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nama Pegawai</th>
                                        <th rowspan="2">Golongan</th>
                                        <th rowspan="2"><center>Unit Kerja</center></th>
                                        <th rowspan="2"><center>Status <br/>Kepegawaian</center></th>
                                        <th rowspan="2"><center>Atasan Langsung</center></th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->nm_sdm}}<br/>{{$r->nip}}</td>
                                        <td>{{$r->nm_golongan->kode_golongan}}</td>
                                        <td>{{$r->nm_satker->nm_lemb}}</td>
                                        <td>{{$r->stat_kepegawaian->namastatuspegawai}}</td>
                                        <td>{{$r->nm_atasan->nm_sdm}}</td>
                                        <td>
                                            <a class="btn btn-primary text-white" onclick="edit('<?php echo $r->id_sdm;?>');" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
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
                <h5 class="modal-title" id="modaledit">Form Edit Setting Atasan</h5>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}"/>
<script>
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('data-pegawai.atasan-pegawai.edit') }}",
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
           url : "{{ route('data-pegawai.atasan-pegawai.simpan') }}",
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

