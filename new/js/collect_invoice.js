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

    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('itemdetails1').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";
    document.getElementById('c_code').value = "";
    document.getElementById('c_name').value = "";
    document.getElementById('tot').value = "";
    document.getElementById('invNo').value = "";

    getdt();
}

function searchCus(arg) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "collect_invoice_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&C_CODE=" + document.getElementById('c_code').value;
    url = url + "&arg=" + arg;

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
    document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;
    document.getElementById('itemdetails1').innerHTML = "";
    document.getElementById('tot').value = "";
}


function getcode(cdata) {


    document.getElementById('ll').value = cdata;
    window.scrollTo(0, 0);



}

function gen(cdata) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "collect_invoice_data.php";
    url = url + "?Command=" + "set";
    url = url + "&id=" + cdata;
    if (document.getElementById(cdata).checked == true) {
        url = url + "&stat=1";
    } else {
        url = url + "&stat=0";
    }

    url = url + "&tmpno=" + document.getElementById('c_code').value;

    xmlHttp.onreadystatechange = added_tmp;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function setInv(cdata1, cdata2) {
//    alert (cdata);
    document.getElementById("invNo").value = cdata1;
    document.getElementById("conDate").value = cdata2;
}

function added_tmp() {

    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tot");
        document.form1.tot.value = XMLAddress1[0].childNodes[0].nodeValue;

    }
}



function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
//            newent();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}


function save_inv(arg) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('invNo').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Plz Click Radio Button</span></div>";
        return false;
    }

    var url = "collect_invoice_data.php";
    url = url + "?Command=" + "save_item";

    url = url + "&invNo=" + document.getElementById('invNo').value;
    url = url + "&C_CODE=" + document.getElementById('c_code').value;
    url = url + "&conDate=" + document.getElementById('conDate').value;
    url = url + "&arg=" + arg;

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function cancel() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('invNo').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Plz Click Radio Button</span></div>";
        return false;
    }

    var url = "collect_invoice_data.php";
    url = url + "?Command=" + "cancel";

    url = url + "&con_ref=" + document.getElementById('invNo').value;
    url = url + "&C_CODE=" + document.getElementById('c_code').value;

    xmlHttp.onreadystatechange = cancel1;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function cancel1() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Cancel") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-danger' role='alert'><span class='center-block'>Cancel</span></div>";
//            newent();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}
