<?php
ini_set('session.gc_maxlifetime', 30 * 60 * 60 * 60);
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Transport Report</title>

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
            $mode = "";
            if ($_GET['department'] != "all") {
                $mode = "for " . $_GET['department'];
            }
            
            echo "<center><span class=\"heading1\">Transport Report $mode: " . $_GET["dateFrom"] . " to " . $_GET["dateTo"] . "<span class=\"heading\"></center><br>";

            echo "<table  width=1000 border=1>";
            //rate removed
            echo "<tr>
                       <th align=center>Date</th>
                       <th align=center>Inv NO</th>
                       <th align=center>C Code</th>
                       <th align=center>Customer</th>
                       <th align=center>Mode</th>
                       <th align=center>Remark1</th>
                       <th align=center width=200>Remark2</th>
                  </tr>";
            

            $sql = "SELECT * from s_salma where SDATE between '" . $_GET["dateFrom"] . "' and '" . $_GET["dateTo"] . "'";

            /*
              if ($_GET["supChk"] == "on") {
              if ($_GET['supplier_code'] != "") {
              $sql .= "and SUP_CODE='" . $_GET["supplier_code"] . "'";
              }
              }
             */
            

            if ($_GET['department'] == "all") {
                $sql .= " and tp_mode != 'not' ";
            }else{
                $sql .= " and tp_mode = '".$_GET['department']."' ";
            }
            

            $sql .= " order by SDATE desc";

//            echo $sql;

            $result = mysqli_query($GLOBALS['dbinv'], $sql);
            
            while ($row = mysqli_fetch_array($result)) {

                
                echo "<tr>
                                <td>" . $row["SDATE"] . "</td>
                                <td>" . $row["REF_NO"] . "</td>
                                <td>" . $row["C_CODE"] . "</td>
                                <td>" . $row["CUS_NAME"] . "</td>
                                <td>" . $row["tp_mode"] . "</td>
                                <td>" . $row["tp_rmk"] . "</td>
                                <td>" . $row["tp_rmk1"] . "</td>
                              </tr>";
            }
            echo "</table>";
            ?>


    </body>
</html>
