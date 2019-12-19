<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////

if ($_GET["Command"] == "add_address") {
    //echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;


    /* 		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
      $result =$db->RunQuery($sql);
      if($row = mysql_fetch_array($result)){
      $ResponseXML .= "exist";



      }	else { */

    //	$ResponseXML .= "";
    //$ResponseXML .= "<ArmyDetails>";

    /* 	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
      $result1 =$db->RunQuery($sql1);
      $row1 = mysql_fetch_array($result1);
      $ResponseXML .=  $row1["int_Educational_Qulifications"]; */

    $sqlt = "Select * from customer_mast where id ='" . $_GET['customerid'] . "'";

    $resultt = $db->RunQuery($sqlt);
    if ($rowt = mysql_fetch_array($resultt)) {
        echo $rowt["str_address"];
    }
}

if ($_GET["Command"] == "search_inv") {

    $ResponseXML .= "";
    //$ResponseXML .= "<invdetails>";

    include_once("connection.php");

    $ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">GIN No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">GIN Date</font></td>
							  <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
							  <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                             
   							</tr>";

    $phrase = "";
    if($_GET["stname"] == "caj"){
        $phrase = "REF_NO LIKE 'CAJ%' AND";
    }
    
    if ($_GET["mstatus"] == "invno") {
        $letters = $_GET['invno'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        //$letters="/".$letters;
        //$a="SELECT * from s_salma where REF_NO like  '$letters%'";
        //echo $a;
        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
            $sql = mysql_query("SELECT * FROM s_crnma where $phrase company='" . $_SESSION['COMCODE'] . "' and REF_NO like  '$letters%' order by SDATE desc limit 50  ") or die(mysql_error());
//            $sql = mysql_query("SELECT * FROM s_crnma where $phrase mid(REF_NO, 5, 1)='" . $_SESSION['COMCODE'] . "'  and REF_NO like  '$letters%' order by SDATE desc limit 50  ") or die(mysql_error());
        } else {
            $sql = mysql_query("SELECT * FROM s_crnma where $phrase REF_NO like  '$letters%' order by SDATE desc limit 50  ") or die(mysql_error());
//            $sql = mysql_query("SELECT * FROM s_crnma where $phrase and REF_NO like  '$letters%' order by SDATE desc limit 50  ") or die(mysql_error());
        }
    } else if ($_GET["mstatus"] == "customername") {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
            $sql = mysql_query("SELECT * from s_salma where company='" . $_SESSION['COMCODE'] . "' and CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
        } else {
            $sql = mysql_query("SELECT * from s_salma where CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
        }
    } else {
        $letters = $_GET['customername'];
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        if (($_SESSION['COMCODE'] == "A") or ( $_SESSION['COMCODE'] == "B") or ( $_SESSION['COMCODE'] == "R")) {
            $sql = mysql_query("SELECT * from s_salma where company='" . $_SESSION['COMCODE'] . "' and CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
        } else {
            $sql = mysql_query("SELECT * from s_salma where CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
        }
    }



    while ($row = mysql_fetch_array($sql)) {
        $ResponseXML .= "<tr>               
                              <td onclick=\"grn('" . $row['REF_NO'] . "');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"grn('" . $row['REF_NO'] . "');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"grn('" . $row['REF_NO'] . "');\">" . $row['C_CODE'] . " - " . $row['CUS_NAME'] . "</a></td>
							  <td onclick=\"grn('" . $row['REF_NO'] . "');\">" . $row['INVOICENO'] . "</a></td>
                            </tr>";
    }

    $ResponseXML .= "   </table>";


    echo $ResponseXML;
}



if ($_GET["Command"] == "new_inv_grn") {


    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =$db->RunQuery($sql);
      $row = mysql_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    if ($_SESSION["dev"] == "") {
        exit("no");
    }


    $sql = "Select grn from invpara where COMCODE='" . $_SESSION['company'] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $tmpinvno = "000000" . $row["grn"];

    $lenth = strlen($tmpinvno);
    $invno = trim("GRN/ ") . $_SESSION['company'] . "/" . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "Select ARR from invpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $_SESSION["tmp_no_purret"] = "ARR/" . $row["ARR"];

    $sql = "Select grn, rno from tmpinvpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $tmpinvno = "000000" . $row["grn"];

    $lenth = strlen($tmpinvno);
    //if ($_SESSION['company']=="BEN"){
    $invnotmp = trim("GRN/ ") . substr($tmpinvno, $lenth - 6);
    //} 
    //	if ($_SESSION['company']=="THT"){
    //	$invnotmp=trim("TGRN/ ").substr($tmpinvno, $lenth-6);
    //}

    $_SESSION["tmp_invno"] = $invnotmp;

    $sql = "delete from tmp_grn_data where tmp_no='" . $_SESSION["tmp_invno"] . "'";
    $result = $db->RunQuery($sql);

    $sql = "update tmpinvpara set grn=grn+1";
    $result = $db->RunQuery($sql);

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<rno><![CDATA[" . $row["rno"] . "]]></rno>";
    $ResponseXML .= "<cdate><![CDATA[" . date("Y-m-d") . "]]></cdate>";
    $ResponseXML .= "</salesdetails>";

    $_SESSION["custno"] = "";

    echo $ResponseXML;
}

if ($_GET["Command"] == "new_inv_caj") {


    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =$db->RunQuery($sql);
      $row = mysql_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

    if ($_SESSION["dev"] == "") {
        exit("no");
    }


    $sql = "Select caj from invpara where COMCODE='" . $_SESSION['company'] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $tmpinvno = "000000" . $row["caj"];

    $lenth = strlen($tmpinvno);
    $invno = trim("CAJ/ ") . $_SESSION['company'] . "/" . substr($tmpinvno, $lenth - 7);
    $_SESSION["invno"] = $invno;

    $sql = "Select ARR from invpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $_SESSION["tmp_no_purret"] = "ARR/" . $row["ARR"];

    $sql = "Select caj, rno from tmpinvpara";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $tmpinvno = "000000" . $row["caj"];

    $lenth = strlen($tmpinvno);
    //if ($_SESSION['company']=="BEN"){
    $invnotmp = trim("CAJ/ ") . substr($tmpinvno, $lenth - 6);
    //} 
    //	if ($_SESSION['company']=="THT"){
    //	$invnotmp=trim("TGRN/ ").substr($tmpinvno, $lenth-6);
    //}

    $_SESSION["tmp_invno"] = $invnotmp;

    $sql = "delete from tmp_grn_data where tmp_no='" . $_SESSION["tmp_invno"] . "'";
    $result = $db->RunQuery($sql);

    $sql = "update tmpinvpara set caj=caj+1";
    $result = $db->RunQuery($sql);

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $ResponseXML .= "<invno><![CDATA[" . $invno . "]]></invno>";
    $ResponseXML .= "<rno><![CDATA[" . $row["rno"] . "]]></rno>";
    $ResponseXML .= "<cdate><![CDATA[" . date("Y-m-d") . "]]></cdate>";
    $ResponseXML .= "</salesdetails>";

    $_SESSION["custno"] = "";

    echo $ResponseXML;
}


if ($_GET["Command"] == "add_tmp") {
    include_once("connection.php");

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount1</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount2</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";





//echo "Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, pre_ret_qty, ret_qty, dis_per, cur_discount, cur_subtot, brand) values ( '".$_GET["invno"]."', '".$_GET["itemcode"]."', '".$_GET["item"]."', ".$_GET["rate"].", ".$_GET["qty"].", 0, 0, ".$_GET["discount"].", ".$_GET["discount_amt"].", ".$_GET["subtotal"].", '".$_GET["brand"]."')";				
    $sql_tmp = mysql_query("Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, pre_ret_qty, ret_qty, dis_per, cur_discount, dis_per2, cur_discount2, cur_subtot, brand, tmp_no) values ( '" . $_GET["invno"] . "', '" . $_GET["itemcode"] . "', '" . $_GET["item"] . "', " . $_GET["rate"] . ", 0, 0, " . $_GET["qty"] . ", " . $_GET["discount"] . ", " . $_GET["discount_amt"] . ", " . $_GET["discount2"] . ", " . $_GET["discount_amt2"] . ", " . $_GET["subtot_new"] . ", '" . $_GET["brand"] . "', '" . $_SESSION["tmp_invno"] . "')") or die(mysql_error());

    $i = 1;
    $sql_tmp = mysql_query("select * from tmp_grn_data where tmp_no = '" . $_SESSION["tmp_invno"] . "'") or die(mysql_error());
    while ($row = mysql_fetch_array($sql_tmp)) {

        $stkno = "stkno" . $i;
        $descript = "descript" . $i;
        $price = "price" . $i;
        $qty = "qty" . $i;
        $preretqty = "preret" . $i;
        $retqty = "ret" . $i;
        $disc = "disc" . $i;
        $disc2 = "disc2" . $i;
        $disc3 = "disc3" . $i;
        $disc4 = "disc4" . $i;
        $subtot = "subtot" . $i;


        if (is_null($_GET["qty"]) or $_GET["qty"] == 0) {
            $ret_qty = 0;
        } else {
            $ret_qty = $row['ret_qty'];
        }


        $ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=" . $stkno . "  disabled id=" . $stkno . " value='" . $row["str_code"] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=" . $descript . "  disabled id=" . $descript . " value='" . $row["str_description"] . "' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=" . $price . " disabled  id=" . $price . " value=" . number_format($row["cur_rate"], 2, ".", ",") . " class=\"text_purchase3\" onblur=\"ret_deduct('" . $i . "',event, '" . $_GET["mcou"] . "', 'price');\" /></td>
							 <td  ><input type=\"text\" size=\"10\" name=" . $qty . " disabled id=" . $qty . " value=" . $row["cur_qty"] . " class=\"text_purchase3\" /></td>
							 <td  ><input type=\"text\" size=\"10\" name=" . $preretqty . " disabled id=" . $preretqty . " value=" . $row["pre_ret_qty"] . " class=\"text_purchase3\" /></td>";


        $ResponseXML .= "<td  ><input type=\"text\" size=\"10\" disabled name=" . $retqty . " id=" . $retqty . " value=" . $row["ret_qty"] . " class=\"text_purchase3\" onblur=\"ret_deduct('" . $i . "',event, '" . $_GET["mcou"] . "', 'retqty');\"/></td>
							 <td  ><input type=\"text\" size=\"10\" disabled name=" . $disc . " id=" . $disc . " value=" . $row["dis_per"] . " class=\"text_purchase3\" onblur=\"ret_deduct('" . $i . "',event, '" . $_GET["mcou"] . "', 'discou');\" /></td>
							 <td  ><input type=\"text\" size=\"10\" disabled name=" . $disc2 . " id=" . $disc2 . " value=" . $row["dis_per2"] . " class=\"text_purchase3\" onblur=\"ret_deduct('" . $i . "',event, '" . $_GET["mcou"] . "', 'discou2');\" /></td>
							 <td  ><input type=\"hidden\" size=\"10\" disabled name=" . $disc3 . " id=" . $disc3 . " value=\"\" class=\"text_purchase3\"  /></td>
							 <td  ><input type=\"hidden\" size=\"10\" disabled name=" . $disc4 . " id=" . $disc4 . " value=\"\" class=\"text_purchase3\"  /></td>
							 <td  ><input type=\"text\" size=\"10\" disabled name=" . $subtot . " id=" . $subtot . " value=" . $row["cur_subtot"] . " class=\"text_purchase3\"/></td>
							 
							
							 
                            </tr>";

        $subtot1 = $row["ret_qty"] * $row["cur_rate"];
        $valdisc1 = $valdisc1 + ($subtot1 * $row["dis_per"] / 100);

        $subtot2 = $subtot1 - ($subtot1 * $row["dis_per"] / 100);

        $valdisc2 = $valdisc2 + ($subtot2 * $row["dis_per2"] / 100);

        $valdisc = $valdisc1 + $valdisc2;
        $totsubtot = $totsubtot + $row["cur_subtot"];
        $i = $i + 1;
    }

    $ResponseXML .= "   </table>]]></sales_table>";
    $ResponseXML .= "<mcou><![CDATA[" . $i . "]]></mcou>";

    $sql_tmp = mysql_query("SELECT * from invpara") or die(mysql_error());
    $row_invpara = mysql_fetch_array($sql_tmp);


    $ResponseXML .= "<valdisc><![CDATA[" . $valdisc . "]]></valdisc>";
    $ResponseXML .= "<totsubtot><![CDATA[" . $totsubtot . "]]></totsubtot>";
    if ($_GET["vatgrp"] == "vat") {
        $taxtot = ($totsubtot * $row_invpara["vatrate"]) / 100;
        $ResponseXML .= "<taxtot><![CDATA[" . $taxtot . "]]></taxtot>";
    } else {
        $ResponseXML .= "<taxtot><![CDATA[0]]></taxtot>";
    }

    $nettot = $totsubtot + $taxtot;
    $ResponseXML .= "<nettot><![CDATA[" . $nettot . "]]></nettot>";
    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}
if ($_GET["Command"] == "setord") {

    include_once("connection.php");

    $len = strlen($_GET["salesord1"]);
    $need = substr($_GET["salesord1"], $len - 7, $len);
    $salesord1 = trim("ORD/ ") . $_GET["salesrep"] . trim(" / ") . $need;


    $_SESSION["custno"] = $_GET['custno'];
    $_SESSION["brand"] = $_GET["brand"];
    $_SESSION["department"] = $_GET["department"];


    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";

    $cuscode = $_GET["custno"];
    $salesrep = $_GET["salesrep"];
    $brand = $_GET["brand"];

    //		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
    //Call SETLIMIT ====================================================================



    /* 	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
      $sql = mysql_query("CREATE VIEW view_s_salma
      AS
      SELECT     s_salma.*, brand_mas.class AS class
      FROM         brand_mas RIGHT OUTER JOIN
      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error()); */

    $OutpDAMT = 0;
    $OutREtAmt = 0;
    $OutInvAmt = 0;
    $InvClass = "";

    $sqlclass = mysql_query("select class from brand_mas where barnd_name='" . trim($brand) . "'") or die(mysql_error());
    if ($rowclass = mysql_fetch_array($sqlclass)) {
        if (is_null($rowclass["class"]) == false) {
            $InvClass = $rowclass["class"];
        }
    }

    $sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='" . trim($cuscode) . "' and SAL_EX='" . trim($salesrep) . "' and class='" . $InvClass . "'") or die(mysql_error());
    if ($rowoutinv = mysql_fetch_array($sqloutinv)) {
        if (is_null($rowoutinv["totout"]) == false) {
            $OutInvAmt = $rowoutinv["totout"];
        }
    }

    $sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='REC' and sal_ex='" . trim($salesrep) . "'") or die(mysql_error());
    while ($rowinvcheq = mysql_fetch_array($sqlinvcheq)) {

        $sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='" . trim($rowinvcheq["refno"]) . "' and ST_CHNO ='" . trim($rowinvcheq["cheque_no"]) . "'") or die(mysql_error());
        while ($rowsttr = mysql_fetch_array($sqlsttr)) {
            $sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='" . trim($rowsttr["ST_INVONO"]) . "'") or die(mysql_error());
            if ($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)) {

                if (trim($rowview_s_salma["class"]) == $InvClass) {
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
            }
        }
    }



    $pend_ret_set = 0;

    $sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'" . date("d-m-Y") . "' AND cus_code='" . trim($cuscode) . "' and trn_type='RET'") or die(mysql_error());
    if ($rowinvcheq = mysql_fetch_array($sqlinvcheq)) {
        if (is_null($rowinvcheq["che_amount"]) == false) {
            $pend_ret_set = $rowinvcheq["che_amount"];
        }
    }


    $sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='" . trim($cuscode) . "'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='" . trim($salesrep) . "'") or die(mysql_error());
    if ($rowcheq = mysql_fetch_array($sqlcheq)) {
        if (is_null($rowcheq["tot"]) == false) {
            $OutREtAmt = $rowcheq["tot"];
        } else {
            $OutREtAmt = 0;
        }
    }



    $ResponseXML .= "<sales_table_acc><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>" . number_format($OutInvAmt, 2, ".", ",") . "</td></tr>
						 <td>Return Cheque Amount</td><td>" . number_format($OutREtAmt, 2, ".", ",") . "</td></tr>
						 <td>Pending Cheque Amount</td><td>" . number_format($OutpDAMT, 2, ".", ",") . "</td></tr>
						 <td>PSD Cheque Settlments</td><td>" . number_format($pend_ret_set, 2, ".", ",") . "</td></tr>
						 <td>Total</td><td>" . number_format($OutInvAmt + $OutREtAmt + $OutpDAMT + $pend_ret_set, 2, ".", ",") . "</td></tr>
						 </table></table>]]></sales_table_acc>";


    $sqlbr_trn = mysql_query("select * from br_trn where Rep='" . trim($salesrep) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($cuscode) . "'") or die(mysql_error());
    if ($rowbr_trn = mysql_fetch_array($sqlbr_trn)) {
        if (is_null($rowbr_trn["credit_lim"]) == false) {
            $crLmt = $rowbr_trn["credit_lim"];
        } else {
            $crLmt = 0;
        }


        if (is_null($rowbr_trn["tmpLmt"]) == false) {
            $tmpLmt = $rowbr_trn["tmpLmt"];
        } else {
            $tmpLmt = 0;
        }

        if (is_null($rowbr_trn["CAT"]) == false) {
            $cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A") {
                $m = 2.5;
            }
            if ($cuscat = "B") {
                $m = 2.5;
            }
            if ($cuscat = "C") {
                $m = 1;
            }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $txt_crebal = number_format($crebal, "2", ".", ",");
        } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
        }
        $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
    }
    $ResponseXML .= "<txt_crelimi><![CDATA[" . $txt_crelimi . "]]></txt_crelimi>";
    $ResponseXML .= "<txt_crebal><![CDATA[" . $txt_crebal . "]]></txt_crebal>";

    $ResponseXML .= "<creditbalance><![CDATA[" . $creditbalance . "]]></creditbalance>";


    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "del_item") {


    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_grn_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";
    $result = $db->RunQuery($sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";


    $sql = "Select * from tmp_grn_data where str_invno='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >" . $row['str_code'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['str_description'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_rate'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_qty'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_discount'] . "</a></td>
							 <td bgcolor=\"#222222\" >" . $row['cur_subtot'] . "</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td>";

        include_once("connection.php");

        $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='" . $row['str_code'] . "' AND STO_CODE='" . $_GET["department"] . "'") or die(mysql_error());
        if ($rowqty = mysql_fetch_array($sqlqty)) {
            $qty = $rowqty['QTYINHAND'];
        } else {
            $qty = 0;
        }

        $ResponseXML .= "<td bgcolor=\"#222222\" >" . $qty . "</a></td>
                            </tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table></salesdetails>";

    //	}	


    echo $ResponseXML;
}



if ($_POST["Command"] == "save_item_grn") {
    if ($_SESSION["dev"] == "") {
        exit("no");
    }
    include('connection.php');

    $sqltmp = "select * from invpara";
    $resulttmp = mysql_query($sqltmp, $dbinv);
    $rowtmp = mysql_fetch_array($resulttmp);

    if ($rowtmp["form_loc"] == "1") {
        exit("no");
    }

    $sql_alredy = "select * from s_crnma where REF_NO='" . $_POST["grnno"] . "'";
    $result_alredy = mysql_query($sql_alredy, $dbinv);

    if ($row_alredy = mysql_fetch_array($result_alredy)) {
        exit("Already Exist");
    }

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    /* 		$_SESSION["CURRENT_DOC"] = 1;      //document ID
      $_SESSION["VIEW_DOC"] = false ;     //view current document
      $_SESSION["FEED_DOC"] = true;       //save  current document
      $_GET["MOD_DOC"] = false  ;         //delete   current document
      $_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
      $_GET["PRICE_EDIT"] = false ;       //edit selling price
      $_GET["CHECK_USER"] = false ;       //check user permission again

     */
    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysql_query($sql_invpara, $dbinv);
    $row_invpara = mysql_fetch_array($result_invpara);

    $mvatrate = $row_invpara["vatrate"];

    $cre_balance = str_replace(",", "", $_POST["balance"]);
    $totdiscount = str_replace(",", "", $_POST["totdiscount"]);
    $subtot = str_replace(",", "", $_POST["subtot"]);
    $invtot = str_replace(",", "", $_POST["invtot"]);



    // Insert c_bal ============================================================ 
    $sql_status = 0;

    mysql_query("SET AUTOCOMMIT=0", $dbinv);
    mysql_query("START TRANSACTION", $dbinv);

    $sql = "insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, RNO, Cancell, company) values ('" . $_POST["grnno"] . "', '" . $_POST["grndate"] . "', 'GRN', '" . $_POST["cusno"] . "', " . $invtot . ", " . $invtot . ", '" . $_POST["brand"] . "', '" . $_POST["department"] . "', '" . $_POST["salesrep"] . "', '" . $_SESSION['dev'] . "', " . $mvatrate . ", '" . $_POST["rno"] . "', '0', '".$_SESSION['company']."')";
    $result = mysql_query($sql, $dbinv);

    if ($result != 1) {
        $sql_status = 1;
    }



    $sql = "insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL, TRN_TYPE, stoRef, company) values ('" . $_POST["grnno"] . "', '" . $_POST["grndate"] . "', '" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["cusno"] . "', '" . $_POST["cusname"] . "', " . $invtot . ", " . $totdiscount . ", '" . $_POST["department"] . "', '" . $_POST["department"] . "', '" . $_POST["brand"] . "', '" . $_POST["salesrep"] . "', '" . $_SESSION['dev'] . "', " . $mvatrate . ", '" . $_POST["serialno"] . "', " . $mvatrate . ", '0', 'GRN', '" . $_POST["txtstoRef"] . "', '".$_SESSION['company']."')";
    $result = mysql_query($sql, $dbinv);

    if ($result != 1) {
        $sql_status = 2;
    }



    $i = 1;

    while ($_POST["mcou"] > $i) {
        $stkno = "stkno" . $i;
        $descript = "descript" . $i;
        $price = "price" . $i;
        $qty = "qty" . $i;
        $preretqty = "preret" + $i;
        $retqty = "ret" . $i;
        $disc = "disc" . $i;
        $disc2 = "disc2" . $i;
        $disc3 = "disc3" . $i;
        $disc4 = "disc4" . $i;
        $subtot = "subtot" . $i;

        $price_val = str_replace(",", "", $_POST[$price]);
        $retqty_val = str_replace(",", "", $_POST[$retqty]);
        $qty_val = str_replace(",", "", $_POST[$qty]);

        if ($_POST[$retqty] > 0) {

            $mprice = $price_val;
            $mprice1 = $price_val;
            $mprice1 = $mprice1 - ($price_val * $_POST[$disc] / 100);

            $mprice1 = $mprice1 - ($mprice1 * $_POST[$disc2] / 100);

            $mprice1 = $mprice1 - ($mprice1 * $_POST[$disc3] / 100);
            $x = $mprice1;

            $mprice1 = $mprice1 - ($mprice1 * $_POST[$disc4] / 100);
            $y = $mprice1;

            $mdis = $mprice - $mprice1;
            $com_ad_val = $x - $y;

            $sql = "insert into s_crntrn(REF_NO, STK_NO, SDATE, DESCRIPT, PRICE, DIS_P, DIS_P2, DIS_P3,sp_dr,sp_dval, QTY, DEPARTMENT, VAT, Seri_no, vatrate,DIS_RS) values"
                        . " ('" . $_POST["grnno"] . "', '" . $_POST[$stkno] . "', '" . $_POST["grndate"] . "', '" . $_POST[$descript] . "', '" . $price_val . "', '" . $_POST[$disc] . "', '" . $_POST[$disc2] . "', '" . $_POST[$disc3] . "', '" . $_POST[$disc4] . "','$com_ad_val', " . $retqty_val . ", '" . $_POST["department"] . "', '" . $_POST["vatmethod"] . "', '" . $_POST["serialno"] . "', " . $mvatrate . ",'" . $mdis . "')";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
                $sql_status = 3;
            }
 
            $sql = "update s_invo set ret_qty=ret_qty+" . $_POST[$retqty] . " where REF_NO='" . $_POST["grnno"] . "' and STK_NO='" . $_POST[$stkno] . "'";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
                $sql_status = 4;
            }

            $sql = "update s_mas set QTYINHAND=QTYINHAND+" . $_POST[$retqty] . " where STK_NO='" . $_POST[$stkno] . "'";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
                $sql_status = 5;
            }

            $sql = "update s_submas set QTYINHAND=QTYINHAND+" . $_POST[$retqty] . " where STK_NO='" . $_POST[$stkno] . "' and STO_CODE='" . $_POST["department"] . "'";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
                $sql_status = 6;
            }

            $sql = "insert into s_trn(STK_NO, SDATE, REFNO, QTY, LEDINDI, DEPARTMENT, seri_no) values ('" . $_POST[$stkno] . "', '" . $_POST["grndate"] . "', '" . $_POST["grnno"] . "', " . $_POST[$retqty] . ", 'GRN', '" . $_POST["department"] . "', '" . $_POST["serialno"] . "')";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
                $sql_status = 7;
            }
        }

        $i = $i + 1;
    }

    $sql8 = "update s_salma set RET_AMO=RET_AMO+" . $_POST["invtot"] . " where REF_NO='" . $_POST["grnno"] . "' ";
    $result = mysql_query($sql8, $dbinv);
    if ($result != 1) {
        $sql_status = 8;
    }

    $sql = "insert into s_led(REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values ('" . $_POST["grnno"] . "', '" . $_POST["grndate"] . "', '" . $_POST["cusno"] . "', " . $_POST["invtot"] . ", 'GRN', '" . $_POST["department"] . "', '" . $_SESSION['dev'] . "') ";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 9;
    }
    
    //========gl_posting===================
    
    require_once './gl_posting.php';
    $ayear = ac_year($_POST["grndate"]);
    $vat = $_POST["vatmethod"];
    $invno = $_POST["grnno"];
    
    $sql = "select vatrate from invpara";
    $result=mysql_query($sql, $dbinv);
    $rowVat = mysql_fetch_array($result);
    $vatrate = $rowVat["vatrate"];
    $amount = $_POST["invtot"];
    $vatAmount = $amount*$vatrate/(100+$vatrate);
    $vatAmount = number_format($vatAmount, "2", ".", "");
    
    $orgAmount = $amount - $vatAmount;

    $sqlGlPost = "select * from gl_posting where docname = 'Good Return' and action = 'ADD_VAT'";    
    $result=mysql_query($sqlGlPost, $dbinv);
    $rowGlPost = mysql_fetch_array($result);


    $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $invno . "', '" . $_POST["grndate"] . "', '" . $rowGlPost["l_code"] . "', " . $vatAmount . ", 'GRN', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "', '" . $_POST["cusno"] . "')";
    $result1=mysql_query($sqlLedger, $dbinv);

    if ($result1!=1){ $sql_status=221; }
    
    $sqlGlPost = "select * from gl_posting where docname = 'Good Return' and action = 'RTN_INW'";    
    $result=mysql_query($sqlGlPost, $dbinv);
    $rowGlPost = mysql_fetch_array($result);
    
    $sqlLedger222 = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks)  Values ('" . $invno . "', '" . $_POST["grndate"] . "', '" . $rowGlPost["l_code"] . "', " . $orgAmount . ", 'GRN', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "', '" . $_POST["cusno"] . "')";
    $result1=mysql_query($sqlLedger222, $dbinv);
    if ($result1!=1){ $sql_status=222; }    
    
    $sql = "select TYPE from s_salma where REF_NO = '".$_POST["invno"]."'";
    $result=mysql_query($sql, $dbinv);
    $row = mysql_fetch_array($result);
    $action = "ADD_DEBTORS";
    if($row["TYPE"]=="CA"){
        $action = "ADD_CASHIH";
    }
    
    $sqlGlPost = "select * from gl_posting where docname = 'Good Return' and action = '$action'";    
    $result=mysql_query($sqlGlPost, $dbinv);
    $rowGlPost = mysql_fetch_array($result);
    $sqlLedger223 = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks)  Values ('" . $invno . "', '" . $_POST["grndate"] . "', '" . $rowGlPost["l_code"] . "', " . $amount . ", 'GRN', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "', '" . $_POST["cusno"] . "')";
    $result1=mysql_query($sqlLedger223, $dbinv);
    if ($result1!=1){ $sql_status=223; }    
    
    //


    $sql = "update invpara set grn=grn+1 where COMCODE='" . $_SESSION['company'] . "' ";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 10;
    }

    $sql = "delete from tmp_grn_data where tmp_no='" . $_SESSION["tmp_invno"] . "' ";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 11;
    }

    $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST["grnno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'GRN', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $result = mysql_query($sql, $dbinv);
    
    if ($result != 1) {
        $sql_status = 12;
    }


    $_SESSION["custno"] = "";

    if ($sql_status == 0) {
        mysql_query("COMMIT", $dbinv);
        echo "Saved";
    } else {
        mysql_query("ROLLBACK", $dbinv);
        echo "Error ($sql_status) has occured. Can't Saved $sqlLedger223";
    }
}


