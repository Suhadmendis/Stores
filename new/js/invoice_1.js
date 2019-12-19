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



function print_inv(cdata) {

    var url = "invoice_print.php";
    url = url + "?tmp_no=" + document.getElementById('tmpno').value;
    url = url + "&action=" + cdata;

    window.open(url, '_blank');


}

function add_tmp() {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if ((document.getElementById('tmpno').value != "")) {

        var url = "invoice_data_1.php";
        url = url + "?Command=" + "setitem";
        url = url + "&Command1=" + "add_tmp";
        url = url + "&invno=" + document.getElementById('txt_entno').value;
        url = url + "&itemCode=" + document.getElementById('itemCode').value;
        url = url + "&itemDesc=" + document.getElementById('itemDesc').value;
        url = url + "&itemPrice=" + document.getElementById('itemPrice').value;
        url = url + "&qty=" + document.getElementById('qty').value;
        url = url + "&tmpno=" + document.getElementById('tmpno').value;
        var vattype;
        if (document.getElementById('non').checked == true) {
            vattype = "non";
        }

        if (document.getElementById('svat').checked == true) {
            vattype = "svat";
        }
        url = url + "&vat=" + vattype;
        
        var isNbt = "false";
        if (document.getElementById('chkNbt').checked == true) {
            isNbt = "true";
        }
        url = url + "&isNbt=" + isNbt;
        
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }
}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
        document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("gtot");
        document.getElementById('gtot').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vattot");
        document.getElementById('svattot').value = XMLAddress1[0].childNodes[0].nodeValue;
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vattot1");
        document.getElementById('svattot1').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("nbt");
        document.getElementById('nbt').value = XMLAddress1[0].childNodes[0].nodeValue;
        

        document.getElementById('itemCode').value = "";
        document.getElementById('itemDesc').value = "";
        document.getElementById('qty').value = "";
        document.getElementById('itemPrice').value = "";

        document.getElementById('itemDesc').focus();
    }
}



function save_inv(status) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('c_name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Customer Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('subtot').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Amount Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('txt_gl_code').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Ledger Not Enterd</span></div>";
        return false;
    }



    var url = "invoice_data_1.php";
    url = url + "?Command=" + "save_item";
    url = url + "&Command1=" + status;

    url = url + "&txt_entno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&customercode=" + document.getElementById('c_code').value;
    url = url + "&customername=" + document.getElementById('c_name').value;
    url = url + "&cont_p=" + document.getElementById('cus_address').value;
    url = url + "&txt_remarks=" + document.getElementById('txt_remarks').value;

    url = url + "&subtot=" + document.getElementById('subtot').value;
    url = url + "&invdate=" + document.getElementById('invdate').value;

    url = url + "&currency=" + document.getElementById('currency').value;
    url = url + "&txt_rate=" + document.getElementById('txt_rate').value;

    url = url + "&salesrep=" + document.getElementById('salesrep').value;
    url = url + "&department=" + document.getElementById('department').value;
    url = url + "&DANO=" + document.getElementById('DANO').value;
    url = url + "&txt_minno=" + document.getElementById('txt_minno').value;
    url = url + "&txt_gl_code=" + document.getElementById('txt_gl_code').value;
    url = url + "&txt_gl_name=" + document.getElementById('txt_gl_name').value;




    var vattype;
    if (document.getElementById('non').checked == true) {
        vattype = "non";
    }

    if (document.getElementById('svat').checked == true) {
        vattype = "svat";
    }
    url = url + "&vat=" + vattype;
    
    var isNbt = "false";
    if (document.getElementById('chkNbt').checked == true) {
        isNbt = "true";
    }
    url = url + "&isNbt=" + isNbt;
    
    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
//            print_inv('save');
        } else if (xmlHttp.responseText.startsWith("<div")) {
            document.getElementById('msg_box').innerHTML = xmlHttp.responseText;
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var paymethod;

    document.getElementById('txt_entno').value = "";
    document.getElementById('c_code').value = "";
    document.getElementById('c_name').value = "";
    document.getElementById('cus_address').value = "";
    document.getElementById('svat').checked = true;
    document.getElementById('chkNbt').checked = true;
    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('subtot').value = "";
    document.getElementById('msg_box').innerHTML = "";
    document.getElementById('itemCode').value = "1";
    document.getElementById('itemDesc').value = "";
    document.getElementById('itemPrice').value = "";
    document.getElementById('qty').value = "1";
    document.getElementById('gtot').value = "";
    document.getElementById('txt_remarks').value = "";
    document.getElementById('nbt').value = "";
    document.getElementById('DANO').value = "";
    document.getElementById('txt_minno').value = "";
    
    document.getElementById('txt_gl_code').value = "";
    document.getElementById('txt_gl_name').value = "";


    document.getElementById('svattot').value = "";
    document.getElementById('svattot1').value = "";
    var url = "invoice_data_1.php";
    url = url + "?Command=" + "new_inv";

    xmlHttp.onreadystatechange = assign_invno;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function assign_invno() {



    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('txt_entno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("dt");
        document.getElementById('invdate').value = XMLAddress1[0].childNodes[0].nodeValue;



    }

}




function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "invoice_data_1.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&itemCode=" + cdate;
    url = url + "&invno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    var vattype;
    if (document.getElementById('non').checked == true) {
        vattype = "non";
    }

    if (document.getElementById('svat').checked == true) {
        vattype = "svat";
    }
    url = url + "&vat=" + vattype;

    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}




