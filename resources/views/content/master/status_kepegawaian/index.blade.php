@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Status Kepegawaian</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-reponsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Status Kepegawaian</th>
                                        <th>Penerima Remun ?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $idx=>$r)
                                    <tr>
                                        <td>{{$r->kode_lokal}}</td>
                                        <td>{{$r->namastatuspegawai}}</td>
                                        <td>
                                            @if($r->isremun==1)
                                                Ya
                                            @else
                                                Tidak
                                            @endif
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
    </div>
</div>

@stop