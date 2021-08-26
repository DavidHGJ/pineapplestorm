<?php

namespace models\class\queryManager;

use Exception;

class Tabela{

    private $nome = null;
    private $coluna = null;

    public function __construct(String $nome, String ... $coluna){
        $this-> nome = $nome;
        $this-> coluna = $coluna;
    }

    public function getNome(){
        return $this-> nome;
    }

    public function getColuna(){
        if(func_num_args() == 1)
            if( is_string(func_get_arg(0)) )
                if( is_array($this-> coluna) )
                    if( in_array(func_get_arg(0), $this-> coluna) )
                        return func_get_arg(0);
                    else
                        throw new Exception("Coluna buscada não foi encontrada.");
                else
                    return func_get_arg(0);
            else
                throw new Exception("Este método aceita apenas string como parâmetro.");
        else if(func_num_args() > 1)
            throw new Exception("Só é possível buscar uma coluna por vez");
        else
            return $this-> coluna;
    }

}

?>