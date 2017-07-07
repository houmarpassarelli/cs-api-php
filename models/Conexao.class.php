<?php

abstract class Conexao {

//    private $host = HOST;
//    private $database = DB;
//    private $user = USER;
//    private $password = PWD;
//
//    /** @var PDO **/
//    private $instancia = NULL;
//
//    private function Conecta(){
//        try{
//            if($this->instancia == NULL):
//                $opcoes = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
//                $this->instancia = new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->user,$this->password,$opcoes);
//            endif;
//        }catch(PDOException $erro){
//            echo $erro->getCode();
//            echo $erro->getMessage();
//            echo $erro->getFile();
//            echo $erro->getLine();
//            //PHPErro($erro->getCode(), $erro->getMessage(),$erro->getFile(), $erro->getLine());
//            //die;
//        }
//        $this->instancia->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//        return $this->instancia;
//    }
//
//    protected function getCon(){
//        return $this->Conecta();
//    }
    private $instancia = NULL;

    private function Conecta(){
        try{
            if($this->instancia == NULL):
                $this->instancia = new MongoDB\Client("mongodb://localhost:27017");
            endif;
        }catch(MongoException $erro){
            echo '<pre>';
            echo $erro->getCode();
            echo $erro->getFile();
            echo $erro->getLine();
            echo $erro->getMessage();
            echo '</pre>';
        }

        return $this->instancia;
    }

    protected function getCon(){
        return $this->Conecta();
    }
}
