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
                                    o.titulo AS titulo_cupom,
                                    o.descricao AS descricao_cupom,
                                    o.min_pessoas,
                                    o.max_pessoas,
                                    o.validade,
                                    o.img AS img_cupom,
                                    i.altcode,
                                    i.qrcode,
                                    e.titulo AS titulo_parceiro,
                                    e.logo AS img_parceiro,
                                    e.descritivo AS descricao_parceiro
                                    FROM oferta o
                                    INNER JOIN oferta_interacao i ON i.id_oferta = o.id_oferta
                                    JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                    WHERE i.id_usuario = (SELECT id_usuario FROM usuario WHERE codigo = :codigo)", NULL, NULL, "codigo={$this->ID}", FALSE);

        $this->Retorno = json_encode($perUser->Resultado());
    }

    private function putcupommercado(){

        $Dados = new Exibir();
        $Dados->exeExibir("SELECT o.id_oferta, u.id_usuario FROM oferta o
                                    JOIN usuario u ON u.codigo = :usuario
                                    WHERE o.codigo = :oferta", NULL, NULL, "usuario={$this->Dados['usercode']}&oferta={$this->Dados['cupomcode']}", FALSE);

        if($Dados->Resultado()):

            $Inserir = new Inserir();
            $Inserir->exeInserir("oferta_mercado", $Dados->Resultado()[0]);

            if($Inserir->errorCode() == '23000' || $Inserir->errorCode() == '42S02' || $Inserir->errorCode() == '42S22'):
                $this->Retorno = json_encode(["codigo" => $Inserir->errorCode()]);
            else:
                $this->Retorno = json_encode(["codigo" => "200"]);
            endif;
        endif;
    }
}