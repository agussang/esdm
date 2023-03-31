@extends('layouts.layout')
@section('content')
<?php
$arrnmbulan = Fungsi::nm_bulan();
$arrStatusJustifikasi = array("1"=>"Disetujui","2"=>"Tidak Disetuji","0"=>"Proses Persetujuan Atasan");
?>
<div class="row">
    <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    <i class="fas fa-list-alt" style="color:red;"></i> <span>Selamat Datang {{Session::get('nama_pengguna')}} di aplikasi E-SDM POLTEKBANG SURABAYA.</span>
                </h4>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-lg-3">
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
                <div class="col-md-6 col-lg-3">
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
                <div class="col-md-6 col-lg-6">
                  <div class="card text-white bg-danger">
                     <div class="card-body">
                        <h4 class="card-title text-white">Periode SKP Aktif</h4>
                        <hr/>
                        <div class="row">
                           <div class="col-md-3">
                               <center><h4 class="mt-2"><span class="badge badge-primary">Bulan</span></h4><h4><hr/>{{$arrBulanPanjang[$periodeaktif->bulan]}}</h4></center>
                           </div>
                           <div class="col-md-3">
                               <center><h4 class="mt-2"><span class="badge badge-primary">Tahun</span></h4><h4><hr/>{{$periodeaktif->tahun}}</h4></center>
                           </div>
                           <div class="col-md-6">
                              <center><h4 class="mt-2"><span class="badge badge-warning">Batas Pengumpulan SKP</span></h4><h4><hr/>{{date('d-m-Y',strtotime($periodeaktif->tgl_batas_skp))}}</h4></center>
                          </div>
                       </div>
                     </div>
                  </div>
                </div>
            </div>
            <div class="row">
               <div class="col-md-6 col-lg-3">
                  <div class="card card-block card-stretch card-height">
                     <div class="card-body bg-info-light rounded">
                        <div class="d-flex align-items-center justify-content-between">
                           <div class="rounded iq-card-icon bg-info"><i class="ri-hospital-line"></i>
                           </div>
                           <div class="text-right">
                              <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="terlambat"></div></span></h2>
                              <h5 class="">Terlambat</h5>
                           </div>
                        </div>
                     </div>
                  </div>
              </div>
               <div class="col-md-6 col-lg-3">
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
               <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                       <div class="card-body bg-success-light rounded">
                          <div class="d-flex align-items-center justify-content-between">
                             <div class="rounded iq-card-icon bg-primary"><i class="ri-user-fill"></i>
                             </div>
                             <div class="text-right">
                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="pulang_cepat"></div></span></h2>
                                <h5 class="">Pulang Cepat</h5>
                             </div>
                          </div>
                       </div>
                    </div>
               </div>
               <div class="col-md-6 col-lg-3">
                    <div class="card card-block card-stretch card-height">
                       <div class="card-body bg-danger-light rounded">
                          <div class="d-flex align-items-center justify-content-between">
                             <div class="rounded iq-card-icon bg-danger"><i class="ri-group-fill"></i>
                             </div>
                             <div class="text-right">
                                <h2 class="mb-0"><span class="counter" style="visibility: visible;"><div id="absen_kehadiran"></div></span></h2>
                                <h5 class="">Absen Kehadiran</h5>
                             </div>
                          </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <span><i class="text-dark">*Nb: Rekap presensi kehadiran yang ditampilkan di halaman ini dimulai dari tanggal 1 {{$arrnmbulan[date('m')]}} {{date('Y')}} Sampai {{$tanggal_terakhir}} {{$arrnmbulan[date('m')]}} {{date('Y')}}</i></span>
                </div>
            </div>
        </div>
    </div>
