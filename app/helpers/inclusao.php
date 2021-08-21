<?php

namespace app\include;

class inclusao {

    public static function css(Array $listaNomesArquivos) {
        $styles = '';
        foreach ($listaNomesArquivos as $nome)
            $styles .= '<link rel="stylesheet" href="' . URL_CSS . $nome . '.css">';

        echo $styles;
    }
}