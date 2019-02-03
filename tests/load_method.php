<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();
$CSSLoL->load('css/css1.css');

echo 'Minified' . PHP_EOL. PHP_EOL;
echo $CSSLoL->get('string');