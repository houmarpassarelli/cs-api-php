<?php
/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 28/04/2015
 * Time: 13:37
 * Agenda Assessoria
 */

class Inserir extends Conexao{

    private $Tabela;
    private $Dados;
    private $Resultado;

    /** @var PDOStatement */
    private $Inserir;

    /** @var PDO */
    private $Conexao;

    /**
     * @param $Tabela : Informar a tabela que recebera os dados
     * @param array $Dados : Dados a serem inseridos
     */
    public function exeInserir($Tabela, array $Dados){
        $this->Tabela = (string)$Tabela;
        $this->Dados = $Dados;

        $this->getSyntax();
    }

    public function Resultado(){
        return $this->Resultado;
    }

    public function rowCount(){
        return $this->Inserir->rowCount();
    }

    public function errorCode(){
        return $this->Inserir->errorCode();
    }

    private function Connection(){
        $this->Conexao = parent::getCon();
    }

    private function getSyntax(){

        $this->Connection();

        $Fields = implode(', ',  array_keys($this->Dados));
        $Places = ':' . implode(', :',  array_keys($this->Dados));

        try{
            $this->Inserir = $this->Conexao->prepare("INSERT INTO {$this->Tabela} ({$Fields}) VALUES ({$Places})");
            $this->Inserir->execute($this->Dados);
            $this->Resultado = $this->Conexao->lastInsertId();
        }catch(PDOException $erro){
            $this->Resultado = NULL;
            PHPErro($erro->getCode(), $erro->getMessage(), $erro->getFile(), $erro->getLine());
        }
    }

}