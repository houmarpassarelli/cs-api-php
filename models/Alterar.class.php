<?php
/**
 * Created by PhpStorm.
 * User: Houmar
 * Date: 28/04/2015
 * Time: 13:47
 * Agenda Assessoria
 */

class Alterar extends Conexao{

    private $Tabela;
    private $Resultado;
    private $Termos;
    private $Condicoes;
    private $Dados;
    private $Manual;

    /** @var PDOStatement */
    private $Alterar;

    /** @var PDO */
    private $Conexao;

    /**
     * @param $Manual : Passa toda a query manualmente
     * @param $Tabela : Tabela a ser alterada
     * @param array $Dados : Dados a serem inseridos
     * @param $Condicoes : Condições para alteração
     * @param $ParseString
     */
    public function ExeAlterar($Manual = NULL,$Tabela = NULL, array $Dados = NULL, $Condicoes = NULL,$ParseString = NULL){

        if(!empty($Manual)):
            $this->Manual = (string)$Manual;
        endif;

        if(!empty($Tabela)):
            $this->Tabela = (string)$Tabela;
        endif;

        if(!empty($Dados)):
            $this->Dados = $Dados;
        endif;

        if(!empty($Condicoes)):
            $this->Condicoes = (string)$Condicoes;
        endif;
        if(!empty($ParseString)):
            parse_str($ParseString,$this->Termos);
        endif;

        $this->getSyntax();
    }

    public function Resultado(){
        return $this->Resultado;
    }

    public function rowCount(){
        return $this->Alterar->rowCount();
    }

    private function Connection(){
        $this->Conexao = parent::getCon();
    }

    private function getSyntax(){
        $this->Connection();

    if(!$this->Manual):
        foreach($this->Dados as $Key=>$Value):
            $Places[] = $Key .' =:'.$Key;
        endforeach;

        $Places = implode(', ',$Places);
    endif;

        try{

            if($this->Manual && !empty($this->Manual)):
                $this->Alterar = $this->Conexao->prepare($this->Manual);
                $this->Alterar->execute();
            else:
                $this->Alterar = $this->Conexao->prepare("UPDATE {$this->Tabela} SET {$Places} {$this->Condicoes}");
                $this->Alterar->execute(array_merge($this->Dados,$this->Termos));
            endif;
            $this->Resultado = TRUE;

        }catch(PDOException $erro){
            $this->Resultado = NULL;
            PHPErro($erro->getCode(), $erro->getMessage(), $erro->getFile(), $erro->getLine());
        }
    }
} 