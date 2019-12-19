<?php
session_start();
require_once ("connectioni.php");
?>
<link rel="stylesheet" href="css/themes/redmond/jquery-ui-1.10.3.custom.css" />
<!-- Main content -->
<section class="content">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Order List</h3>
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
                    if($_SESSION["CURRENT_REP"] == ""){
                        $sql = "select * from s_quomas1 order by REF_NO desc limit 20";
                    }else{
                        $sql = "select * from s_quomas1 where sal_ex = '" . $_SESSION["CURRENT_REP"] . "' order by REF_NO desc limit 20";
                    }
                    $result = mysqli_query($GLOBALS['dbinv'], $sql);

                    while ($row = mysqli_fetch_array($result)) {
                        ?>	
                        <tr>
                            <td><a href="home.php?url=order&refno=<?php echo $row['REF_NO']; ?>"><?php echo $row['REF_NO']; ?></a></td>
                            <td><a href="home.php?url=order&refno=<?php echo $row['REF_NO']; ?>"><?php echo $row['SDATE']; ?></a></td>
                            <td><a href="home.php?url=order&refno=<?php echo $row['REF_NO']; ?>"><?php echo $row['CUS_NAME']; ?></a></td>
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

            </div>
        </form>
    </div>
</section>

