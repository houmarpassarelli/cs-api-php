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

    static public function verificaEmail($email) : array{

        if(filter_var($email, FILTER_VALIDATE_EMAIL)):

            $Email = new Exibir();
            $Email->exeExibir(NULL, "usuario","WHERE email = :email","email={$email}", FALSE);

            if($Email->Resultado()):
                return [false, '0201'];
            else:
                return [true, '200'];
            endif;
        else:
            return [false, '0203'];
        endif;
    }

    static public function verificaLogin($login) : array{

        $usuario = md5($login);

        $Login = new Exibir();
        $Login->exeExibir(NULL, "usuario_access", "WHERE login = :login","login={$usuario}", FALSE);

        if($Login->Resultado()):
            return [false, '0202'];
        else:

            return [true, '200'];
        endif;
    }

    static public function longRandnDateCode(){

        $Data = [date("y"), date("d"), date("m"), date("H"), date("i"), date("s")];

        return array_rand($Data, 1).mt_rand(1,99).array_rand($Data, 1).mt_rand(99,999).array_rand($Data, 1).mt_rand(999,9999);
    }

    private function HTTP_METHOD(){
        return filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    }

    private function HTTP_PATH($url){
        return explode('/', $url);
    }

    private function URI_HASH(){

        $metodos = [
                        "usuario" => "f8032d5cae3de20fcec887f395ec9a6a",
                        "getusuario" => "c494e4539220ba43bb76159d22e70a66",
                        "putusuario" => "f757f01ff43e111bbddfabd18d99d03f",
                        "putusuariocomentario" => "a6ebd6a69763c780b8cf5318d94136d2",
                        "updateusuario" => "3b666aaf61ff766211491d9d46cfeb0a",
                        "deleteusuario" => "1dcd0a49a4a152c08a53695cbacfa616",
                        "parceiro" => "22935d7f7084b1ef474f7a006d2102ce",
                        "getparceiro" => "183628fa96d1c1ec88e09ebe83fb96b4",
                        "putparceiro" => "16ddac9584e012e2173fb52566979e22",
                        "updateparceiro" => "c0663d4ca6d92f5a257bcd607c867b8f",
                        "deleteparceiro" => "f6a0f79c5dcb58638a95b38bb8d3b08c",
                        "cupom" => "f61e7f04c539f2aa08d2ddb23be63f92",
                        "getcupom" => "15bc2f541b0ff3869471b514eb5e4fa9",
                        "getcupomperpack" => "910572e3f281348ce7807952e993fada",
                        "getgroupofcupomperpack" => "fcc5a59de15197250861d6c3a9f3fb89",
                        "getcupomperuser" => "7d370f49aeaf1473b44755d8b0158003",
                        "getcupomonmarket" => "a086654648ab1cbc20560ee7165d87db",
                        "getcupomonmarketperuse" => "69b3dd31da8a76c45fba530f3b56a422",
                        "getcupomcomment" => "7ca6176c074dcf2f6a774594d491634c",
                        "putcupom" => "e2f189e0949db9308441953db5293a72",
                        "putcupommarket" => "dc122f8086185814ff083b7ce05509d4",
                        "putcupomrating" => "5ca6eb852234e7d4bf020273bdd11ce2",
                        "updatecupom" => "cb1219577315b48fba401a166f4c99c0",
                        "deletecupom" => "5a7ce680226189faf51dce0b5419b77a",
                        "login" => "d56b699830e77ba53855679cb1d252da",
                        "checkLogin" => "c0ef4307f8ff9b9beded5c3967c53e9a",
                        "pacote" => "c307f45ed96b6596975a477a22f199f0",
                        "getpacote" => "772f4e03368ec3654f10d185260398e6",
                        "putpacote" => "0710e0529b97eda266e332822f9cd0fc",
                        "updatepacote" => "",
                        "deletepacote" => "",
                        "setpacote" => "a9e250a864dc3526e8b4b947685a781b",
                        "contato" => "b5f06e72d6d5104bdae7736fd0786d9c",
                        "getcontato" => "e3c1501305ee0d32e71bb89477376fa0",
                        "searchcontato" => "d0e4cb0eca3b41ca861090b884a337c6",
                        "putcontato" => "0c6ed687d54ffc4b7c1df5ccbe6c6e30",
                        "updatecontato" => "",
                        "deletecontato" => "",
                        "imagem" => "bf19122987928493131d5bf846637fbc",
                        "putimagem" => "c99a3febab0c09597b6dd62a1ba25cb7"
                    ];
     
       

        return array_search($this->URI, $metodos);

    }
}