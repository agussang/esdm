<input type="hidden" value="{{$rsData->id}}" name="id">
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Status Kepegawaian</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" value="{{$rsData->namastatuspegawai}}" name="namastatuspegawai" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Penerima Remun ?</span>
            </div>
            <select class="form-control" aria-label="Default" name="isremun" aria-describedby="inputGroup-sizing-default" required>
                {!!$pilihan_penerima_remun!!}
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
