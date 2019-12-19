<?php

session_start();


require_once ("connection_sql.php");

header('Content-Type: text/xml');

date_default_timezone_set('Asia/Colombo');

if ($_GET["Command"] == "getdt") {
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

    $ResponseXML = "";
    $ResponseXML .= "<new>";
    $sql = "SELECT ref_no FROM invpara";
    $result = $conn->query($sql);
    $row = $result->fetch();
    $no = $row['ref_no'];
    $ResponseXML .= "<idd><![CDATA[$no]]></idd>";
    $ResponseXML .= "</new>";

    echo $ResponseXML;
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



if ($_GET["Command"] == "setitem") {
    header('Content-Type: text/xml');

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";


//    $sql = "delete from tem_por_data where ref_no='" . $_GET['ref_no'] . "' and tmp_no='" . $_GET['tmpno'] . "' ";
//    $result = $conn->query($sql);
    if ($_GET["Command1"] == "add_tmp") {

        $sql = "Insert into tem_por_data (code,des,qty,tmp_no)values 
			('" . $_GET['code'] . "', '" . $_GET['des'] . "', '" . $_GET['qty'] . "','" . $_GET['tmpno'] . "') ";
        $result = $conn->query($sql);
    }

    $ResponseXML .= "<sales_table><![CDATA[<table class=\"table\">
					<tr>
                                            <th style=\"width: 120px;\">No</th>
                                            <th style=\"width: 120px;\"> code</th>
                                            <th style=\"width: 120px;\"> Description</th>
                                            <th style=\"width: 120px;\">Qty</th>
                                            <th style=\"width: 100px;\"></th>
					</tr>";

    $i = 1;

    $sql = "Select * from tem_por_data where tmp_no='" . $_GET['tmpno'] . "'";
    foreach ($conn->query($sql) as $row) {

        $ResponseXML .= "<tr>                              
                             <td>" . $i . "</td>
                                                         <td>" . $row['code'] . "</td>   
							 <td>" . $row['des'] . "</td>
							 <td>" . $row['qty'] . "</td>
							 <td><a class=\"btn btn-danger btn-xs\" onClick=\"del_item('" . $row['code'] . "')\"> <span class='fa fa-remove'></span></a></td>
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
        $sql = "delete from po_req where ref_no = '" . $_GET['ref_no'] . "'";
        $result = $conn->query($sql);



        $sql = "Insert into po_req (ref_no,req_date,man_no,job_no,remark)values 
    ('" . $_GET['ref_no'] . "', '" . $_GET['req_date'] . "', '" . $_GET['man_no'] . "', '" . $_GET['job_no'] . "', '" . $_GET['remark'] . "') ";

        $result = $conn->query($sql);

        $sql2 = "Select * from tem_por_data where tmp_no='" . $_GET['tmpno'] . "'";
        foreach ($conn->query($sql2) as $row) {

            $sql1 = "Insert into por_item(ref_no,code,des,qty)values 
                ('" . $_GET['ref_no'] . "','" . $row['code'] . "','" . $row['des'] . "','" . $row['qty'] . "')";

            $result = $conn->query($sql1);
        }


        //stock minus

        $sql = "select * from tem_por_data where tmp_no = '" . $_GET['code'] . "'";

        foreach ($conn->query($sql) as $rowMenu) {

            $qty = $rowMenu["qty"];
            $val3 = number_format($qty, "2", ".", "");


            $sql1 = "update it_mas set qty=qty-" . $val3 . " where p_code='" . $rowMenu['code'] . "'";
            $conn->exec($sql1);


            $sql1 = "insert into por_item(ref_no,code,qty) values ('" . $rowMenu['ref_no'] . "', '" . $_GET['code'] . "',  '" . $val3 . "')";
            $conn->exec($sql1);
        }

        $sql = "SELECT ref_no FROM invpara";
        $resul = $conn->query($sql);
        $row = $resul->fetch();
        $no = $row['ref_no'];
        $no2 = $no + 1;
        $sql = "update invpara set ref_no = $no2 where ref_no = $no";
        $result = $conn->query($sql);

        $conn->commit();
        echo "Saved";
    } catch (Exception $e) {
        $conn->rollBack();
        echo $e;
    }
}
?>