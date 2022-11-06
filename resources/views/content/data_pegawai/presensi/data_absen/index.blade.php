@extends('layouts.layout')
@section('content')
<?php
$disabled = "";
{{--  if(Session::get('level')=="P" && ){
    $disabled = "disabled";
}  --}}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="las la-keyboard"></i> Data Absen Kehadiran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')=="P" && Session::get('id_sdm_atasan')==Session::get('id_sdm'))
                                <a href="{{route('data-presensi.data-absen.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                            @else
                                <a href="{{route('data-pegawai.data-presensi.data-absen.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(Session::get('level')=="P" && Session::get('id_sdm_atasan')==Session::get('id_sdm'))
                <form class="form" id="formku" action="{{route('data-presensi.data-absen.cari')}}" method="post">
                @else
                <form class="form" id="formku" action="{{route('data-pegawai.data-presensi.data-absen.cari')}}" method="post">
                @endif
				{!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                </div>
                                <select class="form-control" id="id_sdm" name="id_sdm" {{$disabled}}>
                                        {!!$pilihan_sdm!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Mulai Absen</span>
                                </div>
                                <input type="date" class="form-control" name="tgl_awal" value="{{Session::get('tgl_awal')}}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Berakhir Absen</span>
                                </div>
                                <input type="date" class="form-control" name="tgl_akhir" value="{{Session::get('tgl_akhir')}}" required>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Alasan Absen</span>
                                </div>
                                <select class="form-control" id="id_alasan" name="id_alasan">
                                        {!!$pilihan_alasan_absen!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-primary pull-right"><i class="fas fa-search"></i> Tampilkan Data</button>
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
                                        <th>Nip</th>
                                        <th>Nama Pegawai</th>
                                        <th>Tanggal Absen</th>
                                        <th>Jmlh Absen<br/>(Hari)</th>
                                        <th>Alasan</th>
                                        <th>File Bukti</th>
                                        <th>Setujui?</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->dt_pegawai->nip}}</td>
                                        <td>{{$r->dt_pegawai->nm_sdm}}</td>
                                        <td align="center">{{date('d-m-Y',strtotime($r->tgl_awal))}} <br/>Sampai<br/> {{date('d-m-Y',strtotime($r->tgl_akhir))}}</td>
                                        <td align="center">{{$r->lama_hari}}<br/>(hari)</td>
                                        <td align="center">{{$r->alasan->alasan}}</td>
                                        <td align="center">
                                            <a href="{{URL::to('assets/file_bukti_absen')}}/{{$r->file_bukti}}" target="_blank"><i class="fas fa-file-pdf" style="font-size:50px;"></i></a>
                                        </td>
                                        <td align="center">
                                            <?php
                                                $setujui = "<span class=\"badge badge-warning\">Belum Disetujui</span>";
                                                if($r->is_valid==1){
                                                    $setujui = "<span class=\"badge badge-success\">Disetujui</span>";
                                                }else if($r->is_valid==2){
                                                    $setujui = "<span class=\"badge badge-warning\">Tidak Disetujui</span>";
                                                }
                                            ?>
                                            {!!$setujui!!}
                                            @if($r->is_valid!=null)
                                                <br/>
                                                {{date('d-m-Y H:i:s',strtotime($r->tgl_verifikasi))}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($r->is_valid!=1)
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                    @if(Session::get('level')!="P" || Session::get('id_sdm_atasan')!=Session::get('id_sdm'))
                                                        <a class="dropdown-item" href="{{URL::to('/data-pegawai/data-presensi/data-absen/verifikasi')}}/{{Crypt::encrypt($r->id_absen)}}"><i class="fas fa-check"></i> Verifikasi</a>
                                                        <a class="dropdown-item" href="{{URL::to('/data-pegawai/data-presensi/data-absen/edit')}}/{{Crypt::encrypt($r->id_absen)}}"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                                        <a class="dropdown-item" href="{{URL::to('/data-pegawai/data-presensi/data-absen/hapus')}}/{{Crypt::encrypt($r->id_absen)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus</a>
                                                    @else
                                                        <a class="dropdown-item" href="{{URL::to('/data-absen/edit')}}/{{Crypt::encrypt($r->id_absen)}}"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                                        <a class="dropdown-item" href="{{URL::to('/data-absen/hapus')}}/{{Crypt::encrypt($r->id_absen)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus</a>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
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