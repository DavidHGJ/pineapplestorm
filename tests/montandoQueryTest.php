<?php

use models\class\queryManager\QueryManager;
use models\class\queryManager\TableManager;

require '../app/models/autoload.php';
require '../vendor/autoload.php';

$tabelas = TableManager::getInstance();
$manager = QueryManager::getInstance()->setTabela($tabelas->getTabela("USUARIO"));