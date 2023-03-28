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
if(Session::get('level')=="A" || Session::get('level')=="SA"){
    $readonly = "";
}
$point_justifikasi = "0";
if($rekap_skp->point_justifikasi!=null){
    $point_justifikasi = $rekap_skp->point_justifikasi;
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
                            <h5 class="card-label"><i class="fas fa-plus"></i> Form Penilaian Data SPK dan Perilaku </h5>
                        </div>
                        <div class="col-md-6">
                            <a href="{{route('skp.data-skp.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
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
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Batas Pengumpulan SKP</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{date('d-m-Y',strtotime($periodeaktif->tgl_batas_skp))}}" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($rekap_skp)
    @if($rekap_skp->file_skp)
        <div class="row">
            <div class="col-md-12">
                <form class="form" action="{{route('skp.data-skp.simpan-penilaian-skp')}}" method="post">
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
                                <div class="card text-white bg-primary">
                                    <div class="card-body">
                                        <span>File SKP diunggah pada tanggal : {{date('d-m-Y H:i:s',strtotime($rekap_skp->created_at))}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(date('dmY',strtotime($rekap_skp->created_at)) >= date('dmY',strtotime($periodeaktif->tgl_batas_skp)))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-block card-stretch card-height iq-border-box iq-border-box-2 text-warning basic-drop-shadow p-4 shadow-showcase text-center">
                                    <div class="card-body">
                                        <span class="text-dark"><h5>FORM JUSTIFIKASI KETERLAMBATAN PENGUMPULAN SKP</h5></span>
                                        <hr/>
                                        <span class="text-dark">
                                            Pegawai atas nama <b>{{$dtpegawai->nm_sdm}}</b> terlambat <b>{{$arrpointpenguran['ket_disiplin']}}</b> mengumpulkan SKP dan akan dikenakan sanksi disiplin berupa pengurangan point e-remun sebanyak <b>{{$arrpointpenguran['point_disiplin']}}%</b>. Anda sebagai atasan langsung diperbolehkan memberikan justifikasi terkait keterlambatan pengumpulan skp dengan cara memberikan alasan justifikasi pada form alasan justifikasi keterlambatan pengumpulan skp dibawah ini.
                                            Justifikasi keterlambatan pengumpulan skp bisa dilakukan selama durasi terlambat masih dibawah 10 hari kerja.Jika anda tidak berkenan memberikan justifikasi silahkan kosongi alasan justifikasi.
                                        </span>
                                        <br/><br/>
                                        <?php
                                        $ket_justifikasi = $rekap_skp->ket_justifikasi;
                                        if($arrpointpenguran['point_disiplin']=="100"){
                                            $readonly = "readonly=\"true\"";
                                            $ket_justifikasi = "";
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlTextarea1"> Alasan justifikasi keterlambatan pengumpulan skp </label>
                                                    <textarea class="form-control" rows="3" name="ket_justifikasi" placeholder="Masukkan alasan justifikasi keterlambatan pengumpulan skp" {{$readonly}}>{{$ket_justifikasi}}</textarea>
                                                 </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group mb-4">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-default">Point Justifikasi %</span>
                                                    </div>
                                                    <input type="text" name="point_justifikasi" id="point_justifikasi" class="form-control" aria-label="Default" max="{{$arrpointpenguran['point_disiplin']}}" value="{{$point_justifikasi}}" aria-describedby="inputGroup-sizing-default" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <i><b style="color:red">Silahkan kosongi alasan dan point justifikasi justifikasi keterlambatan pengumpulan skp jika anda tidak memberikan justifikasi.</b></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <hr/>
                                <input type="hidden" value="{{$dtpegawai->nip}}" name="nip" id="nip">
                                <input type="hidden" value="{{$dtpegawai->id_sdm}}" name="id_sdm" id="id_sdm">
                                <input type="hidden" value="{{$periodeaktif->id}}" name="idperiode" id="idperiode">
                                <br/>
                                @if($rekap_skp->validasi!=1 || Session::get('level')=="A" || Session::get('level')=="SA")
                                    @if(Session::get('atasan_penilai')!=null || Session::get('level')=="A" || Session::get('level')=="SA" )
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
                <center><span>Belum unggah File Dokumen SKP</span></center>
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
