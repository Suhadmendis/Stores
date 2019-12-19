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

    document.getElementById('codeTxt').value = "";
    document.getElementById('tsNoTxt').value = "";
    document.getElementById('gatePassTxt').value = "";
    document.getElementById('tStartTxt').value = "";
    document.getElementById('tFinishTxt').value = "";
    document.getElementById('dateForm').value = "";
    document.getElementById('dateTo').value = "";
    document.getElementById('driverNameTxt').value = "";
    document.getElementById('vehicleNoTxt').value = "";
    document.getElementById('driverContactTxt').value = "";
//    document.getElementById('radio1').value = "";
    document.getElementById('departFormCombo').value = "";
    document.getElementById('departToCombo').value = "";
    document.getElementById('remark').value = "";


    document.getElementById('plantNoTxt').value = "";
    document.getElementById('serialNoTxt').value = "";
    document.getElementById('morterNoTxt').value = "";

    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Tally_Sheet_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}



function assign_dt() {
    document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;

    XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
    document.form1.codeTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "Tally_Sheet_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    url = url + "&tmpno=" + document.getElementById('codeTxt').value;
    url = url + "&plantno=" + document.getElementById('plantNoTxt').value;
    url = url + "&serialno=" + document.getElementById('serialNoTxt').value;
    url = url + "&morterno=" + document.getElementById('morterNoTxt').value;


    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
//        document.getElementById('noTxt').value = XMLAddress1[0].childNodes[0].nodeValue;

//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
//        document.getElementById('gtot').value = XMLAddress1[0].childNodes[0].nodeValue;

//        document.getElementById('noTxt').value = "";
        document.getElementById('plantNoTxt').value = "";
        document.getElementById('serialNoTxt').value = "";
        document.getElementById('morterNoTxt').value = "";


        document.getElementById('plantNoTxt').focus();

    }
}


function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Tally_Sheet_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&plantno=" + cdate;
    url = url + "&invno=" + document.getElementById('codeTxt').value;
    url = url + "&tmpno=" + document.getElementById('codeTxt').value;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}




function getcode(cdata, cdata1, cdata2, cdata3, cdata4, cdata5) {


    document.getElementById('codeText').value = cdata;
    document.getElementById('pronameText').value = cdata1;
    document.getElementById('typeCombo').value = cdata2;
    document.getElementById('rateText').value = cdata3;
    document.getElementById('unitText').value = cdata4;
    document.getElementById('downPaymentText').value = cdata5;


    if (cdata6 == 'Y') {
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
    if (document.getElementById('tsNoTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Tally No Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('gatePassTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Gate Pass No  Not Enterd</span></div>";
        return false;
    }

    if (document.getElementById('tStartTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>T Start  Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('tFinishTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>T Finish Not Enterd</span></div>";
        return false;
    }

    if (document.getElementById('dateForm').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Date Form Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('dateTo').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Date To Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('driverNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Driver Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('vehicleNoTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Vehicle No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('driverContactTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Contact No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('departFormCombo').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Department Form  Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('departToCombo').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Department To Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('remark').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Remark Not Enterd</span></div>";
        return false;
    }


    var url = "Tally_Sheet_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('radio1').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }

    url = url + "&code=" + document.getElementById('codeTxt').value;
    url = url + "&tallyNo=" + document.getElementById('tsNoTxt').value;
    url = url + "&gatepass=" + document.getElementById('gatePassTxt').value;
    url = url + "&tstart=" + document.getElementById('tStartTxt').value;
    url = url + "&tfinish=" + document.getElementById('tFinishTxt').value;
    url = url + "&dateform=" + document.getElementById('dateForm').value;
    url = url + "&dateto=" + document.getElementById('dateTo').value;
    url = url + "&drivername=" + document.getElementById('driverNameTxt').value;
    url = url + "&vehicleno=" + document.getElementById('vehicleNoTxt').value;
    url = url + "&drivercontact=" + document.getElementById('driverContactTxt').value;
    
//    url = url + "&drivercontact=" + document.getElementById('radio1').checked;    
//    url = url + "&drivercontact=" + document.getElementById('radio2').checked;
    url = url + "&departform=" + document.getElementById('departFormCombo').value;
    url = url + "&departto=" + document.getElementById('departToCombo').value;
    url = url + "&remark=" + document.getElementById('remark').value;

    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&tmpno=" + document.getElementById('codeTxt').value;



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




