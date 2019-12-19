<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <title>Search Issue</title>

        <script language="JavaScript" src="js/job.js"></script>
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
                        <th width="201">Date</th>
                        <th width="201">Description</th> 
                    </tr>
                    <?php
                    include './connection_sql.php';
                    if(($stname == "")||($stname == "pickJOB")||($stname == "pickJOB_fg")||($stname == "pickJOB_mst")){
                        $sql = "select * from job_mas where cancel='0'";
                    }else if(($stname == "pickJOB_is_ut")){
                        $sql = "select * from job_mas where flag_inv='1'";
                    }else if(($stname == "job")||($stname == "mrn")){
                        $sql = "select * from s_mrnmas where TYPE = 'MRN'";
                    }else if(($stname == "jobi")||($stname == "mrni")){
                        $sql = "select * from s_mrnmas where TYPE = 'MRNI'";
                    }else if(($stname == "jobg")||($stname == "mrng")){
                        $sql = "select * from s_mrnmas where TYPE = 'MRNG'";
                    }else if($stname == "ming"){
                        $sql = "select * from s_ginmas where TYPE = 'MING'";
                    }else if($stname == "fg"){
                        $sql = "select * from s_ginmas where TYPE = 'FG'";
                    }else if($stname == "isa"){
                        $sql = "select * from s_ginmas where TYPE = 'ISA'";
                    }else if($stname == "pick_is"){
                        $sql = "select * from s_ginmas where TYPE = 'ISA'";
                    }else if($stname == "ginu"){
                        $sql = "select * from s_ginmas where TYPE = 'ISU'";
                    }
                    $sql .= " and cancel='0' order by SDATE desc limit 50";
                    
//                    echo $sql;
                    
                    foreach ($conn->query($sql) as $row) {
                        $cuscode = $row["REF_NO"];


                        echo "<tr>               
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['REF_NO'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['SDATE'] . "</a></td>
                              <td onclick=\"crnview('$cuscode', '$stname');\">" . $row['descript'] . "</a></td>
                            </tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>
