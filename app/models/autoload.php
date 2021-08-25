<?php

/**
 * Função responsável pelo include automático da classe
 * 
 * @DavidHGJ
 */
function autoload($class) {
    if (file_exists(PATH_APP . "$class.php"))
        require PATH_APP . "$class.php";
}

spl_autoload_register('autoload');