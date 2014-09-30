<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of session
 *
 * @author augusto
 */
class session {
    private $session;
    
    public function __construct($session=null)
    {
        if( $session != null )
        {            
            $this->__set('session', $session);
        }
        else
        {
            $session = $this->createSession();            
            $this->__set('session', $session);
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
    
    public function createSession()
    {
        $CaracteresAceitos = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
        $max = strlen($CaracteresAceitos)-1;
        $session = null;

        for($i=0; $i < 20; $i++) 
        { 
            $session .= $CaracteresAceitos{mt_rand(0, $max)}; 
        }
        
        return $session;
        
        /**
         * Cria uma session randomica. 
         */
    }
}

?>
