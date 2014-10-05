<div id="fora">
    <b id="b" style="margin-right: 750px;">Serviços</b>
    <div class='servicos' align="center">
        <div id="serv">
            <?php
            include('classes/config.php');
            include('gerenciadoradmin/classes/servico.php');
            include('classes/home.php');
            
            session_start();

            $config = new config();

            $servicos  = new servico();
            $ids      = $servicos->getAllIdsActivate(true);
            $cont     = 0;

            while( $ids[$cont] != 'end' )
            {                
                $servico = $servicos->getServico($ids[$cont]);

                $id_servico   = $servico[0];
                $titulo       = $servico[1];
                $status       = $servico[2];
                $descri       = $servico[3];
                $descricao    = $config->descriBroken($descri);
                $imgChamada   = $servico[4];

                if( $imgChamada != null )
                {
                    $capa = 'Imagens/serviços/'.$id_servico.'/'.$imgChamada;
                }
                else
                {
                    $capa = "Imagens/no_image.png";
                }

                if( $status != 'inativo' )
                {

                    echo "<div class='contornoServIndex' align='center'>
                                <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('serviço.php?idServ=$id_servico&session=$session', 'conteudo');\">
                                    <div id='fotoServ'>
                                        <img id='imagens' src='$capa' alt='Menu' width='190px' height='140px'>
                                    </div><br>
                                </a>
                                <b align='left' style='text-align:left;color:#222;'>$titulo</b>                                
                                <p id='pServ' align='left'>$descri</p>
                        </div>";
                }
                $cont++;     
            }            
            ?>
        </div>
    </div>
</div><br>

<div id='bloco' align="left">
    <div class='ext'>        
        
        <div class='novidades'>
            <script type="text/javascript">
                atualiza('novidades.php', 'novidades');
            </script>
        </div>
    </div>

    <div class='ext2'>
        <div id='centro'>
                        
            <b id="b">Sobre nós</b>
            <div class='sobrenos' align="center">                                
                <div id="conteudoSobreNos">
                    <p align='left'>
                        <?php
                        $home = new home('home', 'conteudo');
                        echo $home->imprimirHome();
                        ?>
                    </p>
                </div>
            </div><br>
            
            <b id="b">Notícias</b>
            <div class='noticias' align="left">                    
                <script type="text/javascript">
                    atualiza('noticias.php', 'noticias');
                </script>                          
            </div><br>
            
            <b id="b">Widgats</b>
            <div class='widgats' align="left">
                <div align="center" style="display:block;height:auto;">                    

                    <div style="width:190px;height:auto;float:left;margin-left:5px;-moz-border-radius:10px;border-radius:10px;border:1px solid #ccc;margin-top:5px;">
                        <p align='center'>Navegadores recomendados</p>
						<div>
							<a style='margin-bottom:5px;' href='http://www.baixaki.com.br/download/google-chrome.htm' title="Baixar Google Chrome"><img src='Imagens/chrome.png' width='60px' height='60px' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a href='http://www.baixaki.com.br/download/mozilla-firefox.htm' title="Baixar Mozilla Firefox"><img src='Imagens/firefox.png' width='60px' height='60px' /></a>
						</div>
						<div style='margin-bottom:5px;'>
							<a href='http://www.baixaki.com.br/download/safari.htm' title="Baixar Safari"><img src='Imagens/safari.png' width='60px' height='60px' /></a>&nbsp;&nbsp;&nbsp;&nbsp;
							<a href='http://www.baixaki.com.br/download/opera.htm' title="Baixar Opera"><img src='Imagens/opera.png' width='60px' height='60px' /></a>
						</div>
                    </div>

                    <div style="width:120px;float:left;text-align:right;margin-left:10px;margin-top:5px;">
                        <div style="width:120px;height:150px;float:right;">
							<iframe src='http://selos.climatempo.com.br/selos/MostraSelo120.php?CODCIDADE=1388,1399,4345,4359&SKIN=azul' scrolling='no' frameborder='0' width=150 height='170' marginheight='0' marginwidth='0'></iframe>
                        </div>
                    </div>

					<div id='mapa' style="width:245px;height:auto;float:left;margin-left:5px;margin-top:5px;">
						<iframe name="widgetbox_widget_iframe_0" id="widgetbox_widget_iframe_0" width="240" height="170" border="0" frameborder="0" src="http://www.widgetserver.com/syndication/get_widget.html?pin=1&amp;address=Altari S/A Viaturas e Refrigeração, Estrela - Rio Grande do Sul&amp;zoom=0&amp;__cb=1340287815780&amp;widget.appId=09c29c0a-d620-4807-8450-4d257ac3e243&amp;widget.regId=efdb0b41-a0bf-4aab-9318-ebe780e3d2fa&amp;widget.friendlyId=google-map&amp;widget.name=Google%20Map&amp;widget.token=f1cd419e0c84fe9ffc170ba8a16e636845c7586a000001380e2c2a3b&amp;widget.sid=213be59c8935c878104aa725678ebeff&amp;widget.vid=213be59c8935c878104aa725678ebeff&amp;widget.id=0&amp;widget.location=http%3A%2F%2Fwww.widgetbox.com%2Fwidget%2Fgoogle-map&amp;widget.timestamp=1340287816283&amp;widget.serviceLevel=0&amp;widget.provServiceLevel=2&amp;widget.instServiceLevel=0&amp;widget.width=240&amp;widget.height=170&amp;widget.wrapper=JAVASCRIPT&amp;widget.isAdFriendly=true&amp;widget.isAdEnabled=true&amp;widget.adPlacement=BR&amp;widget.prototype=NONE&amp;widget.prototypeOrdinal=0&amp;widget.ua=mozilla%2F5.0%20%28x11%3B%20linux%20i686%29%20applewebkit%2F535.19%20%28khtml%2C%20like%20gecko%29%20chrome%2F18.0.1025.142%20safari%2F535.19&amp;widget.version=1&amp;widget.regVersion=178&amp;widget.output=htmlcontent" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no" style="visibility: visible; "></iframe>						
					</div>
                </div>
                
            </div>
        </div>
    </div>
</div><br>
