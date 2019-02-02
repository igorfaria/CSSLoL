<h1 align="center">:zap::zap::zap:  CSSLoL  :zap::zap::zap: </h1>
<p align='center'>
An standalone CSS optimizer in PHP.
 </p>
<br>

## Optimize
  - [x] Remove zeros when not needed
  - [x] rgb to hex
  - [x] abbreviation for hex (*#ffcc00* -> *#fc0*) 
  - [ ] add prefixes (*-webkit-*, *-moz-*, *-ms-* and *-o-*)
- [x] Support to media queries
- [x] Support to animations
<br><br>
## Minify
- [x] Yeah it does, by nature. Remove whitespaces, tabs, comments and those things.
<br><br>
## Configs
- [ ] **Variables**: replace variables to values
- [ ] **Overwrite**: verify if already have that property defined to that same selector and replace it, to be used in some specifics cases like the one that make me do this  :D 
- [ ] **Auto Prefixer**: add prefixes automatically if not yet defined to specified properties that you define 
<br><br>
## Public Methods
- [x] **append(*$array* or *$string*)** - To add some css rules
- [x] **load('*string with local path or remote url*')** - To load some css file local or remote
- [x] **get(*'array'* or *'string'*)** - to get the array of parsed css to change the data structury 
- [x] **save(*'name.css','path/css',true*)** - Save the final css to some final file (minified or not)
- [x] **set(*$array* or *$string*)** - to set the array of parsed css or in text, it will not append, it will replace the actual data
<br><br><br>
