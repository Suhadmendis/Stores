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
	
	$ResponseXML = "";
		//$ResponseXML .= "<invdetails>";
			
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
						<tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sales Ex</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Amount</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Extn Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Approved</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Acc Appro</font></td>
						</tr>";
	
		
                           
						 //  $letters = $_GET['invno'];
						   
						 //  $sql = mysql_query("select * from s_invcheq where cheque_no like '$letters%' ORDER BY che_date desc limit 50") or die(mysql_error());
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
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
							$letters = $_GET['invno'];
							
							$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  ch_no like '".$letters."%' ORDER BY sdate desc limit 50";

							if ($_GET["mstatus"]=="Option1"){
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
							}	
							if ($_GET["mstatus"]=="Option2"){ 
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  approved = '0'  and  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
							}	
							if ($_GET["mstatus"]=="Option3"){ 
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  approved != '0' and acc_approved ='0' and  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
							}	
							if ($_GET["mstatus"]=="Option4"){
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  acc_approved !='0' and  ch_no like '" . $letters . "%' ORDER BY ch_exdate desc limit 50";
							}	

							//echo $sql;
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
								
									$ResponseXML .= "<tr>               
                              <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_no']."</a></td>
                              <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['refno']."</a></td>
                              <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['sal_ex']."</a></td>
							  <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_amount']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_date']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_exdate']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['approved']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['acc_approved']."</a></td>
                            </tr>";
							
							}
						
						
							
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="select_list"){
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
							
		echo "<table><tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Sales Ex</font></td>
                              <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Amount</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Chq Extn Date</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Approved</font></td>
							  <td width=\"176\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Acc Appro</font></td>
</tr>";
						
                            
							
							require_once("config.inc.php");
							require_once("DBConnector.php");
							$db = new DBConnector();
							
							$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend ORDER BY sdate desc limit 50";

							if ($_GET["mstatus"]=="Option1"){
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  ch_no like '" . $_GET["chqno"] . "%' ORDER BY ch_exdate desc limit 50";
							}	
							if ($_GET["mstatus"]=="Option2"){ 
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  approved = '0'  and  ch_no like '" . $_GET["chqno"] . "%' ORDER BY ch_exdate desc limit 50";
							}	
							if ($_GET["mstatus"]=="Option3"){ 
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  approved != '0' and acc_approved ='0' and  ch_no like '" . $_GET["chqno"] . "%' ORDER BY ch_exdate desc limit 50";
							}	
							if ($_GET["mstatus"]=="Option4"){
								$sql = "select ch_no, refno, sal_ex, ch_amount, ch_date, ch_exdate, approved, acc_approved  from  s_cheque_extend where  acc_approved !='0' and  ch_no like '" . $_GET["chqno"] . "%' ORDER BY ch_exdate desc limit 50";
							}	

							//echo $sql;
							$result =$db->RunQuery($sql);
							while($row = mysql_fetch_array($result)){
								
									echo "<tr>               
                              <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_no']."</a></td>
                              <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['refno']."</a></td>
                              <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['sal_ex']."</a></td>
							  <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_amount']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_date']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['ch_exdate']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['approved']."</a></td>
							   <td onclick=\"chq_extn('".$row['ch_no']."', '".$row['refno']."');\">".$row['acc_approved']."</a></td>
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
									$ResponseXML .= "<tr>
                              
                             			<td >".$row_rst['REF_NO']."</td>
							 			<td>".$row_rst['SDATE']."</td>
							 			<td >".$row_rst['GRAND_TOT']."</td>
							 			<td  >".$st_amou."</td>
							 			</tr>";
								}
   						 
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
								$ResponseXML .= "<tr>
                              
                             	<td >".$row_rst['REF_NO']."</td>
							 	<td>".$row_rst['SDATE']."</td>
							 	<td >".$row_rst['GRAND_TOT']."</td>
							 	<td  >".$st_amou."</a></td>
							 	</tr>";
							}
					}
				}	
      
			}	
	
			$ResponseXML .= "   </table>]]></sales_table>";
			
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}

