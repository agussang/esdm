<input type="hidden" name="id_alasan" id="id_alasan" value="{{$rsData->id_alasan}}">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Alasan Absen </span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->kode_lokal}}" name="kode_lokal" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Alasan Absen</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->alasan}}" name="alasan" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
