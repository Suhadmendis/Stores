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
//    $sql = "select * from qr order by ref_no desc";
//
//
//    $tb .= "<tr class=\"info\">";
//    $tb .= "<th style=\"width: 350px;\">Ref No</th>";
//    $tb .= "<th style=\"width: 500px;\">Drf No</th>";
//    $tb .= "<th style=\"width: 350px;\">Date</th>";
//    $tb .= "</tr>";
//
//    foreach ($conn->query($sql) as $row) {
//        $tb .= "<tr>";
//        $tb .= "<td onclick=\"getcode('" . $row['ref_no'] . "','" . $row['drf_no'] . "','" . $row['t_date'] . "')\">" . $row['ref_no'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['ref_no'] . "','" . $row['drf_no'] . "','" . $row['t_date'] . "')\">" . $row['drf_no'] . "</td>";
//        $tb .= "<td onclick=\"getcode('" . $row['ref_no'] . "','" . $row['drf_no'] . "','" . $row['t_date'] . "')\">" . $row['t_date'] . "</td>";
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
                        <th width=\"121\">Item No</th>
                        <th width=\"424\"> Item Description </th>
                        
                        <th width=\"121\">Amount</th>  
                    </tr>";


    $sql = "SELECT * from itemmasterentry where itcode <> ''";
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

if ($_GET["Command"] == "setitem") {
    header('Content-Type: text/xml');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


    $sql = "delete from tmp_po_data where r_no='" . $_GET['r_no'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
    $result = $conn->query($sql);
    if ($_GET["Command1"] == "add_tmp") {
        $r_no = str_replace(",", "", $_GET["r_no"]);
        $des = str_replace(",", "", $_GET["des"]);
        $qty = str_replace(",", "", $_GET["qty"]);



        $sql = "Insert into tmp_po_data (r_no,des,qty,tmp_no)values 
			('" . $_GET['r_no'] . "', '" . $_GET['des'] . "', '" . $_GET['qty'] . "','" . $_GET['tmpno'] . "') ";
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
                                            <th style=\"width: 120px;\">No</th>
                                            <th style=\"width: 120px;\">Rec No</th>
                                            <th style=\"width: 120px;\"> Description</th>
                                            <th style=\"width: 120px;\">Qty</th>
                                            <th style=\"width: 100px;\"></th>
					</tr>";

    $i = 1;

    $sql = "Select * from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                             <td>" . $i . "</td>
                                                         <td>" . $row['r_no'] . "</td>
							 <td>" . $row['des'] . "</td>
							 <td>" . $row['qty'] . "</td>
							 <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['r_no'] . "')\"> <span class='fa fa-remove'></span></a></td>
							 </tr>";

        $i = $i + 1;
    }

    $ResponseXML .= "</table>]]></sales_table>";
    $ResponseXML .= "<item_count><![CDATA[" . $i . "]]></item_count>";

    $ResponseXML .= "</salesdetails>";

    echo $ResponseXML;
}

if ($_GET["Command"] == "save_item") {


    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->beginTransaction();
        $sql = "delete from dr where ref_no = '" . $_GET['referenceTxt'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into dr (ref_no,drf_no,cash_date,cus_code,cus_name,mar_code,mar_name,brand_code,brand_name,tar_code,tar_name,req_by,sample_check,des,wrk_code,wrk_name,s_qty,b_qty,length,width,height,uom,spe,con_path)values 
    ('" . $_GET['ref_no'] . "', '" . $_GET['drf_no'] . "', '" . $_GET['cash_date'] . "','" . $_GET['cus_code'] . "','" . $_GET['cus_name'] . "',  '" . $_GET['mak_code'] . "','" . $_GET['mak_name'] . "','" . $_GET['brand_code'] . "', '" . $_GET['brand_name'] . "','" . $_GET['tar_code'] . "','" . $_GET['tar_name'] . "', '" . $_GET['req_by'] . "','" . $_GET['sample_check'] . "','" . $_GET['des'] . "','" . $_GET['wrk_code'] . "','" . $_GET['wrk_name'] . "','" . $_GET['s_qty'] . "','" . $_GET['b_qty'] . "','" . $_GET['length'] . "','" . $_GET['width'] . "','" . $_GET['height'] . "','" . $_GET['uom'] . "','" . $_GET['spe'] . "','" . $_GET['con_path'] . "') ";

        $result = $conn->query($sql);

        $sql2 = "Select * from tmp_po_data where tmp_no='" . $_GET['tmpno'] . "'";
        foreach ($conn->query($sql2) as $row) {

            $sql1 = "Insert into qr_item(ref_no,r_no,des,qty)values 
   ('" . $_GET['ref_no'] . "','" . $row['r_no'] . "','" . $row['des'] . "','" . $row['qty'] . "') ";

            $result1 = $conn->query($sql1);
        }


        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>