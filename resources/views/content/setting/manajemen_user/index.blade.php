@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Manajemen User</h5>
                        </div>
                        <div class="col-md-4">
                            @if(Session::get('level')=="SA" || Session::get('level')=="A")
                                <a href="{{route('setting.manajemen-user.re-index-user')}}" class="btn btn-danger"><i class="fas fa-plus"></i> Re-Index User Pegawai</a>
                            @endif
                            <a href="{{route('setting.manajemen-user.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('setting.manajemen-user.cari')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Username / Nama</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" id="text_user" name="text_user" aria-describedby="inputGroup-sizing-default">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Hak Akses</span>
                            </div>
                            <select class="form-control" name="id_role" id="id_role">
                                {!!$pilihan_role!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
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
                <div class="row">
                    <div class="col-md-4">
                        <span><b>Total Data : {!!$totalRecord!!}</b></span>    
                    </div>
                    <div class="col-md-8">
                        {!!$paging!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama User</th>
                                        <th>Role User</th>
                                        <th>Aktif?</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->username}}</td>
                                        <td>{{$r->nama_user}}</td>
                                        <td>{{$r->roleuser->nama_role}}</td>
                                        <td>
                                            <div class="custom-control custom-switch custom-switch-text custom-control-inline">
                                                <div class="custom-switch-inner">
                                                <input onChange="aktifkan('{{$r->id_user}}',$(this))" type="checkbox" class="custom-control-input" id="{{$r->id_user}}" @if($r->is_aktif==1) checked @endif>
                                                <label class="custom-control-label" for="{{$r->id_user}}" data-on-label="On" data-off-label="Off">
                                                </label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cogs"></i> Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                    <a class="dropdown-item" href="{{URL::to('setting/manajemen-user/edit')}}/{{Crypt::encrypt($r->id_user)}}"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                                    <a class="dropdown-item" href="{{URL::to('setting/manajemen-user/hapus')}}/{{Crypt::encrypt($r->id_user)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Delete</a>
                                                    <hr/>
                                                    <a class="dropdown-item" href="{{URL::to('login-as')}}/{{Crypt::encrypt($r->id_user)}}"><i class="fas fa-key"></i> Login As</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br/><br/><br/><br/>
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

<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script>
function aktifkan(kode,value)
{
    var x=value.prop("checked");
    var request = $.ajax ({
           url : "{{route('setting.manajemen-user.update_status')}}",
           data:"id_user="+kode+"&is_aktif="+x+"&statment="+1,
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