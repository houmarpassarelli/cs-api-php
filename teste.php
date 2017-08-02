<?php

require ('config.inc.php');


$Exibir = new Exibir();
$Exibir->exeExibir("SELECT u.id_usuario, u.nome, u.sobrenome, u.codigo FROM usuario u
                            LEFT JOIN cupom_interacao c ON
                            WHERE codigo = '220071846355'", NULL, NULL, NULL, FALSE);

//$sobrenome = ;



//$implode = implode("");

$Valor = NULL;

foreach (explode(" ", $Exibir->Resultado()[0]["sobrenome"]) as $Value):
        if($Value <> "de"):
            $Valor .= substr($Value,0,1);
        endif;
endforeach;

//echo $Valor;

echo strtoupper(substr($Exibir->Resultado()[0]["nome"], 0, 1).$Valor.substr($Exibir->Resultado()[0]["codigo"],0,3));

//print_r($Exibir->Resultado());

//for($i=0;$i<count($Exibir->Resultado());$i++):
//    echo $Exibir->Resultado()[$i]["id_oferta"];
//endfor;

