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
		
		
		include_once("connection.php");

if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">CRN No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                             <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">CRN Date</font></td>
   							</tr>";
                           
					
							if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql = mysql_query("SELECT * FROM cred where C_REFNO like  '$letters%'  order by C_DATE desc limit 50") or die(mysql_error());
								
								
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								
									$sql = mysql_query("SELECT * FROM cred where and C_REFNO like  '$letters%'  order by C_DATE desc limit 50") or die(mysql_error());
								
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								
									$sql = mysql_query("SELECT * from s_cusordmas where CANCELL!='1' and CUS_NAME like  '$letters%' limit 50") or die(mysql_error()) or die(mysql_error());
								
							}
					
						
						
								
						
							while($row = mysql_fetch_array($sql)){
							
					
							$ResponseXML .= "<tr>               
                              <td onclick=\"crnno('".$row['C_REFNO']."');\">".$row['C_REFNO']."</a></td>";
							    
								$sql1="SELECT * FROM vendor where CODE='".$row["C_CODE"]."'";
								$result1 =$db->RunQuery($sql1);
								if($row1 = mysql_fetch_array($result1)){
							  		$ResponseXML .= "<td onclick=\"crnno('".$row['C_REFNO']."');\">".$row1["NAME"]."</a></td>";
								}	
                              $ResponseXML .= "<td onclick=\"crnno('".$row['C_REFNO']."');\">".$row['C_DATE']."</a></td>
                              
                            </tr>";
							
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

				
		if($_GET["Command"]=="new_crn")
		{
			
			
		/*	$sql="Select CAS_INV_NO_m from invpara";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CAS_INV_NO_m"];
			$lenth=strlen($tmpinvno);
			$invno="INV".substr($tmpinvno, $lenth-7);
			echo $invno;*/
		  
		  if ($_SESSION["dev"]==""){
		  	exit("no");
		  }
		  	
                $sql="Select ADP from invpara where COMCODE = '" .$_SESSION['COMCODE']. "'";
                $result =$db->RunQuery($sql);
                $row = mysql_fetch_array($result);
                $tmpinvno="000000".$row["ADP"];
                $lenth=strlen($tmpinvno);
                if ($_SESSION['COMCODE']=="A"){
                        $crn=trim("AADP/ ").substr($tmpinvno, $lenth-6);
                }else if ($_SESSION['COMCODE']=="B"){
                        $crn=trim("BADP/ ").substr($tmpinvno, $lenth-6);
                }else if ($_SESSION['COMCODE']=="R"){
                        $crn=trim("RADP/ ").substr($tmpinvno, $lenth-6);
                } else {
                        $crn=trim("ADP/ ").substr($tmpinvno, $lenth-6);
                }	
			$_SESSION["crn"]=$crn;
			
			$_SESSION["custno"]="";
		//	$sql1="delete from tmp_ord_data where str_invno='".$invno."'";
		//	$result1 =$db->RunQuery($sql1);
			
			//echo $crn;	
			
			header('Content-Type: text/xml'); 
			echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$ResponseXML .= "<crn><![CDATA[".$crn."]]></crn>";
			$ResponseXML .= "<cur_date><![CDATA[".date("Y-m-d")."]]></cur_date>";
			$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
			
		}
		
		
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

	
	if($_GET["Command"]=="setord")
	{
		
		include_once("connection.php");
		
		$len=strlen($_GET["salesord1"]);
		$need=substr($_GET["salesord1"],$len-7, $len);
		$salesord1=trim("ORD/ ").$_GET["salesrep"].trim(" / ").$need;
		
		
		$_SESSION["custno"]=$_GET['custno'];
		$_SESSION["brand"]=$_GET["brand"];
	
	$sql = mysql_query("DROP VIEW view_s_salma") or die(mysql_error());
					$sql = mysql_query("CREATE VIEW view_s_salma
AS
SELECT     s_salma.*, brand_mas.class AS class
FROM         brand_mas RIGHT OUTER JOIN
                      s_salma ON brand_mas.barnd_name = s_salma.brand") or die(mysql_error());
					  
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
				$cuscode=$_GET["custno"];	
				
					
					$ResponseXML .= "<salesord><![CDATA[".$salesord1."]]></salesord>";
				
					
				$cuscode=$_GET["custno"];	
				$sql = mysql_query("Select * from vendor where CODE='".$cuscode."'") or die(mysql_error());
				if($row = mysql_fetch_array($sql)){
					
					$OldRefno = "";
					$NewRefNo = "";
					$sql1 = mysql_query("SELECT  * From REF_HISTORY WHERE NewRefNo = '".$_GET["salesrep"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$OldRefno = trim($row1["OldRefno"]);
    					$NewRefNo = trim($row1["NewRefNo"]);	
					}
					
					$OutpDAMT = 0;
					$OutREtAmt = 0;
					$OutInvAmt = 0;
					

		
					$sql1 = mysql_query("select * from brand_mas where barnd_name='".trim($_GET["brand"])."'") or die(mysql_error());
					
					if($row1 = mysql_fetch_array($sql1)){
						if (is_null($row1["class"])==false){ $InvClass = trim($row1["class"]); }
					}
					
		//////// Total Invoice Amount ///////////////////////////////////////////////////////////////	/						
				if ($NewRefNo==$_GET["salesrep"]){
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				} else {
					$sqlview = mysql_query("select sum(grand_tot-totpay) as totout from view_s_salma where ACCNAME <> 'NON STOCK' and grand_tot>totpay and cancell='0' and c_code='".trim($cuscode)."' and sal_ex='".trim($_GET["salesrep"])."' and class='".$InvClass."'") or die(mysql_error());
				}
				
					$rowview = mysql_fetch_array($sqlview);
						if (is_null($rowview["totout"])==false) { $OutInvAmt = $rowview["totout"]; }


////////// PD Cheques ////////////////////////////////////////////////////////////////////////////
				if ($NewRefNo==$_GET["salesrep"]){
				
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and (sal_ex='".$OldRefno."' or sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				} else {	
					
					$sqlinvcheq = mysql_query("SELECT * FROM s_invcheq WHERE che_date>'".date("Y-m-d")."' AND cus_code='".trim($cuscode)."' and trn_type='REC' and sal_ex='".trim($_GET["salesrep"])."'") or die(mysql_error());
				}
				while($rowinvcheq = mysql_fetch_array($sqlinvcheq)){
				
					$sqlstr = mysql_query("select * from s_sttr where ST_REFNO='".trim($rowinvcheq["refno"])."' and ST_CHNO ='".trim($rowinvcheq["cheque_no"])."'") or die(mysql_error());
						
						while($rowstr = mysql_fetch_array($sqlstr)){
							echo "select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ";
						  	$sqltmp = mysql_query("select class from view_s_salma where Accname <> 'NON STOCK' and REF_NO='".trim($rowstr["ST_INVONO"])."' ") or die(mysql_error());
                    		if($rowstmp = mysql_fetch_array($sqltmp)){
								//echo $rowstmp["class"];
                    			if (trim($rowstmp["class"] == $InvClass)) {
                   			 		$OutpDAMT = $OutpDAMT + $rowstr["ST_PAID"];
								}
               			     }
                		}
     				}	
	 
////////////  Return Settlement PD Cheques////////////////////////////////////////////////////////	 
	 	 $pend_ret_set = 0;
		 $sqlview = mysql_query("SELECT sum(che_amount) as  che_amount FROM S_INVCHeQ WHERE CHE_DATE >'".date("Y-m-d")."' AND CUS_CODE='".trim($cuscode)."' and trn_type='RET'") or die(mysql_error());
          $rowsview = mysql_fetch_array($sqlview);
			if( is_null($rowsview["che_amount"])==false){ $pend_ret_set = $rowsview["che_amount"]; }
							

//////////// Reurn Cheques////////////////////////////////////// //   /////////////////////////////////
	 	if ($NewRefNo==$_GET["salesrep"]){
		
     		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and (S_REF='".$_GET["salesrep"]."' or S_REF='" & $OldRefno & "') ") or die(mysql_error());
		
		} else {
	 
	 		$sqlcheq = mysql_query("Select sum(CR_CHEVAL-paid) as tot from s_cheq where CR_C_CODE='".trim($cuscode)."'  and CR_CHEVAL-PAID>0 and CR_FLAG='0' and S_REF='".$_GET["salesrep"]."' ") or die(mysql_error());
			
		}	
		$rowscheq = mysql_fetch_array($sqlcheq);
		if (is_null($rowscheq["tot"])==false){ 
			$OutREtAmt=$rowscheq["tot"];
		} else {
			$OutREtAmt=0;
		}
 
   
		$ResponseXML .= "<sales_table><![CDATA[ <table  bgcolor=\"#0000FF\" border=1  cellspacing=0>
						<tr><td>Outstanding Invoice Amount</td><td>".number_format($OutInvAmt, 2, ".", ",")."</td></tr>
						 <td>Return Cheque Amount</td><td>".number_format($OutREtAmt, 2, ".", ",")."</td></tr>
						 <td>Pending Cheque Amount</td><td>".number_format($OutpDAMT, 2, ".", ",")."</td></tr>
						 <td>PSD Cheque Settlments</td><td>".number_format($pend_ret_set, 2, ".", ",")."</td></tr>
						 <td>Total</td><td>".number_format($OutInvAmt+$OutREtAmt+$OutpDAMT+$pend_ret_set, 2, ".", ",")."</td></tr>
						 </table></table>]]></sales_table>";
						 
        
        $sqlbrtrn = mysql_query("select * from br_trn where Rep='".trim($_GET["salesrep"])."' and brand='".$InvClass."' and cus_code='".trim($cuscode)."' ") or die(mysql_error());
       if( $rowsbrtrn = mysql_fetch_array($sqlbrtrn)){
	   	if (is_null($rowsbrtrn["credit_lim"])==false){
			$crLmt = $rowsbrtrn["credit_lim"];
		} else {
			$crLmt =0;
		}
		
		if (is_null($rowsbrtrn["tmpLmt"])==false){
			$tmpLmt = $rowsbrtrn["tmpLmt"];
		} else {
			$tmpLmt =0;
		}
		
		if (is_null($rowsbrtrn["CAT"])==false){ $cuscat=$rowsbrtrn["CAT"]; }
		if ($cuscat="A") { $m=2.5; }
		if ($cuscat="B") { $m=2.5; }
		if ($cuscat="C") { $m=1; }
			
		$txt_crelimi="0";
		$txt_crebal="0";
		
		$txt_crelimi=number_format($crLmt, 2, ".", ",");
		
		$txt_crebal = number_format($crLmt * $m + $tmpLmt - $OutInvAmt - $OutREtAmt - $OutpDAMT - $pend_ret_set, 2, ".", ",");
			
		
		$ResponseXML .= "<txt_crelimi><![CDATA[".$txt_crelimi."]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[".$txt_crebal."]]></txt_crebal>";
	   } else {
	   	$ResponseXML .= "<txt_crelimi><![CDATA[0.00]]></txt_crelimi>";
        $ResponseXML .= "<txt_crebal><![CDATA[0.00]]></txt_crebal>";
	   }
		
		$creditbalance = $OutInvAmt + $OutREtAmt + $OutpDAMT;
		


				
				
		 			$sql = mysql_query("select dis from brand_mas where barnd_name = '".trim($_GET["brand"])."'") or die(mysql_error());
					if ($row = mysql_fetch_array($sql)){	
						$ResponseXML .= "<dis><![CDATA[".$row["dis"]."]]></dis>";
					}
			
				}
			
	
				$ResponseXML .= "</salesdetails>";	
				echo $ResponseXML;
				
				
	
	
	}
	
	if($_GET["Command"]=="add_tmp")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_ord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			$rate=str_replace(",", "", $_GET["rate"]);
			$qty=str_replace(",", "", $_GET["qty"]);
			$discount=str_replace(",", "", $_GET["discount"]);
			$subtotal=str_replace(",", "", $_GET["subtotal"]);
			
			$sql="Insert into tmp_ord_data (str_invno, str_code, str_description, cur_rate, cur_qty, dis_per, cur_discount, cur_subtot, brand)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', ".$rate.", ".$qty.", ".$_GET["discountper"].", ".$discount.", ".$subtotal.", '".$_GET["brand"]."') ";
			$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
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
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_rate'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($_GET["discountper"], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['cur_subtot'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
						
						include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
						
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$sql="Select sum(cur_subtot) as tot_sub, sum(cur_discount) as tot_dis from tmp_ord_data where str_invno='".$_GET['invno']."'";
				$result =$db->RunQuery($sql);
				$row = mysql_fetch_array($result);	
				$ResponseXML .= "<subtot><![CDATA[".number_format($row['tot_sub'], 2, ".", ",")."]]></subtot>";
				$ResponseXML .= "<tot_dis><![CDATA[".number_format($row['tot_dis'], 2, ".", ",")."]]></tot_dis>";
				
				$sql_invpara="SELECT * from invpara";
				$result_invpara =$db->RunQuery($sql_invpara);
				$row_invpara = mysql_fetch_array($result_invpara);
			
				$vatrate=$row_invpara["vatrate"]/100;
			
				
				
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
	


	
if($_GET["Command"]=="delete_crn")
{
	$sql_status=0;
		
	mysql_query("SET AUTOCOMMIT=0", $dbinv);	 
	mysql_query("START TRANSACTION", $dbinv);	 
	
	$sql="select * from c_bal where REFNO= '".trim($_GET["crnno"])."' and BALANCE=AMOUNT ";
	$result=mysql_query($sql, $dbinv);
				
	if($row = mysql_fetch_array($result)){
		if (date("m", strtotime($row["SDATE"]))==date("m")){
			$sql1="delete from c_bal where REFNO='".$_GET["crnno"]."'";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=1; }
                        
                        $sql="DELETE from ledger WHERE l_refno='" . trim($_GET["crnno"]) . "'";
                        $result=mysql_query($sql, $dbinv);                            
						
			$sql1="update cred set CANCELL='1' where C_REFNO='".$_GET["crnno"]."'";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=2; }	
						
			$sql1="update s_salma set RET_AMO=RET_AMO-".$_GET["amount"]." where REF_NO='".$_GET["invno"]."'";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=3; }	
			
			$sql1="delete from s_led  where REF_NO = '".$_GET["crnno"]."'";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=4; }	
			
			//$sql1="update vendor set CUR_BAL=CUR_BAL+ ".$_GET["amount"]."  where CODE='".$_GET["cus_code"]."'";
			//$result1=mysql_query($sql1, $dbinv);
			//if ($result1!=1){ $sql_status=5; }	
			
			//$sql1="update br_trn set credit=credit+ ".$_GET["amount"]."  where cus_code='".$_GET["cus_code"]."' and Rep='".$_GET["salesrep"]."'";
			//$result1=mysql_query($sql1, $dbinv);
			//if ($result1!=1){ $sql_status=6; }	
			
			$sql2="insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('".$_GET["crnno"]."', '".$_SESSION["CURRENT_USER"]."', 'Advance Payment', 'Cancel', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."')";
			$resul2=mysql_query($sql2, $dbinv);
			if ($resul2!=1){ $sql_status=7; }	
			
			//echo $sql_status;
			if ($sql_status==0){
				mysql_query("COMMIT", $dbinv);
				$ResponseXML .= "<msg_cancel><![CDATA[Cancelled]]></msg_cancel>";
			}	else {
				mysql_query("ROLLBACK", $dbinv);
				$ResponseXML .= "<msg_cancel><![CDATA[Error has occured. Can't Cancel]]></msg_cancel>";
				
			}		
				
			
		}	else {
			$ResponseXML .= "<msg_cancel><![CDATA[Cant Cancel]]></msg_cancel>";
		}
		
		
		
	}
	
	
	
  echo $ResponseXML;
}
	
		
	if($_GET["Command"]=="del_item")
		{
		
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
	
			$sql="delete from tmp_ord_data where str_code='".$_GET['code']."' and str_invno='".$_GET['invno']."' ";
			//echo $sql;
			$result =$db->RunQuery($sql);
			
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
							
			
			$sql="Select * from tmp_ord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>
                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_rate']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_qty']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_discount']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['cur_subtot']."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td>";
							 
							 	include_once("connection.php");
							 
							 $sqlqty = mysql_query("select QTYINHAND from s_submas where STK_NO='".$row['str_code']."' AND STO_CODE='".$_GET["department"]."'") or die(mysql_error());
					if($rowqty = mysql_fetch_array($sqlqty)){
						$qty=$rowqty['QTYINHAND'];
					} else {
						$qty=0;
					}	
						
							$ResponseXML .= "<td bgcolor=\"#222222\" >".$qty."</a></td>
                            </tr>";
				}			
							
                $ResponseXML .= "   </table>]]></sales_table></salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	

	if($_GET["Command"]=="pass_crnno")
	{
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from cred where C_REFNO='".$_GET['crnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<C_REFNO><![CDATA[".$row["C_REFNO"]."]]></C_REFNO>";
			$ResponseXML .= "<C_DATE><![CDATA[".$row["C_DATE"]."]]></C_DATE>";
			$ResponseXML .= "<C_CODE><![CDATA[".$row["C_CODE"]."]]></C_CODE>";
                        
                        $ResponseXML .= "<cancel><![CDATA[" . $row['CANCELL'] . "]]></cancel>";
                        
			$sql1="Select * from vendor where CODE='".$row["C_CODE"]."'";
			$result1 =$db->RunQuery($sql1);	
			if ($row1 = mysql_fetch_array($result1)){
				$ResponseXML .= "<name><![CDATA[".$row1["NAME"]."]]></name>";
			}
			$ResponseXML .= "<C_INVNO><![CDATA[".$row["C_INVNO"]."]]></C_INVNO>";
			
			$sql1="Select * from s_salma where REF_NO='".$row["C_INVNO"]."'";
			$result1 =$db->RunQuery($sql1);	
			if ($row1 = mysql_fetch_array($result1)){
					$ResponseXML .= "<invdate><![CDATA[".$row1['SDATE']."]]></invdate>";
					$ResponseXML .= "<inv_amt><![CDATA[".$row1['GRAND_TOT']."]]></inv_amt>";
					$ResponseXML .= "<TOTPAY><![CDATA[".$row1['TOTPAY']."]]></TOTPAY>";
					$bal=$row1['GRAND_TOT']-$row1['TOTPAY'];
					$ResponseXML .= "<balance><![CDATA[".$bal."]]></balance>";
			} else {
					$ResponseXML .= "<invdate><![CDATA[]]></invdate>";
					$ResponseXML .= "<inv_amt><![CDATA[]]></inv_amt>";
					$ResponseXML .= "<TOTPAY><![CDATA[]]></TOTPAY>";
					$ResponseXML .= "<balance><![CDATA[]]></balance>";
			}
			$ResponseXML .= "<C_REMARK><![CDATA[".$row["C_REMARK"]."]]></C_REMARK>";
			$ResponseXML .= "<C_SALEX><![CDATA[".$row["C_SALEX"]."]]></C_SALEX>";
			$ResponseXML .= "<Brand><![CDATA[".$row["Brand"]."]]></Brand>";
			$ResponseXML .= "<C_PAYMENT><![CDATA[".$row["C_PAYMENT"]."]]></C_PAYMENT>";
		}
		
		$sql="Select * from c_bal where REFNO='".$_GET['crnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<DEP><![CDATA[".$row["DEP"]."]]></DEP>";
			$ResponseXML .= "<flag1><![CDATA[".$row["flag1"]."]]></flag1>";
			$ResponseXML .= "<vat><![CDATA[".$row["VAT"]."]]></vat>";
			$ResponseXML .= "<nbt><![CDATA[".$row["btt"]."]]></nbt>";
		} else {
                        $ResponseXML .= "<vat><![CDATA[1]]></vat>";
			$ResponseXML .= "<nbt><![CDATA[1]]></nbt>";
			$ResponseXML .= "<DEP><![CDATA[]]></DEP>";
			$ResponseXML .= "<flag1><![CDATA[]]></flag1>";
		}
		
		$sql_c="select * from s_crnfrm where Credit_note = '" . trim($_GET['crnno']) . "'";
		$result_c =$db->RunQuery($sql_c);
		$row_c = mysql_fetch_array($result_c);
		$ResponseXML .= "<form_no><![CDATA[".$row_c["Refno"]."]]></form_no>";
				
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
	if($_GET["Command"]=="save_crn")
		{
	/*		$_SESSION["CURRENT_DOC"] = 1;      //document ID
			$_SESSION["VIEW_DOC"] = false ;     //view current document
			$_SESSION["FEED_DOC"] = true;       //save  current document
			$_GET["MOD_DOC"] = false  ;         //delete   current document
			$_GET["PRINT_DOC"] = false  ;       //get additional print   of  current document
			$_GET["PRICE_EDIT"] = false ;       //edit selling price
			$_GET["CHECK_USER"] = false ;       //check user permission again   */

			//$ResponseXML .= "";
			//$ResponseXML .= "<salesdetails>";
			
		  if ($_SESSION["dev"]==""){
		  	exit("no");
		  }	
		  
		include_once("connection.php");
		
		$sqltmp="select * from invpara";
		$resulttmp=mysql_query($sqltmp, $dbinv);
		$rowtmp = mysql_fetch_array($resulttmp);
	
		if ($rowtmp["form_loc"]=="1"){
  			exit("no");
  		}	
		
		$sql_status=0;
		
		mysql_query("SET AUTOCOMMIT=0", $dbinv);	 
		mysql_query("START TRANSACTION", $dbinv);	 	
	
			$sql="Select C_REFNO from cred where C_REFNO='".$_GET['crnno']."'";
			$result=mysql_query($sql, $dbinv);
			
			if ($row = mysql_fetch_array($result)){
				//$ResponseXML .= "<msg_exist><![CDATA[Credit Note NO Already Exists]]></msg_exist>";
				exit("Credit Note NO Already Exists");
			}
			
			$mcash=0;
			if ($_GET["chkcash_disc"]=="true"){
				$mcash=1;
			}
			
			$remarks=str_replace("~", "&", $_GET["remarks"]);
	 		$remarks=str_replace("&nbsp;", " ", $remarks);
	 		
			$sql_crnfrm="select * from s_crnfrm where Refno='".$_GET["txt_frmno"]."'";
			$result_crnfrm=mysql_query($sql_crnfrm, $dbinv);
			$row_crnfrm = mysql_fetch_array($result_crnfrm);
                        
                        $sql = "select vatrate,nbt from invpara";
                        $result=mysql_query($sql, $dbinv);
                        $row = mysql_fetch_array($result);                        
                        
                        $mtot = $_GET["amount"];
                        $mtot1 = 0;
                        $svatValue = 0;
                        $nbt = 0;
                        
                        if($_GET["chk_nbt"] == "true"){
                            $nbt = ($mtot * ($row['nbt'] / 100)); 
                            $nbt = number_format($nbt, 2, ".", "");
                        }
                        
                        //check vat or svat
                        $vatType = 1;
                        if ($_GET['vatgroup_0'] == "true") {
                            //vat value
                            $mtot1 = ($mtot + $nbt) * ($row['vatrate'] / 100);
                            $mtot1 = number_format($mtot1, 2, ".", "");
                        }else{
                            //svat value
                            $svatValue = ($mtot + $nbt) * ($row['vatrate'] / 100);
                            $svatValue = number_format($svatValue, 2, ".", "");
                            $vatType = 2;
                        }

                        $mgrand_tot = ($mtot + $mtot1 + $nbt);
                        $mgrand_tot = number_format($mgrand_tot, 2, ".", "");                        
                        
			$sql="Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, brand, DEP, SAL_EX, vatrate, RNO, flag1, DEV, CANCELL, old, active, totpay, svatref, company, VAT, btt, VAT_VAL, SVAT, btt_rate, cheque_no, ch_date, ch_branch) values 
			('".$_GET["crnno"]."', '".$_GET["crndate"]."', 'AR_ADP', '".$_GET["cus_code"]."', '".$_GET["amount"]."', '".$_GET["amount"]."', '".$_GET["brand"]."', '".$_GET["department"]."', '".$_GET["salesrep"]."', '".$row["vatrate"]."', '".$_GET["txtrno"]."', '".$mcash."', '".$_SESSION['dev']."', '0', '0', 1, 0, '".$row_crnfrm["svatref"]."', '".$_SESSION['company']."', '0', 0, 0, 0, '".$row['nbt']."', '".$_GET["txtChqNo"]."', '".$_GET["txtChqDate"]."', '".$_GET["txtChqBranch"]."')";
                        $result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=1; }
                        
                        //-----gl posting
                        require_once './gl_posting.php';
                        
                        $ldate = $_GET["crndate"];
                        if($_GET["txtChqNo"] != ""){
                            $ldate = $_GET["txtChqDate"];
                        }
                        
                        $ayear = ac_year($ldate);
                        
                        
                        $amount = $mgrand_tot;
                        $vatAmount = $mtot1;
                        $orgAmount = $mtot;
                        
                        if($_GET["txtChqNo"] != ""){
                            $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $_GET["crnno"] . "', '" . $ldate . "', '1035', " . $_GET["amount"] . ", 'AR_ADP', 'DEB', '$ayear', '" . $_SESSION['company'] . "', '".$_GET["cus_code"]."')";
                            $result1=mysql_query($sqlLedger, $dbinv);
                            if ($result1!=1){ $sql_status=223; }
                            
                            $sql2 = "insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, sal_ex, trn_type, ex_flag, ch_owner, noof, ret_refno, ch_count_ret, department) values
                            ('" . $_GET["crnno"] . "', '" . $_GET["crndate"] . "', '" . $_GET["cus_code"] . "', '" . $_GET["cus_name"] . "', '" . $_GET["txtChqNo"] . "', '" . $_GET["txtChqDate"] . "', '" . $_GET["txtChqBranch"] . "',  " . $_GET["amount"] . ", '" . $_GET["salesrep"] . "', 'REC', 'N', '', 0, '1', '0', 'O')";
                            $result1=mysql_query($sql2, $dbinv);
                            if ($result1!=1){ $sql_status=224; }
                        }else{
                            $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $_GET["crnno"] . "', '" . $ldate . "', '1010', " . $_GET["amount"] . ", 'AR_ADP', 'DEB', '$ayear', '" . $_SESSION['company'] . "', '".$_GET["cus_code"]."')";
                            $result1=mysql_query($sqlLedger, $dbinv);
                            if ($result1!=1){ $sql_status=223; }  
                        }
                        
                        $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $_GET["crnno"] . "', '" . $ldate . "', '" . $_GET["accno2"] . "', " . $_GET["amount"] . ", 'AR_ADP', 'CRE', '$ayear', '" . $_SESSION['company'] . "', '".$_GET["cus_code"]."')";
                        $result1=mysql_query($sqlLedger, $dbinv);
                        if ($result1!=1){ $sql_status=223; } 
                        
                        /*
                        if($vatAmount > 0){
                            $sqlGlPost = "select * from gl_posting where docname = 'CREDIT NOTE' and action = 'ADD_VAT'";    
                            $result=mysql_query($sqlGlPost, $dbinv);
                            $rowGlPost = mysql_fetch_array($result);

                            $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $_GET["crnno"] . "', '" . $ldate . "', '" . $rowGlPost["l_code"] . "', " . $vatAmount . ", 'CNT', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "', '".$_GET["cus_code"]."')";
                            $result1=mysql_query($sqlLedger, $dbinv);
                            if ($result1!=1){ $sql_status=223; }                              
                        }
                        if($nbt > 0){
                            $sqlGlPost = "select * from gl_posting where docname = 'CREDIT NOTE' and action = 'ADD_NBT'";    
                            $result=mysql_query($sqlGlPost, $dbinv);
                            $rowGlPost = mysql_fetch_array($result);

                            $sqlLedger = "Insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, acyear, ComCode, c_remarks) Values ('" . $_GET["crnno"] . "', '" . $ldate . "', '" . $rowGlPost["l_code"] . "', " . $nbt . ", 'CNT', '" . $rowGlPost['entry_flag'] . "', '$ayear', '" . $_SESSION['company'] . "', '".$_GET["cus_code"]."')";
                            $result1=mysql_query($sqlLedger, $dbinv);
                            if ($result1!=1){ $sql_status=223; }                              
                        }
			*/

			$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, balance, netamount, cus_code, cusname, sal_ex, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".$_GET["crnno"]."', '".$_GET["crndate"]."', '".$_GET["crnno"]."', ".$_GET["amount"].", ".$_GET["amount"].", ".(-1*$_GET["amount"]).", '".$_GET["cus_code"]."', '".$_GET["cus_name"]."', '".$_GET["salesrep"]."',  '".$_SESSION['dev']."', 0, 0, 0, '0', '".$_GET["department"]."', 'AR_ADP', 'OVER')";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=3; }	
					
			$sql="Insert into cred (C_REFNO, C_DATE, C_INVNO, C_CODE, C_PAYMENT, C_REMARK, C_SALEX, Brand, DEV, CANCELL, company, type) values 
			('".$_GET["crnno"]."', '".$_GET["crndate"]."', '".$_GET["invno"]."', '".$_GET["cus_code"]."', '".$_GET["amount"]."', '".$remarks."', '".$_GET["salesrep"]."', '".$_GET["brand"]."', '".$_SESSION['dev']."', '0', '".$_SESSION['COMCODE']."', '1') ";
			//echo $sql;
			//dnINV.conINV.Execute "Insert into cred (C_REFNO,C_DATE,C_INVNO,C_CODE,C_PAYMENT,C_REMARK,C_SALEX,brand,dev)" _
