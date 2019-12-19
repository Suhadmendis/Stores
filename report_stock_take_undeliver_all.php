<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Undeliver Report - All</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
table
{
border-collapse:collapse;
}
table, td, th
{
border:0px solid black ;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:14px;
border-bottom:dotted 1px black;

}
td
{
font-size:14px;


}
</style>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>

<body>
 <!-- Progress bar holder -->


<?php
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();




		echo "<center><b>Un Deliver Stock Report</b><br>";
		echo "<center><br>";
		
		echo "<center><table border=1 width=\"1000\"><tr>
		<th align=left>Invoice No</th>
		<th align=left>Stk No</th>
		<th align=left>Description</th>
		<th align=left>Part No</th>
		<th align=left>Brand</th>
		<th align=right>Qty</th>
		<th align=right>Damage</th>
		<th align=right>Cost</th>
		<th align=right>Total Cost</th>
		</tr>";
		//echo $sql;
		//$sql=$sql." order by SDATE, ST_INVONO"; 
		//echo $sql;
		$sql = "SELECT * from stk_take_undelever  order by REF_NO, id ";
		$result =$db->RunQuery($sql);
		while($row = mysql_fetch_array($result)){	
			
			echo "<tr>";
			if ($REF_NO!=$row["REF_NO"]){
				echo  "<td>".$row["REF_NO"]."</td>";
				$REF_NO=$row["REF_NO"];
			} else {
				echo  "<td></td>";
			}
				
				echo "<td align=left>".$row["STK_NO"]."</td>
				<td align=left>".$row["DESCRIPT"]."</td>
				<td align=left>".$row["PART_NO"]."</td>
				<td align=left>".$row["BRAND"]."</td>
				<td align=right>".$row["QTY"]."</td>
				<td align=right>".$row["damage"]."</td>
				<td align=right>".number_format($row["COST"], 2, ".", ",")."</td>
				<td align=right>".number_format(($row["QTY"]*$row["COST"]), 2, ".", ",")."</td></tr>";
				
				$qty=$qty+$row["QTY"];
				$damage=$damage+$row["damage"];
				$tot_cost=$tot_cost+($row["QTY"]*$row["COST"]);
		}		 
		 	
			
		echo "<tr>
				<td colspan=5>&nbsp;</td>
				<td align=right><b>".$qty."</b></td>
				<td align=right><b>".$damage."</b></td>
				<td>&nbsp;</td>
				<td align=right><b>".number_format($tot_cost, 2, ".", ",")."</b></td></tr>";
			
			
		echo "<table>";	

?>
</body>
</html>
