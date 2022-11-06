@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="las la-book"></i> Data Master Prilaku</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp.master-skp.prilaku.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kode Indikator</span>
                            </div>
                            <input type="text" class="form-control" readonly="true" name="kode" value="{{count($rsData)+1}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Indikator</span>
                            </div>
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
                                <th>No</th>
                                <th>Kode Indikator</th>
                                <th>Nama Indikator</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$r->kode}}</td>
                                <td>{{$r->nama}}</td>
                                <td>
                                    <div class="custom-control custom-switch custom-switch-text custom-control-inline">
                                        <div class="custom-switch-inner">
                                        <input onChange="aktifkan('{{$r->id}}',$(this))" type="checkbox" class="custom-control-input" id="{{$r->id}}" @if($r->status==1) checked @endif>
                                        <label class="custom-control-label" for="{{$r->id}}" data-on-label="On" data-off-label="Off">
                                        </label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <center>
                                        <a onclick="edit('<?php echo $r->id;?>');" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-white btn-xs"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                        <a href="{{URL::to('/skp/master-skp/prilaku/hapus')}}/{{Crypt::encrypt($r->id)}}" class="btn btn-danger text-white btn-xs" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus</a>
                                    </center>
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
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Prilaku</h5>
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
<script>
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('skp.master-skp.prilaku.edit_prilaku') }}",
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
           url : "{{ route('skp.master-skp.prilaku.update_prilaku') }}",
           type : "post",
           dataType: "html",
           data: x
       });
       request.done(function(output) {
        $('#balik').html(output);
       });
}
function aktifkan(kode,value)
{
    var x=value.prop("checked");
    var request = $.ajax ({
           url : "{{route('skp.master-skp.prilaku.update_status')}}",
           data:"id="+kode+"&status="+x,
           type : "get",
           dataType: "html"
       });
       $('#balik').html('Proses menampilkan data .... ');
       request.done(function(output) {
        $('#balik').html(output);
       });
}
</script>
@stop
        