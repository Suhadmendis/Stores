<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Utiliti Report</title>

<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:16px;
}
table
{
border-collapse:collapse;
}
table, td, th
{
 
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
border-bottom:thick;



}
</style>

</head>

<body><center>


<p>
  <?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpcustomerout";
	$result =$db->RunQuery($sql);
	
	$sql_head="select * from invpara";
	$result_head =$db->RunQuery($sql_head);
	$row_head = mysql_fetch_array($result_head);
		
		//////////////////////

	$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


if ($_GET["cmbdev"] == "All") { $dev = "A"; }
if ($_GET["cmbdev"] == "Manual") { $dev = "0"; }
if ($_GET["cmbdev"] == "Computer") { $dev = "1"; }

if ($_GET["chkappro"]!="on"){
if ($_GET["cmbrep"] == "All") {
   if ($_GET["radio"]=="optdaly") {
      if ($_GET["cmdtype"] = "Invoice") { 
	  	$sql = "SELECT * from view_s_ut where  C_DATE='" . $_GET["dtfrom"] . "' and TYPE='INV' and DEV!='" . $dev . "' ";
	  }	
      if ($_GET["cmdtype"] == "Cash") { 
	  	$sql = "SELECT * from view_s_ut  where C_DATE='" . $_GET["dtfrom"] . "' and TYPE='Cash'   ";
	  }	
      if ($_GET["cmdtype"] == "Return Cheque") { 
	  	$sql = "SELECT * from view_s_ut   where C_DATE='" . $_GET["dtfrom"] . "' and TYPE='CHQ'   ";
	  }	
	  
	  if ($_GET["cmdtype"] == "All") { 
	  	$sql = "SELECT * from view_s_ut   where C_DATE='" . $_GET["dtfrom"] . "'  ";
	  }	
   }
    
   if ($_GET["radio"]=="optperiod") {
      if ($_GET["cmdtype"] == "Invoice") { 
	  	$sql = "SELECT * from view_s_ut where  (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' )  and TYPE='INV' and DEV!='" . $dev . "' ";
	  }	
      if ($_GET["cmdtype"] == "Cash") { 
	  	$sql = "SELECT * from view_s_ut  where  (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CAS'  ";
	  }	
      if ($_GET["cmdtype"] == "Return Cheque") { 
	  	$sql = "SELECT * from view_s_ut  where (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CHQ'  ";
	  }	
	  
	  if ($_GET["cmdtype"] == "All") { 
	  	$sql = "SELECT * from view_s_ut  where (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' )  ";
	  }	
   }
} else {
    if ($_GET["radio"]=="optdaly") {
       if ($_GET["cmdtype"] == "Invoice") { 
	   	$sql = "SELECT * from view_s_ut where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' and TYPE='INV' and DEV!='" . $dev . "'  ";
	   }	
       if ($_GET["cmdtype"] == "Cash") { 
	   	$sql = "SELECT * from view_s_ut  where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' and TYPE='Cash'  ";
	   }	
       if ($_GET["cmdtype"] == "Return Cheque") { 
	   	$sql = "SELECT * from view_s_ut   where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "' and TYPE='CHQ'  ";
		}
		if ($_GET["cmdtype"] == "All") { 
	   	$sql = "SELECT * from view_s_ut   where SAL_EX='" . trim($_GET["cmbrep"]) . "' and C_DATE='" . $_GET["dtfrom"] . "'  ";
		}
    }
     
    if ($_GET["radio"]=="optperiod") {
       if ($_GET["cmdtype"] == "Invoice") { 
	   	$sql = "SELECT * from view_s_ut where SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' )  and TYPE='INV' and DEV!='" . $dev . "'  ";
	   }	
       if ($_GET["cmdtype"] == "Cash") { 
	   	$sql = "SELECT * from view_s_ut  where  SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CAS'  ";
	   }	
       if ($_GET["cmdtype"] == "Return Cheque") { 
	   	$sql = "SELECT * from view_s_ut  where SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' ) and TYPE='CHQ'  ";
	   }
	   if ($_GET["cmdtype"] == "All") { 
	   	$sql = "SELECT * from view_s_ut  where SAL_EX='" . trim($_GET["cmbrep"]) . "' and (C_DATE='" . $_GET["dtfrom"] . "' or C_DATE>'" . $_GET["dtfrom"] . "' ) and (C_DATE='" . $_GET["dtto"] . "' or C_DATE<'" . $_GET["dtto"] . "' )  ";
	   }	
    }
}

if ($_GET["cmdtype1"] == "GRN") { 
$sql  =$sql  . " and trn_type='GRN'";
}

if ($_GET["cmdtype1"] == "DGRN") { 
$sql  =$sql  . " and trn_type='DGRN'";
}
 
if ($_GET["cmdtype1"] == "Credit Note") { 
$sql  =$sql  . " and  (trn_type='CNT' OR  trn_type='INC')";
} 

if ($_GET["cmdtype1"] == "Credit Note - SVAT") { 
$sql  =$sql  . " and  (trn_type='CNT' OR  trn_type='INC') and svatref!=''";
} 
 
 
$sql  =$sql  . " order by c_refno";
 
} else {
	$sql = "select * from s_crnfrm where Credit_note='A' order by Refno";
}  

$rtxtComName= $row_head["COMPANY"];
$rtxtcomadd1 = $row_head["ADD1"];
$rtxtComAdd2 = $row_head["ADD2"] . ", " . $row_head["ADD3"];