//& " values('" & Trim(txtrefno) & "','" & DateValue(dtdate) & "','" & Trim(txt_invno) & "', '" & Trim(txt_cuscode) & "'," & Val(Format(txtamount, General)) & ",'" & Trim(txt_remark) & "','" & Trim(Left(Com_rep, 5)) & "','" & Trim(cmbbrand) & "','0')"
			$result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=4; }	
						
			$sql="update s_salma set RET_AMO=RET_AMO+".$_GET["amount"]." where REF_NO='".$_GET["invno"]."'";
			$result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=5; }	
			
	
			$sql="Insert into s_led (REF_NO, SDATE, C_CODE, AMOUNT, FLAG, DEPARTMENT, DEV) values 
			('".$_GET["crnno"]."', '".$_GET["crndate"]."', '".$_GET["cus_code"]."', '".$_GET["amount"]."', 'AR_ADP', '".$_GET["department"]."', '".$_SESSION['dev']."') ";
			$result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=6; }	
			
			$sql="update vendor set CUR_BAL = CUR_BAL - ".$_GET["amount"]." where CODE='".$_GET["cus_code"]."'";
			$result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=7; }	
			
			
			$sql="update br_trn set credit = credit - ".$_GET["amount"]." where cus_code='".$_GET["cus_code"]."' and Rep='".$_GET["salesrep"]."'";
			$result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=8; }	
			
			

			//==============update CRN Form ============================================
			if (trim($_GET["txt_frmno"]) != "") {
				$sql="Update s_crnfrm set Credit_note = '" . trim($_GET["crnno"]) . "' where Refno = '" . trim($_GET["txt_frmno"]) . "'";
				$result=mysql_query($sql, $dbinv);
				if ($result!=1){ $sql_status=9; }	
				
				$sql="Update s_crnfrmtrn set crd_note = '" . trim($_GET["crnno"]) . "' where Refno = '" . trim($_GET["txt_frmno"]) . "'";
				$result=mysql_query($sql, $dbinv);
				if ($result!=1){ $sql_status=10; }	
				
				
				//echo $sql;
  			}
			
			
			$sql="update invpara set ADP = ADP + 1 where COMCODE = '" .$_SESSION['COMCODE']. "'";
			$result=mysql_query($sql, $dbinv);
			if ($result!=1){ $sql_status=11; }	
			
			
			$sql2="insert into entry_log(refno, username, docname, trnType, stime, sdate) values ('". trim($_GET["crnno"])."', '".$_SESSION["CURRENT_USER"]."', 'Advance Payment', 'Save', '".date("Y-m-d H:i:s")."', '".date("Y-m-d")."')";
			$resul2=mysql_query($sql2, $dbinv);
			if ($resul2!=1){ $sql_status=12; }	
			
			if ($sql_status==0){
				mysql_query("COMMIT", $dbinv);
				echo "Saved";	
			}	else {
				mysql_query("ROLLBACK", $dbinv);
				echo "Error ($sql_status) has occured. Can't Save";
			}				
		
					
			
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