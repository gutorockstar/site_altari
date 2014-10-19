<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config
 *
 * @author augusto
 */
class config {
    
    private $dbhost; // Local onde o banco está, ex: localhost;
    private $dbuser; // Usuário do banco.
    private $dbpsswd; // Senha do banco.
    private $dbname; // Nome do banco(database).
    
    public function __construct($dbhost=null, $dbuser=null, $dbpsswd=null, $dbname=null) 
    {
        if( $dbhost != null )
        {
            $this->__set('dbhost', $dbhost);
            $this->__set('dbuser', $dbuser);
            $this->__set('dbpsswd', $dbpsswd);
            $this->__set('dbname', $dbname);
        }
        else
        {
            $this->__set('dbhost', 'localhost');
            $this->__set('dbuser', 'altari_dbuser');
            $this->__set('dbpsswd', '73cn0n_altar1');
            $this->__set('dbname', 'altari_database');
            
            $this->conectarDB();
        }
        
        /**
         * Construtor que recebe os devidos parâmetros
         * para estabelecer a conexão com o banco de
         * dados
         */
    }
    
    public function __set($var, $value)
    {
        $this->$var = $value;
    }
    
    public function __get($var)
    {
        return $this->$var;
    }
    
    public function conectarDB()
    {
        @mysql_connect($this->__get('dbhost'), $this->__get('dbuser'), $this->__get('dbpsswd'))or die("Conexão com o banco falhou!");
        @mysql_select_db($this->__get('dbname'))or die("Conexão com a database ".$this->__get('dbname')." falhou!");
        return true;
        
        /**
         * Faz a conexão com o banco de dados e com a database. 
         */
    }
    
    public function encerrarCon()
    {
        @mysql_close();
    }
    
    public function descriBroken($descri)
    {        
        if( strlen($descri) > 50 )
        {
            $descriBroken = '';
            for( $x=0; $x<50; $x++ )
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
}

?>
