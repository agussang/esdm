<html>
<title>{{$rsDataKetApp->nama_aplikasi}}</title>
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
        @page { size: "A4"; }
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

<div class="page" align="center" id="container">
    <body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
        <span><b>Data Presensi Pegawai</b></span><br/>
        <span><b>Jam Kerja {{$jam_kerja_text}}</b></span><br/>
        <br/><hr style="border: 1px solid"/><br/>
        <br/><hr style="border: 1px solid"/><br/>
        <table width="100%" border=1 cellspacing=0 cellpadding="3" style="font-size:12pt";>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nip</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Durasi Bekerja <br/>(Jam)</th>
                    <th>Durasi Bekerja<br/>(Menit)</th>
                    <th>Lembur<br/>(Jam)</th>
                    @if($id_satker == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                    <th>Ket Jadwal Shift</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                @foreach($arrData as $id_sdm=>$dt_sdm)
                    <?php $no=1;?>
                    @foreach($dt_sdm['data_presensi'] as $tanggal=>$presensi)
                    <?php
                    $hariabsen = explode(',',$presensi['ket_tgl']);
                    $jam_masuk = array_shift($presensi['jam_absen']);
                    $jam_keluar = end($presensi['jam_absen']);
                    if($jam_keluar==null){
                        $jam_keluar = $jam_masuk;
                    }
                    if($hariabsen[0]=="Jumat"){
                        $jamkerja = $jam_kerja[2];
                    }else{
                        $jamkerja = $jam_kerja[1];
                    }

                    if($dt_sdm['id_satker'] == "30c82828-d938-42c1-975e-bf8a1db2c7b0"){
                        $jamkerja = $presensi['msjadwalshift'];
                    }
                    $durasi = Fungsi::hitungdurasi($jamkerja['jam_masuk'],$jamkerja['jam_pulang']);
                    $jam_masukex = explode(':',$jam_masuk);
                    $jam_keluarex = explode(':',$jam_keluar);

                    $j_masuk_start = $jam_masukex[0];
                    $menit_masuk_start = $jam_masukex[1];

                    $j_keluar_start = $jam_keluarex[0];
                    $menit_keluar_start = $jam_keluarex[1];

                    // $hasil = (intVal($j_keluar_start) - intVal($j_masuk_start)) * 60 + (intVal($menit_keluar_start) - intVal($menit_masuk_start));
                    // $hasil = $hasil / 60;
                    // $hasil = number_format($hasil,2);
                    // $hasilx = explode(".",$hasil);
                    // $depan = sprintf("%02d", $hasilx[0]);
                    // $gabung = $depan.":".$hasilx[1];
                    $warna = "";

                    // if($gabung < $durasi){
                    //     $warna = "background-color: #F78282;";
                    // }
                    $durasikerja = "00:00:00";$durasikerjamenit = "0";
                    if($jam_masuk!="--:--" && $jam_keluar!="--:--"){
                        $jamawal = $tgl." ".$jam_masuk;
                        $jamakhir = $tgl." ".$jam_keluar;
                        $durasikerja = Fungsi::durasikerja($jamawal,$jamakhir);
                        $durasikerjamenit = Fungsi::konversiwaktu($durasikerja);
                    }
                    $hari = explode(',',$tanggal);
                    if($hariabsen[0]=="Minggu" || $hariabsen[0]=="Sabtu"){
                        $warna = "background-color: #E3CC6D;";
                    }
                    $gabung_lembur = 0;
                    if($durasikerja>$durasi){
                        $jamkel = explode(':',$jamkerja['jam_pulang']);
                        $jamlembur = -($jamkel[0]-$j_keluar_start);
                        $menit_lembur = -($jamkel[1]-$menit_keluar_start);
                        $gabung_lembur = sprintf("%02d", $jamlembur).":".sprintf("%02d", $menit_lembur);
                    }
                    //$menit = ($gabung*60)+$hasilx[1];
                    $gabung_lembur = explode(":",$gabung_lembur);

                    ?>
                    <tr style="{{$warna}}">
                        <td>{{$no++}}</td>
                        <td>{{$dt_sdm['nip']}}</td>
                        <td>{{$dt_sdm['nm_sdm']}}</td>
                        <td>{{$presensi['ket_tgl']}}</td>
                        <td align="center">{{$jam_masuk}}</td>
                        <td align="center">{{$jam_keluar}}</td>
                        <td align="center">{{$durasikerja}}</td>
                        <td align="center">{{$durasikerjamenit}}</td>
                        <td align="center">
                            @if($durasikerjamenit>0)
                            {{sprintf("%01d",$gabung_lembur[0])}}
                            @else
                            0
                            @endif
                        </td>
                        @if($dt_sdm['id_satker'] == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                            <td>
                                {{$jamkerja['nm_shift']}}
                            </td>
                        @endif
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </body>
</div>
</html>
