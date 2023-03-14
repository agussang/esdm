<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LoginController,
    IndexController,
    MasterAgamaController,
    MasterBankController,
    MasterWaktuPresensiController,
    MsJabatanController,
    MsEselonController,
    MsPendidikanController,
    MsGolonganController,
    MsKedinasanController,
    MsStatusKeaktifanController,
    MsStatusKepegawaianController,
    MsPegawaiController,
    MsJnsSdmController,
    SatuanUnitKerjaController,
    RiwayatJabatanController,
    RiwayatPangkatController,
    PresensiController,
    PresensiApelController,
    LaporanPresensiController,
    DataAbsenController,
    ManajemenUserController,
    SettingAppController,
    MasterGradeController,
    SettingPeriodeSkpControler,
    DataSkpController,
    MasterSkpController,
    SettingAtasanPegawaiController,
    SkpPrilakuPegawaiController,
    TargetSkpPegawaiController,
    ApiController,
    MasterKategoriPelanggaranController,
    DataPelanggaranPegawaiController,
    SettingHariLiburController,
    MasterAlasanAbsenController,
    TrLogloginController,
    MsWaktuShiftController,
    JadwalPresensiShiftController,
    SettingTanggalRamadhanController,
    MasterProsentaseController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('/');
Route::post('/login', [LoginController::class, 'proses_login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/login-as/{id?}', [LoginController::class, 'loginas'])->name('loginas');
Route::get('/ubahpassword', [LoginController::class, 'ubahpassword'])->name('ubahpassword');
Route::post('/ubahpassword/simpan', [LoginController::class, 'simpan_ubah_password'])->name('ubahpassword.simpan');

Route::group(['middleware' => 'role:SA_A_PI_B'], function () {
    Route::get('home',[IndexController::class,'index'])->name('home');
    Route::group(['prefix' => 'data-master'], function () {
        Route::group(['prefix' => 'waktu-shift'], function () {
            Route::get('/',[MsWaktuShiftController::class,'index'])->name('data-master.waktu-shift');
            Route::get('edit',[MsWaktuShiftController::class,'edit'])->name('data-master.waktu-shift.edit');
            Route::post('/simpan',[MsWaktuShiftController::class,'store'])->name('data-master.waktu-shift.simpan');
            Route::post('/update',[MsWaktuShiftController::class,'update'])->name('data-master.waktu-shift.update');
            Route::get('hapus/{id}',[MsWaktuShiftController::class,'destroy'])->name('data-master.waktu-shift.hapus');
        });

        Route::group(['prefix' => 'alasan-absen'], function () {
            Route::get('/',[MasterAlasanAbsenController::class,'index'])->name('data-master.alasan-absen');
            Route::get('edit',[MasterAlasanAbsenController::class,'edit'])->name('data-master.alasan-absen.edit');
            Route::post('/simpan',[MasterAlasanAbsenController::class,'store'])->name('data-master.alasan-absen.simpan');
            Route::post('/update',[MasterAlasanAbsenController::class,'update'])->name('data-master.alasan-absen.update');
            Route::get('hapus/{id}',[MasterAlasanAbsenController::class,'destroy'])->name('data-master.alasan-absen.hapus');
        });

        Route::group(['prefix' => 'agama'], function () {
            Route::get('/',[MasterAgamaController::class,'index'])->name('data-master.agama');
            Route::get('edit',[MasterAgamaController::class,'edit'])->name('data-master.agama.edit');
            Route::post('/simpan',[MasterAgamaController::class,'store'])->name('data-master.agama.simpan');
            Route::post('/update',[MasterAgamaController::class,'update'])->name('data-master.agama.update');
        });

        Route::group(['prefix' => 'bank'], function () {
            Route::get('/',[MasterBankController::class,'index'])->name('data-master.bank');
            Route::get('/tambah',[MasterBankController::class,'create'])->name('data-master.bank.tambah');
            Route::get('edit',[MasterBankController::class,'edit'])->name('data-master.bank.edit');
            Route::post('/update',[MasterBankController::class,'update'])->name('data-master.bank.update');
            Route::post('/simpan',[MasterBankController::class,'store'])->name('data-master.bank.simpan');
        });

        Route::group(['prefix' => 'waktu-presensi'], function () {
            Route::get('/',[MasterWaktuPresensiController::class,'index'])->name('data-master.waktu-presensi');
            Route::get('edit',[MasterWaktuPresensiController::class,'edit'])->name('data-master.waktu-presensi.edit');
            Route::get('hapus/{id}',[MasterWaktuPresensiController::class,'destroy'])->name('data-master.waktu-presensi.hapus');
            Route::post('/update',[MasterWaktuPresensiController::class,'update'])->name('data-master.waktu-presensi.update');
            Route::post('/simpan',[MasterWaktuPresensiController::class,'store'])->name('data-master.waktu-presensi.simpan');
        });

        Route::group(['prefix' => 'jabatan'], function () {
            Route::get('/',[MsJabatanController::class,'index'])->name('data-master.jabatan');
            Route::get('/tambah',[MsJabatanController::class,'create'])->name('data-master.jabatan.tambah');
            Route::post('/simpan',[MsJabatanController::class,'store'])->name('data-master.jabatan.simpan');
            Route::post('/cari',[MsJabatanController::class,'cari'])->name('data-master.jabatan.cari');
            Route::get('hapus/{id}',[MsJabatanController::class,'destroy'])->name('data-master.jabatan.hapus');
            Route::get('edit/{id}',[MsJabatanController::class,'edit'])->name('data-master.jabatan.edit');
            Route::post('/update',[MsJabatanController::class,'update'])->name('data-master.jabatan.update');
        });

        Route::group(['prefix' => 'eselon'], function () {
            Route::get('/',[MsEselonController::class,'index'])->name('data-master.eselon');
            Route::get('edit',[MsEselonController::class,'edit'])->name('data-master.eselon.edit');
            Route::post('/update',[MsEselonController::class,'update'])->name('data-master.eselon.update');
        });

        Route::group(['prefix' => 'pendidikan'], function () {
            Route::get('/',[MsPendidikanController::class,'index'])->name('data-master.pendidikan');
            Route::post('/simpan',[MsPendidikanController::class,'store'])->name('data-master.pendidikan.simpan');
            Route::get('hapus/{id?}',[MsPendidikanController::class,'destroy'])->name('data-master.pendidikan.hapus');
            Route::get('edit',[MsPendidikanController::class,'edit'])->name('data-master.pendidikan.edit');
            Route::post('/update',[MsPendidikanController::class,'update'])->name('data-master.pendidikan.update');
        });

        Route::group(['prefix' => 'tanggal-ramadhan'], function () {
            Route::get('/',[SettingTanggalRamadhanController::class,'index'])->name('data-master.tanggal-ramadhan');
            Route::post('/cari',[SettingTanggalRamadhanController::class,'cari'])->name('data-master.tanggal-ramadhan.cari');
            Route::get('tambah',[SettingTanggalRamadhanController::class,'create'])->name('data-master.tanggal-ramadhan.tambah');
            Route::post('/simpan',[SettingTanggalRamadhanController::class,'store'])->name('data-master.tanggal-ramadhan.simpan');
            Route::get('hapus/{id?}',[SettingTanggalRamadhanController::class,'destroy'])->name('data-master.tanggal-ramadhan.hapus');
            Route::get('edit/{id?}',[SettingTanggalRamadhanController::class,'edit'])->name('data-master.tanggal-ramadhan.edit');
            Route::post('/update',[SettingTanggalRamadhanController::class,'update'])->name('data-master.tanggal-ramadhan.update');
        });

        Route::group(['prefix' => 'kategori-pelanggaran'], function () {
            Route::get('/',[MasterKategoriPelanggaranController::class,'index'])->name('data-master.kategori-pelanggaran');
            Route::post('/simpan',[MasterKategoriPelanggaranController::class,'store'])->name('data-master.kategori-pelanggaran.simpan');
            Route::get('edit',[MasterKategoriPelanggaranController::class,'edit'])->name('data-master.kategori-pelanggaran.edit');
            Route::post('/update',[MasterKategoriPelanggaranController::class,'update'])->name('data-master.kategori-pelanggaran.update');
            Route::get('hapus/{id?}',[MasterKategoriPelanggaranController::class,'destroy'])->name('data-master.kategori-pelanggaran.hapus');
        });

        Route::group(['prefix' => 'golongan'], function () {
            Route::get('/',[MsGolonganController::class,'index'])->name('data-master.golongan');
            Route::post('/simpan',[MsGolonganController::class,'store'])->name('data-master.golongan.simpan');
            Route::get('edit',[MsGolonganController::class,'edit'])->name('data-master.golongan.edit');
            Route::post('/update',[MsGolonganController::class,'update'])->name('data-master.golongan.update');
            Route::get('hapus/{id?}',[MsGolonganController::class,'destroy'])->name('data-master.golongan.hapus');

        });

        Route::group(['prefix' => 'grade'], function () {
            Route::get('/tmp-grade',[MasterGradeController::class,'tmp_grade'])->name('data-master.grade.tmp-grade');
            Route::get('/',[MasterGradeController::class,'index'])->name('data-master.grade');
            Route::post('/simpan',[MasterGradeController::class,'store'])->name('data-master.grade.simpan');
            Route::get('edit',[MasterGradeController::class,'edit'])->name('data-master.grade.edit');
            Route::post('/update',[MasterGradeController::class,'update'])->name('data-master.grade.update');
            Route::get('hapus/{id}',[MasterGradeController::class,'destroy'])->name('data-master.grade.hapus');
            Route::post('update_realisasi_p1',[MasterGradeController::class,'update_realisasi_p1'])->name('data-master.grade.update_realisasi_p1');
            Route::post('update_realisasi_p2',[MasterGradeController::class,'update_realisasi_p2'])->name('data-master.grade.update_realisasi_p2');
        });

        Route::group(['prefix' => 'prosentase'], function () {
            Route::get('/',[MasterProsentaseController::class,'index'])->name('data-master.prosentase');
            Route::post('/simpan',[MasterProsentaseController::class,'store'])->name('data-master.prosentase.simpan');
            Route::get('edit',[MasterProsentaseController::class,'edit'])->name('data-master.prosentase.edit');
            Route::post('/update',[MasterProsentaseController::class,'update'])->name('data-master.prosentase.update');
        });

        Route::group(['prefix' => 'kedinasan'], function () {
            Route::get('/',[MsKedinasanController::class,'index'])->name('data-master.kedinasan');
            Route::post('/simpan',[MsKedinasanController::class,'store'])->name('data-master.kedinasan.simpan');
            Route::get('edit',[MsKedinasanController::class,'edit'])->name('data-master.kedinasan.edit');
            Route::post('/update',[MsKedinasanController::class,'update'])->name('data-master.kedinasan.update');
            Route::get('hapus/{id}',[MsKedinasanController::class,'destroy'])->name('data-master.kedinasan.hapus');

        });

        Route::group(['prefix' => 'status-aktif'], function () {
            Route::get('/',[MsStatusKeaktifanController::class,'index'])->name('data-master.status-aktif');
            Route::post('/simpan',[MsStatusKeaktifanController::class,'store'])->name('data-master.status-aktif.simpan');
            Route::get('edit',[MsStatusKeaktifanController::class,'edit'])->name('data-master.status-aktif.edit');
            Route::post('/update',[MsStatusKeaktifanController::class,'update'])->name('data-master.status-aktif.update');
            Route::get('hapus/{id}',[MsStatusKeaktifanController::class,'destroy'])->name('data-master.status-aktif.hapus');

        });

        Route::group(['prefix' => 'status-kepegawaian'], function () {
            Route::get('/',[MsStatusKepegawaianController::class,'index'])->name('data-master.status-kepegawaian');
            Route::post('/simpan',[MsStatusKepegawaianController::class,'store'])->name('data-master.status-kepegawaian.simpan');
            Route::get('edit',[MsStatusKepegawaianController::class,'edit'])->name('data-master.status-kepegawaian.edit');
            Route::post('/update',[MsStatusKepegawaianController::class,'update'])->name('data-master.status-kepegawaian.update');
            Route::get('hapus/{id}',[MsStatusKepegawaianController::class,'destroy'])->name('data-master.status-kepegawaian.hapus');

        });

        Route::group(['prefix' => 'jenis-sdm'], function () {
            Route::get('/',[MsJnsSdmController::class,'index'])->name('data-master.jenis-sdm');
            Route::post('/simpan',[MsJnsSdmController::class,'store'])->name('data-master.jenis-sdm.simpan');
            Route::get('edit',[MsJnsSdmController::class,'edit'])->name('data-master.jenis-sdm.edit');
            Route::post('/update',[MsJnsSdmController::class,'update'])->name('data-master.jenis-sdm.update');
            Route::get('hapus/{id}',[MsJnsSdmController::class,'destroy'])->name('data-master.jenis-sdm.hapus');

        });

        Route::group(['prefix' => 'satuan-unit-kerja'], function () {
            Route::get('/',[SatuanUnitKerjaController::class,'index'])->name('data-master.satuan-unit-kerja');
            Route::post('/simpan',[SatuanUnitKerjaController::class,'store'])->name('data-master.satuan-unit-kerja.simpan');
            Route::get('edit',[SatuanUnitKerjaController::class,'edit'])->name('data-master.satuan-unit-kerja.edit');
            Route::post('/update',[SatuanUnitKerjaController::class,'update'])->name('data-master.satuan-unit-kerja.update');
            Route::get('hapus/{id}',[SatuanUnitKerjaController::class,'destroy'])->name('data-master.satuan-unit-kerja.hapus');
        });


        Route::group(['prefix' => 'hari-libur'], function () {
            Route::get('/',[SettingHariLiburController::class,'index'])->name('data-master.hari-libur');
            Route::post('/simpan',[SettingHariLiburController::class,'store'])->name('data-master.hari-libur.simpan');
            Route::get('edit',[SettingHariLiburController::class,'edit'])->name('data-master.hari-libur.edit');
            Route::post('/update',[SettingHariLiburController::class,'update'])->name('data-master.hari-libur.update');
            Route::get('hapus/{id}',[SettingHariLiburController::class,'destroy'])->name('data-master.hari-libur.hapus');

        });
    });

    Route::group(['prefix' => 'data-pegawai'], function () {
        Route::group(['prefix' => 'master-pegawai'], function () {
            Route::get('/',[MsPegawaiController::class,'index'])->name('data-pegawai.master-pegawai.index');
            Route::get('/tambah',[MsPegawaiController::class,'create'])->name('data-pegawai.master-pegawai.tambah');
            Route::get('/detil-data/{id}',[MsPegawaiController::class,'show'])->name('data-pegawai.master-pegawai.detil-data');
            Route::post('/simpan',[MsPegawaiController::class,'store'])->name('data-pegawai.master-pegawai.simpan');
            Route::post('/cari',[MsPegawaiController::class,'cari'])->name('data-pegawai.master-pegawai.cari');
            Route::post('/update',[MsPegawaiController::class,'update'])->name('data-pegawai.master-pegawai.update');

            Route::get('/import',[MsPegawaiController::class,'import'])->name('data-pegawai.master-pegawai.import');
            Route::post('/simpan-import',[MsPegawaiController::class,'gasimport'])->name('data-pegawai.master-pegawai.simpan-import');

            Route::get('/import/rekening',[MsPegawaiController::class,'import_rekening'])->name('data-pegawai.master-pegawai.import-rekening');
            Route::post('/simpan-import-rekening',[MsPegawaiController::class,'gasimport_rekening'])->name('data-pegawai.master-pegawai.simpan-import-rekening');

            Route::post('/update-foto',[MsPegawaiController::class,'update_foto'])->name('data-pegawai.master-pegawai.update-foto');

        });

        Route::group(['prefix' => 'pelanggaran'], function () {
            Route::get('/',[DataPelanggaranPegawaiController::class,'index'])->name('data-pegawai.pelanggaran.index');
            Route::post('/cari',[DataPelanggaranPegawaiController::class,'cari'])->name('data-pegawai.pelanggaran.cari');
            Route::get('/tambah',[DataPelanggaranPegawaiController::class,'create'])->name('data-pegawai.pelanggaran.tambah');
            Route::post('/simpan',[DataPelanggaranPegawaiController::class,'store'])->name('data-pegawai.pelanggaran.simpan');
            Route::get('/edit/{id}',[DataPelanggaranPegawaiController::class,'edit'])->name('data-pegawai.master-pegawai.edit');
            Route::post('/update',[DataPelanggaranPegawaiController::class,'update'])->name('data-pegawai.pelanggaran.update');
            Route::get('/hapus/{id}',[DataPelanggaranPegawaiController::class,'destroy'])->name('data-pegawai.master-pegawai.hapus');
        });

        Route::group(['prefix' => 'riwayat'], function () {
            Route::group(['prefix' => 'jabatan'], function () {
                Route::get('/{id}',[RiwayatJabatanController::class,'index'])->name('data-pegawai.riwayat.jabatan');
                Route::post('/simpan',[RiwayatJabatanController::class,'store'])->name('data-pegawai.riwayat.jabatan.simpan');
            });
            Route::group(['prefix' => 'pangkat'], function () {
                Route::get('/{id}',[RiwayatPangkatController::class,'index'])->name('data-pegawai.riwayat.pangkat');
                Route::post('/simpan',[RiwayatPangkatController::class,'store'])->name('data-pegawai.riwayat.pangkat.simpan');
            });
        });
        Route::group(['prefix' => 'atasan-pegawai'], function () {
            Route::get('/',[SettingAtasanPegawaiController::class,'index'])->name('data-pegawai.atasan-pegawai.index');
            Route::get('/edit',[SettingAtasanPegawaiController::class,'edit'])->name('data-pegawai.atasan-pegawai.edit');
            Route::post('/simpan',[SettingAtasanPegawaiController::class,'store'])->name('data-pegawai.atasan-pegawai.simpan');
        });

        Route::group(['prefix' => 'data-presensi'], function () {
            Route::group(['prefix' => 'upload-presensi'], function () {
                Route::get('/',[PresensiController::class,'index'])->name('data-pegawai.data-presensi.upload-presensi.index');
                Route::get('/clear',[PresensiController::class,'clear'])->name('data-pegawai.data-presensi.upload-presensi.clear');
                Route::post('/simpan',[PresensiController::class,'store'])->name('data-pegawai.data-presensi.upload-presensi.simpan');
                Route::post('/upload',[PresensiController::class,'upload'])->name('data-pegawai.data-presensi.upload-presensi.upload');
                Route::post('/sync-finger',[PresensiController::class,'sync_finger'])->name('data-pegawai.data-presensi.upload-presensi.sync-finger');
            });

            Route::group(['prefix' => 'jadwal-presensi-shift'], function () {
                Route::get('/',[JadwalPresensiShiftController::class,'index'])->name('data-pegawai.data-presensi.jadwal-presensi-shift.index');
                Route::post('/cari',[JadwalPresensiShiftController::class,'cari'])->name('data-pegawai.data-presensi.jadwal-presensi-shift.search');
                Route::get('/import-jadwal',[JadwalPresensiShiftController::class,'import'])->name('data-pegawai.data-presensi.jadwal-presensi-shift.import-jadwal');
            });

            Route::group(['prefix' => 'apel'], function () {
                Route::get('/',[PresensiApelController::class,'index'])->name('data-pegawai.data-presensi.apel.index');
                Route::get('/tambah',[PresensiApelController::class,'create'])->name('data-pegawai.data-presensi.apel.tambah');
                Route::post('/simpan',[PresensiApelController::class,'store'])->name('data-pegawai.data-presensi.apel.simpan');
                Route::get('hapus/{id}',[PresensiApelController::class,'destroy'])->name('data-pegawai.data-presensi.apel.hapus');
                Route::get('edit/',[PresensiApelController::class,'edit'])->name('data-pegawai.data-presensi.apel.edit');
                Route::post('/update',[PresensiApelController::class,'update'])->name('data-pegawai.data-presensi.apel.update');
                Route::post('/cari',[PresensiApelController::class,'cari'])->name('data-pegawai.data-presensi.apel.cari');

                Route::group(['prefix' => 'peserta'], function () {
                    Route::get('/{id?}',[PresensiApelController::class,'peserta'])->name('data-pegawai.data-presensi.apel.peserta');
                    Route::get('download/{id?}',[PresensiApelController::class,'download_template'])->name('data-pegawai.data-presensi.apel.download-template');
                    Route::post('/upload',[PresensiApelController::class,'upload'])->name('data-pegawai.data-presensi.apel.peserta.upload');
                    Route::get('/clear/{id}',[PresensiApelController::class,'clear'])->name('data-pegawai.data-presensi.apel.peserta.clear');
                });
            });
        });
    });

    Route::group(['prefix' => 'laporan'], function () {
        Route::group(['prefix' => 'presensi-kehadiran'], function () {
            Route::get('/',[LaporanPresensiController::class,'index'])->name('laporan.presensi-kehadiran.index');
            Route::get('/cari-pegawai',[LaporanPresensiController::class,'cari_pegawai'])->name('laporan.presensi-kehadiran.cari-pegawai');
            Route::post('/cari-presensi',[LaporanPresensiController::class,'cari_presensi'])->name('laporan.presensi-kehadiran.cari-presensi');
        });

        Route::group(['prefix' => 'presensi-apel'], function () {
            //belum
        });
            //belum
        Route::group(['prefix' => 'data-absen'], function () {

        });
    });

    Route::group(['prefix' => 'skp'], function () {
        Route::group(['prefix' => 'setting-skp'], function () {
            Route::get('/',[SettingPeriodeSkpControler::class,'index'])->name('skp.setting-skp.index');
            Route::post('/cari',[SettingPeriodeSkpControler::class,'cari'])->name('skp.setting-skp.cari');
            Route::get('/update_status',[SettingPeriodeSkpControler::class,'update_status'])->name('skp.setting-skp.update_status');
            Route::post('/update-batas-skp',[SettingPeriodeSkpControler::class,'update_batas_skp'])->name('skp.setting-skp.update-batas-skp');
        });

        Route::group(['prefix' => 'master-skp'], function () {
            Route::group(['prefix' => 'prilaku'], function () {
                Route::get('/',[MasterSkpController::class,'prilaku'])->name('skp.master-skp.prilaku.index');
                Route::get('hapus/{id?}',[MasterSkpController::class,'hapus_prilaku'])->name('skp.master-skp.prilaku.hapus');
                Route::post('simpan',[MasterSkpController::class,'simpan_prilaku'])->name('skp.master-skp.prilaku.simpan');
                Route::get('edit',[MasterSkpController::class,'edit_prilaku'])->name('skp.master-skp.prilaku.edit_prilaku');
                Route::get('update_status',[MasterSkpController::class,'update_prilaku'])->name('skp.master-skp.prilaku.update_status');
                Route::post('update',[MasterSkpController::class,'update_prilaku'])->name('skp.master-skp.prilaku.update_prilaku');
            });
            Route::group(['prefix' => 'satuan'], function () {
                Route::get('/',[MasterSkpController::class,'satuan'])->name('skp.master-skp.satuan');
                Route::get('/hapus/{id?}',[MasterSkpController::class,'hapus_satuan'])->name('skp.master-skp.satuan.hapus');
                Route::post('/simpan',[MasterSkpController::class,'simpan_satuan'])->name('skp.master-skp.satuan.simpan');
                Route::get('edit',[MasterSkpController::class,'edit_satuan'])->name('skp.master-skp.satuan.edit_satuan');
                Route::get('update_status',[MasterSkpController::class,'update_satuan'])->name('skp.master-skp.satuan.update_status');
                Route::post('update',[MasterSkpController::class,'update_satuan'])->name('skp.master-skp.satuan.update_satuan');
            });
            Route::group(['prefix' => 'rubrik'], function () {
                Route::get('/',[MasterSkpController::class,'rubrik'])->name('skp.master-skp.rubrik');
                Route::get('/edit-rubrik',[MasterSkpController::class,'edit_rubrik'])->name('skp.master-skp.rubrik.edit-rubrik');
                Route::post('/simpan',[MasterSkpController::class,'simpan_rubrik'])->name('skp.master-skp.rubrik.simpan');
                Route::post('/update',[MasterSkpController::class,'update_rubrik'])->name('skp.master-skp.rubrik.update_rubrik');
                Route::get('/hapus/{id?}',[MasterSkpController::class,'hapus_rubrik'])->name('skp.master-skp.satuan.hapus_rubrik');
            });
        });
    });

    Route::group(['prefix' => 'setting'], function () {

        Route::group(['prefix' => 'app'], function () {
            Route::get('/',[SettingAppController::class,'index'])->name('setting.app.index');
            Route::post('/update',[SettingAppController::class,'update'])->name('setting.app.update');
        });

        Route::group(['prefix' => 'log-login'], function () {
            Route::get('/',[TrLogloginController::class,'index'])->name('setting.log-login.index');
            Route::post('/cari',[TrLogloginController::class,'cari'])->name('setting.log-login.search');
        });

        Route::group(['prefix' => 'manajemen-user'], function () {
            Route::get('/',[ManajemenUserController::class,'index'])->name('setting.manajemen-user.index');
            Route::get('/tambah',[ManajemenUserController::class,'create'])->name('setting.manajemen-user.tambah');
            Route::get('/re-index-user',[ManajemenUserController::class,'reindex'])->name('setting.manajemen-user.re-index-user');
            Route::post('/simpan',[ManajemenUserController::class,'store'])->name('setting.manajemen-user.simpan');
            Route::get('/edit/{id?}',[ManajemenUserController::class,'edit'])->name('setting.manajemen-user.edit');
            Route::post('/update',[ManajemenUserController::class,'update'])->name('setting.manajemen-user.update');
            Route::get('update_status',[ManajemenUserController::class,'update'])->name('setting.manajemen-user.update_status');
            Route::get('/hapus/{id?}',[ManajemenUserController::class,'destroy'])->name('setting.manajemen-user.hapus');
            Route::get('/login-as/{id?}',[ManajemenUserController::class,'login_as'])->name('setting.manajemen-user.login-as');
            Route::post('/cari',[ManajemenUserController::class,'cari'])->name('setting.manajemen-user.cari');
        });
    });


});
Route::group(['middleware' => 'role:P_SA_A_PI_B'], function () {
    Route::group(['prefix' => 'skp'], function () {
        Route::group(['prefix' => 'data-skp'], function () {
            Route::get('/',[DataSkpController::class,'index'])->name('skp.data-skp.index');
            Route::get('penilaian-skp/{id_periode?}/{id_sdm?}',[SkpPrilakuPegawaiController::class,'penilaian'])->name('skp.data-skp.penilaian-skp');
            Route::post('/cari',[DataSkpController::class,'cari'])->name('skp.data-skp.cari');
            Route::post('/simpan-penilaian-skp',[SkpPrilakuPegawaiController::class,'simpan_penilaian_skp'])->name('skp.data-skp.simpan-penilaian-skp');
        });
    });
    Route::group(['prefix' => 'data-pegawai'], function () {
        Route::group(['prefix' => 'data-presensi'], function () {
            Route::group(['prefix' => 'data-absen'], function () {
                Route::get('/',[DataAbsenController::class,'index'])->name('data-pegawai.data-presensi.data-absen.index');
                Route::get('/tambah',[DataAbsenController::class,'create'])->name('data-pegawai.data-presensi.data-absen.tambah');
                Route::post('/simpan',[DataAbsenController::class,'store'])->name('data-pegawai.data-presensi.data-absen.simpan');
                Route::get('/edit/{id?}',[DataAbsenController::class,'edit'])->name('data-pegawai.data-presensi.data-absen.edit');
                Route::post('/update',[DataAbsenController::class,'update'])->name('data-pegawai.data-presensi.data-absen.update');
                Route::post('/cari',[DataAbsenController::class,'cari'])->name('data-pegawai.data-presensi.data-absen.cari');
                Route::get('/hapus/{id?}',[DataAbsenController::class,'destroy'])->name('data-pegawai.data-presensi.data-absen.delete');
                Route::get('/verifikasi/{id?}',[DataAbsenController::class,'verifikasi'])->name('data-pegawai.data-presensi.data-absen.verifikasi');
                Route::post('/simpan_verifikasi',[DataAbsenController::class,'simpan_verifikasi'])->name('data-pegawai.data-presensi.data-absen.simpan_verifikasi');

                Route::get('/import',[DataAbsenController::class,'import'])->name('data-pegawai.data-presensi.data-absen.import');
                Route::post('/import-simpan',[DataAbsenController::class,'gasimport'])->name('data-pegawai.data-presensi.data-absen.import-simpan');
                Route::get('/clear',[DataAbsenController::class,'clear'])->name('data-pegawai.data-presensi.data-absen.clear');

                Route::get('/hapus-file-sk/{id?}',[DataAbsenController::class,'hapus_file'])->name('data-pegawai.data-presensi.data-absen.hapus-file-sk');
                Route::get('/unggah-sk',[DataAbsenController::class,'unggah_sk'])->name('data-pegawai.data-presensi.data-absen.unggah-sk');
                Route::post('/unggah-sk-cari',[DataAbsenController::class,'cari_sk'])->name('data-pegawai.data-presensi.data-absen.unggah-sk-cari');
                Route::post('/unggah-file-sk-simpan',[DataAbsenController::class,'unggah_file_sk_simpan'])->name('data-pegawai.data-presensi.data-absen.unggah-file-sk-simpan');
            });
        });
    });
});
Route::group(['middleware' => 'role:P_SA_A_PI'], function () {
    Route::get('beranda',[IndexController::class,'index'])->name('beranda');
    Route::group(['prefix' => 'justifikasi'], function () {
        Route::get('/pengajuan/{id_sdm?}/{tanggal?}/{kode?}',[MsPegawaiController::class,'pengajuan_justifikasi'])->name('justifikasi.pengajuan');
        Route::post('simpan-pengajuan',[MsPegawaiController::class,'simpan_pengajuan'])->name('justifikasi.simpan-pengajuan-justifikasi');
    });
    Route::group(['prefix' => 'pegawai'], function () {
        Route::get('/riwayat-apel/{id?}',[MsPegawaiController::class,'riwayat_apel'])->name('pegawai.riwayat-apel');
        Route::post('/cari/apel',[MsPegawaiController::class,'cari_apel'])->name('pegawai.cari.apel');

        Route::get('/riwayat-kehadiran/{id?}',[MsPegawaiController::class,'riwayat_kehadiran'])->name('pegawai.riwayat-kehadiran');
        Route::post('/cari/kehadiran',[MsPegawaiController::class,'cari_kehadiran'])->name('pegawai.cari.kehadiran');
        Route::get('/justifikasi-kehadiran-pegawai/{id_sdm?}/{tanggal?}/{kode?}',[MsPegawaiController::class,'justifikasi_kehadiran_pegawai'])->name('pegawai.justifikasi-kehadiran-pegawai');
        Route::post('simpan-pengajuan',[MsPegawaiController::class,'simpan_justifikasi_by_admin'])->name('pegawai.simpan-pengajuan-justifikasi');

        Route::get('/riwayat-absen/{id?}',[MsPegawaiController::class,'riwayat_absen'])->name('pegawai.riwayat-absen');
        Route::post('/cari/absen',[MsPegawaiController::class,'cari_absen'])->name('pegawai.cari.absen');
        Route::get('/riwayat-absen-tambah',[MsPegawaiController::class,'tambah_riwayat_absen'])->name('pegawai.riwayat-absen.tambah');
        Route::post('/riwayat-absen-tambah-simpan',[MsPegawaiController::class,'tambah_riwayat_absen_simpan'])->name('pegawai.riwayat-absen.tambah.simpan');

        Route::get('detil/{id?}',[MsPegawaiController::class,'show'])->name('pegawai.detil-data');
        Route::post('/update',[MsPegawaiController::class,'update'])->name('pegawai.update');

    });

    Route::group(['prefix' => 'data-absen'], function () {
        Route::get('/',[DataAbsenController::class,'index'])->name('data-presensi.data-absen.index');
        Route::get('/tambah',[DataAbsenController::class,'create'])->name('data-presensi.data-absen.tambah');
        Route::post('/simpan',[DataAbsenController::class,'store'])->name('data-presensi.data-absen.simpan');
        Route::get('/edit/{id?}',[DataAbsenController::class,'edit'])->name('data-presensi.data-absen.edit');
        Route::post('/update',[DataAbsenController::class,'update'])->name('data-presensi.data-absen.update');
        Route::post('/cari',[DataAbsenController::class,'cari'])->name('data-presensi.data-absen.cari');
        Route::get('/hapus/{id?}',[DataAbsenController::class,'destroy'])->name('data-presensi.data-absen.delete');
        Route::get('/verifikasi/{id?}',[DataAbsenController::class,'verifikasi'])->name('data-presensi.data-absen.verifikasi');
        Route::post('/simpan_verifikasi',[DataAbsenController::class,'simpan_verifikasi'])->name('data-presensi.data-absen.simpan_verifikasi');
    });

    Route::group(['prefix' => 'pegawai-bawahan'], function () {
        Route::get('/detil/{id?}',[MsPegawaiController::class,'show'])->name('pegawai-bawahan.detil_pegawai');
        Route::get('/pegawai',[MsPegawaiController::class,'bawahan'])->name('pegawai-bawahan.pegawai');
        Route::post('/cari',[MsPegawaiController::class,'cari_bawahan'])->name('pegawai-bawahan.cari');
        Route::get('/approve-justifikasi/{id_sdm?}/{tahun?}/{bulan?}',[MsPegawaiController::class,'form_approve_justifikasi'])->name('pegawai-bawahan.approve-justifikasi');
        Route::get('/proses-justifikasi/{id_justifikasi?}',[MsPegawaiController::class,'proses_justifikasi'])->name('pegawai-bawahan.proses-justifikasi');
        Route::post('simpan-proses-pengajuan-justifikasi',[MsPegawaiController::class,'simpan_proses_pengajuan'])->name('pegawai-bawahan.simpan-proses-pengajuan-justifikasi');


        Route::get('/riwayat-apel/{id?}',[MsPegawaiController::class,'riwayat_apel'])->name('pegawai-bawahan.riwayat-apel');
        Route::post('/cari/apel',[MsPegawaiController::class,'cari_apel_bawahan'])->name('pegawai-bawahan.cari.apel');

        Route::get('/riwayat-kehadiran/{id?}',[MsPegawaiController::class,'riwayat_kehadiran'])->name('pegawai-bawahan.riwayat-kehadiran');
        Route::post('/cari/kehadiran',[MsPegawaiController::class,'cari_kehadiran_bawahan'])->name('pegawai-bawahan.cari.kehadiran');

        Route::get('/riwayat-absen/{id?}',[MsPegawaiController::class,'riwayat_absen'])->name('pegawai-bawahan.riwayat-absen');
        Route::post('/cari/absen',[MsPegawaiController::class,'cari_absen_bawahan'])->name('pegawai-bawahan.cari.absen');

        Route::get('/justifikasi/{id_sdm?}/{bulan?}/{tahun?}',[MsPegawaiController::class,'justifikasi'])->name('pegawai-bawahan.justifikasi');
        Route::get('/gen-justifikasi',[MsPegawaiController::class,'gen_justifikasi_kehadiran'])->name('pegawai-bawahan.gen-justifikasi');
        Route::post('/save-gen-justifikasi',[MsPegawaiController::class,'save_justifikasi_kehadiran'])->name('pegawai-bawahan.save-gen-justifikasi');

        Route::get('/justifikasi-apel/{id_sdm?}/{bulan?}/{tahun?}',[MsPegawaiController::class,'justifikasi_apel'])->name('pegawai-bawahan.justifikasi-apel');
        Route::get('/gen-justifikasi-apel',[MsPegawaiController::class,'gen_justifikasi_apel'])->name('pegawai-bawahan.gen-justifikasi-apel');
        Route::post('/save-gen-justifikasi-apel',[MsPegawaiController::class,'save_justifikasi_apel'])->name('pegawai-bawahan.save-gen-justifikasi-apel');
    });

    Route::group(['prefix' => 'skp-pegawai'], function () {
        Route::group(['prefix' => 'target-skp'], function () {
            Route::get('/{id_sdm?}',[TargetSkpPegawaiController::class,'index'])->name('skp-pegawai.target-skp.index');
            Route::get('/isi_skp/{id?}',[TargetSkpPegawaiController::class,'create'])->name('skp-pegawai.target-skp.isi_skp');
            Route::post('/simpan',[TargetSkpPegawaiController::class,'store'])->name('skp-pegawai.target-skp.simpan');
        });
        Route::group(['prefix' => 'skp'], function () {
            Route::get('/{id_sdm?}',[SkpPrilakuPegawaiController::class,'prilaku'])->name('skp-pegawai.skp.index');

            Route::get('detil-skp/{id_periode?}/{id_sdm?}',[SkpPrilakuPegawaiController::class,'edit'])->name('skp-pegawai.skp.detil-skp');
            Route::get('reset-penilaian-skp/{id_periode?}/{id_sdm?}',[SkpPrilakuPegawaiController::class,'reset_penilaian'])->name('skp-pegawai.skp.reset-penilaian-skp');

            Route::post('/cari',[SkpPrilakuPegawaiController::class,'cari'])->name('skp-pegawai.skp.cari');
            Route::get('/isi/{id_periode?}/{id_sdm?}',[SkpPrilakuPegawaiController::class,'edit'])->name('skp-pegawai.skp.edit');
            Route::post('/simpan',[SkpPrilakuPegawaiController::class,'store'])->name('skp-pegawai.skp.simpan');
            Route::post('/unggah-skp',[SkpPrilakuPegawaiController::class,'unggah_skp'])->name('skp-pegawai.skp.unggah_skp');
        });
    });

});

Route::group(['prefix' => 'api-rekap'], function () {
    Route::group(['prefix' => 'presensi'], function () {
        Route::get('/{nip?}/{tgl_awal?}/{tgl_akhir}',[ApiController::class,'index'])->name('api-rekap.presensi');
    });
    Route::group(['prefix' => 'skp'], function () {
        Route::get('/per-pegawai/{nip?}/{bulan?}/{tahun?}',[ApiController::class,'rekap_skp'])->name('api-rekap.rekap-skp');
        Route::get('/all/{bulan?}/{tahun?}',[ApiController::class,'rekap_skp_all'])->name('api-rekap.rekap-skp-all');
    });
    Route::group(['prefix' => 'pelanggaran-disiplin'], function () {
        Route::get('per-pegawai/{nip?}/{bulan?}/{tahun?}',[ApiController::class,'pelanggaran'])->name('api-rekap.pelanggaran-disiplin.per-pegawai');
        Route::get('all/{bulan?}/{tahun?}',[ApiController::class,'pelanggaranall'])->name('api-rekap.pelanggaran-disiplin.all');

    });
});


