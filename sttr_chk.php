<?php

	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$sql="select * from s_crec where CA_DATE>='2014-08-01' and CANCELL!='1' and FLAG!='RET'";
	$result =$db->RunQuery($sql);
	while ($row = mysql_fetch_array($result)){
		$sql1="select * from s_sttr where ST_REFNO='".$row["CA_REFNO"]."'";
		$result1 =$db->RunQuery($sql1);
		if ($row1 = mysql_fetch_array($result1)){
		} else {
			echo $row["CA_REFNO"]."-".$row["CA_DATE"]."-".$row["CA_CODE"]."</br>";
		}
	}
?>