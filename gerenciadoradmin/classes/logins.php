<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logins
 *
 * @author augusto
 */
class logins {
    private $nome;
    private $email;
    private $fone;
    private $login;
    private $senha;
    
    public function __construct($nome=null, $email=null, $fone=null, $login=null, $senha=null)
    {
        if( $nome != null )
        {
            $this->__set( 'nome', $nome );
            $this->__set( 'email', $email );
            $this->__set( 'fone', $fone );
            $this->__set( 'login', $login );
            $this->__set( 'senha', $senha );
            
            $this->gravarLogin();
        }
    }
    
    public function __get($var)
    {
        return $this->$var;
    }
    
    public function __set($var, $value)
    {
        $this->$var = $value;
    }
    
    public function gravarLogin()
    {
        $nome  = $this->__get('nome');
        $email = $this->__get('email');
        $fone  = $this->__get('fone');
        $login = $this->__get('login');
        $senha = $this->__get('senha');
        
        $sql = "INSERT INTO login
                            ( nome,
                              email,
                              telefone,
                              login,
                              senha )
                     VALUES
                            ( '$nome',
                              '$email',
                              '$fone',
                              '$login',
                              '$senha' )";
        mysql_query($sql)or die(mysql_error());
        
        /**
         * Insere um login de administrador do site
         * na base. 
         */
    }
    
    public function getIdsLogin()
    {
        $sql = "SELECT id_login 
                  FROM login
              ORDER BY id_login";
        $busca = mysql_query($sql)or die(mysql_error());
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_login"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna todos os ids dos administradores
         * que estão cadastrados na base. 
         */
    }
    
    public function getLogin($idLog)
    {
        $sql = "SELECT id_login,
                       nome,
                       email,
                       telefone,
                       login,
                       senha
                  FROM login
                 WHERE id_login=$idLog";
        $busca = mysql_query($sql)or die(mysql_error());
            
        $login = array();
        while($dados = mysql_fetch_array($busca))
        {
            $login[] = $dados["id_login"];
            $login[] = $dados["nome"];
            $login[] = $dados["email"];
            $login[] = $dados["telefone"];
            $login[] = $dados["login"];
            $login[] = $dados["senha"];
        }
            
        return $login;
        
        /**
         * Retorna todos os dados do login do administrador
         * recebido por parâmetro o id do login. 
         */
    }
    
    public function deleteLogin($idLog)
    {
        $sql = "DELETE FROM login
                      WHERE id_login=$idLog";        
        mysql_query($sql)or die(mysql_error());        
    }
    
    public function getIdloginByLogin($login)
    {
        $sql = "SELECT id_login
                  FROM login
                 WHERE login='$login'";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $id = mysql_fetch_array($busca);
                
        return $id;
    }
    
    public function validaLogin($login)
    {
        $sql = "SELECT *
                  FROM login
                 WHERE login = '$login'";
        
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $result = mysql_fetch_array($busca);
                
        return $result;
    }
}

?>
