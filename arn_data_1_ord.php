<?php

session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();

////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

$stname = "";
if (isset($_GET["stname"])) {
    $stname = $_GET["stname"];
}

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


if ($_GET["Command"] == "new_inv") {

    $_SESSION["print"] = 0;

    /* 	$sql="Select CAS_INV_NO_m from invpara";
      $result =$db->RunQuery($sql);
      $row = mysql_fetch_array($result);
      $tmpinvno="000000".$row["CAS_INV_NO_m"];
      $lenth=strlen($tmpinvno);
      $invno="INV".substr($tmpinvno, $lenth-7);
      echo $invno; */

//    $sql = "Select ARN from invpara where COMCODE='" . $_SESSION['company'] . "'";
    $sql = "Select ORD_NO, vatrate, nbt from invpara";

    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $tmpinvno="000000".$row["ORD_NO"];
    $lenth=strlen($tmpinvno);
    $invno=trim("ORD/ ").substr($tmpinvno, $lenth-8);

//    echo $invno;
    
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        
    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";
    
    $ResponseXML .= "<REFNO><![CDATA[" . $invno . "]]></REFNO>";
    $ResponseXML .= "<vatrate><![CDATA[" . $row['vatrate'] . "]]></vatrate>";
    $ResponseXML .= "<nbt><![CDATA[" . $row['nbt'] . "]]></nbt>";
    $ResponseXML .= " </salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "add_tmp") {

    $department = $_GET["department"];

    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_purord_data where str_code='" . $_GET['itemcode'] . "' and str_invno='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = $db->RunQuery($sql);

    //echo $_GET['rate'];
    //echo $_GET['qty'];

    $qty = str_replace(",", "", $_GET["qty"]);


    $sql = "Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
			('" . $_GET['invno'] . "', '" . $_GET['itemcode'] . "', '" . $_GET['item'] . "', '" . $_GET["partno"] . "', " . $qty . ") ";
    //$ResponseXML .= $sql;
    $result = $db->RunQuery($sql);


    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";


    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . number_format($row['qty'], 2, ".", ",") . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";

    //	}	


    echo $ResponseXML;
}


