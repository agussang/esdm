@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-9">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="header-title">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-9">
                                <h5 class="card-label"><i class="fas fa-list-alt"></i> Data Pengisian Penilaian Prilaku Dan Sasaran Kinerja Pegawai</h5>
                            </div>
                            <div class="col-md-3">
                                @if(Session::get('level')!="P")
                                    <a href="{{URL::to('data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($dtpegawai->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp-pegawai.skp.cari')}}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="id_sdm" id="id_sdm" value="{{$dtpegawai->id_sdm}}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                                </div>
                                <select class="form-control" id="tahun" name="tahun">
                                    {!!$pilihan_tahun_skp!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button href="" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
                        </div>
                    </div><hr/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                                </div>
                                <input type="text" value="{{$dtpegawai->nm_sdm}}" readonly="true" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Nip Pegawai</span>
                                </div>
                                <input type="text" value="{{$dtpegawai->nip}}" readonly="true" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Batas Pengumpulan SKP</span>
                                </div>
                                <input type="text" value="{{date('d-m-Y',strtotime($periodeaktif->tgl_batas_skp))}}" readonly="true" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
                <br/>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-block card-stretch card-height">
            <div class="card-body light rounded">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <center><span><h4 class="text-white">Periode Aktif Pengisian Skp dan Prilaku Pegawai</h4></span><hr/></center>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <center><h2 class="mt-2"><span class="badge badge-primary">Bulan</span></h2><h4><hr/>{{$arrBulanPanjang[$periodeaktif->bulan]}}</h4></center>
                    </div>
                    <div class="col-md-6">
                        <center><h2 class="mt-2"><span class="badge badge-primary">Tahun</span></h2><h4><hr/>{{$periodeaktif->tahun}}</h4></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <span>Informasi Atasan Penilai<hr/></span>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Atasan Langsung</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$dtpegawai->nm_atasan->nm_sdm}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card bg-warning">
            <div class="card-body">
                <div class="col-md-12">
                    <ul>Ketentuan Disiplin Pengumpulan SKP Point Pengurang E-Remun:
                        <li>Terlambat lebih dari 5 hari kerja point remun dikurangi 3% pada setiap periode pengisian skp</li>
                        <li>Terlambat lebih dari 10 hari kerja point remun dikurangi 10% pada setiap periode pengisian skp</li>
                        <li>Penentuan point pengurang e-remun dilihat berdasarkan tanggal pengumpulan skp dan batas tanggal pengumpulan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <span><b>Data Pengisian Prilaku dan Sasaran Kinerja Pegawai Tahun {{$tahun}}</b></span>
                    </div>
                    <div class="col-md-4">
                        @if($periodeaktif->tahun==$tahun)
                            <a href="{{URL::to('/skp-pegawai/skp/isi')}}/{{Crypt::encrypt($periodeaktif->id)}}/{{Crypt::encrypt($dtpegawai->id_sdm)}}" class="btn btn-primary pull-right"><i class="fas fa-pencil-ruler text-white"></i> Isi / Edit Nilai Prilaku Dan Skp</a>
                        @endif
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <span><i class="text-dark">Nb: Nilai skp dan prilaku hanya dapat diisi pada periode aktif saja, dan dapat diubah ketika belum tervalidasi.</i></span>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th colspan="2">Periode SKP</th>
                                        <th colspan="5">Realisasi SKP</th>
                                        <th rowspan="2">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th>Nama Bulan</th>
                                        <th>Tanggal Batas Pengumpulan</th>
                                        <th>NilaiSkp</th>
                                        <th>File Skp</th>
                                        <th>Status Validasi</th>
                                        <th>Point Pengurang</th>
                                        <th>Justifikasi Atasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;?>
                                    @foreach($rsData as $rs=>$r)
                                    <?php
                                    $dtrekap = $arrRekapskp[$r->bulan];
                                    $point = "100";
                                    $ket = "Belum mengumpulkan.";
                                    if($dtrekap['created_at']!=null && $dtrekap['point_disiplin']>0){
                                        $point = $dtrekap['point_disiplin'];
                                        $ket = $dtrekap['ket_disiplin'];
                                    }else if($dtrekap['created_at']!=null && $dtrekap['point_disiplin']<1){
                                        $point = "0";
                                        $ket = "Sudah dinilai";
                                    }
                                    if($dtrekap['nilai_skp']==null && $dtrekap['created_at']!=null){
                                        $ket = "Belum dinilai.<br/>".$dtrekap['ket_disiplin'];
                                    }
                                    if($dtrekap['ket_justifikasi']){
                                        $point = "0";
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$arrBulanPanjang[$r->bulan]}}</td>
                                        <td>{{date('d-m-Y',strtotime($r->tgl_batas_skp))}}</td>
                                        {{-- <td>{{$dtrekap['nilai_perilaku']}}</td> --}}
                                        <td>{{$dtrekap['nilai_skp']}}</td>
                                        <td>
                                            @if($dtrekap['file_skp'])
                                            <a href="{{URL::to('assets/file_bukti_skp')}}/{{$dtrekap['file_skp']}}" target="_blank" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat File Skp</a>
                                            <br/><span>{{$dtrekap['created_at']}}</span>
                                            @endif
                                        </td>
                                        <td align="center">
                                        @if($dtrekap)
                                            @if($dtrekap['validasi']!=1)
                                                <span class="badge badge-danger">Belum Tervalidasi</span>
                                            @else
                                                <span class="badge badge-success">Valid</span><br/>
                                                <span>
                                                    {{$dtrekap['validated_at']}}
                                                </span>
                                            @endif
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
                                            @if($dtrekap['ket_justifikasi'])
                                            <a href="#" class="mt-2 badge badge-primary" data-trigger="hover" data-toggle="popover" data-content="{{$dtrekap['ket_justifikasi']}}">Ya</a>
                                            @else
                                            <a href="#" class="mt-2 badge badge-danger">Tidak</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($dtrekap)
                                            <a href="{{URL::to('/skp-pegawai/skp/isi')}}/{{Crypt::encrypt($dtrekap['idperiode'])}}/{{Crypt::encrypt($dtpegawai->id_sdm)}}" class="btn btn-primary"><i class="fas fa-eye text-white"></i> Lihat</a>
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
@stop
