@extends('layouts.layout')
@section('content')
<?php
$induk = explode('/',request()->path());
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Riwayat / History Presensi Kehadiran Apel</h5>
                        </div>
                        <div class="col-md-3">
                            @if(Session::get('level')!="P")
                            <a href="{{URL::to('data-pegawai/master-pegawai/detil-data')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                            @else
                                @if($induk[0]=="pegawai-bawahan")
                                    <a href="{{URL::to('pegawai-bawahan/detil')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @else
                                    <a href="{{URL::to('pegawai/detil')}}/{{Crypt::encrypt($id_sdm)}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <input type="hidden" name="id_sdm" id="id_sdm" value="{{$id_sdm}}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                            </div>
                            <select class="form-control" name="tahun" id="tahun" required disabled>
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
                            <input type="text" readonly="true" value="{{$dt_pegawai->nm_sdm}}" class="form-control">
                        </div>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Jam Kegiatan</th>
                                        <th>Hadir ?</th>
                                        <th>Ket Justifikasi</th>
                                        <th>Justifikasi ?</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;?>
                                    @foreach($rsData as $rs=>$r)
                                    <?php
                                    $tgl_jus = "";
                                    $alasan_jus = "";
                                    if((int)$r->justifikasi_atasan>0){
                                        $tgl_jus = $r->tgl_justifikasi;
                                        $alasan_jus = $r->alasan;
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$r->nm_kegiatan_apel->nama_kegiatan}}</td>
                                        <td>{{Fungsi::formatDate($r->nm_kegiatan_apel->tgl_kegiatan)}}</td>
                                        <td>{{$r->nm_kegiatan_apel->jam_mulai}} - {{$r->nm_kegiatan_apel->jam_selesai}}</td>
                                        <td>
                                            @if($r->kehadiran=="H")
                                                Hadir
                                            @else
                                                Tidak Hadir
                                            @endif
                                        </td>
                                        <td>
                                            @if($r->kehadiran!="H")
                                            <li>Tgl : {{$tgl_jus}}</li>
                                            <li>Alasan : {{$alasan_jus}}</li>
                                            @endif
                                        </td>
                                        <td>
                                            @if($r->kehadiran=="T")
                                                @if((int)$r->justifikasi_atasan<1)
                                                <a onclick="edit('<?php echo $r->id_presensi;?>');" class="btn btn-primary text-white" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fas fa-check"></i> Justifikasi</a>
                                                @endif
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
                <h5 class="modal-title">Justifikasi Kehadiran Kegiatan Apel Pegawai</h5>
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
function edit(id_presensi)
{
    var request = $.ajax ({
       url : "{{ route('pegawai-bawahan.gen-justifikasi-apel') }}",
       data:"id_presensi="+id_presensi,
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
           url : "{{ route('pegawai-bawahan.save-gen-justifikasi-apel') }}",
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