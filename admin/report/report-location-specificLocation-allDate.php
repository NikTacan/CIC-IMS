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

// Content object
$imagePath = '../../assets/images/' . $customize['logo_file'] . ''; // Update with the path to your image file
$address = $customize['address']; // Update with the address

$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
$sheet = $spreadsheet->getActiveSheet();

if (isset($_POST['report-location-specificLocation-allDate'])) {
    $location = $_POST['location'];
    $session_name = $_POST['session_name']; // Session name

    $locationDetail = $model->getLocationDetailsByID($location);
    $locationName = $locationDetail['location_name'];

    $locations = $model->getInventorySpecificLocationAllDateReport($location);

	$date_now = date("Y-m-d");

    // Logo
    $sheet->mergeCells('B1:K3'); 
    $cellWidth = $sheet->getColumnDimension('F')->getWidth();
    $logoWidth = 100; // Width of the logo
    $startX = $cellWidth - $logoWidth; // Starting X coordinate

    $drawing->setName('Logo');
    $drawing->setDescription('Logo');
    $drawing->setPath($imagePath);
    $drawing->setCoordinates('G1'); // Change coordinates to E1
    $drawing->setOffsetX($startX);; // Change coordinates to E1
    
    // Resize the logo
    $drawing->setWidth(100); // Adjust width as needed
    $drawing->setHeight(50); // Adjust height as needed
    
    $drawing->setWorksheet($sheet);
    $sheet->getStyle('B1:K3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // (College of Information and Computing)
    $sheet->mergeCells('B4:K4'); 
    $sheet->setCellValue('B4', 'College of Information and Computing');
    $sheet->getStyle('B4:K4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B4')->getFont()->setSize(10);

    // (Address)
    $sheet->mergeCells('B5:K5'); 
    $sheet->setCellValue('B5', $address);
    $sheet->getStyle('B5:K5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B5')->getFont()->setSize(10);

    $sheet->mergeCells('B6:K6'); 
    $sheet->mergeCells('B7:K7'); 

    
    // Inventory Report
    $sheet->mergeCells('B8:K8'); 
    $sheet->setCellValue('B8', 'LOCATION REPORT');
    $sheet->getStyle('B8:K8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('B8')->getFont()->setSize(14);
    $sheet->getStyle('B8')->getFont()->setBold(true);

     // End User Name
     $sheet->mergeCells('B9:K9');
     $sheet->setCellValue('B9', '______' . $locationName . '_____');
     $sheet->getStyle('B9:K9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
     $sheet->getStyle('B9')->getFont()->setUnderline(true);

     // (As of)
    $sheet->mergeCells('B10:K10'); 
    $sheet->setCellValue('B10', 'As of ' . date('F d, Y', strtotime($date_now)));
    $sheet->getStyle('B10:K10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('B12', 'PROPERTY NUMBER');
    $sheet->setCellValue('C12', 'ARTICLE');
    $sheet->setCellValue('D12', 'DESCRIPTION');
    $sheet->setCellValue('E12', 'CATEGORY');
    $sheet->setCellValue('F12', 'QTY PER PROPERTY CARD');
    $sheet->setCellValue('G12', 'QTY PER PHYSICAL COUNT');
    $sheet->setCellValue('H12', 'UNIT OF MEASUREMENT');
    $sheet->setCellValue('I12', 'UNIT VALUE');
    $sheet->setCellValue('J12', 'REMARKS');
    $sheet->setCellValue('K12', 'PROPERTY ACQUISITION DATE');

    $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
    foreach ($columns as $column) {
        $sheet->getStyle($column.'12')->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle($column.'12')->getFont()->setBold(true);
    }

    $borderRange = 'B12:K12';
    $sheet->getStyle($borderRange)->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ]);


    if (!empty($locations)) {
        $rowIndex = 13; // Start from the 10 row
        
        foreach ($locations as $items) {
            // Insert data into spreadsheet cells
            $sheet->setCellValue('B' . $rowIndex, $items['property_no']);
            $sheet->setCellValue('C' . $rowIndex, $items['article_name']);
            $sheet->setCellValue('D' . $rowIndex, $items['description']);
            $sheet->setCellValue('E' . $rowIndex, $items['category_name']);
            $sheet->setCellValue('F' . $rowIndex, $items['qty_pcard']);
            $sheet->setCellValue('G' . $rowIndex, $items['qty_pcount']);
            $sheet->setCellValue('H' . $rowIndex, $items['unit_name']);
            $sheet->setCellValue('I' . $rowIndex, $items['unit_cost']);
            $sheet->setCellValue('J' . $rowIndex, $items['remark_name']);
            $sheet->setCellValue('K' . $rowIndex, date('M. d, Y', strtotime($items['acquisition_date'])));          

            $sheet->getStyle('B' . $rowIndex . ':K' . $rowIndex)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            
            // Apply borders to each cell in the range
            $columns = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
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

    if (!empty($locations)) {

        // Add content below "Printed by:"
        $rowIndex--; // Increment rowIndex to move to the next row

        $sheet->mergeCells('B' . ($rowIndex + 1) . ':F' . ($rowIndex + 1));

        // Printed by:
        $sheet->setCellValue('B' . ($rowIndex + 2), 'Printed by:');
        $sheet->getStyle('B' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . ($rowIndex + 2))->getFont()->setBold(true);
       
        // Printed by name
        $sheet->mergeCells('B' . ($rowIndex + 3) . ':F' . ($rowIndex + 3));
        $sheet->setCellValue('B' . ($rowIndex + 3), '_______________'. $session_name .'________________');
        $sheet->getStyle('B' . ($rowIndex + 3) . ':F' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('B' . ($rowIndex + 4) . ':F' . ($rowIndex + 4));
        $sheet->setCellValue('B' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('B' . ($rowIndex + 4) . ':F' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('B' . ($rowIndex + 5) . ':F' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('B' . ($rowIndex + 6) . ':F' . ($rowIndex + 6));
        $sheet->setCellValue('B' . ($rowIndex + 6), '_______________'. date('F d, Y', strtotime($date_now)) .'________________');
        $sheet->getStyle('B' . ($rowIndex + 6) . ':F' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('B' . ($rowIndex + 7) . ':F' . ($rowIndex + 7));
        $sheet->setCellValue('B' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('B' . ($rowIndex + 7) . ':F' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('B' . ($rowIndex + 8) . ':F' . ($rowIndex + 8));
        
        // Apply border around the content
        $borderRange = 'B' . ($rowIndex + 1) . ':F' . ($rowIndex + 8);
        $sheet->getStyle($borderRange)->applyFromArray([
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    
        $sheet->mergeCells('G' . ($rowIndex + 1) . ':K' . ($rowIndex + 1));

        // Noted by:
        $sheet->setCellValue('G' . ($rowIndex + 2), 'Noted by:');
        $sheet->getStyle('G' . ($rowIndex + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G' . ($rowIndex + 2))->getFont()->setBold(true);
    
        // Noted by name
        $sheet->mergeCells('G' . ($rowIndex + 3) . ':K' . ($rowIndex + 3));
        $sheet->setCellValue('G' . ($rowIndex + 3), '_______________________________________');
        $sheet->getStyle('G' . ($rowIndex + 3) . ':K' . ($rowIndex + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G' . ($rowIndex + 3))->getFont()->setUnderline(true);

        // Signature over printed name
        $sheet->mergeCells('G' . ($rowIndex + 4) . ':K' . ($rowIndex + 4));
        $sheet->setCellValue('G' . ($rowIndex + 4), 'Signature over Printed Name');
        $sheet->getStyle('G' . ($rowIndex + 4) . ':K' . ($rowIndex + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        $sheet->mergeCells('G' . ($rowIndex + 5) . ':K' . ($rowIndex + 5));

        // Date printed
        $sheet->mergeCells('G' . ($rowIndex + 6) . ':K' . ($rowIndex + 6));
        $sheet->setCellValue('G' . ($rowIndex + 6), '_______________________________________');
        $sheet->getStyle('G' . ($rowIndex + 6) . ':K' . ($rowIndex + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G' . ($rowIndex + 6))->getFont()->setUnderline(true);

        // Date
        $sheet->mergeCells('G' . ($rowIndex + 7) . ':K' . ($rowIndex + 7));
        $sheet->setCellValue('G' . ($rowIndex + 7), 'Date');
        $sheet->getStyle('G' . ($rowIndex + 7) . ':K' . ($rowIndex + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('G' . ($rowIndex + 8) . ':K' . ($rowIndex + 8));
        
        // Apply border around the content
        $borderRange = 'G' . ($rowIndex + 1) . ':K' . ($rowIndex + 8);
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
    $sheet->getColumnDimension('C')->setWidth($widthMd); // Article
    $sheet->getColumnDimension('D')->setWidth($widthLg); // Description
    $sheet->getColumnDimension('E')->setWidth($widthMd); // Category
    $sheet->getColumnDimension('F')->setWidth($widthMd); // Qty per Property Card
    $sheet->getColumnDimension('G')->setWidth($widthMd); // Qty per Physical Count
    $sheet->getColumnDimension('H')->setWidth($widthMd); // Unit of Measurement
    $sheet->getColumnDimension('I')->setWidth($widthMd); // Unit Value
    $sheet->getColumnDimension('J')->setWidth($widthMd); // Remarks
    $sheet->getColumnDimension('K')->setWidth($widthMx); // Acquisition Date

    $sheet->getStyle('B')->getAlignment()->setWrapText(true); // Property Number
    $sheet->getStyle('C')->getAlignment()->setWrapText(true); // Article
    $sheet->getStyle('D')->getAlignment()->setWrapText(true); // Description
    $sheet->getStyle('E')->getAlignment()->setWrapText(true); // Category
    $sheet->getStyle('F')->getAlignment()->setWrapText(true); // Remarks
    $sheet->getStyle('G')->getAlignment()->setWrapText(true); // Qty per Propert Count
    $sheet->getStyle('H')->getAlignment()->setWrapText(true); // Qty per Physical Count 
    $sheet->getStyle('I')->getAlignment()->setWrapText(true); // Unit of Measurement
    $sheet->getStyle('J')->getAlignment()->setWrapText(true); // Unit Value
    $sheet->getStyle('K')->getAlignment()->setWrapText(true); // Acquisition Date

    
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
    $filename = 'Location-Report-' . $locationName . '-' . $date_now . '.xlsx'; // Specify the file name
    
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename );
    header('Cache-Control: max-age=0');

    $writer->save('php://output');

}
?>