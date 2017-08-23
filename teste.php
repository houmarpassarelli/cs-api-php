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
?>

<html>
<head>
    <meta charset="UTF-8" />
</head>
<body>
<!--<img src="data:image/jpeg;base64,"  />-->
<img src="<?php echo (new ImageManager())->make('teste2.jpg')->encode('jpg', 85)->widen(2048)->encode('data-url') ?>" style="width:100%;"/>
</body>
</html>