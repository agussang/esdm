@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-block card-stretch card-height iq-border-box iq-border-box-1 text-primary">
            <div class="card-header">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 10px;">
                    <h5 class="card-label mb-0"><i class="fas fa-file-upload"></i> Bulk Upload Data Presensi</h5>
                    <div class="d-flex flex-wrap" style="gap: 8px;">
                        <a href="{{route('data-pegawai.data-presensi.upload-presensi.bulk-upload-template')}}" class="btn btn-sm btn-success">
                            <i class="fas fa-download"></i> Download Template Excel
                        </a>
                        <a href="{{route('data-pegawai.data-presensi.upload-presensi.index')}}" class="btn btn-sm btn-danger">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Info Box --}}
                <div class="alert alert-info" style="border-left: 4px solid #17a2b8;">
                    <h6 class="mb-2"><i class="fas fa-info-circle"></i> Petunjuk Upload</h6>
                    <ol class="mb-0 pl-3" style="font-size: 13px;">
                        <li>Download template Excel terlebih dahulu dengan klik tombol <strong>"Download Template Excel"</strong></li>
                        <li>Isi data sesuai format yang ada di template (hapus contoh baris abu-abu)</li>
                        <li>Kolom wajib: <strong>NIP</strong>, <strong>Tanggal</strong>, <strong>Jam Masuk</strong></li>
                        <li>Kolom opsional: <strong>Jam Pulang</strong>, <strong>Keterangan</strong></li>
                        <li>Data duplikat (NIP + tanggal + jam sama) akan otomatis dilewati</li>
                        <li>Gunakan untuk kasus: <span class="badge badge-warning">Finger Error</span> <span class="badge badge-info">WFH</span> <span class="badge badge-secondary">Dinas Luar</span></li>
                    </ol>
                </div>

                <form action="{{route('data-pegawai.data-presensi.upload-presensi.bulk-upload-process')}}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>File Excel (.xlsx)</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileExcel" name="file_excel" accept=".xlsx" required>
                                    <label class="custom-file-label" for="fileExcel" id="fileLabel">Pilih file excel...</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Sumber / Mesin</strong></label>
                                <select class="form-control" name="mesin">
                                    <option value="MANUAL">MANUAL (Input Admin)</option>
                                    <option value="WFH">WFH (Work From Home)</option>
                                    <option value="DINAS_LUAR">DINAS LUAR</option>
                                    <option value="FINGER_ERROR">FINGER ERROR</option>
                                    {!!$pilihan_mesin_finger!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block" id="btnUpload">
                                    <i class="fas fa-upload"></i> Upload & Proses
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Preview format --}}
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-label mb-0"><i class="fas fa-table"></i> Contoh Format Data</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead style="background-color: #4472C4; color: white;">
                            <tr>
                                <th>NIP</th>
                                <th>NAMA PEGAWAI</th>
                                <th>TANGGAL</th>
                                <th>JAM MASUK</th>
                                <th>JAM PULANG</th>
                                <th>KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>198501012010011001</code></td>
                                <td>Ahmad Suryadi</td>
                                <td>2026-04-01</td>
                                <td>07:30</td>
                                <td>16:00</td>
                                <td><span class="badge badge-info">WFH</span></td>
                            </tr>
                            <tr>
                                <td><code>198501012010011001</code></td>
                                <td>Ahmad Suryadi</td>
                                <td>2026-04-02</td>
                                <td>07:30</td>
                                <td>16:00</td>
                                <td><span class="badge badge-info">WFH</span></td>
                            </tr>
                            <tr>
                                <td><code>199002152015021002</code></td>
                                <td>Siti Aminah</td>
                                <td>2026-04-01</td>
                                <td>07:15</td>
                                <td>16:15</td>
                                <td><span class="badge badge-warning">Finger Error</span></td>
                            </tr>
                            <tr class="table-light">
                                <td colspan="6" class="text-center text-muted" style="font-size: 12px;">
                                    <i class="fas fa-arrow-up"></i> Bisa diisi banyak pegawai sekaligus, banyak tanggal sekaligus
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3" style="font-size: 12px;">
                    <span class="text-danger"><strong>*</strong></span> = Wajib diisi &nbsp;|&nbsp;
                    <strong>NIP</strong><span class="text-danger">*</span>: Harus sesuai data master pegawai &nbsp;|&nbsp;
                    <strong>Tanggal</strong><span class="text-danger">*</span>: Format YYYY-MM-DD &nbsp;|&nbsp;
                    <strong>Jam Masuk</strong><span class="text-danger">*</span>: Format HH:MM &nbsp;|&nbsp;
                    <strong>Jam Pulang</strong>: Opsional &nbsp;|&nbsp;
                    <strong>Keterangan</strong>: Opsional
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    // Show filename on file input change
    document.getElementById('fileExcel').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file excel...';
        document.getElementById('fileLabel').textContent = fileName;
    });

    // Loading state on submit
    document.querySelector('form').addEventListener('submit', function() {
        var btn = document.getElementById('btnUpload');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
</script>
@endpush
@stop
