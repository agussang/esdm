@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Alasan Absen</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <span class="text-dark">Form Tambah Data Master Alasan Absen</span><br/><br/>
                <form class="form" action="{{route('data-master.alasan-absen.simpan')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Kode Alasan Absen </span>
                                </div>
                                <input type="text" class="form-control" aria-label="Default" name="kode_lokal" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Alasan Absen</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Default" name="alasan" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                        <div class="col-md-2">
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
                <div class="table-reponsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Alasan Absen</th>
                                <th>Nama Alasan Absen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$r->kode_lokal}}</td>
                                <td>{{$r->alasan}}</td>
                                <td>
                                    <a onclick="edit('<?php echo $r->id_alasan;?>');" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-white"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
                                    <a href="{{URL::to('/data-master/alasan-absen/hapus')}}/{{Crypt::encrypt($r->id_alasan)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Alasan Absen</h5>
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
       url : "{{ route('data-master.alasan-absen.edit') }}",
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
           url : "{{ route('data-master.alasan-absen.update') }}",
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
