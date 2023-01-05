<input type="hidden" name="id_bank" id="id_bank" value="{{$rsData->id_bank}}">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Bank</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" required value="{{$rsData->kode_bank}}" name="kode_bank" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Bank</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" required value="{{$rsData->nama_bank}}" name="nama_bank" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
