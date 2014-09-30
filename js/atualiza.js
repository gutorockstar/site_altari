function atualiza(link, div)
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
        if(div=='conteudo')
        {
            $j('#conteudo').html(data);//Carrega os conteúdos para a div #cont.
        }
        else if(div=='novidades')
        {
            $j('.novidades').html(data);//Para a div novidades
        }
        else if(div=='noticias')
        {
            $j('.noticias').html(data);//Para a div noticias
        }
				
    });
/**
 * Atualiza os conteúdos da página sem nescecitar refresh
 * da página inteira.
 */
}