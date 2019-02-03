
# CSSLoL - CSS optimizer in PHP
An standalone CSS optimizer in PHP.

This is a *CSS optimizer* that parse CSS code into an set of arrays associatives, allowing to manipulate the CSS with PHP and execute the magic, outputing as a text or into a file.

### Optimize
-  [x] Remove zeros when it is not needed (0.3s -> .3s)
-  [x] Colors rgb to hex (*rgb(255,255,255)* -> *#fff*)
-  [x] Abbreviation for hex (*#ffcc00* -> *#fc0*)
-  [x] Add prefixes (*-webkit-*, *-moz-*, *-ms-* and *-o-*)
- [ ] Replace multiples related properties with the shorthanded version
- [ ] Remove duplicated properties with the same selector
-  [x] Support to media queries
-  [x] Support to animations (*-webkit-*)

### Minify

-  [x] Yeah it does, by nature. Removing whitespaces, tabs, comments and those things.

<br>

## Installing
##### Prerequisites: PHP 5.4+
Just download the file **CSSLoL.class.php** and use it, there is no others external dependencies to the CSSLoL class.
Of course you can download the folder /tests/ if you want some examples to how use and to test the funcionalities.


#### Configurations

-  [x]  **autoprefixer**  *(default: true)*: add prefixes automatically if not yet defined to specified properties that you define

- [ ] **duplicated**  *(default: false)*: Remove duplicated properties with the same selector in different parts of your css code.

- [ ] **shorthand**  *(default: false)*: Replace multiples related properties with the shorthanded version.

<br><br>

## Usage
-  [x]  **append(*$array* or *$string*)** - To add some css rules to the end

```php
<?php
$CSSLoL = new CSSLoL();
// Set initial CSS 
$CSSLoL->set('body{color:#333333;});
// Add rule to the end of the CSS
$CSSLoL->append(array('p' => array('color'=>'#222222')));
echo $CSS->get('text');
```

Will output: 
```css
body{color:#333}p{color:#222}
```
-  [x]  **prepend(*$array* or *$string*)** - To add some css rules to the beginning
```php
<?php
$CSSLoL = new CSSLoL();
// Set initial CSS 
$CSSLoL->set('body{color:#333333;});
// Add rule to the beginning of the CSS
$CSSLoL->prepend(array('p' => array('color'=>'#222222')));
echo $CSS->get('text');
```

Will output: 
```css
p{color:#222}body{color:#333}
```

-  [x]  **load('*string with local path or remote url*')** - To load some css file local or remote

-  [x]  **get(*'array'* or *'string'*)** - to get the array of parsed css to change the data structury

-  [x]  **save(*'name.css','path/css',true*)** - Save the final css to some final file (minified or not)

-  [x]  **set(*$array* or *$string*)** - to set the array of parsed css or in text, it will not append, it will replace the actual data



## Running the tests
The tests are in the **/tests/** folder, just run them into your browser to see the results. They are not that good as a test but I think they do their job. 
Basically the tests *test* the methods in the class, to see if they output what is desired. 
  

## Built With
Google Search, Visual Code Editor, PHP 7, Apache (on Windows),  Git and Github.
 

## Versioning
I use my imagination for versioning. For the versions available, see the [releases on this repository](https://github.com/igorfaria/CSSLoL/releases).

  

## Author
*  **Igor Faria**, myself.
  

There is no other contributors until now, but if someone show up will be in the list of [contributors](https://github.com/igorfaria/CSSLoL/contributors) who participated in this project.

 
## License

  

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details