<input type="hidden" name="id_sdm" id="id_sdm"value="{{$dt_pegawai->id_sdm}}">
<input type="hidden" name="ket" id="ket"value="{{$ket}}">
<input type="hidden" name="kode" id="kode"value="{{$kode}}">
<input type="hidden" name="jam_masuk" id="jam_masuk"value="{{$jam_kerja['jam_masuk']}}">
<input type="hidden" name="jam_pulang" id="jam_pulang"value="{{$jam_kerja['jam_pulang']}}">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jenis Kehadiran</span>
            </div>
            <input type="text" class="form-control"  value="{{$ket}}" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
            </div>
            <input type="text" class="form-control" name="nm_sdm" id="nm_sdm"  value="{{$dt_pegawai->nm_sdm}}" readonly="true">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Kehadiran</span>
            </div>
            <input type="date" class="form-control" name="tanggal_absen" id="tanggal_absen" value="{{$tgl}}" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Keterangan Justifikasi</label>
            <select class="form-control" name="kategori_justifikasi" id="kategori_justifikasi" required>
                {!!$pilihan_menggangu!!}
            </select>
        </div>
    </div>
    @if($kode!="1")
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Jumlah Justifikasi Dalam Menit</label>
            <input class="form-control" type="number" name="durasi_justifikasi" id="durasi_justifikasi" required value="0">
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
