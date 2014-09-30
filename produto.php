<?php
    include('classes/config.php');
    include('gerenciadoradmin/classes/subCategoria.php');
    include('gerenciadoradmin/classes/produto.php');
    include('classes/users.php');
    
    $config = new config();
    
    $idCat  = $_GET['idCat'];
    $idSub  = $_GET['idSub'];
    $idProd = $_GET['idProd'];
    $action = $_GET['action'];
    
    $session = $_GET['session'];    

    if( $session != null )
    {        
        session_start($session);
        $login = $_SESSION['login'];        
        
        $user = new users();
        if( ($login != null) && ($user->loginUserLog($login)) )
        {
            if( ($idProd != null) && ($action == 'insert') )
            {
                if( !$user->insertProduto($login, $idProd) )
                {
                    echo "<script>alert('Produto selecionado já está na lista!')</script>";
                }
                else
                {
                    echo "<script>alert('O produto foi adicionado na lista')</script>";
                }
            }
        }
    }
    
    if( $idCat != null )
    {
        $categoria = new categoria();
        $cat       = $categoria->getCategoria($idCat);    
        $titulo    = "<a onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" href=\"javascript:void(0);\" style=\"color:#222;text-decoration:none;\" onclick=\"javascript:atualiza('subcategorias.php?idCat=$idCat&session=$session', 'conteudo');\">$cat[1]</a>";
    }
    
    if( $idSub != null )
    {
        $subCateg = new subCategoria();
        $subCat   = $subCateg->getSubCategoria($idSub);
        $tSub     = "<a onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" href=\"javascript:void(0);\" style=\"color:#222;text-decoration:none;\" onclick=\"javascript:atualiza('produtos.php?idSub=$idSub&idCat=$idCat&session=$session', 'conteudo');\">$subCat[2]</a>";
    }
    
    $produto = new produto();
    $prod    = $produto->getProduto($idProd);
    $tProd    = $prod[3];
?>

<script type="text/javascript">
    $(document).ready(function()
    {
       $("#oculto").hide();
       
       $("#mostrar").click(function(event){
           event.preventDefault();
           $("#oculto").show("slow");
       });
       
       $("#ocultar").click(function(event){
           event.preventDefault();
           $("#oculto").hide("slow");
       });
    });
</script>

<div id='bloco'>
    <div class="produtosIndex">
        <b id="b">
            <?php echo "<a onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" style=\"color:#222;text-decoration:none;\" href=\"javascript:void(0);\" onclick=\"javascript:atualiza('categorias.php?session=$session', 'conteudo');\">Categorias e carrocerias</a> >";?>
            <?php echo $titulo;?> > 
            <?php if($idSub!=null){echo $tSub." > ";}echo $tProd;?>
        </b>
        <div id="prodOut">
            <div>
                <div style="float:left;margin-top:30px;margin-left:30px;width:350px;">
                    <div>
                        <?php
                        $produto = new produto();
                        $dados   = $produto->getProduto($idProd);
                        $descri  = $dados[5];

                        if( $login == null )
                        {
                            $l = true;
                            echo "<p align='left' style='font-size:15px;font-weight:bold;color:#222;'>".$tProd."</p>";
                        }
                        else
                        {
                            $l = false;
                            echo "<p align='left' style='font-size:15px;font-weight:bold;color:#222;'>".$tProd."</p>";
                        }
                        echo "<p align='left'>".$descri."</p><br>";
                        ?>
                    </div>                
                </div>    

                <div style="float:left;margin-top:30px;width:450px;">
                    <div class="highslide-gallery">
                        <?php
                        $dir  = opendir("Imagens/produtos/$idProd/");

                        $cont = 0;
                        $end  = false;
                        $conteudoDivOculta = "";
                        while($read = readdir($dir))
                        {                        
                            if( ($read!= '.') && ($read!= '..') && ($conteudoDivOculta == null) )
                            {
                                if( !$end )
                                {
                                    echo "<a href=\"Imagens/produtos/$idProd/$read\" class=\"highslide\" onclick=\"return hs.expand(this)\" title='Clique para visualizar' style='margin-left:10px;'><img src='Imagens/produtos/$idProd/$read' alt=\"Highslide JS\" width='200px' height='150px' style='margin-bottom:10px;' /></a>";
                                }
                                $cont++;
                            }            
                            
                            if( $cont == 4 )
                            {
                                $end = true;
                            }
                            
                            if( ($cont > 4) && ($read!= '.') && ($read!= '..') )
                            {
                                $conteudoDivOculta .= "<a href=\"Imagens/produtos/$idProd/$read\" class=\"highslide\" onclick=\"return hs.expand(this)\" title='Clique para visualizar' style='margin-left:10px;'><img src='Imagens/produtos/$idProd/$read' alt=\"Highslide JS\" width='200px' height='150px' style='margin-bottom:10px;' /></a>";
                            }                        
                        }
                        closedir($dir);
                        
                        if(isset($conteudoDivOculta))
                        {
                            echo "<div id='oculto' style='width:auto;'>
                                    $conteudoDivOculta
                                    <div id='hideAll'>
                                        <a href='#' style='text-decoration:none;font-size:13px;font-weight:bold;color:#fff;' id='ocultar'><img src='gerenciadoradmin/imagens/hide.png' width='20px' height='20px'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Ocultar</b></a>
                                    </div>
                                  </div>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div style="display:block;">
                <div id="orçar">
                    <?php
                    if( $l )
                    {
                        echo "<a style='text-decoration:none;font-size:13px;font-weight:bold;color:#fff;' href=\"javascript:void(0);\" onclick=\"javascript:atualiza('orçar.php?idProd=$idProd&action=insert', 'conteudo');\" title='Adicionar à lista de orçamentos'><img src='gerenciadoradmin/imagens/prancheta.png' width='20px' height='20px'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Adicionar à lista de orçamentos</b></a>";
                    }
                    else
                    {
                        echo "<a style='text-decoration:none;font-size:13px;font-weight:bold;color:#fff;' href=\"javascript:void(0);\" onclick=\"javascript:atualiza('produto.php?idProd=$idProd&idSub=$idSub&idCat=$idCat&session=$session&action=insert', 'conteudo');\" title='Adicionar à lista de orçamentos'><img src='gerenciadoradmin/imagens/prancheta.png' width='20px' height='20px'>&nbsp;&nbsp;&nbsp;&nbsp;<b >Adicionar à lista de orçamentos</b></a>";
                    }
                    ?>
                </div>
                <div id="showAll">
                    <a style='text-decoration:none;font-size:13px;font-weight:bold;color:#fff;' href="#" id="mostrar" title='Ver todas imagens'><img src='gerenciadoradmin/imagens/lupa.png' width='20px' height='20px'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Ver todas imagens</b></a>
                </div>
            </div>
        <br></div><br><br>
    </div>
</div>

