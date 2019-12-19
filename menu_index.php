
<script src="js/user.js"></script>
<?php
require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();
?>
<div id="menus_wrapper">





    <div id="main_menu">
        <ul>
            <li><a href="home.php" class="selected"><span><span>Home</span></span></a></li>
            <?php
            echo $sql;
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Master Files' and doc_view=1";
            $result = $db->RunQuery($sql);

            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"masterfiles.php\"  ><span><span>Master Files</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Data Capture' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"datacapture.php\"><span><span>Data Capture</span></span></a></li>";
            }
            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Costing' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Costing</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inquiries' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"inquiry.php\"><span><span>Inquiries</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Analysis' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Analysis</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Delivery' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"#\"><span><span>Delivery</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and (grp='Reports-Sales' or grp='Reports-Customer' or grp='Reports-Other' or grp='Reports-Stock') and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"reports.php\"><span><span>Reports</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='System Utilities' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"utility.php\"><span><span>System Utilities</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Stores' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"stores.php\"><span><span>Stores</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Administration' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"administration.php\"><span><span>Administration</span></span></a></li>";
            }

            $sql = "select * from userpermission where username='" . $_SESSION['UserName'] . "' and grp='Inventory' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"inventory.php\"><span><span>Inventory</span></span></a></li>";
            }
            ?>	
            <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
        </ul>
    </div>



    <div id="sec_menu">
        <ul>
          
            <?php
            
            
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Sales Invoice' and grp='Data Capture' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                
//                echo "<li><a href=\"new/home.php?url=inv\" target=\"_blank\" class=\"sm5\">Sales Invoice</a></li>";
//                echo "<li><a href=\"new/home.php?url=vieword\" target=\"_blank\" class=\"sm5\">CNSLTD INV</a></li>";
                
                echo "<li>
                        <span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">INVOICING</a></span></span></span>
                        <ul>";
                        echo "<li><a class=\"sm6\" href=\"new/home.php?url=inv\" target=\"_blank\">Sales Invoice</a></li>";
                        echo "<li><a class=\"sm6\" href=\"new/home.php?url=inv_drc\" target=\"_blank\">Direct Sales Invoice</a></li>";
                        echo "<li><a class=\"sm6\" href=\"new/home.php?url=vieword\" target=\"_blank\">Consolidated Invoice</a></li>";
                echo "</ul>
                </li>";                
            }
            
            
           
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Stock Report' and grp='Reports-Stock' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"serach_item.php\" target=\"_blank\" class=\"sm1\">Stock</a></li>";
            }            
            
            $sql = "select * from view_userpermission where username='" . $_SESSION['UserName'] . "' and docname='Outstanding Report' and grp='Reports-Sales' and doc_view=1";
            $result = $db->RunQuery($sql);
            if ($row = mysql_fetch_array($result)) {
                echo "<li><a href=\"rep_outstanding.php\" target=\"_blank\" class=\"sm1\">Outstanding</a></li>";
            } 
            $db = null;
            
            echo "<li><a href=\"new/home.php?url=costing\" target=\"_blank\" class=\"sm5\">Costing</a></li>";
            echo "<li><a href=\"new/home.php?url=POReq\" target=\"_blank\" class=\"sm5\">PO Requisition</a></li>";
            echo "<li><a href=\"new/home.php?url=Stc_PurO_E\" target=\"_blank\" class=\"sm5\">PO</a></li>";
            echo "<li><a href=\"new/home.php?url=qttn\" target=\"_blank\" class=\"sm5\">QTN</a></li>";
            echo "<li><a href=\"new\home.php?url=job_request\" target=\"_blank\" class=\"sm5\" >JRQ</a></li>";
            echo "<li><a href=\"new/home.php?url=job_mas\" target=\"_blank\" class=\"sm5\">JOB</a></li>";
            
            
//            $sql1="select * from view_userpermission where username='".$_SESSION['UserName']."' and grp='AR and Orders' and doc_view=1";
//            $result1 =$db->RunQuery($sql1);	
//            if ($row1 = mysql_fetch_array($result1)){	
            if (true){	

                     echo "<li>
                            <span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">MRN</a></span></span></span>
                            <ul>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_mrn\" target=\"_blank\">MRN</a></li>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_mrn_x\" target=\"_blank\">MRN_EX</a></li>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_mrn_is\" target=\"_blank\">MRN_IS</a></li>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_mrn_gn\" target=\"_blank\">MRN_GN</a></li>";
                    echo "</ul>
                    </li>";	
            }            
            if (true){	

                     echo "<li>
                            <span class=\"drop\"><span><span><a href=\"#\" class=\"sm1\">MIN</a></span></span></span>
                            <ul>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_nt\" target=\"_blank\">MIN</a></li>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_is\" target=\"_blank\">MIN_IS</a></li>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_is_ut\" target=\"_blank\">MIN_IS_UT</a></li>";
                            echo "<li><a class=\"sm6\" href=\"new/home.php?url=gin_nt_gnrl\" target=\"_blank\">MIN General</a></li>";
                    echo "</ul>
                    </li>";	
            }            
            
            echo "<li><a href=\"new/home.php?url=gin_nt_fg\" target=\"_blank\" class=\"sm5\">FG Transfer</a></li>";
            echo "<li><a href=\"new/home.php?url=gin_dpt\" target=\"_blank\" class=\"sm5\">Dispatch</a></li>";
            echo "<li><a href=\"new/home.php?url=gin_nt_gnrl_1\" target=\"_blank\" class=\"sm5\">DRCT SL RQST</a></li>";
            
            ?>
          
            




        </ul>
    </div>
</div>