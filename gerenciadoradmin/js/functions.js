function focusField(idField)
{
    document.getElementById(idField).focus();
    
/**
     * Seta o foco do cursor para o campo determinado.
     */
}

function popupImagem(URL, nome) 
{
    var width = '500px';
    var height = '400px';
    window.open(URL, nome, 'width='+width+', height='+height+', scrollbars=no, status=no, toolbar=no, location=no, directories=no, menubar=no, titlebar=no, resizable=no, fullscreen=no');
        
/**
     * Abre um popup com a imagem selecionada.
     */
}
    
function atualizaParent()
{
    parent.subcategorias.location.reload();
        
/**
     * Faz um refresh no iframe das subCategorias pelo iframe
     * das categorias.
     */
}

function atualizarCampos(id, link, value) 
{
    var item = document.getElementById(id).value;
    window.location.href= link + '?action=selected&item=' + item + '&idCat=' + value;
    
/**
     * Atualiza os inputs do iframe subGrupos.
     */
}

function refreshPage(action)
{
    window.location.href=action;
}

function ckeditorConfig(read)
{
    CKEDITOR.replace( 'editor1',
    {
        extraPlugins : 'bbcode',
        // Remove unused plugins.
        removePlugins : 'bidi,button,dialogadvtab,div,filebrowser,flash,format,forms,horizontalrule,iframe,indent,justify,liststyle,pagebreak,showborders,stylescombo,table,tabletools,templates',
        // Width and height are not supported in the BBCode format, so object resizing is disabled.
        disableObjectResizing : true,
        
        // Define font sizes in percent values.
        fontSize_sizes : "30/30%;50/50%;100/100%;120/120%;150/150%;200/200%;300/300%",
        toolbar :
        [
        ['Source', '-', 'Save','NewPage','-','Undo','Redo'],
        ['Find','Replace','-','SelectAll','RemoveFormat'],
        ['Link', 'Unlink', 'Image', 'Smiley','SpecialChar'],
        '/',
        ['Bold', 'Italic','Underline'],
        ['FontSize'],
        ['TextColor'],
        ['NumberedList','BulletedList','-','Blockquote'],
        ['Maximize']
        ],
        // Strip CKEditor smileys to those commonly used in BBCode.
        smiley_images :
        [
        'regular_smile.gif','sad_smile.gif','wink_smile.gif','teeth_smile.gif','tounge_smile.gif',
        'embaressed_smile.gif','omg_smile.gif','whatchutalkingabout_smile.gif','angel_smile.gif','shades_smile.gif',
        'cry_smile.gif','kiss.gif'
        ],
        smiley_descriptions :
        [
        'smiley', 'sad', 'wink', 'laugh', 'cheeky', 'blush', 'surprise',
        'indecision', 'angel', 'cool', 'crying', 'kiss'
        ]
    } );
}

function lightbox()
{
    jQuery(document).ready(function($) {
        $('a').smoothScroll({
            speed: 1000,
            easing: 'easeInOutCubic'
        });

        $('.showOlderChanges').on('click', function(e){
            $('.changelog .old').slideDown('slow');
            $(this).fadeOut();
            e.preventDefault();
        })
    });

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-2196019-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
}

function yesOrNot(msg, id)
{
    var option = confirm(msg)
    if( option == true )
    {
        // ok.
        window.location.href= 'FrmProdutos.php?deletar=true&idProd='+id;
    }
    else
    {
    // cancel.
    }
}

function yesOrNotWorks(msg, id)
{
    var option = confirm(msg)
    if( option == true )
    {
        // ok.
        window.location.href= 'FrmServiços.php?deletar=true&idServ='+id;
    }
    else
    {
    // cancel.
    }
}

function yesOrNotNews(msg, id)
{
    var option = confirm(msg)
    if( option == true )
    {
        // ok.
        window.location.href= 'FrmNoticias.php?deletar=true&idNot='+id;
    }
    else
    {
    // cancel.
    }
}

function yesOrNotWhatever(msg, action)
{
    var option = confirm(msg)
    if( option == true )
    {
        // ok.
        window.location.href= action;
    }
}

function calendarOptionsStart()
{
    Calendar.setup
    ({
        inputField     :    "f_date_c1",     // id of the input field
        ifFormat       :    "dd/mm/y",      // format of the input field
        button         :    "f_trigger_c1",  // trigger for the calendar (button ID)
        align          :    "Bl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
}

function calendarOptionsEnd()
{
    Calendar.setup
    ({
        inputField     :    "f_date_c2",     // id of the input field
        ifFormat       :    "dd/mm/y",      // format of the input field
        button         :    "f_trigger_c2",  // trigger for the calendar (button ID)
        align          :    "Bl",           // alignment (defaults to "Bl")
        singleClick    :    true
    });
}

function refreshDivSubCateg(link)
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
       $j('#select').html(data);
				
    });
}




/**
 *<script>
function mensagem() {
var name=confirm("Pressione um botão.")
if (name==true)
{
document.write("Você pressionou o botão OK!")
}
else
{
document.write("Você pressionou o botão CANCELAR")
}
}
</script>
<html>
<body>
<a href="#" onclick="mensagem()">Mensagem</a>
</body>
</html>

/**
 *
 * Alguns exemplos:
 * 
 * parent.subcategorias.document.write("Entrou");
 * parent.subcategorias.document.innerHTML = "não funca";
 * document.parent.getElementById('não funca').innerHTML = window.location.reload();
 * 
 */