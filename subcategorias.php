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
    
    $session = $_GET['session'];
    $idCat   = $_GET['idCat'];
    
    $config    = new config();
    $categoria = new categoria();
    $cat       = $categoria->getCategoria($idCat);
    
    $titulo    = $cat[1];
?>
<div id='bloco'>
    <div class="produtosIndex">        
        <b id="b"><?php echo"<a id=\"1\" onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" title='Clique para voltar' style=\"color:#222;text-decoration:none;\" href=\"javascript:void(0);\" onclick=\"javascript:atualiza('categorias.php?session=$session', 'conteudo');\">Categorias e carrocerias</a> > $titulo";?></b>
        <div id="prodOut">
            <div>
                <?php    
                $subCategorias = new subCategoria();
                $ids           = $subCategorias->getIds($idCat);
                $cont          = 0;
                $quebra        = 0;

                $nenhumaSub = false;
                if( $ids[0] == 'end' )
                {
                    $nenhumaSub = true;
                }
                else
                {
                    while( $ids[$cont] != 'end' )
                    {
                        $subCategoria = $subCategorias->getSubCategoria($ids[$cont]);

                        $id_subcategoria = $subCategoria[0];
                        $id_categoria    = $subCategoria[1];
                        $titulo          = $subCategoria[2];  
                        $imagem          = $subCategoria[3];
                        $descricao       = $subCategoria[4];
                        $descri          = $config->descriBroken($descricao);
                        $status          = $subCategoria[5];
                        $quantProd       = $subCategorias->getProdFromThis($id_categoria, $id_subcategoria);
                        
                        if ( $quantProd[0] == 0 )
                        {
                            $quantProd = "<font color='red'>$quantProd[0]</font>";
                        }
                        else
                        {
                            $quantProd = "<font color='#4682B4'>$quantProd[0]</font>";
                        }

                        if( $status != 'inativo' )
                        {                            
                            echo "<ul class='menuHover'>
                                    <li>
                                        <div class='contornoProdCat' align='center'>                                    
                                            <b align='center'>$titulo</b>
                                            <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('produtos.php?idSub=$id_subcategoria&idCat=$id_categoria&session=$session', 'conteudo');\">
                                                <div id='foto'>
                                                    <img id='imagens' src='$imagem' alt='Menu' width='190px' height='140px'>
                                                </div>
                                            </a>
                                            <em>$descri</em>
                                            <div>
                                                <p style='text-align:left;margin-left:5px;'>Carrocerias: $quantProd</p>
                                            </div>
                                        </div>
                                    </li>
                                  </ul>";
                        }
                        $cont++;
                    }
                }

                $produtos = new produto();
                $ids      = $produtos->getIdsBycat($idCat);
                $cont     = 0;
                $quebra   = 0;

                $nenhumProd = false;
                if( $ids[0] == 'end' )
                {                    
                    $nenhumProd = true;
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

                if( $nenhumaSub && $nenhumProd )
                {
                    echo "<p align='center' style='color:red;'>Não há subcategorias nem carrocerias cadastrados nesta categoria!</p><br>";
                }
                ?>
            </div>
        <br></div><br><br>
    </div>
</div>

