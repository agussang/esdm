<div class="page" align="center" id="container">
    <body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
        <table width="100%" border=1 cellspacing=0 cellpadding="3" style="font-size:12pt";>
            <thead>
                <tr>
                    <td colspan="14"><span><b>Jam Kerja {{$data['jam_kerja_text']}}</b></span><br/></td>
                </tr>
            </thead>
        </table>
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
                    @if($data['id_satker'] == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
                    <th>Ket Jadwal Shift</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                @foreach($data['arrData'] as $id_sdm=>$dt_sdm)
                    @foreach($dt_sdm['data_presensi'] as $tanggal=>$presensi)
                    <?php
                    $hariabsen = explode(',',$presensi['ket_tgl']);
                    $jam_masuk = array_shift($presensi['jam_absen']);
                    $jam_keluar = end($presensi['jam_absen']);
                    if($jam_keluar==null){
                        $jam_keluar = $jam_masuk;
                    }
                    if($hariabsen[0]=="Jumat"){
                        $jamkerja = $data['jam_kerja'][2];
                    }else{
                        $jamkerja = $data['jam_kerja'][1];
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
                    $menitlemburjumat="540";
                    $menitlemburnonjumat = "510";
                    $masterdurasikerja = Fungsi::konversiwaktu($durasi);
                    if($hariabsen[0]!="Sabtu" && $hariabsen[0]!="Minggu"){
                        if($durasikerja>$durasi){
                            // dikurangi
                            $durasikurangidurasikerja= abs($durasikerjamenit-$masterdurasikerja);
                            if($durasikurangidurasikerja>60){
                                $jamkel = explode(':',$jamkerja['jam_pulang']);
                                $jamlembur = -($jamkel[0]-$j_keluar_start);
                                $menit_lembur = -($jamkel[1]-$menit_keluar_start);
                                $gabung_lembur = sprintf("%02d", $jamlembur).":".sprintf("%02d", $menit_lembur);
                            }
                        }
                    }else{
                        $gabung_lembur = $durasikerja;
                    }
                    $gabung_lembur = floor($durasikurangidurasikerja / 60).':'.($durasikurangidurasikerja -   floor($durasikurangidurasikerja / 60) * 60);
                    $gabung_lembur = explode(":",$gabung_lembur);


                    ?>
                    <tr style="{{$warna}}">
                        <td>{{$no++}}</td>
                        <td>&nbsp;{{$dt_sdm['nip']}}</td>
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
                            0 {{$x}}
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
