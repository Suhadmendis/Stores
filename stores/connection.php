<?php




$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('acc', $dbacc);
mysql_select_db('ben', $dbinv);

/*

$hostname = 'localhost';
$username = 'root';
$password = '';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

mysql_select_db('acc', $dbacc);
mysql_select_db('tht', $dbinv);	*/



$hostname = 'localhost';
$username = 'lotterix_admin';
$password = 'shan@123';

$dbacc = mysql_connect($hostname, $username, $password);
$dbinv = mysql_connect($hostname, $username, $password, true);

//mysql_select_db('lotterix_accben', $dbacc);
//mysql_select_db('lotterix_ben', $dbinv);

mysql_select_db('lotterix_ben', $dbinv);


?>
