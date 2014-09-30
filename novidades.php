<link href="hoverDialog/estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="hoverDialog/jqueryHover.js"></script>
<script type="text/javascript">
    $.noConflict('hover');
    jQuery(document).ready(function(){
            $(".menuHover a").hover(function(){
                    $(this).next("em").animate({opacity: "show", top: "-75"}, "slow");
            }, 
            function(){
                    $(this).next("em").animate({opacity: "hide", top: "-85"}, "fast");
            });
    });
</script>

<b id="b">Destaques</b>

<div id='externo' align='center' align="center">        
    <div class="sc_menu_wrapper">
        <div class="sc_menu" width='150px'>
            <?php
            include('classes/config.php');
            include('gerenciadoradmin/classes/produto.php');
            
            $config   = new config();
            $produtos = new produto();
            
            $ids      = $produtos->getAllIdsActivate(true);
            $cont     = 0;
            $quebra   = 0;
            
            while( $ids[$cont] != 'end' )
            {                
                $produto = $produtos->getProduto($ids[$cont]);

                $id_produto   = $produto[0];
                $categoria    = $produto[1];
                $titulo       = $produto[3];
                $status       = $produto[4];
                $descri       = $produto[5];
                $descricao    = $config->descriBroken($descri);
                $imgChamada   = $produto[6];
                
                if( $imgChamada != null )
                {
                    $capa = 'Imagens/produtos/'.$id_produto.'/'.$imgChamada;
                }
                else
                {
                    $capa = "Imagens/no_image.png";
                }
                
                if( $status != 'inativo' )
                {            
                    echo "<ul class='menuHover'>
                            <li>
                                <div class='contornoProdDest' align='center'>
                                    <b align='center' style='color:#222;'>$titulo</b>
                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('produto.php?idProd=$id_produto&idCat=$categoria&session=$session', 'conteudo');\">
                                        <div id='foto'>
                                            <img id='imagens' src='$capa' alt='Menu' width='190px' height='140px'>
                                        </div>
                                    </a>
                                    <em>$descricao</em>
                                    <div>
                                        <p>Altari S/A</p>
                                    </div>
                                </div>
                            </li>
                          </ul>";

                    if( $quebra == 2 )
                    {
                        echo "<br>";
                        $quebra = 0;
                    }
                    $quebra++;
                }
                $cont++;
            }
            ?>            
        </div>
    </div>
</div>


