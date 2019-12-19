<?php  session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
		header('Content-Type: text/xml'); 
	 date_default_timezone_set('Asia/Colombo'); 
	 
	$MSHFlexGrid1 = array(array());
	$MSHFlexGrid1_count=0;
	$gridchk = array(array());

if ($_GET["Command"]=="update_bal"){
		$rct = "insert into cash_book_summery(company, trn_date, open_bal, closing_bal, balance) values ('".$_SESSION['COMCODE']."', '".$_GET["dtfrom"]."', ".str_replace(",", "", $_GET["opening_bal"]) .", ".str_replace(",", "", $_GET["tot_sale"]).", ".str_replace(",", "", $_GET["txtbf"]).")";
		$result = $db->RunQuery($rct);
		//echo $rct;
		echo "Updated";
	}
	
}
?>