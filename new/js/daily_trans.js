/* global google */

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

function mm() {

//    document.getElementById('codeTxt').value = "";
//    document.getElementById('descriptionTxt').value = "";
//    document.getElementById('catCombo').value = "";
//    document.getElementById('latitudeTxt').value = "";
//    document.getElementById('longitudeTxt').value = "";

    getdt();
}

//function getdt() {
//
//    xmlHttp = GetXmlHttpObject();
//    if (xmlHttp == null) {
//        alert("Browser does not support HTTP Request");
//        return;
//    }
//
//    var url = "daily_trans_report_data.php";
//    url = url + "?Command=" + "getdt";
//    url = url + "&ls=" + "new";
//
//    xmlHttp.onreadystatechange = assign_dt;
//    xmlHttp.open("GET", url, true);
//    xmlHttp.send(null);
//
//}
function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "daily_trans_report_data.php";
    url = url + "?Command=" + "getdt";
   // url = url + "&ls=" + "new";
   url = url + "&month=" + document.getElementById('month').value;
  
   

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
    document.getElementById('item_details').innerHTML = xmlHttp.responseText;
}


function getcode(cdata, cdata1, cdata2, cdata3, cdata4) {


    document.getElementById('codeTxt').value = cdata;
    document.getElementById('descriptionTxt').value = cdata1;
    document.getElementById('catCombo').value = cdata2;
    document.getElementById('latitudeTxt').value = cdata3;
    document.getElementById('longitudeTxt').value = cdata4;



    if (cdata3 == 'Y') {
        document.getElementById('active').checked = true;
    } else {
        document.getElementById('active').checked = false;
    }
    window.scrollTo(0, 0);

}


function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('codeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('catCombo').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Category Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('descriptionTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Description Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('latitudeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Latitude Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('longitudeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Longitude Not Enterd</span></div>";
        return false;
    }



    var url = "Ass_Ward_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&code=" + document.getElementById('codeTxt').value;
    url = url + "&description=" + document.getElementById('descriptionTxt').value;
    url = url + "&catergory=" + document.getElementById('catCombo').value;
    url = url + "&latitude=" + document.getElementById('latitudeTxt').value;
    url = url + "&longitude=" + document.getElementById('longitudeTxt').value;



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
