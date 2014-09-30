<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of funcoes
 *
 * @author augusto
 */
    class home 
    {
        private $tabela;
        private $coluna;

        public function __construct($tabela, $coluna) 
        {            
            self::setTabela($tabela);
            self::setColuna($coluna);
            
            /**
             * Construtor onde recebe uma tabela e uma coluna
             * para serem trabalhadas com o banco sql.  
             */
        }

        public function __destruct() 
        {
            self::setTabela(NULL);
            self::setColuna(NULL);
            
            /**
              * Destrutor onde desocupa o espaço utilizado
              * pelo construtor para alocar os repectivos dados. 
             */
            
        }
        

        public function setTabela($tabela) 
        {
            $this->tabela = $tabela;
            
            /**
             * Seta uma tabela recebida por parâmetro. 
             */
        }

        public function getTabela() 
        {
            return $this->tabela;
            
            /**
             * Retorna o valor da tabela global.
             */
        }
        
        public function setColuna($coluna)
        {
            $this->coluna = $coluna;
            
            /**
             * Seta uma coluna recebida por parâmetro. 
             */
        }
        
        public function getColuna()
        {
            return $this->coluna;
            
            /**
             * Retorna o valor da coluna global.
             */
        }
        
        public function gravarHome($conteudo)
        {
            $sql = "INSERT INTO `".self::getTabela()."`(`".self::getColuna()."`) 
                    VALUES ('$conteudo')";
            mysql_query($sql)or print(mysql_error());
            
            /**
             * Grava no banco de dados o conteúdo enviado por 
             * parâmetro. 
             */
        }
        
        public function updateHome($conteudo)
        {
            $sql = "UPDATE ".self::getTabela()." 
                    SET ".self::getColuna()."='$conteudo' 
                    WHERE id_home=1";
            mysql_query($sql)or print(mysql_error());

            /**
             * Edita o conteúdo do home que está gravado no
             * banco de dados.
             */
        }
        
        public function deletaHome()
        {
            $sql = "DELETE FROM ".self::getTabela()."
                    WHERE id_home=1";
            mysql_query($sql);
            
            /**
             * Deleta o conteúdo do home que está gravado no 
             * banco de dados.
             */
        }
        
        public function imprimirHome()
        {
            $sql = "SELECT * 
                    FROM ".self::getTabela()." 
                    ORDER BY id_home 
                    DESC LIMIT 1";
            $busca = mysql_query($sql)or print(mysql_error());
            
            while($linha = mysql_fetch_array($busca))
            {
                $conteudo = $linha["conteudo"];
                return $conteudo;
            }
            
            /**
             * Retorna o conteúdo do home que está salvo no 
             * banco de dados. 
             */
        }
    }

?>
