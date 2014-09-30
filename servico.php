<?php
    include('classes/config.php');
    include('gerenciadoradmin/classes/servico.php');
    
    $config = new config();
    
    $idServ = $_GET['idServ'];
    //$action = $_GET['action'];
    
    $session = $_GET['session'];    
    
    $servico = new servico();
    $serv    = $servico->getServico($idServ);
    $tServ   = $serv[1];
?>
<div id='bloco'>
    <div class="produtosIndex">
        <b id="b">
            <?php echo "<a onmouseover=\"this.style.color='#4682B4';\" onmouseout=\"this.style.color='#222'\" style=\"color:#222;text-decoration:none;\" href=\"javascript:void(0);\" onclick=\"javascript:atualiza('serviços.php?session=$session', 'conteudo');\">Nossos serviços</a> > $tServ";?>
        </b>
        <div id="prodOut">
            <div>
                <div style="float:left;margin-top:30px;margin-left:30px;width:350px;">
                    <div>
                        <?php
                        $servico = new servico();
                        $dados   = $servico->getServico($idServ);
                        $descri  = $dados[3];
                        
                        echo "<p align='left' style='font-size:15px;font-weight:bold;color:#222;'>".$tServ."</p>";
                        echo "<p align='left'>".$descri."</p><br>";
                        ?>
                    </div>                
                </div>    

                <div style="float:left;margin-top:30px;width:450px;">
                    <div class="highslide-gallery">
                        <?php
                        $dir  = opendir("Imagens/serviços/$idServ/");

                        $cont = 0;
                        while($read = readdir($dir))
                        {                        
                            if($read!= '.' && $read!= '..')
                            {
                                echo "<a href=\"Imagens/serviços/$idServ/$read\" class=\"highslide\" onclick=\"return hs.expand(this)\" title='Clique para visualizar' style='margin-left:10px;'><img src='Imagens/serviços/$idServ/$read' alt=\"Highslide JS\" width='200px' height='150px' style='margin-bottom:10px;' /></a>";
                                $cont++;
                            }                        
                            if( $cont == 4 )
                            {
                                break;
                            }                        
                        }             

                        closedir($dir);
                        ?>
                    </div>
                </div>
            </div>
            <div style="display:block;">
                <div id="contatServ">
                    <input type="hidden"/>
                </div>
                <div id="showAll">
                    <a style='text-decoration:none;font-size:13px;font-weight:bold;color:#fff;' href="javascript:void(0);" onclick="javascript:atualiza('', '');" title='Ver todas imagens'><img src='gerenciadoradmin/imagens/lupa.png' width='20px' height='20px'>&nbsp;&nbsp;&nbsp;&nbsp;<b>Ver todas imagens</b></a>
                </div>
            </div>
        <br></div><br><br>
    </div>
</div>

