@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Upload Data Apel</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.apel.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" id="formku" action="{{route('data-pegawai.data-presensi.apel.cari')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Kegiatan</span>
                            </div>
                            <input type="date" name="tgl_kegiatan" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Kegiatan</span>
                            </div>
                            <input type="text" name="cari_kegiatan" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <span><b>Total Data : {!!$totalRecord!!}</b></span>    
                    </div>
                    <div class="col-md-8">
                        {!!$paging!!}
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->nama_kegiatan}}</td>
                                        <td>{{date('Y-m-d',strtotime($r->tgl_kegiatan))}}</td>
                                        <td>{{$r->jam_mulai}}</td>
                                        <td>{{$r->jam_selesai}}</td>
                                        <td>
                                            <li>{{$r->peserta->where('kehadiran','H')->count()}} Hadir</li>
                                            <li>{{$r->peserta->where('kehadiran','T')->count()}} Tidak Hadir</li>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal" onclick="edit('<?php echo $r->id_kegiatan;?>');"><i class="fas fa-pencil-ruler text-warning"></i> Edit</a>
                                                    <a class="dropdown-item" href="{{URL::to('data-pegawai/data-presensi/apel/peserta')}}/{{Crypt::encrypt($r->id_kegiatan)}}"><i class="fas fa-upload text-primary"></i> Upload Presensi Kegiatan</a>
                                                    <a class="dropdown-item" href="{{URL::to('data-pegawai/data-presensi/apel/hapus')}}/{{Crypt::encrypt($r->id_kegiatan)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash text-danger"></i> Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <span><b>Total Data : {!!$totalRecord!!}</b></span>    
                    </div>
                    <div class="col-md-8">
                        {!!$paging!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-xl">
            <div class="modal-header">
                <h5 class="modal-title" id="modaledit">Form Edit Data Kegiatan Apel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formku" action="{{route('data-pegawai.data-presensi.apel.update')}}" method="post">
				{!! csrf_field() !!}
                    <div id="edit_kegiatan">
                    
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
       url : "{{ route('data-pegawai.data-presensi.apel.edit') }}",
       data:"id="+id,
       type : "get",
       dataType: "html"
   });
   $('#edit_kegiatan').html('Sedang Melakukan Proses Pencarian Data...');
   request.done(function(output) {
       $('#edit_kegiatan').html(output);
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