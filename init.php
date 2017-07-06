<?php

require('config.inc.php');
require('abstract.php');

$input = file_get_contents('php://input');
$dados = json_decode($input, true);

$request = (new System())->Request($_SERVER['REQUEST_URI']);
$output = NULL;

if(!empty($request["PATH"][2])):
    switch ((new System())->URI_COMPARE($request["PATH"][2])):
        case "usuario" :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    @$output = (new callUsuario([
                                                "METODO" => (new System())->URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4]
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'PUT'):
                    $output = (new callUsuario([
                                                "METODO" => (new System())->URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4],
                                                "DADOS" => $teste3
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'DELETE'):
                    $output = 'DELETE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $output = (new callUsuario([
                                                "METODO" => (new System())->URI_COMPARE("f757f01ff43e111bbddfabd18d99d03f"),
                                                "DADOS" => $dados
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'GET'):
                    $output = (new callUsuario(["METODO" => (new System())->URI_COMPARE("c494e4539220ba43bb76159d22e70a66")]))->Resultado();
                endif;
            endif;
            break;
        case 'cupom' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    @$output = (new callCupom([
                                                "METODO" => (new System())->URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4]
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'PUT'):
                    $output = (new callCupom([
                                                "METODO" => (new System())->URI_COMPARE($request["PATH"][3]),
                                                "ID" => $request["PATH"][4],
                                                "DADOS" => $teste2
                                            ]))->Resultado();
                elseif($request["METHOD"] == 'DELETE'):
                    $output = 'UPDATE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $output = (new callCupom([
                                            "METODO" => (new System())->URI_COMPARE("e2f189e0949db9308441953db5293a72"),
                                            "DADOS" => $teste
                                        ]))->Resultado();
                else:
                    $output = (new callCupom(["METODO" => (new System())->URI_COMPARE("15bc2f541b0ff3869471b514eb5e4fa9")]))->Resultado();
                endif;
            endif;
            break;
        case 'parceiro' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    $output = 'GET';
                elseif($request["METHOD"] == 'PUT'):
                    $output = 'PUT';
                elseif($request["METHOD"] == 'DELETE'):
                    $output = 'UPDATE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $output = 'POST - EMPTY';
                else:
                    $output = 'GET - EMPTY';
                endif;
            endif;
            break;
        case 'pacote' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    $output = 'GET';
                elseif($request["METHOD"] == 'PUT'):
                    $output = 'PUT';
                elseif($request["METHOD"] == 'DELETE'):
                    $output = 'UPDATE';
                endif;
            else:
                if($request["METHOD"] == 'POST'):
                    $output = 'POST - EMPTY';
                else:
                    $output = 'GET - EMPTY';
                endif;
            endif;
            break;
        case 'pesquisa' :
            if(!empty($request["PATH"][3])):
                if($request["METHOD"] == 'GET'):
                    $output = 'GET';
                endif;
            endif;
            break;
    endswitch;
    file_put_contents('php://output', $output);
endif;
?>