<?php

namespace models\class\module;

use QueryManager;

class Cadastro {

    public function __construct()
    {
        QueryManager::getInstance();
    }
}