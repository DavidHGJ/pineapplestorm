<?php

namespace models\class\queryManager;

use models\class\queryManager\Action;
use Exception;

class Query{

    private $action = null;

    public function __construct(){}

    public function setAction(String $action){
        if( in_array($action, array(Action::SELECT, Action::INSERT, Action::UPDATE)) )
            $this-> action = $action;
        else if(!is_null($action))
            throw new Exception("A ação \"" + $this-> action + "\" já foi definida para esta query.");
        else
            throw new Exception("A ação \"" + $action + "\" não é suportada.");
    }

}

?>