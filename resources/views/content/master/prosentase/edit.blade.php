<input type="hidden" name="id_prosentase" id="id_prosentase" value="{{$rsData->id_prosentase}}">
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nilai Prosentase</span>
            </div>
            <input type="number" value="{{$rsData->nilai}}" class="form-control" aria-label="Default" max="100" name="nilai" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Kode Realisasi</span>
            </div>
            <select class="form-control" name="kode_p">
                <option value="1" @if($rsData->kode_p==1) selected @endif>P1</option>
                <option value="2" @if($rsData->kode_p==2) selected @endif>P2</option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>

