<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <title>Search Issue</title>

        <script language="JavaScript" src="js/search_job_request.js"></script>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">


    </head>

    <body>
        <div class="container">

            <table border="0" class="table table-bordered">

                <tr>
                    <?php
                    $stname = "";
                    if (isset($_GET["stname"])) {
                        $stname = $_GET["stname"];
                    }
                    ?>
                    <td width="122" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
                    <td width="603" ><input type="text" size="70" name="customername" id="customername" value=""  class="form-control" onkeyup="<?php echo "update_list('$stname')"; ?>"/></td>
            </table>    
            <div id="filt_table">  <table class="table table-bordered">
                    <tr>
                        <th width="201">Reference No</th>
                        <th width="201">Customer Name</th>
                        <th width="201">Date</th> 
                    </tr>
                    <?php
                    include './connection_sql.php';
                    $sql = "SELECT * from s_jobreq where cancel='0'";


                    $sql = $sql . " order by REF_NO limit 500";

                    $stname = "";
                    if (isset($_GET['stname'])) {
                        $stname = $_GET["stname"];
                    }
                    foreach ($conn->query($sql) as $row) {
                        $cuscode = $row["REF_NO"];


                        echo "<tr>               
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['cus_name'] . "</a></td>
                              <td onclick=\"custno('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                                                          </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
