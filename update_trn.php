<?php

	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	$sql="select * from s_trn";
	$result =$db->RunQuery($sql);
	while($row = mysql_fetch_array($result)){
		
		//$sqlvan="select * from vendor where CODE='".$row["cus_code"]."'";
		//$resultvan =$db->RunQuery($sqlvan);
		//$rowvan = mysql_fetch_array($resultvan);
		
		if (($row["LEDINDI"]=="ARN") or ($row["LEDINDI"]=="GINR") or ($row["LEDINDI"]=="GRN")){
			$QTY=$row["QTY"];
		} else if (($row["LEDINDI"]=="GINI") or ($row["LEDINDI"]=="INV")){
			$QTY=(-1*$row["QTY"]);
		}	
		
		$cuscode="";
		$cusname="";
		$salex="";
		$brand="";
				
		if ($row["LEDINDI"]=="INV"){
			$sqlsalma="select * from s_salma where REF_NO='".$row["REFNO"]."'";
			$resultsalma =$db->RunQuery($sqlsalma);
			if ($rowsalma = mysql_fetch_array($resultsalma)){
				$cuscode=$rowsalma["C_CODE"];
				$cusname=$rowsalma["CUS_NAME"];
				$salex=$rowsalma["SAL_EX"];
				$brand=$rowsalma["Brand"];
			}
			
		}
		
		if ($row["LEDINDI"]=="GRN"){
			$sqlsalma="select * from s_crnma where REF_NO='".$row["REFNO"]."'";
			$resultsalma =$db->RunQuery($sqlsalma);
			if ($rowsalma = mysql_fetch_array($resultsalma)){
				$cuscode=$rowsalma["C_CODE"];
				$cusname=$rowsalma["CUS_NAME"];
				$salex=$rowsalma["SAL_EX"];
				$brand=$rowsalma["Brand"];
			}
			
		}
		
		if ($row["LEDINDI"]=="ARN"){
			$sqlsalma="select * from s_purmas where REFNO='".$row["REFNO"]."'";
			$resultsalma =$db->RunQuery($sqlsalma);
			if ($rowsalma = mysql_fetch_array($resultsalma)){
				$cuscode=$rowsalma["SUP_CODE"];
				$cusname=$rowsalma["SUP_NAME"];
				$salex=$rowsalma["SAL_EX"];
				$brand=$rowsalma["brand"];
			}
			
		}
		
		if (($row["LEDINDI"]=="GINI") or ($row["LEDINDI"]=="GINR")){
			$sqlbrand="select * from s_mas where STK_NO='".$row["STK_NO"]."'";
			$resultbrand =$db->RunQuery($sqlbrand);
			$rowbrand = mysql_fetch_array($resultbrand);
			$brand=$rowbrand["BRAND_NAME"];
		}	
					
		$sql1="insert into s_trn_all(STK_NO, SDATE, QTY, LEDINDI, REFNO, DEPARTMENT, seri_no, Dev, SAL_EX, ACTIVE, DONO, cuscode, cusname, brand) values ('".$row["STK_NO"]."', '".$row["SDATE"]."', '".$QTY."', '".$row["LEDINDI"]."', '".$row["REFNO"]."', '".$row["DEPARTMENT"]."', '".$row["seri_no"]."', '".$_SESSION['dev']."', '".$salex."', '".$row["ACTIVE"]."', '".$row["DONO"]."', '".$cuscode."', '".$cusname."', '".$brand."')";
		$result1 =$db->RunQuery($sql1);
	}	
	
	echo "Successfully Completed";	
	
?>