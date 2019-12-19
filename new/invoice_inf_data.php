<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once('./connection_sql.php');

if ($_GET["Command"] == "pass_quot") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_salma where REF_NO='" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $cuscode . "]]></id>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['CUS_NAME'] . "]]></str_customername>";
        $ResponseXML .= "<sdate><![CDATA[" . $row['SDATE'] . "]]></sdate>";
        $ResponseXML .= "<remark><![CDATA[" . $row['tp_rmk'] . "]]></remark>";
        $ResponseXML .= "<status><![CDATA[" . $row['tp_mode'] . "]]></status>";
        $ResponseXML .= "<status1><![CDATA[" . $row['tp_rmk1'] . "]]></status1>";
    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_quot_smp") {

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];

    $sql = "Select * from s_salma where REF_NO='" . $cuscode . "' ";

    $sql = $conn->query($sql);
    if ($row = $sql->fetch()) {
        $ResponseXML .= "<id><![CDATA[" . $cuscode . "]]></id>";
        $ResponseXML .= "<str_customercode><![CDATA[" . $row['C_CODE'] . "]]></str_customercode>";
        $ResponseXML .= "<str_customername><![CDATA[" . $row['CUS_NAME'] . "]]></str_customername>";
    }


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "save") {
    if ($_GET["status"] != "not"){
        $sql = "update s_salma set tp_mode = '" . $_GET["status"] . "' ,tp_rmk= '" . $_GET["rmk"] . "',tp_rmk1= '" . $_GET["rmk1"] . "' where REF_NO = '" .$_GET["c_code"]. "'";
    }else{
        $sql = "update s_salma set tp_mode = '" . $_GET["status"] . "' ,tp_rmk= '',tp_rmk1= '' where REF_NO = '" .$_GET["c_code"]. "'";
    }
    $conn->exec($sql);
    
    echo "saved!";
}

if ($_GET["Command"] == "search_custom") {
    $ResponseXML = "";
    $ResponseXML .= "<table   class=\"table table-bordered\">
                            <tr>
                    <th width=\"121\"  >Invoice No</th>
                    <th width=\"424\"  >Dealer Name</th>
                    <th width=\"300\"  >Date</th>

                </tr>";

    if ($_GET["mstatus"] == "cusno") {
        $letters = $_GET['cusno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,CUS_NAME,SDATE from s_salma where  REF_NO like '%$letters%' ";
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,CUS_NAME,SDATE from s_salma where  CUS_NAME like '%$letters%' ";
    } else {

        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $sql = "select REF_NO,CUS_NAME,SDATE from s_salma where  CUS_NAME like '%$letters%' ";
    }
    $sql .= " order by SDATE DESC limit 50";


    foreach ($conn->query($sql) as $row) {
        $cuscode = $row['REF_NO'];
        $stname = $_GET["stname"];

        $ResponseXML .= "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['CUS_NAME'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                            </tr>";
    }


    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}

?>
