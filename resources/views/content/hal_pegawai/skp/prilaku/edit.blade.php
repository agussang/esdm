@extends('layouts.layout')
@section('content')
<?php
$cek_file=0;
$readonly = "";
if($rekap_skp){
    if($rekap_skp->validasi==1){
        $cek_file = 1;
        $readonly = "readonly=\"true\"";
    }
}
if(Session::get('atasan_penilai')==null){
    $readonly = "readonly=\"true\"";
}

$induk = explode('/',request()->path());
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-label"><i class="fas fa-plus"></i> Form Pengisian Data SPK dan Perilaku </h5>
                        </div>
                        <div class="col-md-6">
                            @if(Session::get('level')=="P")
                            <a href="{{URL::to('/skp-pegawai/skp')}}/{{Crypt::encrypt($dtpegawai->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                                @if($induk[2]=="detil-skp")
                                    <a href="{{route('skp.data-skp.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @else

                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$dtpegawai->nm_sdm}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Atasan Langsung</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$dtpegawai->nm_atasan->nm_sdm}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Bulan Penilaian</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$arrBulan[$periodeaktif->bulan]}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun Penilaian</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$periodeaktif->tahun}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($cek_file==0)
<div class="row">
    <div class="col-md-12">
        <form class="form" action="{{route('skp-pegawai.skp.unggah_skp')}}" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <input type="hidden" value="{{$dtpegawai->id_sdm}}" name="id_sdm" id="id_sdm">
        <input type="hidden" value="{{$dtpegawai->nip}}" name="nip" id="nip">
        <input type="hidden" value="{{$periodeaktif->id}}" name="idperiode" id="idperiode">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <span><b>Form Unggah File SKP dan Prilaku</b></span>
                        </center>
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">File pdf SKP dan Prilaku</label>
                            <input type="file" class="custom-file-input" id="inputGroupFile03" accept="application/pdf" id="file_skp" name="file_skp" required>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning" role="alert">
                           <div class="iq-alert-text">
                                <ul>
                                    <span>Ketentuan Unggah File :</span>
                                    <li>Format File .pdf</li>
                                    <li>Ukuran maksimal 2 Mb</li>
                                    <li>File yang di unggah adalah file yang telah di tanda tangani oleh atasan langsung dan pendamping.</li>
                                    <li>File dapat diubah ketika berstatus belum terverfikasi oleh atasan.</li>
                                </ul>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary"><i class="fas fa-upload"></i> Unggah File</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endif
