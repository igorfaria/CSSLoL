<h1 align="center">:zap::zap::zap:  CSSLoL  :zap::zap::zap: </h1>
<p align='center'>
An standalone CSS optimizer in PHP.
 </p>
<br>

## Optimize
  - Remove zeros when it is not needed (0.3s -> .3s)
  - Colors rgb to hex (*rgb(255,255,255)* -> *#fff*)
  - Abbreviation for hex (*#ffcc00* -> *#fc0*) 
  - Add prefixes (*-webkit-*, *-moz-*, *-ms-* and *-o-*)
- Support to media queries
- Support to animations (*-webkit-*)
<br><br>
## Minify
- Yeah it does, by nature. Remove whitespaces, tabs, comments and those things.
<br><br>
## Configs
- **Auto Prefixer**: add prefixes automatically if not yet defined to specified properties that you define 
<br><br>
## Public Methods
- **append(*$array* or *$string*)** - To add some css rules to the end 
- **prepend(*$array* or *$string*)** - To add some css rules to the top
- **load('*string with local path or remote url*')** - To load some css file local or remote
- **get(*'array'* or *'string'*)** - to get the array of parsed css to change the data structury 
- **save(*'name.css','path/css',true*)** - Save the final css to some final file (minified or not)
- **set(*$array* or *$string*)** - to set the array of parsed css or in text, it will not append, it will replace the actual data
<br><br><br>
