<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	 date_default_timezone_set('Asia/Colombo'); 
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	$msset = array(array());
	
		
if($_GET["Command"]=="addchq_cash_rec")
{
		
			//echo "Regt=".$Regt."RegimentNo=".RegimentNo."Command=".$Command;addchq_cash_rec
		
		$sql="delete from tmp_ret_chq_sett where recno='".$_GET["invno"]."' and chqno='".$_GET["chqno"]."'";
		$result =$db->RunQuery($sql);
		
		$sql="insert into tmp_ret_chq_sett(recno, chqno, chqdate, chqbank, chqamt) values ('".$_GET["invno"]."', '".$_GET["chqno"]."', '".$_GET["chqdate"]."', '".$_GET["bank"]."', '".$_GET["chqamt"]."')";
		//echo $sql;
		$result =$db->RunQuery($sql);
			
			$totchq=0;
			$ResponseXML = "";
			$ResponseXML .= "<salesdetails>";
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_ret_chq_sett where recno='".$_GET["invno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td>".$row["chqbank"]."</td>
					<td align=right>".number_format($row["chqamt"], 2, ".", ",")."</td>
					</tr>";
					$totchq=$totchq+$row["chqamt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";
				$ResponseXML .= "<chqtot><![CDATA[".$totchq."]]></chqtot>";	
				$ResponseXML .= "<chqbal><![CDATA[".$totchq."]]></chqbal>";			
				
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;			
}



if($_POST["Command"]=="utilization")
{	

	if ($_SESSION["dev"]==""){
		exit("no");
	}
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$msset = array(array());
	
	$sql1="delete from tmp_utilization_ret_chq_set where recno='".$_POST["recno"]."'"; 
 	$result1 =$db->RunQuery($sql1);
		
//	if (($_POST["paytype"]!="R/Deposit") and ($_POST["paytype"]!="C/TT")) {
		$sql="select * from tmp_ret_chq_sett where recno='".$_POST["recno"]."'"; 
		$result =$db->RunQuery($sql);
		while ($row = mysql_fetch_array($result)){
			if ($row["chqdate"]!=""){
			
				$date1=strtotime(date("Y-m-d"));
				$date2=strtotime($row["chqdate"]);
				$diff = $date1 - $date2;
				
				//if ((strtotime("Y-m-d", $row["chqdate"]) < strtotime(date("Y-m-d"))) or (strtotime("Y-m-d", $row["chqdate"])== strtotime(date("Y-m-d")))){
				if ($diff>=0){
					$d=date('Y-m-d', strtotime("+1 days"));
					$sql1="update tmp_ret_chq_sett set chqdate='".$d."' where recno='".$_POST["recno"]."' and chqno='".$row["chqno"]."'"; 
					$result1 =$db->RunQuery($sql1);
				}
			}
		}
//	}
	$tmp=array();
	
	$i=1;
	$docno="docno".$i;
	
	while ($_POST[$docno]!=""){
		$docno="docno".$i;
		$setamount="setamount".$i;
			
		if ($_POST[$setamount]!=""){
			$tmp[$i]=$_POST[$setamount];
			
		}
		$i=$i+1;
	}	
	
	$i=1;
	$k=1;
	
	
	$sql="select * from tmp_ret_chq_sett where recno='".$_POST["recno"]."'"; 
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		$chqbalval = $row["chqamt"];
    	$chqvalval = $row["chqamt"];
		
		$j=1;
		while (($_POST["mcount"]>$j) and ($chqbalval>0)){
			$invset=$tmp[$j];
			$docno="docno".$j;
					$docdate="docdate".$j;
					$chqval="chqval".$j;
					$chqno="chqno".$j;
					$chqdate="chqdate".$j;
					
			if ($invset>0){
				$msset[$k][0]="";
					$msset[$k][1]="";
					$msset[$k][2]="";
					$msset[$k][3]="";
					$msset[$k][4]="";
					$msset[$k][5]="";
					$msset[$k][6]="";
					$msset[$k][7]="";
					$msset[$k][8]="";
					$msset[$k][9]="";
				if ($invset<=$chqbalval){
					if ($tmp[$j] > 0){ $tmp[$j] = 0; }
					
					$chqbalval=$chqbalval-$invset;
					
					
				
					$diff = abs(strtotime($_POST[$docdate]) - strtotime($row["chqdate"]));
					$days = floor($diff / (60*60*24));
			
					/*$ResponseXML .= "<tr><td>".$_POST[$docno]."</td>
										<td>".$_POST[$docdate]."</td>
										<td>".$row["chqno"]."</td>
										<td>".$row["chqdate"]."</td>
										<td>".$invset."</td>
										<td>".$days."</td>
										<td>0</td>
										<td>".$_POST[$chqval]."</td>
										<td>".$_POST[$chqno]."</td>
										<td>".$_POST[$chqdate]."</td></tr>";*/
										
										$msset[$k][0]=$_POST[$docno];
										$msset[$k][1]=$_POST[$docdate];
										$msset[$k][2]=$row["chqno"];
										$msset[$k][3]=$row["chqdate"];
										$msset[$k][4]=$invset;
										$msset[$k][5]=$days;
										$msset[$k][6]=0;
										$msset[$k][7]=$_POST[$chqval];
										$msset[$k][8]=$_POST[$chqno];
										$msset[$k][9]=$_POST[$chqdate];
										
										$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_POST["recno"]."', '".$msset[$k][0]."', '".$msset[$k][1]."', '".$msset[$k][2]."', '".$msset[$k][3]."', '".$msset[$k][4]."', '".$msset[$k][5]."', '".$msset[$k][6]."', '".$msset[$k][7]."', '".$msset[$k][8]."', '".$msset[$k][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
					$tmp[$j]=0;					
				} else {
					if ($tmp[$j] > 0){ $tmp[$j] = $invset-$chqbalval; }
					
					$diff = abs(strtotime($_POST[$docdate]) - strtotime($row["chqdate"]));
					$days = floor($diff / (60*60*24));
					
					/*$ResponseXML .= "<tr><td>".$_POST[$docno]."</td>
										<td>".$_POST[$docdate]."</td>
										<td>".$row["chqno"]."</td>
										<td>".$row["chqdate"]."</td>
										<td>".$chqbalval."</td>
										<td>".$days."</td>";*/
										
										$tmp[$j]=$invset-$chqbalval;
										
				/*	$ResponseXML .= "<td>".$tmp[$j]."</td>
										<td>".$_POST[$chqval]."</td>
										<td>".$_POST[$chqno]."</td>
										<td>".$_POST[$chqdate]."</td></tr>";*/
										
										$msset[$k][0]=$_POST[$docno];
										$msset[$k][1]=$_POST[$docdate];
										$msset[$k][2]=$row["chqno"];
										$msset[$k][3]=$row["chqdate"];
										$msset[$k][4]=$chqbalval;
										$msset[$k][5]=$days;
										$msset[$k][6]=$tmp[$j];
										$msset[$k][7]=$_POST[$chqval];
										$msset[$k][8]=$_POST[$chqno];
										$msset[$k][9]=$_POST[$chqdate];
										$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_POST["recno"]."', '".$msset[$k][0]."', '".$msset[$k][1]."', '".$msset[$k][2]."', '".$msset[$k][3]."', '".$msset[$k][4]."', '".$msset[$k][5]."', '".$msset[$k][6]."', '".$msset[$k][7]."', '".$msset[$k][8]."', '".$msset[$k][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
					$chqbalval=0;					
				}
				$k=$k+1;
			}
			$j=$j+1;
		}
		$i=$i+1; 
	}
	
	
	$ii=1; 
	$docdate="docdate".$ii;
	
	while ($_POST[$docdate]!=""){
		$cash="cash".$ii;
		
		if ($_POST[$cash]!=""){
			
			$docno="docno".$ii;
			
			$chqval="chqval".$ii;
			$chqno="chqno".$ii;
			$chqdate="chqdate".$ii;
			
			
			$msset[$k][0]="";
					$msset[$k][1]="";
					$msset[$k][2]="";
					$msset[$k][3]="";
					$msset[$k][4]="";
					$msset[$k][5]="";
					$msset[$k][6]="";
					$msset[$k][7]="";
					$msset[$k][8]="";
					$msset[$k][9]="";
					
					
			$diff = abs(strtotime($_POST[$docdate]) - strtotime(date("Y-m-d")));
			$days = floor($diff / (60*60*24));
					
			/*$ResponseXML .= "<tr><td>".$_POST[$docno]."</td>
										<td>".$_POST[$docdate]."</td>
										<td>Cash</td>
										<td>".date("Y-m-d")."</td>
										<td>".$_POST[$cash]."</td>
										<td>".$days."</td>
										<td></td>
										<td>".$_POST[$chqval]."</td>
										<td>".$_POST[$chqno]."</td>
										<td>".$_POST[$chqdate]."</td></tr>";*/
				
										$msset[$k][0]=$_POST[$docno];
										$msset[$k][1]=$_POST[$docdate];
										$msset[$k][2]="Cash";
										$msset[$k][3]=date("Y-m-d");
										$msset[$k][4]=$_POST[$cash];
										$msset[$k][5]=$days;
										$msset[$k][6]=0;
										$msset[$k][7]=$_POST[$chqval];
										$msset[$k][8]=$_POST[$chqno];
										$msset[$k][9]=$_POST[$chqdate];
										
										$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_POST["recno"]."', '".$msset[$k][0]."', '".$msset[$k][1]."', '".$msset[$k][2]."', '".$msset[$k][3]."', '".$msset[$k][4]."', '".$msset[$k][5]."', '".$msset[$k][6]."', '".$msset[$k][7]."', '".$msset[$k][8]."', '".$msset[$k][9]."')"; 
									//	echo $sql1;
 		$result1 =$db->RunQuery($sql1);
										
										
		}
		$ii=$ii+1;
		$docdate="docdate".$ii;
	} 
	 
	$S = 1;
	while ($_POST[$docno] != ""){
		$docno="docno".$S;
			$docdate="docdate".$S;
			$chqval="chqval".$S;
			$chqno="chqno".$S;
			$chqdate="chqdate".$S;
			$cash="cash".$S;
			$retchqbal="retchqbal".$S;
			
		$H = 10;
		while ($H != 0){
  			if ($_POST[$docno] == $msset[$H][0]){
    			if ($msset[$H + 1][0] == $msset[$H][0]){
        			if (trim($msset[$H][2]) != "Cash"){
            			$msset[$H][6] = $msset[$H + 1][6] + $msset[$H + 1][4] - $_POST[$cash];
					} else {	
                    	$msset[$H][6] = $msset[$H + 1][6] + $msset[$H + 1][4];
        			}
    			} else {
       				if ($msset[$H][2] != "Cash"){
        				$msset[$H][6] = $_POST[$retchqbal] - $_POST[$cash];
					} else {	 
               			$msset[$H][6] = $_POST[$retchqbal];
       				}
				}
			}		
     		$H = $H - 1;
		}
		$deutot = $deutot +  $_POST[$retchqbal];
		$S = $S + 1;
	}

 
	
/*	$sql1="delete from tmp_utilization_ret_chq_set where recno='".$_POST["recno"]."'";
	$result1 =$db->RunQuery($sql1);
	
	$i=1;
	while ($k >	$i){						
 		$sql1="insert into tmp_utilization_ret_chq_set(recno, docno, docdate, chequeno, chequedate, settled, days, retchbal, retchqval, col1, col2) values ('".$_POST["recno"]."', '".$msset[$i][0]."', '".$msset[$i][1]."', '".$msset[$i][2]."', '".$msset[$i][3]."', '".$msset[$i][4]."', '".$msset[$i][5]."', '".$msset[$i][6]."', '".$msset[$i][7]."', '".$msset[$i][8]."', '".$msset[$i][9]."')"; 
 		$result1 =$db->RunQuery($sql1);
		$i=$i+1;
 	}*/
	
	$ResponseXML .= "<uti_table><![CDATA[ <table   border=1  cellspacing=0>
								<tr><td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Doc.No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Doc.Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque No</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Cheque Date</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Settled</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Days</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ret.ch.bal</font></td>
								<td width=\"80\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ret.chq.val</font></td>
							</tr>";
							
	$sql="select * from tmp_utilization_ret_chq_set where recno='".$_POST["recno"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<tr><td>".$row["docno"]."</td>
						<td>".$row["docdate"]."</td>
						<td>".$row["chequeno"]."</td>
						<td>".$row["chequedate"]."</td>
						<td>".$row["settled"]."</td>
						<td>".$row["days"]."</td>
						<td>".$row["retchbal"]."</td>
						<td>".$row["retchqval"]."</td>
						</tr>";			
				
	}			
			
				$ResponseXML .= "   </table>]]></uti_table>";
							
				$ResponseXML .= " </salesdetails>";
				echo $ResponseXML;		
	
	
}



		if($_GET["Command"]=="new_rec")
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
			$sql="Select CHRET from invpara where COMCODE = '" .$_SESSION['COMCODE']. "'";
			$result =$db->RunQuery($sql);
			$row = mysql_fetch_array($result);
			$tmprecno="000000".$row["CHRET"];
			$lenth=strlen($tmprecno);
			if ($_SESSION['COMCODE']=="A"){
                                $recno=trim("ARTC/ ").substr($tmprecno, $lenth-7);
			}else if ($_SESSION['COMCODE']=="B"){
                                $recno=trim("BRTC/ ").substr($tmprecno, $lenth-7);
			}else if ($_SESSION['COMCODE']=="R"){
                                $recno=trim("RRTC/ ").substr($tmprecno, $lenth-7);
			} else {
				$recno=trim("RTC/ ").substr($tmprecno, $lenth-7);
			}                        
			
			$_SESSION["recno"]=$recno;
			
			$sql="delete from tmp_ret_chq_sett where recno='".$recno."'";
			$result =$db->RunQuery($sql);
			
			$sql="delete from tmp_utilization_ret_chq_set where recno='".$recno."'";
			$result =$db->RunQuery($sql);
		
			echo $recno;	
			
		}
		
		
if($_GET["Command"]=="save_crec")
{

	if ($_SESSION['dev']==""){
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
        $sql="select * from tmp_utilization_ret_chq_set where recno='".trim($_GET["recno"])."'";
        $result=mysql_query($sql, $dbinv);

        $count = mysql_num_rows($result);
        if($count < 1){
           exit("error in utilization");
        }
        
        
        
	mysql_query("SET AUTOCOMMIT=0", $dbinv);	 
	mysql_query("START TRANSACTION", $dbinv);
        
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	$sql="select CA_REFNO from s_crec where CA_REFNO='".trim($_GET["recno"])."'";
	$result=mysql_query($sql, $dbinv);
	
	if ($row = mysql_fetch_array($result)){
		exit("Receipt No Already Exists");
	} else {
		
	}
	
	$sql="select * from tmp_ret_chq_sett where recno='".trim($_GET["recno"])."'";
	$result=mysql_query($sql, $dbinv);
	while ($row = mysql_fetch_array($result)){
		if 	($row["chqdate"]!=""){
			$sql1="insert into s_invcheq(refno, Sdate, cus_code, CUS_NAME, cheque_no, che_date, bank, che_amount, trn_type, ex_flag, sal_ex, dev, noof, ret_refno, ch_count_ret, department, SERI_NO) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."', '".$_GET["cusname"]."', '".$row["chqno"]."', '".$row["chqdate"]."', '".$row["chqbank"]."', ".$row["chqamt"].", 'RET', 'N', '".$_GET["salesrep"]."', '".$_SESSION['dev']."', 0, '0', '0', 'O', '0')";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=1; }
		} else {
			exit();
		}
	}	
	
	
	$chqno="";
        
        $sql="select * from tmp_utilization_ret_chq_set where recno='".trim($_GET["recno"])."'";
        $result=mysql_query($sql, $dbinv);

        $count = mysql_num_rows($result);
        if($count < 1){
            exit("error in utilization");
        }

        while ($row = mysql_fetch_array($result)){
		
			$sql1="insert into ch_sttr (ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, ST_FLAG, ST_INDATE, ST_DAYS, ST_CHNO, DEV, cus_code, ap_days) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', '".$row["docno"]."', '".$row["settled"]."', 'CRN', '".$row["chequedate"]."', '".$row["days"]."', '".$row["chequeno"]."', '".$_SESSION['dev']."', '".$_GET["cuscode"]."', '".$row["days"]."' )";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=1; }
			
			$chqno=$chqno." ".$row["chequeno"]."-".$row["settled"];
			
			$sql1="update s_cheq set PAID= PAID+".$row["settled"]." where CR_REFNO='".$row["docno"]."'";
			$result1=mysql_query($sql1, $dbinv);
			if ($result1!=1){ $sql_status=1; }
		
	}	
	
	$sql1="update vendor set RET_CHEQ= RET_CHEQ-".$_GET["txtpaytot"]." where CODE='".$_GET["cuscode"]."'";
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=1; }
	
	
	$sql1="insert into s_led (REF_NO, C_CODE, SDATE, FLAG, AMOUNT, DEV) values ('".trim($_GET["recno"])."', '".$_GET["cuscode"]."', '".$_GET["invdate"]."', 'REC', ".$_GET["txtpaytot"].", '".$_SESSION['dev']."')";
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=1; }
	
	
	//$totpay=$_GET["txtpaytot"]+$_GET["txtoverpay"];
	$totpay=$_GET["txtpaytot"];
	
	$sql1="insert into s_crec (CA_REFNO, CA_DATE, CA_CODE, CA_CASSH, CA_AMOUNT, CA_SALESEX, DEPARTMENT, DEV, overpay, FLAG, pay_type,AC_REFNO, TTDATE, company) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', '".$_GET["cuscode"]."',  ".$_GET["cashtot"].", ".$totpay.", '".$_GET["salesrep"]."', 'O', '".$_SESSION['dev']."', ".$_GET["txtoverpay"].", 'RET', '".$_GET["paytype"]."','".$_GET["cashtt"]."', '".$_GET["cashttdate"]."', '" . $_SESSION['company'] . "')";
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=1; }
	
	include_once("connection.php");
	
