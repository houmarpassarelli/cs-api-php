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
                'controllers/cupom',
                'controllers/pacote',
                'controllers/contato'
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

function PHPErro($Codigo, $Mensagem, $Arquivo, $Linha){
    $eClasse = ($Codigo == E_USER_NOTICE ? INFO : ($Codigo == E_USER_WARNING ? ALERT : ($Codigo == E_USER_ERROR ? ERROR : $Codigo)));
    if(!strstr($Mensagem, 'in_array')):
        echo "<div class=\"aviso {$eClasse}\">";
        echo "<span>Erro na linha: #{$Linha} :: {$Mensagem}</span>";
        echo "</span>Arquivo:{$Arquivo}</span>";
        echo "</div>";
    endif;
    if($eClasse == E_USER_ERROR):
        die;
    endif;
}

