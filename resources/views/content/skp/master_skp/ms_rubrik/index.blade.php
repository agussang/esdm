@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Rubrik</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp.master-skp.rubrik.simpan')}}" method="post">
				{!! csrf_field() !!}
                <?php $jml_data = count($rsData)+1;?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kode Rubrik</span>
                            </div>
                            <input type="text" class="form-control" readonly="true" name="kode" value="{{$arrhuruf[$jml_data]}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Indikator</span>
                            </div>
                            <input type="text" class="form-control" name="nama" required>
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
                        <span><i>*Nb: Menghapus data parent akan menghapus turunan indikator skp juga.</i></span>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="15%" colspan="3">Kode</th>
                                        <th width="70%">Nama Rubrik</th>
                                        <th width="5%">Satuan</th>
                                        <th width="15%"><center>Point<br/>( Sks MAK )</center></th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $id_induk_rubrik=>$r)
                                    <tr>
                                        <td colspan="3">{{$r['kode']}}</td>
                                        <td colspan="3">{{$r['nama']}}</td>
                                        <td>
                                            <center>
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-swatchbook"></i> Aksi
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                        <a class="dropdown-item" href="#" onclick="tambah('{{$id_induk_rubrik}}','2');"><i class="fas fa-plus"></i> Tambah </a>
                                                        <a class="dropdown-item" onclick="edit('<?php echo $id_induk_rubrik;?>');" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler"></i> Edit </a>
                                                        <a class="dropdown-item" href="#"><i class="fas fa-trash"></i> Hapus </a>
                                                    </div>
                                                </div>
                                            </center>
                                        </td>
                                    </tr>
                                    <tr id="dua_{{$id_induk_rubrik}}">
                                        <form class="form" action="{{route('skp.master-skp.rubrik.simpan')}}" method="post">
                                        {!! csrf_field() !!}
                                        <td colspan="3">
                                            <input type="hidden" name="idparent" id="idparent" value="{{$id_induk_rubrik}}">
                                            <input type="hidden" name="level" id="level" value="2">
                                            <input type="text" name="kode" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="text" name="nama" class="form-control" required>
                                        </td>
                                        <td>
                                            <select name="idsatuan" class="form-control" id="idsatuan">
                                                {!!$pilihan_satuan_rubrik!!}
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="poin" class="form-control" onkeypress="return goodchars(event,'1234567890.,',this)">
                                        </td>
                                        <td>
                                            
                                            <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i></button>
                                            </form>
                                            <button class="btn btn-danger btn-sm" onclick="cancel('{{$id_induk_rubrik}}','2');"><i class="fas fa-times text-white"></i></button>
                                        </td>
                                    </tr>
                                        @foreach($r['child'] as $id_rubrik=>$dt_rubrik)
                                        <tr>
                                            <td style="background-color:#EEEEEE"></td>
                                            <td colspan="2">{{$dt_rubrik['kode']}}</td>
                                            <td>{{$dt_rubrik['nama']}}</td>
                                            <td>{{$dt_rubrik['satuan']}}</td>
                                            <td>{{$dt_rubrik['point']}}</td>
                                            <td>
                                                <center>
                                                    <div class="btn-group" role="group">
                                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-swatchbook"></i> Aksi
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                            <a class="dropdown-item" onclick="tambah('{{$id_rubrik}}','3');"><i class="fas fa-plus"></i> Tambah </a>
                                                            <a class="dropdown-item" onclick="edit('<?php echo $id_rubrik;?>');" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler"></i> Edit </a>
                                                            <a class="dropdown-item" href="#"><i class="fas fa-trash"></i> Hapus </a>
                                                        </div>
                                                    </div>
                                                </center>
                                            </td>
                                        </tr>
                                        <tr id="tiga_{{$id_rubrik}}">
                                            <form class="form" action="{{route('skp.master-skp.rubrik.simpan')}}" method="post">
                                            {!! csrf_field() !!}
                                            <td style="background-color:#EEEEEE"></td>
                                            <td style="background-color:#EEEEEE">
                                                <input type="hidden" name="idparent" id="idparent" value="{{$id_rubrik}}">
                                                <input type="hidden" name="level" id="level" value="3">
                                            </td>
                                            <td>
                                                <input type="text" name="kode" class="form-control" required>
                                            </td>
                                            <td>
                                                <input type="text" name="nama" class="form-control" required>
                                            </td>
                                            <td>
                                                <select name="idsatuan" class="form-control" id="idsatuan">
                                                    {!!$pilihan_satuan_rubrik!!}
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="poin" class="form-control" onkeypress="return goodchars(event,'1234567890.,',this)">
                                            </td>
                                            <td>
                                                
                                                <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i></button>
                                                </form>
                                                <button class="btn btn-danger btn-sm" onclick="cancel('{{$id_rubrik}}','3');"><i class="fas fa-times text-white"></i></button>
                                            </td>
                                        </tr>
                                            @foreach($dt_rubrik['child'] as $id_rubrik3=>$dt_rubrik3)
                                            <tr>
                                                <td style="background-color:#EEEEEE"></td>
                                                <td style="background-color:#EEEEEE"></td>
                                                <td>{{$dt_rubrik3['kode']}}</td>
                                                <td>{!!$dt_rubrik3['nama']!!}</td>
                                                <td>{{$dt_rubrik3['satuan']}}</td>
                                                <td>{{$dt_rubrik3['point']}}</td>
                                                <td>
                                                    <center>
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-swatchbook"></i> Aksi
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                                <a class="dropdown-item" onclick="tambah('{{$id_rubrik3}}','4');"><i class="fas fa-plus"></i> Tambah </a>
                                                                <a class="dropdown-item" onclick="edit('<?php echo $id_rubrik3;?>');" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler"></i> Edit </a>
                                                                <a class="dropdown-item" href="{{URL::to('/skp/master-skp/rubrik/hapus')}}/{{$id_rubrik3}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus </a>
                                                            </div>
                                                        </div>
                                                    </center>
                                                </td>
                                            </tr>
                                            <tr id="empat_{{$id_rubrik3}}">
                                                <form class="form" action="{{route('skp.master-skp.rubrik.simpan')}}" method="post">
                                                {!! csrf_field() !!}
                                                <td style="background-color:#EEEEEE"></td>
                                                <td style="background-color:#EEEEEE">
                                                    <input type="hidden" name="idparent" id="idparent" value="{{$id_rubrik3}}">
                                                    <input type="hidden" name="level" id="level" value="3">
                                                </td>
                                                <td>
                                                    <input type="text" name="kode" class="form-control" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="nama" class="form-control" required>
                                                </td>
                                                <td>
                                                    <select name="idsatuan" class="form-control" id="idsatuan">
                                                        {!!$pilihan_satuan_rubrik!!}
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="poin" class="form-control" onkeypress="return goodchars(event,'1234567890.,',this)">
                                                </td>
                                                <td>
                                                    
                                                    <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i></button>
                                                    </form>
                                                    <button class="btn btn-danger btn-sm" onclick="cancel('{{$id_rubrik3}}','4');"><i class="fas fa-times text-white"></i></button>
                                                </td>
                                            </tr>
                                                @foreach($dt_rubrik3['child'] as $id_rubrik4=>$dt_rubrik4)
                                                <tr>
                                                    <td style="background-color:#EEEEEE"></td>
                                                    <td style="background-color:#EEEEEE"></td>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$dt_rubrik4['kode']}}</td>
                                                    <td>{!!$dt_rubrik4['nama']!!}</td>
                                                    <td>{{$dt_rubrik4['satuan']}}</td>
                                                    <td>{{$dt_rubrik4['point']}}</td>
                                                    <td>
                                                        <center>
                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-swatchbook"></i> Aksi
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                                    <a class="dropdown-item" onclick="edit('<?php echo $id_rubrik3;?>');" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-pencil-ruler"></i> Edit </a>
                                                                    <a class="dropdown-item" href="{{URL::to('/skp/master-skp/rubrik/hapus')}}/{{$id_rubrik3}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus </a>
                                                                </div>
                                                            </div>
                                                        </center>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
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
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Rubrik SKP</h5>
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
@foreach($rsData as $id_induk_rubrik=>$r)
    $('#dua_{{$id_induk_rubrik}}').hide();
    @foreach($r['child'] as $id_rubrik=>$dt_rubrik)
        $('#tiga_{{$id_rubrik}}').hide();
        @foreach($dt_rubrik['child'] as $id_rubrik3=>$dt_rubrik3)
            $('#empat_{{$id_rubrik3}}').hide();
        @endforeach
    @endforeach
@endforeach
function edit(id)
{
    var request = $.ajax ({
       url : "{{ route('skp.master-skp.rubrik.edit-rubrik') }}",
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
           url : "{{ route('skp.master-skp.rubrik.update_rubrik') }}",
           type : "post",
           dataType: "html",
           data: x
       });
       request.done(function(output) {
        $('#balik').html(output);
       });
}
function tambah(id_induk,level)
{
    if(level==2){
        $('#dua_'+id_induk).show();
    }else if(level==3){
        $('#tiga_'+id_induk).show();
    }else if(level==4){
        $('#empat_'+id_induk).show();
    }
}
function cancel(id_induk,level)
{
   $('#dua_'+id_induk).hide();
   $('#tiga_'+id_induk).hide();
   $('#empat_'+id_induk).hide();
}
</script>
@stop
        