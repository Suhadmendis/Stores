<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Commission Report</title>

        <style>
            table {
                border-collapse: collapse;
            }
            table, td, th {

                font-family: Arial, Helvetica, sans-serif;
                padding: 5px;
            }
            th {
                font-weight: bold;
                font-size: 12px;
            }

            .border {
                border: 1px solid;
            }

            .bottom {
                border-bottom: 1px solid;
            }

            td {
                font-size: 12px;
            }
        </style>
    </head>
    <body>

        <?php
        date_default_timezone_set('Asia/Colombo');

          include_once ("connectioni.php");
          $from = $_GET['dateFrom'];
          $to = $_GET['dateTo'];
          $saleEx = $_GET['cmbrep'];
          $dtld = $_GET['detailed'];
        
        /*
        include_once ("connection_pr.php");
        $from = '2015-12-01';
        $to = '2016-03-31';
//        $from = '2015-04-01';
//        $to = '2016-12-31';
        $saleEx = '26';
        $dtld = 'off';
        */
        
        $sql = "SELECT Name FROM s_salrep WHERE repcode='" . $saleEx . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if (!$result) {
            echo("Error description: " . mysqli_error($GLOBALS['dbinv']));
        }

        $row = mysqli_fetch_array($result);

        echo "<center><b>Commision Report From " . $from . " To " . $to . " for Sales Executive Code " . $saleEx . " (" . $row["Name"] . ")</b></center><br><br>";

        echo "<center><table width='950' border=1>
            <tr>
		<th width='80'>Inovice Date</th>
                <th width='80'>Invoice No.</th>
                <th width='120'>Recipt No</th>
                <th width='50'>Customer Code</th>
                <th width='350'>Customer Name</th>
                <th width='80'>Grand Total</th>
                <th width='80'>Total Pay</th>
                <th width='80'>Current Pay</th>
                <th width='50'>No Of Days</th>
                <th width='50'>Outstanding</th>
                </tr>";

        $sql = "SELECT s.SDATE AS SDATE, s.REF_NO AS REF_NO, ST_REFNO AS ST_REFNO,st_chdate AS st_chdate,s.CUS_NAME AS NAME, s.GRAND_TOT AS GRAND_TOT, s.TOTPAY AS TOTPAY, st.ST_DATE AS ST_DATE, st.ST_PAID AS ST_PAID, s.C_CODE AS C_CODE,st.ST_FLAG AS ST_FLAG FROM s_salma AS s, s_sttr AS st WHERE s.REF_NO = st.ST_INVONO AND s.CANCELL='0' AND s.SAL_EX = '" . $saleEx . "' AND ST_DATE BETWEEN '" . $from . "' AND '" . $to . "'
                and ST_FLAG != 'ut'
                ORDER BY s.SDATE, st.ST_INVONO";

        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        if (!$result) {
            echo("Error description: " . mysqli_error($GLOBALS['dbinv']));
        }

        $m30 = 0;
        $m60 = 0;
        $m90 = 0;
        $m120 = 0;
        $m121 = 0;

        while ($row = mysqli_fetch_array($result)) {

            $date1 = $row["SDATE"];
            $clType = trim($row['ST_FLAG']);

            $check = "";
            $check2 = "";

            if ($clType == 'CHK' || $clType == 'CHQ' || $clType == 'Cheque' || $clType == 'Cash TT' || $clType == 'REC') {
                $check = "filter";
                $chDate = trim($row["st_chdate"]);
                if ($chDate == '' || $chDate == '0000-00-00') {
                    $date2 = "problem";
                } else {
                    $date2 = $chDate;
                }
            } else {
//                if (is_null($row["ST_DATE"])) {
//                    $date2 = date('Y-m-d');
//                    $date2 = "Problem";
//                } else {
                    $date2 = $row["ST_DATE"];
//                }
            }
            if ($date2 === "problem") {
                $days = "problem";
            } else {
//                $check2 = "date2 ok";
                $diff = abs(strtotime($date2) - strtotime($date1));
                $days = floor($diff / (60 * 60 * 24));
            }
            /* earlier
              //collection
              if ($days <= 30) {
              $m30 = $m30 + $row["ST_PAID"];
              } else if (($days > 30) && ($days <= 60)) {
              $m60 = $m60 + $row["ST_PAID"];
              } else if (($days > 60) && ($days <= 90)) {
              $m90 = $m90 + $row["ST_PAID"];
              } else if (($days > 90) && ($days <= 120)) {
              $m120 = $m120 + $row["ST_PAID"];
              } else if ($days > 120) {
              $m121 = $m121 + $row["ST_PAID"];
              }



              if ($row['ST_FLAG'] == "UT") {
              //credit notes
              if ($days <= 30) {
              $mn30 = $mn30 + $row["ST_PAID"];
              } else if (($days > 30) && ($days <= 60)) {
              $mn60 = $mn60 + $row["ST_PAID"];
              } else if (($days > 60) && ($days <= 90)) {
              $mn90 = $mn90 + $row["ST_PAID"];
              } else if (($days > 90) && ($days <= 120)) {
              $mn120 = $mn120 + $row["ST_PAID"];
              } else if ($days > 120) {
              $mn121 = $mn121 + $row["ST_PAID"];
              }
              } else {
              //reciepts
             */
            if ($days !== "problem") {
                if ($days <= 30) {
                    $mc30 = $mc30 + $row["ST_PAID"];
                } else if (($days > 30) && ($days <= 60)) {
                    $mc60 = $mc60 + $row["ST_PAID"];
                } else if (($days > 60) && ($days <= 90)) {
                    $mc90 = $mc90 + $row["ST_PAID"];
                } else if (($days > 90) && ($days <= 120)) {
                    $mc120 = $mc120 + $row["ST_PAID"];
                } else if ($days > 120) {
                    $mc121 = $mc121 + $row["ST_PAID"];
                }
            }



            echo "<tr>";
            if ($dtld == 'on') {
                echo "<td>" . $row["SDATE"] . "</td>";
                echo "<td>" . $row["REF_NO"] . "</td>";
                echo "<td>" . $row["ST_REFNO"] . "</td>";

                echo "<td>" . $row["C_CODE"] . "</td>";
                echo "<td>" . $row["NAME"] . "</td>";
//                echo "<td>$days </td>";
            }
            if ($minv !== $row["REF_NO"]) {
                if ($dtld == 'on') {
                    echo "<td align='right'>" . number_format($row["GRAND_TOT"], "2", ".", ",") . "</td>";
                }
                $mtot = $mtot + $row["GRAND_TOT"];
                if ($dtld == 'on') {
                    echo "<td align='right'>" . number_format($row["TOTPAY"], "2", ".", ",") . "</td>";
                }
                $mtot1 = $mtot1 + $row["TOTPAY"];
            } else {
                if ($dtld == 'on') {
                    echo "<td align='right'></td>";
                    echo "<td align='right'></td>";
                }
            }
            if ($dtld == 'on') {
                echo "<td align='right'>" . number_format($row["ST_PAID"], "2", ".", ",") . "</td>";
            }
            $mtot2 = $mtot2 + $row["ST_PAID"];
            if ($dtld == 'on') {
                if ($days !== "problem"){
                echo "<td align='right'>" . number_format($days, "0", ".", ",") . "</td>";
                }else{
                echo "<td align='right'><font color='red'>wait</font></td>";
                }
            }
            if ($minv !== $row["REF_NO"]) {
                if ($dtld == 'on') {
                    echo "<td align='right'>" . number_format($row["GRAND_TOT"] - $row["TOTPAY"], "2", ".", ",") . "</td>";
                }
                $mtot3 = $mtot3 + $row["GRAND_TOT"] - $row["TOTPAY"];
            } else {
                if ($dtld == 'on') {
                    echo "<td align='right'></td>";
                }
            }
            echo "</tr>";
            $minv = $row["REF_NO"];
        }


        echo "<tr>";
        echo "<td colspan='5'></td>";


        echo "<td align='right'><b>" . number_format($mtot, "2", ".", ",") . "</b></td>";


        echo "<td align='right'>" . number_format($mtot1, "2", ".", ",") . "</td>";


        echo "<td align='right'>" . number_format($mtot2, "2", ".", ",") . "</td>";
        echo "<td></td>";
        echo "<td align='right'><b><font color='red'>" . number_format($mtot3, "2", ".", ",") . "</font></b></td>";
        echo "</tr>";

        $edit = " - 91 days";
        $calday = date('Y-m-d', strtotime($to . $edit));
        $sql = "SELECT SUM(GRAND_TOT) FROM s_salma WHERE CANCELL='0' AND SAL_EX = '" . $saleEx . "' AND SDATE BETWEEN '" . $from . "' AND '" . $calday . "' AND TOTPAY = '0'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $zeroInvOv90 = $row[0];
        echo "<tr>";
        echo "<th colspan='10'><font color='red'>0 sale Invoice Total over 90 days :-" . number_format($zeroInvOv90, "2", ".", ",") . "</font></td>";
        echo "</tr>";
        
        $sql = "SELECT SUM(GRAND_TOT) FROM s_salma WHERE CANCELL='0' AND SAL_EX = '" . $saleEx . "' AND SDATE BETWEEN '" . $from . "' AND '" . $to . "' AND TOTPAY = '0'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $zeroInv = $row[0];
        echo "<tr>";
        echo "<th colspan='10'>0 sale Invoice Total :-      " . number_format($zeroInv, "2", ".", ",") . "</td>";
        echo "</tr>";

        $grossSale = $mtot + $zeroInv;
        echo "<tr>";
        echo "<th colspan='10'>Gross Sale :-      " . number_format($grossSale, "2", ".", ",") . "</td>";
        echo "</tr>";

        $sql = "select sum(amount) from c_bal where sal_ex = '" . $saleEx . "' and sdate BETWEEN '" . $from . "' and '" . $to . "' and trn_type<>'INC'and trn_type<>'REC' and trn_type<>'PAY' and trn_type<>'ARN'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $grossReturn = $row[0];
        echo "<tr>";
        echo "<th colspan='10'>Gross Return :-      " . number_format($grossReturn, "2", ".", ",") . "</td>";
        echo "</tr>";

        $netSale = $grossSale - $grossReturn;
        echo "<tr>";
        echo "<th colspan='10'>Net Sale :-      " . number_format($netSale, "2", ".", ",") . "</td>";
        echo "</tr>";

        $sql = "select sum(cr_cheval - paid) from s_cheq
                where CR_FLAG = '0' and CR_DATE BETWEEN '" . $from . "' and '" . $to . "'
                and S_REF = '" . $saleEx . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $chequeReturn = $row[0];
        echo "<tr>";
        echo "<th colspan='10'><font color='red'>Cheque Return :-      " . number_format($chequeReturn, "2", ".", ",") . "</font></td>";
        echo "</tr>";

        $effSale = $netSale - $chequeReturn;
        echo "<tr>";
        echo "<th colspan='10'>Net Sale without return cheques:-      " . number_format($effSale, "2", ".", ",") . "</td>";
        echo "</tr>";
        
        $sql = "select sum(cr_cheval - paid) from s_cheq
                where CR_FLAG = '0' and CR_DATE < '" . $from . "' 
                and S_REF = '" . $saleEx . "'";
        $result = mysqli_query($GLOBALS['dbinv'], $sql);
        $row = mysqli_fetch_array($result);
        $chequeReturnOutside = $row[0];
        
        echo "<tr>";
        echo "<th colspan='10'><font color='red'>Return cheques outside reference period:-      " . number_format($chequeReturnOutside, "2", ".", ",") . "</font></td>";
        echo "</tr>";

        /*
          echo "<tr>";
          echo "<td colspan='10'>Collection before 30 days :-      " . number_format($m30, "2", ".", ",") . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan='10'>Collection before 60 days :-      " . number_format($m60, "2", ".", ",") . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan='10'>Collection before 90 days :-      " . number_format($m90, "2", ".", ",") . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan='10'>Collection before 120 days :-      " . number_format($m120, "2", ".", ",") . "</td>";
          echo "</tr>";
          echo "<tr>";
          echo "<td colspan='10'>Collection over 120 days :-      " . number_format($m121, "2", ".", ",") . "</td>";
          echo "</tr>";
         */

        echo "<tr>";
        $totRecCollected = $mc30 + $mc60 + $mc90 + $mc120 + $mc121;
        $per = $totRecCollected*100/$effSale;
        $per = number_format($per, "2", ".", ",");
        echo "<th colspan='10'>Total Recipt collected :" . number_format($totRecCollected, "2", ".", ",") . "  ($per%)</th>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "</tr>";




        echo "<tr>";
        $c30 = $mc30 * 0.005;
        echo "<th align='left' colspan='4'>Recipit before 30 days :- </th><th align='right'>" . number_format($mc30, "2", ".", ",") . "</th><th align='left' colspan='4'>Commission Paid @ 0.5% :- </th><th align='right'>" . number_format($c30, "2", ".", ",") . "</th>";
        echo "</tr>";
        /*
          echo "<tr>";
          echo "<th align='left' colspan='4'>Credit Notes before 30 days :- </th><th align='right'>" . number_format($mn30, "2", ".", ",") . "</th><th colspan='5'></th>";
          echo "</tr>";
         */
        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "</tr>";

        echo "<tr>";
        $c60 = $mc60 * 0.0025;
        $c60 = $mc60 * 0.003;
        //echo "<th align='left'  colspan='4'>Recipit before 60 days :- </th><th align='right'>" . number_format($mc60, "2", ".", ",") . "</th><th align='left' colspan='4'>Commission Paid @ 0.25% :- </th><th align='right'>" . number_format($c60, "2", ".", ",") . "</th></th>";
        echo "<th align='left'  colspan='4'>Recipit before 60 days :- </th><th align='right'>" . number_format($mc60, "2", ".", ",") . "</th><th align='left' colspan='4'>Commission Paid @ 0.3% :- </th><th align='right'>" . number_format($c60, "2", ".", ",") . "</th></th>";
        echo "</tr>";
        /*
          echo "<tr>";
          echo "<th align='left'  colspan='4'>Credit Notes before 60 days :- </th><th align='right'>" . number_format($mn60, "2", ".", ",") . "</th><th colspan='5'></th>";
          echo "</tr>";
         */
        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "</tr>";

        echo "<tr>";
        $c90 = $mc90 * 0.002;
        echo "<th align='left'  colspan='4'>Recipit before 90 days :- </th><th align='right'>" . number_format($mc90, "2", ".", ",") . "</th><th align='left' colspan='4'>Commission Paid @ 0.2%"
        . " :- </th><th align='right'>" . number_format($c90, "2", ".", ",") . "</th>";
        echo "</tr>";
        /*
          echo "<tr>";
          echo "<th align='left'  colspan='4'>Credit Notes before 90 days :- </th><th align='right'>" . number_format($mn90, "2", ".", ",") . "</th><th colspan='5'></th>";
          echo "</tr>";
         */
        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "</tr>";

        echo "<tr>";
        $c120 = $mc120 * 0.001;
        echo "<th align='left'  colspan='4'>Recipit before 120 days :-</th><th align='right'>" . number_format($mc120, "2", ".", ",") . "</th><th align='left' colspan='4'>Commission Paid @ 0.1% :- </th><th align='right'>" . number_format($c120, "2", ".", ",") . "</th>";
        echo "</tr>";
        /*
          echo "<tr>";
          echo "<th align='left'  colspan='4'>Credit Notes before 120 days :- </th><th align='right'>" . number_format($mn120, "2", ".", ",") . "</th><th colspan='5'></th>";
          echo "</tr>";
         */
        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<th align='left'  colspan='4'><font color='red'>Recipit over 120 days :- </font></th><th align='right'><font color='red'>" . number_format($mc121, "2", ".", ",") . "</font></th><th align='left' colspan='4'>Not Eligible for Commission :- </th><th align='right'>0.00</th>";
        echo "</tr>";
        /*
          echo "<tr>";
          echo "<th align='left'  colspan='4'>Credit Notes over 120 days :- </th><th align='right'>" . number_format($mn121, "2", ".", ",") . "</th><th colspan='5'></th>";
          echo "</tr>";
         */
        echo "<tr>";
        echo "<td colspan='10'></td>";
        echo "</tr>";

        echo "<tr>";
        $totc = $c30 + $c60 + $c90 + $c120;
        echo "<th>Total Commission</th><th>" . number_format($totc, "2", ".", ",") . "</th>";

        $factors = $mtot3 + $chequeReturn + $m121 + $zeroInvOv90 + $chequeReturnOutside;
        $pnlty = $totc * $factors * 1.76 / $netSale;
        
        echo "<th>Penalty " . number_format($pnlty, "2", ".", ",") . "</th>";
        $payedCom = $totc - $pnlty;
        echo "<th>Payed Commission</th><th>" . number_format($payedCom, "2", ".", ",") . "</th>";
        
        $per = 10;
        
        if($per > 60){
            $bonus = $payedCom*0.1678;
            $pay = $payedCom*1.1678;
        }else{
            $pay = $payedCom;
        }
//        echo "<th>Bonus " . number_format($bonus, "2", ".", ",") . "</th><th>" . number_format($pay, "2", ".", ",") . "</th>";
        echo "<th>&nbsp;</th><th>" . number_format($pay, "2", ".", ",") . "</th>";

        $diff = abs(strtotime($to) - strtotime($from));
        $months = floor($diff / (60 * 60 * 24 * 30));
        if ($months != 0) {
            $monthlyPay = $pay / $months;
        }
        echo "<th colspan='2'>Monthly Commission (for $months)</th><th>" . number_format($monthlyPay, "2", ".", ",") . "</th>";
        echo "</tr>";

        echo "</table></center>";
        mysqli_close($GLOBALS['dbinv']);
        ?>
    </body>
</html>

