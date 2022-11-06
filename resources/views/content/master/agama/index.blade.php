@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    <i class="fas fa-list-alt"></i> Data Master Agama
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="table-reponsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Agama</th>
                            <th>Nama Agama</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rsData as $rs=>$r)
                        <tr>
                            <td>{{$r->idagama}}</td>
                            <td>{{$r->namaagama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop