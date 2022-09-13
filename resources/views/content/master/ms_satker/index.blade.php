@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Kerja</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <span class="text-dark">Form Tambah Data Master Unit Kerja</span><hr/>
                <form class="form" action="{{route('data-master.satuan-unit-kerja.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kode Satker</span>
                            </div>
                            <input min="1" type="number" class="form-control" aria-label="Default" name="kode_prodi" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Satker</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="nm_lemb" aria-describedby="inputGroup-sizing-default" required>
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
        <div class="table-responsive">
            <table class="table table-bordered table-md">
                <thead>
                    <tr>    
                        <th>No</th>
                        <th>Kode Unit</th>
                        <th>Nama Unit Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;?>
                    @foreach($unitkerja as $id_sms=>$r)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$r['kode_satker']}}</td>
                            <td>{{$r['nama_satker']}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a onclick="edit('<?php echo $id_sms;?>');" class="dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                        <a class="dropdown-item" href="{{URL::to('data-master/satuan-unit-kerja/hapus')}}/{{Crypt::encrypt($id_sms)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @foreach($child[$id_sms] as $rsidsms=>$rid_sms)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$rid_sms['kode_satker']}}</td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$rid_sms['nama_satker']}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Aksi
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                        <a onclick="edit('<?php echo $rsidsms;?>');" class="dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                        <a class="dropdown-item" href="{{URL::to('data-master/satuan-unit-kerja/hapus')}}/{{Crypt::encrypt($rsidsms)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formku" action="{{route('data-master.satuan-unit-kerja.update')}}" method="post">
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
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('data-master.satuan-unit-kerja.edit') }}",
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
           url : "{{ route('data-master.satuan-unit-kerja.update') }}",
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