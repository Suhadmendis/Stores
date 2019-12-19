<?php

/** Include path * */
set_include_path(get_include_path() . PATH_SEPARATOR . 'PHPExcel/Classes/');
include 'PHPExcel/IOFactory.php';

include_once("connection_sql.php");

header('Content-Type: text/xml');


$columns = array("A", "Z");

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["file-3"]["name"]);
// unlink($target_file);
if (move_uploaded_file($_FILES["file-3"]["tmp_name"], $target_file)) {
    
}

$objPHPExcel = PHPExcel_IOFactory::load($target_file);
$objPHPExcel->setActiveSheetIndexByName("Sheet1");
$worksheet = $objPHPExcel->getActiveSheet();

$ResponseXML = "";
$ResponseXML .= "<salesdetails>";
$sql = "select * from costing_allocation";
foreach ($conn->query($sql) as $row) {

    $cellCus = $worksheet->getCell($row['customer'])->getValue();
    $cell1 = $worksheet->getCell($row['product_one'])->getValue();
    $cell2 = $worksheet->getCell($row['length'])->getValue();
    $cell3 = $worksheet->getCell($row['req_qty'])->getValue();
    $cell4 = $worksheet->getCell($row['waste'])->getValue();
    $cell5 = $worksheet->getCell($row['color'])->getValue();
    $cell6 = $worksheet->getCell($row['no_of_outs'])->getValue();

    $cell7 = $worksheet->getCell($row['no_of_impre'])->getCalculatedValue();
    $cell8 = $worksheet->getCell($row['foh_margin'])->getCalculatedValue();
    $cell9 = $worksheet->getCell($row['sales_margin'])->getCalculatedValue();
    $cell10 = $worksheet->getCell($row['commision_per_unit'])->getCalculatedValue();
    $cell11 = $worksheet->getCell($row['width'])->getValue();

    $cell12 = $worksheet->getCell($row['no_of_ups'])->getValue();
    $cellDesc = $worksheet->getCell($row['description'])->getValue();
    
    $totalCost = $worksheet->getCell("J140")->getCalculatedValue();
    $rawCost = $worksheet->getCell("J82")->getCalculatedValue();
    $rawWaste = $worksheet->getCell("L81")->getCalculatedValue();
    if($rawWaste == ""){
        $rawWaste = 0;
    } 
    $sellingPrice = $worksheet->getCell("J142")->getCalculatedValue();
    $sellingPrice = number_format($sellingPrice, 0, ".", "");
    
    $jobCost = $totalCost - $rawCost;
}

$msg = "<div class='col-sm-12'>
<table class='table table-striped'>
<tr class='success'>
        <th style='width: 120px;'>Item Description</th>
        <th style='width: 10px;'>Item Code</th>
        <th style='width: 10px;'>Qty</th>
        <th style='width: 10px;'>Cost</th>
        <th style='width: 10px;'>WAC</th>
        <th style='width: 10px;'>Job Total Unit</th>
</tr>";
$subCell = "";
for ($index = 20; $index < (20+61); $index++) {
    $i = "A" . $index;
    $subCell = $worksheet->getCell($i)->getValue();
    if ($subCell == "i") {
        $i = "L" . $index;
        $subCellCost = $worksheet->getCell($i)->getCalculatedValue();
        $i = "J" . $index;
        $subCell1 = $worksheet->getCell($i)->getValue();
        $subCell1 = trim($subCell1);
        $i = "K" . $index;
        $subCell2 = $worksheet->getCell($i)->getCalculatedValue();
        
        $sql = "select acc_cost, DESCRIPT, STK_NO from s_mas where STK_NO = '" .$subCell1. "'";
        $rowItem = $conn -> query($sql) -> fetch();
        
        //user defined cost to be saved $subCellCost
        $bulkInsert[] = "('" . $rowItem["DESCRIPT"] . "','" . $subCell1 . "','" . $subCell2 . "','" . $_POST["refno"] . "','i', $subCellCost)";
//		$bulkInsert1 .= "('" . $rowItem["DESCRIPT"] . "','" . $subCell1 . "','" . $subCell2 . "','" . $_POST["refno"] . "','i', $subCellCost)";
		
    
        $msg .= "<tr>";
        $msg .= "<td style = 'width: 120px;text-align: left;'>" . $rowItem["DESCRIPT"] . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . $subCell1 . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2, 2, ".", ",") . "</td>";
        
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCellCost, 2, ".", ",") . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($rowItem["acc_cost"], 2, ".", ",") . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2*$cell3, 2, ".", ",") . "</td>";
        $msg .= "</tr>";
    }
}

