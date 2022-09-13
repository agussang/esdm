<style>
.table > tbody > tr > td {
     vertical-align: top;
}
</style>
<style>
.responsive {
  width: 100%;
  height: auto;
}
</style>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Kegiatan</th>
            <th colspan="7"> : {{$data['info_kegiatan']->nama_kegiatan}}</th>
        </tr>
        <tr>
            <th>Tanggal Kegiatan</th>
            <th colspan="7"> : {{date('Y-m-d',strtotime($data['info_kegiatan']->tgl_kegiatan))}}</th>
        </tr>
        <tr>
            <th>Jam Kegiatan</th>
            <th colspan="7"> : {{date('Y-m-d',strtotime($data['info_kegiatan']->tgl_kegiatan))}}</th>
        </tr>
    </thead>
</table>
<table>
    <thead>
        <tr>
            <th colspan="8"><b><i>Mohon untuk tidak merubah Kolom Nip dan tata letak kolom.</i></b></th>
        </tr>
    </thead>
</table>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pegawai</th>
            <th>Nip</th>
            <th>Jenis Kelamin</th>
            <th>Jenis Sdm</th>
            <th>Presensi</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1;?>
        @foreach($data['rsData'] as $rs=>$r)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$r->nm_sdm}}</td>
            <td>&nbsp;{{$r->nip}}</td>
            <td>{{$r->jk}}</td>
            <td>{{$r->nm_jns_sdm->nm_jns_sdm}}</td>
            <td>H</td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
</table>

        