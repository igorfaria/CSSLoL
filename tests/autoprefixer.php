<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();
$CSSLoL->load('css/prefixes_test.css');

echo 'Autoprefixer' . PHP_EOL. PHP_EOL;
echo $CSSLoL->get('string',false);