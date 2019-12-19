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

    document.getElementById('cusCodeTxt').value = "";
    document.getElementById('cusNameTxt').value = "";
    document.getElementById('telTxt').value = "";

    document.getElementById('addressTxt').value = "";
    document.getElementById('faxTxt').value = "";
    document.getElementById('emailTxt').value = "";
    document.getElementById('mobNotxt').value = "";
    document.getElementById('idNoTxt').value = "";

    document.getElementById('birthTxt').value = "";
    document.getElementById('acCodeTxt').value = "";
    document.getElementById('statusTxt').value = "";

    document.getElementById('advancedACCode').value = "";
    document.getElementById('gainTxt').value = "";
    document.getElementById('contactNameTxt').value = "";

    document.getElementById('contactTelTxt').value = "";
    document.getElementById('contactAdressTxt').value = "";
    document.getElementById('contactFaxTxt').value = "";
    document.getElementById('contactEmailTxt').value = "";
    //document.getElementById('propertyNameTxt').value = "";

    document.getElementById('deliNameTxt').value = "";
    document.getElementById('deliAddTxt').value = "";
    document.getElementById('deliTelTxt').value = "";
    document.getElementById('deliFaxTxt').value = "";
    document.getElementById('deliEmailTxt').value = "";

    document.getElementById('creditTxt').value = "";
    document.getElementById('limitTxt').value = "";

    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "CussMas_data.php";
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


    document.getElementById('codeTxt').value = cdata;
    document.getElementById('catCombo').value = cdata1;
    document.getElementById('descriptionTxt').value = cdata2;


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

    if (document.getElementById('cusCodeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('cusNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('telTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Telephone Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('addressTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Address Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('faxTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Fax No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('emailTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Email Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('mobNotxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Mobile No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('idNoTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> ID NO Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('birthTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Birth Day Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('acCodeTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer A/C Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('statusTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Status Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('advancedACCode').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>  Advanced A/C Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('gainTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Gain/Loss/A/C NO Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('contactNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Contact Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('contactTelTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Contact Tel No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('contactAdressTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Contact Address Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('contactFaxTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>  Contact Fax Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('contactEmailTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Contact Email Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('gropCodeTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Group Code No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('groupNameTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Group Name Address Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('areaCodeTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>   Area Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('areaNameTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Area Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('refCodeTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Ref Code No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('refNameTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Ref Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('segCodeTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>   Seg Code Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('segNameTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Seg Name  Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('deliNameTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Delivery Name Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('deliAddTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Delivery Code No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('deliTelTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Delivery Telephone Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('deliFaxTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>   Delivery Fax Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('deliEmailTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Delivery Fax  Not Enterd</span></div>";
        return false;
    }

    if (document.getElementById('creditTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>   Delivery Fax Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('limitTxt').vadlue == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Delivery Fax  Not Enterd</span></div>";
        return false;
    }

    var url = "CussMas_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&cus_code=" + document.getElementById('cusCodeTxt').value;
    url = url + "&cus_name=" + document.getElementById('cusNameTxt').value;
    url = url + "&cus_tel=" + document.getElementById('telTxt').value;
    url = url + "&cus_address=" + document.getElementById('addressTxt').value;
    url = url + "&cus_fax=" + document.getElementById('faxTxt').value;
    url = url + "&cus_email=" + document.getElementById('emailTxt').value;
    url = url + "&cus_mob=" + document.getElementById('mobNotxt').value;
    url = url + "&id_no=" + document.getElementById('idNoTxt').value;
    url = url + "&birth_day=" + document.getElementById('birthTxt').value;
    url = url + "&cus_ac=" + document.getElementById('acCodeTxt').value;
    url = url + "&status=" + document.getElementById('statusTxt').value;
    url = url + "&adv_ac=" + document.getElementById('advancedACCode').value;
    url = url + "&gain_ac=" + document.getElementById('gainTxt').value;
    url = url + "&con_name=" + document.getElementById('contactNameTxt').value;
    url = url + "&con_tel=" + document.getElementById('contactTelTxt').value;
    url = url + "&con_address=" + document.getElementById('contactAdressTxt').value;
    url = url + "&con_fax=" + document.getElementById('contactFaxTxt').value;
    url = url + "&con_email=" + document.getElementById('contactEmailTxt').value;

    url = url + "&group_code=" + document.getElementById('gropCodeTxt').value;
    url = url + "&group_name=" + document.getElementById('groupNameTxt').value;
    url = url + "&area_code=" + document.getElementById('areaCodeTxt').value;
    url = url + "&area_name=" + document.getElementById('areaNameTxt').value;
    url = url + "&ref_code=" + document.getElementById('refCodeTxt').value;
    url = url + "&ref_name=" + document.getElementById('refNameTxt').value;
    url = url + "&seg_code=" + document.getElementById('segCodeTxt').value;
    url = url + "&seg_name=" + document.getElementById('segNameTxt').value;

    url = url + "&deli_name=" + document.getElementById('deliNameTxt').value;
    url = url + "&deli_addre=" + document.getElementById('deliAddTxt').value;
    url = url + "&deli_tel=" + document.getElementById('deliTelTxt').value;
    url = url + "&deli_fax=" + document.getElementById('deliFaxTxt').value;
    url = url + "&deli_email=" + document.getElementById('deliEmailTxt').value;

    url = url + "&cre_pre=" + document.getElementById('creditTxt').value;
    url = url + "&cre_lim=" + document.getElementById('limitTxt').value;

//    if (document.getElementById('active').checked == true) {
//        url = url + "&credit=Y";
//    } else {
//        url = url + "&credit=N";
//    }

//    var radio;
//    if (document.getElementById('radio1').checked == true) {
//        radio = "Y";
//    } else {
//        radio = "N";
//    }
//    url = url + "&radio=" + document.getElementById('radio').value;

    //  url = url + "&completeC=" + document.getElementById('checkButton').value;


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