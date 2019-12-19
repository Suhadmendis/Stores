<?php session_start(); ?>
<?php date_default_timezone_set('Asia/Colombo'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Return Cheque Report</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:0px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12px;

}
td
{
font-size:12px;

}
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
}
</style>

</head>

<body>


<p>
  <?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
	
	
	
		
	
	if ($_GET["radio"]=="optout") { outrep(); }
	if ($_GET["radio"]=="optreceipt") { receipt(); }
	if ($_GET["radio"]=="optRetChk") { RTn(); }
	if ($_GET["radio"]=="optOverpay") { //Overpay();
							 }
		//////////////////////



function RTn(){
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["cmbdev"] == "ALL") { $sysdiv = "A"; }
	if ($_GET["cmbdev"] == "Computer") { $sysdiv = "1"; }
	if ($_GET["cmbdev"] == "Manual") { $sysdiv = "0"; }


	 $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
       
        $sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
       
 
        $Text1 = "Return Cheque   " . date("Y-m-d", strtotime($_GET["dtdate"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
       
        
       
		 echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td colspan=\"6\">".$Text1."</td>
  </tr>";
	
	echo " <tr>
    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Date</b></td>
        <td ><b>Refno</b></td>
        <td ><b>Cheq. No</b></td>
        <td ><b>Customer</b></td>
        <td ><b>Amount</b></td>
       
      </tr>";
	  
	  $CA_AMOUNT1=0;
	  $CA_AMOUNT2=0;
	  $CA_AMOUNT3=0;
	  $CA_AMOUNT4=0;
	  
	$sql="select  * from s_cheq where dev!='" . $sysdiv . "' and  CR_FLAG='0' and CR_DATE>='" . $_GET["dtfrom"] . "' and CR_DATE<='" . $_GET["dtto"] . "' ";
   // echo $sql;
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
		 echo "<tr>
        <td>".$row["CR_DATE"]."</td>
        <td>".$row["CR_REFNO"]."</td>
        <td>".$row["CR_CHNO"]."</td>
		<td>".$row["CR_C_CODE"]."</td>
		<td>".$row["CR_C_NAME"]."</td>
		<td align=right>".number_format($row["CR_CHEVAL"], 2, ".", ",")."</td></tr>";
		$CR_CHEVAL=$CR_CHEVAL+$row["CR_CHEVAL"];
		
		
	}
	
       
	echo "<tr>
        <td colspan=5></td>";
		
		echo "<td align=right><b>".number_format($CR_CHEVAL, 2, ".", ",")."</b></td></tr>";
      
   echo  "</table></td>
  </tr>
 
</table>";
}

function receipt(){
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["cmbdev"] == "ALL") { $sysdiv = "A"; }
	if ($_GET["cmbdev"] == "Computer") { $sysdiv = "1"; }
	if ($_GET["cmbdev"] == "Manual") { $sysdiv = "0"; }


	 $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
       
        $sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
       
 
        $Text1 = "Receipt  from   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . " To " . date("Y-m-d", strtotime($_GET["dtto"]));
       
        
       
		 echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td colspan=\"6\">".$Text1."</td>
  </tr>
  <tr>
    <td colspan=\"6\">Current Date - ".date("Y-m-d")."</td>
  </tr>";
	
	echo " <tr>
    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Refno</b></td>
        <td ><b>Date</b></td>
        <td ><b>Customer</b></td>
        <td align=right><b>Cash/Cheque</b></td>
        <td align=right><b>C/TT</b></td>
        <td align=right><b>RD</b></td>
        <td align=right><b>J/Entry</b></td>
        <td align=right><b>Total Amt</b></td>
      </tr>";
	  
	  $CA_AMOUNT1=0;
	  $CA_AMOUNT2=0;
	  $CA_AMOUNT3=0;
	  $CA_AMOUNT4=0;
	  
	$sql="select  * from s_crec where DEV!='" . $sysdiv . "' and FLAG='RET' and CA_DATE>='" . $_GET["dtfrom"] . "' and CA_DATE<='" . $_GET["dtto"] . "' and CANCELL='0'";
   // echo $sql;
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
		 echo "<tr>
        <td>".$row["CA_REFNO"]."</td>
        <td>".$row["CA_DATE"]."</td>
        <td>".$row["CA_CODE"]."</td>";
		
		if (($row["pay_type"]=='Cheque') or ($row["pay_type"]=='Cash')) {
			echo "<td align=right>".($row["CA_AMOUNT"]+$row["overpay"])."</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>";
			$CA_AMOUNT1=$CA_AMOUNT1+$row["CA_AMOUNT"]+$row["overpay"];
		}	
		
		if ($row["pay_type"]=='Cash TT') { 
			echo "<td>&nbsp;</td>
					<td align=right>".($row["CA_AMOUNT"]+$row["overpay"])."</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>";
			$CA_AMOUNT2=$CA_AMOUNT2+$row["CA_AMOUNT"]+$row["overpay"];
		}	
		
		if ($row["pay_type"]=='R/Deposit') { 
			echo "<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td align=right>".($row["CA_AMOUNT"]+$row["overpay"])."</td>
			<td>&nbsp;</td>";
			$CA_AMOUNT3=$CA_AMOUNT3+$row["CA_AMOUNT"]+$row["overpay"];
		}	
		
		if ($row["pay_type"]=='J/Entry') { 
			echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=right>".($row["CA_AMOUNT"]+$row["overpay"])."</td>";
			$CA_AMOUNT4=$CA_AMOUNT4+$row["CA_AMOUNT"]+$row["overpay"];
		}	

        echo "
        <td align=right>".($row["CA_AMOUNT"]+$row["overpay"])."</td></tr>";
		
		$CA_AMOUNT=$CA_AMOUNT+$row["CA_AMOUNT"]+$row["overpay"];
		
   
	}
	
       
	echo "<tr>
        <td colspan=3></td>";
		
		echo "<td align=right><b>".$CA_AMOUNT1."</b></td>";
		echo "<td align=right><b>".$CA_AMOUNT2."</b></td>";
		echo "<td align=right><b>".$CA_AMOUNT3."</b></td>";
		echo "<td align=right><b>".$CA_AMOUNT4."</b></td>";
			
        echo "<td align=right><b>".($CA_AMOUNT1+$CA_AMOUNT2+$CA_AMOUNT3+$CA_AMOUNT4)."</td>
        </tr>";	 

    
      
   echo  "</table></td>
  </tr>
 
