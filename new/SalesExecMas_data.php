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
//    $sql = "select * from book order by book_code";
//
//    foreach ($conn->query($sql) as $row) {
//        
//    }
//    $tb .= "</table>";
//
//    echo $tb;
//}
//
//if ($_GET["Command"] == "update_list") {
//    $ResponseXML = "";
//    $ResponseXML .= "<table class=\"table\">
//	            <tr>
//                        <th width=\"121\">Item No</th>
//                        <th width=\"424\"> Item Description </th>
//                        
//                        <th width=\"121\">Amount</th>  
//                    </tr>";
//
//
//    $sql = "SELECT * from s_mas where itcode <> ''";
//    if ($_GET['refno'] != "") {
//        $sql .= " and itcode like '%" . $_GET['refno'] . "%'";
//    }
//    if ($_GET['cusname'] != "") {
//        $sql .= " and itname like '%" . $_GET['cusname'] . "%'";
//    }
//    $stname = $_GET['stname'];
//
//    $sql .= " ORDER BY itcode limit 50";
//
//    foreach ($conn->query($sql) as $row) {
//        $cuscode = $row["itcode"];
//
//
//        $ResponseXML .= "<tr>               
//                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['itcode'] . "</a></td>
//                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['itname'] . "</a></td>
//                              <td onclick=\"itno_undeliver('$cuscode', '$stname');\">" . $row['price'] . "</a></td>
//                            </tr>";
//    }
//    $ResponseXML .= "</table>";
//    echo $ResponseXML;
}


if ($_GET["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "delete from sales_ex_mas where ex_code = '" . $_GET['ex_code'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into sales_ex_mas (ex_code,ex_name,ex_ID,ex_add`,ex_tel,ex_mob,ex_email)values 
               ('" . $_GET['ex_code'] . "','" . $_GET['ex_name'] . "', '" . $_GET['ex_ID'] . "', '" . $_GET['ex_add'] . "', '" . $_GET['ex_tel'] . "', '" . $_GET['ex_mob'] . "', '" . $_GET['ex_email'] . "') ";

        $result = $conn->query($sql);
        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>