function update_list(stname) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "invoice_data_1.php";
    url = url + "?Command=" + "update_list";
    url = url + "&refno=" + document.getElementById('cusno').value;
    url = url + "&cusname=" + document.getElementById('customername').value;
    url = url + "&stname=" + stname;

    xmlHttp.onreadystatechange = showitemresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function showitemresult()
{
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('filt_table').innerHTML = xmlHttp.responseText;
    }
}



function crnview(custno, stname)
{
    try {


        xmlHttp = GetXmlHttpObject();
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request");
            return;
        }

        var url = "invoice_data_1.php";
        url = url + "?Command=" + "pass_rec";
        url = url + "&refno=" + custno;
        url = url + "&stname=" + stname;

        xmlHttp.onreadystatechange = pass_rec_result;

        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    } catch (err) {
        alert(err.message);
    }
}

function pass_rec_result()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        alert(xmlHttp.responseText);
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("stname");
        var stname = XMLAddress1[0].childNodes[0].nodeValue;

        if ((stname == "")||(stname == "dinv")) {

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmp_no");
            opener.document.form1.tmpno.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");
            opener.document.form1.txt_entno.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_CODE");
            opener.document.form1.c_code.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("name");
            opener.document.form1.c_name.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_DATE");
            opener.document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_remarks");
            opener.document.form1.txt_remarks.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("Attn");
            opener.document.form1.cus_address.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("nbt");
            opener.document.form1.nbt.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            if (XMLAddress1[0].childNodes[0].nodeValue > 0) {
                window.opener.document.getElementById('chkNbt').checked = true;
            } else {
                window.opener.document.getElementById('chkNbt').checked = false;
            }

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("currency");
            opener.document.form1.currency.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("salesrep");
            opener.document.form1.salesrep.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("department");
            opener.document.form1.department.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("DANO");
            opener.document.form1.DANO.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("ORD_NO");
            opener.document.form1.txt_minno.value = XMLAddress1[0].childNodes[0].nodeValue;



            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_rate");
            opener.document.form1.txt_rate.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
            window.opener.document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
            window.opener.document.getElementById('subtot').value = XMLAddress1[0].childNodes[0].nodeValue;


            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
            opener.document.form1.item_count.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("subtot");
            opener.document.form1.subtot.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("gtot");
            opener.document.form1.gtot.value = XMLAddress1[0].childNodes[0].nodeValue;

            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vattot");
            opener.document.form1.svattot.value = XMLAddress1[0].childNodes[0].nodeValue;
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vattot1");
            opener.document.form1.svattot1.value = XMLAddress1[0].childNodes[0].nodeValue;
            
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("vatType");
            if (XMLAddress1[0].childNodes[0].nodeValue == "1") {
                //vat method
                window.opener.document.getElementById('svat').checked = true;
            } else {
                //svat method
                window.opener.document.getElementById('non').checked = true;
            }
        } else if (stname == "set_inv") {
            XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");
            opener.document.form1.itemDesc.value = XMLAddress1[0].childNodes[0].nodeValue;
        }


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("msg");
        if (XMLAddress1[0].childNodes[0].nodeValue != "") {
            window.opener.document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + XMLAddress1[0].childNodes[0].nodeValue + "</span></div>";
        }
        self.close();
    }
}


function cancel_inv() {
    $('#myModal_c').modal('hide');

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    document.getElementById('msg_box').innerHTML = "";
    if (document.getElementById('c_name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Entry</span></div>";
        return false;
    }
    if (document.getElementById('subtot').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Entry</span></div>";
        return false;
    }

    var url = "invoice_data_1.php";
    url = url + "?Command=" + "del_inv";
    url = url + "&crnno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    xmlHttp.onreadystatechange = cancel_result;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function cancel_result() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {


        if (xmlHttp.responseText == "ok") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Cancelled</span></div>";
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        } else {
            if (xmlHttp.responseText != "") {
                document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
            }
        }
    }
}