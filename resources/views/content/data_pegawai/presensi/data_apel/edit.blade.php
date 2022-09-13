<input type="hidden" name="id_kegiatan" class="form-control" required value="{{$rsData->id_kegiatan}}">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Judul Kegiatan</span>
            </div>
            <input type="text" name="nama_kegiatan" class="form-control" required value="{{$rsData->nama_kegiatan}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Kegiatan</span>
            </div>
            <input type="date" name="tgl_kegiatan" class="form-control" required value="{{$rsData->tgl_kegiatan}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Mulai</span>
            </div>
            <input type="time" name="jam_mulai" class="form-control" required value="{{$rsData->jam_mulai}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Selesai</span>
            </div>
            <input type="time" name="jam_selesai" class="form-control" required value="{{$rsData->jam_selesai}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary pull-right" onclick="simpan_edit();"><i class="fas fa-save"></i> Simpan</button>
    </div>
</div>