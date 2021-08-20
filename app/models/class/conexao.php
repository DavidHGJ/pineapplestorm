<?php 

namespace models\class;

use PDO;

/**
 * Representa a configuração que acessa o banco de dados.
 * 
 * @androide23
 */
class Conexao{

    /** Sessão de conexão com o banco de dados */
    private $conexao;
    /** Informações para conexão com o banco de dados */
    private $host,
            $dbname, 
            $usuario, 
            $senha;

    private function __construct($host, $dbname, $usuario, $senha){
        $this->host = $host;
        $this->dbname = $dbname;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->connect();
    }

    public function __sleep(){
        return array('dbname', 'usuario', 'senha');
    }

    private function __wakeup(){
        $this->connect();
    }

    /**
     * Realiza a conexão com o banco de dados.
     */
    private function connect(){
        $this->conexao = new PDO(
            "mysql:host = " + $this->host + ";dbname = " + $this->dbname, 
            $this->usuario, 
            $this->senha
        );
        ($this->conexao)-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retorna a conexão realizada com o banco de dados.
     */
    public function getConexao(){
        return $this->conexao;
    }

}

?>