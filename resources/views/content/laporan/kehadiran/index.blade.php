@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
        <div class="card-header d-flex justify-content-between">
            <div class="header-title">
                <h4 class="card-title">
                    <i class="fas fa-list-alt"></i> Laporan Presensi Kehadiran Pegawai
                </h4>
            </div>
        </div>
        <div class="card-body">
            <form class="form" action="{{route('laporan.presensi-kehadiran.cari-presensi')}}" method="post" target="_blank">
			{!! csrf_field() !!}
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Satuan Unit Kerja</span>
                        </div>
                        <select class="form-control" id="satuan_kerja" name="satuan_kerja" onchange="tmp_pegawai();">
                            {!!$pilihan_satker!!}
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                        </div>
                        <select class="form-control" id="id_sdm" name="id_sdm">
                            {!!$pilihan_sdm!!}
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Tipe</span>
                        </div>
                        <select class="form-control" id="tipe" name="tipe" required>
                            <option value="1">Format Harian 1</option>
                            <option value="2">Format Harian 2</option>
                            <option value="3">Harian+Lembur</option>
                            <option value="4">Bulanan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Jam Kerja</span>
                        </div>
                        <select class="form-control" id="id_jam_kerja" name="id_jam_kerja" required>
                            {!!$pilihan_jam_kerja!!}
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Awal</span>
                        </div>
                        <input type="date" class="form-control" name="tgl_awal" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Akhir</span>
                        </div>
                        <input type="date" class="form-control" name="tgl_akhir" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary pull-right"><i class="fas fa-search"></i> Tampilkan Data</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script>
$(document).ready(function() {
    tmp_pegawai();
});
function tmp_pegawai(){
        var satuan_kerja = document.getElementById("satuan_kerja").value;
	
        var request = $.ajax ({
               url : "{{route('laporan.presensi-kehadiran.cari-pegawai')}}",
               type : "get",
               data : {satuan_kerja : satuan_kerja },
               dataType: "html"
           });
           $('#id_sdm').html('Sedang Mencari data ..');
           request.done(function(output) {
               $('#id_sdm').html(output);
           });
}

</script>
@stop