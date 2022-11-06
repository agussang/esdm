@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Bank</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-master.bank.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-reponsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Bank</th>
                                <th>Nama Bank</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$r->kode_bank}}</td>
                                <td>{{$r->nama_bank}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop