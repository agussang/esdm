<?php
error_reporting(0);
$induk = explode('/', request()->path());
$seg1 = $induk[0] ?? '';
$seg2 = $induk[1] ?? '';
$seg3 = $induk[2] ?? '';
?>

<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'beranda' ? 'active' : '' }}">
        <a href="{{URL::to('/beranda')}}">
            <span class="nav-icon"><i class="fas fa-home"></i></span>
            <span class="nav-label">Dashboard</span>
        </a>
    </li>
    <li class="{{ $seg1 == 'pegawai' ? 'active' : '' }}">
        <a href="{{URL::to('/pegawai/detil')}}/{{Crypt::encrypt(Session::get('id_sdm_pengguna'))}}">
            <span class="nav-icon"><i class="fas fa-id-card"></i></span>
            <span class="nav-label">Data Pegawai</span>
        </a>
    </li>
    <li class="{{ $seg2 == 'skp' ? 'active' : '' }}">
        <a href="{{URL::to('skp-pegawai/skp/')}}/{{Crypt::encrypt(Session::get('id_sdm_pengguna'))}}">
            <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
            <span class="nav-label">SKP & Perilaku</span>
        </a>
    </li>
</ul>

@if(Session::get('atasan_penilai')!=null)
<span class="sidebar-section-label">Pimpinan</span>
<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'pegawai-bawahan' ? 'active' : '' }}">
        <a href="{{route('pegawai-bawahan.pegawai')}}">
            <span class="nav-icon"><i class="fas fa-users"></i></span>
            <span class="nav-label">Pegawai Bawahan</span>
        </a>
    </li>
    <li class="{{ $seg2 == 'data-skp' ? 'active' : '' }}">
        <a href="{{route('skp.data-skp.index')}}">
            <span class="nav-icon"><i class="fas fa-clipboard-check"></i></span>
            <span class="nav-label">Penilaian SKP</span>
        </a>
    </li>
    <li class="{{ $seg3 == 'data-absen' ? 'active' : '' }}">
        <a href="{{route('data-pegawai.data-presensi.data-absen.index')}}">
            <span class="nav-icon"><i class="fas fa-calendar-check"></i></span>
            <span class="nav-label">Data Absen</span>
        </a>
    </li>
</ul>
@endif
