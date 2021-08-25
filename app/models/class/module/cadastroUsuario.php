<?php

namespace models\class\module;

use DateTime;
use QueryManager;

/**
 * Classe responsável pelo cadastro de usuários
 * 
 * @DavidHGJ
 */
class CadastroUsuario {

    private $nomeCompleto;
    private $nomeUsuario;
    private $dataNascimento;
    private $senha;
    private $confirmacaoSenha;

    public function __construct(
        String $nomeCompleto,
        String $nomeUsuario,
        String $senha,
        String $confirmacaoSenha,
        DateTime $dataNascimento
    ) {
        $queryManager = QueryManager::getInstance();
        $queryManager->getConexao();

        $this->nomeCompleto = $nomeCompleto;
        $this->nomeUsuario = $nomeUsuario;
        $this->senha = $senha;
        $this->confirmacaoSenha = $confirmacaoSenha;
        $this->dataNascimento = $dataNascimento;
    }
}