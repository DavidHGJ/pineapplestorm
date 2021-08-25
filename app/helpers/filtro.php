<?php

namespace app\helpers;

/**
 * Classe responsável pelos filtros de validação
 * 
 * @DavidHGJ
 */
class Filtro {

    /**
     * Responsável pela validação de requests recebidos
     * 
     * @param Mixed $nomeRequest
     *      Nome do request desejado
     */
    public static function request($nomeRequest) {

        $request = $_REQUEST[$nomeRequest];

        if (is_array($request)) {
            foreach ($request as $dado) $requestTratado[] = trim(str_replace(['\\', '\'', '"', ',' , ';', '<', '>'], '', strval($dado)));
            return $requestTratado;
        }
        else
            return trim(str_replace(['\\', '\'', '"', ',' , ';', '<', '>'], '', strval($request)));
    }
}