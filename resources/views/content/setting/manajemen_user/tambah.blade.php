@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Tambah Data Pengguna</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('setting.manajemen-user.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('setting.manajemen-user.simpan')}}" method="post">
				{!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Username</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Default" id="username" name="username" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pengguna</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Default" id="nama_user" name="nama_user" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Email Pengguna</span>
                                </div>
                                <input type="text" class="form-control" aria-label="Default" id="email" name="email" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Role User</span>
                                </div>
                                <select class="form-control" name="id_role" id="id_role" required>
                                    {!!$pilihan_role!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
                                </div>
                                <input type="password" class="form-control" aria-label="Default" id="password" name="password" aria-describedby="inputGroup-sizing-default" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </div>
                </from>
            </div>
        </div>
    </div>
</div>


@stop