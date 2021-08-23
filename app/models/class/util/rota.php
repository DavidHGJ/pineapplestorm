<?php

namespace models\class;

/**
 * Classe que define a rota das url's
 * 
 * @DavidHGJ
 */
class Rota {
    public $caminhoPagina;
    private $urlRecuperada;

    public function __construct($urlRecuperada) {
        $this->urlRecuperada = $urlRecuperada;
        $this->criarCaminho();
        $this->validarCaminho();
    }

    /**
     * Cria caminho da url.
     */
    private function criarCaminho() {
        if (sizeof($this->urlRecuperada) > 1) {
            $this->caminhoPagina = PATH_PAGE;

            foreach ($this->urlRecuperada as $index => $valor) {
                if (array_key_last($this->urlRecuperada) == $index)
                    $this->caminhoPagina .= "$valor.php";
                else
                    $this->caminhoPagina .= "$valor\\";
            }
        }
        else
            $this->caminhoPagina = PATH_PAGE . end($this->urlRecuperada) . '.php';
    }

    /**
     * Valida  o caminho da url. 
     */
    private function validarCaminho() {
        if (!file_exists($this->caminhoPagina)) {
            header('Location: ' . URL . PAGINA_INICIAL);
            exit;
        }
    }

    /**
     * Redireciona para o arquivo
     */
    public static function redirecionar($url_destino) {
        header('Location: ' . $url_destino);
    }
}