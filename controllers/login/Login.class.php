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
        $Exibir->exeExibir(NULL,"usuario", "WHERE email = :email", "email={$this->Dados["login"]}",FALSE);

        if($Exibir->Resultado()):

            $Senha = md5($this->Dados["password"]);
            $Exibir->exeExibir(NULL, "usuario_access","WHERE senha = :senha","senha={$Senha}", FALSE);

            if($Exibir->Resultado()):

                $Profile = new Exibir();
                $Profile->exeExibir("SELECT
                                            u.codigo,
                                            u.nome,
                                            u.sobrenome,
                                            u.avatar,
                                            u.email,
                                            u.visivel,
                                            s.hash AS session_id,
                                            ac.ativo,
                                            COUNT(p.id_usuario) AS package,
                                            CASE WHEN (SELECT id_usuario_access FROM usuario_sessao WHERE id_usuario_access = {$Exibir->Resultado()[0]['id_usuario_access']}) = 1 THEN 'N' ELSE 'S' END AS initial,
                                            e.logradouro,
                                            e.numero,
                                            e.bairro,
                                            e.cep,
                                            c.titulo AS cidade,
                                            c.sigla AS estado
                                            FROM usuario u
                                            LEFT JOIN usuario_endereco e ON e.id_usuario = u.id_usuario
                                            INNER JOIN usuario_access ac ON ac.id_usuario = u.id_usuario
                                            LEFT JOIN usuario_sessao s ON s.id_usuario_access = ac.id_usuario_access                                               
                                            LEFT JOIN cidade c ON c.id_cidade = e.cidade_id
                                            JOIN pacote_interacao p ON p.id_usuario = u.id_usuario
                                            WHERE u.id_usuario = :id", NULL, NULL, "id={$Exibir->Resultado()[0]['id_usuario']}", FALSE);

                $this->Retorno = json_encode(['codigo' => '200', 'profile' => $Profile->Resultado()[0]]);
            else:
                $this->Retorno = json_encode(['codigo' => '0103']);
            endif;
        else:
            $Usuario = md5($this->Dados["login"]);
            $Exibir->exeExibir(NULL, "usuario_access","WHERE login = :login","login={$Usuario}", FALSE);

            if($Exibir->Resultado()):

                $Senha = md5($this->Dados["password"]);
                $Exibir->exeExibir(NULL, "usuario_access","WHERE senha = :senha","senha={$Senha}", FALSE);

                if($Exibir->Resultado()):

                    $Profile = new Exibir();
                    $Profile->exeExibir("SELECT
                                                u.codigo,
                                                u.nome,
                                                u.sobrenome,
                                                u.avatar,
                                                u.email,
                                                u.visivel,
                                                s.hash AS session_id,
                                                ac.ativo,
                                                COUNT(p.id_usuario) AS package,
                                                CASE WHEN (SELECT id_usuario_access FROM usuario_sessao WHERE id_usuario_access = {$Exibir->Resultado()[0]['id_usuario_access']}) = 1 THEN 'N' ELSE 'S' END AS initial,
                                                e.logradouro,
                                                e.numero,
                                                e.bairro,
                                                e.cep,
                                                c.titulo AS cidade,
                                                c.sigla AS estado
                                                FROM usuario u
                                                LEFT JOIN usuario_endereco e ON e.id_usuario = u.id_usuario
                                                INNER JOIN usuario_access ac ON ac.id_usuario = u.id_usuario
                                                LEFT JOIN usuario_sessao s ON s.id_usuario_access = ac.id_usuario_access                                               
                                                LEFT JOIN cidade c ON c.id_cidade = e.cidade_id
                                                JOIN pacote_interacao p ON p.id_usuario = u.id_usuario
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