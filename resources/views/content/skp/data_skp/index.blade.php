@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Data SKP dan Prilaku</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp.data-skp.cari')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Bulan</span>
                                </div>
                                <select class="form-control" id="bulan" name="bulan">
                                    {!!$pilihan_bulan_skp!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                                </div>
                                <select class="form-control" id="tahun" name="tahun">
                                    {!!$pilihan_tahun_skp!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama / Nip Pegawai</span>
                                </div>
                                <input type="text" name="text_cari" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button href="" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
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
                <div calss="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            <span>
                                <ul>Ketentuan Disiplin Pengumpulan SKP Point Pengurang E-Remun:
                                    <li>Terlambat lebih dari 5 hari kerja point remun dikurangi 3% pada setiap periode pengisian skp</li>
                                    <li>Terlambat lebih dari 10 hari kerja point remun dikurangi 100% pada setiap periode pengisian skp</li>
                                    <li>Penentuan point pengurang e-remun dilihat berdasarkan tanggal pengumpulan skp dan batas tanggal pengumpulan</li>
                                </ul>
                                <ul>
                                    <li>NB : Skp dapat dinilai oleh atasan pegawai ketika file skp sudah diunggah oleh pegawai. File skp yang sudah dinilai dan divalidasi tidak bisa diubah kembali.</li>
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>
                <div calss="row">
                    <div class="col-md-12">
                        <table>
                            <tr>
                                <td >Skp Terisi</td>
                                <td >: </td>
                                <td ><div id="terisi"></div></td>
                            </tr>
                            <tr><td>Skp Belum Terisi</td>
                                <td>: </td>
                                <td><div id="belumterisi"></div></td>
                            </tr>
                            <tr>
                                <td>Skp Belum Dinilai</td>
                                <td>: </td>
                                <td><div id="sudahdiisibelumdinilai"></div></td>
                            </tr>
                            <tr>
                                <td>Skp Sudah Dinilai</td>
                                <td>: </td>
                                <td><div id="sudahdinilai"></div></td>
                            </tr>
                            <tr>
                                <td>Batas Pengumpulan Skp</td>
                                <td>: </td>
                                <td><i><b>{{date('d-m-Y',strtotime($periode_skp->tgl_batas_skp))}}</b></i></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pengurang remun 3%</td>
                                <td>: </td>
                                <td><i><b>{{date('d-m-Y',strtotime($periode_skp->tgl_potongan3persen))}}</b></i></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nip / Nama</th>
                                <th rowspan="2"><center>Atasan Langsung</center></th>
                                <th colspan="6"><center>Realisasi SKP</center></th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Tanggal Unggah SKP</th>
                                <th>Nilai Realisasi</th>
                                <th>Disetujui</th>
                                <th>File Skp</th>
                                <th>Point Pengurang</th>
                                <th>Justifikasi?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;$terisi = 0;$belumterisi=0;$sudahdiisibelumdinilai=0;$sudahdinilai=0;?>
                            @foreach($rsData as $rs=>$r)
                            <?php
                            $dtnilai_skp = $arrrekapnilai[$r->id_sdm];
                            $point = "100";
                            $ket = "Belum mengumpulkan.";
                            if($dtnilai_skp['created_at']!=null && $dtnilai_skp['point_disiplin']>0){
                                $point = $dtnilai_skp['point_disiplin'];
                                $ket = $dtnilai_skp['ket_disiplin'];
                            }else if($dtnilai_skp['created_at']!=null && $dtnilai_skp['point_disiplin']<1){
                                $point = "0";
                                $ket = "Sudah dinilai";
                            }
                            if($dtnilai_skp['nilai_skp']==null && $dtnilai_skp['created_at']!=null){
                                $ket = "Belum dinilai.<br/>".$dtnilai_skp['ket_disiplin'];
                                $sudahdiisibelumdinilai++;
                            }
                            if($dtnilai_skp!=null){
                                $terisi++;
                            }
                            if($dtnilai_skp==null){
                                $belumterisi++;
                            }
                            if($dtnilai_skp['nilai_skp']){
                                $sudahdinilai++;
                            }
                            ?>
                            <tr>
                                <td>{{$no++}}</td>
                                <td>
                                    <b>{{$r->nm_sdm}}</b><br/>
                                    {{$r->nip}}
                                </td>
                                <td>{{$r->nm_atasan->nm_sdm}}</td>
                                <td>{{$dtnilai_skp['created_at']}}</td>
                                <td>{{$dtnilai_skp['nilai_skp']}}</td>
                                <td align="center">
                                    @if($dtnilai_skp)
                                        @if($dtnilai_skp['validasi']!=1)
                                            <span class="badge badge-danger">Belum Tervalidasi</span>
                                        @else
                                            <span class="badge badge-success">Valid</span><br/>
                                            <span>
                                                {{$dtnilai_skp['validated_at']}}
                                            </span>
                                        @endif
                                    @endif
                                </td>
                                <td align="center">
                                    @if($dtnilai_skp['file_skp'])
                                        <a href="{{URL::to('assets/file_bukti_skp')}}/{{$dtnilai_skp['file_skp']}}" target="_blank"><i class="fas fa-file-pdf" style="font-size:50px;"></i></a>
                                    @endif
                                </td>
                                <td align="center">
                                    <span>
                                        {{$point}} %<br/>
                                        <i style="font-size:10px;">
                                            {!!$ket!!}
                                        </i>
                                    </span>
                                </td>
                                <td align="center">
                                    @if($dtnilai_skp['ket_justifikasi'])
                                    <a href="#" class="mt-2 badge badge-primary" data-trigger="hover" data-toggle="popover" data-content="{{$dtnilai_skp['ket_justifikasi']}}">Ya</a>
                                    @else
                                    <a href="#" class="mt-2 badge badge-danger">Tidak</a>
                                    @endif
                                </td>
                                <td>
                                    @if($dtnilai_skp)
                                    <?php $text = "Lihat";
                                    if(Session::get('atasan_penilai')==1){
                                        $text = "Nilai";
                                    }
                                    ?>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                            <a class="dropdown-item" href="{{URL::to('skp/data-skp/penilaian-skp')}}/{{Crypt::encrypt($dtnilai_skp['idperiode'])}}/{{Crypt::encrypt($r->id_sdm)}}" ><i class="fas fa-eye"></i> {{$text}}</a>
                                            @if($dtnilai_skp['nilai_skp'])
                                                @if(Session::get('level')=='A')
                                                <a class="dropdown-item" href="{{URL::to('skp-pegawai/skp/reset-skp')}}/{{Crypt::encrypt($dtnilai_skp['idperiode'])}}/{{Crypt::encrypt($r->id_sdm)}}" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-sync"></i> Reset Penilaian</a>
                                                @endif
                                            @endif
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Justifikasi SKP Pegawai</h5>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
document.getElementById("terisi").innerHTML = "{{$terisi}} Pegawai";
document.getElementById("belumterisi").innerHTML = "{{$belumterisi}} Pegawai";
document.getElementById("sudahdiisibelumdinilai").innerHTML = "{{$sudahdiisibelumdinilai}} Pegawai";
document.getElementById("sudahdinilai").innerHTML = "{{$sudahdinilai}} Pegawai";
</script>
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

</script>
@stop
