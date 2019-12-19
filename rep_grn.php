<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Print GRN</title>
        <style type="text/css">
            <!--
            .companyname {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }

            .com_address {
                color: #000000;
                font-weight: bold;
                font-size: 18px;
            }

            .heading {
                color: #000000;
                font-weight: bold;
                font-size: 26px;
            }

            body {
                color: #000000;
                font-size: 16px;
            }
            .style2 {
                font-size: 36px;
                font-weight: bold;
            }


            -->
        </style>
    </head>

    <body><center>
            <?php
            require_once("config.inc.php");
            require_once("DBConnector.php");
            $db = new DBConnector();
            ?>

            <table width="1000" height="428" border="0">

                <?php
                $sql_para = "Select * from invpara where COMCODE='" . $_SESSION['company'] . "'";

                $result_para = $db->RunQuery($sql_para);
                $row_para = mysql_fetch_array($result_para);

                $sql = "Select * from s_crnma where REF_NO='" . $_GET["invno"] . "'";
                $result = $db->RunQuery($sql);
                $row = mysql_fetch_array($result);

                $sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
                $result1 = $db->RunQuery($sql1);
                $row1 = mysql_fetch_array($result1);

                $sql2 = "Select * from s_crntrn where REF_NO='" . $_GET["invno"] . "'";
                $result2 = $db->RunQuery($sql2);
                
                if (substr($row["REF_NO"], 0, 3) == "GRN"){
                    $note = "GRN";
                }else if(substr($row["REF_NO"], 0, 3) == "CAJ"){
                    $note = "CAJ";
                }
                ?>
 		
