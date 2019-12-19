<?php

/*
	include_once("config.inc.php");
	include_once("DBConnector.php");
	$letters = $_GET['letters'];
	
	$sql="SELECT * FROM mast_family where name like '".$letters."%'";
		$result =$db->RunQuery($sql);
			
			
			while($row = mysql_fetch_array($result))
			{
			
			echo $row["name"];
			
			}
			
		*/	
		
		
session_start();


	include_once("connection.php");

if ($_GET["Command"]=="save_bank"){
	
		//echo "insert into brand_mas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysql_query("delete from brand_mas_new where brand_name='".$_GET["barnd_name"]."'") or die(mysql_error()) or die(mysql_error());
		
		 
		$sql = mysql_query("insert into brand_mas_new(brand_name) values ('".$_GET["barnd_name"]."')") or die(mysql_error()) or die(mysql_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<table width=\"735\" border=\"1\"  cellspacing=\"0\" >
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
				 
   							</tr>";
                                      
									  $sql = mysql_query("select * from brand_mas_new") or die(mysql_error()) or die(mysql_error());
									
										while ($row = mysql_fetch_array($sql)){
											if ($row["brand_name"]!=""){
											$ResponseXML .= "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['brand_name']."', '".$row['id']."');\">".$row["id"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['brand_name']."', '".$row['id']."');\">".$row["brand_name"]."</td>
                                           		 </tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       echo $ResponseXML; 	
	
	
}

if ($_GET["Command"]=="setbrand"){
	
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	
	$ResponseXML = "";
	$ResponseXML .= "<salesdetails>";
	
	 $sql = mysql_query("select * from brand_mas_new where  brand_name='".$_GET["barnd_name"]."'") or die(mysql_error()) or die(mysql_error());
	 if ($row = mysql_fetch_array($sql)){
	 	 
	 }
	 
	 $ResponseXML .= "</salesdetails>";	
	 echo $ResponseXML;
										
}


if ($_GET["Command"]=="delete_bank"){
	
		//echo "insert into brand_mas(bcode, bbcode, bname, shname) values ('".$_GET["bcode"]."', '".$_GET["bbcode"]."', '".$_GET["bname"]."', '".$_GET["shname"]."')";
		$sql = mysql_query("delete from brand_mas_new where brand_name='".$_GET["barnd_name"]."'") or die(mysql_error()) or die(mysql_error());
	
	
	$ResponseXML = "";
	$ResponseXML .= "<table width=\"735\" border=\"1\"  cellspacing=\"0\" >
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
				 
   							</tr>";
                                      
									  $sql = mysql_query("select * from brand_mas_new") or die(mysql_error()) or die(mysql_error());
									
										while ($row = mysql_fetch_array($sql)){
											if ($row["brand_name"]!=""){
											$ResponseXML .=  "<tr>
                                            	<td width=\"155\" onclick=\"bankno('".$row['brand_name']."', '".$row['id']."');\">".$row["id"]."</td>
                                            	<td width=\"155\" onclick=\"bankno('".$row['brand_name']."', '".$row['id']."');\">".$row["brand_name"]."</td> 
                                          		</tr>";
												}
										}
										
										
                                          
                                       $ResponseXML .= " </table>";
                                       echo $ResponseXML; 	
	
	
}

if ($_GET["Command"]=="search_brand"){
	
	$ResponseXML .= "";
		//$ResponseXML .= "<invdetails>";
			
	
	
		$ResponseXML .= "<table width=\"735\" border=\"1\"  cellspacing=\"0\" >
                            <tr>
                              <td width=\"121\"  background=\"\" ><font color=\"#FFFFFF\">ID</font></td>
                              <td width=\"424\"  background=\"\"><font color=\"#FFFFFF\">Brand</font></td>
				 
   							</tr>";
                           
							
						   		$letters = $_GET['brand_name'];
								$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
								//$letters="/".$letters;
								
								//echo $a;
							$sql = mysql_query("SELECT * from brand_mas where brand_name like  '$letters%'") or die(mysql_error());
							while($row = mysql_fetch_array($sql)){
								
							$ResponseXML .= "<tr>
                           	  <td bgcolor=\"#222222\" onclick=\"bankno('".$row['brand_name']."', '".$row['id']."'</a></td>
                               <td bgcolor=\"#222222\" onclick=\"bankno('".$row['brand_name']."', '".$row['id']."'</a></td> 
                                                                            	
                            </tr>";
							}
							  
                    $ResponseXML .= "   </table>";
		
										
					echo $ResponseXML;
}

?>
