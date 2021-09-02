<?php

namespace models\class\queryManager;

use models\class\queryManager\Operador;
use Exception;
use WeakMap;

class Condicao{

    private $expressao;

    public function __construct(){
        $this-> expressao = new WeakMap();

        switch(func_num_args()){
            case 1:
                if( is_object(func_get_arg(0)) )
                    ($this-> expressao)-> offsetSet(func_get_arg(0), strval(count($this-> expressao) + 1));
                else
                    throw new Exception("Só é possível definir um objeto do tipo Condição como parâmetro.");
            break;

            case 2:
                throw new Exception("Não é possível definir uma condição com 2 parâmetros.");
            break;

            case 3:
                $args = func_get_args();
            
                ($this-> expressao)-> offsetSet(new Expressao($args[0], $args[1], $args[2]), strval(count($this-> expressao) + 1));
            break;

            default:
                throw new Exception("O Construtor aceita apenas 1 ou 3 parâmetros.");
        }            
    }
    
    public function addExpressao(){
        $args = func_get_args();

        switch(func_num_args()){
            case 1:
                if( is_object($args[0]) )
                    ($this-> expressao)-> offsetSet(new Expressao($args[0]), strval(count($this-> expressao) + 1));
            break;

            case 4:
                ($this-> expressao)-> offsetSet(new Expressao($args[0], $args[1], $args[2], $args[3]), strval(count($this-> expressao) + 1));
            break;

            default:
                throw new Exception("
                    Quantidade de parâmetros inválida.\n Deve ser utilizado apenas um do tipo expressao ou 4 strings
                    sendo a primeira o operador lógico.
                ");
        }
    }

    /*private $termoEsquerda;
    private $operador;
    private $termoDireita;

    public function __construct(){

        switch(func_num_args()){
            case 1:
                if( is_string(func_get_arg(0)) || is_object(func_get_arg(0)))
                    $this-> termoEsquerda = func_get_arg(0);
                else
                    throw new Exception("Só é possível definir uma String ou um objeto Condição como parâmetro.");
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
    }*/

}

?>