//  if (($_GET["paytype"]=="J/Entry") or ($_GET["paytype"]=="Cash TT") or ($_GET["paytype"]=="R/Deposit")){	
	
	$mHead="Cash/Cheque RECEIVED FROM ".$_GET["cuscode"]." ".$_GET["cusname"]." TO SETTLE RET.CHE.NO.- ".$chqno;
        /*
	$sql_rst="Insert into bankdepmas (refno, bdate, heading, code, name, amount, cash, comcode, cancel, type, tmp_no) Values ('" . trim($_GET["recno"]) . "', '" . $_GET["invdate"] . "', '" . $mHead . "', '" . $_GET["accno"] . "', '" . $_GET["acc_name"] . "', " . $_GET["txtpaytot"] . ", 0,'" . $_SESSION['company'] . "', '0', 'D', '".trim($_GET["recno"])."')";
	//echo $sql_rst;
	$result_rst=mysql_query($sql_rst, $dbacc);
	if ($result_rst!=1){ $sql_status=1; }		
	*/
	
	$l_lmem = $mHead;
	
        if ($_GET["paytype"] =="Cash TT") {
		 $ldate = $_GET["cashttdate"];  
	} else {
		$ldate = $_GET["invdate"];  
	}
        
        require_once './gl_posting.php';
        $ayear = ac_year($ldate);
        
	$sql="insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_flag2, l_flag3, l_yearfl, comcode, chno, recdate, l_year, c_remarks, acyear) values ('".trim($_GET["recno"])."', '".$ldate."', '". trim($_GET["accno2"])."', ".$_GET["txtpaytot"].", 'REC', 'CRE', '".$l_lmem."', '0', 'R', 0, '".$_SESSION['company']."', '', '0', '$ayear', '".$_GET["cuscode"]."', '$ayear')";
	//echo $sql;
	$result=mysql_query($sql, $dbinv);
	if ($result!=1){ $sql_status=1; }		
	
	$sql="insert into ledger(l_refno, l_date, l_code, l_amount, l_flag, l_flag1, l_lmem, l_flag2, l_flag3, l_yearfl, comcode, chno, recdate, l_year, c_remarks, acyear) values ('".trim($_GET["recno"])."', '".$ldate."', '". trim($_GET["accno"])."', ".$_GET["txtpaytot"].", 'REC', 'DEB', '".$l_lmem."', '0', 'R', 0, '".$_SESSION['company']."', '', '0', '$ayear', '".$_GET["cuscode"]."', '$ayear')";
	//echo $sql;
        $result=mysql_query($sql, $dbinv);
	if ($result!=1){ $sql_status=1; }		
	/*
	 $sql="Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($_GET["recno"]) . "', '" . $_GET["invdate"] . "', '" . $_GET["accno2"] . "', " . $_GET["txtpaytot"] . ", 'CRE', '" . trim($l_lmem) . "' ,'" . $_SESSION['company'] . "', '".$_GET["recno"]."')";
	// echo $sql;
	 $result=mysql_query($sql, $dbacc);
	 if ($result!=1){ $sql_status=1; }		
	  
	$sql="select * from tmp_ret_chq_sett where recno='".trim($_GET["recno"])."'";
	$result=mysql_query($sql, $dbacc);
	
	while ($row = mysql_fetch_array($result)){
	
		$sql2="Insert into bankdeptrn(refno, bdate, code, amount, flag, nara, comcode, tmp_no) Values ('" . trim($_GET["recno"]) . "', '" . $_GET["invdate"] . "', '" . trim($_GET["accno"]) . "', " . $row["chqamt"] . ", 'DEB', '" . trim($l_lmem) . ", '" . $_SESSION['company'] . "', '".trim($_GET["recno"])."' )";
		//echo $sql2;
		$result2=mysql_query($sql2, $dbacc);
		if ($result2!=1){ $sql_status=1; }		
		
		$sql1="Insert into bankdepche(refno, cheno, bdate, ven_code, ven_name, bank, amount ,comcode, id  ) Values ('" . trim($_GET["recno"]) . "', '" . $row["chqno"] . "', '" . $_GET["invdate"] . "', '" . $l_lmem  . "', '" . $l_lmem  . "', '" . $row["chqbank"] . "', " . $row["chqamt"] . ",'" . $_SESSION['company'] . "', 0 )";
		//echo $sql1;
		$result1=mysql_query($sql1, $dbacc);             
		if ($result1!=1){ $sql_status=1; }		
	}
        */
