<?php

function autoload($class) {
    if (file_exists(PATH_APP . "$class.php"))
        require PATH_APP . "$class.php";
}

spl_autoload_register('autoload');