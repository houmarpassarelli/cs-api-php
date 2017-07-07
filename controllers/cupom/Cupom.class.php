<?php

/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 31/05/2017
 * Time: 09:19
 */
class Cupom extends Conexao
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

    private function getcupom(){

        $Conexao = $this->Conexao();
        $Collection = $Conexao->csdb->cupom;

        if(!is_null($this->ID)):
            $Resultado = $Collection->findOne(["_id" => new MongoDB\BSON\ObjectID($this->ID)]);

        else:
            $Resultado  = $Collection->find([])->toArray();
        endif;

        $this->Retorno = json_encode($Resultado);
    }

    private function putcupom(){

        if(!is_null($this->Dados)):

            //@$Dados = [ "identify" => md5($this->Dados["nome"].date('dmYHis')), "dados" => [$this->Dados]];

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->cupom;

            $this->Retorno = $Collection->insertOne($this->Dados)->getInsertedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }

    private function updatecupom(){

        if(!is_null($this->Dados)):

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->cupom;

            $this->Retorno = $Collection->updateOne(["_id" => new MongoDB\BSON\ObjectID($this->ID)],['$push' => $this->Dados])->getModifiedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }

    private function deletecupom(){
        if(!is_null($this->Dados)):

            $Conexao = $this->Conexao();
            $Collection = $Conexao->csdb->cupom;

            $this->Retorno = $Collection->deleteOne(["identify" => $this->ID])->getDeletedCount() ?? 0;
        else:
            $this->Retorno = 0;
        endif;
    }
}