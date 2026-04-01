@extends('layouts.layout')
@section('content')
<?php
ksort($nm_golongan);
$total_pegawai = 0;
$total_lk = 0;
$total_pr = 0;
foreach($dtjmpegawaijk as $nmjk=>$dtjk){
    $total_pegawai += count($dtjk);
    if(strpos(strtolower($nmjk),'laki') !== false){
        $total_lk = count($dtjk);
    } else {
        $total_pr = count($dtjk);
    }
}
$total_golongan = count($nm_golongan);
$total_pendidikan = count($jm_perpendidikan);
?>

<style>
/* ===== Dashboard Modern Style ===== */
.dash-greeting {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 28px 32px;
    color: #fff;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}
.dash-greeting::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255,255,255,0.08);
    border-radius: 50%;
}
.dash-greeting::after {
    content: '';
    position: absolute;
    bottom: -60%;
    right: 5%;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}
.dash-greeting h2 {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 6px;
    position: relative;
    z-index: 1;
}
.dash-greeting p {
    opacity: 0.9;
    margin: 0;
    font-size: 0.95rem;
    position: relative;
    z-index: 1;
}
.dash-greeting .greeting-icon {
    font-size: 2.5rem;
    margin-right: 16px;
}

/* Stat Cards */
.stat-card {
    border: none;
    border-radius: 14px;
    padding: 22px 24px;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    min-height: 130px;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
}
.stat-card .stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 14px;
}
.stat-card .stat-value {
    font-size: 1.8rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
}
.stat-card .stat-label {
    font-size: 0.82rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.7;
    font-weight: 600;
}

