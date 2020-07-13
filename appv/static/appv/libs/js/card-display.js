function getCardText(idcard, tagId){
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var Obj = JSON.parse(xmlhttp.responseText);
            if (idcard <= 5)
            {
                var content =  "".concat("<h5>", Obj.libelle, "</h5> <br/>", Obj.annonce);
                document.getElementById(tagId).innerHTML= content;
            }
            else
            {
                var tagTitle = tagId.concat("-title");
                document.getElementById(tagTitle).innerHTML= Obj.libelle;
                document.getElementById(tagId).innerHTML= Obj.annonce;                   
            }
        }
    }
    xmlhttp.open("POST","/libs/mysql/get-card-data-by-id.php?id="+idcard,true);
    xmlhttp.send();
}

function getRSSFluxText(idcard, tagId){
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var Obj = JSON.parse(xmlhttp.responseText);
                var tagTitle = tagId.concat("-title");
                document.getElementById(tagTitle).innerHTML= Obj.libelle;
                document.getElementById(tagId).innerHTML= Obj.annonce;                   

        }
    }
    xmlhttp.open("POST","/libs/mysql/get-last-rssflux-verset-data.php?id="+idcard,true);
    xmlhttp.send();
}




getCardText(10, "card-events");
//getRSSFluxText(11, "card-prays");