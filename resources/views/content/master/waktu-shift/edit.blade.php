<input type="hidden" name="id" value="{{$rsData->id}}">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Shift</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->kode_shift}}" name="kode_shift" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Shift</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->nm_shift}}" name="nm_shift" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" value="{{$rsData->jam_masuk}}" name="jam_masuk" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk Telat</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" value="{{$rsData->masuk_telat}}" name="masuk_telat" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jama Pulang</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" value="{{$rsData->jam_pulang}}" name="jam_pulang" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang Telat</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" value="{{$rsData->pulang_telat}}" name="pulang_telat" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit_waktu();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
