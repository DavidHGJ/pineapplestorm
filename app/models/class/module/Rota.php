<?php

namespace models\class\module;

use Exception;

/**
 *## Representa a classe responsável pelas rotas
 *
 * @DavidHGJ
 */
class Rota {
    
    private $url;
    private $rotasPermitidas;
    private $rota;

    /**
     *## Construtor
     */
    public function __construct(Array $url) {

        $this->url = $url;
        $this->definirRotasPermitidas();
        $this->validarRota();
        $this->definirRota();
    }

    /**
     *## Método responsável pela definição das rotas permitidas 
     */
    private function definirRotasPermitidas() : void {
        $this->rotasPermitidas = scandir(PATH_ROOT . 'routers\\api');
    }

    /**
     *## Método valida a url recebida 
     */
    private function validarRota() : void {
        try {
            if (!in_array($this->url[0] . '.php', $this->rotasPermitidas))
                throw new Exception('Acesso negado, URL inserida invalida.', '2');
        }
        catch (Exception $erro) {
            header('Content-type: application/json');
            echo json_encode(['error' => true, 'message' => $erro->getMessage(), 'code' => $erro->getCode()]);
            exit;     
        }
    }

    /**
     *## Método responsável por definir a rota do sistema. 
     */
    private function definirRota() : void {
        $this->rota = PATH_ROOT . 'routers\\api\\' . $this->url[0] . '.php';
    }

    /**
     *## Recupera a rota
     *
     * @return String
     */ 
    public function getRota() : String {
        return $this->rota;
    }
}