</table>";
}

function outrep(){
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["cmbdev"] == "ALL") { $sysdiv = "A"; }
	if ($_GET["cmbdev"] == "Computer") { $sysdiv = "1"; }
	if ($_GET["cmbdev"] == "Manual") { $sysdiv = "0"; }


	$sql="delete from tmpsttr";
	$result =$db->RunQuery($sql);
	
	$sql="select * from s_cheq where  dev!='" . $sysdiv . "' and  CR_FLAG='0' and CR_DATE<='" . $_GET["dtdate"] . "' and tmp='0'";
	//echo $sql;
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
		 $paid = 0;
	   	$sql_sttr = "select sum(ST_PAID) as paid from ch_sttr where ST_INVONO='" . trim($row["CR_REFNO"]) . "' and ST_DATE <='" . $_GET["dtdate"] . "' ";
		$result_sttr =$db->RunQuery($sql_sttr);
		$row_sttr = mysql_fetch_array($result_sttr);
	
   		if (is_null($row_sttr["paid"])==false) { $paid = $row_sttr["paid"]; }
      
      	if (($row["CR_CHEVAL"] - $paid) > 1) {
      		$sql_tmp = "insert into tmpsttr (refno, sdate, cheVal, paid, che_no, code, cusname) values  ('" . $row["CR_REFNO"] . "', '" . $row["CR_DATE"] . "','" . $row["CR_CHEVAL"] . "' ," . $paid . ",'" . $row["CR_CHNO"] . "' ,'" . $row["CR_C_CODE"] . "','" . $row["CR_C_NAME"] . "')";
			//echo $sql_tmp;
			$result_tmp =$db->RunQuery($sql_tmp);
   		}
   
	}
	
        $txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
       
        $sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
       
 
       
       
        
         $Text1 = "Return Cheque Outstanding As At " . date("Y-m-d", strtotime($_GET["dtdate"]));
		 

	echo "<table width=\"1000\" border=\"0\">
  <tr>
    <td colspan=\"6\">".$Text1."</td>
  </tr>
  <tr>
    <td colspan=\"6\">Current Date - ".date("Y-m-d")."</td>
  </tr>
  <tr>
    <td colspan=\"6\"><table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Date</b></td>
        <td ><b>Refno</b></td>
        <td ><b>Che. No</b></td>
        <td ><b>Customer Code</b></td>
		<td ><b>Customer Name</b></td>
        <td align=right ><b>Amount</b></td>
        <td align=right ><b>Paid</b></td>
        <td align=right ><b>Balance</b></td>
       
      </tr>";
   
		$balance=0;
	  $sql="Select * from tmpsttr order by sdate";	
      $result =$db->RunQuery($sql);
	  while ($row = mysql_fetch_array($result)){
      	echo "<tr>
        <td>".$row["sdate"]."</td>
        <td>".$row["refno"]."</td>
        <td>".$row["che_no"]."</td>
        <td>".$row["code"]."</td>
        <td>".$row["cusname"]."</td>
        <td align=right>".$row["cheVal"]."</td>
		<td align=right>".$row["paid"]."</td>";
	
        echo "<td align=right>".($row["cheVal"]-$row["paid"])."</td>
       
      </tr>";
	  
	  $balance=$balance+($row["cheVal"]-$row["paid"]);
	  	
	 }
	 
	 echo "<tr>
        <td colspan=7></td>
        <td align=right><b>".$balance."</b></td>
               
      </tr>";
	 
     
     
      
   echo  "</table></td>
  </tr>
 
</table>";
}

?> 
</body>
</html>
