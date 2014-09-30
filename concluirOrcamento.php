<?php
include('classes/config.php');
include('classes/users.php');
include('gerenciadoradmin/classes/produto.php');

$session = $_GET['session'];
session_start($session);

$config = new config();
$prod   = new produto();
$user   = new users();

$login = $_SESSION['login'];

$action = $_GET['action'];
echo "<a href=\"javascript:void(0);\" onclick=\"atualiza('listaProdutos.php?login=$login&session=$session&prim=true&action=insert', 'conteudo');\" title=\"Voltar para seleção de produtos\"><img src=\"gerenciadoradmin/imagens/voltar.png\" width=\"40px\" height=\"40px\"></a>";

?>

<div id="orçaExt">
    <div class="concOrça">
        Observações ou comentário:
    </div>
    
    <div class="concOrça2">
        <p align="center" style="font-weight: bold;">Produtos a serem orçados</p>
        <?php
        $cont = $user->getAllIdsProdUser($login);
        $x    = 0;

        while( $cont[$x] != 'end' )
        {
            $dadosProduto = $prod->getProduto($cont[$x]);

            $prodId    = $dadosProduto[0]; // id produto
            $prodCat   = $dadosProduto[1]; // id categoria
            $tituloCat = $prod->tituloCategoria($prodCat);
            $prodSub   = $dadosProduto[2]; // id da subcategoria
            $tituloSub = $prod->tituloSubCategoria($prodSub);
            $titulo    = $dadosProduto[3]; // titulo do produto            
            $chamada   = $dadosProduto[6]; //imagem de chamada

            echo "
                <div id='produtoIndex'>
                    <div class='imgProduto'>
                        <img src='Imagens/produtos/$prodId/$chamada' title='Clique para ver todas imagens' width='25px' height='25px'/>
                    </div>

                    <div class='tituloProdutoIndex'>
                        <p style='color:#4682B4;'>$titulo</p>
                    </div>

                    <div class='tituloCategoriaIndex'>
                        <p style='color:#222;'>$tituloCat[0]</p>
                    </div>

                    <div class='tituloSubCategoria'>
                        <p style='color:#222;'>$tituloSub[0]</p>
                    </div>
                </div>";
            $x++;
        }
        ?>
    </div>
</div>
