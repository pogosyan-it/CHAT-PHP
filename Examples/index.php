<h1>Test Driving MySqlExcelBuilder</h1>
<? 
require_once('MySqlExcelBuilder.class.php');

// Intialize the object with the database variables
$database = 'xls_sample';
$user='yourdbusername';
$pwd='yourdbpassword';
$mysql_xls = new MySqlExcelBuilder($database,$user,$pwd);

// Setup the SQL Statements
$sql_statement = <<<END_OF_SQL

SELECT `name` AS `Customer Name`,
        `email_address` AS `Email Address`,
        CONCAT( right(`phone_number`,3) , '-' , mid(`phone_number`,4,3) , '-', right(`phone_number`,4)) AS `Phone Number`,
        `item_sku` AS `Part Number`,
        `item_name` AS `Item Name`,
         `price` AS `Price`,
        `order_date` as `Order Date`        
 FROM `order`,`customer`,`order_item` 
 WHERE `customer_id` = `customer`.`id`
         AND item_id = `order_item`.`id`
         AND `item_sku` = 'GMG1'

END_OF_SQL;

$sql_statement2 = <<<END_OF_SQL2

SELECT `name` AS `Customer Name`,
        `email_address` AS `Email Address`,
        CONCAT( right(`phone_number`,3) , '-' , mid(`phone_number`,4,3) , '-', right(`phone_number`,4)) AS `Phone Number`,
        `item_sku` AS `Part Number`,
        `item_name` AS `Item Name`,
         `price` AS `Price`,
        `order_date` as `Order Date`        
 FROM `order`,`customer`,`order_item` 
 WHERE `customer_id` = `customer`.`id`
         AND item_id = `order_item`.`id`
         AND `item_sku` = 'TEGH'

END_OF_SQL2;



// Add the SQL statements to the spread sheet
$mysql_xls->add_page('Gold Mugs',$sql_statement,'Price','B',2);
$mysql_xls->add_page('Tea',$sql_statement2,'Price','B',2);

// Get the spreadsheet after the SQL statements are built...
$phpExcel = $mysql_xls->getExcel(); // This needs to come after all the pages have been added.

$phpExcel->setActiveSheetIndex(0); // Set the sheet to the first page.
// Do some addtional formatting using PHPExcel
$sheet = $phpExcel->getActiveSheet();
$date = date('Y-m-d');
$cellKey = "A1"; 
$sheet->setCellValue($cellKey,"Gold Mugs Sold as Of $date");
$style = $sheet->getStyle($cellKey);                              
$style->getFont()->setBold(true);

$phpExcel->setActiveSheetIndex(1); // Set the sheet to the second page.
$sheet = $phpExcel->getActiveSheet(); 
$sheet->setCellValue($cellKey,"Tea Sold as Of $date");
$style = $sheet->getStyle($cellKey);                              
$style->getFont()->setBold(true);

$phpExcel->setActiveSheetIndex(0); // Set the sheet back to the first page.

// Write the spreadsheet file...
$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5'); // 'Excel5' is the oldest format and can be read by old programs.
$fname = "TestFile.xls";
$objWriter->save($fname);

// Make it available for download.
echo "<a href=\"$fname\">Download $fname</a>";


?>