//  }	
	
	if ($_GET["txtoverpay"]>0){
		$sql1="Insert into c_bal (REFNO, SDATE, trn_type, CUSCODE, AMOUNT, BALANCE, SAL_EX, DEV, company) values ('".trim($_GET["recno"])."', '".$_GET["invdate"]."', 'REC',  '".$_GET["cuscode"]."', ".$_GET["txtoverpay"].", ".$_GET["txtoverpay"].", '".$_GET["salesrep"]."', '".$_SESSION['dev']."', '".$_SESSION['company']."')";
		$result1=mysql_query($sql1, $dbinv);
		if ($result1!=1){ $sql_status=1; }		
		
		
		$sql1="insert into s_sttr_all(ST_REFNO, ST_DATE, ST_INVONO, ST_PAID, balance, netamount, cus_code, cusname, sal_ex, DEV, del_days, deliin_days, deliin_amo, deliin_lock, department, form_type, trn_type) values
	  ('".$_GET["recno"]."', '".$_GET["invdate"]."', '".$_GET["recno"]."', ".$_GET["txtoverpay"].", ".$_GET["txtoverpay"].", ".(-1*$_GET["txtoverpay"]).", '".$_GET["cuscode"]."', '".$_GET["cusname"]."', '".$_GET["salesrep"]."',  '".$_SESSION['dev']."', 0, 0, 0, '0', 'O', 'RET', 'OVER')";
		$result1=mysql_query($sql1, $dbinv);
		if ($result1!=1){ $sql_status=1; }		
		
	}

	$sql1="update invpara set CHRET=CHRET+1 where COMCODE = '" .$_SESSION['COMCODE']. "'";
	$result1=mysql_query($sql1, $dbinv);
	if ($result1!=1){ $sql_status=1; }		
	
	if ($sql_status==0){
		mysql_query("COMMIT", $dbinv);
		echo "Saved";	
	}	else {
		mysql_query("ROLLBACK", $dbinv);
		echo "Error has occured. Can't Save";
	}	
	
}

