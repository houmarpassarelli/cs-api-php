<?php

/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 31/05/2017
 * Time: 09:04
 */
class Parceiro extends Conexao
{
    private $Retorno;
    private $Dados;
    private $ID;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function Conexao(){
        return parent::getCon();
    }

    private function getparceiro(){

        $Conexao = $this->Conexao();
        $Collection = $Conexao->csdb->parceiro;

        if(!is_null($this->ID)):
            $Resultado = $Collection->findOne(["identify" => $this->ID]);

        else:
            $Resultado  = $Collection->find([])->toArray();
        endif;

        $this->Retorno = json_encode($Resultado);
    }

    private function putparceiro(){

        if(!is_null($this->Dados)):

            @$Dados = [ "identify" => md5($this->Dados["nome"].date('dmYHis')), "dados" => [$this->Dados]];

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->parceiro;

            $this->Retorno = $Collection->insertOne($Dados)->getInsertedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }

    private function updateparceiro(){

        if(!is_null($this->Dados)):

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->parceiro;

            $this->Retorno = $Collection->updateOne(["identify" => $this->ID],['$push' => ["dados" => $this->Dados]])->getModifiedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }

    private function deleteparceiro(){
        if(!is_null($this->Dados)):

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->parceiro;

            $this->Retorno = $Collection->deleteOne(["identify" => $this->ID])->getDeletedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }
}