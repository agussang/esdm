@extends('layouts.layout')
@section('content')
<?php
$induk = explode('/',request()->path());
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Riwayat / History Data Absen</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')!="P")
                            <a href="{{URL::to('data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                                @if($induk[0]=="pegawai-bawahan")
                                    <a href="{{URL::to('pegawai-bawahan/detil')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @else
                                    <a href="{{URL::to('pegawai/detil')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($induk[0]=="pegawai-bawahan")
                <form class="form" action="{{route('pegawai-bawahan.cari.absen')}}" method="post">
                @else
                <form class="form" action="{{route('pegawai.cari.absen')}}" method="post">
                @endif
                {!! csrf_field() !!}
                <input type="hidden" name="id_sdm" id="id_sdm" value="{{$id_sdm}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                            </div>
                            <select class="form-control" name="tahun" id="tahun" required>
                                {!!$pilihan_tahun_absen!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input type="text" readonly="true" value="{{$dt_pegawai->nm_sdm}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
                        <a href="{{route('pegawai.riwayat-absen.tambah')}}" class="btn btn-warning pull-right"><i class="fas fa-plus"></i> Tambah Data</a>
                    </div>
                </div>
                </from>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span><i>*Nb: Data ditampilkan dalam 1 tahun.</i></span>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Absen</th>
                                <th>Lama Hari</th>
                                <th>Alasan / Keterangan</th>
                                <th>File Surat</th>
                                <th>Status Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$no++}}</td>
                                <td align="center">{{Fungsi::formatDate($r->tgl_awal)}}<br/><b>Sampai</b><br/>{{Fungsi::formatDate($r->tgl_akhir)}}</td>
                                <td>{{$r->lama_hari}} Hari</td>
                                <td>{{$r->r_alasan->alasan}}</td>
                                <td>
                                    @if($r->file_bukti!=null)
                                    <a href="{{URL::to('assets/file_bukti_absen')}}/{{$r->file_bukti}}" target="_blank"><i class="fas fa-file-pdf" style="font-size:50px;"></i></a>
                                    @else
                                    File Tidak ada.
                                    @endif
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
                                                <a class="dropdown-item" href="{{URL::to('/data-pegawai/data-presensi/data-absen/edit')}}/{{Crypt::encrypt($r->id_absen)}}"><i class="fas fa-pencil-ruler"></i> Edit</a>
                                                <a class="dropdown-item" href="{{URL::to('/data-pegawai/data-presensi/data-absen/hapus')}}/{{Crypt::encrypt($r->id_absen)}}" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ? ');"><i class="fas fa-trash"></i> Hapus</a>
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
    </div>
</div>

@stop
