function atualiza(link, titulo)
{
    var $j = jQuery.noConflict();
    for(i=0; i< link.length; i++)
    { 
        if(link[i] == "?")
        {
            var encontrou = true; 
        }
    }

    if(encontrou)
    {
        var randobj = link +"&timestamp="+ new Date().getTime();
    }
    else
    {
        var randobj = link +"?timestamp="+ new Date().getTime();
    }

    $j.get(randobj,'',function(data)
    {			
        if( titulo == null )
        {			
            $j(".interno2").html(data);
        }
        else
        {
            $j(".interno2").html(data);
            $j('.interno1').html("<h2 align='center'>"+titulo+"</h2>");
        }
			
    });
}
