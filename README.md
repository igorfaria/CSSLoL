<h1 align="center">:zap::zap::zap:  CSSLoL  :zap::zap::zap: </h1>
<p align='center'>
An standalone CSS optimizer in PHP.
 </p>
<br>

## Optimize
  - [x] Remove zeros when it is not needed (0.2s -> .2s)
  - [x] rgb to hex (rgb(255,255,255) -> #fff)
  - [x] abbreviation for hex (*#ffcc00* -> *#fc0*) 
  - [x] add prefixes (*-webkit-*, *-moz-*, *-ms-* and *-o-*)
- [x] Support to media queries
- [x] Support to animations (*-webkit-*)
<br><br>
## Minify
- [x] Yeah it does, by nature. Remove whitespaces, tabs, comments and those things.
<br><br>
## Configs
- [x] **Auto Prefixer**: add prefixes automatically if not yet defined to specified properties that you define 
<br><br>
## Public Methods
- [x] **append(*$array* or *$string*)** - To add some css rules to the end 
- [x] **prepend(*$array* or *$string*)** - To add some css rules to the top
- [x] **load('*string with local path or remote url*')** - To load some css file local or remote
- [x] **get(*'array'* or *'string'*)** - to get the array of parsed css to change the data structury 
- [x] **save(*'name.css','path/css',true*)** - Save the final css to some final file (minified or not)
- [x] **set(*$array* or *$string*)** - to set the array of parsed css or in text, it will not append, it will replace the actual data
<br><br><br>
