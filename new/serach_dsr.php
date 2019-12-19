<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <title>Search Invoice</title>

    <script language="JavaScript" src="js/invoice.js"></script>
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
            <td width="122" ><input type="text" size="20" name="cusno" id="cusno" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_list_dsr('$stname')"; ?>" /></td>
            <td width="122" ><input type="hidden" size="20" name="cusno1" id="cusno1" value=""  class="form-control" tabindex="1" onkeyup="<?php echo "update_list_dsr('$stname')"; ?>" /></td>
            <td width="481" ><input type="hidden" size="70" name="customername" id="customername" value=""  class="form-control" onkeyup="<?php echo "update_list_dsr('$stname')"; ?>"/></td>
    </table>
    <div id="filt_table">  <table class="table table-bordered">
            <tr>
                <th width="121">Reference No</th>
                <th width="121"></th>
                <th width="121">Date</th>
                <th width="100"></th>
                <th width="200"></th>
                <th width="121"></th>
            </tr>
            <?php
            include './connection_sql.php';

            $sql = "select * from s_ginmas where TYPE = 'DSR' and cancel='0'";
            $sql .= " order by SDATE desc limit 50";

            foreach ($conn->query($sql) as $row) {
                $cuscode = $row["REF_NO"];


                echo "<tr>               
                              <td onclick=\"dsrview('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"dsrview('$cuscode', '$stname');\"></a></td>
                              <td onclick=\"dsrview('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"dsrview('$cuscode', '$stname');\"></a></td>
                                  <td onclick=\"dsrview('$cuscode', '$stname');\"></a></td>
                                      <td onclick=\"dsrview('$cuscode', '$stname');\"></a></td>
                            </tr>";
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
