<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns = "http://www.w3.org/1999/xhtml"> 
    <head> 
        <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" /> 
        <title>Login</title> 
        <link rel="stylesheet" href="css/corpoadmin.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="css/inputs.css" type="text/css" media="screen" />
        <script type="text/javascript" src="js/functions.js"></script>
    </head> 
    <body style='background: #fff;color: #222;'>
        <div id='log'>
            <div class="bordaBox">
                <b class="b12"></b><b class="b22"></b><b class="b32"></b><b class="b42"></b>
                <div class='login'>
                    <form action="verificaLogin.php" method="post">
                        <table align="center" width="200px">
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td>Login: </td><td><input type="text" name="login" id="login"/></td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td>Senha: </td><td><input type="password" name="passwd" id="passwd"/></td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td></td><td><input type="submit" name="logar" id="logar" value='Logar'/>&nbsp;&nbsp;<input type="reset" name="cancel" id="cancel" value='Cancelar'/></td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr></tr>
                        </table>
                    </form>
                </div>
                <b class="b42"></b><b class="b32"></b><b class="b22"></b><b class="b12"></b>
            </div>
        </div>
        <?php
        $action = $_GET["action"];        
        echo "<script>focusField('login')</script>";
        
        if ($action == 'fail')echo"<script>alert(\"LOGIN INVÁLIDO!!!\");</script>";
        ?>
    </body> 
</html> 