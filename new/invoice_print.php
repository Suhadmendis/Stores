<?php
require_once("connectioni.php");

$sql = "Select * from s_salma where tmp_no='" . $_GET["tmp_no"] . "'";
$result = mysqli_query($GLOBALS['dbinv'], $sql);
$row = mysqli_fetch_array($result);

$sql1 = "Select * from vendor where CODE='" . $row["C_CODE"] . "'";
$result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
$row1 = mysqli_fetch_array($result1);


$sql_invpara = "SELECT * from invpara";
$result_invpara = mysqli_query($GLOBALS['dbinv'], $sql_invpara);
$row_invpara = mysqli_fetch_array($result_invpara);
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
        <table width="800px;" cellspacing="0" border="0">
            
            <tr>
                <th class="center"  colspan=6 ><?php echo $row_invpara['COMPANY'] ?></th>
            </tr>
            <tr>
                <th class="center" colspan=6 ><?php echo $row_invpara['ADD1'] ?></th>
            </tr>
            <tr>
                <th class="center" colspan=6 >Tel: <?php echo $row_invpara['TELE'] ?>, Fax: <?php echo $row_invpara['FAX'] ?></th>
            </tr>
            <tr>
                <th class="center" colspan=6 >E- mail : <?php echo $row_invpara['EMAIL'] ?></th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td height="18"></td>
                <td><?php echo $row['CUS_NAME'] ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td><br></td>
            </tr>
            <tr>
                <td ></td>
                <td><?php echo $row['ADD'] ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td >Credit</td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td>Company VAT No: <?php echo $row_invpara['VAT'] ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Date: <?php echo $row['SDATE'] ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Customer VAT No: </td>
                <td></td>
                <td></td>
                <td></td>
                <td>Invoice No: <?php echo $row['REF_NO']; ?></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th class='center' colspan='6'><?php if ($row["vat"]==1){echo "VAT ";}else{echo "SVAT ";}?>INVOICE</th>
            </tr>
        </table><table width="800px;">
            <tr>
                <th width="0px;"></th>
                <th width="30px;">No</th>
                <th width="80px;">Qty</th>
                <th width="450px;">Description</th>
                <th width="120px;">Rate</th>
                <th width="120px;">Amount</th>
            </tr>
            <?php
            $sql1 = "Select * from s_invo where REF_NO='" . $row['REF_NO'] . "'";
            $result1 = mysqli_query($GLOBALS['dbinv'], $sql1);
            while ($row1 = mysqli_fetch_array($result1)) {
                ?>
            <tr>
                <td></td>
                <td>1</td>
                <td><?php echo $row1['QTY']; ?></td>
                <td><?php echo $row1['DESCRIPT']; ?></td>
                <td class="right"><?php echo $row1['PRICE']; ?></td>
                <td class="right"><?php echo number_format($row1['PRICE']*$row1['QTY'], 2, ".", ","); ?></td>
            </tr>
            <?php
//            $mtot = $mtot + ($row1['QTY']*$row1['PRICE']);
            }
            ?>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td><?php if($row['BTT']>0) echo "NBT " .$row['btt_rate']."%";?></td>
                <td></td></td>
                <td class="right"><?php 
                if($row['BTT']>0) echo number_format($row['BTT'], 2, ".", ","); ?></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td</td>
                <td ></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td</td>
                <td  ></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td</td>
                <td  ></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td</td>
                <td  ></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td</td>
                <td  ></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td</td>
                <td</td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td ></td>
                <td</td>
                <td  ></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td ></td>
                <td>Sub Total</td>
                <td class="right"><?php
                echo number_format(($row['GRAND_TOT']-$row['btt']), 2, ".", ",");
                
                ?></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php if($row['vat']==1) {echo "VAT " .$row['gst']. "%"; $vat = $row["VAT_VAL"];}else{echo "SVAT " .$row['gst']. "%";$vat = $row["SVAT"];}?></td>
                <td class="right"><?php
                echo number_format($vat, 2, ".", ",");
                
                ?></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total Amount</td>
                <td class="right"><?php
                $invtot_g = $row["GRAND_TOT"];
                echo number_format($invtot_g, 2, ".", ",");
                
                ?></td>
            </tr>
            </table><table width="800px;">
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td  colspan='2'></td>
                 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td ></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table><table width="800px;">
            <tr>
                <td> </td>
                <td>Prepared By:  .................     </td>
                <td></td> 
                <td>Checked By:   .................</td>
                <td></td>
                <td>Authorised By:.................</td>
            </tr>
        </table>
        <!-- ************************************************************************** -->
    </body>

</html>
