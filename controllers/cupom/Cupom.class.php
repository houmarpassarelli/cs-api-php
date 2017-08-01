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
    private $Codigo;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function getcupom(){

        if(!is_null($this->ID)):



        else:

        endif;

    }

    private function putcupom(){

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

    private function getcupomperpack(){

        $perPack = new Exibir();
        $perPack->exeExibir("SELECT
                                    o.codigo AS id_cupom,
                                    o.titulo AS titulo_cupom,
                                    o.img AS img_cupom,
                                    e.titulo AS titulo_parceiro,
                                    e.logo AS img_parceiro
                                    FROM oferta o
                                    LEFT JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                    WHERE id_pacote = :id", NULL, NULL, "id={$this->ID}", FALSE);

        $this->Retorno = json_encode($perPack->Resultado());
    }

    private function codeGenerate(){
        $this->Codigo = hexdec(date("dmY").rand(1,999));
    }
}