<link rel="stylesheet" href="gerenciadoradmin/css/inputs.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/corpo.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/validateFunctions.js"></script>

<body style="background: #B2CBFF;font-family:'Trebuchet MS', Arial;font-size: 11px;">
    <p align="center" style='font-weight: bold;'>Mande-nos sua pergunta, elogios, conselhos ou críticas:</p>
    <div id="divNot">
        <form action="contato.php?action=enviar" method="post">
            <table align="center" width="300px;" style="font:14px 'Arial';">
                <tr>
                    <td><br>Nome:<b class="required">*</b></td><td><br><input type="text" id="text" name="nome"/></td>
                </tr>
                <tr>
                    <td>E-mail:<b class="required">*</b></td><td><input type="text" id="email" name="email" onBlur="emailValidation(this.value);" /></td>
                </tr>
                <tr>
                    <td>Fone:</td><td><input type="text" id="fone" name="fone"/></td>
                </tr>
                <tr>
                    <td>Cidade:<b class="required">*</b></td><td><input type="text" class="text" id="cidade" name="cidade"/></td>
                </tr>
                <tr>
                    <td>Tipo de pessoa:<b class="required">*</b></td><td><input type="radio" id="tipoPessoa" name="tipoPessoa" value="f" onClick="verificaTipoPessoa(this.value)" checked/>Física &nbsp;<input type="radio" id="tipoPessoa" name="tipoPessoa" value="j" onClick="verificaTipoPessoa(this.value)"/>Jurídica</td>
                </tr>
                <tr>
                    <td>CPF:<b class="required">*</b></td><td><input type="text" class="text" id="cpf" name="cpf"/></td>
                </tr>
                <tr>
                    <td>CNPJ:<b class="required">*</b></td><td><input type="text" class="textDisabled" id="cnpj" name="cnpj" disabled/></td>
                </tr>
                <tr>
                    <td>Mensagem:<b class="required">*</b></td><td><textarea id="descri" name="msg"></textarea></td>
                </tr>
                <tr>
                    <td><br></td><td><br><input type="submit" id="logar" name="enviar" value="Enviar"/>&nbsp&nbsp<input type="reset" id="cancel" name="cancel" value="Limpar"/></td>
                </tr>
                <tr>
                    <td><br></td><td><br></td>
                </tr>
            </table>
        </form>
    </div>
</body>

<?php
include('classes/config.php');
include('classes/email.php');
include('classes/users.php');

$action = $_GET['action'];

if( $action == 'enviar' )
{
    try
    {
        $config = new config();
        
        $dataUser = new stdClass();
        $dataUser->nome   = $_POST['nome'];
        $dataUser->email  = $_POST['email'];
        $dataUser->fone   = $_POST['fone'];
        $dataUser->cidade = $_POST['cidade'];
        $dataUser->cpf    = $_POST['cpf'];
        $dataUser->cnpj   = $_POST['cnpj'];

        $dadosUsuario = users::montarDadosDoUsuarioParaEmail(null, $dataUser);
        $dataUser->msg = $dadosUsuario . $_POST['msg'];

        if( ($dataUser->nome != null) && ($dataUser->email != null) && ($dataUser->msg != null) && ($dataUser->cidade != null) && (($dataUser->cpf != null) || ($dataUser->cnpj != null)) )
        {
            $email   = new email($dataUser->msg, "Contato do site", $dataUser->email);
            $emails  = $email->getEmailsFromAdmins();
            $enviado = false;

            foreach ( $emails as $para )
            {
                $email->__set('para', $para);
                $enviado = $email->enviar();
            }

            if ( $enviado )
            {
                $email->salvarContato(null, $dataUser->nome, $dataUser->email, $dataUser->fone, $dataUser->msg);
                echo "<script>alert('Mensagem enviada com sucesso.');</script>";
            }
            else
            {
                throw new Exception("Ops! Ocorreu algum problema ao enviar o e-mail...");
            }
        }
        else
        {
            throw new Exception("Preencha os campos requeridos!");
        }
    }
    catch ( Exception $err )
    {
        echo "<script>alert('{$err->getMessage()}');</script>";
    }
}
?>