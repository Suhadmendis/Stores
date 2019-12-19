function GetXmlHttpObject()
{
    var xmlHttp = null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp = new XMLHttpRequest();
    } catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e)
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function newent() {

}

function getdtl() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
    url = url + "?Command=" + "getdt";
//    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function assign_dt() {
    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
        document.getElementById('comments').innerHTML = xmlHttp.responseText;
        getdt2();
    }
}

function getdt2() {
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
    url = url + "?Command=" + "getdt2";
//    url = url + "&ls=" + "new";

    xmlHttp.onreadystatechange = assign_dt2;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}



function assign_dt2() {

    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {

        XMLAddress1 = xmlHttp.responseXML.getElementsByTagName("filebox");
        document.getElementById('filebox').innerHTML = XMLAddress1[0].childNodes[0].nodeValue;
    }

}



function submit() {
//        alert(x + " " + y);
    var userComment = document.getElementById("description").value;
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
    url = url + "?Command=" + "comment";
    url = url + "&cmnt=" + document.getElementById("description").value;

    xmlHttp.onreadystatechange = result_submit;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}



function result_submit()
{
    var XMLAddress1;

    if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
    {
//            alert(xmlHttp.responseText);
        //  location.href = "canteen.php";
        getdtl();
    }
}

function gotpost(cdata) {
//        alert(x + " " + y);
    var userComment = document.getElementById("description").value;
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null)
    {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
    url = url + "?Command=" + "sub_comment";


    var subcom = "comm" + cdata;

    url = url + '&subcom=' + document.getElementById(subcom).value;


    url = url + "&cmnt=" + cdata;

    xmlHttp.onreadystatechange = result_submit;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

}



function del_item(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
//    url = url + "?Command=" + "setitem";
    url = url + "?Command=" + "del_item";
//    url = url + "&itemCode=" + cdate;
    url = url + "&id=" + cdate;

    xmlHttp.onreadystatechange = result_submit;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}


function del_item1(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
//    url = url + "?Command=" + "setitem";
    url = url + "?Command=" + "del_item1";
//    url = url + "&itemCode=" + cdate;
    url = url + "&id=" + cdate;

    xmlHttp.onreadystatechange = result_submit;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function uploadfile() {

    var files = $('#file-3')[0].files; //where files would be the id of your multi file input
//or use document.getElementById('files').files;

    for (var i = 0, f; f = files[i]; i++) {
        var name = document.getElementById('file-3');
        var alpha = name.files[i];
        console.log(alpha.name);
        var data = new FormData();

        data.append('file', alpha);
        $.ajax({
            url: 'fileup.php',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (msg) {
                alert(msg);

            }
        });
    }

}


function postlink(cdate) {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }

    var url = "canteen_data.php";
    url = url + "?Command=" + "getcoom";
//    url = url + "&itemCode=" + cdate;
    url = url + "&id=" + cdate;

    xmlHttp.onreadystatechange = result_submit;
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);

    document.getElementById("msg").innerHTML = cdate ;
    $('#myModal_c').modal('show');

}
