<?php ini_set('session.gc_maxlifetime', 30*60*60*60);
session_start();
date_default_timezone_set('Asia/Colombo');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stock Report</title>

<style>
table
{
border-collapse:collapse;
}
table,  th
{
border:1px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:12x;

}
td
{
font-size:12px;
border-bottom: dashed;
border-width: thin;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
</style>

</head>

<body>
	<?php
	
    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpstk";
	$result =$db->RunQuery($sql);
	
		$sql_head="select * from invpara where COMCODE = 'C'";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\"><b>".$row_head["COMPANY"]." [".date("Y-m-d")."]</b></center><br>";
		
function cost()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
		
		
		
		
	
	
	if ($_GET["brand"] == "All"){
        if ($_GET["cat"] != "All") {$sql = "select * from s_mas where CAT='".$_GET["cat"]."' and QTYINHAND!=0  "; }
        if ($_GET["cat"] == "All") {$sql = "select * from s_mas where QTYINHAND!=0  ";}
    }
	
    if ($_GET["brand"] != "All"){
        if ($_GET["cat"] != "All") { $sql = "select * from viewsubmas where BRAND_NAME='".$_GET["brand"]."' and CAT='".$_GET["cat"]."'  and QTYINHAND!=0  "; }
        if ($_GET["cat"]	== "All") { $sql = "select * from viewsubmas where BRAND_NAME='".$_GET["brand"]."' and QTYINHAND!=0 ";  }
    }
	
    if ($_GET['chkmin'] ==on) {
        $sql = $sql . " and qtyinhand <0 " ;
    }
    
    $sql =$sql . " ORDER BY BRAND_NAME, DESCRIPT, GROUP1, GROUP2, model ";
    
	echo "<center><b>Stock Report On ".date("Y-m-d")." Brand - ".$_GET["brand"]." Department - ".$_GET["department"]."</b><br>";
	
	echo "<center><table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Gen No</th><th>Substitute</th><th>Qty in hand </th><th>Cost</th><th>Total Cost</th></tr>";
		
	$totstk=0;
	$cost=0;
	//echo $sql;
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		if ($brand!=$rows["BRAND_NAME"]){
			echo "
			<th colspan=6 align=left><b>".$rows["BRAND_NAME"]."</b></th></tr>";
			$brand=$rows["BRAND_NAME"];
		} 	
		
	//	if ($_SESSION['dev']=='1'){
			echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td>".$rows["GEN_NO"]."</td><td>".$rows["SUBSTITUTE"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["COST"], 2, ".", ",")."</td><td align=\"right\">".number_format(($rows["QTYINHAND"]*$rows["COST"]), 2, ".", ",")."</td></tr>";
			$totstk=$totstk+$rows["QTYINHAND"];
			$cost=$cost+($rows["QTYINHAND"]*$rows["COST"]);
			
	/*	} else if ($_SESSION['dev']=='0'){
		
			echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td>".$rows["GEN_NO"]."</td><td>".$rows["SUBSTITUTE"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 0, ".", ",")."</td><td align=\"right\">".number_format($rows["acc_cost"], 2, ".", ",")."</td><td align=\"right\">".number_format(($rows["QTYINHAND"]*$rows["acc_cost"]), 2, ".", ",")."</td></tr>";
			$totstk=$totstk+$rows["QTYINHAND"];
			$cost=$cost+($rows["QTYINHAND"]*$rows["acc_cost"]);
		}*/	
	}
	
	echo "<tr><td colspan=5>".$rows["STK_NO"]."</td><td align=\"right\"><b>".number_format($totstk, 2, ".", ",")."</b></td><td align=\"right\">&nbsp;</td><td align=\"right\"><b>".number_format($cost, 2, ".", ",")."</b></td></tr>";
	echo "</table>";
}


function selling()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	    if ($_GET["brand"] != "All") { 
			if ($_GET["cat"] != "All") { 
				$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and CAT='".$_GET["cat"]."'  ORDER BY DESCRIPT, GROUP1, model, GROUP2 ";
			} else {
				$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."'  ORDER BY DESCRIPT, GROUP1, model, GROUP2 ";
			}
		}	
        if ($_GET["brand"] == "All") { 
			if ($_GET["cat"] != "All") { 
				$sql = "select * from s_mas where CAT='".$_GET["cat"]."'  ORDER BY BRAND_NAME, DESCRIPT, GROUP1, model, GROUP2 ";
			} else {
				$sql = "select * from s_mas where  ORDER BY BRAND_NAME, DESCRIPT, GROUP1, model, GROUP2 ";
			}
		}	
        //echo $sql;
        echo "<center><table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Gen No</th><th>Substitute</th><th>Qty in hand </th><th>Selling</th><th>Total</th></tr>";
	$QTYINHAND=0;
	$tot=0;
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		if ($brand!=$rows["BRAND_NAME"]){
			echo "
			<th colspan=7 align=left><b>".$rows["BRAND_NAME"]."</b></th></tr>";
			$brand=$rows["BRAND_NAME"];
		} 	
		
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td>".$rows["GEN_NO"]."</td><td>".$rows["SUBSTITUTE"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["SELLING"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["QTYINHAND"]*$rows["SELLING"], 2, ".", ",")."</td></tr>";
		$QTYINHAND=$QTYINHAND+$rows["QTYINHAND"];
		$tot=$tot+($rows["SELLING"]*$rows["QTYINHAND"]);
	}
	
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td><td align=\"right\">&nbsp;</td><td align=\"right\"><b>".number_format($tot, 2, ".", ",")."</b></td></tr>";
	echo "</table>";
       
}
	
