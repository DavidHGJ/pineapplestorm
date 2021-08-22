<?php

namespace app\include;

class inclusao {

    public static function css(Array $listaNomesArquivos) {
        $styles = '';
        foreach ($listaNomesArquivos as $nome)
            $styles .= '<link rel="stylesheet" href="' . URL_CSS . $nome . '.css">';

        echo $styles;
    }

    public static function js(Array $listaNomesArquivos) {
        $scripts = '';
        foreach ($listaNomesArquivos as $nome)
            $scripts .= '<script type="text/javascript" src="' . URL_JS . $nome . '.js"></script>';

        echo $scripts;
    }
}