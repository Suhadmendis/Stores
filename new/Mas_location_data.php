<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {

    $tb = "";
    $tb .= "<table class='table table-hover'>";


    $sql = "select * from master_location order by loc_code";




    $tb .= "<tr>";
    $tb .= "<th class=\"succes;\" style=\"width: 350px;\">Location Code</th>";
    $tb .= "<th style=\"width: 500px;\">Location Name</th>";
    $tb .= "<th style=\"width: 350px;\">Telephone</th>";
    $tb .= "<th style=\"width: 350px;\">Email</th>";
    $tb .= "<th style=\"width: 350px;\">Location Type</th>";

    $tb .= "</tr>";

    foreach ($conn->query($sql) as $row) {
        $tb .= "<tr>";
        $tb .= "<td onclick=\"getcode('" . $row['loc_code'] . "','" . $row['loc_name'] . "','" . $row['tel'] . "','" . $row['email'] . "','" . $row['locTy_combo'] . "')\">" . $row['loc_code'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['loc_code'] . "','" . $row['loc_name'] . "','" . $row['tel'] . "','" . $row['email'] . "','" . $row['locTy_combo'] . "')\">" . $row['loc_name'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['loc_code'] . "','" . $row['loc_name'] . "','" . $row['tel'] . "','" . $row['email'] . "','" . $row['locTy_combo'] . "')\">" . $row['tel'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['loc_code'] . "','" . $row['loc_name'] . "','" . $row['tel'] . "','" . $row['email'] . "','" . $row['locTy_combo'] . "')\">" . $row['email'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['loc_code'] . "','" . $row['loc_name'] . "','" . $row['tel'] . "','" . $row['email'] . "','" . $row['locTy_combo'] . "')\">" . $row['locTy_combo'] . "</td>";
        $tb .= "</tr>";
    }
    $tb .= "</table>";

    echo $tb;
}

if ($_GET["Command"] == "update_list") {
    $ResponseXML = "";
    $ResponseXML .= "<table class=\"table\">
	            <tr>
                        <th width=\"121\">Supplier Code</th>
                        <th width=\"424\"> Supplier Name </th>
                        <th width=\"424\">Address </th>
                        <th width=\"121\">Telephone</th>  
                    </tr>";


    $sql = "SELECT * from s_mas where itcode <> ''";
    if ($_GET['refno'] != "") {
        $sql .= " and itcode like '%" . $_GET['refno'] . "%'";
    }
    if ($_GET['cusname'] != "") {
        $sql .= " and itname like '%" . $_GET['cusname'] . "%'";
    }
    $stname = $_GET['stname'];

    $sql .= " ORDER BY itcode limit 50";

    foreach ($conn->query($sql) as $row) {
        $cuscode = $row["itcode"];


        $ResponseXML .= "<tr>               
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['itcode'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['itname'] . "</a></td>
                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['price'] . "</a></td>
                            </tr>";
    }
    $ResponseXML .= "</table>";
    echo $ResponseXML;
}


if ($_GET["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "delete from master_location where loc_code = '" . $_GET['loc_code'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into master_location (loc_code,loc_name,tel,fax,email,locTy_combo,locTy_txt)values 
    ('" . $_GET['loc_code'] . "', '" . $_GET['loc_name'] . "', '" . $_GET['tel'] . "','" . $_GET['fax'] . "', '" . $_GET['email'] . "', '" . $_GET['locTy_combo'] . "', '" . $_GET['locTy_txt'] . "') ";

        $result = $conn->query($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>