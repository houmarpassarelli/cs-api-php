<?php

class Login extends Conexao
{
    private $Dados;
    private $Retorno;

    public function Retorno(array $dados){

        $this->Dados = $dados["DADOS"] ?? NULL;
        $this->{$dados["METODO"]}();

        return $this->Retorno;
    }

    // private function Conexao(){
    //     return parent::getCon();
    // }

    private function checkLogin(){

        
        
        $Email = new Exibir();
        $Email->exeExibir("SELECT COUNT(*) AS count FROM usuario WHERE email = '{$this->Dados['email']}'", NULL, NULL, NULL, FALSE);



        exit(var_dump($Email->Resultado()[0]['count']));

        if($email->rowCount() > 0):

        endif;

        $this->Retorno = json_encode($Retorno);
        
    }
}