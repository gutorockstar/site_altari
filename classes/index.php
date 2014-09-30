<?php
    include('home.php');
    
    $home = new home('home', 'conteudo');
    echo $home->imprimirHome();
    
?>