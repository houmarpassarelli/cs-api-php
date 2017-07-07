<?php
set_time_limit(0);

require_once ('vendor/autoload.php');

//GLOBAIS PARA ACESSO AO BANCO
define('USER','root');
define('PWD','');
define('HOST','127.0.0.1');
define('DB','cupomstore');


//FUNÇÃO PARA CARREGAR CLASSES
function default_classes($Class)
{
    $cDir = [
                'models',
                'controllers/system',
                'controllers/usuario',
                'controllers/parceiro',
                'controllers/login',
                'controllers/cupom'
            ];
    $iDir = NULL;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php')
            && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php')):

            include_once(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php');
            $iDir = TRUE;
        endif;
    endforeach;
}

spl_autoload_register('default_classes');

