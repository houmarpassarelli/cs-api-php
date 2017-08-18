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
                                            ath.hash AS user_hash,
                                            ac.ativo,
                                            COUNT(p.id_usuario) AS package,
                                            CASE WHEN (SELECT COUNT(id_usuario_access) FROM usuario_sessao WHERE id_usuario_access = {$Exibir->Resultado()[0]['id_usuario_access']}) = 1 THEN 'N' ELSE 'S' END AS initial,
                                            e.logradouro,
                                            e.numero,
                                            e.bairro,
                                            e.cep,
                                            c.titulo AS cidade,
                                            c.sigla AS estado
                                            FROM usuario u
                                            LEFT JOIN usuario_endereco e ON e.id_usuario = u.id_usuario
                                            LEFT JOIN usuario_access ac ON ac.id_usuario = u.id_usuario
                                            LEFT JOIN usuario_sessao s ON s.id_usuario_access = ac.id_usuario_access
                                            LEFT JOIN usuario_aauth ath ON ath.id_usuario_access = s.id_usuario_access
                                            LEFT JOIN cidade c ON c.id_cidade = e.cidade_id
                                            LEFT JOIN pacote_interacao p ON p.id_usuario = u.id_usuario
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
                                                ath.hash AS user_hash,
                                                ac.ativo,
                                                COUNT(p.id_usuario) AS package,
                                                CASE WHEN (SELECT COUNT(id_usuario_access) FROM usuario_sessao WHERE id_usuario_access = {$Exibir->Resultado()[0]['id_usuario_access']}) = 1 THEN 'N' ELSE 'S' END AS initial,
                                                e.logradouro,
                                                e.numero,
                                                e.bairro,
                                                e.cep,
                                                c.titulo AS cidade,
                                                c.sigla AS estado
                                                FROM usuario u
                                                LEFT JOIN usuario_endereco e ON e.id_usuario = u.id_usuario
                                                LEFT JOIN usuario_access ac ON ac.id_usuario = u.id_usuario
                                                LEFT JOIN usuario_sessao s ON s.id_usuario_access = ac.id_usuario_access
                                                LEFT JOIN usuario_aauth ath ON ath.id_usuario_access = s.id_usuario_access
                                                LEFT JOIN cidade c ON c.id_cidade = e.cidade_id
                                                LEFT JOIN pacote_interacao p ON p.id_usuario = u.id_usuario
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

    private function putsession(){

        $Access = new Exibir();
        $Access->exeExibir("SELECT uac.id_usuario_access, uat.hash FROM usuario u
                                    LEFT JOIN usuario_access uac ON uac.id_usuario = u.id_usuario
                                    LEFT JOIN usuario_auth uat ON uat.id_usuario_access = uac.id_usuario_access
                                    WHERE u.codigo = :codigo", NULL, NULL, "codigo={$this->Dados["codigo"]}", FALSE);
        $Dados = [
          "id_usuario_access" => $Access->Resultado()[0]["id_usuario_access"],
          "hash" => sha1(date("dmYHis").$Access->Resultado()[0]["hash"])
        ];

        $Inserir = new Inserir();
        $Inserir->exeInserir("usuario_session", $Dados);

        if($Inserir->errorCode() == '23000' || $Inserir->errorCode() == '42S02' || $Inserir->errorCode() == '42S22'):
            $this->Retorno = json_encode(["codigo" => $Inserir->errorCode()]);
        else:
            $this->Retorno = json_encode(["codigo" => "200", "session_id" => $Dados["hash"]]);
        endif;
    }
}