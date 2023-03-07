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
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nip</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Jam Masuk</th>
                    <th rowspan="2">Jam Pulang</th>
                    <th rowspan="2">Durasi Bekerja <br/>(Jam)</th>
                    <th rowspan="2">Durasi Bekerja <br/>(Menit)</th>
                    <th rowspan="2">Durasi Terlambat<br/>(Menit)</th>
                    <th rowspan="2">Durasi Pulang Cepat<br/>(Menit)</th>
                    <th rowspan="2">Ket Tanggal</th>
                    <th rowspan="2">Ket</th>
                    <th colspan="2">Ket Justifikasi</th>
                    @if($id_satker == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                    <th rowspan="2">Ket Jadwal Shift</th>
                    @endif
                </tr>
                <tr>
                    <th>Kategori</th>
                    <th>Durasi Justifikasi<br/>(Menit)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($arrData as $id_sdm=>$dt_sdm)
                    @foreach($data_bulan as $id_bulan=>$dtbulan)
                        <?php $no=1;?>
                        @foreach($dtbulan['list_tgl'] as $tgl=>$dtgl)
                        <?php
                        $presensi = $dt_sdm['data_presensi'][$tgl];
                        $hariabsen = explode(',',$dtgl['tgl']);
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
                        $ket = "";
                        $j_keluar_start = $jam_keluarex[0];
                        $menit_keluar_start = $jam_keluarex[1];
                        $gabung = 0;$menit = 0;$hitungdurasi_terlambat = 0;$hitungdurasi_pulang_cepat = 0;
                        $warna = "";
                        if($jam_masuk!=null){
                            if(str_replace(':','',$jam_keluar) < str_replace(':','',$jamkerja['jam_pulang'])){
                                if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu" && $jam_masuk != "--:--" && $jam_keluar != "--:--"){

                                    if($jam_masuk!=$jam_keluar){
                                        $ket = "Pulang Cepat";
                                        $pulang_cepat++;
                                        $hitungdurasi_pulang_cepat = Fungsi::hitungdurasipulangcepat($jam_keluar,$jamkerja['jam_pulang']);
                                    }
                                }
                            }


                            if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu"){
                                //if($gabung < $durasi){
                                    $hitungdurasi_terlambat = Fungsi::hitungdurasiterlambat($jamkerja['jam_masuk'],$jam_masuk);
                                    if($hitungdurasi_terlambat>0){
                                        $ket = "Terlambat Datang";
                                    }
                                    if($jam_masuk == $jam_keluar){
                                        $ket = "Absen 1x";
                                    }
                                //}
                            }

                            //$menit = ($gabung*60)+$hasilx[1];

                            $kategori = "";
                            $durasijustifikasi = "";
                            $menitjustifikasi = 0;
                            if($presensi['justifikasi']){
                                $kategori = $presensi['justifikasi']['kategori_justifikasi'];
                                $durasijustifikasi = $presensi['justifikasi']['durasi_justifikasi']." Menit";
                                $menitjustifikasi = $presensi['justifikasi']['durasi_justifikasi'];
                            }
                        }


                        if($hariabsen[0]!="Minggu" && $hariabsen[0]!="Sabtu"){
                            if($ket == null && $jam_masuk==null && $jam_keluar==null){
                                $ket = "Tidak Hadir";
                                $warna = "background-color: #F1E780;";
                            }
                        }
                        if($hariabsen[0]=="Minggu" || $hariabsen[0]=="Sabtu" || $dtgl['ket_nasional'] != null){
                            $warna = "background-color: #F98686;";
                            $ket = "";
                        }
                        if($jam_masuk == null){
                            $jam_masuk = "--:--";
                        }
                        if($jam_keluar == null){
                            $jam_keluar = "--:--";
                        }
                        $absenkehadiran = $dt_sdm['dt_absen'][$tgl]['alasan_absen'];
                        if($absenkehadiran!=null){
                            $ket = $absenkehadiran['kode_alasan'];
                            $warna = "background-color: #F1E780;";
                            $hitungdurasi_terlambat = "0";
                            $hitungdurasi_pulang_cepat = 0;
                        }
                        $durasikerja = "00:00:00";$durasikerjamenit = "0";
                        if($jam_masuk!="--:--" && $jam_keluar!="--:--"){
                            $jamawal = $tgl." ".$jam_masuk;
                            $jamakhir = $tgl." ".$jam_keluar;
                            $durasikerja = Fungsi::durasikerja($jamawal,$jamakhir);
                            $durasikerjamenit = Fungsi::konversiwaktu($durasikerja);
                        }
                        $ketajuan = $getajuan_justifikasi[$id_sdm][$tgl];
                        $durasi_justifikasi = 0;
                        $kategori = "";
                        if($ketajuan){
                            $kategori = $arrkategorijustifikasi[$ketajuan['kategori_justifikasi']];
                            $durasi_justifikasi = $ketajuan['durasi_justifikasi'];
                            $durasijustifikasi = $ketajuan['durasi_justifikasi']." Menit";
                        }else{
                            $durasijustifikasi = "";
                        }
                        $terlambat_durasi = $hitungdurasi_terlambat-$durasi_justifikasi;
                        if($terlambat_durasi == 0){
                            //$ket = "";
                        }
                        ?>
                        <tr style="{{$warna}}">
                            <td>{{$no++}}</td>
                            <td>{{$dt_sdm['nip']}}</td>
                            <td>{{$dt_sdm['nm_sdm']}}</td>
                            <td>{{$dtgl['tgl']}}</td>
                            <td>{{$jam_masuk}}</td>
                            <td>{{$jam_keluar}}</td>
                            <td>{{$durasikerja}}</td>
                            <td>{{$durasikerjamenit}}</td>
                            <td>{{$terlambat_durasi}}</td>
                            <td>{{$hitungdurasi_pulang_cepat}}</td>
                            <td style="font-size:11px;">{{$dtgl['ket_nasional']}}</td>
                            <td>{{$ket}}</td>
                            <td>
                                {{$kategori}}
                            </td>
                            <td>
                                {{$durasijustifikasi}}
                            </td>
                            @if($dt_sdm['id_satker'] == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                            <td>
                                {{$jamkerja['nm_shift']}}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </body>
</div>
</html>
