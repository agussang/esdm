@extends('layouts.layout')
@section('content')
<?php
$arrnmbulan = Fungsi::nm_bulan();
$arrStatusJustifikasi = array("1"=>"Disetujui","2"=>"Tidak Disetuji","0"=>"Proses Persetujuan Atasan");
$hour = date('H');
if($hour < 12) $salam = 'Selamat Pagi';
elseif($hour < 15) $salam = 'Selamat Siang';
elseif($hour < 18) $salam = 'Selamat Sore';
else $salam = 'Selamat Malam';
?>

<style>
/* ===== Greeting Banner Pegawai ===== */
.peg-greeting {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}
.peg-greeting::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -15%;
    width: 250px;
    height: 250px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
}
.peg-greeting h3 {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 4px;
}
.peg-greeting p {
    opacity: 0.85;
    margin: 0;
    font-size: 0.88rem;
}

/* ===== Award / Penghargaan ===== */
.award-banner {
    border: none;
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
}
.award-banner .award-header {
    padding: 16px 24px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 0.95rem;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}
.award-juara {
    background: linear-gradient(135deg, #fef9c3 0%, #fde68a 100%);
}
.award-juara .award-header {
    color: #92400e;
}
.award-juara .award-header i { font-size: 1.3rem; }
.award-body {
    padding: 20px 24px;
}
.award-rank-box {
    text-align: center;
    padding: 16px;
}
.award-rank-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-size: 2rem;
}
.award-rank-1 { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; box-shadow: 0 4px 20px rgba(245,158,11,0.35); }
.award-rank-2 { background: linear-gradient(135deg, #d1d5db, #9ca3af); color: #374151; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.award-rank-3 { background: linear-gradient(135deg, #f59e0b, #b45309); color: #fff; box-shadow: 0 4px 15px rgba(180,83,9,0.3); }
.award-rank-other { background: linear-gradient(135deg, #dbeafe, #93c5fd); color: #1e40af; box-shadow: 0 4px 15px rgba(59,130,246,0.2); }
.award-rank-num {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 2px;
}
.award-rank-label {
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 600;
}
.award-jam {
    font-size: 0.85rem;
    color: #64748b;
    margin-top: 4px;
}
.award-jam i { color: #10b981; }
.award-msg {
    font-size: 0.92rem;
    color: #334155;
    line-height: 1.6;
}
.award-msg strong { color: #1e293b; }

/* Top 3 mini podium */
.mini-podium {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px solid rgba(0,0,0,0.06);
}
.mini-podium-item {
    text-align: center;
    width: 120px;
}
.mini-podium-medal {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    margin: 0 auto 6px;
}
.mini-podium-medal.gold { background: linear-gradient(135deg, #fbbf24, #f59e0b); color: #78350f; }
.mini-podium-medal.silver { background: linear-gradient(135deg, #d1d5db, #9ca3af); color: #374151; }
.mini-podium-medal.bronze { background: linear-gradient(135deg, #f59e0b, #b45309); color: #fff; }
.mini-podium-name {
    font-size: 0.72rem;
    font-weight: 700;
    color: #1e293b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.mini-podium-time {
    font-size: 0.68rem;
    color: #64748b;
}

/* Stat cards pegawai */
.peg-stat {
    border: none;
    border-radius: 12px;
    padding: 18px 16px;
    text-align: center;
    transition: transform 0.2s;
    min-height: 100px;
}
.peg-stat:hover { transform: translateY(-3px); }
.peg-stat .peg-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin: 0 auto 10px;
    color: #fff;
}
.peg-stat .peg-stat-val {
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 2px;
}
.peg-stat .peg-stat-sub {
    font-size: 0.7rem;
    color: #64748b;
    font-weight: 600;
}
.peg-stat .peg-stat-lbl {
    font-size: 0.75rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-top: 4px;
}
.bg-stat-hadir { background: #ecfdf5; } .bg-stat-hadir .peg-stat-icon { background: #10b981; } .bg-stat-hadir .peg-stat-val { color: #065f46; }
.bg-stat-absent { background: #fef3c7; } .bg-stat-absent .peg-stat-icon { background: #f59e0b; } .bg-stat-absent .peg-stat-val { color: #92400e; }
.bg-stat-late { background: #dbeafe; } .bg-stat-late .peg-stat-icon { background: #3b82f6; } .bg-stat-late .peg-stat-val { color: #1e40af; }
.bg-stat-finger { background: #f3e8ff; } .bg-stat-finger .peg-stat-icon { background: #8b5cf6; } .bg-stat-finger .peg-stat-val { color: #5b21b6; }
.bg-stat-early { background: #fce7f3; } .bg-stat-early .peg-stat-icon { background: #ec4899; } .bg-stat-early .peg-stat-val { color: #9d174d; }
.bg-stat-absen { background: #fee2e2; } .bg-stat-absen .peg-stat-icon { background: #ef4444; } .bg-stat-absen .peg-stat-val { color: #991b1b; }

/* SKP Card */
.skp-card {
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(239,68,68,0.2);
}
.skp-card .skp-title { font-size: 0.95rem; font-weight: 700; margin-bottom: 12px; }
.skp-card .skp-item { text-align: center; }
.skp-card .skp-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 700;
    background: rgba(255,255,255,0.2);
    margin-bottom: 6px;
}
.skp-card .skp-val { font-size: 1.1rem; font-weight: 700; }

@media (max-width: 768px) {
    .peg-greeting { padding: 18px; }
    .peg-greeting h3 { font-size: 1.1rem; }
    .mini-podium { gap: 8px; }
    .mini-podium-item { width: 90px; }
    .peg-stat { padding: 14px 10px; min-height: auto; }
    .peg-stat .peg-stat-val { font-size: 1.2rem; }
}
</style>

{{-- ===== Greeting ===== --}}
<div class="peg-greeting">
    <h3><i class="ri-hand-heart-line" style="margin-right:8px;"></i>{{ $salam }}, {{ Session::get('nama_pengguna') }}</h3>
    <p>Aplikasi E-SDM Poltekbang Surabaya &mdash; {{ date('l, d F Y') }}</p>
</div>

{{-- ===== Penghargaan Kehadiran Hari Ini ===== --}}
@if($ranking_hari_ini !== null)
<div class="award-banner award-juara">
    <div class="award-header">
        @if($ranking_hari_ini <= 3)
            <i class="ri-trophy-fill" style="color:#f59e0b;"></i> Penghargaan Kehadiran Hari Ini
        @else
            <i class="ri-medal-fill" style="color:#3b82f6;"></i> Kehadiran Hari Ini
        @endif
    </div>
    <div class="award-body">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="award-rank-box">
                    <div class="award-rank-circle {{ $ranking_hari_ini == 1 ? 'award-rank-1' : ($ranking_hari_ini == 2 ? 'award-rank-2' : ($ranking_hari_ini == 3 ? 'award-rank-3' : 'award-rank-other')) }}">
                        @if($ranking_hari_ini <= 3)
                            <i class="ri-trophy-fill"></i>
                        @else
                            <i class="ri-medal-fill"></i>
                        @endif
                    </div>
                    <div class="award-rank-num">#{{ $ranking_hari_ini }}</div>
                    <div class="award-rank-label">dari {{ $total_hadir_hari_ini }} pegawai</div>
                    <div class="award-jam"><i class="ri-time-line"></i> Masuk {{ $jam_masuk_hari_ini }}</div>
                </div>
            </div>
            <div class="col">
                <div class="award-msg">
                    @if($ranking_hari_ini == 1)
                        <strong>Luar biasa! Anda datang paling awal hari ini!</strong><br/>
                        Anda meraih posisi <strong>Juara 1</strong> kehadiran. Dedikasi dan kedisiplinan Anda patut menjadi teladan bagi seluruh pegawai. Tetap pertahankan semangat ini!
                    @elseif($ranking_hari_ini == 2)
                        <strong>Hebat! Anda datang kedua paling awal!</strong><br/>
                        Posisi <strong>Juara 2</strong> hari ini. Kedisiplinan Anda sangat diapresiasi. Terus semangat untuk meraih posisi pertama!
                    @elseif($ranking_hari_ini == 3)
                        <strong>Keren! Anda masuk 3 besar paling awal!</strong><br/>
                        Posisi <strong>Juara 3</strong> hari ini. Konsistensi kehadiran Anda sangat baik. Pertahankan semangat dan kedisiplinan Anda!
                    @elseif($ranking_hari_ini <= 10)
                        <strong>Bagus! Anda termasuk 10 besar yang datang lebih awal.</strong><br/>
                        Posisi ke-<strong>{{ $ranking_hari_ini }}</strong> hari ini. Terus tingkatkan kedisiplinan Anda untuk meraih posisi yang lebih baik!
                    @else
                        <strong>Terima kasih sudah hadir hari ini!</strong><br/>
                        Anda berada di posisi ke-<strong>{{ $ranking_hari_ini }}</strong>. Setiap kehadiran Anda sangat berarti. Semangat bekerja hari ini!
                    @endif
                </div>
                {{-- Mini podium top 3 --}}
                @if(count($juara_top3) > 0)
                <div class="mini-podium">
                    @foreach($juara_top3 as $jt)
                    <div class="mini-podium-item">
                        <div class="mini-podium-medal {{ $jt['ranking'] == 1 ? 'gold' : ($jt['ranking'] == 2 ? 'silver' : 'bronze') }}">
                            <i class="{{ $jt['ranking'] == 1 ? 'ri-trophy-fill' : 'ri-medal-fill' }}"></i>
                        </div>
                        <div class="mini-podium-name" title="{{ $jt['nama'] }}">{{ $jt['nama'] }}</div>
                        <div class="mini-podium-time"><i class="ri-time-line"></i> {{ $jt['jam_masuk'] }}</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

{{-- ===== Stat Cards ===== --}}
<div class="row mb-3">
    <div class="col-6 col-lg-2 mb-3">
        <div class="peg-stat bg-stat-hadir">
            <div class="peg-stat-icon"><i class="ri-user-follow-line"></i></div>
            <div class="peg-stat-val"><span id="hadir">0</span></div>
            <div class="peg-stat-lbl">Kehadiran</div>
        </div>
    </div>
    <div class="col-6 col-lg-2 mb-3">
        <div class="peg-stat bg-stat-absent">
            <div class="peg-stat-icon"><i class="ri-user-unfollow-line"></i></div>
            <div class="peg-stat-val"><span id="tidak_masuk">0</span></div>
            <div class="peg-stat-lbl">Tidak Masuk</div>
        </div>
    </div>
    <div class="col-6 col-lg-2 mb-3">
        <div class="peg-stat bg-stat-late">
            <div class="peg-stat-icon"><i class="ri-alarm-warning-line"></i></div>
            <div class="peg-stat-val"><span id="terlambat">0</span></div>
            <div class="peg-stat-sub"><span id="terlambatmenit"></span></div>
            <div class="peg-stat-lbl">Terlambat</div>
        </div>
    </div>
    <div class="col-6 col-lg-2 mb-3">
        <div class="peg-stat bg-stat-finger">
            <div class="peg-stat-icon"><i class="ri-fingerprint-line"></i></div>
            <div class="peg-stat-val"><span id="finger_sekali">0</span></div>
            <div class="peg-stat-lbl">Finger 1x</div>
        </div>
    </div>
    <div class="col-6 col-lg-2 mb-3">
        <div class="peg-stat bg-stat-early">
            <div class="peg-stat-icon"><i class="ri-run-line"></i></div>
            <div class="peg-stat-val"><span id="pulang_cepat">0</span></div>
            <div class="peg-stat-sub"><span id="pulangepatmenit"></span></div>
            <div class="peg-stat-lbl">Pulang Cepat</div>
        </div>
    </div>
    <div class="col-6 col-lg-2 mb-3">
        <div class="peg-stat bg-stat-absen">
            <div class="peg-stat-icon"><i class="ri-calendar-close-line"></i></div>
            <div class="peg-stat-val"><span id="absen_kehadiran">0</span></div>
            <div class="peg-stat-lbl">Absen Kehadiran</div>
        </div>
    </div>
</div>

{{-- ===== SKP Periode Aktif ===== --}}
<div class="row mb-3">
    <div class="col-lg-12">
        <div class="skp-card p-3">
            <div class="skp-title"><i class="ri-file-list-3-line mr-1"></i> Periode SKP Aktif</div>
            <div class="row">
                <div class="col-4 skp-item">
                    <div class="skp-badge">Bulan</div>
                    <div class="skp-val">{{$arrBulanPanjang[$periodeaktif->bulan]}}</div>
                </div>
                <div class="col-4 skp-item">
                    <div class="skp-badge">Tahun</div>
                    <div class="skp-val">{{$periodeaktif->tahun}}</div>
                </div>
                <div class="col-4 skp-item">
                    <div class="skp-badge">Batas Pengumpulan</div>
                    <div class="skp-val">{{date('d-m-Y',strtotime($periodeaktif->tgl_batas_skp))}}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-md-12">
        <small class="text-muted"><i class="ri-information-line"></i> Rekap presensi: 1 {{$arrnmbulan[date('m')]}} {{date('Y')}} s/d {{$tanggal_terakhir}} {{$arrnmbulan[date('m')]}} {{date('Y')}}</small>
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
                        $no=1;$tidak_hadir = 0;$hadir = 0;$finger_sekali = 0;$jterlambat=0;$pulang_cepat=0;$absen_kehadiran=0;
                        $terlambuatmenit = 0;$pulang_cepatmenit = 0;
                        ?>
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
                                       $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'], $jam_masuk, $jamkerja['jam_pulang'], $jam_keluar); // develop by masgus
                                       if($hitungdurasi_terlambat>0){
                                          $ket = "Terlambat Datang";
                                          $kode_justifikasi = 2;
                                       }
                                    }
                              }
                              if($info_pegawai->id_satkernow=="30c82828-d938-42c1-975e-bf8a1db2c7b0" && $jamkerja['kode_jadwal']!="5"){
                                $hadir++;
                                if($ket!="Absen 1x"){
                                    $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'], $jam_masuk, $jamkerja['jam_pulang'], $jam_keluar); // develop by masgus
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
                        $durasikerja = "00:00";$durasikerjamenit = "0";
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
                                        {{-- develop by masgus - cek kuota kat.4 --}}
                                        @if($kode_justifikasi == 4 && $justifikasiKat4Count >= 2)
                                            <span class="btn btn-secondary disabled" title="Kuota justifikasi lupa absen bulan ini sudah habis (2/2)">Kuota Habis ({{$justifikasiKat4Count}}/2)</span>
                                        @else
                                            <a href="{{URL::to('justifikasi/pengajuan')}}/{{Session::get('id_sdm')}}/{{$tgl}}/{{$kode_justifikasi}}" class="btn btn-primary">Ajukan Justifikasi @if($kode_justifikasi == 4)({{$justifikasiKat4Count}}/2)@endif</a>
                                        @endif
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
<?php
$textterlambat = $terlambuatmenit." ( Menit )";
$textpulangcepat = $pulang_cepatmenit." ( Menit ) ";
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
document.getElementById("tidak_masuk").textContent = "{{$tidak_hadir}}";
document.getElementById("hadir").textContent = "{{$hadir}}";
document.getElementById("finger_sekali").textContent = "{{$finger_sekali}}";
document.getElementById("terlambat").textContent = "{{$jterlambat}}";
document.getElementById("pulang_cepat").textContent = "{{$pulang_cepat}}";
document.getElementById("terlambatmenit").textContent = "{{$textterlambat}}";
document.getElementById("pulangepatmenit").textContent = "{{$textpulangcepat}}";
document.getElementById("absen_kehadiran").textContent = "{{$absen_kehadiran}}";
</script>
@stop
