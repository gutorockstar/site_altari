<p align='left'>
    <?php
    include('classes/config.php');
    include('classes/data.php');
    include('gerenciadoradmin/classes/noticia.php');
    
    $config = new config();
    $date   = new data();
    $not    = new noticia();
    
    $cont = $not->getAllIdsValidate(true);
    $x    = 0;

    while( $cont[$x] != 'end' )
    {
        $dadosNot = $not->getNoticia($cont[$x]);
        
        $idNot     = $dadosNot[0];
        $titulo    = $dadosNot[1];
        $sDate     = $dadosNot[2];
        $startDate = $date->convertDateToIndex($sDate);
        $descriNot = $dadosNot[5];
        $descri    = $not->quebraDescri($descriNot);
        
        echo "
            <div id='not'>
                <div class='in' style='margin-top:3px;'>
                    <img style='margin-top:3px;' src='gerenciadoradmin/imagens/noticias.png' title='Notícias' width='33px' height='33px'>
                </div>
                <a href=\"showNoticia.php?noticia=$descriNot&data=$startDate&titulo=$titulo\" id=\"formcontato\" class=\"highslide\" style='text-decoration: none;' onclick=\"return hs.htmlExpand( this, {
                objectType: 'iframe', headingText: 'Notícia da empresa', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\">
                    <div class='noticia'>
                        <div id='out' align='center'>        
                            <div class='in' style='width:80px;'>
                                <p align='left' style='color:#222;margin-left:30px;font-weight:bold;'>$startDate</p>
                            </div><div class='in'><p align='center' style='color:#222;font-weight:bold;'> -</p></div>
                            
                            <div class='in' style='width:140px;'>
                                <p align='left' style='color:#222;margin-left:5px;font-weight:bold;'>$titulo</p>
                            </div>                            
        
                            <div class='in' style='width:280px;'>
                                <p align='left'>$descri</p>
                            </div>                            
                        </div>
                    </div>
                </a>
            </div>";        
        $x++;
    }
    ?>
</p>
      
