<?php
include('classes/session.php');
include('classes/config.php');
include('classes/users.php');

$session = $_GET['session'];

if( $session == null )
{
    $userSession = new session();
    $session = $userSession->__get('session');
    session_start($session);
}

if ( $_REQUEST['action'] == 'logout' )
{
    session_destroy('secao');
}

$_SESSION['secao'] = $session;

?>
<html>
    <head>
        <meta content="TECNON Soluções em Sistemas" name="AUTHOR"/> 			
        <meta content="Tecnon, Soluções em Sistemas Empresarias" name="DESCRIPTION"/> 			
        <meta content="altari, altari s/a, carrocerias altari, altari sa, carrocerias estrela, carrocerias, altari carrocerias, estrela altari" name="KEYWORDS"/> 			
        <meta content="index,follow" name="ROBOTS"/> 			
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>

        <link rel='SHORTCUT ICON' href='Imagens/icon.ico'>
        <title>Altari S/A</title>
        <script language="JavaScript1.2">
            var nom = navigator.appName;
            if( nom == 'Firefox' )
            {
                //alert('Firefox');
                document.write('<link href="css/bodyFirefox.css" media="screen" rel="stylesheet" type="text/css"/>');
                document.write('<link href="css/corpo.css" media="screen" rel="stylesheet" type="text/css"/>');
            }
            else if( nom == 'Microsoft Internet Explorer')
            {
                document.write('<link href="css/bodyExplorer.css" media="screen" rel="stylesheet" type="text/css"/>');
                document.write('<link href="css/corpoExplorer.css" media="screen" rel="stylesheet" type="text/css"/>');
				alert('Este site é melhor visualizado nos navegadores Google Chrome, Firefox e Opera, pois possui tecnologias no qual o Internet Explorer não suporta.');
            }
            else
            {
                document.write('<link href="css/bodyOthers.css" media="screen" rel="stylesheet" type="text/css"/>');
                document.write('<link href="css/corpo.css" media="screen" rel="stylesheet" type="text/css"/>');
            }
        </script>                
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />        
        <script type="text/javascript" src="gerenciadoradmin/js/functions.js"></script>        
        
        <script src="lightbox/js/jquery-1.7.2.min.js"></script>
        <script src="lightbox/js/lightbox.js"></script>
        <link href="lightbox/css/lightbox.css" rel="stylesheet" />

        <link type="text/css" href="css/menu.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/menu.js"></script>
        <script type="text/javascript" src="js/atualiza.js"></script>
        <link href="gerenciadoradmin/css/inputs.css" media="screen" rel="stylesheet" type="text/css"/>        
        
        <script type="text/javascript" src="gerenciadoradmin/forms/highslide/highslide-with-html.js"></script>
        <link rel="stylesheet" type="text/css" href="gerenciadoradmin/forms/highslide/highslide.css" />
        <script type="text/javascript">
                hs.graphicsDir = 'gerenciadoradmin/forms/highslide/graphics/';
                hs.outlineType = 'rounded-white';
                hs.showCredits = false;
                hs.wrapperClassName = 'draggable-header';
        </script>
        <script type="text/javascript" src="js/validateFunctions.js"></script>
    </head>
    
    <body align='center' width='900px;'>
        <div id="principal">
            <div style="background: #fff;">
                <div class="bordaBox">                
                    <div class='data' align="left">
                        <?php
                        include("classes/data.php");
                        $d = new data();
                        echo $d->getDataCompleta();

                        $config = new config();

                        $logado = true;

                        if( $session != null )
                        {
                            $login = $_REQUEST['login'];
                            $senha = $_REQUEST['senha'];
                            $user = new users();

                            if( isset($login) )
                            {
                                if( $user->loginUser($login, $senha) )
                                {
                                    $_SESSION['login'] = $login;
                                    $logado = true;
                                    echo "<script>window.history.replaceState('', '', 'principal.php' );</script>";
                                }
                                else
                                {
                                    $logado = false;                                
                                }
                            }

                            if( (isset($_SESSION['login'])) && ($user->loginUserLog($_SESSION['login'])) )
                            {
                                $nome = $user->getNameUserByLogin($_SESSION['login']);

                                echo "<table width=\"auto\" style=\"float:right;font-family:'Trebuchet MS', Arial;font-size:11px;\">
                                        <form id='formLog' name='formLog'>
                                            <tr>
                                                <td><b style=\"color:#999;float:right;\">Olá</b></td><td><b style='color:blue;'>{$nome[0]}</b><b style=\"color:#999;\"> !</b></td><td><a id='loginUser' href='javascript:void(0);' onClick=\"window.location.href=window.location.href+'action=logout'\">Logout</a></td>
                                            </tr>
                                        </form>
                                    </table>";
                            }
                            else
                            {
                                echo "<table width=\"auto\" style=\"float:right;font-family:'Trebuchet MS', Arial;font-size:11px;\">
                                        <form id='formLog' name='formLog' method='post'>
                                            <tr>
                                                <td><b style=\"color:#999;\">Login:</b></td><td><input type=\"text\" style=\"height:20px;width:100px;margin-right:5px;\" name=\"login\" id=\"login\" /></td>
                                                <td><b style=\"color:#999;\">Senha:</b></td><td><input type=\"password\" style=\"height:20px;width:100px;margin-right:5px;\" name=\"senha\" id=\"passwd\" /></td>
                                                <td><a id='loginUser' href=\"javascript:void(0);\" onClick=\"formLog.submit();\">Logar</a></td>
                                                <td><a id='loginUser' href='javascript:void(0);' onClick=\"javascript:atualiza('orcar.php?session=$session', 'conteudo');\">Cadastre-se</a></td>
                                            </tr>
                                        </form>
                                    </table>";
                            }
                        }
                        ?>                
                    </div>            
                    <b class="b41"></b><b class="b31"></b><b class="b21"></b><b class="b11"></b>				
                </div>

                <div id='logo' align="center">
                    <img src='Imagens/logo.jpg' width='600px' height='120px'>
                </div>
            </div>

            <div class='fora'>
                <div class="bordaBox">
                    <b class="b11"></b><b class="b21"></b><b class="b31"></b><b class="b41"></b>
                    <div class='topoIndex'>			
                        <div id='m'>
                            <div id="menu">
                                <ul class="menu">
                                    <?php
                                    echo "
                                    <li><a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('home.php?session=$session', 'conteudo');\"><span>Home</span></a>					  
                                    </li>
                                    <li><a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('categorias.php?session=$session', 'conteudo');\"><span>Carrocerias</span></a></li>
                                    <li><a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('servicos.php?session=$session', 'conteudo');\"><span>Nossos serviços</span></a></li>
                                    <li><a id='orc' href=\"javascript:void(0);\" onclick=\"javascript:atualiza('orcar.php?session=$session', 'conteudo');\"><span>Orçamentos</span></a></li>
                                    <li class=\"last\"><a href=\"contato.php\" id=\"formcontato\" class=\"highslide\" onclick=\"return hs.htmlExpand( this, {
                                    objectType: 'iframe', headingText: 'Contato', outlineType: 'rounded-white', wrapperClassName: 'titlebar',
                                    outlineWhileAnimating: true, preserveContent: false, width: 500, height:550 } )\"><p style='margin-top:6px;width:65px;margin-right:10px !important;'>Contato</p></a></li>                                ";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>
                </div>
            </div>

            <div class="bordaBox">
                <b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
                <div class='corpo'>
                    <div id="center">

                        <div align='center' id="frameBanner">
                            <iframe src="banner.php" id="lista" width='875px' height='250px' frameBorder='no' frameSpacing='0' marginHeight='0' marginWidth='0' name="content"></iframe>
                        </div><br>

                        <?php
                        $action = $_GET['act'];
                        $user   = $_GET['user'];

                        if( $action == 'orcar' )
                        {
                            echo "<script>
                                    var url = 'listaProdutos.php?$user';
                                    atualiza(url, 'conteudo');
                                </script>";
                        }
                        else
                        {
                            echo "<script>atualiza('home.php', 'conteudo');</script>";
                        }
                        ?>                    
                        <div id='conteudo' align="center">
                            <!--Aqui será carregado todos os conteúdos da página-->
                        </div>
                    </div>

                </div>
                <b class="b4"></b><b class="b3"></b><b class="b2"></b><b class="b1"></b>
            </div>

            <div class="bordaBox">
                <b class="b1" style="background:#4682B4;"></b><b class="b2" style="background:#4682B4;"></b><b class="b3" style="background:#4682B4;"></b><b class="b4" style="background:#4682B4;"></b>
                <div class='footer'>                
                    <div id="footerOut">

                        <div class="altari" style="float:left;margin-left:50px;">                        
                            <div id="for" style="display: block;">
                                <div class="info" style="width:270px;float:left;"><br><br>                                
                                    <b style="color:#fff;font-size:12px;margin-left:5px;">BR-386, Km-354, Bairro Santa Rita, Estrela RS</b>
                                    <b style="color:#fff;font-size:12px;margin-left:5px;">Telefone para contato: (51)3712-21-11</b><br>
                                    <b style="color:#fff;font-size:12px;margin-left:5px;">Altari S/A - Todos direitos reservados</b>
                                </div>
                            </div>                        
                        </div>

                        <div class="tecnon" style="float:right;margin-right:60px;margin-top:20px;">
                            <div>
                                <b align="center" style="color:#fff;font-size:12px;">Desenvolvimento</b><br>
                                <img src="Imagens/tecnon.png" width="150px" height="40px">
                            </div>
                        </div>

                    </div>

                    <div id="copyright" align='right' style='background: red;width:0px;color:#fff'>
                        <a href="http://apycom.com/"></a>                    
                    </div>
                </div>				
            </div>
            <?php
            if( !$logado )
            {
                echo "<script>alert('Login ou senha inválida!');</script>";
            }        
            ?>
        </div>
    </body>
</html>
