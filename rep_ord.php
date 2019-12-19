<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Order</title>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	text-decoration:underline;
}
.style2 {
	font-family: Arial;
	font-size: 15px;
}
.style4 {
	font-size: 22px;
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
	?>
    
    <?php
		
	
        
		
			$sql_invpara="SELECT * from invpara";
			$result_invpara =$db->RunQuery($sql_invpara);
			$row_invpara = mysql_fetch_array($result_invpara);
			
			


		$txtrepono = $_GET["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");


		$txtdep= $_GET["department"];
		
		$sql_dep="select * from s_stomas where CODE='" . trim($txtdep) . "'";
    	$result_dep =$db->RunQuery($sql_dep);	
		$row_dep = mysql_fetch_array($result_dep);
		
		$txtdep_name=$row_dep["DESCRIPTION"];
		
		$rtxtinvno = $_GET["txt_invno"];
		$txtcusvat = $_GET["vat1"];
		
		$rtxtrep = trim($_GET["Com_rep"]);
		$sql_rep="select * from s_salrep where REPCODE='" . trim($rtxtrep) . "'";
    	$result_rep =$db->RunQuery($sql_rep);	
		$row_rep = mysql_fetch_array($result_rep);
		
		$rep_name=$row_rep["Name"];
		
		$rtxtSupCode = $_GET["txt_cuscode"];
		
		
		$rtxtSupName =str_replace("~", "&", $_GET["txt_cusname"]);  
		$txtadd =str_replace("~", "&", $_GET["txt_cusadd"]);  
		
		$rtxtdate = date("Y-m-d", strtotime($_GET["dtdate"]));
		
		$sql_brndmas="select * from brand_mas where barnd_name='" . trim($_GET["cmbbrand"]) . "'";
    	$result_brndmas =$db->RunQuery($sql_brndmas);	
		if ($row_brndmas = mysql_fetch_array($result_brndmas)){
			if (is_null($row_brndmas["class"])==false) { $InvClass = trim($row_brndmas["class"]); }
		}	
		
		$sql_rsbr="select * from br_trn where Rep='" . trim($_GET["Com_rep"]) . "' and brand='" . trim($InvClass) . "' and cus_code='" . trim($_GET["txt_cuscode"]) . "'";
    	$result_rsbr =$db->RunQuery($sql_rsbr);	
		if ($row_rsbr = mysql_fetch_array($result_rsbr)){

    		if (is_null($row_rsbr["CAT"])==false) { $cuscat = trim($row_rsbr["CAT"]); }
			if ($cuscat == "A") { $m = 2.5; }
    		if ($cuscat == "B") { $m = 2.5; }
    		if ($cuscat == "C") { $m = 1; }
    		$rtxlimit= ($row_rsbr["credit_lim"] * $m);
		} else {
    		$rtxlimit= "0";
		}
		
		$rtxout = str_replace(",", "", $_GET["OutInvAmt"]);
		$rtxrtnchq = str_replace(",", "", $_GET["OutREtAmt"]);
		$crebal = str_replace(",", "", $_GET["txt_crebal"]);
		$net = str_replace(",", "", $_GET["txt_net"]);

		
		if ($crebal < $net) {
    		$limex = $net - $crebal;
    		$rtxexlmt = $limex;
		} else {
    		$limex = $net - $crebal;
    		$rtxexlmt = number_format(0, 2, ".", ",");
		}

		//echo "crebal-".$crebal."/net-".$net."/rtxexlmt".$rtxexlmt;
		
		$sql_rs_ven="Select * From vendor where CODE = '" . trim($_GET["txt_cuscode"]) . "'";
    	$result_rs_ven =$db->RunQuery($sql_rs_ven);	
		if ($row_rs_ven = mysql_fetch_array($result_rs_ven)){
			if (is_null($row_rs_ven["acno"])==false) {
        		$rtxagree = $row_rs_ven["acno"];
    		} else {
        		$rtxagree = "Agreement Not Signed";
    		}
		}
		
		$d=date("Y-m-d");
		
		$date = date('Y-m-d',strtotime($d.' -60 days'));
		
		$sql_rssal="Select sum(GRAND_TOT - TOTPAY) as out1 from s_salma where C_CODE = '" . trim($_GET["txt_cuscode"]) . "' and (SDATE < '" . $date . "' or SDATE = '" . $date . "') and GRAND_TOT - TOTPAY > 1 and CANCELL = '0'";
		
    	$result_rssal =$db->RunQuery($sql_rssal);	
		if ($row_rssal = mysql_fetch_array($result_rssal)){

			if (is_null($row_rssal["out1"])==false) { 
				$rtxover60 = $row_rssal["out1"];
			}
		}
		$rtxrtnpd = str_replace(",", "", $_GET["OutpDAMT"]);
		
		$txtRet_PDChq=0;
		$strsql = "Select sum(che_amount) as totchq_amount from s_invcheq where cus_code='" . trim($_GET["txt_cuscode"]) . "'  and che_date>'" . date("Y-m-d") . "' and sal_ex='" . trim($_GET["Com_rep"]) . "' and trn_type='RET' order by che_date";
		
		$result_rst2 =$db->RunQuery($strsql);
		$row_rst2 = mysql_fetch_array($result_rst2);
		 
		$txtRet_PDChq=$row_rst2["totchq_amount"];
		
	?>
<table width="922" height="833" border="0">
  <tr>
    <td height="45" colspan="2">&nbsp;</td>
    <td colspan="4" align="center" valign="top"><span class="style4">OREDER FORM</span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="56" align="center">    </td>
    <td colspan="3" align="center"><?php echo $txtdep."  ".$txtdep_name; ?></td>
    <td width="222">
      <?php echo $rtxtinvno; ?>    </td>
  </tr>
  <tr>
    <td width="95" height="21">&nbsp;</td>
    <td width="87"><?php echo $rtxtSupCode; ?></td>
    <td colspan="3" ><?php echo $rtxtSupName; ?></td>
    <td width="221">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="1">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="4"><span class="style2"><?php echo $txtadd; ?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="21" colspan="2">&nbsp;</td>
    <td colspan="2"><?php echo $txtcusvat; ?></td>
    <td width="204"><span class="style2"><b><?php  echo "&nbsp;&nbsp;&nbsp;&nbsp;". $rep_name; ?></b></span></td>
    <td>&nbsp;</td>
    <td><?php echo $rtxtdate; ?></td>
  </tr>
  
  <tr>
    <td height="164" colspan="7"><table border="1" cellpadding="0" cellspacing="0"><tr><td><table width="900" height="81" border="0" cellspacing="0">
      <tr  bgcolor="#999999">
        <td width="100" height="30"><span class="style1">Stock No</span></td>
        <td width="400"><span class="style1">Description</span></td>
        <td width="50" align="right"><span class="style1">Qty</span></td>
        <td width="100" align="right"><span class="style1">PRICE</span></td>
        <td width="120" align="right"><span class="style1">Discount (%)</span></td>
        <td width="130" align="right"><span class="style1">Sub Total</span></td>
        </tr>
      <?php 
	  	$sql_rsPrInv="SELECT * from print_repord where REF_NO= '" . trim($_GET["txt_invno"]) . "'  order by id";
		
		$totdis=0;
    	$result_rsPrInv =$db->RunQuery($sql_rsPrInv);	
		while ($row_rsPrInv = mysql_fetch_array($result_rsPrInv)){	
			echo "<tr height=\"30\"><td><span class=\"style2\">".$row_rsPrInv["STK_NO"]."</span></td>
			<td><span class=\"style2\">".$row_rsPrInv["DESCRIPT"]."</span></td>
			<td  align=\"right\"><span class=\"style2\">".number_format($row_rsPrInv["QTY"], 0, ".", ",")."</span></td>
			<td align=\"right\"><span class=\"style2\">".number_format($row_rsPrInv["PRICE"], 2, ".", ",")."</span></td>
			<td align=\"right\"><span class=\"style2\">".number_format($row_rsPrInv["DIS_per"], 2, ".", ",")."</span></td>";
			
			$dis=($row_rsPrInv["PRICE"]*$row_rsPrInv["QTY"])-($row_rsPrInv["PRICE"]*$row_rsPrInv["QTY"]*$row_rsPrInv["DIS_per"]/100);
			echo "<td align=\"right\"><span class=\"style2\">".number_format($dis, 2, ".", ",")."</span></td></tr>";
			
			$totdis=$totdis+$dis;
		}	
	  	
		$tax=0;
		
		$final_total=0;
		if ((trim($_GET["tax"])!="") and ($_GET["tax"]>0) and ($_GET["tax"]!="0.00")){
			$tax=$totdis*$row_invpara["vatrate"]/100;
			echo "<tr><td colspan=5></td><td align=right><b>".number_format($totdis, 2, ".", ",")."</b></td></tr>";
			echo "<tr><td colspan=4></td><td>VAT ".$row_invpara["vatrate"]."%</td><td align=right><b>".number_format($tax, 2, ".", ",")."</b></td></tr>";
			$tot=$totdis+$tax;
			$final_total=$tot;
			echo "<tr><td colspan=5></td><td align=right><b><u>".number_format($tot, 2, ".", ",")."</u></b></td></tr>";
		}	else {
			echo "<tr><td colspan=5></td><td align=right><b><u>".number_format($totdis, 2, ".", ",")."</u></b></td></tr>";
			$final_total=$totdis;
		}
		
	   ?>
      
     
      
    </table></td></tr></table></td>
  </tr>
  <tr>
    <td height="94" colspan="2" valign="bottom">_______________________</td>
    <td>&nbsp;</td>
    <td colspan="2" valign="bottom">________________________</td>
    <td valign="bottom">__________________________</td>
    <td valign="bottom" align="right">_______________________</td>
  </tr>
  <tr>
    <td colspan="2"  align="center">Sales Person </td>
    <td>&nbsp;</td>
    <td colspan="2"  align="center">Marketing Manager</td>
    <td align="center">Authorized By 1</td>
    <td align="center">Authorized By 2</td>
  </tr>
  <tr>
    <td height="50" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Credit Limit</td>
    <td colspan="3" align="right"><?php echo number_format($rtxlimit, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Outstanding</td>
    <td colspan="3"  align="right"><?php 

	echo number_format($rtxout, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Return Chqs</td>
    <td colspan="3" align="right"><?php echo number_format($rtxrtnchq, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  height="35" colspan="2">PD Cheque Amount</td>
    <td colspan="3" align="right"><?php echo number_format($rtxrtnpd, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">PD Cheque for Return Chq</td>
    <td colspan="3" align="right"><?php echo number_format($txtRet_PDChq, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Total Outstandigs</td>
    <td colspan="3" align="right"><?php 
	$tmprtnchp=str_replace(",", "", $_GET["OutREtAmt"]);
	$totout=$rtxout+$rtxrtnpd+$tmprtnchp;
	
	
	echo number_format($totout, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Exceed Limit</td>
    <?php
		/*if ($rtxlimit-($rtxrtnpd+$rtxout)<0){
			$rtxexlmt=-1*($rtxlimit-($rtxrtnpd+$rtxout))+$totdis;
		} else {
			$rtxexlmt=$rtxlimit-($rtxrtnpd+$rtxout)+$totdis;
		}*/
		$bal_limit=$rtxlimit-$totout;
		if ($bal_limit>0){
			$bal1=$bal_limit-$final_total;
			
			if ($bal1>=0){
				$rtxexlmt=0;
			} else {
				$rtxexlmt=abs($bal1);
			}
		} else {
			
			$rtxexlmt=$final_total+($totout-$rtxlimit);
		}
	?>
    <td colspan="3" align="right"><?php echo number_format(abs($rtxexlmt), 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" colspan="2">Agreement No</td>
    <td colspan="3" align="right"><?php echo $rtxagree; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td height="35" colspan="2">Over 60 Days Outstandigs</td>
    <td colspan="3" align="right"><?php echo number_format($rtxover60, 2, ".", ","); ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
