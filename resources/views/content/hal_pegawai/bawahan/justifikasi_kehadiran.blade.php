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
                                <h5 class="card-label"><i class="fas fa-list-alt"></i> Justifikasi Data Kehadiran Pegawai</h5>
                            </div>
                            <div class="col-md-3">
                                <a href="{{route('pegawai-bawahan.pegawai')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Bulan</span>
                            </div>
                            <select class="form-control" name="bln" id="bln" required disabled>
                                {!!$pilihan_bulan_presensi!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                            </div>
                            <select class="form-control" name="tahun" id="tahun" required disabled>
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
                        <div class="alert alert-warning" role="alert">
                           <div class="iq-alert-text">Kehadiran yang dapat di justifikasi adalah yang berjenis kehadiran <b>Terlambat, Pulang Cepat, Tidak Hadir. Data presensi kehadiran yang dijustifikasi akan tersimpan sesuai dengan ketentuan waktu setting presensi yang berlaku.</b></b></div>
                        </div>
                    </div>
                </div>
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
                            <a class="nav-link active" id="profile-tab-two" data-toggle="tab" href="#profile-two" role="tab" aria-controls="profile" aria-selected="false">Tanggal Tidak Hadir <span class="badge badge-danger ml-2 rtl-mr-2 rtl-ml-0">{{count($rekap['tidakmasuk']['list_tgl'])}} Hari</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="contact-tab-two" data-toggle="tab" href="#contact-two" role="tab" aria-controls="contact" aria-selected="false">Tanggal Kehadiran Terlambat <span class="badge badge-danger ml-2 rtl-mr-2 rtl-ml-0">{{count($rekap['telat']['list_tglwaktuabsen'])}} Hari</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pulang-tab-two" data-toggle="tab" href="#pulang-two" role="tab" aria-controls="pulang" aria-selected="false">Tanggal Pulang Cepat <span class="badge badge-danger ml-2 rtl-mr-2 rtl-ml-0">{{count($rekap['pulang_cepat']['list_tgl'])}} Hari</span></a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent-1">
                        <div class="tab-pane fade active show" id="profile-two" role="tabpanel" aria-labelledby="profile-tab-two">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Ket Justifikasi</th>
                                            <th>Justifikasi ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $noz=1;?>
                                        @foreach($rekap['tidakmasuk']['list_tgl'] as $tgl=>$presensi)
                                            <?php $nm_tgl = Fungsi::formatDate($thn_bulan."-".$tgl);
                                            $tgltidakmasuk = $thn_bulan."-".$tgl;
                                            $tgl_jus = "";
                                            $alasan_jus = "";
                                            $kategori = "";
                                            if(count($presensi['justifikasi'])>0){
                                                $tgl_jus = $presensi['justifikasi']['tgl_justifikasi'];
                                                $alasan_jus = $presensi['justifikasi']['alasan'];
                                                $kategori = $presensi['justifikasi']['kategori_justifikasi'];
                                            }
                                            ?>
                                            <tr>
                                                <td>{{$noz++}}</td>
                                                <td>{{$nm_tgl}}</td>
                                                <td>
                                                    <li>Tgl : {{$tgl_jus}}</li>
                                                    <li>Kategori : {{$kategori}}</li>
                                                </td>
                                                <td>
                                                    @if(count($presensi['justifikasi'])<1)
                                                    <a onclick="edit('<?php echo $tgltidakmasuk;?>','{{$id_sdm}}','1');" class="btn btn-primary text-white" data-toggle="modal" data-target=".bd-example-modal-lg">Justifikasi Tidak Masuk</a>
                                                    @endif
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
                                        <th>Waktu Fingger</th>
                                        <th>Durasi Terlambat <br/>(Menit)</th>
                                        <th>Ket</th>
                                        <th>Ket Justifikasi</th>
                                        <th>Justifikasi ?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $noz=1;?>
                                    @foreach($rekap['telat']['list_tglwaktuabsen'] as $tgltlt=>$presensitlt)
                                        <?php $nm_tgltlt = Fungsi::formatDate($thn_bulan."-".$tgltlt);
                                        $tgltelat = $thn_bulan."-".$tgltlt;
                                        $ket = "";
                                        if($presensitlt['masuk']==$presensitlt['pulang']){
                                            $ket = "Absen 1x";
                                        }
                                        $tgl_justlt = "";
                                        $alasan_justlt = "";
                                        $kategoritelat = "";
                                        $durasijustelat = 0;
                                        if(count($presensitlt['justifikasi'])>0){
                                            $tgl_justlt = $presensitlt['justifikasi']['tgl_justifikasi'];
                                            $alasan_justlt = $presensitlt['justifikasi']['alasan'];
                                            $kategoritelat = $presensitlt['justifikasi']['kategori_justifikasi'];
                                            $durasijustelat = $presensitlt['justifikasi']['durasi_justifikasi'];
                                        }
                                        ?>
                                        <tr>
                                            <td>{{$noz++}}</td>
                                            <td>{{$nm_tgltlt}}</td>
                                            <td>
                                                <li>Masuk : {{$presensitlt['masuk']}}</li>
                                                <li>Pulang : {{$presensitlt['pulang']}}</li>
                                            </td>
                                            <td>{{$presensitlt['menit']-$durasijustelat}}</td>
                                            <td>{{$ket}}</td>
                                            <td>
                                                <li>Tgl : {{$tgl_justlt}}</li>
                                                <li>Kategori : {{$kategoritelat}}</li>
                                                <li>Durasi Justifikasi<i>(Menit)</i> : {{$durasijustelat}} Menit</li>
                                            </td>
                                            <td>
                                            @if(count($presensitlt['justifikasi'])<1)
                                            <a onclick="edit('<?php echo $tgltelat;?>','{{$id_sdm}}','2');" class="btn btn-primary text-white" data-toggle="modal" data-target=".bd-example-modal-lg">Justifikasi Terlambat</a></td>
                                            @endif
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
                                        <th>Waktu Fingger</th>
                                        <th>Durasi Bekerja <br/>(Menit)</th>
                                        <th>Ket</th>
                                        <th>Ket Justifikasi</th>
                                        <th>Justifikasi ?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $noz=1;?>
                                    @foreach($rekap['pulang_cepat']['list_tglwaktuabsen'] as $tglcpt=>$presensicpt)
                                        <?php $nm_tglx = Fungsi::formatDate($thn_bulan."-".$tglcpt);
                                        $tglplngcpt = $thn_bulan."-".$tglcpt;
                                        $tgl_juscpt = "";
                                        $alasan_juscpt = "";
                                        $kategoricpt = "";
                                        $durasijuspulang_cpt = 0;
                                        if(count($presensicpt['justifikasi'])>0){
                                            $tgl_juscpt = $presensicpt['justifikasi']['tgl_justifikasi'];
                                            $alasan_juscpt = $presensicpt['justifikasi']['alasan'];
                                            $kategoricpt = $presensicpt['justifikasi']['kategori_justifikasi'];
                                            $durasijuspulang_cpt = $presensicpt['justifikasi']['durasi_justifikasi'];
                                        }
                                        $ketx = "";
                                        if($presensicpt['masuk']==$presensicpt['pulang']){
                                            $ketx = "Absen 1x";
                                        }
                                        ?>
                                        <tr>
                                            <td>{{$noz++}}</td>
                                            <td>{{$nm_tglx}}</td>
                                            <td>
                                                <li>Masuk : {{$presensicpt['masuk']}}</li>
                                                <li>Pulang : {{$presensicpt['pulang']}}</li>
                                            </td>
                                            <td>{{$presensicpt['menit']-$durasijuspulang_cpt}}</td>
                                            <td>{{$ketx}}</td>
                                            <td>
                                                <li>Tgl : {{$tgl_juscpt}}</li>
                                                <li>Kategori : {{$kategoricpt}}</li>
                                                <li>Durasi Justifikasi<i>(Menit)</i> : {{$durasi_pulang_cpt}} Menit</li>
                                            </td>
                                            <td>
                                                @if(count($presensicpt['justifikasi'])<1)
                                                <a onclick="edit('<?php echo $tglplngcpt;?>','{{$id_sdm}}','3');" class="btn btn-primary text-white" data-toggle="modal" data-target=".bd-example-modal-lg">Justifikasi Pulang Cepat</a>
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
    </div>
</div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Justifikasi Kehadiran Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formku" method="post">
				{!! csrf_field() !!}
                    <div id="form-edit">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script>
function edit(tgl,id_sdm,kode)
{
    var request = $.ajax ({
       url : "{{ route('pegawai-bawahan.gen-justifikasi') }}",
       data:"tgl="+tgl+"&id_sdm="+id_sdm+"&kode="+kode,
       type : "get",
       dataType: "html"
   });
   $('#form-edit').html('Sedang Melakukan Proses Pencarian Data...');
   request.done(function(output) {
       $('#form-edit').html(output);
   });
}
function simpan_edit()
{
    var x=$('#formku').serialize();
    var request = $.ajax ({
           url : "{{ route('pegawai-bawahan.save-gen-justifikasi') }}",
           type : "post",
           dataType: "html",
           data: x
       });
       request.done(function(output) {
        $('#balik').html(output);
       });
}
</script>
@stop
