<input type="hidden" value="{{$rsData->id}}" name="id">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Kode Pendidikan</span>
                </div>
                <input type="text" class="form-control"  maxlength="2" aria-label="Default" value="{{$rsData->idpendidikan}}" name="idpendidikan" aria-describedby="inputGroup-sizing-default" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Nama Pendidikan</span>
                </div>
                <input type="text" class="form-control" aria-label="Default" value="{{$rsData->namapendidikan}}" name="namapendidikan" aria-describedby="inputGroup-sizing-default" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
        </div>
    </div>
