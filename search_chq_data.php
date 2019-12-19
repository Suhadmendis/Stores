<?php

/*
	include_once("config.inc.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =$db->RunQuery($sql);
			
			
			while($row = mysql_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		
session_start();


	include_once("connection.php");

if ($_GET["Command"]=="search_inv"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">";
					
					if ($_GET["stname"]=="extend"){
						$ResponseXML .="  <tr>
                             <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque Date</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque Amount</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Bank</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
   							</tr>";
					} else {
                          $ResponseXML .="  <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque Date</font></td>
                             <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque Amount</font></td>
							 <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Bank</font></td>
							 <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
   							</tr>";
					}		
                           
						   $letters = $_GET['invno'];
						   
						   $sql = mysql_query("select * from s_invcheq where cheque_no like '$letters%' ORDER BY che_date desc limit 50") or die(mysql_error());
						 //  echo "select * from s_invcheq where cheque_no like '$letters%' ORDER BY che_date desc limit 50";
							/*if ($_GET["mstatus"]=="invno"){
						   		$letters = $_GET['invno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
								$sql = mysql_query("SELECT * from s_purmas where  REFNO like  '$letters%' order by id desc") or die(mysql_error());
							} else if ($_GET["mstatus"]=="customername"){
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_purmas where SUP_NAME like  '$letters%' order by id desc") or die(mysql_error()) or die(mysql_error());
							} else {
								$letters = $_GET['customername'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql = mysql_query("SELECT * from s_purmas where SUP_NAME like  '$letters%' order by id desc") or die(mysql_error()) or die(mysql_error());
							}*/
							
													
						
							while($row = mysql_fetch_array($sql)){
								$REF_NO = $row['REF_NO'];
								$stname = "inv_mast";
								
								if ($_GET["stname"]=="extend"){
									
									$ResponseXML .= "<tr>               
                              <td onclick=\"chq_extn('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['cheque_no']."</a></td>
                              <td onclick=\"chq_extn('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['che_date']."</a></td>
                              <td onclick=\"chq_extn('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['che_amount']."</a></td>
							  <td onclick=\"chq_extn('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['bank']."</a></td>
							   <td onclick=\"chq_extn('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['CUS_NAME']."</a></td>
                            </tr>";
								
								} else if ($_GET["stname"]=="modify"){
									
									$ResponseXML .= "<tr>               
                              <td onclick=\"chq_mod('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['cheque_no']."</a></td>
                              <td onclick=\"chq_mod('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['che_date']."</a></td>
                              <td onclick=\"chq_mod('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['che_amount']."</a></td>
							  <td onclick=\"chq_mod('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['bank']."</a></td>
							   <td onclick=\"chq_mod('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."', '".$row['cus_code']."');\">".$row['CUS_NAME']."</a></td>
                            </tr>";
								
								} else {
							
									$ResponseXML .=  "<tr>               
                              <td onclick=\"ret_chq('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."');\">".$row['cheque_no']."</a></td>
                              <td onclick=\"ret_chq('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."');\">".$row['che_date']."</a></td>
                              <td onclick=\"ret_chq('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."');\">".$row['che_amount']."</a></td>
							  <td onclick=\"ret_chq('".$row['cheque_no']."', '".$row['che_date']."', '".$row['che_amount']."', '".$_GET['stname']."');\">".$row['bank']."</a></td>
                            </tr>";
								}
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="select_list"){
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
							
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
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Invoice Date</font></td>
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

if ($_GET["Command"]=="pass_arr"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			if (trim($_GET["txtChequeNo"]) != ""){
				//$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysql_error());
				
				$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' ") or die(mysql_error());
				//echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."'";
				if($row = mysql_fetch_array($sql)){
					//$ResponseXML .= "<lblReciptNo><![CDATA[".$row['refno']."]]></lblReciptNo>";
					$ResponseXML .= "<Txtcusco><![CDATA[".$row['cus_code']."]]></Txtcusco>";
					$ResponseXML .= "<txtcusname><![CDATA[".$row['CUS_NAME']."]]></txtcusname>";
					
					$sql1 = mysql_query("Select * from s_salrep where REPCODE='".$row["sal_ex"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$ResponseXML .= "<com_rep><![CDATA[".$row1['REPCODE']."]]></com_rep>";
					}	else {
						$ResponseXML .= "<com_rep><![CDATA[]]></com_rep>";
					}
					$ResponseXML .= "<txtChequeNo><![CDATA[".$row['cheque_no']."]]></txtChequeNo>";
					$ResponseXML .= "<txtChequeAmount><![CDATA[".$row['che_amount']."]]></txtChequeAmount>";
					$ResponseXML .= "<cmbBankname><![CDATA[".$row['bank']."]]></cmbBankname>";
					$ResponseXML .= "<txtrctdate><![CDATA[".$row['SDATE']."]]></txtrctdate>";
					$ResponseXML .= "<DTPicker2><![CDATA[".$row['che_date']."]]></DTPicker2>";
					$ResponseXML .= "<lblRET_chno><![CDATA[".$row['ret_chno']."]]></lblRET_chno>";
					$ResponseXML .= "<lblretrefno><![CDATA[".$row['ret_refno']."]]></lblretrefno>";
					$ResponseXML .= "<lblretdate><![CDATA[".$row['ret_chdate']."]]></lblretdate>";
					$ResponseXML .= "<lblnoof><![CDATA[".$row['noof']."]]></lblnoof>";
					
					$sql_chq = mysql_query("select * from  s_cheq where  CR_CHNO='".trim($_GET["txtChequeNo"])."' order by id desc ") or die(mysql_error());
					if($row_chq = mysql_fetch_array($sql_chq)){
						$ResponseXML .= "<cheq_dpo_bank><![CDATA[".$row_chq['depobank']."]]></cheq_dpo_bank>";
						$ResponseXML .= "<reason><![CDATA[".$row_chq['reason']."]]></reason>";
						$ResponseXML .= "<REMARK><![CDATA[".$row_chq['REMARK']."]]></REMARK>";
						
						
						include('connection.php');
						
						$sql_led = "select * from  ledger where  l_refno='".$row_chq['CR_REFNO']."' ";
						$result_led=mysql_query($sql_led, $dbacc);
						$row_led = mysql_fetch_array($result_led);
						$ResponseXML .= "<bank_st_date><![CDATA[".$row_led['l_date']."]]></bank_st_date>";
						
					} else {
						$ResponseXML .= "<cheq_dpo_bank><![CDATA[]]></cheq_dpo_bank>";
						$ResponseXML .= "<reason><![CDATA[]]></reason>";
						$ResponseXML .= "<REMARK><![CDATA[]]></REMARK>";
						//$ResponseXML .= "<lblReciptNo><![CDATA[]]></lblReciptNo>";
						$ResponseXML .= "<bank_st_date><![CDATA[]]></bank_st_date>";
					}
				}
			}
			
			$refinv = "";
			$i = 1;
			$st_amou = 0;
			$a=1;
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Inv No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv Amt</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">St. Amt</font></td>
                             
                            </tr>";
			
		  
			//echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = ".$_GET["che_amount"];
			$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = ".$_GET["che_amount"]) or die(mysql_error());
			if($row = mysql_fetch_array($sql)){
				if (trim($row["trn_type"]) == "RET") {
				//	echo "select * from ch_sttr where ST_CHNO = '".trim($_GET["txtChequeNo"])."' and ST_INDATE = '".$row['che_date']."'";
					$sql1 = mysql_query("select * from ch_sttr where ST_CHNO = '".trim($_GET["txtChequeNo"])."' and ST_INDATE = '".$row['che_date']."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
					//	echo "select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'";
						$sql_his = mysql_query("select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'") or die(mysql_error());
						while($row_his = mysql_fetch_array($sql_his)){
							$refinv = $row_his["Inv_no"];
							$sql_rs = mysql_query("select * from  ret_ch_sett where CR_REFNO = '".trim($row1["ST_INVONO"])."' and  ST_CHNO = '" .trim($_GET["txtChequeNo"])."' and ret_chno = '".$row_his["chk_no"]."'") or die(mysql_error());
							$row_rs = mysql_fetch_array($sql_rs);
							
							if (is_null($row_his["st_amt"])==false) { $st_amou=$row_his["st_amt"]; }
								
								$sql_rst = mysql_query("select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysql_error());
								if ($row_rst = mysql_fetch_array($sql_rst)){
									
                              			$REF_NO="REF_NO_".$a;
										$SDATE="SDATE_".$a;
										$GRAND_TOT="GRAND_TOT_".$a;
										$st_amou_name="st_amou_".$a;
										
									$ResponseXML .= "<tr>	
                             			<td ><div id=".$REF_NO.">".$row_rst['REF_NO']."</div></td>
							 			<td><div id=".$SDATE.">".$row_rst['SDATE']."</div></td>
							 			<td ><div id=".$GRAND_TOT.">".$row_rst['GRAND_TOT']."</div></td>
							 			<td  ><div id=".$st_amou_name.">".$st_amou."</div></td>
							 			</tr>";
										
										$a=$a+1;
										
								}
								$st_amou=0;
   						 
    					}
					}
				} else {
					//echo "Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'";
					$sql_inv = mysql_query("Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and ST_CHNO = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'") or die(mysql_error());
					while($row_inv = mysql_fetch_array($sql_inv)){
						$refinv = $row_inv["ST_INVONO"];
        				$st_amou = $row_inv["ST_PAID"];
					//	echo "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'";
						$sql_rst = mysql_query("select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysql_error());
							if ($row_rst = mysql_fetch_array($sql_rst)){
								
								
								$REF_NO="REF_NO_".$a;
										$SDATE="SDATE_".$a;
										$GRAND_TOT="GRAND_TOT_".$a;
										$st_amou_name="st_amou_".$a;
										
								$ResponseXML .= "<tr>
                              
                             	<td ><div id=".$REF_NO.">".$row_rst['REF_NO']."</div></td>
							 	<td><div id=".$SDATE.">".$row_rst['SDATE']."</div></td>
							 	<td ><div id=".$GRAND_TOT.">".$row_rst['GRAND_TOT']."</div></td>
							 	<td  ><div id=".$st_amou_name.">".$st_amou."</div></td>
							 	</tr>";
								
								$a=$a+1;
								
							}
							$st_amou=0;
					}
				}	
      
			}	
	
			$ResponseXML .= "   </table>]]></sales_table>";
			$ResponseXML .= "<mcount><![CDATA[".$a."]]></mcount>";
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}

if ($_GET["Command"]=="extend"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			if (trim($_GET["txtChequeNo"]) != ""){
				//$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysql_error());
				
				$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and cus_code = '".$_GET["cusno"]."' ") or die(mysql_error());
				//echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."'";
				if($row = mysql_fetch_array($sql)){
					//$ResponseXML .= "<lblReciptNo><![CDATA[".$row['refno']."]]></lblReciptNo>";
					$ResponseXML .= "<txtcode><![CDATA[".$row['cus_code']."]]></txtcode>";
					$ResponseXML .= "<txtname><![CDATA[".$row['CUS_NAME']."]]></txtname>";
					
					$ResponseXML .= "<refno><![CDATA[".$row['refno']."]]></refno>";
					$ResponseXML .= "<recdate><![CDATA[".$row['Sdate']."]]></recdate>";
					
					$sql1 = mysql_query("Select * from s_salrep where REPCODE='".$row["sal_ex"]."'") or die(mysql_error());
					if($row1 = mysql_fetch_array($sql1)){
						$ResponseXML .= "<com_rep><![CDATA[".$row1['REPCODE']."]]></com_rep>";
						$ResponseXML .= "<txtsal_ex><![CDATA[".$row1['Name']."]]></txtsal_ex>";
					}	else {
						$ResponseXML .= "<com_rep><![CDATA[]]></com_rep>";
						$ResponseXML .= "<txtsal_ex><![CDATA[]]></txtsal_ex>";
					}
					$ResponseXML .= "<txtch_no><![CDATA[".$row['cheque_no']."]]></txtch_no>";
					$ResponseXML .= "<txtch_amount><![CDATA[".$row['che_amount']."]]></txtch_amount>";
					$ResponseXML .= "<txtch_date><![CDATA[".$row['che_date']."]]></txtch_date>";
				
					
					
				}
			}
			
			$refinv = "";
			$i = 1;
			$st_amou = 0;
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"300\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv/Del Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Paid</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque.Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Extended Up To</font></td>
                            </tr>";
			
		  
			
					//echo "Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'";
					$sql_inv = mysql_query("Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and ST_CHNO = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."' ORDER BY ST_INVONO") or die(mysql_error());
					while($row_inv = mysql_fetch_array($sql_inv)){
						$refinv = $row_inv["ST_INVONO"];
        				$st_amou = $row_inv["ST_PAID"];
					//	echo "select * from s_salma where REF_NO='" . trim($refinv) . "'";
						$sql_rst = mysql_query("select * from s_salma where REF_NO='" . trim($refinv) . "'") or die(mysql_error());
							if ($row_rst = mysql_fetch_array($sql_rst)){
								$ResponseXML .= "<tr>
                              
                             	<td >".$refinv."</td>";
								
								if (is_null($row_rst["deli_date"])==true){
							 		
									
									$date1 = $row_inv["st_chdate"];
									$date2 = $row_rst['SDATE'];
									$diff = abs(strtotime($date2) - strtotime($date1));
									$days1 = floor($diff / (60*60*24));
									
									$date1 = $_GET["txtchexdate"];
									$date2 = $row_rst['SDATE'];
									$diff = abs(strtotime($date2) - strtotime($date1));
									$days2 = floor($diff / (60*60*24));
									
									$ResponseXML .="<td>".$row_rst['SDATE']."</td>";
									$ResponseXML .="<td>".$row_inv['ST_PAID']."</td>";
									$ResponseXML .="<td>".$row_inv["st_chdate"]."</td>";
									$ResponseXML .="<td>".$days1."</td>";
									$ResponseXML .="<td>".$days2."</td>";
									
								} else {
									$date1 = $row_inv["st_chdate"];
									$date2 = $row_rst["deli_date"];
									$diff = abs(strtotime($date2) - strtotime($date1));
									$days1 = floor($diff / (60*60*24));
									
									$date1 = $_GET["txtchexdate"];
									$date2 = $row_rst["deli_date"];
									$diff = abs(strtotime($date2) - strtotime($date1));
									$days2 = floor($diff / (60*60*24));
									
									$ResponseXML .="<td>".$row_rst["deli_date"]."</td>";
									$ResponseXML .="<td>".$row_inv['ST_PAID']."</td>";
									$ResponseXML .="<td>".$row_inv["st_chdate"]."</td>";
									$ResponseXML .="<td>".$days1."</td>";
									$ResponseXML .="<td>".$days2."</td>";
								}
							 	
							 	$ResponseXML .="</tr>";
							}
					}
					
      
			
	
			$ResponseXML .= "   </table>]]></sales_table>";
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}

if ($_GET["Command"]=="modify"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			
			//if (trim($_GET["txtChequeNo"]) != ""){
				//$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysql_error());
				
				$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and cus_code = '".$_GET["cusno"]."' ") or die(mysql_error());
				//echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."'";
				if($row = mysql_fetch_array($sql)){
					//$ResponseXML .= "<lblReciptNo><![CDATA[".$row['refno']."]]></lblReciptNo>";
					$ResponseXML .= "<txtcode><![CDATA[".$row['cus_code']."]]></txtcode>";
					$ResponseXML .= "<txtname><![CDATA[".$row['CUS_NAME']."]]></txtname>";
					$ResponseXML .= "<cheque_no><![CDATA[".$row['cheque_no']."]]></cheque_no>";
					$ResponseXML .= "<txtch_amount><![CDATA[".$row['che_amount']."]]></txtch_amount>";
					$ResponseXML .= "<txtbank><![CDATA[".$row['bank']."]]></txtbank>";
					$ResponseXML .= "<recdate><![CDATA[".$row['Sdate']."]]></recdate>";
					$ResponseXML .= "<che_date><![CDATA[".$row['che_date']."]]></che_date>";
					$ResponseXML .= "<trn_type><![CDATA[".$row['trn_type']."]]></trn_type>";
					
					if (trim($row['ex_flag'])=="N"){
						$ResponseXML .= "<lblmodi><![CDATA[Not Modified]]></lblmodi>";
						$ResponseXML .= "<ex_date1><![CDATA[]]></ex_date1>";
						$ResponseXML .= "<ex_date2><![CDATA[]]></ex_date2>";
					} else {
						$ResponseXML .= "<lblmodi><![CDATA[Modified]]></lblmodi>";
						$ResponseXML .= "<ex_date1><![CDATA[".$row['ex_date1']."]]></ex_date1>";
						$ResponseXML .= "<ex_date2><![CDATA[".$row['ex_date2']."]]></ex_date2>";
					}
					
				}	
					
				
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}
?>
