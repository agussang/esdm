# LAPORAN PENGEMBANGAN SISTEM
# Aplikasi E-SDM (Elektronik Sistem Data Manajemen)

---

**Tanggal Pelaksanaan:** 1 April 2026
**Pengembang:** masgus
**Versi Aplikasi:** Laravel 8 / PHP 7.4
**Database:** PostgreSQL (eremun)
**Watermark Kode:** `// develop by masgus`

---

## I. LATAR BELAKANG

Pengembangan ini dilakukan berdasarkan kebutuhan penyesuaian kebijakan kehadiran dan kinerja pegawai pada sistem E-SDM. Perubahan mencakup penyesuaian aturan keterlambatan, penghapusan fitur justifikasi yang tidak lagi berlaku, pembatasan kuota justifikasi, perbaikan bug pada reset presensi, serta perbaikan tampilan data SKP yang tidak sinkron antara akun admin dan akun pegawai.

---

## II. BACKUP DATABASE

Sebelum pelaksanaan pengembangan, dilakukan backup database sebagai langkah pencegahan kehilangan data.

| Parameter | Detail |
|-----------|--------|
| **Tanggal Backup** | 1 April 2026, 14:23 WIB |
| **Lokasi File** | `/Users/agus/esdm/backups/eremun_backup_20260401_142317.dump` |
| **Ukuran File** | 27.172.527 bytes (25,9 MB) |
| **Format** | PostgreSQL Custom Dump (.dump) |
| **Schema** | neosimpeg |
| **Database Sumber** | eremun (103.227.0.85:5432) |
| **Perintah Restore** | `pg_restore -h HOST -U postgres -d eremun backups/eremun_backup_20260401_142317.dump` |

---

## III. RINCIAN PERUBAHAN

### 3.1. Penghapusan Opsi "Keluar Kantor" dari Alasan Absen

**Tujuan:** Menghilangkan opsi "Keluar Kantor" dari daftar pilihan alasan absen pada seluruh halaman sistem, sesuai kebijakan baru yang tidak lagi mengakomodasi alasan tersebut.

**Metode Implementasi:**
Dilakukan *soft-delete* pada tabel `ms_alasan_absen` untuk record dengan ID `18645517-74cf-4709-a3d9-47bc46d2a37a` (kode lokal: KK). Metode soft-delete dipilih agar data historis yang telah menggunakan alasan ini tetap valid dan tidak mengalami error referensi.

**Perubahan Teknis:**

| File | Perubahan |
|------|-----------|
| **Database** (`ms_alasan_absen`) | Kolom `deleted_at` diisi timestamp untuk record "Keluar Kantor" |
| **`app/Helper/Fungsi.php`** (5 lokasi) | Menambahkan `->whereNull('deleted_at')` pada seluruh raw query `DB::table('ms_alasan_absen')` agar konsisten dengan mekanisme SoftDeletes |

**Dampak:**
- Opsi "Keluar Kantor" tidak lagi muncul pada dropdown alasan absen di halaman tambah data absen, edit data absen, maupun import data.
- Data absen lama yang menggunakan alasan "Keluar Kantor" tetap tersimpan dan dapat ditampilkan pada riwayat.

---

### 3.2. Penghapusan Satuan Detik dari Perhitungan Jam Kerja

**Tujuan:** Menyederhanakan perhitungan dan tampilan durasi kerja dari format `HH:MM:SS` menjadi `HH:MM` (hanya jam dan menit), sesuai kebijakan bahwa perhitungan jam kerja cukup sampai satuan menit.

**Perubahan Teknis:**

| File | Fungsi/Bagian | Perubahan |
|------|---------------|-----------|
| **`app/Helper/Fungsi.php`** | `durasikerja()` | Format output diubah dari `sprintf("%02d:%02d:%02d", h, i, s)` menjadi `sprintf("%02d:%02d", h, i)`. Satuan detik (`$durasiker->s`) dihilangkan dari hasil kalkulasi. |
| **`app/Helper/Fungsi.php`** | `konversiwaktu()` | Logika konversi diperbaiki dari implementasi lama yang mengandung bug (operasi `($rsData[1].":".$rsData[2])*60` menghasilkan konversi string-to-number yang tidak akurat) menjadi `intval($rsData[0]) * 60 + intval($rsData[1])` yang menghasilkan total menit secara presisi. |
| **7 file Blade** | Default value | Variabel `$durasikerja` diubah dari `"00:00:00"` menjadi `"00:00"` |

