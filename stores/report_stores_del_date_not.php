<?php session_start(); ?>
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
border:1px solid black;
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

<body><center>


<p>
  <?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
	if ($_GET["checkbox"]=="on"){
	echo "<table border=1>
	<tr>
    <td><b>Invoice No</b></td>
    <td><b>Dealer Code</b></td>
    <td><b>Dealer Name</b></td>
    <td><b>Invoice Date</b></td>
    <td><b>Rep Code</b></td>
    <td><b>Driver</b></td>
    <td><b>Vehicle No</b></td>
    
  </tr>";
  } else {
  	echo "<table border=1>
	<tr>
    <td><b>Invoice No</b></td>
    <td><b>Dealer Code</b></td>
    <td><b>Dealer Name</b></td>
    <td><b>Invoice Date</b></td>
    <td><b>Rep Code</b></td>
    <td><b>Driver</b></td>
    <td><b>Vehicle No</b></td>
    <td><b>Delivery Date</b></td>
  </tr>";
  }
 
	
  if ($_GET["checkbox"]=="on")	{
	$sql_rst = "select * from s_salma where (deli_date IS NULL or deli_date='0000-00-00') and CANCELL='0' and SDATE>='".$_GET["dtfrom"]."' and SDATE<='".$_GET["dtto"]."' order by REF_NO";
  } else {
  	$sql_rst = "select * from s_salma where CANCELL='0' and SDATE>='".$_GET["dtfrom"]."' and SDATE<='".$_GET["dtto"]."' order by REF_NO";
  }	
	$result_rst =$db->RunQuery($sql_rst);
	while($row_rst = mysql_fetch_array($result_rst)){
	
	if ($_GET["checkbox"]=="on"){
		echo "
	<tr>
    <td>".$row_rst["REF_NO"]."</td>
    <td>".$row_rst["C_CODE"]."</td>
    <td>".$row_rst["CUS_NAME"]."</td>
    <td>".$row_rst["SDATE"]."</td>
    <td>".$row_rst["SAL_EX"]."</td>
    <td>".$row_rst["driver"]."</td>
    <td>".$row_rst["veheno"]."</td>
    
  </tr>";
    } else {
		
		echo "
	<tr>
    <td>".$row_rst["REF_NO"]."</td>
    <td>".$row_rst["C_CODE"]."</td>
    <td>".$row_rst["CUS_NAME"]."</td>
    <td>".$row_rst["SDATE"]."</td>
    <td>".$row_rst["SAL_EX"]."</td>
    <td>".$row_rst["driver"]."</td>
    <td>".$row_rst["veheno"]."</td>
    <td>".$row_rst["deli_date"]."</td>
  </tr>";
		
	}
  }
 

?> 
</table>
</body>
</html>
