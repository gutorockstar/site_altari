<?php
    session_start();
    if( isset($_SESSION['adminLogin']) )
    {
        $actualAdmin = $_SESSION['adminLogin'];
    }
    
?>

<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/inputs.css" type="text/css" media="screen" />
<script type="text/javascript" src="../js/functions.js"></script>
<script type="text/javascript" src="../../js/validateFunctions.js"></script>

<?php
include('../../classes/config.php');
include('../classes/logins.php');

$action = $_GET['action'];

$config = new config();
if( $action == 'insert' )
{
    $nome  = $_POST['name'];
    $email = $_POST['email'];
    $fone  = $_POST['fone'];
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    
    if( ($nome != null)&&($nome != null)&&($nome != null)&&($nome != null)&&($nome != null) )
    {
        $logins = new logins();
        $validate = $logins->validaLogin($login);
        
        if( !isset($validate[0]) )
        {
            $login = new logins($nome, $email, $fone, $login, $senha);
        }
        else
        {
            echo "<script>alert('Login já existe!')</script>";
        }
    }
    else
    {
        echo "<script>alert('Campos obrigatórios não foram preenchidos!')</script>";
    }
}
else if( $action == 'delete' )
{
    $idLog = $_GET['idLog'];
    $login = new logins();
    $login->deleteLogin($idLog);
}
?>

<body>
    <div class="bordaBox">
        <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
        <div class='titulos'>
            <p align="left" style="margin-left:20px;color:#222;font-weight:bold;">Cadastro de logins administrativos:</p>
        </div>
        <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>				
    </div>
    
    <div id="grups" align="center">
        <div class="d" name="d">
            <table width="400px" align="left" style="font:14px 'Arial';margin-left:20px;">
                <form id="form" action="FrmLogins.php?action=insert" method="post">
                    <tr>
                        <td>Nome:<b style="color:red;">*</b></td><td><input type='text' id='text' name='name' /></td>
                    </tr>
                    <tr>
                        <td>Email:<b style="color:red;">*</b></td><td><input type='text' id='email' name='email' onBlur="if(!$.validateEmail(document.getElementById('email').value)){alert('Email inválido');document.getElementById('email').value=null;} " /></td>
                    </tr>
                    <tr>
                        <td>Fone:</td><td><input type='text' id='fone' name='fone' /></td>
                    </tr>
                    <tr>
                        <td>Login:<b style="color:red;">*</b></td><td><input type='login' id='login' name='login' /></td>
                    </tr>
                    <tr>
                        <td>Senha:<b style="color:red;">*</b></td><td><input type='password' id='senha' name='senha' /></td>
                    </tr>
                    <tr>
                        <td><br><input type="submit" id="logar" value="Salvar"/>&nbsp;&nbsp;<input type="reset" id="cancel" value="Limpar"/></td><td></td>
                    </tr>
                </form>
                
            </table>            
        </div>       
        <div class="d2Login">
            <div id="topo">
                <div class='nameAdmin' style="width:132px;">
                    <p>Nome do administrador</p>
                </div>
                <div class='loginAdmin'>
                    <p>Login</p>
                </div>
                <div class='psswdAdmin'>
                    <p>Senha</p>
                </div>
                <div class='optAdmin'>
                    <p>Opt.</p>
                </div>
            </div>
            <div id="listaSubCategorias">
                <?php
                
                $login = new logins();
                $cont = $login->getIdsLogin();
                
                $x    = 0;
                
                while( $cont[$x] != 'end' )
                {
                    $dadosLogin = $login->getLogin($cont[$x]);
                    
                    $idLogin  = $dadosLogin[0];
                    $logNome  = $dadosLogin[1];
                    $logLogin = $dadosLogin[4];
                    $logSenha = $dadosLogin[5];
                    
                    $style = "style='width:290px'";
                    $onClick  = "onclick=\"yesOrNotWhatever('Deseja deletar este login?', 'FrmLogins.php?action=delete&idLog=$idLogin');\"";
                    $src = "src='../imagens/deletar.png'";
                    
                    if( $logLogin == $actualAdmin )
                    {
                        $style = "style='width:290px;background:#98FB98;'";
                        $onClick  = "''";
                        $src = "src='../imagens/deletarDisabled.png'";
                    }
                    else
                    {
                        
                        $chars = strlen($logSenha);
                        
                        $logSenha = "";
                        
                        while( $chars != 0 )
                        {
                            $logSenha .= "*";
                            $chars --;
                        }
                        
                    }

                    echo "
                        <div id='produto' $style>
                            <div class='nameAdmin'>
                                <p>$logNome</p>
                            </div>
                            <div class='loginAdmin'>
                                <p style='color:#4682B4;'>$logLogin</p>
                            </div>
                            <div class='psswdAdmin'>
                                <p style='color:#4682B4;'>$logSenha</p>
                            </div>
                            <div class='optAdmin'>
                                <a href=\"javascript:void(0);\" $onClick title='Deletar login'><img style='margin-top:3px;' $src width='19px' height='19px'></a>
                            </div>
                        </div>";
                    $x++;
                }
                
                ?>
            </div>
        </div>
    </div>
</body>

