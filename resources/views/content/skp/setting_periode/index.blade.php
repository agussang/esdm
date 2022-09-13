@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Setting Periode SKP</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('skp.setting-skp.cari')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tahun</span>
                            </div>
                            <select class="form-control" id="tahun" name="tahun">
                                {!!$pilihan_tahun_skp!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button href="" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan Data</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Bulan</th>
                                <th>Tahun</th>
                                <th>Aktif ?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($rsData as $rs=>$r)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$r->kode}}</td>
                                <td>{{$arrBulan[$r->bulan]}}</td>
                                <td>{{$r->tahun}}</td>
                                <td>
                                    <div class="custom-control custom-switch custom-switch-text custom-control-inline">
                                        <div class="custom-switch-inner">
                                        <input onChange="aktifkan('{{$r->id}}',$(this))" type="checkbox" class="custom-control-input" id="{{$r->id}}" @if($r->status==1) checked @endif>
                                        <label class="custom-control-label" for="{{$r->id}}" data-on-label="On" data-off-label="Off">
                                        </label>
                                        </div>
                                    </div>
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
<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script>
function aktifkan(kode,value)
{
    var x=value.prop("checked");
    var request = $.ajax ({
           url : "{{route('skp.setting-skp.update_status')}}",
           data:"id="+kode+"&status="+x,
           type : "get",
           dataType: "html"
       });
       $('#balik').html('Proses menampilkan data .... ');
       request.done(function(output) {
        $('#balik').html(output);
       });
}
</script>
@stop