if ($_POST["Command"] == "save_item_caj") {
    if ($_SESSION["dev"] == "") {
        exit("no");
    }

    include('connection.php');

    $sqltmp = "select * from invpara";
    $resulttmp = mysql_query($sqltmp, $dbinv);
    $rowtmp = mysql_fetch_array($resulttmp);

    if ($rowtmp["form_loc"] == "1") {
        exit("no");
    }

    $sql_alredy = "select * from s_crnma where REF_NO='" . $_POST["grnno"] . "'";
    $result_alredy = mysql_query($sql_alredy, $dbinv);

    if ($row_alredy = mysql_fetch_array($result_alredy)) {
        exit("Already Exist");
    }

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    /* 		$_SESSION["CURRENT_DOC"] = 1;      //document ID
      $_SESSION["VIEW_DOC"] = false ;     //view current document
      $_SESSION["FEED_DOC"] = true;       //save  current document
      $_GET["MOD_DOC"] = false  ;         //delete   current document
      $_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
      $_GET["PRICE_EDIT"] = false ;       //edit selling price
      $_GET["CHECK_USER"] = false ;       //check user permission again

     */
    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysql_query($sql_invpara, $dbinv);
    $row_invpara = mysql_fetch_array($result_invpara);

    $mvatrate = $row_invpara["vatrate"];

    $cre_balance = str_replace(",", "", $_POST["balance"]);
    $totdiscount = str_replace(",", "", $_POST["totdiscount"]);
    $subtot = str_replace(",", "", $_POST["subtot"]);
    $invtot = str_replace(",", "", $_POST["invtot"]);



    // Insert c_bal ============================================================ 
    $sql_status = 0;

    mysql_query("SET AUTOCOMMIT=0", $dbinv);
    mysql_query("START TRANSACTION", $dbinv);
    /*
    $sql = "insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, RNO, Cancell) values ('" . $_GET["grnno"] . "', '" . $_GET["grndate"] . "', 'CAJ', '" . $_GET["cusno"] . "', " . $invtot . ", " . $invtot . ", '" . $_GET["brand"] . "', '" . $_GET["department"] . "', '" . $_GET["salesrep"] . "', '" . $_SESSION['dev'] . "', " . $mvatrate . ", '" . $_GET["rno"] . "', '0')";

    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }



    $sql = "insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL, TRN_TYPE, stoRef) values ('" . $_GET["grnno"] . "', '" . $_GET["grndate"] . "', '" . $_GET["invno"] . "', '" . $_GET["invdate"] . "', '" . $_GET["cusno"] . "', '" . $_GET["cusname"] . "', " . $invtot . ", " . $totdiscount . ", '" . $_GET["department"] . "', '" . $_GET["department"] . "', '" . $_GET["brand"] . "', '" . $_GET["salesrep"] . "', '" . $_SESSION['dev'] . "', " . $mvatrate . ", '" . $_GET["serialno"] . "', " . $mvatrate . ", '0', 'CAJ', '" . $_GET["txtstoRef"] . "')";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }
    */

    $tot_com_ad_val = 0;
    $i = 1;

    while ($_POST["mcou"] > $i) {
        $stkno = "stkno" . $i;
        $descript = "descript" . $i;
        $price = "price" . $i;
        $qty = "qty" . $i;
        $preretqty = "preret" + $i;
        $retqty = "ret" . $i;
        $disc = "disc" . $i;
        $disc2 = "disc2" . $i;
        $disc3 = "disc3" . $i;
        $disc4 = "disc4" . $i;
        $subtot = "subtot" . $i;
        $com_ad_val = 0;

        $price_val = str_replace(",", "", $_POST[$price]);
        $retqty_val = str_replace(",", "", $_POST[$retqty]);
        $qty_val = str_replace(",", "", $_POST[$qty]);

        $mprice = $price_val*$qty_val;
        $mprice1 = $price_val*$qty_val;
        $mprice1 = $mprice1 - ($price_val * $qty_val * $_POST[$disc] / 100);

        $mprice1 = $mprice1 - ($mprice1 * $_POST[$disc2] / 100);

        $mprice1 = $mprice1 - ($mprice1 * $_POST[$disc3] / 100);
        $x = $mprice1;

        $mprice1 = $mprice1 - ($mprice1 * $_POST[$disc4] / 100);
        $y = $mprice1;

        $mdis = $mprice - $mprice1;
        $com_ad_val = $x - $y;
        if ($com_ad_val > 0){
            $sql = "insert into s_crntrn(REF_NO, STK_NO, SDATE, DESCRIPT, PRICE, DIS_P, DIS_P2, DIS_P3,sp_dr,sp_dval,caj, QTY, DEPARTMENT, VAT, Seri_no, vatrate,DIS_RS) values"
                    . " ('" . $_POST["grnno"] . "', '" . $_POST[$stkno] . "', '" . $_POST["grndate"] . "', '" . $_POST[$descript] . "', '" . $price_val . "', '" . $_POST[$disc] . "', '" . $_POST[$disc2] . "', '" . $_POST[$disc3] . "', '" . $_POST[$disc4] . "','$com_ad_val','1', " . $qty_val . ", '" . $_POST["department"] . "', '" . $_POST["vatmethod"] . "', '" . $_POST["serialno"] . "', " . $mvatrate . ",'" . $mdis . "')";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
            $sql_status = 1;
            }
        }

        $sql = "update s_invo set sp_dr='" . $_POST[$disc4] . "', sp_dval='$com_ad_val' where REF_NO='" . $_POST["invno"] . "' and STK_NO='" . $_POST[$stkno] . "'";
        $result = mysql_query($sql, $dbinv);
        if ($result != 1) {
            $sql_status = 1;
        }

        $i = $i + 1;
        
        $tot_com_ad_val += $com_ad_val;
    }

    $sql = "select vat from s_salma where REF_NO = '".$_POST["invno"]."'";
    $result = mysql_query($sql, $dbinv);
    $row = mysql_fetch_array($result); 
    if(($row["vat"]=="1")||($row["vat"]=="2")){
        $x = 1 + $mvatrate/100;
        $tot_com_ad_val *= $x;
    }
    
    $sql = "insert into c_bal(REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, DEV, vatrate, RNO, Cancell) values ('" . $_POST["grnno"] . "', '" . $_POST["grndate"] . "', 'CAJ', '" . $_POST["cusno"] . "', " . $tot_com_ad_val . ", " . $tot_com_ad_val . ", '" . $_POST["brand"] . "', '" . $_POST["department"] . "', '" . $_POST["salesrep"] . "', '" . $_SESSION['dev'] . "', " . $mvatrate . ", '" . $_POST["rno"] . "', '0')";

    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }

    $sql = "update s_salma set flg_caj = '1' where REF_NO = '".$_POST["invno"]."'";

    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }




    $sql = "insert into s_crnma(REF_NO, SDATE, INVOICENO, DDATE, C_CODE, CUS_NAME, GRAND_TOT, DIS, DEPARTMENT, DEP_CODE, Brand, SAL_EX, DEV, GST, seri_no, vatrate, CANCELL, TRN_TYPE, stoRef) values ('" . $_POST["grnno"] . "', '" . $_POST["grndate"] . "', '" . $_POST["invno"] . "', '" . $_POST["invdate"] . "', '" . $_POST["cusno"] . "', '" . $_POST["cusname"] . "', " . $tot_com_ad_val . ", " . $totdiscount . ", '" . $_POST["department"] . "', '" . $_POST["department"] . "', '" . $_POST["brand"] . "', '" . $_POST["salesrep"] . "', '" . $_SESSION['dev'] . "', " . $mvatrate . ", '" . $_POST["serialno"] . "', " . $mvatrate . ", '0', 'CAJ', '" . $_POST["txtstoRef"] . "')";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }
    
    $sql = "update invpara set caj=caj+1 where COMCODE='" . $_SESSION['company'] . "' ";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }

    $sql = "delete from tmp_grn_data where tmp_no='" . $_SESSION["tmp_invno"] . "' ";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }

    $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_POST["grnno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'CAJ', 'Save', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
    $result = mysql_query($sql, $dbinv);
    if ($result != 1) {
        $sql_status = 1;
    }


    $_SESSION["custno"] = "";

    if ($sql_status == 0) {
        mysql_query("COMMIT", $dbinv);
        echo "Saved";
    } else {
        mysql_query("ROLLBACK", $dbinv);
        echo "Error has occured. Can't Saved";
    }
}



