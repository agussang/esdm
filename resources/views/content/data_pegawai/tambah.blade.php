@extends('layouts.layout')
@section('content')
<form class="form" action="{{route('data-pegawai.master-pegawai.simpan')}}" method="post">
{!! csrf_field() !!}
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-list"></i> Tambah Data Pegawai</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.master-pegawai.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
                            </div>
                            <input type="text" class="form-control" name="nm_sdm" id="nm_sdm" required value="{{ old('nm_sdm') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tempat Lahir</span>
                            </div>
                            <input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" required value="{{ old('tmpt_lahir') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Lahir</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" required value="{{ old('tgl_lahir') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jenis Kelamin</span>
                            </div>
                            <select class="form-control" name="jk" id="jk" required>
                                {!!$pilihan_jenis_kelamin!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">NIK</span>
                            </div>
                            <input type="text" class="form-control" name="nik" id="nik" required minlength="16" maxlength="16" onkeypress="return goodchars(event,'1234567890',this)" value="{{ old('nik') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Hp</span>
                            </div>
                            <input type="text" class="form-control" name="no_hp" id="no_hp" minlength="11" maxlength="13" required onkeypress="return goodchars(event,'1234567890',this)" value="{{ old('no_hp') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Email</span>
                            </div>
                            <input type="text" class="form-control" name="email" id="email" required value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Perkawinan</span>
                            </div>
                            <select class="form-control" name="id_stat_kawin" id="id_stat_kawin" required>
                                {!!$pilihan_status_kawin!!}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Agama</span>
                            </div>
                            <select class="form-control" name="id_agama" id="id_agama" required>
                                {!!$pilihan_agama!!}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <p class="text-dark"><i class="fa fa-home text-dark"></i> Informasi Alamat Rumah</p><hr/>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jalan</span>
                            </div>
                            <input type="text" class="form-control" name="jln" id="jln" required value="{{ old('jln') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Kode Pos</span>
                            </div>
                            <input type="text" class="form-control" name="kode_pos" value="{{ old('kode_pos') }}" id="kode_pos" required minlength="5" maxlength="5" onkeypress="return goodchars(event,'1234567890',this)">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Desa</span>
                            </div>
                            <input type="text" class="form-control" name="ds_kel" id="ds_kel" required value="{{ old('ds_kel') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nama Dusun</span>
                            </div>
                            <input type="text" class="form-control" name="nm_dsn" id="nm_dsn" required value="{{ old('nm_dsn') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">RT</span>
                            </div>
                            <input type="text" class="form-control" name="rt" id="rt" required minlength="1" value="{{ old('rt') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">RW</span>
                            </div>
                            <input type="text" class="form-control" name="rw" id="rw" required minlength="1" value="{{ old('rw') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-body">
                <p class="text-dark"><i class="fa fa-user text-dark"></i> Informasi Status Kepegawaian</p><hr/>
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Jenis Pegawai</span>
                            </div>
                            <select class="form-control" name="id_jns_sdm" id="id_jns_sdm" onchange="tmp_jns_sdm(this)" required>
                                {!!$pilihan_jns_sdm!!}
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Kepegawaian</span>
                            </div>
                            <select class="form-control" name="id_stat_kepegawaian" id="id_stat_kepegawaian" onchange="tmp_status_kepegawaian(this)" required>
                                {!!$pilihan_status_kepegawaian!!}
                            </select>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Status Keaktifan</span>
                            </div>
                            <select class="form-control" name="id_stat_aktif" id="id_stat_aktif" required>
                                {!!$pilihan_status_keaktifan!!}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" id="form-nidn">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nidn</span>
                            </div>
                            <input type="number" class="form-control" name="nidn" id="nidn" value="{{ old('nidn') }}">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Nip</span>
                            </div>
                            <input type="number" class="form-control" name="nip" id="nip" value="{{ old('nip') }}">
                        </div>
                    </div> 
                </div>
                <div class="row" id="form-non-cpns">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk</span>
                            </div>
                            <input type="text" class="form-control" name="no_sk" id="no_sk" value="{{ old('no_sk') }}">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Sk Angkat</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_sk_angkat" id="tgl_sk_angkat" value="{{ old('tgl_sk_angkat') }}">
                        </div>
                    </div> 
                </div>
                <div class="row" id="form-cpns">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk Cpns</span>
                            </div>
                            <input type="text" class="form-control" name="no_sk_cpns" id="no_sk_cpns" value="{{ old('no_sk_cpns') }}">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">TMT CPNS</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_tmt_cpns" id="tgl_tmt_cpns" value="{{ old('tgl_tmt_cpns') }}">
                        </div>
                    </div> 
                </div>
                <div class="row" id="form-pns">
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk PNS</span>
                            </div>
                            <input type="text" class="form-control" name="no_sk_pns" id="no_sk_pns" value="{{ old('no_sk_pns') }}">
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">TMT PNS</span>
                            </div>
                            <input type="date" class="form-control" name="tgl_tmt_pns" id="tgl_tmt_pns" value="{{ old('tgl_tmt_pns') }}">
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary pull-right"><i class="fas fa-save"></i> Simpan</button>
    </div>
</div>
</form>
<br/><br/><br/><br/><br/>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script>
$('#form-pns').hide();
$('#form-cpns').hide();
$('#form-non-cpns').hide();

$('#form-nidn').hide();
function tmp_status_kepegawaian(a)
{
    var x = (a.value || a.options[a.selectedIndex].value);
    
    if (x == "eb592b52-58d8-4dfc-ac7d-c41c7cea695e") {
        $('#form-pns').show();
        $('#form-cpns').hide();
        $('#form-non-cpns').hide();
    } else if(x == "588fe662-9f66-44e3-a923-5056b67536f5") {
        $('#form-cpns').show();
        $('#form-non-cpns').hide();
        $('#form-pns').hide();
    } else if(x != "588fe662-9f66-44e3-a923-5056b67536f5" && x != "eb592b52-58d8-4dfc-ac7d-c41c7cea695e") {
        $('#form-non-cpns').show();
        $('#form-cpns').hide();
        $('#form-pns').hide();
    }
}
function tmp_jns_sdm(a)
{
    var x = (a.value || a.options[a.selectedIndex].value);
    
    if (x == "60943815-0ef4-403e-98d8-7a96ecdc6d5f") {
        $('#form-nidn').show();
    } else {
        $('#form-nidn').hide();
    } 
}
</script>
@stop