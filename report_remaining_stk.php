<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Unsold Report</title>
        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

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
				border-bottom:none;
				border-top:none;        
            }
        .style1 {
	font-size: 16px;
	font-weight: bold;
}

.style2 {
	font-size: 18px;
	font-weight: bold;
}
        </style>
    </head>

    <body>
<center>
        <!-- Progress bar holder -->
        <!-- Progress information -->
        <div id="information" style="width"></div>

        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();

     
		
		$sql_rspara="select *from invpara";
		$result_rspara = $db->RunQuery($sql_rspara);
        $row_rspara = mysql_fetch_array($result_rspara);
		
		$txtrepono= $_SESSION["CURRENT_USER"] . " " . date("Y-m-d") . "  " . date("H:i:s");

		$rep = trim($_GET["cmbrep"]);
		$code = trim($_GET["cmbdep"]);
		$DTpiker1=$_GET["DTpiker1"];
		
		$sql_RSINVO = "select sum(COST_smas * QTY) as Tot from view_sinvo_smas where REP ='" . $rep . "'and CANCELL='0' and month(SDATE)= ' " . date("m", strtotime($DTpiker1)) . " ' and year(SDATE) = ' " . date("Y", strtotime($DTpiker1)) . " '";
		//echo $sql_RSINVO;
		$result_RSINVO = $db->RunQuery($sql_RSINVO);
        $row_RSINVO = mysql_fetch_array($result_RSINVO);
		
		$sql_rsStock = "select sum(QTYINHAND * COST) as Stock from view_smas_submas where STO_CODE ='" . $code . "'and QTYINHAND > 0 ";
		//echo $sql_rsStock;
		$result_rsStock = $db->RunQuery($sql_rsStock);
        $row_rsStock = mysql_fetch_array($result_rsStock);
		
		$sql_RSGRN = "Select sum(QTY * COST) as GRN from view_crntrn_smas where SAL_EX = '" . $rep . "' and CANCELL = '0' and month(SDATE)= ' " . date("m", strtotime($DTpiker1)) . " ' and year(SDATE) = ' " . date("Y", strtotime($DTpiker1)) . " ' ";
		//echo $sql_RSGRN;
		$result_RSGRN = $db->RunQuery($sql_RSGRN);
        $row_RSGRN = mysql_fetch_array($result_RSGRN);
		
		$sql_RScbal = "Select sum(AMOUNT) as CRN from c_bal where SAL_EX = '" . $rep . "' and CANCELL = '0' and month(SDATE)= ' " . date("m", strtotime($DTpiker1)) . " ' and year(SDATE) = ' " . date("Y", strtotime($DTpiker1)) . " ' and trn_type = 'CNT' and flag1 <> '1' ";
		//echo $sql_RScbal;
		$result_RScbal = $db->RunQuery($sql_RScbal);
        $row_RScbal = mysql_fetch_array($result_RScbal);
		
		$sql_rss_salrep = "select * from s_salrep where REPCODE='" . $rep . "'";
		$result_rss_salrep = $db->RunQuery($sql_rss_salrep);
        if ($row_rss_salrep = mysql_fetch_array($result_rss_salrep)){
			$txtrep = $row_rss_salrep["Name"];
		}
		
		$TXTCOM= $row_rspara["COMPANY"];
		$txtmon = date("Y-m", strtotime($DTpiker1));
		
		$remstk=($row_rsStock["Stock"]/($row_RSINVO["Tot"] - ($row_RSGRN["GRN"] + ($row_RScbal["CRN"] / 1.11)))) * 100;
		$rtxremaining = number_format($remstk, 2, ".", ",");
		

        ?>
                <table width="726" border="0">
                  <tr>
                    <td height="55" colspan="2" align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><span class="style2"><strong><?php echo $TXTCOM; ?></strong></span></td>
                  </tr>
                  <tr>
                    <td width="422">&nbsp;</td>
                    <td width="294">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><span class="style1"><?php echo $txtrep; ?></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><span class="style1">Remaining Stock Balance as at</span></td>
                    <td><strong><span class="style1"><?php echo $txtmon; ?></span></strong></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><span class="style1"><strong>Remaining Stock Balance %</strong></span></td>
                    <td><span class="style1"><strong>= <?php echo $rtxremaining; ?>%</strong></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
</body>
                </html>
