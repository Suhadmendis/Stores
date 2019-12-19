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

    document.getElementById('code_txt').value = "";
    document.getElementById('name_txt').value = "";
    document.getElementById('add_txt').value = "";
    document.getElementById('tel_txt').value = "";
    document.getElementById('fax_txt').value = "";
    document.getElementById('email_txt').value = "";
    document.getElementById('conPer_txt').value = "";


    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Mas_borrower_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
    document.getElementById('item_details').innerHTML = xmlHttp.responseText;
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

    if (document.getElementById('code_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('name_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('add_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Address Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('tel_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('fax_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('email_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('conPer_txt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Address Not Enterd</span></div>";
        return false;
    }





    var url = "Mas_borrower_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&b_code=" + document.getElementById('code_txt').value;
    url = url + "&b_name=" + document.getElementById('name_txt').value;
    url = url + "&b_add=" + document.getElementById('add_txt').value;
    url = url + "&b_tel=" + document.getElementById('tel_txt').value;
    url = url + "&b_fax=" + document.getElementById('fax_txt').value;
    url = url + "&b_email=" + document.getElementById('email_txt').value;
    url = url + "&b_conPerson=" + document.getElementById('conPer_txt').value;



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










