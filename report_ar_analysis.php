<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AR Analysis Report</title>

        <style>
            body{
                font-family:Arial, Helvetica, sans-serif;
                font-size:14px;
            }
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {
                 
                font-family:Arial, Helvetica, sans-serif;
                padding:4px;
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



        echo "<center><table width=800 >";

        echo "<tr><td width=100>AR No</td><td  width=100>" . $_GET["invno"] . "</td>  <td width=800>&nbsp;</td> </tr>";
        echo "<tr><td  width=100>AR Date</td><td  width=100>" . $_GET["invdate"] . "</td> <td width=800>&nbsp;</td>  </tr>";

        $sqll = "select * from s_purmas where refno = '" . $_GET["invno"] . "'  ";

        $result = $db->RunQuery($sqll);
        if ($row = mysql_fetch_array($result)) {
            echo "<tr><td  width=100>LC No</td>"
            . "<td  width=100>" . $row['LCNO'] . "</td> "
                    . "<td width=800>" . $row["brand"] . "</td>  </tr>";
        }

        echo "</table><br>";

        $sql = "delete from tmpArAnalysis";
        $result = $db->RunQuery($sql);

        $sql = "SELECT * from s_purtrn where refno='" . $_GET["invno"] . "'   ";
        $result = $db->RunQuery($sql);
        while ($row = mysql_fetch_array($result)) {
            $balar = 0;
            $sql_mas = "select *from s_mas where STK_NO = '" . $row['STK_NO'] . "'";
            $result_mas = $db->RunQuery($sql_mas);
            $row_mas = mysql_fetch_array($result_mas);
            $arbal = 0;
            if ($row_mas) {
                $balar = $row_mas['QTYINHAND'];
            }

            $sql_trn = "select * from s_trn where STK_NO = '" . $row['STK_NO'] . "' and LEDINDI='ARN'  order by sdate desc";
            $result_trn = $db->RunQuery($sql_trn);
  
            while ($row_trn = mysql_fetch_array($result_trn)) {
                while ($balar > 0) {

                    if ($row_trn['QTY'] > $balar) {
                        if ($row_trn['REFNO'] == $row['REFNO']) {
                            $arbal = $balar;
                        }
                        break;
                    } else {
                        if ($row_trn["REFNO"] == $row["REFNO"]) {
                            $arbal = $row_trn['QTY'];
                            break;
                        } else {
                            $balar = $balar - $row_trn['QTY'];
                        }
                    }
                }
            }

            $sql_ins = "Insert into tmpArAnalysis (stk_no,des,part_no,arqty,balqty  ) values ('" . $row_mas["STK_NO"] . "','" . $row_mas["DESCRIPT"] . "','" . $row_mas["PART_NO"] . "', " . $row['REC_QTY'] . " ," . $arbal . "  )";
            $result_ins = $db->RunQuery($sql_ins);
        }

        $sql = "select * from tmparanalysis";
        $result = $db->RunQuery($sql);


        echo "<center><table border='1' width=800 ><tr> <td><b>Stock No</td> <td><b>Description</td> <td><b>Part No</td><td><b>AR Qty</td><td><b>Balance Qty</td><td><b>Balance %</td> </tr>";
        while ($row = mysql_fetch_array($result)) {
            echo "<tr> <td width='100'>" . $row['stk_no'] . "</td> "
                    . "<td width='400'>" . $row['des'] . "</td> "
                    . "<td>" . $row['part_no'] . "</td>  "
                    . "<td>" . $row['arqty'] . "</td>  "
                    . "<td>" . $row['balqty'] . "</td>   "
                    . "<td>" . round($row['balqty'] / $row['arqty'] * 100, 2) . "</tr>";
            $arqtyt = $arqtyt + $row['arqty'];
            $balqtyt = $balqtyt + $row['balqty'];
        }
        echo "<tr> <td></td> <td></td> <td></td>  <td>" . $arqtyt . "</td>  <td>" . $balqtyt . "</td>   <td>" . round($balqtyt / $arqtyt * 100, 2) . "</tr>";

        echo "</table><br>";
        ?>



    </body>
</html>
