
<input type="hidden" name="id_sms" value="{{$rsData->id_sms}}">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Satker</span>
            </div>
            <input min="1" type="number" class="form-control" aria-label="Default" name="kode_prodi" aria-describedby="inputGroup-sizing-default" value="{{$rsData->kode_prodi}}" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Satker</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" name="nm_lemb" aria-describedby="inputGroup-sizing-default" value="{{$rsData->nm_lemb}}" required>
        </div>
    </div>
</div><hr/>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary pull-right" onclick="simpan_edit();">Save changes</button>
    </div>
</div>
