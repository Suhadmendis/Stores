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
	font-size: 18px;
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
	
	$sql_para="select * from invpara where COMCODE='".$_SESSION['company']."'";
	$result_para =$db->RunQuery($sql_para);
	$row_para = mysql_fetch_array($result_para);
	?>
    
    
<table width="922" height="428" border="0">
   <tr>
    <th colspan="2" scope="col"><span class="companyname"><?php 
		echo $row_para["COMPANY"];	
			?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col"></th>
  </tr>
  <tr>
    <th colspan="2" scope="col"><span class="com_address"><?php 
		/*if ($_SESSION['company']=="THT"){
			echo "221-1/4 Sri Sangaraja Mawatha Colombo - 10";
		} if ($_SESSION['company']=="BEN"){
			echo "221-1/2 Sri Sangaraja Mawatha Colombo - 10";
		}
		*/
			 ?></span></th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  
   <tr>
    <th colspan="4" scope="col">&nbsp;</th>
    
  </tr>
  
  <tr>
    <td width="130">Customer :</td>
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
    <td>Invoice Details
	</td>
    <td width="420">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><table width="922" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th width="170" scope="col">Inv. Date</th>
        <th width="170" scope="col">Inv. No</th>
        <th width="170" height="22">Mnl. No</th>
        <th width="170" scope="col">Inv. Amount</th>
        <th width="170" scope="col">Inv. Balance</th>
        <th width="170" height="22">Paid</th>
      </tr>
     <?php 
	 $totpay=0;
	$totcashtot=0;
	
	//$sql_inv1="select distinct invno from tmp_utilization where recno='".$_GET["invno"]."'";
	$sql_inv1="select distinct invno from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	$result_inv1 =$db->RunQuery($sql_inv1);
	while ($row_inv1 = mysql_fetch_array($result_inv1)){
	 
	 $sql_inv="select * from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and invno='".$row_inv1["invno"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 if ($row_inv = mysql_fetch_array($result_inv)){
	 	
		
        $sql_sal="select * from s_salma where REF_NO='".$row_inv["invno"]."'";
	 	$result_sal =$db->RunQuery($sql_sal);
	 	$row_sal = mysql_fetch_array($result_sal);
		
	    echo "<tr>
        <td align=center>".$row_sal["SDATE"]."</td>
        <td align=center>".$row_inv["invno"]."</td>
        <td align=center>".$row_sal["dele_no"]."</td>";
		
		
        echo "<td align=center>".number_format($row_sal["GRAND_TOT"], 2, ".", ",")."</td>";
		
		
		
		$sql_inv_tot="select sum(settled) as totset from tmp_utilization where invno='".$row_inv1["invno"]."' and user_id='".$_SESSION['UserName']."' and tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
		//echo $sql_inv_tot;
	 	$result_inv_tot =$db->RunQuery($sql_inv_tot);
	 	$row_inv_tot = mysql_fetch_array($result_inv_tot);
		//echo $row_sal["GRAND_TOT"]."/".$row_sal["TOTPAY"]."/".$row_inv_tot["totset"];
		$invbal=($row_sal["GRAND_TOT"]-($row_sal["TOTPAY"]-$row_inv_tot["totset"]));
		//$invbal=($row_sal["GRAND_TOT"]-($row_sal["TOTPAY"]));
		echo "<td align=center>".number_format($invbal, 2, ".", ",")."</td>";
		
        echo "<td align=center>".number_format($row_inv_tot["totset"], 2, ".", ",")."</td>";
		
		$bal=($row_sal["GRAND_TOT"]-($row_sal["TOTPAY"]-$row_inv_tot["totset"]))-$row_inv_tot["totset"];
		//$bal=$invbal-$row_inv_tot["totset"];
		$bal=abs($bal);
//		echo "<td align=center>".number_format($bal, 2, ".", ",")."</td>
        echo "</tr>";
	  
	  	$sql_inv_cash="select sum(settled) as totset from tmp_utilization where tmp_no='".$_SESSION["tmp_no_cashrec"]."' and invno='".$row_inv1["invno"]."' and (chqno='Cash' or chqno='J/Entry' or chqno='Cash TT')";
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
			echo "Total Invoice Payment Amount";
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
	 
	 $sql_inv="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
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
	 
	 $sql_inv="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
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
	 
	 $sql_inv="select * from tmp_cash_chq where tmp_no='".$_SESSION["tmp_no_cashrec"]."'";
	 $result_inv =$db->RunQuery($sql_inv);
	 while ($row_inv = mysql_fetch_array($result_inv)){
      echo "<tr>";
	  	if ((strtotime($row_inv["chqdate"]) < strtotime($row["CA_DATE"])) or (strtotime($row_inv["chqdate"]) == strtotime($row["CA_DATE"]))) {
	  		$date = date('Y-m-d',strtotime(($row["CA_DATE"]).' +1 days'));
		} else {
			$date = $row_inv["chqdate"];
		}	
        echo "<td align=center>".$date."</td>
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
        <th width="197" align="left" ><b><?php if (($_GET["paytype"]!="Cash TT") and ($_GET["paytype"]!="J/Entry")) { echo "Payment By Cheque"; }?></b></th>
        <th width="202" align="left"><b><?php $totPay = 0; if ($totchq>0) {$totPay += $totchq; echo number_format($totchq, 2, ".", ",");} ?></b></th>
        <th width="230" scope="col">&nbsp;</th>
        <th width="163" scope="col">&nbsp;</th>
        <th width="186" scope="col">&nbsp;</th>
      </tr>
      <tr>
        <td width="257" align="left"><b><?php 
		if ($_GET["paytype"]=="Cash TT"){
			echo "TT Date : ".$row["TTDATE"]; 
		} else if ($_GET["paytype"]=="J/Entry"){
			echo "J/Entry Date : ".$row["TTDATE"]; 
		}
		
		if (($row["CA_CASSH"]>0) and (($_GET["paytype"]=="Cash")or($_GET["paytype"]=="Cheque"))){ echo "Cash"; }
 		?></b></td>
        <th scope="col" align="left"><b><?php //if ($totcashtot>0) {echo number_format($totcashtot, 2, ".", ",");} 
		 if ($row["CA_CASSH"]>0) {$totPay += $row["CA_CASSH"]; echo number_format($row["CA_CASSH"], 2, ".", ",");}
		?></b></th>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
          <td><b>Total Payment</b></td>
        <td><b><?php 
		echo number_format($totPay, 2, ".", ","); ?></b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><b><?php 
		if ($_GET["paytype"]=="Cash TT"){
			echo "TT No : ".$row["AC_REFNO"]; 
		} else if ($_GET["paytype"]=="J/Entry"){
			echo "J/Entry No : ".$row["AC_REFNO"]; 
		} ?></b></td>
        <td>&nbsp;</td>
        <td>_________________</td>
        <td>&nbsp;</td>
        <td>_________________</td>
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
