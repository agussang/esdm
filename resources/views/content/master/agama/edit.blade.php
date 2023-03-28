<input type="hidden" name="id" value="{{$rsData->id}}">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Agama</span>
            </div>
            <input type="text" class="form-control" required value="{{$rsData->idagama}}" aria-label="Default" name="idagama" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Agama</span>
            </div>
            <input type="text" class="form-control" required value="{{$rsData->namaagama}}" aria-label="Default" name="namaagama" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