if ($_GET["Command"] == "pass_grnno") {
    include_once("connection.php");

    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    $sql = mysql_query("Select * from s_crnma where REF_NO='" . $_GET['grn'] . "'")or die(mysql_error());
    if ($row = mysql_fetch_array($sql)) {

        $ResponseXML .= "<REF_NO><![CDATA[" . $row['REF_NO'] . "]]></REF_NO>";
        $ResponseXML .= "<DDATE><![CDATA[" . $row['DDATE'] . "]]></DDATE>";
        $ResponseXML .= "<C_CODE><![CDATA[" . $row['C_CODE'] . "]]></C_CODE>";
        $ResponseXML .= "<CUS_NAME><![CDATA[" . $row['CUS_NAME'] . "]]></CUS_NAME>";

        $sql_ven = mysql_query("Select * from vendor where CODE='" . $row['C_CODE'] . "'")or die(mysql_error());
        $row_ven = mysql_fetch_array($sql_ven);
        $ResponseXML .= "<address><![CDATA[" . $row_ven['ADD1'] . " " . $row_ven['ADD2'] . "]]></address>";
        $ResponseXML .= "<INVOICENO><![CDATA[" . $row['INVOICENO'] . "]]></INVOICENO>";
        $ResponseXML .= "<SAL_EX><![CDATA[" . $row['SAL_EX'] . "]]></SAL_EX>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<Brand><![CDATA[" . $row['Brand'] . "]]></Brand>";
        $ResponseXML .= "<DEPARTMENT><![CDATA[" . $row['DEPARTMENT'] . "]]></DEPARTMENT>";
        $ResponseXML .= "<DIS><![CDATA[" . $row['DIS'] . "]]></DIS>";
        $ResponseXML .= "<GRAND_TOT><![CDATA[" . $row['GRAND_TOT'] . "]]></GRAND_TOT>";
        $ResponseXML .= "<stoRef><![CDATA[" . $row['stoRef'] . "]]></stoRef>";
        $ResponseXML .= "<cancel><![CDATA[" . $row['CANCELL'] . "]]></cancel>";
        $txtvatp = $row['GST'];

        //	$sql1="insert into s_trn(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT) values ('".$row2["str_code"]."', '".$_GET["invdate"]."', '".$cur_qty."', 'GINI', '".$_GET["invno"]."', '".$_GET["from_dep"]."')";
        //	$result1 =$db->RunQuery($sql1);





        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Pre.RetQty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Ret.Qty</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount1</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount2</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
                            </tr>";

        $i = 1;

        //echo "delete from tmp_grn_data where str_invno='".$row['REF_NO']."'";
        $sql_data = mysql_query("delete from tmp_grn_data where str_invno='" . $row['REF_NO'] . "'") or die(mysql_error());
        //echo "Select * from s_invo where REF_NO='".$inv."'";

        $sql_data = mysql_query("Select count(*) as mcount from s_crntrn where REF_NO='" . $row['REF_NO'] . "'") or die(mysql_error());
        $row_data = mysql_fetch_array($sql_data);
        $mcou = $row_data['mcount'];

        //echo "Select * from s_crntrn where REF_NO='".$row['REF_NO']."'";
        $sql_data = mysql_query("Select * from s_crntrn where REF_NO='" . $row['REF_NO'] . "'") or die(mysql_error());
        while ($row_data = mysql_fetch_array($sql_data)) {
            $sql_itdata = mysql_query("Select * from s_mas where STK_NO='" . $row_data['STK_NO'] . "' and BRAND_NAME='" . $row["Brand"] . "'") or die(mysql_error());
            $rowit = mysql_fetch_array($sql_itdata);

            $vat = $row_data["VAT"];




            if ($row_data['DIS_RS'] == "") {
                $DIS_RS = 0;
            } else {
                $DIS_RS = $row_data['DIS_RS'];
            }
            if ($row_data['DIS_P'] == "") {
                $DIS_P = 0;
            } else {
                $DIS_P = $row_data['DIS_P'];
            }


            $subtot_val = $row_data['PRICE'] * $row_data['QTY'] - ($row_data['PRICE'] * $row_data['QTY']) * $row_data['DIS_P'] * 0.01;

            $subtot_val = $subtot_val - ($subtot_val * $row_data['DIS_P'] * 0.01);

            $tot = $tot + $subtot_val;
            $dis = $dis + ($row_data['PRICE'] * $row_data['QTY']) * $row_data['DIS_P'] * 0.01;




            //echo $subtot;
            //	echo "Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '".$row['REF_NO']."', '".$row_data['STK_NO']."', '".$row_data['DESCRIPT']."', ".$row_data['PRICE'].", 0, ".$DIS_P.", ".$DIS_RS.", ".$subtot.", '".$row["Brand"]."')";
            $sql_tmp = mysql_query("Insert into tmp_grn_data(str_invno, str_code, str_description, cur_rate, cur_qty, dis_per,cur_discount, cur_subtot, brand) values ( '" . $row['REF_NO'] . "', '" . $row_data['STK_NO'] . "', '" . $row_data['DESCRIPT'] . "', " . str_replace(",", "", $row_data['PRICE']) . ", 0, " . $DIS_P . ", " . $DIS_RS . ", " . $subtot_val . ", '" . $row["Brand"] . "')") or die(mysql_error());

            $stkno = "stkno" . $i;
            $descript = "descript" . $i;
            $price = "price" . $i;
            $qty = "qty" . $i;
            $preretqty = "preret" . $i;
            $retqty = "ret" . $i;
            $disc = "disc" . $i;
            $disc2 = "disc2" . $i;
            $subtot = "subtot" . $i;


            if (is_null($row_data['QTY']) or $row_data['QTY'] == 0) {
                $ret_qty = 0;
            } else {
                $ret_qty = $row_data['QTY'];
            }


            $ResponseXML .= "<tr>
                        
							 <td><input type=\"text\" name=" . $stkno . "  disabled id=" . $stkno . " value='" . $row_data['STK_NO'] . "' class=\"text_purchase3\"/></td>
							 <td><input type=\"text\"  name=" . $descript . "  disabled id=" . $descript . " value='" . $row_data['DESCRIPT'] . "' class=\"text_purchase3\"/></td>
							 <td><input type=\"text\" name=" . $price . "  disabled id=" . $price . " value=" . number_format(str_replace(",", "", $row_data['PRICE']), 0, ".", ",") . " class=\"text_purchase3\"/></td>";

            $sql_inv = mysql_query("Select * from s_invo where REF_NO='" . $row['INVOICENO'] . "' and STK_NO='" . $row_data['STK_NO'] . "'") or die(mysql_error());
            $row_inv = mysql_fetch_array($sql_inv);

            //$qty_r=str_replace(",", "", $row_inv['QTY']);

            $ResponseXML .= " <td><input type=\"text\" name=" . $qty . "  disabled id=" . $qty . " value=" . $row_data['QTY'] . " class=\"text_purchase3\"/></td>
							 <td><input type=\"text\" name=" . $preretqty . "  disabled id=" . $preretqty . "  class=\"text_purchase3\"/></td>
							
							 <td><input type=\"text\" name=" . $retqty . " disabled id=" . $retqty . "  class=\"text_purchase3\" value=" . $ret_qty . " onKeyPress=\"ret_deduct('" . $i . "',event, '" . $mcou . "');\"/></td>
							 <td><input type=\"text\" name=" . $disc . " disabled id=" . $disc . "  class=\"text_purchase3\" value=\"" . $row_data['DIS_P'] . "\" /></td>
							 <td><input type=\"text\" name=" . $disc2 . " disabled id=" . $disc2 . "  class=\"text_purchase3\" value=\"" . $row_data['DIS_P2'] . "\" /></td>
							 <td><input type=\"text\" name=" . $subtot . " disabled id=" . $subtot . " value='" . $subtot_val . "' class=\"text_purchase3\"/></td>
							 
							
							 
                            </tr>";

            $i = $i + 1;
        }

        $ResponseXML .= "   </table>]]></sales_table>";

        $ResponseXML .= "<vat><![CDATA[" . $vat . "]]></vat>";

        if ($vat != "1") {
            $txtvat = 0;
        } else {
            $txtvat = $tot * $txtvatp / 100;
        }
        //$txtvat = $tot / (100 + $txtvatp) * $txtvatp;
        $ResponseXML .= "<mcount><![CDATA[" . $i . "]]></mcount>";
        $ResponseXML .= "<txtvat><![CDATA[" . $txtvat . "]]></txtvat>";
        $ResponseXML .= "<txt_dis><![CDATA[" . $dis . "]]></txt_dis>";
        $ResponseXML .= "<txt_net><![CDATA[" . $tot . "]]></txt_net>";




        $ResponseXML .= " </salesdetails>";
    }


    echo $ResponseXML;
}

