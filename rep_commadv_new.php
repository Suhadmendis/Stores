<?php
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Advance Commission</title>
<style type="text/css">
<!--
.companyname {
	color: #0000FF;
	font-weight: bold;
	font-size: 24px;
}

.com_address {
	color: #000000;
	font-weight: bold;
	font-size: 22px;
}

.heading {
	color: #000000;
	font-weight: bold;
	font-size: 20px;
}

body {
	color: #000000;
	font-size: 14px;
}
.style1 {
	font-size: 18px;
	font-weight: bold;
}


-->
</style>
</head>

<body><center>
<?php 
	require_once("config.inc.php");
	require_once("DBConnector.php");
	$db = new DBConnector();
	
	$row_rspara= "select * from invpara";
	$result_rspara =$db->RunQuery($row_rspara);
	$row_rspara= mysql_fetch_array($result_rspara);
	
	$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");
	
	$row_rss_salrep= "select * from s_salrep where repcode='" . $_GET["cmbrep"] . "'";
	$result_rss_salrep =$db->RunQuery($row_rss_salrep);
	if ($row_rss_salrep= mysql_fetch_array($result_rss_salrep)){
		$TXTREP=$row_rss_salrep["Name"];
	}

	$TXTCOM=$row_rspara["COMPANY"];
	$txtmon=date("M/Y", strtotime($_GET["dtMonth"]));
	$txttyre = "Battery";
	$txtbattery = "Tyre/A-W";

	$txttube = "Total";
	$Text5 = "Battery";
	$Text6 = "Tyre/A-W";

	$Text21 = "Total";


	$txttyresale = $_GET["Sales_gridA41"];
	$txtBatsale = $_GET["Sales_gridB41"];

	$Txttubesale = $_GET["Sales_gridA41"] + $_GET["Sales_gridB41"];

	$Text22=$_GET["Sales_gridA41"] / 2;
	$Text23 = $_GET["Sales_gridB41"] / 2;

	$Text25 = ($_GET["Sales_gridA41"] + $_GET["Sales_gridB41"]) / 2;

	$Text26 = $_GET["Comm_grid11"];
	$Text27 = $_GET["Comm_grid21"];

	$Text29= $_GET["Comm_grid31"];

	$txtout = $_GET["Ratio_grid31"];
	$Text40 = $_GET["TXTADJ"];
	$txtoutper = $_GET["txtra_per"];
	$txtoutamou = $_GET["txt_rded"] * -1;
	$txttotcom = $_GET["txt_adv"];
	$txtroucom = $_GET["txt_radv"];

    $Text9 = $_GET["Deduction_grid11"];
    $Text13 = $_GET["Deduction_grid21"];
    $Text14 = $_GET["Deduction_grid31"];
    $Text15 = $_GET["Deduction_grid41"];
    $Text30 = $_GET["Deduction_grid51"];
    $Text42 = $_GET["Deduction_grid61"];
    $Text43 = $_GET["Deduction_grid71"];
    $Text44 = $_GET["Deduction_grid81"];
    
    $Text31 = $_GET["Deduction_grid12"] * -1;
    $Text32 = $_GET["Deduction_grid22"] * -1;
    $Text33 = $_GET["Deduction_grid32"] * -1;
    $Text34 = $_GET["Deduction_grid42"] * -1;
    $Text16 = $_GET["Deduction_grid52"] * -1;
    $Text45 = $_GET["Deduction_grid62"] * -1;
    $Text46 = $_GET["Deduction_grid72"] * -1;
    $Text47 = $_GET["Deduction_grid82"] * -1;
    
	$txtcommi= $txt_padv;
	


	
	?>
    
<table width="800" border="0">
  <tr>
    <td colspan="5" align="center"><span class="companyname"><?php echo $row_rspara["COMPANY"]; ?></span></td>
  </tr>
  <tr>
    <td colspan="5" align="left"><span class="com_address"><?php echo $TXTREP ?></span></td>
  </tr>
   <?php
		//echo $_GET["invno"];
    			 
		$sql="Select * from s_purmas where REFNO='".$_GET["invno"]."'";
    	$result =$db->RunQuery($sql);	
		$row = mysql_fetch_array($result);			
        
		$sql1="Select * from vendor where CODE='".$row["SUP_CODE"]."'";
    	$result1 =$db->RunQuery($sql1);	
		$row1 = mysql_fetch_array($result1);	
		
		$sql2="Select * from viewarn where REFNO='".$_GET["invno"]."' order by ID";
		//echo $sql2;
    	$result2 =$db->RunQuery($sql2);	
		
	?>
  <tr>
    <td><span class="style1">Sales Commission Advance for</span></td>
    <td><span class="style1"><?php echo $txtmon; ?></span></td>
    <td width="125" align="center">    </td>
    <td colspan="2" align="center"></td>
  </tr>
    <tr>
    <th colspan="4" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <td width="254"><span class="style1">Nett Sales</span></td>
    <td width="177"><?php echo $txttyre; ?></td>
    <td width="125"><?php echo number_format($txttyresale, 0, ".", ","); ?></td>
    <td width="226">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $txtbattery; ?></td>
    <td><?php echo number_format($txtBatsale, 0, ".", ","); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $txtalloy; ?></td>
    <td><?php echo number_format($TxtAWsale, 0, ".", ","); ?></td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $txttube; ?></td>
    <td><?php echo number_format($Txttubesale, 0, ".", ","); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">Commission</span></td>
  </tr>
  <tr>
    <td><span class="style1">50%</span> </td>
    <td><?php echo $Text5; ?></td>
    <td><?php echo number_format($Text22, 0, ".", ","); ?></td>
    <td><?php echo number_format($Text26, 0, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $Text6; ?></td>
    <td><?php echo number_format($Text23, 0, ".", ","); ?></td>
    <td><?php echo number_format($Text27, 0, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $Text20; ?></td>
    <td><?php echo number_format($Text24, 0, ".", ","); ?></td>
    <td><?php echo number_format($Text28, 0, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $Text21; ?></td>
    <td><?php echo number_format($Text25, 0, ".", ","); ?></td>
    <td><?php echo number_format($Text29, 0, ".", ","); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Return Chqs &amp; Outstanding</span></td>
    <td><?php echo $txtout; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Return Chqs & Outstanding - Adjustment</span></td>
    <td><?php echo $Text40; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">Return Chqs &amp; Outstanding - % &amp; Deduct Amount </td>
    <td><?php echo $txtoutper." %"; ?></td>
    <td><?php echo $txtoutamou; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><span class="style1">___________________</span></td>
  </tr>
  <tr>
    <td colspan="2"><span class="style1">Total for Commission Advance</span></td>
    <td>&nbsp;</td>
    <td><?php echo $txtcommi; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>======================</td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="18"><span class="style1">Less</span></td>
    <td height="18"><?php echo $Text9; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text31; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text13; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text32; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text14; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text33; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text15; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text34; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text30; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text16; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text42; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text45; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text43; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text46; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text44; ?></td>
    <td height="18">&nbsp;</td>
    <td height="18"><?php echo $Text47; ?></td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
    <td height="18">&nbsp;</td>
  </tr>
  <tr>
    <td height="46" colspan="4"><?php echo $Text38; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Prepared By:</td>
    <td>&nbsp;</td>
    <td>Authorized By:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Prepared Date: <?php echo $Text36; ?></td>
    <td>&nbsp;</td>
    <td>Authorized Date:</td>
    <td><?php echo $Text37; ?></td>
  </tr>
  <tr>
    <td><?php echo $txtrepono; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
