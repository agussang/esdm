<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
            </div>
            <input type="text" class="form-control" aria-label="Default"  value="{{$rsData->dt_pegawai->nm_sdm}}" readonly="true" aria-describedby="inputGroup-sizing-default" required>
            <input type="hidden" class="form-control" aria-label="Default" name="id_jadwal_shift" value="{{$rsData->id_jadwal_shift}}" readonly="true" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Presensi</span>
            </div>
            <input type="date" class="form-control" value="{{$rsData->tanggal_absen}}" readonly="true" aria-label="Default" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Shift</span>
            </div>
            <select class="form-control" name="id_shift" id="id_shift" required>
                {!!$pilihanjamkerjashift!!}
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
