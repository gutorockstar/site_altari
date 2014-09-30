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

<div id='bloco'>
    <div class="produtosIndex">        
        <b id="b">Categorias e carrocerias</b>
        <div id="prodOut" align="center">           
            <div>
                <?php
                include('classes/config.php');
                include('gerenciadoradmin/classes/categoria.php');                
                include('gerenciadoradmin/classes/produto.php');
                
                $session = $_GET['session'];

                $config     = new config();
                $categorias = new categoria();
                $ids        = $categorias->getAllIds();
                $cont       = 0;
                $quebra     = 0;

                $nenhumaCat = false;
                if( $ids[0] == 'end' )
                {
                    $nenhumaCat = true;
                }
                else
                {
                    while( $ids[$cont] != 'end' )
                    {
                        $categoria = $categorias->getCategoria($ids[$cont]);

                        $id_cat    = $categoria[0];
                        $titulo    = $categoria[1];
                        $imagem    = $categoria[2];
                        $descricao = $categoria[3];
                        $descri    = $config->descriBroken($descricao);
                        $status    = $categoria[4];
                        $quantSub  = $categorias->getSubcatFromThis($ids[$cont]);
                        
                        if ( $quantSub[0] == 0 )
                        {
                            $quantSub = "<font color='red'>$quantSub[0]</font>";
                        }
                        else
                        {
                            $quantSub = "<font color='#4682B4'>$quantSub[0]</font>";
                        }
                        
                        $quantProd = $categorias->getProdFromThis($ids[$cont]);
                        
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
                                            <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('subcategorias.php?idCat=$id_cat&session=$session', 'conteudo');\">
                                                <div id='foto'>
                                                    <img id='imagens' src='$imagem' alt='Menu' width='190px' height='140px'>
                                                </div>
                                            </a>
                                            <em>$descri</em>
                                            <div>
                                                <p style='text-align:left;margin-left:5px;'>Subcategorias: $quantSub &nbsp;&nbsp;Carrocerias: $quantProd</p>
                                            </div>
                                        </div>
                                    </li>
                                  </ul>";
                        }
                        $cont++;
                    }
                }
                
                $produtos = new produto();
                $ids      = $produtos->getIdsByNoNathing();
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

                if( $nenhumaCat && $nenhumProd )
                {
                    echo "<p align='center' style='color:red;'>Não há categorias nem carrocerias cadastrados nesta categoria!</p><br>";
                }
                ?>
            </div>
        <br></div><br><br>
    </div>
</div>

