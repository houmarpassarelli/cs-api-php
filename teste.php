<?php

//require_once '../vendor/autoload.php';

require('config.inc.php');

//use Intervention\Image\ImageManager;

//$img = (string) Image::make('public/foo.png')->encode('jpg', 75);
//$jpg = ;
//$jpg = (string) Image::make('public/foo.png')->encode('jpg', 75);

//$uri

//echo $jpg;

//if(isset($_FILES) && !empty($_FILES)):
//    echo '<pre>';
//    print_r($_FILES);
//    echo '</pre>';
//endif;
//
//if(!empty($_POST)):
//    exit(print_r($_POST));
//endif;

//$img = new ImageManager();
//
//$Cupom = new Exibir();
//$Cupom->exeExibir(NULL, "oferta", NULL, NULL, FALSE);
//
//$sizes = ['x480' => 480, 'x640' => 640, 'x760' => 760, 'x1024' => 1024, 'x1280' => 1280, 'x1440' => 1440, 'x1920' => 1920, 'x2048' => 2048, 'x2160' => 2160];
//$Dados = [];
//
//for($b=0; $b < count($Cupom->Resultado()); $b++):
//    for ($a = 0; $a < count($sizes); $a++):
//        $Dados[$b]['id_oferta'] = $Cupom->Resultado()[$b]['id_oferta'];
//        $Dados[$b]['original'] = $img->make('./prato.jpg')->encode('data-url');
//        $Dados[$b][array_keys($sizes)[$a]] = $img->make('./prato.jpg')->encode('jpg', 85)->widen(array_values($sizes)[$a])->encode('data-url');
//    endfor;
//endfor;

//for ($a = 0; $a < count($sizes); $a++):
    //for($b=0; $b < count($Cupom->Resultado()); $b++):
        //$Dados[$b]['id_oferta'] = $Cupom->Resultado()[$b]['id_oferta'];
//        $Dados['original'] = $img->make('./prato.jpg')->encode('data-url');
//        $Dados[array_keys($sizes)[$a]] = $img->make('./prato.jpg')->encode('jpg', 85)->widen(array_values($sizes)[$a])->encode('data-url');
    //endfor;
//endfor;

//for($c=0;$c < count($Dados); $c++):
//    $Dados[$c]['id_oferta'] = $Cupom->Resultado()[$c];
//endfor;



//echo '<pre>';
//print_r($Dados);
//echo count($Cupom->Resultado());
//echo '</pre>';
//$Inserir = new Inserir();

//for($c = 0; $c < count($Cupom->Resultado());$c++):
//
//endfor;

print_r($_POST);
echo '<br />';
print_r($_FILES);


?>

<html>
<head>
    <meta charset="UTF-8" />
</head>
<body>
<!--<form enctype="multipart/form-data" method="post" action="--><?php //echo $_SERVER['PHP_SELF']?><!--">-->
<h3>Estabelecimento</h3>
<form enctype="multipart/form-data" method="post" action="http://localhost/cs_api/22935d7f7084b1ef474f7a006d2102ce">
    <label>Titulo</label>
    <input type="text" name="titulo" />
    <input type="file" name="arquivos[]" multiple />
    <input type="submit" name="Enviar" />
</form>
<hr />
<h3>Cupom</h3>
<form enctype="multipart/form-data" method="post" action="http://10.0.3.32:8080/cs_api/f61e7f04c539f2aa08d2ddb23be63f92">
<label>Titulo</label>
<input type="text" name="titulo" />
<label>ID Estabelecimento</label>
<input type="number" name="id_estabelecimento" />
<label>ID Pacote</label>
<input type="number" name="id_pacote" />
<input type="file" name="arquivos[]" multiple />
<input type="submit" name="Enviar" />
</form>
</body>
</html>