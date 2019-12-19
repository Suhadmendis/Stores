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

    document.getElementById('referenceTxt').value = "";
    document.getElementById('dateTxt').value = "";
    document.getElementById('DRFTxt').value = "";
    document.getElementById('requiredByTxt').value = "";
    document.getElementById('cusCodeTxt').value = "";
    document.getElementById('cusNameTxt').value = "";
    document.getElementById('marExCodeTxt').value = "";
    document.getElementById('marExNameTxt').value = "";
    document.getElementById('attTxt').value = "";
    document.getElementById('ccTxt').value = "";
    document.getElementById('payTxt').value = "";
    document.getElementById('brandCodeTxt').value = "";
    document.getElementById('brandNameTxt').value = "";
    document.getElementById('remarksTxt').value = "";

    getdt();
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "QuotationRequisitionForm_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {

    document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;

}

function print() {

    var url = "QR_Print.php";
    url = url + "?Command=" + "print";

    url = url + "&ref_no=" + document.getElementById('referenceTxt').value;
    url = url + "&t_date=" + document.getElementById('dateTxt').value;
    url = url + "&drf_no=" + document.getElementById('DRFTxt').value;
    url = url + "&req_date=" + document.getElementById('requiredByTxt').value;
    url = url + "&cus_code=" + document.getElementById('cusCodeTxt').value;
    url = url + "&cus_name=" + document.getElementById('cusNameTxt').value;
    url = url + "&mak_code=" + document.getElementById('marExCodeTxt').value;
    url = url + "&mak_name=" + document.getElementById('marExNameTxt').value;
    url = url + "&attention=" + document.getElementById('attTxt').value;
    url = url + "&cc=" + document.getElementById('ccTxt').value;
    url = url + "&pay_term=" + document.getElementById('payTxt').value;
    url = url + "&brand_code=" + document.getElementById('brandCodeTxt').value;
    url = url + "&brand_name=" + document.getElementById('brandNameTxt').value;
    url = url + "&remarks=" + document.getElementById('remarksTxt').value;

    window.open(url, "_blank")

}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    var url = "QuotationRequisitionForm_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    url = url + "&tmpno=" + document.getElementById('referenceTxt').value;
    url = url + "&r_no=" + document.getElementById('recNoTxt').value;
    url = url + "&des=" + document.getElementById('desTxt').value;
    url = url + "&qty=" + document.getElementById('qtyTxt').value;


    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}



function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "QuotationReqisitionForm_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&r_no=" + cdate;
    url = url + "&invno=" + document.getElementById('referenceTxt').value;
    url = url + "&tmpno=" + document.getElementById('referenceTxt').value;
   
    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}




function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        document.getElementById('recNoTxt').value = "";
        document.getElementById('desTxt').value = "";
        document.getElementById('qtyTxt').value = "";


        document.getElementById('recNoTxt').focus();

    }
}


function getcode(cdata, cdata1, cdata2, cdata3) {


    document.getElementById('codeTxt').value = cdata;
    document.getElementById('propertyTypeTxt').value = cdata1;
    document.getElementById('propertyNameTxt').value = cdata2;
    document.getElementById('locationTxt').value = cdata3;



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

    if (document.getElementById('referenceTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Reference No Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('dateTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'> Date Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('DRFTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>DRF No Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('requiredByTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Required By Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('cusCodeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Code Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('cusNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Nmae Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('marExCodeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Marketin Excention Code Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('marExNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Marketin Excention Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('attTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Attention Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('ccTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>CC Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('payTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Payment Term Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('brandCodeTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Brand Code Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('brandNameTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Brand Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('remarksTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Remark Not Selected</span></div>";
        return false;
    }

    var url = "QuotationRequisitionForm_data.php";
    url = url + "?Command=" + "save_item";


    url = url + "&ref_no=" + document.getElementById('referenceTxt').value;
    
    url = url + "&t_date=" + document.getElementById('dateTxt').value;
    url = url + "&drf_no=" + document.getElementById('DRFTxt').value;
    url = url + "&req_date=" + document.getElementById('requiredByTxt').value;
    url = url + "&cus_code=" + document.getElementById('cusCodeTxt').value;
    url = url + "&cus_name=" + document.getElementById('cusNameTxt').value;
    url = url + "&mak_code=" + document.getElementById('marExCodeTxt').value;
    url = url + "&mak_name=" + document.getElementById('marExNameTxt').value;
    url = url + "&attention=" + document.getElementById('attTxt').value;
    url = url + "&cc=" + document.getElementById('ccTxt').value;
    url = url + "&pay_term=" + document.getElementById('payTxt').value;
    url = url + "&brand_code=" + document.getElementById('brandCodeTxt').value;
    url = url + "&brand_name=" + document.getElementById('brandNameTxt').value;
    url = url + "&remarks=" + document.getElementById('remarksTxt').value;
    
    
    url = url + "&tmpno=" + document.getElementById('referenceTxt').value;
    


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










