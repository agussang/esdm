<div calss="row">
    <div class="col-md-12">
        <table>
            <tr>
                <td >Skp Terisi</td>
                <td >: </td>
                <td ><div id="terisi"></div></td>
            </tr>
            <tr><td>Skp Belum Terisi</td>
                <td>: </td>
                <td><div id="belumterisi"></div></td>
            </tr>
            <tr>
                <td>Skp Belum Dinilai</td>
                <td>: </td>
                <td><div id="sudahdiisibelumdinilai"></div></td>
            </tr>
            <tr>
                <td>Skp Sudah Dinilai</td>
                <td>: </td>
                <td><div id="sudahdinilai"></div></td>
            </tr>
            <tr>
                <td>Batas Pengumpulan Skp</td>
                <td>: </td>
                <td><i><b>{{date('d-m-Y',strtotime($data['periode_skp']->tgl_batas_skp))}}</b></i></td>
            </tr>
            <tr>
                <td>Tanggal Pengurang remun 3%</td>
                <td>: </td>
                <td><i><b>{{date('d-m-Y',strtotime($data['periode_skp']->tgl_potongan3persen))}}</b></i></td>
            </tr>
            <tr>
                <td>Tanggal Download Dokumen Rekap SKP</td>
                <td>: </td>
                <td><i><b>{{date('d-m-Y H:i:s')}}</b></i></td>
            </tr>
        </table>
    </div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nip / Nama</th>
            <th rowspan="2"><center>Atasan Langsung</center></th>
            <th colspan="6"><center>Realisasi SKP</center></th>
        </tr>
        <tr>
            <th>Tanggal Unggah SKP</th>
            <th>Nilai Realisasi</th>
            <th>Disetujui</th>
            <th>File Skp</th>
            <th>Point Pengurang</th>
            <th>Justifikasi?</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1;$terisi = 0;$belumterisi=0;$sudahdiisibelumdinilai=0;$sudahdinilai=0;?>
        @foreach($data['rsData'] as $rs=>$r)
        <?php
        $dtnilai_skp = $data['arrrekapnilai'][$r->id_sdm];
        $point = "100";
        $ket = "Belum mengumpulkan.";
        if($dtnilai_skp['created_at']!=null && $dtnilai_skp['point_disiplin']>0){
            $point = $dtnilai_skp['point_disiplin'];
            $ket = $dtnilai_skp['ket_disiplin'];
        }else if($dtnilai_skp['created_at']!=null && $dtnilai_skp['point_disiplin']<1){
            $point = "0";
            $ket = "Sudah dinilai";
        }
        if($dtnilai_skp['nilai_skp']==null && $dtnilai_skp['created_at']!=null){
            $ket = "Belum dinilai.<br/>".$dtnilai_skp['ket_disiplin'];
            $sudahdiisibelumdinilai++;
        }
        if($dtnilai_skp!=null){
            $terisi++;
        }
        if($dtnilai_skp==null){
            $belumterisi++;
        }
        if($dtnilai_skp['nilai_skp']){
            $sudahdinilai++;
        }
        ?>
        <tr>
            <td>{{$no++}}</td>
            <td>
                <b>{{$r->nm_sdm}}</b><br/>
                {{$r->nip}}
            </td>
            <td>{{$r->nm_atasan->nm_sdm}}</td>
            <td>{{$dtnilai_skp['created_at']}}</td>
            <td>{{$dtnilai_skp['nilai_skp']}}</td>
            <td align="center">
                @if($dtnilai_skp)
                    @if($dtnilai_skp['validasi']!=1)
                        <span class="badge badge-danger">Belum Tervalidasi</span>
                    @else
                        <span class="badge badge-success">Valid</span><br/>
                        <span>
                            {{$dtnilai_skp['validated_at']}}
                        </span>
                    @endif
                @endif
            </td>
            <td align="center">
                @if($dtnilai_skp['file_skp'])
                    <a href="{{URL::to('assets/file_bukti_skp')}}/{{$dtnilai_skp['file_skp']}}" target="_blank">Lihat SKP</a>
                @endif
            </td>
            <td align="center">
                <span>
                    {{$point}} %<br/>
                    <i style="font-size:10px;">
                        {!!$ket!!}
                    </i>
                </span>
            </td>
            <td align="center">
                @if($dtnilai_skp['ket_justifikasi'])
                <span class="mt-2 badge badge-primary">Ya</span>
                @else
                <span class="mt-2 badge badge-danger">Tidak</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


