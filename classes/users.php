<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author augusto
 */
class users 
{
    const TIPO_PESSOA_FISICA = 'f';
    const TIPO_PESSOA_JURIDICA = 'j';
    
    private $nome;
    private $email;
    private $fone;
    private $cidade;
    private $tipoPessoa;
    private $cpf;
    private $cnpj;
    private $login;
    private $senha;
    
    public function __construct($nome=null, $email=null, $fone=null, $login=null, $senha=null, $cidade=null, $tipoPessoa=self::TIPO_PESSOA_FISICA, $cpf=null, $cnpj=null)
    {
        if( $nome != null )
        {
            $this->__set('nome', $nome);
            $this->__set('email', $email);
            $this->__set('fone', $fone);
            $this->__set('cidade', $cidade);
            $this->__set('tipoPessoa', $tipoPessoa);
            $this->__set('cpf', $cpf);
            $this->__set('cnpj', $cnpj);
            $this->__set('login', $login);
            $this->__set('senha', $senha);
        }
        
        /**
         * Construtor da classe users
         */
    }
    
    public function __get($var)
    {
        return $this->$var;
        
        /**
         * Retorna a variável private
         * recebida por parâmetro.
         */
    }
    
    public function __set($var, $value)
    {
        $this->$var = $value;
        
        /**
         * Seta um valor para a variável
         * private, ambos recebidos por
         * parâmetro.
         */
    }
    
    public function verificarUser()
    {
        $login = $this->__get('login');
        $cpf   = $this->__get('cpf');
        $cnpj  = $this->__get('cnpj');
        
        $sql = "SELECT login
                  FROM userLogin
                 WHERE login = '{$login}'";
                 
        if ( strlen($cpf) > 0 )
        {
            $sql .= " OR cpf = '{$cpf}'";
        }
        else if ( strlen($cnpj) > 0 )
        {
            $sql .= " OR cnpj = '{$cnpj}'";
        }
        
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        if( $result[0] != null )
        {            
            return false;
        }
        else
        {
            return true;
        }
        
        /**
         * Verifica na base se existe o login setado,
         * se existir retorna falso se não, retorna 
         * verdadeiro. 
         */
    }
    
    public function salvarUser()
    {
        $nome        = $this->__get('nome');
        $email       = $this->__get('email');
        $fone        = $this->__get('fone');
        $cidade      = $this->__get('cidade');
        $tipoPessoa  = $this->__get('tipoPessoa');
        $cpf         = $this->__get('cpf');
        $cnpj        = $this->__get('cnpj');
        $login       = $this->__get('login');
        $senha       = $this->__get('senha');
        
        $sql = "INSERT INTO userLogin
                                ( nome,
                                  email,
                                  telefone,
                                  cidade,
                                  tipoPessoa,
                                  cpf,
                                  cnpj,
                                  login,
                                  senha )
                               VALUES
                                ( '{$nome}',
                                  '{$email}',
                                  '{$fone}',
                                  '{$cidade}',
                                  '{$tipoPessoa}',
                                  '{$cpf}',
                                  '{$cnpj}',
                                  '{$login}',
                                  '{$senha}' )";
        mysql_query($sql)or die(mysql_error());
        $this->createTempTable($login);
        
        /**
         * Salva na base de dados os dados do
         * novo usuário do site.
         */
    }
    
    public function loginUser($login, $senha)
    {
        $sql = "SELECT login,
                       senha 
                  FROM userLogin
                 WHERE login='$login'
                   AND senha='$senha'";
        
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        if( $result[0] != null )
        {            
            return true;
        }
        else
        {
            return false;
        }
        
        /**
         * Verifica se o usuário e senha estão
         * cadastrados no banco, se estão, retorna
         * falso, se não retorna verdadeiro.
         */
    }
    
    public function loginUserLog($login)
    {
        $sql = "SELECT login
                  FROM userLogin
                 WHERE login='$login'";
        
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        
        return ($result[0] != null);
        
        /**
         * Verifica na base se existe o login recebido
         * por parâmetro, se existir retorna falso se não, 
         * retorna verdadeiro. 
         */
    }
    
    //ln -s /var/www/html/sagu2trunk/modules/admin/classes/mpermssagu.class /var/www/html/sagu2trunk/classes/security/mpermssagu.class // criar links
    //$conn .= "options='--client_encoding=LATIN1'" // pro sagu funcionar com utf-8
    //window.scrollTo(0,0); // javascript para setar o foco da página.
    
