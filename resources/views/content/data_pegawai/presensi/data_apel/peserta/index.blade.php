@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Upload Peserta Kegiatan</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.apel.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Judul Kegiatan</span>
                            </div>
                            <input type="text" name="nama_kegiatan" class="form-control" required value="{{$rsData->nama_kegiatan}}" readonly="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Kegiatan</span>
                            </div>
                            <input type="date" name="tgl_kegiatan" class="form-control" required value="{{$rsData->tgl_kegiatan}}" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Mulai</span>
                            </div>
                            <input type="time" name="jam_mulai" class="form-control" required value="{{$rsData->jam_mulai}}" readonly="true">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jam Selesai</span>
                            </div>
                            <input type="time" name="jam_selesai" class="form-control" required value="{{$rsData->jam_selesai}}" readonly="true">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <span><i>*Nb:Template sudah berisi nip dan nama pegawai, jangan merubah tata letak kolom pada file template</i></span>
                    </div>
                    <div class="col-md-3">
                        <a href="{{URL::to('data-pegawai/data-presensi/apel/peserta/download')}}/{{Crypt::encrypt($rsData->id_kegiatan)}}" class="btn btn-primary pull-right"><i class="fas fa-download"></i> Download Template</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-danger">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Data Peserta Kegiatan</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-pegawai.data-presensi.apel.peserta.upload')}}" method="post" enctype="multipart/form-data">
				{!! csrf_field() !!}
                <input type="hidden" name="id_kegiatan"value="{{$rsData->id_kegiatan}}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="custom-file">
                            <label class="custom-file-label" for="inputGroupFile03">File Excel Peserta</label>
                            <input type="file" class="custom-file-input" id="inputGroupFile03" name="file_excel" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary"><i class="fas fa-upload"></i> Upload Excel</button>
                    </div>
                </div>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        @if(count(Session::get('pegawaiapelbelumada'))>0)
                        <span class="text-dark">Data Pegawai yang gagal di upload, dikarenakan data master pagwai nya belum ada didalam database.</span>
                        <ul class="text-dark">
                            @foreach(Session::get('pegawaiapelbelumada') as $rs=>$r)
                                <li>{{$r['nip']}} -- {{$r['nama']}}</li>
                            @endforeach
                        </ul>
                        <a href="{{URL::to('data-pegawai/data-presensi/apel/peserta/clear')}}/{{Crypt::encrypt($rsData->id_kegiatan)}}" class="btn btn-warning">Clear Data Gagal</a>
                        @endif
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
                        <span><i class="fas fa-list text-dark"></i><b>Data Kehadiran Kegiatan<hr/></b> </span>
                    </div>
                </div>
                <div class="row">
                    @if(count($peserta)>0)
                    <div class="col-md-3">
                        <div id="chart"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="batang"></div>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <span><b>Jumlah Kehadiran<hr/></b></span>
                        @foreach($kehadiran as $nm_kehadiran=>$jm)
                            <?php
                                $kelas = "primary";
                                if($nm_kehadiran=="Tidak Hadir"){
                                    $kelas = "danger";
                                }
                            ?>
                            <div class="alert alert-{{$kelas}}" role="alert">
                                <span class="counter">
                                    {{$jm}} Pegawai {{$nm_kehadiran}}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div><br/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nip</th>
                                        <th>Nama</th>
                                        <th>Hadir ?</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1;?>
                                    @foreach($peserta as $rs=>$r)
                                    <?php
                                        $badge = "";
                                        if($r->kehadiran=="H"){
                                            $badge = "<span class=\"badge badge-primary\">Hadir</span>";
                                        }if($r->kehadiran=="T" || $r->kehadiran=="TH"){
                                            $badge = "<span class=\"badge badge-danger\">Tidak Hadir</span>";
                                        }
                                    ?>
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$r->dt_pegawai->nip}}</td>
                                        <td>{{$r->dt_pegawai->nm_sdm}}</td>
                                        <td>{!!$badge!!}</td>
                                        <td></td>
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
<script src="{{URL::to('assets/js/apexcharts.js')}}"></script>
<script>
var options = {
    series: [
        @foreach($kehadiran as $nm=>$jm)
            {{$jm}},
        @endforeach
    ],
    chart: {
    type: 'donut',
},
labels: [
    @foreach($kehadiran as $nm=>$jm)
        "{{$nm}}",
    @endforeach
],
responsive: [{
    breakpoint: 480,
    options: {
    chart: {
        width: 200
    },
    legend: {
        position: 'bottom'
    }
    }
}]
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

var options = {
    series: [{
    name: 'Laki - Laki',
    data: [
        @foreach($kehadiran_jk['L'] as $nm_kehadiran=>$dtkehadiran)
            {{$dtkehadiran}},
        @endforeach
    ]
}, {
    name: 'Perempuan',
    data: [
        @foreach($kehadiran_jk['P'] as $nm_kehadiran=>$dtkehadiran)
            {{$dtkehadiran}},
        @endforeach
    ]
}],
    chart: {
    type: 'bar',
    height: 230
},
plotOptions: {
    bar: {
    horizontal: false,
    columnWidth: '55%',
    endingShape: 'rounded'
    },
},
dataLabels: {
    enabled: false
},
stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
},
xaxis: {
    categories: [
        @foreach($text_kehadiran as $nm_kehadiran=>$dtkehadiran)
            '{{$nm_kehadiran}}',
        @endforeach
    ],
},
yaxis: {
    title: {
    text: ' Jumlah Pegawai'
    }
},
fill: {
    opacity: 1
},
tooltip: {
    y: {
    formatter: function (val) {
        return val + " Pegawai"
    }
    }
}
};

var chart = new ApexCharts(document.querySelector("#batang"), options);
chart.render();
</script>
@stop
