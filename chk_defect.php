<?php

require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	$sqlt="SELECT * from c_clamas where  entdate>='2014-04-01' order by entdate";
	$resultt =$db->RunQuery($sqlt);
	while ($row = mysql_fetch_array($resultt)){
		$tot=0;
		if ($row["DGRN_NO"]!="0"){
			$sqlt1="SELECT * from s_deftrn where  REFNO='".$row["DGRN_NO"]."' and CANCELL!='1'";
			$resultt1 =$db->RunQuery($sqlt1);
			if ($row1 = mysql_fetch_array($resultt1)){
				$tot=$row1["AMOUNT"];
			}
			
		}
		
		if ($row["DGRN_NO2"]!="0"){
			$sqlt1="SELECT * from s_deftrn where  REFNO='".$row["DGRN_NO2"]."' and CANCELL!='1'";
			$resultt1 =$db->RunQuery($sqlt1);
			if ($row1 = mysql_fetch_array($resultt1)){
				$tot=$tot+$row1["AMOUNT"];
			}
			
		}
		
		if ($row["DGRN_NO3"]!="0"){
			$sqlt1="SELECT * from s_deftrn where  REFNO='".$row["DGRN_NO3"]."' and CANCELL!='1'";
			$resultt1 =$db->RunQuery($sqlt1);
			if ($row1 = mysql_fetch_array($resultt1)){
				$tot=$tot+$row1["AMOUNT"];
			}
			
		}
		
		
		if ($row["Amount"]!=$tot){
			echo $row["refno"]."--".$row["entdate"]."--Amount-".$row["Amount"]."--/--Total of GDRN-".$tot."</br>";
		}
	}
?>