**Daftar View yang Diperbarui:**
1. `resources/views/content/data_pegawai/riwayat/presensi_kehadiran/index.blade.php`
2. `resources/views/content/hal_pegawai/home.blade.php`
3. `resources/views/content/laporan/kehadiran/cetak_data_presensi.blade.php`
4. `resources/views/content/laporan/kehadiran/cetak_data_presensi2.blade.php`
5. `resources/views/content/laporan/kehadiran/cetak_data_presensi2_xls.blade.php`
6. `resources/views/content/laporan/kehadiran/cetak_data_presensi_lembur.blade.php`
7. `resources/views/content/laporan/kehadiran/cetak_data_presensi_lembur_xls.blade.php`

---

### 3.3. Penghapusan Justifikasi Keterlambatan (Kategori 2)

**Tujuan:** Meniadakan seluruh mekanisme justifikasi keterlambatan dari sistem. Sebelumnya pegawai dapat mengajukan justifikasi atas keterlambatan sebanyak 3 kali per bulan. Kebijakan baru menetapkan bahwa keterlambatan tidak lagi dapat dijustifikasi.

**Perubahan Teknis:**

| File | Bagian | Perubahan |
|------|--------|-----------|
| **`app/Helper/Fungsi.php`** | `arrkategorijustifikasi()` | Menghapus elemen `"2"=>"Terlambat"` dari array kategori justifikasi. Array sekarang hanya berisi: `1=Lupa Finger/Tidak Masuk`, `3=Pulang Cepat`, `4=Finger 1 Kali`. |
| **`app/Http/Controllers/MsPegawaiController.php`** | `simpan_justifikasi_by_admin()` | Menambahkan validasi di awal method: jika `kategori_justifikasi == '2'`, sistem langsung menolak dengan pesan error: *"Justifikasi keterlambatan sudah tidak berlaku. Sesuai kebijakan baru, keterlambatan tidak dapat dijustifikasi."* |
| **`app/Http/Controllers/MsPegawaiController.php`** | `simpan_pengajuan()` | Validasi yang sama ditambahkan pada method pengajuan oleh pegawai. |
| **`index.blade.php`** (Riwayat Presensi) | Kolom Durasi Terlambat | Blok kode yang menampilkan informasi justifikasi terlambat (Durasi Terlambat dan Durasi Justifikasi) dihapus dari kolom. Kolom sekarang hanya menampilkan angka menit keterlambatan. |
| **`index.blade.php`** (Riwayat Presensi) | Kolom Aksi | Tombol "Justifikasi" disembunyikan apabila `$kode_justifikasi == 2` (kasus terlambat). |
| **`home.blade.php`** (Dashboard Pegawai) | Kolom Aksi | Perubahan yang sama diterapkan: tombol "Ajukan Justifikasi" tidak ditampilkan untuk kasus terlambat. |
| **Kedua View** | Perhitungan | Logika pengurangan durasi terlambat dengan durasi justifikasi (`$terlambat = abs($hitungdurasi_terlambat - $menitjustifikasi)`) diubah menjadi langsung menggunakan durasi terlambat tanpa pengurangan (`$terlambat = abs($hitungdurasi_terlambat)`). |

**Catatan:** Data justifikasi keterlambatan yang telah disetujui sebelumnya tetap tersimpan di database sebagai data historis, namun tidak lagi mempengaruhi perhitungan presensi.

---

### 3.4. Implementasi Aturan Keterlambatan Baru (Toleransi 15 Menit)

**Tujuan:** Menerapkan aturan keterlambatan baru dengan mekanisme toleransi 15 menit yang dikompensasi dengan mundurnya jam pulang, sebagai berikut:

| Kondisi | Hasil |
|---------|-------|
| Terlambat **<= 15 menit** dan jam kerja **terpenuhi** (pulang mundur sesuai keterlambatan) | **TIDAK dianggap terlambat** (0 menit) |
| Terlambat **> 15 menit** | **SELALU dianggap terlambat**, meskipun jam kerja terpenuhi |
| Terlambat **<= 15 menit** namun jam kerja **TIDAK terpenuhi** | **Kekurangan jam kerja dihitung sebagai keterlambatan** |

