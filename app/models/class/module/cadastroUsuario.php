<?php

namespace models\class\module;

use DateTime;
use models\class\queryManager\QueryManager;

/**
 * Classe responsável pelo cadastro de usuários
 * 
 * @DavidHGJ
 */
class CadastroUsuario {

    private $nomeCompleto;
    private $nomeUsuario;
    private $email;
    private $dataNascimento;
    private $senha;
    private $confirmacaoSenha;

    public function __construct(
        String $nomeCompleto,
        String $nomeUsuario,
        String $email,
        String $senha,
        String $confirmacaoSenha,
        DateTime $dataNascimento
    ) {
        $queryManager = QueryManager::getInstance();
        $queryManager->getConexao();

        $this->nomeCompleto = $nomeCompleto;
        $this->nomeUsuario = $nomeUsuario;
        $this->email = $email;
        $this->senha = $senha;
        $this->confirmacaoSenha = $confirmacaoSenha;
        $this->dataNascimento = $dataNascimento;
    }
}

########

$dados

ob_start();

require

<a href="$dados->token"></a>

$mensagem = ob_get_clean();

enviarEmail(xxxx, $mensagem);