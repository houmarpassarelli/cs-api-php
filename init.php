<?php

require('config.inc.php');
require('abstract.php');

var_dump(System::Request($_SERVER['REQUEST_URI']));
echo '<br />';
echo sha1('hackers2');
echo '<br />';
echo sha1('senha');
echo '<br />';

$teste["INFO"] =[
    "nome" => "Houmar",
    "sobrenome" => "Passarelli",
    "email" => "houmarpassarelli@gmail.com",
    "email2" => "houmar@agendaassessoria.com.br"
];

print_r($teste);

$teste2["ENDERECO"] = [
    "logradouro" => "Rua Itapuã",
    "numero" => "101",
    "complemento" => "Apartamento",
    "bairro" => "Jardim Aeroporto",
    "cidade" => "Várzea Grande",
    "estado" => "MT"
];

echo '<br />';

$request = System::Request($_SERVER['REQUEST_URI']);
$dados = NULL;

if(!empty($request["PATH"][2])):
    switch (System::URI_COMPARE($request["PATH"][2])):
        case 'usuario' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    @$dados = (new callUsuario([
                                                "METODO" => System::URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4]
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'PUT'):
                    $dados = (new callUsuario([
                                                "METODO" => System::URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4],
                                                "DADOS" => $teste2
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'DELETE'):
                    $dados = 'DELETE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $dados = (new callUsuario([
                                                "METODO" => System::URI_COMPARE("f757f01ff43e111bbddfabd18d99d03f"),
                                                "DADOS" => $teste
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'GET'):
                    $dados = (new callUsuario(["METODO" => System::URI_COMPARE("c494e4539220ba43bb76159d22e70a66")]))->Resultado();
                endif;
            endif;
            break;
        case 'cupom' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    @$dados = (new callCupom([
                                                "METODO" => System::URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4]
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'PUT'):
                    $dados = (new callCupom([
                                                "METODO" => System::URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4],
                                                "DADOS" => $teste2
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'DELETE'):
                    $dados = 'UPDATE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $dados = (new callCupom([
                                            "METODO" => System::URI_COMPARE("e2f189e0949db9308441953db5293a72"),
                                            "DADOS" => $teste
                                        ]))->Resultado();
                else:
                    $dados = (new callCupom(["METODO" => System::URI_COMPARE("15bc2f541b0ff3869471b514eb5e4fa9")]))->Resultado();
                endif;
            endif;
            break;
        case 'parceiro' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    $dados = 'GET';
                elseif($request["METHOD"] == 'PUT'):
                    $dados = 'PUT';
                elseif($request["METHOD"] == 'DELETE'):
                    $dados = 'UPDATE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $dados = 'POST - EMPTY';
                else:
                    $dados = 'GET - EMPTY';
                endif;
            endif;
            break;
        case 'pacote' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    $dados = 'GET';
                elseif($request["METHOD"] == 'PUT'):
                    $dados = 'PUT';
                elseif($request["METHOD"] == 'DELETE'):
                    $dados = 'UPDATE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $dados = 'POST - EMPTY';
                else:
                    $dados = 'GET - EMPTY';
                endif;
            endif;
            break;
        case 'pesquisa' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    $dados = 'GET';
                endif;
            endif;
            break;
    endswitch;
    //file_put_contents('php://output', $dados);
    echo '<pre>';
    //echo $dados;
    var_dump($dados);
    echo '</pre>';
endif;
