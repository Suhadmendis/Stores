<?php

	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
//	echo "<table>";
	$sql="select * from s_crec where  CA_DATE>='2014-08-01' and FLAG!='RET'  order by CA_DATE";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		
		$sql1="select * from s_sttr where ST_REFNO='".$row["CA_REFNO"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
		} else {
			echo $row["CA_REFNO"]."-".$row["CA_DATE"]."</br>";
		}
			
		//if ($row1["totpay"]!=$row["TOTPAY"]){
		//	$bal=$row["TOTPAY"]-$row1["totpay"];
		//	echo "<tr><td>".$row["REF_NO"]."=".$row["SDATE"]."=</td><td>(".$row["TOTPAY"]."-".$row1["totpay"].")=</td><td>".$bal."</td></tr>";
		//}
		
	}
//echo "</table>";
?>