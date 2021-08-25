<?php

namespace app\helpers;

class Filtro {

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