**Contoh Kasus:**
- Pegawai A masuk pukul 07:40 (terlambat 10 menit dari jadwal 07:30).
- Seharusnya pegawai pulang pukul 16:10 (16:00 + 10 menit kompensasi).
- Jika pulang pukul 16:10 atau lebih = **tidak terlambat**.
- Jika pulang pukul 16:05 = **terlambat 5 menit** (kekurangan 5 menit dari jam kerja yang seharusnya).

**Perubahan Teknis:**

Fungsi `hitungdurasiterlambat()` di `app/Helper/Fungsi.php` ditulis ulang secara menyeluruh:

**Signature Lama:**
```php
hitungdurasiterlambat($jm_kerja_masuk, $jam_absen)
```

**Signature Baru:**
```php
hitungdurasiterlambat($jm_kerja_masuk, $jam_absen, $jm_kerja_pulang = null, $jam_pulang_actual = null)
```

Parameter baru (`$jm_kerja_pulang` dan `$jam_pulang_actual`) bersifat nullable untuk menjaga *backward compatibility*. Apabila parameter baru tidak diisi, fungsi tetap mengembalikan durasi keterlambatan mentah.

**Logika Internal Baru:**
1. Hitung selisih waktu masuk aktual dengan jadwal masuk (dalam menit).
2. Jika datang tepat waktu atau lebih awal, kembalikan 0.
3. Jika terlambat > 15 menit, langsung kembalikan durasi terlambat.
4. Jika terlambat <= 15 menit:
   - Hitung jam pulang yang diharuskan = jam pulang normal + menit terlambat.
   - Bandingkan dengan jam pulang aktual.
   - Jika jam pulang aktual >= jam pulang yang diharuskan, kembalikan 0 (jam kerja terpenuhi).
   - Jika tidak, kembalikan selisih kekurangan sebagai durasi terlambat.

**File yang Diperbarui (Call Site):**

| File | Jumlah Call Site |
|------|-----------------|
| `riwayat/presensi_kehadiran/index.blade.php` | 2 |
| `hal_pegawai/home.blade.php` | 2 |
| `laporan/kehadiran/cetak_data_presensi.blade.php` | 2 |
| `laporan/kehadiran/cetak_data_presensi2.blade.php` | 2 |
| `laporan/kehadiran/cetak_data_presensi2_xls.blade.php` | 2 |
| `laporan/kehadiran/cetak_data_presensi2_old.blade.php` | 1 |
| `laporan/kehadiran/cetak_data_presensi_old.blade.php` | 1 |
| `laporan/kehadiran/cetakdatapresensixls.blade.php` | 1 |
| `app/Helper/Fungsi.php` (`get_rekap_data_kehadiran()`) | 1 |
| **Total** | **14 call site** |

Seluruh call site telah diperbarui untuk mengirimkan 4 parameter (`jam_masuk_kerja`, `jam_masuk_aktual`, `jam_pulang_kerja`, `jam_pulang_aktual`).

---

### 3.5. Pembatasan Justifikasi Lupa Absen Maksimal 2 Kali per Bulan

**Tujuan:** Membatasi pengajuan justifikasi lupa absen (Kategori 4: Finger 1 Kali) menjadi maksimal 2 (dua) kali kesempatan per bulan per pegawai.

**Perubahan Teknis:**

**A. Fungsi Helper Baru** (`app/Helper/Fungsi.php`):

| Fungsi | Deskripsi |
|--------|-----------|
| `countApprovedJustifikasiKat4($id_sdm, $tanggal_referensi)` | Menghitung jumlah justifikasi kategori 4 yang telah **disetujui** pada bulan tertentu. Digunakan saat admin menyimpan justifikasi atau saat atasan menyetujui pengajuan. |
| `countAllJustifikasiKat4($id_sdm, $tanggal_referensi)` | Menghitung jumlah justifikasi kategori 4 yang berstatus **pending + disetujui** pada bulan tertentu. Digunakan saat pegawai mengajukan justifikasi (mencegah pengajuan berlebih meskipun belum disetujui). |