</div>
@if($info_pegawai->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0")
<div class="row">
    <div class="col-md-6">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <center><h6>Jam Kerja Biasa</h6><hr/><br/></center>
                <div class="row">
                    <div class="col-md-12">
                        <table border=0 cellspacing=0 cellpadding="3" style="font-size:12pt";>
                            <tr>
                                <td class="text-dark">Jam Kerja</td>
                                <td class="text-dark">:</td>
                                <td class="text-dark">{{$jam_kerja_text}}</td>
                            </tr>
                            <tr>
                                <td class="text-dark">Durasi Bekerja</td>
                                <td class="text-dark">:</td>
                                <td class="text-dark">{{$durasi_kerja_text}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-body">
                <center><h6>Jam Kerja Ramadhan</h6><hr/><br/></center>
                <div class="row">
                    <div class="col-md-12">
                        <table border=0 cellspacing=0 cellpadding="3" style="font-size:12pt";>
                            <tr>
                                <td class="text-dark">Jam Kerja</td>
                                <td class="text-dark">:</td>
                                <td class="text-dark">{{$jam_kerja_textramadhan}}</td>
                            </tr>
                            <tr>
                                <td class="text-dark">Durasi Bekerja</td>
                                <td class="text-dark">:</td>
                                <td class="text-dark">{{$durasi_kerja_textramadhan}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <center><h6>Jam Kerja Shift</h6><hr/><br/></center>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered" style="font-size:12pt";>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row">
    <div class="card card-block card-stretch card-height iq-border-box iq-border-box-2 text-warning">
        <div class="card-body">
            <center>
                <span><h4>Riwayat Presensi Fingger 1 {{$arrnmbulan[date('m')]}} {{date('Y')}} Sampai {{$tanggal_terakhir}} {{$arrnmbulan[date('m')]}} {{date('Y')}}</h4></span><hr/>
            </center>
            <div class="table-responsive">
               <table border=0 cellspacing=0 cellpadding="3" style="font-size:12pt";>
                  <thead>
                     <tr>
                        <td class="text-dark">Jumlah Hari</td>
                        <td class="text-dark">:</td>
                        <td class="text-dark">{{count($data_bulan[sprintf("%0d",date('m'))]['list_tgl'])}} hari</td>
                     </tr>
                     <tr>
                        <td class="text-dark">Jumlah Hari Kerja</td>
                        <td class="text-dark">:</td>
                        <td class="text-dark">{{count($data_bulan[sprintf("%0d",date('m'))]['hari_kerja'])}} hari</td>
                     </tr>
                     <tr>
                        <td class="text-dark">Jumlah Hari Libur Nasional</td>
                        <td class="text-dark">:</td>
                        <td class="text-dark">{{count($dt_hari_libur[date('Y')."-".date('m')])}} hari</td>
                     </tr>
                  </thead>
               </table>
               <br/>
               <table class="table table-bordered">
                     <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal</th>
                            <th rowspan="2">Jam Masuk</th>
                            <th rowspan="2">Jam Pulang</th>
                            <th rowspan="2"><center>Durasi Bekerja <br/>(Jam)</center></th>
                            <th rowspan="2"><center>Durasi Bekerja<br/>(Menit)</center></th>
                            <th rowspan="2"><center>Durasi Terlambat<br/>(Menit)</center></th>
                            <th rowspan="2"><center>Durasi Pulang Cepat<br/>(Menit)</center></th>
                            <th rowspan="2"><center>Lembur<br/>(Jam)</center></th>
                            <th rowspan="2">Ket Tanggal</th>
                            <th rowspan="2">Ket</th>
                            @if($info_pegawai->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0")
                            <th rowspan="2">Aksi</th>
                            @endif
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $bulanx = sprintf("%0d", date('m'));
                        $no=1;$tidak_hadir = 0;$hadir = 0;$finger_sekali = 0;$jterlambat=0;$pulang_cepat=0;$absen_kehadiran=0;?>
                        @foreach($data_bulan[$bulanx]['list_tgl'] as $tgl=>$dtgl)
                        <?php
                        $kode_justifikasi = 0;
                        $presensi = $getRekapDataAbsen[$id_sdm][$tgl];
                        $hariabsen = explode(',',$dtgl['tgl']);
                        $jam_masuk = array_shift($presensi['jam_absen']);
                        $jam_keluar = end($presensi['jam_absen']);
                        $ketajuanall = $getajuan_justifikasiall[$id_sdm][$tgl];
                        $prei = $dt_hari_libur[date('Y')."-".date('m')];
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
                        if($info_pegawai->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
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
                        $warna = "";
                        $hitungdurasi_pulang_cepat = 0;
                        if($jam_masuk!=null && $prei[$tgl]==null){
                              if(str_replace(':','',$jam_keluar) < str_replace(':','',$jamkerja['jam_pulang'])){
                                    if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $jam_masuk != "--:--" && $jam_keluar != "--:--"){
                                       if($jam_masuk!=$jam_keluar){
                                          $ket = "Pulang Cepat";
                                          $kode_justifikasi = 3;
                                          $pulang_cepat++;
                                          $hitungdurasi_pulang_cepat = Fungsi::hitungdurasipulangcepat($jam_keluar,$jamkerja['jam_pulang']);
                                       }
                                    }
                              }
                              if($jam_masuk == $jam_keluar && $hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu"){
                                 $ket = "Absen 1x";
                                 $kode_justifikasi = 4;
                                 $finger_sekali++;
                              }

                              if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $info_pegawai->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                                    $hadir++;
                                    if($ket!="Absen 1x"){
                                       $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'],$jam_masuk);
                                       if($hitungdurasi_terlambat>0){
                                          $ket = "Terlambat Datang";
                                          $kode_justifikasi = 2;
                                       }
                                    }
                              }
                              if($info_pegawai->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0" && $jamkerja['kode_jadwal']!="5"){
                                $hadir++;
                                if($ket!="Absen 1x"){
                                    $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'],$jam_masuk);
                                    if($hitungdurasi_terlambat>0){
                                        $ket = "Terlambat Datang";
                                        $kode_justifikasi = 2;
                                    }
                                }
                              }
                              $kategori = "";
                              $durasijustifikasi = "";
                            //   $menitjustifikasi = 0;
                            //   if($presensi['justifikasi']){
                            //      $kategori = $presensi['justifikasi']['kategori_justifikasi'];
                            //      $durasijustifikasi = $presensi['justifikasi']['durasi_justifikasi']." Menit";
                            //      $menitjustifikasi = $presensi['justifikasi']['durasi_justifikasi'];
                            //   }
                        }
                        $absenkehadiran = $getDataAbsen[$id_sdm][$tgl]['alasan_absen'];
                        if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $absenkehadiran==null && $prei[$tgl]==null){
                              if($ket == null && $jam_masuk==null && $jam_keluar==null){
                                 $ket = "Tidak Hadir";
                                 $kode_justifikasi = 3;
                                 $tidak_hadir++;
                                 $warna = "background-color: #F1E780;";
                              }
                        }
                        if($hariabsen[0]=="Minggu" || $hariabsen[0]=="Sabtu" || $dtgl['ket_nasional'] != null){
                            if($info_pegawai->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                               $warna = "background-color: #f9cacb;";
                               $ket = "";
                            }else{
                                $warna = "background-color: #f9cacb;";
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
                        $durasikerja = "00:00:00";$durasikerjamenit = "0";
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
                            }elseif($ketajuan['kategori_justifikasi']=="2"){
                                $menitjustifikasi = $ketajuan['durasi_justifikasi'];
                                $terlambat = $hitungdurasi_terlambat-$menitjustifikasi;
                                if($terlambat==0){
                                    $ket="";
                                }
                            }
                        }
                        if($ket=="Terlambat Datang"){
                            $jterlambat++;
                        }
                        $terlambat = abs($hitungdurasi_terlambat-$menitjustifikasi);
                        $gabung_lembur = 0;
                        $masterdurasikerja = Fungsi::konversiwaktu($durasi);
                        if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu" && $prei[$tgl]==null){
                            if($durasikerja>$durasi){
                                // dikurangi
                                $durasikurangidurasikerja= abs($durasikerjamenit-$masterdurasikerja);
                                if($durasikurangidurasikerja>60){
                                    $jamkel = explode(':',$jamkerja['jam_pulang']);
                                    $jamlembur = -($jamkel[0]-$j_keluar_start);
                                    $menit_lembur = -($jamkel[1]-$menit_keluar_start);
                                    $gabung_lembur = sprintf("%02d", $jamlembur).":".sprintf("%02d", $menit_lembur);
                                }
                            }
                        }else{
                            $gabung_lembur = $durasikerja;
                        }
                        $gabung_lembur = floor($durasikurangidurasikerja / 60).':'.($durasikurangidurasikerja -   floor($durasikurangidurasikerja / 60) * 60);
                        $gabung_lembur = explode(":",$gabung_lembur);
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
                           <td>
                            {{$terlambat}}
                            @if($ketajuan['status']==1)
                                @if($ketajuan['kategori_justifikasi']=="2")
                                    <li style="font-size:10px;color:green">Durasi Terlambat : {{$hitungdurasi_terlambat}}</li>
                                    <li style="font-size:10px;color:green">Durasi Justifikasi : {{$menitjustifikasi}}</li>
                                @endif
                            @endif
                           </td>
                           <td>{{$hitungdurasi_pulang_cepat}}</td>
                           <td>
                            @if($durasikerjamenit>0)
                            {{sprintf("%01d",$gabung_lembur[0])}}
                            @else
                            0 {{$x}}
                            @endif
                           </td>
                           <td style="font-size:11px;">{{$dtgl['ket_nasional']}}</td>
                           <td>{{$ket}}</td>
                           @if($info_pegawai->id_satkernow!="30c82828-d938-42c1-975e-bf8a1db2c7b0")
                           <td>
                              @if($absenkehadiran == null && $ket!=null && date('Ymd')>=date('Ymd',strtotime($tgl)))
                                 @if(str_replace(":","",$durasikerja) >= str_replace(":","",$lama_kerja) || $ket=="Absen 1x")
                                    @if($ketajuan)
                                        {{$arrStatusJustifikasi[$ketajuan['status']]}}
                                    @else
                                        <a href="{{URL::to('justifikasi/pengajuan')}}/{{Session::get('id_sdm')}}/{{$tgl}}/{{$kode_justifikasi}}" class="btn btn-primary">Ajukan Justifikasi</a>
                                    @endif
                                 @else
                                 Tidak bisa diajukan justifikasi
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
document.getElementById("tidak_masuk").innerHTML = "{{$tidak_hadir}}";
document.getElementById("hadir").innerHTML = "{{$hadir}}";
document.getElementById("finger_sekali").innerHTML = "{{$finger_sekali}}";
document.getElementById("terlambat").innerHTML = "{{$jterlambat}}";
document.getElementById("pulang_cepat").innerHTML = "{{$pulang_cepat}}";
document.getElementById("absen_kehadiran").innerHTML = "{{$absen_kehadiran}}";
</script>
@stop
