<?php
class Imagem{

    private $Retorno;
    private $Dados;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function putimagem(){

        exit(var_dump($this->Dados));

        //$this->Retorno = $this->Dados;
    }

}