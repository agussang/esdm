<input type="hidden" name="id_waktu_absen" value="{{$rsData->id}}">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Keterangan Hari</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$kategoriwaktuabsen[$rsData->hari_biasa]}}" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" name="jam_masuk" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->jam_masuk}}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" name="jam_keluar" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->jam_keluar}}">
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Masuk Telat</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" name="masuk_telat" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->masuk_telat}}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Jam Pulang Telat</span>
            </div>
            <input type="time" class="form-control" aria-label="Default" name="pulang_telat" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->pulang_telat}}">
        </div>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit_waktu();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
