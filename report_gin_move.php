<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>GIN Report</title>

        <style>
            .heading {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }

            .heading1 {
                color: #000000;
                font-weight: bold;
                font-size: 18px;
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
                font-size:15px;

            }
            td
            {
                font-size:15px;

            }
        </style>

    </head>

    <body> <center> 


            <?php
            include_once 'connectioni.php';

            $sql_head = "select * from invpara";
            $result_head = mysqli_query($GLOBALS['dbinv'], $sql_head);
            $row_head = mysqli_fetch_array($result_head);

            echo "<center><span class=\"heading\">" . $row_head["COMPANY"] . "</span></center><br>";

            echo "<center><span class=\"heading1\">GIN Report : " . $_GET["dateFrom"] . " to " . $_GET["dateTo"] . "<span class=\"heading\"></center><br>";

            echo "<table  width=1000 border=1>";
            echo "<tr>
                       <th align=center>Date</th>
                       <th align=center>REF NO</th>
                       <th align=center>Department</th>
                       <th align=center>Item</th>
                       <th align=center width=200>Item Description</th>
                       <th align=center>Rate</th>
                       <th align=center>Quantity</th>
                       <th align=center>Value</th>
                  </tr>";

//            $sql = "SELECT * from vieword where S_date between '2016-12-31' and '2017-05-12'";
            $sql = "SELECT * from viewstran where SDATE between '" . $_GET["dateFrom"] . "' and '" . $_GET["dateTo"] . "' and LEDINDI = 'GINR'";

            /*
              if ($_GET["supChk"] == "on") {
              if ($_GET['supplier_code'] != "") {
              $sql .= "and SUP_CODE='" . $_GET["supplier_code"] . "'";
              }
              }
             */

            if ($_GET['department'] != "All") {
                $sql .= "and DEPARTMENT='" . $_GET["department"] . "'";
            }
            /*
              if ($_GET['item'] != "All") {
              $sql .= "and STK_NO='" . $_GET["item"] . "'";
              }


              if ($_GET['rep'] != "All") {
              $sql .= "and REP_CODE='" . $_GET["rep"] . "'";
              }
             */

            $sql .= " order by SDATE";

//            echo $sql;

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            $totVal = 0;
            $totQty = 0;
            while ($row = mysqli_fetch_array($result)) {

                $ordQty = $row["QTY"];
                $rate = $row["cost"];
                $value = $ordQty * $rate;

                $totQty += $ordQty;
                $totVal += $value;
                
                $sql = "select DESCRIPTION from s_stomas where CODE = '".$row["DEPARTMENT"]."'";
                $resultStore = mysqli_query($GLOBALS['dbinv'], $sql);
                $rowStore = mysqli_fetch_array($resultStore);
                
                echo "<tr>
                                <td>" . $row["SDATE"] . "</td>
                                <td>" . $row["REFNO"] . "</td>
                                <td>" . $rowStore["DESCRIPTION"] . "</td>
                                <td>" . $row["STK_NO"] . "</td>
                                <td>" . $row["DESCRIPT"] . "</td>
                                <td align=right>" . number_format($rate, 2, ".", ",") . "</td>
                                <td align=right>" . number_format($ordQty, 2, ".", ",") . "</td>    
                                <td align=right>" . number_format($value, 2, ".", ",") . "</td>
                              </tr>";
            }
            echo "<tr><td colspan=6 align=right><b>" . number_format($totQty, 2, ".", ",") . "</b></td><td colspan=2 align=right><b>" . number_format($totVal, 2, ".", ",") . "</b></td></tr>";
            echo "</table>";
            ?>


    </body>
</html>
