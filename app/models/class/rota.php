<?php

namespace models\class;

class Rota {

    public $caminhoPagina;

    private $urlRecuperada;

    public function __construct($urlRecuperada) {
        $this->urlRecuperada = $urlRecuperada;
        $this->criarCaminho();
        $this->validarCaminho();
    }

    private function criarCaminho() {

        if (is_array($this->urlRecuperada)) {

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

    private function validarCaminho() {
        if (!file_exists($this->caminhoPagina)) $this->caminhoPagina = PATH_PAGE . PAGINA_INICIAL . '.php';
    }
}