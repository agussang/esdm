<input type="hidden" name="id" value="{{$rsData->id}}">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Indikator</span>
            </div>
            <input type="text" class="form-control" readonly="true" name="kode" id="kode"  value="{{$rsData->kode}}">
        </div>
    </div>
    <div class="col-md-8">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Indikator</span>
            </div>
            <input type="text" class="form-control" name="nama" id="nama" value="{{$rsData->nama}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>