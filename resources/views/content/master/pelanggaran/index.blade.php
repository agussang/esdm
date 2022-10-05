@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Master Kategori Pelanggaran</h5>
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
                                <th>Nama Ketagori Pelanggaran</th>
                                <th>% Pengurang</th>
                                <th>Durasi Berlaku<br/>(Bulan)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$r->nama_pelanggaran}}</td>
                                <td>{{$r->prosentase_pengurang}} %</td>
                                <td>{{$r->durasi}} Bulan</td>
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