<input type="hidden" value="{{$rsData->id_jns_sdm}}" name="id_jns_sdm">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Jenis Sdm</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->kode_lokal}}" name="kode_lokal" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Jenis Sdm</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->nm_jns_sdm}}" name="nm_jns_sdm" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
