<?php
include('classes/config.php');
include('classes/users.php');
include('gerenciadoradmin/classes/produto.php');
include('classes/email.php');

$session = $_GET['session'];
session_start($session);

$config  = new config();
$user    = new users();

$action = $_GET['action'];
$prim   = $_GET['prim'];
$login  = $_GET['login'];
$idProd = $_GET['idProd'];

$_SESSION['login'] = $login;

if( $action == 'enviar' )
{   
    $mensagem = $_GET['msg'];
    $msg = "<p>$mensagem</p>";
    
    $prod = new produto();        
    
    $cont = $user->getAllIdsProdUser($login);    
    $x    = 0;
        
    $cabecalho = "";
    if( $cont[$x] != 'end' )
    {
        $cabecalho = "<p><strong>Produtos selecionados pelo usuário:</strong></p>";
    }
    
    $produtos  = "";
    while( $cont[$x] != 'end' )
    {
        $dadosProduto = $prod->getProduto($cont[$x]);
        
        $titulo    = $dadosProduto[3]; // titulo do produto
        
        $produtos .= "- " . $titulo . "<br>";
        $x++;
    }
    
    $allMessage = $msg . $cabecalho . $produtos;
    $email = new email($allMessage, 'Requisição de orçamento');
    $email->getEmailUser($login);
    
    $emails = $email->getEmailsFromAdmins();
    $x = 0;
    
    $enviado = true;
    while( $emails[$x] != 'end' )
    {        
        $email->__set('para', $emails[$x]);
        $email->getEmailUser($login);
        $email->getNameUser($login);
        
        if( !$email->enviar() )
        {
            $enviado = false;
        }
        $x++;
    }
    
    if( $enviado )
    {
        $email->salvarOrcamento();
        $user->deleteAllProd($login);        
        echo "<script>alert('Orçamento enviado com sucesso, retornaremos em breve');</script>";
        $email->emailReturn();
    }
    else
    {
        echo "<script>alert('Problema ao enviar orçamento');</script>";
    }
    
}


