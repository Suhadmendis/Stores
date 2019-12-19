<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AR Report</title>

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
                font-size:13px;

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

        $heading = "<center>AR Report From  " . $_GET["DT1"] . " To " . $_GET["DT2"] . " <br><br>";
        echo $heading;


        $sql = "SELECT SUP_CODE from viewpur where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0  ";
        if ($_GET["cmbcat"] != "All") {
            $sql .=" and type ='" . $_GET["cmbcat"] . "'";
        }
        $sql .="  group by SUP_CODE order by SUP_CODE ";
        $result = $db->RunQuery($sql);

        echo "<table border='1' width=1000 ><tr>"
        . "<td>Suplier</td>"
        . "<td>Brand</td> "
        . "<td>Item</td>"
        . "<td>Description</td>"
        . "<td>Qty</td>"
        . "</tr>";

        while ($row = mysql_fetch_array($result)) {



            
            $sql= "select * from vendor where CODE = '" . $row['SUP_CODE'] . "'";
            $resultv = $db->RunQuery($sql);
            $rowv = mysql_fetch_array($resultv);
            echo "<tr><td colspan='5'><b>" . $row['SUP_CODE'] . "-"  . $rowv['NAME'] . "</b></td></tr>";
            $sql = "SELECT sBRAND_NAME from viewpur where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and sup_code = '" . $row['SUP_CODE'] . "'  AND cancel=0 ";
            if ($_GET["cmbcat"] != "All") {
                $sql .=" and type ='" . $_GET["cmbcat"] . "'";
            }
            $sql .="  group by sBRAND_NAME order by sBRAND_NAME ";
            $result1 = $db->RunQuery($sql);
            $bqty=0;
            
            while ($row1 = mysql_fetch_array($result1)) {

                echo "<tr><td></td><td colspan='4'><b>" . $row1['sBRAND_NAME'] . "</b></td></tr>";

                $sql = "SELECT STK_NO,DESCRIPT,SUM(REC_QTY) AS REC_QTY  from viewpur where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "' and sBRAND_NAME ='" . $row1['sBRAND_NAME'] . "' and sup_code = '" . $row['SUP_CODE'] . "'  AND cancel=0 ";
                if ($_GET["cmbcat"] != "All") {
                    $sql .=" and type ='" . $_GET["cmbcat"] . "'";
                }
                $sql .=" group by  STK_NO,DESCRIPT order by STK_NO ";

                $result2 = $db->RunQuery($sql);
                while ($row2 = mysql_fetch_array($result2)) {

                    echo "<tr>"
                    . "<td colspan='2'></td>"
                    . "<td>" . $row2['STK_NO'] . "</td>"
                    . "<td>" . $row2['DESCRIPT'] . "</td>"
                    . "<td>" . number_format($row2['REC_QTY'], 0, ".", ",") . "</td>"
                    . "</tr>";
                    $bqty = $bqty+$row2['REC_QTY'];
                }
                 echo "<tr>"
                    . "<td colspan='2'></td>"
                    . "<td></td>"
                    . "<td></td>"
                    . "<td><b>" . number_format($bqty, 0, ".", ",") . "</b></td>"
                    . "</tr>";
            }
        }





        echo "<tr> <td> </td> </tr>";

        echo "</table><br>";
        ?>



    </body>
</html>
