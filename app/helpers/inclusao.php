<?php

namespace app\helpers;

/**
 * Classe responsavel pela realização de inclusões de arquivos na página
 * 
 * @DavidHGJ
 */
class Inclusao {

    /**
     * Responsável por inserir arquivos CSS
     * 
     * @param Array $listaNomesArquivos
     *      Array com os nomes dos arquivos CSS desejados sem a extensão
     */
    public static function css(Array $listaNomesArquivos) {
        $styles = '';
        foreach ($listaNomesArquivos as $nome)
            $styles .= '<link rel="stylesheet" href="' . URL_CSS . $nome . '.css">';

        echo $styles;
    }

    /**
     * Responsável por inserir arquivos JS
     * 
     * @param Array $listaNomesArquivos
     *      Array com os nomes dos arquivos JS desejados sem a extensão
     */
    public static function js(Array $listaNomesArquivos) {
        $scripts = '';
        foreach ($listaNomesArquivos as $nome)
            $scripts .= '<script type="text/javascript" src="' . URL_JS . $nome . '.js"></script>';

        echo $scripts;
    }
}