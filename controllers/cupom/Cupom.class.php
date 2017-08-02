<?php

/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 31/05/2017
 * Time: 09:19
 */
class Cupom
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

    static protected function setcupom(array $dados){

        $Inserir = new Inserir();
        $Inserir->exeInserir("oferta_interacao", ["id_pacote" => $dados["codpack"], "id_usuario" => $dados["iduser"], "id_oferta" => $dados["codcupom"], "hash" => $dados["hash"], "altcode" => $dados["altcode"]]);
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

    private function getcupomperuser(){

        $perUser = new Exibir();
        $perUser->exeExibir("SELECT
                                    o.codigo,  
                                    o.titulo,
                                    o.descricao,
                                    o.min_pessoas,
                                    o.max_pessoas,
                                    o.validade,
                                    o.img AS IMG_MAIN,
                                    i.altcode,
                                    i.qrcode
                                    FROM oferta o
                                    INNER JOIN oferta_interacao i ON i.id_oferta = o.id_oferta
                                    WHERE i.id_usuario = (SELECT id_usuario FROM usuario WHERE codigo = :codigo)", NULL, NULL, "codigo={$this->ID}", FALSE);

        $this->Retorno = json_encode($perUser->Resultado());
    }
}