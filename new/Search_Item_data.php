<?php

session_start();


include_once("connectioni.php");




if ($_GET["Command"] == "pass_itno") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";


    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";



    $sql = mysqli_query($GLOBALS['dbinv'], "Select * from s_mas where STK_NO='" . $_GET['itno'] . "'") or die(mysqli_error());

    if ($row = mysqli_fetch_array($sql)) {


        $ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
        $ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPT'] . "]]></str_description>";
        $ResponseXML .= "<actual_selling><![CDATA[" . $row['COST'] . "]]></actual_selling>";
        $ResponseXML .= "<GROUP2><![CDATA[" . $row['GROUP2'] . "]]></GROUP2>";
        $ResponseXML .= "<GROUP3><![CDATA[" . $row['GROUP3'] . "]]></GROUP3>";
    }

    if ($_GET["stname"] == "isn") {
        $sql = mysqli_query($GLOBALS['dbinv'], "Select QTYINHAND from s_submas where STK_NO='" . $_GET['itno'] . "' and STO_CODE = '" .$_GET["dep"]. "' and QTYINHAND > 0") or die(mysqli_error());

        if ($row = mysqli_fetch_array($sql)) {
            $ResponseXML .= "<QTYINHAND><![CDATA[" . $row['QTYINHAND'] . "]]></QTYINHAND>";
        }else{
            $ResponseXML .= "<QTYINHAND><![CDATA[0]]></QTYINHAND>";
        }
    }
    
    $ResponseXML .= "<stname><![CDATA[".$_GET["stname"]."]]></stname>";




    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_itno_dsr_itm") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    if($_SESSION["ming_req_ref"] != ""){
        $sql = mysqli_query($GLOBALS['dbinv'],"Select * from s_trn where REFNO='" . $_SESSION["ming_req_ref"] . "' and STK_NO='" . $_GET['itno'] . "'") or die(mysqli_error());
    }else{
        $sql = mysqli_query($GLOBALS['dbinv'],"Select STK_NO, DESCRIPT as DESCRIPt from s_mas where STK_NO='" . $_GET['itno'] . "'") or die(mysqli_error());
    }
    
    if ($row = mysqli_fetch_array($sql)) {

        $ResponseXML .= "<str_code><![CDATA[" . $row['STK_NO'] . "]]></str_code>";
        $ResponseXML .= "<str_description><![CDATA[" . $row['DESCRIPt'] . "]]></str_description>";
        $ResponseXML .= "<qtyinhand><![CDATA[".$row['QTY']."]]></qtyinhand>";
    } 
    $ResponseXML .= "<stname><![CDATA[".$_GET["stname"]."]]></stname>";



    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}
?>
