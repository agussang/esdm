@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Riwayat / History Presensi Kehadiran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')!="P")
                            <a href="{{URL::to('data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                            <a href="{{URL::to('pegawai')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('pegawai.cari.kehadiran')}}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="id_sdm" id="id_sdm" value="{{$rsData->id_sdm}}">
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
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-body">
                <span class="text-dark">Informasi Setting Durasi / Waktu Bekerja<hr/></span>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jam Masuk</th>
                                <th>Jam Maksimal Terlambat</th>
                                <th>Jam Pulang</th>
                                <th>Jam Maksimal Pulang</th>
                                <th>Durasi Bekerja (Jam)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$jam_kerja_unit->jam_masuk}}</td>
                                <td>{{$jam_kerja_unit->masuk_telat}}</td>
                                <td>{{$jam_kerja_unit->jam_keluar}}</td>
                                <td>{{$jam_kerja_unit->pulang_telat}}</td>
                                <td>{{$jam_kerja_unit->lama_kerja}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-body">
                    <b><p>Data Riwayat Kehadiran Pegawai<hr/></p></b><br/>
                    <ul class="nav nav-tabs" id="myTab-two" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab-two" data-toggle="tab" href="#home-two" role="tab" aria-controls="home" aria-selected="true">Riwayat Kehadiran</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab-two" data-toggle="tab" href="#profile-two" role="tab" aria-controls="profile" aria-selected="false">Tanggal Tidak Hadir</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab-two" data-toggle="tab" href="#contact-two" role="tab" aria-controls="contact" aria-selected="false">Tanggal Kehadiran Terlambat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pulang-tab-two" data-toggle="tab" href="#pulang-two" role="tab" aria-controls="pulang" aria-selected="false">Tanggal Pulang Cepat</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent-1">
                        <div class="tab-pane fade active show" id="home-two" role="tabpanel" aria-labelledby="home-tab-two">
                           <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jam Pulang</th>
                                            <th>Durasi Bekerja <br/>(Jam)</th>
                                            <th>Durasi Bekerja<br/>(Menit)</th>
                                            <th>Ket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($arrAbsen as $id_sdm=>$r)
                                            <?php $no=1;?>
                                            @foreach($r as $tanggal=>$dt)
                                            <?php
                                            $jam_masuk = array_shift($dt);
                                            $jam_keluar = end($dt);
                                            if($jam_keluar==null){
                                                $jam_keluar = $jam_masuk;
                                            }
                                            $warna = "";$ket = "";
                                            if(end($dt)==null){
                                                $warna = "background-color: #F78282;";
                                                $ket = "Absen 1x";
                                            }
                                            $jam_masukex = explode(':',$jam_masuk);
                                            $jam_keluarex = explode(':',$jam_keluar);

                                            $j_masuk_start = $jam_masukex[0];
                                            $menit_masuk_start = $jam_masukex[1];

                                            $j_keluar_start = $jam_keluarex[0];
                                            $menit_keluar_start = $jam_keluarex[1];

                                            $hasil = (intVal($j_keluar_start) - intVal($j_masuk_start)) * 60 + (intVal($menit_keluar_start) - intVal($menit_masuk_start));
                                            $hasil = $hasil / 60;
                                            $hasil = number_format($hasil,2);
                                            $hasilx = explode(".",$hasil);
                                            $depan = sprintf("%02d", $hasilx[0]);
                                            $gabung = $depan.":".$hasilx[1];
                                            $menit = ($gabung*60)+$hasilx[1];
                                            ?>
                                            <tr style="{{$warna}}">
                                                <td>{{$no++}}</td>
                                                <td>{{$tanggal}}</td>
                                                <td>{{$jam_masuk}}</td>
                                                <td>{{$jam_keluar}}</td>
                                                <td>{{$gabung}}</td>
                                                <td>{{$menit}}</td>
                                                <td>{{$ket}}</td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-two" role="tabpanel" aria-labelledby="profile-tab-two">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $noz=1;?>
                                        @foreach($tidakmasuk as $tgl=>$dttgl)
                                        <tr>
                                            <td>{{$noz++}}</td>
                                            <td>{{$dttgl}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact-two" role="tabpanel" aria-labelledby="contact-tab-two">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Fingger Masuk</th>
                                        <th>Waktu Finger Pulang</th>
                                        <th>Durasi Terlambat <br/>(Menit)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nox=1;?>
                                    @foreach($telat as $tgltelat=>$dtterlambat)
                                    <tr>
                                        <td>{{$nox++}}</td>
                                        <td>{{$tgltelat}}</td>
                                        <td>{{$dtterlambat['jam_masuk']}}</td>
                                        <td>{{$dtterlambat['jam_pulang']}}</td>
                                        <td>{{$dtterlambat['durasi']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pulang-two" role="tabpanel" aria-labelledby="pulang-tab-two">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Fingger Masuk</th>
                                        <th>Waktu Finger Pulang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nox=1;?>
                                    @foreach($cepatpulang as $tglcepat=>$dtplngcepat)
                                    <tr>
                                        <td>{{$nox++}}</td>
                                        <td>{{$tglcepat}}</td>
                                        <td>{{$dtplngcepat['jam_masuk']}}</td>
                                        <td>{{$dtplngcepat['jam_pulang']}}</td>
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