**B. Validasi di Controller** (`app/Http/Controllers/MsPegawaiController.php`):

| Method | Validasi | Pesan Error |
|--------|----------|-------------|
| `simpan_justifikasi_by_admin()` | Cek `countApprovedJustifikasiKat4() >= 2` | *"Justifikasi lupa absen sudah mencapai batas maksimal 2 kali per bulan. Tidak dapat menambah justifikasi lagi."* |
| `simpan_pengajuan()` | Cek `countAllJustifikasiKat4() >= 2` | *"Justifikasi lupa absen sudah mencapai batas maksimal 2 kali per bulan. Tidak dapat mengajukan justifikasi lagi."* |
| `simpan_proses_pengajuan()` | Cek `countApprovedJustifikasiKat4() >= 2` sebelum approval | *"Tidak dapat menyetujui. Justifikasi lupa absen pegawai ini sudah mencapai batas maksimal 2 kali per bulan."* |

Seluruh pesan error ditampilkan melalui notifikasi **Toastr** (pop-up) dengan tipe `error` sehingga jelas terlihat oleh pengguna.

**C. Tampilan UI:**

| Elemen | Kondisi | Tampilan |
|--------|---------|----------|
| Tombol Justifikasi | Kuota tersedia (< 2) | `[Justifikasi (0/2)]` atau `[Justifikasi (1/2)]` - tombol aktif |
| Tombol Justifikasi | Kuota habis (>= 2) | `[Kuota Habis (2/2)]` - tombol disabled (abu-abu) dengan tooltip: *"Kuota justifikasi lupa absen bulan ini sudah habis (2/2)"* |
| Status Justifikasi | Setelah disetujui | Menampilkan status + label kuota: *"Disetujui (1/2 kuota bulan ini)"* |

**D. Controller Pendukung:**

| Controller | Method | Perubahan |
|------------|--------|-----------|
| `MsPegawaiController` | `riwayat_kehadiran()` | Mengirimkan variabel `$justifikasiKat4Count` ke view |
| `IndexController` | `index()` | Mengirimkan variabel `$justifikasiKat4Count` ke view dashboard pegawai |

---

### 3.6. Perbaikan Bug Reset Jam Kerja pada Justifikasi Lupa Absen

**Deskripsi Bug:** Ketika admin melakukan reset justifikasi lupa absen, jam presensi pegawai tidak kembali ke kondisi semula baik pada tampilan akun pegawai maupun akun admin. Hal ini terjadi karena proses reset hanya menghapus record di tabel `tr_justifikasi`, namun tidak menghapus record tambahan yang telah diinsert ke tabel `riwayat_finger` pada saat justifikasi disetujui.

**Analisis Akar Masalah:**
Pada saat justifikasi kategori 4 (Finger 1 Kali) disetujui melalui method `simpan_proses_pengajuan()`, sistem memasukkan 2 record baru ke tabel `riwayat_finger` dengan nilai:
- `mesin = "justifikasi"`
- `sn = "justifikasi"`
- `ket_justifikasi = "justifikasi 1x absen"`

Record-record ini yang menyebabkan jam masuk dan jam pulang pegawai berubah. Ketika admin melakukan reset, record ini tidak ikut dihapus sehingga perubahan jam tetap berlaku.

**Perbaikan** (`app/Http/Controllers/DataAbsenController.php` - method `reset_justifikasi()`):

Ditambahkan logika penghapusan record `riwayat_finger` yang terkait **sebelum** menghapus record justifikasi:

```php
if ($rsData->kategori_justifikasi == '4' || $rsData->kategori_justifikasi == '3') {
    RiwayatPresensi::where('id_sdm', $rsData->id_sdm)
        ->where('tanggal_absen', $rsData->tanggal_absen)
        ->where('mesin', 'justifikasi')
        ->delete();
}
```

Kriteria penghapusan menggunakan tiga kolom (`id_sdm`, `tanggal_absen`, `mesin='justifikasi'`) untuk memastikan hanya record yang dibuat oleh proses justifikasi yang dihapus, tanpa mempengaruhi record presensi finger asli.

Penghapusan menggunakan mekanisme *soft-delete* (model `RiwayatPresensi` memiliki trait `SoftDeletes`) sehingga data tidak hilang permanen dan dapat dipulihkan jika diperlukan.

