<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Commercial Adjustment</title>

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
                font-size:12px;

            }

            .border {
                border: 1px solid;
            }

            .bottom {
                border-bottom:  1px solid;
            }

            td
            {
                font-size:12px;

            }
        </style>
    </head>
    <body>

        <?php
        include_once("connectioni.php");

        $from = $_GET['dateFrom'];
        $to = $_GET['dateTo'];
        $cuscode = $_GET['cuscode'];
        $cusname = $_GET['cusname'];
        $chkus = $_GET['chkcus'];

        echo "<center><b>Commercial Adjustment Report From " . $from . " To " . $to;

        if ($chkus == "on")
            echo " for " . $cusname . " (" . $cuscode . ")";

        echo "</b></center><br><br>";

        echo "<center><table width='750' border=1>
            <tr>
		<th width='80'>Inovice No</th>
                <th width='80'>Invoice Date</th>";

        if ($chkus != "on")
            echo "<th width='80'>Customer</th>";

        echo "<th width='250'>Item No</th>
                <th width='250'>Description</th>
                <th width='80'>Qty</th>
                <th width='80'>Commercial Adj</th>
                </tr>";

        if ($chkus == "on") {
            $sql = "select * from view_salma_sinvo where SDATE between '$from' and '$to' and C_CODE='$cuscode' and CANCELL='0' and sp_dval>0 order by SDATE";
        } else {
            $sql = "select * from view_salma_sinvo where SDATE between '$from' and '$to' and CANCELL='0' and sp_dval>0 order by C_CODE,SDATE";
        }
//        echo $sql;

        $result = mysqli_query($GLOBALS["dbinv"], $sql) or die(mysqli_error($GLOBALS["dbinv"]));


        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["REF_NO"] . "</td>";
            echo "<td>" . $row["SDATE"] . "</td>";

            if ($chkus != "on")
                echo "<td>" . $row["CUS_NAME"] . "</td>";

            echo "<td>" . $row["STK_NO"] . "</td>";
            echo "<td>" . $row["DESCRIPT"] . "</td>";
            echo "<td align=right>" . number_format($row["QTY"], "0", "", ",") . "</td>";
            $totComAdj += $row["sp_dval"];
            echo "<td align=right>" . number_format($row["sp_dval"], "2", ".", ",") . "</td>";
            echo "</tr>";
        }

        if ($chkus != "on") {
            echo "<tr><td colspan=6><b>Total Commercial Adjustment</b></td><td align=right><b>" . number_format($totComAdj, "2", ".", ",") . "</b></td></tr>";
        } else {
            echo "<tr><td colspan=5><b>Total Commercial Adjustment</b></td><td align=right><b>" . number_format($totComAdj, "2", ".", ",") . "</b></td></tr>";
        }
        echo "</table></center>";
        mysqli_close($GLOBALS['dbinv']);
        ?>
    </body>
</html>    

