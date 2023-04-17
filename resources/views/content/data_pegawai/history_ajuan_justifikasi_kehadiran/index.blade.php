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
                                <h5 class="card-label"><i class="fas fa-list-alt"></i> Data Justifikasi Kehadiran Pegawai</h5>
                            </div>
                            <div class="col-md-3">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.pengajuan-justifikasi-kehadiran.cari')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Bulan</span>
                                </div>
                                <select class="form-control" name="bln" id="bln" required>
                                    {!!$pilihan_bulan_presensi!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                    <div class="col-md-7"></div>
                    <div class="col-md-5">
                        @foreach($arrStatusJustifikasi as $key1=>$nm_status1)
                        <?php
                        $wrn1 = "primary";
                        if($key1=="2"){
                            $wrn1 = "danger";
                        }
                        if($key1=="0"){
                            $wrn1 = "warning";
                        }
                        ?>
                        <button type="button" class="btn mb-1 btn-{{$wrn1}} btn-xs">
                            {{$nm_status1}} <span class="badge badge-light ml-2 rtl-ml-0 rtl-mr-2">{{(int)$arrRekap[$key1]['jmlh']}}</span>
                        </button>
                        @endforeach
                    </div>
                </div>
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
                                        <th>Pengajuan Justifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;
                                    ?>
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
                                        <td>
                                            @foreach($arrStatusJustifikasi as $key=>$nm_status)
                                            <?php
                                            $wrn = "primary";
                                            if($key=="2"){
                                                $wrn = "danger";
                                            }
                                            if($key=="0"){
                                                $wrn = "warning";
                                            }
                                            ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn mb-1 btn-{{$wrn}} btn-sm">
                                                            {{$nm_status}} <span class="badge badge-light ml-2 rtl-ml-0 rtl-mr-2">{{(int)$getajuan_justifikasi[$r->id_sdm][$key]['jmlh']}}</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{URL::to('/data-pegawai/data-presensi/pengajuan-justifikasi-kehadiran/history')}}/{{Crypt::encrypt($r->id_sdm)}}/{{$bulan}}/{{$tahun}}" class="btn btn-primary btn-xs">Lihat Data</a>
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