.stat-total { background: linear-gradient(135deg, #e8f0fe 0%, #d4e4fc 100%); }
.stat-total .stat-icon { background: #3b82f6; color: #fff; }
.stat-total .stat-value { color: #1e40af; }

.stat-lk { background: linear-gradient(135deg, #e0f7f4 0%, #ccf0ea 100%); }
.stat-lk .stat-icon { background: #10b981; color: #fff; }
.stat-lk .stat-value { color: #065f46; }

.stat-pr { background: linear-gradient(135deg, #fce7f3 0%, #fbd5e8 100%); }
.stat-pr .stat-icon { background: #ec4899; color: #fff; }
.stat-pr .stat-value { color: #9d174d; }

.stat-gol { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); }
.stat-gol .stat-icon { background: #f59e0b; color: #fff; }
.stat-gol .stat-value { color: #92400e; }

/* Chart Cards */
.chart-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    margin-bottom: 24px;
}
.chart-card .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    padding: 18px 24px;
}
.chart-card .card-header h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.chart-card .card-header .badge-section {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
}
.chart-card .card-body {
    padding: 20px 24px;
}

/* Modern Table */
.table-modern {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.table-modern thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 16px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
}
.table-modern tbody td {
    padding: 11px 16px;
    font-size: 0.88rem;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.table-modern tbody tr:hover {
    background: #f8fafc;
}
.table-modern tbody tr:last-child td {
    border-bottom: none;
}
.table-modern .text-right {
    text-align: right;
}
.table-modern .font-bold {
    font-weight: 700;
}
.table-modern tfoot td {
    background: #f1f5f9;
    font-weight: 700;
    padding: 12px 16px;
    font-size: 0.88rem;
    color: #1e293b;
}

/* Gender Badges */
.gender-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    font-weight: 600;
}
.gender-badge i {
    font-size: 1rem;
}
.gender-lk { color: #3b82f6; }
.gender-pr { color: #ec4899; }

/* Section Title */
.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    margin-top: 8px;
}
.section-title .section-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #fff;
}
.section-title h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.section-title p {
    font-size: 0.8rem;
    color: #94a3b8;
    margin: 0;
}

/* ===== Juara Kehadiran ===== */
.juara-podium {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: 16px;
    padding: 20px 24px 10px;
}
.juara-item {
    text-align: center;
    flex: 0 0 auto;
    width: 160px;
    transition: transform 0.3s ease;
}
.juara-item:hover { transform: translateY(-4px); }
.juara-medal {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 8px;
    font-weight: 800;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}
.juara-1 .juara-medal {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #78350f;
    width: 60px;
    height: 60px;
    font-size: 1.8rem;
    box-shadow: 0 4px 20px rgba(245,158,11,0.4);
}
.juara-2 .juara-medal {
    background: linear-gradient(135deg, #d1d5db, #9ca3af);
    color: #374151;
    font-size: 1.5rem;
}
.juara-3 .juara-medal {
    background: linear-gradient(135deg, #f59e0b, #b45309);
    color: #fff;
    font-size: 1.5rem;
}
.juara-nama {
    font-size: 0.82rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2px;
    line-height: 1.3;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.juara-1 .juara-nama { font-size: 0.9rem; }
.juara-jam {
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 600;
}
.juara-jam i { color: #10b981; margin-right: 2px; }
.juara-unit {
    font-size: 0.68rem;
    color: #94a3b8;
    margin-top: 2px;
    max-width: 160px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.juara-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}
.juara-1 .juara-label { color: #d97706; }
.juara-2 .juara-label { color: #6b7280; }
.juara-3 .juara-label { color: #b45309; }
@media (max-width: 576px) {
    .juara-podium { gap: 8px; }
    .juara-item { width: 100px; }
    .juara-nama { font-size: 0.72rem; }
    .juara-medal { width: 40px; height: 40px; font-size: 1.2rem; }
    .juara-1 .juara-medal { width: 48px; height: 48px; }
}

/* ===== Live Kehadiran ===== */
.live-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    overflow: hidden;
    margin-bottom: 24px;
}
.live-card .card-header {
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.live-card .card-header h5 {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}
.live-pulse {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    font-weight: 600;
    color: #10b981;
}
.live-pulse .dot {
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    animation: pulse-dot 1.5s ease-in-out infinite;
}
@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.7); }
}
.live-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px;
    padding: 20px 24px;
}
.live-stat-item {
    text-align: center;
    padding: 14px 10px;
    border-radius: 10px;
    background: #f8fafc;
}
.live-stat-item .live-num {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.2;
}
.live-stat-item .live-lbl {
    font-size: 0.72rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    color: #64748b;
    font-weight: 600;
    margin-top: 2px;
}
.live-stat-hadir .live-num { color: #10b981; }
.live-stat-hadir { background: #ecfdf5; }
.live-stat-belum .live-num { color: #ef4444; }
.live-stat-belum { background: #fef2f2; }
.live-stat-telat .live-num { color: #f59e0b; }
.live-stat-telat { background: #fffbeb; }
.live-stat-tepat .live-num { color: #3b82f6; }
.live-stat-tepat { background: #eff6ff; }
.live-stat-pulang .live-num { color: #8b5cf6; }
.live-stat-pulang { background: #f5f3ff; }

/* Progress bar */
.live-progress-wrap {
    padding: 0 24px 8px;
}
.live-progress-bar {
    height: 10px;
    background: #f1f5f9;
    border-radius: 99px;
    overflow: hidden;
    position: relative;
}
.live-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #34d399);
    border-radius: 99px;
    transition: width 0.8s ease;
}
.live-progress-text {
    display: flex;
    justify-content: space-between;
    font-size: 0.78rem;
    color: #64748b;
    font-weight: 600;
    margin-top: 6px;
}

/* Tabs */
.live-tabs {
    display: flex;
    border-bottom: 2px solid #f1f5f9;
    padding: 0 24px;
    gap: 0;
}
.live-tab {
    padding: 10px 20px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #94a3b8;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s;
    background: none;
    border-top: none;
    border-left: none;
    border-right: none;
}
.live-tab:hover { color: #3b82f6; }
.live-tab.active {
    color: #3b82f6;
    border-bottom-color: #3b82f6;
}
.live-tab .badge-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    margin-left: 6px;
    padding: 0 6px;
}
.live-tab .badge-green { background: #d1fae5; color: #065f46; }
.live-tab .badge-red { background: #fee2e2; color: #991b1b; }

/* Table list */
.live-table-wrap {
    max-height: 350px;
    overflow-y: auto;
    padding: 0;
}
.live-table-wrap::-webkit-scrollbar { width: 5px; }
.live-table-wrap::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 10px; }
.live-table {
    width: 100%;
    border-collapse: collapse;
}
.live-table thead th {
    position: sticky;
    top: 0;
    background: #f8fafc;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    padding: 10px 16px;
    border-bottom: 1px solid #e2e8f0;
    z-index: 1;
}
.live-table tbody td {
    padding: 9px 16px;
    font-size: 0.82rem;
    color: #334155;
    border-bottom: 1px solid #f8fafc;
}
.live-table tbody tr:hover { background: #f8fafc; }
.live-badge-telat {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 99px;
    font-size: 0.7rem;
    font-weight: 700;
    background: #fef3c7;
    color: #92400e;
}
.live-badge-tepat {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 99px;
    font-size: 0.7rem;
    font-weight: 700;
    background: #d1fae5;
    color: #065f46;
}
.live-update-time {
    font-size: 0.75rem;
    color: #94a3b8;
    padding: 10px 24px 16px;
    text-align: right;
}
.live-loading {
    text-align: center;
    padding: 40px;
    color: #94a3b8;
}

/* Responsive */
@media (max-width: 768px) {
    .dash-greeting { padding: 20px; }
    .dash-greeting h2 { font-size: 1.2rem; }
    .stat-card { padding: 16px; min-height: auto; }
    .stat-card .stat-value { font-size: 1.4rem; }
    .chart-card .card-body { padding: 14px; }
    .live-stats { grid-template-columns: repeat(2, 1fr); gap: 8px; padding: 14px; }
    .live-stat-item .live-num { font-size: 1.3rem; }
    .live-tabs { padding: 0 14px; }
    .live-tab { padding: 8px 12px; font-size: 0.78rem; }
}
</style>

{{-- ===== Greeting Banner ===== --}}
<div class="dash-greeting">
    <div class="d-flex align-items-center">
        <div>
            <?php
            $hour = date('H');
            if($hour < 12) $salam = 'Selamat Pagi';
            elseif($hour < 15) $salam = 'Selamat Siang';
            elseif($hour < 18) $salam = 'Selamat Sore';
            else $salam = 'Selamat Malam';
            ?>
            <h2><i class="ri-dashboard-line" style="margin-right:10px;"></i>{{ $salam }}, {{ Session::get('nama_pengguna') }}</h2>
            <p>Dashboard Kepegawaian &mdash; Data Ringkasan Pegawai {{ date('d F Y') }}</p>
        </div>
    </div>
</div>

{{-- ===== Stat Cards ===== --}}
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-total">
            <div class="stat-icon"><i class="ri-team-line"></i></div>
            <div class="stat-value">{{ $total_pegawai }}</div>
            <div class="stat-label">Total Pegawai</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-lk">
            <div class="stat-icon"><i class="ri-men-line"></i></div>
            <div class="stat-value">{{ $total_lk }}</div>
            <div class="stat-label">Laki-laki</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-pr">
            <div class="stat-icon"><i class="ri-women-line"></i></div>
            <div class="stat-value">{{ $total_pr }}</div>
            <div class="stat-label">Perempuan</div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="stat-card stat-gol">
            <div class="stat-icon"><i class="ri-bar-chart-grouped-line"></i></div>
            <div class="stat-value">{{ $total_golongan }}</div>
            <div class="stat-label">Jenis Golongan</div>
        </div>
    </div>
</div>

{{-- ===== Live Preview Kehadiran ===== --}}
<div class="section-title">
    <div class="section-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="ri-fingerprint-line"></i></div>
    <div>
        <h4>Live Kehadiran Hari Ini</h4>
        <p>Data presensi real-time dari mesin fingerprint</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="live-card card" id="liveKehadiranCard">
            <div class="card-header">
                <h5><i class="ri-fingerprint-line text-success mr-2"></i>Presensi Hari Ini</h5>
                <div class="live-pulse"><span class="dot"></span> Live</div>
            </div>

            {{-- Juara Podium --}}
            <div class="juara-podium" id="juaraPodium" style="display:none;">
                {{-- Juara 2 --}}
                <div class="juara-item juara-2" id="juara2" style="display:none;">
                    <div class="juara-label">Juara 2</div>
                    <div class="juara-medal"><i class="ri-medal-line"></i></div>
                    <div class="juara-nama" id="juara2Nama">-</div>
                    <div class="juara-jam"><i class="ri-time-line"></i> <span id="juara2Jam">-</span></div>
                    <div class="juara-unit" id="juara2Unit"></div>
                </div>
                {{-- Juara 1 --}}
                <div class="juara-item juara-1" id="juara1" style="display:none;">
                    <div class="juara-label">Juara 1</div>
                    <div class="juara-medal"><i class="ri-trophy-line"></i></div>
                    <div class="juara-nama" id="juara1Nama">-</div>
                    <div class="juara-jam"><i class="ri-time-line"></i> <span id="juara1Jam">-</span></div>
                    <div class="juara-unit" id="juara1Unit"></div>
                </div>
                {{-- Juara 3 --}}
                <div class="juara-item juara-3" id="juara3" style="display:none;">
                    <div class="juara-label">Juara 3</div>
                    <div class="juara-medal"><i class="ri-medal-line"></i></div>
                    <div class="juara-nama" id="juara3Nama">-</div>
                    <div class="juara-jam"><i class="ri-time-line"></i> <span id="juara3Jam">-</span></div>
                    <div class="juara-unit" id="juara3Unit"></div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="live-stats" id="liveStats">
                <div class="live-stat-item live-stat-hadir">
                    <div class="live-num" id="liveHadir">-</div>
                    <div class="live-lbl">Hadir</div>
                </div>
                <div class="live-stat-item live-stat-belum">
                    <div class="live-num" id="liveBelum">-</div>
                    <div class="live-lbl">Belum Hadir</div>
                </div>
                <div class="live-stat-item live-stat-telat">
                    <div class="live-num" id="liveTelat">-</div>
                    <div class="live-lbl">Terlambat</div>
                </div>
                <div class="live-stat-item live-stat-tepat">
                    <div class="live-num" id="liveTepat">-</div>
                    <div class="live-lbl">Tepat Waktu</div>
                </div>
                <div class="live-stat-item live-stat-pulang">
                    <div class="live-num" id="livePulang">-</div>
                    <div class="live-lbl">Sudah Pulang</div>
                </div>
            </div>

            {{-- Progress bar --}}
            <div class="live-progress-wrap">
                <div class="live-progress-bar">
                    <div class="live-progress-fill" id="liveProgressFill" style="width: 0%"></div>
                </div>
                <div class="live-progress-text">
                    <span id="liveProgressLabel">Memuat data...</span>
                    <span id="liveProgressPersen">0%</span>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="live-tabs">
                <button class="live-tab active" data-tab="semua" onclick="switchLiveTab(this, 'semua')">
                    Semua Hadir <span class="badge-count badge-green" id="liveBadgeSemua">0</span>
                </button>
                <button class="live-tab" data-tab="terlambat" onclick="switchLiveTab(this, 'terlambat')">
                    Terlambat <span class="badge-count badge-red" id="liveBadgeTelat">0</span>
                </button>
            </div>

            {{-- Table: Semua Hadir --}}
            <div class="live-table-wrap" id="tabSemua">
                <table class="live-table">
                    <thead>
                        <tr>
                            <th style="width:35px">No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Unit Kerja</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="liveBodySemua">
                        <tr><td colspan="7" class="live-loading"><i class="ri-loader-4-line"></i> Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- Table: Terlambat --}}
            <div class="live-table-wrap" id="tabTerlambat" style="display:none;">
                <table class="live-table">
                    <thead>
                        <tr>
                            <th style="width:35px">No</th>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Unit Kerja</th>
                            <th>Masuk</th>
                            <th>Pulang</th>
                        </tr>
                    </thead>
                    <tbody id="liveBodyTelat">
                        <tr><td colspan="6" class="live-loading"><i class="ri-loader-4-line"></i> Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="live-update-time">
                Terakhir diperbarui: <span id="liveUpdateTime">-</span> &middot; Auto-refresh setiap 30 detik
            </div>
        </div>
    </div>
</div>

{{-- ===== Charts: Golongan ===== --}}
<div class="section-title">
    <div class="section-icon" style="background: linear-gradient(135deg, #3b82f6, #6366f1);"><i class="ri-bar-chart-2-line"></i></div>
    <div>
        <h4>Distribusi Pegawai Berdasarkan Golongan</h4>
        <p>Data sebaran golongan kepangkatan pegawai</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="chart-card card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="ri-bar-chart-2-fill text-primary mr-2"></i>Grafik Golongan</h5>
                <span class="badge-section" style="background: #eff6ff; color: #3b82f6;">Bar Chart</span>
            </div>
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="chart-card card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="ri-pie-chart-2-fill text-success mr-2"></i>Persentase</h5>
                <span class="badge-section" style="background: #ecfdf5; color: #10b981;">Donut</span>
            </div>
            <div class="card-body">
                <div id="donut"></div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Table: Data Golongan ===== --}}
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="chart-card card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="ri-table-2 text-info mr-2"></i>Tabel Data Golongan</h5>
                <span class="badge-section" style="background: #f0f9ff; color: #0ea5e9;">{{ count($jm_by_golongan) }} Golongan</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th style="width:40px;">No</th>
                                <th>Nama Golongan</th>
                                @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
                                <th class="text-right">
                                    @if(strpos(strtolower($nmjk),'laki') !== false)
                                    <span class="gender-badge gender-lk"><i class="ri-men-line"></i> {{ $nmjk }}</span>
                                    @else
                                    <span class="gender-badge gender-pr"><i class="ri-women-line"></i> {{ $nmjk }}</span>
                                    @endif
                                </th>
                                @endforeach
                                <th class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            ksort($jm_by_golongan);
                            $no = 1;
                            $totals = [];
                            foreach($dtjmpegawaijk as $nmjk=>$dtjk){ $totals[$nmjk] = 0; }
                            $grand_total = 0;
                            ?>
                            @foreach($jm_by_golongan as $kodegolongan=>$dtgolongan)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td><strong>{{ $dtgolongan['nm_golongan'] }}</strong></td>
                                @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
                                <?php
                                $count_val = count($dtgolongan['dt_golongan'][$nmjk]);
                                $totals[$nmjk] += $count_val;
                                ?>
                                <td class="text-right">{{ $count_val }}</td>
                                @endforeach
                                <?php $grand_total += $jm_pergolongan[$kodegolongan]; ?>
                                <td class="text-right font-bold">{{ $jm_pergolongan[$kodegolongan] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"><strong>Total</strong></td>
                                @foreach($totals as $nmjk=>$total_val)
                                <td class="text-right">{{ $total_val }}</td>
                                @endforeach
                                <td class="text-right">{{ $grand_total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== Charts: Pendidikan ===== --}}
<div class="section-title">
    <div class="section-icon" style="background: linear-gradient(135deg, #10b981, #059669);"><i class="ri-graduation-cap-line"></i></div>
    <div>
        <h4>Distribusi Pegawai Berdasarkan Pendidikan Terakhir</h4>
        <p>Data sebaran tingkat pendidikan pegawai</p>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="chart-card card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="ri-bar-chart-2-fill text-success mr-2"></i>Grafik Pendidikan</h5>
                <span class="badge-section" style="background: #ecfdf5; color: #10b981;">Bar Chart</span>
            </div>
            <div class="card-body">
                <div id="pendidikan"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="chart-card card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5><i class="ri-pie-chart-2-fill text-warning mr-2"></i>Persentase</h5>
                <span class="badge-section" style="background: #fef3c7; color: #d97706;">Donut</span>
            </div>
            <div class="card-body">
                <div id="prosen_pendidikan"></div>
            </div>
        </div>
    </div>
</div>

{{-- ===== ApexCharts Scripts ===== --}}
<script src="{{URL::to('assets/js/apexcharts.js')}}"></script>
<script>
// Color palette
var colors = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#06b6d4','#84cc16','#f97316','#6366f1','#14b8a6','#e11d48'];

// ===== Bar Chart: Golongan =====
var optGolongan = {
    series: [
    @foreach($arrData as $jk=>$dt_jk)
    {
        name: '{{ $jk }}',
        data: [
            @foreach($nm_golongan as $golongan=>$gol)
                {{ count($dt_jk[$golongan]) }},
            @endforeach
        ]
    },
    @endforeach
    ],
    chart: { type: 'bar', height: 320, fontFamily: 'inherit', toolbar: { show: false } },
    colors: ['#3b82f6', '#ec4899'],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '60%',
            borderRadius: 6,
            dataLabels: { position: 'top' },
        },
    },
    dataLabels: {
        enabled: true,
        offsetY: -22,
        style: { fontSize: '11px', fontWeight: 700, colors: ['#475569'] }
    },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    xaxis: {
        categories: [
            @foreach($nm_golongan as $golongan=>$gol)
                '{{ $golongan }}',
            @endforeach
        ],
        labels: { style: { fontSize: '11px', colors: '#64748b' } },
        axisBorder: { show: false },
    },
    yaxis: {
        title: { text: 'Jumlah Pegawai', style: { fontSize: '12px', color: '#94a3b8' } },
        labels: { style: { colors: '#94a3b8' } },
    },
    fill: { opacity: 1 },
    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
    tooltip: {
        y: { formatter: function (val) { return val + " Pegawai" } },
        theme: 'light',
    },
    legend: { position: 'top', horizontalAlign: 'right', fontWeight: 600 },
};
new ApexCharts(document.querySelector("#chart"), optGolongan).render();

// ===== Donut Chart: Jenis Kelamin =====
var optDonut = {
    series: [
        @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
            {{ count($dtjk) }},
        @endforeach
    ],
    chart: { type: 'donut', height: 320, fontFamily: 'inherit' },
    colors: ['#3b82f6', '#ec4899'],
    labels: [
        @foreach($dtjmpegawaijk as $nmjk=>$dtjk)
            '{{ $nmjk }}',
        @endforeach
    ],
    tooltip: {
        y: { formatter: function (val) { return val + " Pegawai" } }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '68%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '14px',
                        fontWeight: 700,
                        color: '#1e293b',
                        formatter: function(w) {
                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                        }
                    }
                }
            }
        }
    },
    stroke: { width: 3, colors: ['#fff'] },
    legend: { position: 'bottom', fontWeight: 600, fontSize: '13px', markers: { width: 10, height: 10, radius: 4 } },
    responsive: [{ breakpoint: 480, options: { chart: { width: 280 }, legend: { position: 'bottom' } } }],
};
new ApexCharts(document.querySelector("#donut"), optDonut).render();

// ===== Bar Chart: Pendidikan =====
var optPendidikan = {
    series: [
    @foreach($jm_by_pendidikan as $jkp=>$dtjkp)
    {
        name: '{{ $jkp }}',
        data: [
            @foreach($arrpendidikan as $urutan=>$dt_urutan)
                @foreach($dt_urutan as $nm_pendidikan=>$dt_pendidikan)
                    {{ count($dtjkp[$nm_pendidikan]) }},
                @endforeach
            @endforeach
        ]
    },
    @endforeach
    ],
    chart: { type: 'bar', height: 320, fontFamily: 'inherit', toolbar: { show: false } },
    colors: ['#3b82f6', '#ec4899'],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '60%',
            borderRadius: 6,
            dataLabels: { position: 'top' },
        },
    },
    dataLabels: {
        enabled: true,
        offsetY: -22,
        style: { fontSize: '11px', fontWeight: 700, colors: ['#475569'] }
    },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    xaxis: {
        categories: [
            @foreach($arrpendidikan as $urutan=>$dt_urutan)
                @foreach($dt_urutan as $nm_pendidikan=>$dt_pendidikan)
                    '{{ $nm_pendidikan }}',
                @endforeach
            @endforeach
        ],
        labels: { style: { fontSize: '11px', colors: '#64748b' } },
        axisBorder: { show: false },
    },
    yaxis: {
        title: { text: 'Jumlah Pegawai', style: { fontSize: '12px', color: '#94a3b8' } },
        labels: { style: { colors: '#94a3b8' } },
    },
    fill: { opacity: 1 },
    grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
    tooltip: {
        y: { formatter: function (val) { return val + " Pegawai" } },
        theme: 'light',
    },
    legend: { position: 'top', horizontalAlign: 'right', fontWeight: 600 },
};
new ApexCharts(document.querySelector("#pendidikan"), optPendidikan).render();

// ===== Donut Chart: Pendidikan =====
var optPendidikanDonut = {
    series: [
        @foreach($jm_perpendidikan as $nm_pen=>$jm_pen)
            {{ $jm_pen }},
        @endforeach
    ],
    chart: { type: 'donut', height: 320, fontFamily: 'inherit' },
    colors: colors,
    labels: [
        @foreach($arrpendidikan as $urutan=>$dt_urutan)
            @foreach($dt_urutan as $nm_pendidikan=>$dt_pendidikan)
                '{{ $nm_pendidikan }}',
            @endforeach
        @endforeach
    ],
    tooltip: {
        y: { formatter: function (val) { return val + " Pegawai" } }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '68%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '14px',
                        fontWeight: 700,
                        color: '#1e293b',
                        formatter: function(w) {
                            return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                        }
                    }
                }
            }
        }
    },
    stroke: { width: 3, colors: ['#fff'] },
    legend: { position: 'bottom', fontWeight: 600, fontSize: '12px', markers: { width: 10, height: 10, radius: 4 } },
    responsive: [{ breakpoint: 480, options: { chart: { width: 280 }, legend: { position: 'bottom' } } }],
};
new ApexCharts(document.querySelector("#prosen_pendidikan"), optPendidikanDonut).render();
</script>

@push('js')
{{-- ===== Live Kehadiran Script ===== --}}
<script>
var liveCurrentTab = 'semua';

function switchLiveTab(el, tab) {
    document.querySelectorAll('.live-tab').forEach(function(t){ t.classList.remove('active'); });
    el.classList.add('active');
    liveCurrentTab = tab;
    document.getElementById('tabSemua').style.display = (tab === 'semua') ? '' : 'none';
    document.getElementById('tabTerlambat').style.display = (tab === 'terlambat') ? '' : 'none';
}

var juaraIcons = {1: 'ri-trophy-fill', 2: 'ri-medal-fill', 3: 'ri-medal-fill'};
var juaraColors = {1: '#f59e0b', 2: '#9ca3af', 3: '#b45309'};

function renderLiveRow(item, no) {
    var status = item.terlambat
        ? '<span class="live-badge-telat">Terlambat</span>'
        : '<span class="live-badge-tepat">Tepat Waktu</span>';
    var badge = '';
    if (item.ranking <= 3) {
        badge = ' <span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:' + juaraColors[item.ranking] + ';color:#fff;font-size:0.7rem;vertical-align:middle;margin-left:4px;"><i class="' + juaraIcons[item.ranking] + '"></i></span>';
    }
    return '<tr>' +
        '<td>' + no + '</td>' +
        '<td><strong>' + escHtml(item.nama) + '</strong>' + badge + '</td>' +
        '<td>' + escHtml(item.nip) + '</td>' +
        '<td>' + escHtml(item.unit || '-') + '</td>' +
        '<td>' + item.jam_masuk + '</td>' +
        '<td>' + (item.jam_pulang || '-') + '</td>' +
        '<td>' + status + '</td>' +
    '</tr>';
}

function renderLiveRowTelat(item, no) {
    return '<tr>' +
        '<td>' + no + '</td>' +
        '<td><strong>' + escHtml(item.nama) + '</strong></td>' +
        '<td>' + escHtml(item.nip) + '</td>' +
        '<td>' + escHtml(item.unit || '-') + '</td>' +
        '<td><span class="live-badge-telat">' + item.jam_masuk + '</span></td>' +
        '<td>' + (item.jam_pulang || '-') + '</td>' +
    '</tr>';
}

function escHtml(str) {
    if (!str) return '';
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}

function fetchLiveKehadiran() {
    $.ajax({
        url: '{{ route("api.live-kehadiran") }}',
        type: 'GET',
        dataType: 'json',
        success: function(d) {
            // Update stats
            $('#liveHadir').text(d.hadir);
            $('#liveBelum').text(d.belum_hadir);
            $('#liveTelat').text(d.terlambat);
            $('#liveTepat').text(d.tepat_waktu);
            $('#livePulang').text(d.sudah_pulang);

            // Progress bar
            $('#liveProgressFill').css('width', d.persen_hadir + '%');
            $('#liveProgressLabel').text(d.hadir + ' dari ' + d.total_pegawai + ' pegawai sudah hadir');
            $('#liveProgressPersen').text(d.persen_hadir + '%');

            // Badges
            $('#liveBadgeSemua').text(d.hadir);
            $('#liveBadgeTelat').text(d.terlambat);

            // Juara podium
            if (d.juara && d.juara.length > 0) {
                $('#juaraPodium').show();
                // Juara 1 (tengah)
                if (d.juara[0]) {
                    $('#juara1').show();
                    $('#juara1Nama').text(d.juara[0].nama).attr('title', d.juara[0].nama);
                    $('#juara1Jam').text(d.juara[0].jam_masuk);
                    $('#juara1Unit').text(d.juara[0].unit || '');
                }
                // Juara 2 (kiri)
                if (d.juara[1]) {
                    $('#juara2').show();
                    $('#juara2Nama').text(d.juara[1].nama).attr('title', d.juara[1].nama);
                    $('#juara2Jam').text(d.juara[1].jam_masuk);
                    $('#juara2Unit').text(d.juara[1].unit || '');
                } else { $('#juara2').hide(); }
                // Juara 3 (kanan)
                if (d.juara[2]) {
                    $('#juara3').show();
                    $('#juara3Nama').text(d.juara[2].nama).attr('title', d.juara[2].nama);
                    $('#juara3Jam').text(d.juara[2].jam_masuk);
                    $('#juara3Unit').text(d.juara[2].unit || '');
                } else { $('#juara3').hide(); }
            } else {
                $('#juaraPodium').hide();
            }

            // Table: Semua
            var htmlSemua = '';
            if (d.list_hadir.length === 0) {
                htmlSemua = '<tr><td colspan="7" class="live-loading">Belum ada data kehadiran</td></tr>';
            } else {
                for (var i = 0; i < d.list_hadir.length; i++) {
                    htmlSemua += renderLiveRow(d.list_hadir[i], i + 1);
                }
            }
            $('#liveBodySemua').html(htmlSemua);

            // Table: Terlambat
            var htmlTelat = '';
            if (d.list_terlambat.length === 0) {
                htmlTelat = '<tr><td colspan="6" class="live-loading">Tidak ada yang terlambat hari ini</td></tr>';
            } else {
                for (var j = 0; j < d.list_terlambat.length; j++) {
                    htmlTelat += renderLiveRowTelat(d.list_terlambat[j], j + 1);
                }
            }
            $('#liveBodyTelat').html(htmlTelat);

            // Update time
            $('#liveUpdateTime').text(d.waktu_update);
        },
        error: function() {
            $('#liveBodySemua').html('<tr><td colspan="7" class="live-loading" style="color:#ef4444;">Gagal memuat data</td></tr>');
        }
    });
}

// Initial load
$(document).ready(function() {
    fetchLiveKehadiran();
    // Auto-refresh setiap 30 detik
    setInterval(fetchLiveKehadiran, 30000);
});
</script>
@endpush
@stop
