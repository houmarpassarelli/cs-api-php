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
    private $LIMITE;
    private $OFFSET;
    private $FILES;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->LIMITE = $dados["LIMIT"] ?? NULL;
        $this->OFFSET = $dados["OFFSET"] ?? NULL;
        $this->FILES = $dados["FILES"] ?? NULL;
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
            $Resultado = $Collection->findOne(["_id" => new MongoDB\BSON\ObjectID($this->ID)]);

        else:
            $Resultado  = $Collection->find([])->toArray();
        endif;

        $this->Retorno = json_encode($Resultado);
    }

    private function putparceiro(){

//        if(!is_null($this->Dados)):
//
//            //@$Dados = [ "identify" => md5($this->Dados["nome"].date('dmYHis')), "dados" => [$this->Dados]];
//
//            $Conexao = $this->Conexao();
//            $Collection = $Conexao->csdb->parceiro;
//
//            $this->Retorno = $Collection->insertOne($this->Dados)->getInsertedCount() ?? 0;
//        else:
//            $this->Retorno = 0;
//        endif;

//        $array = [];

//        $array = [$this->Dados, $this->FILES];
        //exit(print_r($this->Dados));
        //exit(print_r($this->FILES));
        //$this->Retorno = json_encode($this->Dados);
        unset($this->Dados[0]["Enviar"]);

        if(!is_null($this->Dados)):
            $Inserir = new Inserir();
            $Inserir->exeInserir("estabelecimento", $this->Dados[0]);

            if($Inserir->Resultado() > 0):
                Imagem::putimagem([0 => ["id_estabelecimento" => $Inserir->Resultado()], $this->Dados[1]]);
            endif;
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