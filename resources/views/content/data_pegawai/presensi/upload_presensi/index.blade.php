@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Upload Data Presensi</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.upload-presensi.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Nama Pegawai</label>
                            </div>
                            <select class="form-control" name="id_sdm" required>
                                {!!$pilihan_sdm!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Tanggal Presensi</label>
                            </div>
                            <input class="form-control" type="date" name="tgl_absen" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Jam Masuk</label>
                            </div>
                            <input class="form-control" type="time" name="jam_absen" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Jam Pulang</label>
                            </div>
                            <input class="form-control" type="time" name="jam_absen_pulang" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Mesin Finger</label>
                            </div>
                            <select class="form-control" name="mesin" required>
                                {!!$pilihan_mesin_finger!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button href="" class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-download"></i> Sync Presensi Kehadiran Mesin Fingger</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <span class="text-dark">List Tgl Presensi Belum Sync :</span>
                <div class="row">
                    @foreach($arrTgl as $k=>$list)
                        @foreach($list as $kx=>$tgl)
                        <div class="col-md-3">
                            <ul>
                                <li class="text-dark">{{$tgl}}</li>
                            </ul>
                        </div>
                        @endforeach
                    @endforeach
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div id="progressingkron">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 0%" id="prosessSing">
                                    <span class="rsynclabel">0% Proses Sinkron Data Fingger (Jangan close halaman saat melakukan sync fingger)</span>
                                </div>
                            </div>
                        </div><br/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <center>
                            <a class="btn btn-primary" onclick="sinkronkan(0);">Sync Presensi Kehadiran Fingger</a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Upload Data Presensi Excel</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.upload-presensi.upload')}}" method="post" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">File Excel Finger</label>
                            <input type="file" class="custom-file-input" id="inputGroupFile03" name="file_excel" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-upload"></i> Upload Excel</button>
                    </div>
                </div>
                </form>
                <br/><br/>
                @if(count((array)Session::get('pegawaiblumada'))>0)
                <span class="text-dark">Data Pegawai yang gagal di upload, dikarenakan data master pagwai nya belum ada didalam database.</span>
                <ul class="text-dark">
                    @foreach(Session::get('pegawaiblumada') as $rs=>$r)
                        <li>{{$r['nip']}} -- {{$r['nama']}}</li>
                    @endforeach
                </ul>
                <a href="{{route('data-pegawai.data-presensi.upload-presensi.clear')}}" class="btn btn-warning">Clear Data Gagal</a>
                @endif
            </div>
        </div>
    </div>
</div> --}}
{{-- <div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-warning">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Upload Data Presensi Excel (Shift)</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.upload-presensi.upload')}}" method="post" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">File Excel Finger</label>
                            <input type="file" class="custom-file-input" id="inputGroupFile03" name="file_excel" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-upload"></i> Upload Excel</button>
                        <a class="btn btn-warning" href="{{URL::to('assets/template_excel/template_unggah_excel_presensi_pegawai_shift.xlsx')}}"><i class="fas fa-download"></i> Template Excel</a>
                    </div>
                </div>
                </form>
                <br/><br/>
                @if(count((array)Session::get('pegawaiblumada'))>0)
                <span class="text-dark">Data Pegawai yang gagal di upload, dikarenakan data master pagwai nya belum ada didalam database.</span>
                <ul class="text-dark">
                    @foreach(Session::get('pegawaiblumada') as $rs=>$r)
                        <li>{{$r['nip']}} -- {{$r['nama']}}</li>
                    @endforeach
                </ul>
                <a href="{{route('data-pegawai.data-presensi.upload-presensi.clear')}}" class="btn btn-warning">Clear Data Gagal</a>
                @endif
            </div>
        </div>
    </div>
</div> --}}
<div id="balik"></div>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="{{URL::to('assets/plugins/global/plugins.bundle1ff3.js?v=7.1.2')}}"></script>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
$('#progressingkron').hide();
var p = 0;
var jml = {{count($listtgl)}};
var relem = document.getElementById("prosessSing");
var arrKode = <?php echo json_encode($listtgl);?>;
function sinkronkan(p)
{
  var tgl_absen = arrKode[p];
  $('#progressingkron').show();
   var request = $.ajax ({
       url : "{{ route('data-pegawai.data-presensi.upload-presensi.sync-finger') }}",
       beforeSend: function (xhr) {
            var token = $('meta[name="csrf_token"]').attr('content');

            if (token) {
                  return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        data        : "tgl_absen="+tgl_absen,
        type        : "post",
        dataType    : "html"
   });
    request.done(function(output) {
    p = p+1;
    console.log(p);
    rcur = Math.floor(((p-1)/jml) * 100)
    relem.style.width = rcur + '%';
    $('.rsynclabel').text(rcur + '% Proses Sinkron Mesin Finger, jangan direfresh sampai proses sync selesai.');
    width=0;
    if(p<=jml){
      sinkronkan(p);
    }
    else{
        toastr.success("Proses Sinkron Ke siakadu Telah Selesai .");
    }

   $('#balik').html(output);
  });
}
</script>
@stop
