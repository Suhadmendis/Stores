<?php

session_start();
date_default_timezone_set('Asia/Colombo');
require_once ("connectioni.php");

//print_r($_FILES['file']);

$target_dir = "uploads/";


$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$mok = "no";
//while ($mok == "ok") {
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $mok = "ok";
} else {
    $mok = "ok";
}
//}
if ($mok == "ok") {

    if (file_exists($_FILES["file"]["tmp_name"])) {
        $lastmod = date("F d Y g:i:s A", filemtime($_FILES["file"]["tmp_name"]));
    }

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $sql = "insert into docs (loc,ref_no,file_name,c_date) values ('" . $target_file . "','". $_POST['refno'] ."','" . basename($_FILES["file"]["name"]) . "', '" . date("Y-m-d H:i:s") . "')";
    $result = mysqli_query($GLOBALS['dbinv'], $sql);
}