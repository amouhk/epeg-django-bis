function updatePredicationsInfo(num)
{
    if (num.length==0)
    { 
        document.getElementById("descpPred").innerHTML="";
        return;
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            //document.getElementById("descpPred").innerHTML=xmlhttp.responseText;
            var predJsonData = xmlhttp.responseText;
            var predObj = JSON.parse(predJsonData);
            
            // Set Html content
            // Audio
            /*var audio = document.getElementById("audioSrc");
            audio.src = predObj.cheminFichier;
            audio.load();*/
            
            //description
            document.getElementById("titlePred").innerHTML= predObj.titre;
            document.getElementById("descpPred").innerHTML= predObj.titre + '<br\>' + predObj.predicateur + '<br\>' + predObj.type
                                                        + '<br\>' + predObj.date + '<br\>' + predObj.description;
            
        }
    }
    xmlhttp.open("GET","/libs/mysql/get-item-by-id.php?idpred="+num,true);
    xmlhttp.send();
};

//First load data
$("#firstPred").addClass('selected');
var firstId = $("#firstPred").attr("value");
updatePredicationsInfo(firstId);

// Select predication actions
$(document).ready(function() {
    var id;
    var table = $('#dataTable').DataTable();
 
    $('#dataTable tbody').on( 'click', 'tr', function () 
    {
        if ( $(this).hasClass('selected') ) 
        {
            //$(this).removeClass('selected');
        }
        else 
        {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            id = $(this).attr("value");
        
            updatePredicationsInfo(id);
        }
    });
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );