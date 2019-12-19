<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bin Card Print</title>
<style>
body{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
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
font-size:12px;

}
td
{
font-size:12px;

}
</style>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}
-->
</style>
</head>

<body>
 <!-- Progress bar holder -->


<?php
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();


if ($_GET["radio"]=="Option1") { printbincard(); }
if ($_GET["radio"]=="Option2") { Option2(); }
if ($_GET["radio"]=="Option3") { PRINTBIN(); }


/////////// Sales Summery////////////////////////////////////////

function Option2()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	
	$sql_rst = "delete from tmpcard";
	$result_rst =$db->RunQuery($sql_rst);
	
         
       if ($_GET["Com_rep"] == "All") { 
	   	if ($_GET["checkbox"]=="on"){
	   		$sql = "SELECT * from viewinv where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and cancel_m='0' and cus_code='".$_GET["firstname_hidden"]."' ";
		} else {
			$sql = "SELECT * from viewinv where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and cancel_m='0' ";
		}	
	   }
       if ($_GET["Com_rep"] != "All") { 
	    if ($_GET["checkbox"]=="on"){
	   		$sql = "SELECT * from viewinv where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and cancel_m='0' and SAL_EX= '" . $_GET["Com_rep"] . "' and cus_code='".$_GET["firstname_hidden"]."' ";
		} else {
			$sql = "SELECT * from viewinv where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "')and cancel_m='0' and SAL_EX= '" . $_GET["Com_rep"] . "' ";
		}	
	   }
       
	   $result =$db->RunQuery($sql);
	   while($row = mysql_fetch_array($result)){
	   
       		$sql_ins = "insert into tmpcard (sdate, refno, ccode, cname, invqty, sal_ex) values('" . trim($row["SDATE"]) . "','" . trim($row["REF_NO"]) . "','" . trim($row["Cus_Code"]) . "','" . trim($row["cust_name"]) . "','" . trim($row["QTY"]) . "','" . trim($row["SAL_EX"]) . "')  ";
			$result_ins =$db->RunQuery($sql_ins);
	   }
	   
       if ($_GET["Com_rep"] == "All") { 
	   	 if ($_GET["checkbox"]=="on"){	
			$sql2 = "SELECT * from viewcrntrn where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and CANCELL='0' and C_CODE='".$_GET["firstname_hidden"]."'";
		 } else {	
			$sql2 = "SELECT * from viewcrntrn where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and CANCELL='0' ";
		  }	
		}	
       if ($_GET["Com_rep"] != "All") { 
	   	 if ($_GET["checkbox"]=="on"){	
	   		$sql2 = "SELECT * from viewcrntrn where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "'or SDATE='" . $_GET["dtto"] . "')and CANCELL='0' and SAL_EX= '" . trim($_GET["Com_rep"]) . "' and C_CODE='".$_GET["firstname_hidden"]."'";
		  } else {
		  	$sql2 = "SELECT * from viewcrntrn where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "' or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "'or SDATE='" . $_GET["dtto"] . "')and CANCELL='0' and SAL_EX= '" . trim($_GET["Com_rep"]) . "'";
		  }	
	   }
	   
       $result2 =$db->RunQuery($sql2);
	   while($row2 = mysql_fetch_array($result2)){
	   	   
		   $sql_ins = "insert into tmpcard (sdate, refno, ccode, cname, retqty, sal_ex) values('" . trim($row2["SDATE"]) . "','" . trim($row2["REF_NO"]) . "', '" . trim($row2["c_code"]) . "','" . trim($row2["CUS_NAME"]) . "','" . trim($row2["qty"]) . "','" . trim($row2["SAL_EX"]) . "')  ";
			$result_ins =$db->RunQuery($sql_ins);
       }
	   
        $txtremark = "From  " . date("Y-m-d", strtotime($_GET["dtfrom"])) . "   To  " . date("Y-m-d", strtotime($_GET["dtto"]));
        $txtitem ="<b>Item No - ". $_GET["invno"] . "</b>";
		
		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$txtremark."</center><br>";
		
		echo "<center>".$txtitem."</center><br>";
		
		echo "<table width=\"834\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td width=\"81\">Date</td>
    <td width=\"196\">Refno</td>
    <td width=\"99\">Rep</td>
    <td width=\"81\">Customer</td>
    <td width=\"52\">Invoice Qty</td>
    <td width=\"66\">Return Qty</td>
   
  </tr>";
  
  $invqty=0;
  $retqty=0;
  
   $sql = "select * from tmpcard order by sdate";
  $result =$db->RunQuery($sql);
  while($row = mysql_fetch_array($result)){
  	echo "<tr>
    <td>".$row["sdate"]."</td>
    <td>".$row["refno"]."</td>
	<td>".$row["sal_ex"]."</td>
	<td>".$row["cname"]."</td>
	<td>".$row["invqty"]."</td>
    <td>".$row["retqty"]."</td>
  	</tr>";
	
	$invqty=$invqty+$row["invqty"];
	$retqty=$retqty+$row["retqty"];
	
  }
  echo "<tr>
    <td colspan=4></td>
	<td><b>".$invqty."</b></td>
	<td><b>".$retqty."</b></td>
	</tr>";
  echo "</table>";
	
}


	
function printbincard()
{
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	
	$sql_rst = "select * from s_mas where STK_NO= '" . $_GET["invno"] . "' ";
	$result_rst =$db->RunQuery($sql_rst);
	$row_rst = mysql_fetch_array($result_rst);

	if ($_GET["cmbdep"] == "All") { 
		$sql = "SELECT * from s_trn where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "' or  SDATE='" . $_GET["dtfrom"] . "') and (SDATE<'" . $_GET["dtto"] . "' or SDATE='" . $_GET["dtto"] . "') and LEDINDI!='VGI' and LEDINDI!='VGR' and LEDINDI!='GINR' and LEDINDI!='GINI' order by SDATE ";
	}
	if ($_GET["cmbdep"] != "All") { 
		$sql = "SELECT * from s_trn where STK_NO='" . $_GET["invno"] . "' and (SDATE>'" . $_GET["dtfrom"] . "'or SDATE='" . $_GET["dtfrom"] . "')and (SDATE<'" . $_GET["dtto"] . "'or SDATE='" . $_GET["dtto"] . "') and DEPARTMENT='" . trim($_GET["cmbdep"]) . "' order by SDATE ";
	}	
	
	


	$txtstkno = $row_rst["STK_NO"];
	$txtbrand = $row_rst["BRAND_NAME"];
	$txtpartno = $row_rst["PART_NO"];

	$txtdes = $row_rst["descript"];
	$txtcost = $row_rst["acc_cost"];
	$txtmarg =$row_rst["MARGIN"]." %";
	$txtsel = $row_rst["selling"];

	$txtjan = $row_rst["SALE01"];
	$txtfeb = $row_rst["SALE02"];
	$txtmar = $row_rst["SALE03"];
	$txtapr = $row_rst["SALE04"];
	$txtmay = $row_rst["SALE05"];
	$txtjun = $row_rst["SALE06"];
	$txtjul = $row_rst["SALE07"];
	$txtaug = $row_rst["SALE08"];
	$txtsep = $row_rst["SALE09"];
	$txtoct = $row_rst["SALE10"];
	$txtnov = $row_rst["SALE11"];
	$txtdec = $row_rst["SALE12"];
	$txtbalqty = $row_rst["QTYINHAND"];
	$txtloc = trim($_GET["cmbdep"]);
 



		$sql_head="select * from invpara";
		$result_head =$db->RunQuery($sql_head);
		$row_head = mysql_fetch_array($result_head);
		
		echo "<center><span class=\"style1\">".$row_head["COMPANY"]."</span></center><br>";
		
		
		echo "<center>".$heading."</center><br>";
		
		
		
		echo "<table width=\"834\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
  <tr>
    <td width=\"81\">Stock No</td>
    <td width=\"196\">Description</td>
    <td width=\"99\">Part No</td>
    <td width=\"81\">Brand</td>
    <td width=\"52\">Cost</td>
    <td width=\"66\">&nbsp;</td>
    <td width=\"99\">Selling</td>
    <td width=\"108\">Loc.</td>
  </tr>
  <tr>
    <td>".$txtstkno."</td>
    <td>".$txtdes."</td>
    <td>".$txtpartno."</td>
    <td>".$txtbrand."</td>
    <td>".number_format($txtcost, 2, ".", ",")."</td>
    <td>".number_format($txtmarg, 2, ".", ",")."</td>
    <td>".number_format($txtsel, 2, ".", ",")."</td>
    <td>".number_format($txtloc, 2, ".", ",")."</td>
  </tr>
</table><br />
<table width=\"867\" border=\"0\">
  <tr>
    <td width=\"693\"><table width=\"693\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\">
      <tr>
        <td width=\"20\">Jan</td>
        <td width=\"24\">Feb</td>
        <td width=\"26\">Mar</td>
        <td width=\"24\">Apr</td>
        <td width=\"28\">May</td>
        <td width=\"20\">Jun</td>
        <td width=\"16\">Jul</td>
        <td width=\"25\">Aug</td>
        <td width=\"24\">Sep</td>
        <td width=\"23\">Oct</td>
        <td width=\"27\">Nov</td>
        <td width=\"25\">Dec</td>
      </tr>
      <tr>
        <td>".$txtjan."</td>
        <td>".$txtfeb."</td>
        <td>".$txtmar."</td>
        <td>".$txtapr."</td>
        <td>".$txtmay."</td>
        <td>".$txtjun."</td>
        <td>".$txtjul."</td>
        <td>".$txtaug."</td>
        <td>".$txtsep."</td>
        <td>".$txtoct.";</td>
        <td>".$txtnov."</td>
        <td>".$txtdec."</td>
      </tr>
    </table></td>
    <td width=\"78\">Balance Qty : ".$txtbalqty."</td>
    
  </tr>
</table>
<br />
<table width=\"875\" border=\"1\">
  <tr>
    <td width=\"95\">Date</td>
    <td width=\"111\">Ref.No</td>
    <td width=\"244\">Des.</td>
    <td width=\"144\">Qty. Recd</td>
    <td width=\"132\">Qty.Sold</td>
    <td width=\"109\">&nbsp;</td>
  </tr>";
  
  $result_rsPrInv =$db->RunQuery($sql);
  while($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){
  	echo "<tr>
    <td>".$row_rsPrInv["SDATE"]."</td>
    <td>".$row_rsPrInv["REFNO"]."</td>
	<td>";
	if ($row_rsPrInv["LEDINDI"]=='ARN') {
		echo "Purchase";
	} else if ($row_rsPrInv["LEDINDI"]=='INV') {
		echo "Invoice";
	} else if ($row_rsPrInv["LEDINDI"]=='GRN') {
		echo "Sales Return";
	} else if ($row_rsPrInv["LEDINDI"]=='IOU') {
		echo "Stock Adjetment Out";
	} else if ($row_rsPrInv["LEDINDI"]=='IIN') {
		echo "Stock Adjetment In";
	} else if ($row_rsPrInv["LEDINDI"]=='GINI') {
		echo "Internal Stock Trans In";
	} else if ($row_rsPrInv["LEDINDI"]=='GINR') {
		echo "Internal Stock Trans Out";
	}	

    echo "</td><td>";
	if (($row_rsPrInv["LEDINDI"]=='ARN') or ($row_rsPrInv["LEDINDI"]=='GRN')){ 
		echo $row_rsPrInv["QTY"];
	}	

    echo "</td><td>";
	
	if (($row_rsPrInv["LEDINDI"]!='ARN') and ($row_rsPrInv["LEDINDI"]!='GRN'))  { 
		echo $row_rsPrInv["QTY"];
	}	

  	echo "</td>
    <td>&nbsp;</td>
  	</tr>";
  }
echo "</table>";
		
}	
		
	


?>



</body>
</html>