@if($rekap_skp)
    @if($rekap_skp->file_skp)
        <div class="row">
            <div class="col-md-12">
                <form class="form" action="{{route('skp-pegawai.skp.simpan')}}" method="post">
                {!! csrf_field() !!}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <span><b>Nilai Realisasi Sasaran Kinerja Pegawai</b></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Nilai Realisasi Skp</span>
                                    </div>
                                    <input type="text" id="nilai_skp" name="nilai_skp" class="form-control" aria-label="Default" value="{{$rekap_skp->nilai_skp}}" aria-describedby="inputGroup-sizing-default" required onkeypress="return goodchars(event,'1234567890.',this)" {{$readonly}}>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{URL::to('assets/file_bukti_skp')}}/{{$rekap_skp->file_skp}}" target="_blank" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat File Skp</a>
                            </div>
                            @if($rekap_skp->validasi==1)
                            <div class="col-md-6">
                                <a class="btn btn-success text-white"> Valid pada tanggal : {{date('Y-m-d H:i:s',strtotime($rekap_skp->validated_at))}}</a>
                            </div>
                            @endif
                        </div>               
                        <div class="row">
                            <div class="col-md-12">
                                <hr/>
                                <span><b>Nilai Realisasi Prilaku Pegawai</b></span>
                                <input type="hidden" value="{{$dtpegawai->id_sdm}}" name="id_sdm" id="id_sdm">
                                <input type="hidden" value="{{$dtpegawai->nip}}" name="nip" id="nip">
                                <input type="hidden" value="{{$periodeaktif->id}}" name="idperiode" id="idperiode">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th rowspan="2">Nama Aspek</th>
                                                <th colspan="2"><center>Penilaian</center></th>
                                            </tr>
                                            <tr>
                                                <th>Nilai</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1;$ttl_nilai = 0;$jumlahkom=0;?>
                                            @foreach($dtprilaku as $rs=>$r)
                                            <?php $jumlahkom++;?>
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$r->nama}}</td>
                                                <td>
                                                    <input value="{{$arrPenilaian[$r->id]['nilai']}}" onkeyup="getNilaiHuruf(this);calculateSum();" type="text" class="form-control" name="nilai_{{$r->id}}" id="nilai_{{$r->id}}" onkeypress="return goodchars(event,'1234567890.',this)" {{$readonly}}>
                                                </td>
                                                <td>
                                                    <input value="{{$arrPenilaian[$r->id]['keterangan']}}" type="text" readonly="true" class="form-control" name="keterangan_{{$r->id}}" id="keterangan_row_nilai_{{$r->id}}" {{$readonly}}>
                                                </td>
                                            </tr>
                                            <?php
                                            $ttl_nilai+=$arrPenilaian[$r->id]['nilai'];
                                            ?>
                                            @endforeach
                                            <?php
                                            $jmkom = count((array)$arrPenilaian);
                                            $ratnilai = $ttl_nilai/$jumlahkom;
                                            ?>
                                            @if($jmkom>0)
                                            <tr>
                                                <td colspan="2">Total Nilai</td>
                                                <td>
                                                    <input type="text" id="ttl_nilai" name="ttl_nilai" value="{{$ttl_nilai}}" readonly="true" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Nilai Rata-rata (Total Nilai / Jumlah Komponen Perilaku)</td>
                                                <td colspan="2">
                                                    <input type="text" id="ttl_nilai" name="ttl_nilai" value="{{$ratnilai}}" readonly="true" class="form-control">
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <br/>
                                @if($rekap_skp->validasi!=1)
                                    @if(Session::get('atasan_penilai')!=null)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                <div class="checkbox d-inline-block mr-3 rtl-mr-0">
                                                    <input type="checkbox" class="checkbox-input" id="checkbox1" name="valid" required>
                                                    <label for="checkbox1">Data skp atas nama <b>{{$rsData->nm_sdm}} pada bulan {{$arrBulan[$periodeaktif->bulan]}} tahun {{$periodeaktif->tahun}} sudah saya nilai dan saya nyatakan valid.</b></label>
                                                </div><br/>
                                                <button class="btn btn-primary text-white"><i class="fas fa-save"></i> Simpan</button>
                                            </center>
                                        </div>
                                    </div>    
                                    @endif                            
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            <div class="iq-alert-text">
                <center><span>Anda Belum unggah File Dokumen SKP</span></center>
            </div>
        </div>
    @endif
@endif
<script>

function calculateSum() {
        
}
function getNilaiHuruf(arg)
{
    let id = arg.getAttribute('id');
    let last_char = id.charAt(id.length - 1);
    let nilai = parseInt(arg.value);
    let status = '';
    if((nilai=="0"))
    { status = "SANGAT KURANG"; }
    else if((nilai<40))
    { status = "SANGAT KURANG"; }
    else if ((nilai>=41)&&(nilai<=60))
    { status = "KURANG"; }
    else if((nilai>=61)&&(nilai<=80))
    { status = "CUKUP"; }
    else if((nilai>=81)&&(nilai<=100))
    { status = "BAIK"; }
    else if((nilai>=101))
    { alert("Nilai tidak boleh lebih dari 100"); }
    let keterangan_row = '#keterangan_row_' + id;
    $(keterangan_row).val(status);
}
</script>
@stop