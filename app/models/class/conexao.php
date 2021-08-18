<?php 

class conexao{

    private $conexao;
    private $dbname, 
            $usuario, 
            $senha;

    private function __construct($dbname, $usuario, $senha){
        $this->dbname = $dbname;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->connect();
    }

    private function connect(){
        $this->conexao = new PDO($this->dbname, $this->usuario, $this->password);
    }

    public function __sleep(){
        return array('dbname', 'usuario', 'senha');
    }

    private function __wakeup(){
        $this->connect();
    }

}

?>