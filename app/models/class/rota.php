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
<<<<<<< HEAD
        if (sizeof($this->urlRecuperada) > 1) {
=======

        if (sizeof($this->urlRecuperada) > 1) {

>>>>>>> 9da5795a840c062e8146d5576d5eb13d7f11c811
            $this->caminhoPagina = PATH_PAGE;

            foreach ($this->urlRecuperada as $index => $valor) {
                if (array_key_last($this->urlRecuperada) == $index)
                    $this->caminhoPagina .= "$valor.php";
                else
                    $this->caminhoPagina .= "$valor\\";
            }
        }
        else
            $this->caminhoPagina = PATH_PAGE . $this->urlRecuperada . '.php';
    }

    /**
     * Valida  o caminho da url.
     */
    private function validarCaminho() {
        if (!file_exists($this->caminhoPagina)) $this->caminhoPagina = PATH_PAGE . PAGINA_INICIAL . '.php';
    }
}