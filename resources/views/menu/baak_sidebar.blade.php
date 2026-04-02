<?php
error_reporting(0);
$induk = explode('/', request()->path());
$seg1 = $induk[0] ?? '';
$seg2 = $induk[1] ?? '';
?>

<ul class="sidebar-nav">
    <li class="{{ $seg1 == 'home' ? 'active' : '' }}">
        <a href="{{URL::to('/home')}}">
            <span class="nav-icon"><i class="fas fa-home"></i></span>
            <span class="nav-label">Dashboard</span>
        </a>
    </li>
    <li class="{{ $seg2 == 'data-skp' ? 'active' : '' }}">
        <a href="{{route('skp.data-skp.index')}}">
            <span class="nav-icon"><i class="fas fa-clipboard-check"></i></span>
            <span class="nav-label">Data SKP</span>
        </a>
    </li>
</ul>
