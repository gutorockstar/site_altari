<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email
 *
 * @author augusto
 */
class email 
{
    /**
     * To
     * 
     * @var type 
     */
    private $para;
    
    /**
     * From
     * 
     * @var type 
     */
    private $de;
    
    /**
     * Message
     * 
     * @var type 
     */
    private $mensagem;
    
    /**
     * Subject
     * 
     * @var type 
     */
    private $assunto;
    
    private $nome;
    
    
    public function __construct($mensagem="", $assunto="", $de="", $para="", $nome="", $enviar=false, $idOrc=null, $idCont=null, $allAdmin=false)
    {
        $this->__set('mensagem', $mensagem);
        $this->__set('de', $de);
        $this->__set('para', $para);
        $this->__set('assunto', $assunto);
        $this->__set('nome', $nome);
        
        if( $enviar )
        {
            $this->enviar();
        }
        
        if( $idOrc != null )
        {
            $this->atualizarStatusOrc($idOrc);
        }
        
        if( $idCont != null )
        {
            $this->atualizarStatusCont($idCont);
        }
        
        if( $allAdmin )
        {
            $para = $this->getEmailsFromAdmins();
            $x = 0;
            
            while( $para[$x] != 'end' )
            {
                $this->sendMail($para[$x], $de, $mensagem, $assunto);
                $x++;
            }
         }
        
        /**
         * Construtor da classe de email
         */
    }
    
    public function __get($var)
    {
        return $this->$var;
        
        /**
         * Retorna a variável private recebida
         * por parâmetro
         */
    }
    
    public function __set($var, $value)
    {
        $this->$var = $value;
        
        /**
         * Seta o valor para a variável private
         * ambos dados recebidos por parâmetro.
         */
    }
    
    public function enviar()
    {
        $para     = $this->__get('para');
        $de       = $this->__get('de');
        $mensagem = $this->__get('mensagem');
        $assunto  = $this->__get('assunto');
        
        if( $this->sendMail($para, $de, $mensagem, $assunto) )
        {
            return true;
        }
        else
        {
            return false;
        }
        
        /**
         * Prepara os dados para o envio 
         * de email.
         */
    }
    
    public function getEmailUser($user)
    {
        $sql = "SELECT email
                  FROM userLogin
                 WHERE login='$user'";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $email = mysql_fetch_array($busca);
        $mail  = $email[0];
        $this->__set('de', $mail);
                
        return $mail;
        
        /**
         * Busca na base o email do usuário
         * que está logado. 
         */
    }
    
    public function getNameUser($user)
    {
        $sql = "SELECT nome
                  FROM userLogin
                 WHERE login='$user'";
        $busca = mysql_query($sql)or die("Erro".mysql_error());
        $nome = mysql_fetch_array($busca); 
        $this->__set('nome', $nome[0]);
                
        return $nome;
        
        /**
         * Busca na base o nome do usuário
         * que está logado. 
         */
    }
    
    public function getEmailsFromAdmins()
    {
        $sql = "SELECT email
                  FROM login";
        $busca = mysql_query($sql)or die(mysql_error());
        while($dados = mysql_fetch_array($busca))
        {
            $emails[] = $dados["email"];
        }
        
        return $emails;
        
        /**
         * Busca na base todos os emails dos
         * administradores do site 
         */
    }
    
    function sendMail($para, $de, $mensagem, $assunto)
    {
        $headers = "MIME-Version: 1.1\n";
        $headers .= "Content-type: text/html; charset=utf-8\n";
        $headers .= "From: $de\n";
        $headers .= "Return-Path: $de\n";
        $headers .= "Reply-To: $de\n";
        
        return mail($para, $assunto, $mensagem, $headers, "-f{$de}");
    }
    
    public function salvarOrcamento($data='', $nomeUser='', $de='', $fone='', $mensagem='')
    {
        include('data.php');
        
        $de       = $this->__get('de'); //Email
        $mensagem = $this->__get('mensagem'); //Mensagem
        
        $date = new data();
        $data = $date->getDateForBase();//Data
                
        $user = new users();
        $nome = $user->getNameUserByEmail($de);//Nome [0]
        $nome = $nome[0];
        
        $fone = $user->getFoneByName($nome);//Telefone
        $fone = $fone[0];    
                
        $sql = "INSERT INTO orcamentos
                                ( data,
                                  nomeUser,
                                  emailUser,
                                  foneUser,
                                  mensagem,
                                  status )
                                VALUES
                                ( '$data',
                                  '$nome',
                                  '$de',
                                  '$fone',
                                  '$mensagem',
                                  'aguardando')";
       
        mysql_query($sql)or die("Erro aqui:$sql".mysql_error());
    }
    
    public function atualizarStatusOrc($idOrc)
    {
        $sql = "UPDATE orcamentos
                   SET status='respondido'
                 WHERE id_orcamento=$idOrc";
        mysql_query($sql)or die(mysql_error());
    }
    
    public function salvarContato($data=null, $nome=null, $de=null, $fone=null, $mensagem=null)
    {
        include('data.php');
        
        $de       = $this->__get('de'); //Email
        $mensagem = $this->__get('mensagem'); //Mensagem
        $user     = new users();
        
        if( $data == null )
        {
            $date = new data();
            $data = $date->getDateForBase();//Data
        }
        
        if( $nome == null )
        {
            $nome = $user->getNameUserByEmail($de);//Nome [0]
            $nome = $nome[0];
        }
        
        if( $fone == null )
        {
            $fone = $user->getFoneByName($nome);//Telefone
            $fone = $fone[0];    
        }
                
        $sql = "INSERT INTO contatos
                                ( data,
                                  nomeRem,
                                  emailRem,
                                  foneRem,
                                  mensagem,
                                  status )
                                VALUES
                                ( '$data',
                                  '$nome',
                                  '$de',
                                  '$fone',
                                  '$mensagem',
                                  'aguardando')";
       
        mysql_query($sql)or die("Erro aqui:$sql".mysql_error());
    }
    
    public function atualizarStatusCont($idCont)
    {
        $sql = "UPDATE contatos
                   SET status='respondido'
                 WHERE id_contato=$idCont";
        mysql_query($sql)or die(mysql_error());
    }
}

?>
