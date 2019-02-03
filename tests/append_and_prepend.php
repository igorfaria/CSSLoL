<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

$CSSLoL = new CSSLoL();

// Initial CSS
$CSSLoL->set('body {margin:0}');

// Append an string
$CSSLoL->append('p {color:blue}');

// Prepend an array
$array_of_rules = array(
    // Rule 1
    array('*,*:after,*:before' => array('box-sizing' => 'border-box')),
    // Rule 2
    array('html,body' => array('margin' => '0', 'padding' => '0'))
);
$CSSLoL->prepend($array_of_rules);

echo 'Final CSS' . PHP_EOL. PHP_EOL;
echo $CSSLoL->get('string',false);