if ($_GET["Command"]=="extend"){
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
			$txtchexdate="";
			if (trim($_GET["txtChequeNo"]) != ""){
				//$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."' and che_amount = '".$_GET["che_amount"]."'") or die(mysql_error());
				
				$sql = mysql_query("SELECT *  FROM s_cheque_extend WHERE refno = '".trim($_GET["ref_no"])."' ") or die(mysql_error());
				//$sql = mysql_query("select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and cus_code = '".$_GET["cusno"]."' ") or die(mysql_error());
				//echo "select * from  s_invcheq where  cheque_no='".trim($_GET["txtChequeNo"])."' and che_date = '".$_GET["che_date"]."'";
				if($row = mysql_fetch_array($sql)){
					//$ResponseXML .= "<lblReciptNo><![CDATA[".$row['refno']."]]></lblReciptNo>";
					$ResponseXML .= "<refno><![CDATA[".trim($row['refno'])."]]></refno>";
					$ResponseXML .= "<txtcode><![CDATA[".$row['c_code']."]]></txtcode>";
					$ResponseXML .= "<txtname><![CDATA[".$row['c_name']."]]></txtname>";
					$ResponseXML .= "<txtsal_ex><![CDATA[".$row['sal_ex']."]]></txtsal_ex>";
					
					$ResponseXML .= "<txtch_no><![CDATA[".$row['ch_no']."]]></txtch_no>";
					$ResponseXML .= "<txtch_amount><![CDATA[".$row['ch_amount']."]]></txtch_amount>";
					$ResponseXML .= "<txtch_date><![CDATA[".$row['ch_date']."]]></txtch_date>";
					$ResponseXML .= "<ch_exdate><![CDATA[".$row['ch_exdate']."]]></ch_exdate>";
					$ResponseXML .= "<approved><![CDATA[".$row['approved']."]]></approved>";
					$ResponseXML .= "<acc_approved><![CDATA[".$row['acc_approved']."]]></acc_approved>";
					$txtch_date=$row['ch_date'];
					$txtchexdate=$row['ch_exdate'];
				}
			}
			
			$refinv = "";
			$i = 1;
			$st_amou = 0;
			
			$ResponseXML .= "<sales_table><![CDATA[ <table><tr>
                              <td width=\"100\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Invoice No</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Inv/Del Date</font></td>
                              <td width=\"150\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Paid</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Cheque.Date</font></td>
                              <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Days</font></td>
							  <td width=\"100\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Extended Up To</font></td>
                            </tr>";
			
		  
			
					//echo "Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'";
					//$sql_inv = mysql_query("Select * from s_sttr where cus_code = '".trim($row['c_code'])."' and ST_CHNO = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['ch_date']."' ORDER BY ST_INVONO") or die(mysql_error());
					$sql_inv = mysql_query("Select * from s_sttr where cus_code = '".trim($row['c_code'])."' and ST_CHNO = '".trim($_GET["txtChequeNo"])."' ORDER BY ST_INVONO") or die(mysql_error());
					//echo "Select * from s_sttr where cus_code = '".trim($row['c_code'])."' and ST_CHNO = '".trim($_GET["txtChequeNo"])."' ORDER BY ST_INVONO";
					while($row_inv = mysql_fetch_array($sql_inv)){
						$refinv = $row_inv["ST_INVONO"];
        				$st_amou = $row_inv["ST_PAID"];
					//	echo "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'";
						$sql_rst = mysql_query("select * from s_salma where REF_NO='" . trim($refinv) . "'") or die(mysql_error());
						//echo "select * from s_salma where REF_NO='" . trim($refinv) . "'";
							if ($row_rst = mysql_fetch_array($sql_rst)){
								$ResponseXML .= "<tr>
                              
                             	<td >".$refinv."</td>";
								
							  if ((is_null($row_rst["deli_date"])==false) and ($row_rst["deli_date"]!="0000-00-00")){
							 	$ResponseXML .= "<td>".$row_rst['SDATE']."</td>
							 	<td align=right>".$row_inv["ST_PAID"]."</td>
								<td >".$row_inv["st_chdate"]."</td>";
								
								$date1 = $txtch_date;
								$date2 = $row_rst["deli_date"];
								$diff = abs(strtotime($date2) - strtotime($date1));
								$days = floor($diff / (60*60*24));
								//echo $date1."/".$date2."-";
								$ResponseXML .= "<td align=right >".$days."</td>";
								
								$date1 = $txtchexdate;
								$date2 = $row_rst["deli_date"];
								$diff = abs(strtotime($date2) - strtotime($date1));
								$days = floor($diff / (60*60*24));
								//echo $date1."/".$date2."-";
								$ResponseXML .="<td  align=right>".$days."</td>";
							 }	else {
							 
							 	$ResponseXML .= "<td>".$row_rst['SDATE']."</td>
							 	<td align=right >".$row_inv["ST_PAID"]."</td>
								<td >".$row_inv["st_chdate"]."</td>";
								
								$date1 = $txtch_date;
								$date2 = $row_rst["SDATE"];
								$diff = abs(strtotime($date2) - strtotime($date1));
								$days = floor($diff / (60*60*24));
								//echo $date1."/".$date2;
								$ResponseXML .= "<td  align=right>".$days."</td>";
								
								$date1 = $txtchexdate;
								$date2 = $row_rst["SDATE"];
								$diff = abs(strtotime($date2) - strtotime($date1));
								$days = floor($diff / (60*60*24));
								//echo $date1."/".$date2."-";
								$ResponseXML .="<td  align=right>".$days."</td>";
							 }
							 	$ResponseXML .="</tr>";
							}
					}
					
      
			
	
			$ResponseXML .= "   </table>]]></sales_table>";
			
			
			$sql_inv = mysql_query("select * from userpermission where username='" . $_SESSION['UserName'] . "' and docid='17'") or die(mysql_error());
			$row_rs = mysql_fetch_array($sql_inv);
			if ($row_rs["doc_feed"]=="1"){	
				$ResponseXML .= "<autho><![CDATA[1]]></autho>";
			} else {
				$ResponseXML .= "<autho><![CDATA[0]]></autho>";
			}
												
		$ResponseXML .= "</salesdetails>";	
		echo $ResponseXML; 
}

