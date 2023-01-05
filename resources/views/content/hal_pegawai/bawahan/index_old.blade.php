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
                    <div class="col-md-12">
                        <a href="#" class="btn btn-warning pull-right">Jumlah hari kerja bulan agustus : {{$dt_rekap_absen['jmabsen']}} Hari </a>
                    </div>
                </div><br/>
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
                                    <?php $no=1;
                                    ?>
                                    @foreach($rsData as $rs=>$r)
                                    <?php
                                    $rekappresensi = $getRekapDataAbsen[$r->id_sdm][$tahun.$bulan];
                                    ?>
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
                                            <ul>
                                                <li style="font-size:12px;">Masuk <br/><b>( {{(int)$rekappresensi['masuk']['total']}} Hari)</b></li>
                                                <li style="font-size:12px;">Telat <br/><b>( {{(int)$rekappresensi['telat']['total']}} Menit)</b></li>
                                                <li style="font-size:12px;">Pulang Cepat <br/><b>({{(int)$rekappresensi['pulang_cepat']['total']}} Menit)</b></li>
                                                <li style="font-size:12px;">Absen Sekali <br/><b>( {{(int)$rekappresensi['absensekali']['total']}} Hari)</b></li>
                                                <li style="font-size:12px;">Tidak Masuk <br/><b>( {{(int)$rekappresensi['tidakmasuk']['total']}} Hari)</b></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                @foreach($rekappresensi['absen'] as $id_alasan=>$dtalasan)
                                                    @if($dtalasan && $dtalasan['data']['total'])
                                                        <li style="font-size:12px;">{{$dtalasan['nm_alasan']}} <br/><b>({{$dtalasan['data']['total']}} Hari)</b></li>
                                                    @endif
                                                @endforeach
                                             </ul>
                                        </td>
                                        <td>
                                            <ul>
                                                <li style="font-size:12px;">Hadir <br/><b>({{(int)$rekappresensi['dt_apel']['hadir']}} Kegiatan)</b></li>
                                                <li style="font-size:12px;">Tidak Hadir <br/><b>({{(int)$rekappresensi['dt_apel']['tidak_hadir']}} Kegiatan)</b></li>
                                             </ul>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Aksi
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                    {{--  <a class="dropdown-item" href="{{URL::to('/pegawai-bawahan/detil')}}/{{Crypt::encrypt($r->id_sdm)}}"><i class="fas fa-eye"></i> Lihat Detil</a>  --}}
                                                    <a class="dropdown-item" href="{{URL::to('/pegawai-bawahan/justifikasi')}}/{{Crypt::encrypt($r->id_sdm)}}/{{Crypt::encrypt($bulan)}}/{{Crypt::encrypt($tahun)}}"><i class="fas fa-calendar"></i> Justifikasi Kehadiran</a>
                                                    <a class="dropdown-item" href="{{URL::to('/pegawai-bawahan/justifikasi-apel')}}/{{Crypt::encrypt($r->id_sdm)}}/{{Crypt::encrypt($bulan)}}/{{Crypt::encrypt($tahun)}}"><i class="fas fa-tag"></i> Justifikasi Apel</a>
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