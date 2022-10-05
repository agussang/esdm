@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data Pelanggaran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.pelanggaran.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.pelanggaran.cari')}}" method="post">
                {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                                </div>
                                <select class="form-control" name="tahun" id="tahun" required>
                                    {!!$pilihan_tahun_presensi!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                </div>
                                <input type="text" name="text_cari" id="text_cari" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                        <th rowspan="2">Nama Pegawai</th>
                                        <th rowspan="2">Tgl Mulai Berlaku</th>
                                        <th rowspan="2">Tgl Surat</th>
                                        <th rowspan="2">No Surat</th>
                                        <th colspan="4">Kategori Pelanggaran</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Pelanggaran</th>
                                        <th>Lama Berlaku<br/>(Bulan)</th>
                                        <th>%Pengurang</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <?php
                                    $tgl_surat = "-";
                                    $no_surat = "-";
                                    if($r->tgl_surat){
                                        $tgl_surat = date('d-m-Y',strtotime($r->tgl_berlaku));
                                    }
                                    if($r->no_surat){
                                        $no_surat = $r->no_surat;
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$r->dt_pegawai->nm_sdm}}</td>
                                        <td align="center">
                                            {{date('d-m-Y',strtotime($r->tgl_berlaku))}}<br/>
                                            sampai<br/>
                                            {{date('d-m-Y',strtotime($r->tgl_berakhir))}}
                                        </td>
                                        <td>{{$tgl_surat}}</td>
                                        <td>{{$no_surat}}</td>
                                        <td>{{$r->kategori_pelanggaran->nama_pelanggaran}}</td>
                                        <td>{{$r->kategori_pelanggaran->durasi}} Bulan</td>
                                        <td>{{$r->kategori_pelanggaran->prosentase_pengurang}} %</td>
                                        <td>{{$r->keterangan}}</td>
                                        <td>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-cogs"></i> Aksi
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                <a class="dropdown-item" href="{{URL::to('data-pegawai/pelanggaran/edit')}}/{{Crypt::encrypt($r->id_pelanggaran)}}"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                                <a class="dropdown-item" href="{{URL::to('data-pegawai/pelanggaran/hapus')}}/{{Crypt::encrypt($r->id_pelanggaran)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
@stop