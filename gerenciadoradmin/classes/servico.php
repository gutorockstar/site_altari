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
class servico {
    
    private $titulo;
    private $status;
    private $descri;
    
    public function __construct( $titulo='', $status='', $descri='', $idServ=null, $update=false ){
        
        if( $titulo != '' )
        {
            $this->__set( 'titulo', $titulo );
            $this->__set( 'status', $status );
            $this->__set( 'descri', $descri );
            
            if( !$update )
            {
                // Add.
                $this->gravarServico();
                $this->criarDirServico();
            }
            else
            {
                // Update.
                $this->editarServico($idServ);
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
    
    public function gravarServico()
    {
        $titulo = $this->__get( 'titulo' );
        $status = $this->__get( 'status' );
        $descri = $this->__get( 'descri' );
        
        $sql = "INSERT INTO servicos
                            ( titulo, 
                              status, 
                              descricao )
                     VALUES 
                            ( '$titulo',
                              '$status',
                              '$descri' )";
        
        mysql_query($sql)or die("Erro aqui:".mysql_error());
        
        /**
         * Grava os dados do novo produto
         * no banco de dados. 
         */
    }
    
    public function editarServico($id)
    {
        $titulo = $this->__get( 'titulo' );
        $status = $this->__get( 'status' );
        $descri = $this->__get( 'descri' );
        
        $sql = "UPDATE servicos
                   SET titulo='$titulo',
                       status='$status',
                       descricao='$descri'
                 WHERE id_servico=$id";
        mysql_query($sql)or die("Erro aqui:".mysql_error());
        
        /**
         * Edita os dados do produto no
         * banco de dados 
         */
    }
    
    public function criarDirServico()
    {
        $sql = "SELECT id_servico
                  FROM servicos 
              ORDER BY id_servico 
            DESC LIMIT 1";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $id = mysql_fetch_array($busca);
        
        $dir = '../../Imagens/serviços/'.$id[0];
        
        if( mkdir( $dir, 0777 ) )
        {
            $sql = "UPDATE servicos
                       SET imagens='$dir'
                     WHERE id_servico=$id[0]";
            mysql_query($sql)or die("Erro:".mysql_error());
        }
        
        /**
         * Cria um diretório do produto recem cadastrado
         * para serem salvas suas imagens.
         */       
    }
    
    public function getAllIds()
    {
        $sql = "SELECT id_servico
                  FROM servicos
              ORDER BY id_servico";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_servico"];
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
        $sql = "SELECT id_servico
                  FROM servicos
                 WHERE status='ativo'
              ORDER BY titulo ";
        
        if( $home )
        {
            $sql .= 'DESC LIMIT 2';
        }
        
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_servico"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos com status ativo.
         *  
         */
    }
    
    public function getQuantServicos()
    {
        $sql = "SELECT COUNT(id_servico) 
                        FROM servicos";
        
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade total de produtos que estão
         * registradas no banco. 
         */
    }
    
    public function getServico($id)
    {
        $sql = "SELECT * 
                  FROM servicos
                 WHERE id_servico=$id";
        $busca = mysql_query($sql)or die(mysql_error());
            
        $servico = array();
        while($dados = mysql_fetch_array($busca))
        {
            $servico[] = $dados["id_servico"];
            $servico[] = $dados["titulo"];
            $servico[] = $dados["status"];
            $servico[] = $dados["descricao"];
            $servico[] = $dados["imagemChamada"];
        }
            
        return $servico;
            
        /**
         * Retorna uma array com todos os dados do produto
         * selecionado pelo id. 
         */
    }
    
    public function deletarServico($id)
    {
       $sql = "DELETE FROM servicos
                     WHERE id_servico=$id";
       mysql_query($sql)or die("Erro:".mysql_error());
       
       $this->deletaDirServico($id);
        
        /**
         * Deleta do banco o produto recebido por parâmetro
         * o seu id. 
         */
    }
    
    public function deletaDirServico($id)
    {
        $dir = '../../Imagens/serviços/'.$id;

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
    
    public function getIdsByNoNathing()
    {
        $sql = "SELECT id_servico
                  FROM servicos
                 WHERE status='ativo'
              ORDER BY id_servico";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_servico"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids dos produtos sem categorias
         * e sem subcategorias.
         *  
         */
    }
    
    public function getImagemChamada($idServ)
    {
        $sql = "SELECT imagemChamada
                  FROM servicos
                 WHERE id_servico=$idServ";
        $busca = mysql_query($sql)or die('Erro: '.mysql_error());
        $imagem = mysql_fetch_array($busca);
        
        return $imagem[0];
        
    }
    
    public function updateChamada($idServ, $img)
    {
        $sql = "UPDATE servicos
                   SET imagemChamada='$img' 
                 WHERE id_servico=$idServ";        
        mysql_query($sql)or die('Erro: '.mysql_error());
    }
    
    public function changeStatus($idServ)
    {
        $sql = "SELECT status
                  FROM servicos
                 WHERE id_servico = $idServ";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'ativo' )
        {
            $sql = "UPDATE servicos
                       SET status = 'ativo'
                     WHERE id_servico = $idServ";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE servicos
                       SET status = 'inativo'
                     WHERE id_servico = $idServ";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status do serviço recebido
         * por parâmetro o id.
         */
    }
}

?>
