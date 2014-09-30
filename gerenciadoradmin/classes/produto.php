<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of produto
 *
 * @author augusto
 */
class produto 
{
    
    private $idCategoria;
    private $idSubCategoria;
    private $titulo;
    private $status;
    private $descri;
    
    public function __construct( $idCategoria='', $idSubCategoria='', $titulo='', $status='', $descri='', $idProd=null, $update=false )
    {        
        if( $titulo != '' )
        {
            $this->__set( 'idCategoria', $idCategoria );
            $this->__set( 'idSubCategoria', $idSubCategoria );
            $this->__set( 'titulo', $titulo );
            $this->__set( 'status', $status );
            $this->__set( 'descri', $descri );
            
            if( !$update )
            {
                // Add.
                $this->gravarProduto();
                $this->criarDirProduto();
            }
            else
            {
                // Update.
                $this->editarProduto($idProd);
            }
        }
        
        /**
         * Construtor onde recebe como parâmetros todos os dados
         * do produto e salva no banco, ou se for apenas acesso,
         * somente constroi a classe.
         */
    }
    
    public function __get( $var )
    {
        return $this->$var;
        
        /**
         * Retorna o valor da variável private recebida
         * como parâmetro. 
         */
    }
    
    public function __set( $var, $value )
    {
        $this->$var = $value;
        
        /**
         * Seta o valor da váriavel, ambas recebidas como
         * parâmetro. 
         */
    }
    
    public function gravarProduto()
    {
        $idCat  = $this->__get( 'idCategoria' );
        $idSub  = $this->__get( 'idSubCategoria' );
        
        if( ($idCat == 'null') || ($idCat == null) )
        {
            $idCat = 0;
            $idSub = 0;
        }
        
        if( ($idSub == 'null') || ($idSub == null) )
        {
            $idSub = 0;
        }
        
        $titulo = $this->__get( 'titulo' );
        $status = $this->__get( 'status' );
        $descri = $this->__get( 'descri' );
        
        $sql = "INSERT INTO produtos
                            ( categoria, 
                              subcategoria, 
                              titulo, 
                              status, 
                              descricao )
                     VALUES 
                            ( '$idCat',
                              '$idSub',
                              '$titulo',
                              '$status',
                              '$descri' )";
        
        mysql_query($sql)or die("Erro aqui:".mysql_error());
        
        /**
         * Grava os dados do novo produto
         * no banco de dados. 
         */
    }
    
    public function editarProduto($id)
    {
        $idCat  = $this->__get( 'idCategoria' );
        $idSub  = $this->__get( 'idSubCategoria' );
        
        if( ($idCat == 'null') || ($idCat == null) )
        {
            $idCat = 0;
        }
        
        if( ($idSub == 'null') || ($idSub == null) )
        {
            $idSub = 0;
        }
        
        $titulo = $this->__get( 'titulo' );
        $status = $this->__get( 'status' );
        $descri = $this->__get( 'descri' );
        
        $sql = "UPDATE produtos
                   SET categoria=$idCat,
                       subcategoria=$idSub,
                       titulo='$titulo',
                       status='$status',
                       descricao='$descri'
                 WHERE id_produto=$id";
        
        mysql_query($sql)or die("Erro aqui:".mysql_error());
        
        /**
         * Edita os dados do produto no
         * banco de dados 
         */
    }
    
    public function criarDirProduto()
    {
        $sql = "SELECT id_produto 
                  FROM produtos 
              ORDER BY id_produto 
            DESC LIMIT 1";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $id = mysql_fetch_array($busca);
        
        $dir = '../../Imagens/produtos/'.$id[0];
        
        if( mkdir( $dir, 0777 ) )
        {
            $sql = "UPDATE produtos
                       SET imagens='$dir'
                     WHERE id_produto=$id[0]";
            mysql_query($sql)or die("Erro:".mysql_error());
        }
        
        /**
         * Cria um diretório do produto recem cadastrado
         * para serem salvas suas imagens.
         */       
    }
    
    public function getAllIds()
    {
        $sql = "SELECT id_produto
                  FROM produtos
              ORDER BY id_produto";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_produto"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos
         *  
         */
    }
    
    public function getAllIdsActivate($home=false)
    {
        $sql = "SELECT id_produto
                  FROM produtos
                 WHERE status='ativo'";
        
        if( $home )
        {
            $sql .= 'ORDER BY id_produto
                   DESC LIMIT 3';
        }
        else
        {
            $sql .= 'ORDER BY titulo';
        }
        
        $busca = mysql_query($sql)or die('Erro:'.mysql_error());
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_produto"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos com status ativo.
         *  
         */
    }
    
