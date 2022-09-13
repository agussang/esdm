<input type="hidden" name="id" value="{{$rsData->id}}">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Grade</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" name="grade" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->grade}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">N.Jabatan ( Job Score )</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" name="jobscore" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->jobscore}}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">PIR ( Job Price )</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" name="jobprice" aria-describedby="inputGroup-sizing-default" required value="{{$rsData->jobprice}}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>