function print_rep()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["brand"] != "All") { 
		if ($_GET["cat"] != "All") { 
	 		$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and CAT='".$_GET["cat"]."' and QTYINHAND!=0 ORDER BY  DESCRIPT, GROUP1, model, GROUP2 "; 
		} else {
			$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and QTYINHAND!=0 ORDER BY  DESCRIPT, GROUP1, model, GROUP2 ";
		}
	}	
    
	if ($_GET["brand"] == "All") { 
		if ($_GET["cat"] != "All") { 
	 		$sql = "select * from s_mas where CAT='".$_GET["cat"]."' and QTYINHAND!=0   ORDER BY BRAND_NAME, DESCRIPT, GROUP1, model, GROUP2 "; 
		} else {
			$sql = "select * from s_mas where QTYINHAND!=0   ORDER BY BRAND_NAME, DESCRIPT, GROUP1, model, GROUP2 ";
		}
	}		

  	echo "<center><table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Gen No</th><th>Substitute</th><th>Qty in hand </th></tr>";
	
	$QTYINHAND=0;
	
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		if ($brand!=$rows["BRAND_NAME"]){
			echo "
			<th colspan=7 align=left><b>".$rows["BRAND_NAME"]."</b></th></tr>";
			$brand=$rows["BRAND_NAME"];
		} 	
		
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PART_NO"]."</td><td>".$rows["GEN_NO"]."</td><td>".$rows["SUBSTITUTE"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 2, ".", ",")."</td></tr>";
		$QTYINHAND=$QTYINHAND+$rows["QTYINHAND"];
	}
	
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td></tr>";
	
	echo "</table>";
}

function print_grp_rep()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	if ($_GET["brand"] != "All") { 
		if ($_GET["cat"] != "All") { 
	 		$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' and CAT='".$_GET["cat"]."' and QTYINHAND!=0 ORDER BY  DESCRIPT, GROUP1, model, GROUP2 "; 
		} else {
			$sql = "select * from s_mas where BRAND_NAME='".$_GET["brand"]."' ORDER BY  GROUP1, GROUP2, DESCRIPT, model ";
		}
	}else{
            echo "Please select a Brand !";
            die();
        }	
        //echo $sql;
		

  	echo "<center><table border=1><tr>
		<th>Item</th><th>Part No</th><th>".$_GET["brand"]." Description</th><th>Selling </th></tr>";
	
	$QTYINHAND=0;
	$brand = "";
	$brand1 = "";
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		if ($brand != $rows["GROUP1"]){
		    $brand=$rows["GROUP1"];
			echo "
			<th colspan=7 align=left><b>Group 1 : ".$rows["GROUP1"]."</b></th></tr>";
			
		}
		if ($brand1 != $rows["GROUP2"]){
		    $brand1=$rows["GROUP2"];
			echo "
			<th colspan=7 align=center><b>Group 2 : ".$rows["GROUP2"]."</b></th></tr>";
			
		} 
		
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["PART_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td align=\"right\">".number_format($rows["SELLING"], 2, ".", ",")."</td></tr>";
		//$QTYINHAND=$QTYINHAND+$rows["QTYINHAND"];
	}
	
	//echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td><td>&nbsp;</td></tr>";
	
	echo "</table>";
}
	
