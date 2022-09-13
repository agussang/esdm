@extends('layouts.layout')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-plus"></i> Tambah Data Master Jabatan</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-master.jabatan')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" action="{{route('data-master.jabatan.simpan')}}" method="post">
				{!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Jabatan</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Default" name="namajabatan" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Type Jabatan</span>
                            </div>
                            <select class="form-control" name="tipejabatan" id="tipejabatan" required>
                                {!!$pilihan_tipe_jabatan!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Grade</span>
                            </div>
                            <select class="form-control" name="id_grade" id="id_grade" onchange="tmp_grade(this)" required>
                                {!!$pilihan_grade!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Job Score</span>
                            </div>
                            <input type="text" class="form-control" value="" id="jobscore" aria-label="Default"  readonly= "true" aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Job Price</span>
                            </div>
                            <input type="text" class="form-control" value="" id="jobprice" aria-label="Default" readonly= "true"  aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tambahan Gaji P1</span>
                            </div>
                            <input type="text" class="form-control" value="" id="p1" aria-label="Default" readonly= "true"  aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Insentif Kinerja P2</span>
                            </div>
                            <input type="text" class="form-control" value="" id="p2" aria-label="Default" readonly= "true"  aria-describedby="inputGroup-sizing-default" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="balik"></div>
<meta name="csrf_token" content="{{ csrf_token() }}" />
<script type="text/javascript">
function tmp_grade(a)
{
    var id = (a.value || a.options[a.selectedIndex].value);
    var request = $.ajax ({
       url : "{{ route('data-master.grade.tmp-grade') }}",
       data:"id="+id,
       type : "get",
       dataType: "html"
   });
   $('#balik').html('Sedang Melakukan Proses Pencarian Data...');
   request.done(function(output) {
       $('#balik').html(output);
   });
}
</script>

@stop