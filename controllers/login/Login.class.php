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
                $this->Retorno = '200';
            else:
                $this->Retorno = '0103';
            endif;
        else:
            $Usuario = md5($this->Dados["usuario"]);
            $Exibir->exeExibir(NULL, "usuario_access","WHERE login = :login","login={$Usuario}", FALSE);

            if($Exibir->Resultado()):

                $Senha = md5($this->Dados["senha"]);
                $Exibir->exeExibir(NULL, "usuario_access","WHERE senha = :senha","senha={$Senha}", FALSE);

                if($Exibir->Resultado()):
                    $this->Retorno = '200';
                else:
                    $this->Retorno = '0103';
                endif;
            else:
                $this->Retorno = '0102';
            endif;
        endif;
    }
}