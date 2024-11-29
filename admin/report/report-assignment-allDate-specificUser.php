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

if (isset($_POST['report-excel-assignment-all'])) {
    $end_user = $_POST['end_user'];
    $session_name = $_POST['session_name']; // Session name

    $assignmentItems = $model->getEndUserAssignment($end_user);

    $endUserDetail = $model->getEndUserDetailById($end_user);
    $endUsername = $endUserDetail['username'];

	$date_now = date("Y-m-d");

    // Logo
    $sheet->mergeCells('B1:I3'); 
    $cellWidth = $sheet->getColumnDimension('E')->getWidth();
    $logoWidth = 105; // Width of the logo
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
    $sheet->getStyle('B1:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // (College of Information and Computing)
    $sheet->mergeCells('B4:I4'); 
    $sheet->setCellValue('B4', 'College of Information and Computing');
    $sheet->getStyle('B4:I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B4')->getFont()->setSize(10);

    // (Address)
    $sheet->mergeCells('B5:I5'); 
    $sheet->setCellValue('B5', $address);
    $sheet->getStyle('B5:I5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B5')->getFont()->setSize(10);

    $sheet->mergeCells('B6:I6'); 
    $sheet->mergeCells('B7:I7'); 

    // Property Acknowledgement Receipt
    $sheet->mergeCells('B8:I8'); 
    $sheet->setCellValue('B8', 'PROPERTY ACKNOWLEDGEMENT RECEIPT');
    $sheet->getStyle('B8:I8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B8')->getFont()->setSize(14);
    $sheet->getStyle('B8')->getFont()->setBold(true);

     // End User Name
     $sheet->mergeCells('B9:I9');
     $sheet->setCellValue('B9', '______' . $endUsername . '______');
     $sheet->getStyle('B9:I9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
     $sheet->getStyle('B9')->getFont()->setUnderline(true);
 
     // (Accountable End User)
     $sheet->mergeCells('B10:I10');
     $sheet->setCellValue('B10', '(Accountable End User)');
     $sheet->getStyle('B10:I10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

     // (As of)
    $sheet->mergeCells('B11:I11'); 
    $sheet->setCellValue('B11', 'As of  ' . date('M d, Y', strtotime($date_now)));
    $sheet->getStyle('B11:I11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('B13', 'PROPERTY NUMBER');
    $sheet->setCellValue('C13', 'DESCRIPTION');
    $sheet->setCellValue('D13', 'QUANTITY');
    $sheet->setCellValue('E13', 'UNIT OF MEASUREMENT');
    $sheet->setCellValue('F13', 'UNIT VALUE');
    $sheet->setCellValue('G13', 'AMOUNT');
    $sheet->setCellValue('H13', 'PROPERTY ACQUISITION DATE');
    $sheet->setCellValue('I13', 'PROPERTY ASSIGNED TO END USER');

    $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
    foreach ($columns as $column) {
        $sheet->getStyle($column.'13')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle($column.'13')->getFont()->setBold(true);
    }

    $borderRange = 'B13:I13';
    $sheet->getStyle($borderRange)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ]);


    if (!empty($assignmentItems)) {
        $rowIndex = 14; // Start from the 10 row
        
        foreach ($assignmentItems as $assignmentItem) {
            if(!empty($assignmentItem['property_no'])) {
                // Insert data into spreadsheet cells
                $sheet->setCellValue('B' . $rowIndex, $assignmentItem['property_no']);
                $sheet->setCellValue('C' . $rowIndex, $assignmentItem['description']);
                $sheet->setCellValue('D' . $rowIndex, $assignmentItem['qty']);
                $sheet->setCellValue('E' . $rowIndex, $assignmentItem['unit']);
                $sheet->setCellValue('F' . $rowIndex, $assignmentItem['unit_cost']);
                $sheet->setCellValue('G' . $rowIndex, $assignmentItem['total_cost']);
                $sheet->setCellValue('H' . $rowIndex, date('M. d, Y', strtotime($assignmentItem['acquisition_date'])));
                $sheet->setCellValue('I' . $rowIndex, date('M. d, Y', strtotime($assignmentItem['date_added'])));
            

                $sheet->getStyle('B' . $rowIndex . ':I' . $rowIndex)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Apply borders to each cell in the range
                $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
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
    
        $sheet->mergeCells('F' . ($rowIndex + 1) . ':I' . ($rowIndex + 1));

        // Printed by:
        $sheet->setCellValue('F' . ($rowIndex + 2), 'Noted by:');
        $sheet->getStyle('F' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F' . ($rowIndex + 2))->getFont()->setBold(true);
    
        // Printed by name
        $sheet->mergeCells('F' . ($rowIndex + 3) . ':I' . ($rowIndex + 3));
        $sheet->setCellValue('F' . ($rowIndex + 3), '_______________________________________');
        $sheet->getStyle('F' . ($rowIndex + 3) . ':I' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('F' . ($rowIndex + 4) . ':I' . ($rowIndex + 4));
        $sheet->setCellValue('F' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('F' . ($rowIndex + 4) . ':I' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('F' . ($rowIndex + 5) . ':I' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('F' . ($rowIndex + 6) . ':I' . ($rowIndex + 6));
        $sheet->setCellValue('F' . ($rowIndex + 6), '_______________________________________');
        $sheet->getStyle('F' . ($rowIndex + 6) . ':I' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('F' . ($rowIndex + 7) . ':I' . ($rowIndex + 7));
        $sheet->setCellValue('F' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('F' . ($rowIndex + 7) . ':I' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('F' . ($rowIndex + 8) . ':I' . ($rowIndex + 8));
        
        // Apply border around the content
        $borderRange = 'F' . ($rowIndex + 1) . ':I' . ($rowIndex + 8);
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
        $widthMx = 20.00;
        $widthLg = 40.00;
        $sheet->getColumnDimension('B')->setWidth($widthMd); // Property Number
        $sheet->getColumnDimension('C')->setWidth($widthLg); // Description
        $sheet->getColumnDimension('D')->setWidth($widthMd); // Quantity
        $sheet->getColumnDimension('E')->setWidth($widthMd); // Unit
        $sheet->getColumnDimension('F')->setWidth($widthMd); // Unit Value
        $sheet->getColumnDimension('G')->setWidth($widthMd); // Total Amount
        $sheet->getColumnDimension('H')->setWidth($widthMx); // Acquisition Date
        $sheet->getColumnDimension('I')->setWidth($widthMx); // Property Assigned to End User



        $sheet->getStyle('B')->getAlignment()->setWrapText(true); // Property Number
        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Description
        $sheet->getStyle('D')->getAlignment()->setWrapText(true); // Quantity
        $sheet->getStyle('E')->getAlignment()->setWrapText(true); // Unit
        $sheet->getStyle('F')->getAlignment()->setWrapText(true); // Unit Value
        $sheet->getStyle('G')->getAlignment()->setWrapText(true); // Total Amount
        $sheet->getStyle('H')->getAlignment()->setWrapText(true); // Acquisition Date
        $sheet->getStyle('I')->getAlignment()->setWrapText(true); // Property Assigned to End User
 
        
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
        $filename = 'Inventory-Assignment-' . $endUsername . '-' . $date_now . '.xlsx'; // Specify the file name
        
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename );
        header('Cache-Control: max-age=0');

       $writer->save('php://output');

}

?>