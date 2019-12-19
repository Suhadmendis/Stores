<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {

    $tb = "";
    $tb .= "<table class='table table-hover'>";


    $sql = "select * from master_reason order by rea_code";




    $tb .= "<tr>";
    $tb .= "<th class=\"succes;\" style=\"width: 350px;\">Reason Code</th>";
    $tb .= "<th style=\"width: 500px;\">Reason Name</th>";
    $tb .= "<th style=\"width: 350px;\">Reason Cat</th>";
    $tb .= "<th style=\"width: 350px;\">Reason Type</th>";


    $tb .= "</tr>";

    foreach ($conn->query($sql) as $row) {
        $tb .= "<tr>";
        $tb .= "<td onclick=\"getcode('" . $row['rea_code'] . "','" . $row['rea_name'] . "','" . $row['rea_cat'] . "','" . $row['rea_type'] . "')\">" . $row['rea_code'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['rea_code'] . "','" . $row['rea_name'] . "','" . $row['rea_cat'] . "','" . $row['rea_type'] . "')\">" . $row['rea_name'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['rea_code'] . "','" . $row['rea_name'] . "','" . $row['rea_cat'] . "','" . $row['rea_type'] . "')\">" . $row['rea_cat'] . "</td>";
        $tb .= "<td onclick=\"getcode('" . $row['rea_code'] . "','" . $row['rea_name'] . "','" . $row['rea_cat'] . "','" . $row['rea_type'] . "')\">" . $row['rea_type'] . "</td>";
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
        $sql = "delete from master_reason where rea_code = '" . $_GET['rea_code'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into master_reason (rea_code,rea_name,rea_cat,rea_type)values 
    ('" . $_GET['rea_code'] . "', '" . $_GET['rea_name'] . "', '" . $_GET['rea_cat'] . "', '" . $_GET['rea_type'] . "') ";

        $result = $conn->query($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>