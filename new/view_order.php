<?php
require_once ("connectioni.php");
?>
<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Order </h3>
        </div>
        <form role="form" class="form-horizontal">
            <div class="box-body">

                <table class="table table-hover">
                    <tr>
                        <th>Ref No</th>
                        <th>Date</th>
                        <th>Dealer</th>
                        <th>Status</th>		 					 					 		
                    </tr>

                    <?php
                    $mrefno = $_GET['refno'];

                    $sql = "select * from s_quomas1 where REF_NO = '" . $mrefno . "' order by REF_NO desc limit 20";
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);

                    if ($row = mysqli_fetch_array($result)) {
                        ?>	
                        <tr>
                            <td><?php echo $row['REF_NO']; ?></td>
                            <td><?php echo $row['SDATE']; ?></td>
                            <td><?php echo $row['CUS_NAME']; ?></td>
                            <td>
                                <?php
                                if ($row['ORD_NO'] == "0") {
                                    echo "Pending";
                                } else {
                                    echo $row['ORD_NO'];
                                }
                                ?>
                            </td>		 					 					 		
                        </tr>      
    <?php
}
?>


                </table>

                <table class="table">
                    <tr>
                        <td style="width: 90px;">Item</td>
                        <td>Description</td>
                        <td style="width: 100px;">Qty</td>
                    </tr>

<?php
$mrefno = $_GET['refno'];

$sql = "select * from s_quotrn1 where REF_NO = '" . $mrefno . "' ";
$result = mysqli_query($GLOBALS['dbinv'], $sql);

while ($row = mysqli_fetch_array($result)) {
    ?>

                        <tr>                             
                            <td><?php echo $row['STK_NO']; ?></td>
                            <td><?php echo $row['DESCRIPT']; ?></td>
                            <td><?php echo number_format($row['QTY'], 0, ".", ","); ?></td>
                            <td></td>

                        </tr>
    <?php
}
?>
                </table>

            </div>
        </form>
    </div>
</section>

