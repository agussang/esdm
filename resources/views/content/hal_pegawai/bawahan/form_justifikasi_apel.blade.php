<input type="hidden" name="id_presensi" id="id_presensi"value="{{$rsData->id_presensi}}">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Kegiatan</span>
            </div>
            <input type="text" class="form-control"  value="{{$rsData->nm_kegiatan_apel->nama_kegiatan}}" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
            </div>
            <input type="text" class="form-control"  value="{{$rsData->dt_pegawai->nm_sdm}}" readonly="true">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Kegiatan</span>
            </div>
            <input type="date" class="form-control" value="{{$rsData->nm_kegiatan_apel->tgl_kegiatan}}" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Alasan Justifikasi Kehadiran Apel Pegawai</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required name="alasan" id="alasan"></textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>