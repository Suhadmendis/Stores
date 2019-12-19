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

    document.getElementById('refNoTxt').value = "";
    document.getElementById('dateTxt').value = "";
    document.getElementById('manNoTxt').value = "";
    document.getElementById('jobNoTxt').value = "";
    document.getElementById('remarkTxt').value = "";

    document.getElementById('pCTxt').value = "";
    document.getElementById('pDTxt').value = "";
    document.getElementById('qtyTxt').value = "";
//    document.getElementById('uomTxt').value = "";

    document.getElementById('itemdetails').innerHTML = "";

    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "POReq_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("idd");
        document.form1.refNoTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

    }
}

function print() {

    var url = "POReq_Print.php";
    url = url + "?Command=" + "print";

    url = url + "&ref_no=" + document.getElementById('refNoTxt').value;
    url = url + "&req_date=" + document.getElementById('dateTxt').value;
    url = url + "&man_no=" + document.getElementById('manNoTxt').value;
    url = url + "&job_no=" + document.getElementById('jobNoTxt').value;
    url = url + "&remark=" + document.getElementById('remarkTxt').value;


    window.open(url, "_blank")

}



function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "POReq_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    url = url + "&tmpno=" + document.getElementById('refNoTxt').value;

    url = url + "&code=" + document.getElementById('pCTxt').value;
    url = url + "&des=" + document.getElementById('pDTxt').value;
    url = url + "&qty=" + document.getElementById('qtyTxt').value;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('pCTxt').value = "";
        document.getElementById('pDTxt').value = "";
        document.getElementById('qtyTxt').value = "";

        document.getElementById('qtyTxt').focus();

    }
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



    var url = "POReq_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&ref_no=" + document.getElementById('refNoTxt').value;
    url = url + "&tmpno=" + document.getElementById('refNoTxt').value;
    url = url + "&req_date=" + document.getElementById('dateTxt').value;
    url = url + "&man_no=" + document.getElementById('manNoTxt').value;
    url = url + "&job_no=" + document.getElementById('jobNoTxt').value;
    url = url + "&remark=" + document.getElementById('remarkTxt').value;



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










