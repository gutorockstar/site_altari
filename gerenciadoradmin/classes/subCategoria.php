<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of subCategorias
 *
 * @author augusto
 */
ini_set('display_errors', 'Off');
ini_set('display_startup_errors', 'Off');
error_reporting(0);

include('categoria.php');

class subCategoria extends categoria
{
    private $categoria;
    private $titulo;
    private $imagem;
    private $descri;
    private $status;
    
    public function __construct($categoria='', $titulo='', $imagem='', $descri='', $status='', $update='', $id='')
    {
        parent::__construct();
            
        if( $titulo!='')   
        {
            self::__set('categoria', $categoria);
            self::__set('titulo', $titulo);
            self::__set('descri', $descri);
            self::__set('status', $status);
            
            self::gravarSubCategoria($update, $id);
            
            if( $update == '' )
            {
                if(parent::validaImagem($imagem))
                {
                    self::setImagem($imagem);
                    self::salvarImagem($imagem, self::getUltimoId());
                }
            }
            else
            {
                if( $imagem['name'] != null)
                {
                    if(parent::validaImagem($imagem))
                    {
                        self::setImagem($imagem);
                        self::salvarImagem($imagem, $id, $update);
                    }
                }                
            }
        }
        
        /**
         * Construtor onde recebe como parâmetros todos os dados
         * da subcategoria e salva no banco, ou se for apenas acesso,
         * somente constroi a classe.
         */
    }
    
    public function __get($var)
    {
        return $this->$var;
        
        /**
         * Retorna o valor da variável private recebida
         * como parâmetro. 
         */
    }
    
    public function __set($var, $value) 
    {
        $this->$var = $value;
        
        /**
         * Seta o valor da váriavel, ambas recebidas como
         * parâmetro. 
         */
    }
    
    public function getTitulosCategorias($popula=FALSE)
    {
        if($popula)
        {
            $sql = "SELECT id_categoria, titulo 
                    FROM categorias
                ORDER BY titulo";
        }
        else
        {
            $sql = "SELECT id_categoria, titulo 
                    FROM categorias
                    WHERE status='ativo'
                ORDER BY titulo";
        }
        $busca = mysql_query($sql);
        
        $categorias = array();
        while($dados = mysql_fetch_array($busca))
        {
            $categorias[] = $dados['id_categoria'];
            $categorias[] = $dados['titulo'];
        }
        $categorias[] = "null";
        $categorias[] = "";
        $categorias[] = "end";
        
        return $categorias;
        
        /**
         * Retorna uma array com todos os títulos das categorias
         * para popular o checkbox. 
         */
    }
    
    public function getTitulosSubCategorias($popula=false, $idCat=null)
    {
        if($popula)
        {
            $sql = "SELECT id_subcategoria, titulo 
                      FROM subcategorias
                     WHERE id_categoria=$idCat
                  ORDER BY titulo";
        }
        else
        {
            $sql = "SELECT id_subcategoria, titulo 
                      FROM subcategorias
                     WHERE status='ativo'
                       AND id_categoria=$idCat
                  ORDER BY titulo";
        }
        $busca = mysql_query($sql);
        
        $subcategorias = array();
        while($dados = mysql_fetch_array($busca))
        {
            $subcategorias[] = $dados['id_subcategoria'];
            $subcategorias[] = $dados['titulo'];
        }
        $subcategorias[] = "null";
        $subcategorias[] = "";
        $subcategorias[] = "end";
        
        return $subcategorias;
        
        /**
         * Retorna uma array com todos os títulos das Subcategorias
         * para popular o checkbox. 
         */
    }
    
    public function gravarSubCategoria($up='', $id='')
    {
        $idCategoria = self::__get('categoria');
        $titulo      = self::__get('titulo');
        $descri      = self::__get('descri');
        $status      = self::__get('status');
        
        if( $up != '')
        {
            $sql = "UPDATE subcategorias
                    SET id_categoria=$idCategoria,
                        titulo='$titulo', 
                        descricao='$descri',
                        status='$status'
                    WHERE id_subcategoria=$id";
            mysql_query($sql)or die("Erro".mysql_error());
        }
        else
        {
            $sql = "INSERT INTO subcategorias(id_categoria, titulo, descricao, status)
                        VALUES ('$idCategoria', '$titulo', '$descri', '$status')";

            mysql_query($sql)or die("Erro:".mysql_error());
        }
        
        /**
         * Grava no banco os dados principais da subcategoria ou edita a categoria. 
         */
    }
    
