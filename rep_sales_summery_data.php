<?php session_start();

////////////////////////////////////////////// Database Connector /////////////////////////////////////////////////////////////
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	////////////////////////////////////////////// Write XML ////////////////////////////////////////////////////////////////////
	header('Content-Type: text/xml'); 
	 date_default_timezone_set('Asia/Colombo'); 
		
	
	/////////////////////////////////////// GetValue //////////////////////////////////////////////////////////////////////////
	
		
				
	///////////////////////////////////// Registration /////////////////////////////////////////////////////////////////////////
		
		
		
		if($_GET["Command"]=="update_bal")
		{
			$open_bal=str_replace(",", "",$_GET["open_bal"]);
				$closing_bal=str_replace(",", "",$_GET["closing_bal"]);
				$txtbf=str_replace(",", "",$_GET["txtbf"]);
				
			$sql="SELECT * from cash_book_summery where company='".$_SESSION['COMCODE']."' and trn_date='".$_GET["dtfrom"]."'";
			$result =$db->RunQuery($sql);
			if ($row = mysql_fetch_array($result)){
				
				
				
				$sql1="SELECT * from cash_book_summery where company='".$_SESSION['COMCODE']."' and trn_date>'".$_GET["dtfrom"]."'";
				$result1 =$db->RunQuery($sql1);
				if ($row1 = mysql_fetch_array($result1)){
				} else {
					
					$sql1="delete from cash_book_summery where company='".$_SESSION['COMCODE']."' and trn_date='".$_GET["dtfrom"]."'";
					$result1 =$db->RunQuery($sql1);
					
					$sql1="insert into cash_book_summery (company, trn_date, open_bal, closing_bal, balance) values ('".$_SESSION['COMCODE']."', '".$_GET["dtfrom"]."', ".$open_bal.", ".$closing_bal.", ".$txtbf.")";
					//echo $sql1;
					$result1 =$db->RunQuery($sql1);
				}
				
			} else {
				$sql1="insert into cash_book_summery (company, trn_date, open_bal, closing_bal, balance) values ('".$_SESSION['COMCODE']."', '".$_GET["dtfrom"]."', ".$open_bal.", ".$closing_bal.", ".$txtbf.")";
				//echo $sql1;
					$result1 =$db->RunQuery($sql1);
			}
				
			echo "Balance Updated";
		}
		
	
?>