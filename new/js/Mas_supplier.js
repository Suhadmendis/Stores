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

    document.getElementById('supCTxt').value = "";
    document.getElementById('supNTxt').value = "";
    document.getElementById('supATxt').value = "";
    document.getElementById('supTelTxt').value = "";
    document.getElementById('supFaxTxt').value = "";
    document.getElementById('supMobTxt').value = "";
    document.getElementById('supWebTxt').value = "";
    document.getElementById('supEmailTxt').value = "";
    document.getElementById('statusTxt').value = "";
    document.getElementById('supACTxt').value = "";
    document.getElementById('addACTxt').value = "";
    document.getElementById('gainACTxt').value = "";
    document.getElementById('conPerTxt').value = "";
    document.getElementById('conTelTxt').value = "";
    document.getElementById('conAddTxt').value = "";
    document.getElementById('conFaxTxt').value = "";
    document.getElementById('conEmailTxt').value = "";
    document.getElementById('supGrupTxt').value = "";
    document.getElementById('crePerTxt').value = "";
    document.getElementById('creLimtTxt').value = "";

    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Mas_supplier_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
   // document.getElementById('item_details').innerHTML = xmlHttp.responseText;
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

//    if (document.getElementById('areaCodeTxt').value == "") {
//        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Code Not Enterd</span></div>";
//        return false;
//    }
//    if (document.getElementById('areaNameTxt').value == "") {
//        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Suppplier Name Not Selected</span></div>";
//        return false;
//    }
//    if (document.getElementById('mileageTxt').value == "") {
//        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Address Not Enterd</span></div>";
//        return false;
//    }
//    


    var url = "Mas_supplier_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&sup_code=" + document.getElementById('supCTxt').value;
    url = url + "&sup_name=" + document.getElementById('supNTxt').value;
    url = url + "&sup_add=" + document.getElementById('supATxt').value;
    url = url + "&sup_tel=" + document.getElementById('supTelTxt').value;
    url = url + "&sup_fax=" + document.getElementById('supFaxTxt').value;
    url = url + "&sup_mob=" + document.getElementById('supMobTxt').value;
    url = url + "&sup_web=" + document.getElementById('supWebTxt').value;
    url = url + "&sup_email=" + document.getElementById('supEmailTxt').value;
    url = url + "&sup_status=" + document.getElementById('statusTxt').value;
    url = url + "&sup_ac=" + document.getElementById('supACTxt').value;
    url = url + "&sup_adv=" + document.getElementById('addACTxt').value;
    url = url + "&sup_gain=" + document.getElementById('gainACTxt').value;

    url = url + "&con_per=" + document.getElementById('conPerTxt').value;
    url = url + "&con_tel=" + document.getElementById('conTelTxt').value;
    url = url + "&con_add=" + document.getElementById('conAddTxt').value;
    url = url + "&con_fax=" + document.getElementById('conFaxTxt').value;
    url = url + "&con_email=" + document.getElementById('conEmailTxt').value;

    url = url + "&sup_group=" + document.getElementById('supGrupTxt').value;

    url = url + "&per_txt=" + document.getElementById('crePerTxt').value;
    url = url + "&limit_txt=" + document.getElementById('creLimtTxt').value;



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










