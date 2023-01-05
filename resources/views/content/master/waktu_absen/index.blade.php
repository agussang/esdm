@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Waktu Presensi</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- <span class="text-dark">Form Tambah Data Presensi</span><hr/> --}}
                <form class="form" action="{{route('data-master.waktu-presensi.simpan')}}" method="post">
				{!! csrf_field() !!}
                {{--  <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk</span>
                            </div>
                            <input type="time" class="form-control" aria-label="Default" name="jam_masuk" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang</span>
                            </div>
                            <input type="time" class="form-control" aria-label="Default" name="jam_keluar" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk Telat</span>
                            </div>
                            <input type="time" class="form-control" aria-label="Default" name="masuk_telat" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang Telat</span>
                            </div>
                            <input type="time" class="form-control" aria-label="Default" name="pulang_telat" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary btn-xs pull-right"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>  --}}
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
                                <th>Hari</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Durasi Bekerja</th>
                                <th>Keterangan</th>
                                <th>Aksi ?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($arrData as $idkatkhusus=>$dtidkatkhusus)
                                <?php
                                    $cont = count($dtidkatkhusus);
                                    $n=0;

                                ?>
                                @foreach($dtidkatkhusus as $id_hari_biasa=>$dt_hari_biasa)
                                    @foreach($dt_hari_biasa as $idwaktu=>$dtwaktu)
                                    <tr>
                                        <?php $n++;if($n==1){?>
                                        <td rowspan="{{$cont}}">{{$no++}}</td>
                                        <?php }?>
                                        <td>{{$dtwaktu['ket']}}</td>
                                        <td>{{$dtwaktu['jam_masuk']}}</td>
                                        <td>{{$dtwaktu['jam_keluar']}}</td>
                                        <td>{{$dtwaktu['lama_kerja']}}</td>
                                        <td>{{$ketramahadhan[$idkatkhusus]}}</td>
                                        <td>
                                            <a onclick="edit('<?php echo $idwaktu;?>');" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-white"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
                                        </td>
                                    </tr>
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
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Master Absen</h5>
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
       url : "{{ route('data-master.waktu-presensi.edit') }}",
       data:"id="+id,
       type : "get",
       dataType: "html"
   });
   $('#form-edit').html('Sedang Melakukan Proses Pencarian Data...');
   request.done(function(output) {
       $('#form-edit').html(output);
   });
}
function simpan_edit_waktu()
{
    var x=$('#formku').serialize();
    var request = $.ajax ({
           url : "{{ route('data-master.waktu-presensi.update') }}",
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
