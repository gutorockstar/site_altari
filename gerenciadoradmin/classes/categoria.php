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

class categoria 
{
    
    private $titulo;
    private $imagem;
    private $descri;
    private $status;
    
    public function __construct($titulo='', $imagem='', $descri='', $status='', $update='', $id='')
    {            
        if( $titulo!='')   
        {            
            self::setTitulo($titulo);
            self::setDescri($descri);
            self::setStatus($status);
         
            self::gravarCategoria($update, $id);
            
            if( $update == '' )
            {
                if(self::validaImagem($imagem))
                {
                    self::setImagem($imagem);
                    self::salvarImagem($imagem, self::getUltimoId());
                }
            }
            else
            {
                if( $imagem['name'] != null)
                {
                    if(self::validaImagem($imagem))
                    {
                        self::setImagem($imagem);
                        self::salvarImagem($imagem, $id, $update);
                    }
                }                
            }
        }
        
        /**
         * Construtor onde recebe como parâmetros todos os dados
         * da categoria e salva no banco, ou se for apenas acesso,
         * somente constroi a classe.
         */
    }
    
    public function getTitulo()
    {
        return $this->titulo;
        
        /**
         * Retorna o título da categoria. 
         */
    }
    
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        
        /**
         * Recebe o título da categoria. 
         */
    }
    
    public function getImagem()
    {
        return $this->imagem;
        
        /**
         * Retorna a imagem da categoria. 
         */
    }
    
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
        
        /**
         * Recebe a imagem da categoria. 
         */
    }
    
    public function getDescri()
    {
        return $this->descri;
        
        /**
         * Retorna a descrição da categoria.
         */
    }
    
    public function setDescri($descri)
    {
        $this->descri = $descri;
        
        /**
         * Recebe a descrição da categoria. 
         */
    }
    
    public function getStatus()
    {
        return $this->status;
        
        /**
         * Retorna o status da categoria. 
         */
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
        
        /**
         * Recebe o status da categoria. 
         */
    }
    
    public function gravarCategoria($up, $id)
    {
        $titulo   = self::getTitulo();
        $descri   = self::getDescri();
        $status   = self::getStatus();
        
        if( $up != '')
        {
            $sql = "UPDATE categorias 
                    SET titulo='$titulo', 
                        descricao='$descri',
                        status='$status'
                    WHERE id_categoria=$id";
            mysql_query($sql)or die("Aqui deu erro".mysql_error());
        }
        else
        {
            $sql = "INSERT INTO categorias(titulo, descricao, status)
                        VALUES ('$titulo', '$descri', '$status')";

            mysql_query($sql)or die("Erro:".mysql_error());
        }
        
        /**
         * Grava no banco os dados principais da categoria ou edita a categoria. 
         */
    }
    
    public function validaImagem($imagem)
    {
        if ($imagem) 
        {
            if (!eregi('^image\/(pjpeg|jpeg|png|gif|bmp)$', $imagem['type'])) 
            {
                return false;
            }
            else 
            {
                return true;
            }
        }
        else
        {
           return false; 
        }
        
        /**
         * Validador de imagem, verifica se o arquivo dado como POST
         * é realmente um arquivo de imagem e verifica se é de uma 
         * extenção compátivel, somente assim retornando true. 
         */
    }
    
    public function getUltimoId()
    {
        $sql = "SELECT id_categoria 
                  FROM categorias 
              ORDER BY id_categoria 
            DESC LIMIT 1";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $id = mysql_fetch_array($busca); 
            
        return $id;
        
        /**
         * Retorna o id da última categoria cadastrada
         * no banco. 
         */
    }
    
    public function salvarImagem($imagem, $id, $update='')
    {
        preg_match('/\.(gif|bmp|png|jpg|jpeg){1}$/i', $imagem['name'], $ext);
        $nomeImagem = $id[0].$ext[0];
        $dir        = "Imagens/categorias/";
        
        if( $update != '') // Se for editar a imagem.
        {
            $nomeImagem = $id.$ext[0];
            self::verificaImagem($id, $dir.$nomeImagem); //se a imagem existir já será deletada.
            move_uploaded_file($imagem['tmp_name'], '../../'.$dir.$nomeImagem);
        }
        else //Se estivér adicionando uma categoria nova.
        {
            move_uploaded_file($imagem['tmp_name'], '../../'.$dir.$nomeImagem);
            $idc = self::getUltimoId();

            $sql = "UPDATE categorias 
                    SET imagem='".$dir.$nomeImagem."' 
                    WHERE id_categoria=$idc[0]";
            mysql_query($sql)or die(mysql_error());

            return true;
        }
        
        /**
         * Salva a imagem da categoria no diretório específicado
         * e salva no banco da categoria o diretório da imagem. 
         */
    }
    
    public function verificaImagem($id, $dirImagemNova)
    {
        $sql = "SELECT imagem
                  FROM categorias
                 WHERE id_categoria=$id";
        $busca = mysql_query($sql)or die(mysql_error());
        $dirImagem = mysql_fetch_array($busca);
        
        if( file_exists($dirImagem[0]) )
        {
            self::deletaImagem($dirImagem[0]);
        }
        
        $sql = "UPDATE categorias 
                   SET imagem='$dirImagemNova' 
                 WHERE id_categoria=$id";
        mysql_query($sql)or die(mysql_error());
        
        /**
         * Verifica se a imagem existe, se exitir, deleta e atualiza o banco
         * se não existir apenas atualiza no banco. 
         */
    }
    
    public function deletaImagem($dirImagem)
    {
        unlink($dirImagem);
        
        /**
         * Deleta uma imagem recebida como parâmetro.
         */
    }
    
    public function getQuantCategorias()
    {
        $sql = "SELECT COUNT(id_categoria) 
                        FROM categorias";
        
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade total de categorias que estão
         * registradas no banco. 
         */
    }
    
    public function getCategoria($id)
    {
        $sql = "SELECT * 
                  FROM categorias
                 WHERE id_categoria=$id";
        $busca = mysql_query($sql);
            
        $categoria = array();
        while($dados = mysql_fetch_array($busca))
        {
            $categoria[] = $dados["id_categoria"];
            $categoria[] = $dados["titulo"];
            $categoria[] = $dados["imagem"];
            $categoria[] = $dados["descricao"];
            $categoria[] = $dados["status"];
        }
            
        return $categoria;
            
        /**
         * Retorna uma array com todos os dados da categoria
         * selecionada pelo id. 
         */
    }
    
    public function getAllIds()
    {
        $sql = "SELECT id_categoria
                  FROM categorias
              ORDER BY id_categoria";
        $busca = mysql_query($sql);
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_categoria"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna uma array com todos os ids das categorias
         *  
         */
    }
    
    public function getSubcatFromThis($idCat)
    {
        $sql = "SELECT count(id_subcategoria) 
                  FROM subcategorias 
                 WHERE id_categoria = $idCat
                   AND status = 'ativo'";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade de subcategorias
         * que a categoria, recebida por parâmetro
         * possui.
         */
    }
    
    public function getProdFromThis($idCat)
    {
        $sql = "SELECT count(id_produto) 
                  FROM produtos 
                 WHERE categoria = $idCat
                   AND subcategoria = 0
                   AND status = 'ativo'";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $quant = mysql_fetch_array($busca); 
            
        return $quant;
        
        /**
         * Retorna a quantidade de produtos
         * que a categoria, recebida por parâmetro
         * possui.
         */
    }
    
    public function changeStatus($idCat)
    {
        $sql = "SELECT status
                  FROM categorias
                 WHERE id_categoria = $idCat";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'ativo' )
        {
            $sql = "UPDATE categorias
                       SET status = 'ativo'
                     WHERE id_categoria = $idCat";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE categorias
                       SET status = 'inativo'
                     WHERE id_categoria = $idCat";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status da categoria recebida
         * por parâmetro o id.
         */
    }
}

?>
