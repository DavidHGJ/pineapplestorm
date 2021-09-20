<?php

/**
 *## Interface para os controladores. 
 */
interface iController {
    public function get();
    public function post();
    public function put();
    public function delete();
}