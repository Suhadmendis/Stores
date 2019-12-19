<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	
		date_default_timezone_set('Asia/Colombo'); 
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		if($_GET["Command"]=="add_address")
		{
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;
			
			
	/*		$sql="Select * from tmp_army_no where edu= '".$_GET['edu']."'";
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "exist";
				
				
				
			}	else {*/
			
		//	$ResponseXML .= "";
			//$ResponseXML .= "<ArmyDetails>";
			
		/*	$sql1="Select * from mas_educational_qualifications where str_Educational_Qualification= '".$_GET['edu']."'";
			$result1 =$db->RunQuery($sql1);
			$row1 = mysql_fetch_array($result1);
			$ResponseXML .=  $row1["int_Educational_Qulifications"];*/
			
			$sqlt="Select * from customer_mast where id ='".$_GET['customerid']."'";
			
			$resultt =$db->RunQuery($sqlt);
			if ($rowt = mysql_fetch_array($resultt)){
				echo $rowt["str_address"];
			}
			
			
				
			
	}
	
	
	
 if ($_GET["Command"]=="chk_number"){
 	$sql="select * from vendor where CODE = '".trim($_GET["txt_cuscode"])."'";
	$result =$db->RunQuery($sql);
	if($row = mysql_fetch_array($result)){
		echo "included";
	} else { 
		echo "no";
	}
 }
 
 		
if($_GET["Command"]=="new_inv")
{

	
	if ($_SESSION["dev"]==""){
		exit("no");
	}		
			$_SESSION["print"]=0;
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
			
			
			//echo $_GET["chk_crenote"];
			if ($_GET["chk_crenote"]=="true"){
				$sql="Select debnoteno from invpara";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				$tmpinvno="0000000".$row["debnoteno"];
				$lenth=strlen($tmpinvno);
				$invno=trim("DEB/ ").substr($tmpinvno, $lenth-8);
			} else {
				$sql="Select CHE_RET from invpara where COMCODE = '" .$_SESSION['COMCODE']. "'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);
				$tmpinvno="0000000".$row["CHE_RET"];
				$lenth=strlen($tmpinvno);
			
				$invno=trim("RCH/ ").substr($tmpinvno, $lenth-8);
                                
                                if ($_SESSION['COMCODE']=="A"){
                                        $invno=trim("ARCH/ ").substr($tmpinvno, $lenth-8);
                                }else if ($_SESSION['COMCODE']=="B"){
                                        $invno=trim("BRCH/ ").substr($tmpinvno, $lenth-8);
                                }else if ($_SESSION['COMCODE']=="R"){
                                        $invno=trim("RRCH/ ").substr($tmpinvno, $lenth-8);
                                } else {
                                        $invno=trim("RCH/ ").substr($tmpinvno, $lenth-8);
                                }
                                
			}	
			$_SESSION["invno"]=$invno;
			
			//echo ("okkkkkkkkkkkkkk");
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<invno><![CDATA[".$invno."]]></invno>";
			$ResponseXML .= "<curdate><![CDATA[".date("Y-m-d")."]]></curdate>";
			$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
			
			
		}
	
	
	if($_GET["Command"]=="cancel_inv")
	{
		include('connection.php');
		
		$sql_status=0;
		
		mysql_query("SET AUTOCOMMIT=0", $dbinv);	 
		mysql_query("START TRANSACTION", $dbinv);	 	
		
	$sql_rscheque="Select * from s_cheq where CR_REFNO='".trim($_GET["lblReciptNo"])."' and PAID=0";
	$result_rscheque=mysql_query($sql_rscheque, $dbinv);
	if($row_rscheque = mysql_fetch_array($result_rscheque)){
 		
		$sql_strsqlstr="update s_cheq set CR_FLAG='c' where CR_REFNO='".trim($_GET["lblReciptNo"])."'";
		$result_strsqlstr=mysql_query($sql_strsqlstr, $dbinv);
		if ($result_strsqlstr!=1){ $sql_status=1; }
		
		$sql="delete  from s_led where REF_NO='".$_GET["lblReciptNo"]."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
	
		$sql="delete  from ledger where l_refno='" . trim($_GET["lblReciptNo"]) . "' and chno='".$_GET["txtChequeNo"]."'";
		//echo $sql;
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
	
	
		$sql="update s_invcheq set ch_count_ret= '0' where cheque_no = '".trim($_GET["txtChequeNo"])."' and cus_code = '".trim($_GET["Txtcusco"])."' and bank = '".trim($_GET["cmbBankname"])."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
	
		if ($sql_status==0){
			mysql_query("COMMIT", $dbinv);
			echo "Deleted";	
		}	else {
			mysql_query("ROLLBACK", $dbinv);
			echo "Error has occured. Can't Delete";
		}	
		
	}else {	
		echo "Not Exist";
	}
}	
	
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_inv_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_inv_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.") ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_inv_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td >".$row['str_code']."</a></td>
							 <td >".$row['str_description']."</a></td>
							 <td >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connection.php");
						
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$department."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td >".$qty."</a></td>
							 
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
		$_SESSION["department"]=$_GET["department"];
		
		
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				$salesrep=$_GET["salesrep"];
				$brand=$_GET["brand"];
					
			//		$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
	    //Call SETLIMIT ====================================================================
		
		
		
	/*	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());*/

	$OutpDAMT = 0;
	$OutREtAmt = 0;
	$OutInvAmt = 0;
	$InvClass="";
	
	$sqlclass = mysql_query("select class from brand_mas where barnd_name='".trim($brand)."'") or die(mysql_error());
	if ($rowclass = mysql_fetch_array($sqlclass)){
		if (is_null($rowclass["class"])==false){
			$InvClass=$rowclass["class"];
		}
	}
	
	$sqloutinv = mysql_query("select sum(GRAND_TOT-TOTPAY) as totout from view_s_salma where GRAND_TOT>TOTPAY and CANCELL='0' and C_CODE='".trim($cuscode)."' and SAL_EX='".trim($salesrep)."' and class='".$InvClass."'") or die(mysql_error());
	if ($rowoutinv = mysql_fetch_array($sqloutinv)){
		if (is_null($rowoutinv["totout"])==false){
			$OutInvAmt=$rowoutinv["totout"];
		}
	}

