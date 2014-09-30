<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/inputs.css" type="text/css" media="screen" />
<script type="text/javascript" src="../js/functions.js"></script>
<script type="text/javascript" src="../../js/validateFunctions.js"></script>

<?php
$imagem = $_FILES['fileOculto'];
$action = $_GET['action'];
$dir    = "../../Imagens/banner/";

if( $action == 'salvar' )
{
    if( isset($imagem) ) 
    {
        if (eregi('^image\/(pjpeg|jpeg|png|gif|bmp)$', $imagem['type'])) 
        {
            move_uploaded_file($imagem['tmp_name'], $dir.$imagem['name']);
        }
        else
        {
            echo "<script>alert('Arquivo inválido');</script>";
        }
    }
}
else if( $action == 'deletar' )
{
    $imagem = $_GET['imagem'];
    unlink($dir.$imagem);
}


?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Imagens do banner principal:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        <form action="FrmBanners.php?action=salvar" method="post" enctype="multipart/form-data">
            <table width="500px" style="font:14px 'Arial';margin-top:10px;">
                <tr>
                    <td>Selecione a imagem:</td><td><input type="button" id="procurar" onClick="fileOculto.click()" value="Procurar">&nbsp;<input type="text" <?php if($ac=='popula'){echo"value='$catDirImagem'";}?> id="file" size="20" disabled /></td><td><input type="submit" id="logar" value="Upload"/></td>
                </tr>            
            </table>
            <input type="file" id="fileOculto" name="fileOculto" onChange="file.value = this.value;">
        </form>
        <div id="imgsBanner">
            <?php
                $dir = opendir("../../Imagens/banner/");
                $cont = 0;

                echo"<table align='center' width='330px' cellpadding='4'><tr>";

                while ($read = readdir($dir)) {
                    if ($read != '.' && $read != '..') {                        
                        $del = "<a href='javascript:void(0);' onclick=\"yesOrNotWhatever('Deseja excluir esta imagem?', 'FrmBanners.php?action=deletar&imagem=$read')\" title='Deletar imagem'><img src='../imagens/deletar.png' border='0' title='Deletar'></a>";                        

                        echo "<td align='right'>
                                <div id='del'>                                    
                                    $del
                                </div>
                                <a href=\"javascript:popupImagem('../../Imagens/banner/$read', 'null');\"><img id='imgP' src='../../Imagens/banner/$read' height='90' width='200' title='Clique para ampliar' /></a>
                              </td>";
                        $cont++;
                    }
                    if ($cont == 3) {
                        echo "</tr><tr>";
                        $cont = 0;
                    }
                }
                echo "</tr></table><br>";
                closedir($dir);
            ?>
        </div>
    </div>
</body>

