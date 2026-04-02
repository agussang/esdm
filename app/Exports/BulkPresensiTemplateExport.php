<?php

namespace App\Exports;

use App\Models\MsPegawai;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BulkPresensiTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    public function headings(): array
    {
        return [
            'NIP',
            'NAMA PEGAWAI',
            'TANGGAL (YYYY-MM-DD)',
            'JAM MASUK (HH:MM)',
            'JAM PULANG (HH:MM)',
            'KETERANGAN',
        ];
    }

    public function array(): array
    {
        // Ambil pegawai aktif untuk sample data berbagai case
        $pegawai = MsPegawai::whereNull('deleted_at')
            ->where('nip', '!=', '')
            ->orderBy('nm_sdm')
            ->limit(10)
            ->get(['nip', 'nm_sdm']);

        if ($pegawai->count() < 5) {
            return [];
        }

        $tglBase = date('Y-m-01'); // awal bulan ini

        // Helper: ambil N hari kerja dari tanggal mulai
        $hariKerjaList = function($start, $count) {
            $result = [];
            $current = strtotime($start);
            while (count($result) < $count) {
                $dow = date('N', $current);
                if ($dow < 6) { // Senin-Jumat
                    $result[] = date('Y-m-d', $current);
                }
                $current = strtotime('+1 day', $current);
            }
            return $result;
        };

        // Ambil 25 hari kerja dari awal bulan
        $hk = $hariKerjaList($tglBase, 25);

        $p = $pegawai->values();
        $rows = [];

        // ============================================================
        // CASE 1: WFH normal (masuk & pulang lengkap)
        // ============================================================
        $rows[] = [$p[0]->nip, $p[0]->nm_sdm, $hk[0], '07:30', '16:00', 'WFH'];
        $rows[] = [$p[0]->nip, $p[0]->nm_sdm, $hk[1], '07:30', '16:00', 'WFH'];

        // ============================================================
        // CASE 2: Finger error - jam normal
        // ============================================================
        $rows[] = [$p[1]->nip, $p[1]->nm_sdm, $hk[2], '07:15', '16:15', 'Finger Error'];

        // ============================================================
        // CASE 3: Dinas luar - berangkat pagi pulang sore
        // ============================================================
        $rows[] = [$p[2]->nip, $p[2]->nm_sdm, $hk[3], '06:00', '18:00', 'Dinas Luar Kota'];
        $rows[] = [$p[2]->nip, $p[2]->nm_sdm, $hk[4], '06:00', '18:00', 'Dinas Luar Kota'];

        // ============================================================
        // CASE 4: Jam pulang kosong (lupa absen pulang / hanya absen masuk)
        // ============================================================
        $rows[] = [$p[3]->nip, $p[3]->nm_sdm, $hk[5], '07:30', '', 'Finger Error - Lupa Absen Pulang'];
        $rows[] = [$p[4]->nip, $p[4]->nm_sdm, $hk[5], '07:15', '', 'WFH - Hanya Absen Masuk'];
        $rows[] = [$p[5]->nip, $p[5]->nm_sdm, $hk[5], '08:00', '', 'Dinas Luar - Belum Kembali'];

        // ============================================================
        // CASE 5: Terlambat masuk (> 15 menit)
        // ============================================================
        $rows[] = [$p[4]->nip, $p[4]->nm_sdm, $hk[6], '08:00', '16:30', 'WFH - Terlambat Mulai Kerja'];

        // ============================================================
        // CASE 6: Terlambat masuk <= 15 menit, pulang mundur (tidak dihitung telat)
        // ============================================================
        $rows[] = [$p[5]->nip, $p[5]->nm_sdm, $hk[7], '07:45', '16:15', 'WFH - Masuk Telat 15 Menit Pulang Mundur'];

        // ============================================================
        // CASE 7: Pulang cepat
        // ============================================================
        $rows[] = [$p[6]->nip, $p[6]->nm_sdm, $hk[8], '07:30', '14:00', 'Finger Error - Ijin Pulang Cepat'];

        // ============================================================
        // CASE 8: Satu pegawai banyak hari sekaligus (bulk per pegawai)
        // ============================================================
        for ($d = 0; $d < 5; $d++) {
            $rows[] = [$p[7]->nip, $p[7]->nm_sdm, $hk[9 + $d], '07:30', '16:00', 'WFH - Isolasi Mandiri'];
        }

        // ============================================================
        // CASE 9: Shift malam / lembur (jam di atas normal)
        // ============================================================
        $rows[] = [$p[8]->nip, $p[8]->nm_sdm, $hk[14], '07:00', '21:00', 'Lembur - Deadline Proyek'];

        // ============================================================
        // CASE 10: Banyak pegawai 1 tanggal yang sama (finger mati seharian)
        // ============================================================
        $rows[] = [$p[0]->nip, $p[0]->nm_sdm, $hk[15], '07:30', '16:00', 'Mesin Finger Mati'];
        $rows[] = [$p[1]->nip, $p[1]->nm_sdm, $hk[15], '07:15', '16:00', 'Mesin Finger Mati'];
        $rows[] = [$p[2]->nip, $p[2]->nm_sdm, $hk[15], '07:30', '16:30', 'Mesin Finger Mati'];
        $rows[] = [$p[3]->nip, $p[3]->nm_sdm, $hk[15], '07:00', '16:00', 'Mesin Finger Mati'];
        $rows[] = [$p[4]->nip, $p[4]->nm_sdm, $hk[15], '07:30', '16:00', 'Mesin Finger Mati'];

        return $rows;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,          // NIP as text
            'C' => NumberFormat::FORMAT_DATE_YYYYMMDD2, // Tanggal
            'D' => NumberFormat::FORMAT_TEXT,          // Jam masuk
            'E' => NumberFormat::FORMAT_TEXT,          // Jam pulang
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Sample data styling (italic, gray)
        $lastRow = $sheet->getHighestRow();
        if ($lastRow > 1) {
            $sheet->getStyle("A2:F{$lastRow}")->applyFromArray([
                'font' => [
                    'italic' => true,
                    'color' => ['rgb' => '808080'],
                ],
            ]);
        }

        // Add note/instruction di bawah sample data
        $noteRow = $lastRow + 2;
        $sheet->setCellValue("A{$noteRow}", 'PETUNJUK PENGISIAN:');
        $sheet->getStyle("A{$noteRow}")->getFont()->setBold(true);

        $instructions = [
            'NIP: Isi sesuai NIP pegawai yang terdaftar di sistem (wajib)',
            'NAMA PEGAWAI: Untuk referensi saja, tidak diproses oleh sistem',
            'TANGGAL: Format YYYY-MM-DD, contoh: 2026-04-01 (wajib)',
            'JAM MASUK: Format HH:MM, contoh: 07:30 (wajib)',
            'JAM PULANG: Format HH:MM, contoh: 16:00 (opsional, kosongkan jika hanya absen masuk)',
            'KETERANGAN: Alasan upload manual, contoh: WFH, Finger Error, Dinas Luar (opsional)',
            'Hapus baris contoh (berwarna abu-abu) sebelum upload',
            'Data duplikat (NIP + tanggal + jam yang sama) akan otomatis dilewati',
        ];

        foreach ($instructions as $i => $text) {
            $row = $noteRow + 1 + $i;
            $sheet->setCellValue("A{$row}", ($i + 1) . '. ' . $text);
            $sheet->getStyle("A{$row}")->getFont()->setSize(10);
        }

        return [];
    }
}
