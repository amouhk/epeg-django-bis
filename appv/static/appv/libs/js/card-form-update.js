function displayModal(enterTag, outputTag, fluxRss) {

    $(enterTag).on('show.bs.modal', function (e) {
    
    var idpred = $(e.relatedTarget).data('id');

    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var fdata = xmlhttp.responseText; 
            //$(".remove-preach-info").innerHTML = xmlhttp.responseText;
            document.getElementById(outputTag).innerHTML= xmlhttp.responseText;                    
        }
    }
    if (fluxRss == 1) 
        xmlhttp.open("POST","/modals/update-rssflux-verset-modal-data.php",true);
    else
        xmlhttp.open("POST","/modals/update-edit-card-modal-data.php?idpred="+idpred,true);

    xmlhttp.send();
  });

}

$(document).ready(function(){

    displayModal("#modalEvents", "edit-card-events", 0);
    displayModal("#modalVerset",  "edit-card-verset", 1);

});