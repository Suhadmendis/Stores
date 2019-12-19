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

var wage = document.getElementById("pre_col");
wage.addEventListener("keydown", function (e) {
    if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
        add_tmp('add');
    }
})


function cal_amo() {
    

    

    document.getElementById('lc_amo').value = parseFloat(document.getElementById('txt_rate').value) * parseFloat(document.getElementById('os_amo').value);

}


function get_cos(cdata) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "costing_data.php";
    url = url + "?Command=" + "get_cos";
    url = url + "&refno=" + cdata;

    xmlHttp.onreadystatechange = showresultgetcos;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showresultgetcos() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('msg_box').innerHTML = "";

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb1");
        document.getElementById('itemdetails1').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb2");
        document.getElementById('itemdetails3').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb3");
        document.getElementById('itemdetails2').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;




        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("jobno");
        document.getElementById('txt_consolno').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtcost");
        document.getElementById('txtcost').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtinvoiced");
        document.getElementById('txtinvoiced').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txtprofit");
        document.getElementById('txtprofit').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("os_amo");
        document.getElementById('os_amo_a').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("lc_amo");
        document.getElementById('lc_amo_a').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("txt_entno");
        document.getElementById('txt_entno').value = XMLAddress1[0].childNodes[0].nodeValue;
        $('#myModal_search').modal('hide');
    }
}


function add_tmp(cdata) {


    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }







    var url = "invoice_opr_data.php";
    url = url + "?Command=" + "add_tmp";
    url = url + "&Command1=" + cdata;

    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&charg_code=" + document.getElementById('charg_code').value;
    url = url + "&currency=" + document.getElementById('currency').value;
    url = url + "&os_amo=" + document.getElementById('os_amo').value;
    url = url + "&tax=" + document.getElementById('tax').value;

    url = url + "&creditor=" + document.getElementById('creditor').value;

    url = url + "&ex_rate=" + document.getElementById('txt_rate').value;
    url = url + "&lc_amo=" + document.getElementById('lc_amo').value;

    url = url + "&inv_type=" + document.getElementById('inv_type').value;
    url = url + "&console=" + document.getElementById('console').value;
    url = url + "&house=" + document.getElementById('house').value;
    url = url + "&description=" + document.getElementById('description').value;



    xmlHttp.onreadystatechange = showresultaddtmp;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function showresultaddtmp() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tb");
        document.getElementById('itemdetails').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;


        document.getElementById('charg_code').value = "";

        document.getElementById('os_amo').value = "";

 
        document.getElementById('creditor').value = "";
         
        document.getElementById('lc_amo').value = "";
        
        document.getElementById('description').value = "";
     

        document.getElementById('charg_code').focus();

    }
}


function new_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


    document.getElementById('charg_code').value = "";

    document.getElementById('os_amo').value = "";


    
    document.getElementById('creditor').value = "";
     
    document.getElementById('txt_rate').value = "1";
    document.getElementById('lc_amo').value = "";
    

    document.getElementById('itemdetails').innerHTML = "";

 

     
    document.getElementById('msg_box').innerHTML = "";



    

    document.getElementById('tmpno').value = "";


    document.getElementById('txt_entno').value = "";


    var url = "invoice_opr_data.php";
    url = url + "?Command=" + "new_inv";
    url = url + "&jobno=" + document.getElementById('txt_consolno').value;
    url = url + "&type=" + document.getElementById('txt_type').value;
    url = url + "&txt_houseno=" + document.getElementById('txt_houseno').value;



    xmlHttp.onreadystatechange = showresultnew;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showresultnew() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("invno");
        document.getElementById('txt_entno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OVAgID");
        document.getElementById('csType').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OVAgName");
        document.getElementById('csName').value = XMLAddress1[0].childNodes[0].nodeValue;


        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("OVAgadd");
        document.getElementById('csAdd').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CusId");
        document.getElementById('shType').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("CuName");
        document.getElementById('shName').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("cuadd");
        document.getElementById('shAdd').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("tmpno");
        document.getElementById('tmpno').value = XMLAddress1[0].childNodes[0].nodeValue;




    }
}


function save_inv() {

    var url = "costing_data.php";
    url = url + "?Command=" + "save_item";

    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&txt_consolno=" + document.getElementById('txt_consolno').value;
    url = url + "&crndate=" + document.getElementById('invdate').value;

    xmlHttp.onreadystatechange = showresultsave;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showresultsave() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";

    }
}


function search() {
    $('#myModal_search').modal('show');
    search_cos('');
}




function search_cos(cdata) {

    var url = "costing_data.php";
    url = url + "?Command=" + "search_cos";

    url = url + "&tmpno=" + document.getElementById('tmpno').value;
    url = url + "&txt_consolno=" + document.getElementById('txt_consolno').value;
    url = url + "&crndate=" + document.getElementById('invdate').value;
    url = url + "&mtype=" + cdata;

    url = url + "&jobno=" + document.getElementById('jobno').value;
    url = url + "&costnum=" + document.getElementById('costnum').value;
    url = url + "&invoiceno=" + document.getElementById('invoiceno').value;
    url = url + "&creditor=" + document.getElementById('creditor').value;


    xmlHttp.onreadystatechange = showresultsearch;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);


}

function showresultsearch() {
    var XMLAddress1;
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        document.getElementById('search_res').innerHTML = xmlHttp.responseText;


    }
}