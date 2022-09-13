@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data SKP dan Prilaku</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp.data-skp.cari')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Bulan</span>
                                </div>
                                <select class="form-control" id="bulan" name="bulan">
                                    {!!$pilihan_bulan_skp!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                                </div>
                                <select class="form-control" id="tahun" name="tahun">
                                    {!!$pilihan_tahun_skp!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama / Nip Pegawai</span>
                                </div>
                                <input type="text" name="text_cari" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button href="" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
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
                                <th rowspan="2">Nip / Nama</th>
                                <th colspan="2"><center>Atasan</center></th>
                                <th colspan="4"><center>SKP Dan Prilaku</center></th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Pendamping</th>
                                <th>Langsung</th>
                                <th>Skp</th>
                                <th>Prilaku</th>
                                <th>Disetujui</th>
                                <th>File Skp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rsData as $rs=>$r)
                            <?php
                            $dtnilai_skp = $arrrekapnilai[$r->id_sdm];
                            ?>
                            <tr>
                                <td>
                                    <b>{{$r->nm_sdm}}</b><br/>
                                    {{$r->nip}}
                                </td>
                                <td>{{$r->nm_atasan->nm_sdm}}</td>
                                <td>{{$r->nm_atasan_pendamping->nm_sdm}}</td>
                                <td>{{$dtnilai_skp['nilai_skp']}}</td>
                                <td>{{$dtnilai_skp['nilai_perilaku']}}</td>
                                <td align="center">
                                    @if($dtnilai_skp)
                                        @if($dtnilai_skp['validasi']!=1)
                                            <span class="badge badge-danger">Belum Tervalidasi</span>
                                        @else
                                            <span class="badge badge-success">Valid</span><br/>
                                            <span>
                                                {{$dtnilai_skp['validated_at']}}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td align="center">
                                    @if($dtnilai_skp['file_skp'])
                                        <a href="{{URL::to('assets/file_bukti_skp')}}/{{$dtnilai_skp['file_skp']}}" target="_blank"><i class="fas fa-file-pdf" style="font-size:50px;"></i></a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{URL::to('skp-pegawai/skp/detil-skp')}}/{{Crypt::encrypt($dtnilai_skp['idperiode'])}}/{{Crypt::encrypt($r->id_sdm)}}" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Lihat</a>
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

@stop
        