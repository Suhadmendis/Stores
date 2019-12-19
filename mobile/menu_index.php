<?php session_start(); ?>
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
                                        <li><a href="sales_ord_new.php"  target="_blank" ><span><span>
   Sales Order</span></span></a></li>
                                        <li><a href="bin_card.php"  target="_blank" ><span><span>
   Bin Card</span></span></a></li>
   										<li><a href="weekly_target.php"  target="_blank" ><span><span>
   Weekly Target</span></span></a></li>
                                        <li><a href="rep_outstanding.php" target="_blank" ><span><span>Outstanding</span></span></a></li>
                                        <li><a href="rep_ret_chq.php" target="_blank" ><span><span>Return Cheque</span></span></a></li>
                                        <li><a href="rep_customer_current.php" target="_blank" ><span><span>Customer Current Status</span></span></a></li>
                                        <li><a href="sales_register.php" target="_blank" ><span><span>Sales Register</span></span></a></li>
									<?php
									
									if ((strtoupper($_SESSION["CURRENT_USER"])=="ERROL") or (strtoupper($_SESSION["CURRENT_USER"])=="ERROL1")or (strtoupper($_SESSION["CURRENT_USER"])=="ERROL_TMP")or (strtoupper($_SESSION["CURRENT_USER"])=="GAYAL")){
                                        echo "<li><a href=\"over_limit.php\" target=\"_blank\" ><span><span>Limit Exceed</span></span></a></li>";
									}
									?>	

                                       
                       
                        <li class="last" onclick="logout();"><a href="#"><span><span>Logout</span></span></a></li>
					</ul>
				</div>
				
				
				
				<div id="sec_menu">
					<ul>
						<li></li>
						<li></li>
						<li><a href="#" class="sm3">&nbsp;</a></li>
					
					
					
						
						
					</ul>
				</div>
			</div>