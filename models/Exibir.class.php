<?php
/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 28/04/2015
 * Time: 13:49
 * Agenda Assessoria
 */

class Exibir extends Conexao {

    private $Tabela;
    private $Termos;
    private $Condicoes;
    private $Coluna;
    private $Resultado;
    private $FetchObj = FALSE;
    private $Manual;

    /** @var PDOStatement */
    private $Exibir;

    /** @var PDO */
    private $Conexao;

    /**
     * @param $Tabela : Passar o nome da Tabela
     * @param null $Condicoes : Caso precisa precise passar condições manualmente
     * @param null $ParseString : Informações da condições, serão transformadas em variável e inseridas na query
     * @param null $FetchOBJ : Retorna objeto, caso contrário ira retornar em array
     * @param null $Coluna : Caso precise passar coluna manualmente. Se habilitado, necessário definir CONDIÇÕES
     */
    public function exeExibir($Manual = NULL, $Tabela = NULL, $Condicoes = NULL, $ParseString = NULL, $FetchOBJ = NULL,$Coluna = NULL){

        if(!empty($Manual)):
            $this->Manual = (string)$Manual;
        endif;

        if(!empty($Tabela)):
            $this->Tabela = $Tabela;
        endif;

        if(!empty($Condicoes)):
            $this->Condicoes = $Condicoes;
        endif;

        if(!empty($ParseString)):
            parse_str($ParseString,$this->Termos);
        endif;

        if($FetchOBJ == NULL):
            $this->FetchObj = FALSE;
        else:
            $this->FetchObj = $FetchOBJ;
        endif;

        if(!empty($Coluna)):
            $this->Coluna = $Coluna;
        endif;

        $this->getSyntax();
    }

    public function Resultado(){
        return $this->Resultado;
    }

    public function rowCount(){
        return $this->Exibir->rowCount();
    }

    private function Connection(){

        $this->Conexao = parent::getCon();

    }

    private function Termo(){
        if($this->Termos):
            foreach($this->Termos as $Key=>$Value):
                if ($Key == 'limit' || $Key == 'offset'):
                    $Value = (int) $Value;
                endif;
                $this->Exibir->bindValue(":{$Key}", $Value,(is_int($Value ? PDO::PARAM_INT : PDO::PARAM_STR)));
            endforeach;
        endif;
    }

    private function getSyntax(){
        $this->Connection();
        try{

            if($this->Condicoes && $this->Tabela):
                $this->Exibir = $this->Conexao->prepare("SELECT * FROM {$this->Tabela} {$this->Condicoes}");
            elseif($this->Coluna && $this->Tabela):
                $this->Exibir = $this->Conexao->prepare("SELECT {$this->Coluna} FROM {$this->Tabela} {$this->Condicoes}");
            elseif($this->Manual && !empty($this->Tabela) || !empty($this->Manual) && !$this->Tabela):
                $this->Exibir = $this->Conexao->prepare($this->Manual);
            else:
                $this->Exibir = $this->Conexao->prepare("SELECT * FROM {$this->Tabela}");
            endif;

            if($this->FetchObj):
                $this->Exibir->setFetchMode(PDO::FETCH_OBJ);
            else:
                $this->Exibir->setFetchMode(PDO::FETCH_ASSOC);
            endif;
            echo $this->Termo();
            $this->Exibir->execute($this->Termo());
            $this->Resultado = $this->Exibir->fetchAll();

        }catch(PDOException $erro){
            $this->Resultado = NULL;
            echo $erro->getCode();
            echo $erro->getMessage(); echo $erro->getFile(); echo $erro->getLine();
        }
    }
} 