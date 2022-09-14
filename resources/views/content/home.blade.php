@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <span><b><center>Grafik Jumlah Pegawai Berdasarkan Golongan</center></b></span><hr/>
                <div id="chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <span><b><center>Prosentase Jumlah Pegawai</center></b></span><hr/>
                <div id="donut"></div>
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
                        <span><b>Tabel Jumlah Data Golongan<hr/></b></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Nama Golongan</th>
                                        <th colspan="2">Jenis Kelamin</th>
                                        <th rowspan="2">Jumlah</th>
                                    </tr>
                                    <tr>    
                                        @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
                                        <th>{{$nmjk}}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    ksort($jm_by_golongan);
                                    ?>
                                    @foreach($jm_by_golongan as $kodegolongan=>$dtgolongan)
                                    <tr>
                                        <td>{{$dtgolongan['nm_golongan']}}</td>
                                        @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
                                        <td align="right">{{count($dtgolongan['dt_golongan'][$nmjk])}}</td>
                                        @endforeach
                                        <td align="right">{{$jm_pergolongan[$kodegolongan]}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-2">
                            @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
                            <li>{{$nmjk}} ({{count($dtjk)}})</li>
                            @endforeach
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
                <span><b><center>Grafik Jumlah Pegawai Berdasarkan Pendidikan Terakhir</center></b></span><hr/>
                <div class="row">
                    <div class="col-md-9">
                        <div id="pendidikan"></div>
                    </div>
                    <div class="col-md-3">
                        <div id="prosen_pendidikan"></div>
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
                <span><b><center>Grafik Jumlah Pegawai Berdasarkan Massa Kerja</center></b></span><hr/>
                <div class="row">
                    <div class="col-md-12">
                        <div id="by_massa_kerja"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<script src="{{URL::to('assets/js/apexcharts.js')}}"></script>
<script>
var options = {
    series: [{
    name: 'Net Profit',
    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
}, {
    name: 'Revenue',
    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
}, {
    name: 'Free Cash Flow',
    data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
}],
    chart: {
    type: 'bar',
    height: 350
},
plotOptions: {
    bar: {
    horizontal: false,
    columnWidth: '75%',
    endingShape: 'rounded',
    dataLabels: {
            position: 'top', // top, center, bottom
            },
    },
},
dataLabels: {
    enabled: true,
    formatter: function (val) {
    return val;
    },
    offsetY: -20,
    style: {
    fontSize: '12px',
    colors: ["#304758"]
    }
},
stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
},
xaxis: {
    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
},
yaxis: {
    title: {
    text: '$ (thousands)'
    }
},
fill: {
    opacity: 1
},
tooltip: {
    y: {
    formatter: function (val) {
        return "$ " + val + " thousands"
    }
    }
}
};

var chart = new ApexCharts(document.querySelector("#by_massa_kerja"), options);
chart.render();
var options = {
    series: [
        @foreach($jm_perpendidikan as $nm_pen=>$jm_pen)
            {{$jm_pen}},
        @endforeach
    ],
    chart: {
    type: 'donut',
},
tooltip: {
	y: {
        formatter: function (val) {
            return val + " Pegawai"
        }
	}
},
labels: [
          @foreach($arrpendidikan as $urutan=>$dt_urutan)
            @foreach($dt_urutan as $nm_pendidikan=>$dt_pendidikan)
            '{{$nm_pendidikan}}',
            @endforeach
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

var chart = new ApexCharts(document.querySelector("#prosen_pendidikan"), options);
chart.render();
var options = {
    series: [
    @foreach($jm_by_pendidikan as $jkp=>$dtjkp)
    {
    name: '{{$jkp}}',
    data: [
        @foreach($arrpendidikan as $urutan=>$dt_urutan)
            @foreach($dt_urutan as $nm_pendidikan=>$dt_pendidikan)
                {{count($dtjkp[$nm_pendidikan])}},
            @endforeach
        @endforeach
    ]
    },
    @endforeach
],
    chart: {
    type: 'bar',
    height: 350
},
plotOptions: {
    bar: {
    horizontal: false,
    columnWidth: '75%',
    endingShape: 'rounded',
    dataLabels: {
            position: 'top', // top, center, bottom
            },
    },
},
dataLabels: {
    enabled: true,
    formatter: function (val) {
    return val;
    },
    offsetY: -20,
    style: {
    fontSize: '12px',
    colors: ["#304758"]
    }
},
stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
},
xaxis: {
    categories: [
        @foreach($arrpendidikan as $urutan=>$dt_urutan)
            @foreach($dt_urutan as $nm_pendidikan=>$dt_pendidikan)
            '{{$nm_pendidikan}}',
            @endforeach
        @endforeach
    ],
},
yaxis: {
    title: {
    text: 'Jumlah Pegawai'
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

var chart = new ApexCharts(document.querySelector("#pendidikan"), options);
        chart.render();



var options = {
    series: [
        @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
            {{count($dtjk)}},
        @endforeach
    ],
    chart: {
    type: 'donut',
},
tooltip: {
	y: {
        formatter: function (val) {
            return val + " Pegawai"
        }
	}
},
labels: [
          @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
            '{{$nmjk}}',
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
    @foreach($arrData as $jk=>$dt_jk)
    {
        name: '{{$jk}}',
        data: [
            @foreach($nm_golongan as $golongan=>$gol)
                {{count($dt_jk[$golongan])}},
            @endforeach
        ]
    },
    @endforeach
    ],
    chart: {
    type: 'bar',
    height: 250
},
plotOptions: {
    bar: {
    horizontal: false,
    columnWidth: '75%',
    endingShape: 'rounded',
    dataLabels: {
            position: 'top', // top, center, bottom
            },
    },
},
dataLabels: {
    enabled: true,
    formatter: function (val) {
    return val;
    },
    offsetY: -20,
    style: {
    fontSize: '12px',
    colors: ["#304758"]
    }
},
stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
},
xaxis: {
    categories: [
        @foreach($nm_golongan as $golongan=>$gol)
            '{{$golongan}}',
        @endforeach
    ],
},
yaxis: {
    title: {
    text: 'Jumlah Pegawai'
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

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
</script>
@stop