function printit_print()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	echo "<center>Stock Report On " . date("Y-m-d")." &nbsp;&nbsp;&nbsp;&nbsp;Brand :".$_GET["brand"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department : ".$_GET["department"]."<center>";

	if ($_GET["stype"]=="Print"){
		$sql = "select * from tmpstk where QTYINHAND!=0 order by DESCRIPT"; 
	} else {	
		$sql = "select * from tmpstk where QTYINHAND!=0 and TOTCOST!=0 order by DESCRIPT"; 
	}
	
	
//echo $sql;
  	//echo "<center><table border=1><tr>
	//	<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total</th></tr>
	//	<th></th><th><b>".$_GET["brand"]."</b></th><th></th><th></th><th></th><th></th></tr>";
	
	echo "<center><table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th></tr>
		<th></th><th><b>".$_GET["brand"]."</b></th><th></th><th></th></tr>";
	
	$QTYINHAND=0;
	$TOTCOST=0;
	//echo $sql;
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		//echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PARTNO"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 0, ".", ",")."</td><td align=\"right\">".number_format($rows["COST"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["TOTCOST"], 2, ".", ",")."</td></tr>";
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PARTNO"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 2, ".", ",")."</td></tr>";
		$QTYINHAND=$QTYINHAND+$rows["QTYINHAND"];
		$TOTCOST=$TOTCOST+$rows["TOTCOST"];
	}
	
	//echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td><td align=\"right\">&nbsp;</td><td align=\"right\"><b>".number_format($TOTCOST, 2, ".", ",")."</b></td></tr>";
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td></tr>";
	
	echo "</table>";
}	

function printit()
{

	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	//$sql = "select * from tmpstk where QTYINHAND!=0 and TOTCOST!=0  order by GROUP1"; 
	$sql = "select * from tmpstk where QTYINHAND!=0  order by DESCRIPT"; 
	
	echo "<center>Sales Summery Report On " . date("Y-m-d")." &nbsp;&nbsp;&nbsp;&nbsp;Brand :".$_GET["brand"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department : ".$_GET["department"]."<center>";
	
  	echo "<center><table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Cost</th><th>Total Cost</th></tr>
		<th></th><th><b>".$_GET["brand"]."</b></th><th></th><th></th><th></th><th></th></tr>";
	
	$QTYINHAND=0;
	$TOTCOST=0;
	//echo $sql;
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PARTNO"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["COST"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["TOTCOST"], 2, ".", ",")."</td></tr>";
		$QTYINHAND=$QTYINHAND+$rows["QTYINHAND"];
		$TOTCOST=$TOTCOST+$rows["TOTCOST"];
	}
	
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td><td align=\"right\">&nbsp;</td><td align=\"right\"><b>".number_format($TOTCOST, 2, ".", ",")."</b></td></tr>";
	echo "</table>";
}

