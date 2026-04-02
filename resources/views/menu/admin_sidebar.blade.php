<?php
error_reporting(0);
$induk = explode('/', request()->path());
$seg1 = $induk[0] ?? '';
$seg2 = $induk[1] ?? '';
$seg3 = $induk[2] ?? '';
?>

{{-- HOME --}}
<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'home' ? 'active' : '' }}">
        <a href="{{URL::to('/home')}}">
            <span class="nav-icon"><i class="fas fa-home"></i></span>
            <span class="nav-label">Dashboard</span>
        </a>
    </li>
</ul>

{{-- DATA MASTER --}}
<span class="sidebar-section-label">Master Data</span>
<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'data-master' ? 'active' : '' }}">
        <button class="nav-link-toggle" aria-expanded="{{ $seg1 == 'data-master' ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-database"></i></span>
            <span class="nav-label">Data Master</span>
            <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
        </button>
        <ul class="sidebar-submenu" style="{{ $seg1 == 'data-master' ? '' : 'display:none' }}">
            <li class="{{ $seg2 == 'agama' ? 'active' : '' }}">
                <a href="{{route('data-master.agama')}}">Master Agama</a>
            </li>
            <li class="{{ $seg2 == 'bank' ? 'active' : '' }}">
                <a href="{{route('data-master.bank')}}">Master Bank</a>
            </li>
            <li class="{{ $seg2 == 'waktu-presensi' ? 'active' : '' }}">
                <a href="{{route('data-master.waktu-presensi')}}">Waktu Presensi</a>
            </li>
            <li class="{{ $seg2 == 'waktu-shift' ? 'active' : '' }}">
                <a href="{{route('data-master.waktu-shift')}}">Waktu Presensi Shift</a>
            </li>
            <li class="{{ $seg2 == 'tanggal-ramadhan' ? 'active' : '' }}">
                <a href="{{route('data-master.tanggal-ramadhan')}}">Tanggal Ramadhan</a>
            </li>
            <li class="{{ $seg2 == 'jabatan' ? 'active' : '' }}">
                <a href="{{route('data-master.jabatan')}}">Master Jabatan</a>
            </li>
            <li class="{{ $seg2 == 'kategori-pelanggaran' ? 'active' : '' }}">
                <a href="{{route('data-master.kategori-pelanggaran')}}">Kategori Pelanggaran</a>
            </li>
            <li class="{{ $seg2 == 'alasan-absen' ? 'active' : '' }}">
                <a href="{{route('data-master.alasan-absen')}}">Alasan Absen</a>
            </li>
            <li class="{{ $seg2 == 'pendidikan' ? 'active' : '' }}">
                <a href="{{route('data-master.pendidikan')}}">Master Pendidikan</a>
            </li>
            <li class="{{ $seg2 == 'hari-libur' ? 'active' : '' }}">
                <a href="{{route('data-master.hari-libur')}}">Hari Libur</a>
            </li>
            <li class="{{ $seg2 == 'grade' ? 'active' : '' }}">
                <a href="{{route('data-master.grade')}}">Master Grade</a>
            </li>
            <li class="{{ $seg2 == 'prosentase' ? 'active' : '' }}">
                <a href="{{route('data-master.prosentase')}}">Prosentase Realisasi</a>
            </li>
            <li class="{{ $seg2 == 'golongan' ? 'active' : '' }}">
                <a href="{{route('data-master.golongan')}}">Master Golongan</a>
            </li>
            <li class="{{ $seg2 == 'kedinasan' ? 'active' : '' }}">
                <a href="{{route('data-master.kedinasan')}}">Master Kedinasan</a>
            </li>
            <li class="{{ $seg2 == 'status-aktif' ? 'active' : '' }}">
                <a href="{{route('data-master.status-aktif')}}">Status Aktif</a>
            </li>
            <li class="{{ $seg2 == 'status-kepegawaian' ? 'active' : '' }}">
                <a href="{{route('data-master.status-kepegawaian')}}">Status Kepegawaian</a>
            </li>
            <li class="{{ $seg2 == 'jenis-sdm' ? 'active' : '' }}">
                <a href="{{route('data-master.jenis-sdm')}}">Jenis SDM</a>
            </li>
            <li class="{{ $seg2 == 'satuan-unit-kerja' ? 'active' : '' }}">
                <a href="{{route('data-master.satuan-unit-kerja')}}">Unit Kerja</a>
            </li>
        </ul>
    </li>
</ul>

