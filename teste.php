<?php
/**
 * @filesource   example.php
 * @created      10.12.2015
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2015 Smiley
 * @license      MIT
 */

//require_once '../vendor/autoload.php';

require('config.inc.php');

use Intervention\Image\ImageManager;

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

?>

<html>
<head>
    <meta charset="UTF-8" />
</head>
<body>
<form enctype="multipart/form-data" method="post" action="http://10.0.3.32:8080/cs_api/bf19122987928493131d5bf846637fbc">
    <input type="file" name="arquivos[]" multiple />
    <input type="submit" name="Enviar" />
</form>
<!--<img src="data:image/jpeg;base64,"  />-->
<!--<img src="--><?php //echo (new ImageManager())->make('teste2.jpg')->encode('jpg', 85)->widen(2048)->encode('data-url') ?><!--" style="width:100%;"/>-->
</body>
</html>