<?php

header('Content-type: text/plain;charset=utf8;');

require '../CSSLoL.class.php';

// If the file exists, it is deleted before the test
$css_test_file = 'css/save_method.min.css';
if(file_exists($css_test_file)){
    if(unlink($css_test_file)){
        echo 'Previous file ' . $css_test_file . ' was deleted with sucess!' . PHP_EOL . PHP_EOL;
    } else {
        echo 'Something went bad while deleting the file ' . $css_test_file  . PHP_EOL . PHP_EOL;
    }
} 
$CSSLoL = new CSSLoL();
// Initial CSS
$CSSLoL->set('body {color:#665544;}');
// Append an string
$CSSLoL->append('p {color:blue}');
// Prepend an array
$array_of_rules = array(
    array('*,*:after,*:before' => array('box-sizing' => 'border-box')),
    array('html,body' => array('margin' => '0', 'padding' => '0'))
);

$CSSLoL->prepend($array_of_rules);
$CSSLoL->save($css_test_file);

if(file_exists($css_test_file)) {
    echo 'File created with success in ' . $css_test_file;
} else {
    echo 'Something it\'s wrong, the file ' .  $css_test_file . ' wasn\'t created as expected';
}