<tr>
                    <td colspan="2" scope="col"><?php
                        echo $row_para["COMPANY"];
                        ?></td>
                    <td scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" scope="col"><span class="heading">
                        <?php if ($note == "GRN") { echo "Good Return Note";}
                        else if($note == "CAJ") {echo "Commercial Adjacment Note";}?></span></td>
                    <td scope="col">&nbsp;</td>
                    <td scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td scope="col" colspan='2'><?php if($note == "GRN") { echo "GRN No : ". $row['REF_NO'];}
                    else if($note == "CAJ"){ echo "CAJ No : ". $row['REF_NO'];}?></td>
                   
                </tr>
                <tr>
                    <td scope="col" colspan='2'><?php if($note == "GRN") {echo "GRN Date : ".$row["SDATE"];} 
                    else if($note == "CAJ"){ echo "CAJ Date : ". $row['REF_NO'];}
                    ?></td>
                    <td scope="col"></td>
                </tr>
                <tr>
                    <td width="196">Sales Reference - </td>
                  <td width="457"><?php echo $row["SAL_EX"]; ?></td>
                  <td width="101">Invoice Number</td>
                  <td width="136"><?php echo $_GET["invoiceno"]; ?></td>
              </tr>
                <tr>
                    <td><?php if($note == "GRN") {echo "Return By -";} else if ($note == "CAJ"){echo "Customer -";}?></td>
                    <td><?php echo $row["C_CODE"] . " - " . $row1["NAME"]; ?></td>
                    <td>Invoice Date</td>
                    <td><?php echo $row["DDATE"]; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $row1["ADD1"] . ", " . $row1["ADD2"]; ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
				 
                <tr>
                    <td colspan="4">
                        <table width="900" border="1" cellpadding="0" cellspacing="0"><tr><td colspan="3">
                                    <table width="900" border="1" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <th width="102" scope="col" align="left">Stk No</th>
                                            <th width="350" scope="col" align="left">Description</th>
                                            <th width="98" scope="col" align="left">Part No</th>
                                            <th width="117" scope="col" align="right">Rate</th>
                                            <th width="79" height="22" align="right">Qty</th>
                                            <th width="74" scope="col" align="right">D1%</th>
                                            <th width="74" scope="col" align="right">D2%</th>
                                            <th width="74" scope="col" align="right">D3%</th>
                                            <th width="74" scope="col" align="right">CAJ%</th>
                                            <th width="150" scope="col" align="right">Amount</th>
                                        </tr>
                                        <?php
                                        while ($row2 = mysql_fetch_array($result2)) {

                                            echo "<tr>
        <td align=\"left\">" . $row2["STK_NO"] . "</td>
        <td align=\"left\">" . $row2["DESCRIPT"] . "</td>";

                                            $sql_stk = "Select * from s_mas where STK_NO='" . $row2["STK_NO"] . "'";
                                            $result_stk = $db->RunQuery($sql_stk);
                                            $row_stk = mysql_fetch_array($result_stk);

                                            echo "<td  align=\"left\">" . $row_stk["PART_NO"] . "</td>";
                                            /* 	if ($row2["VAT"]=="1"){
                                              $rate=$row2["PRICE"]/(1+$row["GST"]/100);
                                              } else {
                                              $rate=$row2["PRICE"];
                                              } */
                                            echo "<td align=\"right\">" . number_format($row2["PRICE"], 2, ".", ",") . "</td>
        <td align=\"right\">" . number_format($row2["QTY"], 0, ".", ",") . "</td>
        <td align=\"right\">" . $row2["DIS_P"] . "</td>
		<td align=\"right\">" . $row2["DIS_P2"] . "</td>
		<td align=\"right\">" . $row2["DIS_P3"] . "</td>
		<td align=\"right\">" . $row2["sp_dr"] . "</td>";

                                            if ($row2["VAT"] == '1') {
                                                //if (is_null($row2["DIS_P"])==false) {
                                                $amount = ($row2["QTY"] * $row2["PRICE"] - $row2["QTY"] * $row2["PRICE"] * $row2["DIS_P"] / 100);
                                                $amount = $amount - ($amount * $row2["DIS_P2"] / 100);
                                                $amount=$amount - ($amount * $row2["DIS_P3"] / 100);
                                                $amount=$amount - ($amount * $row2["sp_dr"] / 100);
                                                //} else {
                                                //	$amount=$row2["QTY"]*$row2["PRICE"]/(1+ $row["GST"]/100);
                                                //}	
                                            } else {
                                                if (is_null($row2["DIS_P"]) == false) {
                                                    $amount = $row2["QTY"] * $row2["PRICE"] - $row2["QTY"] * $row2["PRICE"] * $row2["DIS_P"] / 100;
                                                    $amount = $amount - ($amount * $row2["DIS_P2"] / 100);
                                                    $amount = $amount - ($amount * $row2["DIS_P3"] / 100);
                                                    $amount = $amount - ($amount * $row2["sp_dr"] / 100);
                                                } else {
                                                    $amount = $row2["QTY"] * $row2["PRICE"];
                                                }
                                            }
                                            $totAmount += $amount;
                                            echo " <td align=right>" . number_format($amount, 2, ".", ",") . "</td>
     
      </tr>";
                                        }
                                        ?>
                                    </table></td></tr></table><br />
                        <table width="900" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td  width="600">&nbsp;</td>
                                <?php
                                $sql_vat = "Select SVAT from s_salma where REF_NO='" . $_GET["invoiceno"] . "'";
                                $result_vat = $db->RunQuery($sql_vat);
                                $row_vat = mysql_fetch_array($result_vat);
                                
                                /*
                                $sql_invpara = "SELECT * from invpara";
                                $result_invpara = $db->RunQuery($sql_invpara);
                                $row_invpara = mysql_fetch_array($result_invpara);
                                */
                                
                                $txtvata ="";
                                $vatRate = $row["GST"];
                                if ($row_vat["SVAT"] > 0) {
//                                    $txtvat = "SVAT " . $row_invpara["vatrate"] . "%: ";
                                    $txtvat = "SVAT " . $vatRate . "%: ";
                                    $txtvata = $_GET["tax"];
                                } else {
                                    if ($_GET["tax"] > 0) {
//                                        $txtvat = "VAT " . $row_invpara["vatrate"] . "%: ";
                                        $txtvat = "VAT " . $vatRate . "%: ";
                                        $txtvata = $_GET["tax"];
                                    }
                                }
                                ?>   
                                <td><?php echo $txtvat; ?></td>
                                <td align="right"><?php 
                                    $vatVal = 0;    
                                    if ($txtvata !=="") { 
                                    //echo number_format($txtvata, 2, ".", ","); 
//                                    $vatVal = $totAmount*$row_invpara["vatrate"]/100;
                                    $vatVal = $totAmount*$vatRate/100;
                                    echo number_format($vatVal, 2, ".", ","); 
                                } ?></td>
                            </tr>

                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td align="right"><b><?php 
//                                echo number_format($_GET["invtot"], 2, ".", ","); 
                                $invTot = $totAmount + $vatVal;
                                echo number_format($invTot, 2, ".", ","); 
                                ?></b></td>
                            </tr>
                        </table></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><b><?PHP if($row["CANCELL"]=="1") echo "CANCELED";?></b></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>_______________________</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;________________________</td>
                     
                    <td>_________________</td>
              </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Entered By</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checked by</td>
                     
                    <td>&nbsp;Authorized by</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
</body>
</html>
