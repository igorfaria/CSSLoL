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
            // Auto Prefixes - add prefixes automatically if not yet defined to specified properties that you define
            'autoprefixer' => true,
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
        
        $re_media = "/(@\w+[^{]+)\{([\s\S]+?})\s*}/";
        preg_match_all($re_media, $css_text, $matches_media);

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
                    if(empty($s[1])) continue;

                    $propertie = trim($s[0]);
                    $value = $this->optimize_value(trim($s[1]));
                    
                    // Autoprefixer :D
                    if($this->config['autoprefixer']){
                        if(is_array($this->config['prefixes'])){
                            foreach($this->config['prefixes'] as $prefix=>$pre_prop){
                                if(in_array($propertie, $pre_prop)){
                                    $rules_a[$prefix . $propertie] = $value;
                                }
                            }
                        }
                    }

                    $rules_a[$propertie] = $value;

                }
            }

            // Media queries
            if(preg_match('/\@media-(\d+)/',$name, $media_query)) {
                if(isset($media_query[1]) AND isset($matches_media[0][$media_query[1]])){
                    $media_query_name = $matches_media[1][$media_query[1]];
                    $name = trim($media_query_name);
                    $media_query_css = $matches_media[2][$media_query[1]];
                    $rules_a = $this->parse($media_query_css); 
                    if($this->config['autoprefixer'] AND strpos($name,'@keyframes') !== false){
                        $name_webkit = preg_replace('/@keyframes/i','@-webkit-keyframes', $name);
                        $return[][$name_webkit] = $rules_a;
                    }
                } 
            }

            //Add the name and its values to the array
             $return[][$name] = $rules_a;
        }
        
        //Return the array
        return $return;
    }

    private function replaceMedias($pattern, $text) {
        $this->_countMedias = 0;
        return preg_replace_callback($pattern, array($this, '_callbackMedias'), $text);
    }
    public function _callbackMedias($matches) {
        return '@media-' . $this->_countMedias++ . '{}';
    }

    private function optimize_value($value){
        // Remove zeros when not needed
        $value = preg_replace('/\s+0\./', ' .', $value);

        // Replace 0px to 0
        $value = preg_replace('/\s+0px/', ' 0', $value);
        if(strtolower($value) == '0px') $value = '0';

        // Rgb to Hex
        if(strpos($value,'rgb(') !== false){
            preg_match_all('/rgb\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)$/', $value, $rgb_colors);
            if(count($rgb_colors) == 4){
                $rgb_color = $rgb_colors[0];
                $hex_color = $this->rgb_to_hex($rgb_colors[1][0],$rgb_colors[2][0],$rgb_colors[3][0]);
                $value = str_replace($rgb_color, $hex_color, $value);
            }
        }
        
        if(preg_match_all('/#(?>[[:xdigit:]]{3}){1,2}$/', $value, $hex_colors)){
            foreach($hex_colors[0] as $hex_color){
                $value = str_replace($hex_color, $this->compress_hex($hex_color), $value);   
            }
        }

        return $value;
    }

    private function rgb_to_hex($R, $G, $B){
        $R = dechex($R); if(strlen($R)<2) $R = '0'.$R;
        $G = dechex($G); if(strlen($G)<2) $G = '0'.$G;
        $B = dechex($B); if(strlen($B)<2) $B = '0'.$B;
        return '#' . $R . $G . $B;
    }

    private function compress_hex($original){
        if (strlen($original) == 6
        && $original[1] == $original[2]
        && $original[3] == $original[4]
        && $original[5] == $original[6]) {
          return "#" . $original[1] . $original[3] . $original[5];
        } else return $original;
    }

    public function append($css_input,$prepend=false){

        // If it is an string we parsed before append
        if(is_string($css_input)) {
            $css_input = $this->parse($css_input);
        }
        
        // If already was an array or if it was parsed into one, it is appended to the end of the main css
        if(is_array($css_input) AND count($css_input) > 0){
            if($prepend) {
                $this->css = array_merge($css_input,$this->css);
            } else {
                $this->css = array_merge($this->css, $css_input);
            }
            return true;
        }

        // In case something went wrong
        return false;
    }

    public function prepend($css_input){
        return $this->append($css_input,true);
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

    public function get($format='array',$minify=true){
        // It its to be returned in text...
        if(strtolower($format) == 'string'){
            return $this->toString(($minify)?true:false);
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
        $ident_space = "    ";
        $break_line = PHP_EOL;
        // Iterates over the array with rules like a crazy
        foreach($this->css as $rule){
            foreach($rule as $selector1=>$properties1){
              if(!is_array($properties1)) continue;

              $css_text .= $selector1 . ' {' . $break_line;

              // Media Queries
              if(strpos($selector1,'@media') !== FALSE){
                foreach($properties1 as $media_rule){
                    if(!is_array($media_rule)) continue;
                    foreach($media_rule as $selector2=>$properties2){
                        if(!is_array($properties2)) continue;
                        $css_text .= $ident_space . $selector2 . ' {' . $break_line;
                        foreach($properties2 as $prop=>$value){
                            $css_text .= $ident_space . $ident_space . $prop . ': ' . $value . ';' . $break_line; 
                        }
                        $css_text .= $ident_space . '}' . $break_line;
                    }
                }                
              } else {
                  // :D 
                  foreach($properties1 as $prop=>$value){
                      if(is_array($value)){ 
                          // To support to @keyframes
                        foreach($value as $keyframes=>$props2){
                            if(!is_array($props2)) continue;
                            $css_text .=  $ident_space . $keyframes . ' {' . $break_line;
                            foreach($props2 as $selector2=>$properties2){
                                    if(is_array($properties2)){
                                        $css_text .= $ident_space . $ident_space . $selector2 . ' {' . $break_line;
                                        foreach($properties2 as $prop2=>$value2){
                                            $css_text .= $ident_space . $ident_space . $ident_space . $prop2 . ': ' . $value2 . ';' . $break_line; 
                                        }
                                        $css_text .= $ident_space . $ident_space . '}' . $break_line;
                                    } else {
                                        $css_text .= $ident_space . $ident_space . $selector2 . ': ' . $properties2 . ';' . $break_line; 
                                    }
                            }
                            $css_text .= $ident_space . '}' . $break_line;
                        }
                      } else {
                          // Normal css :)
                          $css_text .= $ident_space . $prop . ': ' . $value . ';' . $break_line; 
                      }
                  }
              }

              $css_text .= '}' . $break_line;
            }
        }

        if($minify) $css_text = $this->minify($css_text);

        return $css_text;
    }

    private function minify($css){
        $from=array('@\\s*/\\*.*\\*/\\s*@sU', '/\\s{2,}/');
        $to=array('', ' ');
        $css=preg_replace($from,$to,$css); 
        $css=preg_replace('@\s*([\:;,."\'{}()])\s*@',"$1",$css);  
        $css=preg_replace('@;}@','}',$css);
        return $css;
    }
}