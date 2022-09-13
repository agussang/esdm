<input type="hidden" name="id_sdm" value="{{$rsData->id_sdm}}" id="id_sdm">
<div class="row">
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nama Pegawai</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$rsData->nm_sdm}}" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Nip Pegawai</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$rsData->nip}}" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Unit Kerja</span>
            </div>
            <input type="text" class="form-control" aria-label="Default" readonly="true" value="{{$rsData->nm_satker->nm_lemb}}" aria-describedby="inputGroup-sizing-default" required>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Atasan Pendamping</span>
            </div>
            <select class="form-control" id="id_sdm_pendamping" name="id_sdm_pendamping">
                {!!$pilihan_sdm_pendamping!!}
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Atasan Langsung</span>
            </div>
            <select class="form-control" id="id_sdm_atasan" name="id_sdm_atasan">
                {!!$pilihan_sdm_atasan!!}
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary pull-right text-white" onclick="simpan_edit();"><i class="fas fa-save text-white"></i> Simpan</a>
    </div>
</div>
