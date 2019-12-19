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
    document.getElementById('manuTxt').value = "";
    document.getElementById('poTxt').value = "";
    document.getElementById('dtTxt').value = "";
    document.getElementById('cuTxt').value = "";
    document.getElementById('exTxt').value = "";
    document.getElementById('supCodeTxt').value = "";
    document.getElementById('supNameTxt').value = "";
    document.getElementById('cCodeTxt').value = "";
    document.getElementById('cNameTxt').value = "";
    document.getElementById('remarkTxt').value = "";
    document.getElementById('taxCodeTxt').value = "";
    document.getElementById('taxNameTxt').value = "";
    document.getElementById('locCodeTxt').value = "";
    document.getElementById('locNameTxt').value = "";
    document.getElementById('conPerTxt').value = "";
    document.getElementById('delAddTxt').value = "";


//    document.getElementById('proCodeTxt').value = "";
//    document.getElementById('proDesTxt').value = "";
//    document.getElementById('reqBalTxt').value = "";
//    document.getElementById('qtyTxt').value = "";
//    document.getElementById('priceTxt').value = "";
//    document.getElementById('disTxt').value = "";
//    document.getElementById('valueTxt').value = "";
//    document.getElementById('taxTxt').value = "";

    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Stc_pPurO_E_data.php";
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
        document.form1.refTxt.value = XMLAddress1[0].childNodes[0].nodeValue;

    }
}

function print() {

//    var url = "PO_Print.php";
//    url = url + "?Command=" + "print";
//
//    url = url + "&ref_no=" + document.getElementById('refTxt').value;
//    url = url + "&manu_no=" + document.getElementById('manuTxt').value;
//    url = url + "&po_req=" + document.getElementById('poTxt').value;
//    url = url + "&p_date=" + document.getElementById('dtTxt').value;
//    url = url + "&cur_code=" + document.getElementById('cuTxt').value;
//    url = url + "&ex_rate=" + document.getElementById('exTxt').value;
//    url = url + "&sup_code=" + document.getElementById('supCodeTxt').value;
//    url = url + "&sup_name=" + document.getElementById('supNameTxt').value;
//    url = url + "&cost_code=" + document.getElementById('cCodeTxt').value;
//    url = url + "&cost_name=" + document.getElementById('cNameTxt').value;
//    url = url + "&remark=" + document.getElementById('remarkTxt').value;
//    url = url + "&txtC_code=" + document.getElementById('taxCodeTxt').value;
//    url = url + "&txtC_name=" + document.getElementById('taxNameTxt').value;
//    url = url + "&loc_code=" + document.getElementById('locCodeTxt').value;
//    url = url + "&loc_name=" + document.getElementById('locNameTxt').value;
//    url = url + "&con_person=" + document.getElementById('conPerTxt').value;
//    url = url + "&deli_add=" + document.getElementById('delAddTxt').value;
//
//    window.open(url, "_blank")

}





function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "Stc_PurO_E_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&r_no=" + cdate;
    url = url + "&invno=" + document.getElementById('poTxt').value;
    url = url + "&tmpno=" + document.getElementById('refTxt').value;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
//url = url + "&p_code=" + document.getElementById('proCodeTxt').value;
        document.getElementById('recNoTxt').value = "";
        document.getElementById('proCodeTxt').value = "";
        document.getElementById('proDesTxt').value = "";
        document.getElementById('reqBalTxt').value = "";
        document.getElementById('qtyTxt').value = "";
        document.getElementById('priceTxt').value = "";
        document.getElementById('disTxt').value = "";
        document.getElementById('valueTxt').value = "";
        document.getElementById('taxTxt').value = "";


        document.getElementById('recNoTxt').focus();

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



    var url = "Stc_PurO_E_data.php";
    url = url + "?Command=" + "save_item";

//    if (document.getElementById('active').checked == true) {
//        url = url + "&lockitem=Y"; 
//    } else {
//        url = url + "&lockitem=N";
//    }


    url = url + "&ref_no=" + document.getElementById('refTxt').value;
    url = url + "&manu_no=" + document.getElementById('manuTxt').value;
    url = url + "&po_req=" + document.getElementById('poTxt').value;
    url = url + "&p_date=" + document.getElementById('dtTxt').value;
    url = url + "&cur_code=" + document.getElementById('cuTxt').value;
    url = url + "&ex_rate=" + document.getElementById('exTxt').value;
    url = url + "&sup_code=" + document.getElementById('supCodeTxt').value;
    url = url + "&sup_name=" + document.getElementById('supNameTxt').value;
    url = url + "&cost_code=" + document.getElementById('cCodeTxt').value;
    url = url + "&cost_name=" + document.getElementById('cNameTxt').value;
    url = url + "&remark=" + document.getElementById('remarkTxt').value;
    url = url + "&txtC_code=" + document.getElementById('taxCodeTxt').value;
    url = url + "&txtC_name=" + document.getElementById('taxNameTxt').value;
    url = url + "&loc_code=" + document.getElementById('locCodeTxt').value;
    url = url + "&loc_name=" + document.getElementById('locNameTxt').value;
    url = url + "&con_person=" + document.getElementById('conPerTxt').value;
    url = url + "&deli_add=" + document.getElementById('delAddTxt').value;


    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            print();
            newent();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}



function update_item(cdata) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var arg1 = cdata + "reqBal";
    var arg2 = cdata + "qty";
    var arg3 = cdata + "pur_price";
    var arg4 = cdata + "discount";
    var arg5 = cdata + "p_value";
    var arg6 = cdata + "tax_com";

    var url = "Stc_PurO_E_data.php";
    url = url + "?Command=" + "update_item";
//    url = url + "&ref_no=" + document.getElementById('refTxt').value;
    url = url + "&ref_no=" + cdata;

    url = url + "&r_bal=" + document.getElementById(arg1).value;
    url = url + "&qty=" + document.getElementById(arg2).value;
    url = url + "&p_price=" + document.getElementById(arg3).value;
    url = url + "&dis=" + document.getElementById(arg4).value;
    url = url + "&p_value=" + document.getElementById(arg5).value;
    url = url + "&tax_com=" + document.getElementById(arg6).value;
//alert(url);
    xmlHttp.onreadystatechange = showarmyresultx;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function showarmyresultx() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        
        alert('Added');
    
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("totval");
        document.getElementById('totValTxt').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('code_txt').value = "";
        document.getElementById('des_txt').value = "";
        document.getElementById('bal_txt').value = "";
        document.getElementById('qty_txt').value = "";
        document.getElementById('pPrice_txt').value = "";
        document.getElementById('dis_txt').value = "";
        document.getElementById('value_txt').value = "";
        document.getElementById('tax_txt').value = "";
        document.getElementById('recNoTxt').focus();

    }
}