     public function salvarImagem($imagem, $id, $update='')
    {
        preg_match('/\.(gif|bmp|png|jpg|jpeg){1}$/i', $imagem['name'], $ext);
        $nomeImagem = $id[0].$ext[0];
        $dir        = "Imagens/subcategorias/";
        
        if( $update != '')
        {
            $nomeImagem = $id.$ext[0];
            self::verificaImagem($id, $dir.$nomeImagem);
            move_uploaded_file($imagem['tmp_name'], '../../'.$dir.$nomeImagem);
        }
        else 
        {
            move_uploaded_file($imagem['tmp_name'], '../../'.$dir.$nomeImagem);
            $idc = self::getUltimoId();
            
            $sql = "UPDATE subcategorias 
                    SET imagem='".$dir.$nomeImagem."' 
                    WHERE id_subcategoria=$idc[0]";//Está dando pau aqui.
            mysql_query($sql)or die(mysql_error());
                 
            return true;
        }
        
        /**
         * Salva a imagem da subcategoria no diretório específicado
         * e salva no banco da subcategoria o diretório da imagem. 
         */
    }
    
    public function verificaImagem($id, $dirImagemNova)
    {
        $sql = "SELECT imagem
                  FROM subcategorias
                 WHERE id_subcategoria=$id";
        $busca = mysql_query($sql)or die(mysql_error());
        $dirImagem = mysql_fetch_array($busca);
        
        if( file_exists($dirImagem[0]) )
        {
            parent::deletaImagem($dirImagem[0]);
        }
        
        $sql = "UPDATE subcategorias 
                   SET imagem='$dirImagemNova' 
                 WHERE id_subcategoria=$id";
        mysql_query($sql)or die(mysql_error());
        
        /**
         * Verifica se a imagem existe, se exitir, deleta e atualiza o banco
         * se não existir apenas atualiza no banco. 
         */
    }
    
    public function getUltimoId()
    {
        $sql = "SELECT id_subcategoria 
                  FROM subcategorias 
              ORDER BY id_subcategoria 
            DESC LIMIT 1";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $id = mysql_fetch_array($busca); 
            
        return $id;
        
        /**
         * Retorna o id da última subcategoria cadastrada
         * no banco. 
         */
    }
    
    public function getQuantSubCategorias()
    {
        $sql = "SELECT COUNT(id_subcategoria) 
                        FROM subcategorias";
        
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade total de categorias que estão
         * registradas no banco. 
         */
    }
    
    public function getSubCategoria($id)
    {
        $sql = "SELECT * 
                  FROM subcategorias
                 WHERE id_subcategoria=$id";
        $busca = mysql_query($sql);
            
        $subcategoria = array();
        while($dados = mysql_fetch_array($busca))
        {
            $subcategoria[] = $dados["id_subcategoria"];
            $subcategoria[] = $dados["id_categoria"];
            $subcategoria[] = $dados["titulo"];
            $subcategoria[] = $dados["imagem"];
            $subcategoria[] = $dados["descricao"];
            $subcategoria[] = $dados["status"];
        }
            
        return $subcategoria;
            
        /**
         * Retorna uma array com todos os dados da categoria
         * selecionada pelo id. 
         */
    }
    
    public function getIds($idCat)
    {
        $sql = "SELECT id_subcategoria
                  FROM subcategorias
                 WHERE id_categoria=$idCat
              ORDER BY id_subcategoria";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_subcategoria"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids das subcategorias.
         *  
         */
    }
    
    public function getProdFromThis($idCat, $idSub)
    {
        $sql = "SELECT count(id_produto) 
                  FROM produtos 
                 WHERE categoria = $idCat
                   AND subcategoria = $idSub
                   AND status = 'ativo'";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade de produtos
         * que a subcategoria, recebida por parâmetro
         * junto com a categoria do qual pertence,
         * possui.
         */
    }
    
    public function changeStatus($idSub)
    {
        $sql = "SELECT status
                  FROM subcategorias
                 WHERE id_subcategoria = $idSub";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'ativo' )
        {
            $sql = "UPDATE subcategorias
                       SET status = 'ativo'
                     WHERE id_subcategoria = $idSub";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE subcategorias
                       SET status = 'inativo'
                     WHERE id_subcategoria = $idSub";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status da subcategoria recebida
         * por parâmetro o id.
         */
    }
}

?>