//exit($bulkInsert1);

$msg .= "<tr class='success'>
        <th style='width: 120px;'>Direct Labour</th>
        <th style='width: 10px;'>Code</th>
        <th style='width: 10px;'>Value</th>
        <th style='width: 10px;'>Hours</th>
        <th style='width: 10px;'>Labour Value</th>
        <th style='width: 10px;'>Job Labour Hours</th>
        </tr>";
$subCell = "";
for ($index = 85; $index < (85+12); $index++) {
    $i = "A" . $index;
    $subCell = $worksheet->getCell($i)->getValue();
    if ($subCell == "d") {
        $i = "B" . $index;
        $subCell = $worksheet->getCell($i)->getValue();
        $i = "J" . $index;
        $subCell1 = $worksheet->getCell($i)->getValue();
        $subCell1 = trim($subCell1);
        $i = "I" . $index;
        $subCell2 = $worksheet->getCell($i)->getCalculatedValue();
        
        $i = "L" . $index;
        $subCellHours = $worksheet->getCell($i)->getValue();
        if($subCellHours == ""){
            $subCellHours = 0;
        }
        
        //hours to be saved
        $bulkInsert[] = "('" . $subCell . "','" . $subCell1 . "','" . $subCell2 . "','" . $_POST["refno"] . "','d', $subCellHours)";
    
        $msg .= "<tr>";
        $msg .= "<td style = 'width: 120px;text-align: left;'>" . $subCell . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . $subCell1 . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2, 2, ".", ",") . "</td>";
        
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . $subCellHours . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2*$cell3, 2, ".", ",") . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCellHours*$cell3, 2, ".", ",") . "</td>";
        $msg .= "</tr>";
    }
}


$msg .= "<tr class='success'>
        <th style='width: 120px;'>Variable Overhead</th>
        <th style='width: 10px;'>Code</th>
        <th style='width: 10px;'>Value</th>
        <th style='width: 10px;'>Job Cost</th>
        <th style='width: 10px;'>&nbsp;</th>
        <th style='width: 10px;'>&nbsp;</th>        
        </tr>";

$subCell = "";
for ($index = 101; $index < (101+25); $index++) {
    $i = "A" . $index;
    $subCell = $worksheet->getCell($i)->getValue();
    if ($subCell == "v") {
        $i = "B" . $index;
        $subCell = $worksheet->getCell($i)->getValue();
        $i = "J" . $index;
        $subCell1 = $worksheet->getCell($i)->getValue();
        $subCell1 = trim($subCell1);
        $i = "I" . $index;
        $subCell2 = $worksheet->getCell($i)->getCalculatedValue();
        $bulkInsert[] = "('" . $subCell . "','" . $subCell1 . "','" . $subCell2 . "','" . $_POST["refno"] . "','v', 0)";
    
        $msg .= "<tr>";
        $msg .= "<td style = 'width: 120px;text-align: left;'>" . $subCell . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . $subCell1 . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2, 2, ".", ",") . "</td>";
        
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2*$cell3, 2, ".", ",") . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>&nbsp;</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>&nbsp;</td>";
        $msg .= "</tr>";
    }
}


$msg .= "<tr class='success'>
        <th style='width: 120px;'>Fixed Overhead</th>
        <th style='width: 10px;'>Code</th>
        <th style='width: 10px;'>Value</th>
        <th style='width: 10px;'>Job Cost</th>
        <th style='width: 10px;'>&nbsp;</th>
        <th style='width: 10px;'>&nbsp;</th>        
        </tr>";

