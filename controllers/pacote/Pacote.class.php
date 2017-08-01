<?php

class Pacote
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

        $Exibir = new Exibir();

        if(!is_null($this->ID)):

        else:
            $Exibir->exeExibir(NULL, "pacote", NULL, NULL, FALSE);
            $this->Retorno = json_encode($Exibir->Resultado());
        endif;
    }

    private function setpacote(){

        $Usuario = new Exibir();
        $Usuario->exeExibir("SELECT id_usuario FROM usuario WHERE codigo = :id", NULL, NULL,"id={$this->Dados['usuario_id']}", FALSE);

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
        endif;
    }
}