<?php session_start();  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cash Book</title>
<link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
</head>
<script language="JavaScript" src="js/rep_sales_summery.js"></script>
<body>
<center>
<b>Company <?php echo $_SESSION['COMCODE']; ?> - Cash Book on <?php echo "<div id='dtfrom'>".$_GET["dtfrom"]."</div>"; ?></b></br>
<table width="1000" border="1" cellpadding="0" cellspacing="0">
  <tr>
    
    <td width="451" align="center"><strong>Description</strong></td>
    <td width="150" align="center"><strong>Recieved</strong></td>
    <td width="150" align="center"><strong>Issued</strong></td>
  </tr>
 
  <?php
  		if ($_SESSION['COMCODE']=="A"){
			include('connection_a.php');
		} else if ($_SESSION['COMCODE']=="B"){
			include('connection_b.php');
		} else if ($_SESSION['COMCODE']=="C"){
			include('connection_c.php');
		}			
		
		$rct = "select * from cash_book_summery where company='".$_SESSION['COMCODE']."' order by trn_date desc";
		$result_rct=mysql_query($rct, $dbinv);
	 	$row_rct = mysql_fetch_array($result_rct);
		
		$opening_bal=$row_rct["balance"];
		
  		echo "<tr>";
		echo "<td><b>".$row_rct["trn_date"]." B/F Balance</b></td>";
		echo "<td align=right><b><div id='open_bal'>".number_format($row_rct["balance"], 2, ".", ",")."</div></b></td>";
		echo "<td></td>";
		echo "</tr>";
		
  		$tyre_sale=0;
		$battery_sale=0;
		$battery_charge=0;
		$dis_water=0;
		$ms_sale=0;
		$tyre_fitting=0;
		$tube_sale=0;
		$noncat_sale=0;
		
		$tot_pay=0;
		
		$tot_sale=$opening_bal;
		
		if ($_SESSION['COMCODE']=="A"){
	 		$rct = "select * from view_crec_sttr_invo_smas where CA_DATE='" . $_GET["dtfrom"] . "' and left(CA_REFNO, 1)='A' and pay_type='Cash' and  CANCELL='0' and CA_CASSH>0 ";
		} else if ($_SESSION['COMCODE']=="B"){
			$rct = "select * from view_crec_sttr_invo_smas where CA_DATE='" . $_GET["dtfrom"] . "' and left(CA_REFNO, 1)='B' and pay_type='Cash' and  CANCELL='0' and CA_CASSH>0 ";
		} else if ($_SESSION['COMCODE']=="C"){
			$rct = "select * from view_crec_sttr_invo_smas where CA_DATE='" . $_GET["dtfrom"] . "'  and pay_type='Cash' and  CANCELL='0' and CA_CASSH>0 ";
		}	
		//echo $rct;
		$result_rct=mysql_query($rct, $dbinv);
	 	while ($row_rct = mysql_fetch_array($result_rct)) {
		
			
	 		if ($row_rct["CA_CASSH"] > 0) {
			
				if ($row_rct["CA_DATE"]!=$row_rct["SDATE"]){
					echo "<tr>";
					echo "<td>".$row_rct["ST_INVONO"]." - ".$row_rct["CUS_NAME"]."</td>";
					echo "<td align=right>".number_format($row_rct["ST_PAID"], 2, ".", ",")."</td>";
					echo "<td></td>";
					echo "</tr>";
					
					
				} else {
				
					if ($row_rct["Brand"]=="TYRE SALE") {
						$tyre_sale=$tyre_sale+$row_rct["ST_PAID"];
						
					} else if ($row_rct["Brand"]=="BATTERY SALE"){
						$battery_sale=$battery_sale+$row_rct["ST_PAID"];
						
					} else if ($row_rct["Brand"]=="BATTERY CHARGE"){
						$battery_charge=$battery_charge+$row_rct["ST_PAID"];
						
					} else if ($row_rct["Brand"]=="TUBE SALE"){
						$tube_sale=$tube_sale+$row_rct["ST_PAID"];
						
					} else if ($row_rct["Brand"]=="TYRE FITTING"){
						$tyre_fitting=$tyre_fitting+$row_rct["ST_PAID"];
						
					} else if ($row_rct["Brand"]=="DIS. WATER"){
						$dis_water=$dis_water+$row_rct["ST_PAID"];
						
					} else if ($row_rct["Brand"]=="MS SALE"){
						$ms_sale=$ms_sale+$row_rct["ST_PAID"];
						
					} else {
						$noncat_sale=$noncat_sale+$row_rct["ST_PAID"];
					}	
					
				}
				$tot_sale=$tot_sale+$row_rct["ST_PAID"];
			}
			
			
		}	
		
  	echo "<tr>";
	echo "<td>Tyre Sale</td>";
	echo "<td align=right>".number_format($tyre_sale, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>Battery Sale</td>";
	echo "<td align=right>".number_format($battery_sale, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>Battery Charge</td>";
	echo "<td align=right>".number_format($battery_charge, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>Tube Sale</td>";
	echo "<td align=right>".number_format($tube_sale, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>Tyre Fittings</td>";
	echo "<td align=right>".number_format($tyre_fitting, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>Dis. Water</td>";
	echo "<td align=right>".number_format($dis_water, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>MS Sale</td>";
	echo "<td align=right>".number_format($ms_sale, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td>None Category Sale</td>";
	echo "<td align=right>".number_format($noncat_sale, 2, ".", ",")."</td>";
	echo "<td></td>";
	echo "</tr>";
	
	$rct = "select * from ledger where l_date='" . $_GET["dtfrom"] . "'  and l_code='12502'";
	$result_rct=mysql_query($rct, $dbacc);
	while ($row_rct = mysql_fetch_array($result_rct)) {
		echo "<tr>";
		echo "<td>".$row_rct["l_lmem"]."</td>";
		echo "<td></td>";
		echo "<td align=right>".number_format($row_rct["l_amount"], 2, ".", ",")."</td>";
		echo "</tr>";
		
		$tot_pay=$tot_pay+$row_rct["l_amount"];
	}
	
	echo "<tr>
   	<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  	</tr>";
  
	$bf=$tot_sale-$tot_pay;
				
	echo "<tr>";
	echo "<td><b>Balance C/F </b></td>";
	echo "<td align=right><b>".number_format($bf, 2, ".", ",")."</b></td>";
	echo "<td align=right><b>".number_format($tot_pay, 2, ".", ",")."</b></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td></td>";
	echo "<td align=right><u><b><div id='tot_sale'>".number_format($tot_sale, 2, ".", ",")."</div></b></u></td>";
	echo "<td align=right><u><b>".number_format($tot_sale, 2, ".", ",")."</b></u></td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td><b>Balance B/F </b></td>";
	echo "<td align=right></td>";
	echo "<td align=right><input type=\"text\" name=\"txtbf\" id=\"txtbf\" value=\"".number_format($bf, 2, ".", ",")."\" class=\"text_purchase3\" /></td>";
	echo "</tr>";
	
	
	
  
  
 
echo "</table>";
echo "<p>
  <input type=\"button\" name=\"button\" id=\"button\" value=\"Update Balance\" class=\"btn_purchase1\" onclick=\"update_bal('".$_GET["dtfrom"]."', ".$opening_bal.", ".$tot_sale.", ".$bf.");\"/>
  
</p>";

?>
</body>
</html>
