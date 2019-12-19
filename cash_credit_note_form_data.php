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
	
	
	if ($_GET["Command"]=="chk_ccrnf"){
		
		$_SESSION["CURRENT_DOC"] = "17";     //document ID
    //VIEW_DOC = True      '  view current document
     	$_SESSION["FEED_DOC"] = "true";      //   save  current document
    //MOD_DOC = True       '   delete   current document
    //PRINT_DOC = True     ' get additional print   of  current document
    //PRICE_EDIT=true      ' edit selling price
    	$_SESSION["CHECK_USER"] = "true";    // check user permission again
    
    
    
	
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
			
			$_SESSION["MonthView1"]="";
			
			$sql="Select CCRNNO from invpara";
			
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CCRNNO"];
			$lenth=strlen($tmpinvno);
			//txtrefno = "CCRN\" + dnINV.conINV.DefaultDatabase + "\" + Right("0000" + Trim(Str(rsinvpara.Fields("CCRNNO"))), 4)
			$invno=trim("CCRN/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["invno"]=$invno;
			
			$sql="Select CCRNNO from tmpinvpara";
			
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmpinvno="000000".$row["CCRNNO"];
			$lenth=strlen($tmpinvno);
			$invno1=trim("CCRN/".$_SESSION['company']."/ ").substr($tmpinvno, $lenth-7);
			$_SESSION["credit_note_form"]=$invno1;
			
			$sql="update tmpinvpara set CCRNNO=CCRNNO+1";
			$result =$db->RunQuery($sql);
			
			$sql_tmpinst= " delete from tmp_cash_credit_note_form where crn_form_no='".$invno."'";
			
			$result_tmpinst =$db->RunQuery($sql_tmpinst);
			
			
			
			echo $invno;	
			
		}
	
if ($_GET["Command"]=="set_check"){	
	
        //mrefno = Trim(txtrefno)
		$sql= "Select * from s_crnfrm where Refno = '" . $_GET["txtrefno"] . "'";
		$result =$db->RunQuery($sql);
		if ($row = mysql_fetch_array($result)){
			$sql1= "update s_crnfrm set Checked = '" . $_SESSION['UserName'] . "',Check_date = '" . date("Y-m-d") . "' where Refno = '" . $_GET["txtrefno"] . "'";
			$result1 =$db->RunQuery($sql1);
		}
	
       echo "Recordes are marked as Checked";
   
}

if ($_GET["Command"]=="search_inv"){	
$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	include_once("connection.php");
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   							</tr>";
                       
						if ($_GET["mstatus"]=="invno"){ 
							$letters = $_GET['invno']; 
						//  if ($_SESSION["slected"]=="all"){
						  	$sql = "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' and cancell = '0' and flag = 'CCRN'  and flg_caj='0' and company = '" . $_SESSION["company"]. "' order BY Refno desc limit 50";
							$result=mysql_query($sql, $dbinv);
								
						//  } else if ($_SESSION["slected"]=="locked"){
						//  	$sql = "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50";
						//	$result=mysql_query($sql, $dbinv);
							
		
						//  } else if ($_SESSION["slected"]=="pending"){
						//  	$sql = "select Refno, Code, Amount   from s_crnfrm where Refno like  '$letters%' cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50";
						//	$result=mysql_query($sql, $dbinv);
							
		
					//	  }	
	 					}
							
							//echo $sql;
													
						
							while($row = mysql_fetch_array($result)){
								$cuscode = $row["CODE"];
								$stname = $_GET["stname"];
							$ResponseXML .= "<tr>               
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Refno']."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row["Code"]."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Amount']."</a></td>
                              
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
	}			
	
			
if ($_GET["Command"]=="select_list"){
	
	$_SESSION["slected"]=$_GET["mstatus"];
	if ($_GET["mstatus"]=="all"){
		$sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and flag = 'CCRN' order BY Refno desc limit 50";
	} else if ($_GET["mstatus"]=="locked"){
		$sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='1' and flag = 'CCRN' order BY Refno desc limit 50";
		
	} else if ($_GET["mstatus"]=="pending"){
		$sql = "select Refno, Code, Amount   from s_crnfrm where cancell = '0' and Lock1='0' and flag = 'CCRN' order BY Refno desc limit 50";	
		
	}	
	
							//}
							echo "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Invoice Date</font></td>
   </tr>";
								
							//echo $sql;
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
							
							echo "<tr>               
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Refno']."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row["Code"]."</a></td>
                              <td onclick=\"invno_check('".$row['Refno']."', '".$_GET['stname']."');\">".$row['Amount']."</a></td>
                              
                            </tr>";
							}
							 echo "</table>";
                    
}
	
if ($_GET["Command"]=="set_session_month"){
	$_SESSION["MonthView1"]=$_GET["MonthView1"];
	echo $_SESSION["MonthView1"];
}	


if ($_GET["Command"]=="setord"){
						
						echo "   <table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"176\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
   </tr>";
						
						
						if ($_SESSION["MonthView1"]!=""){	
								
								
								$year=substr($_SESSION["MonthView1"], 0, 4);
								$month=substr($_SESSION["MonthView1"], 5, 2);
								
								$sql="select REF_NO , SDATE, GRAND_TOT, TOTPAY  from s_salma where Accname != 'NON STOCK' and CANCELL='0' and C_CODE='" . $_SESSION["suppno"] . "' and year(SDATE)='".$year."' and month(SDATE)='".$month."' and Brand='".$_GET["brand"]."' ORDER BY SDATE desc limit 50";
								//echo $sql;
								//$sql = "select REF_NO , SDATE, GRAND_TOT  from s_salma where Accname='OFFICE' and CANCELL='0'and C_CODE='" . $_SESSION["crn_form_supplierno"] . "' and year(SDATE)='".$year."' and month(SDATE)='".$month."'   ORDER BY SDATE desc limit 50";
							//}
								
							//echo $sql;
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
							
							echo "<tr>               
                              <td onclick=\"invno1('".$row['REF_NO']."', '".$_GET['stname']."');\">".$row['REF_NO']."</a></td>
                              <td align=\"right\" onclick=\"invno1('".$row['REF_NO']."', '".$_GET['stname']."');\">".number_format($row["GRAND_TOT"], 2, ".", ",")."</a></td>";
							  $balance=$row["GRAND_TOT"]-$row["TOTPAY"];
                              echo "<td align=\"right\" onclick=\"invno1('".$row['REF_NO']."', '".$_GET['stname']."');\">".number_format($balance, 2, ".", ",")."</a></td>
                              
                            </tr>";
							}
						}	
						
						echo "</table>";
}


