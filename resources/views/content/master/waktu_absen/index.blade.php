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
                <span class="text-dark">Form Tambah Data Presensi</span><hr/>
                <form class="form" action="{{route('data-master.waktu-presensi.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
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
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Jam Masuk Telat</th>
                                <th>Jam Pulang Telat</th>
                                <th>Durasi Bekerja</th>
                                {{--  <th>Berlaku ?</th>  --}}
                                <th>Aksi ?</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData as $rs=>$r)
                            <tr>        
                                <td>{{$r->jam_masuk}}</td>
                                <td>{{$r->jam_keluar}}</td>
                                <td>{{$r->masuk_telat}}</td>
                                <td>{{$r->pulang_telat}}</td>
                                <td>{{$r->lama_kerja}}</td>
                                {{--  <td>
                                    <div class="custom-control custom-switch custom-switch-text custom-control-inline">
                                        <div class="custom-switch-inner">
                                        <input onChange="aktifkan('{{$r->id}}',$(this))" type="checkbox" class="custom-control-input" id="{{$r->id}}" @if($r->status_aktif==1) checked @endif>
                                        <label class="custom-control-label" for="{{$r->id}}" data-on-label="On" data-off-label="Off">
                                        </label>
                                        </div>
                                    </div>
                                </td>  --}}
                                <td>
                                    <a href="{{URL::to('data-master/waktu-presensi/hapus')}}/{{Crypt::encrypt($r->id)}}"  onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');" class="btn btn-danger btn-xs"><i class="fas fa-trash text-white"></i></a>
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
<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script>
function aktifkan(kode,value)
{
    var x=value.prop("checked");
    var request = $.ajax ({
           url : "{{route('data-master.waktu-presensi.update')}}",
           data:"id_waktu_absen="+kode+"&status_aktif="+x,
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