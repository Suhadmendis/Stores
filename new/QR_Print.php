<?php session_start();
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Report KOT ENTRY</title>


    <style>
        @media print {
            a[href]:after {
                content: none !important;
            }
        }
        a:link, a:visited {

            text-decoration: none;
            color:#000000;
        }


        a:hover {
            text-decoration: underline;
        }
        body {
            color: #333;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 10px;
            line-height: 1.32857;
        }
        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            border-top:2px solid #DDDDDD;
            line-height:1.2857;
            padding:1.5px;

            vertical-align:top;
        }
        .right {
            text-align: right;
        }   
        .left {
            text-align: left;
        }  
        .left {
            text-align: left;
        }
        .table1 {
            border-collapse: collapse;
            border: 1px;
        }
        .table1, td, th {

            font-family: Arial, Helvetica, sans-serif;
            padding: 5px;

        }
        .table1 th {
            font-weight: bold;
            font-size: 12px;
        }
        .table1 td {
            font-size: 12px;
        }
        .horizontal_dotted_line{
            border-bottom: 1px dotted black;
            width: 100px;
        }

        p.solid {border-style: solid;}

    </style>
</head>



<body> 
    <?php
    require_once ("./connection_sql.php");

    date_default_timezone_set("Asia/Colombo");
    if ($_GET["Command"] == "print") {

        $table = "";



        $table .= "<table   style='width: 1200px;' class='table1'>
            <tr>
                 <th class='bottom head' colspan='3'>Crymson</th> 
            </tr>
            
            <tr>
                 <th class='bottom head' colspan='3'>Tel : 0114768000 Fax : 114768010</th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'></th> 
            </tr>
            <tr>
                 <th class='bottom head' colspan='3'>Quotation Requisition Form</th> 
            </tr>
              </table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> </th>
                        <th style='width: 60px;' class='left'>" . $_GET[''] . "</th>  
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>
                   </tr></table>";


        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> </th>
                        <th style='width: 60px;' class='left'>" . $_GET[''] . "</th>  
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> </th>
                        <th style='width: 60px;' class='left'>" . $_GET[''] . "</th>  
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 50px;' class='left'>" . $_GET[''] . "</th>
                   </tr></table>";




        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Reference No :</th>
                        <th style='width: 60px;' class='left'>" . $_GET['ref_no'] . "</th>  
                        <th style='width: 10px;' class='left'>Date :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['t_date'] . "</th>
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> DRF No :</th>
                        <th style='width: 60px;' class='left p solid'>" . $_GET['drf_no'] . "</th> 
                        <th style='width: 10px;' class='left'> Required By :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['req_date'] . "</th> 
                   </tr></table>";


        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>Customer  Code:</th>
                        <th style='width: 50px;' class='left'>" . $_GET['cus_code'] . "</th>  
                        <th style='width: 10px;' class='left'>Customer Name:</th>
                        <th style='width: 50px;' class='left'>" . $_GET['cus_name'] . "</th>  
               
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'> Marketing Ex Code :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['mak_code'] . "</th>  
                        <th style='width: 10px;' class='left'>Marketing Ex Name :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['mak_name'] . "</th>  
                   </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Attention :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['attention'] . "</th> 
                            <th style='width: 10px;' class='left'>  CC :</th>
                        <th style='width: 60px;' class='left'>" . $_GET['cc'] . "</th>
                         </tr></table>";

        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Brand Code :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['brand_code'] . "</th>  
                            <th style='width: 10px;' class='left'>  Brand Name :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['brand_name'] . "</th>  
                         </tr></table>";



        $table .= "<table style='width: 660px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                        <th style='width: 10px;' class='left'>  Payment Term :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['pay_term'] . "</th> 
                            <th style='width: 10px;' class='left'>Remarks :</th>
                        <th style='width: 50px;' class='left'>" . $_GET['remarks'] . "</th>  
                        
                         </tr></table>";






        $table .= "<table style='width: 1000px;' class='table1'><tr>
                        <th style='width: 10px;' class='left'></th>
                                               
                   </tr></table>";

        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";
        
        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";

        $table .= "<table class='table' >	
      	<tr>
                        <th style='width: 100px;' class='left'>No</th>     
                        <th style='width: 100px;' class='left'>Meal Type</th>      
                        <th style='width: 100px;' class='left'>Item Code</th>                        
                        <th style='width: 100px;' class='left'>Description</th>
                        <th style='width: 100px;' class='left'>Qty</th>
                        
        </tr>";

        $i = 0;
        $tot = 0;
        $sql3 = "select * from qr_item  where ref_no = '" . $_GET['ref_no'] . "'";

        foreach ($conn->query($sql3) as $row) {
            $i = $i + 1;

            $table .= "<tr>";

            $table .= "<td>" . $i . "</td>";
            $table .= "<td>" . $row['ref_no'] . "</td>";
            $table .= "<td>" . $row['r_no'] . "</td>";
            $table .= "<td>" . $row['des'] . "</td>";
            $table .= "<td>" . $row['qty'] . "</td>";

            $table .= "</tr>";
        }


        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";



        $table .= "<table class='table1' ><tr>
                                
                        <th style='width: 100px;' class='left'></th>                        
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
                        <th style='width: 100px;' class='left'></th>
	
                    </tr></table>";






        echo $table;
    }
    ?>
