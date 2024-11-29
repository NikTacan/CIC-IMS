<?php
require_once('../../assets/PhpSpreadsheet/Spreadsheet.php');
require_once('../../vendor/autoload.php');
include('../../global/model.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$model = new Model();

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$customize = $model->displayReportEdit();

$imagePath = '../../assets/images/' . $customize['logo_file'] . ''; // Update with the path to your image file
$address = $customize['address']; // Update with the address

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$sheet = $spreadsheet->getActiveSheet();

if (isset($_POST['report-excel-assignment-all-all'])) {
    $session_name = $_POST['session_name']; // Session name

    $assignmentItems = $model->getAllInventoryAssignment();

	$date_now = date("Y-m-d");

    // Logo
    $sheet->mergeCells('B1:J3'); 
    $cellWidth = $sheet->getColumnDimension('F')->getWidth();
    $logoWidth = 40; // Width of the logo
    $startX = $cellWidth - $logoWidth; // Starting X coordinate

    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath($imagePath);
    $drawing->setCoordinates('F1'); // Change coordinates to E1
    $drawing->setOffsetX($startX);; // Change coordinates to E1
    
    // Resize the logo
    $drawing->setWidth(100); // Adjust width as needed
    $drawing->setHeight(50); // Adjust height as needed
    
    $drawing->setWorksheet($sheet);
    $sheet->getStyle('B1:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // (College of Information and Computing)
    $sheet->mergeCells('B4:J4'); 
    $sheet->setCellValue('B4', 'College of Information and Computing');
    $sheet->getStyle('B4:J4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B4')->getFont()->setSize(10);

    // (Address)
    $sheet->mergeCells('B5:J5'); 
    $sheet->setCellValue('B5', $address);
    $sheet->getStyle('B5:J5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B5')->getFont()->setSize(10);

    $sheet->mergeCells('B6:I6'); 
    $sheet->mergeCells('B7:I7'); 

    // INVENTORY REPORT"
    $sheet->mergeCells('B8:J8'); 
    $sheet->setCellValue('B8', 'PROPERTY ACKNOWLEDGEMENT RECEIPT');
    $sheet->getStyle('B8:J8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B8')->getFont()->setSize(14);
    $sheet->getStyle('B8')->getFont()->setBold(true);
 
     // (Overall Property Assignment)
     $sheet->mergeCells('B9:J9');
     $sheet->setCellValue('B9', '____Overall Property Assignment____');
     $sheet->getStyle('B9:J9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B9')->getFont()->setUnderline(true);

     // (As of)
    $sheet->mergeCells('B10:J10'); 
    $sheet->setCellValue('B10', 'As of  ' . date('F d, Y', strtotime($date_now)));
    $sheet->getStyle('B10:J10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('B12', 'ACCOUNTABLE END USER');
    $sheet->setCellValue('C12', 'DESCRIPTION');
    $sheet->setCellValue('D12', 'PROPERTY NUMBER');
    $sheet->setCellValue('E12', 'QUANTITY');
    $sheet->setCellValue('F12', 'UNIT OF MEASUREMENT');
    $sheet->setCellValue('G12', 'UNIT VALUE');
    $sheet->setCellValue('H12', 'AMOUNT');
    $sheet->setCellValue('I12', 'PROPERTY ACQUISITION DATE');
    $sheet->setCellValue('J12', 'PROPERTY ASSIGNED TO END USER');

    $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
    foreach ($columns as $column) {
        $sheet->getStyle($column.'12')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle($column.'12')->getFont()->setBold(true);
    }

    $borderRange = 'B12:J12';
    $sheet->getStyle($borderRange)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ]);


    if (!empty($assignmentItems)) {
        $rowIndex = 13; // Start from the 13 row
        
        foreach ($assignmentItems as $assignmentItem) {
			if(!empty($assignmentItem['property_no'])) {
                
                // Insert data into spreadsheet cells
                $sheet->setCellValue('B' . $rowIndex, $assignmentItem['username']);
                $sheet->setCellValue('C' . $rowIndex, $assignmentItem['description']);
                $sheet->setCellValue('D' . $rowIndex, $assignmentItem['property_no']);
                $sheet->setCellValue('E' . $rowIndex, $assignmentItem['qty']);
                $sheet->setCellValue('F' . $rowIndex, $assignmentItem['unit']);
                $sheet->setCellValue('G' . $rowIndex, $assignmentItem['unit_cost']);
                $sheet->setCellValue('H' . $rowIndex, $assignmentItem['total_cost']);
                $sheet->setCellValue('I' . $rowIndex, date('M. d, Y', strtotime($assignmentItem['acquisition_date'])));
                $sheet->setCellValue('J' . $rowIndex, date('M. d, Y', strtotime($assignmentItem['date_added'])));
            

                $sheet->getStyle('B' . $rowIndex . ':J' . $rowIndex)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Apply borders to each cell in the range
                $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
                foreach ($columns as $column) {
                    $sheet->getStyle($column . $rowIndex)->applyFromArray([
                        'borders' => [
                            'left' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                            'right' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    ]);
                }

                $rowIndex++;
            }
        }
    } 

    if (!empty($assignmentItems)) {

        // Add content below "Printed by:"
        $rowIndex--; // Increment rowIndex to move to the next row

        $sheet->mergeCells('B' . ($rowIndex + 1) . ':E' . ($rowIndex + 1));

        // Printed by:
        $sheet->setCellValue('B' . ($rowIndex + 2), 'Printed by:');
        $sheet->getStyle('B' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . ($rowIndex + 2))->getFont()->setBold(true);
       
        // Printed by name
        $sheet->mergeCells('B' . ($rowIndex + 3) . ':E' . ($rowIndex + 3));
        $sheet->setCellValue('B' . ($rowIndex + 3), '_______________'. $session_name .'________________');
        $sheet->getStyle('B' . ($rowIndex + 3) . ':E' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('B' . ($rowIndex + 4) . ':E' . ($rowIndex + 4));
        $sheet->setCellValue('B' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('B' . ($rowIndex + 4) . ':E' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('B' . ($rowIndex + 5) . ':E' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('B' . ($rowIndex + 6) . ':E' . ($rowIndex + 6));
        $sheet->setCellValue('B' . ($rowIndex + 6), '_______________'. date('F d, Y', strtotime($date_now)) .'________________');
        $sheet->getStyle('B' . ($rowIndex + 6) . ':E' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('B' . ($rowIndex + 7) . ':E' . ($rowIndex + 7));
        $sheet->setCellValue('B' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('B' . ($rowIndex + 7) . ':E' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('B' . ($rowIndex + 8) . ':E' . ($rowIndex + 8));
        
        // Apply border around the content
        $borderRange = 'B' . ($rowIndex + 1) . ':E' . ($rowIndex + 8);
        $sheet->getStyle($borderRange)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->mergeCells('F' . ($rowIndex + 1) . ':J' . ($rowIndex + 1));

        // Printed by:
        $sheet->setCellValue('F' . ($rowIndex + 2), 'Noted by:');
        $sheet->getStyle('F' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F' . ($rowIndex + 2))->getFont()->setBold(true);
    
        // Printed by name
        $sheet->mergeCells('F' . ($rowIndex + 3) . ':J' . ($rowIndex + 3));
        $sheet->setCellValue('F' . ($rowIndex + 3), '_______________________________________');
        $sheet->getStyle('F' . ($rowIndex + 3) . ':J' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('F' . ($rowIndex + 4) . ':J' . ($rowIndex + 4));
        $sheet->setCellValue('F' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('F' . ($rowIndex + 4) . ':J' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('F' . ($rowIndex + 5) . ':J' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('F' . ($rowIndex + 6) . ':J' . ($rowIndex + 6));
        $sheet->setCellValue('F' . ($rowIndex + 6), '_______________________________________');
        $sheet->getStyle('F' . ($rowIndex + 6) . ':J' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('F' . ($rowIndex + 7) . ':J' . ($rowIndex + 7));
        $sheet->setCellValue('F' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('F' . ($rowIndex + 7) . ':J' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('F' . ($rowIndex + 8) . ':J' . ($rowIndex + 8));
        
        // Apply border around the content
        $borderRange = 'F' . ($rowIndex + 1) . ':J' . ($rowIndex + 8);
        $sheet->getStyle($borderRange)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    }


    // Set the column width for columns A to F
    $widthSm = 11.00;
    $widthMd = 15.00;
    $widthLg = 35.00;
    $sheet->getColumnDimension('B')->setWidth($widthMd); // Property Number
    $sheet->getColumnDimension('C')->setWidth($widthLg); // Description
    $sheet->getColumnDimension('D')->setWidth($widthMd); // End User
    $sheet->getColumnDimension('E')->setWidth($widthMd); // Quantity
    $sheet->getColumnDimension('F')->setWidth($widthMd); // Unit
    $sheet->getColumnDimension('G')->setWidth($widthMd); // Unit Value
    $sheet->getColumnDimension('H')->setWidth($widthMd); // Total Amount
    $sheet->getColumnDimension('I')->setWidth($widthMd); // Acquisition Date
    $sheet->getColumnDimension('J')->setWidth($widthMd); // Property Assigned to End User

    $sheet->getStyle('B')->getAlignment()->setWrapText(true); // Property Number
    $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Description
    $sheet->getStyle('D')->getAlignment()->setWrapText(true); // End User
    $sheet->getStyle('E')->getAlignment()->setWrapText(true); // Quantity
    $sheet->getStyle('F')->getAlignment()->setWrapText(true); // Unit
    $sheet->getStyle('G')->getAlignment()->setWrapText(true); // Unit Value
    $sheet->getStyle('H')->getAlignment()->setWrapText(true); // Total Amount
    $sheet->getStyle('I')->getAlignment()->setWrapText(true); // Acquisition Date
    $sheet->getStyle('J')->getAlignment()->setWrapText(true); // Property Assigned to End Use
    
    // Set the Excel sheet size to A4 for printing
    $spreadsheet->getActiveSheet()->getPageSetup()
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

    // Set the orientation to portrait (vertical)
    $spreadsheet->getActiveSheet()->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);

    // Set the print area to fit the content
    $spreadsheet->getActiveSheet()->getPageSetup()
    ->setFitToWidth(1)
    ->setFitToHeight(0);

    // Adjust margins if needed
    $spreadsheet->getActiveSheet()->getPageMargins()
    ->setTop(0.75)
    ->setBottom(0.75)
    ->setLeft(0.7)
    ->setRight(0.7);


    // Save the spreadsheet to a file
    $writer = new Xlsx($spreadsheet);
    $filename = 'Inventory-Assignment-Overall-' . $date_now . '.xlsx'; // Specify the file name
    
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename );
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
}
?>