if ($_GET["Command"] == "arn") {

    //$department=$_GET["department"];
	
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        
    $ResponseXML .= "";
    $ResponseXML .= "<salesdetails>";


    $sql = "select * from s_ordmas_1 where REFNO='" . $_GET['invno'] . "' ";
    //$ResponseXML .= $sql;
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row['REFNO'] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row['SDATE'] . "]]></SDATE>";
        $ResponseXML .= "<SUP_CODE><![CDATA[" . $row['SUP_CODE'] . "]]></SUP_CODE>";
        $ResponseXML .= "<SUP_NAME><![CDATA[" . $row['SUP_NAME'] . "]]></SUP_NAME>";
        $ResponseXML .= "<REMARK><![CDATA[" . $row['REMARK'] . "]]></REMARK>";
        $ResponseXML .= "<DEP_CODE><![CDATA[" . $row['DEP_CODE'] . "]]></DEP_CODE>";
        $ResponseXML .= "<DEP_NAME><![CDATA[" . $row['DEP_NAME'] . "]]></DEP_NAME>";
        $ResponseXML .= "<REP_CODE><![CDATA[" . $row['REP_CODE'] . "]]></REP_CODE>";
        $ResponseXML .= "<REP_NAME><![CDATA[" . $row['REP_NAME'] . "]]></REP_NAME>";
        $ResponseXML .= "<S_date><![CDATA[" . $row['S_date'] . "]]></S_date>";
        $ResponseXML .= "<LC_No><![CDATA[" . $row['LC_No'] . "]]></LC_No>";
        $ResponseXML .= "<pi_no><![CDATA[" . $row['pi_no'] . "]]></pi_no>";
        $ResponseXML .= "<Brand><![CDATA[" . $row['Brand'] . "]]></Brand>";
        $ResponseXML .= "<COUNTRY><![CDATA[" . $row["COUNTRY"] . "]]></COUNTRY>";
//        $ResponseXML .= "<type><![CDATA[".$row['TYPE']."]]></type>";
        $ResponseXML .= "<purType><![CDATA[".$row['po_type']."]]></purType>";
    }

    //	$sql="delete from tmp_purord_data where str_invno='".$_GET['invno']."' ";
    //$ResponseXML .= $sql;
    //	$result =$db->RunQuery($sql);
    //	$sql="select * from s_ordtrn where REFNO='".$_GET['invno']."' ";
    //$ResponseXML .= $sql;
    //	$result =$db->RunQuery($sql);
    //	while($row = mysql_fetch_array($result)){
    //		$sql1="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
    //		('".$row['REFNO']."', '".$row['STK_NO']."', '".$row['DESCRIPT']."', '".$row["partno"]."', ".$row["ORD_QTY"].") ";
    //$ResponseXML .= $sql;
    //		$result1 =$db->RunQuery($sql1);	
    //	}






    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Cost</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Tax</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
                            <td width=\"15\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"15\"  background=\"\"><font color=\"#FFFFFF\"></font></td>	
                            <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";

    $mcou = 0;
    $sql = "Select count(*) as mcou from s_ordtrn_1 where REFNO='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    $mcou = $row["mcou"] + 1;
    
    $i = 1;
    $total = 0;
    $sql = "Select * from s_ordtrn_1 where REFNO='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        
        $itemcode = "itemcode" . $i;
        $itemname = "itemname" . $i;
        $ord_qty = "ord_qty" . $i;
        $fob = "fob" . $i;
        $qty = "qty" . $i;
		$discount_a = "discount_a" . $i;
		$discount_b = "discount_b" . $i;
        $cost = "cost" . $i;
        $selling = "selling" . $i;
        $taxNum = "taxNum" . $i;
        $margin = "margin" . $i;
        $nbt = "nbt" . $i;
        $vat = "vat" . $i;	
        
        $subtotal = "subtotal" . $i;

        $sql_selling = "select * from s_rawmas where STK_NO='" . $row['STK_NO'] . "'";
        $result_selling = $db->RunQuery($sql_selling);
        $row_selling = mysql_fetch_array($result_selling);

		$descr= trim($row_selling['PART_NO'])  . " " . trim($row_selling['DESCRIPT'])  . " " . trim($row_selling['SUBSTITUTE']) .  " " . trim($row_selling['jobno']);
        $ResponseXML .= "<tr>                              
                             <td ><input type=\"text\" size=\"15\" name=" . $itemcode . " id=" . $itemcode . "   value=" . $row['STK_NO'] . " class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td ><input type=\"text\" size=\"15\" name=" . $itemname . " id=" . $itemname . "  value='" . $descr . "' class=\"text_purchase3\" disabled=\"disabled\"/></td>

							  <td ><input type=\"hidden\" size=\"15\" name=" . $ord_qty . " id=" . $ord_qty . "   class=\"text_purchase3\" disabled=\"disabled\"/></td>
							
							 <td ><input type=\"hidden\" size=\"15\" name=" . $fob . " id=" . $fob . "  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $qty . " id=" . $qty . " value=" . $row['ORD_QTY'] . " class=\"text_purchase3\" onkeyup=\"cal_subtot('" . $i . "', '" . $mcou . "');\" disabled=\"disabled\"/></td>
							 <td ><input type=\"hidden\" size=\"15\" name=" . $discount_a . " id=" . $discount_a . " value='0' class=\"text_purchase3\" onkeyup=\"cal_disc('" . $i . "', '" . $mcou . "');\"/></td>
							 <td ><input type=\"hidden\" size=\"15\" name=" . $discount_b . " id=" . $discount_b . " value='0' class=\"text_purchase3\" onkeyup=\"cal_disc('" . $i . "', '" . $mcou . "');\"/></td>
							 <td ><input type=\"text\" size=\"15\" name=" . $cost . " id=" . $cost . " value=0 class=\"text_purchase3\" onkeyup=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							 <td ><select size=\"5\" class=\"text_purchase3\" name=" . $taxNum . " id=" . $taxNum . " onchange=\"cal_subtot('" . $i . "', '" . $mcou . "');\">
                                                            <option value=\"0\" selected=\"selected\">NonVat</option>
                                                            <option value=\"1\">Vat</option>
                                                            <option value=\"2\">Svat</option>
                                                            <option value=\"3\">VatNbt</option>
                                                            <option value=\"4\">SvatNbt</option>
                                                            <option value=\"5\">NbtOnly</option>
                                                        </select></td>
							 <td ><input type=\"hidden\" size=\"15\" name=" . $selling . " id=" . $selling . " class=\"text_purchase3\" onkeyup=\"cal_margine('" . $i . "', '" . $mcou . "');\" value=" . $row_selling['SELLING'] . "  ></td>
							 <td ><input type=\"hidden\" size=\"15\" name=" . $margin . " id=" . $margin . "  class=\"text_purchase3\" disabled=\"disabled\"/></td>
							 <td ><input type=\"hidden\" size=\"15\" name=" . $nbt . " id=" . $nbt . " class=\"text_purchase3\"  disabled=\"disabled\" /></td>
							 <td ><input type=\"hidden\" size=\"15\" name=" . $vat . " id=" . $vat . "  class=\"text_purchase3\" disabled=\"disabled\"/></td>							 
							 <td ><input type=\"text\" size=\"15\" name=" . $subtotal . " id=" . $subtotal . " value=0 class=\"text_purchase3\" disabled=\"disabled\"/></td>
							</tr>";
        $i = $i + 1;