if ($_GET["Command"]=="pass_crn_form"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	//$sql_tmpinst= " delete from tmp_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["invno"]."'";
	$sql_tmpinst= " delete from tmp_cash_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["invno"]."'";
	//echo $sql_tmpinst;
	$result_tmpinst =$db->RunQuery($sql_tmpinst);
	
	$ResponseXML = "<salesdetails>";		
	
	
			
	$i = 1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
        $sql_rscrn= " Select * from s_crnfrmtrn where Inv_no = '" .$_GET["invno"]. "' and Flag = 'CCRN'";
		//echo $sql_rscrn;
        $result_rscrn =$db->RunQuery($sql_rscrn);
		if ($row_rscrn = mysql_fetch_array($result_rscrn)){
			
			 	
		
			$ResponseXML .= "<msg><![CDATA[Sorry this Invoice Incentive Already Paid]]></msg>";	
			$ResponseXML .= "<Incen_val><![CDATA[]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[]]></mcou>";
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Deli.Date</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Inv.Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Inv.Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Amou</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Cash Dis%</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis Amount</font></td>
       						</tr>";		
			
			$sql_rsstr = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "'  ";
			$result_rsstr =$db->RunQuery($sql_rsstr);
        	$row_rsstr = mysql_fetch_array($result_rsstr);
			
			if ((is_null($row_rsstr["deli_date"])==false) and ($row_rsstr["deli_date"]!="0000-00-00")) {
	                            $Inv_date = $row_rsstr["deli_date"];
	                      
							} else {
							
	                            $Inv_date = $row_rsstr["SDATE"];
	                        }
			$balance_val=$row_rsstr["GRAND_TOT"]-$row_rsstr["ST_PAID"];
			
			//$settledate = $row_rsstr["ST_DATE"];
				$settledate = $row_rsstr["st_chdate"];	
							$date1 = $Inv_date;
							$date2 = $settledate;
							$diff = abs(strtotime($date2) - strtotime($date1));
							$days = floor($diff / (60*60*24));
																	
			$ResponseXML .= "<tr>
                              <td width=\"100\" >".$Inv_date."</td>
							  <td width=\"100\" >".$row_rsstr["SDATE"]."</td>
                              <td width=\"300\" >".$row_rsstr["ST_INVONO"]."</td>
                              <td width=\"100\" >".$row_rsstr["GRAND_TOT"]."</td>
                              <td width=\"100\" >".$row_rsstr["ST_PAID"]."</td>
							  <td width=\"100\" >".$settledate."</td>
							  <td width=\"100\" >".$balance_val."</td>
							  <td width=\"100\" >".$days."</td>
							  <td width=\"100\" >".$row_rscrn["Incen_per"]."</td>
							  <td width=\"100\" >".$row_rscrn["Incen_val"]."</td>
       						</tr>";						
			$ResponseXML .= "   </table>]]></sales_table>";					
			$ResponseXML .= "</salesdetails>";		

			
			   
        } else {
        	
			$sql_rssalma1 = "Select sum(ST_PAID) as sum_ST_PAID from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "' AND (ST_FLAG = 'CHK' or ST_FLAG ='Cash TT' or ST_FLAG ='CAS' or ST_FLAG ='UT')";
			$result_rssalma1 =$db->RunQuery($sql_rssalma1);
			$row_rssalma1 = mysql_fetch_array($result_rssalma1);
			
			$sql_rssalma = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "' AND (ST_FLAG = 'CHK' or ST_FLAG ='Cash TT' or ST_FLAG ='CAS' or ST_FLAG ='UT')";
			//echo $sql_rssalma;
			$result_rssalma =$db->RunQuery($sql_rssalma);
			
        	if ($row_rssalma = mysql_fetch_array($result_rssalma)){
			  if ($row_rssalma["GRAND_TOT"]>$row_rssalma1["sum_ST_PAID"]){
        	   	$result_rssalma =$db->RunQuery($sql_rssalma);
        		while ($row_rssalma = mysql_fetch_array($result_rssalma)){
                	if ((is_null($row_rssalma["deli_date"])==false) or ($row_rssalma["deli_date"]!="0000-00-00")){
	                   $Inv_date = $row_rssalma["deli_date"];
	                } else {
						$Inv_date = $row_rssalma["SDATE"];
	                }
					
					//echo $result_rssalma["GRAND_TOT"]."/".$result_rssalma["TOTPAY"];
		 		
					$balance_val=$row_rssalma["GRAND_TOT"]-$row_rssalma["ST_PAID"];
					
	                $inv_no = $row_rssalma["ST_INVONO"];
					$invamount = $row_rssalma["GRAND_TOT"];
					$settleamt = $row_rssalma["ST_PAID"];
					//$settledate = $row_rssalma["ST_DATE"];
					$settledate = $row_rssalma["st_chdate"];	
					
					$date1 = $Inv_date;
					$date2 = $settledate;
					$diff = abs(strtotime($date2) - strtotime($date1));
					$days = floor($diff / (60*60*24));
				
					$sql_tmpinst= " insert into tmp_cash_credit_note_form (id, crn_form_no, Inv_date, InvInv_date, inv_no, Amount, settleamt, settledate,  days, tmp_no, balance) values (".$row_rssalma["ID"].", '".$_GET["txtrefno"]."', '".$Inv_date."', '".$row_rssalma["SDATE"]."', '".$inv_no."', ".$invamount.", ".$settleamt.", '".$settledate."', ".$days." , '".$_SESSION["credit_note_form"]."', ".$balance_val.")";
				//echo $sql_tmpinst;
        			$result_tmpinst =$db->RunQuery($sql_tmpinst);
	            }
			  } else {
			  	$msg = "Already Settled";
			  }	
	            
	        } else {
	            if ($_SESSION["check"] == "new") {
	                $msg = "No cash/cheque settlement records found in this invoice";
	            } else {
	                $msg = "yes";
	            }
	            if ($msg == "yes") {
	                
					$sql_rsstr = "Select * from view_s_sttr_copy where ST_INVONO = '" . trim($_GET["invno"]) . "'  ";
					$result_rsstr =$db->RunQuery($sql_rsstr);
        			if ($row_rsstr = mysql_fetch_array($result_rsstr)){
						
						$result_rsstr =$db->RunQuery($sql_rsstr);
        				while ($row_rsstr = mysql_fetch_array($result_rsstr)){
	               
	                        if ((is_null($row_rsstr["deli_date"])==false) and ($row_rsstr["deli_date"]!="0000-00-00")) {
	                            $Inv_date = $row_rsstr["deli_date"];
	                        } else {
	                            $Inv_date = $row_rsstr["SDATE"];
	                        }
							
							$balance_val=$row_rsstr["GRAND_TOT"]-$row_rsstr["ST_PAID"];
							
							$inv_no = $row_rsstr["ST_INVONO"];
							$invamount = $row_rsstr["GRAND_TOT"];
							$settleamt = $row_rsstr["ST_PAID"];
							$settledate = $row_rsstr["ST_DATE"];
					
							$date1 = $Inv_date;
							$date2 = $settledate;
							$diff = abs(strtotime($date2) - strtotime($date1));
							$days = floor($diff / (60*60*24));
					
	                       $sql_tmpinst= " insert into tmp_cash_credit_note_form (id, crn_form_no, Inv_date, InvInv_date, inv_no, Amount, settleamt, settledate,  days, tmp_no, balance) values (".$row_rsstr["ID"].", '".$_GET["txtrefno"]."', '".$Inv_date."', '".$row_rsstr["SDATE"]."', '".$inv_no."', ".$invamount.", ".$settleamt.", '".$settledate."', ".$days." , '".$_SESSION["credit_note_form"]."', ".$balance_val.")";
				//echo $sql_tmpinst;
							
							
        					$result_tmpinst =$db->RunQuery($sql_tmpinst);
	                    }
	                } else {
	                    $msg = "No any records found in this invoice";
	                    
	                }
	                
	            } else {
    	            
	            }
	        }
	        $_SESSION["check"] = "";
			
       
        
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"50\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Deli.Date</font></td>
							  <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Inv.Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Inv.Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Amou</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Cash Dis%</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis Amount</font></td>
       						</tr>";		
			
			$Incen_val_val=0;
			
			$sql= "Select * from tmp_cash_credit_note_form where tmp_no = '" .$_SESSION["credit_note_form"]. "'";
			$result =$db->RunQuery($sql);
        	while ($row = mysql_fetch_array($result)){
			
						$inv_id="id".$i;
						$Inv_date="Inv_date".$i;
						$InvInv_date="InvInv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$settleamt="settleamt".$i;
						$settledate="settledate".$i;
						$days="days".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$balance="balance".$i;
												
					$ResponseXML .= "<tr>
                        	
							 <td ><input type=\"text\" size=\"10\" name=".$inv_id."  disabled id=".$inv_id." value='".$row['id']."'  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row['Inv_date']."'  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$InvInv_date."  disabled id=".$InvInv_date." value='".$row['InvInv_date']."'  class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$row["inv_no"]."' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row['Amount']." class=\"text_purchase3_right\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$settleamt."  disabled id=".$settleamt." value=".$row['settleamt']." class=\"text_purchase3_right\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$settledate."  disabled id=".$settledate." value=".$row['settledate']." class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$balance."  disabled id=".$balance." value='".$row["balance"]."' class=\"text_purchase3_right\"/></td>
							  <td ><input type=\"text\" size=\"10\" name=".$days."  disabled id=".$days." value=".$row['days']." class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_per."   id=".$Incen_per." value='".$row['Incen_per']."' class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_val." onBlur=\"cal_incentive_val_cash('".$i."')\" onkeypress=\"cal_incentive_val_cash('".$i."')\"  id=".$Incen_val." value='".$row['Incen_val']."' class=\"text_purchase3_right\"/></td>
            	            	
            	
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["inv_no"]."  name=".$row["inv_no"]." onClick=\"del_item('".$row["inv_no"]."');\"></td>
				<td ><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=".$row["inv_no"]."&trn_type=".$rstemp['TRN_TYPE']."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><input type=\"button\" name=\"searchcust\" id=\"searchcust\" value=\"...\"  class=\"btn_purchase\"></a></td>
				
				
				</tr>"; 		
				
				
				
				if ((is_null($row['Incen_val'])==false) and ($row['Incen_val']!="")){
					$Incen_val_val=$Incen_val_val+$row['Incen_val'];
				}	
				$i=$i+1;
			}
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<Incen_val><![CDATA[".$Incen_val_val."]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[".$msg."]]></msg>";						
			$ResponseXML .= "</salesdetails>";		
		}	 	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
		
		

		echo $ResponseXML;	
			
	
}
	