    public function createTempTable($login)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $login(
                    id_orcamento int(11) NOT NULL AUTO_INCREMENT,
                    id_produto int(11) DEFAULT NULL,
                    PRIMARY KEY (id_orcamento)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";        
        mysql_query($sql)or die(mysql_error());
        
        /**
         * Cria uma tabela para o usuário do site
         * onde serão gravados todos os produtos
         * no qual ele irá selecionar, para em seguida
         * serem salvos na tabela de orçamentos.
         */
    }
    
    public function insertProduto($table, $idProd)
    {
        $sql = "SELECT id_produto
                  FROM $table
                 WHERE id_produto=$idProd";
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        if( $result[0] == null )
        {
            $sql = "INSERT INTO $table
                                    ( id_produto )
                                VALUES
                                    ( $idProd )";
            mysql_query($sql)or die(mysql_error());
            
            return true;
        }
        else
        {
            return false;
        }
        
        /**
         * Insere o produto selecionado pelo usuário
         * em sua respectiva tabela de orçamentos. 
         */
    }
    
    public function deleteProduto($table, $idProd)
    {
        $sql = "DELETE FROM $table 
                      WHERE id_produto=$idProd";
        mysql_query($sql)or die(mysql_error());
        
        /**
         * Deleta o produto da tabela de orçamentos
         * do usuário.
         */
    }
    
    public function getAllIdsProdUser($table)
    {
        $sql = "SELECT id_produto
                  FROM $table
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
         * selecinados para serem orçados pelo usuário.
         *  
         */    
    }
    
    public function deleteAllProd($table)
    {
        $sql = "DELETE FROM $table 
                      WHERE id_orcamento > 0";
        mysql_query($sql)or die(mysql_error());
        
        /**
         * Deleta todos os produtos da tabela de
         * orçamentos do usuário.
         */
    }
    
    public function getNameUserByLogin($login)
    {
        $sql = "SELECT nome 
                  FROM userLogin
                 WHERE login = '$login'";
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        return $result;
        
        /**
         * Retorna o nome do usuário referente
         * ao seu login recebido por parâmetro.
         */
    }
    
    public function getNameUserByEmail($email)
    {
        $sql = "SELECT nome 
                  FROM userLogin
                 WHERE email='$email'";
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        return $result;
        
        /**
         * Retorna o nome do usuário referente
         * ao seu email recebido por parâmetro.
         */
    }
    
    public function getFoneByName($name)
    {
        $sql = "SELECT telefone
                  FROM userLogin
                 WHERE nome = '$name'"; 
        $busca = mysql_query($sql)or die(mysql_error());
        $result = mysql_fetch_array($busca);
        
        return $result;
        
        /**
         * Retorna o telefone do usuário referente
         * ao seu nome recebido por parâmetro.
         */
    }
    
    public function getIdsOrcamentos()
    {
        $sql = "SELECT id_orcamento 
                  FROM orcamentos
              ORDER BY data";
        $busca = mysql_query($sql)or die(mysql_error());
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_orcamento"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna todos os ids dos orçamentos
         * que estão cadastrados na base. 
         */
    }
    
    public function getIdsContatos()
    {
        $sql = "SELECT id_contato 
                  FROM contatos
              ORDER BY data";
        $busca = mysql_query($sql)or die(mysql_error());
        
        while($dados = mysql_fetch_array($busca))
        {
            $ids[] = $dados["id_contato"];
        }
        $ids[] = 'end';
        
        return $ids;
        
        /**
         * Retorna todos os ids dos contatos
         * que estão cadastrados na base. 
         */
    }
    
    public function getOrcamento($idOrca)
    {
        $sql = "SELECT id_orcamento,
                       data,
                       nomeUser,
                       emailUser,
                       foneUser,
                       mensagem,
                       status
                  FROM orcamentos
                 WHERE id_orcamento=$idOrca";
        $busca = mysql_query($sql)or die(mysql_error());
            
        $orcamento = array();
        while($dados = mysql_fetch_array($busca))
        {
            $orcamento[] = $dados["id_orcamento"];
            $orcamento[] = $dados["data"];
            $orcamento[] = $dados["nomeUser"];
            $orcamento[] = $dados["emailUser"];
            $orcamento[] = $dados["foneUser"];
            $orcamento[] = $dados["mensagem"];
            $orcamento[] = $dados["status"];
        }
            
        return $orcamento;
        
        /**
         * Retorna todos os dados do orçamento da base
         * recebido por parâmetro o id do mesmo. 
         */
    }
    