//        $total += $row['COST']*$row['REC_QTY'];
    }

    $ResponseXML .= "   </table>]]></sales_table>";
    $ResponseXML .= "<count><![CDATA[" . $i . "]]></count>";
    $ResponseXML .= "<total><![CDATA[0]]></total>";
    $ResponseXML .= "<stname><![CDATA[" . $stname . "]]></stname>";
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


    $sql = "delete from tmp_purord_data where str_code='" . $_GET['code'] . "' and str_invno='" . $_GET['invno'] . "' ";

    $result = $db->RunQuery($sql);

    $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                            </tr>";


    $sql = "Select * from tmp_purord_data where str_invno='" . $_GET['invno'] . "'";
    $result = $db->RunQuery($sql);
    while ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<tr>
                              
                             <td  >" . $row['str_code'] . "</a></td>
							 <td  >" . $row['str_description'] . "</a></td>
							 <td  >" . $row['partno'] . "</a></td>
							 <td  >" . $row['qty'] . "</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=" . $row['str_code'] . "  name=" . $row['str_code'] . " onClick=\"del_item('" . $row['str_code'] . "');\"></td></tr>";
    }

    $ResponseXML .= "   </table>]]></sales_table>";

    $ResponseXML .= " </salesdetails>";


    //	}	


    echo $ResponseXML;
}

if ($_GET["Command"] == "approve_item") {
    include('connection.php');
    $refNo = $_GET["invno"];

    $sql = "select * from s_ordmas where REFNO='" . $refNo . "' and app_by = ''";
            $result=mysql_query($sql, $dbinv);
//            exit($sql);
    if ($row = mysql_fetch_array($result)) {
        $sql = "update s_ordmas set app_by='" . $_SESSION["CURRENT_USER"] . "', cancel = '0' where REFNO='" . $refNo . "'";
        $result=mysql_query($sql, $dbinv);
        $sql = "update s_ordtrn set CANCEL = '0' where REFNO='" . $refNo . "'";
        $result=mysql_query($sql, $dbinv);
        echo "Purchase Order Approved";
    } else {
        echo "Invalid Purchase Order or already approved!";
    }
}

