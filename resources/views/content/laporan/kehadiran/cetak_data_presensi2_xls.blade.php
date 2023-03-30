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
            @if($data['id_satker'] == "30c82828-d938-42c1-975e-bf8a1db2c7b0")
            <th rowspan="2">Ket Jadwal Shift</th>
            @endif
        </tr>
        <tr>
            <th>Kategori</th>
            <th>Durasi Justifikasi<br/>(Menit)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['arrData'] as $id_sdm=>$dt_sdm)
            @foreach($data['data_bulan'] as $id_bulan=>$dtbulan)
                <?php $no=1;?>
                @foreach($dtbulan['list_tgl'] as $tgl=>$dtgl)
                <?php
                $presensi = $dt_sdm['data_presensi'][$tgl];
                $hariabsen = explode(',',$dtgl['tgl']);
                $jam_masuk = array_shift($presensi['jam_absen']);
                $jam_keluar = end($presensi['jam_absen']);
                $ketajuan = $data['getajuan_justifikasi'][$id_sdm][$tgl];
                if($ketajuan){
                    if($ketajuan['kategori_justifikasi']=="4" && $ketajuan['status']=="1"){
                        $jam_masuk = $ketajuan['jam_masuk'];
                        $jam_keluar = $ketajuan['jam_pulang'];
                    }
                }
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
                $ketajuan = $data['getajuan_justifikasi'][$id_sdm][$tgl];
                $durasi_justifikasi = 0;
                $kategori = "";
                if($ketajuan){
                    $kategori = $data['arrkategorijustifikasi'][$ketajuan['kategori_justifikasi']];
                    if($ketajuan['kategori_justifikasi']!="4" && $ketajuan['status']=="1"){
                        $durasi_justifikasi = $ketajuan['durasi_justifikasi'];
                        $durasijustifikasi = $ketajuan['durasi_justifikasi']." Menit";
                    }
                }else{
                    $durasijustifikasi = "";
                }
                $terlambat_durasi = abs($hitungdurasi_terlambat-$durasi_justifikasi);
                if($terlambat_durasi == 0){
                    //$ket = "";
                }
                if($jamkerja['nm_shift']=="Libur"){
                        $ket = "";
                        $warna = "background-color: #F98686;";
                    }
                ?>
                <tr style="{{$warna}}">
                    <td>{{$no++}}</td>
                    <td>&nbsp;{{$dt_sdm['nip']}}</td>
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

