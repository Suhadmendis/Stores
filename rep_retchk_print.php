<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Receipt</title>
<style type="text/css">
<!--
.companyname {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}

.com_address {
	color: #000000;
	font-weight: bold;
	font-size: 18px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 20px;
}

body {
	color: #000000;
	font-size: 17px;
}
-->
</style>
</head>

<body><center>

<?php 
require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	 date_default_timezone_set('Asia/Colombo'); 
	 
	$sql="select * from s_crec where CA_REFNO='".$_GET["invno"]."'";
	$result =$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	$sql1="select * from vendor where CODE='".$row["CA_CODE"]."'";
	$result1 =$db->RunQuery($sql1);
	$row1 = mysql_fetch_array($result1);
	$address=$row1["ADD1"]." ".$row1["ADD2"];
	
	$sql_para="select * from invpara";
	$result_para =$db->RunQuery($sql_para);
	$row_para = mysql_fetch_array($result_para);
	?>
    
    
<table width="922" height="428" border="0">
   <tr>
    <th colspan="2" scope="col"><span class="companyname"><?php 
		if ($_SESSION['company']=="THT"){
			echo "TYRE HOUSE TRADING (PVT) LTD"; 
		} if ($_SESSION['company']=="BEN"){
			echo "BENEDICTSONS (PVT) LTD"; 
		}	
			?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col"><?php if ($_GET['paytype'] =="Cash") { echo "CASH RECIPIT";  } ?></th>
  </tr>
  <tr>
    <th colspan="2" scope="col"><span class="com_address"><?php 
		if ($_SESSION['company']=="THT"){
			echo "221-1/4 Sri Sangaraja Mawatha Colombo - 10";
		} if ($_SESSION['company']=="BEN"){
			echo "221-1/2 Sri Sangaraja Mawatha Colombo - 10";
		}
		
			 ?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  
   <tr>
    <th colspan="4" scope="col">&nbsp;</th>
  </tr>
  
  <tr>
    <td width="180">Customer :</td>
    <td  width="400"><?php echo $row1["CODE"]; ?></td>
    <td width="100">Receipt No :</td>
    <td width="207"><?php echo $_GET["invno"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $row1["NAME"]; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $address; ?></td>
    <td>Date :</td>
    <td><?php echo $row["CA_DATE"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>Return Cheque Details
	</td>
    <td width="420">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><table width="922" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="170" scope="col">Cheque Rtn D.</th>
        <th width="170" scope="col">Rtn. Cheque No </th>
        <th width="170" scope="col">Rtn. Cheque Amount</th>
        <th width="170" scope="col">Rtn. Cheque Balance</th>
        <th width="170" height="22">Paid</th>
       <th width="170" height="22">Due</th>
      </tr>
     <?php 
	 $totpay=0;
	$totcashtot=0;
	
	$sql_inv1="select distinct st_invono from ch_sttr where st_refno='".$_GET["invno"]."'";
        
	$result_inv1 =$db->RunQuery($sql_inv1);
	while ($row_inv1 = mysql_fetch_array($result_inv1)){
	 
	 $sql_inv="select * from ch_sttr where st_refno='".$_GET["invno"]."' and st_invono='".$row_inv1["st_invono"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
        
	 if ($row_inv = mysql_fetch_array($result_inv)){
             
             	
		$sql_sal="select * from s_cheq where cr_refno='".$row_inv["ST_INVONO"]."'";
	 	$result_sal =$db->RunQuery($sql_sal);
	 	$row_sal = mysql_fetch_array($result_sal);
            
      echo "<tr>
        <td align=center>".$row_sal["CR_DATE"]."</td>
        <td align=center>".$row_sal["CR_CHNO"]."</td>";
	
        echo "<td align=center>".number_format($row_sal["CR_CHEVAL"], 2, ".", ",")."</td>";
		
		
		
		$sql_inv_tot="select sum(ST_PAID) as totset from ch_sttr where st_refno='".$_GET["invno"]."' and st_invono='".$row_inv1["st_invono"]."'";
	 	$result_inv_tot =$db->RunQuery($sql_inv_tot);
	 	$row_inv_tot = mysql_fetch_array($result_inv_tot);
		
		$invbal=($row_sal["CR_CHEVAL"]-($row_sal["PAID"]-$row_inv_tot["totset"]));
		echo "<td align=center>".number_format($invbal, 2, ".", ",")."</td>";
		
        echo "<td align=center>".number_format($row_inv_tot["totset"], 2, ".", ",")."</td>";
		
		$bal=($row_sal["CR_CHEVAL"]-($row_sal["PAID"]-$row_inv_tot["totset"]))-$row_inv_tot["totset"];
		if ($bal>0){
			echo "<td align=center>".number_format($bal, 2, ".", ",")."</td>";
		} else {
			echo "<td align=center></td>";
		}	
      echo "</tr>";
	  
	  	$sql_inv_cash="select sum(settled) as totset from tmp_utilization where recno='".$_GET["invno"]."' and invno='".$row_inv1["invno"]."' and (chqno='Cash' or chqno='J/Entry' or chqno='Cash TT')";
	 	$result_inv_cash =$db->RunQuery($sql_inv_cash);
	 	$row_inv_cash = mysql_fetch_array($result_inv_cash);
		$totcashtot=$totcashtot+$row_inv_cash["totset"];
		
		
	  	$totpay=$totpay+$row_inv_tot["totset"];
	  }
	 } 
	  ?>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php 
		if ($totpay>0){
			echo "Total Return Cheque Settled Amount";
		}	
		?></td>
    <td><?php 
		if ($totpay>0){
			echo number_format($totpay, 2, ".", ","); 
		}	
			?></td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <?php 
	 $totchq=0;
	 
	 $sql_inv="select * from tmp_ret_chq_sett where recno='".$_GET["invno"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 if ($row_inv = mysql_fetch_array($result_inv)){
    	echo "<tr>
    <td>Cheque Details
	</td>
    <td width=\"420\">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>";
  }
  ?>
  
  <tr>
    <td colspan="4">
    <table width="922" border="1" cellpadding="0" cellspacing="0">
     <?php 
	 $totchq=0;
	 
	 $sql_inv="select * from tmp_ret_chq_sett where recno='".$_GET["invno"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 if ($row_inv = mysql_fetch_array($result_inv)){
    
	
	
     echo " <tr>
        <th width=\"170\" scope=\"col\">Ch. Date</th>
        <th width=\"170\" scope=\"col\">Ch. No</th>
        <th width=\"170\" scope=\"col\">Bank</th>
        <th width=\"170\" height=\"22\">Ch. Amount</th>
       
      </tr>";
	  }
     
	 $totchq=0;
	 
	 $sql_inv="select * from tmp_ret_chq_sett where recno='".$_GET["invno"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 while ($row_inv = mysql_fetch_array($result_inv)){
      echo "<tr>
        <td align=center>".$row_inv["chqdate"]."</td>
        <td align=center>".$row_inv["chqno"]."</td>
		<td align=center>".$row_inv["chqbank"]."</td>
		<td align=center>".number_format($row_inv["chqamt"], 2, ".", ",")."</td>
      </tr>";
	  	$totchq=$totchq+$row_inv["chqamt"];
	  }
	  
	  $tot=$totchq+$totcashtot;
	  
	  
	  ?>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php 
		if ($totchq>0){
			echo "Total Cheque Payment";
		}	?>
    </td>
    <td><?php 
	if ($totchq>0){	
		echo number_format($totchq, 2, ".", ","); 
	}	
	?></td>
    <td>&nbsp;</td>
    
  </tr>
  
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>



  <tr>
    <td colspan="4"><table width="1000" border="0">
      <tr>
        <th width="197" align="left" ><b><?php echo "Payment By ".$_GET["paytype"]; ?></b></th>
        <th width="202" align="left"><b><?php if ($totchq>0) {echo number_format($totchq, 2, ".", ",");} ?></b></th>
        <th width="230" scope="col">&nbsp;</th>
        <th width="163" scope="col">&nbsp;</th>
        <th width="186" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td width="197" align="left"><b><?php 
		if ($_GET["paytype"]=="Cash TT"){echo "TT Date : ".$_GET["dt"]; } 
		if (($row["CA_CASSH"]>0) && (($_GET["paytype"]=="Cash")||($_GET["paytype"]=="Cheque"))){ echo "Cash"; }
 		?></b></td>
        <th scope="col" align="left"><b><?php //if ($totcashtot>0) {echo number_format($totcashtot, 2, ".", ",");} 
		 if ($row["CA_CASSH"]>0) {echo number_format($row["CA_CASSH"], 2, ".", ",");}
		?></b></th>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
      <tr>
        <td><b><?php if ($_GET["paytype"]=="Cash TT"){echo "TT No : ".$_GET["ca_refno"]; } ?></b></td>
        <td>&nbsp;</td>
        <td>_______________________</td>
        <td>&nbsp;</td>
        <td>_______________________</td>
      </tr>
      <tr>
        <td><?php echo $_SESSION['UserName']." ".date("Y-m-d H:i:s"); ?></td>
        <td>&nbsp;</td>
        <td>Entered by</td>
        <td>&nbsp;</td>
        <td>Checked by</td>
      </tr>
</table>
</body>
</html>
