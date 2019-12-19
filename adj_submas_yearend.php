<?php  session_start();

/*
	include_once("config.inc.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =$db->RunQuery($sql);
			
			
			while($row = mysql_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		



	include_once("connection.php");


	$sql1 = "update s_submas set QTYINHAND=0 ";
	$result1=mysql_query($sql1, $dbinv);	
	//$row1 = mysql_fetch_array($sql1);
	
//$sql_item = mysql_query("select * from s_mas where BRAND_NAME='CHENG SHING' and STK_NO='06010' order by STK_NO") or die(mysql_error());				
$sql_item ="select * from s_mas order by STK_NO";		
$result_item=mysql_query($sql_item, $dbinv);			
while($row_item = mysql_fetch_array($result_item)){	
  $M_BAL = 0;
  	$sql1 = "update s_submas set QTYINHAND=".$row_item["QTYINHAND"]." where STK_NO='".$row_item["STK_NO"]."' and STO_CODE='1'";
	$result1=mysql_query($sql1, $dbinv);			
//	$row1 = mysql_fetch_array($sql1);
	
 
}
	
?>