**Import tambahan:** `use App\Models\RiwayatPresensi;` ditambahkan di bagian atas file `DataAbsenController.php`.

---

### 3.7. Perbaikan Bug Data SKP Tidak Sinkron (Stale Data)

**Deskripsi Bug:** Saat admin melakukan revisi atau pembaruan data SKP pegawai, data terbaru belum langsung tampil di akun pegawai dan masih menampilkan data lama. Sementara pada akun admin, data sudah terbarui setelah selang waktu tertentu.

**Analisis Akar Masalah:**
Setelah investigasi, ditemukan bahwa:
1. Query database pada sisi pegawai (`SkpPrilakuPegawaiController::prilaku()`) dan admin (`DataSkpController::index()`) sudah mengambil data langsung dari database tanpa caching aplikasi.
2. Penyebab utama adalah **browser caching** yang menyimpan response halaman lama dan menampilkannya kembali tanpa meminta data terbaru ke server.

**Perbaikan:**
Ditambahkan HTTP header anti-cache pada response dari 3 controller yang menangani tampilan SKP:

```php
return response()
    ->view('nama.view', $data)
    ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
    ->header('Pragma', 'no-cache')
    ->header('Expires', '0');
```

| Controller | Method | Keterangan |
|------------|--------|------------|
| `DataSkpController` | `index()` | Halaman daftar SKP (sisi admin) |
| `SkpPrilakuPegawaiController` | `prilaku()` | Halaman rekap SKP (sisi pegawai) |
| `TargetSkpPegawaiController` | `index()` | Halaman target SKP tahunan (sisi pegawai) |

Dengan header ini, browser dipaksa untuk selalu meminta data terbaru ke server dan tidak menggunakan cache lokal.

---

## IV. RINGKASAN PERUBAHAN FILE

### File Backend (PHP)

| No | File | Baris Ditambah | Baris Dihapus | Deskripsi Perubahan |
|----|------|:-:|:-:|-----|
| 1 | `app/Helper/Fungsi.php` | 82 | 57 | Rewrite `hitungdurasiterlambat()`, perbaikan `durasikerja()` dan `konversiwaktu()`, hapus kategori 2 dari array justifikasi, tambah 2 helper baru untuk kuota kat.4, fix raw query soft-delete |
| 2 | `app/Http/Controllers/MsPegawaiController.php` | 53 | 0 | Validasi block kategori 2, validasi limit kategori 4, cek kuota sebelum approve, pass data kuota ke view |
| 3 | `app/Http/Controllers/DataAbsenController.php` | 13 | 5 | Fix reset justifikasi dengan hapus riwayat_finger, import model |
| 4 | `app/Http/Controllers/DataSkpController.php` | 6 | 1 | No-cache headers pada response SKP |
| 5 | `app/Http/Controllers/SkpPrilakuPegawaiController.php` | 6 | 1 | No-cache headers pada response SKP pegawai |
| 6 | `app/Http/Controllers/TargetSkpPegawaiController.php` | 6 | 1 | No-cache headers pada response target SKP |
| 7 | `app/Http/Controllers/IndexController.php` | 2 | 0 | Pass data kuota justifikasi kat.4 ke dashboard pegawai |

### File Frontend (Blade Views)

| No | File | Baris Ditambah | Baris Dihapus | Deskripsi Perubahan |
|----|------|:-:|:-:|-----|
| 8 | `riwayat/presensi_kehadiran/index.blade.php` | 21 | 18 | Sembunyikan tombol justifikasi terlambat, tampilkan kuota kat.4, update call site terlambat, hapus info justifikasi di kolom durasi, format waktu |
| 9 | `hal_pegawai/home.blade.php` | 19 | 12 | Sama seperti di atas untuk dashboard pegawai |
| 10-16 | 7 file laporan kehadiran | 12 | 12 | Update call site `hitungdurasiterlambat()` ke 4 parameter, format waktu |

### Perubahan Database

| No | Tabel | Aksi | Detail |
|----|-------|------|--------|
| 1 | `ms_alasan_absen` | UPDATE | Soft-delete record "Keluar Kantor" (`deleted_at` diisi timestamp) |

### Total Statistik

