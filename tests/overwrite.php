<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$configs = array('overwrite' => true);

$CSSLoL = new CSSLoL($configs);
$CSSLoL->load('css/overwrite.css');

echo 'Autoprefixer' . PHP_EOL. PHP_EOL;
echo $CSSLoL->get('string',false);