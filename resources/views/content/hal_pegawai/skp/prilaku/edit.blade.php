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
}else{
    if(Session::get('id_sdm_pengguna') != $dtpegawai->id_sdm_atasan){
        $readonly = "readonly=\"true\"";
    }
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
                            @if(Session::get('level')=="P" && Session::get('id_sdm_pengguna') != Session::get('id_sdm_atasan'))
                            <a href="{{URL::to('/skp-pegawai/skp')}}/{{Crypt::encrypt($dtpegawai->id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                                <a href="{{route('skp.data-skp.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @endif
                            {{--  <a href="{{ URL::previous() }}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>  --}}
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

@if($cek_file==0 && Session::get('id_sdm_pengguna') != $dtpegawai->id_sdm_atasan)
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
                                    <input type="text" @if($dtpegawai->id_sdm_atasan != $dtpegawai->id_sdm) readonly="true" @endif id="nilai_skp" name="nilai_skp" class="form-control" aria-label="Default" value="{{$rekap_skp->nilai_skp}}" aria-describedby="inputGroup-sizing-default" required onkeypress="return goodchars(event,'1234567890.',this)" {{$readonly}}>
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