function chk_invo(&$txtch_no, &$txtcode, &$txtchexdate)
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$ii = 1;						
	$sql_rst = "Select ST_INVONO, ST_CHNO, ST_PAID from ch_sttr where ST_CHNO = '" . $txtch_no . "' and cus_code ='" . $txtcode . "' order by ST_INVONO ";
	$result_rst =$db->RunQuery($sql_rst);
	while($row_rst = mysql_fetch_array($result_rst)){
		
		$v = $row_rst["ST_PAID"];
        $sql_rs = "Select CR_C_CODE, CR_CHNO, CR_CHDATE from s_cheq where CR_REFNO = '" . trim($row_rst["ST_INVONO"]) . "'";
		$result_rs =$db->RunQuery($sql_rs);
		while($row_rs = mysql_fetch_array($result_rs)){
            
			if ($v != 0) {
                
            	$sql_rs1 = "Select ST_INVONO, ST_CHNO from ch_sttr where ST_CHNO = '" . trim($row_rs["CR_CHNO"]) . "' and cus_code= '" . trim($row_rs["CR_C_CODE"]) . "' order by ST_INVONO ";
				$result_rs1 =$db->RunQuery($sql_rs1);
				while($row_rs1 = mysql_fetch_array($result_rs1)){
                
                	if ($v != 0) {
                            
                    	$sql_rs2 = "Select CR_C_CODE, CR_CHNO, CR_CHDATE from s_cheq where CR_REFNO = '" . trim($row_rs1["ST_INVONO"]) . "'";
						$result_rs2 =$db->RunQuery($sql_rs2);
						while($row_rs2 = mysql_fetch_array($result_rs2)){
                            
                        	if ($v != 0) {
                                    
                            	$sql_rs3 = "Select ST_INVONO, ST_CHNO from ch_sttr where ST_CHNO = '" . trim($row_rs2["CR_CHNO"]) . "' and cus_code ='" . trim($row_rs2["CR_C_CODE"]) . "' order by ST_INVONO ";
                                $result_rs3 =$db->RunQuery($sql_rs3);
								while($row_rs3 = mysql_fetch_array($result_rs3)){
                                            
									if ($v != 0){
                                                
                                    	$sql_rs4 = "Select CR_C_CODE, CR_CHNO, CR_CHDATE from s_cheq where CR_REFNO = '" . trim($row_rs3["ST_INVONO"]) . "'";
										$result_rs4 =$db->RunQuery($sql_rs4);
										while($row_rs4 = mysql_fetch_array($result_rs4)){
                                        
                                        	if ($v != 0) {
                                            	
												$sql_rs5 = "select *    from s_sttr where  ST_CHNO= '" . trim($row_rs4["CR_CHNO"]) . "' and cus_code = '" . trim($row_rs4["CR_C_CODE"]) . "'  ORDER BY ST_INVONO";
                                                $result_rs5 =$db->RunQuery($sql_rs5);
												while($row_rs5 = mysql_fetch_array($result_rs5)){
                                                                
													if ($v != 0) {
                                                    	
                                                        $sql_rs6 = "Select SDATE, deli_date, class from VIEW_S_SALMA_BRAND_MAS where  REF_NO='" . trim($row_rs5["ST_INVONO"]) . "' ";
														$result_rs6 =$db->RunQuery($sql_rs6);
														while($row_rs6 = mysql_fetch_array($result_rs6)){
                                                                    
                                                                    $MSFlexGrid1.TextMatrix[$ii][1] = $row_rs5["ST_INVONO"];
                                                                    if ($v < $row_rs5["ST_PAID"]) {
                                                                        $MSFlexGrid1[$ii][3] = $v;
                                                                        $v = 0;
                                                                    } else {
                                                                        $MSFlexGrid1[$ii][3] = $row_rs5["ST_PAID"];
                                                                        $v = $v - $row_rs5["ST_PAID"];
                                                                    }
                                                                    $MSFlexGrid1[$ii][4] = $row_rs5["ST_CHDATE"];
																	
																	$result_rs61 =$db->RunQuery($sql_rs6);
																	if($row_rs61 = mysql_fetch_array($result_rs61)){
														
                                                                       if (is_null($row_rs61["DELI_DATE"])==false) {
                                                                         	$MSFlexGrid1[$ii][2] = $row_rs61["SDATE"];
                                                                         	$MSFlexGrid1[$ii][5] = $row_rs5["ST_CHDATE"] - $row_rs61["SDATE"];
                                                                         	$MSFlexGrid1[$ii][6] = $txtchexdate - $row_rs61["SDATE"];
                                                                       } else {
                                                                         	$MSFlexGrid1[$ii][2] = $row_rs61["DELI_DATE"];
                                                                         	$MSFlexGrid1[$ii][5] = $row_rs5["ST_CHDATE"] - $row_rs61["DELI_DATE"];
                                                                         	$MSFlexGrid1[$ii][6] = $txtchexdate - $row_rs61["DELI_DATE"];
                                                                       }
                                                                    }
                                                                   /* if ($row_rs5["deliin_amo"] > 0) {
                                                                        
																		$sql_rs_in = "Select * from Ins_payment where cuscode = '" . trim($row_rs5["cus_code"]) . "' and I_year = '" . date("Y", strtotime($row_rs6["SDATE"])) . "' and I_month = '" . date("m", strtotime($row_rs6["SDATE"])) . "' and type = '" . trim($row_rs6["class"]) . "'";
																		$result_rs_in =$db->RunQuery($sql_rs_in);
																		if($row_rs_in = mysql_fetch_array($result_rs_in)){
                                                                       
                                                                            if ($row_rs_in["chno"] != "X") {
                                                                                Lbl_tinc.Visible = True
                                                                                MSFlexGrid1.Row = ii
                                                                                For colcount = MSFlexGrid1.FixedCols To MSFlexGrid1.Cols - 1
                                                                                    MSFlexGrid1.Col = colcount
                                                                                    MSFlexGrid1.CellBackColor = vbRed
                                                                                Next
                                                                            End If
                                                                        End If
                                                                        rs_in.Close
                                                                    End If
                                                                    rs6.Close*/
                                                                    $ii = $ii + 1;
                                                                }
                                                                
                                                            }
                                                        } else {
                                                            //Lbl_tinc.Visible = True
                                                            //Lbl_tinc.Caption = "Chq return more than 4 Times"
                                                        }
                                                        
                                                    }
                                                    
                                                }
                                                
                                            }
                                            
                                        }
                                    } else {
                                        $sql_rs5 = "select *    from s_sttr where  ST_CHNO= '" . trim($row_rs2["CR_CHNO"]) . "' and cus_code = '" . trim($row_rs2["CR_C_CODE"]) . "'  ORDER BY ST_INVONO";
                                        $result_rs5 =$db->RunQuery($sql_rs5);
										while($row_rs5 = mysql_fetch_array($result_rs5)){
                                        
                                        	if ($v != 0) {
                                                    
                                            	$sql_rs6 = "Select SDATE, deli_date, class from VIEW_S_SALMA_BRAND_MAS where  REF_NO='" . trim($row_rs5["ST_INVONO"]) . "' ";
												
                                                    
                                             	$MSFlexGrid1[$ii][1] = $row_rs5["ST_INVONO"];
                                                if ($v < $row_rs5["ST_PAID"]) {
                                                	$MSFlexGrid1[$ii][3] = $v;
                                                    $v = 0;
                                                } else {
                                                    $MSFlexGrid1[$ii][3] = $row_rs5["ST_PAID"];
                                                    $v = $v - $row_rs5["ST_PAID"];
                                                }
                                                $MSFlexGrid1[$ii][4] = $row_rs5["ST_CHDATE"];
                                                
												$result_rs6 =$db->RunQuery($sql_rs6);
												if($row_rs6 = mysql_fetch_array($result_rs6)){
                                                	if (is_null($row_rs6["DELI_DATE"])==false) {
                                                         $MSFlexGrid1[$ii][2] = $row_rs6["SDATE"];
                                                         $MSFlexGrid1[$ii][5] = $row_rs5["ST_CHDATE"] - $row_rs6["SDATE"];
                                                         $MSFlexGrid1[$ii][6] = $txtchexdate - $row_rs6["SDATE"];
                                                    } else {
                                                         $MSFlexGrid1[$ii][2] = $row_rs6["DELI_DATE"];
                                                         $MSFlexGrid1[$ii][5] = $row_rs5["ST_CHDATE"] - $row_rs6["DELI_DATE"];
                                                         $MSFlexGrid1[$ii][6] = $txtchexdate - $row_rs6["DELI_DATE"];
                                                    }
                                                 }
                                                 if ($row_rs5["deliin_amo"] > 0) {
                                                 	$sql_rs_in = "Select * from Ins_payment where cuscode = '" . trim($row_rs5["Cus_Code"]) . "' and I_year = '" . date("Y", strtotime($row_rs6["SDATE"])) . "' and I_month = '" . date("m", strtotime($row_rs6["SDATE"])) . "' and type = '" . trim($row_rs6["Class"]) . "'";
													$result_rs_in =$db->RunQuery($sql_rs_in);
													if($row_rs_in = mysql_fetch_array($result_rs_in)){
                          						    	if ($row_rs_in["chno"] <> "X") {
                                                        	Lbl_tinc.Visible = True
                                                            MSFlexGrid1.Row = ii
                                                            For colcount = MSFlexGrid1.FixedCols To MSFlexGrid1.Cols - 1
                                                            	MSFlexGrid1.Col = colcount
                                                                MSFlexGrid1.CellBackColor = vbRed
                                                            Next
                                                        End If
                                                     End If
                                                     rs_in.Close
                                                  End If
                                                    rs6.Close
                                                    ii = ii + 1
                                                End If
                                                rs5.MoveNext
                                            Loop
                                        Else
                                            Lbl_tinc.Visible = True
                                            Lbl_tinc.Caption = "No Records Found"
                                        End If
                                        rs5.Close
                                    End If
                                    rs3.Close
                                End If
                                rs2.MoveNext
                            Loop
                            rs2.Close
                        End If
                        rs1.MoveNext
                    Loop
                Else
                    rs5.Open "select *    from s_sttr where  ST_CHNO= '" & Trim(rs!cr_chno) & "' and cus_code = '" & Trim(rs!CR_C_CODE) & "'  ORDER BY ST_INVONO", dnINV.conINV
                    If Not rs5.EOF Then
                        Do While Not rs5.EOF
                            If v = 0 Then
                                rs5.MoveLast
                            Else
                                rs6.Open "Select sdate,deli_date,class from VIEW_S_SALMA_BRAND_MAS where  ref_no='" & Trim(rs5!ST_INVONO) & "' ", dnINV.conINV
                                
                                MSFlexGrid1.TextMatrix(ii, 1) = rs5!ST_INVONO
                                
                                If v < rs5!ST_PAID Then
                                    MSFlexGrid1.TextMatrix(ii, 3) = v
                                    v = 0
                                Else
                                    MSFlexGrid1.TextMatrix(ii, 3) = rs5!ST_PAID
                                    v = v - rs5!ST_PAID
                                End If
                                MSFlexGrid1.TextMatrix(ii, 4) = rs5!ST_CHDATE
                                If Not rs6.EOF Then
                                   If IsNull(rs6!DELI_DATE) Then
                                     MSFlexGrid1.TextMatrix(ii, 2) = rs6!SDATE
                                     MSFlexGrid1.TextMatrix(ii, 5) = rs5!ST_CHDATE - rs6!SDATE
                                     MSFlexGrid1.TextMatrix(ii, 6) = txtchexdate - rs6!SDATE
                                   Else
                                     MSFlexGrid1.TextMatrix(ii, 2) = rs6!DELI_DATE
                                     MSFlexGrid1.TextMatrix(ii, 5) = rs5!ST_CHDATE - rs6!DELI_DATE
                                     MSFlexGrid1.TextMatrix(ii, 6) = txtchexdate - rs6!DELI_DATE
                                   End If
                                End If
                                If rs5!deliin_amo > 0 Then
                                    rs_in.Open "Select * from Ins_payment where cuscode = '" & Trim(rs5!Cus_Code) & "' and i_year = '" & year(rs6!SDATE) & "' and i_month = '" & Month(rs6!SDATE) & "' and type = '" & Trim(rs6!Class) & "'", dnINV.conINV
                                    If Not rs_in.EOF Then
                                        If rs_in!chno <> "X" Then
                                            Lbl_tinc.Visible = True
                                            MSFlexGrid1.Row = ii
                                            For colcount = MSFlexGrid1.FixedCols To MSFlexGrid1.Cols - 1
                                                MSFlexGrid1.Col = colcount
                                                MSFlexGrid1.CellBackColor = vbRed
                                            Next
                                        End If
                                    End If
                                    rs_in.Close
                                End If
                                rs6.Close
                                ii = ii + 1
                            End If
                            rs5.MoveNext
                        Loop
                    Else
                        Lbl_tinc.Visible = True
                        Lbl_tinc.Caption = "No Records Found"
                    End If
                    rs5.Close
                End If
                rs1.Close
            End If
            rs.MoveNext
        Loop
        rs.Close
        rst.MoveNext
    Loop
Else
    strsql = "select *    from s_sttr where  ST_CHNO= '" & Trim(txtch_no) & "' and cus_code = '" & Trim(txtcode) & "'  ORDER BY ST_INVONO"
    Set rs.ActiveConnection = dnINV.conINV
    rs.Open strsql
    Do While Not rs.EOF
       rs1.Open "Select sdate,deli_date,class from VIEW_S_SALMA_BRAND_MAS where  ref_no='" & Trim(rs!ST_INVONO) & "' ", dnINV.conINV
       
       MSFlexGrid1.TextMatrix(ii, 1) = rs!ST_INVONO
       
       MSFlexGrid1.TextMatrix(ii, 3) = rs!ST_PAID
       MSFlexGrid1.TextMatrix(ii, 4) = rs!ST_CHDATE
       If Not rs1.EOF Then
          If IsNull(rs1!DELI_DATE) Then
            MSFlexGrid1.TextMatrix(ii, 2) = rs1!SDATE
            MSFlexGrid1.TextMatrix(ii, 5) = rs!ST_CHDATE - rs1!SDATE
            MSFlexGrid1.TextMatrix(ii, 6) = txtchexdate - rs1!SDATE
          Else
            MSFlexGrid1.TextMatrix(ii, 2) = rs1!DELI_DATE
            MSFlexGrid1.TextMatrix(ii, 5) = rs!ST_CHDATE - rs1!DELI_DATE
            MSFlexGrid1.TextMatrix(ii, 6) = txtchexdate - rs1!DELI_DATE
          End If
       End If
       Dim cls As String
       If rs!deliin_amo > 0 Then
            If rs1!Class = "ALLOY WHEEL" Then
                cls = "TYRE"
            Else
                cls = rs1!Class
            End If
            rs_in.Open "Select * from Ins_payment where cuscode = '" & Trim(rs!Cus_Code) & "' and i_year = '" & year(rs1!SDATE) & "' and i_month = '" & Month(rs1!SDATE) & "' and type = '" & cls & "'", dnINV.conINV
            If Not rs_in.EOF Then
                If rs_in!chno <> "X" Then
                    Lbl_tinc.Visible = True
                    MSFlexGrid1.Row = ii
                    For colcount = MSFlexGrid1.FixedCols To MSFlexGrid1.Cols - 1
                        MSFlexGrid1.Col = colcount
                        MSFlexGrid1.CellBackColor = vbRed
                    Next
                End If
            End If
            rs_in.Close
        End If
       rs1.Close
       
       ii = ii + 1
       rs.MoveNext
    Loop
    rs.Close
End If

}
?>
