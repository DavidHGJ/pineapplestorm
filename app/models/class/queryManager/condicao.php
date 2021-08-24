<?php

namespace models\class\queryManager;

use models\class\queryManager\Operador;
use Exception;

class Condicao{

    private $termoEsquerda;
    private $operador;
    private $termoDireita;

    public function __construct(){
        if(func_num_args() == 1)
            if( is_string(func_get_arg(0)) )
                $this-> termoEsquerda = func_get_arg(0);
            else if( is_object(func_get_arg(0)) )
                $this-> termoEsquerda = func_get_arg(0);
            else
                throw new Exception("Só é possível definir uma String ou um objeto Condição como parâmetro.");
        else if(func_num_args() == 2)     
            throw new Exception("Não é possível definir uma condição com 2 parâmetros.");
        else if(func_num_args() == 3){
            $args = func_get_args();
            
            if( is_string($args[0]) || is_object($args[0]) )
                $this-> termoEsquerda = $args[0];
            else
                throw new Exception("O primeiro parâmetro não foi reconhecido.");
            
            if( is_string($args[1]) )
                if( in_array(
                        $args[1], 
                        array(
                            Operador::MAIOR, Operador::MENOR, 
                            Operador::MAIOR_IGUAL, Operador::MENOR_IGUAL, 
                            Operador::IGUAL, Operador::DIFERENTE
                        )
                    ) 
                )
                {
                    $this-> operador = $args[1];
                }
                else
                    throw new Exception("A condição \"" + $args[1] +"\" não foi reconhecida.");

            if( is_string($args[2]) || is_object($args[2]) )
                $this-> termoDireita = $args[2];
            else
                throw new Exception("O terceiro parâmetro não foi reconhecido.");
            
        }
    }

}

?>