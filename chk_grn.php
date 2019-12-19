<?php

require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();

	$rs3= "Select *  from s_crnma where SDATE>='2014-08-01'  and CANCELL!='1'";
	$result3 =$db->RunQuery($rs3);
	while ($row3 = mysql_fetch_array($result3)){
		
		$rs2= "Select * from c_bal where REFNO='".$row3["REF_NO"]."'";
		//echo $rs2;
		$result2 =$db->RunQuery($rs2);
		if ($row2 = mysql_fetch_array($result2)){
			if ($row2["AMOUNT"]!=$row3["GRAND_TOT"]){
				echo $row2["REFNO"]."  ".$row2["SDATE"]." - ".$row2["AMOUNT"]." - ".$row3["GRAND_TOT"]."</br>";
			}
		} else {
			echo $row3["REF_NO"]."  ".$row3["SDATE"]." ".$row3["CANCELL"]."</br>";
		}
	
	}
	
?>