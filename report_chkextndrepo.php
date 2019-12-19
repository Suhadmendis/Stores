<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Extended Cheque Report</title>

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
                font-size:12px;

            }
            td
            {
                font-size:11px;

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

        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();







        $sql_head = "select * from invpara";
        $result_head = $db->RunQuery($sql_head);
        $row_head = mysql_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $heading = "<center>Cheque Extended Report From  " . $_GET["dtfrom"] . " To  " . $_GET["dtto"] . "<br>";
        echo $heading;



        echo "<br><table border=1>";
        echo "<tr><td><b>Cheque No</b></td>"
        . "<td><b>Customer</b></td>"
        . "<td><b>Amount</b></td>"
        . "<td><b>Cheq. Date I</b></td>"
        . "<td><b>Cheq Date II</b></td>"
        . "<td><b>Extended Date</b></td>"
        . "</tr>";

        $sql = "SELECT * From S_INVCHEQ wHERE ((ex_date1 >= '" . $_GET["dtfrom"] . "'  and ex_date1 <= '" . $_GET["dtto"] . "') or (ex_date2 >= '" . $_GET["dtfrom"] . "'  and ex_date2 <= '" . $_GET["dtto"] . "'))  ";


        if (isset($_GET["Check1"])) {
            $sql .= " and cus_code='" . $_GET["cuscode"] . "' ";
        }


        $result = $db->RunQuery($sql);
        while ($row = mysql_fetch_array($result)) {
            echo "<tr>
			<td>" . $row["cheque_no"] . "</td>
			<td>" . $row["CUS_NAME"] . "</td>
			<td align=\"right\">" . number_format($row["che_amount"], 2, ".", ",") . "</td>";

            $dt1 = "";
            $dt2 = "";
            if (($row["ex_date1"] != "0000-00-00")) {
                $dt1 = $row["ex_date1"];
            }

            if (($row["ex_date2"] != "0000-00-00")) {
                $dt2 = $row["ex_date2"];
            }



            echo "<td>" . $dt1 . "</td>
                        <td>" . $dt2 . "</td>    
                        <td>" . $row["che_date"] . "</td>";



            echo "</tr>";
        }
        ?>



    </body>
</html>
