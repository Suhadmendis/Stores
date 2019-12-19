<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Return Cheque Summery</title>
        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            table
            {
                border-bottom: 1px solid;
                border-left: 1px solid;
                border-right: 1px solid;
                border-top: 1px solid;

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
                font-size:16px;
            }
            td
            {
                font-size:14px;
            }

            .thd {
                border-top: 1px solid;
            }

            .thl {
                border-right: 1px solid;
            }

            .th2 {
                border-bottom: 1px dotted;
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
        $isPrtFrdly = $_GET['detailed'];
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();



        $sysdiv = "1";
        if ($_GET["cmbdev"] == "ALL") {
            $sysdiv = "A";
        }
        if ($_GET["cmbdev"] == "Computer") {
            $sysdiv = "1";
        }
        if ($_GET["cmbdev"] == "Manual") {
            $sysdiv = "0";
        }

//        $sql = "delete * from TmpRETCHKAna";
//        $result = $db->RunQuery($sql);
/*
        $i = 0;
        while ($i <= 4) {
            $chk = "chk" . $i;
            $dt = "dt" . $i;
            if ($_GET[$chk] == "on") {
                AsAtValue($_GET[$dt]);
            }
            $i = $i + 1;
        }
*/


        $sql_PrInv = "SELECT * from s_cheq where  dev!='" . $sysdiv . "' and CR_FLAG='0'   ";
        if ($_GET['radio'] == "optunsettle") {
            $sql_PrInv .= " and  CR_CHEVAL>PAID+1 ";
        }
        if ($_GET["cmbrep"] != "All") {
            $sql_PrInv .= " and S_REF='" . trim($_GET["cmbrep"]) . "'";
        }
        if ($_GET["Check1"] == "on") {
            $sql_PrInv .= " and CR_C_CODE='" . $_GET["cuscode"] . "'";
        }
        if ($_GET["radio"] == "optall") {
            $sql_PrInv .= " and   (cr_date>='" . $_GET["dtfrom"] . "' and cr_date<='" . $_GET["dtto"] . "')";
        }
        if($_SESSION["company"] != "C"){
            $sql_PrInv .= " and company='" . $_SESSION["company"] . "'";
        }
        
/*
        if ($_GET["radio"] == "optunsettle") {
            if ($_GET["Check1"] != "on") {
                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and CR_FLAG='0'   ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0'  ";
                }
            }
            if ($_GET["Check1"] == "on") {
                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1  and CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_FLAG='0'  ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and S_REF='" . trim($_GET["cmbrep"]) . "'and CR_C_CODE='" . $_GET["cuscode"] . "'and CR_FLAG='0'  ";
                }
            }
            if($_SESSION["company"] != "C"){
                $sql .= " and company='" . $_SESSION["company"] . "'";
            }
        }
*/
        if ($_GET["radio"] == "optall") {
            if ($_GET["Check1"] != "on") {
                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot   from s_cheq where  dev!='" . $sysdiv . "' and   (CR_DATE>'" . $_GET["dtfrom"] . "' or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "')  and CR_FLAG='0'   ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  (CR_DATE>'" . $_GET["dtfrom"] . "'or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "') and S_REF='" . trim($_GET["cmbrep"]) . "' and CR_FLAG='0' ";
                }
            }
            if ($_GET["Check1"] == "on") {
                if ($_GET["cmbrep"] == "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  (CR_DATE>'" . $_GET["dtfrom"] . "'or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "')  and CR_C_CODE='" . $_GET["cuscode"] . "'  and CR_FLAG='0' ";
                }
                if ($_GET["cmbrep"] != "All") {
                    $sql = "SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt ,sum(CR_REPAY) as BchaTot  from s_cheq where  dev!='" . $sysdiv . "' and  (CR_DATE>'" . $_GET["dtfrom"] . "'or CR_DATE='" . $_GET["dtfrom"] . "')and (CR_DATE<'" . $_GET["dtto"] . "'or CR_DATE='" . $_GET["dtto"] . "') and S_REF='" . trim($_GET["cmbrep"]) . "'and CR_C_CODE='" . $_GET["cuscode"] . "'and CR_FLAG='0' ";
                }
            }
        }
        
        /*
        $sql_rs1 = " SELECT sum(CR_CHEVAL-PAID) as Baltot,sum(CR_CHEVAL) as chTOt,sum(CR_REPAY) as BchaTot  from  s_cheq where  dev!='" . $sysdiv . "' and  CR_CHEVAL>PAID+1 and CR_FLAG='0'   ";
        $result_rs1 = $db->RunQuery($sql_rs1);
        if ($row_rs1 = mysql_fetch_array($result_rs1)) {
            $txtunsetcheq = number_format($row_rs1["Baltot"], 2, ".", ",");
        }
        */

/*
        $result_sql = $db->RunQuery($sql);
        $row_tot = mysql_fetch_array($result_sql);
        $txtBal = number_format($row_tot["Baltot"], 2, ".", ",");
        $txtChAmt = number_format($row_tot["chtot"], 2, ".", ",");
        $txtTotCHa = number_format($row_tot["BchaTot"], 2, ".", ",");
*/

        $sql_head = "select * from invpara where COMCODE = '" . $_SESSION["company"] . "'";
        $result_head = $db->RunQuery($sql_head);
        $row_head = mysql_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";


        echo "<center>" . $heading . "</center><br>";

        if ($_GET["radio"] == "optunsettle") {
            $heading = "Unsettle Return Cheque Report on  " . date("Y-m-d") . " Sales Rep. " . $_GET["cmbrep"];
        }
        if ($_GET["radio"] == "optall") {
            $heading = "Return Cheque Report From  " . $_GET["dtfrom"] . " To  Sales Rep. " . $_GET["dtto"];
        }
        echo "<center><b>" . $heading . "</b><br></br>";

        $tableHead = "<center><table ><tr>
		<th class='thl'>Return Date</th>
		<th  class='thl'>Cheq. No</th>
		<th  class='thl' colspan=4></th>	 
		<th  class='thl'>Rep</th>
		<th  class='thl' colspan=3>Settlement Summery</th>";

        if ($isPrtFrdly != "on")
            $tableHead .= "<th  class='thl'>Days</th>
                <th  class='thl'>Invoice_Date</th>
		<th  class='thl'>Invoice Amount</th>
		<th  class='thl'></th>
		<th  class='thl'>Prev. Cheque No</th>";

        $tableHead .= "</tr>";

        echo $tableHead;
        
        //echo $sql;
        $totgross = 0;
        $totvat = 0;
        $totnet = 0;

        $i = 0;
        $tototbal = 0;
        $totot = 0;


        $sql_PrInv = $sql_PrInv . " order by CR_C_CODE, CR_CHNO";


        $result_PrInv = $db->RunQuery($sql_PrInv);
        while ($row_PrInv = mysql_fetch_array($result_PrInv)) {

            $sql_ven = "select * from vendor where code = '" . $row_PrInv["CR_C_CODE"] . "'";
            $result_ven = $db->RunQuery($sql_ven);
            $row_ven = mysql_fetch_array($result_ven);
            if ($name != $row_ven["NAME"]) {

                if ($i == 1) {
                    echo "<tr>
                    <td class='thl th2'>&nbsp;</td>
                    <td class='thl th2'></td>
                    <td class='thl th2'></td>
                    <td class='thl th2'></td>
                    <td class='thl th2' align=right><b>" . number_format($totbal, 2, ".", ",") . "</b></td>
                    <td class='thl th2'></td>    
                    <td class='thl th2'></td>
                    <td class='thl th2'></td>
                    <td class='thl th2'></td>
                    <td class='thl th2'></td>";
                    
                    
                    echo "</tr>";
                }
                echo "<tr class='thd'>	 
                <td class='thl'></td>
                <td class='thl'></td>
                <td class='thl th2' colspan=8><b>" . $row_ven["CODE"] . " " . $row_ven["NAME"] . " - " . $row_ven["ADD2"] . "</b></td>";
                
                if ($isPrtFrdly != "on"){
                    echo "<td class='thl'></td>
                <td class='thl'></td><td class='thl'></td>
                <td class='thl'></td>";
                }
                
                echo "</tr>";

                $name = $row_ven["NAME"];

                $i = 1;
                $totbal = 0;
            }

            if ($ch_no != $row_PrInv["CR_CHNO"]) {
                echo "<tr>
			<td class='thl'>" . $row_PrInv["CR_DATE"] . "</td>
			<td class='thl'>" . $row_PrInv["CR_CHNO"] . "</td>";
                $ch_no = $row_PrInv["CR_CHNO"];

                echo "<td class='thl'>" . $row_PrInv["rep_remark"] . " " . $row_PrInv["CR_CHDATE"] . "</td>
			<td class='thl' align=right>" . number_format($row_PrInv["CR_CHEVAL"], 2, ".", ",") . "</td>";

                $bal = $row_PrInv["CR_CHEVAL"] - $row_PrInv["PAID"];
                if ($bal > 0) {
                    echo "<td class='thl' align=right>" . number_format($bal, 2, ".", ",") . "</td>";
                } else {
                    echo "<td class='thl' align=right></td>";
                }

                $totbal = $totbal + $bal;
                $tototbal = $tototbal + $bal;
                $totot = $totot + $row_PrInv["CR_CHEVAL"];

                if ($bal > 1) {

                    $diff = abs(strtotime($row_PrInv["CR_DATE"]) - strtotime(date("Y-m-d")));
                    $days = floor($diff / (60 * 60 * 24));
                } else if ($row_PrInv["ST_FLAG"] == "UT") {

                    $diff = abs(strtotime($row_PrInv["CR_CHDATE"]) - strtotime($row_PrInv["ST_DATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                } else {

                    $diff = abs(strtotime($row_PrInv["CR_CHDATE"]) - strtotime($row_PrInv["ST_INDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                }
                echo "<td class='thl'></td>
                <td class='thl'>" . $row_PrInv["S_REF"] . "</td>
		<td class='thl'></td>
                <td class='thl'></td>
                <td class='thl'></td>";
                
                if ($isPrtFrdly != "on"){
                   echo "<td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>";
                }
                
                echo "</tr>";
            }


            $sett = "select * from ch_sttr where st_invono = '" . $row_PrInv["CR_REFNO"] . "'";
            $result_PrInv1 = $db->RunQuery($sett);
            while ($row_PrInv1 = mysql_fetch_array($result_PrInv1)) {
                echo "<tr>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>";


                if (($row_PrInv1["ST_INDATE"] != "1970-01-01") and ( $row_PrInv1["ST_INDATE"] != "0000-00-00") and ( is_null($row_PrInv1["ST_INDATE"]) == false)) {
                    $diff = abs(strtotime($row_PrInv["CR_DATE"]) - strtotime($row_PrInv1["ST_INDATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                } else {
                    $diff = abs(strtotime($row_PrInv["CR_DATE"]) - strtotime($row_PrInv1["ST_DATE"]));
                    $days = floor($diff / (60 * 60 * 24));
                }
                echo "<td class='thl'>" . $days . "</td>
                    <td class='thl'>&nbsp;</td>
                    <td class='thl'>" . $row_PrInv1["ST_CHNO"] . "</td>";
                if (($row_PrInv1["ST_INDATE"] != "1970-01-01") and ( $row_PrInv1["ST_INDATE"] != "0000-00-00") and ( is_null($row_PrInv1["ST_INDATE"]) == false)) {
                    echo "<td class='thl'>" . $row_PrInv1["ST_INDATE"] . "</td>";
                } else {
                    echo "<td class='thl'>" . $row_PrInv1["ST_DATE"] . "</td>";
                }
                echo "<td class='thl' align=right>" . $row_PrInv1["ST_PAID"] . "</td>";
                
                if ($isPrtFrdly != "on"){
                    echo "<td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>
                    <td class='thl'></td>";
                }
                
                echo "</tr>";
            }

            $inv_his = "select Inv_date,Inv_no,inv_Amt from ret_chq_history where ref_no = '" . $row_PrInv["CR_REFNO"] . "' group by Inv_date,Inv_no,inv_Amt";

            $result_his = $db->RunQuery($inv_his);
            while ($row_his = mysql_fetch_array($result_his)) {
                $invoice_no = $row_his["Inv_no"];
                echo "<tr>
                <td class='thl'></td>    
                <td class='thl'></td>
                <td class='thl'></td>
                <td class='thl'></td>
                <td class='thl'></td>";
                $diff = abs(strtotime($row_PrInv["CR_CHDATE"]) - strtotime($row_PrInv["CR_DATE"]));
                $days = floor($diff / (60 * 60 * 24));

                echo " <td class='thl'>" . $days . "</td>
                <td class='thl'></td>
                <td class='thl'></td>
                <td class='thl'></td>
                <td class='thl'></td>";
                if ($isPrtFrdly != "on"){
                // if ($bal > 1) {
                $diff = abs(strtotime($row_his["Inv_date"]) - strtotime(date("Y-m-d")));
                $daysin = floor($diff / (60 * 60 * 24));

                $sett_s = "select * from ch_sttr where st_invono = '" . $row_PrInv["CR_REFNO"] . "' order by ST_DATE";
                $row_PrInv_s = $db->RunQuery($sett_s);
                if ($row_PrInv_s = mysql_fetch_array($row_PrInv_s)) {
                    if ($row_PrInv_s["ST_FLAG"] == "UT") {
                        $diff = abs(strtotime($row_his["Inv_date"]) - strtotime($row_PrInv_s["ST_DATE"]));
                        $daysin = floor($diff / (60 * 60 * 24));
                    } else {
                        $diff = abs(strtotime($row_his["Inv_date"]) - strtotime($row_PrInv_s["ST_INDATE"]));
                        $daysin = floor($diff / (60 * 60 * 24));
                    }
                }

                if (is_null($row_his["Inv_date"])) {
                    echo "<td class='thl'><font color=\"#FF0000\"><b></b></font></td>";
                } else {
                    echo "<td class='thl'><font color=\"#FF0000\"><b>" . $daysin . "</b></font></td>";
                }
                echo "<td class='thl'>" . $row_his["Inv_date"] . "</td>
                    <td class='thl'>" . $row_his["inv_Amt"] . "</td>
                    <td class='thl' >" . $row_PrInv["noof"] . "</td>
                    <td class='thl'>" . $row_PrInv["FORwhat"] . "</td>";
                }
                echo "</tr>";
            }
        }

        echo "<tr>
				<td class='thl th2'>&nbsp;</td>
				 <td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
				
				<td class='thl th2' align=right><b>" . number_format(abs($totbal), 2, ".", ",") . "</b></td>
				 
                                <td class='thl th2'></td>    
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>";
        
        if ($isPrtFrdly != "on")
        echo "<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>";
        
        echo "</tr>";



        echo "<tr>
				 
				 <td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
				<td class='thl th2' align=right><b>" . number_format($totot, 2, ".", ",") . "</b></td>
				
				<td class='thl th2' align=right><b>" . number_format($tototbal, 2, ".", ",") . "</b></td>
				                              <td class='thl th2'></td>    
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>";
        
        if ($isPrtFrdly != "on")
        echo "<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>
<td class='thl th2'></td>";    
            
        echo "</tr>";

/////////// Sales Summery////////////////////////////////////////
        function AsAtValue($dtdate) {

            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();


            if (date('m', strtotime($dtdate)) == "01") {
                $yr = date('Y', strtotime($dtdate)) - 1;
                $Mon = 12;
            } else {
                $yr = date('Y', strtotime($dtdate));
                $Mon = date('m', strtotime($dtdate)) - 1;
            }

            if ($_GET["cmbrep"] == "All") {
                $sql_rst = "select sum(GRAND_TOT/(1+GST/100)) as sale from s_salma where Accname != 'NON STOCK' and year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and CANCELL=0 ";
            } else {
                $sql_rst = "select sum(GRAND_TOT/(1+GST/100)) as sale from s_salma where Accname != 'NON STOCK' and year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL=0 ";
            }

            $result_rst = $db->RunQuery($sql_rst);
            if ($row_rst = mysql_fetch_array($result_rst)) {
                if (is_null($row_rst["sale"]) == false) {
                    $sale = $row_rst["sale"];
                }
            }

            if ($_GET["cmbrep"] == "All") {
                $rst = "select sum(AMOUNT/(1+vatrate/100)) as ret from c_bal where year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and trn_type!='REC' and trn_type!='ARN' and trn_type!='PAY' and CANCELL=0 ";
            } else {
                $rst = "select sum(AMOUNT/(1+vatrate/100)) as ret from c_bal where year(SDATE)='" . $yr . "' and month(SDATE)='" . $Mon . "' and trn_type!='REC' and trn_type!='ARN' and trn_type!='PAY' and SAL_EX='" . trim($_GET["cmbrep"]) . "' and CANCELL=0 ";
            }
            $result_rst = $db->RunQuery($sql_rst);
            if ($row_rst = mysql_fetch_array($result_rst)) {
                if (is_null($row_rst["sale"]) == false) {
                    $sale = $sale - $row_rst["ret"];
                }
            }


            if ($_GET["cmbrep"] == "All") {
                $rst = "select * from s_cheq where  CR_DATE <'" . $dtdate . "' and CR_FLAG='0'  ";
            } else {
                $rst = "select * from s_cheq where  CR_DATE <'" . $dtdate . "' and CR_FLAG='0' and S_REF='" . trim($_GET["cmbrep"]) . "' ";
            }
            $result_rst = $db->RunQuery($sql_rst);
            while ($row_rst = mysql_fetch_array($result_rst)) {
                $stt = "select sum(ST_PAID+1) as (totPAID+1) from ch_sttr where ST_INVONO='" . $row_rst["CR_REFNO"] . "' and ST_DATE <'" . $dtdate . "'";
                $result_stt = $db->RunQuery($stt);
                echo $stt;
                $row_stt = mysql_fetch_array($result_stt);

                if (is_null($row_stt["totPAID"]) == false) {
                    $sttAmt = $sttAmt + $row_stt["totPAID"] + 1;
                }
            }

            if ($_GET["cmbrep"] == "All") {
                $rst = "select sum(CR_CHEVAL) as chval from s_cheq where  CR_DATE <'" . $dtdate . "'and CR_FLAG='0'  ";
            } else {
                $rst = "select sum(CR_CHEVAL) as chval from s_cheq where  CR_DATE <'" . $dtdate . "'and CR_FLAG='0' and S_REF='" . trim($_GET["cmbrep"]) . "' ";
            }
            $result_rst = $db->RunQuery($rst);
            $row_rst = mysql_fetch_array($result_rst);
            if (is_null($row_rst["chval"]) == false) {
                $RETCHQ = $row_rst["chval"];
            }

            if ($sale > 0) {
                $pr = ($RETCHQ - $sttAmt) / $sale * 100;
                $rst = "insert into tmpretchkana (sdate,SAle,ret,Pr) values ('" . $dtdate . "' ," . $sale . ", " . $RETCHQ - $sttAmt . "," . $pr . ")";
                $result_rst = $db->RunQuery($rst);
            }
        }
        ?>



    </body>
</html>
