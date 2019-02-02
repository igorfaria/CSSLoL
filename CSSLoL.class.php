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

    private $_countMedias = 0;

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
                            'animation', 'animation-*', 'background-clip', 'box-reflect', 'filter', 'flex', 'box-flex',
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
        
        $re_media = "/(@\.+[^{]+)\{([\s\S]+?})\s*}/";
        preg_match_all($re_media, $css_text, $matches_media);

        $count_replaces = 0;
        $css_text_aux = $this->replaceMedias($re_media, $css_text);
        
        # Initial Source: https://stackoverflow.com/questions/33547792/php-css-from-string-to-array
        $re_css = "/(.+)\{([^\}]*)\}/";
        preg_match_all($re_css, $css_text_aux, $matches);

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

            // Media queries
            if(preg_match('/\@media-(\d+)/',$name, $media_query)) {
                if(isset($media_query[1]) AND isset($matches_media[0][$media_query[1]])){
                    $media_query_name = $matches_media[1][$media_query[1]];
                    $name = trim($media_query_name);
                    $media_query_css = $matches_media[2][$media_query[1]];
                    $rules_a = $this->parse($media_query_css); 
                } 
            }

            //Add the name and its values to the array
            $return[][$name] = $rules_a;
        }

        //Return the array
        return $return;
    }

    public function replaceMedias($pattern, $text) {
        $this->_countMedias = 0;
        return preg_replace_callback($pattern, array($this, '_callbackMedias'), $text);
    }
    public function _callbackMedias($matches) {
        return '@media-' . $this->_countMedias++ . '{}';
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
        if(strtolower($format) == 'string'){
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

    public function save($name,$path='',$minify=true){
        // Try to get css in text
        $css_text = $this->toString((($minify)?true:false));
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

    private function toString($minify=true){
        $css_text = "";
        $ident_space = '  ';
        foreach($this->css as $selector=>$prop_and_value){
            if(!is_array($prop_and_value)) continue;
            if($minify){
                $css_text .= $selector.'{';
                    foreach($prop_and_value as $prop=>$value){
                        $css_text .= "{$prop}:{$value};";
                    }
                    $css_text .= '}';
            } else {
                    $css_text .= $selector.'{\n';
                    foreach($prop_and_value as $prop=>$value){
                        $css_text .= $ident_space . "{$prop}:{$value};" . '\n';
                    }
                    $css_text .= '}\n';
            }
        }
        return $css_text;
    }
}