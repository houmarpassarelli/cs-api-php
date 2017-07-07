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

    private function Conexao(){
        return parent::getCon();
    }

    private function checkLogin(){

        $Conexao = $this->Conexao();
        $Collection = $Conexao->csdb->usuario;

        if(!is_null($this->Dados)):
            $Resultado = $Collection->find(["usuario" => $this->Dados["usuario"], "senha" => $this->Dados["senha"]])->toArray();
        endif;

        if($Resultado):
            $Retorno = $Resultado;
        else:
            $Retorno = false;
        endif;

        $this->Retorno = json_encode($Retorno);
        //$this->Retorno = $Resultado;
    }
}