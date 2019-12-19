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

function newent() {

    document.getElementById('memeberIDTxt').value = "";
    document.getElementById('receiptNoTxt').value = "";
    document.getElementById('totDueAmountTxt').value="";
    document.getElementById('payAmountTxt').value="";
    document.getElementById('balanceTxt').value="";
    
    getdt();
    
}

function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "payments_data.php";
    url = url + "?Command=" + "getdt";
    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function assign_dt() {
    
//    document.getElementById('itemdetails').innerHTML = xmlHttp.responseText;
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("id");
        document.form1.receiptNoTxt.value = XMLAddress1[0].childNodes[0].nodeValue;
    }
}
function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('memberIDTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Member ID Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('receiptNoTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Receipt No Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('totDueAmountTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Total Due Amount Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('payAmountTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Pay Amount Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('balanceTxt').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Balance Not Enterd</span></div>";
        return false;
    }
    

    var url = "payments_data.php";
    url = url + "?Command=" + "save_item";


    url = url + "&mem_id=" + document.getElementById('mem_id').value;
    url = url + "&recipt_no=" + document.getElementById('recipt_no').value;
    url = url + "&tot_due_amount=" + document.getElementById('tot_due_amount').value;
    url = url + "&pay_amount=" + document.getElementById('pay_amount').value;
    url = url + "&balance=" + document.getElementById('balance').value;
   

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            newent();
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function custno(custno, stname)
{
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
       return;
    }

    var url = "payments_data.php";
    url = url + "?Command=" + "pass_quot";
    url = url + "&custno=" + custno;
    url = url + "&stname=" + stname;
    xmlHttp.onreadystatechange = passcusresult_quot;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function cust(cuscode, stname) {

    xmlHttp = GetXmlHttpObject();
   if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
   }

    var url = "payments_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    
    url = url + "&custno=" + cuscode;
    url = url + "&stname=" + stname;
    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}




function passcusresult_quot()
{
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
        stname = XMLAddress1[0].childNodes[0].nodeValue;
        if (stname == "book_mas") {

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("b_code");
            opener.document.form1.book_code.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mtit");
            opener.document.form1.main_title.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stit");
            opener.document.form1.sub_title.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("aut");
            opener.document.form1.author.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("autdes");
            opener.document.form1.author_description.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pub");
            opener.document.form1.publisher.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("series");
            opener.document.form1.series.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("isbn");
            opener.document.form1.isbn.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("adap");
            opener.document.form1.adapter.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("geoc");
            opener.document.form1.geoCode.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("rem");
            opener.document.form1.remarks.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cat");
            opener.document.form1.cat.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pri");
            opener.document.form1.price.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("keyw");
            opener.document.form1.keywords.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("edi");
            opener.document.form1.editor.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("trana");
            opener.document.form1.translator.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("pubyr");
            opener.document.form1.publishYr.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("loc");
            opener.document.form1.location.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("clano");
            opener.document.form1.class_no.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("calno");
            opener.document.form1.callNo.value = XMLAddress1[0].childNodes[0].nodeValue;

            if (stname == "lending") {

                XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
                opener.document.getElementById('itemd').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

           }


        }

        self.close();
    }
}

function showarmyresultdel() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        opener.itemd.innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        self.close();
    }

}