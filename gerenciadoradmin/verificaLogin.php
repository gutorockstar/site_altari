<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("../classes/config.php");
$banco = new config();

$login = $_POST["login"];
$passwd = $_POST["passwd"];

$buscar = mysql_query("SELECT login, senha FROM login WHERE login = '" . $login . "'") or die("Erro ao buscar dados: " . mysql_error());

$log = false;
while ($reg = mysql_fetch_assoc($buscar)) {

    if ($login == $reg["login"] and $passwd == $reg["senha"]) { //login sucesso
        session_start();        
        $_SESSION["adminLogin"] = $login;
        header("Location:gerenciador.php?logado=true");
        $log = true;
        exit;
        break;
    }
}

if (!$log) { //login falhou volta pro formulario
    header("Location:index.php?action=fail");
}
?>
