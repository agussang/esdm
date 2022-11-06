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
                            <h5 class="card-label"><i class="fa fa-list"></i> Riwayat / History Presensi Kehadiran Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')!="P")
                            <a href="{{URL::to('data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                                @if($induk[0]=="pegawai-bawahan")
                                    <a href="{{URL::to('pegawai-bawahan/detil')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @else
                                     <a href="{{URL::to('pegawai/detil')}}/{{Crypt::encrypt($rsData->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if($induk[0]=="pegawai-bawahan")
                <form class="form" action="{{route('pegawai-bawahan.cari.kehadiran')}}" method="post">
                @else
                <form class="form" action="{{route('pegawai.cari.kehadiran')}}" method="post">
                @endif
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
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input type="text" readonly="true" value="{{$rsData->nm_sdm}}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-body">
                <span class="text-dark">Informasi Setting Durasi / Waktu Bekerja<hr/></span>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Masuk</th>
                                <th>Jam Maksimal Terlambat</th>
                                <th>Jam Pulang</th>
                                <th>Jam Maksimal Pulang</th>
                                <th>Durasi Bekerja (Jam)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jam_kerja_unit as $idhari=>$r)
                            <tr>
                                <td>{{$kategoriwaktuabsen[$idhari]}}</td>
                                <td>{{$r['jam_masuk']}}</td>
                                <td>{{$r['masuk_telat']}}</td>
                                <td>{{$r['jam_pulang']}}</td>
                                <td>{{$r['pulang_telat']}}</td>
                                <td>{{$r['lama_kerja']}}</td>
                            </tr>
                            @endforeach
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
                                        <?php $no=1;?>
                                        @foreach($arrData as $tgl=>$presensi)
                                        <?php
                                            $hariabsen = explode(',',$presensi['ket_tgl']);
                                            $jam_masuk = array_shift($presensi['jam_absen']);
                                            $jam_keluar = end($presensi['jam_absen']);
                                            if($jam_keluar==null){
                                                $jam_keluar = $jam_masuk;
                                            }
                                            if($hariabsen[0]=="Jumat"){
                                                $jamkerja = $jam_kerja_unit[2];
                                            }else{
                                                $jamkerja = $jam_kerja_unit[1];
                                            }
                                            $warna = "";$ket = "";
                                            if(end($presensi['jam_absen'])==null){
                                                $warna = "background-color: #F78282;";
                                                $ket = "Absen 1x";
                                            }
                                            $durasi = Fungsi::hitungdurasi($jamkerja['jam_masuk'],$jamkerja['jam_pulang']);
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
                                            
                                            if($gabung < $durasi){
                                                $warna = "background-color: #F78282;";
                                            }
                                            $hari = explode(',',$tanggal);
                                            if($hari[0]=="Minggu" || $hari[0]=="Sabtu"){
                                                $warna = "background-color: #E3CC6D;";
                                            }
                                            $menit = ($gabung*60)+$hasilx[1];
                                            
                                            ?>
                                            <tr style="{{$warna}}">
                                                <td>{{$no++}}</td>
                                                <td>{{$presensi['ket_tgl']}}</td>
                                                <td align="center">{{$jam_masuk}}</td>
                                                <td align="center">{{$jam_keluar}}</td>
                                                <td align="center">{{$gabung}}</td>
                                                <td align="center">{{$menit}}</td>
                                                <td align="center">{{$ket}}</td>
                                            </tr>
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
                                            <th>Ket Justifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $noz=1;?>
                                        @foreach($rekap['tidakmasuk']['list_tgl'] as $tgl=>$presensi)
                                            <?php $nm_tgl = Fungsi::formatDate($thn_bulan."-".$tgl);
                                            $tgl_jus = "";
                                            $alasan_jus = "";
                                            if(count($presensi['justifikasi'])>0){
                                                $tgl_jus = $presensi['justifikasi']['tgl_justifikasi'];
                                                $alasan_jus = $presensi['justifikasi']['alasan'];
                                            }
                                            ?>
                                            <tr>
                                                <td>{{$noz++}}</td>
                                                <td>{{$nm_tgl}}</td>
                                                <td>
                                                    <li>Tgl : {{$tgl_jus}}</li>
                                                    <li>Alasan : {{$alasan_jus}}</li>
                                                </td>
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
                                        <th>Ket</th>
                                        <th>Ket Justifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $noz=1;?>
                                    @foreach($rekap['telat']['list_tglwaktuabsen'] as $tgltlt=>$presensitlt)
                                        <?php $nm_tgltlt = Fungsi::formatDate($thn_bulan."-".$tgltlt);
                                        $ket = "";
                                        if($presensitlt['masuk']==$presensitlt['pulang']){
                                            $ket = "Absen 1x";
                                        }
                                        $tgl_justlt = "";
                                        $alasan_justlt = "";
                                        if(count($presensitlt['justifikasi'])>0){
                                            $tgl_justlt = $presensitlt['justifikasi']['tgl_justifikasi'];
                                            $alasan_justlt = $presensitlt['justifikasi']['alasan'];
                                        }
                                        
                                        ?>
                                        <tr>
                                            <td>{{$noz++}}</td>
                                            <td>{{$nm_tgltlt}}</td>
                                            <td>{{$presensitlt['masuk']}}</td>
                                            <td>{{$presensitlt['pulang']}}</td>
                                            <td>{{$presensitlt['menit']}}</td>
                                            <td>{{$ket}}</td>
                                            <td>
                                                <li>Tgl : {{$tgl_justlt}}</li>
                                                <li>Alasan : {{$alasan_justlt}}</li>
                                            </td>
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
                                        <th>Durasi Pulang Cepat <br/>(Menit)</th>
                                        <th>Ket</th>
                                        <th>Ket Justifikasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $noz=1;?>
                                    @foreach($rekap['pulang_cepat']['list_tglwaktuabsen'] as $tglcpt=>$presensicpt)
                                        <?php $nm_tglx = Fungsi::formatDate($thn_bulan."-".$tglcpt);
                                        $tgl_juscpt = "";
                                        $alasan_juscpt = "";
                                        if(count($presensicpt['justifikasi'])>0){
                                            $tgl_juscpt = $presensicpt['justifikasi']['tgl_justifikasi'];
                                            $alasan_juscpt = $presensicpt['justifikasi']['alasan'];
                                        }
                                        $ketx = "";
                                        if($presensicpt['masuk']==$presensicpt['pulang']){
                                            $ketx = "Absen 1x";
                                        }
                                        ?>
                                        <tr>
                                            <td>{{$noz++}}</td>
                                            <td>{{$nm_tglx}}</td>
                                            <td>{{$presensicpt['masuk']}}</td>
                                            <td>{{$presensicpt['pulang']}}</td>
                                            <td>{{$presensicpt['menit']}}</td>
                                            <td>{{$ketx}}</td>
                                            <td>
                                                <li>Tgl : {{$tgl_juscpt}}</li>
                                                <li>Alasan : {{$alasan_juscpt}}</li>
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