if ($_POST["Command"] == "save_item") {
    require_once './gl_posting.php';
    if ($_SESSION['dev'] == "") {
        exit("logout");
    }
	
	include('connection.php');
	
	$sql_status=0;
			
	mysql_query("SET AUTOCOMMIT=0", $dbinv);
	mysql_query("START TRANSACTION", $dbinv);
        
			
	$supplier_name=str_replace("~", "&", $_POST["supplier_name"]);
	
    if ($_POST["count"] > 0) {

//        $sql_invpara = "SELECT * from invpara where COMCODE='" . $_SESSION['company'] . "'";
        $sql_invpara = "SELECT * from invpara";
		$result_invpara=mysql_query($sql_invpara, $dbinv);
        $row_invpara = mysql_fetch_array($result_invpara);

        $vatrate = $row_invpara["vatrate"];
        $nbtrate = $row_invpara["nbt"];

        $ResponseXML .= "";
        $ResponseXML .= "<salesdetails>";

        $_SESSION["CURRENT_DOC"] = 1;      //document ID
        $_SESSION["VIEW_DOC"] = false;     //view current document
        $_SESSION["FEED_DOC"] = true;       //save  current document
        $_POST["MOD_DOC"] = false;         //delete   current document
        $_POST["PRINT_DOC"] = false;       //get additional print   of  current document
        $_POST["PRICE_EDIT"] = false;       //edit selling price
        $_POST["CHECK_USER"] = false;       //check user permission again
        //$cre_balance=str_replace(",", "", $_GET["balance"]);

        $refNo = $_POST["purType"]."/".$_POST["type"]."/".$_POST["invno"];

        $sql = "select * from s_ordmas where REFNO='" . $refNo . "'";
		$result=mysql_query($sql, $dbinv);
      
        //echo $sql;
        if ($row = mysql_fetch_array($result)) {
            exit("Order Already Exists");
        } else {
            
            $sql1="select * from s_salrep where REPCODE='".$_POST["salesrep"]."'";
            $result1 =mysqli_query($GLOBALS['dbinv'],$sql1) ; 
            $row1 = mysqli_fetch_array($result1);
            $rep_name=$row1["Name"];
            
//            $sql1 = "insert into c_bal(REFNO, SDATE, CUSCODE, AMOUNT, BALANCE, DEP, SAL_EX, Cancell, brand, DEV, trn_type, vatrate, old, flag1, active, totpay, VAT, btt, VAT_VAL, SVAT, btt_rate) values ('" . $refNo . "', '" . $_POST["invdate"] . "', '" . $_POST["supplier_code"] . "', '" . $mgrand_tot . "', '" . $mgrand_tot . "', '" . $_POST["department"] . "', '" . $_POST["salesrep"] . "', '0', '" . $_POST["brand"] . "', '" . $_SESSION['dev'] . "', 'ARN', '" . $vatrate . "', '0', 0, 1, 0, '$vatType', $nbt, $mtot1, $svatValue, '".$row['nbt']."')";
            //tmp_no removed
            $sql1="insert into s_ordmas(REFNO, SDATE, SUP_CODE, SUP_NAME, REMARK, DEP_CODE, REP_CODE, REP_NAME, cancel, S_date, LC_No, pi_no, Brand, REQNO, type1, TYPE, net_tot, g_tot, nbt_val, vat_val, user, vatrate, btt_rate) values ('".$refNo."', '".$_POST["invdate"]."', '".$_POST["supplier_code"]."','".$_POST["supplier_name"]."','".$_POST["textarea"]."','".$_POST["department"]."','".$_POST["salesrep"]."','".$rep_name."', '2','".$_POST["dte_shedule"]."','".$_POST["lc_no"]."', '".$_POST["pi_no"]."', '".$_POST["brand"]."', '".$_POST["orderno1"]."', '".$_POST["type"]."', '".$_POST["purType"]."', '".$_POST["net_value"]."', '".$_POST["total_value"]."', '".$_POST["total_nbt"]."', '".$_POST["total_vat"]."', '".$_SESSION["CURRENT_USER"]."', '" . $vatrate . "', '" . $nbtrate . "')";
            //echo $sql1;
           $result1=mysql_query($sql1, $dbinv);
		   if ($result1==false){ $sql_status=1; }

        }
        
        
        $i = 1;
        //echo $_POST["count"];
        while ($i < $_POST["count"]) {

            $itemcode_name = "itemcode" . $i;
            $itemname_name = "itemname" . $i;
            $ord_qty_name = "ord_qty" . $i;
            $fob_name = "fob" . $i;
            $qty_name = "qty" . $i;
            $discount_a_name = "discount_a" . $i;
            $discount_b_name = "discount_b" . $i;
            $cost_name = "cost" . $i;
            $taxNum = "taxNum" . $i;
            $selling_name = "selling" . $i;
            $margin_name = "margin" + $i;
            $subtotal_name = "subtotal" . $i;

            $QTYINHAND = 0;
            $cost = 0;
            $acc_cost = 0;
            $acc_cost_c = 0;
            $m_qty = 0;
            $m_totval = 0;
            $COST_mas = 0;

            if ($_POST[$qty_name] > 0) {
                
                //tmp no, partno removed
                $sql4="insert into s_ordtrn(REFNO, SDATE, STK_NO, DESCRIPT, ORD_QTY, CANCEL, RATE, tax, sub_tot) values ('".$refNo."', '".$_POST["invdate"]."', '".$_POST["$itemcode_name"]."','".$_POST["$itemname_name"]."','".$_POST["$qty_name"]."','2','".$_POST["$cost_name"]."','".$_POST["$taxNum"]."','".$_POST["$subtotal_name"]."')";

// echo $sql1;
			   	$result1=mysql_query($sql4, $dbinv);
				if ($result1==false){ $sql_status=4; }
                                //echo $sql4;
//                                die();
               
            }

            $i = $i + 1;
        }

        if ($sql_status==0){

            $sql1 = "update s_ordmas_1 set cancel='1' where REFNO='" . $_POST["orderno1"] . "'";
            $result1=mysql_query($sql1, $dbinv);
            $sql1 = "update s_ordtrn_1 set CANCEL='1' where REFNO='" . $_POST["orderno1"] . "'";
            $result1=mysql_query($sql1, $dbinv);

            //$sql1 = "update invpara set ARN=ARN+1 where COMCODE='" . $_SESSION['company'] . "'";
            $sql1 = "update invpara set ORD_NO=ORD_NO+1";
                    $result1=mysql_query($sql1, $dbinv);
            mysql_query("COMMIT", $dbinv);
        echo "Saved";
        } else {
                mysql_query("ROLLBACK", $dbinv);
                echo "no $sql_status $sql1";
        }	
    } else {
        echo "no";
    }
}


