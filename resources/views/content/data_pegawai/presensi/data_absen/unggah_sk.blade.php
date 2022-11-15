@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-9">
                            <h5 class="card-label"><i class="fa fa-upload"></i> Form Unggah SK Absen Kehadiran</h5>
                        </div>
                        <div class="col-md-3">
                            <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}" class="btn btn-danger pull-right"><i class="fas fa-backspace"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="form" id="formku" action="{{route('data-pegawai.data-presensi.data-absen.unggah-sk-cari')}}" method="post">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">No Sk</span>
                            </div>
                            <input type="text" class="form-control" id="no_sk" name="no_sk">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-default">Mode</span>
                            </div>
                            <select class="form-control" id="mode" name="mode">
                                <option value="2" @if($mode==2) selected @endif>Belum Terisi</option>
                                <option value="1" @if($mode==1) selected @endif>Sudah Terisi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                <span>Daftart No Sk</span>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Sk</th>
                                <th>Tanggal Sk</th>
                                <th>Jumlah Penerima</th>
                                <th>File Sk</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                            @foreach($arrData AS $nosk=>$r)
                            <form class="form" action="{{route('data-pegawai.data-presensi.data-absen.unggah-file-sk-simpan')}}" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            <input type="hidden" name="no_sk" value="{{$nosk}}">
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$nosk}}</td>
                                <td>{{date('d-m-Y',strtotime($r['tgl_sk']))}}</td>
                                <td>{{count($arrpenerima[$nosk])}} Pegawai</td>
                                <td>
                                    @if($r['file_bukti']!=null)
                                    <a href="{{URL::to('assets/file_bukti_absen')}}/{{$r['file_bukti']}}" target="_blank"><i class="fas fa-file-pdf" style="font-size:50px;"></i></a>
                                    @else
                                    <input type="file" name="file" class="form-control" required accept="application/pdf">
                                    @endif
                                </td>
                                <td>{{$r['alasan']}}</td>
                                <td>
                                    @if($r['file_bukti']!=null)
                                    <a class="btn btn-danger" href="{{URL::to('data-pegawai/data-presensi/data-absen/hapus-file-sk')}}/{{Crypt::encrypt($nosk)}}" onclick="return confirm('Apakah anda yakin ingin menghapus file sk pada data ini ? ');"><i class="fas fa-trash"></i> Hapus File</a>
                                    @else
                                    <button class="btn btn-primary text-white"><i class="fas fa-save text-white"></i> Simpan</button>
                                    @endif
                                </td>
                            </tr>
                            </form>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
