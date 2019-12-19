

function ImgUpload(imgUpload) {
    if (imgUpload.files && imgUpload.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgUpload')
                    .attr('src', e.target.result)
                    .width(400)
                    .height(150);
        };

        reader.readAsDataURL(imgUpload.files[0]);
    }
}

function save_inv() {

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Browser does not support HTTP Request");
        return;
    }


  
    var files = $('#file')[0].files; //where files would be the id of your multi file input
//or use document.getElementById('files').files;

    for (var i = 0, f; f = files[i]; i++) {
        var name = document.getElementById('file');
        var alpha = name.files[i];
        console.log(alpha.name);


        var data = new FormData();



        data.append('Command', "save_item");




        data.append('file', alpha);

        $.ajax({
            url: 'food_MenuMaster_data.php',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (msg) {
                alert(msg);
            }
        });
    }


    var url = "contents_data.php";
    url = url + "?Command=" + "save_item";
    
    xmlHttp.onreadystatechange = salessaveresult;
    xmlHttp.open("POST", url, true);
    xmlHttp.send(null);


    return true;
    
    newent();
}