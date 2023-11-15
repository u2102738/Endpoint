<?php

namespace App\Exports;

use App\Models\Device;
use App\Models\Hardware;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class DeviceExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithEvents, WithColumnWidths
{
    private $devices;
    private $softwareName;
    private $date;

    public function __construct(Collection $devices, $softwareName, $date)
    {
        $this->devices = $devices;
        $this->softwareName = $softwareName;
        $this->date = $date;
    }

    public function getGroupForDevice(Device $device)
    {
        // Get the group name for the device (comma-separated if multiple groups)
        $groups = $device->groups;
        return $groups->isEmpty() ? 'N/A' : $groups->pluck('name')->implode(', ');
    }

    public function collection()
    {
        return $this->devices->map(function (Device $device) {
            return [
                'Device Name' => $device->name,
                'Device Owner' => $device->device_owner,
                'Group' => $this->getGroupForDevice($device),
                'Serial Number' => $device->hardware->serial_number,
            ];
        });
    }

    public function headings(): array
    {
        return [' #', 'Device Name', 'Device Owner','Group','Serial Number'];
    }

    public function title(): string
    {
        return 'Device Report';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 30,
            'C' => 25,
            'D' => 30,
            'E' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Set the software name and report date
                $sheet->setCellValue('A1', 'Software Name: ' . $this->softwareName);
                $sheet->setCellValue('A2', 'Report Date: ' . $this->date);

                // Merge cells and apply styling
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->getStyle('A1:E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Set the table headers
                $sheet->setCellValue('A3', '#');
                $sheet->setCellValue('B3', 'Device Name');
                $sheet->setCellValue('C3', 'Device Owner');
                $sheet->setCellValue('D3', 'Serial Number');
                $sheet->setCellValue('E3', 'Group');

                // Get the table data
                $tableData = $this->collection();

                // Add table data starting from row 4
                $row = 4;
                $index = 1;
                foreach ($tableData as $data) {
                    $sheet->setCellValue('A' . $row, $index);
                    $sheet->setCellValue('B' . $row, $data['Device Name']);
                    $sheet->setCellValue('C' . $row, $data['Device Owner']);
                    $sheet->setCellValue('D' . $row, $data['Serial Number']);
                    $sheet->setCellValue('E' . $row, $data['Group']);
                    $row++;
                    $index++;
                }

                // Merge the cells in row 1 and apply styling
                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'size' => [
                        '14',
                    ]
                ]);

                // Merge the cells in row 2 and apply styling
                $sheet->mergeCells('A2:E2');
                $sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);

                $sheet->getStyle('A3:E3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E6B8B7',
                        ],
                    ],
                ]);

                // Get the last row of data
                $lastRow = $row - 1;
                $sheet->getDefaultRowDimension()->setRowHeight(18);
                $sheet->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A3:E' . $lastRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A3:E' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('D4:E' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            },
        ];
    }
}
