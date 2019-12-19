<?php
	
	include_once("connection.php");
	
	$sql = mysql_query("select * from s_cheq where CR_DATE>='2014-11-12'") or die(mysql_error());
			//echo $sql;
	while($row = mysql_fetch_array($sql)){
		
		$sql_invchq = mysql_query("select * from  s_invcheq where  cheque_no='".trim($row["CR_CHNO"])."' and che_date = '".$row["CR_CHDATE"]."' and che_amount = ".$row["CR_CHEVAL"]) or die(mysql_error());
			if($row_invchq = mysql_fetch_array($sql_invchq)){
				if (trim($row_invchq["trn_type"]) == "RET") {
				//	echo "select * from ch_sttr where ST_CHNO = '".trim($_GET["txtChequeNo"])."' and ST_INDATE = '".$row['che_date']."'";
					$sql1 = mysql_query("select * from ch_sttr where ST_CHNO = '".trim($row["CR_CHNO"])."' and ST_INDATE = '".$row_invchq['che_date']."'") or die(mysql_error());
					while($row1 = mysql_fetch_array($sql1)){
					//	echo "select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'";
						$sql_his = mysql_query("select * from ret_chq_history where Ref_no = '".trim($row1["ST_INVONO"])."'") or die(mysql_error());
						while($row_his = mysql_fetch_array($sql_his)){
							$refinv = $row_his["Inv_no"];
							$sql_rs = mysql_query("select * from  ret_ch_sett where CR_REFNO = '".trim($row1["ST_INVONO"])."' and  ST_CHNO = '" .trim($row["CR_CHNO"])."' and ret_chno = '".$row_his["chk_no"]."'") or die(mysql_error());
							$row_rs = mysql_fetch_array($sql_rs);
							
							if (is_null($row_his["st_amt"])==false) { $st_amou=$row_his["st_amt"]; }
								
								$sql_rst = mysql_query("select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysql_error());
								if ($row_rst = mysql_fetch_array($sql_rst)){
									
                              			$REF_NO="REF_NO_".$a;
										$SDATE="SDATE_".$a;
										$GRAND_TOT="GRAND_TOT_".$a;
										$st_amou_name="st_amou_".$a;
										
										
										$sql_rst = mysql_query("insert into ret_chq_history (Ref_no, Inv_no, Inv_date, inv_Amt, st_amt, chk_no) values ('" . $row['CR_REFNO'] . "','" . $row_rst['REF_NO'] . "', '" . $row_rst['SDATE'] . "', " . $row_rst['GRAND_TOT'] . ", " . $st_amou . ", '" . $row["CR_CHNO"] . "')") or die(mysql_error());
			//echo $sql_chq;
									//	$result_chq=mysql_query($sql_chq, $dbinv);
			
								/*	$ResponseXML .= "<tr>	
                             			<td ><div id=".$REF_NO.">".$row_rst['REF_NO']."</div></td>
							 			<td><div id=".$SDATE.">".$row_rst['SDATE']."</div></td>
							 			<td ><div id=".$GRAND_TOT.">".$row_rst['GRAND_TOT']."</div></td>
							 			<td  ><div id=".$st_amou_name.">".$st_amou."</div></td>
							 			</tr>";
										
										$a=$a+1;*/
										
								}
								$st_amou=0;
   						 
    					}
					}
				} else {
					//echo "Select * from s_sttr where cus_code = '".trim($row['cus_code'])."' and st_chno = '".trim($_GET["txtChequeNo"])."' and st_chdate = '".$row['che_date']."'";
					$sql_inv = mysql_query("Select * from s_sttr where cus_code = '".trim($row_invchq['cus_code'])."' and ST_CHNO = '".trim($row["CR_CHNO"])."' and st_chdate = '".$row_invchq['che_date']."'") or die(mysql_error());
					while($row_inv = mysql_fetch_array($sql_inv)){
						$refinv = $row_inv["ST_INVONO"];
        				$st_amou = $row_inv["ST_PAID"];
					//	echo "select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'";
						$sql_rst = mysql_query("select * from s_salma where Accname <> 'NON STOCK' and REF_NO='" . trim($refinv) . "'") or die(mysql_error());
							if ($row_rst = mysql_fetch_array($sql_rst)){
							
								$sql_rst = mysql_query("insert into ret_chq_history (Ref_no, Inv_no, Inv_date, inv_Amt, st_amt, chk_no) values ('" . $row['CR_REFNO'] . "','" . $row_rst['REF_NO'] . "', '" . $row_rst['SDATE'] . "', " . $row_rst['GRAND_TOT'] . ", " . $st_amou . ", '" . $row["CR_CHNO"] . "')") or die(mysql_error());
								echo "insert into ret_chq_history (Ref_no, Inv_no, Inv_date, inv_Amt, st_amt, chk_no) values ('" . $row['CR_REFNO'] . "','" . $row_rst['REF_NO'] . "', '" . $row_rst['SDATE'] . "', " . $row_rst['GRAND_TOT'] . ", " . $st_amou . ", '" . $row["CR_CHNO"] . "')</br>";
								
								$REF_NO="REF_NO_".$a;
										$SDATE="SDATE_".$a;
										$GRAND_TOT="GRAND_TOT_".$a;
										$st_amou_name="st_amou_".$a;
										
								/*$ResponseXML .= "<tr>
                              
                             	<td ><div id=".$REF_NO.">".$row_rst['REF_NO']."</div></td>
							 	<td><div id=".$SDATE.">".$row_rst['SDATE']."</div></td>
							 	<td ><div id=".$GRAND_TOT.">".$row_rst['GRAND_TOT']."</div></td>
							 	<td  ><div id=".$st_amou_name.">".$st_amou."</div></td>
							 	</tr>";
								
								$a=$a+1;*/
								
							}
							$st_amou=0;
					}
				}	
      
			}	
			
	}
			
?>