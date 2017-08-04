<?php

require ('config.inc.php');


//$Exibir = new Exibir();
//$Exibir->exeExibir("SELECT u.id_usuario, u.nome, u.sobrenome, u.codigo FROM usuario u
//                            LEFT JOIN cupom_interacao c ON
//                            WHERE codigo = '220071846355'", NULL, NULL, NULL, FALSE);

//$sobrenome = ;



//$implode = implode("");

//$Valor = NULL;
//
//foreach (explode(" ", $Exibir->Resultado()[0]["sobrenome"]) as $Value):
//        if($Value <> "de"):
//            $Valor .= substr($Value,0,1);
//        endif;
//endforeach;

//echo $Valor;

//echo strtoupper(substr($Exibir->Resultado()[0]["nome"], 0, 1).$Valor.substr($Exibir->Resultado()[0]["codigo"],0,3));

//print_r($Exibir->Resultado());

//for($i=0;$i<count($Exibir->Resultado());$i++):
//    echo $Exibir->Resultado()[$i]["id_oferta"];
//endfor;


//$Dados = ["id_oferta" => 1, "id_estabelecimento" => "'(select id_usuario from usuario where codigo = '240597002571')'"];
//
//$Inserir = new Inserir();
//$Inserir->exeInserir("tag_interacao", $Dados);
//
//
//if($Inserir->errorCode()):
//    echo 'erro: '.$Inserir->errorCode();
//else:
//    echo 'certo: '.$Inserir->Resultado();
//endif;

?>

<form method="post" action="http://10.0.3.32:8080/cs_api/bf19122987928493131d5bf846637fbc" enctype="multipart/form-data">
    <input type="file" name="arquivo" />
    <input type="submit" name="Enviar" />
</form>