if ($_GET["Command"] == "cancel_inv") {

    include('connection.php');

    $sql_status = 0;






    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";

    /* 		$_SESSION["CURRENT_DOC"] = 1;      //document ID
      $_SESSION["VIEW_DOC"] = false ;     //view current document
      $_SESSION["FEED_DOC"] = true;       //save  current document
      $_GET["MOD_DOC"] = false  ;         //delete   current document
      $_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
      $_GET["PRICE_EDIT"] = false ;       //edit selling price
      $_GET["CHECK_USER"] = false ;       //check user permission again

     */
    $sql_invpara = "SELECT * from invpara";
    $result_invpara = mysql_query($sql_invpara, $dbinv);
    $row_invpara = mysql_fetch_array($result_invpara);

    $mvatrate = $row_invpara["vatrate"];


    mysql_query("SET AUTOCOMMIT=0", $dbinv);
    mysql_query("START TRANSACTION", $dbinv);

    $cre_balance = str_replace(",", "", $_GET["balance"]);
    $totdiscount = str_replace(",", "", $_GET["totdiscount"]);
    $subtot = str_replace(",", "", $_GET["subtot"]);
    $invtot = str_replace(",", "", $_GET["invtot"]);


    $sql = "select * from c_bal where REFNO='" . $_GET["grnno"] . "'";
    $result = mysql_query($sql, $dbinv);

    if ($row = mysql_fetch_array($result)) {
        if ($row["AMOUNT"] == $row["BALANCE"]) {
            $sql1 = "update s_crnma set CANCELL='1' where REF_NO='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "update s_crntrn set CANCELL='1' where REF_NO='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }


            $sql1 = "delete from c_bal where REFNO='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }
            
            $sql1 = "DELETE from ledger WHERE l_refno='" . trim($_GET["grnno"]) . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }


            $i = 1;

            while ($_GET["mcou"] > $i) {
                $stkno = "stkno" . $i;
                $descript = "descript" . $i;
                $price = "price" . $i;
                $qty = "qty" . $i;
                $preretqty = "preret" . $i;
                $retqty = "ret" . $i;
                $disc = "disc" . $i;
                $subtot = "subtot" . $i;

                if ($_GET[$retqty] > 0) {
                    $sql1 = "update s_invo set ret_qty=ret_qty-" . $_GET[$retqty] . " where REF_NO='" . $_GET["grnno"] . "' and STK_NO='" . $_GET[$stkno] . "'";
                    $result1 = mysql_query($sql1, $dbinv);
                    if ($result1 != 1) {
                        $sql_status = 1;
                    }

                    $sql1 = "update s_mas set QTYINHAND=QTYINHAND-" . $_GET[$retqty] . " where STK_NO='" . $_GET[$stkno] . "'";
                    $result1 = mysql_query($sql1, $dbinv);
                    if ($result1 != 1) {
                        $sql_status = 1;
                    }

                    $sql1 = "update s_submas set QTYINHAND=QTYINHAND-" . $_GET[$retqty] . " where STK_NO='" . $_GET[$stkno] . "' and STO_CODE='" . $_GET["department"] . "'";
                    //echo $sql1;
                    $result1 = mysql_query($sql1, $dbinv);
                    if ($result1 != 1) {
                        $sql_status = 1;
                    }
                }
                $i = $i + 1;
            }

            $sql1 = "delete from s_trn where ltrim(REFNO)='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "delete from s_trn_all where ltrim(REFNO)='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "delete from s_led where REF_NO='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "update s_salma set RET_AMO=RET_AMO+" . $_GET["invtot"] . " where REF_NO='" . $_GET["grnno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql1 = "update vendor set CUR_BAL=CUR_BAL+" . $_GET["invtot"] . " where CODE='" . $_GET["cusno"] . "'";
            $result1 = mysql_query($sql1, $dbinv);
            if ($result1 != 1) {
                $sql_status = 1;
            }

            $sql = "insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('" . trim($_GET["grnno"]) . "', '" . $_SESSION["CURRENT_USER"] . "', 'GRN', 'Cancel', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d") . "')";
            $result = mysql_query($sql, $dbinv);
            if ($result != 1) {
                $sql_status = 1;
            }

            if ($sql_status == 0) {
                mysql_query("COMMIT", $dbinv);
                echo "Canceled";
            } else {
                mysql_query("ROLLBACK", $dbinv);
                echo "Error has occured. Can't Cancel";
            }
        } else {
            echo "Can't Cancel";
        }
    }



    $_SESSION["custno"] = "";
}



