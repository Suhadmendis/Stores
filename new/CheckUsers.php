<?php

session_start();
date_default_timezone_set('Asia/Colombo');
$Command = "";

if (isset($_GET['Command'])) {

    $Command = $_GET["Command"];
    include './connection_sql.php';
}


if ($Command == "CheckUsers") {

    $ResponseXML = "";
    $ResponseXML .= "<salesdetails>";
    $UserName = $_GET["UserName"];
    $Password = $_GET["Password"];
//    $ResponseXML .= "<action><![CDATA[" . $_GET['action'] . "]]></action>";
//    $ResponseXML .= "<form><![CDATA[" . $_GET['form'] . "]]></form>";
    $sql = "SELECT * FROM user_mast WHERE user_name =  '" . $UserName . "' and password =  '" . $Password . "' ";
    $result = $conn->query($sql);

    if ($row = $result->fetch()) {
//        if (true) {

        $sessionId = session_id();
        $_SESSION['sessionId'] = session_id();
        session_regenerate_id();
        $ip = $_SERVER['REMOTE_ADDR'];
        $_SESSION['UserName'] = $UserName;
        /*
        $_SESSION["CURRENT_USER"] = $UserName;
        $_SESSION['User_Type'] = $row['dev'];

        if (is_null($row["sal_ex"]) == false) {
            $_SESSION["CURRENT_REP"] = $row["sal_ex"];
        } else {
            $_SESSION["CURRENT_REP"] = "";
        }
        $_SESSION['dev'] = $row["dev"];
        $_SESSION['COMCODE'] = $row["COMCODE"];
        $_SESSION['company'] = $row["COMCODE"];

        $salEx = $row['sal_ex'];
        if ($salEx > 0) {
            $_SESSION['salEx'] = $salEx;
        }
        */

        $action = "ok";
        $cookie_name = "user";
        $cookie_value = $UserName;
        //setcookie($cookie_name, $cookie_value, time() + (43200)); // 86400 = 1 day

        $token = substr(hash('sha512', mt_rand() . microtime()), 0, 50);
        $extime = time() + 43200;


        $domain = $_SERVER['HTTP_HOST'];

// set cookie

        setcookie('user', $cookie_value, $extime, "/", $domain);


        $ResponseXML .= "<stat><![CDATA[" . $action . "]]></stat>";
        echo $action;


        $time = mktime(date('h'), date('i'), date('s'));
        $time = date("g.i a");
        $today = date('Y-m-d');
    } else {
        $action = "not";
        $ResponseXML .= "<stat><![CDATA[" . $action . "]]></stat>";
        $ResponseXML .= "</salesdetails>";
        echo $ResponseXML;
    }
}



if ($_GET["Command"] == "save_inv") {


    $sql = "select * from user_mast where user_name='" . $_GET["user_name"] . "'";
    $result = $conn->query($sql);
    if ($row1 = $result->fetch()) {
        echo "User Found !!!";
    } else {
        $sql="insert into user_mast(user_name,user_depart, password) values ('".$_GET["user_name"]."', '".$_GET["user_depart"]."', '".$_GET["password"]."')";
        echo $sql;
        $result = $conn->query($sql);
        echo "Saved";
    }
}

if ($Command == "logout") {





    $today = date('Y-m-d');
    $domain = $_SERVER['HTTP_HOST'];
    setcookie('user', "", 1, "/", $domain);



    session_unset();
    session_destroy();
}
?>