| Metrik | Jumlah |
|--------|--------|
| **File dimodifikasi** | 17 |
| **Baris ditambahkan** | 223 |
| **Baris dihapus** | 110 |
| **Baris bersih (net)** | +113 |
| **Controller diubah** | 7 |
| **View diubah** | 10 |
| **Helper diubah** | 1 |
| **Fungsi baru** | 2 |
| **Fungsi diubah/rewrite** | 3 |
| **Record database diubah** | 1 |

---

## V. PANDUAN PENGUJIAN

### 5.1. Pengujian Aturan Keterlambatan Baru

| No | Skenario | Data Uji | Hasil yang Diharapkan |
|----|----------|----------|----------------------|
| 1 | Terlambat <= 15 menit, pulang mundur cukup | Masuk 07:40, Pulang 16:10 (jadwal 07:30-16:00) | Terlambat: **0 menit** |
| 2 | Terlambat <= 15 menit, pulang mundur kurang | Masuk 07:40, Pulang 16:05 (jadwal 07:30-16:00) | Terlambat: **5 menit** |
| 3 | Terlambat > 15 menit | Masuk 07:50, Pulang 16:20 (jadwal 07:30-16:00) | Terlambat: **20 menit** (meskipun jam kerja lebih) |
| 4 | Tepat waktu | Masuk 07:30, Pulang 16:00 | Terlambat: **0 menit** |

### 5.2. Pengujian Justifikasi

| No | Skenario | Hasil yang Diharapkan |
|----|----------|-----------------------|
| 1 | Klik tombol justifikasi pada kasus terlambat | Tombol **tidak muncul** |
| 2 | Ajukan justifikasi lupa absen ke-1 | Berhasil, tampilan: *"Justifikasi (1/2)"* |
| 3 | Ajukan justifikasi lupa absen ke-2 | Berhasil, tampilan: *"Justifikasi (2/2)"* |
| 4 | Ajukan justifikasi lupa absen ke-3 | **Ditolak**, muncul pesan error via pop-up |
| 5 | Tombol saat kuota habis | Tampil tombol disabled: *"Kuota Habis (2/2)"* dengan tooltip |

### 5.3. Pengujian Lainnya

| No | Skenario | Hasil yang Diharapkan |
|----|----------|-----------------------|
| 1 | Cek dropdown alasan absen | "Keluar Kantor" **tidak muncul** |
| 2 | Cek format waktu di riwayat presensi | Format **HH:MM** (tanpa detik) |
| 3 | Admin reset justifikasi lupa absen | Jam presensi **kembali ke semula** di akun pegawai dan admin |
| 4 | Admin revisi SKP, cek di akun pegawai | Data **langsung diperbarui** tanpa delay |

---

## VI. PROSEDUR ROLLBACK

Apabila ditemukan masalah kritis pasca-implementasi, rollback dapat dilakukan dengan langkah berikut:

### 6.1. Rollback Database
```bash
PGPASSWORD='****' pg_restore -h 103.227.0.85 -p 5432 -U postgres \
  -d eremun --clean --if-exists \
  /Users/agus/esdm/backups/eremun_backup_20260401_142317.dump
```

### 6.2. Rollback Kode
```bash
cd /Users/agus/esdm
git checkout -- .
```

---

## VII. CATATAN PENTING

1. Seluruh kode pengembangan baru diberi komentar watermark `// develop by masgus` untuk memudahkan identifikasi dan audit perubahan di masa mendatang.

2. Fungsi `hitungdurasiterlambat()` menggunakan parameter opsional dengan nilai default `null` untuk menjaga kompatibilitas mundur (*backward compatibility*) dengan kode yang belum diperbarui.

3. Penghapusan record menggunakan mekanisme *soft-delete* (mengisi kolom `deleted_at`) sehingga data tidak hilang permanen dan dapat dipulihkan jika diperlukan.

4. Seluruh pesan penolakan dari sistem ditampilkan melalui notifikasi **Toastr** dengan tipe `error` (warna merah) agar jelas terlihat oleh pengguna. Tombol yang di-disable dilengkapi atribut `title` sebagai tooltip penjelasan.

---

*Dokumen ini dibuat sebagai dokumentasi resmi perubahan sistem E-SDM per tanggal 1 April 2026.*
*Pengembang: masgus*
