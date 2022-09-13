<input type="hidden" name="id" id="id" value="{{$rsData['id']}}">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Eselon</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData['namaeselon']}}" aria-describedby="inputGroup-sizing-default" required readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tunjangan</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" id="tunjangan" value="{{$rsData['tunjangan']}}" name="tunjangan" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div><hr/>
<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary pull-right" onclick="simpan_edit();">Simpan</button>
    </div>
</div>