<?php session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href="admin_min.css" rel="stylesheet" type="text/css" media="screen" />



        <title>Search Customer</title>
        <link rel="stylesheet" href="css/table_min.css" type="text/css"/>
        <script language="JavaScript" src="js/search_item_gin_adv.js"></script>
        <style type="text/css">

            /* START CSS NEEDED ONLY IN DEMO */
            html{
                height:100%;
            }


            #mainContainer{
                width:700px;
                margin:0 auto;
                text-align:left;
                height:100%;
                background-color:#FFF;
                border-left:3px double #000;
                border-right:3px double #000;
            }
            #formContent{
                padding:5px;
            }
            /* END CSS ONLY NEEDED IN DEMO */


            /* Big box with list of options */
            #ajax_listOfOptions{
                position:absolute;	/* Never change this one */
                width:175px;	/* Width of box */
                height:250px;	/* Height of box */
                overflow:auto;	/* Scrolling features */
                border:1px solid #317082;	/* Dark green border */
                background-color:#FFF;	/* White background color */
                text-align:left;
                font-size:0.9em;
                z-index:100;
            }
            #ajax_listOfOptions div{	/* General rule for both .optionDiv and .optionDivSelected */
                margin:1px;		
                padding:1px;
                cursor:pointer;
                font-size:0.9em;
            }
            #ajax_listOfOptions .optionDiv{	/* Div for each item in list */

            }
            #ajax_listOfOptions .optionDivSelected{ /* Selected item in the list */
                background-color:#317082;
                color:#FFF;
            }
            #ajax_listOfOptions_iframe{
                background-color:#F00;
                position:absolute;
                z-index:5;
            }

            form{
                display:inline;
            }

            #article {font: 12pt Verdana, geneva, arial, sans-serif;  background: white; color: black; padding: 10pt 15pt 0 5pt}
        </style>


    </head>

    <body>

        <table width="735" border="0" class=\"form-matrix-table\">

            <tr>
                <td  background="" >&nbsp;</td>
                <td  background="" >
                    <?php
                        echo "<input type=\"checkbox\" name=\"checkbox\" id=\"checkbox\" onclick=\"update_item_list();\" />";
                    ?>	
                    Stock Item Only</td><td><input type="checkbox" name="chkProblem" id="chkProblem" onclick="update_item_list();"/> With Problematic</td>
                <tr>
                    <td><input type="text"  class="label_purchase" value="Item Code" disabled="disabled"/></td>
                    <td><input type="text"  class="label_purchase" value="Item Description" disabled="disabled"/></td>
                    <td><input type="text"  class="label_purchase" value="Brand" disabled="disabled"/></td>
                    <td><input type="text"  class="label_purchase" value="Part No" disabled="disabled"/></td>
                    <tr>
                        <?php
//                        if ($_GET["stname"] == "") {
                        $stname = $_GET["stname"];
                            echo "<td width=\"122\"  background=\"\" ><input type=\"text\" size=\"20\" name=\"itno\" id=\"itno\" value=\"\" class=\"txtbox\" onkeyup=\"update_item_list('$stname');\"/></td>
      <td width=\"603\"  background=\"\" ><input type=\"text\" size=\"70\" name=\"itemname\" id=\"itemname\" value=\"\" class=\"txtbox\" onkeyup=\"update_item_list('$stname');\"/></td>
	  <td width=\"122\"  background=\"\" ><input type=\"text\" size=\"20\" name=\"brand\" id=\"brand\" value=\"\" class=\"txtbox\" onkeyup=\"update_item_list('$stname');\"/></td>
	  <td width=\"122\"  background=\"\" ><input type=\"text\" size=\"10\" name=\"jobno\" id=\"jobno\" value=\"\" class=\"txtbox\" onkeyup=\"update_item_list('$stname');\"/></td>";
//                        } 
                        ?>  
                        </table>    
                        <div id="filt_table" class="CSSTableGenerator">  <table width="735" border="0" class=\"form-matrix-table\">
                                <tr>
                                    <td width="121"  background="" ><strong><font color="#FFFFFF">Item No</font></strong></td>
                                    <td width="424"  background=""><strong><font color="#FFFFFF">Item Description</font></strong></td>
                                    <td width="200"  background=""><strong><font color="#FFFFFF">Brand</font></strong></td>
                                    <td width="100"  background=""><strong><font color="#FFFFFF">Gen No</font></strong></td>
                                    <td width="80"  background=""><strong><font color="#FFFFFF">Substitute</font></strong></td>
                                    <td width="100"  background=""><strong><font color="#FFFFFF">Cost</font></strong></td>
                                    <td width="100"  background=""><strong><font color="#FFFFFF">Selling</font></strong></td>
                                    <td width="100"  background=""><strong><font color="#FFFFFF">Part No</font></strong></td>
                                    <td width="100"  background=""><strong><font color="#FFFFFF">Stock In Hand</font></strong></td>
                                    <?php
                                    if ($_GET["stname"] == "")
                                    echo "<td width='100'  background=''><strong><font color='#FFFFFF'>Stock Value</font></strong></td>";
                                    ?>        
                                </tr>
                                <?php
                                require_once("config.inc.php");
                                require_once("DBConnector.php");
                                $db = new DBConnector();


                                $_SESSION["stname"] = $_GET["stname"];


                                    $sql = "SELECT * from s_mas order by STK_NO limit 50";

                                    $result = $db->RunQuery($sql);

                                    while ($row = mysql_fetch_array($result)) {

                                            $brName = $row['BRAND_NAME'];
                                            $problemBrands = ($brName == 'Dag Customer' || $brName == 'Dag Custormer' || $brName == 'Dag CustomeDag Customerr' || $brName == 'Dag Sale' || $brName == 'Rebuild Customer' || $brName == 'rebuild sale');

                                        if (!($problemBrands && ($row['QTYINHAND'] == '0'))) {
                                            echo "<tr>               
                              <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['STK_NO'] . "</td>
                              <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['PART_NO'] . " " . $row['DESCRIPT'] . "</td>
							  <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['BRAND_NAME'] . "</td>
							  <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['GEN_NO'] . "</td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\">" . $row['SUBSTITUTE'] . "</td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\" align=right>" . number_format($row['COST'], 2, ".", ",") . "</td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\" align=right>" . number_format($row['SELLING'], 2, ".", ",") . "</td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\" align=left>" . $row['PART_NO'] . "</td>
							   <td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\" align=right>" . number_format($row['QTYINHAND'], 2, ".", "") . "</td>";
                                            if ($row['QTYINHAND'] > -1) {
                                                $stockValue = $row['COST'] * $row['QTYINHAND'];
                                                echo "<td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\" align=right>" . number_format($stockValue, 2, ".", "") . "</td>";
                                            } else {
                                                echo "<td onclick=\"itno('" . $row['STK_NO'] . "', '" . $_GET["stname"] . "');\" align=right></td>";
                                            }

                                            $department = $_SESSION["department"];

                                            /*  $sql1="select QTYINHAND from s_submas where STK_NO='".$row['STK_NO']."' AND STO_CODE='".$department."'";

                                              $result1 =$db->RunQuery($sql1);
                                              if($row1 = mysql_fetch_array($result1)){
                                              echo "<td onclick=\"itno('".$row['STK_NO']."');\">".$row1['QTYINHAND']."</a></td>";
                                              } else {
                                              echo "<td onclick=\"itno('".$row['STK_NO']."');\">0</a></td>";
                                              }
                                             */
                                        }
                                    }

                                    echo "</tr>";
                                ?>
                            </table>
                        </div>

                        </body>
                        </html>
