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
include('../classes/servico.php');

$config = new config();

$action    = $_GET['action'];
$item      = $_GET['item'];
$idServ    = $_GET['id'];
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
    $s = new servico();
    $s->changeStatus($idServ);
}

if( $editar == 'true' )
{
    $prim = FALSE;
    $s = new servico();    
    $dadosServ = $s->getServico($idServ);
    
    $sId     = $dadosServ[0];
    $sTitulo = $dadosServ[1];
    $sStatus = $dadosServ[2];
    $sDescri = $dadosServ[3];
}
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Cadastrar serviços:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        
        <div class="d" style="margin-left:10px;">
            <form <?php if($editar!='true'){echo"action='FrmServiços.php?salvar=true'";}else{echo"action='FrmServiços.php?salvar=true&update=true&idServ=$idServ'";}?> method="post">
                <table width="350px" style="font:14px 'Arial';">                    
                    <tr>
                        <td>Título: <b id="obrigatory">*</b></td><td><input class="inputGerenciador" type="text" name="text" id="text" <?php if($editar=='true'){echo"value='$sTitulo'";}?>></td>
                    </tr>
                    <tr>
                        <td>Status:</td><td><input type="checkbox" <?php if($editar=='true'){if($sStatus=='ativo'){echo"checked";}else{echo"status.click()";}}else{echo"checked";}?> name="status" id="status">ativo</td>
                    </tr>
                </table>
                <div id="editor" align="left" width="350px">
                    <p align='left' style="font:14px 'Arial';">Descrição:</p>
                    <textarea cols="80" id="editor1" name="editor1" rows="10"><?php if($editar=='true'){echo"$sDescri";}?></textarea>
                    <script type='text/javascript'>ckeditorConfig();</script><br>                    
                    <input type="submit" value="Salvar" name="salvar" id="logar">&nbsp&nbsp&nbsp&nbsp<input type="reset" value="cancelar" id="cancel" name="cancel">
                </div>
                
            </form>
            <?php            
            $salvar  = $_GET['salvar'];
            $update  = $_GET['update'];
            $deletar = $_GET['deletar'];
            $id      = $_GET['idServ'];
            
                
            if( $salvar == 'true' )
            {
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
                        $servico = new servico( $titulo, $status, $descri );
                    }
                    else
                    {
                        $servico = new servico( $titulo, $status, $descri, $id, TRUE );
                    }
                }
            }
            else if( $deletar == 'true' )
            {
                // DELETAR O PRODUTO CONFORME ID.                
                $servico = new servico();
                $servico->deletarServico($id);
            }
            ?>
        </div>
      
        <div class="d2Serv">
            <div id="topo">
                <div class='imgProduto' style="width:40px">
                    <p>Imagens</p>
                </div>
                <div class='tituloProduto'>
                    <p>Serviço</p>
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
                $servico = new servico();
                $cont = $servico->getAllIds();
                $x    = 0;
                
                while( $cont[$x] != 'end' )
                {
                    $dadosServico = $servico->getServico($cont[$x]);
                    
                    $servId  = $dadosServico[0]; // id produto
                    $titulo  = $dadosServico[1]; // titulo do produto
                    $status  = $dadosServico[2]; // status do produto
                    $descri  = $dadosServico[3]; // descrição do produto

                    echo "
                        <div id='produto'>
                            <div class='imgProduto'>
                                <a href=\"imagensServiços.php?id=$servId\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Escolher imagens', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 700, height:580 } )\"><img src=\"../imagens/imagens.png\" title=\"Uploader de imagens\" border=\"0\" width=\"22px\" height=\"22px\"></a>
                            </div>

                            <div class='tituloProduto'>
                                <a href='FrmServiços.php?editar=true&id=$servId' title='$descri' style='text-decoration:none;'><p style='color:#4682B4;'>$titulo</p></a>
                            </div>";
                    if( $status == 'ativo')
                    {
                        echo "
                            <div class='statusProduto'>
                                <a href='FrmServiços.php?action=changeStatus&id=$servId' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:green;'>$status</p></a>
                            </div>";
                    }
                    else if( $status == 'inativo')
                    {
                        echo "
                            <div class='statusProduto'>
                                <a href='FrmServiços.php?action=changeStatus&id=$servId' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:red;'>$status</p></a>
                            </div>";
                    }

                    echo "
                            <div class='opcoesProdutos'>
                                <a href='FrmServiços.php?editar=true&id=$servId' title='Editar produto' ><img src='../imagens/editar.png' width='25px' height='22px'></a>&nbsp&nbsp&nbsp&nbsp
                                <a href='javascript:void(0);' onclick=\"yesOrNotWorks('Deseja excluir este serviço?', $servId)\" title='Deletar produto'><img src='../imagens/deletar.png' width='19px' height='19px'></a>
                            </div>
                        </div>";
                    $x++;
                }
                ?>
            </div>
        </div>
    </div>
</body>
