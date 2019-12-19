function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function keyset(key, e) {

    if (e.keyCode == 13) {
        document.getElementById(key).focus();
    }
}

function got_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000066";

}

function lost_focus(key) {
    document.getElementById(key).style.backgroundColor = "#000000";

}

function newent() {

    document.getElementById('refTxt').value = "";
    document.getElementById('dateTxt').value = "";
    document.getElementById('drfTxt').value = "";
    document.getElementById('mrExCodeTxt').value = "";
    document.getElementById('mrExNameTxt').value = "";
    document.getElementById('cusCodeTxt').value = "";


    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "DA_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
//    document.getElementById('item_details').innerHTML = xmlHttp.responseText;
}


function getcode(cdata, cdata1, cdata2) {


    document.getElementById('areaCodeTxt').value = cdata;
    document.getElementById('areaNameTxt').value = cdata1;
    document.getElementById('mileageTxt').value = cdata2;



}


function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('refTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Reference No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('dateTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Date Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('drfTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>DRF No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('mrExCodeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Mar Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('mrExNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Mar Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('cusCodeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('cusNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('proDesTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Product Description Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('wrkPathTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Work Path Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('conPathTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Concept Path Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('cosPathTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Costing & Specification Path Not Enterd</span></div>";
        return false;
    }


    var url = "DA_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&ref_no=" + document.getElementById('refTxt').value;
    url = url + "&da_date=" + document.getElementById('dateTxt').value;
    url = url + "&cus_code=" + document.getElementById('cusCodeTxt').value;
    url = url + "&cus_name=" + document.getElementById('cusNameTxt').value;
    url = url + "&mar_code=" + document.getElementById('mrExCodeTxt').value;
    url = url + "&mar_name=" + document.getElementById('mrExNameTxt').value;
    url = url + "&pro_des=" + document.getElementById('proDesTxt').value;
    url = url + "&wrk_path=" + document.getElementById('wrkPathTxt').value;
    url = url + "&con_path=" + document.getElementById('conPathTxt').value;
    url = url + "&cos_path=" + document.getElementById('cosPathTxt').value;


    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            newent();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}










