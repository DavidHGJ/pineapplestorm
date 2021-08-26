<?php 

namespace models\class\util;

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

    public function __construct($host, $dbname, $usuario, $senha){
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
        $driver_options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
         ); 

        $this->conexao = new PDO(
            "mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";port=3306", 
            $this->usuario, 
            $this->senha,
            $driver_options
        );
        $this->conexao-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retorna a conexão realizada com o banco de dados.
     */
    public function getConexao(){
        return $this->conexao;
    }

}

?>