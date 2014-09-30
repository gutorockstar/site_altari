<?php
    $session = $_GET['session'];
	if( $session != null )
	{
		session_start($session);
	}	
?>

<script type="text/javascript" src="js/validateFunctions.js"></script>

<?php
    include('classes/config.php');
    include('classes/users.php');
    
    $conf    = new config();       
    
    $action  = $_GET['action'];
    $idProd  = $_GET['idProd'];

    if( $session != null )
    {
        $log = $_SESSION['login'];
        
        $user = new users();
        if( ($log != null) && ($user->loginUserLog($log)) )
        {
            echo "<script>
                    var url = 'listaProdutos.php?login=$log&idProd=$idProd&session=$session&prim=true&action=insert';
                    atualiza(url, 'conteudo');
                  </script>";
        }
    }
    
    if( $action == 'salvar' )
    {
        $nome  = $_GET['name'];
        $email = $_GET['email'];
        $fone  = $_GET['fone'];
        $login = $_GET['login'];
        $senha = $_GET['senha'];
        
        $user = new users($nome, $email, $fone, $login, $senha);
        if( $user->verificarUser() )
        {
            if( ($nome == null) || ($email == null) || ($login == null) || ($senha == null) )
            {
                echo "<script>alert('Existem campos obrigatórios que não foram preenchidos!');</script>";
            }
            else
            {
                $user->salvarUser();
                $action = "login=$login&idProd=$idProd&session=$session&prim=true&action=insert";
                echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=principal.php?act=orcar&login=$login&senha=$senha&user=$action'> ";
            }
        }
        else
        {
            echo "<script>alert('Login já existe');</script>";
        }
    }
    else if( $action == 'logar' )
    {
        $login = $_GET['login'];
        $senha = $_GET['senha'];
        
        $user = new users();
        if( $user->loginUser($login, $senha) )
        {
            $action = "login=$login&idProd=$idProd&session=$session&prim=true&action=insert";
            echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=principal.php?act=orcar&login=$login&senha=$senha&user=$action'> ";
        }
        else
        {
            echo "<script>alert('Login ou senha inválida!');</script>";
        }
    }
    
?>
    
<p style='text-align:center;margin-top:20px;color:#222;font-weight: bold;'>Para criar sua lista de orçamentos é necessário efetuar login:</p><br>

<div id="orçaExt">    
    <div class="orçaIntLog1">
        <b id="b" style="margin-right:260px">Registrar-se:</b>
        <div id="orçaIntLog1">
            <form id="form"><br>
                <table width='290px' style='font-size:14px;margin-left:10px;margin-right:10px;' align='center'>
                    <tr>
                        <td>Nome:<b style="color:red;">*</b></td><td><input type='text' id='text' name='name' /></td>
                    </tr>
                    <tr>
                        <td>E-mail:<b style="color:red;">*</b></td><td><input type='text' id='email' name='campoEmail' onBlur="if(!$.validateEmail(document.getElementById('email').value)){alert('Email inválido');document.getElementById('email').value=null;} " /></td>
                    </tr>
                    <tr>
                        <td>Fone:</td><td><input type='text' id='fone' name='fone' /></td>
                    </tr>
                    <tr>
                        <td>Login:<b style="color:red;">*</b></td><td><input type="text" id="loginReg" name="loginReg" /></td>
                    </tr>
                    <tr>
                        <td>Senha:<b style="color:red;">*</b></td><td><input type='password' id='senha' name='senhaReg' /></td>
                    </tr>
                    <tr>
                        <td><br></td><td><br><?php if($idProd!=null)
                                    {
                                        echo"<a id='loginUser' href=\"javascript:void(0);\" onclick=\"
                                                                                var nome  = document.getElementById('text').value;
                                                                                var email = document.getElementById('email').value;
                                                                                var fone  = document.getElementById('fone').value;
                                                                                var login = document.getElementById('loginReg').value;
                                                                                var senha = document.getElementById('senha').value;
                                                                                var href  = 'orçar.php?idProd=$idProd&action=salvar&session=$session&login='+login+'&senha='+senha+'&name='+nome+'&email='+email+'&fone='+fone;
                                                                                atualiza(href, 'conteudo');\">Salvar e logar</a>";                    
                                    }
                                    else
                                    {
                                        echo"<a id='loginUser' href=\"javascript:void(0);\" onclick=\"
                                                                                var nome  = document.getElementById('text').value;
                                                                                var email = document.getElementById('email').value;
                                                                                var fone  = document.getElementById('fone').value;
                                                                                var login = document.getElementById('loginReg').value;
                                                                                var senha = document.getElementById('senha').value;
                                                                                var href  = 'orçar.php?action=salvar&session=$session&login='+login+'&senha='+senha+'&name='+nome+'&email='+email+'&fone='+fone;
                                                                                atualiza(href, 'conteudo');\">Salvar e logar</a>";};?>
                        </td>
                    </tr>
                </table><br>
            </form>
        </div>
    </div>
    
    
    <div class="orçaIntLog2">
        <b id="b" style="margin-right:160px">Logar:</b>
        <div id="orçaIntLog2">
            <form><br>
                <table width='200px' style='font-size:14px;margin-left:10px;margin-right:10px;' align='center'>
                    <tr>
                        <td>Login:</td><td><input type="text" id="login1" name="login"/></td>
                    </tr>
                    <tr>
                        <td>Senha:</td><td><input type="password" id="senha1" name="senha"/></td>
                    </tr>
                    <tr>
                        <td><br></td><td><br><?php if($idProd!=null)
                                    {
                                        echo"<a id='loginUser' href=\"javascript:void(0);\" onclick=\"
                                                                                var login = document.getElementById('login1').value;
                                                                                var senha = document.getElementById('senha1').value;
                                                                                var href  = 'orçar.php?idProd=$idProd&session=$session&action=logar&login='+login+'&senha='+senha;
                                                                                atualiza(href, 'conteudo');\">Logar</a>";                    
                                    }
                                    else
                                    {
                                        echo"<a id='loginUser' href=\"javascript:void(0);\" onclick=\"
                                                                                var login = document.getElementById('login1').value;
                                                                                var senha = document.getElementById('senha1').value;
                                                                                var href  = 'orçar.php?action=logar&session=$session&login='+login+'&senha='+senha;
                                                                                atualiza(href, 'conteudo');\">Logar</a>";};?>
                        </td>
                    </tr>
                </table><br>
            </form>
        </div>
    </div>
</div><br>
