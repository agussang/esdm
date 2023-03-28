@foreach($data['data_bulan'] as $id_bulan=>$dt_bln)
<table width="100%" border=1 cellspacing=0 cellpadding="3" style="font-size:12pt";>
    <tr valign="top">
        <td colspan="14"><span><b>Data Presensi Pegawai Bulanan</b></span><br/></td>
    </tr>
    <tr valign="top">
        <td colspan="14"><span><b>Jam Kerja : {{$data['jam_kerja_text']}}</b></span><br/></td>
    </tr>
</table>
<table width="100%" border=0 cellspacing=0 cellpadding="3" style="font-size:12pt";>
    <thead>
        <tr>
            <td>Nama Bulan</td>
            <td>:</td>
            <td>{{$dt_bln['nm_bulan']}}</td>
            <td>Jumlah Hari</td>
            <td>:</td>
            <td>{{count($dt_bln['list_tgl'])}}</td>
        </tr>
        <tr>
            <td>Jumlah Hari Kerja</td>
            <td>:</td>
            <td>{{count($dt_bln['hari_kerja'])}}</td>
            <td>Jumlah Hari Libur Nasional</td>
            <td>:</td>
            <td>{{count($dt_bln['hari_libur_nasional'])}}</td>
        </tr>
    </thead>
</table>
<table width="950" border=1 cellspacing=0 cellpadding="3" style="font-size:10pt";>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nip</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">Hari Kerja</th>
            <th rowspan="2">Jmlh Kehadiran</th>
            <th rowspan="2">Terlambat <br/>( Menit )</th>
            <th rowspan="2">Pulang Cepat</th>
            <th rowspan="2">Finger 1 kali</th>
            <th rowspan="2">Tidak Hadir Apel</th>
            <th colspan="{{count($data['arrAlasan'])+1}}">Keterangan Tidak Masuk</th>
            <th rowspan="2">Total Tidak Hadir</th>
        </tr>
        <tr>
            <th>Tidak Masuk Tanpa Keterangan</th>
            @foreach($data['arrAlasan'] as $id=>$nm_alasan)
            <th>{{$nm_alasan}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <?php $no=1;?>
        @foreach($data['arrData'] as $id_sdm=>$dt_sdm)
        <?php
        $kode = $data['tahun'].sprintf("%02d", $id_bulan);
        $dt_presensi = $dt_sdm['data_presensi'][$kode];
        $jmh_hari_kerja = count($dt_bln['list_tgl']) - count($data['dt_hari_libur'][$dt_bln['tahun']."-".$id_bulan]);
        $total_tidak_masuk = $dt_presensi['tidakmasuk']['total'];
        ?>
        @if(count($dt_presensi)>0)
        <tr>
            <td>{{$no++}}</td>
            <td>&nbsp;{{$dt_sdm['nip']}}</td>
            <td>{{$dt_sdm['nm_sdm']}}</td>
            <td align="center">{{count($dt_bln['hari_kerja'])}}</td>
            <td align="center">{{(int)$dt_presensi['masuk']['total']}}</td>
            <td align="center">{{(int)$dt_presensi['telat']['total'] - $data['arrjumlahjustifikasi'][$id_sdm]['jumlah_justifikasi']}}</td>
            <td align="center">{{(int)$dt_presensi['pulang_cepat']['total']}}</td>
            <td align="center">{{(int)$dt_presensi['absensekali']['total']}}</td>
            <td align="center">{{(int)$dt_presensi['dt_apel']['tidak_hadir']['total']}}</td>
            <td align="center">{{(int)$dt_presensi['tidakmasuk']['total']}}</td>
            @foreach($data['arrAlasan'] as $id=>$nm_alasan)
            <?php
            $absenalasan = $dt_presensi['absen'][$id]['data']['total'];
            if($absenalasan==null){
                $absenalasan = count($arrjumlahabsen[$dt_sdm['nip']][$nm_alasan]);
            }
            $total_tidak_masuk+=$absenalasan;
            ?>
            <td align="center">{{$absenalasan}}</td>
            @endforeach
            <td align="center">{{$total_tidak_masuk}}</td>
        </tr>
        @else
        <tr>
            <td>{{$no++}}</td>
            <td>{{$dt_sdm['nip']}}</td>
            <td>{{$dt_sdm['nm_sdm']}}</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            <td align="center">0</td>
            @foreach($arrAlasan as $id=>$nm_alasan)
                <td align="center">{{count($arrjumlahabsen[$dt_sdm['nip']][$nm_alasan])}}</td>
            @endforeach
            <td align="center"></td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@endforeach
