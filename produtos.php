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

<?php
    include('classes/config.php');
    include('gerenciadoradmin/classes/subCategoria.php');
    include('gerenciadoradmin/classes/produto.php');
    $idCat   = $_GET['idCat'];
    $idSub   = $_GET['idSub'];
    $session = $_GET['session'];
    
    $config    = new config();
    $subCateg  = new subcategoria();
    
    $sub       = $subCateg->getSubCategoria($idSub);
    $tSub      = $sub[2];
    $categoria = new categoria();
    $cat       = $categoria->getCategoria($idCat);    
    $titulo    = "<a href=\"javascript:void(0);\" onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" style=\"color:#222;text-decoration:none;\" onclick=\"javascript:atualiza('subcategorias.php?idCat=$idCat&session=$session', 'conteudo');\">$cat[1]</a>";
?>

<div id='bloco'>
    <div class="produtosIndex">
        <b id="b"><?php echo "<a onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" style=\"color:#222;text-decoration:none;\" href=\"javascript:void(0);\" onclick=\"javascript:atualiza('categorias.php?session=$session', 'conteudo');\">Categorias e carrocerias</a> > $titulo > $tSub";?></b>
        <div id="prodOut">
            <?php            
            $produtos = new produto();
            $ids      = $produtos->getIds($idSub);
            $cont     = 0;
            $quebra   = 0;
            
            if( $ids[0] == 'end' )
            {
                echo "<p align='center' style='color:red;'>Não há carrocerias cadastrados nesta subcategoria!</p><br>";                
            }
            else
            {
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
                    }
                    $cont++;
                }            
            }            
            ?>
        </div>
    <br></div><br><br>
</div>

