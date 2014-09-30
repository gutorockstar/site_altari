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

<link rel="stylesheet" type="text/css" media="all" href="../js/jscalendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="../js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="../js/jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="../js/jscalendar/calendar-setup.js"></script>

<?php
include('../../classes/config.php');
include('../../classes/data.php');
include('../classes/noticia.php');

$config = new config();
$date   = new data();

$action = $_GET['action'];
$idNot  = $_GET['idNot'];
$editar = $_GET['editar'];

if ( $action == 'changeStatus' )
{
    $n = new noticia();
    $n->changeStatus($idNot);
}

if( $editar == 'true' )
{
    $n = new noticia();    
    $dadosNot = $n->getNoticia($idNot);
    
    $nId        = $dadosNot[0];
    $nTitulo    = $dadosNot[1];
    $nSDate     = $dadosNot[2];
    $nStartDate = $date->convertDateToIndex($nSDate);
    $nEDate     = $dadosNot[3];
    $nEndDate   = $date->convertDateToIndex($nEDate);
    $nStatus    = $dadosNot[4];
    $nDescri    = $dadosNot[5];
}
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Notícias da empresa:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        
        <div class="d" style="margin-left:5px;">
            <form <?php if($editar!='true'){echo"action='FrmNoticias.php?salvar=true'";}else{echo"action='FrmNoticias.php?salvar=true&update=true&idNot=$nId'";}?> method="post">
                <table width="350px" style="font:14px 'Arial';">
                    <tr>
                        <td>Título: <b id="obrigatory">*</b></td><td><input type="text" name="nTitulo" id="text" <?php if($editar=='true'){echo"value='$nTitulo'";}?>></td>
                    </tr>
                    <tr>
                        <td>Data inicial: <b id="obrigatory">*</b></td><td><input type="text" name="startDate" id="f_date_c1" <?php if($editar=='true'){echo"value='$nStartDate'";}?> readonly="1" /><img src="../imagens/calendario.png" id="f_trigger_c1" style="cursor:pointer;"  width="19px" height="19px" title="Selecionar data inicial" onmouseover="this.style.background='#4682B4';" onmouseout="this.style.background=''" /></td>
                    </tr>
                    <tr>
                        <td>Data final: <b id="obrigatory">*</b></td><td><input type="text" name="endDate" id="f_date_c2" <?php if($editar=='true'){echo"value='$nEndDate'";}?> readonly="1" /><img src="../imagens/calendario.png" id="f_trigger_c2" style="cursor:pointer;"  width="19px" height="19px" title="Selecionar data inicial" onmouseover="this.style.background='#4682B4';" onmouseout="this.style.background=''" /></td>
                    </tr>
                    <tr>
                        <td>Status:</td><td><input type="checkbox" <?php if($editar=='true'){if($nStatus=='ativo'){echo"checked";}else{echo"status.click()";}}else{echo"checked";}?> name="status" id="status">ativo</td>
                    </tr>
                </table>
                <div id="editor" align="left" width="350px">
                    <p align='left' style="font:14px 'Arial';">Descrição:<b id="obrigatory">*</b></p>
                    <textarea cols="80" id="editor1" name="editor1" rows="10"><?php if($editar=='true'){echo"$nDescri";}?></textarea>
                    <script type='text/javascript'>ckeditorConfig();</script><br>                    
                    <input type="submit" value="Salvar" name="salvar" id="logar">&nbsp&nbsp&nbsp&nbsp<input type="reset" value="cancelar" id="cancel" name="cancel">
                </div>                
            </form>
            <script>
                calendarOptionsStart();
                calendarOptionsEnd();
            </script>
            <?php            
            $salvar  = $_GET['salvar'];
            $update  = $_GET['update'];
            $deletar = $_GET['deletar'];
            $id      = $_GET['idNot'];
            $date = new data();
                
            if( $salvar == 'true' )
            {                
                $nTitulo   = $_POST['nTitulo'];
                $sDate     = $_POST['startDate'];
                $startDate = $date->convertDateToBase($sDate);
                $eDate     = $_POST['endDate'];
                $endDate   = $date->convertDateToBase($eDate);
                $status    = (isset($_POST['status'])) ? 'ativo' : 'inativo';
                $descri    = $_POST['editor1'];                
                
                if( ($nTitulo == NULL) && ($startDate == NULL) && ($endDate == NULL) && ($descri == NULL) )
                {
                    echo "<script>alert(\"Existem campos obrigatórios que não foram preenchidos!\");</script>";
                }
                else
                {
                    if( $update != 'true' )
                    {
                        $noticia = new noticia( $nTitulo, $startDate, $endDate, $status, $descri );
                    }
                    else
                    {
                        $noticia = new noticia( $nTitulo, $startDate, $endDate, $status, $descri, $id, TRUE );
                    }
                }
            }
            else if( $deletar == 'true' )
            {
                // DELETAR O PRODUTO CONFORME ID.                
                $noticia = new noticia();
                $noticia->deletarNoticia($id);
                echo "<script>alert(\"Notícia deletada.\");</script>";
            }
            ?>
        </div>
        
      
        <div class="d2Not">
            <div id="topo">
                <div class='tituloNot'>
                    <p>Notícia</p>
                </div>
                <div class='dataInicial'>
                    <p>Data inicial</p>
                </div>
                <div class='dataFinal'>
                    <p>Data final</p>
                </div>
                <div class='statusNot'>
                    <p>Status</p>
                </div>
                <div class='optNot'>
                    <p>opt.</p>
                </div>
            </div>
            <div id="listaNoticias">
                <?php
                $date = new data();
                $not = new noticia();
                $cont = $not->getAllIds();
                $x    = 0;
                
                while( $cont[$x] != 'end' )
                {
                    $dadosNot = $not->getNoticia($cont[$x]);
                    
                    $idNot     = $dadosNot[0];                 
                    $titulo    = $dadosNot[1];
                    $sDate     = $dadosNot[2];
                    $startDate = $date->convertDateToIndex($sDate);
                    $eDate     = $dadosNot[3];
                    $endDate   = $date->convertDateToIndex($eDate);
                    $status    = $dadosNot[4];
                    $descri    = $dadosNot[5];

                    echo "
                        <div id='noticia'>
                            <div class='tituloNot'>
                                <p style='color:#4682B4;'>$titulo</p>
                            </div>

                            <div class='dataInicial'>
                               <p style='font-weight: bold;'>$startDate</p>
                            </div>
                 
                            <div class='dataFinal'>
                               <p style='font-weight: bold;'>$endDate</p> 
                            </div>";
                 
                    if( $status == 'ativo')
                    {
                        echo "
                            <div class='statusNot'>
                                <a href='FrmNoticias.php?action=changeStatus&idNot=$idNot' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:green;'>$status</p></a>
                            </div>";
                    }
                    else if( $status == 'inativo')
                    {
                        echo "
                            <div class='statusNot'>
                                <a href='FrmNoticias.php?action=changeStatus&idNot=$idNot' title='Clique para alterar o status' style='text-decoration:none;'><p style='color:red;'>$status</p></a>
                            </div>";
                    }

                    echo "
                            <div class='optNot'>
                                <a href='FrmNoticias.php?editar=true&idNot=$idNot' title='Editar notícia' ><img src='../imagens/editar.png' width='20px' height='22px'></a>
                                <a href='javascript:void(0);' onclick=\"yesOrNotNews('Deseja excluir esta notícia?', $idNot)\" title='Deletar notícia'><img src='../imagens/deletar.png' width='19px' height='19px'></a>
                            </div>
                        </div>";
                    $x++;
                }
                ?>
            </div>
        </div>
    </div>
</body>
<?php
$not = new noticia();
$not->getAllIdsValidate();
?>
