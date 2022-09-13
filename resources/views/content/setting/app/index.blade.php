@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Setting App</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('setting.app.update')}}" method="post">
				{!! csrf_field() !!}
                <input type="hidden" name="id_setting" id="id_setting" value="{{$rsData->id_setting}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Aplikasi</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->nama_aplikasi}}" aria-label="Default" id="nama_aplikasi" name="nama_aplikasi" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Instansi</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->nama_instansi}}" name="nama_instansi" id="nama_instansi" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Fax</span>
                            </div>
                            <input type="number" class="form-control" value="{{$rsData->fax}}" aria-label="Default" id="fax" name="fax" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Tlpn</span>
                            </div>
                            <input type="number" class="form-control" value="{{$rsData->no_tlpn}}" name="no_tlpn" id="no_tlpn" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->email}}" name="email" id="email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Url Facebook</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->facebook}}" id="facebook" name="facebook" aria-label="Default"   aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Url Instagram</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->ig}}" id="ig" name="ig" aria-label="Default"   aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Url Youtube</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->youtube}}" id="youtube" name="youtube" aria-label="Default"   aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Url Website Instansi</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->website_instansi}}" id="website_instansi" name="website_instansi" aria-label="Default"   aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Alamat Instansi</span>
                            </div>
                            <input type="text" class="form-control" value="{{$rsData->alamat_instansi}}" id="alamat_instansi" name="alamat_instansi" aria-label="Default"   aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop