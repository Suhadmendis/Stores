<?php
/*
$hostname = 'localhost';
$username = 'root';
$password = '';*/
$hostname = 'localhost';
$username = 'nwpgis';
$password = 'Anaconda@';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//$ben = mysql_connect($hostname, $username, $password);
//$ben_tyre = mysql_connect($hostname, $username, $password, true);
/*
if ($_SESSION['COMCODE']=="A"){
	mysql_select_db('nwpgis_pt_acca', $dbacc);
} else if ($_SESSION['COMCODE']=="B"){
	mysql_select_db('nwpgis_pt_accb', $dbacc);
} else if ($_SESSION['COMCODE']=="C"){
	mysql_select_db('nwpgis_pt_accc', $dbacc);
}
*/
mysql_select_db('nwpgis_pt_accc', $dbacc);
mysql_select_db('nwpgis_pt', $dbinv);

 $sql = "select * from s_crec where pay_type='Cash TT' and CA_DATE>='2015-05-01'";
 
 $result = mysql_query($sql, $dbinv);
 while ($row = mysql_fetch_array($result)){
 
 	$sql1="update bankdepmas set bdate='".$row["TTDATE"]."' where refno='".$row["CA_REFNO"]."'";
	$result1 = mysql_query($sql1, $dbacc);
	
	$sql1="update ledger set l_date='".$row["TTDATE"]."' where l_refno='".$row["CA_REFNO"]."'";
	$result1 = mysql_query($sql1, $dbacc);
	
	$sql1="update bankdeptrn set bdate='".$row["TTDATE"]."' where refno='".$row["CA_REFNO"]."'";
	$result1 = mysql_query($sql1, $dbacc);
	
	$sql1="update bankdepche set bdate='".$row["TTDATE"]."' where refno='".$row["CA_REFNO"]."'";
	$result1 = mysql_query($sql1, $dbacc);
 	
 
 }

 

?>