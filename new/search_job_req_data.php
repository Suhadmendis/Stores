<?php

session_start();



include_once './connection_sql.php';

if ($_GET["Command"] == "pass_quot") {

    $_SESSION["custno"] = $_GET['custno'];

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_jobreq where REF_NO='" . $cuscode . "' and cancel='0'";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {

        $ResponseXML .= "<refno><![CDATA[" . $row['REF_NO'] . "]]></refno>";
        $ResponseXML .= "<cusname><![CDATA[" . $row['cus_code'] . "]]></cusname>";
        $ResponseXML .= "<cuscode><![CDATA[" . $row['cus_name'] . "]]></cuscode>";
        $ResponseXML .= "<sdate><![CDATA[" . $row['SDATE'] . "]]></sdate>";
        $ResponseXML .= "<tmpno><![CDATA[" . $row['tmp_no'] . "]]></tmpno>";
    }
    $i = 1;
    $ResponseXML .= "<sales_table><![CDATA[<table class = \"table\">
					<tr>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th>Qty</th> 
					</tr>";


    $sql = "Select * from s_jobreq_trn where REFNO='" . $cuscode . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>               
                        <td>" . $row['STK_NO'] . "</td>
                        <td>" . $row['DESCRIPt'] . "</td>
                        <td>" . $row['QTY'] . "</td>
			</tr>";
        $i = $i + 1;
    }

    $ResponseXML .= "</table>]]></sales_table>";

    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "search_custom") {


    $ResponseXML = "";




    $ResponseXML .= "<table   class=\"table table-bordered\">
                <tr>
                    <th width=\"201\">Reference No</th>
                        <th width=\"201\">Customer Name</th>
                        <th width=\"201\">Date</th> 
                </tr>";

    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,cus_name,SDATE from s_jobreq where  REF_NO like '%$letters%' and cancel='0' ";
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,cus_name,SDATE from s_jobreq where  cus_name like '%$letters%' and cancel='0' ";
    } else {

        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,cus_name,SDATE from s_jobreq where  REF_NO like '%$letters%' and cancel='0' ";
    }
    $sql .= " ORDER BY REF_NO limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['itemCode'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                               <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['cus_name'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                             
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}
?>
