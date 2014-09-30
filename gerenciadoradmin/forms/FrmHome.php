<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/inputs.css" type="text/css" media="screen" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script> 
<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../ckeditor/adapders/jquery.js"></script>
<script type="text/javascript" language="javascript">
    $(function() { $('textarea.ckeditor').ckeditor(); });
</script>

<?php
include('../../classes/config.php');
include('../../classes/home.php');

$config = new config();
$home = new home('home', 'conteudo');
$conteudoHome = $_REQUEST['ckhome'];

if( $conteudoHome != null )
{
    $home->updateHome($conteudoHome);
}
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
            <div class='titulos'>
                <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Conteúdo 'Sobre nós':</p>
            </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
        
    <form action="FrmHome.php" method="request">
        <?php
        $conteudo = $home->imprimirHome();
        echo "<textarea class='ckeditor' cols='5' id='ckhome' name='ckhome' rows='10'>$conteudo</textarea><br>";
        ?>
        <table width="200px" align="left">
            <tr>
                <td align="center"><input type="submit" id="logar" value="Salvar" /></td><td align="center"><input type="reset" id="cancel" value="Limpar" /></td>
            </tr>
        </table>
    </form>
</body>
