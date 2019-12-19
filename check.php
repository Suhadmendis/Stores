<?php

require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	echo "<table>";
	$sql="select * from s_salma where CANCELL='0' and SDATE>='2013-08-01' and C_CODE='L057'  order by SDATE";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		$sql1="select sum(ST_PAID) as totpay from s_sttr where ST_INVONO='".$row["REF_NO"]."'";
		$result1 =$db->RunQuery($sql1);
		$row1 = mysql_fetch_array($result1);
			
		//if ($row1["totpay"]!=$row["TOTPAY"]){
			$bal=$row["TOTPAY"]-$row1["totpay"];
			echo "<tr><td>".$row["REF_NO"]."=".$row["SDATE"]."=</td><td>(".$row["TOTPAY"]."-".$row1["totpay"].")=</td><td>".$bal."</td></tr>";
		//}
		
	}
echo "</table>";
?>