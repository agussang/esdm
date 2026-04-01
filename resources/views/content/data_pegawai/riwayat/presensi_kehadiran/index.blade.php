@extends('layouts.layout')
@section('content')
<?php
$induk = explode('/',request()->path());
?>
<?php
$arrnmbulan = Fungsi::nm_bulan();
$arrStatusJustifikasi = array("1"=>"Disetujui","2"=>"Tidak Disetuji","0"=>"Proses Persetujuan Atasan");
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
                @if($rsData->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0")
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Masuk</th>
                                <th>Jam Maksimal Terlambat</th>
                                <th>Jam Pulang</th>
                                <th>Jam Maksimal Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jam_kerja as $idhari=>$r)
                            <tr>
                                <td>{{$kategoriwaktuabsen[$idhari]}}</td>
                                <td>{{$r['jam_masuk']}}</td>
                                <td>{{$r['masuk_telat']}}</td>
                                <td>{{$r['jam_pulang']}}</td>
                                <td>{{$r['pulang_telat']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jamkerjashift as $idshift=>$rshift)
                            <tr>
                                <td>{{$rshift['nm_shift']}}</td>
                                <td>{{$rshift['jam_masuk']}}</td>
                                <td>{{$rshift['jam_pulang']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
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
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="profile-tab-two" data-toggle="tab" href="#profile-two" role="tab" aria-controls="profile" aria-selected="false">Tanggal Tidak Hadir</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab-two" data-toggle="tab" href="#contact-two" role="tab" aria-controls="contact" aria-selected="false">Tanggal Kehadiran Terlambat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pulang-tab-two" data-toggle="tab" href="#pulang-two" role="tab" aria-controls="pulang" aria-selected="false">Tanggal Pulang Cepat</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="myTabContent-1">
                        <div class="tab-pane fade active show" id="home-two" role="tabpanel" aria-labelledby="home-tab-two">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-block card-stretch card-height">
                                       <div class="card-body bg-primary-light rounded">
                                          <div class="d-flex align-items-center justify-content-between">
                                             <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
                                             </div>
                                             <div class="text-right">
                                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="hadir"></div></span></h2>
                                                <h5 class="">Kehadiran</h5>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-block card-stretch card-height">
                                       <div class="card-body bg-warning-light rounded">
                                          <div class="d-flex align-items-center justify-content-between">
                                             <div class="rounded iq-card-icon bg-warning"><i class="ri-women-fill"></i>
                                             </div>
                                             <div class="text-right">
                                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="tidak_masuk"></div></span></h2>
                                                <h5 class="">Tidak Masuk</h5>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card card-block card-stretch card-height">
                                       <div class="card-body bg-info-light rounded">
                                          <div class="d-flex align-items-center justify-content-between">
                                             <div class="rounded iq-card-icon bg-info"><i class="ri-hospital-line"></i>
                                             </div>
                                             <div class="text-right">
                                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="terlambat"></div></span></h2>
                                                <font style="font-size:14px;"><div id="terlambatmenit"></div></font>
                                                <h5 class="">Terlambat</h5>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col-md-6 col-lg-4">
                                    <div class="card card-block card-stretch card-height">
                                       <div class="card-body bg-secondary-light rounded">
                                          <div class="d-flex align-items-center justify-content-between">
                                             <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
                                             </div>
                                             <div class="text-right">
                                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="finger_sekali"></div></span></h2>
                                                <h5 class="">Finger 1 kali</h5>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                               </div>
                               <div class="col-md-6 col-lg-4">
                                    <div class="card card-block card-stretch card-height">
                                       <div class="card-body bg-success-light rounded">
                                          <div class="d-flex align-items-center justify-content-between">
                                             <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
                                             </div>
                                             <div class="text-right">
                                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="pulang_cepat"></div></span></h2>
                                                <font style="font-size:14px;"><div id="pulangepatmenit"></div></font>
                                                <h5 class="">Pulang Cepat</h5>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                               </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                               <tr>
                                                   <th>No</th>
                                                   <th>Tanggal</th>
                                                   <th>Jam Masuk</th>
                                                   <th>Jam Pulang</th>
                                                   <th><center>Durasi Bekerja <br/>(Jam)</center></th>
                                                   <th><center>Durasi Bekerja<br/>(Menit)</center></th>
                                                   <th><center>Durasi Terlambat<br/>(Menit)</center></th>
                                                   <th><center>Durasi Pulang Cepat<br/>(Menit)</center></th>
                                                   <th>Ket Tanggal</th>
                                                   <th>Ket</th>
                                                   @if($rsData->id_satkernow == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                                                   <th>Ket Jadwal Shift</th>
                                                   @endif
                                                   @if($rsData->id_satkernow != "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                                                   <th>Aksi</th>
                                                   @endif

                                               </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               $arrDatacek = array();
                                               $bulanx = $bulan;
                                               $tidak_hadir = 0;
                                               if(count($getDataAbsen[$rsData->id_sdm])>0){
                                                    $tidak_hadir = count($getDataAbsen[$rsData->id_sdm]);
                                                }
                                                $no=1;$hadir = 0;$finger_sekali = 0;$jterlambat=0;$pulang_cepat=0;$absen_kehadiran=0;
                                                $terlambuatmenit = 0;$pulang_cepatmenit = 0;
                                                ?>
                                                @foreach($data_bulan[$bulanx]['list_tgl'] as $tgl=>$dtgl)
                                                <?php

                                                $kode_justifikasi = 0;
                                                $prei = $dt_hari_libur[date('Y-m',strtotime($tgl))];
                                                $presensi = $arrData[$tgl];
                                                $hariabsen = explode(',',$dtgl['tgl']);
                                                $jam_masuk = array_shift($presensi['jam_absen']);
                                                $jam_keluar = end($presensi['jam_absen']);
                                                $ketajuanall = $getajuan_justifikasiall[$rsData->id_sdm][$tgl];
                                                if($ketajuanall){
                                                    if($ketajuanall['kategori_justifikasi']=="4" && $ketajuanall['status']=="1"){
                                                        $jam_masuk = $ketajuanall['jam_masuk'];
                                                        $jam_keluar = $ketajuanall['jam_pulang'];

                                                    }
                                                    $kode_justifikasi = $ketajuanall['kategori_justifikasi'];
                                                }
                                                if($jam_keluar==null){
                                                        $jam_keluar = $jam_masuk;
                                                }
                                                if($arrtglramadhan[$tgl]){
                                                    $idwaktuabsen = $wakturamadhan;
                                                }else{
                                                    $idwaktuabsen = $jam_kerja;
                                                }
                                                if($hariabsen[0]=="Jumat"){
                                                    if($ramadhan[$tgl]){
                                                        $jamkerja = $jam_kerja_ramadhan[2];
                                                        $lama_kerja = $durasibekerja_ramadhan[2]['lama_kerja'];
                                                    }else{
                                                        $jamkerja = $jam_kerja[2];
                                                        $lama_kerja = $durasibekerja[2]['lama_kerja'];
                                                    }

                                                }else{

                                                    if($ramadhan[$tgl]){
                                                        $jamkerja = $jam_kerja_ramadhan[1];
                                                        $lama_kerja = $durasibekerja_ramadhan[1]['lama_kerja'];
                                                    }else{
                                                        $jamkerja = $jam_kerja[1];
                                                        $lama_kerja = $durasibekerja[1]['lama_kerja'];
                                                    }

                                                }
                                                if($rsData->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                                                    $jamkerja = $presensi['msjadwalshift'];
                                                }

                                                $durasi = Fungsi::hitungdurasi($jamkerja['jam_masuk'],$jamkerja['jam_pulang']);
                                                $jam_masukex = explode(':',$jam_masuk);
                                                $jam_keluarex = explode(':',$jam_keluar);

                                                $j_masuk_start = $jam_masukex[0];
                                                $menit_masuk_start = $jam_masukex[1];
                                                $ket = "";
                                                $j_keluar_start = $jam_keluarex[0];
                                                $menit_keluar_start = $jam_keluarex[1];
                                                $gabung = 0;$menit = 0;$hitungdurasi_terlambat = 0;
                                                $warna = "";$kode_justifikasi = 0;
                                                $hitungdurasi_pulang_cepat = 0;
                                                $absenkehadiran = $getDataAbsen[$rsData->id_sdm][$tgl]['alasan_absen'];
                                                if($jam_masuk!=null && $prei[$tgl]==null && $absenkehadiran == null){

                                                        if(str_replace(':','',$jam_keluar) < str_replace(':','',$jamkerja['jam_pulang'])){
                                                            if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $jam_masuk != "--:--" && $jam_keluar != "--:--"){

                                                                if($jam_masuk!=$jam_keluar){
                                                                    $ket = "Pulang Cepat";
                                                                    $pulang_cepat++;
                                                                    $kode_justifikasi = 3;
                                                                    $hitungdurasi_pulang_cepat = Fungsi::hitungdurasipulangcepat($jam_keluar,$jamkerja['jam_pulang']);
                                                                }
                                                            }
                                                        }
                                                        if($jam_masuk == $jam_keluar && $hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu"){
                                                            $ket = "Absen 1x";
                                                            $finger_sekali++;
                                                            $kode_justifikasi = 4;
                                                        }
                                                    //   $hasil = (intVal($j_keluar_start) - intVal($j_masuk_start)) * 60 + (intVal($menit_keluar_start) - intVal($menit_masuk_start));
                                                    //   $hasil = $hasil / 60;
                                                    //   $hasil = number_format($hasil,2);
                                                    //   $hasilx = explode(".",$hasil);
                                                    //   $depan = sprintf("%02d", $hasilx[0]);
                                                    //   $gabung = $depan.":".$hasilx[1];

                                                        <?php // develop by masgus - aturan terlambat baru dengan toleransi 15 menit ?>
                                                        if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $rsData->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                                                            $hadir++;
                                                            if($ket!="Absen 1x"){
                                                                $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'], $jam_masuk, $jamkerja['jam_pulang'], $jam_keluar);
                                                                if($hitungdurasi_terlambat>0){
                                                                    $ket = "Terlambat Datang";
                                                                    $kode_justifikasi = 2;
                                                                }
                                                            }
                                                        }

                                                        if($rsData->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0" && $jamkerja['kode_jadwal']!="5"){
                                                            $hadir++;
                                                            if($ket!="Absen 1x"){
                                                                $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'], $jam_masuk, $jamkerja['jam_pulang'], $jam_keluar);
                                                                if($hitungdurasi_terlambat>0){
                                                                    $ket = "Terlambat Datang";
                                                                    $kode_justifikasi = 2;
                                                                }
                                                            }
                                                        }

                                                        //$menit = ($gabung*60)+$hasilx[1];

                                                        $kategori = "";
                                                        $durasijustifikasi = "";
                                                        $menitjustifikasi = 0;
                                                        if($presensi['justifikasi']){
                                                            $kategori = $presensi['justifikasi']['kategori_justifikasi'];
                                                            $durasijustifikasi = $presensi['justifikasi']['durasi_justifikasi']." Menit";
                                                            $menitjustifikasi = $presensi['justifikasi']['durasi_justifikasi'];
                                                        }
                                                }

                                                if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $prei[$tgl]==null && $absenkehadiran == null){
                                                        if($ket == null && $jam_masuk==null && $jam_keluar==null){
                                                            $ket = "Tidak Hadir";
                                                            $tidak_hadir++;
                                                            $warna = "background-color: #F1E780;";

                                                        }
                                                }
                                                if($hariabsen[0]=="Minggu" || $hariabsen[0]=="Sabtu" || $dtgl['ket_nasional'] != null){
                                                        $warna = "background-color: #f9cacb;";
                                                        $ket = "";
                                                }
                                                if($rsData->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                                                    if($hariabsen[0]=="Minggu" || $hariabsen[0]=="Sabtu" || $dtgl['ket_nasional'] != null){
                                                        if($jamkerja['nm_shift']!="Libur"){
                                                            $warna = "";
                                                            $ket = "";
                                                        }
                                                    }

                                                    if($hariabsen[0]!="Sabtu" || $hariabsen[0]!="Minggu"){
                                                        if($jamkerja['nm_shift']=="Libur" && $jam_masuk==null && $jam_keluar==null ){
                                                            $warna = "background-color: #f9cacb;";
                                                            $ket = "";
                                                        }
                                                    }
                                                }
                                                if($jam_masuk == null){
                                                        $jam_masuk = "--:--";
                                                }
                                                if($jam_keluar == null){
                                                        $jam_keluar = "--:--";
                                                }


                                                if($absenkehadiran!=null){
                                                    $absen_kehadiran++;
                                                    $ket = $absenkehadiran['kode_alasan'];
                                                    $warna = "background-color: #F1E780;";
                                                    $hitungdurasi_terlambat = "0";
                                                    $hitungdurasi_pulang_cepat = 0;
                                                }

                                                $durasikerja = "00:00";$durasikerjamenit = "0"; // develop by masgus - tanpa detik
                                                if($jam_masuk!="--:--" && $jam_keluar!="--:--"){
                                                    $jamawal = $tgl." ".$jam_masuk;
                                                    $jamakhir = $tgl." ".$jam_keluar;
                                                    $durasikerja = Fungsi::durasikerja($jamawal,$jamakhir);
                                                    $durasikerjamenit = Fungsi::konversiwaktu($durasikerja);
                                                }
                                                $tglajuanabsenjus = date('d',strtotime($tgl));
                                                $ketajuan = $getajuan_justifikasi[$tgl][$kode_justifikasi];
                                                $ket_masuk = "";$ket_keluar = "";$menitjustifikasi=0;

                                                if($ketajuan['status']==1){
                                                    if($ketajuan['kategori_justifikasi']=="4"){
                                                        if($ketajuan['ket_justifikasi']=="jam_masuk"){
                                                            $ket_masuk = "ajuan justifikasi";
                                                        }
                                                        if($ketajuan['ket_justifikasi']=="jam_pulang"){
                                                            $ket_keluar = "ajuan justifikasi";
                                                        }
                                                    }
                                                    // develop by masgus - justifikasi keterlambatan (kategori 2) dihapus
                                                }

                                                if($ket=="Terlambat Datang"){
                                                    $jterlambat++;
                                                }
                                                $terlambat = abs($hitungdurasi_terlambat); // develop by masgus - tanpa justifikasi terlambat
                                                $terlambuatmenit+=$terlambat;
                                                $pulang_cepatmenit+=$hitungdurasi_pulang_cepat;

                                                ?>
                                                <tr style="{{$warna}}">
                                                    <td>{{$no++}}</td>
                                                    <td>{{$dtgl['tgl']}}</td>
                                                    <td>{{$jam_masuk}}<br/>
                                                        <i style="font-size:10px;"><p style="color:green">{{$ket_masuk}}</a></i>
                                                    </td>
                                                    <td>{{$jam_keluar}}<br/>
                                                    <i style="font-size:10px;"><p style="color:green">{{$ket_keluar}}</a></i>
                                                    </td>
                                                    <td>{{$durasikerja}}</td>
                                                    <td>{{$durasikerjamenit}}</td>
                                                    {{-- develop by masgus - hapus info justifikasi terlambat dari kolom --}}
                                                    <td>
                                                        {{$terlambat}}
                                                    </td>
                                                    <td>{{$hitungdurasi_pulang_cepat}}</td>
                                                    <td style="font-size:11px;">{{$dtgl['ket_nasional']}}</td>
                                                    <td>{{$ket}}</td>
                                                    @if($rsData->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0")
                                                        <td>
                                                            {{$jamkerja['nm_shift']}}
                                                        </td>
                                                    @endif
                                                    @if($rsData->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0")
                                                    <td>
                                                        {{-- develop by masgus - hide justifikasi untuk keterlambatan (kode 2) --}}
                                                        @if($kode_justifikasi == 2)
                                                            {{-- Keterlambatan tidak dapat dijustifikasi --}}
                                                        @elseif($absenkehadiran == null && $ket!=null && date('Ymd')>=date('Ymd',strtotime($tgl)))
                                                            @if(str_replace(":","",$durasikerja) >= str_replace(":","",$lama_kerja) || $ket=="Absen 1x")
                                                                @if($ketajuan)
                                                                    {{$arrStatusJustifikasi[$ketajuan['status']]}}
                                                                    {{-- develop by masgus - tampilkan kuota kat.4 --}}
                                                                    @if($ketajuan['kategori_justifikasi']=="4")
                                                                        <br/><small class="text-muted">({{$justifikasiKat4Count}}/2 kuota bulan ini)</small>
                                                                    @endif
                                                                @else
                                                                    {{-- develop by masgus - cek kuota kat.4 sebelum tampilkan tombol --}}
                                                                    @if($kode_justifikasi == 4 && $justifikasiKat4Count >= 2)
                                                                        <span class="btn btn-secondary disabled" title="Kuota justifikasi lupa absen bulan ini sudah habis (2/2)">Kuota Habis ({{$justifikasiKat4Count}}/2)</span>
                                                                    @else
                                                                        <a href="{{URL::to('pegawai/justifikasi-kehadiran-pegawai')}}/{{$rsData->id_sdm}}/{{$tgl}}/{{$kode_justifikasi}}" class="btn btn-primary">Justifikasi @if($kode_justifikasi == 4)({{$justifikasiKat4Count}}/2)@endif</a>
                                                                    @endif
                                                                @endif
                                                            @elseif($hitungdurasi_pulang_cepat>0 and !$ketajuan)
                                                                <a href="{{URL::to('pegawai/justifikasi-kehadiran-pegawai')}}/{{$rsData->id_sdm}}/{{$tgl}}/{{$kode_justifikasi}}" class="btn btn-primary">Justifikasi</a>
                                                            @else
                                                            Tidak bisa dijustifikasi
                                                            @endif
                                                        @endif
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="tab-pane fade" id="profile-two" role="tabpanel" aria-labelledby="profile-tab-two">
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
                        </div> --}}
                        {{-- <div class="tab-pane fade" id="contact-two" role="tabpanel" aria-labelledby="contact-tab-two">
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
                        </div> --}}
                        {{-- <div class="tab-pane fade" id="pulang-two" role="tabpanel" aria-labelledby="pulang-tab-two">
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
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$textterlambat = $terlambuatmenit." ( Menit )";
$textpulangcepat = $pulang_cepatmenit." ( Menit ) ";
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
document.getElementById("tidak_masuk").innerHTML = "{{$tidak_hadir}}";
document.getElementById("hadir").innerHTML = "{{$hadir}}";
document.getElementById("finger_sekali").innerHTML = "{{$finger_sekali}}";
document.getElementById("terlambat").innerHTML = "{{$jterlambat}}";
document.getElementById("pulang_cepat").innerHTML = "{{$pulang_cepat}}";
document.getElementById("terlambatmenit").innerHTML = "{{$textterlambat}}";
document.getElementById("pulangepatmenit").innerHTML = "{{$textpulangcepat}}";
document.getElementById("absen_kehadiran").innerHTML = "{{$absen_kehadiran}}";
</script>
@stop
