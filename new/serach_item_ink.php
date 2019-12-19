<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <title>Search Ink</title>



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

                <td width="122" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                <td width="603" ><input type="text" size="70" name="customername" id="customername" value=""  class="form-control" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
        </table>    
        <div id="filt_table" class="CSSTableGenerator">  <table width="735"    class="table table-bordered">
                <tr>
                    <th width="121">Item No</th>
                    <th width="424">Item Description</th>
                    <th width="100">Avg Cost</th>

                </tr>
                <?php
                include_once './connectioni.php';

                $stname = "";
                if (isset($_GET['stname'])) {
                    $stname = $_GET["stname"];
                }

                if($stname == "pre_ink"){
                    $sql = "SELECT * from s_mas where GROUP1 = 'PRE_INK' order by STK_NO limit 50";
                }
                
                $result = mysqli_query($GLOBALS['dbinv'], $sql);

                while ($row = mysqli_fetch_array($result)) {

                    echo "<tr>
                              <td onclick=\"itno_undeliver('" . $row['STK_NO'] . "','" . $stname . "');\">" . $row['STK_NO'] . "</a></td>
                              <td onclick=\"itno_undeliver('" . $row['STK_NO'] . "','" . $stname . "');\">" . $row['DESCRIPT'] . "</a></td>
                    <td onclick=\"itno_undeliver('" . $row['STK_NO'] . "','" . $stname . "');\">" . $row['GROUP2'] . "</a></td> 
                            </tr>";
                }
                ?>
            </table>
        </div>

    </body>
</html>