$subCell = "";
for ($index = 133; $index < (133+5); $index++) {
    $i = "A" . $index;
    $subCell = $worksheet->getCell($i)->getValue();
    if ($subCell == "f") {
        $i = "B" . $index;
        $subCell = $worksheet->getCell($i)->getValue();
        $i = "J" . $index;
        $subCell1 = $worksheet->getCell($i)->getValue();
        $subCell1 = trim($subCell1);
        $i = "I" . $index;
        $subCell2 = $worksheet->getCell($i)->getCalculatedValue();
        $bulkInsert[] = "('" . $subCell . "','" . $subCell1 . "','" . $subCell2 . "','" . $_POST["refno"] . "','f', 0)";
    
        $msg .= "<tr>";
        $msg .= "<td style = 'width: 120px;text-align: left;'>" . $subCell . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . $subCell1 . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2, 2, ".", ",") . "</td>";
        
        $msg .= "<td style = 'width: 10px;text-align: left;'>" . number_format($subCell2*$cell3, 2, ".", ",") . "</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>&nbsp;</td>";
        $msg .= "<td style = 'width: 10px;text-align: left;'>&nbsp;</td>";
        $msg .= "</tr>";
    }
}





$msg .= "</table></div>";

$ResponseXML .= "<itemList><![CDATA[" . $msg . "]]></itemList>";
$sql = "delete from tmp_subitem where tmpno = '" .$_POST["refno"]. "'";
$conn->exec($sql);

if (count($bulkInsert) > 0) {
    $sql = "insert into tmp_subitem (s_descrip, s_item, qty, tmpno, type, value) values " . implode(',', $bulkInsert);
//    echo $sql;
	$conn->exec($sql);
}

$sql = "select NAME from vendor where CODE = '$cellCus'";
$row = $conn -> query($sql) -> fetch();

$ResponseXML .= "<cus><![CDATA[" . $cellCus . "]]></cus>";
$ResponseXML .= "<cusName><![CDATA[" . $row["NAME"] . "]]></cusName>";
$ResponseXML .= "<product><![CDATA[" . $cell1 . "]]></product>";
$ResponseXML .= "<length><![CDATA[" . $cell2 . "]]></length>";
$ResponseXML .= "<qty><![CDATA[" . $cell3 . "]]></qty>";
$ResponseXML .= "<waste><![CDATA[" . $cell4 . "]]></waste>";
$ResponseXML .= "<color><![CDATA[" . $cell5 . "]]></color>";
$ResponseXML .= "<noofouts><![CDATA[" . $cell6 . "]]></noofouts>";
$ResponseXML .= "<noofups><![CDATA[" . $cell12 . "]]></noofups>";
$ResponseXML .= "<noofimpre><![CDATA[" . $cell7 . "]]></noofimpre>";
$ResponseXML .= "<fohmargin><![CDATA[" . $cell8 . "]]></fohmargin>";
$ResponseXML .= "<salesmargin><![CDATA[" . $cell9 . "]]></salesmargin>";
$ResponseXML .= "<commisionperunit><![CDATA[" . $cell10 . "]]></commisionperunit>";
$ResponseXML .= "<width><![CDATA[" . $cell11 . "]]></width>";

$sql = "select DESCRIPT from s_mas where STK_NO = '$cell1'";
$row = $conn -> query($sql) -> fetch();

$ResponseXML .= "<description><![CDATA[" . $row["DESCRIPT"] . "]]></description>";
$ResponseXML .= "<totalCost><![CDATA[" . $totalCost . "]]></totalCost>";
$ResponseXML .= "<rawWaste><![CDATA[" . $rawWaste . "]]></rawWaste>";
$ResponseXML .= "<jobCost><![CDATA[" . $jobCost . "]]></jobCost>";
$ResponseXML .= "<sellingPrice><![CDATA[" . $sellingPrice . "]]></sellingPrice>";

$totSqIn = $cell2*$cell11*$cell3;
$totSqFt = $totSqIn/144;

$effSqFt = $totSqFt*$cell5*(1+$cell4);

$ResponseXML .= "<totSqIn><![CDATA[" . $totSqIn . "]]></totSqIn>";
$ResponseXML .= "<totSqFt><![CDATA[" . number_format($totSqFt, 2, ".", "") . "]]></totSqFt>";
$ResponseXML .= "<effSqFt><![CDATA[" . number_format($effSqFt, 2, ".", "") . "]]></effSqFt>";

$ResponseXML .= "</salesdetails>";

echo $ResponseXML;
?>
