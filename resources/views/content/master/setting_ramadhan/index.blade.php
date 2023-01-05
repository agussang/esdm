@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Setting Ramadhan</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-master.tanggal-ramadhan.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-master.tanggal-ramadhan.cari')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                                </div>
                                <select class="form-control" name="tahun" required id="tahun">
                                    {!!$pilihan_tahun_presensi!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
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
                                <th rowspan="2">No</th>
                                <th rowspan="2">Tahun</th>
                                <th colspan="2">Tanggal Pelaksanaan Ramadhan</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$r->tahun}}</td>
                                <td>{{date('d-m-Y',strtotime($r->tgl_ramadhan))}}</td>
                                <td>{{date('d-m-Y',strtotime($r->tgl_ramadhan_akhir))}}</td>
                                <td>
                                    <a href="{{URL::to('/data-master/tanggal-ramadhan/edit')}}/{{Crypt::encrypt($r->id_setting)}}" class="btn btn-primary text-white"><i class="fas fa-pencil-ruler text-white"></i> Edit</a>
                                    <a href="{{URL::to('/data-master/tanggal-ramadhan/hapus')}}/{{Crypt::encrypt($r->id_setting)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
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
                <h5 class="modal-title" id="modaledit">Form Edit Data Setting Tanggal Ramadhan</h5>
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
       url : "{{ route('data-master.tanggal-ramadhan.edit') }}",
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
           url : "{{ route('data-master.tanggal-ramadhan.update') }}",
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
