<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {

//    $tb = "";
//    $tb .= "<table class='table table-hover'>";
//
//
//    $sql = "select * from area_mas order by area_code";
//
//
//
//
//    $tb .= "<tr>";
//    $tb .= "<th class=\"succes;\" style=\"width: 350px;\">Area Code</th>";
//    $tb .= "<th style=\"width: 500px;\">Area Name</th>";
//    $tb .= "<th style=\"width: 350px;\">Mileage</th>";
//
//    $tb .= "</tr>";
//
//    foreach ($conn->query($sql) as $row) {
//        $tb .= "<tr>";
//        $tb .= "<td onclick=\"getcode('" . $row['area_code'] . "','" . $row['area_name'] . "','" . $row['area_mi'] . "')\">" . $row['area_code'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['area_code'] . "','" . $row['area_name'] . "','" . $row['area_mi'] . "')\">" . $row['area_name'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['area_code'] . "','" . $row['area_name'] . "','" . $row['area_mi'] . "')\">" . $row['area_mi'] . "</td>";
//        $tb .= "</tr>";
//    }
//    $tb .= "</table>";
//
//    echo $tb;
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
        $sql = "delete from edit_image where ref_no = '" . $_GET['ref_no'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into edit_image (ref_no,da_date,cus_code,cus_name,mar_code,mar_name,pro_des,wrk_path,con_path,cos_path)values 
    ('" . $_GET['ref_no'] . "', '" . $_GET['da_date'] . "', '" . $_GET['cus_code'] . "','" . $_GET['cus_name'] . "', '" . $_GET['mar_code'] . "', '" . $_GET['mar_name'] . "', '" . $_GET['pro_des'] . "', '" . $_GET['wrk_path'] . "', '" . $_GET['con_path'] . "', '" . $_GET['cos_path'] . "') ";

        $result = $conn->query($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>