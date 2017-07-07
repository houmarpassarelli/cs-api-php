<?php
class System extends Conexao
{

    private $URI;

    public function Request($url){
        return [
                "METHOD" => $this->HTTP_METHOD(),
                "PATH" => $this->HTTP_PATH($url),
                ];
    }

    public function URI_COMPARE($valor){

        $this->URI = $valor;
        return $this->URI_HASH();
    }

    private function Conexao(){
        return parent::getCon();
    }

    private function HTTP_METHOD(){
        return filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    }

    private function HTTP_PATH($url){
        return explode('/', $url);
    }

    private function URI_HASH(){

        //$Conexao = $this->Conexao();
        //$Collection = $Conexao->csdb->sysparam;

        //$Resultado = $Collection->distinct($this->URI);

        /*$metodos = [
                        "usuario" => "f8032d5cae3de20fcec887f395ec9a6a",
                        "getusuario" => "c494e4539220ba43bb76159d22e70a66",
                        "putusuario" => "f757f01ff43e111bbddfabd18d99d03f",
                        "updateusuario" => "3b666aaf61ff766211491d9d46cfeb0a",
                        "deleteusuario" => "1dcd0a49a4a152c08a53695cbacfa616",
                        "parceiro" => "22935d7f7084b1ef474f7a006d2102ce",
                        "getparceiro" => "183628fa96d1c1ec88e09ebe83fb96b4",
                        "putparceiro" => "16ddac9584e012e2173fb52566979e22",
                        "updateparceiro" => "c0663d4ca6d92f5a257bcd607c867b8f",
                        "deleteparceiro" => "f6a0f79c5dcb58638a95b38bb8d3b08c",
                        "cupom" => "f61e7f04c539f2aa08d2ddb23be63f92",
                        "getcupom" => "15bc2f541b0ff3869471b514eb5e4fa9",
                        "putcupom" => "e2f189e0949db9308441953db5293a72",
                        "updatecupom" => "cb1219577315b48fba401a166f4c99c0",
                        "deletecupom" => "5a7ce680226189faf51dce0b5419b77a",
                        "login" => "d56b699830e77ba53855679cb1d252da",
                        "checkLogin" => "c0ef4307f8ff9b9beded5c3967c53e9a"
                    ];*/
     
        return $this->Conexao()->csdb->sysparam->distinct($this->URI)[0];


    }
}