<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/inputs.css" type="text/css" media="screen" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/functions.js"></script>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Cadastrar categoria:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    <?php    
    include('../../classes/config.php');
    include('../classes/categoria.php');
    
    $ac = $_GET['action'];
    $id = $_GET['idCat']; //Id da categoria.
    
    $config = new config();
    $categ = new categoria();
    
    if( $ac == 'popula')
    {
        $c = $categ->getCategoria($id);
        
        $catTitulo    = $c[1]; //Título da categoria
        $catDirImagem = $c[2]; //Diretório da imagem da categoria
        $catDescri    = $c[3]; //Descrição da categoria
        $catStatus    = $c[4]; //Status da categoria
    }
    else if ( $ac == 'changeStatus' )
    {
        $categ->changeStatus($id);
    }
    ?>
    
    <div id="grups" align="center">
        <div class="d">

            <table width="400px" align="left" style="font:14px 'Arial';margin-left:20px;">
                <form <?php if($ac=='popula'){echo"action='FrmGrupos.php?action=enter&up=true&id=$id'";}else{echo"action='FrmGrupos.php?action=enter&up=false'";}?>method="post" enctype="multipart/form-data">                    
                    <tr>
                        <td>Título do grupo: <b style="color:red;">*</b></td><td><input class="inputGerenciador" type="text"<?php if($ac=='popula'){echo"value='$catTitulo'";}?> id="text" name="text"/></td>
                    </tr>
                    <tr>
                        <td>Imagem de chamada:</td><td><input type="button" id="procurar" onClick="fileOculto.click()" value="Procurar">&nbsp;<input type="text" <?php if($ac=='popula'){echo"value='$catDirImagem'";}?> id="file" size="20" disabled /></td>
                    </tr>
                    <tr>
                        <td>Descrição:</td><td><textarea id="descri" class="inputGerenciador" name="descri"><?php if($ac=='popula'){echo"$catDescri";}else{}?></textarea></td>
                    </tr>
                    <tr>
                        <td>Status:</td><td><input type="checkbox" <?php if($ac=='popula'){if($catStatus=='ativo'){echo"checked";}else{echo"status.click()";}}else{echo"checked";}?>  name="status" id="status">ativo
                    </tr>
                    <tr>
                        <td></td><td><input type="file" id="fileOculto" name="fileOculto" onChange="file.value = this.value;"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" id="logar" value="Salvar" />&nbsp;&nbsp;<input type="reset" id="cancel" value="Limpar" /></td><td></td>
                    </tr>
                </form>
            </table>
        </div>
         <?php
         $action = $_GET["action"];
         $update = $_GET["up"];
         $id     = $_GET["id"];

         if( $action == 'enter' ) 
         {
             $titulo = $_POST['text'];
             $imagem = isset($_FILES["fileOculto"]) ? $_FILES["fileOculto"] : FALSE;
             $descri = $_POST['descri'];
             $status = (isset($_POST['status'])) ? 'ativo' : 'inativo';
             
             if( $titulo == NULL)
             {
                 // Comando mais abaixo para carregar o iframe completo antes de alertar.
             }
             else
             {             
                if( $update == 'false')//Se entrar aqui, grava.
                {
                    $cat = new categoria($titulo, $imagem, $descri, $status);        
                }
                else//Se entrar aqui, update.
                {
                    $cat = new categoria($titulo, $imagem, $descri, $status, $update, $id);
                }
                echo "<script>atualizaParent()</script>"; // Atualiza o iframe das subcategorias.
             }
         }
         ?>
        

        <div class="d2Cat">
            <div id="topo">
                <div class='imgCategoria' style="width:40px">
                    <p>Imagem</p>
                </div>
                <div class='tituloCategoria'>
                    <p>Categoria</p>
                </div>
                <div class='statusCategoria'>
                    <p>Status</p>
                </div>
                <div class='opcoesCategoria'>
                    <p>Opção</p>
                </div>
            </div>
            <div id="listaCategorias">
                <?php
                $categoria = new categoria();
                $cont      = $categoria->getQuantCategorias();

                for( $x=1; $x<=$cont[0]; $x++)
                {
                    $cat          = $categoria->getCategoria($x);
                    $catId        = $cat[0];
                    $catTitulo    = $cat[1]; //Título da categoria
                    $catDirImagem = $cat[2]; //Diretório da imagem da categoria
                    if( $catDirImagem == NULL )
                    {
                        $catDirImagem = "../../Imagens/noimage.jpg";
                    }
                    $catDescri    = $cat[3]; //Descrição da categoria
                    $catStatus    = $cat[4]; //Status da categoria

                    echo "
                        <div id='categoria'>
                            <div class='imgCategoria'>
                                <a href=\"javascript:popupImagem('../../$catDirImagem', '$catTitulo');\"><img align='center' src='../../$catDirImagem' width='29px' height='24px' /></a>
                            </div>

                            <div class='tituloCategoria'>
                                <a href='FrmGrupos.php?action=popula&idCat=$catId' title='$catDescri' style='text-decoration:none;'><p style='color:#4682B4;'>$catTitulo</p></a>
                            </div>";
                    if( $catStatus == 'ativo')
                    {
                        echo "
                            <div class='statusCategoria'>
                                <a href='FrmGrupos.php?action=changeStatus&idCat=$catId' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:green;'>$catStatus</p></a>
                            </div>";
                    }
                    else if( $catStatus == 'inativo')
                    {
                        echo "
                            <div class='statusCategoria'>
                                <a href='FrmGrupos.php?action=changeStatus&idCat=$catId' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:red;'>$catStatus</p></a>
                            </div>";
                    }

                    echo "
                            <div class='opcoesCategoria'>
                                <a href='FrmGrupos.php?action=popula&idCat=$catId' title='Editar categoria' ><img src='../imagens/editar.png' width='24px' height='24px'></a>
                            </div>
                        </div>";
                }
                ?>
            </div>
        </div>
    </div>
    <?php
        $action = $_GET["action"];
        
        if( $action == 'enter' ) 
        {
            if( $titulo == NULL)
            {
                echo"<script>alert(\"TÍTULO OBRIGATÓRIO!!!\");</script>";
            }
        }
        ?>
</body>
