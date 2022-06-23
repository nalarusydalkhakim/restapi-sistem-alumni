<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TracerExport implements FromCollection, WithHeadings, WithCustomStartCell, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::leftjoin('tracer_studies', 'tracer_studies.user_id', '=', 'users.id')
                    ->leftjoin('tracer_works', 'tracer_works.user_id', '=', 'users.id')
                    ->leftjoin('tracer_entrepreneurs', 'tracer_entrepreneurs.user_id', '=', 'users.id')
                    ->select('name', 'university_name', 'university_address', 'study_location', 'departement', 'tracer_studies.entry_year', 'tracer_studies.graduate_year', 'study_matches', 
                             'company_name', 'company_address', 'company_sector', 'position', 'contract_status', 'salary', 'start_working', 'get_job_from', 'job_matches',
                             'business_name', 'business_address', 'business_sector', 'business_phone', 'establish_year', 'capital_source', 'income', 'business_matches')
                    ->where('role', 'user')
                    ->get();
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function registerEvents(): array {
        
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                $sheet->mergeCells('A1:A2');
                $sheet->setCellValue('A1', "Nama");

                $sheet->mergeCells('B1:H1');
                $sheet->setCellValue('B1', "Study Lanjut");

                $sheet->mergeCells('I1:Q1');
                $sheet->setCellValue('I1', "Bekerja");

                $sheet->mergeCells('R1:X1');
                $sheet->setCellValue('R1', "Wira Swasta");
                
                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                
                $cellRange = 'A1:X1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
            },
        ];
    }

    public function headings(): array
    {
        return [
                "Nama",
                'Nama Perguruan Tinggi',
                'Alamat Perguruan Tinggi',
                'Dalam atau Luar Negeri',
                'Bidang/Jurusan',
                'Tahun Masuk',
                'Tahun Lulus',
                'Kesesuaian Jurusan/Bidang',
                'Nama Perusahaan',
                'Alamat Perusahaan',
                'Sektor Industri',
                'Posisi Dalam Perusahaan',
                'Status Kontrak',
                'Gaji',
                'Mulai Bekerja',
                'Memperoleh Pekerjaan',
                'Kesesuaian Pekerjaan dengan Jurusan',
                'Nama Usaha',
                'Alamat Bisnis',
                'Bidang Usaha',
                'No. Telp Usaha',
                'Tahun Berdiri',
                'Sumber Permodalan',
                'Estimasi Pendapatan',
                'Kesesuaian Usaha dengan Jurusan',
        ];
    }
}
