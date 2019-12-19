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


$sql_item = mysql_query("select * from s_mas where BRAND_NAME='CHENG SHING' order by STK_NO") or die(mysql_error());				
while($row_item = mysql_fetch_array($sql_item)){	
 $totqty=0;
  //echo $row_item["STK_NO"]."-";
  	$department=0;
  	$sql_sto = mysql_query("select * from s_stomas order by CODE") or die(mysql_error());				
  	while($row_sto = mysql_fetch_array($sql_sto)){	
		
		 $M_BAL = 0;
		// department wise/////////////////////////////////////
   		$sql = mysql_query("select * from s_trn where  ( SDATE <  '2013-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT='".$row_sto["CODE"]."' ORDER by SDATE") or die(mysql_error());
		//echo "select * from s_trn where  ( SDATE <  '2014-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT='".$row_sto["CODE"]."' ORDER by SDATE";
	
	
	
	
		while($row = mysql_fetch_array($sql)){
   
   	//===stock out
   			if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")){
      			$M_BAL = $M_BAL - $row["QTY"];
			
   			}
    
	//====stock in
   			if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
      			$M_BAL = $M_BAL + $row["QTY"];
   			}
   

      		if ($row["LEDINDI"] == "TRN"){
         		$M_BAL = $row["QTY"];
      		}
    	//}
   		}


   		
		
      	$sql = mysql_query("select * from s_trn where (SDATE >= '2013-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT = '".$row_sto["CODE"]."' ORDER BY SDATE") or die(mysql_error());
		//echo "select * from s_trn where (SDATE >= '2014-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT = '".$row_sto["CODE"]."' ORDER BY SDATE";
			
	

		$i = 0;
		while($row = mysql_fetch_array($sql)){



    		$refno=$row["REFNO"];
			$sdate=$row["SDATE"];
			$doc_type="";
			$fcolor="";
	
	
	
			if ($row["LEDINDI"]=="TRN"){
				
				$M_BAL = $row["QTY"];
   			}
	
	
    	//==stock out
			$qty4="";
    		if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")) {
       			$qty4 = $row["QTY"];
       			$M_BAL = $M_BAL - $row["QTY"];;
    		}
    
    	//===stock in
			$qty3="";
    		if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
       			$qty3 = $row["QTY"];
       			$M_BAL = $M_BAL + $row["QTY"];
    		}
    		$qty5 = $M_BAL;
						           
   						
    		$i = $i + 1;
		}
		//$department=$department+$M_BAL;
  			
	
	//$department=$M_BAL;
	
	/*
		// All/////////////////////////////////////
   		//$sql = mysql_query("select * from s_trn where  ( SDATE <  '2013-04-02') and STK_NO='".$row_item["STK_NO"]."' and DEPARTMENT='".$row_sto["CODE"]."' ORDER by SDATE") or die(mysql_error());
	$sql = mysql_query("select * from s_trn where  ( SDATE <  '2014-04-02') and STK_NO='".$row_item["STK_NO"]."' and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysql_error());
	
	
	
	$M_BAL = 0;
	while($row = mysql_fetch_array($sql)){
   
   	//===stock out
   		if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")){
      		$M_BAL = $M_BAL - $row["QTY"];
			
   		}
    
	//====stock in
   		if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
      		$M_BAL = $M_BAL + $row["QTY"];
   		}
   

      	if ($row["LEDINDI"] == "TRN"){
         	$M_BAL = $row["QTY"];
      	}
    	//}
   	}


		
	$sql = mysql_query("select *from s_trn where  (SDATE >=  '2014-04-02') and STK_NO='".$row_item["STK_NO"]."'and LEDINDI!='GINR' and LEDINDI!='GINI' and LEDINDI!='VGI' and LEDINDI!='VGR' ORDER BY SDATE") or die(mysql_error());	
	




	$i = 0;
	while($row = mysql_fetch_array($sql)){



    	$refno=$row["REFNO"];
		$sdate=$row["SDATE"];
		$doc_type="";
		$fcolor="";
	
	
		if ($row["LEDINDI"]=="INV"){
			$doc_type="Sales Invoice";
			$fcolor="#330066";
		}

	
		if ($row["LEDINDI"]=="TRN"){
			$doc_type="Inventory";
			$fcolor="#996600";
			$M_BAL = $row["QTY"];
   		}
	
	
    	//==stock out
		$qty4="";
    	if (($row["LEDINDI"] == "INV") or ($row["LEDINDI"] == "ORC") or ($row["LEDINDI"] == "GINI") or ($row["LEDINDI"] == "ARR") or ($row["LEDINDI"] == "IOU")) {
       		$qty4 = $row["QTY"];
       		$M_BAL = $M_BAL - $row["QTY"];;
    	}
    
    	//===stock in
		$qty3="";
    	if (($row["LEDINDI"] == "ARN") or ($row["LEDINDI"] == "GINR") or ($row["LEDINDI"] == "CRN") or ($row["LEDINDI"] == "GRN") or ($row["LEDINDI"] == "IIN")){
       		$qty3 = $row["QTY"];
       		$M_BAL = $M_BAL + $row["QTY"];
    	}
    	$qty5 = $M_BAL;
 
  
    	$i = $i + 1;
	}*/
	
	//if ($department!=$M_BAL){
	//	echo $row_item["STK_NO"]."-".$department."/".$M_BAL."</br>";
	//}
	$sql1 = mysql_query("update s_submas set QTYINHAND=".$M_BAL." where STO_CODE='".$row_sto["CODE"]."' and STK_NO='".$row_item["STK_NO"]."'") or die(mysql_error());
	echo "update s_submas set QTYINHAND=".$M_BAL." where STO_CODE='".$row_sto["CODE"]."' and STK_NO='".$row_item["STK_NO"]."'</br>";
	
	$totqty=$totqty+$M_BAL;
  }	
	//echo $row_sto["CODE"]."-".$row_item["STK_NO"]."-".$M_BAL."</br>";

	$sql1 = mysql_query("update s_mas set QTYINHAND=".$totqty." where STK_NO='".$row_item["STK_NO"]."' ") or die(mysql_error());
	echo "update s_mas set QTYINHAND=".$totqty." where STK_NO='".$row_item["STK_NO"]."'</br>";
}
	
?>
