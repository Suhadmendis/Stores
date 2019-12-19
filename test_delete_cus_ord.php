<?php

include('connection_server.php');
	
	$REF_NO="";
	$sql="select * from s_cusordmas where SDATE='2014-04-05' order by REF_NO";
	echo $sql;
	$result=mysql_query($sql, $dbtht);
	while ($row = mysql_fetch_array($result)){
		if ($REF_NO != $row["REF_NO"]){
			$REF_NO = $row["REF_NO"];
		} else {
			$sql="delete from s_cusordmas where id=".$row["id"];
			$result=mysql_query($sql, $dbtht);
		}
	}
	
	
	

?>