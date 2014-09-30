<link href="hoverDialog/estilo.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="hoverDialog/jqueryHover.js"></script>
<script type="text/javascript">
    $.noConflict('hover');
    jQuery(document).ready(function(){
            $(".menuHover a").hover(function(){
                    $(this).next("em").animate({opacity: "show", top: "-75"}, "slow");
            }, 
            function(){
                    $(this).next("em").animate({opacity: "hide", top: "-85"}, "fast");
            });
    });
</script>

<?php
    include('classes/config.php');
    include('gerenciadoradmin/classes/servico.php');
    $session = $_GET['session'];
    
    $config    = new config();    
?>

<div id='bloco'>
    <div class="produtosIndex">
        <b id="b">Nossos serviços</b>
        <div id="prodOut">
            <?php            
            $servicos  = new servico();
            $ids      = $servicos->getAllIdsActivate();
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

                    echo "<div class='contornoServ' align='center'>
                                <a href=\"javascript:void(0);\" onclick=\"javascript:atualiza('serviço.php?idServ=$id_servico&session=$session', 'conteudo');\">
                                    <div id='fotoServ'>
                                        <img id='imagens' src='$capa' alt='Menu' width='190px' height='140px'>
                                    </div>
                                </a><br>
                                <b align='left' style='text-align:left;color:#222;'>$titulo</b>                                
                                <p id='pServ' align='left'>$descri</p>
                          </div>";
                }
                $cont++;     
            }            
            ?>
        </div>
    <br></div><br><br>
</div>

