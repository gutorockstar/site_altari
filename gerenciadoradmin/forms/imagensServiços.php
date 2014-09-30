<html> 
    <head>
        <script type="text/javascript" src="../js/functions.js"></script>
        <link rel="stylesheet" href="../css/corpoadmin.css" type="text/css" media="screen" />
        <link rel='stylesheet' href='../css/inputs.css' type='text/css' media='screen' />
        <link href="uploadify/css/uploadify.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="uploadify/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="uploadify/swfobject.js"></script>
        <script type="text/javascript" src="uploadify/jquery.uploadify.v2.1.0.min.js"></script>
        <script type="text/javascript">
            <?php
            $idServ = $_GET['id'];
            $delet  = $_GET['deletar'];
            
            if( $delet != null )
            {                
                unlink('../../Imagens/serviços/'.$idServ.'/'.$delet);
            }
            
            echo "
                $(document).ready(function() {
                    $('#file_upload').uploadify({
                        'uploader'  : 'uploadify/uploadify.swf',
                        'script'    : 'uploadify/uploadify.php',
                        'cancelImg' : 'uploadify/cancel.png',
                        'folder'    : '../../Imagens/serviços/$idServ',
                        'auto'      : false, // False para não começar automaticamente, e True para começar o upload automaticamente.
                        'multi'     : true, // False para fazer upload apenas de um arquivo e True para vários arquivos.
                        'onAllComplete' : function(event,data) 
                         { 
                            refreshPage('imagensServiços.php?id=$idServ'); 
                         } 
                    });
                });";
            ?>
        </script>
    </head>
    <body style="background:#eee;">
        <div id="imgProdutos">
            
            <div class="browserImagens" align="center"><br>
                <input id="file_upload" name="file_upload" type="file" />
                <a href="javascript:$('#file_upload').uploadifyUpload();" ><img src="../imagens/salvar.png" id="imgSalvar" title="Salvar imagens" ></a>
            </div>

            <div class="listaImagensProdutos">
                <?php	
                include('../../classes/config.php');
                include('../classes/servico.php');
                $config = new config();
                
                $servico = new servico();
                $optC = $_GET['opt']; 
                $imgC = $_GET['img'];
                
                if( $optC == "marcar" )
                {
                    $servico->updateChamada($idServ, $imgC);
                }
                                
                $dir = opendir("../../Imagens/serviços/$idServ");
                $cont = 0;
                $chamada = $servico->getImagemChamada($idServ);

                echo"<table align='center' width='330px' cellpadding='4'><tr>";
                                
                while($read = readdir($dir))
                {
                    if($read!= '.' && $read!= '..')
                    {
                        $prim = true;
                        if( ($chamada == null) && ($prim) )
                        {
                            $servico->updateChamada($idServ, $read);
                            $checked = "checked disabled='true'";
                            $opcao   = "desmarcar";
                            $del     = "<img src='../imagens/deletarDisabled.png' border='0' title='Deletar'>";
                            $prim    = false;                            
                        }
                        else if( $read == $chamada )
                        {
                            $checked = "checked disabled='true'";
                            $opcao   = "desmarcar";
                            $del     = "<img src='../imagens/deletarDisabled.png' border='0' title='Deletar'>";
                            //ESTA ATIVANDO TODAS AO INICIAR!!!
                            $prim    = false;
                        }
                        else{
                            $del     = "<a href='javascript:void(0);' onclick=\"yesOrNotWhatever('Deseja excluir esta imagem?', 'imagensServiços.php?id=$idServ&deletar=$read')\"><img src='../imagens/deletar.png' border='0' title='Deletar'></a>";
                            $checked = null;
                            $opcao   = "marcar";
                            $prim    = false;
                        }                        
                        
                        echo "<td align='right'>
                                <div id='del'>
                                    <input type='checkbox' title='Selecionar como imagem de chamada' id='$read' $checked onclick='refreshPage(\"imagensServiços.php?id=$idServ&opt=$opcao&img=$read\")' />
                                    $del
                                </div>
                                <a href=\"javascript:popupImagem('../../Imagens/serviços/$idServ/$read', 'null');\"><img id='imgP' src='../../Imagens/serviços/$idServ/$read' height='70' width='70' title='Clique para ampliar' /></a>
                              </td>";
                        $cont++;

                    }
                    if($cont==4)
                    {
                        echo "</tr><tr>";
                        $cont = 0;
                    }
                }
                echo "</tr></table>";
                closedir($dir);
                ?>
            </div>
            
        </div>
    </body> 
</html>