function printit_selling()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	//$sql = "select * from tmpstk where QTYINHAND!=0 and TOTCOST!=0  order by GROUP1"; 
	$sql = "select * from tmpstk where QTYINHAND!=0  order by DESCRIPT"; 
	
	echo "<center>Sales Summery Report On " . date("Y-m-d")." &nbsp;&nbsp;&nbsp;&nbsp;Brand :".$_GET["brand"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Department : ".$_GET["department"]."<center>";
	
  	echo "<center><table border=1><tr>
		<th>Item</th><th>Description</th><th>Part No</th><th>Qty in hand </th><th>Selling</th><th>Total</th></tr>
		<th></th><th><b>".$_GET["brand"]."</b></th><th></th><th></th><th></th><th></th></tr>";
	
	$QTYINHAND=0;
	$TOTCOST=0;
	//echo $sql;
	$result =$db->RunQuery($sql);
	while ($rows = mysql_fetch_array($result)){
		echo "<tr><td>".$rows["STK_NO"]."</td><td>".$rows["DESCRIPT"]."</td><td>".$rows["PARTNO"]."</td><td align=\"right\">".number_format($rows["QTYINHAND"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["COST"], 2, ".", ",")."</td><td align=\"right\">".number_format($rows["TOTCOST"], 2, ".", ",")."</td></tr>";
		$QTYINHAND=$QTYINHAND+$rows["QTYINHAND"];
		$TOTCOST=$TOTCOST+$rows["TOTCOST"];
	}
	
	echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align=\"right\"><b>".number_format($QTYINHAND, 2, ".", ",")."</b></td><td align=\"right\">&nbsp;</td><td align=\"right\"><b>".number_format($TOTCOST, 2, ".", ",")."</b></td></tr>";
	echo "</table>";
}


		if ($_GET["stype"]=="Cost"){
			
			cost();
		} else if ($_GET["stype"]=="Selling"){
			
			selling();
		} else if ($_GET["stype"]=="grpPrint"){
			
                        print_grp_rep();
		} else {
			
			print_rep();
		}
		
/*
if ($_GET["cat"]=="All"){
	
	if ($_GET["chkitem"]!="on") {
		if ($_GET["stype"]=="Cost"){
			
			cost();
		} else if ($_GET["stype"]=="Selling"){
			
			selling();
		} else {
			
			print_rep();
		}
	} else {
		
        $sql="select itemcode, name from tmpitem";
		$result =$db->RunQuery($sql);
		while ($rows = mysql_fetch_array($result)){
	    	
			$sql1="select * from s_mas where STK_NO='".$rows["itemcode"]."'";
			$result1 =$db->RunQuery($sql1);
			if ($rows1 = mysql_fetch_array($result1)){
            	$costval=0;
            	if ($_GET["stype"] == "Cost") {
					if ($_SESSION['dev']=='1'){
                		if (!is_null($rows1["COST"])) {$costval = $rows1["COST"];}
					} else if ($_SESSION['dev']=='0'){	
						if (!is_null($rows1["acc_cost"])) {$costval = $rows1["acc_cost"];}
					}
            	} else {
					if (!is_null($rows1["selling"])) {$costval = $rows1["selling"];}
            	}
                
				$sql2="Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, COST, TOTCOST, QTYINHAND, group1) values ('".$rows1["STK_NO"]."', '".$rows1["DESCRIPT"]."', '".$rows1["PART_NO"]."', ".$costval.", ".$costval * $rows1["QTYINHAND"].", ".$rows1["QTYINHAND"].", '".$rows1["GROUP1"]."')";
				
           		$result2 =$db->RunQuery($sql2);
            	$costval = 0;
            }

        }
      
       if ($_GET["stype"] == "Print"){
	   		
       		printit_print();
       } else {
	   		//echo "printit";
			printit();
       }
		
		
	}

} else {
	
	if ($_GET["chkitem"]!="on") {
	
    	if ($_GET["brand"] != "All")  {$sql = "select * from viewsubmas where BRAND_NAME='".$_GET["brand"]."' and STO_CODE='".intval($_GET["department"])."' and QTYINHAND!=0  ORDER BY STK_NO, GROUP1, GROUP2, model ";}
        
		if ($_GET["brand"] == "All")  {$sql = "select * from viewsubmas where STO_CODE='".intval($_GET["department"])."' and QTYINHAND!=0  ORDER BY  STK_NO, GROUP1, GROUP2, model ";}
		//echo $sql;
			$result =$db->RunQuery($sql);
			while ($rows = mysql_fetch_array($result)){
				$costval=0;
    			if ($_GET["stype"] == "Cost") {
					if ($_SESSION['dev']=='1'){
                		if (!is_null($rows["COST"])) { $costval = $rows["COST"]; }
					} else if ($_SESSION['dev']=='0'){
						if (!is_null($rows["acc_cost"])) { $costval = $rows["acc_cost"]; }
					}	
                } else {
                 	if (!is_null($rows["SELLING"])) { $costval = $rows["SELLING"]; }
                }
				
				$sql1="Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, COST, TOTCOST, QTYINHAND, BRAND, group1) values ('".$rows["STK_NO"]."', '".$rows["DESCRIPt"]."', '".$rows["PART_NO"]."', ".$costval.", ".$costval * $rows["QTYINHAND"].", ".$rows["QTYINHAND"].", '".$rows["BRAND_NAME"]."', '".$rows["GROUP1"]."')";
                $result1 =$db->RunQuery($sql1);
   				$costval = 0;
      
    		}
	
      
	   	if ($_GET["stype"] == "Print"){
        	printit_print();
       	} else if ($_GET["stype"] == "Selling"){
			printit_selling();
		} else {	
        	printit();
       	}
    
	} else {
        
        $sql="select * from tmpitem";
		$result =$db->RunQuery($sql);
		while ($rows = mysql_fetch_array($result)){
            $sql1="select * from s_mas where STK_NO='".$rows["itemcode"]."'";
			$result1 =$db->RunQuery($sql1);
			if ($rows1 = mysql_fetch_array($result1)){
				$sql2="select QTYINHAND from s_submas where STK_NO='".$rows["itemcode"]."' and STO_CODE='".intval($_GET["department"])."'";
				$result2 =$db->RunQuery($sql2);
				if ($rows2 = mysql_fetch_array($result2)){
					$costval=0;
					if ($_GET["stype"] = "Cost"){
						if ($_SESSION['dev']=='1'){
                			$costval = $rows1["COST"];
						} else if ($_SESSION['dev']=='0'){
							$costval = $rows1["acc_cost"];
						}
					} else {
						$costval = $rows1["SELLING"];
					}	
          
                	$sql3="Insert into tmpstk (STK_NO, DESCRIPT, PARTNO, TOTCOST, QTYINHAND, BRAND, group1) values 
					('".$rows1["STK_NO"]."', '".$rows1["DESCRIPT"]."', '".$rows1["PART_NO"]."', ".$costval.", ".$costval * $rows2["QTYINHAND"].", ".$rows2["QTYINHAND"].", '".$rows1["BRAND_NAME"]. "', '".$rows1["GROUP1"]."')";
					$result3 =$db->RunQuery($sql3);
					$costval = 0;

				}
			}
		}

       	if ($_GET["stype"] == "Print"){
        	printit_print();
       	} else if ($_GET["stype"] == "Selling"){
			printit_selling();
		} else {	
        	printit();
       	}
    }
}	
	
*/

?>
</body>
</html>