if ($_GET["Command"] == "pass_arnno") {
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_purmas where REFNO='" . $_GET['arnno'] . "'";
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row["REFNO"] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row["SDATE"] . "]]></SDATE>";
        $ResponseXML .= "<ORDNO><![CDATA[" . $row["ORDNO"] . "]]></ORDNO>";
        $ResponseXML .= "<LCNO><![CDATA[" . $row["LCNO"] . "]]></LCNO>";
        $ResponseXML .= "<pi_no><![CDATA[" . $row["pi_no"] . "]]></pi_no>";
        $ResponseXML .= "<COUNTRY><![CDATA[" . $row["COUNTRY"] . "]]></COUNTRY>";
        $ResponseXML .= "<SUP_CODE><![CDATA[" . $row["SUP_CODE"] . "]]></SUP_CODE>";
        $ResponseXML .= "<SUP_NAME><![CDATA[" . $row["SUP_NAME"] . "]]></SUP_NAME>";
        $ResponseXML .= "<REMARK><![CDATA[" . $row["REMARK"] . "]]></REMARK>";
        $ResponseXML .= "<DEPARTMENT><![CDATA[" . $row["DEPARTMENT"] . "]]></DEPARTMENT>";
        $ResponseXML .= "<AMOUNT><![CDATA[" . $row["AMOUNT"] . "]]></AMOUNT>";
        $ResponseXML .= "<PUR_DATE><![CDATA[" . $row["PUR_DATE"] . "]]></PUR_DATE>";
        $ResponseXML .= "<brand><![CDATA[" . $row["brand"] . "]]></brand>";
        $ResponseXML .= "<TYPE><![CDATA[" . $row["TYPE"] . "]]></TYPE>";
        $ResponseXML .= "<type1><![CDATA[" . $row["type1"] . "]]></type1>";

        $ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\"></font></td>
								 <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";

        $mcou = 0;
        $sql = "Select count(*) as mcou from s_purtrn where REFNO='" . $_GET['arnno'] . "'";
        $result = $db->RunQuery($sql);
        $row = mysql_fetch_array($result);
        $mcou = $row["mcou"] + 1;

        $i = 1;
        $tot = 0;
        $sql = "Select * from s_purtrn where REFNO='" . $_GET['arnno'] . "'";
        $result = $db->RunQuery($sql);
        while ($row = mysql_fetch_array($result)) {

            $itemcode = "itemcode" . $i;
            $itemname = "itemname" . $i;
            $ord_qty = "ord_qty" . $i;
            $fob = "fob" . $i;
            $qty = "qty" . $i;
			$discount_a = "discount_a" . $i;
			$discount_b = "discount_b" . $i;
            $cost = "cost" . $i;
            $selling = "selling" . $i;
            $margin = "margin" . $i;
            $subtotal = "subtotal" . $i;
			
			if (($row['REC_QTY'] > 0) and ( $row['acc_cost'] > 0) ) {
                $stot = $row['REC_QTY'] * $row['acc_cost'];
				if ($row['SELLING'] > 0){
                	$margine_val = ($row['SELLING'] - $row['acc_cost']) / $row['acc_cost'] * 100;
				} else {
					$margine_val ="";	
				}	
            } else {
                $stot = "";
                $margine_val = "";
            }
			
           

            $ResponseXML .= "<tr>                              
                             <td  ><input type=\"text\" size=\"15\" name=" . $itemcode . " id=" . $itemcode . "   value='" . $row['STK_NO'] . "' class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td  ><input type=\"text\" size=\"15\" name=" . $itemname . " id=" . $itemname . "  value='" . $row['DESCRIPT'] . "' class=\"text_purchase3\" disabled=\"disabled\"/></td>
							  <td  ><input type=\"hidden\" size=\"15\" name=" . $ord_qty . " id=" . $ord_qty . "  value='" . $row['O_QTY'] . "' class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							
							 <td  ><input type=\"hidden\" size=\"15\" name=" . $fob . " id=" . $fob . " value='" . $row['FOB'] . "'  class=\"text_purchase3\"/></td>
							 <td  ><input type=\"text\" size=\"15\" name=" . $qty . " id=" . $qty . " value='" . $row['REC_QTY'] . "'  class=\"text_purchase3_right\" onkeyup=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							  <td  ><input type=\"hidden\" size=\"15\" name=" . $discount_a . " id=" . $discount_a . " value='" . $row['DISCOUNT'] . "'  class=\"text_purchase3_right\" onkeyup=\"cal_disc('" . $i . "', '" . $mcou . "');\"/></td>
							   <td  ><input type=\"hidden\" size=\"15\" name=" . $discount_b . " id=" . $discount_b . " value='" . $row['DISCOUNT2'] . "'  class=\"text_purchase3_right\" onkeyup=\"cal_disc('" . $i . "', '" . $mcou . "');\"/></td>
							 <td  ><input type=\"text\" size=\"15\" name=" . $cost . " id=" . $cost . " value='" . $row['acc_cost'] . "'  class=\"text_purchase3_right\" onkeyup=\"cal_subtot('" . $i . "', '" . $mcou . "');\"/></td>
							 <td  ><input type=\"hidden\" size=\"15\" name=" . $selling . " id=" . $selling . " value='" . $row['SELLING'] . "'  class=\"text_purchase3_right\"/></td>
							 <td  ><input type=\"hidden\" size=\"15\" name=" . $margin . " id=" . $margin . " value='" . $margine_val . "'  class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							 <td  ><input type=\"text\" size=\"15\" name=" . $subtotal . " id=" . $subtotal . " value='" . $stot . "'  class=\"text_purchase3_right\" disabled=\"disabled\"/></td>
							</tr>";
            //$tot=$tot+($row['COST']*$row['REC_QTY']);
            $subtot = $subtot + $stot;
            $i = $i + 1;
        }

        $ResponseXML .= "</table>]]></sales_table>";
        $ResponseXML .= "<tot><![CDATA[" . $tot . "]]></tot>";
        $ResponseXML .= "<subtot><![CDATA[" . number_format($subtot, 2, ".", ",") . "]]></subtot>";
        $ResponseXML .= "<count><![CDATA[" . $i . "]]></count>";
    }



    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}

