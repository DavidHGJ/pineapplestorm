<?php

namespace models\class\controllers;

/**
 *## Interface para os controladores. 
 */
interface iController {
    public function get($identificacao);
    public function post($request);
    public function put($request, $identificacao);
    public function delete($identificacao);
}