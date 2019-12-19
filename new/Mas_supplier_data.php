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
        $sql = "delete from master_supplier where sup_code = '" . $_GET['sup_code'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into master_supplier (sup_code,sup_name,sup_add,sup_tel,sup_fax,sup_mob,sup_web,sup_email,sup_status,sup_ac,sup_adv,sup_gain,con_per,con_tel,con_add,con_fax,con_email,sup_group,per_txt,limit_txt)values 
    ('" . $_GET['sup_code'] . "', '" . $_GET['sup_name'] . "', '" . $_GET['sup_add'] . "','" . $_GET['sup_tel'] . "', '" . $_GET['sup_fax'] . "', '" . $_GET['sup_mob'] . "','" . $_GET['sup_web'] . "', '" . $_GET['sup_email'] . "', '" . $_GET['sup_status'] . "','" . $_GET['sup_ac'] . "', '" . $_GET['sup_adv'] . "', '" . $_GET['sup_gain'] . "', '" . $_GET['con_per'] . "', '" . $_GET['con_tel'] . "','" . $_GET['con_add'] . "', '" . $_GET['con_fax'] . "', '" . $_GET['con_email'] . "', '" . $_GET['sup_group'] . "', '" . $_GET['per_txt'] . "', '" . $_GET['limit_txt'] . "') ";

        $result = $conn->query($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>