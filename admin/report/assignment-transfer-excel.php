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

if (isset($_POST['assignment-transfer-excel'])) {
    $transfer_id = $_POST['transfer_id'];
    $session_name = $_POST['session_name']; // Session name

    $assignment_details = $model->getAssignmentTransferDetailById($transfer_id);
    $assignment_items = $model->getTransferItemsById($transfer_id);

    $newEndUser = $assignment_details['new_username'];
    $oldEndUser = $assignment_details['old_username'];

	$date_now = date("Y-m-d H:i:s");

    // Logo
    $sheet->mergeCells('A1:G3'); 
    $cellWidth = $sheet->getColumnDimension('G')->getWidth();
    $logoWidth = 23; // Width of the logo
    $startX = $cellWidth - $logoWidth; // Starting X coordinate

    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath($imagePath);
    $drawing->setCoordinates('D1'); // Change coordinates to E1
    $drawing->setOffsetX($startX);; // Change coordinates to E1
    
    // Resize the logo
    $drawing->setWidth(100); // Adjust width as needed
    $drawing->setHeight(50); // Adjust height as needed
    
    $drawing->setWorksheet($sheet);
    $sheet->getStyle('A1:G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // (College of Information and Computing)
    $sheet->mergeCells('A4:G4'); 
    $sheet->setCellValue('A4', 'College of Information and Computing');
    $sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A4')->getFont()->setSize(10);

    // (Address)
    $sheet->mergeCells('A5:G5'); 
    $sheet->setCellValue('A5', $address);
    $sheet->getStyle('A5:G5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A5')->getFont()->setSize(10);

    $sheet->mergeCells('A6:G6'); 
    $sheet->mergeCells('A7:G7'); 

    // Property Acknowledgement Receipt
    $sheet->mergeCells('A8:G8'); 
    $sheet->setCellValue('A8', 'PROPERTY ACKNOWLEDGEMENT RECEIPT');
    $sheet->getStyle('A8:G8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A8')->getFont()->setSize(14);
    $sheet->getStyle('A8')->getFont()->setBold(true);

    $sheet->mergeCells('A11:C11');
    $sheet->setCellValue('A11', 'New Accountable End User : ' . $newEndUser);
    $sheet->getStyle('A11:C11')->getFont()->setBold(true);

    $sheet->mergeCells('A12:C12');
    $sheet->setCellValue('A12', 'Old Accountable End User : ' . $oldEndUser);
    $sheet->getStyle('A12:C12')->getFont()->setBold(true);

    $sheet->mergeCells('F12:G12');
    $sheet->setCellValue('F12', 'Assumption Date : ' . date('M d, Y', strtotime($assignment_details['date_transferred'])));
    $sheet->getStyle('F12')->getFont()->setBold(true);

    $sheet->setCellValue('A13', 'PROPERTY NUMBER');
    $sheet->setCellValue('B13', 'DESCRIPTION');
    $sheet->setCellValue('C13', 'UNIT');
    $sheet->setCellValue('D13', 'QUANTITY');
    $sheet->setCellValue('E13', 'UNIT VALUE');
    $sheet->setCellValue('F13', 'TOTAL AMOUNT');
    $sheet->setCellValue('G13', 'ACQUISITION DATE');

    $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
    foreach ($columns as $column) {
        $sheet->getStyle($column.'13')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle($column.'13')->getFont()->setBold(true);
    }

    $borderRange = 'A13:G13';
    $sheet->getStyle($borderRange)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ]);


    if (!empty($assignment_items)) {
        $rowIndex = 14; // Start from the 10 row
        
        foreach ($assignment_items as $items) {
            // Insert data into spreadsheet cells
            $sheet->setCellValue('A' . $rowIndex, $items['property_no']);
            $sheet->setCellValue('B' . $rowIndex, $items['description']);
            $sheet->setCellValue('C' . $rowIndex, $items['unit']);
            $sheet->setCellValue('D' . $rowIndex, $items['qty']);
            $sheet->setCellValue('E' . $rowIndex, $items['unit_cost']);
            $sheet->setCellValue('F' . $rowIndex, $items['total_cost']);
            $sheet->setCellValue('G' . $rowIndex, date('F. d, Y', strtotime($items['acquisition_date'])));
          

            $sheet->getStyle('A' . $rowIndex . ':G' . $rowIndex)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            // Apply borders to each cell in the range
            $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
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

    if (!empty($assignment_items)) {

        // Add content below "Printed by:"
        $rowIndex--; // Increment rowIndex to move to the next row

        $sheet->mergeCells('A' . ($rowIndex + 1) . ':C' . ($rowIndex + 1));

        // Printed by:
        $sheet->setCellValue('A' . ($rowIndex + 2), 'Printed by:');
        $sheet->getStyle('A' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . ($rowIndex + 2))->getFont()->setBold(true);
       
        // Printed by name
        $sheet->mergeCells('A' . ($rowIndex + 3) . ':C' . ($rowIndex + 3));
        $sheet->setCellValue('A' . ($rowIndex + 3), '_______________'. $session_name .'________________');
        $sheet->getStyle('A' . ($rowIndex + 3) . ':C' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('A' . ($rowIndex + 4) . ':C' . ($rowIndex + 4));
        $sheet->setCellValue('A' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('A' . ($rowIndex + 4) . ':C' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('A' . ($rowIndex + 5) . ':C' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('A' . ($rowIndex + 6) . ':C' . ($rowIndex + 6));
        $sheet->setCellValue('A' . ($rowIndex + 6), '_______________'. date('F d, Y', strtotime($date_now)) .'________________');
        $sheet->getStyle('A' . ($rowIndex + 6) . ':C' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('A' . ($rowIndex + 7) . ':C' . ($rowIndex + 7));
        $sheet->setCellValue('A' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('A' . ($rowIndex + 7) . ':C' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('A' . ($rowIndex + 8) . ':C' . ($rowIndex + 8));

        // Apply border around the content
        $borderRange = 'A' . ($rowIndex + 1) . ':C' . ($rowIndex + 8);
        $sheet->getStyle($borderRange)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    
        $sheet->mergeCells('D' . ($rowIndex + 1) . ':G' . ($rowIndex + 1));

        // Printed by:
        $sheet->setCellValue('D' . ($rowIndex + 2), 'Noted by:');
        $sheet->getStyle('D' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . ($rowIndex + 2))->getFont()->setBold(true);
    
        // Printed by name
        $sheet->mergeCells('D' . ($rowIndex + 3) . ':G' . ($rowIndex + 3));
        $sheet->setCellValue('D' . ($rowIndex + 3), '_______________________________________');
        $sheet->getStyle('D' . ($rowIndex + 3) . ':G' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('D' . ($rowIndex + 4) . ':G' . ($rowIndex + 4));
        $sheet->setCellValue('D' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('D' . ($rowIndex + 4) . ':G' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('D' . ($rowIndex + 5) . ':G' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('D' . ($rowIndex + 6) . ':G' . ($rowIndex + 6));
        $sheet->setCellValue('D' . ($rowIndex + 6), '_______________________________________');
        $sheet->getStyle('D' . ($rowIndex + 6) . ':G' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('D' . ($rowIndex + 7) . ':G' . ($rowIndex + 7));
        $sheet->setCellValue('D' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('D' . ($rowIndex + 7) . ':G' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('D' . ($rowIndex + 8) . ':G' . ($rowIndex + 8));
        
        // Apply border around the content
        $borderRange = 'D' . ($rowIndex + 1) . ':G' . ($rowIndex + 8);
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
        $sheet->getColumnDimension('A')->setWidth($widthMd); // Property Number
        $sheet->getColumnDimension('B')->setWidth($widthLg); // Description
        $sheet->getColumnDimension('C')->setWidth($widthSm); // Unit
        $sheet->getColumnDimension('D')->setWidth($widthMd); // Quantity
        $sheet->getColumnDimension('E')->setWidth($widthMd); // Unit Value
        $sheet->getColumnDimension('F')->setWidth($widthMd); // Total Amount
        $sheet->getColumnDimension('G')->setWidth($widthMd); // Acquisition Date



        $sheet->getStyle('A')->getAlignment()->setWrapText(true); // Property Number
        $sheet->getStyle('B')->getAlignment()->setWrapText(true); // Description
        $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Unit
        $sheet->getStyle('D')->getAlignment()->setWrapText(true); // Quantity
        $sheet->getStyle('E')->getAlignment()->setWrapText(true); // Unit Value
        $sheet->getStyle('F')->getAlignment()->setWrapText(true); // Total Amount
        $sheet->getStyle('G')->getAlignment()->setWrapText(true); // Acquisition Date
 
        
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
        $filename = 'Report-Property-Acknowledgement-Receipt-' . $newEndUser . '.xlsx'; // Specify the file name
       
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. $filename );
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');

}

?>