if ($_GET["Command"] == "tmp_crelimit") {
    echo "abc";
    $crLmt = 0;
    $cat = "";

    $rep = trim(substr($_GET["Com_rep1"], 0, 5));

    $sql = "select * from br_trn where rep='" . $rep . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "' and brand='" . trim($_GET["cmbbrand1"]) . "'";
    echo $sql;
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
        $crLmt = $row["credit_lim"];
        If (is_null($row["cat"]) == false) {
            $cat = trim($row["cat"]);
        } else {
            $crLmt = 0;
        }
    }
    /* 	
      $_SESSION["CURRENT_DOC"] = 66     //document ID
      //$_SESSION["VIEW_DOC"] = true      //  view current document
      $_SESSION["FEED_DOC"] = true      //  save  current document
      //$_SESSION["MOD_DOC"] = true       //   delete   current document
      //$_SESSION["PRINT_DOC"] = true     // get additional print   of  current document
      //$_SESSION["PRICE_EDIT"]= true     // edit selling price
      $_SESSION["CHECK_USER"] = true    // check user permission again
      $crLmt = $crLmt;
      setlocale(LC_MONETARY, "en_US");
      $CrTmpLmt = number_format($_GET["txt_tmeplimit"], 2, ".", ",");

      $REFNO = trim($_GET["txt_cuscode"]) ;

      $AUTH_USER="tmpuser";

      $sql = "insert into tmpCrLmt (sdate, stime, username, tmpLmt, class, rep, cuscode, crLmt, cat) values
      ('".date("Y-m-d")."','".date("H:i:s", time())."' ,'".$AUTH_USER."',".$CrTmpLmt." ,'".trim($_GET["cmbbrand1"])."','".$rep."','".trim($_GET["txt_cuscode"])."',".$crLmt.",'".$cat"' )";
      $result =$db->RunQuery($sql);

      $sql = "select * from  br_trn where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."'";
      $result =$db->RunQuery($sql);
      if ($row = mysql_fetch_array($result)) {
      $sqlbrtrn= "insert into br_trn (cus_code, rep, credit_lim, brand, tmplmt) values ('".trim($_GET["txt_cuscode"])."','".$rep."','0','".trim($_GET["cmbbrand1"])."',".$CrTmpLmt." )";
      $resultbrtrn =$db->RunQuery($sqlbrtrn);

      } else {

      $sqlbrtrn= "update br_trn set tmplmt= ".$CrTmpLmt."  where cus_code='".trim($_GET["txt_cuscode"])."' and rep='".$rep."' and brand='".$_GET["cmbbrand1"]."' ";
      $resultbrtrn =$db->RunQuery($sqlbrtrn);

      //	$sqlbrtrn= "update vendor set temp_limit= ".$CrTmpLmt."  where code='".trim($_GET["txt_cuscode"])."' "
      }

      If ($_GET["Check1"] == 1) {
      $sqlblack= "update vendor set blacklist= '1'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =$db->RunQuery($sqlblack);
      } else {
      $sqlblack= "update vendor set blacklist= '0'  where code='".trim($_GET["txt_cuscode"])."' ";
      $resultblack =$db->RunQuery($sqlblack);
      }

      echo "Tempory limit updated"; */
}
?>