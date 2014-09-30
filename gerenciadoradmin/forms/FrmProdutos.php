<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>
<script type="text/javascript" src="../ckeditorMenor/ckeditor.js"></script>
<script src="../ckeditorMenor/_samples/sample.js" type="text/javascript"></script>
<link href="./ckeditorMenor/_samples/sample.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<link rel='stylesheet' href='../css/inputs.css' type='text/css' media='screen' />

<script type="text/javascript">
        hs.graphicsDir = 'highslide/graphics/';
        hs.outlineType = 'rounded-white';
        hs.showCredits = false;
        hs.wrapperClassName = 'draggable-header';
</script>

<?php
include('../../classes/config.php');                                
include('../classes/subCategoria.php');
include('../classes/produto.php');

$config = new config();

$action    = $_GET['action'];
$item      = $_GET['item'];
$idProduto = $_GET['id'];
$editar    = $_GET['editar'];

if( !isset($item) )
{
    $prim = TRUE; // Primeiro acesso.
}
else
{
    $prim = FALSE;
}

if ( $action == 'changeStatus' )
{
    $p = new produto();
    $p->changeStatus($idProduto);
}

if( $editar == 'true' )
{
    $prim = FALSE;
    $p = new produto();    
    $dadosProd = $p->getProduto($idProduto);
    
    $pId     = $dadosProd[0];
    $pCat    = $dadosProd[1];
    $pSub    = $dadosProd[2];
    $pTitulo = $dadosProd[3];
    $pStatus = $dadosProd[4];
    $pDescri = $dadosProd[5];
}
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Cadastrar produtos:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        
        <div class="d" style="margin-left:10px;">
            <form <?php if($editar!='true'){echo"action='FrmProdutos.php?salvar=true'";}else{echo"action='FrmProdutos.php?salvar=true&update=true&idProd=$idProduto'";}?> method="post">
                <table width="350px" style="font:14px 'Arial';">
                    <tr>
                        <td>Categoria:</td><td><select name="categ" id="categ" onchange="refreshDivSubCateg('selectSubCateg.php?action=selected&idCat='+this.value);">
                                <?php                                                                
                                $sub = new subCategoria();
                                
                                if( $action == 'popula' )
                                {
                                    $pop = TRUE;
                                }
                                
                                $categorias = $sub->getTitulosCategorias($pop);                       

                                $end = "";
                                $x   = 0;

                                $select = false;
                                while( $end != "end" )
                                {
                                    if( $categorias[$x] == "end" ) // Se acabou todas as categorias, termina o loop.
                                    {
                                        break;
                                    }

                                    if( ($categorias[$x] == $item) && ($action != 'popula')) // Se o id da categoria for igual ao id selecionado.
                                    {
                                        echo "<option value='".$categorias[$x]."' selected>".$categorias[$x+1]."</option>";
                                        $select = true;
                                    }
                                    else if( ($categorias[$x] == $pCat) && ($editar == 'true') )
                                    {
                                        echo "<option value='".$categorias[$x]."' selected>".$categorias[$x+1]."</option>";
                                    }
                                    else if( ($categorias[$x] == 'null') && ( $pCat == 0 ) && ( !$select ) )
                                    {
                                        echo "<option value='".$categorias[$x]."' selected>".$categorias[$x+1]."</option>";                                        
                                    }
                                    else if( $prim && ( $categorias[$x] == 'null') ) // Se for o primeiro acesso e for a categoria vasia, deixá-la selecionada
                                    {
                                        echo "<option value='".$categorias[$x]."' selected>".$categorias[$x+1]."</option>";
                                    }
                                    else // Imprime os titulos das categorias.
                                    {                                                                    
                                        echo "<option value='".$categorias[$x]."'>".$categorias[$x+1]."</option>";
                                    }

                                    $end = $categorias[$x];
                                    $x = $x + 2;
                                }
                                ?>
			    </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Subcategoria:</td><td><div id="select"></div></td>
                    </tr>
                    <tr>
                        <td>Título: <b id="obrigatory">*</b></td><td><input type="text" name="text" id="text" <?php if($editar=='true'){echo"value='$pTitulo'";}?>></td>
                    </tr>
                    <tr>
                        <td>Status:</td><td><input type="checkbox" <?php if($editar=='true'){if($pStatus=='ativo'){echo"checked";}else{echo"status.click()";}}else{echo"checked";}?> name="status" id="status">ativo</td>
                    </tr>
                </table>
                <?php
                if( $prim )
                {
                    echo "<script>refreshDivSubCateg('selectSubCateg.php');</script>";
                }
                else if( $editar == 'true' )
                {
                    echo "<script>refreshDivSubCateg('selectSubCateg.php?action=selected&editar=true&idCat=$pCat&idSub=$pSub');</script>";
                }
                ?>
                <div id="editor" align="left" width="350px">
                    <p align='left' style="font:14px 'Arial';">Descrição:</p>
                    <textarea cols="80" id="editor1" name="editor1" rows="10"><?php if($editar=='true'){echo"$pDescri";}?></textarea>
                    <script type='text/javascript'>ckeditorConfig();</script><br>                    
                    <input type="submit" value="Salvar" name="salvar" id="logar">&nbsp&nbsp&nbsp&nbsp<input type="reset" value="cancelar" id="cancel" name="cancel">
                </div>
                
            </form>
            <?php            
            $salvar  = $_GET['salvar'];
            $update  = $_GET['update'];
            $deletar = $_GET['deletar'];
            $id      = $_GET['idProd'];
            
                
            if( $salvar == 'true' )
            {                
                $idCat = $_POST['categ'];
                $idSub = $_POST['subcateg'];
                $titulo = $_POST['text'];
                $status = (isset($_POST['status'])) ? 'ativo' : 'inativo';
                $descri = $_POST['editor1'];                
                
                if( $titulo == NULL )
                {
                    echo "<script>alert(\"TÍTULO OBRIGATÓRIO!!!\");</script>";
                }
                else
                {
                    if( $update != 'true' )
                    {
                        $produto = new produto( $idCat, $idSub, $titulo, $status, $descri );
                    }
                    else
                    {
                        $produto = new produto( $idCat, $idSub, $titulo, $status, $descri, $id, TRUE );
                    }
                }
            }
            else if( $deletar == 'true' )
            {
                // DELETAR O PRODUTO CONFORME ID.                
                $produt = new produto();
                $produt->deletarProduto($id);
            }
            ?>
        </div>
      
        <div class="d2Prod">
            <div id="topo">
                <div class='imgProduto' style="width:40px">
                    <p>Imagens</p>
                </div>
                <div class='tituloProduto'>
                    <p>Produto</p>
                </div>
                <div class='statusProduto'>
                    <p>Status</p>
                </div>
                <div class='opcoesProduto'>
                    <p>Opções</p>
                </div>
            </div>
            <div id="listaProdutos">
                <?php
                $prod = new produto();
                $cont = $prod->getAllIds();
                $x    = 0;
                
                while( $cont[$x] != 'end' )
                {
                    $dadosProduto = $prod->getProduto($cont[$x]);
                    
                    $prodId  = $dadosProduto[0]; // id produto
                    $prodCat = $dadosProduto[1]; // id categoria
                    $prodSub = $dadosProduto[2]; // id da subcategoria
                    $titulo  = $dadosProduto[3]; // titulo do produto
                    $status  = $dadosProduto[4]; // status do produto
                    $descri  = $dadosProduto[5]; // descrição do produto

                    echo "
                        <div id='produto'>
                            <div class='imgProduto'>
                                <a href=\"imagensProdutos.php?id=$prodId\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Escolher imagens', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 710, height:580 } )\"><img src=\"../imagens/imagens.png\" title=\"Uploader de imagens\" border=\"0\" width=\"22px\" height=\"22px\"></a>
                            </div>

                            <div class='tituloProduto'>
                                <a href='FrmProdutos.php?editar=true&id=$prodId&idCat=$prodCat' title='$descri' style='text-decoration:none;'><p style='color:#4682B4;'>$titulo</p></a>
                            </div>";
                    if( $status == 'ativo')
                    {
                        echo "
                            <div class='statusProduto'>
                                <a href='FrmProdutos.php?action=changeStatus&id=$prodId' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:green;'>$status</p></a>
                            </div>";
                    }
                    else if( $status == 'inativo')
                    {
                        echo "
                            <div class='statusProduto'>
                                <a href='FrmProdutos.php?action=changeStatus&id=$prodId' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:red;'>$status</p></a>
                            </div>";
                    }

                    echo "
                            <div class='opcoesProdutos'>
                                <a href='FrmProdutos.php?editar=true&id=$prodId&idCat=$prodCat' title='Editar produto' ><img src='../imagens/editar.png' width='25px' height='22px'></a>&nbsp&nbsp&nbsp&nbsp
                                <a href='javascript:void(0);' onclick=\"yesOrNot('Deseja excluir este produto?', $prodId)\" title='Deletar produto'><img src='../imagens/deletar.png' width='19px' height='19px'></a>
                            </div>
                        </div>";
                    $x++;
                }
                ?>
            </div>
        </div>
    </div>
</body>