    public function getQuantProdutos()
    {
        $sql = "SELECT COUNT(id_produto) 
                        FROM produtos";
        
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade total de produtos que estão
         * registradas no banco. 
         */
    }
    
    public function getProduto( $id )
    {
        $sql = "SELECT * 
                  FROM produtos
                 WHERE id_produto=$id";
        $busca = mysql_query($sql)or die(mysql_error());
            
        $produto = array();
        while($dados = mysql_fetch_array($busca))
        {
            $produto[] = $dados["id_produto"];
            $produto[] = $dados["categoria"];
            $produto[] = $dados["subcategoria"];
            $produto[] = $dados["titulo"];
            $produto[] = $dados["status"];
            $produto[] = $dados["descricao"];
            $produto[] = $dados["imagemChamada"];
        }
            
        return $produto;
            
        /**
         * Retorna uma array com todos os dados do produto
         * selecionado pelo id. 
         */
    }
    
    public function deletarProduto($id)
    {
       $sql = "DELETE FROM produtos
                     WHERE id_produto=$id";
       mysql_query($sql)or die("Erro:".mysql_error());
       
       $this->deletaDirProduto($id);
        
        /**
         * Deleta do banco o produto recebido por parâmetro
         * o seu id. 
         */
    }
    
    public function deletaDirProduto($id)
    {
        $dir = '../../Imagens/produtos/'.$id;

        foreach($imagens = scandir($dir) as $deletar)
        {
            @unlink($dir.'/'.$deletar);
        }

        @rmdir($dir);
        
        /**
         * Deleta o diretório das imagens do produto
         * recebido seu id por parâmetro. 
         */
    }
    
    public function getIds($idSub)
    {
        $sql = "SELECT id_produto
                  FROM produtos
                 WHERE subcategoria=$idSub
              ORDER BY subcategoria";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_produto"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos.
         *  
         */
    }
    
    public function getIdsByCat($idCat)
    {
        $sql = "SELECT id_produto
                  FROM produtos
                 WHERE categoria=$idCat
                   AND subcategoria=0
                   AND status='ativo'
              ORDER BY categoria";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_produto"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos sem subcategorias.
         *  
         */
    }
    
    public function getIdsByNoNathing()
    {
        $sql = "SELECT id_produto
                  FROM produtos
                 WHERE categoria=0
                   AND subcategoria=0
                   AND status='ativo'
              ORDER BY id_produto";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_produto"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos sem categorias
         * e sem subcategorias.
         *  
         */
    }
    
    public function getImagemChamada($idProd)
    {
        $sql = "SELECT imagemChamada
                  FROM produtos
                 WHERE id_produto=$idProd";
        $busca = mysql_query($sql)or die('Erro: '.mysql_error());
        $imagem = mysql_fetch_array($busca);
        
        return $imagem[0];
        
    }
    
    public function updateChamada($idProd, $img)
    {
        $sql = "UPDATE produtos 
                   SET imagemChamada='$img' 
                 WHERE id_produto=$idProd";        
        mysql_query($sql)or die('Erro: '.mysql_error());
    }
    
    public function selectRandom()
    {
        $sql = "SELECT id_produto, titulo, imagemChamada
                  FROM produtos
              ORDER BY rand() 
                 LIMIT 10";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $info[] = $dados["id_produto"];
            $info[] = $dados["categoria"];
            $info[] = $dados["subcategoria"];
            $info[] = $dados["titulo"];
            $info[] = $dados["imagemChamada"];
            $info[] = 'end';
            
        }
        
        return $info;        
    }
    
    public function tituloCategoria($idCat)
    {
        $sql = "SELECT titulo
                  FROM categorias
                 WHERE id_categoria=$idCat";
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        return $result;
        
        /**
         * Retorna o título da categoria recebendo o id
         * por parâmetro.  
         */
    }
    
    public function tituloSubCategoria($idSubCat)
    {
        $sql = "SELECT titulo
                  FROM subcategorias
                 WHERE id_subcategoria=$idSubCat";
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        return $result;
        
        /**
         * Retorna o título da subcategoria recebendo o id
         * por parâmetro.  
         */
    }
    
    public function changeStatus($idProd)
    {
        $sql = "SELECT status
                  FROM produtos
                 WHERE id_produto = $idProd";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'ativo' )
        {
            $sql = "UPDATE produtos
                       SET status = 'ativo'
                     WHERE id_produto = $idProd";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE produtos
                       SET status = 'inativo'
                     WHERE id_produto = $idProd";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status do produtos recebido
         * por parâmetro o id.
         */
    }
    
    /**
     * Ler todos conteúdos de um diretório
     * 
     * <?

        $album="album";

        foreach (scandir($album) as $fotos){

        echo $fotos."<br>";

        }

        ?> 
     */
}

?>
