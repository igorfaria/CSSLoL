<?php

# CSSLoL Optimizer
# https://github.com/igorfaria/CSSLoL

class CSSLoL {
    /*
        CSS parsed in an associative array $css = ['selector' => ['prop' => 'value']];
    */
    private $css;

    /*
        Array with configurations
    */
    private $config;

    public function __construct($config = null)
    {   
        // Set default configs or overwrite with passed by the user :D
        $this->set_config($config);
    }


    public function set_config($config){
        $this->config = array(
            // variables - replace variables to 
            'variables' => true,
            // Overwrite - verify if already have that property defined to that same selector and replace it :D
            'overwrite' => false,
            // Auto Prefixes - add prefixes automatically if not yet defined to specified properties that you define
            'autoprefixer' => array(
                # just add prefixes to properties :x
                # http://shouldiprefix.com
                'prefixes' => array(
                        '-webkit-' => array(
                            'animation', 'background-clip', 'box-reflect', 'filter', 'flex', 'box-flex',
                            'font-feature-settings','hyphens','mask-image','column-count', 'column-gap', 
                            'column-rule','flow-from','flow-into','transform','appearance'
                        ), 
                        '-moz-' => array(
                            'font-feature-settings', 'hyphens','column-count','column-gap','column-rule','appearance'
                        ), 
                        '-ms-' => array(
                            'word-break', 'hyphens','flow-from','flow-into','transform'
                        ),
                        '-o-' => array(
                            'object-fit'
                        ),
                    ),
                ),
        );

        // If $config is an array, overwrites the default value
        if(is_array($config)){
            foreach($config as $key=>$value){
                if(array_key_exists($key,$this->config)){
                    $this->config[$key] = $value;
                }
            }
        }
    }

}