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
    private $LIMITE;
    private $OFFSET;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->LIMITE = $dados["LIMIT"] ?? NULL;
        $this->OFFSET = $dados["OFFSET"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    static protected function setcupomuser(array $dados){

        $Inserir = new Inserir();
        $Inserir->exeInserir("oferta_interacao", ["id_pacote" => $dados["codpack"], "id_usuario" => $dados["iduser"], "id_oferta" => $dados["codcupom"], "hash" => $dados["hash"], "altcode" => $dados["altcode"], "qrcode" => $dados["qrcode"]]);
    }

    private function getcupom(){

        if(!is_null($this->ID)):



        else:

        endif;

    }

    private function putcupom(){

        $this->Dados["codigo"] = System::longRandnDateCode();
        $this->Dados["dias_uso"] = serialize($this->Dados["dias_uso"]);

        $Inserir = new Inserir();
        $Inserir->exeInserir("oferta", $this->Dados);
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

        $Condicoes = '';
        $Parse = '';

        if(!empty($this->LIMITE)):
            $Condicoes .= "LIMIT :limit ";
            $Parse .= "&limit={$this->LIMITE}";
        endif;

        if(!empty($this->OFFSET)):
            $Condicoes .= "OFFSET :offset ";
            $Parse .= "&offset={$this->OFFSET}";
        endif;

        $perPack = new Exibir();
        $perPack->exeExibir("SELECT
                                    o.id_oferta,
                                    o.codigo AS id_cupom,
                                    o.titulo AS titulo_cupom,
                                    o.img AS img_cupom,
                                    e.titulo AS titulo_parceiro
                                    e.logo AS img_parceiro
                                    FROM oferta o
                                    LEFT JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                    WHERE id_pacote = :id {$Condicoes}", NULL, NULL, "id={$this->ID}{$Parse}", FALSE);

        $this->Retorno = json_encode($perPack->Resultado());
    }

    private function getcupomperuser(){

        $Condicoes = '';
        $Parse = '';

        if(!empty($this->LIMITE)):
            $Condicoes .= "LIMIT :limit ";
            $Parse .= "&limit={$this->LIMITE}";
        endif;

        if(!empty($this->OFFSET)):
            $Condicoes .= "OFFSET :offset ";
            $Parse .= "&offset={$this->OFFSET}";
        endif;

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
                                    e.descricao AS descricao_parceiro,
                                    CASE WHEN m.id_oferta IS NOT NULL THEN 'S' ELSE 'N' END AS mercado,
                                    ROUND(AVG(r.rating)) AS rating,
                                    CASE WHEN (SELECT COUNT(1) FROM usuario_comentario WHERE id_oferta=o.id_oferta) = 0 
                                    THEN NULL 
                                    ELSE (SELECT COUNT(1) FROM usuario_comentario WHERE id_oferta=o.id_oferta) 
                                    END AS qtd_comentario
                                    FROM oferta o
                                    INNER JOIN oferta_interacao i ON i.id_oferta = o.id_oferta
                                    JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                    LEFT JOIN oferta_mercado m ON m.id_oferta = o.id_oferta
                                    LEFT JOIN oferta_rating r ON r.id_oferta = o.id_oferta
                                    WHERE i.id_usuario = (SELECT id_usuario FROM usuario WHERE codigo = :codigo) GROUP BY o.id_oferta {$Condicoes}", NULL, NULL, "codigo={$this->ID}{$Parse}", FALSE);

        $this->Retorno = json_encode($perUser->Resultado());
    }

    private function getcupomonmarket(){

        $Exibir = new Exibir();
        $Exibir->exeExibir("SELECT 
                                    o.codigo AS codigo_oferta,
                                    u.codigo AS codigo_ofertante,
                                    o.titulo AS titulo_oferta,
                                    o.img AS img_oferta,
                                    e.titulo AS titulo_parceiro
                                    FROM oferta_mercado m
                                    JOIN oferta o ON o.id_oferta = m.id_oferta
                                    JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                    JOIN usuario u ON u.id_usuario = m.id_usuario
                                    WHERE m.pendente = 'N' AND m.id_usuario_sugestao IS NULL", NULL, NULL, NULL, FALSE);

        $this->Retorno = json_encode($Exibir->Resultado());
    }

    private function getcupomonmarketperuse(){

    }

    private function getcupomcomment(){

        $Exibir = new Exibir();
        $Exibir->exeExibir("SELECT 
                                    CONCAT(u.nome,' ',u.sobrenome) AS nome,
                                    u.avatar AS img_usuario,
                                    c.comentario
                                    FROM usuario_comentario c
                                    JOIN usuario u ON u.id_usuario = c.id_usuario
                                    WHERE c.id_oferta = (SELECT id_oferta FROM oferta WHERE codigo = :codigo)", NULL, NULL, "codigo={$this->ID}", FALSE);

        $this->Retorno = json_encode($Exibir->Resultado());
    }

    private function putcupommarket(){

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

    private function putcupomrating(){

        $Exibir = new Exibir();
        $Exibir->exeExibir("SELECT o.id_oferta, u.id_usuario FROM oferta o
                                    JOIN usuario u ON u.codigo = :usuario
                                    WHERE o.codigo = :oferta", NULL,NULL,"usuario={$this->Dados['usercode']}&oferta={$this->Dados['cupomcode']}", FALSE);

        $Dados = [
                    "id_oferta" =>  $Exibir->Resultado()[0]["id_oferta"],
                    "id_usuario" => $Exibir->Resultado()[0]["id_usuario"],
                    "rating" => $this->Dados["rating"]
                ];

        $Inserir = new Inserir();
        $Inserir->exeInserir("oferta_rating", $Dados);

        if($Inserir->Resultado()):
            $this->Retorno = json_encode(["codigo" => "200"]);
        else:
            $this->Retorno = json_encode(["codigo" => "100"]);
        endif;
    }
}