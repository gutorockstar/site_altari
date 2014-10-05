<?php
	session_start();
?>
<html>
    <head>
            <title>Gerenciador</title>
            <meta http-equiv='content-type' content='text/html;  charset=utf-8' />
            <link rel="stylesheet" href="css/corpoadmin.css" type="text/css" media="screen" />
            <script type="text/javascript" src="../js/jquery.js"></script>
            <script type="text/javascript" src="js/atualiza.js"></script>
    </head>

    <body>

<?php
$logado = $_GET['logado'];

if( ($logado == 'true') && ($_SESSION["adminLogin"] != null) )
{
    echo "<div id='corpo'>
            <div class='bordaBox'>
                    <b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
                            <div class='corpo'>
                                    <div id='externo'>
                                            <div class='l'>
                                                    <div class='bordaBox'>
                                                            <b class='b12'></b><b class='b22'></b><b class='b32'></b><b class='b42'></b>
                                                                    <div class='interno'>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('home.php', 'HOME');\"><img src='imagens/home.png' title='Home' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('grupos.php', 'CATEGORIAS');\"><img src='imagens/grupos.png' title='Categorias' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('produtos.php', 'PRODUTOS');\"><img src='imagens/produtos.png' title='Produtos' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('servicos.php', 'SERVIÇOS');\"><img src='imagens/serviços.png' title='Serviços' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('orcamentos.php', 'CONTATOS');\"><img src='imagens/contato.png' title='Contatos' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('noticias.php', 'NOTÍCIAS');\"><img src='imagens/noticias.png' title='Notícias' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('banners.php', 'BANNERS');\"><img src='imagens/banners.png' title='Banners' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('logins.php', 'LOGIN');\"><img src='imagens/login.png' title='Login' width='50px' height='50px'></a>
                                                                            </div>
                                                                            <div class='menu'>
                                                                                    <a href='gerenciador.php?logado=false'><img src='imagens/logout.png' title='Logout' width='50px' height='50px'></a>
                                                                            </div><br>
                                                                    </div>
                                                            <b class='b42'></b><b class='b32'></b><b class='b22'></b><b class='b12'></b>
                                                    </div>
                                            </div>

                                            <div class='r'>			
                                                    <div class='bordaBox'>
                                                            <b class='b12'></b><b class='b22'></b><b class='b32'></b><b class='b42'></b>
                                                                    <div class='interno1'>
                                                                            <h2 align='center'>GERENCIADOR</h2>
                                                                    </div>
                                                            <b class='b42'></b><b class='b32'></b><b class='b22'></b><b class='b12'></b>
                                                    </div><br>

                                                    <div class='bordaBox'>
                                                            <b class='b12'></b><b class='b22'></b><b class='b32'></b><b class='b42'></b>
                                                                    <div class='interno2'>
                                                                        <div align='center'>
                                                                            <img src='img/tecnon.jpg' width='650px' height='450px'>
                                                                        </div>
                                                                    </div>
                                                            <b class='b42'></b><b class='b32'></b><b class='b22'></b><b class='b12'></b>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                    <b class='b4'></b><b class='b3'></b><b class='b2'></b><b class='b1'></b>
            </div>
        </div>";
}
else
{
    $_SESSION["adminLogin"] = null;
    echo "<meta HTTP-EQUIV='REFRESH' CONTENT='0; URL=index.php'> ";	
}

?>
        
    </body>
</html>
