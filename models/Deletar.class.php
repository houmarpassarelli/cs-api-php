<?php
/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 28/04/2015
 * Time: 14:05
 * Agenda Assessoria
 */

class Deletar extends Conexao{

    private $Tabela;
    private $Termos;
    private $Condicoes;
    private $Resultado;

    /** @var PDOStatement */
    private $Deletar;

    /** @var PDO */
    private $Conexao;


    public function exeDeletar($Tabela, $Condicoes, $ParseString = NULL){

        $this->Condicoes = (string)$Condicoes;
        $this->Tabela = (string)$Tabela;

        if(!empty($ParseString)):
            parse_str($ParseString, $this->Termos);
        endif;

        $this->getSyntax();
    }

    public function Resultado(){
        return $this->Resultado;
    }

    public function rowCount(){
        return $this->Deletar->rowCount();
    }

    private function Connection(){
        $this->Conexao = parent::getCon();
    }

    private function getSyntax(){

        $this->Connection();
        try{

            $this->Deletar = $this->Conexao->prepare("DELETE FROM {$this->Tabela} {$this->Condicoes}");

            $this->Deletar->execute($this->Termos);
            $this->Resultado = TRUE;

        }catch(PDOException $erro){
            $this->Resultado = NULL;
            PHPErro($erro->getCode(), $erro->getMessage(), $erro->getFile(), $erro->getLine());
        }

    }
} 