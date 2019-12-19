<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <title>Search Item</title>



        <link rel="stylesheet" href="css/bootstrap.min.css">

            <script language="JavaScript" src="js/comman.js"></script>
            <script language="JavaScript" src="js/po_item.js"></script>


    </head>

    <body>

        <table width="735"   class="table table-bordered">

            <?php
            if (isset($_GET["stname"])) {
                $stname = $_GET["stname"];
            } else {
                $stname = "";
            }
            ?>

            <tr>
                <?php if(($stname != "isn_ut")&&($stname != "dsr_itm")){ ?>
                    <td width="122" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                    <td width="603" ><input type="text" size="70" name="customername" id="customername" value=""  class="form-control" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                <?php } ?>
        </table>    
        <div id="filt_table" class="CSSTableGenerator">  <table width="735"    class="table table-bordered">
                <tr>
                    <th width="121">Item No</th>
                    <th width="424">Item Description</th>
                    <th width="100">All Quantity</th>

                </tr>
                <?php
                include_once './connectioni.php';

                $stname = "";
                if (isset($_GET['stname'])) {
                    $stname = $_GET["stname"];
                }

                if($stname == "isn"){
                    $sql = "SELECT * from s_mas  order by STK_NO limit 50";
                }else if($stname == "isn_ut"){
                    $sql = "SELECT STK_NO, DESCRIPT, (QTY-allocated) as QTYINHAND from s_gintrn where LEDINDI = 'GINMI' and REFNO = '".$_SESSION["pickRef_is"]."' order by STK_NO";
                }else if($stname == "dsr_itm"){
                    if($_SESSION["ming_req_ref"] != ""){
                        $sql = "SELECT STK_NO, DESCRIPt as DESCRIPT, QTY as QTYINHAND from s_trn where REFNO = '".$_SESSION["ming_req_ref"]."' order by STK_NO";
                    }else{
                        $sql = "SELECT * from s_mas where GROUP2 = 'OTHER_SALE' order by STK_NO";
                    }
                }else if($stname == "fg"){
                    $sql = "SELECT * from s_mas where GROUP2 = 'FG' order by STK_NO limit 50";
                }
                
                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                              <td onclick=\"itno_undeliver('" . $row['STK_NO'] . "','" . $stname . "');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itno_undeliver('" . $row['STK_NO'] . "','" . $stname . "');\">" . $row['DESCRIPT'] . "</a></td>
                    <td onclick=\"itno_undeliver('" . $row['STK_NO'] . "','" . $stname . "');\">" . $row['QTYINHAND'] . "</a></td> 
                            </tr>";
                }
                ?>
            </table>
        </div>

    </body>
</html>
