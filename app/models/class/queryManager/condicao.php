<?php

namespace models\class\queryManager;

use models\class\queryManager\Operador;
use Exception;
use SplObjectStorage;
use WeakMap;

class Condicao{

    private SplObjectStorage $expressao;
    private $exp;

    public function __construct(){
        $this-> expressao = new SplObjectStorage();
        
        $args = func_get_args();

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
                $exp = new Expressao($args[0], $args[1], $args[2]);      
                ($this-> expressao)-> offsetSet($exp, strval(count($this-> expressao) + 1));
            break;

            default:
                throw new Exception("O Construtor aceita apenas 1 ou 3 parâmetros.");
        }            
    }
    
    public function addExpressao(){
        $args = func_get_args();

        switch(count($args)){
            case 1:
                if( is_object($args[0]) )
                    ($this-> expressao)-> offsetSet(new Expressao($args[0]), strval(count($this-> expressao) + 1));
            break;

            case 3:
                ($this-> expressao)-> offsetSet(new Expressao($args[0], $args[1], $args[2]), strval(count($this-> expressao) + 1));
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

    public function getExpressaoCompleta(){
        $aux = "";
        
        foreach($this-> expressao as $chave => $valor){
            if(!is_null($valor ->getOperadorLogico()))
                $aux .= is_null($valor-> getOperadorLogico()) ? "" : $valor-> getOperadorLogico() . " " . 
                        $valor-> getTermoEsquerda()  . " " .
                        $valor-> getOperador()       . " " .
                        (is_null($valor-> getTermoDireita()) ? "" : $valor-> getTermoDireita()) . " ";
            else
                $aux .= $valor-> getTermoEsquerda()  . " " .
                        $valor-> getOperador()       . " " .
                        (is_null($valor-> getTermoDireita()) ? "" : $valor-> getTermoDireita()) . " ";

        }

        return $aux;
    }

}

?>