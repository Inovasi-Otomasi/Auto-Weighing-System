<?php

namespace App\Exports;

use App\Models\Historical;
use App\Models\Line;
use App\Models\Machine;
use App\Models\Shift;
use App\Models\Sku;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Excel;


class HistoricalLogExport implements WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     return Historical::all();
    // }
    protected $parameter;
    public function __construct($request)
    {
        // $datetimeexplode = explode(' To ', $request->datetimerange2);
        // $start = $datetimeexplode[0];
        // $end = $datetimeexplode[1];
        $this->parameter = [
            'range' => (int)$request->input('range') ?: 1,
            'from' => $request->input('from') ?: NULL,
            'to' => $request->input('to') ?: NULL,
            'line' => $request->input('line') ?: NULL,
            'machine' => $request->input('machine') ?: NULL,
            'shift' => $request->input('shift') ?: NULL,
            'sku' => $request->input('sku') ?: NULL,
        ];
    }
    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $templateFile = new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('Historical.xlsx'));
                // $templateFile = new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('users.xlsx'));
                $event->writer->reopen($templateFile, Excel::XLSX);
                // $sheet = $event->writer->getSheetByName('DOWNTIME RECORD');
                $sheet = $event->writer->getSheetByIndex(0);
                $this->populateSheet($sheet);

                $event->writer->getSheetByIndex(0)->export($event->getConcernable()); // call the export on the first sheet

                return $event->getWriter()->getSheetByIndex(0);
            },
        ];
    }
    private function populateSheet($sheet)
    {
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $numrow = 4;
        // Populate the static cells
        $sheet->setCellValue('A3', "LINE");
        $sheet->setCellValue('B3', "MACHINE");
        $sheet->setCellValue('C3', "SHIFT");
        $sheet->setCellValue('D3', "SKU");
        $sheet->setCellValue('E3', "WEIGHT");
        $sheet->setCellValue('F3', "TARGET");
        $sheet->setCellValue('G3', "THRESHOLD HIGH");
        $sheet->setCellValue('H3', "THRESHOLD LOW");
        $sheet->setCellValue('I3', "STATUS");
        $sheet->setCellValue('J3', "CREATED AT");
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        //query
        // $proxy = Historical::all();
        $parameters_log = DB::table('historical_log');
        if ($this->parameter['line']) {
            $line_name = Line::where('id', $this->parameter['line'])->first()->line_name;
            $parameters_log = $parameters_log->where('line_name', $line_name);
        }
        if ($this->parameter['machine']) {
            $machine_name = Machine::where('id', $this->parameter['machine'])->first()->machine_name;
            $parameters_log = $parameters_log->where('machine_name', $machine_name);
        }
        if ($this->parameter['shift']) {
            $shift_name = Shift::where('id', $this->parameter['shift'])->first()->shift_name;
            $parameters_log = $parameters_log->where('shift_name', $shift_name);
        }
        if ($this->parameter['sku']) {
            $sku_name = Sku::where('id', $this->parameter['sku'])->first()->sku_name;
            $parameters_log = $parameters_log->where('sku_name', $sku_name);
        }
        if ($this->parameter['from'] && $this->parameter['to']) {
            $from = date("Y-m-d H:i:s", $this->parameter['from']);
            $to = date("Y-m-d H:i:s", $this->parameter['to']);
            $parameters_log = $parameters_log->where([
                ['created_at', '>=', $from], ['created_at', '<=', $to]
            ])->latest()->get();
        } elseif ($this->parameter['range']) {
            $parameters_log = $parameters_log->where('created_at', '>=', Carbon::now()->subDays($this->parameter['range']))->latest()->get();
        }

        foreach ($parameters_log as $row) {
            // $sheet->setCellValue('B' . $numrow, $row->line_name);
            $sheet->setCellValue('A' . $numrow, $row->line_name);
            $sheet->setCellValue('B' . $numrow, $row->machine_name);
            $sheet->setCellValue('C' . $numrow, $row->shift_name);
            $sheet->setCellValue('D' . $numrow, $row->sku_name);
            $sheet->setCellValue('E' . $numrow, $row->weight);
            $sheet->setCellValue('F' . $numrow, $row->target);
            $sheet->setCellValue('G' . $numrow, $row->th_H);
            $sheet->setCellValue('H' . $numrow, $row->th_L);
            $sheet->setCellValue('I' . $numrow, $row->status);
            $sheet->setCellValue('J' . $numrow, $row->created_at);
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('J' . $numrow)->applyFromArray($style_row);
            $numrow++;
        };
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
    }
}
