<?php

$html = "<!DOCTYPE html>
    <head>
        <meta charset='utf-8' />
        <title>Print Order</title>
        <style>
            .spn {
                border-top: 1px solid !important; 

            }
            .box {
                border : 1px solid !important;
            }
        </style>
        <style>


            .bottom  {
                border-bottom: 1px solid #000000;
            }
            .table1 {
                border-collapse: collapse;
            }
            .table1, td, th {

                font-family: Arial, Helvetica, sans-serif;
                padding: 5px;
            }
            .table1 th {
                font-weight: bold;
                font-size: 12px;
            }
            .table1 td {
                font-size: 12px;
                border-bottom: none;
                border-top: none;
            }

            .head {
                font-size: 15px !important;
            }

            p {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }    
        </style>
    </head>";


include './connection_sql.php';
$sql = "Select * from s_ginmas where tmp_no='" . $_GET['tmp_no'] . "'";
$result = $conn->query($sql);

if (!$row = $result->fetch()) {
    exit();
}

$sql = "Select * from COMPANY_INFO";
$result1 = $conn->query($sql);

if (!$row1 = $result1->fetch()) {
    exit();
}


$html .="<body> 
        

        <table   style='width: 660px;' class='table1'>



            <tr>
                <th class='bottom head' rowspan='2'><img src='images/logo.JPG'></th>
                
            </tr>


             <tr>
                <th colspan='3' class='bottom head'><center>FG Transfer Note</th>
             </tr>

            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>

            </tr>


            <tr>
                <td style='width: 120px;'>Company</td>
                <td colspan='3'>" . $row1['COMPANY'] . "</td> 
            </tr>

            <tr>
                <td>Address</td>
                <td colspan='3'>" . $row1['ADD1'] . " " . $row1['ADD2'] . "</td> 
            </tr>";



//$html .= "</tr>
//            <tr>
//                <td></td>   
//                <td>Fax :" . $row1['FAX'] . "</td>";


    $html .="<th></th>
                    <th></th>";

$html .="</tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Reference #</td>
                <td>".$row['REF_NO']."</td>
            </tr>
            <tr>
                <td>Job #</td>
                <td>".$row['JOB_NO']."</td>
            </tr>
            <tr>
                <td>Remark</td>
                <td>".$row['remark']."</td>
            </tr>
        </table>
        <br/><br/>
        <table border=1 style='width: 660px;' class='table1'>
            <tr>
                <th style='width: 50px;'>No</th>
                <th style='width: 400px;'>Description</th>
                <th style='width: 110px;'>Qty</th>
            </tr>";


$i = 1;
//$mnet = 0;
$sql = "Select * from s_trn where REFNO='" . $row["REF_NO"] . "' and LEDINDI = 'FGR'";
foreach ($conn->query($sql) as $row1) {
//    $subtotal = $row1['ORD_QTY'] * $row1['RATE'];
//    $mnet = $mnet + $subtotal;

    $html .="<tr>                              
                    <td>" . $i . "</td>
                    <td>" . $row1['DESCRIPt'] . "</td>
                    <td align='right'>" . number_format($row1['QTY'], 2, ".", ",") . "</td>
                </tr>";

    $i = $i + 1;
}


$html .="</table>
        <br/><br/>
        <table style='width: 660px;' class='table1'>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td class='spn'>Authorized Signature</td>
                <td align='right'>Date of FG Transfer Note</td>
                <td align='center' class='box'>" . $row['SDATE'] . "</td>
            </tr>
        </table>
        <br/><br/>
    </body>
</html>";


////
// include autoloader
require_once 'dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();



$dompdf->loadHtml($html);


// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$pdf = $dompdf->output();
$pdf_name ="drre";

$file_location = $_SERVER['DOCUMENT_ROOT']."/wings_test/pdfReports/".$pdf_name.".pdf";
file_put_contents($file_location,$pdf);


echo $html;
