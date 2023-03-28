<input type="hidden" name="id_golongan" value="{{$rsData->id_golongan}}">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Golongan</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->kode_golongan}}" name="kode_golongan" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Golongan</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->nama_golongan}}" name="nama_golongan" aria-describedby="inputGroup-sizing-default" required >
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
