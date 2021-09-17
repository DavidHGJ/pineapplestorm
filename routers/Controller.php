<?php

header('Content-type: application/json');

$request = json_decode(file_get_contents("php://input"));

require_once $rota->getRota();