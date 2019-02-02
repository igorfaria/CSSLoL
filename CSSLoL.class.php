<?php

# CSSLoL Optimizer
# https://github.com/igorfaria/CSSLoL

class CSSLoL {
    /*
        CSS parsed in an associative array $css = ['selector' => ['prop' => 'value']];
    */
    private $css = array();

    /*
        Array with configurations
    */
    private $config = array();

    public function __construct($config = null)
    {   
        // Set default configs or overwrite with passed by the user :D
        $this->set_config($config);
    }


    private function set_config($config){
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
            // Iterate over the array
            foreach($config as $key=>$value){
                // Verify if the $key is a valid config key
                if(array_key_exists($key,$this->config)){
                    // Overwrite the original value
                    $this->config[$key] = $value;
                }
            }
        }
    }

    private function parse($css_text){
        // If it isn't an string...
        if(!is_string($css_text)) return false;
        
        # Initial Source: https://stackoverflow.com/questions/33547792/php-css-from-string-to-array
        $re = "/(.+)\{([^\}]*)\}/";
        preg_match_all($re, $css_text, $matches);

        //Create an array to hold the returned values
        $return = array();
        for($i = 0; $i<count($matches[0]); $i++){
            //Get the ID/class
            $name = trim($matches[1][$i]);

            //Get the rules
            $rules = trim($matches[2][$i]);

            //Format rules into array
            $rules_a = array();
            $rules_x = explode(";", $rules);
            foreach($rules_x as $r){
                if(trim($r)!=""){
                    $s = explode(":", $r);
                    $rules_a[trim($s[0])] = trim($s[1]);
                }
            }

            //Add the name and its values to the array
            $return[$name] = $rules_a;
        }

        //Return the array
        return $return;
    }

    public function append($css_input){

        // If it is an string we parsed before append
        if(is_string($css_array)) {
            $css_array = $this->parse($css_array);
        }
        
        // If already was an array or if it was parsed into one, it is appended to the end of the main css
        if(is_array($css_array) AND count($css_array) > 0){
            return array_push($this->css, $css_array);
        }

        // In case something went wrong
        return false;
    }

    public function load($path_or_url){
        // Verify if it is an string (url or path)
        if(!is_null($path_or_url) and is_string($path_or_url)){
            // Try to get the content
            $css_text = file_get_contents($path_or_url);
            // If it is successful in getting the content
            if($css_text and is_string($css_text)){
                // Try to parse the content
                $css_parsed = $this->parse($css_text);
                // If it is parsed into an array
                if($css_parsed AND is_array($css_parsed)){
                    // Append the css to the main css array
                    return $this->append($css_parsed);
                }
            }
        }
        return false;
    }

    public function get($format='array'){
        // It its to be returned in text...
        if(strtolower($format) == 'text'){
            return $this->toString();
        }
        // Just return and expose the css parsed in an array
        return $this->css;
    }

    public function set($array_or_string){
        // If it is an array, we simply set it believing in the good sense of the user :D
        if(is_array($array_or_string)){
            $this->css = $array_or_string;
            return true;
        }

        // If it is an string, we try to parse into an array and then we set it
        if(is_string($array_or_string)){
            $css_array = $this->parse($array_or_string);
            if(is_array($css_array)) {
                $this->css = $css_array;
                return true;
            }
        }

        // If it came until here, propably something is bad
        return false;
    }

    public function save($name,$path=''){
        // Try to get css in text
        $css_text = $this->toString();
        if(is_string($css_text) and !empty($css_text)){
            $final_path = $name;
            // Verify if there is an path and if it exists
            if(!empty($path) and is_dir($path)){
                // Check if the last character is a bar
                $length_path_str = strlen($path);
                $last_char = substr($path,$length_path_str-2,$length_path_str-1);
                // It it isn't, we add an / and pray to the gods
                if(!in_array($last_char,array('/','\\'))) $path .= "/";
                $final_path = $path.$name;
            }
            // Try to save the file :D
            return file_put_contents($final_path, $css_text);
        }
        return false;
    }

    private function toString(){
        $css_text = "";
        foreach($this->css as $selector=>$prop_and_value){
            if(!is_array($prop_and_value)) continue;
            $css_text .= $selector.'{';
            foreach($prop_and_value as $prop=>$value){
                $css_text .= "{$prop}:{$value};";
            }
            $css_text .= '}';
        }
        return $css_text;
    }
}