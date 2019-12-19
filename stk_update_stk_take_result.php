<?php
	
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
							
	$entREFNO = "TRN/" . $_GET["dtfrom"];
	
	
	$sql="delete from s_trn where REFNO='" . $entREFNO . "'";
	$result =$db->RunQuery($sql);
							
	//						while($row = mysql_fetch_array($result)){
	
	$sql_smas="select * from s_mas";
	$result_smas =$db->RunQuery($sql_smas);
	while($row_smas = mysql_fetch_array($result_smas)){
		
		$stkqty = 0;
		$sql_stkTake="select sum(QTY) as qty,sum(damage) damQTy from stk_take where STK_NO='" . trim($row_smas["STK_NO"]) . "'";
		//echo $sql_stkTake;
		$result_stkTake =$db->RunQuery($sql_stkTake);
		if($row_stkTake = mysql_fetch_array($result_stkTake)){	
			if ($row_stkTake["qty"]>0){ 
				$stkqty=$row_stkTake["qty"]; 
			} 
			
			if ($row_stkTake["damQTy"]>0){ 
				$stkqty=$stkqty-$row_stkTake["damQTy"]; 
			} 
		}
		
		$sql_stkDeli="select sum(QTY) as qty from stk_take_undelever where STK_NO='" . trim($row_smas["STK_NO"]) . "'";
		$result_stkDeli =$db->RunQuery($sql_stkDeli);
		if($row_stkDeli = mysql_fetch_array($result_stkDeli)){	
			if ($row_stkDeli["qty"]>0){ 
				$stkqty=$stkqty-$row_stkDeli["qty"]; 
			} 
		}
		
   
   		if ($stkqty < 0) { $stkqty = 0; }
		
		$sql="insert into s_trn (SDATE, STK_NO, REFNO, QTY, LEDINDI, DEPARTMENT) values ('" . $_GET["dtfrom"] . "', '" . $row_smas["STK_NO"] . "' , '" . $entREFNO . "', " . number_format($stkqty, 0, ".", "") . ", 'TRN', '1')";
		$result =$db->RunQuery($sql);
		
		$sql="update s_submas set QTYINHAND=".number_format($stkqty, 0, ".", "")." where  STK_NO='" . $row_smas["STK_NO"] . "' and STO_CODE='1'";
		$result =$db->RunQuery($sql);
		
		$sql="update s_mas set QTYINHAND=".number_format($stkqty, 0, ".", "")." where  STK_NO='" . $row_smas["STK_NO"] . "' ";
		$result =$db->RunQuery($sql);
   
  	}
	
	echo "Completed";		

?>
