<?php

class Usuario extends Conexao
{
    private $Dados;
    private $ID;
    private $Retorno;
    private $Codigo;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function getusuario(){

        $Exibir = new Exibir();

        if(!is_null($this->ID)):
            $Exibir->exeExibir("SELECT 
                                            u.nome,
                                            u.sobrenome,
                                            u.avatar,
                                            u.email,
                                            e.logradouro,
                                            e.numero,
                                            e.bairro,
                                            e.cep,
                                            c.titulo AS cidade,
                                            c.sigla AS estado
                                            FROM usuario u
                                            LEFT JOIN usuario_endereco e ON e.id_usuario = u.id_usuario
                                            LEFT JOIN cidade c ON c.id_cidade = e.cidade_id
                                            WHERE u.codigo = :codigo", NULL, NULL,"codigo={$this->ID}", FALSE);


            $this->Retorno = json_encode($Exibir->Resultado());
        else:
            $Exibir->exeExibir("SELECT 
                                            u.nome,
                                            u.sobrenome,
                                            u.avatar,
                                            u.email,
                                            e.logradouro,
                                            e.numero,
                                            e.bairro,
                                            e.cep,
                                            c.titulo AS cidade,
                                            c.sigla AS estado
                                            FROM usuario u
                                            LEFT JOIN usuario_endereco e ON e.id_usuario = u.id_usuario
                                            LEFT JOIN cidade c ON c.id_cidade = e.cidade_id ", NULL, NULL, NULL, FALSE);
            $this->Retorno = json_encode($Exibir->Resultado());
        endif;
    }

    private function putusuario(){

        if(!is_null($this->Dados)):

            unset($this->Dados['repeat']);

            $verificaEmail = System::verificaEmail($this->Dados["email"]);
            $verificaLogin = System::verificaLogin($this->Dados["login"]);

            if($verificaEmail[0] && $verificaLogin[0]):

                $DadosUsuario = [
                    "nome" => $this->Dados["nome"],
                    "sobrenome" => $this->Dados["sobrenome"],
                    "email" => $this->Dados["email"],
                    "codigo" => System::longRandnDateCode()
                ];

                $Inserir = new Inserir();
                $Inserir->exeInserir("usuario", $DadosUsuario);

                $DadosAcesso = [
                    "id_usuario" => $Inserir->Resultado(),
                    "login" => md5($this->Dados["login"]),
                    "senha" => md5($this->Dados["senha"])
                ];

                $Inserir->exeInserir("usuario_access", $DadosAcesso);

                $DadosAuth = [
                    "id_usuario_access" => $Inserir->Resultado(),
                    "token" => md5($this->Dados["email"].date("dmY"))
                ];

                $Inserir->exeInserir("usuario_auth", $DadosAuth);

                $this->Retorno = json_encode(["codigo" => "200"]);
            else:
                if(!$verificaEmail[0]):
                    $this->Retorno = $verificaEmail[1];
                elseif(!$verificaLogin[0]):
                    $this->Retorno = $verificaLogin[1];
                else:
                    $this->Retorno = json_encode(["codigo" => "100" ]);
                endif;
            endif;
        else:
            $this->Retorno = json_encode(["codigo"=> "300"]);
        endif;
    }

    private function updateusuario(){


    }

    private function deleteusuario(){
        if(!is_null($this->Dados)):

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->usuario;

            $this->Retorno = $Collection->deleteOne(["identify" => $this->ID])->getDeletedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }
}