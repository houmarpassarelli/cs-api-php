<?php

class Login extends Conexao
{
    private $Dados;
    private $Retorno;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function checkLogin(){

        $Exibir = new Exibir();
        $Exibir->exeExibir(NULL,"usuario", "WHERE email = :email", "email={$this->Dados["usuario"]}",FALSE);

        if($Exibir->Resultado()):

            $Senha = md5($this->Dados["senha"]);
            $Exibir->exeExibir(NULL, "usuario_access","WHERE senha = :senha","senha={$Senha}", FALSE);

            if($Exibir->Resultado()):

                $Profile = new Exibir();
                $Profile->exeExibir("SELECT
                                                u.codigo,
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
                                                WHERE u.id_usuario = :id", NULL, NULL, "id={$Exibir->Resultado()[0]['id_usuario']}", FALSE);

                $this->Retorno = json_encode(['codigo' => '200', 'profile' => $Profile->Resultado()[0]]);
            else:
                $this->Retorno = json_encode(['codigo' => '0103']);
            endif;
        else:
            $Usuario = md5($this->Dados["usuario"]);
            $Exibir->exeExibir(NULL, "usuario_access","WHERE login = :login","login={$Usuario}", FALSE);

            if($Exibir->Resultado()):

                $Senha = md5($this->Dados["senha"]);
                $Exibir->exeExibir(NULL, "usuario_access","WHERE senha = :senha","senha={$Senha}", FALSE);

                if($Exibir->Resultado()):

                    $Profile = new Exibir();
                    $Profile->exeExibir("SELECT
                                                u.codigo,
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
                                                WHERE u.id_usuario = :id", NULL, NULL, "id={$Exibir->Resultado()[0]['id_usuario']}", FALSE);

                    $this->Retorno = json_encode(['codigo' => '200', 'profile' => $Profile->Resultado()[0]]);
                else:
                    $this->Retorno = json_encode(['codigo' => '0103']);
                endif;
            else:
                $this->Retorno = json_encode(['codigo' => '0102']);
            endif;
        endif;
    }
}