if( $prim != 'true' )
{
    if( $action == 'deletarTudo' )
    {
        $user->deleteAllProd($login);
    }
    else if( ($idProd != null) && ($action == 'insert') )
    {
        if( !$user->insertProduto($login, $idProd) )
        {
            echo "<script>alert('Produto selecionado já está na lista!')</script>";
        }
    }
    else if( ($idProd != null) && ($action == 'delete') )
    {
        $user->deleteProduto($login, $idProd);
    }
}
else
{
    $user->createTempTable($login); //cria a table de produtos para o usuário.
    
    if( $action == 'deletarTudo' )
    {
        $user->deleteAllProd($login);
    }
    else if( ($idProd != null) && ($action == 'insert') )
    {
        if( !$user->insertProduto($login, $idProd) )
        {
            echo "<script>alert('Produto selecionado já está na lista!')</script>";
        }
    }
    else if( ($idProd != null) && ($action == 'delete') )
    {
        $user->deleteProduto($login, $idProd);
    }    
}
?>
<div id="orçaExt">
    <div class="orçaInt1">
        <div id="intOrça" align="center">
            <p align="center" style="font-weight:bold;color:#000;font-size:14px;">Todos os produtos</p>        
            <div id='produtoIndex' style="font-weight: bold;color:#fff;background:#4682B4;">
                <div class='imgProduto'>
                    <p align="center">Img</p>
                </div>
                <div class='tituloProdutoIndex'>                    
                    <p align="center">Titulo</p>
                </div>
                <div class='opcoesProdutos' style='width:27px;'>
                    <p align="center">Orçar</p>
                </div>
            </div>               
            <?php
            $prod = new produto();
            $cont = $prod->getAllIdsActivate();
            $x    = 0;

            while( $cont[$x] != 'end' )
            {
                $dadosProduto = $prod->getProduto($cont[$x]);

                $prodId    = $dadosProduto[0]; // id produto
                $titulo    = $dadosProduto[3]; // titulo do produto            
                $chamada   = $dadosProduto[6]; //imagem de chamada
                
                if( $chamada != null )
                {
                    $capa = 'Imagens/produtos/'.$prodId.'/'.$chamada;
                }
                else
                {
                    $capa = "Imagens/no_image.png";
                }

                echo "
                    <div id='produtoIndex'>
                        <div class='imgProduto'>
                            <img src='$capa' width='25px' height='25px'/>
                        </div>

                        <div class='tituloProdutoIndex'>
                            <p style='color:#4682B4;'>$titulo</p>
                        </div>

                        <div class='opcoesProdutos' style='width:27px;'>
                            <a href=\"javascript:void(0);\" onclick=\"atualiza('listaProdutos.php?login=$login&idProd=$prodId&action=insert', 'conteudo');\" title='Adicionar ao carrinho de orçamentos' ><img src='gerenciadoradmin/imagens/prancheta.png' width='25px' height='22px'></a>                        
                        </div>
                    </div>";
                $x++;
            }
            ?>
        </div>
    </div>    
    <div class="orçaInt2">
        <div id="intOrça" align="center">
            <div id="orçamento">
                <p align="center" style="font-weight:bold;color:#000;font-size:14px;">Produtos selecionados</p>        
                
                <?php
                $cont = $user->getAllIdsProdUser($login);
                $x    = 0;

                while( $cont[$x] != 'end' )
                {
                    $dadosProduto = $prod->getProduto($cont[$x]);

                    $prodId    = $dadosProduto[0]; // id produto
                    $titulo    = $dadosProduto[3]; // titulo do produto            
                    $chamada   = $dadosProduto[6]; //imagem de chamada
                    
                    if( $chamada != null )
                    {
                        $capa = 'Imagens/produtos/'.$prodId.'/'.$chamada;
                    }
                    else
                    {
                        $capa = "Imagens/no_image.png";
                    }

                    echo "
                        <div id='produtoIndex'>
                            <div class='imgProduto'>
                                <img src='$capa' title='Clique para ver todas imagens' width='25px' height='25px'/>
                            </div>

                            <div class='tituloProdutoIndex'>
                                <p style='color:#4682B4;'>$titulo</p>
                            </div>

                            <div class='opcoesProdutos' style='width:27px;'>
                                <a href=\"javascript:void(0);\" onclick=\"atualiza('listaProdutos.php?login=$login&idProd=$prodId&action=delete', 'conteudo');\" title='Remover do carrinho de orçamentos' ><img align='center' src='gerenciadoradmin/imagens/deletar.png' width='22px' height='22px'></a>                        
                            </div>
                        </div>";
                    $x++;
                }
                ?>
            </div>
            <div id="mensagem" style="text-align:center;">
                <p align="center" style="font-weight:bold;color:#000;font-size:14px;">Digite sua observação</p>
                <table width="365px">
                    <tr>
                        <td></td><td><textarea align="center" cols="41" rows="6" name="obs" id="obs"></textarea></td>
                    </tr>
                </table><br>
                <?php
                    echo "<div align=\"center\"><a href=\"javascript:void(0);\" onclick=\"var msg = document.getElementById('obs').value;var url = 'listaProdutos.php?login=$login&session=$session&action=enviar&msg='+msg;atualiza(url, 'conteudo');\" style=\"color:#222;text-decoration:none;font-size:14px;\"><img src=\"gerenciadoradmin/imagens/share.gif\" width='14px' >Concluir orçamento</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:void(0);\" onclick=\"atualiza('listaProdutos.php?login=$login&action=deletarTudo', 'conteudo');\" style=\"color:#222;text-decoration:none;font-size:14px;\"><img src=\"gerenciadoradmin/imagens/cancelar.png\" width=\"14px\" height=\"14px\">Cancelar</a></div>";
                ?>
            </div>
        </div>
    </div>    
</div><br>

