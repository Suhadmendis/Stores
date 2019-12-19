<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */





require_once("config.inc.php");
require_once("DBConnector.php");
$db = new DBConnector();

$sqlt = "select * from  s_sttr order by id desc";
$result1 = $db->RunQuery($sqlt);

while ($rssalma = mysql_fetch_array($result1)) {

    $srefno = str_replace("\\", "-", $rssalma['ST_INVONO']);

    echo $srefno . '-' . $rssalma['ST_INVONO'];

    $sql = "update s_sttr set st_invono = '" . $srefno . "' where st_invono= '" . $rssalma['ID'] . "'";
    $resultp =$db->RunQuery($sqlt);
}
?>

