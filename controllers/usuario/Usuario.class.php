<?php

class Usuario extends Conexao
{
    private $Dados;
    private $ID;
    private $Retorno;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function Conexao(){
        return parent::getCon();
    }

    private function getusuario($interno = FALSE){

        $Conexao = $this->Conexao();
        $Collection = $Conexao->csdb->usuario;

        if(!is_null($this->ID)):
            $Resultado = $Collection->findOne(["identify" => $this->ID]);
        else:
            $Resultado  = $Collection->find()->toArray();
        endif;

        $this->Retorno = json_encode($Resultado[0]["dados"]);
        //$this->Retorno = $Resultado[0];

    }

    private function putusuario(){
        if(!is_null($this->Dados)):

            @$Dados = [ "identify" => md5($this->Dados["nome"].date('dmYHis')), "dados" => [$this->Dados]];

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->usuario;

            $this->Retorno = $Collection->insertOne($Dados)->getInsertedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }

    private function updateusuario(){

        if(!is_null($this->Dados)):

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->usuario;

            $this->Retorno = $Collection->updateOne(["identify" => $this->ID],['$push' => ["dados" => $this->Dados]])->getModifiedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
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