    public function changeStatusOrc($idOrc)
    {
        $sql = "SELECT status
                  FROM orcamentos
                 WHERE id_orcamento = $idOrc";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'respondido' )
        {
            $sql = "UPDATE orcamentos
                       SET status = 'respondido'
                     WHERE id_orcamento = $idOrc";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE orcamentos
                       SET status = 'aguardando'
                     WHERE id_orcamento = $idOrc";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status do orçamento recebido
         * por parâmetro o id.
         */
    }
    
    public function getContato($idCont)
    {
        $sql = "SELECT id_contato,
                       data,
                       nomeRem,
                       emailRem,
                       foneRem,
                       mensagem,
                       status
                  FROM contatos
                 WHERE id_contato=$idCont";
        $busca = mysql_query($sql)or die(mysql_error());
            
        $contato = array();
        while($dados = mysql_fetch_array($busca))
        {
            $contato[] = $dados["id_contato"];
            $contato[] = $dados["data"];
            $contato[] = $dados["nomeRem"];
            $contato[] = $dados["emailRem"];
            $contato[] = $dados["foneRem"];
            $contato[] = $dados["mensagem"];
            $contato[] = $dados["status"];
        }
            
        return $contato;
        
        /**
         * Retorna todos os dados do contato na base
         * recebido por parâmetro o id do mesmo. 
         */
    }
    
    public function changeStatusCont($idCont)
    {
        $sql = "SELECT status
                  FROM contatos
                 WHERE id_contato = $idCont";        
        $busca = mysql_query($sql)or die(mysql_error());        
        $status = array();
        
        while($dados = mysql_fetch_array($busca))
        {
            $status[] = $dados["status"];
        }
        
        if ( $status[0] != 'respondido' )
        {
            $sql = "UPDATE contatos
                       SET status = 'respondido'
                     WHERE id_contato = $idCont";
            mysql_query($sql)or die(mysql_error());
        }
        else
        {
            $sql = "UPDATE contatos
                       SET status = 'aguardando'
                     WHERE id_contato = $idCont";
            mysql_query($sql)or die(mysql_error());
        }
        
        /**
         * Muda o status do contato recebido
         * por parâmetro o id.
         */
    }
    
    public static function montarDadosDoUsuarioParaEmail($login = null, $dataUser = null)
    {
        if ( is_null($dataUser) )
        {
            $dataUser = self::getDataUserByLogin($login);
        }
        
        $dadosEmail = "<strong>Nome: </strong>{$dataUser->nome}<br>";
        $dadosEmail .= "<strong>Cidade: </strong>{$dataUser->cidade}<br>";
        $dadosEmail .= "<strong>E-mail: </strong>{$dataUser->email}<br>";
        
        if ( strlen($dataUser->cpf) > 0 )
        {
            $dadosEmail .= "<strong>CPF: </strong>{$dataUser->cpf}<br>";
        }
        else if ( strlen($dataUser->cnpj) > 0 )
        {
            $dadosEmail .= "<strong>CNPJ: </strong>{$dataUser->cnpj}<br>";
        }
        
        return $dadosEmail . "<br>";
    }
    
    public static function getDataUserByLogin($login)
    {
        $sql = "SELECT id_user,
                       nome,
                       email,
                       telefone,
                       cidade,
                       tipoPessoa,
                       cpf,
                       cnpj,
                       login,
                       senha
                  FROM userLogin
                 WHERE login='{$login}'";
                 
        $busca     = mysql_query($sql)or die(mysql_error());
        $loginData = new stdClass();
        
        while ( $dados = mysql_fetch_array($busca) )
        {
            $loginData->id_user    = $dados["id_user"];
            $loginData->nome       = $dados["nome"];
            $loginData->email      = $dados["email"];
            $loginData->telefone   = $dados["telefone"];
            $loginData->cidade     = $dados["cidade"];
            $loginData->tipoPessoa = $dados["tipoPessoa"];
            $loginData->cpf        = $dados["cpf"];
            $loginData->cnpj       = $dados["cnpj"];
            $loginData->login      = $dados["login"];
            $loginData->senha      = $dados["senha"];
            
            break;
        }
            
        return $loginData;
    }
    
}

?>
