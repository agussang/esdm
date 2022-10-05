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

Route::group(['middleware' => 'role:SA_A_PI'], function () {
    Route::get('home',[IndexController::class,'index'])->name('home');
    Route::group(['prefix' => 'data-master'], function () {
        Route::group(['prefix' => 'agama'], function () {
            Route::get('/',[MasterAgamaController::class,'index'])->name('data-master.agama');
        });
        Route::group(['prefix' => 'bank'], function () {
            Route::get('/',[MasterBankController::class,'index'])->name('data-master.bank');
            Route::get('/tambah',[MasterBankController::class,'create'])->name('data-master.bank.tambah');
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

        });

        Route::group(['prefix' => 'kategori-pelanggaran'], function () {
            Route::get('/',[MasterKategoriPelanggaranController::class,'index'])->name('data-master.kategori-pelanggaran');

        });

        Route::group(['prefix' => 'golongan'], function () {
            Route::get('/',[MsGolonganController::class,'index'])->name('data-master.golongan');

        });

        Route::group(['prefix' => 'grade'], function () {
            Route::get('/tmp-grade',[MasterGradeController::class,'tmp_grade'])->name('data-master.grade.tmp-grade');
            Route::get('/',[MasterGradeController::class,'index'])->name('data-master.grade');
            Route::post('/simpan',[MasterGradeController::class,'store'])->name('data-master.grade.simpan');
            Route::get('edit',[MasterGradeController::class,'edit'])->name('data-master.grade.edit');
            Route::post('/update',[MasterGradeController::class,'update'])->name('data-master.grade.update');
            Route::get('hapus/{id}',[MasterGradeController::class,'destroy'])->name('data-master.grade.hapus');
        });

        Route::group(['prefix' => 'kedinasan'], function () {
            Route::get('/',[MsKedinasanController::class,'index'])->name('data-master.kedinasan');

        });

        Route::group(['prefix' => 'status-aktif'], function () {
            Route::get('/',[MsStatusKeaktifanController::class,'index'])->name('data-master.status-aktif');

        });

        Route::group(['prefix' => 'status-kepegawaian'], function () {
            Route::get('/',[MsStatusKepegawaianController::class,'index'])->name('data-master.status-kepegawaian');

        });

        Route::group(['prefix' => 'jenis-sdm'], function () {
            Route::get('/',[MsJnsSdmController::class,'index'])->name('data-master.jenis-sdm');

        });

        Route::group(['prefix' => 'satuan-unit-kerja'], function () {
            Route::get('/',[SatuanUnitKerjaController::class,'index'])->name('data-master.satuan-unit-kerja');
            Route::post('/simpan',[SatuanUnitKerjaController::class,'store'])->name('data-master.satuan-unit-kerja.simpan');
            Route::get('edit',[SatuanUnitKerjaController::class,'edit'])->name('data-master.satuan-unit-kerja.edit');
            Route::post('/update',[SatuanUnitKerjaController::class,'update'])->name('data-master.satuan-unit-kerja.update');
            Route::get('hapus/{id}',[SatuanUnitKerjaController::class,'destroy'])->name('data-master.satuan-unit-kerja.hapus');
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
            // jangan lupa bikin function generate otomatis periode skp ketika berubah tahun
            Route::get('/',[SettingPeriodeSkpControler::class,'index'])->name('skp.setting-skp.index');
            Route::post('/cari',[SettingPeriodeSkpControler::class,'cari'])->name('skp.setting-skp.cari');
            Route::get('/update_status',[SettingPeriodeSkpControler::class,'update_status'])->name('skp.setting-skp.update_status');
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
        //belum
        Route::group(['prefix' => 'app'], function () {
            Route::get('/',[SettingAppController::class,'index'])->name('setting.app.index');
            Route::post('/update',[SettingAppController::class,'update'])->name('setting.app.update');
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
Route::group(['middleware' => 'role:P_SA_A_PI'], function () {
    Route::group(['prefix' => 'skp'], function () {
        Route::group(['prefix' => 'data-skp'], function () {
            Route::get('/',[DataSkpController::class,'index'])->name('skp.data-skp.index');
            Route::post('/cari',[DataSkpController::class,'cari'])->name('skp.data-skp.cari');
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
            });
        });
    });
});
Route::group(['middleware' => 'role:P_SA_A_PI'], function () {
    Route::get('beranda',[IndexController::class,'index'])->name('beranda');
    Route::group(['prefix' => 'pegawai'], function () {
        Route::get('/riwayat-apel/{id?}',[MsPegawaiController::class,'riwayat_apel'])->name('pegawai.riwayat-apel');
        Route::post('/cari/apel',[MsPegawaiController::class,'cari_apel'])->name('pegawai.cari.apel');

        Route::get('/riwayat-kehadiran/{id?}',[MsPegawaiController::class,'riwayat_kehadiran'])->name('pegawai.riwayat-kehadiran');
        Route::post('/cari/kehadiran',[MsPegawaiController::class,'cari_kehadiran'])->name('pegawai.cari.kehadiran');
       
        Route::get('/riwayat-absen/{id?}',[MsPegawaiController::class,'riwayat_absen'])->name('pegawai.riwayat-absen');
        Route::post('/cari/absen',[MsPegawaiController::class,'cari_absen'])->name('pegawai.cari.absen');

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


