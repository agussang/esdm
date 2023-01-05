@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> <span> Form Persetujuan Pengajuan Justifikasi Kehadiran</span></h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{URL::to('pegawai-bawahan/approve-justifikasi')}}/{{Crypt::encrypt($rsData->id_sdm)}}/{{$bulan}}/{{$tahun}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('pegawai-bawahan.simpan-proses-pengajuan-justifikasi')}}" method="post">
                {!! csrf_field() !!}
                <input type="hidden" name="id_justifikasi" id="id_justifikasi" value="{{$rsData->id_justifikasi}}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input value="{{$rsData->dt_pegawai->nm_sdm}}" class="form-control" name="nm_sdm" id="nm_sdm" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nip Pegawai</span>
                            </div>
                            <input type="text" value="{{$rsData->dt_pegawai->nip}}" class="form-control" name="nip" id="nip" readonly="true">
                            <input type="hidden" value="{{$rsData->dt_pegawai->id_sdm}}" class="form-control" name="id_sdm" id="id_sdm" readonly="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Presensi</span>
                            </div>
                            <input value="{{Fungsi::formatDate($rsData->tanggal_absen)}}" class="form-control" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk</span>
                            </div>
                            <input type="time" value="{{$rsData->jam_masuk}}" class="form-control" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang</span>
                            </div>
                            <input type="time" value="{{$rsData->jam_pulang}}" class="form-control" readonly="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($rsData->kategori_justifikasi==2 || $rsData->kategori_justifikasi=="3")
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Durasi {{$text_kategori}} </span>
                            </div>
                            <input value="{{$rsData->durasi_kategori}} ( Menit )" class="form-control" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Pengajuan Durasi Justifikasi </span>
                            </div>
                            <input value="{{$rsData->ajuan_durasi_justifikasi}} ( Menit )" class="form-control" readonly="true">
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kategori Pengajuan</span>
                            </div>
                            <input value="{{$text_kategori}}" class="form-control" readonly="true" >
                            <input type="hidden" value="{{$kode}}" class="form-control">
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Alasan</span>
                            </div>
                            <textarea class="form-control" name="alasan" id="alasan" readonly="true">
                                {{$rsData->alasan}}
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Mengganggu Layanan ?</span>
                            </div>
                            <select name="id_jns" id="id_jns" class="form-control" onchange="updateInput(this.value)" readonly="true">
                                <option value="2">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if($rsData->kategori_justifikasi==2 || $rsData->kategori_justifikasi=="3")
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Durasi Justifikasi <i><b> (Menit)</b></i></span>
                            </div>
                            <input name="durasi_justifikasi" id="durasi_justifikasi" class="form-control" required max="{{$rsData->ajuan_durasi_justifikasi}}" value="{{$rsData->ajuan_durasi_justifikasi}}">
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Setujui ?</span>
                            </div>
                            <select name="justifikasi_atasan" id="justifikasi_atasan" class="form-control" readonly="true">
                                <option value="1">Ya</option>
                                <option value="2">Tidak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="kode_kategori" id="kode_kategori" value="{{$kode_kategori}}">
                <input type="hidden" name="tanggal_absen" id="tanggal_absen" value="{{$rsData->tanggal_absen}}">
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary pull-right"><i clas="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function updateInput(kode){
    if(kode==1){
        $("#durasi_justifikasi").prop('readonly', true);
        document.getElementById("durasi_justifikasi").value = 0;
    }else{
        $("#durasi_justifikasi").prop('readonly', false);
        document.getElementById("durasi_justifikasi").value = {{$rsData->ajuan_durasi_justifikasi}};
    }
}
</script>
@stop
