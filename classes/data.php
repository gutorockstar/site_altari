<?php

class data 
{

    private $diaSemana;
    private $dia;
    private $mes;
    private $mesExt;
    private $ano;

    public function __construct() 
    {
        $meses        = array
                           ( 1 => "Janeiro",
                             2 => "Fevereiro",
                             3 => "Março",
                             4 => "Abril",
                             5 => "Maio", 
                             6 => "Junho", 
                             7 => "Julho", 
                             8 => "Agosto", 
                             9 => "Setembro", 
                            10 => "Outubro", 
                            11 => "Novembro", 
                            12 => "Dezembro" );
        
        $diasdasemana = array
                           ( 1 => "Segunda-Feira",
                             2 => "Terça-Feira",
                             3 => "Quarta-Feira",
                             4 => "Quinta-Feira",
                             5 => "Sexta-Feira",
                             6 => "Sábado",
                             0 => "Domingo" );
        
        $hoje = getdate();  
        $this->__set('dia', $hoje["mday"]);
        
        $mes = $hoje["mon"];
        $this->__set('mes', $mes);
        $this->__set('mesExt', $meses[$mes]);
        
        $this->__set('ano', $hoje["year"]);
        
        $diadasemana = $hoje["wday"];
        $this->__set('diaSemana', $diasdasemana[$diadasemana]);
        
        /**
         * Construtor onde transforma a data do sitema para uma
         * leitura em extenço. 
         */
    }
    
    public function __get($var)
    {
        return $this->$var;
        
        /**
         * Retorna o valor da variável private
         * recebida por parâmetro.
         */
    }
    
    public function __set($var, $value)
    {
        $this->$var = $value;
        
        /**
         * Seta um valor para a variável private,
         * ambas recebidas por parâmetro.
         */
    }
    
    public function getDataCompleta()
    {
        $data = "&nbsp<b style='color:#222;'>".$this->__get('diaSemana').", ".$this->__get('dia')." de ".$this->__get('mesExt')." de ".$this->__get('ano')."</b>";
        
        return $data;
        
        /**
         * Busca a data completa escrita por extenço. 
         */
    }
    
    public function getDateForBase()
    {
        $dia  = $this->__get('dia');
        if( strlen($dia) == 1 )
        {
            $dia = '0'.$dia;
        }
        $data = $dia.'/';        
        
        $mes  = $this->__get('mes');
        if( strlen($mes) == 1 )
        {
            $mes = '0'.$mes;
        }
        $data .= $mes.'/';
        
        $data .= $this->__get('ano');       
        
        return $data;
    }
    
    public function convertDateToBase($data)
    {
        $date = array();
        $date = explode('/', $data);
        
        $finalDate = '';
        foreach($date as $components)
        {
            if( $finalDate != '' )
            {
                $finalDate = $components.'-'.$finalDate;
            }
            else
            {
                $finalDate = $components;
            }
        }
        
        return $finalDate;
        
        /**
         * Converte a data recebida por parâmetro
         * para o formato padrão do banco de dados.
         */
    }
    
    public function convertDateToIndex($data)
    {
        $date = array();
        $date = explode('-', $data);
        
        $finalDate = '';
        foreach($date as $components)
        {
            if( $finalDate != '' )
            {
                $finalDate = $components.'/'.$finalDate;
            }
            else
            {
                $finalDate = $components;
            }
        }
        
        return $finalDate;
        
        /**
         * Converte a data recebida por parâmetro
         * para o formato de visualização para o site.
         */
    }
}

?>
