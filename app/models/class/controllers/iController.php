<?php

namespace models\class\controllers;

/**
 *## Interface para os controladores. 
 */
interface iController {
    public function get($identificacao);
    public function post();
    public function put();
    public function delete();
}