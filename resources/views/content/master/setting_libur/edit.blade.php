<input type="hidden" value="{{$rsData->id_hari_libur}}" name="id_hari_libur">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal Libur</span>
            </div>
            <input type="date" class="form-control" aria-label="Default" value="{{$rsData->tgl_libur}}" name="tgl_libur" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Hari Libur</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->nama_libur}}" name="nama_libur" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
