@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Log Login Aplikasi E-SDM</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('setting.log-login.search')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-default">Tanggal</span>
                                </div>
                                <input class="form-control" aria-label="Default" type="text" name="daterange" value="{{$tgl1}} - {{$tgl2}}" required aria-describedby="inputGroup-sizing-default">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
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
                <div class="row">
                    <div class="col-md-3">
                        <div id="donut"></div>
                    </div>
                    <div class="col-md-9">
                        <div id="batang"></div>
                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-reponsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama User</th>
                                        <th>Tanggal Login</th>
                                        <th>Ip Address</th>
                                        <th>Browser</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rsData as $rs=>$r)
                                    <tr>
                                        <td>{{$r->username}}</td>
                                        <td>{{$r->nama_user}}</td>
                                        <td>{{date('d-m-Y H:i:s',strtotime($r->tgl_login))}}</td>
                                        <td>{{$r->ip}}</td>
                                        <td>{{$r->browser}}</td>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<script src="{{URL::to('assets/js/apexcharts.js')}}"></script>
<script>

$('input[name="dates"]').daterangepicker();
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
var options = {
    series: [
    @foreach($arrData as $nmbrowser=>$jm)
        {{$jm['jmlh']}},
    @endforeach
    ],
    chart: {
    type: 'donut',
},
labels: [
    @foreach($arrData as $nmbrowser=>$jm)
    '{{$nmbrowser}}',
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
}],
legend: {
    show: true,
    position: 'bottom',
    horizontalAlign: 'center'
},
};

var chart = new ApexCharts(document.querySelector("#donut"), options);
chart.render();

 var options = {
    series: [

    {
        name: 'Jumlah Data',
        data: [
            @foreach($arrData as $nmbrowser=>$jm)
                {{$jm['jmlh']}},
            @endforeach
        ]
    }
],
    chart: {
    type: 'bar',
    height: 270
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
        @foreach($arrData as $nmbrowser=>$jm)
            '{{$nmbrowser}}',
        @endforeach
    ],
},
yaxis: {
    title: {
    text: 'Jumlah'
    }
},
fill: {
    opacity: 1
},
tooltip: {
    y: {
    formatter: function (val) {
        return val + " "
    }
    }
}
};

var chart = new ApexCharts(document.querySelector("#batang"), options);
chart.render();
</script>
@stop
