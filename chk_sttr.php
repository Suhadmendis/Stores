<?php

include('connection.php');

$sql="select * from s_crec where CA_DATE>'2015-08-12' and CANCELL!='1' and FLAG='REC'";
//echo $sql;
$result = mysql_query($sql, $dbinv);
while ($row = mysql_fetch_array($result)){
	
	$sql1="select * from s_sttr where ST_REFNO='".$row["CA_REFNO"]."'";
	$result1 = mysql_query($sql1, $dbinv);
	if ($row1 = mysql_fetch_array($result1)){
		
	} else {
		echo $row["CA_REFNO"]." - ".$row["CA_DATE"]." - ".$row["CA_CODE"]." - ".$row["CA_AMOUNT"]." </br>";
	}
	
}


/*$sql="select * from s_salma where GRAND_TOT=TOTPAY and CANCELL!='1' and SDATE>'2015-05-01'";
echo $sql;
$result = mysql_query($sql, $dbinv);
while ($row = mysql_fetch_array($result)){
	
	$sql1="select * from s_sttr where ST_INVONO='".$row["REF_NO"]."' ";
	$result1 = mysql_query($sql1, $dbinv);
	if ($row1 = mysql_fetch_array($result1)){
		
	} else {
		echo $row["REF_NO"]." - ".$row["SDATE"]." - ".$row["C_CODE"]." - ".$row["CUS_NAME"]."- </br>";
	}
	
}*/


?>