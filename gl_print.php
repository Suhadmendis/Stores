<?php
require_once("connectioni.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
    <head>


        <title>Invoice Print</title>
        <meta name="generator" content="LibreOffice 5.1.6.2 (Linux)"/>
        <meta name="created" content="2006-09-16T00:00:00"/>
        <meta name="changed" content="2017-08-18T00:24:42.237600141"/>
        <meta name="AppVersion" content="14.0300"/>
        <meta name="DocSecurity" content="0"/>
        <meta name="HyperlinksChanged" content="false"/>
        <meta name="LinksUpToDate" content="false"/>
        <meta name="ScaleCrop" content="false"/>
        <meta name="ShareDoc" content="false"/>
        <style>
            .center {
                text-align: center;
            }

            .right {
                text-align: right;
            }

        </style>

    </head>

    <body>
        <table width="800px;" border="1">
            <tr>
                <th width="200px;">Ledger Code</th>
                <th width="450px;">Ledger Details</th>
                <th width="120px;">DEB</th>
                <th width="120px;">CRE</th>
                <th width="120px;">Balance</th>
            </tr>
            <?php
            $sql1 = "select * from view_ledger where L_REFNO = '" .$_GET["invno"]. "' order by id";
//            $sql1 = "select * from ledger where l_refno = 'BCRN/000152' order by L_FLAG1";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            $bal = 0;
//            echo "<tr><td>$sql1</td></tr>";
            while ($row1 = mysqli_fetch_array($result1)) {
                ?>
                <tr>
                    <td><?php echo $row1["L_CODE"]; ?></td>
                    <td><?php echo $row1["C_NAME"]; ?></td>
                    <?php if($row1["L_FLAG1"] == "DEB"){
                        echo "<td>".number_format($row1["L_AMOUNT"], 2, ".", ",")."</td>";
                        echo "<td></td>";
                        $bal += $row1["L_AMOUNT"];
                    }else{
                        echo "<td></td>";
                        echo "<td>".number_format($row1["L_AMOUNT"], 2, ".", ",")."</td>";
                        $bal -= $row1["L_AMOUNT"];
                    }
                    echo "<td>".number_format($bal, 2, ".", ",")."</td>";
                    ?>
            </tr>
            <?php } ?>
        </table>
    </body>
</html>
