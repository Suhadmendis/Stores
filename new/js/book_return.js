
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


    document.getElementById('txt_mem_id').value = "";
    document.getElementById('mem_id').value = "";
    document.getElementById('name_cat').value = "";
    document.getElementById('mem_name').value = "";
    document.getElementById('designation').value = "";
    document.getElementById('tel').value = "";
    document.getElementById('mobile').value = "";
    document.getElementById('email').value = "";
    document.getElementById('max').value = "";
    document.getElementById('item').innerHTML = "";
    document.getElementById('msg_box').innerHTML = "";

//    getdt();
}
//
//function assign_dt() {
//
//    var XMLAddress1;
//
//    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
//    {
//        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("access_no");
//        document.form1.access_no.value = XMLAddress1[0].childNodes[0].nodeValue;
//    }
//}


function getdt() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "lending_data.php";
    url = url + "?Command=" + "getnw";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    if (document.getElementById('access_no').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Access No Not Entered</span></div>";
        return false;
    }
    if (document.getElementById('mem_id').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Member ID Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('txt_mem_id').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Member ID Not Entered</span></div>";
        return false;
    }
    if (document.getElementById('name_cat').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Name Category Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('mem_name').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Member Name Not Selected</span></div>";
        return false;
    }
    if (document.getElementById('designation').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Designation Not Entered</span></div>";
        return false;
    }
    if (document.getElementById('tel').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Private Tel Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('mobile').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Mobile No Not Enterd</span></div>";
        return false;
    }

    if (document.getElementById('email').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Email Not Enterd</span></div>";
        return false;
    }
    if (document.getElementById('max').value == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Max No Not Entered</span></div>";
        return false;
    }

    if (document.getElementById('itemd').innerHTML == "") {
        document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>Select Books</span></div>";
        return false;
    }



    var url = "lending_data.php";
    url = url + "?Command=" + "save_item";



    url = url + "&access_no=" + document.getElementById('access_no').value;
    url = url + "&member_id=" + document.getElementById('txt_mem_id').value;
    url = url + "&title=" + document.getElementById('name_cat').value;
    url = url + "&name=" + document.getElementById('mem_name').value;
    url = url + "&designation=" + document.getElementById("designation").value;
    url = url + "&private_tel=" + document.getElementById('tel').value;
    url = url + "&mobile=" + document.getElementById('mobile').value;
    url = url + "&email=" + document.getElementById('email').value;
    url = url + "&max_item=" + document.getElementById('max').value;

    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function salessaveresult() {
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

        if (xmlHttp.responseText == "Saved") {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-success' role='alert'><span class='center-block'>Saved</span></div>";
            
            setTimeout(function () {
                window.location.reload(1);
            }, 500);

        } else {
            document.getElementById('msg_box').innerHTML = "<div class='alert alert-warning' role='alert'><span class='center-block'>" + xmlHttp.responseText + "</span></div>";
        }
    }
}

function cust(cuscode, stname) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_book_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "add_tmp";
    url = url + "&tmpno=" + opener.document.getElementById('access_no').value;
    url = url + "&custno=" + cuscode;
    url = url + "&stname=" + stname;
    xmlHttp.onreadystatechange = showarmyresultdel;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}

function del_item(cuscode) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "search_book_data.php";
    url = url + "?Command=" + "setitem";
    url = url + "&Command1=" + "del_tmp";
    url = url + "&custno=" + cuscode;
    url = url + "&tmpno=" + document.getElementById('access_no').value;

    xmlHttp.onreadystatechange = showarmyresultdel1;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}


function showarmyresultdel() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        opener.itemd.innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        self.close();
    }



}

function showarmyresultdel1() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemd').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }



}

function details(accno,bkcode) {
    
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "book_return_data.php";
    url = url + "?Command=" + "set";
    url = url + "&bkcode=" + bkcode;
    url = url + "&accno=" + accno;

    xmlHttp.onreadystatechange = show;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

    
    
}

function show() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("sales_table");
        document.getElementById('itemdet').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
        self.close();
    }



}
