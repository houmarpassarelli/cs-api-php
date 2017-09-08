<?php
use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\Output\QRImageOptions;
use chillerlan\QRCode\QRCode;

class Cupom
{
    private $Retorno;
    private $Dados;
    private $ID;
    private $Codigo;
    private $LIMITE;
    private $OFFSET;
    private $RESOLUTION;
    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->ID = $dados["ID"] ?? NULL;
        $this->LIMITE = $dados["LIMIT"] ?? NULL;
        $this->OFFSET = $dados["OFFSET"] ?? NULL;
        $this->RESOLUTION = $dados["RESOLUTION"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    private function setcupomuser(){

        $nomes = ["a","e","i","o","u","A","E","I","O","U","da","de","di","do","du","DA","DE","DI","DO","DU"];

        $Usuario = new Exibir();
        $Usuario->exeExibir("SELECT nome, sobrenome, id_usuario FROM usuario WHERE codigo = :id", NULL, NULL, "id={$this->Dados["codigo"]}", FALSE);

        $Cupom = new Exibir();
        $Cupom->exeExibir("SELECT id_oferta, id_pacote FROM oferta", NULL, NULL, NULL, FALSE);

        $iniSobrenome = NULL;

        $qrImageOptions = new QRImageOptions;
        $qrImageOptions->pixelSize = 8;
        $qrImageOptions->base64 = true;

        foreach(explode(" ", $Usuario->Resultado()[0]["sobrenome"]) as $Value):
            if(!in_array($Value, $nomes)):
                $iniSobrenome .= substr($Value, 0 , 1);
            endif;
        endforeach;

        $Inserir = new Inserir();

        for($a=0;$a < count($Cupom->Resultado()); $a++):

            $hash = sha1($Usuario->Resultado()[0]['id_usuario'].date("dmYHis").$Cupom->Resultado()[$a]["id_oferta"]);
            $altQRCode = strtoupper(substr($Usuario->Resultado()[0]["nome"], 0 , 1).$iniSobrenome.substr($Usuario->Resultado()[0]['id_usuario'],0 , 3).substr($hash,0, 3));
            $qrcode = (new QRCode($hash.$altQRCode, new QRImage($qrImageOptions)))->output();


            $Inserir->exeInserir("oferta_interacao",
                ["id_pacote" => $Cupom->Resultado()[$a]["id_pacote"],
                "id_usuario" => $Usuario->Resultado()[0]['id_usuario'],
                "id_oferta" => $Cupom->Resultado()[$a]["id_oferta"],
                "hash" => $hash,
                "altcode" => $altQRCode,
                "qrcode" => $qrcode]
            );
        endfor;

    }

    private function getcupom(){

        $resolution = Imagem::directXperRequest($this->RESOLUTION);

        $Exibir = new Exibir();

        if(!is_null($this->ID)):
            $Exibir->exeExibir("SELECT                                    
                                        o.codigo,
                                        o.titulo AS titulo_cupom,
                                        (SELECT {$resolution} FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom,
                                        (SELECT updated_at FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom_modified,
                                        o.descricao,
                                        o.regulamento,
                                        o.dias_uso,
                                        o.min_pessoas,
                                        o.max_pessoas,
                                        o.updated_at AS modified,
                                        p.id_pacote AS pacote,
                                        p.titulo AS titulo_pacote,                                                                        
                                        e.titulo AS titulo_parceiro,
                                        (SELECT x480 FROM img_interacao WHERE id_estabelecimento = e.id_estabelecimento) AS img_parceiro,
                                        (SELECT updated_at FROM img_interacao WHERE id_estabelecimento = e.id_estabelecimento) AS img_parceiro_modified
                                        FROM oferta o
                                        LEFT JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                        LEFT JOIN pacote p ON p.id_pacote = o.id_pacote
                                        WHERE o.codigo = :codigo", NULL, NULL, "codigo={$this->ID}", FALSE);
        else:

        endif;

        $this->Retorno = json_encode($Exibir->Resultado()[0]);

    }

    private function putcupom(){

        $this->Dados[0]["codigo"] = System::longRandnDateCode();
//        $this->Dados[0]["dias_uso"] = serialize($this->Dados["dias_uso"]);
//
//        $Inserir = new Inserir();
//        $Inserir->exeInserir("oferta", $this->Dados);

        unset($this->Dados[0]["Enviar"]);

        if(!is_null($this->Dados)):
            $Inserir = new Inserir();
            $Inserir->exeInserir("oferta", $this->Dados[0]);

            if($Inserir->Resultado() > 0):
                Imagem::putimagem([0 => ["id_oferta" => $Inserir->Resultado()], $this->Dados[1]]);
            endif;
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

    private function getcupomperpack(){

        $resolution = Imagem::directXperRequest($this->RESOLUTION);

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
                                        o.codigo,
                                        o.titulo AS titulo_cupom,
                                        (SELECT {$resolution} FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom,
                                        (SELECT updated_at FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom_modified,
                                        o.descricao,
                                        o.regulamento,
                                        o.dias_uso,
                                        o.min_pessoas,
                                        o.max_pessoas,
                                        o.updated_at AS modified,
                                        p.id_pacote AS pacote,
                                        p.titulo AS titulo_pacote,                                    
                                        e.titulo AS titulo_parceiro,
                                        (SELECT x480 FROM img_interacao WHERE id_estabelecimento = e.id_estabelecimento) AS img_parceiro,
                                        (SELECT updated_at FROM img_interacao WHERE id_estabelecimento = e.id_estabelecimento) AS img_parceiro_modified
                                        FROM oferta o
                                        LEFT JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                        LEFT JOIN pacote p ON p.id_pacote = o.id_pacote
                                        WHERE o.id_pacote = :id {$Condicoes}", NULL, NULL, "id={$this->ID}{$Parse}", FALSE);


        $this->Retorno = json_encode($perPack->Resultado());
    }

    private function getgroupofcupomperpack(){

        $array = [];
        $resolution = Imagem::directXperRequest($this->RESOLUTION);

        $Pacote = new Exibir();
        $Pacote->exeExibir(NULL, "pacote", NULL, NULL, FALSE);

        $perGroup = new Exibir();

        for($a=0;$a < count($Pacote->Resultado()); $a++):
            $perGroup->exeExibir("SELECT                                    
                                        o.codigo,
                                        o.titulo AS titulo_cupom,                                        
                                        (SELECT {$resolution} FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom,
                                        (SELECT updated_at FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom_modified,
                                        o.descricao,
                                        o.regulamento,
                                        o.dias_uso,
                                        o.min_pessoas,
                                        o.max_pessoas,
                                        o.updated_at AS modified,
                                        p.id_pacote AS pacote,
                                        p.titulo AS titulo_pacote,                                                                         
                                        e.titulo AS titulo_parceiro,
                                        (SELECT x480 FROM img_interacao WHERE id_estabelecimento = o.id_estabelecimento) AS img_parceiro,
                                        (SELECT updated_at FROM img_interacao WHERE id_estabelecimento = o.id_estabelecimento) AS img_parceiro_modified                                                                       
                                        FROM oferta o
                                        LEFT JOIN estabelecimento e ON e.id_estabelecimento = o.id_estabelecimento
                                        LEFT JOIN pacote p ON p.id_pacote = o.id_pacote 
                                        WHERE o.id_pacote = :id_pacote LIMIT :limit", NULL, NULL, "id_pacote={$Pacote->Resultado()[$a]["id_pacote"]}&limit={$this->LIMITE}", FALSE);

        $array[$Pacote->Resultado()[$a]["id_pacote"]] = $perGroup->Resultado();

        endfor;
        
        $this->Retorno = json_encode($array);

    }

    private function getcupommodified(){

        $Exibir = new Exibir();
        $Exibir->exeExibir("SELECT
                                    o.codigo,
                                    o.updated_at AS modified,
                                    o.id_pacote AS pacote,
                                    img.updated_at AS img_modified
                                    FROM oferta o
                                    LEFT JOIN img_interacao img ON img.id_oferta = o.id_oferta
                                    WHERE o.id_pacote = :pacote LIMIT :limit", NULL, NULL, "pacote={$this->ID}&limit={$this->LIMITE}");


        $this->Retorno = json_encode($Exibir->Resultado());
    }

    private function getcupomperuser(){

        $Condicoes = '';
        $Parse = '';

        $resolution = Imagem::directXperRequest($this->RESOLUTION);

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
                                    (SELECT {$resolution} FROM img_interacao WHERE id_oferta = o.id_oferta) AS img_cupom,
                                    o.updated_at AS modified,
                                    i.altcode,
                                    i.qrcode,
                                    e.titulo AS titulo_parceiro,                                    
                                    (SELECT x480 FROM img_interacao WHERE id_estabelecimento = o.id_estabelecimento) AS img_parceiro,
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

    private function getcupomimg(){

        $resolution = Imagem::directXperRequest($this->RESOLUTION);

        $Condicoes = '';
        $Parse = '';
        $Retorno = NULL;

        if(!empty($this->LIMITE)):
            $Condicoes .= "LIMIT :limit ";
            $Parse .= "limit={$this->LIMITE}";
        endif;

        if(!empty($this->OFFSET)):
            $Condicoes .= "OFFSET :offset ";
            $Parse .= "&offset={$this->OFFSET}";
        endif;

        $Exibir = new Exibir();

        if(!is_null($this->ID)):
            $Exibir->exeExibir("SELECT
                                        img.{$resolution},
                                        o.codigo
                                        FROM img_interacao img
                                        JOIN oferta o ON o.id_oferta = img.id_oferta
                                        WHERE o.codigo = :codigo", NULL, NULL, "codigo={$this->ID}", FALSE);

            if($Exibir->rowCount() > 1):
                $Retorno = $Exibir->Resultado();
            else:
                $Retorno = $Exibir->Resultado()[0];
            endif;
        else:
            $Exibir->exeExibir("SELECT
                                        img.{$resolution},
                                        o.codigo
                                        FROM img_interacao img
                                        JOIN oferta o ON o.id_oferta = img.id_oferta {$Condicoes}", NULL, NULL, "{$Parse}", FALSE);

            $Retorno = $Exibir->Resultado();
        endif;

        $this->Retorno = json_encode($Retorno);
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