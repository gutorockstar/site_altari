function atualiza(link, div)
{     
    var linkIndexOf = link.indexOf("listaProdutos.php");
    var enviando    = link.indexOf("action=enviar");
    
    if ( link != 'novidades.php' && link != 'noticias.php' && linkIndexOf == '-1' )
    {
        // start loading
        $(document).ready(function(){$('#obscure-loading').fadeIn("slow");});
    }
    
    if ( linkIndexOf == 0 )
    {
        if ( enviando >= 0 )
        {
            $(document).ready(function(){$('#obscure-loading').fadeIn("slow");});
        }
    }
    
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
    
    if ( link != 'home.php' && link != 'novidades.php' && link != 'orcar.php?session=' && enviando < 0 )
    {
        // off loading
        $(document).ready(function(){$('#obscure-loading').fadeOut("slow");});
    }
/**
 * Atualiza os conteúdos da página sem nescecitar refresh
 * da página inteira.
 */
}

$(document).ready(function() 
{
    $('.barlittle').removeClass('stop');
    
    $('.triggerBar').click(function() 
    {
        $('.barlittle').toggleClass('stop');
    });
});