<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>AR Report</title>

        <style>
            table
            {
                border-collapse:collapse;
            }
            table, td, th
            {

                font-family:Arial, Helvetica, sans-serif;
                padding:5px;
            }
            th
            {
                font-weight:bold;
                font-size:14px;

            }
            td
            {
                font-size:13px;

            }
        </style>
        <style type="text/css">
            <!--
            .style1 {
                color: #0000FF;
                font-weight: bold;
                font-size: 24px;
            }
            -->
        </style>
    </head>

    <body> 

        <?php
        require_once("config.inc.php");
        require_once("DBConnector.php");
        $db = new DBConnector();









        $sql_head = "select * from invpara";
        $result_head = $db->RunQuery($sql_head);
        $row_head = mysql_fetch_array($result_head);

        echo "<center><span class=\"style1\">" . $row_head["COMPANY"] . "</span></center><br>";

        $heading = "<center>AR Report From  " . $_GET["DT1"] . " To ". $_GET["DT2"] . " <br><br>";
        echo $heading;
        
        if($_GET['cuscode']==""){
        $sql = "SELECT SDATE, REFNO, SUP_CODE, SUP_NAME, brand_name,LCNO,sum(COST*REC_QTY) as COST from viewpur where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0  ";
        }else{
        $sql = "SELECT SDATE, REFNO, SUP_CODE, SUP_NAME, brand_name,LCNO,sum(COST*REC_QTY) as COST from viewpur where SDATE>='" . $_GET["DT1"] . "' AND SDATE<='" . $_GET["DT2"] . "'   AND cancel=0  and SUP_CODE = '".$_GET['cuscode']."'";
        }
        if ($_GET["cmbcom"] != "All") {
        $sql .=" and refno like '".$_GET['cmbcom']."%'";    
        }
        if ($_GET["cmbcat"] != "All") {
        $sql .=" and type ='" . $_GET["cmbcat"] . "'";
        }
        $sql .="  group by SDATE,REFNO,brand_name,LCNO order by REFNO ";
        $result = $db->RunQuery($sql);
        echo "<table border='1' width=1000 ><tr> <td><b>DATE</td> <td><b>AR NO</td> <td><b>SUPPLIER</td> <td><b>LC NO</td><td><b>BRAND NAME</td><td><b>AMOUNT WITHOUT VAT</b></td><td><b>VAT</b></td><td><b>AMOUNT WITH VAT</b></td></tr>";
		$company="";
        if($_GET["cmbcom"] != "All"){
            echo "<tr> <td colspan=6><b>Company ".$_GET["cmbcom"]."</b></td></tr>";
        }
        while ($row = mysql_fetch_array($result)) {
                if($_GET["cmbcom"] == "All"){
			if ($company!=substr($row['REFNO'], 0, 1)){
				if (substr($row['REFNO'], 0, 1)=="A"){      
					echo "<tr> <td colspan=6><b>Company A</b></td></tr>";	
				} else 	if (substr($row['REFNO'], 0, 1)=="B"){      
					echo "<tr> <td colspan=6><b>Company B</b></td></tr>";	
				} else if (substr($row['REFNO'], 0, 1)=="C"){      
					echo "<tr> <td colspan=6><b>Company C</b></td></tr>";	
				}		
				$company=substr($row['REFNO'], 0, 1);
			}
                }else{
                    $company=substr($row['REFNO'], 0, 1);
                }
			if (substr($row['REFNO'], 0, 1)=="A"){ 		
        		echo "<tr> <td>" . $row['SDATE'] . "</td> <td>" . $row['REFNO'] . "</td> <td>".$row['SUP_NAME']. " - ".$row['SUP_CODE']. "</td> <td>" . $row['LCNO'] . "</td>  <td>" . $row['brand_name'] . "</td> <td  align='right'> " . number_format(($row['COST']/111*100), "2",".",",") . "</td><td  align='right'> " . number_format(($row['COST']*0.11), "2",".",",") . "</td> <td  align='right'> " . number_format($row['COST'], "2",".",",") . "</td>    </tr>";
			} else {
				echo "<tr> <td>" . $row['SDATE'] . "</td> <td>" . $row['REFNO'] . "</td> <td>".$row['SUP_NAME']. " - ".$row['SUP_CODE']. "</td> <td>" . $row['LCNO'] . "</td>  <td>" . $row['brand_name'] . "</td><td>" . $row['brand_name'] . "</td><td></td>  <td  align='right'> " . number_format($row['COST'], "2",".",",") . "</td>    </tr>";
			}
        $cos = $cos+($row['COST']);
         
        }
        
 echo "<tr> <td></td> <td></td> <td></td>  <td></td><td></td><td></td><td></td>  <td align='right'><b>" . number_format($cos, "2",".",",")   . "</td>    </tr>";

        echo "</table><br>";
        ?>



    </body>
</html>
