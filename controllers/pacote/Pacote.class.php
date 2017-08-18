<?php

use chillerlan\QRCode\Output\QRImage;
use chillerlan\QRCode\Output\QRImageOptions;
use chillerlan\QRCode\QRCode;

class Pacote extends Cupom
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

    private function putpacote(){

        if(!is_null($this->Dados)):

            $Exibir = new Exibir();
            $Exibir->exeExibir(NULL, "pacote", "WHERE titulo = :titulo","titulo={$this->Dados['titulo']}", FALSE);

            if(!$Exibir->Resultado()):

                $Inserir = new Inserir();
                $Inserir->exeInserir("pacote", $this->Dados);

                if($Inserir->Resultado()):
                    $this->Retorno = '200';
                endif;
            else:
                $this->Retorno = '0301';
            endif;
        else:
            $this->Retorno = '100';
        endif;
    }

    private function getpacote(){

        $array = [];

        $Exibir = new Exibir();

        if(!is_null($this->ID)):

        else:
            $Exibir->exeExibir(NULL, "pacote", NULL, NULL, FALSE);

            for($a=0; $a < count($Exibir->Resultado()); $a++):
                
                $array[$Exibir->Resultado()[$a]["id_pacote"]] = $Exibir->Resultado()[$a];
                $array[$Exibir->Resultado()[$a]["id_pacote"]]["utilizado"] = "N";

                unset($array[$Exibir->Resultado()[$a]["id_pacote"]]["id_pacote"]);
            endfor;

            $this->Retorno = json_encode($array);

        endif;
    }

    private function getpacoteperuser(){

    }

    private function setpacote(){

        $Usuario = new Exibir();
        $Usuario->exeExibir("SELECT id_usuario, nome, sobrenome FROM usuario WHERE codigo = :id", NULL, NULL,"id={$this->Dados['usuario_id']}", FALSE);

        $Dados = [
            "id_usuario" => $Usuario->Resultado()[0]["id_usuario"],
            "id_pacote" => $this->Dados['pacote_id']
        ];

        $setPack = new Inserir();
        $setPack->exeInserir("pacote_interacao", $Dados);

        if($setPack->errorCode() == '23000' || $setPack->errorCode() == '42S02' || $setPack->errorCode() == '42S22'):
            $this->Retorno = json_encode(["codigo" => $setPack->errorCode()]);
        else:
            $this->Retorno = json_encode(["codigo" => "200"]);

            $Cupom = new Exibir();
            $Cupom->exeExibir("SELECT id_oferta FROM oferta WHERE id_pacote = :pacote", NULL, NULL, "pacote={$this->Dados['pacote_id']}", FALSE);

            $iniSobrenome = NULL;

            $qrImageOptions = new QRImageOptions;
            $qrImageOptions->pixelSize = 8;
            $qrImageOptions->base64 = true;

            foreach(explode(" ", $Usuario->Resultado()[0]["sobrenome"]) as $Value):
                if($Value <> "de"):
                    $iniSobrenome .= substr($Value, 0 , 1);
                endif;
            endforeach;

            for($a=0;$a < count($Cupom->Resultado()); $a++):

                $hash = sha1($this->Dados['usuario_id'].date("dmYHis").$Cupom->Resultado()[$a]["id_oferta"]);
                $altQRCode = strtoupper(substr($Usuario->Resultado()[0]["nome"], 0 , 1).$iniSobrenome.substr($this->Dados['usuario_id'],0 , 3).substr($hash,0, 3));
                $qrcode = (new QRCode($hash.$altQRCode, new QRImage($qrImageOptions)))->output();

                Cupom::setcupomuser(["iduser" => $Usuario->Resultado()[0]["id_usuario"], "codpack" => $this->Dados['pacote_id'], "codcupom" => $Cupom->Resultado()[$a]["id_oferta"], "hash" => $hash, "altcode" => $altQRCode, "qrcode" => $qrcode]);

            endfor;
        endif;
    }
}