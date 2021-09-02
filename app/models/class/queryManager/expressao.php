<?php

namespace models\class\queryManager;

use models\class\queryManager\Operador;
use Exception;

class Expressao{
    private $operadorLogico;
    private $termoEsquerda;
    private $operador;
    private $termoDireita;

    public function __construct(){

        switch(func_num_args()){
            case 1:
                if( is_string(func_get_arg(0)) || is_object(func_get_arg(0)))
                    $this-> termoEsquerda = func_get_arg(0);
                else
                    throw new Exception("Quando houver apenas um parâmetro, só será aceito do tipo expressao.");
            break;

            case 2:
                throw new Exception("Não é possível definir uma condição com 2 parâmetros.");
            break;

            case 3:
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
            break;

            case 4:
                $args = func_get_args();
            
                if( in_array( strtoupper($args(0)), array("AND", "OR") ) )
                    $this-> operadorLogico = $args(0);
                else
                    throw new Exception("O primeiro parâmetro recebido deve conter 'AND' ou 'OR'");

                if( is_string($args[1]) || is_object($args[1]) )
                    $this-> termoEsquerda = $args[0];
                else
                    throw new Exception("O primeiro parâmetro não foi reconhecido.");
                
                if( is_string($args[2]) )
                    if( in_array(
                            $args[2], 
                            array(
                                Operador::MAIOR, Operador::MENOR, 
                                Operador::MAIOR_IGUAL, Operador::MENOR_IGUAL, 
                                Operador::IGUAL, Operador::DIFERENTE
                            )
                        ) 
                    )
                    {
                        $this-> operador = $args[2];
                    }
                    else
                        throw new Exception("A condição \"" + $args[1] +"\" não foi reconhecida.");

                if( is_string($args[3]) || is_object($args[3]) )
                    $this-> termoDireita = $args[3];
                else
                    throw new Exception("O terceiro parâmetro não foi reconhecido."); 
            break;

            default:
                throw new Exception("O Construtor só aceita 3 parâmetros.");
        }            
    }

    public function getTermoEsquerda(){
        return $this-> termoEsquerda;
    }

    public function addApelidoTermoEsquerda(string $apelido){
        $this-> termoEsquerda = $apelido + "." + $this-> termoEsquerda;
    }

    public function getOperador(){
        return $this-> operador;
    }

    public function getTermoDireita(){
        return $this-> termoDireita;
    }

    public function addApelidoTermoDireita(string $apelido){
        $this-> termoDireita = $apelido + "." + $this-> termoDireita;
    }
}

?>