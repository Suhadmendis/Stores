<?php

session_start();



include_once './connection_sql.php';

if ($_GET["Command"] == "pass_quot") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_salma where con_ref='" . $cuscode . "'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {

        $ResponseXML .= "<str_type><![CDATA[" . $row['C_CODE'] . "]]></str_type>";
        $ResponseXML .= "<str_type_name><![CDATA[" . $row['CUS_NAME'] . "]]></str_type_name>";
        $ResponseXML .= "<str_type1><![CDATA[" . $row['con_ref'] . "]]></str_type1>";
        $ResponseXML .= "<str_type2><![CDATA[" . $row['con_date'] . "]]></str_type2>";
    }
    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
						<td style=\"width: 90px;\">REF No</td>
                                                <td style=\"width: 90px;\">C CODE</td>
						<td style=\"width: 90px;\">VAT</td>
                                                <td style=\"width: 90px;\">SVAT</td>
                                                <td style=\"width: 90px;\">NBT</td>
                                                <td style=\"width: 100px;\">Grand Total</td>
						<td style=\"width: 10px;\"></td>
					</tr>";
    $subtot = 0;
    $sql = "Select * from s_salma where con_ref='" . $row['con_ref'] . "'";
    foreach ($conn->query($sql) as $row) {
        if($row["con_vat"] == '1'){
           $vatAmt = $row['VAT_VAL']; 
        }else{
            $vatAmt = 0;
        }
        $ResponseXML .= "<tr>
            <td>" . $row['REF_NO'] . "</td>
            <td>" . $row['C_CODE'] . "</td>
            <td>" . $vatAmt . "</td>
            <td>" . $row['SVAT'] . "</td>
            <td>" . $row['BTT'] . "</td>
            <td>" . $row['GRAND_TOT'] . "</td></tr>";
        $subtot = $row['GRAND_TOT'] + $subtot;
    }



    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<tot><![CDATA[" . $subtot . "]]></tot>";
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                <tr>
                    <th>REF_NO</th>
                    <th>C_CODE</th>
                    <th>CON_REF</th>
                </tr>";

    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,C_CODE,con_ref from s_salma where  REF_NO like '%$letters%' and TOTPAY='0' and CANCELL='0'";
//        echo $sql;
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,C_CODE,con_ref from s_salma where  C_CODE like %$letters%' ";
    } else {

        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,C_CODE,con_ref from s_salma where  con_ref like '%$letters%'";
    }
    $sql .= " ORDER BY con_ref  limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['C_CODE'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                               <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['C_CODE'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['con_ref'] . "</a></td>
                             
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
