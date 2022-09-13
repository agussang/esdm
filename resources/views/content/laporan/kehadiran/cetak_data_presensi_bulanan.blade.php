<?php
$kerja_jam_masukex = explode(':',$jam_kerja->jam_masuk);
$kerja_jam_keluarex = explode(':',$jam_kerja->jam_keluar);

$kerja_j_masuk_start = $kerja_jam_masukex[0];
$kerja_menit_masuk_start = $kerja_jam_masukex[1];

$kerja_j_keluar_start = $kerja_jam_keluarex[0];
$kerja_menit_keluar_start = $kerja_jam_keluarex[1];

$kerjahasil = (intVal($kerja_j_keluar_start) - intVal($kerja_j_masuk_start)) * 60 + (intVal($kerja_menit_keluar_start) - intVal($kerja_menit_masuk_start));
$kerjahasil = $kerjahasil / 60;
$kerjahasil = number_format($kerjahasil,2);
$kerjahasilx = explode(".",$kerjahasil);
$kerjadepan = sprintf("%02d", $kerjahasilx[0]);
$kerjagabung = $kerjadepan.":".$kerjahasilx[1];
?>

<html>
<title>{{ config('app.name', 'Laravel') }}</title>
<head>
    <style>
		@media print
		{
		#ttd {position:fixed;bottom:1cm;}
		}
		@font-face {
			font-family: MyriadPro-Regular;
			src: url("../font/MyriadPro-Regular.otf");

		}
		@font-face {
			font-family: MyriadPro-Cond;
			src: url("../font/MyriadPro-Cond.otf");

		}
		#head-title{
			font-family:MyriadPro-Regular;
			font-weight:bold;
		}
		#head-big{
			font-family:MyriadPro-Cond;
			font-weight:bold;
			font-size:12pt;
		}
		#container td{
			font-family:MyriadPro-Regular;
		}
        @page { size: landscape; }
        div.page { page-break-after: always; }
        .tengah{
            text-align:center;
        }
        .kiri{
            text-align:left;
        }
        .kanan{
            text-align:right;
        }
</style>
</head>
@foreach($data_bulan as $id_bulan=>$dt_bln)
<div class="page" align="center" id="container" style="width:25cm;margin:0 auto;">
    <body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
        <span><b>Data Presensi Pegawai Bulanan</b></span><br/>
        <span><b>Jam Kerja {{$jam_kerja->jam_masuk}} - {{$jam_kerja->jam_keluar}} ( {{$kerjagabung}} jam )</b></span><br/>
        <br/><hr style="border: 1px solid"/><br/>
        <span style="float:left;">Presensi Bulan {{$dt_bln['nm_bulan']}}</span>
        <table width="950" border=1 cellspacing=0 cellpadding="3" style="font-size:10pt";>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nip</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Hari Kerja</th>
                    <th rowspan="2">Jmlh Kehadiran</th>
                    <th rowspan="2">Tidak Masuk</th>
                    <th rowspan="2">Terlambat <br/>( Menit )</th>
                    <th rowspan="2">Pulang Cepat</th>
                    <th rowspan="2">Finger 1 kali</th>
                    <th rowspan="2">Tidak Hadir Apel</th>
                    <th colspan="{{count($arrAlasan)}}">Keterangan Tidak Masuk</th>
                </tr>
                <tr>
                    @foreach($arrAlasan as $id=>$nm_alasan)
                        <th>{{$nm_alasan}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                @foreach($arrData as $id_sdm=>$dt_sdm)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$dt_sdm['nip']}}</td>
                    <td>{{$dt_sdm['nm_sdm']}}</td>
                    <td align="center">{{count((array)$dt_bln['tgl_bulan'])}}</td>
                    <td align="center">{{count((array)$masuk[$id_sdm][$id_bulan])}}</td>
                    <td align="center">{{count((array)$tidakmasuk[$id_sdm][$id_bulan])}}</td>
                    <td align="center">{{$terlambat[$id_sdm][$id_bulan]}}</td>
                    <td align="center">{{$molehcepet[$id_sdm][$id_bulan]}}</td>
                    <td></td>
                    <td></td>
                    @foreach($arrAlasan as $id=>$nm_alasan)
                        <td>{{$arrAlasanabsen[$id_sdm][$id][$id_bulan]['jmabsen']}}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</div>
@endforeach
</html>