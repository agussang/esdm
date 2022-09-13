<input type="hidden" name="id" id="id" value="{{$rsData->id}}">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Rubrik</span>
            </div>
            <input type="text" class="form-control" name="kode" id="kode" value="{{$rsData->kode}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Satuan</span>
            </div>
            <select name="idsatuan" class="form-control" id="idsatuan" required>
                {!!$pilihan_satuan_rubrik!!}
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Poin</span>
            </div>
            <input type="text" class="form-control" name="poin" id="poin" value="{{$rsData->poin}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Indikator</span>
            </div>
            <textarea class="form-control" name="nama" id="nama" rows="4" cols="50">{{$rsData->nama}}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>