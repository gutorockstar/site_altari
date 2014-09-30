<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<script type="text/javascript" src="../js/functions.js"></script>

<?php
include('../../classes/config.php');
include('../classes/subCategoria.php');

$config = new config();

$action = $_GET['action'];
$item   = $_GET['item'];

if( ( ($action == 'selected') || ($action == 'popula') ) && ($item != 'null') )
{
    echo "<link rel='stylesheet' href='../css/inputs.css' type='text/css' media='screen' />";
}
else if( ( ($action != 'selected') && ($action != 'popula') ) || ($item == 'null') )
{
    echo "<link rel='stylesheet' href='../css/inputsDisabled.css' type='text/css' media='screen' />";
}

if ( $action == 'changeStatus' )
{
    $subcateg = new subcategoria();
    $subcateg->changeStatus($item);
}

if( !isset($item) )
{
    $prim = TRUE; // Primeiro acesso.
}
else
{
    $prim = FALSE;
}
    
if( $action == 'popula')
{
    $subcateg = new subcategoria();
    $c = $subcateg->getSubCategoria($item);
        
    $idCatego        = $c[1];   
    $subcatTitulo    = $c[2]; //Título da categoria
    $subcatDirImagem = $c[3]; //Diretório da imagem da categoria
    $subcatDescri    = $c[4]; //Descrição da categoria
    $subcatStatus    = $c[5]; //Status da categoria
 }
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Cadastrar subcategoria:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        <div class="d" name="d">
            <table width="400px" align="left" style="font:14px 'Arial';margin-left:20px;">
                <form <?php if($action=='popula'){echo"action='FrmSubGrupos.php?action=enter&up=true&id=$item'";}else{echo"action='FrmSubGrupos.php?action=enter&up=false'";}?> method="post" enctype="multipart/form-data">
                    <tr>
                        <td>Selecionar grupo: <b style="color:red;">*</b></td><td><select name="checkCategorias" id="checkCategorias"<?php if($action!='popula'){echo"onchange=\"atualizarCampos('checkCategorias', 'FrmSubGrupos.php')\"";} ?>>
                                <?php
                                $sub = new subCategoria();
                                if( $action == 'popula' )
                                {
                                    $pop = TRUE;
                                }
                                $categorias = $sub->getTitulosCategorias($pop);

                                $end = "";
                                $x   = 0;

                                while( $end != "end" )
                                {
                                    if( $categorias[$x] == "end" ) // Se acabou todas as categorias, termina o loop.
                                    {
                                        break;
                                    }

                                    if( ($categorias[$x] == $item) && ($action != 'popula')) // Se o id da categoria for igual ao id selecionado.
                                    {
                                        echo "<option value='".$categorias[$x]."' selected>".$categorias[$x+1]."</option>";
                                    }
                                    else if( ($categorias[$x] == $idCatego) && ($action == 'popula') )
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
                        <td <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"style='color:#999;'";}?>>Título do subgrupo: <b id="obrigatory">*</b></td><td><input type="text" <?php if($action=='popula'){echo"value='$subcatTitulo'";}?> id="text" name="text" <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"disabled='true'";}?>/></td>
                    </tr>
                    <tr>
                        <td <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"style='color:#999;'";}?>>Imagem de chamada:</td><td><input type="button" id="procurar" onClick="fileOculto.click()" value="Procurar" <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"disabled='true'";}?>>&nbsp;<input type="text" <?php if($action=='popula'){echo"value='$subcatDirImagem'";}?> id="file" size="20" disabled /></td>
                    </tr>
                    <tr>
                        <td <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"style='color:#999;'";}?>>Descrição:</td><td><textarea id="descri" name="descri" <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"disabled='true'";}?>><?php if($action=='popula'){echo "$subcatDescri";}?></textarea></td>
                    </tr>
                    <tr>
                        <td <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"style='color:#999;'";}?>>Status:</td><td><input type="checkbox" <?php if($action=='popula'){if($subcatStatus=='ativo'){echo"checked";}else{echo"status.click()";}}else{echo"checked";}?> name="status" id="status" <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"disabled='true'";}?>>ativo</td>
                    </tr>
                    <tr>
                        <td></td><td><input type="file" id="fileOculto" name="fileOculto" onChange="file.value = this.value;"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" id="logar" value="Salvar" <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"disabled='true'";}?>/>&nbsp;&nbsp;<input type="reset" id="cancel" value="Limpar" <?php if((($action!='selected')&&($action != 'popula'))||($item=='null')){echo"disabled='true'";}?>/></td><td></td>
                    </tr>
                </form>
            </table>
        </div>
        <?php
        $action = $_GET['action'];
        $update = $_GET['up'];
        $idSubCat = $_GET['id'];
        
        if( $action == 'enter' )
        {
            $categoria = $_POST['checkCategorias'];
            $titulo    = $_POST['text'];
            $imagem    = isset($_FILES["fileOculto"]) ? $_FILES["fileOculto"] : FALSE;
            $descri    = $_POST['descri'];
            $status    = (isset($_POST['status'])) ? 'ativo' : 'inativo';
            
            $href = "FrmSubGrupos.php?action=popula&item=$idSubCat";
            if( $categoria == 'null' )
            {
                echo "<script>alert(\"SELECIONE UM GRUPO!!!\");</script>";
                echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=$href'> ";
            }
            else if( ($titulo == NULL) && ($update != NULL))
            {
                echo "<script>alert(\"TÍTULO OBRIGATÓRIO!!!\");</script>";
                
                if( $idSubCat != NULL )
                {
                    echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=$href'> ";
                }
            }
            else
            {
                if( $update == 'false' )//Se entrar aqui, grava.
                {
                    $subCategoria = new subCategoria($categoria, $titulo, $imagem, $descri, $status);        
                }
                else//Se entrar aqui, update.
                {
                    $subCategoria = new subCategoria($categoria, $titulo, $imagem, $descri, $status, $update, $idSubCat);
                }
            }
        }
        ?>
        
        <div class="d2Sub">
            <div id="topo">
                <div class='imgCategoria' style="width:40px">
                    <p>Imagem</p>
                </div>
                <div class='tituloCategoria'>
                    <p>Subcategoria</p>
                </div>
                <div class='statusCategoria'>
                    <p>Status</p>
                </div>
                <div class='opcoesCategoria'>
                    <p>Opção</p>
                </div>
            </div>
            <div id="listaSubCategorias">
                <?php
                $subcategoria = new subCategoria();//Parei aqui.
                $cont      = $subcategoria->getQuantSubCategorias();

                for( $x=1; $x<=$cont[0]; $x++)
                {
                    $sub          = $subcategoria->getSubCategoria($x);
                    $idSub        = $sub[0];
                    $idCat        = $sub[1];
                    $subTitulo    = $sub[2]; //Título da categoria
                    $subDirImagem = $sub[3]; //Diretório da imagem da categoria
                    if( $subDirImagem == NULL )
                    {
                        $subDirImagem = "../../Imagens/noimage.jpg";
                    }
                    $subDescri    = $sub[4]; //Descrição da categoria
                    $subStatus    = $sub[5]; //Status da categoria
                    
                    echo "
                        <div id='categoria'>
                            <div class='imgCategoria'>
                                <a href=\"javascript:popupImagem('../../$subDirImagem', '$subTitulo');\"><img align='center' src='../../$subDirImagem' width='29px' height='24px' /></a>
                            </div>

                            <div class='tituloCategoria'>
                                <a href='FrmSubGrupos.php?action=popula&item=$idSub' title='$subDescri' style='text-decoration:none;'><p style='color:#4682B4;'>$subTitulo</p></a>
                            </div>";
                    if( $subStatus == 'ativo')
                    {
                        echo "
                            <div class='statusCategoria'>
                                <a href='FrmSubGrupos.php?action=changeStatus&item=$idSub' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:green;'>$subStatus</p></a>
                            </div>";
                    }
                    else if( $subStatus == 'inativo')
                    {
                        echo "
                            <div class='statusCategoria'>
                                <a href='FrmSubGrupos.php?action=changeStatus&item=$idSub' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:red;'>$subStatus</p></a>
                            </div>";
                    }

                    echo "
                            <div class='opcoesCategoria'>
                                <a href='FrmSubGrupos.php?action=popula&item=$idSub' title='Editar subcategoria' ><img src='../imagens/editar.png' width='24px' height='24px'></a>
                            </div>
                        </div>";
                }
                ?> 
            </div>
        </div>
    </div>
</body>
