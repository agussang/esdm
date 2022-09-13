@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Eselon</h5>
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
                                        <th>Nama Eselon</th>
                                        <th>Tunjangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->namaeselon}}</td>
                                        <td>{{number_format($r->tunjangan)}}</td>
                                        <td>
                                            <a onclick="edit('<?php echo $r->id;?>');" class="btn btn-primary text-white" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler text-white"></i> Edit Tunjangan</a>
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Eselon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formku" action="{{route('data-master.eselon.update')}}" method="post">
				{!! csrf_field() !!}
                    <div id="edit_eselon">
                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('data-master.eselon.edit') }}",
       data:"id="+id,
       type : "get",
       dataType: "html"
   });
   $('#edit_eselon').html('Sedang Melakukan Proses Pencarian Data...');
   request.done(function(output) {
       $('#edit_eselon').html(output);
   });
}
function simpan_edit()
{
    var x=$('#formku').serialize();
    var request = $.ajax ({
           url : "{{ route('data-master.eselon.update') }}",
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