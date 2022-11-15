<input type="hidden" value="{{$rsData->id_pelanggaran}}" name="id_pelanggaran">
<div class="row">
    <div class="col-md-8">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pelanggaran</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->nama_pelanggaran}}" name="nama_pelanggaran" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">% Pengurang</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->prosentase_pengurang}}" name="prosentase_pengurang" aria-describedby="inputGroup-sizing-default" required maxlength="3" onkeypress="return goodchars(event,'1234567890.',this)">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Durasi Berlaku</span>
            </div>
            <select class="form-control" aria-label="Default" name="durasi" aria-describedby="inputGroup-sizing-default" required>
                {!!$list_bulan!!}
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>

