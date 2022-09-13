@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Pendidikan</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-md">
                        <thead>
                            <tr>    
                                <th>No</th>
                                <th>Nama Pendidikan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$r->urutan}}</td>
                                <td>{{$r->namapendidikan}}</td>
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