@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="header-title">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-label"><i class="fas fa-list-alt"></i> Data Pegawai Bawahan</h5>
                            </div>
                            <div class="col-md-3">
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('pegawai-bawahan.cari')}}" method="post">
                    {!! csrf_field() !!}
                    
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
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nama Unit Kerja</th>
                                        <th>Golongan</th>
                                        <th>Jabatan</th>
                                        <th>Presensi Kehadiran</th>
                                        <th>Jumlah Absen</th>
                                        <th>Kehadiran Apel</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;?>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>
                                            {{$r->nm_sdm}}
                                            <br/>
                                            {{$r->nip}}
                                        </td>
                                        <td>{{$r->nm_satker->nm_lemb}}</td>
                                        <td>{{$r->nm_golongan->kode_golongan}}</td>
                                        <td>
                                            <li>Jab. Fungsional : {{$r->nm_jab_fung->namajabatan}}</li>
                                            <li>Jab. Struktural : {{$r->nm_jab_struk->namajabatan}}</li>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                    <a class="dropdown-item" href="{{URL::to('/pegawai-bawahan/detil')}}/{{Crypt::encrypt($r->id_sdm)}}"><i class="fas fa-eye"></i> Lihat Detil</a>
                                                    <a class="dropdown-item" href="#">Justifikasi Kehadiran</a>
                                                    <a class="dropdown-item" href="{{URL::to('/pegawai-bawahan/skp-pegawai')}}/{{Crypt::encrypt($r->id_sdm)}}"><i class="fas fa-user-edit"></i> Nilai Skp</a>
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
            </div>
        </div>
    </div>
</div>
@stop