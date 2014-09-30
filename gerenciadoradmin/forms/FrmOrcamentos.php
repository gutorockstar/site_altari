<?php
session_start();
?>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/inputs.css" type="text/css" media="screen" />

<script type="text/javascript" src="../js/functions.js"></script>
<script type="text/javascript" src="../../js/validateFunctions.js"></script>
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
include('../../classes/users.php');
include('../classes/logins.php');
include('../../classes/email.php');
$config = new config();

$adminLogin = $_SESSION["adminLogin"];

$action  = $_GET['action'];
$action2 = $_GET['action2'];
$idOrc   = $_GET['idOrc'];
$idCont  = $_GET['idCont'];
$change  = $_GET['changeStatus'];

if ( $change == 'true' )
{
    $users  = new users();
    
    if ( isset($idOrc) )
    {        
        $users->changeStatusOrc($idOrc);
    }
    else
    {
        $users->changeStatusCont($idCont);
    }
}

if( $action == 'resendOrc' )
{
    $admin      = new logins();
    $idLog      = $admin->getIdloginByLogin($adminLogin);
    $dadosAdmin = $admin->getLogin($idLog[0]);
    
    $de    = $dadosAdmin[2];
    $para  = $_GET['para'];
    $assunto = 'Requisição de orçamento';
}
else if( $action == 'resendCont' )
{
    $admin      = new logins();
    $idLog      = $admin->getIdloginByLogin($adminLogin);
    $dadosAdmin = $admin->getLogin($idLog[0]);
    
    $de    = $dadosAdmin[2];
    $para  = $_GET['para'];
    $assunto = 'Contato do site';
}
else if( $action == 'send' )
{    
    if( $idOrc != null )
    {
        $para  = $_POST['emailPara'];
        $de    = $_POST['cc'];
        $resp  = $_POST['editor1'];

        if( ($para != null) && ($de != null) && ($resp != null) )
        {
            $email = new email($resp, 'Requisição de orçamento', $de, $para, null, true, $idOrc);
            echo "<script>alert('Orçamento respondido com sucesso.');</script>";
        }
        else
        {
            echo "<script>alert('Campos obrigatórios não foram preenchidos!');</script>";
        }
    }
    
    if( $idCont != null )
    {
        $para  = $_POST['emailPara'];
        $de    = $_POST['cc'];
        $resp  = $_POST['editor1'];

        if( ($para != null) && ($de != null) && ($resp != null) )
        {
            $email = new email($resp, 'Contato do site', $de, $para, null, true, null, $idCont);
            echo "<script>alert('Contato respondido com sucesso.');</script>";
        }
        else
        {
            echo "<script>alert('Campos obrigatórios não foram preenchidos!');</script>";
        }
    }
}
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Contatos e orçamentos requisitados por usuários:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        <div class="responderOrç">
            <form <?php if($action=='resendOrc'){echo "action='FrmOrcamentos.php?action=send&idOrc=$idOrc'";}elseif($action=='resendCont'){echo"action='FrmOrcamentos.php?action=send&idCont=$idCont'";}?> method="post">
                <table width="350px" style="font:14px 'Arial';">
                    <tr>
                        <td>Para:</td><td><input type="text" id="emailPara" name="emailPara" <?php if($action2=='resend'){echo"value='$para'";}?>/></td>
                    </tr>
                    <tr>
                        <td>De:</td><td><input type="text" id="cc" name="cc" <?php if($action2=='resend'){echo"value='$de' style='border:2px solid #999;' disabled";}?>/></td>                        
                    </tr>
                    <tr>
                        <td>Assunto:</td><td><input type="text" id="assunto" name="assunto" <?php if($action2=='resend'){echo"value='$assunto'";}?>/></td>
                    </tr>
                </table>
                <div id="editor" align="left" width="350px">
                    <p align='left' style="font:14px 'Arial';">Mensagem:</p>
                    <textarea cols="80" id="editor1" name="editor1" rows="10"></textarea>
                    <script type='text/javascript'>ckeditorConfig();</script><br>                    
                </div>                
            </form>
        </div>        
        
        <div class="orcamentos">
            <div id="topo">
                <div class='dataOrç'>
                    <p>Data</p>
                </div>
                <div class='nameUserOrç'>
                    <p>Remetente</p>
                </div>
                <div class='assuntoUserOrç'>
                    <p>Assunto</p>
                </div>
                <div class='statusOrç'>
                    <p>Status</p>
                </div>
                <div class='optOrç'>
                    <p>Opt.</p>
                </div>
            </div>        
        
            <div id="listaOrcamentos">
                <?php                
                $config = new config();
                $users  = new users();

                $cont = $users->getIdsOrcamentos();
                $x    = 0;

                while( $cont[$x] != 'end' )
                {
                    $dadosOrca = $users->getOrcamento($cont[$x]);

                    $idOrc    = $dadosOrca[0];
                    $data     = $dadosOrca[1];
                    $nome     = $dadosOrca[2];
                    $email    = $dadosOrca[3];
                    $fone     = $dadosOrca[4];
                    $mensagem = $dadosOrca[5];
                    $status   = $dadosOrca[6];

                    if( $status == 'aguardando' )
                    {
                        $color = "style='color:red;font-weight:bold;'";
                        $src   = "src='../imagens/emailClose.png'";
                    }
                    else
                    {
                        $color = "style='color:green;font-weight:bold;'";
                        $src   = "src='../imagens/emailOpen.png'";
                    }

                    echo "<div id='orcamento'>
                            <div class='dataOrçList'>                                
                                <a href=\"orçamento.php?orcamento=$mensagem\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Mensagem', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\"><p style='font-weight:bold;color:#222;' title='Clique para ver o orçamento'>$data</p></a>
                            </div>
                            <div class='nameUserOrçList'>                                
                                <a href=\"orçamento.php?orcamento=$mensagem\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Mensagem', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\"><p style='color:#4682B4;' title='Clique para ver o orçamento'>$nome</p></a>
                            </div>
                            <div class='assuntoUserOrçList'>
                                <a href=\"orçamento.php?orcamento=$mensagem\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Mensagem', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\"><p style='color:#4682B4;' title='Clique para ver o orçamento'>Requisição de orçamento</p></a>
                            </div>
                            <div class='statusOrçList'>
                                <a href=\"FrmOrcamentos.php?idOrc=$idOrc&changeStatus=true\" style='text-decoration:none;'><p $color title='Clique para alterar o status'>$status</p></a>
                            </div>
                            <div class='optOrçList'>
                                <a href='FrmOrcamentos.php?action=resendOrc&action2=resend&idOrc=$idOrc&para=$email'><img  $src width='20px' height='25px' title='Responder orçamento'/></a>
                            </div>
                        </div>";
                    $x++;
                }
                
                $users  = new users();

                $cont = $users->getIdsContatos();
                $x    = 0;

                while( $cont[$x] != 'end' )
                {
                    $dadosCont = $users->getContato($cont[$x]);

                    $idCont   = $dadosCont[0];
                    $data     = $dadosCont[1];
                    $nome     = $dadosCont[2];
                    $email    = $dadosCont[3];
                    $fone     = $dadosCont[4];
                    $mensagem = $dadosCont[5];
                    $status   = $dadosCont[6];

                    if( $status == 'aguardando' )
                    {
                        $color = "style='color:red;font-weight:bold;'";
                        $src   = "src='../imagens/emailClose.png'";
                    }
                    else
                    {
                        $color = "style='color:green;font-weight:bold;'";
                        $src   = "src='../imagens/emailOpen.png'";
                    }

                    echo "<div id='orcamento'>
                            <div class='dataOrçList'>                                
                                <a href=\"orçamento.php?orcamento=$mensagem\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Mensagem', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\"><p style='font-weight:bold;color:#222;' title='Clique para ver o orçamento'>$data</p></a>
                            </div>
                            <div class='nameUserOrçList'>                                
                                <a href=\"orçamento.php?orcamento=$mensagem\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Mensagem', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\"><p style='color:#4682B4;' title='Clique para ver o orçamento'>$nome</p></a>
                            </div>
                            <div class='assuntoUserOrçList'>
                                <a href=\"orçamento.php?orcamento=$mensagem\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                objectType: 'iframe', headingText: 'Mensagem', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                outlineWhileAnimating: true, preserveContent: false, width: 500, height:300 } )\"><p style='color:#4682B4;' title='Clique para ver o orçamento'>Contato do site</p></a>
                            </div>
                            <div class='statusOrçList'>
                                <a href=\"FrmOrcamentos.php?idCont=$idCont&changeStatus=true\" style='text-decoration:none;'><p $color title='Clique para alterar o status'>$status</p></a>
                            </div>
                            <div class='optOrçList'>
                                <a href='FrmOrcamentos.php?action=resendCont&action2=resend&idCont=$idCont&para=$email'><img  $src width='20px' height='25px' title='Responder orçamento'/></a>
                            </div>
                        </div>";
                    $x++;
                }
                ?>
            </div>
        </div>
    </div>
</body>
