@foreach($arrData as $no_sk=>$tgl_sk)
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nomor SK</span>
            </div>
            <input type="text" class="form-control" required value="{{$no_sk}}" aria-label="Default" name="no_sk" aria-describedby="inputGroup-sizing-default" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Tanggal SK</span>
            </div>
            <input type="text" class="form-control" required value="{{$tgl_sk}}" aria-label="Default" aria-describedby="inputGroup-sizing-default" readonly="true">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">File SK</span>
            </div>
            <input type="file" class="form-control" required name="file" accept="application/pdf" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
    </div>
</div>
<br/>
@endforeach
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
