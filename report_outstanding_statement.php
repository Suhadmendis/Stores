<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Outstanding Statement</title>

<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
font-family:Arial, Helvetica, sans-serif;
padding:5px;
}
th
{
font-weight:bold;
font-size:14px;

}
td
{
font-size:14px;

}
</style>

</head>

<body>


<?php

    require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
    
    $sql="delete from tmpcustomerout";
	$result =$db->RunQuery($sql);
	
	$sql_head="select * from invpara where COMCODE='".$_SESSION['company']."'";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center>";
		
	echo "<center><h3>Statement of Account</h3>Date : ".$_GET["dtddate"]."<br>";
	echo "<b>Customer :".$_GET["cuscode"]." - ".$_GET["cusname"]."</b>";
	
	//$_SESSION['dev']="1";
        
        $sql_salma="select * from s_salma where C_CODE='".$_GET["cuscode"]."' and (GRAND_TOT-TOTPAY)>10 and (SDATE<='".$_GET["dtddate"]."')  and CANCELL='0' order by SDATE";

        //echo $sql_salma;
	$result_salma =$db->RunQuery($sql_salma);
	while($row_salma = mysql_fetch_array($result_salma)){
		 
		 	$date1 = $row_salma["SDATE"];
			$date2 = date("Y-m-d");
			$diff = abs(strtotime($date2) - strtotime($date1));
			$days = floor($diff / (60*60*24));
			
			$sql_rep="select name from s_salrep where REPCODE='".$row_salma["SAL_EX"]."'";
			//echo $sql_rep;
			$result_rep =$db->RunQuery($sql_rep);
			$row_rep = mysql_fetch_array($result_rep);
	
		 $sql="insert into tmpcustomerout(REF_NO, SDATE, days, AMOUNT, paid, SAL_EX, barnd, REPNAME, da_no) value ('".$row_salma["REF_NO"]."', '".$row_salma["SDATE"]."', '".$days."', '".$row_salma["GRAND_TOT"]."', '".$row_salma["TOTPAY"]."', '".$row_salma["SAL_EX"]."', '".$row_salma["Brand"]."', '".$row_rep["name"]."', '".$row_salma["dele_no"]."')";
		 $result =$db->RunQuery($sql);
	}

 $sql1 = "SELECT * from view_scheq_vendor where  CR_FLAG='0' and  CR_CHEVAL>PAID+1 and CR_C_CODE = '" . $_GET["cuscode"] . "'";


        $result1 = $db->RunQuery($sql1);
        while ($row = mysql_fetch_array($result1)) {
            $date1 = date("Y-m-d");
            $date2 = $row["CR_DATE"];

            $diff = abs(strtotime($date2) - strtotime($date1));
            $days = floor($diff / (60 * 60 * 24));

            $sqlv = "select * from vendor where code ='" . $row['CR_C_CODE'] . "'";
            $resultv = $db->RunQuery($sqlv);
            $rowv = mysql_fetch_array($resultv);

            $sql_rep = "select name from s_salrep where REPCODE='" . $row_salma["SAL_EX"] . "'";
            //echo $sql_rep;
            $result_rep = $db->RunQuery($sql_rep);
            $row_rep = mysql_fetch_array($result_rep);

//            $sql = "insert into tmpcustomerout(REF_NO, SDATE, days, AMOUNT, paid, SAL_EX, barnd, REPNAME,CHQ_DET) value ('" . $row["CR_REFNO"] . "', '" . $row["CR_DATE"] . "', '" . $days . "', '" . $row["CR_CHEVAL"] . "', '" . $row["PAID"] . "', '" . $row["S_REF"] . "', '" . $row["CR_CHNO"] . " " . $row["CR_BANK"] . " " . $row["CR_CHDATE"] . " ', '" . $row_rep["name"] . "')";
            $sql = "insert into tmpcustomerout(REF_NO, SDATE, days, AMOUNT, paid, SAL_EX, barnd, REPNAME,CHQ_DET) value ('" . $row["CR_REFNO"] . "', '" . $row["CR_DATE"] . "', '" . $days . "', '" . $row["CR_CHEVAL"] . "', '" . $row["PAID"] . "', '" . $row["S_REF"] . "', '', '" . $row_rep["name"] . "', '" . $row["CR_CHNO"] . " " . $row["CR_BANK"] . " " . $row["CR_CHDATE"] . "')";
            $result = $db->RunQuery($sql);
        }
        
if (($_GET["salesrep"] == "All") and ($_GET["brand"] == "All")) { $sql = "SELECT * from tmpcustomerout order by SDATE "; }
if (($_GET["salesrep"] == "All") and ($_GET["brand"] != "All")) { $sql = "SELECT * from tmpcustomerout where barnd='".$_GET["brand"]."' order by SDATE "; }
if (($_GET["salesrep"] != "All") and ($_GET["brand"] == "All")) { $sql = "SELECT * from tmpcustomerout where SAL_EX='".$_GET["salesrep"]."' order by SDATE "; }
if (($_GET["salesrep"] != "All") and ($_GET["brand"] != "All")) { $sql = "SELECT * from tmpcustomerout where barnd='".$_GET["brand"]."' and SAL_EX='".$_GET["salesrep"]."' order by SDATE "; }

$AMOUNT=0;
$totbal=0;
if($_SESSION["company"]!="A"){
    echo "<table border=1 width=1000><tr>
		<th>Date</th><th>Ref No</th><th>Days</th><th>Amount</th><th>Balance</th><th>Ex</td></tr>";
}else{echo "<table border=1 width=1000><tr>
		<th>Date</th><th>Ref No</th><th>ManualNo</th><th>Days</th><th>Amount</th><th>Balance</th><th>Ex</td></tr>";
}
	$result =$db->RunQuery($sql);			 
  while ($rows = mysql_fetch_array($result)){
  	
	$bal=$rows["AMOUNT"]-$rows["paid"];
  if ($bal>0.5){	
	echo "<tr>";
	echo "<td>".$rows["SDATE"]."</td>";
	echo "<td>".$rows["REF_NO"]." <b>".$rows["CHQ_DET"]."</b></td>";
        if($_SESSION["company"]=="A"){
            echo "<td>".$rows["da_no"]."</td>";
        }
	echo "<td align=\"right\">".$rows["days"]."</td>";
	echo "<td align=\"right\">".number_format($rows["AMOUNT"], 2, ".", ",")."</td>";
	echo "<td align=\"right\">".number_format($bal, 2, ".", ",")."</td>";
	echo "<td>".$rows["SAL_EX"]."</td>";
	
	echo "</tr>";
	$AMOUNT=$AMOUNT+$rows["AMOUNT"];
	$totbal=$totbal+$bal;
   }
  }
  
  echo "<tr>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td align=\"right\">&nbsp;</td>";
	echo "<td align=\"right\"><b>".number_format($AMOUNT, 2, ".", ",")."</b></td>";
	echo "<td align=\"right\"><b>".number_format($totbal, 2, ".", ",")."</b></td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	
	echo "</tr>";	

/* echo "<tr><td colspan=7>Please draw Account Payee cheques in favour of 'BENEDICTSONS  (PVT) LTD.' 
Any discrepancies should be brought to the notice of  'BENEDICTSONS  (PVT) LTD.' within 14 days from the date of Statement of Account.</br>
The Statement of Account will be considered accepted by you if discrepancies whatsoever is not reported within the said 14 working days.
The relevant Invoice Number should be quoted when making payment</td></table>";*/

 echo "</table>";
?>


</body>
</html>
