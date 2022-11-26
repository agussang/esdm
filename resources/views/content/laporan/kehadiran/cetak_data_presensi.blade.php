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
        @page { size: portrait; }
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
@foreach($arrData as $id_sdm=>$dt_sdm)
<div class="page" align="center" id="container" style="width:21cm;margin:0 auto;">
    <body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
        <span><b>Data Presensi Pegawai</b></span><br/>
        <span><b>Jam Kerja {{$jam_kerja_text}}</b></span><br/>
        <br/><hr style="border: 1px solid"/><br/>
        <table width="100%" border=0 cellspacing=0 cellpadding="3" style="font-size:12pt";>
            <thead>
                <tr>
                    <td>Nip</td>
                    <td>: {{$dt_sdm['nip']}}</td>
                    <td></td>
                    <td>Nama</td>
                    <td>: {{$dt_sdm['nm_sdm']}}</td>
                    <td></td>
                </tr>
            </thead>
        </table>
        <br/><hr style="border: 1px solid"/><br/>
        <table width="100%" border=1 cellspacing=0 cellpadding="3" style="font-size:12pt";>
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Jam Masuk</th>
                    <th rowspan="2">Jam Pulang</th>
                    <th rowspan="2">Durasi Bekerja <br/>(Jam)</th>
                    <th rowspan="2">Durasi Bekerja<br/>(Menit)</th>
                    <th rowspan="2">Durasi Terlambat<br/>(Menit)</th>
                    <th rowspan="2">Ket</th>
                    <th colspan="2">Keterangan Justifikasi</th>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <th>Durasi Justifikasi<br/>(Menit)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1;
                ?>
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
                $durasi = Fungsi::hitungdurasi($jamkerja['jam_masuk'],$jamkerja['jam_pulang']);
                $jam_masukex = explode(':',$jam_masuk);
                $jam_keluarex = explode(':',$jam_keluar);

                $j_masuk_start = $jam_masukex[0];
                $menit_masuk_start = $jam_masukex[1];

                $j_keluar_start = $jam_keluarex[0];
                $menit_keluar_start = $jam_keluarex[1];

                $hasil = (intVal($j_keluar_start) - intVal($j_masuk_start)) * 60 + (intVal($menit_keluar_start) - intVal($menit_masuk_start));
                $hasil = $hasil / 60;
                $hasil = number_format($hasil,2);
                $hasilx = explode(".",$hasil);
                $depan = sprintf("%02d", $hasilx[0]);
                $gabung = $depan.":".$hasilx[1];
                $warna = "";
                $hitungdurasi_terlambat = 0;
                $ket = "";
                $libur = $dt_hari_libur[substr($tanggal,0,7)][$tanggal];
                if($jam_masuk == $jam_keluar){
                    $ket = "Absen 1 kali";
                }
                if($libur){
                    $warna = "background-color: #E3CC6D;";
                    $ket = $libur;
                }else{
                    if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu"){
                        if($gabung < $durasi){
                            $warna = "background-color: #F78282;";
                            $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'],$jam_masuk);
                            if($hitungdurasi_terlambat>0){
                                    $ket = "Terlambat";
                                }
                        }
                    }
                }
                if($hariabsen[0]=="Minggu" || $hariabsen[0]=="Sabtu"){
                    $warna = "background-color: #E3CC6D;";
                }
                $menit = ($gabung*60)+$hasilx[1];

                $kategori = "";
                $durasijustifikasi = "";
                $menitjustifikasi = 0;
                if($presensi['justifikasi']){
                    $kategori = $presensi['justifikasi']['kategori_justifikasi'];
                    $durasijustifikasi = $presensi['justifikasi']['durasi_justifikasi']." Menit";
                    $menitjustifikasi = $presensi['justifikasi']['durasi_justifikasi'];
                }
                ?>
                <tr style="{{$warna}}">
                    <td>{{$no++}}</td>
                    <td>{{$presensi['ket_tgl']}}</td>
                    <td align="center">{{$jam_masuk}}</td>
                    <td align="center">{{$jam_keluar}}</td>
                    <td align="center">{{$gabung}}</td>
                    <td align="center">{{$menit}}</td>
                    <td align="center">{{$hitungdurasi_terlambat-$menitjustifikasi}}</td>
                    <td align="center">
                        {{$ket}}
                    </td>
                    <td>
                        {{$kategori}}
                    </td>
                    <td>
                        {{$durasijustifikasi}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</div>
@endforeach
</html>