if ($_GET["Command"]=="invno_check"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$sql_tmpinst= " delete from tmp_cash_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["invno"]."'";
	$result_tmpinst =$db->RunQuery($sql_tmpinst);
	
	$ResponseXML = "<salesdetails>";		
	
	$_SESSION["REFNO"]=$_GET["invno"];
			
	$i = 1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
        $sql_rscrn= " Select * from s_crnfrm where Refno = '" .$_GET["invno"]. "'";
        $result_rscrn =$db->RunQuery($sql_rscrn);
		if ($row_rscrn = mysql_fetch_array($result_rscrn)){
			
			$_SESSION["credit_note_form"]=$row_rscrn["tmp_no"];
			
			if (is_null($row_rscrn["Sdate"])==false) { 
				$ResponseXML .= "<DTPicker1><![CDATA[".$row_rscrn["Sdate"]."]]></DTPicker1>";	
			} else {
				$ResponseXML .= "<DTPicker1><![CDATA[]]></DTPicker1>";
			}
			if (is_null($row_rscrn["Code"])==false) { 
				$ResponseXML .= "<txt_cuscode><![CDATA[".$row_rscrn["Code"]."]]></txt_cuscode>";	
			} else {
				$ResponseXML .= "<txt_cuscode><![CDATA[]]></txt_cuscode>";	
			}
			
			$sql2= " Select * from vendor where CODE = '" .$row_rscrn["Code"]. "'";
        	$result2 =$db->RunQuery($sql2);
			$row2 = mysql_fetch_array($result2);
			if (is_null($row2["NAME"])==false) { 
				$ResponseXML .= "<txt_cusname><![CDATA[".$row2["NAME"]."]]></txt_cusname>";	
			} else {
				$ResponseXML .= "<txt_cusname><![CDATA[]]></txt_cusname>";	
			}
			
			if (is_null($row_rscrn["Mon"])==false) { 
				$ResponseXML .= "<MonthView1><![CDATA[".$row_rscrn["Mon"]."]]></MonthView1>";	
			} else {
				$ResponseXML .= "<MonthView1><![CDATA[]]></MonthView1>";	
			}
			if (trim($row_rscrn["Checked"])=="A") { 
				$ResponseXML .= "<txt_check><![CDATA[]]></txt_check>";	
			} else {
				$ResponseXML .= "<txt_check><![CDATA[".$row_rscrn["Checked"]."]]></txt_check>";	
			}
			
			if (is_null($row_rscrn["Check_date"])==false) { 
				$ResponseXML .= "<DTPicker2><![CDATA[".$row_rscrn["Check_date"]."]]></DTPicker2>";	
			} else {
				$ResponseXML .= "<DTPicker2><![CDATA[]]></DTPicker2>";	
			}
			if (is_null($row_rscrn["Approved"])==false) { 
				$ResponseXML .= "<txt_auth><![CDATA[".$row_rscrn["Approved"]."]]></txt_auth>";	
			}	else {
				$ResponseXML .= "<txt_auth><![CDATA[]]></txt_auth>";	
			}
			
			if (is_null($row_rscrn["App_date"])==false) { 
				$ResponseXML .= "<DTPicker5><![CDATA[".$row_rscrn["App_date"]."]]></DTPicker5>";	
			} else {
				$ResponseXML .= "<DTPicker5><![CDATA[]]></DTPicker5>";	
			}
			
			if (is_null($row_rscrn["Sal_ex"])==false) { 
				$sql1= " Select * from s_salrep where REPCODE = '" .$row_rscrn["Sal_ex"]. "'";
        		$result1 =$db->RunQuery($sql1);
				if ($row1 = mysql_fetch_array($result1)){
					$ResponseXML .= "<Com_rep><![CDATA[".$row1["REPCODE"]." ".$row1["Name"]."]]></Com_rep>";	
				}else{
                                        $ResponseXML .= "<Com_rep><![CDATA[]]></Com_rep>";
                                }
			} else {
				$ResponseXML .= "<Com_rep><![CDATA[]]></Com_rep>";	
			}
			
			if (is_null($row_rscrn["Refno"])==false) { 
				$ResponseXML .= "<txtrefno><![CDATA[".$row_rscrn["Refno"]."]]></txtrefno>";	
			} else {
				$ResponseXML .= "<txtrefno><![CDATA[]]></txtrefno>";	
			}
			
			if (is_null($row_rscrn["Remark"])==false) { 
				$ResponseXML .= "<txtremark><![CDATA[".$row_rscrn["Remark"]."]]></txtremark>";	
			}	else {
				$ResponseXML .= "<txtremark><![CDATA[]]></txtremark>";	
			}
    			
    		if ($row_rscrn["Checked"]=="A") { 
				$ResponseXML .= "<cmd_check><![CDATA[Check]]></cmd_check>";	
			} else {
				$ResponseXML .= "<cmd_check><![CDATA[Checked]]></cmd_check>";
			}
			
			if (is_null($row_rscrn["Approved"])==true) { 
				$ResponseXML .= "<cmd_auth><![CDATA[Autorize]]></cmd_auth>";	
			} else {
				$ResponseXML .= "<cmd_auth><![CDATA[Autorized]]></cmd_auth>";
			}
			
			$ResponseXML .= "<txttot><![CDATA[".$row_rscrn["Amount"]."]]></txttot>";	
			if ($row_rscrn["Lock1"]=="1"){
				$ResponseXML .= "<lbllock><![CDATA[Locked]]></lbllock>";	
			} else {
				$ResponseXML .= "<lbllock><![CDATA[]]></lbllock>";	
			}	
			
			
			$sql= "delete from tmp_cash_credit_note_form where tmp_no = '" .$_SESSION["credit_note_form"]. "'";
			//echo $sql;
			$result =$db->RunQuery($sql);
   
        
       
        	$sql_rscrntrn= "Select * from s_crnfrmtrn where Refno = '" . $_GET["invno"] . "'";
		
			$result_rscrntrn =$db->RunQuery($sql_rscrntrn);
        	while ($row_rscrntrn = mysql_fetch_array($result_rscrntrn)){
				
				$sql_rssal = "select deli_date, GRAND_TOT, TOTPAY from s_salma where REF_NO = '" . trim($row_rscrntrn["Inv_no"]) . "'";
				
				$result_rssal =$db->RunQuery($sql_rssal);
        		$row_rssal = mysql_fetch_array($result_rssal);
         		if ((is_null($row_rssal["deli_date"])==false) and ($row_rssal["deli_date"]!="0000-00-00")) {
            		$Inv_date = $row_rssal["deli_date"];
         		} else {
            		if ((is_null($row_rscrntrn["Inv_date"])==false) and ($row_rscrntrn["Inv_date"]!="0000-00-00")) { 
						$Inv_date  = $row_rscrntrn["Inv_date"]; 
					}
         		}
		 		
				$balance_val=$row_rssal["GRAND_TOT"]-$row_rssal["TOTPAY"];
		 
				if ((is_null($row_rscrntrn['Settle_amo'])==false) and ($row_rscrntrn['Settle_amo']!="")){
					$Settle_amo=$row_rscrntrn['Settle_amo'];
				} else {
					$Settle_amo=0;
				}
				
				$date1 = $Inv_date;
				$date2 = $row_rscrntrn["Mon"];
				$diff = abs(strtotime($date2) - strtotime($date1));
				$days = floor($diff / (60*60*24));
				
				
			
								
				$sql_tmpinst= " insert into tmp_cash_credit_note_form (crn_form_no, Inv_date, inv_no, Amount, settleamt, settledate, days,  Incen_per, Incen_val, tmp_no, balance) values ('".$_GET["invno"]."', '".$Inv_date."', '".$row_rscrntrn["Inv_no"]."', '".$row_rscrntrn['Amount']."', ".$Settle_amo.", '".$row_rscrntrn["Mon"]."', ".$days.", ".$row_rscrntrn["Incen_per"].", ".$row_rscrntrn["Incen_val"].", '".$_SESSION["credit_note_form"]."', ".$balance_val.")";
				//echo $sql_tmpinst;
        		$result_tmpinst =$db->RunQuery($sql_tmpinst);
			
				
        	}
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Deli.Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Inv.Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Amou</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Settle Date</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Balance</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Cash Dis%</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Dis Amount</font></td>
                             
                             
                            </tr>";		
							
			$Incen_val_val=0;
			
			$sql= "Select * from tmp_cash_credit_note_form where tmp_no = '" .$_SESSION["credit_note_form"]. "'";
			$result =$db->RunQuery($sql);
        	while ($row = mysql_fetch_array($result)){
			
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$settleamt="settleamt".$i;
						$settledate="settledate".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$days="days".$i;
						$balance="balance".$i;						
					
					$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row['Inv_date']."' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$row["inv_no"]."' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row['Amount']." class=\"text_purchase3_right\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$settleamt."  disabled id=".$settleamt." value=".$row['settleamt']." class=\"text_purchase3_right\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$settledate."  disabled id=".$settledate." value=".$row['settledate']." class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$balance."  disabled id=".$balance." value='".$row["balance"]."' class=\"text_purchase3_right\"/></td>
							 
							  <td ><input type=\"text\" size=\"10\" name=".$days."  disabled id=".$days." value='".$row['days']."' class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_per." disabled onBlur=\"cal_incentive('".$i."')\"  id=".$Incen_per." value='".$row['Incen_per']."' class=\"text_purchase3_right\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_val." disabled onBlur=\"cal_incentive_val('".$i."')\"  id=".$Incen_val." value='".$row['Incen_val']."' class=\"text_purchase3_right\"/></td>
            	            	
            	
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["inv_no"]."  name=".$row["inv_no"]." onClick=\"del_item('".$row["inv_no"]."');\"></td>
				<td ><a href=\"\" class=\"INV\" onClick=\"NewWindow('sales_inv_display.php?refno=".$row["inv_no"]."&trn_type=".$rstemp['TRN_TYPE']."','mywin','900','700','yes','center');return false\" onFocus=\"this.blur()\"><input type=\"button\" name=\"searchcust\" id=\"searchcust\" value=\"...\"  class=\"btn_purchase\"></a></td>
				</tr>"; 		
				
				if ((is_null($row['Incen_val'])==false) and ($row['Incen_val']!="")){
					$Incen_val_val=$Incen_val_val+$row['Incen_val'];
				}	
				$i=$i+1;
			}
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<Incen_val><![CDATA[".$Incen_val_val."]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";						
			
		}	 	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
		
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
	
}

	
	
	if($_GET["Command"]=="save_incent")
		{
		
					
					
						
		
		$sql_tmpinst= " update tmp_cash_credit_note_form set Incen_per=".$_GET["Incen_per"].", Incen_val=".$_GET["Incen_val"]." where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["inv_no"]."' and id=".$_GET["id"];
				echo $sql_tmpinst;
        	$result_tmpinst =$db->RunQuery($sql_tmpinst);
		
		}
		
		
	if($_GET["Command"]=="add_tmp")
		{
		
			$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="delete from tmp_purord_data where str_code='".$_GET['itemcode']."' and str_invno='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			
			//echo $_GET['rate'];
			//echo $_GET['qty'];
			
			$qty=str_replace(",", "", $_GET["qty"]);
			
			
			$sql="Insert into tmp_purord_data (str_invno, str_code, str_description, partno, qty)values 
			('".$_GET['invno']."', '".$_GET['itemcode']."', '".$_GET['item']."', '".$_GET["partno"]."', ".$qty.") ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);	
			
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Part No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                             
                            </tr>";
							
			
			$sql="Select * from tmp_purord_data where str_invno='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){				
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" >".$row['str_code']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['str_description']."</a></td>
							 <td bgcolor=\"#222222\" >".$row['partno']."</a></td>
							 <td bgcolor=\"#222222\" >".number_format($row['qty'], 2, ".", ",")."</a></td>
							 <td bgcolor=\"#222222\" ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row['str_code']."  name=".$row['str_code']." onClick=\"del_item('".$row['str_code']."');\"></td></tr>";
							 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	if($_GET["Command"]=="arn")
		{
		
			//$department=$_GET["department"];
			
			$ResponseXML .= "";
			$ResponseXML .= "<salesdetails>";
			
			
			$sql="select * from s_ordmas where REFNO='".$_GET['invno']."' ";
			//$ResponseXML .= $sql;
			$result =$db->RunQuery($sql);
			if($row = mysql_fetch_array($result)){
				$ResponseXML .= "<REFNO><![CDATA[".$row['REFNO']."]]></REFNO>";
				$ResponseXML .= "<SDATE><![CDATA[".$row['SDATE']."]]></SDATE>";
				$ResponseXML .= "<SUP_CODE><![CDATA[".$row['SUP_CODE']."]]></SUP_CODE>";
				$ResponseXML .= "<SUP_NAME><![CDATA[".$row['SUP_NAME']."]]></SUP_NAME>";
				$ResponseXML .= "<REMARK><![CDATA[".$row['REMARK']."]]></REMARK>";
				$ResponseXML .= "<DEP_CODE><![CDATA[".$row['DEP_CODE']."]]></DEP_CODE>";
				$ResponseXML .= "<DEP_NAME><![CDATA[".$row['DEP_NAME']."]]></DEP_NAME>";
				$ResponseXML .= "<REP_CODE><![CDATA[".$row['REP_CODE']."]]></REP_CODE>";
				$ResponseXML .= "<REP_NAME><![CDATA[".$row['REP_NAME']."]]></REP_NAME>";
				$ResponseXML .= "<S_date><![CDATA[".$row['S_date']."]]></S_date>";
				$ResponseXML .= "<LC_No><![CDATA[".$row['LC_No']."]]></LC_No>";
				$ResponseXML .= "<Brand><![CDATA[".$row['Brand']."]]></Brand>";
				$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
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
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Order Qty</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">FOB</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Cost</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Selling</font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Margin</font></td>
								 <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Sub Total</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$sql="Select * from s_ordtrn where REFNO='".$_GET['invno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$ord_qty="ord_qty".$i;
				$fob="fob".$i;
				$qty="qty".$i;
				$cost="cost".$i;
				$selling="selling".$i;
				$margin="margin".$i;
				$subtotal="subtotal".$i;
							
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value=".$row['STK_NO']." class=\"text_purchase3\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"text_purchase3\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$ord_qty." id=".$ord_qty."  value=".$row['ORD_QTY']." class=\"text_purchase3\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$fob." id=".$fob."  class=\"text_purchase3\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty."  class=\"text_purchase3\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$cost." id=".$cost."  class=\"text_purchase3\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$selling." id=".$selling."  class=\"text_purchase3\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$margin." id=".$margin."  class=\"text_purchase3\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$subtotal." id=".$subtotal."  class=\"text_purchase3\"/></td>
							</tr>";
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "   </table>]]></sales_table>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
				$ResponseXML .= " </salesdetails>";
				
		//	}	
				
				
				echo $ResponseXML;
				
			
	}
	
	
	

		
	if($_GET["Command"]=="del_item")
		{
		
			
			header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$sql_tmpinst= " delete from tmp_cash_credit_note_form where crn_form_no='".$_GET["txtrefno"]."' and inv_no='".$_GET["code"]."'";
	$result_tmpinst =$db->RunQuery($sql_tmpinst);
	
	$ResponseXML = "<salesdetails>";		
	
	
			
	$i = 1;
    $tot = 0;
   // Do While MSFlexGrid1.TextMatrix(i, 1) <> ""
        $mqty = 0;
     
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"\" ><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Amount</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Discount</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Incentive (%)</font></td>
							  <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Incentive Val</font></td>
                              <td width=\"100\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
                             
                            </tr>";		
			
			$Incen_val_val=0;
			
			$sql= "Select * from tmp_cash_credit_note_form where crn_form_no = '" .$_GET["txtrefno"]. "'";
			$result =$db->RunQuery($sql);
        	while ($row = mysql_fetch_array($result)){
			
						$Inv_date="Inv_date".$i;
						$inv_no="inv_no".$i;
						$Amount="Amount".$i;
						$disc="disc".$i;
						$Qty="Qty".$i;
						$Incen_per="Incen_per".$i;
						$Incen_val="Incen_val".$i;
						$Brands="Brands".$i;
						
					$ResponseXML .= "<tr>
                        
							 <td ><input type=\"text\" size=\"10\" name=".$Inv_date."  disabled id=".$Inv_date." value='".$row['Inv_date']."' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"30\" name=".$inv_no."  disabled id=".$inv_no." value='".$row["inv_no"]."' class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Amount."  disabled id=".$Amount." value=".$row['Amount']." class=\"text_purchase3\"/></td>
							 
							 <td ><input type=\"text\" size=\"10\" name=".$disc."  disabled id=".$disc." value=".$row['disc']." class=\"text_purchase3\"/></td>
							 <td ><input type=\"text\" size=\"10\" name=".$Qty."  disabled id=".$Qty." value=".$row['Qty']." class=\"text_purchase3\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_per."  onBlur=\"cal_incentive('".$i."')\" id=".$Incen_per." value='".$row['Incen_per']."' class=\"text_purchase3\"/></td>
				
				<td ><input type=\"text\" size=\"10\" name=".$Incen_val."  disabled id=".$Incen_val." value='".$row['Incen_val']."' class=\"text_purchase3\"/></td>
            	            	
            	<td ><input type=\"text\" size=\"10\" name=".$Brands."  disabled id=".$Brands." value=".$row['Brands']." class=\"text_purchase3\"/></td>
				
				<td ><img src=\"images/delete_01.png\" width=\"20\" height=\"20\" id=".$row["inv_no"]."  name=".$row["inv_no"]." onClick=\"del_item('".$row["inv_no"]."');\"></td></tr>"; 		
				
				if ((is_null($row['Incen_val'])==false) and ($row['Incen_val']!="")){
					$Incen_val_val=$Incen_val_val+$row['Incen_val'];
				}	
				$i=$i+1;
			}
							
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<Incen_val><![CDATA[".$Incen_val_val."]]></Incen_val>";	
			$ResponseXML .= "<mcou><![CDATA[".$i."]]></mcou>";	
			$ResponseXML .= "<msg><![CDATA[]]></msg>";						
			
	
			
        
    //Loop
    //txttot = Format(tot, "######.00")		
			
		
		$ResponseXML .= "</salesdetails>";		

		echo $ResponseXML;	
			
				
			
	}
	

	
if($_GET["Command"]=="save_item")
{

	if ($_SESSION["dev"]==""){
		exit("no");
	}

	include('connection.php');
	
	$sql_status=0;
			
	mysql_query("SET AUTOCOMMIT=0", $dbinv);
	mysql_query("START TRANSACTION", $dbinv);	
	
	$sql_invpara="SELECT * from invpara";
	$result_invpara=mysql_query($sql_invpara, $dbinv);
	$row_invpara = mysql_fetch_array($result_invpara);
			
	$vatrate=$row_invpara["vatrate"]/100;
			
	$ResponseXML .= "";
	$ResponseXML .= "<salesdetails>";
			
  if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)){
    $mrefno = trim($_GET["txtrefno"]);
	
    $sql_rscrnfrm= "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
	$result_rscrnfrm=mysql_query($sql_rscrnfrm, $dbinv);
		
    $sql_rscrn= "Select * From s_crnfrm where Refno = '" . $mrefno . "'";
	$result_rscrn=mysql_query($sql_rscrn, $dbinv);
	if($row_rscrnfrm = mysql_fetch_array($result_rscrnfrm)){	
		$row_rscrn = mysql_fetch_array($result_rscrn);	
        if ($row_rscrn["Lock1"] == "1") {
            exit ("Sorry this Credit note is locked");
            
        }
		$sql1= "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
		$result1=mysql_query($sql1, $dbinv);
		if ($result1!=1){ $sql_status=1; }	
				
		$sql1= "Delete from s_crnfrm where REfno = '" . $mrefno . "'";
		$result1=mysql_query($sql1, $dbinv);
		if ($result1!=1){ $sql_status=1; }	
        
        $i = 1;
        $mamount = 0;
        while ($_GET["mcou"]>$i){
			
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$disc="disc".$i;
			$Qty="Qty".$i;
			$Incen_per="Incen_per".$i;
			$Incen_val="Incen_val".$i;
			$Brands="Brands".$i;
			$settledate="settledate".$i;
			
		  if ($_GET[$Incen_val]!=""){	
			$sql1= "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag, tmp_no) values('" . $_GET["DTPicker1"] . "', '" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "', '" . trim($_GET["txt_cusname"]) . "', '" . $_GET["Com_rep"] . "', '" . $_GET[$settledate] . "','" . trim($_GET[$inv_no]) . "', '" . $_GET[$Inv_date] . "', '" . $_GET[$Amount] . "', '" . $_GET[$Qty] . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','CCRN', '".$_SESSION["credit_note_form"]."')";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=1; }	
			
		  }
          
            $mamount = $mamount + $_GET[$Incen_val];
            $i = $i + 1;
        }
        
		$sql1= "insert into s_crnfrm (Refno, Sdate, Code, Mon, Amount, Remark, Sal_ex, Flag, Checked, Lock1, Cancell, Credit_note, tmp_no, svatref, company) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "', '" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN', 'A', '0', '0', 'A', '".$_SESSION["credit_note_form"]."', '".$_GET["txt_svatref"]."', '" . $_SESSION['company'] . "')";
		$result1=mysql_query($sql1, $dbinv);
		if ($result1!=1){ $sql_status=1; }				
       
	    $sql1= "Update invpara set CCRNNO = CCRNNO+1";
		$result1=mysql_query($sql1, $dbinv);
		if ($result1!=1){ $sql_status=1; }		
		
		if ($sql_status==0){
			mysql_query("COMMIT", $dbinv);
			echo "Saved";
		}	else {
			mysql_query("ROLLBACK", $dbinv);
			echo "Error has occures. Can't Save";
		}
        
    	
		  
    } else {
        $i = 1;
        $mamount = 0;
        while ($_GET["mcou"]>$i){
			
			$Inv_date="Inv_date".$i;
			$inv_no="inv_no".$i;
			$Amount="Amount".$i;
			$disc="disc".$i;
			$Qty="Qty".$i;
			$Incen_per="Incen_per".$i;
			$Incen_val="Incen_val".$i;
			$Brands="Brands".$i;
			$settledate="settledate".$i;
			
			$sql1= "Insert into s_crnfrmtrn (Sdate, Refno, Code, Name, Sal_ex, Mon, Inv_no, Inv_date, Amount, Qty, Incen_per, Incen_val, Brand, Flag, tmp_no) values('" . $_GET["DTPicker1"] . "','" . $mrefno . "','" . trim($_GET["txt_cuscode"]) . "','" . trim($_GET["txt_cuscode"]) . "','" . $_GET["Com_rep"] . "', '" . $_GET[$settledate] . "','" . trim($_GET[$inv_no]) . "','" . $_GET[$Inv_date] . "','" . $_GET[$Amount] . "', '" . $_GET[$Qty] . "', '" . $_GET[$Incen_per] . "', '" . $_GET[$Incen_val] . "','" . $_GET[$Brands] . "','CCRN', '".$_SESSION["credit_note_form"]."')";
			$result1=mysql_query($sql1, $dbinv);
			           
            $mamount = $mamount + $_GET[$Incen_val];
            $i = $i + 1;
        }
        
		$sql1= "insert into s_crnfrm (Refno,sdate,code,mon,Amount,Remark,sal_ex,flag, Checked, Lock1, Cancell, Credit_note, tmp_no) Values('" . $mrefno . "','" . $_GET["DTPicker1"] . "', '" . trim($_GET["txt_cuscode"]) . "','" . $_GET["MonthView1"] . "', '" . $mamount . "','" . trim($_GET["txtremark"]) . "','" . $_GET["Com_rep"] . "','CCRN', 'A', '0', '0', 'A', '".$_SESSION["credit_note_form"]."')";
		$result1=mysql_query($sql1, $dbinv);
		
        
		$sql1= "Update invpara set CCRNNO = CCRNNO+1";
		$result1=mysql_query($sql1, $dbinv);
		
		if ($sql_status==0){
			mysql_query("COMMIT", $dbinv);
			echo "Saved";
		}	else {
			mysql_query("ROLLBACK", $dbinv);
			echo "Error has occures. Can't Save";
		}
      
    }
  } else {
  	echo "Can't Saved";
  }
		
}
	

	if($_GET["Command"]=="pass_arnno")
	{
		$ResponseXML .= "";
		$ResponseXML .= "<salesdetails>";
		$sql="Select * from s_purmas where REFNO='".$_GET['arnno']."'";
		$result =$db->RunQuery($sql);	
		if ($row = mysql_fetch_array($result)){
			$ResponseXML .= "<REFNO><![CDATA[".$row["REFNO"]."]]></REFNO>";
			$ResponseXML .= "<SDATE><![CDATA[".$row["SDATE"]."]]></SDATE>";
			$ResponseXML .= "<ORDNO><![CDATA[".$row["ORDNO"]."]]></ORDNO>";
			$ResponseXML .= "<LCNO><![CDATA[".$row["LCNO"]."]]></LCNO>";
			$ResponseXML .= "<COUNTRY><![CDATA[".$row["COUNTRY"]."]]></COUNTRY>";
			$ResponseXML .= "<SUP_CODE><![CDATA[".$row["SUP_CODE"]."]]></SUP_CODE>";
			$ResponseXML .= "<SUP_NAME><![CDATA[".$row["SUP_NAME"]."]]></SUP_NAME>";
			$ResponseXML .= "<REMARK><![CDATA[".$row["REMARK"]."]]></REMARK>";
			$ResponseXML .= "<DEPARTMENT><![CDATA[".$row["DEPARTMENT"]."]]></DEPARTMENT>";
			$ResponseXML .= "<AMOUNT><![CDATA[".$row["AMOUNT"]."]]></AMOUNT>";
			$ResponseXML .= "<PUR_DATE><![CDATA[".$row["PUR_DATE"]."]]></PUR_DATE>";
			$ResponseXML .= "<brand><![CDATA[".$row["brand"]."]]></brand>";
			$ResponseXML .= "<TYPE><![CDATA[".$row["TYPE"]."]]></TYPE>";
			
				$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"200\"  background=\"\" ><font color=\"#FFFFFF\">Code</font></td>
                              <td width=\"800\"  background=\"\"><font color=\"#FFFFFF\">Description</font></td>
                              <td width=\"300\"  background=\"\"><font color=\"#FFFFFF\">Unit</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Qty</font></td>
                              <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Pre. Ret. Qty</font></td>
							  <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Price</font></td>
							   <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Ret Qty</font></td>
							    <td width=\"200\"  background=\"\"><font color=\"#FFFFFF\">Value</font></td>
							
                            </tr>";
				
			$mcou=0;	
			$sql="Select count(*) as mcou from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			$row = mysql_fetch_array($result);
			$mcou=$row["mcou"]+1;
							
			$i=1;
			$tot=0;
			$sql="Select * from s_purtrn where REFNO='".$_GET['arnno']."'";
			$result =$db->RunQuery($sql);	
			while($row = mysql_fetch_array($result)){	
			
				$itemcode="itemcode".$i;
				$itemname="itemname".$i;
				$unit="unit".$i;
				$qty="qty".$i;
				$preretqty="preretqty".$i;
				$price="price".$i;
				$retqty="retqty".$i;
				$value="value".$i;
			
					
				if (($row['ret_qty']=="") or ($row['ret_qty']==0) or is_null($row['ret_qty'])){
					$val_ret_qty=0;
				}	else {
					$val_ret_qty=$row['ret_qty'];
				}
						
             	$ResponseXML .= "<tr>                              
                             <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemcode." id=".$itemcode."   value='".$row['STK_NO']."' class=\"text_purchase3\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$itemname." id=".$itemname."  value='".$row['DESCRIPT']."' class=\"text_purchase3\"/></td>
							  <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$unit." id=".$unit."  value='' class=\"text_purchase3\"/></td>
							
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$qty." id=".$qty." value='".$row['REC_QTY']."'  class=\"text_purchase3\"/></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$preretqty." id=".$preretqty." value='".$val_ret_qty."'  class=\"text_purchase3\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$price." id=".$price." value='".$row['SELLING']."'  class=\"text_purchase3\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$retqty." id=".$retqty." value=''  class=\"text_purchase3\" onBlur=\"cal_subtot('".$i."', '".$mcou."');\" /></td>
							 <td bgcolor=\"#222222\" ><input type=\"text\" size=\"15\" name=".$value." id=".$value." value=''  class=\"text_purchase3\"/></td>
							
							</tr>";
							$tot=$tot+($row['COST']*$row['REC_QTY']);
							$i=$i+1; 
                           
				}			
							
                $ResponseXML .= "</table>]]></sales_table>";
				$ResponseXML .= "<tot><![CDATA[".$tot."]]></tot>";
				$ResponseXML .= "<count><![CDATA[".$i."]]></count>";
		}
		
		
		
		$ResponseXML .= "</salesdetails>";
		echo $ResponseXML;
	}
	
if($_GET["Command"]=="cancel_inv")
{
	include('connection.php');
	
	$sql_status=0;
			
	mysql_query("SET AUTOCOMMIT=0", $dbinv);
	mysql_query("START TRANSACTION", $dbinv);	
	
	
	if (($_GET["txt_cuscode"] != "") and ($_GET["mcou"] > 0)) {
    	$mrefno = trim($_GET["txtrefno"]);
    	$sql_rscrnfrm= "Select * from s_crnfrmtrn where Refno = '" . $mrefno . "'";
		$result_rscrnfrm=mysql_query($sql_rscrnfrm, $dbinv);	
		if ($result_rscrnfrm!=1){ $sql_status=1; }	
				
    	$sql_rscrn= " Select * from s_crnfrm where Refno = '" . $mrefno . "'";
		$result_rscrn=mysql_query($sql_rscrn, $dbinv);	
		if($row_rscrnfrm = mysql_fetch_array($result_rscrnfrm)){	
			
			$row_rscrn = mysql_fetch_array($result_rscrn);
			
        	if ($row_rscrn["Lock1"] == "1") {
            	exit ("Sorry this credit note cannot Cancel");
            	
        	}
			$sql1= "Update s_crnfrm set Cancell = '1' where Refno = '" . $mrefno . "'";
			$result1=mysql_query($sql1, $dbinv);	
			if ($result1!=1){ $sql_status=1; }	
			
			$sql1= "Delete from s_crnfrmtrn where Refno = '" . $mrefno . "'";
			$result1=mysql_query($sql1, $dbinv);	
			if ($result1!=1){ $sql_status=1; }	
			
			if ($sql_status==0){
				mysql_query("COMMIT", $dbinv);
				echo "Canceled";
			}	else {
				mysql_query("ROLLBACK", $dbinv);
				echo "Error has occures. Can't Cancel";
			}
        	
        	        	
    	}
	}

}	

if ($_GET["Command"]=="set_month")
{
	
	 $_SESSION["MonthView1"]=$_GET["MonthView1"];
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