if ($_GET["Command"]=="search_rec"){
	
	//include_once("connection.php");
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"0\" class=\"form-matrix-table\">
                            <tr>
                              <td width=\"121\"  background=\"images/headingbg.gif\" ><font color=\"#FFFFFF\">Ref No</font></td>
                              <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Date</font></td>
							   <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Amount</font></td>
							    <td width=\"424\"  background=\"images/headingbg.gif\"><font color=\"#FFFFFF\">Customer</font></td>
                             
   							</tr>";
                           
							if ($_GET["mfield"]=="recno"){
						   		$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								//$a="SELECT * from s_salma where REF_NO like  '$letters%'";
								//echo $a;
                                                                if ($_SESSION['COMCODE'] != "C"){
                                                                    $sql="SELECT * from s_crec where FLAG='RET' and company = '".$_SESSION['COMCODE']."' and CA_REFNO like  '$letters%' limit 50";
                                                                }else{
                                                                    $sql="SELECT * from s_crec where FLAG='RET' and CA_REFNO like  '$letters%' limit 50";
                                                                }
								
							
							}/* else if ($_GET["mstatus"]=="recdate"){
								$letters = $_GET['recdate'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="SELECT * from s_crec where CA_DATE like  '$letters%'";
							
								
							}else if ($_GET["mstatus"]=="recamt"){
								$letters = $_GET['recamt'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="SELECT * from s_crec where CA_AMOUNT like  '$letters%'";
								
								
								
							} else {
								$letters = $_GET['recno'];
								//$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								$sql="SELECT * from s_crec where CA_REFNO like  '$letters%'";
								
								
							}*/
							
							//echo $sql;						
							$result =$db->RunQuery($sql);
							//$result=mysql_query($sql, $dbinv);
							while($row = mysql_fetch_array($result)){
								$REF_NO = $row['CA_REFNO'];
								$stname = $_GET["mstatus"];
							$ResponseXML .= "<tr>
                           	  <td onclick=\"recno('$REF_NO');\">".$row['CA_REFNO']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_DATE']."</a></td>
                              <td onclick=\"recno('$REF_NO');\">".$row['CA_AMOUNT']."</a></td>";
							  
							  $sql1="SELECT * FROM vendor where CODE = '".$row["CA_CODE"]."'";
							  $result1 =$db->RunQuery($sql1);
							  $row1 = mysql_fetch_array($result1);
                              $ResponseXML .= "<td onclick=\"recno('$REF_NO');\">".$row1['NAME']."</a></td>                          	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}


if ($_GET["Command"]=="pass_recno"){
	//header('Content-Type: text/xml'); 
	/*echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/

	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	$sql="select * from s_crec where CA_REFNO='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<CA_REFNO><![CDATA[".$row["CA_REFNO"]."]]></CA_REFNO>";
		$ResponseXML .= "<CA_DATE><![CDATA[".$row["CA_DATE"]."]]></CA_DATE>";
		$ResponseXML .= "<CA_CODE><![CDATA[".$row["CA_CODE"]."]]></CA_CODE>";
		
		$sql1="select * from vendor where CODE='".$row["CA_CODE"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			$ResponseXML .= "<cusname><![CDATA[".$row1["NAME"]."]]></cusname>";
		}
		$ResponseXML .= "<CA_CASSH><![CDATA[".$row["CA_CASSH"]."]]></CA_CASSH>";
		$ResponseXML .= "<CA_AMOUNT><![CDATA[".$row["CA_AMOUNT"]."]]></CA_AMOUNT>";
		$ResponseXML .= "<CA_SALESEX><![CDATA[".$row["CA_SALESEX"]."]]></CA_SALESEX>";
		
		$sql1="select * from s_salrep where REPCODE='".$row["CA_SALESEX"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
			$ResponseXML .= "<repname><![CDATA[".$row1["Name"]."]]></repname>";
		}
	}
	
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	if ($row = mysql_fetch_array($result)){
		$ResponseXML .= "<collectcode><![CDATA[".$row["ch_owner"]."]]></collectcode>";
	} else {
		$ResponseXML .= "<collectcode><![CDATA[]]></collectcode>";
	}
	
	$sql="delete from tmp_ret_chq_sett where recno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
		
	$sql="select * from s_invcheq where refno='".$_GET["recno"]."'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$sql1="insert into tmp_ret_chq_sett(recno, chqno, chqdate, chqbank, chqamt) values ('".$row["refno"]."', '".$row["cheque_no"]."', '".$row["che_date"]."', '".$row["bank"]."', ".$row["che_amount"].")";
		$result1 =$db->RunQuery($sql1);
	}		
		
	
				$ResponseXML .= "<chq_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Bank</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Amount</td>
					</tr>";
				
				$sql="select * from tmp_ret_chq_sett where recno='".$_GET["recno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td>".$row["chqbank"]."</td>
					<td align=right>".number_format($row["chqamt"], 2, ".", ",")."</td>
					</tr>";
					$totchq=$totchq+$row["chqamt"];
				}
						
				$ResponseXML .= "   </table>]]></chq_table>";

				$sql="delete from tmp_utilization where recno='".$_GET["recno"]."' ";
				$result =$db->RunQuery($sql);
				
				$sql="select * from s_sttr where ST_REFNO='".$_GET["recno"]."' ";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$sql1="select * from s_salma where REF_NO='".$row["ST_INVONO"]."' ";
					$result1 =$db->RunQuery($sql1);
					$row1 = mysql_fetch_array($result1);
				
					$sql2="insert into tmp_utilization(recno, invno, invdate, chqno, chqdate, chbank, settled, days) values ('".$_GET["recno"]."', '".$row["ST_INVONO"]."', '".$row1["SDATE"]."', '".$row["ST_CHNO"]."', '".$row["st_chdate"]."', '".$row["st_chbank"]."', ".$row["ST_PAID"].", ".$row["st_days"].")"; 
					$result2 =$db->RunQuery($sql2);
			
				}

				$ResponseXML .= "<uti_table><![CDATA[ <table border=1 cellspacing=\"0\" cellpadding=\"0\" class=\"bcgl1\"><tr height=\"25\">
					<td width=\"200\"  background=\"images/headingbg.gif\">Invoice No</td>
					<td width=\"100\"  background=\"images/headingbg.gif\">Invoice Date</td>
					<td width=\"230\"  background=\"images/headingbg.gif\">Cheque No</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Cheque Date</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Settled</td>
					<td width=\"140\"  background=\"images/headingbg.gif\">Days</td>
					</tr>";
				
				$sql="select * from tmp_utilization where recno='".$_GET["recno"]."'";
				$result =$db->RunQuery($sql);
				while ($row = mysql_fetch_array($result)){
					$ResponseXML .= "<tr>
					<td>".$row["invno"]."</td>
					<td>".$row["invdate"]."</td>
					<td>".$row["chqno"]."</td>
					<td>".$row["chqdate"]."</td>
					<td align=right>".number_format($row["settled"], 2, ".", ",")."</td>
					<td>".$row["days"]."</td>
					</tr>";
					
				}
						
				$ResponseXML .= "   </table>]]></uti_table>";
				$ResponseXML .= "</salesdetails>";

				echo $ResponseXML;
	}


if ($_GET["Command"]=="delete_rec"){
	$ResponseXML = "";
		
		include('connection.php');
		
	//if ($_GET["invdate"]==date("Y-m-d")){
		$sql_status=0;
		
 		mysql_query("SET AUTOCOMMIT=0", $dbinv);	 
		mysql_query("START TRANSACTION", $dbinv);	 	
		
		$sql="delete from s_invcheq   WHERE  refno='".$_GET["recno"]."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=1; }
		
                $sql="delete from ledger WHERE  l_refno='".$_GET["recno"]."'";
		$result=mysql_query($sql,$dbinv);
		if ($result!=1){ $sql_status=12; }
		
		
		$sql1="select * from ch_sttr where ST_REFNO = '".$_GET["recno"]."'";
		//echo $sql1;
		$result1=mysql_query($sql1, $dbinv);
		while ($row1 = mysql_fetch_array($result1)){	
			$sql2="update s_cheq set PAID= PAID-" . $row1["ST_PAID"] . " where CR_REFNO='".$row1["ST_INVONO"]."'";
			$result2=mysql_query($sql2, $dbinv);
			if ($result2!=1){ $sql_status=3; }
					
			
		}
		
		$sql="DELETE from ch_sttr WHERE  ST_REFNO='".$_GET["recno"]."'";
		//echo $sql;
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=2; }
			
		$sql="UPDATE s_crec SET CANCELL='1' WHERE CA_REFNO='".$_GET["recno"]."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=4; }
		
		$sql="UPDATE c_bal SET CANCELL='1' WHERE REFNO='".$_GET["recno"]."'";
		$result=mysql_query($sql, $dbinv);
		if ($result!=1){ $sql_status=5; }
		
		
		if ($sql_status==0){
			mysql_query("COMMIT", $dbinv);
			$ResponseXML = "Deleted";	
		}	else {
			mysql_query("ROLLBACK", $dbinv);
			$ResponseXML = "Error has occured. Can't Delete";
		}
			echo $sql_status;
		
		
		//include_once("connection.php");
		
		
		
	
  
	
//	} else {
//		$ResponseXML = "Sorry Cant Cancel.... please check reciept date";
//	}

	echo $ResponseXML;

}
?>