$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($salesrep)."'") or die(mysql_error());
	while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
		
		$sqlsttr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"]) ."'") or die(mysql_error());
		while($rowsttr = mysql_fetch_array($sqlsttr)){
			$sqlview_s_salma = mysql_query("select class from view_s_salma where REF_NO='".trim($rowsttr["ST_INVONO"])."'") or die(mysql_error());
			if($rowview_s_salma = mysql_fetch_array($sqlview_s_salma)){
				
				if (trim($rowview_s_salma["class"]) == $InvClass){
                    $OutpDAMT = $OutpDAMT + $rowsttr["ST_PAID"];
                }
			}
		}
	}


        
        $pend_ret_set = 0;
		
		$sqlinvcheq = mysql_query("SELECT sum(che_amount) as  che_amount FROM s_invcheq WHERE che_date >'".date("d-m-Y")."' AND cus_code='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
		if($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
			if (is_null($rowinvcheq["che_amount"])==false){
				$pend_ret_set=$rowinvcheq["che_amount"];
			}
		}
		
		
		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-PAID) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".trim($salesrep)."'") or die(mysql_error());
		if($rowcheq = mysql_fetch_array($sqlcheq)){
			if (is_null($rowcheq["tot"])==false){
				$OutREtAmt=$rowcheq["tot"];
			} else {
				$OutREtAmt=0;
			}
		}
		
            
 

						 
   $ResponseXML .= "<sales_table_acc><![CDATA[ <table  border=0  cellspacing=0>
						<tr><td><input type=\"text\"  class=\"label_purchase\" value=\"Outstanding Invoice Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Return Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutREtAmt, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Pending Cheque Amount\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutpDAMT, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"PSD Cheque Settlments\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 <td><input type=\"text\"  class=\"label_purchase\" value=\"Total\" disabled=\"disabled\"/></td><td><input type=\"text\"  class=\"label_purchase\" value=\"".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."\" disabled=\"disabled\"/></td></tr>
						 </table></table>]]></sales_table_acc>";
						 
						  
						      

      $sqlbr_trn = mysql_query("select * from br_trn where Rep='".trim($salesrep)."' and brand='".trim($InvClass)."' and cus_code='" .trim($cuscode)."'") or die(mysql_error());  
	if($rowbr_trn = mysql_fetch_array($sqlbr_trn)){
		if(is_null($rowbr_trn["credit_lim"]) == false){
			$crLmt=$rowbr_trn["credit_lim"];
		} else {	
			$crLmt=0;		
		}
	
		
		if(is_null($rowbr_trn["tmpLmt"]) == false){
			$tmpLmt=$rowbr_trn["tmpLmt"];
		} else {	
			$tmpLmt=0;		
		}
		
		if (is_null($rowbr_trn["CAT"])==false) {
			$cuscat = trim($rowbr_trn["cat"]);
            if ($cuscat = "A"){ $m = 2.5; }
            if ($cuscat = "B"){ $m = 2.5; }
            if ($cuscat = "C"){ $m = 1; }
            $txt_crelimi = "0";
            $txt_crebal = "0";
            $txt_crelimi = number_format($crLmt, 2, ".", ",");
			//$crebal=$crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
			$txt_crebal = $crLmt * $m - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            $crebal = $crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set;
            //$txt_crebal = number_format($crebal, "2", ".", ",");
          } else {
            $txt_crelimi = "0";
            $txt_crebal = "0";
          }
         $creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;

	   			
			
			 
    }    
			$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
			$ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
          
         	 $ResponseXML .= "<creditbalance><![CDATA[".number_format($txt_crebal, "2", ".", ",")."]]></creditbalance>";

		

		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML;
				
				
	
	
	}

		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_inv_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			
			$result =$db->RunQuery($sql);
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Rate</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Discount</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sub Total</font></td>
							   <td></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Qty In Hand</font></td>
                            </tr>";
							
			
			$sql="Select * from tmp_inv_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td >".$row['str_code']."</a></td>
							 <td>".$row['str_description']."</a></td>
							 <td >".$row['cur_rate']."</a></td>
							 <td  >".$row['cur_qty']."</a></td>
							 <td  >".$row['cur_discount']."</a></td>
							 <td  >".$row['cur_subtot']."</a></td>
							 <td  ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 include_once("connection.php");
							
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td  >".$qty."</a></td>
                            </tr>";
				}			
				
				$ResponseXML .= "   </table>]]></sales_table>";
				 
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_inv_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$vatrate=0.12;
				
				if ($_GET["vatmethod"]=="vat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (VAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="svat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (SVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="evat"){
					$tax=$row['tot_sub']*$vatrate;
					$taxf=number_format($tax, 2, ".", ",");
					
					$ResponseXML .= "<tax><![CDATA[".$taxf."]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax (EVAT 12%)]]></taxname>";
					
					$invtot=number_format($row['tot_sub']+$tax, 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
					
				} else if ($_GET["vatmethod"]=="non"){
					//$tax=number_format($row['tot_sub']*$vatrate, 2, ".", ",");
					$ResponseXML .= "<tax><![CDATA[0.00]]></tax>";
					$ResponseXML .= "<taxname><![CDATA[Tax]]></taxname>";
					
					$invtot=number_format($row['tot_sub'], 2, ".", ",");
					$ResponseXML .= "<invtot><![CDATA[".$invtot."]]></invtot>";
				}
							
                $ResponseXML .= " </salesdetails>";
				
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	if ($_SESSION["dev"]==""){
		exit("no");
	}
	include('connection.php');
	
	$sqltmp="select * from invpara";
		$resulttmp=mysql_query($sqltmp, $dbinv);
		$rowtmp = mysql_fetch_array($resulttmp);
	
		if ($rowtmp["form_loc"]=="1"){
  			exit("no");
  		}			
			$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again


 $sql_status=0;
		
 mysql_query("SET AUTOCOMMIT=0", $dbinv);	 
 mysql_query("START TRANSACTION", $dbinv);
 
	$sql_strsqlstr="Select * from vendor where CODE='".trim($_GET["Txtcusco"])."'";
	$result_strsqlstr=mysql_query($sql_strsqlstr, $dbinv);
	if($row_strsqlstr = mysql_fetch_array($result_strsqlstr)){

	} else {
		exit("Invalid Customer");
	}	
	
	
	
	$sql_rscheque="Select CR_CHNO from s_cheq where CR_CHNO='".trim($_GET["txtChequeNo"])."' AND CR_CHNO='0'";
	
	$result_rscheque=mysql_query($sql_rscheque, $dbinv);
	if($row_rscheque = mysql_fetch_array($result_rscheque)){
 		if ($_GET["txt_stat"]=="NEW"){
			exit("Cheque No Already Entered");
		}
	}
	
	$sql_rscheque="Select * from s_cheq where CR_REFNO='".trim($_GET["lblReciptNo"])."'";
	$result_rscheque=mysql_query($sql_rscheque, $dbinv);
	if ($row_rscheque = mysql_fetch_array($result_rscheque)){
		$m_oldval = $row_rscheque["CR_CHEVAL"];
		$PAID = $row_rscheque["PAID"];
		
	} else {
		$sql="update invpara set CHE_RET=CHE_RET+1 where COMCODE = '" .$_SESSION['COMCODE']. "'";
		$result=mysql_query($sql, $dbinv);
		if ($result==false){ $sql_status=1; }	
	}	
	
	//if ($_GET["txt_stat"]=="EDIT"){	
	//	$sql_strsqlstr="delete from s_cheq where CR_REFNO='".trim($_GET["lblReciptNo"])."'";
	//	$result_strsqlstr=mysql_query($sql_strsqlstr, $dbinv);
		
	//}	
	
	if ($_GET["op_computer"]=="true"){
		$dev=0;
	} else {
		$dev=1;
	}
	if ($_GET["chk_crenote"]=="true"){
		$chk_crenote=1;
	} else {
		$chk_crenote=0;
	}
	$lblnoof=$_GET["lblnoof"]+1;
	
	//if (($PAID=="") or ($PAID==0)){
	$sql_rscheque1="Select * from s_cheq where CR_REFNO='".trim($_GET["lblReciptNo"])."'";
	//echo $sql_rscheque1;
	$result_rscheque1=mysql_query($sql_rscheque1, $dbinv);
	if ($row_rscheque1 = mysql_fetch_array($result_rscheque1)){
		$sql_rscheque="update s_cheq set depobank='".$_GET["cheq_dpo_bank"]."', REMARK='".$_GET["txtremark"]."', reason='".$_GET["reason"]."' where CR_REFNO='".$_GET["lblReciptNo"]."'";
//echo $sql_rscheque;
		$result_rscheque=mysql_query($sql_rscheque, $dbinv);
		if ($result_rscheque!=1){ $sql_status=1; }	
		
	} else {
		$sql_rscheque="insert into s_cheq (CR_REFNO, CR_DATE, CR_C_CODE, CR_C_NAME, CR_REPAY, CR_BANK, REMARK, reason, CR_CHEVAL, CR_CHNO, DEPARTMENT, S_REF, CR_CHDATE, DEBACC, depobank, ret_chno, ret_chdate, noof, ret_refno, tmp, FORwhat, crenoteno, crenoteamo, dev, debnoteno, CR_REPOSIT, CR_FLAG, PAID, CR_CRVAL, company) values ('".$_GET["lblReciptNo"]."', '".$_GET["DTPicker1"]."', '".$_GET["Txtcusco"]."', '".$_GET["txtcusname"]."', '".$_GET["txtRetChCha"]."', '".$_GET["cmbBankname"]."', '".$_GET["txtremark"]."', '".$_GET["reason"]."', '".$_GET["txtChequeAmount"]."', '".$_GET["txtChequeNo"]."', '".$_GET["com_dep"]."', '".$_GET["com_rep"]."', '".$_GET["DTPicker2"]."', '".$_GET["Txtacco"]."', '".$_GET["cheq_dpo_bank"]."', '".$_GET["lblRET_chno"]."', '".$_GET["lblretdate"]."', '".$lblnoof."', '".$_GET["lblretrefno"]."', '0', '".$_GET["txtforwhat"]."', '".$_GET["txtcrenoteno"]."', '".$_GET["txtcrenoteamo"]."', '".$dev."', '".$chk_crenote."', 1, '0', 0, 0,'" .$_SESSION['COMCODE']. "')";
//echo $sql_rscheque;
	
		$result_rscheque=mysql_query($sql_rscheque, $dbinv);
		if ($result_rscheque!=1){ $sql_status=1; }	
		
	}	

$sql_rscheque="insert into s_cheq_tmp (CR_REFNO, CR_DATE, CR_C_CODE, CR_C_NAME, CR_REPAY, CR_BANK, REMARK, reason, CR_CHEVAL, CR_CHNO, DEPARTMENT, S_REF, CR_CHDATE, DEBACC, depobank, ret_chno, ret_chdate, noof, ret_refno, tmp, FORwhat, crenoteno, crenoteamo, dev, debnoteno, CR_REPOSIT, CR_FLAG, PAID, CR_CRVAL, updated) values ('".$_GET["lblReciptNo"]."', '".$_GET["DTPicker1"]."', '".$_GET["Txtcusco"]."', '".$_GET["txtcusname"]."', '".$_GET["txtRetChCha"]."', '".$_GET["cmbBankname"]."', '".$_GET["txtremark"]."', '".$_GET["reason"]."', '".$_GET["txtChequeAmount"]."', '".$_GET["txtChequeNo"]."', '".$_GET["com_dep"]."', '".$_GET["com_rep"]."', '".$_GET["DTPicker2"]."', '".$_GET["Txtacco"]."', '".$_GET["cheq_dpo_bank"]."', '".$_GET["lblRET_chno"]."', '".$_GET["lblretdate"]."', '".$lblnoof."', '".$_GET["lblretrefno"]."', '0', '".$_GET["txtforwhat"]."', '".$_GET["txtcrenoteno"]."', '".$_GET["txtcrenoteamo"]."', '".$dev."', '".$chk_crenote."', 1, '0', 0, 0, '0')";
//echo $sql_rscheque;
	
	$result_rscheque=mysql_query($sql_rscheque, $dbinv);
	if ($result_rscheque!=1){ $sql_status=1; }	

///////////////////////////////////	
   
	/*if ($_GET["txt_stat"]=="NEW"){
      // echo $_GET["chk_crenote"];
       if ($_GET["chk_crenote"]== "true") {
	   // echo $sql;
          	$sql="update invpara set debnoteno=debnoteno+1";
			$result=mysql_query($sql, $dbinv);
			
       } else {
          $sql="update invpara set CHE_RET=CHE_RET+1";
		  $result=mysql_query($sql, $dbinv);
		
       }
      
      
	
	}*/
////////////////////////////////////////////////////		

	$sql="delete  from s_led where REF_NO='".$_GET["lblReciptNo"]."'";
	$result=mysql_query($sql, $dbinv);
	if ($result!=1){ $sql_status=1; }	
	
	
    $m_flag = "RCH";
	
	$sql="Insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT) values ('".trim($_GET["lblReciptNo"])."', '".$_GET["DTPicker1"]."','".trim($_GET["Txtcusco"])."', ".$_GET["txtChequeAmount"].", '".$m_flag."','".trim($_GET["com_dep"])."')";
	$result=mysql_query($sql, $dbinv);
	if ($result!=1){ $sql_status=1; }	
	
	
	
	$mNara="RETURN CHEQUE - ".$_GET["txtChequeNo"];
	
	$sql="delete  from ledger where l_refno='" . trim($_GET["lblReciptNo"]) . "' and chno='".$_GET["txtChequeNo"]."'";
	$result=mysql_query($sql, $dbinv);
	if ($result!=1){ $sql_status=1; }	
        
        require_once './gl_posting.php';
        $ldate = $_GET["bank_st_date"];
        $ayear = ac_year($ldate);
	
        $sql1="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem,  l_flag2, l_flag3, comcode, l_yearfl, recdate, l_year, chno, c_remarks, acyear) Values ('" . trim($_GET["lblReciptNo"]) . "', '".$_GET["bank_st_date"]."', '" . trim($_GET["accno"]) . "', " . $_GET["txtChequeAmount"] . ", 'RTN', 'DEB', '" . $mNara . "', '0', 'R', '" . $_SESSION['company'] . "', 0, '0', '$ayear', '".$_GET["txtChequeNo"]."','".trim($_GET["Txtcusco"])."', '$ayear')";
        //echo $sql1;
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=1; }	
	
	$sql1="Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem,  l_flag2, l_flag3, comcode, l_yearfl, recdate, l_year, chno, c_remarks, acyear) Values ('" . trim($_GET["lblReciptNo"]) . "', '".$_GET["bank_st_date"]."', '" . trim($_GET["cheq_dpo_bank"]) . "', " . $_GET["txtChequeAmount"] . ", 'RTN', 'CRE', '" . $mNara . "', '0', 'R', '" . $_SESSION['company'] . "', 0, '0', '$ayear', '".$_GET["txtChequeNo"]."','".trim($_GET["Txtcusco"])."', '$ayear')";
        //echo $sql1;
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=1; }					
   
	
	$a=1;
	while ($_GET["mcount"]>$a){
		$REF_NO="REF_NO_".$a;
		$SDATE="SDATE_".$a;
		$GRAND_TOT="GRAND_TOT_".$a;
		$st_amou="st_amou_".$a;
		
    	if (trim($_GET[$REF_NO]) != "") {
			$sql_strsqlstr="delete from ret_chq_history where Ref_no='".trim($_GET[$REF_NO])."' and chk_no='".$_GET[txtChequeNo]."'";
			$result_strsqlstr=mysql_query($sql_strsqlstr, $dbinv);
			if ($result_strsqlstr!=1){ $sql_status=1; }					
			
         	$sql_chq = "insert into ret_chq_history (Ref_no, Inv_no, Inv_date, inv_Amt, st_amt, chk_no) values ('" . trim($_GET["lblReciptNo"]) . "','" . trim($_GET[$REF_NO]) . "', '" . $_GET[$SDATE] . "', " . $_GET[$GRAND_TOT] . ", " . $_GET[$st_amou] . ", '" . $_GET[txtChequeNo] . "')";
			//echo $sql_chq;
			$result_chq=mysql_query($sql_chq, $dbinv);
			if ($result_chq!=1){ $sql_status=1; }					
    	}
		$a=$a+1;
    }
	
        
    if ($_GET["Check1"] == "true"){
		$sql="update s_invcheq set ch_count_ret= '1' where cheque_no = '".trim($_GET["txtChequeNo"])."' and cus_code = '".trim($_GET["Txtcusco"])."' and bank = '".trim($_GET["cmbBankname"])."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }					
		
		$sql="insert into s_invcheq_tmp (CR_REFNO, ch_count_ret, cheque_no, cus_code, bank) value ('" . trim($_GET["lblReciptNo"]) . "', '1', '".trim($_GET["txtChequeNo"])."', '".trim($_GET["Txtcusco"])."', '".trim($_GET["cmbBankname"])."')";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
		
    } else {
		$sql="update s_invcheq set ch_count_ret= '0' where cheque_no = '".trim($_GET["txtChequeNo"])."' and cus_code = '".trim($_GET["Txtcusco"])."' and bank = '".trim($_GET["cmbBankname"])."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
		
		$sql="insert into s_invcheq_tmp (CR_REFNO, ch_count_ret, cheque_no, cus_code, bank) value ('" . trim($_GET["lblReciptNo"]) . "', '0', '".trim($_GET["txtChequeNo"])."', '".trim($_GET["Txtcusco"])."', '".trim($_GET["cmbBankname"])."')";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
	}
                /*
                 * for sms notifications
                 * 
                $sql = "insert into sms_ret_chq (cusno, chqno, amount, dep_date, bank) values ('" . trim($_GET["Txtcusco"]) . "','" . trim($_GET["txtChequeNo"]) . "','". trim($_GET["txtChequeAmount"]) . "','". trim($_GET["DTPicker2"]) . "','". trim($_GET["cmbBankname"]) . "')";
                $sql = "insert into sms_ret_chq (date, body, refno) values ('" . date("Y-m-d") . "','Cheque has been returned: " . trim($_GET["txtChequeNo"]) . " ". trim($_GET["txtcusname"]) . "','". trim($_GET["txtChequeAmount"]) . "',". trim($_GET["lblReciptNo"]) .")";
                $result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
                 * 
                 */
                
  			if ($sql_status==0){
				mysql_query("COMMIT", $dbinv);
				echo "Saved";	
			}	else {
				mysql_query("ROLLBACK", $dbinv);
				echo "Error has occured. Can't Save";
			}	
			
			
		
	}
	
if ($_GET["Command"]=="check_print")
{
	
	echo $_SESSION["print"];
}

	
if($_GET["Command"]=="tmp_crelimit")
{	
	echo "abc";
	$crLmt = 0;
	$cat = "";
	
	$rep=trim(substr($_GET["Com_rep1"], 0, 5));
	
	$sql = "select * from br_trn where rep='".$rep."' and cus_code='".trim($_GET["txt_cuscode"])."' and brand='".trim($_GET["cmbbrand1"])."'";
	echo $sql;
	$result =$db->RunQuery($sql);
    if ($row = mysql_fetch_array($result)) {
		$crLmt = $row["credit_lim"];
   		If (is_null($row["cat"])==false) {
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

echo "Tempory limit updated";*/

}
	
?>