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

    var url = "PO_Print.php";
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

        var url = "rcs_data.php";
        url = url + "?Command=" + "setitem";
        url = url + "&Command1=" + "add_tmp";
        url = url + "&itemCode=" + document.getElementById('hawbNo').value;
        url = url + "&vInv=" + document.getElementById('vInv').value;
        url = url + "&ctns=" + document.getElementById('ctns').value;
        url = url + "&weight=" + document.getElementById('weight').value;
        url = url + "&shcode=" + document.getElementById('shCode').value;
        url = url + "&shipper=" + document.getElementById('shipper').value;
        url = url + "&tmpno=" + document.getElementById('tmpno').value;
        var flag;
        if (document.getElementById('PREPAID').checked == true) {
            flag = "PREPAID";
        } else if (document.getElementById('COLLECT').checked == true) {
            flag = "COLLECT";
        }
        url = url + "&flag=" + flag;
        xmlHttp.onreadystatechange = showarmyresultdel;
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);

    }
}

function showarmyresultdel() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

//        alert(xmlHttp.responseText);

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("item_count");
        document.getElementById('item_count').value = XMLAddress1[0].childNodes[0].nodeValue;



        document.getElementById('hawbNo').value = "";
        document.getElementById('vInv').value = "";
        document.getElementById('ctns').value = "";
        document.getElementById('weight').value = "";
        document.getElementById('shCode').value = "";
        document.getElementById('shipper').value = "";

        document.getElementById('hawbNo').focus();
    }
}



function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('tmpno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('txt_entno').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>New Not Selected</span></div>";
        return false;
    }



    var url = "rcs_data.php";
    url = url + "?Command=" + "save_item";

    url = url + "&txt_entno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;

    url = url + "&invdate=" + document.getElementById('invdate').value;

    url = url + "&mawb1=" + document.getElementById('mawb1').value;
    url = url + "&flight=" + document.getElementById('flight').value;
    url = url + "&fdate=" + document.getElementById('fdate').value;
    url = url + "&load1=" + document.getElementById('load1').value;
    url = url + "&load2=" + document.getElementById('load2').value;
    url = url + "&unload1=" + document.getElementById('unload1').value;
    url = url + "&unload2=" + document.getElementById('unload2').value;
    url = url + "&shType=" + document.getElementById('shType').value;
    url = url + "&shName=" + document.getElementById('shName').value;
    url = url + "&csType=" + document.getElementById('csType').value;
    url = url + "&csName=" + document.getElementById('csName').value;

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
        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function new_inv() {
    window.location.assign("home.php?url=rcs");
}

function new_inv1() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    
    document.getElementById('txt_entno').value = "";
    document.getElementById('itemdetails').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";

    document.getElementById('hawbNo').value = "";
    document.getElementById('vInv').value = "";
    document.getElementById('ctns').value = "";
    document.getElementById('weight').value = "";
    document.getElementById('shCode').value = "";
    document.getElementById('shipper').value = "";

    document.getElementById('mawb1').value = "";
    document.getElementById('flight').value = "";
    document.getElementById('fdate').value = "";
    document.getElementById('load1').value = "";
    document.getElementById('load2').value = "";
    document.getElementById('unload1').value = "";
    document.getElementById('unload2').value = "";
    document.getElementById('shType').value = "";
    document.getElementById('shName').value = "";
    document.getElementById('csType').value = "";
    document.getElementById('csName').value = "";

    document.getElementById('PREPAID').checked = true;

    var url = "rcs_data.php";
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

    var url = "rcs_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_item";
    url = url + "&itemCode=" + cdate;
    url = url + "&invno=" + document.getElementById('txt_entno').value;
    url = url + "&tmpno=" + document.getElementById('tmpno').value;

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

    var url = "rcs_data.php";
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
        var url = "rcs_data.php";
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

 


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_REFNO");
        document.form1.txt_entno.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmp_no");
        document.form1.tmpno.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("C_DATE");
        document.form1.invdate.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mawb1");
        document.form1.mawb1.value = XMLAddress1[0].childNodes[0].nodeValue;

//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("mawb2");
//        document.form1.mawb2.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("flight");
        document.getElementById('flight').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("fdate");
        document.form1.fdate.value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("load1");
        document.form1.load1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("load2");
        document.form1.load2.value = XMLAddress1[0].childNodes[0].nodeValue;

//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("load3");
//        document.form1.load3.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unload1");
        document.form1.unload1.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("unload2");
        document.form1.unload2.value = XMLAddress1[0].childNodes[0].nodeValue;



        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("shType");
        document.form1.shType.value = XMLAddress1[0].childNodes[0].nodeValue;
//
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("shName");
        document.form1.shName.value = XMLAddress1[0].childNodes[0].nodeValue;
//
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("csType");
        document.form1.csType.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("csName");
        document.form1.csName.value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    }
}

function costing() {
    
    var url = "home.php?url=costing&jobno=" + document.getElementById('txt_entno').value;
    window.open(url,'_blank');
        
}

function invoice() {
    
    var url = "home.php?url=inv_opr&jobno=" + document.getElementById('txt_entno').value;
    window.open(url,'_blank');
        
}




function view() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "rcs_data.php";
    url = url + "?Command=" + "view";
    url = url + "&dtfrom=" + document.getElementById("dtfrom").value;
    url = url + "&dtto=" + document.getElementById("dtto").value;
    xmlHttp.onreadystatechange = viewResult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}



function viewResult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

    }
}

function rcsview(refno) {
    alert(refno);
}

function srhRcs(arg) {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }
    var url = "rcs_data.php";
    url = url + "?Command=" + "view";
    url = url + "&para=" + arg;
    url = url + "&content=" + document.getElementById(arg).value;
    xmlHttp.onreadystatechange = viewResult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}