{{-- DATA PEGAWAI --}}
<span class="sidebar-section-label">Kepegawaian</span>
<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'data-pegawai' && !in_array($seg2, ['data-presensi','pengajuan-justifikasi-kehadiran']) ? 'active' : ($seg1 == 'data-pegawai' ? 'active' : '') }}">
        <button class="nav-link-toggle" aria-expanded="{{ $seg1 == 'data-pegawai' ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-users"></i></span>
            <span class="nav-label">Data Pegawai</span>
            <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
        </button>
        <ul class="sidebar-submenu" style="{{ $seg1 == 'data-pegawai' ? '' : 'display:none' }}">
            <li class="{{ $seg2 == 'master-pegawai' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.master-pegawai.index')}}">Master Pegawai</a>
            </li>
            <li class="{{ $seg2 == 'pelanggaran' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.pelanggaran.index')}}">Pelanggaran Disiplin</a>
            </li>
            <li class="{{ $seg2 == 'atasan-pegawai' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.atasan-pegawai.index')}}">Setting Atasan</a>
            </li>
        </ul>
    </li>

    {{-- DATA PRESENSI (separated for clarity) --}}
    <li class="{{ $seg2 == 'data-presensi' || $seg2 == 'pengajuan-justifikasi-kehadiran' ? 'active' : '' }}">
        <button class="nav-link-toggle" aria-expanded="{{ $seg2 == 'data-presensi' || $seg2 == 'pengajuan-justifikasi-kehadiran' ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-fingerprint"></i></span>
            <span class="nav-label">Data Presensi</span>
            <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
        </button>
        <ul class="sidebar-submenu" style="{{ $seg2 == 'data-presensi' || $seg2 == 'pengajuan-justifikasi-kehadiran' ? '' : 'display:none' }}">
            <li class="{{ $seg2 == 'pengajuan-justifikasi-kehadiran' || $seg3 == 'pengajuan-justifikasi-kehadiran' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.data-presensi.pengajuan-justifikasi-kehadiran.index')}}">Ajuan Justifikasi</a>
            </li>
            <li class="{{ $seg3 == 'upload-presensi' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.data-presensi.upload-presensi.index')}}">Upload / Sync Presensi</a>
            </li>
            <li class="{{ $seg3 == 'jadwal-presensi-shift' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.data-presensi.jadwal-presensi-shift.index')}}">Jadwal Presensi Shift</a>
            </li>
            <li class="{{ $seg3 == 'apel' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.data-presensi.apel.index')}}">Upload Apel</a>
            </li>
            <li class="{{ $seg3 == 'data-absen' ? 'active' : '' }}">
                <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}">Data Absen</a>
            </li>
        </ul>
    </li>
</ul>

{{-- SKP --}}
<span class="sidebar-section-label">Kinerja</span>
<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'skp' ? 'active' : '' }}">
        <button class="nav-link-toggle" aria-expanded="{{ $seg1 == 'skp' ? 'true' : 'false' }}">
            <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
            <span class="nav-label">SKP</span>
            <span class="nav-arrow"><i class="fas fa-chevron-right"></i></span>
        </button>
        <ul class="sidebar-submenu" style="{{ $seg1 == 'skp' ? '' : 'display:none' }}">
            <li class="{{ $seg2 == 'setting-skp' ? 'active' : '' }}">
                <a href="{{route('skp.setting-skp.index')}}">Setting Periode SKP</a>
            </li>
            <li class="{{ $seg2 == 'data-skp' ? 'active' : '' }}">
                <a href="{{route('skp.data-skp.index')}}">Data SKP</a>
            </li>
            <li class="{{ $seg3 == 'prilaku' ? 'active' : '' }}">
                <a href="{{route('skp.master-skp.prilaku.index')}}">Master Perilaku</a>
            </li>
        </ul>
    </li>
</ul>

{{-- LAPORAN --}}
<span class="sidebar-section-label">Laporan</span>
<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'laporan' ? 'active' : '' }}">
        <a href="{{route('laporan.presensi-kehadiran.index')}}">
            <span class="nav-icon"><i class="fas fa-file-alt"></i></span>
            <span class="nav-label">Laporan Kehadiran</span>
        </a>
    </li>
</ul>

{{-- SETTING --}}
<span class="sidebar-section-label">Pengaturan</span>
<ul class="sidebar-nav">
    @if(Session::get('id_pengguna')=="30065b84-9afb-4c24-b565-12bfef2dde76")
    <li class="{{ $seg2 == 'app' ? 'active' : '' }}">
        <a href="{{route('setting.app.index')}}">
            <span class="nav-icon"><i class="fas fa-cog"></i></span>
            <span class="nav-label">Setting App</span>
        </a>
    </li>
    @endif
    <li class="{{ $seg2 == 'manajemen-user' ? 'active' : '' }}">
        <a href="{{route('setting.manajemen-user.index')}}">
            <span class="nav-icon"><i class="fas fa-user-cog"></i></span>
            <span class="nav-label">Manajemen User</span>
        </a>
    </li>
    <li class="{{ $seg2 == 'log-login' ? 'active' : '' }}">
        <a href="{{route('setting.log-login.index')}}">
            <span class="nav-icon"><i class="fas fa-history"></i></span>
            <span class="nav-label">Log Login</span>
        </a>
    </li>
</ul>