if ($_GET["Command"] == "pass_arnno_gin") {
    header('Content-Type: text/xml');
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $sql = "Select * from s_purmas where REFNO='" . $_GET['arnno'] . "'";
    $result = $db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
        $ResponseXML .= "<REFNO><![CDATA[" . $row["REFNO"] . "]]></REFNO>";
        $ResponseXML .= "<SDATE><![CDATA[" . $row["SDATE"] . "]]></SDATE>";
    }
    $ResponseXML .= "</salesdetails>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "cancel_inv") {

    $sql = "select * from s_purmas where CANCEL='0' order by id desc";
    $result = $db->RunQuery($sql);
    $row = mysql_fetch_array($result);
    //echo $sql;
    //if ($row["REFNO"]!=$_GET["invno"]){
    //	echo "You Can't cancel this record without cancel last records ";
    //} else {	
    $sql1 = "update s_purmas set CANCEL='1' where REFNO='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "update s_purtrn set CANCEL='1' where REFNO='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "update s_purmas_tmp set cancel='0' where REFNO='" . $_GET["orderno1"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "update s_purtrn_tmp set CANCEL='0' where REFNO='" . $_GET["orderno1"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "delete from s_trn  where REFNO='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "delete from s_trn_all  where REFNO='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "delete from c_bal where REFNO='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql1 = "delete from s_sttr_all where ST_REFNO='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);

    $sql="DELETE from ledger WHERE l_refno='" . $_GET["invno"] . "'";
    $result1 = $db->RunQuery($sql1);
    
    $sql1 = "select * from s_purtrn where REFNO='" . $_GET["invno"] . "'";

    $result1 = $db->RunQuery($sql1);
    while ($row1 = mysql_fetch_array($result1)) {

        $sql2 = "update s_rawmas set COST=" . $row1["Cost_c"] . ", acc_cost=" . $row1["acc_cost_c"] . " where STK_NO='" . $row1["STK_NO"] . "'";
        $result2 = $db->RunQuery($sql2);

        $sql2 = "update s_submas set QTYINHAND=QTYINHAND-" . $row1["REC_QTY"] . " where STK_NO='" . $row1["STK_NO"] . "' and STO_CODE='" . $_GET["department"] . "'";

        $result2 = $db->RunQuery($sql2);

        $sql2 = "update s_rawmas set QTYINHAND=QTYINHAND-" . $row1["REC_QTY"] . " where STK_NO='" . $row1["STK_NO"] . "'";
        $result2 = $db->RunQuery($sql2);
    }

    echo "Canceled!";
    //}
}

if ($_GET["Command"] == "check_print") {

    echo $_SESSION["print"];
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
        If (is_null($row["CAT"]) == false) {
            $cat = trim($row["CAT"]);
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