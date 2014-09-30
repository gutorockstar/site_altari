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
class noticia
{
    private $titulo;
    private $startdate;
    private $endDate;
    private $status;
    private $descri;
    
    public function __construct( $titulo=null, $startDate=null, $endDate=null, $status=null, $descri=null, $idNot=null, $update=false )
    {        
        if( $titulo != null )
        {
            $this->__set( 'titulo', $titulo );
            $this->__set( 'startDate', $startDate );
            $this->__set( 'endDate', $endDate );
            $this->__set( 'status', $status );
            $this->__set( 'descri', $descri );
            
            if( !$update )
            {
                // Add.
                $this->gravarNoticia();
            }
            else
            {
                // Update.
                $this->editarNoticia($idNot);
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
    
    public function gravarNoticia()
    {
        $titulo    = $this->__get('titulo');
        $startDate = $this->__get('startDate');
        $endDate   = $this->__get('endDate');
        $status    = $this->__get('status');
        $descri    = $this->__get('descri');
        
        $sql = "INSERT INTO noticias
                            ( titulo, 
                              startDate, 
                              endDate, 
                              status, 
                              descricao )
                     VALUES 
                            ( '$titulo',
                              '$startDate',
                              '$endDate',
                              '$status',
                              '$descri' )";
        
        mysql_query($sql)or die("Erro aqui:".mysql_error());
        
        /**
         * Grava os dados da nova notícia
         * no banco de dados. 
         */
    }
    
    public function editarNoticia($id)
    {
        $titulo    = $this->__get('titulo');
        $startDate = $this->__get('startDate');
        $endDate   = $this->__get('endDate');
        $status    = $this->__get('status');
        $descri    = $this->__get('descri');
        
        $sql = "UPDATE noticias
                   SET titulo='$titulo',
                       startDate='$startDate',
                       endDate='$endDate',
                       status='$status',
                       descricao='$descri'
                 WHERE id_noticia=$id";
        mysql_query($sql)or die("Erro aqui:".mysql_error());
        
        /**
         * Edita os dados da noticia no
         * banco de dados 
         */
    }
    
    public function getAllIds()
    {
        $sql = "SELECT id_noticia
                  FROM noticias
              ORDER BY id_noticia";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_noticia"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids das notícias
         *  
         */
    }
    
    public function getAllIdsValidate()
    {
        $data = new data();
        
        $todayD = $data->getDateForBase();
        $today  = $data->convertDateToBase($todayD);
        
        $sql = "SELECT id_noticia
                  FROM noticias
                 WHERE status = 'ativo'
                   AND endDate >= '$today'
              ORDER BY id_noticia";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_noticia"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids das notícias
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
    
    public function getNoticia( $id )
    {
        $sql = "SELECT * 
                  FROM noticias
                 WHERE id_noticia=$id";
        $busca = mysql_query($sql)or die(mysql_error());
            
        $noticia = array();
        while($dados = mysql_fetch_array($busca))
        {
            $noticia[] = $dados["id_noticia"];            
            $noticia[] = $dados["titulo"];
            $noticia[] = $dados["startDate"];
            $noticia[] = $dados["endDate"];
            $noticia[] = $dados["status"];
            $noticia[] = $dados["descricao"];
        }
            
        return $noticia;
            
        /**
         * Retorna uma array com todos os dados da notícia
         * selecionada pelo id. 
         */
    }
    
    public function deletarNoticia($id)
    {
       $sql = "DELETE FROM noticias
                     WHERE id_noticia=$id";
       mysql_query($sql)or die("Erro:".mysql_error());
        
        /**
         * Deleta do banco a notícia recebido por parâmetro
         * o seu id. 
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
    
    public function quebraDescri($descri)
    {        
        if( strlen($descri) > 56 )
        {
            $descriBroken = '';
            for( $x=0; $x<56; $x++ )
            {
                $descriBroken .= $descri[$x];
            }
            $descriBroken .= '...';
        }
        else
        {
            $descriBroken = $descri;
        }
        
        return $descriBroken;
    }
    
    public function changeStatus($idNot)
    {
        $sql = "SELECT status
                  FROM noticias
                 WHERE id_noticia = $idNot";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'ativo' )
        {
            $sql = "UPDATE noticias
                       SET status = 'ativo'
                     WHERE id_noticia = $idNot";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE noticias
                       SET status = 'inativo'
                     WHERE id_noticia = $idNot";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status da notícia recebida
         * por parâmetro o id.
         */
    }
}

?>