if ($_GET["chkappro"]!="on"){
if ($_GET["cmbrep"] == "All") {
	if ($_GET["radio"]=="optdaly") { 
		$txthead ="Utilize Report  Type   :" . "  " . $_GET["cmdtype"] .  " - " . $_GET["cmdtype1"] . "   On  " . date("Y-m-d", strtotime($_GET["dtfrom"]));
	}	
	if ($_GET["radio"]=="optperiod") { 
		$txthead = "Utilize Report  Type   :" . "  " . $_GET["cmdtype"] .  " - " . $_GET["cmdtype1"] . " From   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To  " . date("Y-m-d", strtotime($_GET["dtto"]));
	}	
} else {
	if ($_GET["radio"]=="optdaly") { 
		$txthead = "Utilize Report- Rep: " . $_GET["cmbrep"] .  "  Type   :" . "  " . $_GET["cmdtype"] .  " - " . $_GET["cmdtype1"] .  " On  " . date("Y-m-d", strtotime($_GET["dtfrom"]));
	}	
	if ($_GET["radio"]=="optperiod") { 
		$txthead = "Utilize Report - Rep: " . $_GET["cmbrep"] .   "    Type   :" . "  " . $_GET["cmdtype"] .  " - " . $_GET["cmdtype1"] . "   From   " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To  " . date("Y-m-d", strtotime($_GET["dtto"]));
	}
}
} else {
	$txthead ="Credit Note For Approval Report  : From - " . date("Y-m-d", strtotime($_GET["dtfrom"]))." To - ". date("Y-m-d", strtotime($_GET["dtto"]));
}
	


?>
</p>
<table width="1000" border="0">
  <tr>
    <td colspan="6" align="center"><b><?php echo $rtxtComName; ?></b></td>
  </tr>
  <tr>
    <td colspan="6" align="center"><?php echo $rtxtcomadd1; ?></td>
    
  </tr>
  <tr>
    <td colspan="6" align="center"><?php echo $rtxtComAdd2; ?></td>
   
  </tr>
  <tr>
    <td colspan="6"><b><?php echo $txthead; ?></b></td>
  
  </tr>
  <tr>
    <td colspan="6">
<?php
$C_PAYMENT=0;
if ($_GET["chkappro"]!="on"){
    
    echo "<table width=\"1000\" border=\"1\">
      <tr>
        <td ><b>Ref No</b></td>
        <td ><b>Date</b></td>
        <td ><b>GRN No</b></td>
        <td ><b>GRN Date</b></td>
        <td ><b>Ref INV/Ret. Ch</b></td>
        <td ><b>Customer</b></td>
        <td ><b>Amount</b></td>
       
      </tr>";
     
	 	$C_PAYMENT=0;
		$cus_tot=0;
		$i=0;
      $result =$db->RunQuery($sql);
	  while ($row = mysql_fetch_array($result)){
	  	
		if ($row["C_REFNO"]!=$C_REFNO){
		  if ($i!=0){	
			echo "
			<td align=right><b>".number_format($cus_tot, 2, ".", ",")."</b></td></tr>";
			
	  	  }	
		  	$i=1;
			$cus_tot=0;
			$C_REFNO=$row["C_REFNO"];
		} else {
			echo  "</tr>";
		}
      	echo "<tr>
        <td>".$row["C_REFNO"]."</td>
        <td>".$row["C_DATE"]."</td>
        <td>".$row["CRE_NO_NO"]."</td>
        <td>".$row["grndate"]."</td>
        <td>".$row["C_INVNO"]."</td>
        <td>".$row["C_CODE"]." ".$row["name"]."</td>
        <td align=right>".number_format($row["C_PAYMENT"], 2, ".", ",")."</td>";
       	$cus_tot=$cus_tot+$row["C_PAYMENT"];
     
	  	$C_PAYMENT=$C_PAYMENT+$row["C_PAYMENT"];
	 }
	 
	echo  "<tr>
        <td colspan=\"6\" >Total</td>
        
        <td  align=\"right\"><b>".number_format($C_PAYMENT, 2, ".", ",")."</b></td>
       
      </tr>
      
    </table>";
} else {
	$C_PAYMENT=0;
	 echo "<table width=\"1000\" border=\"1\">
      <tr>
       <td ><b>Ref No</b></td>
        <td ><b>Inv No</b></td>
        <td ><b>Cus Code</b></td>
        <td ><b>Cus Name</b></td>
        <td ><b>Incen Amount</b></td>
      </tr>";
	  
	  
	  $result =$db->RunQuery($sql);
	  while ($row = mysql_fetch_array($result)){
	  	
		$sql1="select * from s_crnfrmtrn where Refno='".$row["Refno"]."'";
		$result1 =$db->RunQuery($sql1);
	  	while ($row1 = mysql_fetch_array($result1)){
      		echo "<tr>
        	<td>".$row1["Refno"]."</td>
        	<td>".$row1["Inv_no"]."</td>";
			
			$sql2="select * from vendor where CODE='".$row1["Code"]."'";
			$result2 =$db->RunQuery($sql2);
	  		$row2 = mysql_fetch_array($result2);
			echo "<td>".$row1["Code"]."</td>
        	<td>".$row2["NAME"]."</td>
       	 	
        	<td align=right>".number_format($row1["Incen_val"], 2, ".", ",")."</td>";
       		
	  		$C_PAYMENT=$C_PAYMENT+$row1["Incen_val"];
	 	}
	 	
	  }
       echo "<tr>
       <td colspan=4><b>Total</b></td>
        <td align=right><b>".number_format($C_PAYMENT, 2, ".", ",")."</b></td></tr>";
     
}	
    
	 ?> 
     
      </td>
  </tr>
 
</table>
<p>&nbsp;</p>
</body>
</html>
